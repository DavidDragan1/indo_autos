<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-11-11
 */

class Brands_frontview extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Brands_model');
        $this->load->library('form_validation');
    }


    public function all_brands($type_id=0) {
        $type_id = ( $this->input->get('type_id') )
                    ? intval($this->input->get('type_id'))
                    : $type_id;
        return $brands = $this->db->query("SELECT * FROM brands where FIND_IN_SET($type_id,type_id) and type='Brand'")->result();
    }



    public function model_by_brand() {
        $brand_id = intval( $this->input->post('id'));
        $vehicle_type_id = intval( $this->input->post('vehicle_type_id'));

        $model_names = $this->Brands_model->getModelByBrand($brand_id, $vehicle_type_id);


        $options = '';
        foreach ($model_names as $row) {
            $options .= '<option value="' . $row->id . '" ';
            $options .= '>' . $row->name . '</option>';
        }
        echo $options;
    }


    public function vehicle_widget( ) {

        $page_slug  = $this->uri->segment('1');

        if($page_slug == 'automech-search') {
            $lebel = 'Brand';
        } else {
            $lebel = 'Vehicle';
        }

        $type_id = ($page_slug == 'search')
                        ? intval($this->input->get('type_id'))
                        : GlobalHelper::getTypeIdByPageSlug($page_slug);

        //$type_id = $this->db->get_where('vehicle_types', ['slug'=> $type_id])->row();
        //$html .= $type_id->id;



        $html ='<div class="search-product">';
        $html .='<button type="button" id="vehicleHeading" data-toggle="collapse"';
        $html .='data-target="#vehicleCollaps" aria-expanded="false" aria-controls="vehicleCollaps">';
        $html .='<span class="image">';
        $html .='<img class="unselect" src="assets/theme/new/images/icons/search/new/brand.png" alt="image">';
        $html .='<img class="select" src="assets/theme/new/images/icons/search/new/brand-h.png" alt="image">';
        $html .='</span>'.$lebel.'<i class="fa fa-angle-right"></i>';
        $html .='</button>';
        $html .='<div id="vehicleCollaps" class="collapse" aria-labelledby="vehicleHeading"';
        $html .='data-parent="#accordionExample">';
        $html .='<div class="search-item">';
        if($page_slug != 'automech-search') :
            $html .= $this->getDropVehicleType(  $type_id );
        endif;
        $html .= $this->getDropDownBrands( $type_id, intval($this->input->get('brand_id')) );
        if($page_slug != 'automech-search') :
            $html .= $this->getDropDownModel( intval($this->input->get('brand_id')), intval($this->input->get('model_id')) );
        endif;
        $html .='</div>';
        $html .='</div>';
        $html .='</div>';




//        $html = '<div class="panel panel-default">';
//
//        $html .= '<a class="panel-title collapsed" data-toggle="collapse" data-parent="#filter-result" href="#panel-element-vehicle">';
//        $html .= '<div class="panel-heading">';
//        $html .= '<i class="fa fa-gear" ></i> '. $lebel;
//        $html .= '<span aria-hidden="true" class="glyphicon glyphicon-chevron-down pull-right"></span>';
//        $html .= '</div>';
//        $html .= '</a>';
//
//        $html .= '<div id="panel-element-vehicle" class="panel-collapse collapse in">';
//        $html .= '<div class="panel-body form-group">';
//
//        if($page_slug != 'automech-search') :
//        $html .= $this->getDropVehicleType(  $type_id );
//        endif;
//
//        $html .= $this->getDropDownBrands( $type_id, intval($this->input->get('brand_id')) );
//
//        if($page_slug != 'automech-search') :
//        $html .= $this->getDropDownModel( intval($this->input->get('brand_id')), intval($this->input->get('model_id')) );
//        endif;
//
//        $html .= '</div>';
//        $html .= '</div>';
//        $html .= '</div>';


        return $html;
    }
