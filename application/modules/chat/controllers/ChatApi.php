<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ChatApi extends MX_Controller
{

    // private $role_id;

    function __construct()
    {
        parent::__construct();
        $this->role_id = getLoginUserData('role_id');
        $this->load->helper('chat');
    }

    public function chat_user_list()
    {
        $token = $this->input->server('HTTP_TOKEN');

        if (empty($token)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid data',
                'data' => null
            ]);
        }
        $u = $this->db->select('users.id, users.first_name, user_tokens.user_id , users.last_name, users.email')
            ->join('users', 'users.id = user_tokens.user_id', 'LEFT')
            ->where('user_tokens.token', $token)
            ->get('user_tokens')->row();
        if (empty($u)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid data',
                'data' => null
            ]);
        }

        $vendor_id = $u->user_id;
        $base_url = base_url();
        $query = $this->db->query("select DATE_FORMAT(STR_TO_DATE( `message`.`timestamp`, '%d %M,%Y %H:%i' ), '%Y-%m-%d %H:%i:%s') AS timestamp, message.message, otherUser.id as otherUserId, 
                                    IF(`otherUser`.role_id = '4', `cms`.post_title, concat(`otherUser`.first_name, ' ', `otherUser`.last_name)) as otherUserName, 
                                    CONCAT('$base_url', IF(`otherUser`.`oauth_provider` = 'web', IF(`otherUser`.`role_id` = '4', 'uploads/company_logo/', 'uploads/users_profile/'),''), IF(`otherUser`.role_id = '4', `otherUser`.profile_photo, `otherUser`.user_profile_image)) as otherUserProfileImage,
                                    COALESCE(temp.unread, 0) as unread
                                    from message 
                                    
                                    join users otherUser on otherUser.id = ( CASE message.receiver WHEN ' $vendor_id ' THEN message.sender ELSE message.receiver END )
                                    LEFT JOIN message t2 ON message.id < t2.id and ((t2.sender = otherUser.id AND t2.receiver = '$vendor_id') OR (t2.sender = '$vendor_id' AND t2.receiver = otherUser.id))
                                    LEFT JOIN (SELECT count(message.id) as unread, receiver, sender FROM message  WHERE message.receiver = ' $vendor_id ' AND message.read_status = 0 GROUP BY sender ) as  temp on temp.receiver = ' $vendor_id ' AND temp.sender = otherUser.id
                                    LEFT JOIN cms on cms.user_id = otherUser.id AND otherUser.role_id = 4 AND cms.post_type = 'business'
                                    
                                    where (message.sender = ' $vendor_id ' OR message.receiver = ' $vendor_id ')  AND t2.id is NULL
                                    ORDER BY message.id DESC;");

        $data['chats'] = $query->result();

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $data
        ]);
    }

    public function delete_chat()
    {
        $id = $this->input->get('delete');
        $this->db->delete('chat_messages', array('match_id' => $id));
        redirect('admin/chat');
    }

    public function get_user_chat()
    {
        $token = $this->input->server('HTTP_TOKEN');

        if (empty($token)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid data',
                'data' => null
            ]);
        }
        $u = $this->db->select('users.id, users.first_name, user_tokens.user_id , users.last_name, users.email')
            ->join('users', 'users.id = user_tokens.user_id', 'LEFT')
            ->where('user_tokens.token', $token)
            ->get('user_tokens')->row();
        if (empty($u)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid data',
                'data' => null
            ]);
        }

        $vendor_id = $u->user_id;
        $selectedUser = $_GET['id'];
        $query = $this->db->query('select message.*, DATE_FORMAT(STR_TO_DATE( `timestamp`, "%d %M,%Y %H:%i" ), "%Y-%m-%d %H:%i:%s") AS timestamp, otherUser.id as otherUserId, concat(otherUser.first_name, " ", otherUser.last_name) as otherUserName from message 
                                    join users otherUser on otherUser.id = (
                                        CASE message.receiver
                                        WHEN ' . $vendor_id . ' THEN message.sender
                                        ELSE message.receiver
                                        END
                                    )
                                    
                                     where (sender = ' . $vendor_id . ' and receiver = ' . $selectedUser . ') or (sender = ' . $selectedUser . ' and receiver = ' . $vendor_id . ') ORDER BY id');

        $data['chats'] = $query->result();
        // make msg read from unread
        $update_where_array = [
            'sender' =>  $selectedUser,
            'receiver' => $vendor_id,
            'read_status' => 0
        ];
        $this->db->where($update_where_array)->update('message', ['read_status' => 1]);

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $data
        ]);
    }

    public function send_chat_message()
    {
        $token = $this->input->server('HTTP_TOKEN');

        if (empty($token)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid data',
                'data' => null
            ]);
        }
        $base_url = base_url();
        $senderUser = $this->db->select('users.id, users.first_name, user_tokens.user_id , users.last_name, users.email, users.role_id')
            ->select("CONCAT('$base_url',IF(users.oauth_provider = 'web',IF(`users`.`role_id` = '4', 'uploads/company_logo/', 'uploads/users_profile/'),''), IF(`users`.role_id = '4', `users`.profile_photo, `users`.user_profile_image)) as profile_image")
            ->join('users', 'users.id = user_tokens.user_id', 'LEFT')
            ->where('user_tokens.token', $token)
            ->get('user_tokens')->row();
        if (empty($senderUser)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid data',
                'data' => null
            ]);
        }
        $send_to = $this->input->post('receiver');
        $message = $this->input->post('message');
        $sender = $senderUser->user_id;
        $channel = "chat-" . $send_to ."-" . $sender;
        $senderUserName = $senderUser->first_name . " " . $senderUser->last_name;
        $now = Carbon\Carbon::now()->format("d M, Y H:i");

        if ($senderUser->role_id == '4'){
            $bussnies_page = $this->db->select("post_title")
                ->where(['user_id' => $sender, 'post_type' => 'business'])
                ->get('cms')
                ->row();
            if (!empty($bussnies_page))  $senderUserName = $bussnies_page->post_title;
        }

        // make msg read from unread
        $update_where_array = [
            'sender' =>  $send_to,
            'receiver' => $sender,
            'read_status' => 0
        ];
        $this->db->where($update_where_array)->update('message', ['read_status' => 1]);

        $data = array(
            'sender' => $sender,
            'receiver' => $send_to,
            'timestamp' => $now,
            'message' => $message,
            'read_status' => 0
        );

        $this->db->insert('message', $data);
        send_push_to_app($send_to, $senderUserName, 'chat', $message, $senderUser->profile_image, 'sender_id', $sender);
        $curl = curl_init();


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return apiResponse([
                'status' => false,
                'message' =>  "cURL Error #:" . $err
            ]);
        } else {
            return apiResponse(json_decode($response));
        }
    }

    public function store_chat_message()
    {
        $base_url = base_url();
        $sender = $this->db->select('users.*')
            ->select("CONCAT('$base_url', 'uploads/',IF(`users`.`role_id` = '4', 'company_logo', 'users_profile'),'/', IF(`users`.role_id = '4', `users`.profile_photo, `users`.user_profile_image)) as profile_image")->where('id', $this->input->post('sender_id'))->get('users')->row();
        $receiver = $this->db->select('users.*')
            ->select("CONCAT('$base_url', 'uploads/',IF(`users`.`role_id` = '4', 'company_logo', 'users_profile'),'/', IF(`users`.role_id = '4', `users`.profile_photo, `users`.user_profile_image)) as profile_image")->where('id', $this->input->post('receiver_user_id'))->get('users')->row();

        if (empty($sender) || empty($receiver)){
            apiResponse(['status' => false]);
            return false;
        }

        $message = $this->input->post('message');
        $sender_id = $this->input->post('sender_id');
        $receiver_id = $this->input->post('receiver_user_id');
        $senderUserName = $sender->first_name . " " . $sender->last_name;
        $now = Carbon\Carbon::now()->format("d M, Y H:i");

        if ($sender->role_id == '4'){
            $bussnies_page = $this->db->select("post_title")
                ->where(['user_id' => $sender_id, 'post_type' => 'business'])
                ->get('cms')
                ->row();
            if (!empty($bussnies_page))  $senderUserName = $bussnies_page->post_title;
        }

        // make msg read from unread
        $update_where_array = [
            'sender' =>  $sender_id,
            'receiver' => $receiver_id,
            'read_status' => 0
        ];
        $this->db->where($update_where_array)->update('message', ['read_status' => 1]);

        $data = array(
            'sender' => $sender_id,
            'receiver' => $receiver_id,
            'timestamp' => $now,
            'message' => $message,
            'read_status' => 0
        );

        $this->db->insert('message', $data);
        send_push_to_app($receiver_id, $senderUserName, 'chat', $message, $sender->profile_image, 'sender_id', $sender_id);
        apiResponse(['status' => true]);
    }
}
