<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-18
 */

class Vehicle_types_frontview extends MX_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Vehicle_types_model');        
        $this->load->library('form_validation');
    }


    
    public function vehicle_list(){
	 return $this->Vehicle_types_model->get_all();
    }
    
     public function widget(){

        $html = '<div class="panel panel-default">';

        $html .= '<a class="panel-title collapsed" data-toggle="collapse" data-parent="#filter-result" href="#panel-element-vehicle">';
        $html .= '<div class="panel-heading">';
        $html .= 'Vehicle';
        $html .= '<span aria-hidden="true" class="glyphicon glyphicon-chevron-down pull-right"></span>';
        $html .= '</div>';
        $html .= '</a>';

        $html .= '<div id="panel-element-vehicle" class="panel-collapse collapse">';
        $html .= '<div class="panel-body form-group">';

        $html .= '<select class="form-control select2" style="width: 100%;" id="vehicle_type" name="type_id">';

        $html .= '<option value="0">Select any Vehicle</option>';
        
        //dd($brands=$this->all_brands());
        $vehicles = $this->vehicle_list();
        
        foreach($vehicles as $vehicle) {
            $html .= '<option value="'.$vehicle->id.'">'.$vehicle->name.'</option>';
        }
        
        $html .= '</select>';

        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;

    }
    
     
    
    
     public function services( $service_id = 0 ){
         $html = '<div class="search-product">';
         $html .= '<button type="button" id="serviceHeading" data-toggle="collapse" data-target="#serviceCollaps"
                                        aria-expanded="false" aria-controls="serviceCollaps">';
         $html .= '<span class="image">';
         $html .= '<img class="unselect" src="assets/theme/new/images/icons/search/new/service.png" alt="image">';
         $html .= '<img class="select" src="assets/theme/new/images/icons/search/new/service-h.png" alt="image">';
         $html .= '</span>Services<i class="fa fa-angle-right"></i>';
         $html .= '</button>';
         $html .= '<div id="serviceCollaps" class="collapse" aria-labelledby="serviceHeading" data-parent="#accordionExample">';
         $html .= '<div class="search-item">';
         $html .= '<div class="select2-wrapper">';
         $html .= '<select class="input-style" id="towing_service_id" name="towing_service_id">';
         $html .= GlobalHelper::towing_services($service_id);
         $html .= '</select>';
         $html .= '</div>';
         $html .= '</div>';
         $html .= '</div>';
         $html .= '</div>';

        return $html;
    }
     public function vehicle_types( $vehicle_type = 0 ){
         $html ='<div class="search-product">';
         $html .= '<button type="button" id="vehicle_typeHeading" data-toggle="collapse" data-target="#vehicle_typeCollaps" aria-expanded="false" aria-controls="vehicle_typeCollaps">';
         $html .= '<span class="image">';
         $html .= '<img class="unselect" src="assets/theme/new/images/icons/search/vehicals.png" alt="image">';
         $html .= '<img class="select" src="assets/theme/new/images/icons/search/vehicals-h.png" alt="image">';
         $html .= '</span>Vehicle Types<i class="fa fa-angle-right"></i>';
         $html .= '</button>';
         $html .= '<div id="vehicle_typeCollaps" class="collapse" aria-labelledby="vehicle_typeHeading" data-parent="#accordionExample">';
         $html .= '<div class="search-item">';
         $html .= '<div class="select2-wrapper">';
         $html .= '<select class="input-style" id="vehicle_type" name="vehicle_type">';
         $html .= GlobalHelper::getDropDownVehicleTypeTowing($vehicle_type);
         $html .= '</select>';
         $html .= '</div>';
         $html .= '</div>';
         $html .= '</div>';
         $html .= '</div>';

        return $html;
    }
    
    
     public function type_of_services( $type_of_service = 0 ){
         $html = '<div class="search-product">';
         $html .= '<button type="button" id="type_of_serviceHeading" data-toggle="collapse" data-target="#type_of_serviceCollaps"';
         $html .= 'aria-expanded="false" aria-controls="type_of_serviceCollaps">';
         $html .= '<span class="image">';
         $html .= '<img class="unselect" src="assets/theme/new/images/icons/search/new/service.png" alt="image">';
         $html .= '<img class="select" src="assets/theme/new/images/icons/search/new/service-h.png" alt="image">';
         $html .= '</span>Type Of service <i class="fa fa-angle-right"></i>';
         $html .= '</button>';
         $html .= '<div id="type_of_serviceCollaps" class="collapse" aria-labelledby="type_of_serviceHeading"';
         $html .= ' data-parent="#accordionExample">';
         $html .= '<div class="search-item">';
         $html .= '<div class="select2-wrapper">';
         $html .= '<select class="input-style" id="type_of_service" name="type_of_service">';
         $html .= GlobalHelper::towing_type_of_services($type_of_service);
         $html .= '</select>';
         $html .= '</div>';
         $html .= '</div>';
         $html .= '</div>';
         $html .= '</div>';

        return $html;

    }
    
     public function availability( $availability = 0 ){
         $html = '<div class="search-product">';
         $html .= '<button type="button" id="availabilityHeading" data-toggle="collapse" data-target="#availabilityCollaps"';
         $html .= 'aria-expanded="false" aria-controls="availabilityCollaps">';
         $html .= '<span class="image">';
         $html .= '<img class="unselect" src="assets/theme/new/images/icons/search/new/availability.png" alt="image">';
         $html .= '<img class="select" src="assets/theme/new/images/icons/search/new/availability-h.png" alt="image">';
         $html .= '</span>Availability <i class="fa fa-angle-right"></i>';
         $html .= '</button>';
         $html .= '<div id="availabilityCollaps" class="collapse" aria-labelledby="availabilityHeading"';
         $html .= ' data-parent="#accordionExample">';
         $html .= '<div class="search-item">';
         $html .= '<div class="select2-wrapper">';
         $html .= '<select class="input-style" id="availability" name="availability">';
         $html .= GlobalHelper::getDropDownAvailability($availability);
         $html .= '</select>';
         $html .= '</div>';
         $html .= '</div>';
         $html .= '</div>';
         $html .= '</div>';

        return $html;
    }
}
