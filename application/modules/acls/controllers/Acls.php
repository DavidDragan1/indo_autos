<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-11-14
 */

class Acls extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Acls_model');       
        $this->load->library('form_validation');
    }

    public function index(){
        $acls = $this->Acls_model->get_all();
        $data = ['acls_data' => $acls];
        $this->viewAdminContent('acls/index', $data);
    }

    public function read($id){
        $row = $this->Acls_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'module_id' => $row->module_id,
		'permission_name' => $row->permission_name,
		'permission_key' => $row->permission_key,		
	    );
            $this->viewAdminContent('acls/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'acls'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'acls/create_action'),
	    'id' => set_value('id'),
	    'module_id' => set_value('module_id'),
	    'permission_name' => set_value('permission_name'),
	    'permission_key' => set_value('permission_key'),
	    'order_id' => set_value('order_id'),
	);
        $this->viewAdminContent('acls/form', $data);
    }
    
    public function create_action(){                
        
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'module_id'         => $this->input->post('module_id',TRUE),
                'permission_name'   => $this->input->post('permission_name',TRUE),
                'permission_key'    => $this->input->post('permission_key',TRUE),
                'order_id'          => $this->input->post('order_id',TRUE),
            );

            $acl_id = $this->Acls_model->insert($data);            
            $this->db->insert('role_permissions', ['role_id' => 1, 'acl_id' => $acl_id, 'access' => 1 ] );            
            
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'acls'));
        }
    }
    
    public function update($id){
        $row = $this->Acls_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'acls/update_action'),
		'id' => set_value('id', $row->id),
		'module_id' => set_value('module_id', $row->module_id),
		'permission_name' => set_value('permission_name', $row->permission_name),
		'permission_key' => set_value('permission_key', $row->permission_key),
		'order_id' => set_value('order_id', $row->order_id),
	    );
            $this->viewAdminContent('acls/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'acls'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'module_id'         => $this->input->post('module_id',TRUE),
		'permission_name'   => $this->input->post('permission_name',TRUE),
		'permission_key'    => $this->input->post('permission_key',TRUE),
		'order_id'          => $this->input->post('order_id',TRUE),
	    );

            $this->Acls_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL. 'acls'));
        }
    }
    
    public function delete($id){
        $row = $this->Acls_model->get_by_id($id);

        if ($row) {
            $this->Acls_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'acls'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'acls'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('module_id', 'module id', 'trim|required');
	$this->form_validation->set_rules('permission_name', 'permission name', 'trim|required');
	$this->form_validation->set_rules('permission_key', 'permission key', 'trim|required');
	$this->form_validation->set_rules('order_id', 'order id', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
        
}