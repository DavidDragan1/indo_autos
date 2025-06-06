<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-18
 */

class Fuel_types extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Fuel_types_model');
        $this->load->library('form_validation');
    }

    public function index(){
        $fuel_types = $this->Fuel_types_model->get_all();

        $data = array(
            'fuel_types_data' => $fuel_types
        );

        $this->viewAdminContent('fuel_types/index', $data);
    }

    public function read($id){
        $row = $this->Fuel_types_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'fuel_name' => $row->fuel_name,
	    );
            $this->viewAdminContent('fuel_types/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'fuel_types'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'fuel_types/create_action'),
	    'id' => set_value('id'),
	    'fuel_name' => set_value('fuel_name'),
	);
        $this->viewAdminContent('fuel_types/form', $data);
    }
    
    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'fuel_name' => $this->input->post('fuel_name',TRUE),
	    );

            $this->Fuel_types_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'fuel_types'));
        }
    }
    
    public function update($id){
        $row = $this->Fuel_types_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'fuel_types/update_action'),
		'id' => set_value('id', $row->id),
		'fuel_name' => set_value('fuel_name', $row->fuel_name),
	    );
            $this->viewAdminContent('fuel_types/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'fuel_types'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'fuel_name' => $this->input->post('fuel_name',TRUE),
	    );

            $this->Fuel_types_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL. 'fuel_types'));
        }
    }
    
    public function delete($id){
        $row = $this->Fuel_types_model->get_by_id($id);

        if ($row) {
            $this->Fuel_types_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'fuel_types'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'fuel_types'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('fuel_name', 'fuel name', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }         

}