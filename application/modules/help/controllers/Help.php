<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2017-11-25
 */

class Help extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Help_model');
        $this->load->helper('help');
        $this->load->library('form_validation');
    }

    public function index(){
        $q = urldecode($this->input->get('q', TRUE)?$this->input->get('q', TRUE):'');
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'help/?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'help/?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'help/';
            $config['first_url'] = Backend_URL . 'help/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Help_model->total_rows($q);
        $help = $this->Help_model->get_limit_data($config['per_page'], $start, $q);

        $role_id = getLoginUserData('role_id');

        if ($role_id == 1 || $role_id == 2) {
            $this->load->library('pagination');
            $this->pagination->initialize($config);

            $data = array(
                'help_data' => $help,
                'q' => $q,
                'pagination' => $this->pagination->create_links(),
                'total_rows' => $config['total_rows'],
                'start' => $start,
            );

            $this->viewAdminContent('help/help/index', $data);
        } else {
            $config['page_query_string'] = TRUE;

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
            $config['per_page'] = 10;

            $this->load->library('pagination');
            $this->pagination->initialize($config);

            $data = array(
                'help_data' => $help,
                'q' => $q,
                'pagination' => $this->pagination->create_links(),
                'total_rows' => $config['total_rows'],
                'start' => $start,
            );

            $this->viewNewAdminContent('help/help/trader_index', $data);
        }
    }

    public function read($id){
        $row = $this->Help_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'title' => $row->title,
		'description' => $row->description,
		'content' => $row->content,
		'qustion_by_name' => $row->qustion_by_name,
		'question_by_email' => $row->question_by_email,
		'created' => $row->created,
		'status' => $row->status,
		'featured' => $row->featured,
		'modified' => $row->modified,
	    );
            $role_id = getLoginUserData('role_id');

            if ($role_id == 1 || $role_id == 2) {
                $this->viewAdminContent('help/help/read', $data);
            } else {
                $this->viewNewAdminContent('help/help/trader_detail', $data);
            }
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');

            redirect(site_url( Backend_URL. 'help'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'help/create_action'),
	    'id' => set_value('id'),
	    'title' => set_value('title'),
	    'status' => set_value('status',  'Draft'),
	    'featured' => set_value('featured',  'No'),
	    'content' => set_value('content')
	);
        $temp = $this->input->post('temp',TRUE);

        if (isset($temp) && $temp == "temp") {
            redirect(site_url( Backend_URL. 'help'));
        } else {
            $this->viewAdminContent('help/help/create', $data);
        }
    }
    
    public function create_action(){
        $user_id = getLoginUserData('user_id');

        $user = $this->db->where('id', $user_id)->get('users')->row();

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'title' => $this->input->post('title',TRUE),
                'content' => $this->input->post('content',TRUE),
                'description' => $this->input->post('description',TRUE),
                'status' => $this->input->post('status',TRUE),
                'featured' => $this->input->post('featured', TRUE),
                'qustion_by_name' => $user->first_name." ".$user->last_name,
                'question_by_email' => $user->email,
                'created' => date('Y-m-d'),
                'modified' => date('Y-m-d'),
                'question_at_date'  => date('Y-m-d'),

            );

            $this->Help_model->insert($data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Create Record Success</p>');
            redirect(site_url( Backend_URL. 'help'));
        }
    }
    
    public function update($id){
        $row = $this->Help_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'help/update_action'),
                'id' => set_value('id', $row->id),
                'title' => set_value('title', $row->title),
                'description' => set_value('description', $row->description),
                'content' => set_value('content', $row->content),
                'qustion_by_name' => set_value('qustion_by_name', $row->qustion_by_name),
                'question_by_email' => set_value('question_by_email', $row->question_by_email),
                'status' => set_value('status', $row->status),
                'featured' => set_value('featured', $row->featured),
	    );
            $temp = $this->input->post('temp',TRUE);

            if (isset($temp) && $temp == "temp") {
                redirect(site_url( Backend_URL. 'help'));
            } else {
                $this->viewAdminContent('help/help/update', $data);
            }
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'help'));
        }
    }
    
    public function update_action(){
        $this->_rules();
        
        $notify = ($this->input->post('send_notify')) ? $this->input->post('send_notify') : false;
        $email  = $this->input->post('email',TRUE);
        
        $id = $this->input->post('id', TRUE);
        if ($this->form_validation->run() == FALSE) {
            $this->update( $id );
        } else {
            $data = array(
		'title'     => $this->input->post('title',TRUE),
		'description'   => $this->input->post('description',TRUE),
		'content'   => $this->input->post('content',TRUE),
		'status'    => $this->input->post('status',TRUE),
		'featured'  => $this->input->post('featured',TRUE),		
		'modified'  => date('Y-m-d') 
	    );           
            
            $this->Help_model->update($id, $data);
            
            $this->notify_to_visitor( $notify, $email, $data, $id );

            $temp = $this->input->post('temp',TRUE);

            if (isset($temp) && $temp == "temp") {
                $this->session->set_flashdata('message', '<p class="ajax_success">Data Updated Successlly</p>');

                redirect(site_url( Backend_URL. 'help'));
            } else {
                $this->session->set_flashdata('message', '<p class="ajax_success">Data Updated Successlly</p>');
                redirect(site_url( Backend_URL. 'help/update/'. $id ));
            }
        }
    }
    
    
    private function notify_to_visitor( $notify, $email, $data, $id ){   
        if($notify){
                                    
            $mail_body_html =  '<h3><b>Your Question:</b> ' . $data['title'] . '</h3>';
            $mail_body_html .= 'Answer:</b><br/> ' . $data['content'];
            $mail_body_html .= '<p><br/><br/><b>FAQ Link:</b> ' . site_url( 'faq/' . $id) . '</p>';                        
            
            Modules::run('mail/send_faq_notify_to_visitor',$mail_body_html, $email);
        }        
    }



    public function delete($id){
        $row = $this->Help_model->get_by_id($id);

        if ($row) {
            $this->Help_model->delete($id);
            $this->session->set_flashdata('message', '<p class="ajax_success">Delete Record Success</p>');
            redirect(site_url( Backend_URL. 'help'));
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'help'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('title', 'title', 'trim|required');
	$this->form_validation->set_rules('content', 'content', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    


}