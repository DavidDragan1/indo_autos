<?php defined('BASEPATH') or exit('No direct script access allowed');


class ApiMails extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mails_model');
        $this->load->helper('mails');
        $this->load->library('form_validation');
        define('KB', 1024);
        define('MB', 1048576);
        define('GB', 1073741824);
        define('TB', 1099511627776);
    }

    public function api_index()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            return apiResponse([
                'status' => false,
                'message' => 'Method not allowed',
                'data' => null
            ]);
        }
        $token = $this->input->server('HTTP_TOKEN');
        $user = null;
        if ($token) {
            $user = $this->db->select('user_tokens.user_id, users.role_id')
                ->join('users', 'user_tokens.user_id = users.id', 'LEFT')
                ->where('user_tokens.token', $token)
                ->get('user_tokens')->row();
            if (empty($user)) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Unauthorized',
                    'data' => null
                ]);
            }
            $user_id = $user->user_id;
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        $limit = 25;
        $page = $this->input->get('page');
        $start = startPointOfPagination($limit, $page);
        $type = !empty($this->input->get('type')) ? $this->input->get('type') : 'inbox';

        $ci =& get_instance();
        $query = $ci->db->select('access')
            ->from('role_permissions')
            ->join('acls', 'acls.id = role_permissions.acl_id', 'left')
            ->where('role_id', $user->role_id)
            ->where('permission_key', 'mails/manage_all')
            ->get()
            ->result_array();
        $manage_all_mails = is_array($query) ? count($query) : 0;
        $total = $this->Mails_model->get_mails_total_api($user_id, $manage_all_mails, $type);
        $mails = $this->Mails_model->get_mails_api($user_id, $manage_all_mails, $start, $limit, $type);
        $new_mails = [];
        if ($mails) {

            foreach ($mails as $mail) {
                $new_mails [] = [
                    'id' => $mail->id,
                    'parent_id' => $mail->id,
                    'mail_type' => $mail->mail_type,
                    'sender_id' => $mail->sender_id,
                    'reciever_id' => $mail->reciever_id,
                    'mail_from' => $mail->mail_from,
                    'mail_to' => $mail->mail_to,
                    'subject' => $mail->subject,
                    'body' => strip_tags($mail->body),
                    'status' => $mail->status,
                    'important' => $mail->important,
                    'log' => $mail->log,
                    'created' => $mail->created,
                    'folder_id' => $mail->folder_id,
                    'profile_image' => $mail->profile_image,
                ];

            }
        }

        $data = array(
            'status' => true,
            'message' => '',
            'next_page_url' => next_page_api_url($page, $limit, $total, 'api/my-inbox'),
            'prev_page_url' => prev_page_api_url($page, 'api/my-inbox'),
            'data' => [
                'mails' => $new_mails,
            ]
        );

        return apiResponse($data);
    }

    public function api_read($id)
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $user = $this->db->select('user_tokens.user_id, users.role_id')
                ->join('users', 'user_tokens.user_id = users.id', 'LEFT')
                ->where('user_tokens.token', $token)
                ->get('user_tokens')->row();
            if (empty($user)) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Unauthorized',
                    'data' => null
                ]);
            }
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }
        $row = $this->Mails_model->get_by_id($id);

        $this->Mails_model->mark_as_read($row->id);

        if ($row->parent_id != 0) {
            $row = $this->Mails_model->get_by_id($row->parent_id);
        }

        if ($row) {
            $data = [
                'status' => true,
                'message' => '',
                'data' => [
                    'id' => $row->id,
                    'mail_id' => $row->id,
                    'parent_id' => $row->parent_id,
                    'sender_id' => $row->sender_id,
                    'mail_from' => $row->mail_from,
                    'mail_to' => $row->mail_to,
                    'reciever_id' => $row->reciever_id,
                    'subject' => ($row->subject),
                    'body' => ($row->body),
                    'status' => $row->status,
                    'important' => $row->important,
                    'log' => $row->log,
                    'created' => globalDateTimeFormat($row->created),
                    'folder_id' => $row->folder_id,
                    'child_mails' => $this->Mails_model->get_all_child_mails($row->id),
                    'attachments' => get_all_attachments($row->id)
                ]
            ];

            return apiResponse($data);
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Record not found',
                'data' => null
            ]);
        }
    }

    public function api_reply_mail_action()
    {
        $token = $this->input->server('HTTP_TOKEN');

        if ($token) {
            $user = $this->db->select('user_tokens.user_id, users.role_id, users.email')
                ->join('users', 'user_tokens.user_id = users.id', 'LEFT')
                ->where('user_tokens.token', $token)
                ->get('user_tokens')->row();
            if (empty($user)) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Unauthorized',
                    'data' => null
                ]);
            }
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }


        $email = $this->db->where('mails.id', $this->input->post('id', TRUE))->get('mails')->row();
        $parent_id = $this->input->post('id', TRUE);
        $mail_to = $email->mail_to;
        $mail_from = $user->email;
        $subject = 'Re: ' . $email->subject;
        $message = $this->input->post('message', TRUE);
        $sendername = $this->getUserNameByEmail($mail_from);

        $data = array(
            'subject' => $subject,
            'mail_from' => $mail_from,
            'mail_to' => $mail_to,
            'message' => $message,
            'sendername' => $sendername,
            'mail_type' => 'Reply',
            'parent_id' => $parent_id
        );
        Modules::run('mail/replyMail', $data, true);

        return apiResponse([
            'status' => true,
            'message' => 'Replied Successfully',
            'data' => null
        ]);
    }

    public function getUserNameByEmail($email)
    {
        $this->db->select('first_name,last_name');
        $this->db->where('email', $email);
        $user = $this->db->get('users')->row();
        if ($user) {
            return "{$user->first_name} {$user->last_name}";
        } else {
            return 'Unknown User';
        }
    }

    /**
     * @param $parent_id
     * @return mixed
     */
    public function read_email_details($parent_id)
    {
        // matching request
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            return apiResponse([
                'status' => false,
                'message' => 'Method not allowed',
                'data' => []
            ]);
        }

        // checking isset parent id
        if (empty($parent_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid Request',
                'data' => []
            ]);
        }

        $token = $this->input->server('HTTP_TOKEN');
        $user_id = null;

        // checking token for user exit in our database
        if ($token) {
            $user = $this->db->select('user_tokens.user_id, users.role_id')
                ->join('users', 'user_tokens.user_id = users.id', 'LEFT')
                ->where('user_tokens.token', $token)
                ->get('user_tokens')->row();
            if (empty($user)) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Unauthorized',
                    'data' => []
                ]);
            }
            $user_id = $user->user_id;
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => []
            ]);
        }
        // Getting Parent mail data
        $parent_mail = $this->Mails_model->get_parent_mails_api($parent_id, $user_id);

        // checking isset parent email data
        if (!isset($parent_mail) && empty($parent_mail)) {
            return apiResponse([
                'status' => false,
                'message' => 'Conversation Not Found',
                'data' => []
            ]);
        }

        // MArk As Read
        if ($user_id == $parent_mail->reciever_id){
            $this->Mails_model->mark_as_read($parent_id);
        }

        // Rearrange Parent Data
        $mail_data = [[
            'id' => $parent_mail->id,
            'parent_id' => $parent_mail->parent_id,
            'mail_type' => $parent_mail->mail_type,
            'sender_id' => $parent_mail->sender_id,
            'reciever_id' => $parent_mail->reciever_id,
            'mail_from' => $parent_mail->mail_from,
            'mail_to' => $parent_mail->mail_to,
            'subject' => $parent_mail->subject,
            'body' => strip_tags($parent_mail->body),
            'status' => $parent_mail->status,
            'important' => $parent_mail->important,
            'log' => $parent_mail->log,
            'created' => $parent_mail->created,
            'folder_id' => $parent_mail->folder_id,
            'profile_image' => $parent_mail->profile_image,
        ]];

        // Getting Child Data
        $child_mail = $this->Mails_model->get_child_mails_api($parent_mail->id, $user_id);

        // Rearrange child data
        if ($child_mail) {
            foreach ($child_mail as $mail) {
                // MArk As Read
                if ($user_id == $parent_mail->reciever_id){
                    $this->Mails_model->mark_as_read($mail->id);
                }

                $mail_data [] = [
                    'id' => $mail->id,
                    'parent_id' => $mail->parent_id,
                    'mail_type' => $mail->mail_type,
                    'sender_id' => $mail->sender_id,
                    'reciever_id' => $mail->reciever_id,
                    'mail_from' => $mail->mail_from,
                    'mail_to' => $mail->mail_to,
                    'subject' => $mail->subject,
                    'body' => $mail->body,
                    'status' => $mail->status,
                    'important' => $mail->important,
                    'log' => $mail->log,
                    'created' => $mail->created,
                    'folder_id' => $mail->folder_id,
                    'profile_image' => $mail->profile_image,
                ];

            }
        }
        // finally sending net result
        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $mail_data
        ]);


    }

    /**
     * @return mixed
     * use this function for mail soft delete
     */
    public function mail_delete()
    {
        // matching request
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return apiResponse([
                'status' => false,
                'message' => 'Method not allowed',
                'data' => null
            ]);
        }

        $token = $this->input->server('HTTP_TOKEN');
        $user_id = null;

        // checking token for user exit in our database
        if ($token) {
            $user = $this->db->select('user_tokens.user_id, users.role_id')
                ->join('users', 'user_tokens.user_id = users.id', 'LEFT')
                ->where('user_tokens.token', $token)
                ->get('user_tokens')->row();
            if (empty($user)) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Unauthorized',
                    'data' => null
                ]);
            }
            $user_id = $user->user_id;
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        // collecting Input Field
        $mail_id = $this->input->post('mail_id');
        $who_delete = $this->input->post('delete_by');
        // checking all required field !empty
        if (empty($mail_id) || empty($who_delete)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid Request',
                'data' => null
            ]);
        }
        // getting parent mail data
        $parent_mail = $this->Mails_model->get_parent_mails_api($mail_id, $user_id);

        // checking isset parent email data
        if (!isset($parent_mail) && empty($parent_mail)) {
            return apiResponse([
                'status' => false,
                'message' => 'Conversation Not Found',
                'data' => null
            ]);
        }
        $check_field_name =  '';
        $update_field_name = '';

        if ($who_delete == 'sender') {
            $check_field_name = 'sender_id';
            $update_field_name = 'sender_delete';
        } elseif ($who_delete == 'receiver'){
            $check_field_name = 'reciever_id';
            $update_field_name = 'receiver_delete';
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Access Denied',
                'data' => null
            ]);
        }

        // checking he/she have access to delete the Mail
        if ($parent_mail->$check_field_name != $user_id) {
            return apiResponse([
                'status' => false,
                'message' => 'Access Denied',
                'data' => null
            ]);

        }
        // Now Soft delete the mail With Sending Final MSG
        if ($this->Mails_model->update($mail_id, [$update_field_name => 1])) {
            return apiResponse([
                'status' => true,
                'message' => 'Mail delete successfully.',
                'data' => null
            ]);
        }

        // When failed to delete mail
        return apiResponse([
            'status' => false,
            'message' => 'Something went wrong. Please try again later.',
            'data' => null
        ]);

    }

    function push(){
        send_push_to_app($this->input->get('user_id'), $this->input->get('title'), $this->input->get('type'), $this->input->get('message'), $this->input->get('photo'), $this->input->get('key'), $this->input->get('value'));
    }

    function checkPushOnOff(){
        // matching request
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'GET') {
            return apiResponse([
                'status' => false,
                'message' => 'Method not allowed',
                'data' => []
            ]);
        }

        $token = $this->input->server('HTTP_TOKEN');

        // checking token for user exit in our database
        if ($token) {
            $user = $this->db->select('user_tokens.user_id, users.role_id, user_tokens.is_on')
                ->join('users', 'user_tokens.user_id = users.id', 'LEFT')
                ->where('user_tokens.token', $token)
                ->get('user_tokens')->row();
            if (empty($user)) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Unauthorized',
                    'data' => []
                ]);
            }
            return apiResponse([
                'status' => true,
                'message' => '',
                'data' => [
                    'notification_is_on' => $user->is_on == 1 ? true : false
                ]
            ]);
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => []
            ]);
        }

    }

    /**
     * @return mixed
     */
    function pushOnOff(){
        // matching request
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            return apiResponse([
                'status' => false,
                'message' => 'Method not allowed',
                'data' => null
            ]);
        }

        $token = $this->input->server('HTTP_TOKEN');
        $user_id = null;

        // checking token for user exit in our database
        if ($token) {
            $user = $this->db->select('user_tokens.user_id, users.role_id, user_tokens.id as user_tokens_id')
                ->join('users', 'user_tokens.user_id = users.id', 'LEFT')
                ->where('user_tokens.token', $token)
                ->get('user_tokens')->row();
            if (empty($user)) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Unauthorized',
                    'data' => null
                ]);
            }
            $user_id = $user->user_id;
            $this->db->where('id', $user->user_tokens_id);
            // Update
            $this->db->update('user_tokens', ['is_on' => $this->input->post('is_on')]);
            $message = $this->input->post('is_on') == 1 ? 'Notification Turned On' : 'Notification Turned Off';
            // finalli sending msg
            return apiResponse([
                'status' => true,
                'message' => $message,
                'data' => null
            ]);
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }
    }
}