//    public function vehicle_widget( ) {
//
//        $page_slug  = $this->uri->segment('1');
//
//        if($page_slug == 'automech-search') {
//            $lebel = 'Brand';
//        } else {
//            $lebel = 'Vehicle';
//        }
//
//        $type_id = ($page_slug == 'search')
//                        ? intval($this->input->get('type_id'))
//                        : GlobalHelper::getTypeIdByPageSlug($page_slug);
//
//        //$type_id = $this->db->get_where('vehicle_types', ['slug'=> $type_id])->row();
//        //$html .= $type_id->id;
//
//        $html = '<div class="panel panel-default">';
//
//        $html .= '<a class="panel-title collapsed" data-toggle="collapse" data-parent="#filter-result" href="#panel-element-vehicle">';
//        $html .= '<div class="panel-heading">';
//        $html .= '<i class="fa fa-gear" ></i> '. $lebel;
//        $html .= '<span aria-hidden="true" class="glyphicon glyphicon-chevron-down pull-right"></span>';
//        $html .= '</div>';
//        $html .= '</a>';
//
//        $html .= '<div id="panel-element-vehicle" class="panel-collapse collapse in">';
//        $html .= '<div class="panel-body form-group">';
//
//        if($page_slug != 'automech-search') :
//        $html .= $this->getDropVehicleType(  $type_id );
//        endif;
//
//        $html .= $this->getDropDownBrands( $type_id, intval($this->input->get('brand_id')) );
//
//        if($page_slug != 'automech-search') :
//        $html .= $this->getDropDownModel( intval($this->input->get('brand_id')), intval($this->input->get('model_id')) );
//        endif;
//
//        $html .= '</div>';
//        $html .= '</div>';
//        $html .= '</div>';
//
//
//        return $html;
//    }

    public function getDropVehicleType($selected = 0) {
        $html = '';
        $page_slug  = $this->uri->segment('1');

        $type_id = ($page_slug == 'search')
                        ? intval($this->input->get('type_id'))
                        : GlobalHelper::getTypeIdByPageSlug($page_slug);
        if($type_id) {
            $disabled = 'disabled';
            $html .= '<input type="hidden" name="type_id" value="'. $type_id .'"/>';
        } else {
            $disabled = '';
        }


        $html .= '<div class="select2-wrapper">';
        $html .= '<select class="input-style" '.$disabled.' style="width: 100%;" id="type_id" name="type_id">';
        $html .= '<option value="0">Select Vehicle</option>';

        $vehicles = $this->db->get_where('vehicle_types')->result();

        foreach ($vehicles as $vehicle) {
            $html .= '<option value="' . $vehicle->id . '"';
            $html .= ($vehicle->id == $selected ) ? ' selected="selected"' : '';
            $html .= '>' . $vehicle->name . '</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        return $html;
    }
    public function getDropOptionVehicleType($selected = 0) {
        $html = '';
        $page_slug  = $this->uri->segment('1');

        $type_id = ($page_slug == 'search')
            ? intval($this->input->get('type_id'))
            : GlobalHelper::getTypeIdByPageSlug($page_slug);
        if($type_id) {
            $disabled = 'disabled';
            $html .= '<input type="hidden" name="type_id" value="'. $type_id .'"/>';
        } else {
            $disabled = '';
        }


        $html .= '<div class="select2-wrapper">';
        $html .= '<select class="input-style" '.$disabled.' style="width: 100%;" id="type_id" name="type_id">';
        $html .= '<option value="0">Select Vehicle</option>';

        $vehicles = $this->db->get_where('vehicle_types')->result();

        foreach ($vehicles as $vehicle) {
            $html .= '<option value="' . $vehicle->id . '"';
            $html .= ($vehicle->id == $selected ) ? ' selected="selected"' : '';
            $html .= '>' . $vehicle->name . '</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        return $html;
    }

    public function getDropDownBrands($type_id = 0, $id = 0) {
        // dd($brands=$this->all_brands());
        $html = '';

        $brands = $this->all_brands( $type_id );
        $html .= '<div class="model">';
        $html .= '<div class="select2-wrapper">';
        $html .= '<select class="input-style" id="brand_id" name="brand_id">';


        $html .= ($id) ? '<option value="0">--Any Brand--</option>' : '<option value="0">Select Vehicle </option>';
        foreach ($brands as $brand) {
            $html .= '<option value="' . $brand->id . '"';
            $html .= ($id == $brand->id ) ? ' selected="selected"' : '';
            $html .= '>' . $brand->name . '</option>';
        }
        $html .= '</select>';
         $html .= '</div>';
         $html .= '</div>';
        return $html;
    }

    // not required
    public function getDropDownModel( $model_id = 0, $selected = 0) {



            $brand_id   =  intval( $this->input->get('brand_id') );

            $brands     = $this->db->get_where('brands', ['parent_id' => $brand_id, 'type' => 'Model'])->result();

            $html  = '';
            $html  .= '<div class="select2-wrapper">';
            $html .= '<select class="input-style"  id="model_id" name="model_id">';

            $html .= ($model_id) ? '<option value="0">--Any Model--</option>' : '<option value="0">Select Model </option>';
            foreach ($brands as $brand) {
                $html .= '<option value="' . $brand->id . '"';
                $html .= ($selected == $brand->id ) ? ' selected="selected"' : '';
                $html .= '>' . $brand->name . '</option>';
            }
            $html .= '</select>';
            $html .= '</div>';
            return $html;


    }


    //=================

    public function get_brands_by_vechile( $selected = 0) {
        $vehicle_type_id = $this->input->get('type_id');
        $brands          = $this->db->query("SELECT * FROM brands where FIND_IN_SET('$vehicle_type_id',type_id) and type='Brand'")->result();

        $options = '';
        $options .= '<option selected disabled value="">Select Brand</option>';
        foreach ($brands as $row) {
            $options .= '<option value="' . $row->id . '" ';
            $options .= ($row->id = $selected) ? ' selected="selected"' : '';
            $options .= '>' . $row->name . '</option>';
        }
        echo $options;
    }

    public function all_brands_by_vehicle($vehicle_type_id) {
        return $this->db->query("SELECT * FROM brands WHERE FIND_IN_SET('$vehicle_type_id',type_id) and type='Brand'")->result();
    }

    public function brands_by_vehicle_model($selected = 0) {
        ajaxAuthorized();

        $type_id    = $this->input->get('type_id', TRUE);
        $brand_id   = $this->input->get('brand_id', TRUE);

        $models     = $this->db->from('brands')
                            ->where('parent_id',$brand_id)
                            ->where('type', 'Model')
                            ->get()
                            ->result();

        $options    = '<option value="">Select Model</option>';

        foreach ($models as $model) {
            $options .= '<option value="' . $model->id . '" ';
            $options .= ($model->id == $selected) ? ' selected="selected"' : '';
            $options .= '>' . $model->name . '</option>';
        }
        echo $options;
    }

    public function brands_by_vehicle_model_multiple($selected = [])
    {
        ajaxAuthorized();

        $type_id    = $this->input->post('type_id', TRUE);
        $brand_id   = $this->input->post('brand_id', TRUE);

        $models  = $this->db->from('brands')
            ->where_in('parent_id',$brand_id)
            ->where('type', 'Model')
            ->get()
            ->result();
        $options = '';
        if (empty($models)){
            $options    .= '<option selected disabled value="">Select Model</option>';
        }


        foreach ($models as $model) {
            $options .= '<option value="' . $model->id . '" ';
            $options .= (($model->id == $selected) || empty($selected) )? ' selected="selected"' : '';
            $options .= '>' . $model->name . '</option>';
        }
        echo $options;
    }
    public function brands_by_vehicle_model_select($selected = 0) {
        ajaxAuthorized();

        $type_id    = $this->input->get('type_id', TRUE);
        $brand_slug   = $this->input->get('id', TRUE);

        $models     = $this->db->select('brands.*')
            ->from('brands')
            ->join('brands as parent', 'parent.id = brands.parent_id')
            ->where('parent.slug',$brand_slug)
            ->where('brands.type', 'Model')
            ->get()
            ->result();
        $options    = '<option value="" selected>Model</option>';

        foreach ($models as $model) {
            $options .= '<option value="' . $model->slug . '" ';
            $options .= ($model->slug === $selected) ? ' selected="selected"' : '';
            $options .= '>' . $model->name . '</option>';
        }
        echo $options;
    }


    // using for  diagonistic



    public function getDropDownBrands_view($type_id = 0, $id = 0) {
        // dd($brands=$this->all_brands());
        $html = '';

        $brands = $this->all_brands( $type_id );
        $html .= '<div class="model">';
        $html .= '<div class="select2-wrapper">';
        $html .= '<select class="form-control select2" style="width: 100%;" id="brand_id" name="brand_id">';


        $html .= ($id) ? '<option value="0">--Any Brand--</option>' : '<option value="0">Select Vehicle </option>';
        foreach ($brands as $brand) {
            $html .= '<option value="' . $brand->id . '"';
            $html .= ($id == $brand->id ) ? ' selected="selected"' : '';
            $html .= '>' . $brand->name . '</option>';
        }
        $html .= '</select>';
         $html .= '</div>';
         $html .= '</div>';
        echo $html;
    }

    // not required
    public function getDropDownModel_view( $model_id = 0, $selected = 0) {



            $brand_id   =  intval( $this->input->get('brand_id') );

            $brands     = $this->db->get_where('brands', ['parent_id' => $brand_id, 'type' => 'Model'])->result();

            $html  = '';
            $html  .= '<div class="select2-wrapper">';
            $html .= '<select class="form-control select2" style="width: 100%;" id="model_id" name="model_id">';

            $html .= ($model_id) ? '<option value="0">--Any Model--</option>' : '<option value="0">Select Model </option>';
            foreach ($brands as $brand) {
                $html .= '<option value="' . $brand->id . '"';
                $html .= ($selected == $brand->id ) ? ' selected="selected"' : '';
                $html .= '>' . $brand->name . '</option>';
            }
            $html .= '</select>';
            $html .= '</div>';
            echo  $html;


    }


    // using  for api
    public function all_brands_by_vehicle_api($vehicle_type_id = 0) {
        $data_check = $this->db->query("SELECT id, name FROM `brands` WHERE FIND_IN_SET('$vehicle_type_id',type_id) AND `type`='Brand'")->num_rows();
        if($data_check > 0){
            $brnads = $this->db->query("SELECT id, name FROM `brands` WHERE FIND_IN_SET('$vehicle_type_id',type_id) AND `type`='Brand'")->result();
        } else {
            $brnads = $this->db->query("SELECT id, name FROM `brands` WHERE `type_id`='$vehicle_type_id' AND `type`='Brand'")->result();
        }
        return $brnads;
    }

    public function brands_by_vehicle_model_api($brand_id = 0 ) {
         $models = $this->db
               ->get_where('brands', ['parent_id' => $brand_id, 'type' => 'Model'])
               ->result();
        return   $models;
    }









}

/*
 *    public function model_widget() {

        $html = '<div class="panel panel-default">';

        $html .= '<a class="panel-title collapsed" data-toggle="collapse" data-parent="#filter-result" href="#panel-element-model">';
        $html .= '<div class="panel-heading">';
        $html .= 'Model';
        $html .= '<span aria-hidden="true" class="glyphicon glyphicon-chevron-down pull-right"></span>';
        $html .= '</div>';
        $html .= '</a>';

        $html .= '<div id="panel-element-model" class="panel-collapse collapse">';
        $html .= '<div class="panel-body form-group">';

        $html .= '<select class="form-control select2" style="width: 100%;" id="model" name="model_id">';

        $html .= '<option value="0">Select Any Model</option>';

        $models = $this->all_brands_model();

        foreach ($models as $model) {
            $html .= '<option value="' . $model->id . '">' . $model->name . '</option>';
        }

        $html .= '</select>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

 */
