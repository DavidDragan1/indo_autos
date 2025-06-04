<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-18
 */

class Engine_sizes_frontview extends MX_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Engine_sizes_model');        
        $this->load->library('form_validation');
    }

    public function size_list() {
        return  $this->Engine_sizes_model->get_all();
    }
    

    public function widget(){
        $html = '<div class="search-product">';
        $html .= '<button type="button" id="engineHeading" data-toggle="collapse"';
        $html .= 'data-target="#engineCollaps" aria-expanded="false" aria-controls="engineCollaps">';
        $html .= ' <span class="image">';
        $html .= '<img class="unselect" src="assets/theme/new/images/icons/search/engine.png" alt="image">';
        $html .= '<img class="select" src="assets/theme/new/images/icons/search/engine-h.png" alt="image">';
        $html .= '</span>Engine Size<i class="fa fa-angle-right"></i>';
        $html .= '</button>';
        $html .= '<div id="engineCollaps" class="collapse" aria-labelledby="engineHeading" data-parent="#accordionExample">';
        $html .= '<div class="search-item">';
        $html .= '<div class="select2-wrapper">';
        $html .= '<select class="input-style" id="engine_size" name="engine_size">';
        $html .= '<option value="0">Select Any Engine Size</option>';
        $engine_sizes=$this->size_list();
        foreach($engine_sizes as $engine_size) {
            $html .= '<option value="'.$engine_size->id.'">'.$engine_size->engine_size.'</option>';
        }
        $html .= ' </select>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;

    }

}