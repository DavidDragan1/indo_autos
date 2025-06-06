<?php

/**
 * Description of Admin_controller
 *
 * @author Kanny
 */
class Admin_controller extends MX_Controller {

    protected $user_id;
    protected $role_id;

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Europe/London");


        $this->load->library('user_agent');
        $this->load->helper('html');
        $this->load->helper('download');
        $this->load->helper('email');
        $this->load->helper('security');
        $this->load->helper('cookie');
        $this->load->helper('acl_helper');
        $this->load->helper('photoupload_helper');
        $this->load->model('acls/Acls_model', 'acls');

        $token = $this->input->server('HTTP_TOKEN');

        /* @var $user_id type */
        if($token){
            $user = $this->db->select('user_tokens.user_id, users.role_id')
                ->join('users', 'users.id = user_tokens.user_id', 'LEFT')
                ->where('user_tokens.token' , $token)->get('user_tokens')->row();

            $this->user_id = ($user) ? $user->user_id : 0;
            $this->role_id = ($user) ? $user->role_id : 0;
            is_token_match($user->user_id, $token);
        } else{
            $this->user_id = getLoginUserData('user_id');
            $this->role_id = getLoginUserData('role_id');
        }

        if (!in_array($this->role_id, [1,2])){
            $maintenance = getSettingItem('Maintenance');
            if(!empty($maintenance) && $this->uri->segment(1) != 'maintenance' && $this->uri->segment(1) != 'adb-login') {
                $maintenance_value = maintenanceValue($maintenance);

                if($maintenance_value[1]) {
                    if(!empty($maintenance_value[2]) && $maintenance_value[2] > date('Y-m-d H:i:s')) {
                        redirect('maintenance', 'refresh');
                    }
                    else {
                        redirect('maintenance', 'refresh');
                    }
                }
                else {
                    redirect('/', 'refresh');
                }
            }
        }

        //dd(checkPermission('my_account/access_backoffice', $this->role_id ));
        $checkParent = $this->db->query("SELECT
                                            users.role_id
                                        FROM
                                            roles
                                            JOIN users ON roles.user_id = users.id 
                                        WHERE
                                            roles.id = '$this->role_id'")
            ->row();

        $role_id = isset($checkParent->role_id) && !empty($checkParent->role_id) ? $checkParent->role_id : $this->role_id;
        //ddd($parentRole);
        if( checkPermission('my_account/access_backoffice', $role_id ) == false ){

            redirect( base_url('my-account'), 'refresh' );
        };

        $user_id = getLoginUserData('user_id');
        //$role_id    = getLoginUserData('role_id');
        $access     = checkMenuPermission('profile/business', $role_id);
        $complete = 1;

        if( $access ){
            $page = $this->db->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row();
            $complete = 0;
            if ($page) {
                $complete = 1;
            }
        }

        if ($role_id == 14){
            $exist = $this->db->get_where('drivers', ['user_id' => $user_id])->row();
            if (empty($exist) && current_url() != site_url('admin/profile')  && current_url() != site_url('admin/profile/update')){
                $this->session->set_flashdata([ 'status' => 'error','message'=>'Please Update you Profile']);
                redirect(site_url('admin/profile'));
            }
        }

        if ($role_id == 15){
            $exist = $this->db->get_where('shipping', ['user_id' => $user_id])->row();
            if (empty($exist) && current_url() != site_url('admin/profile')&& current_url() != site_url('admin/profile/business_update') && current_url() != site_url('admin/profile/update')){
                $this->session->set_flashdata([ 'status' => 'error','message'=>'Please Update you Profile']);
                redirect(site_url('admin/profile'));
            } else {
                $complete = 1;
            }
        }

        if ($role_id == 16){
            $exist = $this->db->get_where('clearing', ['user_id' => $user_id])->row();
            if (empty($exist) && current_url() != site_url('admin/profile') && current_url() != site_url('admin/profile/business_update') && current_url() != site_url('admin/profile/update')){
                $this->session->set_flashdata([ 'status' => 'error','message'=>'Please Update you Profile']);
                redirect(site_url('admin/profile'));
            }
        }

        if ($role_id == 17){
            $exist = $this->db->get_where('verifiers', ['user_id' => $user_id])->row();
            if (empty($exist) && current_url() != site_url('admin/profile') && current_url() != site_url('admin/profile/update')){
                $this->session->set_flashdata([ 'status' => 'error','message'=>'Please Update you Profile']);
                redirect(site_url('admin/profile'));
            }
        }

        if ($role_id == 8){
            $exist = $this->db->get_where('mechanic', ['user_id' => $user_id])->row();
            if (empty($exist) && current_url() != site_url('admin/profile')  && current_url() != site_url('admin/profile/update')){
                $this->session->set_flashdata([ 'status' => 'error','message'=>'Please Update you Profile']);
                redirect(site_url('admin/profile'));
            }
        }

        if ($role_id != 1 && $role_id != 2) {
            if(current_url() != site_url('admin/profile') && current_url() != site_url('admin/profile/business_update') && $complete == 0 && current_url() != site_url('admin/profile/update')){
                $this->session->set_flashdata([ 'status' => 'error','message'=>'Please Update Your Business Profile']);
                redirect(site_url('admin/profile'));
            };
        }

        if($this->user_id <= 0){

            redirect( site_url('admin/login'));
        }
        //die('ggg');
        $this->set_admin_prefix( $this->uri->uri_string() );
    }



