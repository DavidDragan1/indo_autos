<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-11-02
 */
use Illuminate\Database\Capsule\Manager as DB;
class Mails extends Admin_controller{
	 
	
    function __construct(){
        parent::__construct();
        $this->load->model('Mails_model');
        $this->load->helper('mails');
        $this->load->library('form_validation');
        define('KB', 1024);
        define('MB', 1048576);
        define('GB', 1073741824);
        define('TB', 1099511627776);
    }

    // Fetch All email

    public function index(){
        $user_id = getLoginUserData('user_id');

        $manage_all_mails = checkPermission('mails/manage_all', $this->role_id);
        $q = urldecode($this->input->get('q', TRUE)?$this->input->get('q', TRUE):'');
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'mails?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'mails?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'mails';
            $config['first_url'] = Backend_URL . 'mails';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;

        if ($manage_all_mails == true) {
            $config['total_rows'] = $this->Mails_model->get_mails_total($user_id,$manage_all_mails );
            $mails = $this->Mails_model->get_trader_mails($this->user_id,$manage_all_mails,$start,$config['per_page']);
        } else {
            $mails = $this->Mails_model->get_trader_mails($this->user_id,$manage_all_mails,$start,$config['per_page']);
            $config['total_rows'] = $this->Mails_model->get_mails_total($user_id,$manage_all_mails);
            $config['query_string_segment'] = 'start';

            $config['num_links'] = 1;

            $config['full_tag_open'] = '<ul class="pagination-wrap">';
            $config['full_tag_close'] = '</ul>';

            $config['first_link'] = false;
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';

            $config['last_link'] = false;
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';

            $config['next_link'] = '<i class="fa fa-angle-right"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li><span class="active">';
            $config['cur_tag_close'] = '</span></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
        }
        $this->load->library('pagination');
        $this->pagination->initialize($config);
        $data = array(
            'mails' => $mails,
            'access' => $manage_all_mails,
            'type'  => 'Inbox',
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        
        if($this->role_id == 1 or $this->role_id == 2) {
            $this->viewAdminContent('mails/index', $data);
        } elseif ($this->role_id == 14){
            viewAdminDriverNew('backend/trade/template/inbox', $data);
        } elseif ($this->role_id == 8){
            viewAdminMechanicNew('backend/trade/template/inbox', $data);
        } else {
            $this->viewAdminContentPrivate('backend/trade/template/inbox', $data);
        }
    }

    public function delete($id){
        $mail = $this->Mails_model->get_by_id($id);
        $user_id = getLoginUserData('user_id');
        $data = [];

        if ($user_id == $mail->sender_id) {
            $data['sender_delete'] = 1;
        } else if ($user_id == $mail->reciever_id) {
            $data['receiver_delete'] = 1;
        }

        if($this->Mails_model->update($id, $data)){
            $this->session->set_flashdata(['status'=> 'success','message'=>'Record deleted successfully']);

        }else{
            $this->session->set_flashdata(['status'=> 'error','message'=>'Record Not Found']);
        }
        redirect(site_url( Backend_URL. 'mails'));
    }

    public function api_index(){  
        $user_id =0;
        $method = $_SERVER['REQUEST_METHOD'];        
        $page   = $this->input->get('page');
        $token  = $this->input->server('HTTP_TOKEN');
        if($token){
            $user = $this->db->select('user_tokens.user_id, users.role_id')
                   ->join('users', 'user_tokens.user_id = users.id', 'LEFT')
                   ->where('user_tokens.token' , $token)
                   ->get('user_tokens')->row();
            if(empty($user)){
                json_output_display(200, ['status' => 0, 'message' => 'No record found']);
                die;
            }
            $user_id = $user->user_id;
        }               
       
        
        is_token_match($user_id, $token);

        $start = ($this->input->get('start')) ? $this->input->get('start') : 0 ;
        $limit = ($this->input->get('limit')) ? $this->input->get('limit') : 20;
        
        
        $manage_all_mails = checkPermission('mails/manage_all', $user->role_id); 
         
        $total = $this->Mails_model->get_mails_total($user_id,$manage_all_mails); 
        $mails = $this->Mails_model->get_mails_api($user_id,$manage_all_mails, $start ,$limit); 
        
        
        
        $new_mails = [];
        if($mails){
            
            foreach($mails as $mail){
                $new_mails [] = [
                    'id'        => $mail->id,
                    'parent_id' => $mail->id,
                    'mail_type' => $mail->mail_type,
                    'sender_id' => $mail->sender_id,
                    'reciever_id' => $mail->reciever_id,
                    'mail_from' => $mail->mail_from,
                    'mail_to'   => $mail->mail_to,
                    'subject'   => $mail->subject,
                    'body'      => strip_tags($mail->body),
                    'status'    => $mail->status,
                    'important' => $mail->important,
                    'log'       => $mail->log,
                    'created'   => $mail->created,
                    'folder_id' => $mail->folder_id,
                ];
         
            }
        }
     
        $next = ($mails) ? ($start + $limit ) : 0;
        $data = array(
            'status' => 1,
            'start' => $start,
            'next' => $next,
            'next_page_url'  => next_page_url($page, $limit, $total),
            'result' => [
                'mails' => $new_mails,
                'access' => $manage_all_mails 
            ]            
        );      
       if($method != 'GET'){
           json_output_display(400,array('status' => 400,'message' => 'Bad request.'));
       } else {
           json_output(200 , $data) ;     
       }
            
    }
    

    

      public function read($id){
        $row = $this->Mails_model->get_by_id($id);
        
        $this->Mails_model->mark_as_read($row->id);
        
        if($row->parent_id!=0){
            $row = $this->Mails_model->get_by_id($row->parent_id);
        }

        if ($row) {
            $data = array(
		'id'            => $row->id,
                'mail_id'       => $row->id,
		'parent_id'     => $row->parent_id,
		'sender_id'     => $row->sender_id,
		'mail_from'     => $row->mail_from,
		'mail_to'       => $row->mail_to,
		'reciever_id'   => $row->reciever_id,
		'subject'       => $row->subject,
		'body'          => $row->body,
		'status'        => $row->status,
		'important'     => $row->important,
		'log'           => $row->log,
		'created'       => globalDateTimeFormat($row->created),
		'folder_id'     => $row->folder_id,
		'child_mails'   => $this->Mails_model->get_all_child_mails($row->id),
		'attachments'   => get_all_attachments($row->id)
	    );
            if ($this->role_id == 1 or $this->role_id == 2) {
                $this->viewAdminContent('mails/view', $data);
            } else {
                $this->viewNewAdminContent('mails/trader_view', $data);
            }

        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'mails'));
        }
    }

    public function trader_read($id, $type = ''){
        $row = $this->Mails_model->get_by_id($id);

        $this->Mails_model->mark_as_read_parent_with_child($row->id,'Read',$type);


        if ($row) {
            $data = array(
                'id'            => $row->id,
                'type'            => $type,
                'mail_id'       => $row->id,
                'parent_id'     => $row->parent_id,
                'sender_id'     => $row->sender_id,
                'mail_from'     => $row->mail_from,
                'mail_to'       => $row->mail_to,
                'reciever_id'   => $row->reciever_id,
                'subject'       => $row->subject,
                'body'          => $row->body,
                'status'        => $row->status,
                'important'     => $row->important,
                'log'           => $row->log,
                'created'       => $row->created,
                'folder_id'     => $row->folder_id,
                'child_mails'   => $this->Mails_model->get_all_child_mails($row->id),
                'attachments'   => get_all_attachments($row->id)
            );
            if ($this->role_id == 1 or $this->role_id == 2) {
                $this->viewAdminContent('mails/view', $data);
            } elseif ($this->role_id == 14) {
                viewAdminDriverNew('backend/trade/template/inbox_detail', $data);
            }elseif ($this->role_id == 8){
                viewAdminMechanicNew('backend/trade/template/inbox_detail', $data);
            } else {
                $this->viewAdminContentPrivate('backend/trade/template/inbox_detail', $data);
            }

        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'mails'));
        }
    }
    
    public function api_read($id){
        $method = $_SERVER['REQUEST_METHOD'];
         $user_id            = getLoginUserData('user_id');
        $token = $this->input->server('HTTP_TOKEN');
        is_token_match($user_id, $token);
        $row = $this->Mails_model->get_by_id($id);
        
        $this->Mails_model->mark_as_read($row->id);
        
        if($row->parent_id!=0){
            $row = $this->Mails_model->get_by_id($row->parent_id);
        }

        if ($row) {
            $data = [
                'status' => 1,
                'result' => [
                    'id'            => $row->id,
                    'mail_id'       => $row->id,
                    'parent_id'     => $row->parent_id,
                    'sender_id'     => $row->sender_id,
                    'mail_from'     => $row->mail_from,
                    'mail_to'       => $row->mail_to,
                    'reciever_id'   => $row->reciever_id,
                    'subject'       => strip_tags($row->subject),
                    'body'          => strip_tags($row->body),
                    'status'        => $row->status,
                    'important'     => $row->important,
                    'log'           => $row->log,
                    'created'       => globalDateTimeFormat($row->created),
                    'folder_id'     => $row->folder_id,
                    'child_mails'   => $this->Mails_model->get_all_child_mails($row->id),
                    'attachments'   => get_all_attachments($row->id)
                ]		
	    ];       
            
           json_output(200 , $data) ;  
        } else {
             json_output_display(400,array('status' => 400,'message' => 'Bad request.'));
        }
    }

    
    public function create(){

        $mail_type     = $this->input->post('mail_type',TRUE)?$this->input->post('mail_type',TRUE):'new';
        $sender_id     = getLoginUserData( 'user_id' );
        $reciever_id     = $this->input->post('reciever_id',TRUE)?$this->input->post('reciever_id',TRUE):0;
        $parent_id     = $this->input->post('parent_id',TRUE)?$this->input->post('parent_id',TRUE):0;
        $subject       = $this->input->post('subject',TRUE)?$this->input->post('subject',TRUE):set_value('subject');
        $message       = $this->input->post('message',TRUE)?$this->input->post('message',TRUE):set_value('body');

        //dd($parent_id);
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'mails/create_action'),
            'id' => set_value('id'),
            'parent_id' => $parent_id,
            'sender_id' => $sender_id,
            'reciever_id' => $reciever_id,
            'subject' => $subject,
            'body' => $message,
            'status' => set_value('status'),
            'important' => set_value('important','Unimportant'),
            'log' => set_value('log'),
            'created' => set_value('created'),
            'folder_id' => set_value('folder_id'),
            'mail_type' => $mail_type,
	);
        $this->viewAdminContent('mails/form', $data);
    }

    public function create_action()
    {

        $this->_rules();

        /*echo form_error('message');
        if($this->form_validation->run() == FALSE) {
            echo 'False';
            var_dump( form_error('subject') );
            var_dump( form_error('message') );
            var_dump( form_error('_wysihtml5_mode') );
        } else {
            echo 'True';
            var_dump( form_error('message') );
        }
        dd($_POST);
        exit;*/
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {

            $parent_id = $this->input->post('parent_id', TRUE) ? $this->input->post('parent_id', TRUE) : 0;
            $reciever_email = $this->input->post('reciever_email', TRUE) ? $this->input->post('reciever_email', TRUE) : '';
            $reciever_id = getUserIdByEmail($reciever_email);
            if ($reciever_id != 0) {
                $subject = $this->input->post('subject', TRUE);
                $message = $this->input->post('message', TRUE);
                //dd($reciever_id);
                if (!empty($_FILES['attachment']['name'])) {
                    $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
                    if ($_FILES['attachment']['size'] < 5 * MB) {
                        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png' || $ext == 'bmp') {
                            $attachment_file = $this->image_upload($_FILES['attachment']);
                            $attachment_name = $_FILES['attachment']['name'];
                        } elseif ($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'txt' || $ext == 'zip' || $ext == 'rar') {
                            $attachment_file = $this->file_upload($_FILES['attachment']);
                            $attachment_name = $_FILES['attachment']['name'];
                        }
                    } else {
                        dd('File size too large');
                    }
                } else {
                    $attachment_file = '';
                }

                $filter = ['Reciever' => $reciever_email, 'Sender' => getLoginUserData('user_mail'), 'Message' => $message, 'Subject' => $subject, 'Attachment' => $attachment_file];
                //dd($filter);

                if ($this->sendEmailReply($reciever_email, 'MailReplyTemplate', $filter)) {
                    $data = array(
                        'parent_id' => $parent_id,
                        'sender_id' => getLoginUserData('user_id'),
                        'reciever_id' => $reciever_id,
                        'subject' => $subject,
                        'body' => $message,
                        'status' => 'Unread',
                        'important' => 'Unimportant',
                        'log' => '',
                        'created' => date('Y-m-d h:i:s'),
                        'folder_id' => 1
                    );
                    $created_mail = $this->Mails_model->insert($data);
                    if ($attachment_file != '') {
                        $data = array(
                            'mail_id' => $created_mail,
                            'filelocation' => $attachment_file,
                            'filename' => $attachment_name,
                            'size' => $reciever_id
                        );
                        $att_id = insert_into_attachs($data);
                    }
                    $this->session->set_flashdata('message', 'Mail Successfully Sent');
                    redirect(site_url(Backend_URL . 'mails'));
                } else {
                    $this->session->set_flashdata('message', 'Mail was Failed to Sent');
                    redirect(site_url(Backend_URL . 'mails'));
                }
            }else{
                $this->session->set_flashdata('message', 'Failed. Reciever is unknown');
                redirect(site_url(Backend_URL . 'mails'));
            }
        }

    }

    public function _rules(){
	$this->form_validation->set_rules('reciever_email', 'reciever email', 'valid_email|required');
	$this->form_validation->set_rules('subject', 'subject', 'trim|required');
	$this->form_validation->set_rules('message', 'message', 'trim|required');

	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function sidebarMenus(){
        $mailmenu=      buildMenuForMoudle([
                        'module'    => 'Mailbox',
                        'icon'      => 'fa-envelope-o',
                        'href'      => 'mails',
                        'children'  => [
                            [
                                'title' => 'Inbox',
                                'icon'  => 'fa fa-circle-o',
                                'href'  => 'mails'
                            ],
                            [
                                'title' => 'Report On Mail',
                                'icon'  => 'fa-envelope-o',
                                'href'  => 'mails/report'
                            ]
                        ]
        ]);
        /*// For Mails Report Only for Admin/Developer
        $mailreport=    buildMenuForMoudle([
                        'module'    => 'Report On Mail',
                        'icon'      => 'fa-envelope-o',
                        'href'      => 'mails/report'
                         ]);*/

        return $mailmenu;

    }

    public function newSidebarMenus(){
        $mailmenu=  buildNewMenuForMoudle([
            'module'    => 'Mailbox',
            'img'      => 'assets/theme/new/images/backend/sidebar/mailbox.svg',
            'hover'      => 'assets/theme/new/images/backend/sidebar/mailbox-h.svg',
            'href'      => 'mails',
            'id'      => 'mailbox',
            'children'  => [
                [
                    'title' => 'Inbox',
                    'img'  => 'assets/theme/new/images/backend/sidebar/photo.svg',
                    'hover'  => 'assets/theme/new/images/backend/sidebar/photo-h.svg',
                    'href'  => 'mails',
                    'badge'      => '<span class="badge">'.unread_mail().'</span>',
                ],
                [
                    'title' => 'Sent',
                    'img'  => 'assets/theme/new/images/backend/sidebar/photo.svg',
                    'hover'  => 'assets/theme/new/images/backend/sidebar/photo-h.svg',
                    'href'  => 'mails/sent'
                ],
                [
                    'title' => 'Report On Mail',
                    'img'  => '',
                    'hover'  => '',
                    'href'  => 'mails/report'
                ]
            ]
        ]);

        return $mailmenu;

    }

    public function newSidebarMenusTrade(){
        $unread = unread_mail();
        $mailmenu=  buildNewMenuForTrade([
            'module'    => 'Mail',
            'icon'    => 'email',
            'href'      => 'mails',
            'id'      => 'mailbox',
            'badge'    => $unread,
            'children'  => [
                [
                    'title' => 'Inbox',
                    'id' => '',
                    'href'  => 'mails',
                    'badge'      => $unread,
                ],
                [
                    'title' => 'Sent',
                    'href'  => 'mails/sent',
                    'badge'      => '',
                    'id' => '',
                ],
//                [
//                    'title' => 'Report On Mail',
//                    'img'  => '',
//                    'hover'  => '',
//                    'href'  => 'mails/report'
//                ]
            ]
        ]);

        return $mailmenu;

    }


    public function update_important_ajax(){
        $id     = $this->input->post('id',TRUE);
        $row = $this->Mails_model->get_by_id($id);
        $change=$row->important;
        if($change=="Important"){
            $imp = 'Unimportant';
        }else{
            $imp = 'Important';
        }

        $data = array( 'important' => $imp );
        if($this->Mails_model->update($id, $data)){
            echo ajaxRespond('OK', $imp );
        }else{
            echo ajaxRespond('FAIL','Not Changed');
        }

    }


    public function image_upload($image) {

        $handle = new Verot\Upload\Upload($image);
        if ($handle->uploaded) {
            $prefix = 9;
            $handle->file_new_name_body = 'image_resized';
            $handle->image_resize = true;
            $handle->image_x = 400;
            $handle->image_ratio_y = true;
            $handle->allowed = array(
                'image/jpeg',
                'image/jpg',
                'image/gif',
                'image/png',
                'image/bmp'
            );
            $handle->file_new_name_body = uniqid($prefix) . '_' . md5(microtime()) . '_' . time();
            $handle->process(dirname(BASEPATH) . '/uploads/attachments/');
            $handle->processed;
            return $receipt_img = 'uploads\\attachments\\'.$handle->file_dst_name;
        }
    }
    
    public function file_upload($file){
        $handle = new upload($file);
        if ($handle->uploaded) {
            $prefix = 9;
            $handle->file_new_name_body = 'file_resized';
            $handle->allowed = array(
                'application/pdf',
                'application/msword',
                'application/x-msexcel',
                'application/x-pdf',
                'text/plain',
                'application/zip',
                'application/x-zip-compressed',
                'application/x-rar-compressed'
            );
            $handle->file_new_name_body = uniqid($prefix) . '_' . md5(microtime()) . '_' . time();
            $handle->process(dirname(BASEPATH) . '/uploads/attachments/');
            $handle->processed;
            return $receipt_img = FCPATH.'uploads\\attachments\\'.$handle->file_dst_name;
        }
    }
    
    public function sent(){
        $user_id = getLoginUserData('user_id');
        $q = urldecode($this->input->get('q', TRUE)?$this->input->get('q', TRUE):'');
        $start = intval($this->input->get('start'));
        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'mails/sent?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'mails/sent?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'mails/sent';
            $config['first_url'] = Backend_URL . 'mails/sent';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;



        $mails = $this->Mails_model->get_all_sent_mails_trader($this->user_id,$start,$config['per_page']);

        $config['total_rows'] = $this->Mails_model->getTradeMailsSentTotal($user_id);
        $config['query_string_segment'] = 'start';

        $config['num_links'] = 1;

        $config['full_tag_open'] = '<ul class="pagination-wrap">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = false;
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-angle-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li><span class="active">';
        $config['cur_tag_close'] = '</span></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'mails' => $mails,
            'type'  => 'Sent',
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
//        pp($data);
        if($this->role_id == 1 or $this->role_id == 2) {
            $this->viewAdminContent('mails/index', $data);
        } elseif ($this->role_id == 14){
            viewAdminDriverNew('backend/trade/template/sent', $data);
        } elseif ($this->role_id == 9){
            viewAdminMechanicNew('backend/trade/template/sent', $data);
        } else {
            $this->viewAdminContentPrivate('backend/trade/template/sent', $data);
        }

    }
    
    
    public function report(){

        $this->db->select('mail_type, COUNT(mail_type) as total');
        $this->db->group_by('mail_type'); 
        $this->db->order_by('total', 'desc'); 
        $datas = $this->db->get('mails')->result_array();
        
        $report = array();
        $total = 0;
        foreach ( $datas as $row  ){            
            $report[$row['mail_type']] = $row['total'];
            $total = $total + $row['total'];
        }
        // echo $total;
        
        
        $report['total_mails'] = $total;
        
        //dd( $report );
        
        $this->viewAdminContent('mails/report', ['data' => $report]);
    }

    function getMailChart(){
        $day = [];
        for( $i=-6; $i<=0;$i++ ){
            $day[] = date('d M y', strtotime("+$i days "));
        }
        return json_encode($day);
    }

    function getMailRequest($type=''){
        $data  = [];
        if($type!=''){
            for( $i=-6; $i<=0;$i++ ){
                $day    = date('Y-m-d', strtotime("+$i days "));
                $data[] = $this->db
                    ->where('mail_type',$type)
                    ->like('created',  $day  )
                    ->get('mails')->num_rows();
            }
            return  json_encode($data);

        }else{
            return  json_encode($data);
        }
    }

    
    
    public function reply_mail_action(){

       $parent_id =  $this->input->post('parent_id',TRUE);
       $mail_to =  $this->input->post('mail_to',TRUE);
       $mail_from = $this->input->post('mail_from',TRUE);
       $subject =  $this->input->post('subject',TRUE);
       $message =  $this->input->post('message',TRUE);

      $subject = substr($subject, 7, 500);

       $data = array(
            'subject'       => $subject,
            'mail_from'     => $mail_from,
            'mail_to'       => $mail_to,
            'message'          => $message,
            'mail_type'        => 'Reply',
            'parent_id'        => $parent_id
        );

        echo Modules::run('mail/replyMail', $data);
    }

    public function reply_mail_action_trader(){

        $parent_id =  $this->input->post('parent_id',TRUE);
        $type =  $this->input->post('type',TRUE);
        $row = $this->Mails_model->get_by_id($parent_id);
        if ($type != 'Inbox') {
            $mail_to =  $row->mail_to;
            $mail_from = $row->mail_from;
        } else {
            $mail_to =  $row->mail_from;
            $mail_from = $row->mail_to;
        }
        $subject =  $row->subject;
        $message =  $this->input->post('message',TRUE);
        $attachment_file = '';

        if (!empty($_FILES['attachment']['name'])) {
            $ext = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
            if ($_FILES['attachment']['size'] < 5 * MB) {
                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png' || $ext == 'bmp') {
                    $attachment_file = $this->image_upload($_FILES['attachment']);
                    $attachment_name = $_FILES['attachment']['name'];
                    $attachment_size = $_FILES['attachment']['size'];
                } elseif ($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' || $ext == 'txt' || $ext == 'zip' || $ext == 'rar') {
                    $attachment_file = $this->file_upload($_FILES['attachment']);
                    $attachment_name = $_FILES['attachment']['name'];
                    $attachment_size = $_FILES['attachment']['size'];
                }
            } else {
                dd('File size too large');
            }
        } else {
            $attachment_file = '';
        }

        $filter = ['Reciever' => $mail_to, 'Sender' => $mail_from, 'Message' => $message, 'Subject' => $subject, 'Attachment' => $attachment_file];
        //dd($filter);

        $data = array(
            'parent_id' => $parent_id,
            'mail_from'=>$mail_from,
            'mail_to'=>$mail_to,
            'subject' => $subject,
            'body' => $message,
            'status' => 'Unread',
            'important' => 'Unimportant',
            'log' => '',
            'created' => date('Y-m-d h:i:s'),
            'folder_id' => 1
        );
        $created_mail = $this->Mails_model->insert($data);
        if ($attachment_file != '') {
            $data = array(
                'mail_id' => $created_mail,
                'filelocation' => $attachment_file,
                'filename' => $attachment_name,
                'size' => $attachment_size
            );
            $att_id = insert_into_attachs($data);
        }
        $this->session->set_flashdata([ 'status' => 'success','message'=>'Mail Successfully Sent']);
        $lastUrl = $_SERVER['HTTP_REFERER'];
        $lastUrl = substr($lastUrl,-4);
        if ($lastUrl === 'Sent'){
            redirect(site_url(Backend_URL . 'mails/sent'));
        }else{
            redirect(site_url(Backend_URL . 'mails'));
        }


//        if ($this->sendEmailReply($mail_to, 'MailReplyTemplate', $filter)) {
//            $data = array(
//                'parent_id' => $parent_id,
//                'mail_from'=>$mail_from,
//                'mail_to'=>$mail_to,
//                'subject' => $subject,
//                'body' => $message,
//                'status' => 'Unread',
//                'important' => 'Unimportant',
//                'log' => '',
//                'created' => date('Y-m-d h:i:s'),
//                'folder_id' => 1
//            );
//            $created_mail = $this->Mails_model->insert($data);
//            if ($attachment_file != '') {
//                $data = array(
//                    'mail_id' => $created_mail,
//                    'filelocation' => $attachment_file,
//                    'filename' => $attachment_name,
//                    'size' => $mail_to
//                );
//                $att_id = insert_into_attachs($data);
//            }
//            $this->session->set_flashdata([ 'status' => 'success','message'=>'Mail Successfully Sent']);
//            redirect(site_url(Backend_URL . 'mails'));
//        } else {
//            $this->session->set_flashdata([ 'status' => 'error','message'=>'Mail was Failed to Sent']);
//            redirect(site_url(Backend_URL . 'mails'));
//        }

    }
    
    public function api_reply_mail_action() {

        $token = $this->input->server('HTTP_TOKEN');

        is_token_match(0, $token);

        $parent_id  = $this->input->post('parent_id', TRUE);
        $mail_to    = trim($this->input->post('mail_to', TRUE));
        $mail_from  = trim($this->input->post('mail_from', TRUE));        
        $subject    = $this->input->post('subject', TRUE);
        $message    = $this->input->post('message', TRUE);
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
        $res = [
            'status' => 1,
            'message' => 'Replied Successfully'
        ];

        json_output(200, $res);
    }

    public function getReplyMails( $parent_id = 0 ){       
        return $this->db->get_where('mails', ['parent_id' => $parent_id])->result();
    }
    public function getUserNameByEmail( $email ){   
        $this->db->select('first_name,last_name');
        $this->db->where('email', $email);
        $user = $this->db->get('users')->row();
        if($user){
            return "{$user->first_name} {$user->last_name}";
        } else {
            return 'Unknown User';
        }
    }

    /**
     * Post Request
     * Request From Mail Index Page
     */
    public function changeStatus()
    {
        /// receiving mails id from post request
        $mailId = $this->input->post('mail_id');
        $type = $this->input->post('type');
        $condition = $type === 'Sent' ? '!=':'=';
        // checking we are received all required input
        if (!empty($mailId)){
            /// receiving status field value from post request
            $markAs = $this->input->post('mark_as');
            // array to mysql receive data format
            $implodeMailId = implode(',', $mailId);
            $user_id = getLoginUserData('user_id');

            // updating paraent status with child
            $this->db->query("UPDATE mails as parent
                                LEFT JOIN mails as child ON (parent.id = child.parent_id)
                                SET parent.`status` = IF(parent.reciever_id = '$user_id', '$markAs', child.`status`), child.`status` = IF(child.mail_to $condition parent.mail_to, '$markAs', child.`status`)
                                WHERE parent.id IN ($implodeMailId)");
            // finally setting flash and redirect
            $this->session->set_flashdata(['status' => 'success','message'=> 'Select Mail Changed as '. $markAs]);
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            // on error finally setting flash and redirect
            $this->session->set_flashdata(['status' => 'error','message'=> 'Please Select a Mail']);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

}