<?php

use Illuminate\Database\Capsule\Manager as DB;


function getFeatImageById($post_id = null) {
    $photo = 'no-photo.jpg';
    if ($post_id) {
        $CI         =& get_instance();
        $post_id    = intval($post_id);
        $result     = $CI->db->select('photo')                        
                        ->get_where('post_photos', ['post_id' => $post_id, 'featured' => 'Yes'])                        
                        ->row();
        
        $photo      = isset($result->photo) ? $result->photo : 'no-photo.jpg';
    }
    
    return $photo;
}

function getUserById($id = null) {
    $CI      =& get_instance();
    $user_id = intval($id);
    
    return $user = $CI->db->select('*')->get_where('users', [ 'id' => $id ])->row();
}

function getUserName( $id = 0 ){
    $user = getUserById($id);
    if($user){        
        return $user->first_name . ' '. $user->last_name;
    } else {
        return 'User not found';
    }
    
}


function getVehiclesOfUserById($id = null, $post_id = null, $limit = 5) {
    $CI = & get_instance();
    $id = intval($id);
    $post_id = intval($post_id);
    $limit = intval($limit);
    return $vehicles = $CI->db
            ->select('id, title, priceinnaira, pricein, post_slug')
            ->get_where('posts', ['user_id ' => $id, 'id !=' => $post_id], $limit)
            ->result();
}



function deadline( $post_date, $expire_date = null ){
    
    $today = date('Y-m-d', strtotime('+1 day'));
    
    $day_limit  = dayCalculator( $post_date, $expire_date );
    
     
    if($expire_date == null or $expire_date == '0000-00-00'){
        $age = 'Unknown';
        $progress = 10;
    } elseif(  $today >= $expire_date  ) {
        $age = 'Expird';
        $progress = 100;
    } else {        
       $age =  dayCalculator( $post_date, null );
       $progress = ($age) ?  ceil(( $age / $day_limit ) * 100 ) : 15;
        //$progress = ($progress >= 20 ) ? $age : 90;
	   
    }
    
        if($progress >= 80) { $progress_bar = 'progress-bar-danger'; } 
    elseif($progress >= 50) { $progress_bar = 'progress-bar-warning'; } 
                      else { $progress_bar = 'progress-bar-info'; }

                
    $html = '';
    $html .=  '<small> '.$age .' / '. $day_limit .' days </small>';
    $html .= '<div class="progress" style="height:8px;">';
    $html .= '<div class="progress-bar progress-xs '. $progress_bar .'"
                    role="progressbar" 
                    aria-valuenow="40"
                    aria-valuemin="0" 
                    aria-valuemax="100" 
                    style="width:'. $progress .'%">';    
   
    $html .= '</div>';        
    //$html .= '<div class="progress-bar progress-bar-danger" style="width:30%"> 30 days </div>';
    $html .= '</div>'; 
    
    $html .= '<p>';
    $html .= '<b class="pull-left">'. globalDateFormat($post_date) . '</b>';
    $html .= '<b class="pull-right">'. globalDateFormat($expire_date) . '</b>';    
    $html .= '</p>';
    return $html;
}

function dayCalculator( $from = null, $to = null ){ 
   
    $to = is_null($to) ? 'now' : $to;
   if($from){ 
       
        $from = date('Y-m-d', strtotime($from));        
        $tz  = new DateTimeZone('Europe/London');
        $age = DateTime::createFromFormat('Y-m-d', $from, $tz)
                        ->diff(new DateTime($to, $tz));        
        return $age->days;        
   } else {
       return 0;
   }        
}


/* function getUserContactById($id= null){
  $CI =& get_instance();
  $id  = intval($id);
  $user=$CI->db->select('contact')->from('users')->where('id ',$id)->get()->row();
  return $user->contact;
  } */

function getImagesById($post_id = null) {
    $CI = & get_instance();
    $post_id = intval($post_id);
    return $photos = $CI->db
            ->select('*')
            ->get_where('post_photos', ['post_id' => $post_id])
            ->result();
}

