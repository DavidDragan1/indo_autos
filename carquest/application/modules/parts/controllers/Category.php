<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2017-06-17
 */

class Category extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->helper('parts_categories');
        $this->load->library('form_validation');
    }

    public function index(){
        $category = $this->Category_model->get_all();

        $data = array(
            'category_data' => $category
        );

        $this->viewAdminContent('parts/category/index', $data);
    }

    public function read($id){
        $row = $this->Category_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'category' => $row->category,
	    );
            $this->viewAdminContent('category/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'category'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'parts/category/create_action'),
	    'id' => set_value('id'),
	    'category' => set_value('category'),
	);
        $this->viewAdminContent('parts/category/form', $data);
    }
    
    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'category' => $this->input->post('category',TRUE),
	    );

            $this->Category_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'parts/category'));
        }
    }
    
    public function update($id){
        $row = $this->Category_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'parts/category/update_action'),
		'id' => set_value('id', $row->id),
		'category' => set_value('category', $row->category),
	    );
            $this->viewAdminContent('category/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'parts/category'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'category' => $this->input->post('category',TRUE),
	    );

            $this->Category_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL. 'parts/category'));
        }
    }
    
    public function delete($id){
        $row = $this->Category_model->get_by_id($id);

        if ($row) {
            $this->Category_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'parts/category'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'parts/category'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('category', 'category', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    


}