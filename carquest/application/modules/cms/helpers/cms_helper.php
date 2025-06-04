<?php  

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @param $array
 * @param $curParent
 * @param $opt_id
 * @param int $currLevel
 * @param int $prevLevel
 *
 * @return string
 */
function show_menu_tree($array, $curParent, $opt_id, $currLevel = 0, $prevLevel = -1) {
	$return = '';
	foreach ($array as $categoryId => $list) {		
		if($curParent == $list['parent_id']) {			
		if($list['parent_id']==0) $class="dropdown"; else $class="sub_menu";
		if($currLevel > $prevLevel) $return .= " <ul class='$class'> ";			
		if($currLevel == $prevLevel) $return .= " </li> ";
		
		$return .= '<li id="arrayorder_'.$list['id'].'" class="pageslist">
						 
							<span id="menu_'. $list['id'] .'">'. $list['id'] . ' - ' . ($list['title']) . '</span>
						 
						<span class="action pull-right">
							<span class="ajax_edit" onclick="updateMenuForm('.$list['id'].','.$list['title'].');" title="Rename"> <i class="fa fa-pencil editMenupage"></i></span>&nbsp;
							<span style="cursor:pointer;" class="ajax_delete" onclick="DeleteMenuItem('.$list['id'].');" title="Delete"> <i class="fa fa-trash-o deleteMenupage"></i> </span>
						</span>
					  </li>';
		
		if($currLevel > $prevLevel) { $prevLevel = $currLevel; }			
		$currLevel++;
		show_menu_tree ($array, $categoryId, $opt_id, $currLevel, $prevLevel);
		$currLevel--;
		}
	}

	if ($currLevel == $prevLevel) $return .= " </li> </ul> ";
	return $return;
}

/**
 * @param $pages
 * @param $curParent
 * @param int $currLevel
 * @param int $prevLevel
 *
 * @return string
 */
function selectable_menu_tree($pages, $curParent, $currLevel = 0, $prevLevel = -1) {
	$pagesOut = '';	
	foreach ($pages as $categoryId => $category) {		
			if($curParent == $category['parent_id']) {			
			if($category['parent_id']==0) $class="dropdown"; else $class="ssub_menu";
			if($currLevel > $prevLevel) 
				
			$pagesOut .= "<ul class='$class'>";			
			$pagesOut .= ($currLevel == $prevLevel)  ?  '</li>' : '';			
			$pagesOut .=  '<li><label><input   type="checkbox" name="obj_id[]" value="'.$categoryId.'" id="data_'.$categoryId.'">'. $category['title'] . '</label></li>';			
			if($currLevel > $prevLevel) { $prevLevel = $currLevel; }			
			$currLevel++;			
			$pagesOut .= selectable_menu_tree ($pages, $categoryId, $currLevel, $prevLevel);			
			$currLevel--;
		}
	}
	$pagesOut .= ($currLevel == $prevLevel) ? "</li></ul>" : '';
	return $pagesOut;
}





/**
 * @param $bannerID
 * @return mixed
 * author: Shafi
 */
function countBannerPhotos( $bannerID ){
    $CI  =& get_instance();
    $sql = "SELECT count(*) as Row FROM `cms_content` WHERE parent_id = '$bannerID' and post_type='banner'";
    $query = $CI->db->query( $sql );
    return $query->row()->Row;
}


function get_banner_thumb($thumb = '') {
    if(!file_exists(BannerDir.$thumb)){
        print '<img src="'. ImageResize . BannerFolder . 'no-thumb.gif&w=120px&h=100&zc=1" alt="Thumb"/>';
    } else {
        print '<img src="'. ImageResize . BannerFolder . $thumb . '&w=120px&h=100&zc=1" alt="Thumb"/>';
    }
}

/**
 * @param $banner_id
 * @return mixed
 * author: shafi
 */
function get_total_slider($banner_id){
    $CI =& get_instance();
    $sql = "SELECT COUNT(*) `Row` FROM `cms_content` WHERE `post_type` = 'banner' AND `parent_id` = '$banner_id'";
    $output = $CI->db->query($sql)->row()->Row;
    return $output;
}


