<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-18
 */

class Color extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Color_model');        
        $this->load->library('form_validation');
    }

    public function index(){
        $color = $this->Color_model->get_all();

        $data = array(
            'color_data' => $color
        );

        $this->viewAdminContent('color/index', $data);
    }

    public function read($id){
        $row = $this->Color_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'color_name' => $row->color_name,
	    );
            $this->viewAdminContent('color/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'color'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'color/create_action'),
	    'id' => set_value('id'),
	    'color_name' => set_value('color_name'),
	);
        $this->viewAdminContent('color/form', $data);
    }
    
    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'color_name' => $this->input->post('color_name',TRUE),
	    );

            $this->Color_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'color'));
        }
    }
    
    public function update($id){
        $row = $this->Color_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'color/update_action'),
		'id' => set_value('id', $row->id),
		'color_name' => set_value('color_name', $row->color_name),
	    );
            $this->viewAdminContent('color/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'color'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'color_name' => $this->input->post('color_name',TRUE),
	    );

            $this->Color_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL. 'color'));
        }
    }
    
    public function delete($id){
        $row = $this->Color_model->get_by_id($id);

        if ($row) {
            $this->Color_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'color'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'color'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('color_name', 'color name', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    
}