<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-18
 */

class Email_templates extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Email_templates_model');
        $this->load->helper('email_templates');
        $this->load->library('form_validation');
    }

    public function index(){
        $q = urldecode($this->input->get('q', TRUE)??'');
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'email_templates/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'email_templates/?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'email_templates/';
            $config['first_url'] = base_url() . 'email_templates/';
        }

        $config['per_page'] = 50;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Email_templates_model->total_rows($q);
        $email_templates = $this->Email_templates_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'email_templates_data' => $email_templates,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('email_templates/index', $data);
    }

    public function read($id){
        $row = $this->Email_templates_model->get_by_id($id);
        if ($row) {
            $data = array(
			'id' => $row->id,
			'title' => $row->title,
			'template' => $row->template,
			'slug' => $row->slug,
			'status' => $row->status,
			'adminnotes' => $row->adminnotes,
			'created' => globalDateFormat($row->created),
			'modified' => globalDateFormat($row->modified)
			);
            $this->viewAdminContent('email_templates/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'email_templates'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'email_templates/create_action'),
			'id' => set_value('id'),
			'title' => set_value('title'),
			'template' => set_value('template'),
			'slug' => set_value('slug'),
			'status' => set_value('status'),
			'adminnotes' => set_value('adminnotes'),
			'created' => set_value('created'),
			'modified' => set_value('modified'),
		);
        $this->viewAdminContent('email_templates/form', $data);
    }
    
    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
				'title' => $this->input->post('title',TRUE),
				'template' => $this->input->post('template',TRUE),
				'slug' => $this->input->post('slug',TRUE),
				'status' => $this->input->post('status',TRUE),
				'adminnotes' => $this->input->post('adminnotes',TRUE),
				'created' => date('Y-m-d h:i:s'),
				'modified' => date('Y-m-d h:i:s'),
			);

            $this->Email_templates_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'email_templates'));
        }
    }
    
    public function update($id){
        $row = $this->Email_templates_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'email_templates/update_action'),
                'id' => set_value('id', $row->id),
                'title' => set_value('title', $row->title),
                'template' => set_value('template', $row->template),
                'slug' => set_value('slug', $row->slug),
                'status' => set_value('status', $row->status),
                'adminnotes' => set_value('adminnotes', $row->adminnotes),
                'created' => set_value('created', $row->created)				
            );
            $this->viewAdminContent('email_templates/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'email_templates'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            
            $id = $this->input->post('id', TRUE);
            $data = array(
                'title' => $this->input->post('title',TRUE),
                'template' => $this->input->post('template',TRUE),
                'slug' => $this->input->post('slug',TRUE),
                'status' => $this->input->post('status',TRUE),
                'adminnotes' => $this->input->post('adminnotes',TRUE),
                'created' => $this->input->post('created',TRUE),
                'modified' => $this->input->post('modified',TRUE),
            );

            $this->Email_templates_model->update($id , $data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Email Template Updated Successfully</p>');
            redirect(site_url( Backend_URL. 'email_templates/update/' . $id ));
        }
    }
    
    public function delete($id){
        $row = $this->Email_templates_model->get_by_id($id);

        if ($row) {
            $this->Email_templates_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'email_templates'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'email_templates'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('title', 'title', 'trim|required');
	$this->form_validation->set_rules('template', 'template', 'trim|required');
	$this->form_validation->set_rules('slug', 'slug', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');	 	 

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
        
}