function showAvatar($type = 'no_image'){
    $CI =& get_instance();
    if($type == 'no_image'){
        return base_url('asset/cms/img/avatar.png');
    }
    if($type == 'male'){
        return base_url('asset/cms/img/avatar.png');
    }
    if($type == 'female'){
        return base_url('asset/cms/img/avatar_female.png');
    }
}

function cmsStatus( $selected = 'Draft'){	
    $status = [ 'Publish', 'Draft', 'Trash' ];
    $options = '';
    foreach ($status as $row) {
        $options .= '<option value="' . $row . '" ';
        $options .= ($row == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $row . '</option>';
    }
    return $options;	
}


function search_array($field_name = '', $show_name = '', $var = ''){
    $array = [
        [
            'field_name' => 'country',
            'show_name' => 'Country',
            'var' => 'country_name'
        ],
        [
            'field_name' => 'location',
            'show_name' => 'State',
            'var' => 'location_name'
        ],
        [
            'field_name' => 'address',
            'show_name' => 'Location',
            'var' => 'address'
        ],
        [
            'field_name' => 'brand',
            'show_name' => 'Brand',
            'var' => 'brand_name'
        ],
        [
            'field_name' => 'model',
            'show_name' => 'Model',
            'var' => 'model_name'
        ],
        [
            'field_name' => 'price_from',
            'show_name' => 'Price From',
            'var' => 'price_from'
        ],
        [
            'field_name' => 'price_to',
            'show_name' => 'Price To',
            'var' => 'price_to'
        ],
        [
            'field_name' => 'condition',
            'show_name' => 'Condition',
            'var' => 'condition'
        ],
        [
            'field_name' => 'fuel_type',
            'show_name' => 'Fuel',
            'var' => 'fuel_name'
        ],
        [
            'field_name' => 'engine_size',
            'show_name' => 'Engine Size',
            'var' => 'engine_name'
        ],
        [
            'field_name' => 'transmission',
            'show_name' => 'Transmission',
            'var' => 'transmission'
        ],
        [
            'field_name' => 'color_id',
            'show_name' => 'Color',
            'var' => 'color_name'
        ],
        [
            'field_name' => 'from_year',
            'show_name' => 'From Year',
            'var' => 'from_year'
        ],
        [
            'field_name' => 'to_year',
            'show_name' => 'To Year',
            'var' => 'to_year'
        ],
        [
            'field_name' => 'category_id',
            'show_name' => 'Parts Category',
            'var' => 'parts_category'
        ],
        [
            'field_name' => 'age_from',
            'show_name' => 'Age From',
            'var' => 'age_from'
        ],
        [
            'field_name' => 'age_to',
            'show_name' => 'Age To',
            'var' => 'age_to'
        ],
        [
            'field_name' => 'mileage_from',
            'show_name' => 'Mileage From',
            'var' => 'mileage_from'
        ],
        [
            'field_name' => 'mileage_to',
            'show_name' => 'Mileage To',
            'var' => 'mileage_to'
        ],
        [
            'field_name' => 'seats',
            'show_name' => 'Seats',
            'var' => 'seats'
        ],
        [
            'field_name' => 'parts_id',
            'show_name' => 'Parts Id',
            'var' => 'parts_id'
        ],
        [
            'field_name' => 'global_search',
            'show_name' => 'Custom Search',
            'var' => 'global_search'
        ],
    ];
    if (!empty($field_name)){
        $k = array_search($field_name, array_column($array, 'field_name'));
        if (is_numeric($k)) return $array[$k]['show_name'];
    } elseif (!empty($show_name)){
        $k = array_search($field_name, array_column($array, 'show_name'));
        if (is_numeric($k)) return $array[$k]['show_name'];
    } elseif (!empty($var)){
        $k = array_search($field_name, array_column($array, 'var'));
        if (is_numeric($k)) return $array[$k]['show_name'];
    } else {
        return $array;
    }
}