    private function check_access( $string = 'dashboard'){

        // $backend_uri = 'admin'; // prefix no need to touch
        $controller = empty($this->uri->segment(2)) ? $string : $this->uri->segment(2);
        $method     = empty($this->uri->segment(3)) ? '' : '/'.$this->uri->segment(3);
        $access_key = $controller . $method;
        $role_id    = getLoginUserData('role_id');
        return $this->acls->checkPermission($access_key,$role_id);
    }


    private function set_admin_prefix( $string = '/'){
        //die($string);
        if($this->uri->segment(1) != 'admin'){
            redirect( site_url('admin') .'/'. $string );
        };
    }




    public function viewAdminContent($view, $data = []){
        if( $this->input->is_ajax_request() ){
            $this->load->view($view, $data);
        } else {
            $this->load->view('backend/layout/header');
            $this->load->view('backend/layout/sidebar');
            //$this->load->view($view, $data);
            //dd( $this->check_access() );
            if($this->check_access()){
                $this->load->view($view, $data);
            } else {
                $this->load->view('backend/restrict');
            }
            $this->load->view('backend/layout/footer');
        }
    }


    public function uploadPhoto( $FILE = array() , $path = '', $rand = 000000 ){
        // Just upload raw photo
        // $_FILES['image_field']

        $handle = new Verot\Upload\Upload( $FILE );
        if ($handle->uploaded) {
            $handle->file_new_name_body   = $rand;
            $handle->image_resize         = true;
            $handle->image_x              = 250;
            $handle->image_ratio_y        = true;
            $handle->file_new_name_ext = 'jpg';
            $handle->file_force_extension = true;

            $handle->process( 'uploads/' . $path );
            $handle->processed;
            $pic1 = $handle->file_dst_name;

        }
        $handle2 = new  Verot\Upload\Upload( $FILE );
        if ($handle2->uploaded) {
            $handle2->file_new_name_body   = $rand;
            $handle2->image_resize         = true;
            $handle2->image_x              = 800;
            $handle2->image_ratio_y        = true;
            $handle2->file_new_name_ext = 'jpg';
            $handle2->file_force_extension = true;
            $handle2->process( 'uploads/' . $path );
            $handle2->processed;
        }

        return $pic1;
    }



    public function sendEmailAjax($to, $subject, $body, $cc = false, $bcc = false, $from = '', $company_name = ''){
        $mail = new PHPMailer;


        $mail->setFrom($from, $company_name);
        $mail->addAddress($to);                                 // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo($from, $company_name);
        $mail->addCC($cc);
        $mail->addBCC($bcc);
        $mail->isHTML(true);                                    // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body = $body;

        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }

    public function sendEmailWithAttachment($to, $subject, $body, $cc = null, $bcc = null, $from = '', $company_name = '', $attachment=null){
        $mail = new PHPMailer;
        $mail->setFrom($from, $company_name);
        $mail->addAddress($to);
        $mail->addReplyTo($from, $company_name);
        $mail->addCC($cc);
        $mail->addBCC($bcc);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        if($attachment!=''){
            $mail->addAttachment($attachment);
        }
        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }

    public function getEmailBody($slug = ''){
        $data = $this->db->get_where('email_templates', ['slug' => $slug])->row();
        return $data;
    }

    public function filterEmailBody($body = '', $arrays = array()){
        if (count($arrays)) {
            foreach ($arrays as $row => $value) {
                $body = str_replace('%' . $row . '%', $value, $body);
            }
        }
        return $body;
    }