function listing_type($selected = NULL) {
    $types = [
        'Business' => 'Trade Seller',
        'Personal' => 'Private Seller',
    ];

    $options = '<option value="0">Please Select</option>';
    foreach ($types as $key => $row) {
        $options .= '<option value="' . $key . '" ';
        $options .= ($key == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $row . '</option>';
    }
    return $options;
}



function advert_type($selected = NULL) {
    $ci = & get_instance();
   // $settings = $ci->db->get_where('')->result();
    $types = [
        'Free' => 'Free  Membership ₦0',
       // 'Regular' => 'Featured listing ₦'.get_option('RegularPrice'),
      //  'Featured' => 'Featured listing ₦'.get_option('FeaturedPrice')
    ];


    $options = '';
    foreach ($types as $key => $row) {
        $options .= '<option value="' . $key . '" ';
        $options .= ($key == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $row . '</option>';
    }
    return $options;
}
//function get_option($value){		
//		$option =  DB::table('settings')
//			 ->select('*')
//			 ->where('label', '=', $value)
//			 ->first();
//		return $option->value;		
//	}


function service_history($selected = NULL) {
    $services = [
        '1' => 'First service is not due',
        '2' => 'Full service history',        
        '3' => 'Part service history',
        '4' => 'No service history',
    ];

    $options = '';
    foreach ($services as $key => $row) {
        $options .= '<option value="' . $key . '" ';
        $options .= ($key == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $row . '</option>';
    }
    return $options;
}





function owners($selected = NULL) {
    $owners = [
        '1' => '1st',
        '2' => '2nd',
        '3' => '3rd',
        '4' => '4th',
        '5' => '5th',
        '6' => '6th',
        '7' => '7th',
    ];


    $options = '';
    foreach ($owners as $key => $row) {
        $options .= '<option value="' . $key . '" ';
        $options .= ($key == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $row . '</option>';
    }
    return $options;
}

function car_age($selected = NULL) {
    $ages = [
        '0' => '0 years old',
        '1' => '1 years old',
        '2' => '2 years old',
        '3' => '3 years old',
        '4' => '4 years old',
        '5' => '5 years old',
        '6' => '6 years old',
        '7' => '7 years old',
        '8' => '8 years old',
        '9' => '9 years old',
        '10' => '10 years old',
        '11' => 'More than 10 years old',
    ];


    $options = '';
    foreach ($ages as $key => $row) {
        $options .= '<option value="' . $key . '" ';
        $options .= ($key == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $row . '</option>';
    }
    return $options;
}

function getColorNameById($id) {
    $CI = & get_instance();
    $color_id = intval($id);
    if ($result = $CI->db->select('color_name')->from('color')->where('id ', $color_id)->get()->row()) {
        return $result->color_name;
    }
    return "No Data";
}

function getFuelNameById($id) {
    $CI = & get_instance();
    $fuel_id = intval($id);
    if ($result = $CI->db->select('fuel_name')->from('fuel_types')->where('id ', $fuel_id)->get()->row()) {
        return $result->fuel_name;
    }
    return "No Data";
}

function getBrandNameById($id) {
    $CI = & get_instance();
    $brand_id = intval($id);
    if ($result = $CI->db->select('name')->from('brands')->where('id ', $brand_id)->get()->row()) {
        return $result->name;
    }
    return "No Data";
}

function getModelNameById($model_id = null, $parent_id = null) {
    $CI = & get_instance();
    $color_id = intval($model_id);
    if ($result = $CI->db->select('name')->from('brands')->where('parent_id ', $parent_id)->where('id ', $model_id)->get()->row()) {
        return $result->name;
    }
    return "No Data";
}

function getCarAgeById($id) {
    $ages = [
        '0' => '0 years old',
        '1' => '1 years old',
        '2' => '2 years old',
        '3' => '3 years old',
        '4' => '4 years old',
        '5' => '5 years old',
        '6' => '6 years old',
        '7' => '7 years old',
        '8' => '8 years old',
        '9' => '9 years old',
        '10' => '10 years old',
        '11' => 'More than 10 years old',
    ];
    $options = '';
    foreach ($ages as $key => $row) {
        $options .= ($key == $id ) ? $row : '';
    }
    return $options;
}

function getOwnerById($id) {
    $owners = [
        '1' => '1st',
        '2' => '2nd',
        '3' => '3rd',
        '4' => '4th',
        '5' => '5th',
        '6' => '6th',
        '7' => '7th',
    ];
    $options = '';
    foreach ($owners as $key => $row) {
        $options .= ($key == $id ) ? $row : '';
    }
    return $options;
}

function getProductTypeById($id) {
    $CI = & get_instance();
   
    //$row = $CI->db->query("SELECT name FROM vehicle_types WHERE id='$id'")->row();
    $result = $CI->db->select('name')->get_where('vehicle_types', ['id' => $id])->row();
    return ($result) ? $result->name : '';
}

function getAllowWheelById($key = 0 ) {
    $key = intval($key);
    $wheels = [
        '0' => 'Undefined',
        '1' => '13" Alloy Wheels',
        '2' => '14" Alloy Wheels',
        '3' => '15" Alloy Wheels',
        '4' => '16" Alloy Wheels',
        '5' => '17" Alloy Wheels',
        '6' => '18" Alloy Wheels',
        '7' => '19" Alloy Wheels',
    ];

    return isset($wheels[$key]) ? $wheels[$key] : $wheels[0];
}

function getServiceHistoryById($id) {
    $services = [
        'first-service-is-not-due' => 'First service is not due',
        'full-service-history' => 'Full service history',
        'no-service-history' => 'No service history',
        'part-service-history' => 'Part service history',
    ];

    $options = '';
    foreach ($services as $key => $row) {
        $options .= ($key == $id ) ? $row : '';
    }
    return $options;
}

function getSeatById($id) {
    $seats = [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => 'More that 10',
    ];
    $options = '';
    foreach ($seats as $key => $row) {
        $options .= ($key == $id ) ? $row : '';
    }
    return $options;
}

function hit_counter($post_id = NULL, $hit = NULL) {

    $total_hit = $hit +1;
    $CI = & get_instance();    
    $CI->db->set('hit', $total_hit);
    $CI->db->where('id', $post_id);
    $CI->db->update('posts');  
    return $total_hit;
}

function getEngineSizesById($id) {
    $CI = & get_instance();
    $engine_id = intval($id);
    if ($result = $CI->db->select('engine_size')->from('engine_sizes')->where('id ', $engine_id)->get()->row()) {
        return $result->engine_size;
    }
    return "No Data";
}

function getBodyTypeById($id) {
    
    $CI             =& get_instance();
    $body_type_id   = intval($id);
    $result         = $CI->db->select('type_name')
                            ->get_where('body_types', ['id ', $body_type_id ])
                            ->row();
        
    return ($result) ? $result->type_name : 'No';
    
}

function getFeatureById($ids = null) {
        
    if(is_null($ids)){
        return false;
    }
	
    $feature_ids    = explode(',', $ids);
    $CI             = & get_instance();
    

    $features = $CI->db->get("special_features")->result();
    
    $options = '';
    $options .= '<ul class="vehicle-feature">';    
    foreach ($features as $feature) {
        
        $options .= in_array($feature->id, $feature_ids) 
                    ? '<li class="col-md-3 no-padding"><i class="fa fa-check"></i>' . $feature->title . '</li>'
                    : '';
    }
    $options .= '</ul>';
    return $options;
}
function getVicheleFeatures($ids = null) {
        
    if(is_null($ids)){
        return false;
    }
	
    $feature_ids    = explode(',', $ids);
    $CI             = & get_instance();
    

    $features = $CI->db->get('special_features')->result();
    
    $options = array();
    
    foreach ($features as $feature) {
        
        if(in_array($feature->id, $feature_ids) ){
            $options[] = $feature->title;
        }                                  
    }    
    return $options;
}



function postUpdateTabs( $active = '', $id = 0, $disable = false ){
    $tabs = [
        'update_general'        => '<i class="fa fa-info"></i> General Info',
        'update_post_detail'    => '<i class="fa fa-gear"></i> Product Info',
        'update_photo'          => '<i class="fa fa-picture-o"></i> Product Photo',
    ];
    
    $html = '<div class="step_holder">';
    $html .= '<ul class="steps">';
    foreach( $tabs as $url=>$title ){
        
        if($id == 0){
            $html .= '<li class="btn btn-default disable">'. $title .'</li>';        
        } else {
            $html .= '<li';        
            $html .= ($active == $url ) ? ' class="active"' : '';
            $html .= '><a href="admin/posts/'. $url .'/'. $id . '">'. $title .'</a></li>';        
        }                
    }   
    if($id == 0){
        $html .= '<li class="btn btn-default disable"><i class="fa fa-search-plus"></i> Preveiw</a></li>';
    }  else {
        $html .= '<li><a href="post/'. getPostSlug($id) .'" target="_blank"><i class="fa fa-search-plus"></i> Preveiw</a></li>';
    }
        
    $html .= '</ul>';
    $html .= '</div>';
    return $html;
}

function getPostSlug( $id = 0 ){
    $filterid   = intval($id);
    $data       = DB::table('posts')
                    ->select('post_slug')
                    ->where('id', '=', $filterid )
                    ->first();
    
    return ($data) ? $data->post_slug : 'unknown';
}



function parts_description($selected = NULL) {
   
    $ci =& get_instance();
    $parts =   $ci->db->select('id,name')->get_where('parts_description')->result();
    $options = '';
    foreach ($parts as $row) {
        $options .= '<option value="' . $row->id . '" ';
        $options .= ($row->id == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $row->name . '</option>';
    }
    return $options;
}
function parts_for($selected = NULL, $label = '--Select--') {
   
    /*$parts = [
        '1' => 'Cars/Vans',
        '3' => 'Motorcycles',
        '7' => 'Trucks/Heavy duty Vehicles',
    ];
    $options = '<option value="0">'.$label.'</option> ';
    foreach ($parts as $key => $row) {
        $options .= '<option value="' . $key . '" ';
        $options .= ($key == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $row . '</option>';
    }
    return $options;
    */
    
    
     $ci = & get_instance();
        $query = $ci->db->where_not_in('id' , [ 4,5,6] )->get('vehicle_types')->result();        
        
        $row = '<option value="0">'.$label.'</option> ';
        foreach ($query as $option) {
            $row .= '<option value="' . $option->id . '"';
            $row .= ($selected === $option->id) ? ' selected' : '';
            $row .= '>' . $option->name . '</option>';
        }
        return $row;
}

function getPartsFor( $selected = NULL ) {
   
    $parts = [
        '1' => 'Cars/Vans',
        '3' => 'Motorcycles',
        '7' => 'Trucks/Heavy duty Vehicles',
    ];
    foreach ( $parts as $key => $part) {
        if($key == $selected){
            $options =  '<label class="label label-primary">'.$part.'</label> ';
        } else {
            $options = 'No data';
        }
    }
        return $options;
   
}

// with checkbox
function parts_for_checkbox($selected = NULL) {
   
    if($selected) {
        $selected = explode( '#', $selected);
        unset($selected[0]);
    } 
    $parts = [
        '1' => 'Cars/Vans',
        '3' => 'Motorcycles',
        '7' => 'Trucks/Heavy duty Vehicles',
    ];
    $options = '';
    $i = 1;
    foreach ($parts as $key => $row) { 
     
        $options .= '<label class="checkbox"><input type="checkbox" name="parent_id[]" value="'.$key.'"';
        if( $selected ) {
            $options .= (in_array($key, $selected ) ) ? 'checked' : '';
        }
        $options .= '> ' . $row . '</label>';
        $i++;
    }
    return $options;
}


function get_parts_for($id = 0 ) {
   
    if($id) {
        $id = explode( '#', $id);
        unset($id[0]);
    }
    
    $parts = [
        '1' => 'Cars/Vans',
        '3' => 'Motorcycles',
        '7' => 'Trucks/Heavy duty Vehicles',
    ];  
    
    $options = '';
    foreach ($parts as $key => $row) { 
        if($id) {
            $options .= (in_array($key, $id ) ) ? '<label class="label label-primary">'.$row.'</label> ' : '';
        } 
    }
    return $options;
    
}


function getBrand($model_id = 0, $brand_id = 0 ) {
   
    $ci      =& get_instance();
    $models  = $ci->db->get_where('brands', ['parent_id' => $brand_id ])->result();
            
    $options = '<option value="0"> -- Select Brand -- </option>';
    foreach ($models as $model) {
        $options .= '<option value="' . $model->id . '" ';
        $options .= ($model->id == $model_id ) ? 'selected="selected"' : '';
        $options .= '>' . $model->name . '</option>';
    }
    return $options;
}

// Tags of Details update page
function getTagName( $table = '', $column = '', $id = 0){
    $ci      =& get_instance();
    $result = $ci->db->select($column)->get_where($table, ['id' => $id ])->row();                                
    return isset($result->$column) ? $result->$column : '';                
}


function getVhecileDetails( $data = ''){
    if ($data) {
        echo $data;
    } else {
        echo 'No Data';
    }
}



function getPostPackages($service_rate = 0) {
    $CI = & get_instance();
    $html = ''; $regular = ''; $featured = '';
    $packages = $CI->db->order_by('id', 'ASC')->get('packages')->result();
    foreach ($packages as $package) {
        if ($package->package_type == 'Featured') {
            $featured .= '<option value="' . $package->id . '"';
            $featured .= ( $service_rate == $package->id ) ? ' selected' : '';
            $featured .= '>' . $package->title . '( ' . $package->duration . ' days)</option>';
        } else {
            $regular .= '<option value="' . $package->id . '"';
            $regular .= ( $service_rate == $package->id ) ? ' selected' : '';
            $regular .= '>' . $package->title . '( ' . $package->duration . ' days)</option>';
        }
    }
    $html = "<optgroup label='Regular'>$regular</optgroup><optgroup label='Featured'>$featured</optgroup>";
    return $html;
}

function getPackagePrice($package_id) {
    $CI = & get_instance();
    $package = $CI->db->get_where('packages', ['id' => $package_id])->row();
    return $package->price;
}

function getPackageName($package_id){
    $html =  '';
    $CI = & get_instance();
    $package = $CI->db->get_where('packages', ['id' => $package_id])->row();
    if($package) {
        $title =  $package->title;
        $html =  "<p style='margin: 0 0 2px;'><strong>Package Name: </strong> <em>$title</em></p>";
    } 
    return $html;
}
function getPackageNameApi($package_id){
    $html =  '';
    $CI = & get_instance();
    $package = $CI->db->get_where('packages', ['id' => $package_id])->row();
    if($package) {
        $title =  $package->title;
        $html =  "Package Name: $title";
    } 
    return $html;
}


function getPackageNameNew($package_id){
    $html =  '';
    $CI = & get_instance();
    $package = $CI->db->get_where('packages', ['id' => $package_id])->row();
    if($package) {
        $title =  $package->title;
        $html =  "<p style='margin: 0 0 2px;'>$title</p>";
    } 
    return $html;
}


function listingName($listing_id){
    $html =  '';
    $CI = & get_instance();
    $listing = $CI->db->get_where('posts', ['id' => $listing_id])->row();
    if($listing) {
        $title =  $listing->title;
        $html =  "<p style='margin: 0 0 2px;'>$title</p>";
    } 
   // return $html;
    
    return "asdas";
}


function serviceName ($listing_id){
    $html =  '';
    $CI = & get_instance();
    $listing = $CI->db->get_where('posts', ['id' => $listing_id])->row();
    if($listing) {
        $title =  $listing->title;
        $html =  "<p style='margin: 0 0 2px;'>$title</p>";
    } 
   // return $html;
    
    return $html;
}

//function getUserNameByUserId($id) {
//    $CI = &get_instance();
//    $user = $CI->db->select('first_name,last_name')->get_where('users', ['id' => $id ])->row();
//    if($user){
//        return $user->first_name .' '. $user->last_name;
//    } else {
//        return 'Unknown';
//    }    
//}

function globalCurrencyFormatPackageNew($string = null) {
    if (is_numeric($string)) {
        return '&#x20A6; ' . ( number_format($string, 0) );
    } else {
        return $string;
    }
}