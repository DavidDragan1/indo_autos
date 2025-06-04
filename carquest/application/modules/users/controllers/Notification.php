<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2017-11-16
 */

class Notification extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Notification_model');
        $this->load->helper('user_notifications');
        $this->load->helper('brands/brands');
        $this->load->library('form_validation');
    }

    public function index(){
        $type_id = urldecode($this->input->get('type_id', TRUE)?$this->input->get('type_id', TRUE):'');
        $brand_id = urldecode($this->input->get('brand_id', TRUE)?$this->input->get('brand_id', TRUE):'');
        $model_id = urldecode($this->input->get('model_id', TRUE)?$this->input->get('model_id', TRUE):'');
        $user_id = urldecode($this->input->get('user_id', TRUE)?$this->input->get('user_id', TRUE):'');
        $start = intval($this->input->get('start'));
        
        if ( $type_id <> '' || $brand_id <> '' || $model_id <> '' || $user_id <> '' ) {
            $config['base_url']  = Backend_URL . 'users/notification/?type_id=' . urlencode($type_id) . '&brand_id='. urlencode($brand_id). '&model_id=' .urlencode($model_id) . '&user_id='. urlencode($user_id) ;
            $config['first_url'] = Backend_URL . 'users/notification/?type_id=' . urlencode($type_id) . '&brand_id='. urlencode($brand_id). '&model_id=' .urlencode($model_id) . '&user_id='. urlencode($user_id) ;
        } else {
            $config['base_url'] = Backend_URL . 'users/notification/';
            $config['first_url'] = Backend_URL . 'users/notification/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Notification_model->total_rows($type_id, $brand_id , $model_id, $user_id );
        $notification = $this->Notification_model->get_limit_data($config['per_page'], $start, $type_id, $brand_id , $model_id, $user_id );

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'notification_data' => $notification,
           
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('users/notification/index', $data);
    }

    public function read($id){
        $row = $this->Notification_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'user_id' => $row->user_id,
		'type_id' => $row->type_id,
		'brand_id' => $row->brand_id,
		'model_id' => $row->model_id,
		'year' => $row->year,
	    );
            $this->viewAdminContent('users/notification/read', $data);
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'users/notification'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'users/notification/create_action'),
	    'id' => set_value('id'),
	    'user_id' => set_value('user_id'),
	    'type_id' => set_value('type_id'),
	    'brand_id' => set_value('brand_id'),
	    'model_id' => set_value('model_id'),
	    'year' => set_value('year'),
	);
        $this->viewAdminContent('users/notification/create', $data);
    }
    
    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'user_id' => $this->input->post('user_id',TRUE),
		'type_id' => $this->input->post('type_id',TRUE),
		'brand_id' => $this->input->post('brand_id',TRUE),
		'model_id' => $this->input->post('model_id',TRUE),
		'year' => $this->input->post('year',TRUE),
	    );

            $this->Notification_model->insert($data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Create Record Success</p>');
            redirect(site_url( Backend_URL. 'users/notification'));
        }
    }
    
    public function update($id){
        $row = $this->Notification_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'users/notification/update_action'),
		'id' => set_value('id', $row->id),
		'user_id' => set_value('user_id', $row->user_id),
		'type_id' => set_value('type_id', $row->type_id),
		'brand_id' => set_value('brand_id', $row->brand_id),
		'model_id' => set_value('model_id', $row->model_id),
		'year' => set_value('year', $row->year),
	    );
            $this->viewAdminContent('users/notification/update', $data);
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'users/notification'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        $id = $this->input->post('id', TRUE);
        if ($this->form_validation->run() == FALSE) {
            $this->update( $id );
        } else {
            $data = array(
		'user_id' => $this->input->post('user_id',TRUE),
		'type_id' => $this->input->post('type_id',TRUE),
		'brand_id' => $this->input->post('brand_id',TRUE),
		'model_id' => $this->input->post('model_id',TRUE),
		'year' => $this->input->post('year',TRUE),
	    );

            $this->Notification_model->update($id, $data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Data Updated Successlly</p>');
            redirect(site_url( Backend_URL. 'users/notification/update/'. $id ));
        }
    }

    public function delete($id){
        $row = $this->Notification_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'user_id' => $row->user_id,
		'type_id' => $row->type_id,
		'brand_id' => $row->brand_id,
		'model_id' => $row->model_id,
		'year' => $row->year,
	    );
            $this->viewAdminContent('users/notification/delete', $data);
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'users/notification'));
        }
    }


    public function delete_action($id){
        $row = $this->Notification_model->get_by_id($id);

        if ($row) {
            $this->Notification_model->delete($id);
            $this->session->set_flashdata('message', '<p class="ajax_success">Delete Record Success</p>');
            redirect(site_url( Backend_URL. 'users/notification'));
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'users/notification'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('user_id', 'user id', 'trim|required|numeric');
	$this->form_validation->set_rules('type_id', 'type id', 'trim|required');
	$this->form_validation->set_rules('brand_id', 'brand id', 'trim|required');
	$this->form_validation->set_rules('model_id', 'model id', 'trim|required');
	$this->form_validation->set_rules('year', 'year', 'trim|required|numeric');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    


}