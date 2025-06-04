<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-11-16
 */

class Countries extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Countries_model');
        $this->load->helper('countries_helper');
        $this->load->library('form_validation');
    }

    public function index(){
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'countries/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'countries/?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'countries/';
            $config['first_url'] = base_url() . 'countries/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Countries_model->total_rows($q);
        $countries = $this->Countries_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'countries_data' => $countries,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('countries/index', $data);
    }

    public function read($id){
        $row = $this->Countries_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'parent_id' => $row->parent_id,
		'name' => $row->name,
		'type' => $row->type,
		'status' => $row->status,
	    );
            $this->viewAdminContent('countries/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'countries'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'countries/create_action'),
	    'id' => set_value('id'),
	    'parent_id' => set_value('parent_id'),
	    'name' => set_value('name'),
	    'type' => set_value('type'),
	    'status' => set_value('status'),
	);
        $this->viewAdminContent('countries/form', $data);
    }
    
    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'parent_id' => $this->input->post('parent_id',TRUE),
		'name' => $this->input->post('name',TRUE),
		'type' => $this->input->post('type',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Countries_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'countries'));
        }
    }
    
    public function update($id){
        $row = $this->Countries_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'countries/update_action'),
		'id' => set_value('id', $row->id),
		'parent_id' => set_value('parent_id', $row->parent_id),
		'name' => set_value('name', $row->name),
		'type' => set_value('type', $row->type),
		'status' => set_value('status', $row->status),
	    );
            $this->viewAdminContent('countries/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'countries'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'parent_id' => $this->input->post('parent_id',TRUE),
		'name' => $this->input->post('name',TRUE),
		'type' => $this->input->post('type',TRUE),
		'status' => $this->input->post('status',TRUE),
	    );

            $this->Countries_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL. 'countries'));
        }
    }
    
    public function delete($id){
        $row = $this->Countries_model->get_by_id($id);

        if ($row) {
            $this->Countries_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'countries'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'countries'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('parent_id', 'parent id', 'trim|required');
	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('type', 'type', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    


}