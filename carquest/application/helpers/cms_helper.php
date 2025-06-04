<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Illuminate\Database\Capsule\Manager as DB;

function getPostWidgetByCategoryID( $category_id = 0, $limit = 2 ){
    //$ci =& get_instance();
    //$posts = $ci->db->get_where('cms', ['post_type' => 'post', 'status' => 'Publish' ],  3,0 )->result();    
    
    $posts = DB::table('cms')                
                ->where('parent_id', '=', $category_id)                                                                        
                ->where('post_type', '=', 'post')                                                                        
                ->where('status', '=', 'Publish')
                ->take( $limit )
                ->get();
        
    //return $posts;
    $html = '';
   // $html = '<ul>';
                $no = 0;            
    foreach ($posts as $post){    $no++;
           if($no == 1){  $div = 'news-devider'; } else {  $div = ''; }
        $html .= '<div class="col-md-6 '.$div.'">';
        $html .= '<h2>'.getShortContent($post->post_title, 25).'</h2>';
        $html .= '<p><em>Post Date: '.globalDateFormat($post->created).'</em></p>';
        $html .= '<div class="col-md-4 nopadding latest_news">';
        $html .= getCMSFeaturedThumb ( $post->thumb, 'medium' );
        $html .= '</div>';
        $html .= '<div class="col-md-8">';
        $html .= '<p>'.getShortContent($post->content, 200).'</p>';
        $html .= '<a class="testmnial-more" href="blog/'.$post->post_url.'">Read More > </a>';
        $html .= '</div>';
        $html .= '<div class="clearfix"></div>';
       
        $html .= '</div>';
   
  
    }
  
    
    return $html;
}



function getRelatedPostWidgetByCategoryID( $category_id = 0, $limit = 2, $except = 0 ){
    //$ci =& get_instance();
    //$posts = $ci->db->get_where('cms', ['post_type' => 'post', 'status' => 'Publish' ],  3,0 )->result();    
    
    $posts = DB::table('cms')                
                ->where('parent_id', '=', $category_id)                                                                        
                ->where('post_type', '=', 'post')                                                                        
                ->where('status', '=', 'Publish')
                ->where('id', '!=', $except)
                ->orderBy('id', 'DESC')
                ->take( $limit )
                ->get();
        
    //return $posts;
    $html = '';
   // $html = '<ul>';
                $no = 0;            
    foreach ($posts as $post){    $no++;
        $html .= '<li><a class="recent-post-wrap" href="blog/'.$post->post_url.'">';
        $html .= '<div class="recent-post-img">'.getCMSFeaturedThumb ( $post->thumb, 'tiny' ).'</div>';
        $html .= '<div class="recent-post-content"><h5>'.$post->post_title.'</h5>';
        $html .= '<span>'.globalDateFormat($post->created).'</span></div></a></li>';

    }
  
    
    return $html;
}

function getCMSFeaturedThumb( $thumb = null, $size = 'small',$alt="images" ){
    
    switch ( $size ){
        case 'tiny':
            $size = 'width="100"';
            break;
        case 'small':
            $size = 'width="220"';
            break;
        case 'medium':
            $size = 'width="350" height="300"';
            break;
        case 'large':
            $size = ''; // Full 
            break;
        case 'blog_details':
            $size = 'class="blog-details-img"'; // Full
            break;
        default :
            $size = 'width="350" height="300"';      
    }
    
    $filepath = dirname( BASEPATH ) . '/uploads/cms_photos/' . $thumb;
    if($thumb && file_exists($filepath)){
        return '<img src="uploads/cms_photos/' . $thumb . '" '. $size .' alt="'.$alt.'"/>';
    } else {
        return '<img src="assets/theme/new/images/no-photo.png" '. $size .'  alt="'.$alt.'"/>';
    }   
    
}





function getCMSStatus( $status = 'Active', $id = 0){
       
    switch ( $status ){
      
        case 'Publish': 
            $class = 'btn-success';
            $icon = '<i class="fa fa-check-square-o"></i> ';
            break;            
        case 'Draft':
            $class = 'btn-default'; 
            $icon = '<i class="fa fa-file-o" ></i> ';
            break;                             
        case 'Trash':
            $class = 'btn-danger';
            $icon = '<i class="fa fa-trash-o"></i> ';
            break;              
        default :
            $class = 'btn-default';
            $icon = '<i class="fa fa-info"></i> ';
    }  
    
    
    return '<button class="btn '. $class .' btn-xs" id="active_status_'. $id .'" type="button" data-toggle="dropdown">
            '. $icon . $status .' &nbsp; <i class="fa fa-angle-down"></i>
        </button>';
    
    
}


// meat value from meta key
function getCategoryDropDown($selected = null) {
     
    $CI         = & get_instance();   
    $categories     = $CI->db->select('*')->get_where('cms_options', ['type' => 'category'])->result();
    
    $row = '';
    $row = '<option value="0">--- None ---</option>';
    foreach ($categories as $category){
         $row .= '<option value="' . $category->id . '"';
        $row .= ($selected == $category->id) ? ' selected' : '';
        $row .= '>' . $category->name . '</option>';
    }
    return $row; 
}


// CMS category Parent ID name
function caretoryParentIdByName($parent_id) {
     $CI         = & get_instance();   
    $catName     = $CI->db->select('*')->get_where('cms_options', ['id' => $parent_id, 'type' => 'category'])->row();
    $count     = $CI->db->where('id',$parent_id )->where('id', $parent_id )->count_all_results('cms_options');
    
    if($count > 0){
        return $catName->name; 
    } else {
        echo 'Default';
    }
    
}

function getCMSPhoto( $photo = null, $size = 'medium', $class='img-responsive lazyload' ){

    switch($size){
        case 'small':
            $width_height = 'width="120"';                
            break;
        case 'medium':
            $width_height = 'width="200"';
            break;
        default :
            $width_height = '';
    }                
                        
    $filename = dirname( APPPATH ) . '/uploads/cms/' . $photo;
    if( $photo && file_exists($filename)){            
        return '<img class="'.$class.'" src="uploads/cms/' . $photo . '" ' . $width_height . '>';
    } else {
        return '<img class="'.$class.'" src="uploads/no-photo.jpg" ' . $width_height . '>';
    } 
}

function getNextPost($parent_id, $post_id) {
    $next_posts =DB::table('cms')
        ->where('parent_id', '=', $parent_id)
        ->where('post_type', '=', 'post')
        ->where('status', '=', 'Publish')
        ->where('id', '>', $post_id)
        ->orderBy('id', 'ASC')
        ->take(1)
        ->get();

    $next_post_url = null;

    foreach ($next_posts as $next_post) {
        $next_post_url = $next_post->post_url;
    }

    return $next_post_url;
}

function getPrevPost($parent_id, $post_id) {
    $next_posts =DB::table('cms')
        ->where('parent_id', '=', $parent_id)
        ->where('post_type', '=', 'post')
        ->where('status', '=', 'Publish')
        ->where('id', '<', $post_id)
        ->orderBy('id', 'DESC')
        ->take(1)
        ->get();

    $next_post_url = null;

    foreach ($next_posts as $next_post) {
        $next_post_url = $next_post->post_url;
    }
    return $next_post_url;

//    $previous_post =$this->db
//        ->from('cms')
//        ->where('parent_id', '=', $post->parent_id)
//        ->where('post_type', '=', 'post')
//        ->where('status', '=', 'Publish')
//        ->where('id', '<', $post->id)
//        ->get()
//        ->row();
}






/*
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


*/