    public function sendEmailToSellerAjax($to, $Slug, $array = [], $cc = false, $bcc = false, $from = '', $company_name = ''){
        $data       = $this->getEmailBody($Slug);
        $Body       = @$data->template;
        $Subject    = @$data->title;
        $from       = $array['Sender'];
        $Body       = self::filterEmailBody($Body, $array);
        if($this->sendEmailAjax($to, $Subject, $Body, $cc, $bcc, $from, $company_name)){
            return true;
        }
        return false;
    }

    public function sendOfferAjax($to, $Slug, $array = [], $cc = false, $bcc = false, $from = '', $company_name = ''){
        $data       = $this->getEmailBody($Slug);
        $Body       = @$data->template;
        $Subject    = $array['Subject'];
        $from       = $array['SenderEmail'];
        $Body       = self::filterEmailBody($Body, $array);
        if($this->sendEmailAjax($to, $Subject, $Body, $cc, $bcc, $from, $company_name)){
            return true;
        }
        return false;
    }

    public function sendOfferAckknoledgeAjax($to, $Slug, $array = [], $cc = false, $bcc = false, $from = '', $company_name = ''){
        $data       = $this->getEmailBody($Slug);
        $Body       = @$data->template;
        $Subject    = $array['Subject'];
        $Body       = self::filterEmailBody($Body, $array);
        if($this->sendEmailAjax($to, $Subject, $Body, $cc, $bcc, $from, $company_name)){
            return true;
        }
        return false;
    }

    public function sendEmailReply($to, $Slug, $array = [], $cc = false, $bcc = false, $from = '', $company_name = ''){
        $data       = $this->getEmailBody($Slug);
        $Body       = @$data->template;
        //dd($Body);
        $Subject    = $array['Subject'];
        $Body       = self::filterEmailBody($Body, $array);
        $attachment = $array['Attachment'];

        if($this->sendEmailWithAttachment($to, $Subject, $Body, $cc, $bcc, $from, $company_name, $attachment)){
            return true;
        }
        return false;

    }

    public function sendEmailFromTeamplateWithFilterAjax($to, $Slug, $array = [], $cc = false, $bcc = false, $from = '', $company_name = ''){
        $data = $this->getEmailBody($Slug);
        $Body     = @$data->template;
        $Subject  = @$data->title;
        $Body     = self::filterEmailBody($Body, $array);
        if($this->sendEmailAjax($to, $Subject, $Body, $cc, $bcc, $from, $company_name)){
            return true;
        }
        return false;
    }

    public function viewNewAdminContent($view, $data = []){
        $user_id = getLoginUserData('user_id');
        $email_verification_status = $this->db->where('id', $user_id)->get('users')->row();

        if($email_verification_status->email_verification_status === 'pending'){
            $this->load->view('backend/new/header');
            $this->load->view('backend/new/sidebar');
            $this->load->view('frontend/template/email_verification');
            $this->load->view('backend/new/footer');
        } else {
            if( $this->input->is_ajax_request() ){
                $this->load->view($view, $data);
            } else {
                $this->load->view('backend/new/header');
                $this->load->view('backend/new/sidebar');

                if($view === 'mails/trader_view' || $this->check_access()){
                    $this->load->view($view, $data);
                } else {
                    $this->load->view('backend/restrict');
                }

                $this->load->view('backend/new/footer');
            }
        }
    }


    public function viewAdminContentPrivate($view, $data = []){
        $user_id = getLoginUserData('user_id');
        $user = $this->db->where('id', $user_id)->get('users')->row();

        if($user->email_verification_status === 'pending'){
            $this->session->set_flashdata([ 'status' => 'error','message'=>'Please verify your email']);
            $this->load->view('backend/trade/header');
//            $this->load->view('backend/new/sidebar');
            $this->load->view('frontend/template/email_verification');
            $this->load->view('backend/trade/footer');
        } else {
            if( $this->input->is_ajax_request() ){
                $this->load->view($view, $data);
            } else {
                $this->load->view('backend/trade/header');
                //$this->load->view('backend/trade/sidebar');

                if($view === 'backend/trade/template/inbox_detail' || $this->check_access()){
                    $this->load->view($view, $data);
                } else {
                    $this->load->view('backend/restrict');
                }
                $this->load->view('backend/trade/footer');
            }
        }
    }


}
