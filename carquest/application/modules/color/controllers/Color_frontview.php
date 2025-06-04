<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-18
 */

class Color_frontview extends MX_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Color_model');        
        $this->load->library('form_validation');
    }


    private function getColors(){
        
        $id     = intval($this->input->get('color_id'));
	
        $colors = $this->Color_model->get_all();
        
        $html = '<option value="0"> Any Color</option>';                  
        foreach($colors as $color) {
            $html .= '<option value="'.$color->id.'"';
            $html .= ($color->id == $id ) ? ' selected' : '';            
            $html .= '>'.$color->color_name.'</option>';
        }
        return $html;
        
    }


    public function widget(){

        $html ='<div class="search-product">
            <button type="button" id="colorHeading" data-toggle="collapse"
                    data-target="#colorCollaps" aria-expanded="false" aria-controls="colorCollaps">
                                    <span class="image">
                                        <img class="unselect" src="assets/theme/new/images/icons/search/color.png" alt="image">
                                        <img class="select" src="assets/theme/new/images/icons/search/color-h.png" alt="image">
                                    </span>
        Colors
                <i class="fa fa-angle-right"></i>
            </button>
            <div id="colorCollaps" class="collapse" aria-labelledby="colorHeading"
                 data-parent="#accordionExample">
                <div class="search-item">
                <div class="select2-wrapper">
                    <select class="input-style" id="color_id" name="color_id">';
        $html .= $this->getColors();
        $html .= '</select>
                </div>
                </div>
            </div>
        </div>';


        return $html;

    }
    

}