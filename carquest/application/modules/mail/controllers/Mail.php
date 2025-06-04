<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends MX_Controller {

    private $useSMTP 	= false;
	private	$cc 		= false;
	private	$bcc 		= false;
	private	$attach 	= false;
	private $subject	= 'Someone try to send mail without subject';
	public  $send_from	= 'no-reply@carquest.com';
	public  $from_name	= 'CarQuest';
	public  $send_to	= 'info@carquest.com';
	public  $body;
	private $ip;

    public function __construct() {
        parent::__construct();
        $this->ip   = $this->input->ip_address();
//        $this->cc   = getSettingItem('SendCcTo');
        $this->bcc   = getSettingItem('SendBccTo');
    }


    public function report_spam(){

        // ajaxAuthorized();
        $method = $_SERVER['REQUEST_METHOD'];

        $this->send_from = $this->input->post('your_mail');
        $user_id = getLoginUserData('user_id');

        //$_token = $this->security->get_csrf_token_name();
        //$_hash  = $this->security->get_csrf_hash();
        //dd(  $_token .' : '. $_hash );

        if (!filter_var($this->send_from, FILTER_VALIDATE_EMAIL)) {
            if($this->input->get('device_code', TRUE)){
                die( ajaxRespond('Fail', 'Invalid Email Address') );
            }else{
                die( ajaxRespond('Fail', '<p class="ajax_error">Invalid Email Address</p>') );
            }

        }

        //$this->send_to  = 'flickmedialtd@gmail.com';
        $this->subject  = 'Report Spam #' .  $this->input->post('post_id');
        $this->body     = $this->input->post('report_msg');


         $msgdata = [
            'name' => getUserDataByUserId( $user_id ),
            'email' => $this->send_from,
            'subject' => $this->subject,
            'message' => $this->input->post('report_msg'),
        ];

        if($method != 'POST'){
                json_output_display(400,array('status' => 0,'message' => 'Bad request.'));
            } else {
                if($this->input->get('device_code', TRUE)){
                    if( DEVICE_AUTH == $this->input->get('device_code', TRUE) && $method == 'POST' ) {
                       json_output_display( 200 ,$msgdata);
                    }
                     exit;
                }
            }



        $this->log();
        $this->save_in_db('ReportSpam', 0, $user_id );
        echo $this->send();
    }

    // get Quote
    // make
    public function send_offer(){

        $method = $_SERVER['REQUEST_METHOD'];

        // ajaxAuthorized();

        $post_id    = intval( $this->input->post('post_id') );
        $seller_id  = intval( $this->input->post('seller_id') );
        $quote_msg  = nl2br($this->input->post('offer_message'));
        $seller     = $this->db->select('id,first_name,last_name,email')->get_where('users', ['id' => $seller_id])->row();
        $sender_id          = getLoginUserData('user_id');
        $name               = getLoginUserData('name');

        if ($seller->id == $sender_id) {
            return ajaxRespond('Fail', 'You can not send offer to your own post' );
        }

        $template           = $this->useEmailTeamplate('sendGetQuoteToSeller');
        $this->from_name    = getLoginUserData('name');
        $this->subject      = $template->title . ' - ID#' . $post_id;
        $this->send_to      = $seller->email;
        $this->send_from    = getLoginUserData('user_mail');
        $templateBody       = $template->template;

        $this->body     = $this->filterEmailBody($templateBody,[
            'seller'        => $seller->first_name .' '. $seller->last_name,
            'sender_name'   => $name,
            'sender_email'  => $this->send_from,
            'message'       => $quote_msg ,
            'offer_price' => $this->input->post('offer_currency') . ' ' .$this->input->post('offer_price')
        ]);

        $this->log();
        $this->save_in_db('getQuote', $seller_id, $sender_id );
        $this->send();

        $this->from_name    = 'CarQuest';
        $this->subject      = $template->title . ' - ID#' . $post_id. ' Buyer Quote Confirmation';
        $this->send_to      = getLoginUserData('user_mail');
        $this->send_from    = 'no-reply@carquest.com';
        $templateBody       = $template->template;

        $this->body     = $this->filterEmailBody($templateBody,[
            'seller'        => $seller->first_name .' '. $seller->last_name,
            'sender_name'   => $name,
            'sender_email'  => getLoginUserData('user_mail'),
            'message'       => $quote_msg ,
            'offer_price' => $this->input->post('offer_currency') . ' ' .$this->input->post('offer_price')
        ]);

        $this->log();
        $this->save_in_db('getQuote', $seller_id, $sender_id );
        echo $this->send();
    }


    public function contact_seller(){
        ajaxAuthorized();
        $post_id            = intval( $this->input->post('post_id') );
        $seller_id          = intval( $this->input->post('seller_id') );
        $listing_url        = ( $this->input->post('listing_url') );
        $message            = nl2br($this->input->post('message'));
        $buyer_phone        = $this->input->post('phone');

        $sender_id          = intval( getLoginUserData('user_id')); // is if log in
        $this->send_from    = $this->input->post('email');      // Name
        $this->from_name    = $this->input->post('senderName'); // Email

        $seller             = $this->db->select('first_name,last_name,email')->get_where('users', ['id' => $seller_id])->row();
        $this->send_to      = $seller->email;


        $template           = $this->useEmailTeamplate('onContractToSeller');
        $this->subject      = $template->title . ' - ID#' . $post_id;
        $templateBody       = $template->template;

        $this->body     = $this->filterEmailBody($templateBody,[
            'seller'        => $seller->first_name .' '. $seller->last_name,
            'listing_url'   => base_url( 'post/'.$listing_url),
            'buyer_name'    => $this->from_name,
            'buyer_email'   => $this->send_from,
            'buyer_phone'   => $buyer_phone,
            'message'       => $message
        ]);

        $this->log();
        $this->save_in_db('onContractToSeller', $seller_id, $sender_id );
        echo $this->send();
    }


    public function buyer_seller_request(){
        ajaxAuthorized();

        $sender_id          = intval( getLoginUserData('user_id')); // is if log in
        $this->send_from    = getLoginUserData('user_mail');      // Name
        $this->from_name    = getLoginUserData('name'); // Email

        $template           = $this->useEmailTeamplate('buyerToSellerRequest');
        $this->subject      = $template->title . ' - ID#' . $sender_id;
        $templateBody       = $template->template;

        $this->body     = $this->filterEmailBody($templateBody,[
            'id'    => getLoginUserData('user_id'),
            'name'   => getLoginUserData('name'),
            'email'   => getLoginUserData('user_mail')
        ]);

        $this->log();
        $this->save_in_db('onContractToSeller', 0, $sender_id );
        echo $this->send();
    }


    public function index(){

       // Report spam
        ajaxAuthorized();

        $this->subject  = $this->input->post('subject');
        $this->body     = $this->input->post('body');




        echo ajaxRespond('Fail', json_encode( $_POST ) );
        echo ajaxRespond('Fail', 'Report Sent Successfully');

        //echo 'Method Callback';
        //dd($_POST);
        //$this->useEmailTeamplate($slug)
        $this->log();
        $this->send();
        $this->save_in_db();
    }

    private function useEmailTeamplate($slug = ''){
        $data = $this->db->get_where('email_templates', ['slug' => $slug])->row();
        return $data;
    }

    private function filterEmailBody($template = null, $placeholders = array(0)){
        if ($template && count($placeholders)){
            foreach ($placeholders as $key=>$value) {
                $template = str_replace('%' . $key . '%', $value, $template);
            }
        }
        return $template;
    }


    /**
     * same sent mail in txt file
     */
    private function log(){
            $log_path = APPPATH . '/logs/mail_log.txt';
            $mail_log = date('Y-m-d H:i:s A') . ' | ' . $this->ip .' | '. $this->subject . "\r\n";
            @file_put_contents( $log_path, $mail_log, FILE_APPEND);
    }

    /**
     * @param string $mail_type
     * @param int $reciever_id
     * @param int $sender_id
     * @param int $parent_id
     * saving all type of mail sent in database
     */
    private function save_in_db( $mail_type = 'general', $reciever_id = 0, $sender_id = 0, $parent_id = 0 ){
            $data = [
                    'mail_type' 	=> $mail_type,
                    'sender_id' 	=> $sender_id,
                    'reciever_id' 	=> $reciever_id,
                    'mail_from' 	=> $this->send_from,
                    'mail_to'           => $this->send_to,
                    'subject'           => $this->subject,
                    'body' 		=> $this->body,
                    'important' 	=> 0,
                    'log' 		=> '',
                    'created'           => date('Y-m-d H:i:s'),
                    'folder_id' 	=> 1,
                    'parent_id' 	=> $parent_id,
            ];
            $this->db->insert('mails', $data);
            if (in_array($mail_type, ['getQuote', 'ActivationNotification', 'onContractToSeller', 'sendNotificationBeforeListingExpires'])){
                send_push_to_app($reciever_id, $this->subject, 'mail', '', null, 'mail_id', $this->db->insert_id());
            }
    }

    private function send( ){
        // $send_to, $subject, $body, $cc = false, $bcc = false, $attach = null
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = $this->config->item('email_host');
        $mail->Port = $this->config->item('email_port');
        $mail->Username = $this->config->item('email_username');
        $mail->Password = $this->config->item('email_password');
        $this->send_from = $this->config->item('email_from');
        $this->from_name = $this->config->item('from_name');

        $mail->HeaderLine("Organization", 'carquest.com');
        $mail->HeaderLine("Content-Transfer-encoding", "8bit");
        $mail->HeaderLine("Message-ID", "<" . md5(uniqid(time())) . "@{$_SERVER['SERVER_NAME']}>");
        $mail->HeaderLine("X-MSmail-Priority", "Normal");
        $mail->HeaderLine("X-Mailer", "Microsoft Office Outlook, Build 11.0.5510");
        $mail->HeaderLine("X-MimeOLE", "Produced By Microsoft MimeOLE V6.00.2800.1441");
        $mail->HeaderLine("X-Sender", $this->send_from);
        $mail->HeaderLine("X-AntiAbuse", "This is a solicited email for - carquest.com mailing list.");
        $mail->HeaderLine("X-AntiAbuse", "Servername - {$_SERVER['SERVER_NAME']}");
        $mail->HeaderLine("X-AntiAbuse", $this->send_from);


        $mail->setFrom($this->send_from, $this->from_name);
        $mail->addAddress($this->send_to);
        $mail->addReplyTo($this->send_from, $this->from_name);

        if($this->cc){ $mail->addCC($this->cc); }
        if($this->bcc) {$mail->addBCC($this->bcc);}

        $mail->isHTML(true);

        $mail->Subject  = $this->subject;
        $mail->Body     = mail_header($this->subject).$this->body.mail_footer();
        $mail->AltBody  = strip_tags($this->body);

        //$mail->addAttachment('/var/tmp/file.tar.gz');

        if( $mail->send() ){
            return ajaxRespond('OK', 'Mail Sent');
        } else {
            return ajaxRespond('Fail', $mail->ErrorInfo );
        }

    }


    public function part_exchange(){

        $this->subject  = 'Part Exchange';

        $template       = $this->useEmailTeamplate('onRequestPartExchangeMailToAdmin');
        $this->send_to  = get_admin_email();

        $this->subject  = $template->title;

        $this->body     = $this->filterEmailBody($template->template,[
            'fullname'      => $this->input->post('full_name'),
            'email'         => $this->input->post('email'),
            'contact_no'    => $this->input->post('contact_no'),
            'vehicle_no'    => $this->input->post('vehicle_no'),
            'make'          => $this->input->post('make'),
            'model'         => $this->input->post('model'),
            'type_car'      => $this->input->post('car_type'),
            'fueltype'      => $this->input->post('fueltype'),

            'enginesize'    => $this->input->post('enginesize'),
            'mileage'       => $this->input->post('mileage'),
            'regi_no'       => $this->input->post('regi_no'),
            'year'          => $this->input->post('year')
        ]);

        $this->send_from = $this->input->post('email');
        $this->from_name = $this->input->post('full_name');


        $this->log();
        $this->save_in_db('onRequestPartExchangeMailToAdmin');
        $this->send_notify( $this->input->post('email') ,'onRequestPartExchangeMailToSender', $this->input->post('full_name'));
        echo $this->send();
    }



    public function car_finance(){

        $template       = $this->useEmailTeamplate('onRequestCarFinianceMailToAdmin');
        $this->send_to  = get_admin_email();

        $this->subject  = $template->title;

        $this->body     = $this->filterEmailBody($template->template,[
            'fullname'      => $this->input->post('full_name'),
            'email'         => $this->input->post('email'),
            'contact_no'    => $this->input->post('contact_no'),
            'amount_car'    => $this->input->post('car_amount'),
            'borrow'        => $this->input->post('borrow'),
            'emp_type'      => $this->input->post('emp_type'),
            'annual_salary' => $this->input->post('annual_salary')
        ]);

        $this->send_from = $this->input->post('email');
        $this->from_name = $this->input->post('full_name');


        $this->log();
        $this->save_in_db('onRequestCarFinianceMailToAdmin');
        $this->send_notify( $this->input->post('email') ,'onRequestCarFinianceMailToSender', $this->input->post('full_name'));
        echo $this->send();

    }


    private function send_notify($send_to, $useTemplate, $full_name){
        $this->send_to = $send_to;

        $templateSender = $this->useEmailTeamplate($useTemplate);
        $this->subject  = $templateSender->title;

        $this->body     = $this->filterEmailBody($templateSender->template,[
            'fullname'  => $full_name
        ]);

        $this->log();
        $this->save_in_db( $useTemplate );
        $this->send();

    }

    public function send_faq_notify_to_admin($mail_body = '', $email = ''){

        $templateSender     = $this->useEmailTeamplate('faqQuestionNotify');
        $this->send_from    = $email;
        $this->subject      = $templateSender->title;
        $this->body         = $this->filterEmailBody($templateSender->template,[
            'question'  => $mail_body
        ]);
        $this->log();
        $this->save_in_db( 'faqQuestionNotify' );
        $this->send();
    }

    public function send_faq_notify_to_visitor($mail_body = '', $email = ''){

        $templateSender     = $this->useEmailTeamplate('onAnswerToVisitorFAQ');
        $this->send_to      = $email;
        $this->subject      = $templateSender->title;
        $this->body         = $this->filterEmailBody($templateSender->template,[
            'html_body'  => $mail_body
        ]);
        $this->log();
        $this->save_in_db( 'onAnswerToVisitorFAQ' );
        $this->send();
    }


    public function send_pwd_mail(){
       $email = $this->input->get('email');
       $token =  $this->input->get('_token');

       $user = $this->db->get_where('users', ['email' => $email])->row();

        $this->send_to = $email;
        $this->from_name = 'CarQuest';



        $templateSender = $this->useEmailTeamplate('onRequestForgotPassword');
        $this->subject  = $templateSender->title;

        $this->body     = $this->filterEmailBody($templateSender->template,[
            'url'  => base_url().'auth/reset_password?token='.$token.'&email='.$email,
            'fullname'  =>  $user->first_name
        ]);

       $this->log();
       $this->save_in_db('resetPassword', $user->id);
       $this->send();
       //  return 'Test';
    }


    public function api_send_pwd_mail($options=[]) {
        $email      = $options['email'];
        $user_id    = $options['id'];

        $this->send_to      = $email;
//        $this->from_name    = $options['fullname'];
        $token              = $options['token'];

        $templateSender = $this->useEmailTeamplate('onAPIRequestForgotPassword');
        $this->subject  = $templateSender->title;

        $this->body = $this->filterEmailBody($templateSender->template, [
            'token'     => $token,
            'fullname'  => $options['fullname']
        ]);

        $this->log();
        $this->save_in_db('ResetPasswordAPI', $user_id);
        $this->send();
    }


    public function subscribe( $email = ''){
        ajaxAuthorized();

        $this->send_to = $email;

        if (!filter_var($this->send_to, FILTER_VALIDATE_EMAIL)) {
            die( ajaxRespond('Fail', '<p class="ajax_error">Invalide Email Address</p>') );
        }



        $templateSender = $this->useEmailTeamplate('onNewsletterSubscription');
        $this->subject  = $templateSender->title;

        $this->body     = $this->filterEmailBody($templateSender->template,[
            'email'  => $email,
            'unsubscribe'  => base_url().'newsletter_subscriber/Newsletter_subscriber_frontview/unsubscribe?e='.$email
        ]);

        $this->log();
        $this->save_in_db('newsletterSubscriber');

        echo $this->send();
   }



    public function send_a_message(){

        //ajaxAuthorized();
        //sleep(5);
        $method = $_SERVER['REQUEST_METHOD'];
        $device = $this->input->get('device', TRUE);

        $validCaptcha = checkRecaptcha();
        if (!$validCaptcha) {
            echo ajaxRespond('FAIL', 'Please verify you are not a robot');
            die();
        }

        $user_id    = intval( getLoginUserData('user_id') );
        $email      = $this->input->post('email');
        $name       = $this->input->post('name');
        $message    = $this->input->post('message');
        $subject    = $this->input->post('subject');
        $contact    = $this->input->post('contact');

        $this->send_from = $email;
        if (!filter_var($this->send_from, FILTER_VALIDATE_EMAIL)) {
            echo  ($device == 'flick') ? json_output_display(200, ['status' => 0, 'message' => 'Invalid Email']) : ajaxRespond('Fail', '<p class="ajax_error">Invalid Email</p>');
            die();
        }

        $this->send_to  = get_admin_email();
        $this->from_name  = $name;

        if(!empty($subject)){
           $this->subject =  '<p>Subject: '.$subject.'</p>';
        }else{
            $this->subject = 'Contact to Admin';
        }

        if(!empty($name)){
           $name =  '<p>Name: '.$name.'</p>';
        }

        if(!empty($email)){
           $c_email =  '<p>Name: '.$email.'</p>';
        }

        if(!empty($contact)){
           $contact =  '<p>Contact Number: '.$contact.'</p>';
        }

        if(!empty($message)){
           $message =  '<p>Message: '.$message.'</p>';
        }

        $this->body     =  $name . $c_email . $contact . $message;

        $msgdata = [

            'name' => $this->input->post('name'),
            'email' => $email,
            'subject' => $subject,
            'message' => $this->input->post('message'),
        ];

        if($method != 'POST'){
                json_output(400,array('status' => 0,'message' => 'Bad request.'));
            } else {
                if($device  && $method == 'POST'){
                   $api = [
                       'status' => 1,
                       'message' => 'Successfully email sent'
                   ];

                    json_output( 200 ,$api);
                   $this->send();
                } else {
                    echo $this->send();
                }
            }


        //dd($this->body);
        $this->log();
        $this->save_in_db('onContactToAdmin', 0, $user_id);

    }

    public function send_motor_association(){

        //ajaxAuthorized();
        //sleep(5);
        $method = $_SERVER['REQUEST_METHOD'];
        $device = $this->input->get('device', TRUE);


        $user_id    = (getLoginUserData('user_id')) ? getLoginUserData('user_id')  : 0;
        $email      = $this->input->post('email');
        $name       = $this->input->post('name');
        $contact    = $this->input->post('contact');

        $this->send_from = $email;
        if (!filter_var($this->send_from, FILTER_VALIDATE_EMAIL)) {
            echo  ($device == 'flick') ? json_output_display(200, ['status' => 0, 'message' => 'Invalid Email']) : ajaxRespond('Fail', '<p class="ajax_error">Invalid Email</p>');
            die();
        }

        $this->send_to  = get_admin_email();
        $this->from_name  = $name;


       $this->subject = 'Contact for Motor Association';


        if(!empty($name)){
           $name =  '<p>Name: '.$name.'</p>';
        }

        if(!empty($email)){
           $c_email =  '<p>Name: '.$email.'</p>';
        }

        if(!empty($contact)){
           $contact =  '<p>Contact Number: '.$contact.'</p>';
        }

        $this->body     =  $name . $c_email . $contact;

        $msgdata = [
            'name' => $name,
            'email' => $email,
            // 'subject' => $subject,
        ];

        if($method != 'POST'){
                json_output(400,array('status' => 0,'message' => 'Bad request.'));
            } else {
                if($device && DEVICE_AUTH == $this->input->get('device_code', TRUE) && $method == 'POST'){
                   $api = [
                       'status' => 1,
                       'message' => 'Successfully email sent'
                   ];

                    json_output( 200 ,$api);
                   $this->send();
                } else {
                    echo $this->send();
                }
            }


        //dd($this->body);
        $this->log();
        $this->save_in_db('onContactToAdmin', 0, $user_id);

    }




//
//    public function send_a_message(){
//
//        ajaxAuthorized();
//        sleep(5);
//
//        $user_id = intval( getLoginUserData('user_id') );
//        $this->send_from = $this->input->post('email');
//
//        if (!filter_var($this->send_from, FILTER_VALIDATE_EMAIL)) {
//            die( ajaxRespond('Fail', '<p class="ajax_error">Invalide Email</p>') );
//        }
//
//
//
//        $template       = $this->useEmailTeamplate('onRequestConactUsToAdmin');
//        $this->send_to  = get_admin_email();
//        $this->from_name  = $this->input->post('name');
//
//        $this->subject  = $template->title;
//
//        $this->body     = $this->filterEmailBody($template->template,[
//            'name'      => $this->input->post('name'),
//            'email'     => $this->input->post('email'),
//            'message'   => $this->input->post('body')
//        ]);
//
//        $this->log();
//        $this->save_in_db('onContactToAdmin', 0, $user_id);
//        echo $this->send();
//    }

    public function activation_notice($post_id){

        ajaxAuthorized();
        $get_user       = $this->db->get_where('posts', ['id' => $post_id ])->row();
        $user           = $this->db->get_where('users', ['id' => $get_user->user_id ])->row();

        $this->send_from = get_admin_email();

        $template       = $this->useEmailTeamplate('onPostActivationNotice');
        $this->send_to  = $user->email;
        $this->from_name  = $user->first_name;

        $this->subject  = $template->title;

        $this->body     = $this->filterEmailBody($template->template,[
            'username'      => $user->first_name,
            'post_slug'     => base_url('post/'). $get_user->post_slug,
        ]);

        $this->log();
        $this->save_in_db('ActivationNotification', $user->id);
        $this->send();

    }

    public function expire_notice(){
        $this->send_from = get_admin_email();
        $template       = $this->useEmailTeamplate('sendNotificationBeforeListingExpires');
        $this->subject  = $template->title;
        $this->body     = $template->template;

        $day_count 	= 3;
        $expriy_date    = date('Y-m-d', strtotime("+$day_count days "));
        $posts 		= $this->db
                                ->from('posts')
                                ->join('users', 'posts.user_id = users.id')
                                ->select('posts.id,user_id,posts.created,expiry_date,first_name,email,posts.title,post_slug')
                                ->where('expiry_date', $expriy_date)
                                ->where('posts.status', 'Active')
                                ->get()
                                ->result();



           foreach( $posts as $post){
               $this->sendExpireNotification( $post );
           }
    }

    private function sendExpireNotification( $post = null ){
        $this->send_to  = $post->email;
        $this->body     = $this->filterEmailBody($this->body,[
            'seller'            => $post->first_name,
            'listing_title'     => $post->title,
            'expire_date'       => globalDateFormat($post->expiry_date),
            'post_date'         => globalDateFormat($post->created),
            'url'               => base_url('post/'.  $post->post_slug )
        ]);

        $this->log();
        $this->save_in_db('sendNotificationBeforeListingExpires', $post->user_id);
        $this->send();
    }


    public function add_post_notice($post_id, $user_id = 0){
        // ajaxAuthorized();
        $get_user       = $this->db->get_where('posts', ['id' => $post_id ])->row();
        $user           = $this->db->get_where('users', ['id' => $get_user->user_id ])->row();

        $this->send_from = get_admin_email();

        $template       = $this->useEmailTeamplate('onPostAddNotice');
        $this->send_to  = $user->email;

        $this->subject  = $template->title;

        $this->body     = $this->filterEmailBody($template->template,[
            'username'      => $user->first_name,
            'post_slug'     => base_url().'admin/posts/update_post_detail/'. $post_id,
        ]);
        $user_id = ($user_id) ? $user_id : getLoginUserData('user_id');
       //  $user->id
        $this->log();
        $this->save_in_db('onPostAddNotice', $user_id  );
        $this->send();

    }


    public function welcome_mails($user_data){
        if($user_data['role_id'] == 4){
            $this->welcomeMail('onRegistrationTradeSeller', $user_data);
        } else if($user_data['role_id'] == 5){
             $this->welcomeMail('onRegistrationPrivateSeller', $user_data);
        }else if($user_data['role_id'] == 6) {
            $this->welcomeMail('onRegistrationNewBuyer', $user_data);
        }else if ($user_data['role_id'] == 999999) {
            $this->welcomeMail('onRegistrationNewSubRole', $user_data);
        }
    }

    private function welcomeMail($temName, $user_data){
        $this->send_from = get_admin_email();
        $this->send_to = $user_data['email'];
        $template       = $this->useEmailTeamplate($temName);
        $this->subject  = $template->title;
        $this->body     = $template->template;
        $this->from_name = 'CarQuest';

        $this->body     = $this->filterEmailBody($template->template,[
            'user_name' => $user_data['first_name'],
            'username'  => $user_data['email'],
            'password'  => $user_data['raw_pass'],
            'url'       => base_url('my-account'),
        ]);

        $this->log('sendWelcomeEmail');
        $this->save_in_db('WelcomeMail', $user_data['user_id']);
        $this->send();
    }

    public function verification_mails($user_data){
        $this->send_from = get_admin_email();
        $this->send_to = $user_data['email'];
        $template       = $this->useEmailTeamplate('emailVerification');
        $this->subject  = $template->title;
        $this->body     = $template->template;
        $this->from_name = 'CarQuest';

        $this->body     = $this->filterEmailBody($template->template,[
            'user_name' => $user_data['first_name'],
            'username'  => $user_data['email'],
            'url'       => base_url().'email-verification/'.$user_data['email_verification_code'],
        ]);

        $this->log('sendEmailVerification');
        $this->save_in_db('sendEmailVerification', $user_data['user_id']);
        pp($this->send());
    }


    public function replyMail($data  = NULL, $from_app = false){
        $template       = $this->useEmailTeamplate('onRequestReplyMail');
        $this->send_to  = $data['mail_to'];
        $this->subject  = $data['subject'];
        $this->body     = $this->filterEmailBody($template->template,[
            'subject'      => $data['subject'],
            'message'      => $data['message'],
        ]);
        $this->send_from = $data['mail_from'];
        $this->from_name = getLoginUserData('name');
        $this->log();
        $this->save_in_db('Reply',0,0, $data['parent_id']);
        if($from_app){
            $this->send();
        }else{
            echo $this->send();
        }
    }



    // Subscribtion notification
    public function subscribtion_notification( $data = null ){



        if( $data['email'] ) {
            $this->send_from =  get_admin_email();  ;
            $this->send_to = $data['email'];

            $templateSender = $this->useEmailTeamplate('onSubscriptionNotification');
            $this->subject  = $templateSender->title;

            $this->body     = $this->filterEmailBody($templateSender->template,[
                'post_title'  => $data['title'],
                'post_slug'  => $data['post_slug'],
                'vehicle_type'  => $data['type_id'],
                'brand_id'  => $data['brand_id'],
                'model_id'  => $data['model_id'],
                'location_id'  => $data['location_id'],
                'parts_description'  => $data['parts_description'],
                'year'  => $data['year'],
                'username'  => $data['username']
            ]);

            $this->log();
            $this->save_in_db('onSubscriptionNotification');
            echo $this->send();
        }
   }

   public function driver_hire(){

        $this->send_from = getLoginUserData('user_mail');
        $this->send_to = get_admin_email(); // $data['email'];

        $templateSender = $this->useEmailTeamplate('onDriverHire');
        $this->subject  = $templateSender->title;

        $this->body     = $this->filterEmailBody($templateSender->template,[
            'age'  => $this->input->post('age'),
            'type_of_car'  => $this->input->post('type_of_car'),
            'service_type'  => $this->input->post('service_type'),
            'marital_status'  => $this->input->post('marital_status'),
            'education_qualification'  => $this->input->post('education_qualification'),
            'year_of_experience'  => $this->input->post('year_of_experience'),
            'duration_day'  => $this->input->post('duration_day'),
            'start_date'  => $this->input->post('start_date'),
            'end_date'  => $this->input->post('end_date'),
            'resumption_date'  => $this->input->post('resumption_date'),
            'accomodation'  => $this->input->post('accomodation'),
            'location'  => GlobalHelper::getLocationById($this->input->post('location')),
            'print_city'  => $this->input->post('print_city'),
        ]);
        $this->log();
        $this->save_in_db('onDriverHire');
        echo $this->send();

   }






   /// API  Send  Offer
    public function api_send_offer(){

        $method = $_SERVER['REQUEST_METHOD'];
        $token = $this->input->server('HTTP_TOKEN');
        $post_id = intval($this->input->post('post_id'));
        $seller_id = intval($this->input->post('seller_id'));
        $this->from_name = $this->input->post('your_name');
        $quote_msg = nl2br($this->input->post('offer_message'));

        if (empty($seller_id) || empty($token)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid data',
                'data' => null
            ]);
        }

        $seller = $this->db->select('id,first_name,last_name,email')->get_where('users', ['id' => $seller_id])->row();
        if (empty($seller)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid data',
                'data' => null
            ]);
        }
        $this->send_to = $seller->email;

        $u = $this->db->select('users.first_name, user_tokens.user_id , users.last_name, users.email')
            ->join('users', 'users.id = user_tokens.id', 'LEFT')
            ->where('user_tokens.token', $token)
            ->get('user_tokens')->row();

        if (empty($u)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid data',
                'data' => null
            ]);
        }

        if ($u->user_id == $seller->id) {
            return apiResponse([
                'status' => false,
                'message' => 'You can not send offer to your own post',
                'data' => null
            ]);
        }
        $sender_id = $u->user_id;
        $this->send_from = $u->email;
        $name = $u->first_name . ' ' . $u->last_name;

        $template = $this->useEmailTeamplate('sendGetQuoteToSeller');
        $this->subject = $template->title . ' - ID#' . $post_id;
        $templateBody = $template->template;

        $this->body = $this->filterEmailBody($templateBody, [
            'seller' => $seller->first_name . ' ' . $seller->last_name,
            'sender_name' => $name,
            'sender_email' => $this->send_from,
            'message' => $quote_msg,
            'offer_price' => $this->input->post('offer_currency') . ' ' .$this->input->post('offer_price')
        ]);

        if ($method == 'POST') {
            $this->log();
            $this->save_in_db('getQuote', $seller_id, $sender_id);
            $this->send();
            return apiResponse([
                'status' => true,
                'message' => 'Your offer is sent to our seller',
                'data' => null
            ]);
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Bad request.',
                'data' => null
            ]);
        }

    }

    public function api_contact_to_seller(){
        $post_id            = intval( $this->input->post('post_id') );
        $seller_id          = intval( $this->input->post('seller_id') );
        $listing_url        = ( $this->input->post('listing_url') );
        $message            = nl2br($this->input->post('message'));
        $buyer_phone        = $this->input->post('phone');

        $sender_id          = intval( getLoginUserData('user_id')); // is if log in
        $this->send_from    = $this->input->post('email');      // Name
        $this->from_name    = $this->input->post('sender_name'); // Email

        $seller             = $this->db->select('first_name,last_name,email')->get_where('users', ['id' => $seller_id])->row();
        $this->send_to      = $seller->email;


        $template           = $this->useEmailTeamplate('onContractToSeller');
        $this->subject      = $template->title . ' - ID#' . $post_id;
        $templateBody       = $template->template;

        $this->body     = $this->filterEmailBody($templateBody,[
            'seller'        => $seller->first_name .' '. $seller->last_name,
            'listing_url'   => base_url( 'post/'.$listing_url),
            'buyer_name'    => $this->from_name,
            'buyer_email'   => $this->send_from,
            'buyer_phone'   => $buyer_phone,
            'message'       => $message
        ]);

        $this->log();
        $this->save_in_db('onContractToSeller', $seller_id, $sender_id );
        $response = $this->send();
        if (strpos($response, 'OK')) {
            return apiResponse([
                'status' => true,
                'message' => 'Your message has been sent to seller',
                'data' => null
            ]);
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Something went wrong. Please try again',
                'data' => null
            ]);
        }
    }

    public function carInsurance($email, $full_name, $code){
        $this->send_to = $email;

        $templateSender = $this->useEmailTeamplate('onRequestCarInsuranceMailToSender');
        $this->subject  = $templateSender->title;

        $this->body     = $this->filterEmailBody($templateSender->template,[
            'fullname'  => $full_name,
            'code'  => $code,
            'track'  => site_url('track-your-application'),
        ]);

        $this->log();
        $this->save_in_db( 'onRequestCarInsuranceMailToSender' );
        $this->send();
    }

    public function carLoan($email, $full_name, $code){
        $this->send_to = $email;

        $templateSender = $this->useEmailTeamplate('onRequestCarLoanMailToSender');
        $this->subject  = $templateSender->title;

        $this->body     = $this->filterEmailBody($templateSender->template,[
            'fullname'  => $full_name,
            'code'  => $code,
            'track'  => site_url('track-your-application'),
        ]);

        $this->log();
        $this->save_in_db( 'onRequestCarLoanMailToSender' );
        $this->send();
    }

    public function send_insurance_message_to_customer($email, $name, $message, $subject, $type){

        $user_id    = intval( getLoginUserData('user_id') );
        $user    = $this->db->where('id', $user_id)->get('users')->row();
        $data = ['status' => 'success', 'message' => 'Email send successfully.'];

//        $this->send_from = $user->email;
//        if (!filter_var($this->send_from, FILTER_VALIDATE_EMAIL)) {
//            $data['status'] = 'error';
//            $data['message'] = 'Invalid Email';
//
//            return $data;
//        }

        $this->send_to  = $email;

        if (!filter_var($this->send_to, FILTER_VALIDATE_EMAIL)) {
            $data['status'] = 'error';
            $data['message'] = 'Invalid Email';

            return $data;
        }

        if(!empty($subject)){
            $this->subject =  $subject;
        }else{
            $data['status'] = 'error';
            $data['message'] = 'Please write a subject.';

            return $data;
        }

        if(empty($message)){
            $data['status'] = 'error';
            $data['message'] = 'Please write a message.';

            return $data;
        }

        $this->body  =  $message;

        echo $this->send();

        $this->log();
        if ($type == 'loan') {
            $this->save_in_db( 'contact_to_loan_customer', 0, $user_id);
        } else {
            $this->save_in_db( 'contact_to_insurance_customer', 0, $user_id);
        }

        return $data;
    }

    public function app_verification_mails($user_data){
        $this->send_from = get_admin_email();
        $this->send_to = $user_data['email'];
        $template       = $this->useEmailTeamplate('appEmailVerification');
        $this->subject  = $template->title;
        $this->body     = $template->template;
//        $this->from_name = $user_data['first_name'];

        $this->body     = $this->filterEmailBody($template->template,[
            'user_name' => $user_data['first_name'],
            'username'  => $user_data['email'],
            'code'       => $user_data['email_verification_code'],
        ]);

        $this->log('sendEmailVerification');
        $this->save_in_db('sendEmailVerification', $user_data['user_id']);
        $this->send();
    }

    public function driver_join_request($user_data){
        $this->send_from = get_admin_email();
        $this->send_to = $user_data['email'];
        $template       = $this->useEmailTeamplate('driverJoin');
        $this->subject  = $template->title;
        $this->body     = $template->template;
//        $this->from_name = $user_data['first_name'];

        $this->body     = $this->filterEmailBody($template->template,[
            'user_name' => $user_data['name'],
            'code'       => $user_data['driver_track_id'],
        ]);

        $this->save_in_db('driverJoin', $user_data['driver_track_id']);
        $this->send();
    }

    public function driver_hire_request($data){
        $this->send_from = get_admin_email();
        $this->send_to = $data['email'];
        $template       = $this->useEmailTeamplate('driverHireRequest');
        $this->subject  = $template->title;
        $this->body     = $template->template;
//        $this->from_name = $user_data['first_name'];

        $this->body     = $this->filterEmailBody($template->template,[
            'code'       => $data['code'],
        ]);

        $this->save_in_db('driverHireRequest', $data['code']);
        $this->send();
    }

    public function send_message_to_admin()
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
            ->join('users', 'users.id = user_tokens.id', 'LEFT')
            ->where('user_tokens.token', $token)
            ->get('user_tokens')->row();
        if (empty($u)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid data',
                'data' => null
            ]);
        }
        $user_id = $u->id;
        $email = $this->input->post('email');
        $name = $this->input->post('name');
        $message = $this->input->post('message');
        $subject = $this->input->post('subject');
        $contact    = $this->input->post('contact');

        $this->send_from = $email;
        if (!filter_var($this->send_from, FILTER_VALIDATE_EMAIL)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid Email',
                'data' => null
            ]);
        }

        $this->send_to = get_admin_email();
        $this->from_name = $name;


        if(!empty($contact)){
            $contact =  '<p>Contact Number: '.$contact.'</p>';
        }

        if (!empty($subject)) {
            $this->subject = '<p>Subject: ' . $subject . '</p>';
        } else {
            $this->subject = 'Contact to Admin';
        }

        if (!empty($name)) {
            $name = '<p>Name: ' . $name . '</p>';
        }

        if (!empty($email)) {
            $email = '<p>Name: ' . $email . '</p>';
        }

        if (!empty($message)) {
            $message = '<p>Message: ' . $message . '</p>';
        }

        $this->body = $name . $email . $contact . $message;
        $this->send();
        $this->log();
        $this->save_in_db('onContactToAdmin', 0, $user_id);

        return apiResponse([
            'status' => true,
            'message' => 'Email is sent successfully',
            'data' => null
        ]);
    }

    public function mechanic($email, $full_name, $problem, $brand, $model, $receiver_id = 0, $sender_id = 0){
        $this->send_to = $email;

        $templateSender = $this->useEmailTeamplate('onRequestMechanicForInsurance');
        $this->subject  = $templateSender->title;

        $this->body     = $this->filterEmailBody($templateSender->template,[
            'name'  => $full_name,
            'problem'  => $problem,
            'brand'  => $brand,
            'model'  => $model,
        ]);

        $this->log();
        $this->save_in_db( 'onRequestMechanicForInsurance', $receiver_id, $sender_id );
        $this->send();
    }


}

