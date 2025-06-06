<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-11-16
 */

class Post_area_frontview extends MX_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Post_area_model');
    }

//    public function index(){
//
//        $html = '<div class="panel panel-default" style="border-top: 1px solid #d2d2d2 !important">';
//
//        $html .= '<a class="panel-title collapsed" data-toggle="collapse" data-parent="#filter-result" href="#panel-area-id">';
//        $html .= '<div class="panel-heading">';
//        $html .= '<i class="fa fa-map-o"></i> Area';
//        $html .= '<span aria-hidden="true" class="glyphicon glyphicon-chevron-down pull-right"></span>';
//        $html .= '</div>';
//        $html .= '</a>';
//
//        $html .= '<div id="panel-area-id" class="panel-collapse collapse">';
//        $html .= '<div class="panel-body form-group">';
//
//        $html .= '<select class="form-control select2" style="width: 100%;" id="location_id" name="location_id">';
//        $html .= GlobalHelper::all_location( $this->input->get('area') );
//        $html .= '</select>';
//
//        $html .= '</div>';
//        $html .= '</div>';
//        $html .= '</div>';
//
//        return $html;
//
//    }
    public function index(){
        //dd($this->input->get('location_id'));
        $html = '<div class="search-product">';
        $html .='<button type="button" id="areaHeading" data-toggle="collapse" data-target="#areaCollaps" aria-expanded="false" aria-controls="areaCollaps">';
        $html .='<span class="image">';
        $html .='<img class="unselect" src="assets/theme/new/images/icons/search/location.png" alt="image">';
        $html .='<img class="select" src="assets/theme/new/images/icons/search/location-h.png" alt="image">';
        $html .='</span>Area<i class="fa fa-angle-right"></i>';
        $html .='</button>';
        $html .='<div id="areaCollaps" class="collapse" aria-labelledby="areaHeading" data-parent="#accordionExample">';
        $html .='<div class="search-item">';
        $html .='<div class="select2-wrapper">';
        $html .='<select class="input-style" id="location_id" name="location_id" onchange="getCity()">';
        $html .= GlobalHelper::all_location( $this->input->get('location_id') );
        $html .='</select>';
        $html .='</div>';
        $html .='</div>';
        $html .='</div>';
        $html .='</div>';
        return $html;
    }


    public function get_state_by_country($selected = 0)
    {
        $countryId = $this->input->get('countryId');
        $countries      = $this->db->query("SELECT * FROM post_area WHERE country_id = '$countryId' AND type='state'")->result();
        $options = '';
        $options .= '<option value="">Select State</option>';
        foreach ($countries as $row) {
            $options .= '<option value="' . $row->id . '" ';
            $options .= ($row->id == $selected) ? ' selected="selected"' : '';
            $options .= '>' . $row->name . '</option>';
        }
        echo $options;
    }

    public function get_state_by_country_slug($selected = 0)
    {
        $countrySlug = $this->input->get('countrySlug');
        $countryId = $this->db->select('id')->get_where('countries',['slug'=>$countrySlug])->row()->id;
        $countries      = $this->db->query("SELECT * FROM post_area WHERE country_id = '$countryId' AND type='state'")->result();
        $options = '';
        $options .= '<option value="">Select State</option>';
        foreach ($countries as $row) {
            $options .= '<option value="' . $row->slug . '" ';
            $options .= ($row->id = $selected) ? ' selected="selected"' : '';
            $options .= '>' . $row->name . '</option>';
        }
        echo $options;
    }

    public function location_for_profile(){
        $location_id = explode(",", $this->input->get('location_id'));
        $state_id = explode(",", $this->input->get('state_id'));
        echo GlobalHelper::location_for_profile($location_id, $state_id);
    }

}
