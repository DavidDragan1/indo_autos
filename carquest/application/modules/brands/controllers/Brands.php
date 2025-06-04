<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-11-11
 */

class Brands extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Brands_model');        
        $this->load->helper('brands');        
        $this->load->library('form_validation');
    }

    public function index(){

        $q = urldecode($this->input->get('q', TRUE)?$this->input->get('q', TRUE):'');
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'brands/?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'brands/?q=' . urlencode($q);
        } else {
            $config['base_url'] =  Backend_URL . 'brands/';
            $config['first_url'] = Backend_URL . 'brands/';
        }

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Brands_model->total_rows($q);
        $brands = $this->Brands_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'brands_data' => $brands,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );

       echo $this->viewAdminContent('brands/index', $data);
    }

    public function read($id){
        $row = $this->Brands_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'parent_id' => $row->parent_id,
		'name' => $row->name,
		'type' => $row->type,
	    );
            $this->viewAdminContent('brands/view', $data);
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_success">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'brands'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'brands/create_action'),
	    'id' => set_value('id'),
	    'parent_id' => set_value('parent_id'),
	    'type_id' => set_value('type_id'),
	    'name' => set_value('name'),
	    'type' => set_value('type'),
	);
        $this->viewAdminContent('brands/form', $data);
    }
    
    public function create_action(){
        $old_data = $this->db->where('slug', slugify($this->input->post('slug',TRUE)))->get('brands')->row();
        if (!empty($old_data)){
            $this->session->set_flashdata('message', '<p class="ajax_error">The slug already in use. please update this</p>');
            redirect(site_url( Backend_URL. 'brands/update/'.$old_data->id));
        } else {
            $data = array(
                'parent_id' => $this->input->post('parent_id',TRUE),
                'name' => $this->input->post('name',TRUE),
                'type' => 'Model',
                'type_id'   => $this->input->post('type_id',TRUE),
                'slug'   => slugify($this->input->post('slug',TRUE))
            );

            $this->Brands_model->insert($data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Create Record Success</p>');
            redirect(site_url( Backend_URL. 'brands'));
        }

    }
    
    public function brand_create_action(){
        //print_r($this->input->post());die();
        $old_data = $this->db->where('slug', slugify($this->input->post('slug',TRUE)))->get('brands')->row();
        if (!empty($old_data)){
            $this->session->set_flashdata('message', '<p class="ajax_error">The slug already in use. please update this</p>');
            redirect(site_url( Backend_URL. 'brands/update/'.$old_data->id));
        } else {
            $type_ids = implode(',', @$this->input->post('type_id'));

            $data = array(
                'name' => $this->input->post('name', TRUE),
                'type' => 'Brand',
                'type_id' => '0,' . $type_ids,
                'slug' => slugify($this->input->post('slug', TRUE))
            );

            $this->Brands_model->insert($data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Brand Added Successfully</p>');
            redirect(site_url(Backend_URL . 'brands'));
        }
        
    }
    
    public function update($id){
        $row = $this->Brands_model->get_by_id($id);

        if ($row) {
            
            if($row->type == 'Model') {
                $data = array(
                    'button' => 'Update',
                    'action' => site_url(Backend_URL . 'brands/update_action'),
                    'id' => set_value('id', $row->id),
                    'parent_id' => set_value('parent_id', $row->parent_id),
                    'type_id' => set_value('type_id', $row->type_id),
                    'name' => set_value('name', $row->name),
                    'type' => set_value('type', $row->type),
                    'slug' => set_value('type', $row->slug),
                );
                $this->viewAdminContent('brands/model', $data);
            } else {
                $data = array(
                    'button' => 'Update',
                    'action' => site_url(Backend_URL . 'brands/brand_update_action'),
                    'id' => set_value('id', $row->id),
                    'parent_id' => set_value('parent_id', $row->parent_id),
                    'type_id' => set_value('type_id', $row->type_id),
                    'name' => set_value('name', $row->name),
                    'type' => set_value('type', $row->type),
                    'slug' => set_value('type', $row->slug),
                );
                $this->viewAdminContent('brands/brand', $data);
            }
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'brands'));
        }
    }
    
    public function brand_update_action(){
        $old_data = $this->db->where('slug', slugify($this->input->post('slug',TRUE)))->where('id !=',$this->input->post('id', TRUE))->get('brands')->row();
        if (!empty($old_data)){
            $this->session->set_flashdata('message', '<p class="ajax_error">Slug Already Exist</p>');
            redirect(site_url(Backend_URL . 'brands'));
        } else {
            $type_ids = implode(',', $this->input->post('type_id'));

            $data = array(
                'name' => $this->input->post('name', TRUE),
                'slug' => $this->input->post('slug', TRUE),
                'type' => 'Brand',
                'type_id' => $type_ids,
            );

            $this->Brands_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Brnad Updated  Successfully</p>');
            redirect(site_url(Backend_URL . 'brands'));
        }
        
    }
    
    public function update_action(){
        $old_data = $this->db->where('slug', slugify($this->input->post('slug',TRUE)))->where('id !=',$this->input->post('id', TRUE))->get('brands')->row();
        if (!empty($old_data)){
            $this->session->set_flashdata('message', '<p class="ajax_error">Slug Already Exist</p>');
            redirect(site_url(Backend_URL . 'brands'));
        } else {
            $data = array(
                'parent_id' => $this->input->post('parent_id', TRUE),
                'type_id' => $this->input->post('type_id', TRUE),
                'name' => $this->input->post('name', TRUE),
                'slug' => $this->input->post('slug', TRUE),
                'type' => 'Model',
            );

            $this->Brands_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Model Name Updated Successfully</p>');
            redirect(site_url(Backend_URL . 'brands'));
        }
        
    }
    
    public function delete($id){
        $row = $this->Brands_model->get_by_id($id);

        if ($row) {
            $this->Brands_model->delete($id);
            $this->session->set_flashdata('message', '<p class="ajax_success">Delete Record Success</p>');
            redirect(site_url( Backend_URL. 'brands'));
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_errorr">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'brands'));
        }
    }



    public function all_brands($vehicle_type_id=1) {
    
        
       return $this->Brands_model->get_all_brand($vehicle_type_id);
       
    }
    
    
    
    
   
    public function sidebarMenus(){
        return buildMenuForMoudle([
            'module'    => 'Manage Brands',
            'icon'      => 'fa-th-list',
            'href'      => 'brands',                    
        ]);
        
    }
  
    
    
    
    //=================
    public function all_brands_by_vehicle($vehicle_type_id = 0, $selected = 0) {
        
        $data_check = $this->db->query("SELECT * FROM `brands` WHERE FIND_IN_SET('$vehicle_type_id',type_id) AND `type`='Brand'")->num_rows();
        
        if($data_check > 0){
            $brnads = $this->db->query("SELECT * FROM `brands` WHERE FIND_IN_SET('$vehicle_type_id',type_id) AND `type`='Brand'")->result();
        } else {
            $brnads = $this->db->query("SELECT * FROM `brands` WHERE `type_id`='$vehicle_type_id' AND `type`='Brand'")->result();
        }

        $option = '<option value="0">--Select Brand--</option>';

        foreach( $brnads as $brand ){
           $option .= '<option value="'. $brand->id .'"'; 
           $option .= ($brand->id == $selected) ? ' selected' : ''; 
           $option .= '>'. $brand->name .'</option>'; 
        }
        
        return $option;      
    }

    public function all_model_by_brand($brand_id = 0, $selected = 0) {
        if ($brand_id == 0) {
            $models = $this->db
                ->get_where('brands', ['type' => 'Model'])
                ->result();
        } else {
            $models = $this->db
                ->get_where('brands', ['parent_id' => $brand_id, 'type' => 'Model'])
                ->result();
        }

        $options  = $this->db->last_query();
        if(count($models) == 0 ){
            $options .= '<option value="0"> No Model Found</option>';
        } else {
            $options  .= '<option value="0">--Select Model--</option>';
        }



        foreach($models as $model ){
            $options .= '<option value="'.$model->id.'" ';
            $options .= ($model->id == $selected) ? ' selected' : '';
            $options .= '>'.$model->name .'</option>';
        }

        return $options;
    }

    public function all_brands_for_automech( $selected = 0, $type_id = 0) {
                
        $this->db->where('type', 'Brand');
        if($type_id){ 
            $this->db->group_start();
            $this->db->like('type_id', $type_id); 
            $this->db->group_end();
        }
        $brnads = $this->db->get('brands')->result();
        
        $option = '';
        foreach( $brnads as $brand ){
           $option .= '<option value="'. $brand->id .'"'; 
           $option .= ($brand->id == $selected) ? ' selected' : ''; 
           $option .= '>'. $brand->name .'</option>'; 
        }        
        return $option;      
    }
    
    public function brands_by_vehicle_model() {
        
        ajaxAuthorized();
        $vehicle_id = $this->input->post('vehicle_type_id',TRUE);
        $brand_id   = $this->input->post('id',TRUE);
                
       //$model_names = $this->db->query("SELECT * FROM `brands` WHERE parent_id='$brand_id' AND type_id='$vehicle_id' AND type='Model'")->result();
       //$models = $this->db->query("SELECT * FROM `brands` WHERE parent_id='$brand_id' AND type_id='$vehicle_id' AND type='Model'")->result();
       $models = $this->db
               ->get_where('brands', ['parent_id' => $brand_id, 'type' => 'Model'])
               ->result();
       
        
        $options  = $this->db->last_query();
        if(count($models) == 0 ){
            $options .= '<option value="0"> No Model Found</option>';
        } else {
           $options  .= '<option value="0">--Select Model--</option>'; 
        }
       
       
       
        foreach($models as $model ){
            $options .= '<option value="'.$model->id.'" ';           
            $options .= '>'.$model->name .'</option>';
        }
        
     
        
        echo  $options;
      
    }

    public function brands_by_vehicle() {

        $vehicle_type_id = $this->input->post('vehicle_type_id',TRUE);
        $selected   = $this->input->post('brand_id',TRUE);

        $data_check = $this->db->query("SELECT * FROM `brands` WHERE FIND_IN_SET('$vehicle_type_id',type_id) AND `type`='Brand'")->num_rows();

        if($data_check > 0){
            $brnads = $this->db->query("SELECT * FROM `brands` WHERE FIND_IN_SET('$vehicle_type_id',type_id) AND `type`='Brand'")->result();
        } else {
            $brnads = $this->db->query("SELECT * FROM `brands` WHERE `type_id`='$vehicle_type_id' AND `type`='Brand'")->result();
        }

        $option = '<option value="0">--Select Brand--</option>';

        foreach( $brnads as $brand ){
            $option .= '<option value="'. $brand->id .'"';
            $option .= ($brand->id == $selected) ? ' selected' : '';
            $option .= '>'. $brand->name .'</option>';
        }

        echo $option;
    }

}