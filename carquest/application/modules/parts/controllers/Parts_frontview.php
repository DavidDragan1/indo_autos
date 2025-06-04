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

        $html = '<div class="search-product">';
        $html .='<button type="button" id="partDescriptionHeading" data-toggle="collapse" data-target="#partDescriptionCollaps" aria-expanded="false" aria-controls="partDescriptionCollaps">';
        $html .='<span class="image">';
        $html .='<img class="unselect" src="assets/theme/new/images/icons/search/vehicals.png" alt="image">';
        $html .='<img class="select" src="assets/theme/new/images/icons/search/vehicals-h.png" alt="image">';
        $html .='</span>Parts Description<i class="fa fa-angle-right"></i>';
        $html .='</button>';
        $html .='<div id="partDescriptionCollaps" class="collapse" aria-labelledby="partDescriptionHeading" data-parent="#accordionExample">';
        $html .='<div class="search-item">';
        $html .='<div class="select2-wrapper">';
        $html .='<select class="input-style" id="parts_id" name="parts_description">';
        if($partsFor){
            $html .= $this->getPartsDescription($partsDescription);
        } else {
            $html .= '<option>Select Parts for </option>';
        }
        $html .='</select>';
        $html .='</div>';
        $html .='</div>';
        $html .='</div>';
        $html .='</div>';
//
//        $html = '<div class="panel panel-default">';
//        $html .= '<a class="panel-title collapsed" data-toggle="collapse" data-parent="#filter-result" href="#panel-element-parts">';
//        $html .= '<div class="panel-heading">';
//        $html .= '<i class="fa fa-flask"></i> Parts Description';
//        $html .= '<i class="glyphicon glyphicon-chevron-down"></i>';
//        $html .= '</div>';
//        $html .= '</a>';
//
//        $html .= '<div id="panel-element-parts" class="panel-collapse collapse">';
//        $html .= '<div class="panel-body">';
//
//        $html .= '<select class="form-control select2" style="width: 100%;" id="parts_id" name="parts_description">';
//        if($partsFor){
//            $html .= $this->getPartsDescription($partsDescription);
//        } else {
//            $html .= '<option>Select Parts for </option>';
//        }
//
//        $html .= '</select>';
//
//        $html .= '</div>';
//        $html .= '</div>';
//        $html .= '</div>';


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
        $html = '<div class="search-product">';
        $html .='<button type="button" id="vehicleHeading" data-toggle="collapse" data-target="#areaCollaps1" aria-expanded="false" aria-controls="areaCollaps1">';
        $html .='<span class="image">';
        $html .='<img class="unselect" src="assets/theme/new/images/icons/search/vehicals.png" alt="image">';
        $html .='<img class="select" src="assets/theme/new/images/icons/search/vehicals-h.png" alt="image">';
        $html .='</span>Vehicle Type<i class="fa fa-angle-right"></i>';
        $html .='</button>';
        $html .='<div id="areaCollaps1" class="collapse" aria-labelledby="vehicleHeading" data-parent="#accordionExample">';
        $html .='<div class="search-item">';
        $html .='<div class="select2-wrapper">';
        $html .='<select class="input-style" id="parts_for" name="parts_for">';
        $html .= parts_for( $partsFor );;
        $html .='</select>';
        $html .='</div>';
        $html .='</div>';
        $html .='</div>';
        $html .='</div>';

        return $html;
    }
//    public function widgetPartsFor($partsFor = 0 ){
//
//        $html = '<div class="panel panel-default">';
//        $html .= '<a class="panel-title collapsed" data-toggle="collapse" data-parent="#filter-result" href="#panel-element-partsFor">';
//        $html .= '<div class="panel-heading">';
//        $html .= '<i class="fa fa-flask"></i> Vehicle Type';
//        $html .= '<i class="glyphicon glyphicon-chevron-down"></i>';
//        $html .= '</div>';
//        $html .= '</a>';
//
//        $html .= '<div id="panel-element-partsFor" class="panel-collapse collapse">';
//        $html .= '<div class="panel-body">';
//
//        $html .= '<select class="form-control select2" style="width: 100%;" id="parts_for" name="parts_for">';
//        //$html .= $this->vehicleType($partsFor);
//        $html .= parts_for( $partsFor );
//        $html .= '</select>';
//
//        $html .= '</div>';
//        $html .= '</div>';
//        $html .= '</div>';
//
//
//        return $html;
//    }
//
    public function widgetCategories( $cat = 0 ){

        $html = '<div class="search-product">';
        $html .='<button type="button" id="partsCategoryHeading" data-toggle="collapse" data-target="#partsCategoryCollaps1" aria-expanded="false" aria-controls="partsCategoryCollaps1">';
        $html .='<span class="image">';
        $html .='<img class="unselect" src="assets/theme/new/images/icons/search/vehicals.png" alt="image">';
        $html .='<img class="select" src="assets/theme/new/images/icons/search/vehicals-h.png" alt="image">';
        $html .='</span>Parts Categories<i class="fa fa-angle-right"></i>';
        $html .='</button>';
        $html .='<div id="partsCategoryCollaps1" class="collapse" aria-labelledby="partsCategoryHeading" data-parent="#accordionExample">';
        $html .='<div class="search-item">';
        $html .='<div class="select2-wrapper">';
        $html .='<select class="input-style" id="category_id" name="category_id">';
        $html .= $this->getCategories($cat);
        $html .='</select>';
        $html .='</div>';
        $html .='</div>';
        $html .='</div>';
        $html .='</div>';

//
//        $html = '<div class="panel panel-default">';
//        $html .= '<a class="panel-title collapsed" data-toggle="collapse" data-parent="#filter-result" href="#panel-element-partsCat">';
//        $html .= '<div class="panel-heading">';
//        $html .= '<i class="fa fa-flask"></i> Parts Categories';
//        $html .= '<i class="glyphicon glyphicon-chevron-down"></i>';
//        $html .= '</div>';
//        $html .= '</a>';
//
//        $html .= '<div id="panel-element-partsCat" class="panel-collapse collapse">';
//        $html .= '<div class="panel-body">';
//
//        $html .= '<select class="form-control select2" style="width: 100%;" id="category_id" name="category_id">';
//        $html .= $this->getCategories($cat);
//        $html .= '</select>';
//
//        $html .= '</div>';
//        $html .= '</div>';
//        $html .= '</div>';


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
        $html = '<option value="0"> --Any Part Name-- </option>';                  
        foreach( $parts as $part ) {
            $html .= '<option value="'.$part->id.'"';
           //  $html .= ($part->id == $selected ) ? ' selected' : '';            
            $html .= '>'.$part->name.'</option>';
        }
        echo $html; 
    }
    public function get_parts_description2(){
      

        // $parts = $this->db->like('parent_id #', $parent_id )->get('parts_description')->result(); 
      
        $parts = $this->db->query( "SELECT * FROM parts_description WHERE parent_id LIKE '%#1#%' OR parent_id LIKE '%#2#%' OR parent_id LIKE '%#3#%' OR parent_id LIKE '%#7#%'" )->result(); 
        //$this->db->last_query();
        $html = '<option value="0"> --Any Part Name-- </option>';                  
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