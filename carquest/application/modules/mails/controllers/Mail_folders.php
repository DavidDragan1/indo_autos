<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-11-02
 */

class Mail_folders extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Mail_folders_model');
        $this->load->helper('mail_folders');
        $this->load->library('form_validation');
    }

    public function index(){
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'mail_folders/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'mail_folders/?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'mail_folders/';
            $config['first_url'] = base_url() . 'mail_folders/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Mail_folders_model->total_rows($q);
        $mail_folders = $this->Mail_folders_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'mail_folders_data' => $mail_folders,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('mail_folders/index', $data);
    }

    public function read($id){
        $row = $this->Mail_folders_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'user_id' => $row->user_id,
		'name' => $row->name,
		'created' => $row->created,
		'modified' => $row->modified,
	    );
            $this->viewAdminContent('mail_folders/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'mail_folders'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'mail_folders/create_action'),
	    'id' => set_value('id'),
	    'user_id' => set_value('user_id'),
	    'name' => set_value('name'),
	    'created' => set_value('created'),
	    'modified' => set_value('modified'),
	);
        $this->viewAdminContent('mail_folders/form', $data);
    }
    
    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'user_id' => $this->input->post('user_id',TRUE),
		'name' => $this->input->post('name',TRUE),
		'created' => $this->input->post('created',TRUE),
		'modified' => $this->input->post('modified',TRUE),
	    );

            $this->Mail_folders_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'mail_folders'));
        }
    }
    
    public function update($id){
        $row = $this->Mail_folders_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'mail_folders/update_action'),
		'id' => set_value('id', $row->id),
		'user_id' => set_value('user_id', $row->user_id),
		'name' => set_value('name', $row->name),
		'created' => set_value('created', $row->created),
		'modified' => set_value('modified', $row->modified),
	    );
            $this->viewAdminContent('mail_folders/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'mail_folders'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'user_id' => $this->input->post('user_id',TRUE),
		'name' => $this->input->post('name',TRUE),
		'created' => $this->input->post('created',TRUE),
		'modified' => $this->input->post('modified',TRUE),
	    );

            $this->Mail_folders_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL. 'mail_folders'));
        }
    }
    
    public function delete($id){
        $row = $this->Mail_folders_model->get_by_id($id);

        if ($row) {
            $this->Mail_folders_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'mail_folders'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'mail_folders'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('user_id', 'user id', 'trim|required');
	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('created', 'created', 'trim|required');
	$this->form_validation->set_rules('modified', 'modified', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    


}