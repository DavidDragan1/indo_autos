<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-18
 */

class Fuel_types_frontview extends MX_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Fuel_types_model');
    }


    private function fuel_list( $id = 0, $option_name = 'Any') {
        $fuels =  $this->Fuel_types_model->get_all();        
        $html = '<option value="0">'.$option_name.'</option>';
        foreach($fuels as $fuel) {
            $html .= '<option value="'.$fuel->id.'"';
            $html .= ($fuel->id == $id ) ? ' selected' : '';
            $html .= '>'.$fuel->fuel_name.'</option>';
        }

        return $html;
    }

    public function widget(){
        $html = '<div class="search-product">';
        $html .= '<button type="button" id="fuelHeading" data-toggle="collapse" data-target="#fuelCollaps"';
        $html .= 'aria-expanded="false" aria-controls="fuelCollaps">';
        $html .= '<span class="image">';
        $html .= '<img class="unselect" src="assets/theme/new/images/icons/search/fuel.png" alt="image">';
        $html .= '<img class="select" src="assets/theme/new/images/icons/search/fuel-h.png" alt="image">';
        $html .= '</span>Fuel Types<i class="fa fa-angle-right"></i>';
        $html .= '</button>';
        $html .= '<div id="fuelCollaps" class="collapse" aria-labelledby="fuelHeading" data-parent="#accordionExample">';
        $html .= '<div class="search-item">';
        $html .= '<div class="select2-wrapper">';
        $html .= '<select class="input-style" id="fuel_type" name="fuel_type">';
        $html .= $this->fuel_list();
        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;

    }
    
    
    public function widget_home(){

        $html = '<div class="select2-wrapper">';
        $html .= '<select class="input-style" style="width: 100%;" id="fuel_type" name="fuel_type">';
        $html .= $this->fuel_list(0, 'Any Fuel Type');
        $html .= '</select>';
        $html .= '</div>';

        return $html;

    }

}