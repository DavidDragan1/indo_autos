<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-12-03
 */

class Parts_frontview extends MX_Controller{
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

    public function widget( $partsDescription = 0 ){

        $html = '<div class="panel panel-default">';
        $html .= '<a class="panel-title collapsed" data-toggle="collapse" data-parent="#filter-result" href="#panel-element-parts">';
        $html .= '<div class="panel-heading">';
        $html .= '<i class="fa fa-flask"></i> Parts Description';
        $html .= '<i class="glyphicon glyphicon-chevron-down"></i>';
        $html .= '</div>';
        $html .= '</a>';

        $html .= '<div id="panel-element-parts" class="panel-collapse collapse">';
        $html .= '<div class="panel-body">';

        $html .= '<select class="form-control select2" style="width: 100%;" id="parts_id" name="parts_description">';    
        if($partsFor){
            $html .= $this->getPartsDescription($partsDescription);
        } else {
            $html .= '<option>Select Parts for </option>';
        }
        
        $html .= '</select>';

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';


        return $html;

    }
    
     public function getPartsDescription( $selected = 0 ){
        $parts = $this->db->get_where('parts_description')->result(); 
        $html = '<option value="0"> Any </option>';                  
        foreach( $parts as $part ) {
            $html .= '<option value="'.$part->id.'"';
             $html .= ($part->id == $selected ) ? ' selected' : '';            
            $html .= '>'.$part->name.'</option>';
        }
        return $html;  
    }
    
    public function widgetPartsFor($partsFor = 0 ){

        $html = '<div class="panel panel-default">';
        $html .= '<a class="panel-title collapsed" data-toggle="collapse" data-parent="#filter-result" href="#panel-element-partsFor">';
        $html .= '<div class="panel-heading">';
        $html .= '<i class="fa fa-flask"></i> Parts For';
        $html .= '<i class="glyphicon glyphicon-chevron-down"></i>';
        $html .= '</div>';
        $html .= '</a>';

        $html .= '<div id="panel-element-partsFor" class="panel-collapse collapse">';
        $html .= '<div class="panel-body">';

        $html .= '<select class="form-control select2" style="width: 100%;" id="parts_for" name="parts_for">';        
        $html .= $this->vehicleType($partsFor);
        $html .= '</select>';

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';


        return $html;
    }
    
    public function widgetCategories( $cat = 0 ){

        $html = '<div class="panel panel-default">';
        $html .= '<a class="panel-title collapsed" data-toggle="collapse" data-parent="#filter-result" href="#panel-element-partsCat">';
        $html .= '<div class="panel-heading">';
        $html .= '<i class="fa fa-flask"></i> Parts Categories';
        $html .= '<i class="glyphicon glyphicon-chevron-down"></i>';
        $html .= '</div>';
        $html .= '</a>';

        $html .= '<div id="panel-element-partsCat" class="panel-collapse collapse">';
        $html .= '<div class="panel-body">';

        $html .= '<select class="form-control select2" style="width: 100%;" id="category_id" name="category_id">';        
        $html .= $this->getCategories($cat);
        $html .= '</select>';

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';


        return $html;

    }
    
    
    
    private function getCategories($selected = 0){    
        $parts = $this->db->get_where('parts_categories')->result();
        
        $html = '<option value="0"> --Any-- </option>';                  
        foreach( $parts as $part ) {
            $html .= '<option value="'.$part->id.'"';
            $html .= ($part->id == $selected ) ? ' selected' : '';            
            $html .= '>'.$part->category.'</option>';
        }
        return $html;        
    }
    private function getpartsFor($selected = 0){        
        $parts = [
            '1' => 'Cars/Vans',
            '3' => 'Motorcycles',
            '7' => 'Trucks/Heavy duty Vehicles',
        ];
        $html = '<option value="0"> Any </option>';                  
        foreach($parts as $key=>$part) {
            $html .= '<option value="'.$key.'"';
            $html .= ($key == $selected ) ? ' selected' : '';            
            $html .= '>'.$part.'</option>';
        }
        return $html;        
    }
    
    private function getparts(){
        
        $id     = intval($this->input->get('color_id'));
	
        $parts = $this->Parts_model->get_all();
        
        $html = '<option value="0"> Any Parts</option>';                  
        foreach($parts as $part) {
            $html .= '<option value="'.$part->id.'"';
            $html .= ($part->id == $id ) ? ' selected' : '';            
            $html .= '>'.$part->name.'</option>';
        }
        return $html;
        
    }
    
    
    public function get_parts_description( $parent_id = 0 ){
      

        // $parts = $this->db->like('parent_id #', $parent_id )->get('parts_description')->result(); 
      
        $parts = $this->db->query( "SELECT * FROM parts_description WHERE parent_id LIKE '%#".$parent_id."#%'" )->result(); 
        //$this->db->last_query();
        $html = '<option value="0"> --Any Description-- </option>';                  
        foreach( $parts as $part ) {
            $html .= '<option value="'.$part->id.'"';
           //  $html .= ($part->id == $selected ) ? ' selected' : '';            
            $html .= '>'.$part->name.'</option>';
        }
        echo $html;  
        
        
    }
    
    public function get_parts_brands( $id = 0 ){
      

        // $parts = $this->db->like('parent_id #', $parent_id )->get('parts_description')->result(); 
      
        $parts = $this->db->query("SELECT * FROM brands where FIND_IN_SET($id,type_id) and type='Brand'")->result(); 
        //$this->db->last_query();
        $html = '<option value="0"> --Any Brand-- </option>';                  
        foreach( $parts as $part ) {
            $html .= '<option value="'.$part->id.'"';
           //  $html .= ($part->id == $selected ) ? ' selected' : '';            
            $html .= '>'.$part->name.'</option>';
        }
        echo $html;  
        
        
    }


    
    private function vehicleType($selected = 0) {
      
        $query = $this->db->get('vehicle_types')->result();

     
        $row = '';
        foreach ($query as $option) {
            $row .= '<option value="' . $option->id . '"';
            $row .= ($selected === $option->id) ? ' selected' : '';
            $row .= '>' . $option->name . '</option>';
        }
        return $row;
    }


}