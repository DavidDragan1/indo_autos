<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-18
 */

class Body_types extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Body_types_model');        
        $this->load->library('form_validation');
    }

    public function index(){
        $body_types = $this->Body_types_model->get_all();

        $data = array(
            'body_types_data' => $body_types
        );

        $this->viewAdminContent('body_types/index', $data);
    }

    public function read($id){
        $row = $this->Body_types_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'type_name' => $row->type_name,
	    );
            $this->viewAdminContent('body_types/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'body_types'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'body_types/create_action'),
	    'id' => set_value('id'),
	    'type_name' => set_value('type_name'),
	);
        $this->viewAdminContent('body_types/form', $data);
    }
    
    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
            'type_name' => $this->input->post('type_name',TRUE),
            'vehicle_type' => $this->input->post('vehicle_type',TRUE),
	    );

            $this->Body_types_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'body_types'));
        }
    }
    
    public function update($id){
        $row = $this->Body_types_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'body_types/update_action'),
                'id' => set_value('id', $row->id),
                'type_name' => set_value('type_name', $row->type_name),
                'vehicle_type'=>set_value('vehicle_type', $row->vehicle_type),
                );
            $this->viewAdminContent('body_types/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'body_types'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		    'type_name' => $this->input->post('type_name',TRUE),
		    'vehicle_type' => $this->input->post('vehicle_type',TRUE),
	    );

            $this->Body_types_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL. 'body_types'));
        }
    }
    
    public function delete($id){
        $row = $this->Body_types_model->get_by_id($id);

        if ($row) {
            $this->Body_types_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'body_types'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'body_types'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('type_name', 'type name', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
       
    function get_body_type($selected = 0){
        $vehicleTypeName= $this->input->get('type_name');
        if (empty($vehicleTypeName)){
            return;
        }
        $bodyTypeName = $this->db->from('body_types')->where('vehicle_type',$vehicleTypeName)->get()->result();
        $options = '';
        $options .= '<option value="">Select Body Type</option>';
        foreach ($bodyTypeName as $row) {
            $options .= '<option value="' . $row->id . '" ';
            $options .= ($row->id = $selected) ? ' selected="selected"' : '';
            $options .= '>' . $row->type_name . '</option>';
        }
        echo $options;
    }
}