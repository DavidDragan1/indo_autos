<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-12-03
 */

class Parts extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Parts_model');
        $this->load->helper('parts');
        $this->load->library('form_validation');
    }

    public function index(){
        $parts = $this->Parts_model->get_all();

        $data = array(
            'parts_data' => $parts
        );

        $this->viewAdminContent('parts/index', $data);
    }

    public function read($id){
        $row = $this->Parts_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'name' => $row->name,
	    );
            $this->viewAdminContent('parts/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'parts'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'parts/create_action'),
	    'id' => set_value('id'),
	    'name' => set_value('name'),
	    'parent_id' => set_value('parent_id'),
	);
        $this->viewAdminContent('parts/form', $data);
    }
    
    public function create_action(){
        
        $vechile = implode( '#', $this->input->post('parent_id',TRUE));
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'parent_id' => '#'.$vechile.'#' ,
	    );

            $this->Parts_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'parts'));
        }
    }
    
    public function update($id){
        $row = $this->Parts_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'parts/update_action'),
		'id' => set_value('id', $row->id),
		'name' => set_value('name', $row->name),
		'parent_id' => set_value('parent_id', $row->parent_id),
               
	    );
            $this->viewAdminContent('parts/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'parts'));
        }
    }
    
    public function update_action(){
        
        $vechile = implode( '#', $this->input->post('parent_id',TRUE));
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'name' => $this->input->post('name',TRUE),
		'parent_id' => '#'.$vechile.'#' ,
	    );

            $this->Parts_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL. 'parts'));
        }
    }
    
    public function delete($id){
        $row = $this->Parts_model->get_by_id($id);

        if ($row) {
            $this->Parts_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'parts'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'parts'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('name', 'name', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    

    
    public function get_parts_description( $parent_id = 0 ){
        //$parts = $this->db->get_where('parts_description', ['parent_id' => $parent_id ])->result(); 
        $parts = $this->db->query( "SELECT * FROM parts_description WHERE parent_id LIKE '%#".$parent_id."#%'" )->result(); 
        $html = '<option value="0"> --Any-- </option>';                  
        foreach( $parts as $part ) {
            $html .= '<option value="'.$part->id.'"';
           //  $html .= ($part->id == $selected ) ? ' selected' : '';            
            $html .= '>'.$part->name.'</option>';
        }
        echo $html;  
    }

}