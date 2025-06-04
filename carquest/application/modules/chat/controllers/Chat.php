<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends Admin_controller
{

    // private $role_id;

    function __construct()
    {
        parent::__construct();
        $this->role_id = getLoginUserData('role_id');
        $this->load->helper('chat');
    }

    public function index()
    {
        $vendor_id = getLoginUserData('user_id');
//        $query = $this->db->query('select message.timestamp, message.message, otherUser.id as otherUserId, concat(otherUser.first_name, " ", otherUser.last_name) as otherUserName
//                                    from message
//                                    join users otherUser on otherUser.id = ( CASE message.receiver WHEN ' . $vendor_id . ' THEN message.sender ELSE message.receiver END )
//                                                        LEFT JOIN message t2 ON message.id < t2.id and (t2.sender = otherUser.id or t2.receiver = otherUser.id)
//                                    where (message.sender = ' . $vendor_id . ' AND t2.id is NULL) or (message.receiver = ' . $vendor_id . ' AND t2.id is NULL)
//                                    ORDER BY message.id DESC;');


        $query = $this->db->query("select roles.role_name as otherUserRoleName, otherUser.id as otherUserId, 
                                    IF(`otherUser`.role_id = '4', `cms`.post_title, concat(`otherUser`.first_name, ' ', `otherUser`.last_name)) as otherUserName, 
                                    CONCAT(IF(`otherUser`.`oauth_provider` = 'web', IF(`otherUser`.`role_id` = '4', 'uploads/company_logo/', 'uploads/users_profile/'),''), IF(`otherUser`.role_id = '4', `otherUser`.profile_photo, `otherUser`.user_profile_image)) as otherUserProfileImage,
                                    COALESCE(temp.unread, 0) as unread

                                    from message 
                                    
                                    join users otherUser on otherUser.id = ( CASE message.receiver WHEN ' $vendor_id ' THEN message.sender ELSE message.receiver END )
                                    LEFT JOIN message t2 ON message.id < t2.id and ((t2.sender = otherUser.id AND t2.receiver = '$vendor_id' AND t2.receiver_delete = 0) OR (t2.sender = '$vendor_id' AND t2.receiver = otherUser.id AND t2.sender_delete = 0))
                                    LEFT JOIN (SELECT count(message.id) as unread, receiver, sender FROM message  WHERE message.receiver = ' $vendor_id ' AND message.read_status = 0 GROUP BY sender ) as  temp on temp.receiver = ' $vendor_id ' AND temp.sender = otherUser.id
                                    LEFT JOIN cms on cms.user_id = otherUser.id AND otherUser.role_id = 4 AND cms.post_type = 'business'
                                    LEFT JOIN roles on roles.id = otherUser.role_id 
                                    
                                    where ((message.sender = ' $vendor_id ' AND message.sender_delete = 0) OR (message.receiver = ' $vendor_id ' AND message.receiver_delete = 0))  AND t2.id is NULL
                                    ORDER BY message.id DESC;");

        $data['chats'] = $query->result();
        //pp($data['chats']);
        //$this->session->set_flashdata(['status' => 'success', 'message' => 'Post added Successfully.']);
        if ($this->role_id == 8) {
            viewAdminMechanicNew('backend/trade/template/chat', $data);
        } elseif ($this->role_id == 14){
            viewAdminDriverNew('backend/trade/template/chat', $data);
        } elseif($this->role_id == 9){
            $this->viewAdminContentPrivate('backend/trade/template/mechanic_chat', $data);
        } else {
            //$this->viewNewAdminContent('chat/chat', $data);
            $this->viewAdminContentPrivate('backend/trade/template/chat', $data);
        }
    }

    public function chat_message_send()
    {

        $send_to = $this->input->post('send_to');

        $options = array(
            'encrypted' => true
        );
        $pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, $options);

        $vendorName = getFirstNameByUserId(getLoginUserData('user_id'));


        $pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID);
        $presence_data = array('name' => $vendorName);

        $pusher->presence_auth('my-channel-' . getLoginUserData('user_id'), @$_POST['socket_id'], $vendorName, $presence_data);


        $data['name'] = $vendorName;
        if (isset($_POST['message'])) {
            $data['message'] = trim($_POST['message']);
            $pusher->trigger('my-channel-' . $send_to, 'my-event-' . $send_to, $data);
        }

        // save in DB
        $this->store($send_to, getLoginUserData('user_id'), $_POST['message']);
    }

    private function store($vendor_id = 0, $sender_id = 0, $message = null)
    {
        $data = array(
            'vendor_id' => $vendor_id,
            'sender_id' => $sender_id,
            'match_id' => $vendor_id,
            'message' => $message
        );

        $this->db->insert('chat_messages', $data);
    }


    public function chat_notice($selected = 0)
    {

        $vendor_id = getLoginUserData('user_id');
        $selected = $this->input->post('selected');
        $this->db->select('sender_id, match_id');
        $this->db->where('vendor_id', $vendor_id);
        $this->db->group_by('sender_id');
        $this->db->order_by('created_at', 'DESC');
        $guests = $this->db->from('chat_messages')->get()->result();


        $html = '';

        $html .= '<div class="chat_user_list">';
        $html .= '<ul>';
        if ($guests) :
            foreach ($guests as $guest) :

                $class = ($selected == $guest->sender_id) ? 'active' : '';
                $html .= '<li class="' . $class . '" id="guestID_' . $guest->sender_id . '" >';
                $html .= '<a href="' . base_url('admin/chat?client_id=' . $guest->sender_id) . '">Guest ID-' . $guest->sender_id . '</a></li> ';

            endforeach;
        else :;
            $html .= ' <p>No Chat history found</p>';
        endif;

        $html .= '</ul>';
        $html .= '</div>';

        echo $html;

    }

    public function delete_chat()
    {
        $id = $this->input->get('delete');
        $this->db->delete('chat_messages', array('match_id' => $id));
        redirect('admin/chat');
    }

    public function request()
    {

        $this->db->select('*');
        $data['requests'] = $this->db->order_by('id', 'DESC')->get('chat_permission')
            ->result();

        $this->viewAdminContent('chat/requests', $data);
    }


    public function chat_status_update()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $data = [
            'payment' => 'Paid',
            'created' => date('Y-m-d H:i:s', strtotime("+2 days")),
            'status' => $status,
        ];
        $this->db->where('id', $id)->update('chat_permission', $data);
        echo '<p class="ajax_success">Update Successfully</p>';
    }

    public function chat_status_delete()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('chat_permission');
        echo '<p class="ajax_success">Successfully Removed</p>';
    }

    public function deleteChatFull(){
        $who_delete = $this->input->post('who_delete');
        $whom_delete = $this->input->post('whom_delete');

        if (empty($who_delete) || empty($whom_delete)){
           echo ajaxRespond('error', 'Some Required Field Missing');die();
        }

        if ($who_delete != getLoginUserData('user_id')){
            echo ajaxRespond('error', 'Access Deny');die();
        }

        $this->db->query("UPDATE message 
                            SET sender_delete =
                            IF
                                ( sender = '$who_delete', 1, sender_delete ),
                                receiver_delete =
                            IF
                                ( receiver = '$who_delete', 1, receiver_delete ) 
                            WHERE
                                ( sender = '$who_delete' AND receiver = '$whom_delete' ) 
                                OR (
                                sender = '$whom_delete' 
                                AND receiver = '$who_delete')");

        echo ajaxRespond('success', 'The Chat Deleted');
    }
}
