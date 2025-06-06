<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-18
 */

class Body_types_frontview extends MX_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Body_types_model');                
    }

    
    
    public function type_list() {
        return  $this->Body_types_model->get_all();
    }
    
    
 

    public function widget($selected = 0){
        $html ='<div class="search-product">';
        $html .='<button type="button" id="bodyTypeHeading" data-toggle="collapse"';
        $html .='data-target="#bodyTypeCollaps" aria-expanded="false" aria-controls="bodyTypeCollaps">';
        $html .='<span class="image">';
        $html .='<img class="unselect" src="assets/theme/new/images/icons/search/body.png" alt="image">';
        $html .='<img class="select" src="assets/theme/new/images/icons/search/body-h.png" alt="image">';
        $html .='</span>Body Types<i class="fa fa-angle-right"></i>';
        $html .='</button>';
        $html .='<div id="bodyTypeCollaps" class="collapse" aria-labelledby="bodyTypeHeading"';
        $html .='data-parent="#accordionExample">';
        $html .='<div class="search-item">';
        $html .='<div class="select2-wrapper">';
        $html .= '<select class="input-style" id="body_type" name="body_type">';
        $html .= '<option value="0">Select Any Body Type</option>';
        $body_types=$this->type_list();
        foreach($body_types as $body_type) {
            $html .= '<option value="' . $body_type->id . '" ';
            $html .= ($body_type->id == $selected ) ? 'selected="selected"' : '';
            $html .= '>' . $body_type->type_name . '</option>';
        }
        $html .= '</select>';
        $html .='</div>';
        $html .='</div>';
        $html .='</div>';
        $html .='</div>';

        return $html;

    }

}