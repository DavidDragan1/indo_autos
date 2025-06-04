<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 8th Oct 2016
 */

class My_account extends Frontend_controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('My_account_model');
        $this->load->helper('acl_helper');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->helper('myaccount');
        $this->load->library('Facebook');

        $user_id = getLoginUserData('user_id');
        $role_id = getLoginUserData('role_id');
        $checkParent = $this->db->query("SELECT
                                            users.role_id
                                        FROM
                                            roles
                                            JOIN users ON roles.user_id = users.id 
                                        WHERE
                                            roles.id = '$role_id'")
            ->row();

        $parentRole = isset($checkParent->role_id) && !empty($checkParent->role_id) ? $checkParent->role_id : $role_id;
        $isAccessBack = checkPermission('my_account/access_backoffice', $parentRole);

        if ($user_id && $isAccessBack) {
            redirect(Backend_URL, 'refresh');
        }


    }

    public function index()
    {
        $user_id = getLoginUserData('user_id');
        $role_id = getLoginUserData('role_id');
//        pp($role_id);
//        pp($user_id);
        $data = [];
        $active_tab = $this->input->get('tab');
        $view_page = $this->getViewPage($active_tab);
//        pp($role_id);
        if ($user_id && $user_id >= 1) {
            $this->viewMemberContent($view_page, $data);
        } else {

            if ($this->input->get('mode') == 'signup'){
                $temp = getCmsPage('sign-up');
            } else {
                $temp = getCmsPage('sign-in');
            }
           // pp($this->uri->segment(1));


            $google_client = new Google_Client();

            $google_client->setClientId($this->config->item('google_client_id')); //Define your ClientID

            $google_client->setClientSecret($this->config->item('google_client_secret')); //Define your Client Secret Key

            $google_client->setRedirectUri($this->config->item('google_redirect_uri')); //Define your Redirect Uri

            $google_client->addScope('email');

            $google_client->addScope('profile');


            $data['facebook_auth_url'] =  $this->facebook->login_url();
            $data['google_auth_url'] =  $google_client->createAuthUrl();

            if (!empty($temp)){
                $data = array_merge($data, [
                    'cms' => $temp['cms'],
                    'meta_title' => $temp['meta_title'],
                    'meta_description' => $temp['meta_description'],
                    'meta_keywords' => $temp['meta_keywords'],
                ]);
            }

            $this->load->view('frontend/new/login', $data);
        }
    }

    private function add_menu_item($link, $title, $access, $icon = '', $linkTitle = null)
    {
        $role_id = getLoginUserData('role_id');
        if (checkMenuPermission($access, $role_id)) {
            $html = '';
            $html .= '<a title="' . $linkTitle . '" class="list-group-item" href="my_account?tab=' . htmlspecialchars($link) . '">';
            $html .= '<i class="fa ' . $icon . '"></i> ';
            $html .= $title . '</a>';
            return $html;
        }
    }

    private function add_menu_item2($link, $title, $access, $icon = '', $linkTitle = null)
    {
        $html = '';
        $html .= '<a target="_blank" title="' . $linkTitle . '" class="list-group-item" href="' . site_url(htmlspecialchars($link)) . '">';
        $html .= '<i class="fa ' . $icon . '"></i> ';
        $html .= $title . '</a>';
        return $html;

    }

    private function getViewPage($view = null)
    {
        $filename = dirname(dirname(__FILE__)) . '/views/' . $view . '.php';

        return ($view && file_exists($filename)) ? 'my_account/' . $view : 'my_account/index';
    }

    public function change_password()
    {

        //dd($_POST);
        ajaxAuthorized();

        $old_pass = $this->input->post('old_pass');
        $new_pass = $this->input->post('new_pass');
        $con_pass = $this->input->post('con_pass');


        if (!$old_pass or !$new_pass or !$con_pass) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Required all fields</p>');
            exit;
        }

        if ($new_pass != $con_pass) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Confirm Password Not Match</p>');
            exit;
        }


        $user_id = getLoginUserData('user_id');
        $user = $this->db->select('password')
            ->get_where('users', ['id' => $user_id])
            ->row();

        $db_pass = $user->password;
        $verify = password_verify($old_pass, $db_pass);

        if ($verify == true) {

            $hass_pass = password_hash($new_pass, PASSWORD_BCRYPT, ["cost" => 12]);
            $this->db->update('users', ['password' => $hass_pass], ['id' => $user_id]);

            echo ajaxRespond('OK', '<p class="ajax_success">Password Reset Successfully</p>');

        } else {
            echo ajaxRespond('Fail', '<p class="ajax_error">Old Password not match, please try again.</p>');
        }

    }

    public function _rules_for_password()
    {
        $this->form_validation->set_rules('old_pass', 'Password is required', 'trim|required');
        $this->form_validation->set_rules('new_pass', 'New Password is required', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('con_pass', 'Password Confirmation is required', 'trim|required|min_length[6]');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    // update user profile
    public function update_user_profile()
    {
        ajaxAuthorized();

        $user_id = getLoginUserData('user_id');

        $data = array(
            'first_name' => $this->input->post('first_name', TRUE),
            'last_name' => $this->input->post('last_name', TRUE),
            'contact' => $this->input->post('contact', TRUE),
            'add_line1' => $this->input->post('add_line1', TRUE),
            'add_line2' => $this->input->post('add_line2', TRUE),
            'city' => $this->input->post('city', TRUE),
            'state' => $this->input->post('state', TRUE),
            'postcode' => $this->input->post('postcode', TRUE),
            'country_id' => (int)$this->input->post('country_id', TRUE),
        );

        $this->db->where('id', $user_id);
        $this->db->update('users', $data);

        echo ajaxRespond('OK', '<p class="ajax_success">Profile Upadte Successfully</p>');

    }


    // serving data to profile page.....
    public function profile_info_view($user_id = 0)
    {
        return $this->db->get_where('users', ['id' => $user_id])->row();
    }


    public function getReport($user_id = 0)
    {
        $reports = $this->db->get_where('mails', ['mail_type' => 'ReportSpam', 'reciever_id' => $user_id])->result();
        return $reports;
    }


    public function getMyMails($folder = 'sent')
    {

        $user_id = getLoginUserData('user_id');

        $this->db->from('mails');

        if ($folder === 'sent') {
            $this->db->where('sender_id', $user_id);
        } else {
            $this->db->where('reciever_id', $user_id);
        }

        return $mails = $this->db->get()->result();

        //dd( $this->db->last_query() );

    }

    public function read_mail($mail_id = 0)
    {
        ajaxAuthorized();

        $data['mail'] = $this->db->get_where('mails', ['id' => $mail_id])->row();
        $this->db->set('status', 'Read')->where('id', $mail_id)->update('mails');
        $this->load->view('read_mail', $data);
    }


    public function menu($active = '')
    {

        $html = '<div class="my_sidebar">';

        $html .= '<div class="list-group" role="group">';

        $html .= $this->add_menu_item('db', 'Dashboard', 'my_account', 'fa-dashboard');
        $html .= $this->add_menu_item('mails', 'My Messages - Inbox <span class="badge">' . unread_mails() . '</span>', 'my_account/mails', 'fa-comments');
        $html .= $this->add_menu_item('mails&type=sent', 'My Messages - Sent', 'my_account/report_spam', 'fa-comments');
        $html .= $this->add_menu_item('notifications', 'My Notification', 'my_account', 'fa-bell', 'Set your notification and get email alert when your preferedspare parts/ Cars is available');

        $html .= $this->add_menu_item2('diagnostic', 'Online Vehicle Diagnostic', 'my_account', 'fa-stethoscope');
        $html .= $this->add_menu_item2('faq', 'FAQ/Help', 'my_account', 'fa-question');
        $html .= $this->add_menu_item2('driver-hire', 'Driver Hire', 'my_account', 'fa-user');
        $html .= $this->add_menu_item2('motor-association', 'Motor Association', 'my_account', 'fa-car');

        $html .= $this->add_menu_item('profile', 'My Profile', 'my_account', 'fa-bars');
        $html .= $this->add_menu_item('pwd', 'Change Password', 'my_account', 'fa-random');

        $html .= '<a class="list-group-item" href="auth/logout">';
        $html .= '<i class="fa fa-sign-out"></i>  Logout </a>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }


    public function getUserNotifications($user_id = 0)
    {
        return $this->db->get_where('user_notifications', ['user_id' => $user_id])->result();
    }

    public function delete_notification()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('user_notifications');
        echo ajaxRespond('OK', '<p class="ajax_success">Removed Successfully</p>');
    }


    public function notifications()
    {
        $user_id = getLoginUserData('user_id');

        $type_id = $this->input->post('type_id');
        $brand_id = $this->input->post('brand_id');
        $model_id = $this->input->post('model_id');
        $location_id = $this->input->post('location_id');
        $year = $this->input->post('year');
        $parts_description = $this->input->post('parts_description');


        $check = $this->db->where('user_id', getLoginUserData('user_id'))->count_all_results('user_notifications');
        if ($check >= 2) {
            echo ajaxRespond('OK', '<p class="ajax_error">Your alert limit exceeded. please remove one first</p>');
            exit;
        }


        $data = array(
            'user_id' => $user_id,
            'type_id' => $type_id,
            'brand_id' => $brand_id,
            'model_id' => $model_id,
            'location_id' => $location_id,
            'year' => $year,
            'parts_description' => $parts_description
        );

        $this->db->insert('user_notifications', $data);

        echo ajaxRespond('OK', '<p class="ajax_success">Successfully Added</p>');


    }

    public function newSidebarMenus() {
        $html = "";

        $active_url = $this->uri->segment( 1 );

        if($active_url == "diagnostic") {
            $active = "active";
        } else {
            $active = "";
        }

        $html = '<li><a class="'.$active.'" href="'.site_url('diagnostic').'"><span class="icons"><img class="normal" src="assets/theme/new/images/backend/sidebar/faq.svg" alt="image">
                 <img class="hover" src="assets/theme/new/images/backend/sidebar/faq-h.svg" alt="image"></span><span class="name">Online Vehicle Diagnostic</span></a></li>';

        echo $html;
    }
}
