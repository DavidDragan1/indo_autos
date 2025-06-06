<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-10-13
 */

class Auth extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('form_validation');
        $this->load->library('Facebook');
    }

    public function login() {
        ob_start();

        $validCaptcha = checkRecaptcha();
        if (!$validCaptcha) {
            echo ajaxRespond('FAIL', 'Please verify you are not a robot');
            exit;
        }

        $method = $_SERVER['REQUEST_METHOD'];
        $device = $this->input->get('device');

        // ajaxAuthorized();
        // sleep(1);
        /*
         * Stop Brute Force Attract   // by sleeping now...
         * will add account deactivation letter
         */
        $data = $this->session->flashdata('login');
        if($this->session->flashdata('login')) {
            $username =  $data['username'];
            $password =  $data['password'];
        } else{
            $username = $this->security->xss_clean($this->input->post('username'));
            $password = $this->security->xss_clean($this->input->post('password'));
        }

        $remember = ($this->input->post('remember')) ? (60 * 60 * 24 * 7) : 0;

        if (!$username) {
            echo ($device == 'flick')
                    ? json_encode(['status' => 0, 'message' => 'Please enter valid username!'])
                    : ajaxRespond('Fail', 'Please enter valid username!');
            exit;
        }


        if (!filter_var($username, FILTER_VALIDATE_EMAIL) ) {
            echo ($device == 'flick')
                ? json_encode(['status' => 0, 'message' => 'Please enter a valid user name'])
                : ajaxRespond('Fail', 'Please enter a valid user name');
            exit;
        }

        $userdata = $this->Auth_model->validateUser($username);

        if(!$userdata){
            echo ($device == 'flick')
                    ? json_encode(['status' => 0, 'message' => 'Incorrect Username!'])
                    : ajaxRespond('Fail', 'Incorrect Username!');
            exit;
        }

        if (!password_verify($password, $userdata->password??'')) {
            echo ($device == 'flick')
                ? json_encode(['status' => 0, 'message' => 'Incorrect Password!'])
                : ajaxRespond('Fail', 'Incorrect Password!');
            exit;
        }

        if (!empty($userdata->is_deleted)){
            echo ($device == 'flick')
                ? json_encode(['status' => 0, 'message' => 'This Account is Deleted'])
                : ajaxRespond('Fail', '<p class="ajax_error">This Account is Deleted</p>');
            exit;
        };


        if ($userdata->status !== 'Active') {
            echo ($device == 'flick')
                ? json_encode(['status' => 0, 'message' => 'Your account is inactive'])
                : ajaxRespond('Fail', 'Your account is inactive');
            exit;
        }

        $history_id = $this->login_history( $userdata->id, $userdata->role_id );


        $cookie_data = json_encode([
            'user_id' 	=> $userdata->id,
            'user_mail' => $userdata->email,
            'role_id' 	=> $userdata->role_id,
            'name' 	=> $userdata->first_name . ' ' . $userdata->last_name,
            'photo' 	=> $userdata->user_profile_image,
            'history' 	=> $history_id,
            'oauth_uid' => $userdata->oauth_uid,
            'oauth_provider' => $userdata->oauth_provider

        ]);

        $cookie = [
            'name' 	=> 'login_data',
            'value' 	=> base64_encode($cookie_data),
            'expire' 	=> $remember,
            'secure' 	=> false
        ];

        $this->input->set_cookie($cookie);
        $this->session->set_userdata($cookie);

        if( $this->session->userdata('re_url') ) {
           echo ajaxRespond('URL', $this->session->userdata('re_url'));
        } else {

            if($method != 'POST'){
                json_output_display(400,array('status' => 0,'message' => 'Bad request.'));
                exit;
            }
            echo ($device == 'flick')
                ? json_encode($this->set_token($userdata) )
                : ajaxRespond('OK', 'Login Success');
        }
    }

    public function sign_up(){
	// ob_start();
        // ajaxAuthorized();
        $this->_rules();
        $device = $this->input->get('device');

        $validCaptcha = checkRecaptcha();
        if (!$validCaptcha) {
            echo ajaxRespond('FAIL', 'Please verify you are not a robot');
            exit;
        }

        if ($this->form_validation->run() == FALSE) {
            $valid = [
                'first_name' => form_error('first_name'),
                'your_email' => form_error('your_email'),
                'password'   => form_error('password'),
                'passconf'   => form_error('passconf'),
                'role_id'    => form_error('role_id'),
            ];
            // mail function add here
            if($device == 'flick'){
                $valid_err =  [
                   'status'     => 0,
//                   'message'    => 'This email address already in used',
                   'message'    =>  form_error('first_name') .
                                    form_error('your_email') .
                                    form_error('password') .
                                    form_error('passconf') .
                                    form_error('role_id'),
                ];
                json_output_display(200, $valid_err);
                die;
            } else {
                $errors = $this->form_validation->error_array();

                echo ajaxRespond('FAIL', $errors[array_keys($errors)[0]]);die();
            }

        } else {
            $user_id = $this->create();

            //echo ( $user_id );
            echo $this->auto_login( $user_id );
        }
	// ob_clean();
    }

    private function auto_login( $user_id ){

        $device = $this->input->get('device');
        $username = $this->security->xss_clean($this->input->post('your_email'));
        $remember = (60 * 60 * 24 * 7);


        $cookie_data = json_encode([
            'user_id'   => $user_id,
            'role_id'   => $this->input->post('choose_profile') == 'seller' ? $this->input->post('seller_role') : $this->input->post('choose_profile'),
            'user_mail' => $username,
            'name'      => $this->input->post('first_name') . ' ' . $this->input->post('last_name') ,
            'photo'     => 'no-photo.gif'
        ]);
//        echo $this->input->post('role_id');
//        pp($cookie_data);
        $cookie = [
            'name'      => 'login_data',
            'value'     => base64_encode($cookie_data),
            'expire'    => $remember,
            'secure'    => false
        ];

        $this->input->set_cookie($cookie);
        $this->session->set_userdata($cookie);

        $user       = $this->Auth_model->get($user_id);
        $respond    = $this->set_token( $user );

        return ($device == 'flick')
            ? json_output_display( 200, $respond )
            : ajaxRespond('OK', 'Auto login success!');
    }

    private function set_token( $user ){

        $this->db->set('current_status', 'Online');
        $this->db->set('last_access', (time() + 120 ) );
        $this->db->where('id', $user->id);
        $this->db->update('users');

        $token  = make_token(128);
        $data   = [
            'user_id'       => $user->id,
            'token'         => $token,
            'device_type'   => $this->input->post('device_type'),
            'device_token'  => $this->input->post('device_token'),
            'created'       => date('Y-m-d H:i:s')
        ];
        $this->db->insert('user_tokens', $data );

        $photo = ($user->user_profile_image) ? $user->user_profile_image : 'default_logo.jpg';

        $api_cookie_data = [
            'user_id'           => $user->id,
            'user_mail'         => $user->email,
            'role_id'           => $user->role_id,
            'name'              => $user->first_name . ' ' . $user->last_name,
            'photo'             => $user->oauth_provider == 'web' ? base_url("uploads/users_profile/{$photo}") : $photo,
            'current_status'    => 'Online',
            'token'             => $token,
        ];
        if($user->role_id == 4){
            $api_cookie_data['photo'] = base_url("uploads/company_logo/{$photo}");
        }

        $loginData = [
            'status'    => 1,
            'message'   => 'Successfully Logged',
            'result'    => $api_cookie_data,
        ];
        return $loginData;
    }

    public function logout() {
        $user_id = getLoginUserData('user_id');
        $current_status = array('current_status' => 'Offline');
        $this->db->where('id', $user_id);
        $this->db->update('users', $current_status);

        if (getLoginUserData('oauth_provider') == 'facebook') {
            $this->facebook->destroy_session();
        }
        if (getLoginUserData('oauth_provider') == 'google') {
            $google_client = new Google_Client();

            $google_client->setClientId($this->config->item('google_client_id')); //Define your ClientID

            $google_client->setClientSecret($this->config->item('google_client_secret')); //Define your Client Secret Key
            $google_client->revokeToken();
        }

        $cookie = [
            'name'      => 'login_data',
            'value'     => false,
            'expire'    => -84000,
            'secure'    => false
        ];
        $this->logout_history();
        $this->input->set_cookie($cookie);
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('value');
        $this->session->unset_userdata('expire');
        $this->session->unset_userdata('secure');
        $this->session->unset_userdata('re_url');
        redirect(site_url(), 'refresh');
    }

    public function login_form() {
        $this->load->view('auth/login');
    }

    private function create(){
        $this->load->helper('string');

        $method = $_SERVER['REQUEST_METHOD'];
        $device = $this->input->get('device');

        if($this->input->post('choose_profile', TRUE) == 'seller'){
            $role_id = $this->input->post('seller_role', TRUE);
        } else {
            $role_id = $this->input->post('choose_profile', TRUE);
        }

        $email_verification_code = md5($this->input->post('your_email', TRUE).uniqid().random_string('alnum',5));
        $user_data = [
            'role_id'       => $role_id,
            'first_name'    => $this->input->post('first_name', TRUE),
            'last_name'     => $this->input->post('last_name', TRUE),
            'email'         => $this->input->post('your_email', TRUE),
            'email_verification_status' => 'pending',
            'email_verification_code' => $email_verification_code,
            'contact'       => $this->input->post('your_contact', TRUE),
            'password'      => password_encription( $this->input->post('password', TRUE) ),
            'status'        => 'Active',
            'created'       => date('Y-m-d H:i:s'),
            'country_id' => 155
        ];

        $this->Auth_model->sign_up( $user_data );

        $user_id = $this->db->insert_id();

        // Create Company Page, if role ID is 4
        if($role_id == 4 && $device == 'flick'){
            $this->setCompanyPage( $user_id );
        }

        $user_data['user_id'] = $user_id;


        $userData = [
            'role_id'       => $role_id,
            'first_name'    => $this->input->post('first_name', TRUE),
            'last_name'     => $this->input->post('last_name', TRUE),
            'email'         => $this->input->post('your_email', TRUE),
            'password'      => password_encription($this->input->post('password', TRUE)),
            'raw_pass'      => $this->input->post('password', TRUE) ,
            'email_verification_code' => $email_verification_code,
            'user_id'       => $user_id,
            'url'           => site_url('/my_account'),
        ];

        $raw_pass = $this->input->post('password', TRUE);
        $userDataApi = [
            'status' => 1,
            'message' => 'Successfully registered',
            'details' => [
                'user_id'       => $user_id,
                'role_id'       => $role_id,
                'role_name'     => getRoleName($role_id),
                'first_name'    => $this->input->post('first_name', TRUE),
                'last_name'     => $this->input->post('last_name', TRUE),
                'email'         => $this->input->post('your_email', TRUE),
                'password'      => password_encription($raw_pass),
                'raw_pass'      => $this->input->post('password', TRUE) ,
                'status'        => 'Active',
                'created'       => date('Y-m-d H:i:s'),
                'redirect_url'  => site_url('admin/Api/notifications')
            ]
        ];

        if($method != 'POST'){
            echo json_output_display(400,array('status' => 0, 'message' => 'Bad request.'));
            exit;
        }

        //      if($this->input->get('device_code', TRUE) && DEVICE_AUTH == $this->input->get('device_code', TRUE) && $method == 'POST' ){
        //      if(empty($device)){
        //          Modules::run('mail/welcome_mails', $userData );
        //          return $user_id;
        //      }
        //      Modules::run('mail/welcome_mails', $userData );
        //      json_output_display( 200, $userDataApi);
        //      exit;
        //  }

        Modules::run('mail/welcome_mails', $userData );
        Modules::run('mail/verification_mails', $userData );

        return $user_id;
    }

    private function setCompanyPage( $user_id ){
        $comapny = $this->input->post('company', TRUE);
        $business = [
            'user_id'   => $user_id,
            'parent_id' => 0,
            'post_type' => 'business',
            'menu_name' => '',
            'post_title'    => $comapny,
            'post_url'      => $this->slugifyCompanyName( $comapny ),
            'content'       => $comapny,
            'seo_title'     => '',
            'seo_keyword'   => '',
            'seo_description' => '',
            'thumb'     => '',
            'template'  => '',
            'status'    => 'Publish',
            'page_order' => 0,
            'created'   => date('Y-m-d H:i:s'),
            'modified'  => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('cms',$business);
    }

    private function slugifyCompanyName($text) {
        $filter1 = strtolower(strip_tags(trim($text)));
        $filter2 = html_entity_decode($filter1);
        $filter3 = iconv('utf-8', 'us-ascii//TRANSLIT', $filter2);
        $filter4 = preg_replace('~[^ a-z0-9_.]~', ' ', $filter3);
        $filter5 = preg_replace('~ ~', '-', $filter4);
        $return = preg_replace('~-+~', '-', $filter5);
        if (empty($return)) {
            return 'auto-' . time() . rand(0, 99);
        } else {
            if($this->autoFixDulicate($return) == 0){
                return $return;
            } else {
                return $return .'-'. rand(0,9) .'-'. rand(0, 99);
            }
        }
    }

    private function autoFixDulicate( $slug ){
        return $this->db->where('post_url', $slug )->count_all_results('cms');
    }

    public function _rules(){
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required');
        $this->form_validation->set_rules('company', 'company name', 'trim');
        $this->form_validation->set_rules('your_email', 'your email', 'trim|valid_email|required|is_unique[users.email]',
                [
                    'is_unique'     => 'This email already in used',
                    'valid_email'   => 'Please enter a valid email address'
                ]);

	// $this->form_validation->set_rules('role_id', 'role_id', 'required|less_than[7]|greater_than[3]');
        $this->form_validation->set_rules('choose_profile', 'Role', 'required');

        $this->form_validation->set_rules('password', 'password field', 'required|min_length[6]');
        if($this->input->get('device') == 'flick'){
            $this->form_validation->set_error_delimiters('', "\n");
        }else{
            $this->form_validation->set_error_delimiters('<p class="ajax_error">', '</p>');
        }

    }

    public function forget_password() {
        $this->load->view('frontend/new/forget_password');
    }

    public function forgot_pass(){

        $email      = $this->input->post('forgot_mail');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo ajaxRespond('Fail', 'Invalid email address!');
            exit;
        }

        $is_exist    = $this->db->get_where('users',['email' => $email, 'oauth_provider' => 'web']);

        if($is_exist->num_rows() == 0){
            echo ajaxRespond('Fail', 'Email address not found!');
            exit;
        }

        $hash_email =  password_encription($email);

        $array = [
            'Status'  => 'OK',
            '_token'  => $hash_email,
            'Msg'     => 'Reset password link sent to your email'
        ];

        echo json_encode($array);
        exit;
    }

    public function api_forgot_pass(){
        $email      = $this->input->post('forgot_mail');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            json_output_display(200, ['status' => 0, 'message' => 'invalid email']);
            exit;
        }
        $this->db->select('id,email,first_name,last_name');
        $user    = $this->db->where('email', $email)->get('users')->row();
        if(!$user){
            json_output_display( 200 ,['status' => 0, 'message' => 'Email address not found!']);
            exit;
        }
        $token =  rand(100000,999999);   // 6 Digit
        $this->db->set('pwd_token', $token)->where('email', $email)->update('users');

        $options = array(
            'id'        => $user->id,
            'email'     => $user->email,
            'fullname'  => "{$user->first_name} {$user->last_name}",
            'token'     => $token,
        );
        Modules::run('mail/api_send_pwd_mail', $options );

        $api_data   = [
            'status'  => 1,
            'message' => 'Reset password code sent to your mail',
        ];
        echo json_output( 200, $api_data);
    }

    public function api_reset_pass(){
        $email      = $this->input->post('email');
        $token      = $this->input->post('token');
        $new_pass   = trim($this->input->post('password'));
        $re_pass    = trim($this->input->post('confirm_password'));

        $user    = $this->db->where('email', $email)->where('pwd_token', $token)->count_all_results('users');
        if(!$user){
            echo json_output( 200, ['status' => 0, 'message' => 'Token not found!']);
            exit;
        }

        if($new_pass != $re_pass){
            echo json_output( 200, ['status' => 0, 'message' => 'Password Not Match']);
            exit;
        }

        $hash_pass  = password_encription($new_pass);

        $this->db->set('password', $hash_pass);
        $this->db->set('pwd_token', null);
        $this->db->where('email', $email);
        $this->db->where('pwd_token', $token);
        $this->db->update('users');

        echo json_output( 200 ,['status' => 1, 'message' => 'Successfully Updated']);

    }

    public function reset_password(){
        //$this->load->view('frontend/new/header');
        $this->load->view('frontend/new/reset_password');
        //$this->load->view('frontend/new/footer');
    }

    public function reset_password_action(){

        $reset_token = $this->input->post('verify_token');
        $email      = $this->input->post('email');

        $new_pass   = trim($this->input->post('new_password'));
        $re_pass    = trim($this->input->post('retype_password'));

        if(!password_verify($email, $reset_token)){
            echo ajaxRespond('Fail', 'Token Not Match');
            exit;
        }

        if($new_pass != $re_pass){
            echo ajaxRespond('Fail', 'Not Match');
            exit;
        }

        $hash_pass  = password_encription($new_pass);

        $this->db->set('password',$hash_pass);
        $this->db->where('email', $email);
        $this->db->update('users');

       //  ob_start();
        // Run Auto Login here
        echo ajaxRespond('OK', 'Successfully updated');
        $newdata = array(
                'username'      => $email,
                'password'      => $new_pass
        );
        $this->session->set_flashdata( 'login', $newdata);
        // redirect('auth/login');
        // ob_clean();



    }

    private function  login_history( $user_id  =  null, $role_id = 0 ) {
        $this->load->library('user_agent');
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        }  elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
             $agent = 'Unidentified User Agent';
        }



        $history = [
            'user_id'       => $user_id,
            'login_time'    => date('Y-m-d H:s:i'),
            'ip'            => getenv('REMOTE_ADDR'),
            'role_id'      => $role_id,
            'browser'       => $agent,
            'device'        => $this->agent->platform(),
        ];


        $this->db->insert('login_history', $history );
        return $this->db->insert_id();

    }

    private function logout_history(){
        $id = getLoginUserData('history');
        $this->db->set('logout_time', date('Y-m-d H:i:s') );
        $this->db->where('id', $id );
        $this->db->update('login_history' );
    }

    public function current_status_check(){
        $user_id = $this->input->post('user_id');
        if($user_id){
            $this->db->set('last_access', (time() + 600 ) );
            $this->db->where('id', $user_id);
            $this->db->update('users');
        }
    }

    public function check_email(){
        $email = $this->input->post('email');
        if($email){
            $user = $this->db->where('email', $email)->get('users')->row();
            if($user) {
                echo ajaxRespond('OK', 'Registration email already in use.');
                exit;
            }
        }

        echo ajaxRespond('Fail', 'Email not exists.');
    }



    public function facebook_login()
    {
        $userData = array();

        // Authenticate user with facebook
        if ($this->facebook->is_authenticated()) {
            // Get user info from facebook
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture.width(800).height(800)');

            // Preparing data for database insertion
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid'] = !empty($fbUser['id']) ? $fbUser['id'] : '';
            $userData['first_name'] = !empty($fbUser['first_name']) ? $fbUser['first_name'] : '';
            $userData['last_name'] = !empty($fbUser['last_name']) ? $fbUser['last_name'] : '';
            if (!empty($fbUser['email'])){
                $userData['email'] = $fbUser['email'];
            }

            $userData['user_profile_image'] = !empty($fbUser['picture']['data']['url']) ? $fbUser['picture']['data']['url'] : '';
           // $userData['facebook_link'] = !empty($fbUser['link']) ? $fbUser['link'] : '';

            // Insert or update user data to the database
            $user = $this->Auth_model->checkUser($userData);

            // Check user data insert or update status
            if (!empty($user)) {

                if ($user->status === 'Active') {


                    if (empty($user->is_deleted)) {
                        $cookie_data = json_encode([
                            'user_id' => $user->id,
                            'user_mail' => $user->email,
                            'role_id' => $user->role_id,
                            'name' => $user->first_name . ' ' . $user->last_name,
                            'photo' => $user->user_profile_image,
                            'oauth_uid' => $user->oauth_uid,
                            'oauth_provider' => $user->oauth_provider
                        ]);
                        $cookie = [
                            'name' => 'login_data',
                            'value' => base64_encode($cookie_data),
                            'expire' => (60 * 60 * 24 * 7),
                            'secure' => false
                        ];
                        $this->input->set_cookie($cookie);
                        $this->session->set_userdata($cookie);
                        $current_status = array(
                            'current_status' => 'Online',
                            'last_access' => (time() + 120),
                        );
                        $this->db->where('id', $user->id);
                        $this->db->update('users', $current_status);
                        $this->session->set_flashdata('success', 'You have successfully Login');
                        redirect(site_url());// $this->session->unset_flashdata('login');
                        // Save Session and refresh
                    } else {
                        $this->session->set_flashdata('danger', 'Your account is deleted.');
                        redirect(site_url());
                    }
                } else {
                    $this->session->set_flashdata('danger', 'Your account is inactive.');
                    redirect(site_url());
                }
            } else {
                $this->session->set_flashdata('danger', 'Something Went Wrong.');
                redirect(site_url());
            }
        }
        redirect('my-account');
    }

    function google_login()
    {

        $google_client = new Google_Client();

        $google_client->setClientId($this->config->item('google_client_id')); //Define your ClientID

        $google_client->setClientSecret($this->config->item('google_client_secret')); //Define your Client Secret Key

        $google_client->setRedirectUri($this->config->item('google_redirect_uri')); //Define your Redirect Uri

        $google_client->addScope('email');

        $google_client->addScope('profile');


        if (isset($_GET["code"])) {
            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
            if (!isset($token["error"])) {
                $google_client->setAccessToken($token['access_token']);

                $google_service = new Google_Service_Oauth2($google_client);

                $data = $google_service->userinfo->get();

                $user_data = array(
                    'oauth_provider' => 'google',
                    'oauth_uid' => $data['id'],
                    'first_name' => $data['given_name'],
                    'last_name' => $data['family_name'],
                    'email' => $data['email'],
                    'user_profile_image' => $data['picture']
                );
                // Insert or update user data to the database
                $user = $this->Auth_model->checkUser($user_data);

                // Check user data insert or update status
                if (!empty($user)) {

                    if ($user->status === 'Active') {
                        if (empty($user->is_deleted)) {

                        $cookie_data = json_encode([
                            'user_id' => $user->id,
                            'user_mail' => $user->email,
                            'role_id' => $user->role_id,
                            'name' => $user->first_name . ' ' . $user->last_name,
                            'photo' => $user->user_profile_image,
                            'oauth_uid' => $user->oauth_uid,
                            'oauth_provider' => $user->oauth_provider
                        ]);

                        $cookie = [
                            'name' => 'login_data',
                            'value' => base64_encode($cookie_data),
                            'expire' => (60 * 60 * 24 * 7),
                            'secure' => false
                        ];
                        $this->input->set_cookie($cookie);
                        $this->session->set_userdata($cookie);

                        $current_status = array(
                            'current_status' => 'Online',
                            'last_access' => (time() + 120),
                        );

                        $this->db->where('id', $user->id);
                        $this->db->update('users', $current_status);


                        $this->session->set_flashdata('success', 'You have successfully Login');
                        redirect(site_url());
                        // $this->session->unset_flashdata('login');
                        // Save Session and refresh
                        }
                        else {
                            $this->session->set_flashdata('danger', 'Your account is deleted.');
                            redirect(site_url());
                        }
                    }

                    else {
                        $this->session->set_flashdata('danger', 'Your account is inactive.');
                        redirect(site_url());
                    }
                }

                else {
                    $this->session->set_flashdata('danger', 'Something Went Wrong.');
                    redirect(site_url());
                }

            }
        }
        redirect('my-account');
    }

    function google_login_ontap()
    {
        $google_client = new Google_Client();
        $google_client->setClientId($this->config->item('google_client_id')); //Define your ClientID
        $google_client->addScope('email');
        $google_client->addScope('profile');


        $code = $this->input->post('credential');
        if (isset($code)) {
            $data = $google_client->verifyIdToken($code);

                $user_data = array(
                    'oauth_provider' => 'google',
                    'oauth_uid' => $data['sub'],
                    'first_name' => $data['given_name'],
                    'last_name' => $data['family_name'],
                    'email' => $data['email'],
                    'user_profile_image' => $data['picture']
                );
                // Insert or update user data to the database
                $user = $this->Auth_model->checkUser($user_data);

                // Check user data insert or update status
                if (!empty($user)) {

                    if ($user->status === 'Active') {

                        if (empty($user->is_deleted)) {

                        $cookie_data = json_encode([
                            'user_id' => $user->id,
                            'user_mail' => $user->email,
                            'role_id' => $user->role_id,
                            'name' => $user->first_name . ' ' . $user->last_name,
                            'photo' => $user->user_profile_image,
                            'oauth_uid' => $user->oauth_uid,
                            'oauth_provider' => $user->oauth_provider
                        ]);

                        $cookie = [
                            'name' => 'login_data',
                            'value' => base64_encode($cookie_data),
                            'expire' => (60 * 60 * 24 * 7),
                            'secure' => false
                        ];
                        $this->input->set_cookie($cookie);
                        $this->session->set_userdata($cookie);

                        $current_status = array(
                            'current_status' => 'Online',
                            'last_access' => (time() + 120),
                        );

                        $this->db->where('id', $user->id);
                        $this->db->update('users', $current_status);


                        $this->session->set_flashdata('success', 'You have successfully Login');
                        redirect(site_url());
                        // $this->session->unset_flashdata('login');
                        // Save Session and refresh
                        } else {
                            $this->session->set_flashdata('danger', 'Your account is deleted.');
                            redirect(site_url());
                        }
                    } else {
                        $this->session->set_flashdata('danger', 'Your account is inactive.');
                        redirect(site_url());
                    }
                } else {
                    $this->session->set_flashdata('danger', 'Something Went Wrong.');
                    redirect(site_url());
                }


        }
        redirect('my-account');
    }


}
