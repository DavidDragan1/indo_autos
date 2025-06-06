<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-18
 */

class Engine_sizes extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Engine_sizes_model');        
        $this->load->library('form_validation');
    }

    public function index(){
        $engine_sizes = $this->Engine_sizes_model->get_all();

        $data = array(
            'engine_sizes_data' => $engine_sizes
        );

        $this->viewAdminContent('engine_sizes/index', $data);
    }

    public function read($id){
        $row = $this->Engine_sizes_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'engine_size' => $row->engine_size,
	    );
            $this->viewAdminContent('engine_sizes/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'engine_sizes'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'engine_sizes/create_action'),
	    'id' => set_value('id'),
	    'engine_size' => set_value('engine_size'),
	);
        $this->viewAdminContent('engine_sizes/form', $data);
    }
    
    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		    'engine_size' => $this->input->post('engine_size',TRUE),
		    'vehicle_type_id' => $this->input->post('vehicle_type',TRUE),

	    );

            $this->Engine_sizes_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'engine_sizes'));
        }
    }
    
    public function update($id){
        $row = $this->Engine_sizes_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'engine_sizes/update_action'),
            'id' => set_value('id', $row->id),
            'engine_size' => set_value('engine_size', $row->engine_size),
            'vehicle_type_id' => set_value('vehicle_type_id', $row->vehicle_type_id),
	    );
            $this->viewAdminContent('engine_sizes/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'engine_sizes'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'engine_size' => $this->input->post('engine_size',TRUE),
		'vehicle_type_id' => $this->input->post('vehicle_type_id',TRUE),
	    );

            $this->Engine_sizes_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL. 'engine_sizes'));
        }
    }
    
    public function delete($id){
        $row = $this->Engine_sizes_model->get_by_id($id);

        if ($row) {
            $this->Engine_sizes_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'engine_sizes'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'engine_sizes'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('engine_size', 'engine size', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function get_engine_size($selected = 0)
    {
        $vehicleTypeId = $this->input->get('type_id');
        if (empty($vehicleTypeId)){
            return;
        }
        $bodyTypeName = $this->db->from('engine_sizes')->where('vehicle_type_id',$vehicleTypeId)->get()->result();
        $options = '';
        $options .= '<option value="">Select Engine Size</option>';
        foreach ($bodyTypeName as $row) {
            $options .= '<option value="' . $row->id . '" ';
            $options .= ($row->id = $selected) ? ' selected="selected"' : '';
            $options .= '>' . $row->engine_size . '</option>';
        }
        echo $options;
    }
}