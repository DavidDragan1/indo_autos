<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-18
 */

class Port extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Port_model');
        $this->load->library('form_validation');
    }

    public function index(){

        $fuel_types = $this->Port_model->get_all();

        $data = array(
            'fuel_types_data' => $fuel_types
        );
        $this->viewAdminContent('port/index', $data);
    }

    public function read($id){
        $row = $this->Port_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'name' => $row->name,
	    );
            $this->viewAdminContent('port/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'port'));
        }
    }

    public function create(){

        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'port/create_action'),
	    'id' => set_value('id'),
	    'name' => set_value('name'),
	);
        $this->viewAdminContent('port/form', $data);
    }
    
    public function create_action(){

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = $this->db->from('ports')->where('name', strtolower($this->input->post('name',TRUE)))->get()->row();
            if (!empty($data)){
                $this->session->set_flashdata('message', 'Port already exists');
                redirect(site_url( Backend_URL. 'port'));
            }
            $data = array(
		        'name' => strtolower($this->input->post('name',TRUE)
            ),
	    );
            $this->Port_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'port'));
        }
    }
    
    public function update($id){
        $row = $this->Port_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'port/update_action'),
		'id' => set_value('id', $row->id),
		'name' => set_value('name', $row->name),
	    );

            $this->viewAdminContent('port/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'port'));
        }
    }
    
    public function update_action(){

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $exist_data = $this->db->from('ports')->where('name', strtolower($this->input->post('name',TRUE)))->get()->row();

            if (!empty($exist_data) && $exist_data->id != $this->input->post('id', TRUE)){
                $this->session->set_flashdata('message', 'Port already exists');
                redirect(site_url( Backend_URL. 'port'));
            }
            $data = array(
		     'name' => strtolower($this->input->post('name',TRUE)),
	        );
            $this->Port_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL. 'port'));
        }
    }
    
    public function delete($id){
        $row = $this->Port_model->get_by_id($id);
        if ($row) {
            $this->Port_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'port'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'port'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('name', 'name', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }         

}