<?php

class Chat_frontview extends MX_Controller {
    function __construct() {
        parent::__construct();
       // $this->load->model('Chat_model');
        $this->load->helper('chat');
    }

    public function chat() {
        $this->load->view( 'chat/index' );
    }

    public function chat_form() {
      $this->load->view( 'chat/chatform' );
    }

    public function machanic_chat_form() {
         $userID =  getLoginUserData('user_id');
        $roleID =  getLoginUserData('role_id');

        $chat_permission = $this->db->select('')
                ->where('requester_id', $userID)
                ->where('created >=',  date('Y-m-d H:i:s') )
                ->where('status', 'Approved' )
                ->where('requester_id', $userID)
                ->count_all_results('chat_permission');
        //  $roleID == 10 &&
        if($userID && $chat_permission ) {
            $this->load->view( 'chat/chatform' );
        } else if($userID  && empty($chat_permission)){
            $this->load->view( 'chat/request_chat' );
        } else {
			error_reporting(0);
			echo  '<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">';
			echo '<style type="text/css">
			.col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
				float: left;
			}
			.col-md-2 {
				width: 16.66666667%;
			} 
			.col-md-5 {
				width: 41.66666667%;
			}
			.clearfix{ clear: both; }
			.chat-front {
				margin-left: 50px;
				margin-right: 50px;
				width: 700px;
				margin: 0 auto;
			}
			.chat-front h3 {
				color: #000000;
				font-size: 28px;
				font-weight: bold;
				text-transform: uppercase;
				font-family: "Open Sans";
				text-align: center;
				margin-top: 30px;
				margin-bottom: 30px;
			}
			.chat-box {
				border: 1px solid #d3d3d3;
				border-radius: 5px;
				padding: 20px;
				font-family: "open sans";
				border-bottom: 2px solid #cfcfcf;
				text-align: center;
			}
			.chat-box  h4 {
				color: #323232;
				font-size: 20px;
				font-weight: bold;
				margin-bottom: 10px;
				margin-top: 13px;
			}
			.chat-box a.btn {
				background-color: #4aba70;
				color: #fff;
				padding: 13px 57px;
				display: inline-block;
				margin-top: 10px;
				text-decoration: none;
			}
			.chat-box.chat-box2 a.btn {
				background-color: #ef5c26;
			}
			.chat-front .col-md-2 {
				color: #969494;
				font-size: 25px;
				font-family: "open sans";
				padding-top: 71px;
				text-align: center;
			}
			</style>';
            echo '
            <div class="chat-front">
            <h3>To chat with our online Mechanics, please<br> make payment for your time session</h3>
            <div class="row">
                <div class="col-md-5">
                    <div class="chat-box">
                    <img src="assets/theme/images/chat-login.png" />
                    <h4>Already have an account?</h4>
                    <span style="color:#49a4d1;">click to login </span>
                    <br>
                    <a target="_parent" class="btn" href="'.site_url('my-account?goto=mechanic').'">Login</a>
                    </div>
                </div>
                <div class="col-md-2">or</div>
                <div class="col-md-5">
                    <div class="chat-box chat-box2">
                    <img src="assets/theme/images/chat-signup.png" />
                    <h4>Don\'t have an account?</h4>
                    <span style="color:#49a4d1;">Please sign up to chat <br> 
with a Mechanic </span>
                    <br>
                    <a target="_parent" class="btn" href="'.site_url('sign-up').'">SIGN UP</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            </div>

' ;
        }

    }

    public function chat_message_send() {

        $user_id = $_POST['send_to'];
        $token = $_POST['token'];


        $log = getLoginUserData('user_id');
        if(empty($log)) {
            $fromName = 'Guest';
        } else {
            $fromName = getFirstNameByUserId($log);
        }

        $options = array(
            'encrypted' => true
        );
        $pusher = new Pusher( PUSHER_APP_KEY , PUSHER_APP_SECRET , PUSHER_APP_ID , $options);

        $presence_data = array('name' => $fromName );

        $pusher->presence_auth('my-channel-'. $token, @$_POST['socket_id'], 'Guest' , $presence_data);

        $pusher = new Pusher( PUSHER_APP_KEY ,  PUSHER_APP_SECRET , PUSHER_APP_ID );

        $data['name'] = $fromName; // $token;
        if (isset($_POST['message'])) {
            $data['message'] = trim($_POST['message']);
            $pusher->trigger('my-channel-' . $user_id, 'my-event-'.$token, $data);
        }


        $this->store( $user_id , $token, $_POST['message']);

    }


    private function store( $vendor_id = 0, $sender_id = 0 , $message = null ){
        $data = array(
            'vendor_id' => $vendor_id,
            'sender_id' => $sender_id,
            'match_id' => $sender_id,
            'guest_user_id' => getLoginUserData('user_id'),
            'message' => $message
        );

        $this->db->insert('chat_messages', $data);
    }


    public function offline_message_send(){
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $message = $this->input->post('message');
        $receiver_id = $this->input->post('vendor_id');

        $data = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'receiver_id' => $receiver_id
        ];

      Modules::run('mail/offline_chat_message_send', $data);
        echo '<center style="padding-top: 150px;">Thank you</center>';
    }


     public function  request_action(){
        if(empty($this->input->post())){
             redirect( site_url('mechanic') );
        }
        $package_id = $this->input->post('package_id');
        $requester_id = getLoginUserData('user_id');
        $payment = 'Unpaid';
        $created = date('Y-m-d H:i:s');
        $status = 'Pending';

        $data = [
            'requester_id' => $requester_id,
            'payment' => $payment,
            'package_id' => $package_id,
           //  'pay_amount' => $xxxx,
            'created' => $created,
            'status' => $status,
        ];

        $this->db->insert('chat_permission', $data);
        $this->session->set_flashdata('msg', 'Your activation request has been submitted, we will activate your chat as soon as we receive your payment confirmation');
        redirect('mechanic');
    }

    public function send_chat_message()
    {
        $send_to = $this->input->post('receiver');
        $message = $this->input->post('message');
        $sender = getLoginUserData('user_id');

        $base_url = base_url();
        $senderUser = $this->db->select('users.*')
            ->select("CONCAT('$base_url', 'uploads/',IF(`users`.`role_id` = '4', 'company_logo', 'users_profile'),'/', IF(`users`.role_id = '4', `users`.profile_photo, `users`.user_profile_image)) as profile_image")
            ->where("id", $sender)
            ->get("users")
            ->row();
        $senderUserName = $senderUser->first_name . " " . $senderUser->last_name;


        if ($senderUser->role_id == '4'){
            $bussnies_page = $this->db->select("post_title")
                ->where(['user_id' => $sender, 'post_type' => 'business'])
                ->get('cms')
                ->row();
            if (!empty($bussnies_page))  $senderUserName = $bussnies_page->post_title;
        }

        $now = Carbon\Carbon::now()->format("d M, Y H:i");
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

        die(json_encode(['success' => true]));
    }


    public function get_user_chat()
    {
        $vendor_id = getLoginUserData('user_id');
        $selectedUser = $_GET['id'];
        $query = $this->db->query('select message.*, otherUser.id as otherUserId, concat(otherUser.first_name, " ", otherUser.last_name) as otherUserName from message 
                                    join users otherUser on otherUser.id = (
                                        CASE message.receiver
                                        WHEN ' . $vendor_id . ' THEN message.sender
                                        ELSE message.receiver
                                        END
                                    )
                                     where (sender = ' . $vendor_id . ' and receiver = ' . $selectedUser . ' and sender_delete = 0) or (sender = ' . $selectedUser . ' and receiver = ' . $vendor_id . ' and receiver_delete = 0) ORDER BY message.id');

        $data['chats'] = $query->result();
        // make msg read from unread
        $update_where_array = [
            'sender' =>  $selectedUser,
            'receiver' => $vendor_id,
            'read_status' => 0
        ];
        $this->db->where($update_where_array)->update('message', ['read_status' => 1]);

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }


}
