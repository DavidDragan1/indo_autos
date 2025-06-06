<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class _Chat extends Admin_controller {

    // private $role_id;

    function __construct() {
        parent::__construct();
        $this->role_id = getLoginUserData('role_id');
        $this->load->helper('chat');
    }

    public function index() {

        $vendor_id = getLoginUserData('user_id');
        $query = $this->db->query('select group_concat(message.id) as id , receiver from message where sender = ' . $vendor_id . ' group by receiver');
        $query = $this->db->query('select message.*, otherUser.id as otherUserId, concat(otherUser.first_name, " ", otherUser.last_name) as otherUserName from message 
                                    join users otherUser on otherUser.id = (
                                        CASE message.receiver
                                        WHEN ' . $vendor_id . ' THEN message.sender
                                        ELSE message.receiver
                                        END
                                    )
                                     where sender = ' . $vendor_id . ' or receiver = ' . $vendor_id . ' ORDER BY timestamp');

        $data['chats'] = $query->result();
//        ddd($query->result_array());
//        $match_id = $this->input->get('client_id');
        
//        $this->db->select('*');
        
//        $this->db->where('match_id', $match_id);
//        $this->db->where('sender', $vendor_id);
//        $this->db->or_where('reciever', $vendor_id);
//        $this->db->order_by('last_message_timestamp', 'DESC');
//        $data['chats'] = $this->db->from('message_thread')->get()->result();
       
        
//        $this->db->select('id, sender_id, match_id');
//        $this->db->where('vendor_id', $vendor_id);
//        $this->db->group_by('sender_id');
//        $this->db->order_by('created_at', 'DESC');
//        $data['guests'] = $this->db->from('chat_messages')->get()->result();


        $this->viewNewAdminContent('chat/chat', $data);
    }

    public function chat_message_send() {

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
            $pusher->trigger('my-channel-' . $send_to, 'my-event-'.$send_to, $data);
        }

        // save in DB
        $this->store($send_to, getLoginUserData('user_id'), $_POST['message']);
    }

    private function store($vendor_id = 0, $sender_id = 0, $message = null) {
        $data = array(
            'vendor_id' => $vendor_id,
            'sender_id' => $sender_id,
            'match_id' => $vendor_id,
            'message' => $message
        );

        $this->db->insert('chat_messages', $data);
    }

    
    public  function chat_notice( $selected = 0 ){
        
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
                                
               $class = ($selected == $guest->sender_id ) ? 'active' : '';
                   $html .=   '<li class="'. $class .'" id="guestID_'. $guest->sender_id .'" >';
                   $html .=    '<a href="'.base_url('admin/chat?client_id=' . $guest->sender_id) .'">Guest ID-'.$guest->sender_id.'</a></li> ';

            endforeach;
             else :;
                $html .=   ' <p>No Chat history found</p>';
           endif;

           $html .=  '</ul>';
           $html .=   '</div>';
        
           echo $html;
        
    }
    
    public function delete_chat(){
       $id =  $this->input->get('delete');
       $this->db->delete('chat_messages', array('match_id' => $id));
       redirect('admin/chat');
    }
    
    public function  request(){
        
        $this->db->select('*');      
        $data['requests'] = $this->db->order_by('id', 'DESC')->get('chat_permission')
                ->result();
       
        $this->viewAdminContent('chat/requests', $data);
    }
    
   
    
    public  function chat_status_update(){
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
    
    public  function chat_status_delete(){
        $id = $this->input->post('id');            
        $this->db->where('id', $id)->delete('chat_permission');
        echo '<p class="ajax_success">Successfully Removed</p>';
    }
    
    
    
    
    
    
}
