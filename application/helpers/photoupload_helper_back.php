<?php defined('BASEPATH') OR exit('No direct script access allowed');

function photo_upload($image,$post_id , array $sizes = []){
   
    $handle = new upload($image);
    if ($handle->uploaded) {        
        $photo = [];
        //$sizes = array(100, 200, 300, 400, 500);
        foreach ($sizes as $key => $value) {
             $photo[] = multiple_upload($handle,$post_id, $value);
        }        
    }      
    return $photo;
}

function multiple_upload($handle,$post_id, $size, $rand) {

    $handle->file_name_body_pre   = $post_id;
    $handle->file_new_name_body   = '_photo_'.$rand.'_'. $size;
    $handle->allowed              = array('image/*');
    $handle->image_resize         = true;
    $handle->image_x              = $size;            
    $handle->image_ratio_y        = true;
    
    
    $handle->file_new_name_ext = 'jpg';
    $handle->file_force_extension = true;

    $photo  = $handle->file_name_body_pre . $handle->file_new_name_body .'.'. $handle->file_src_name_ext;
            
  
    $handle->image_watermark = 'uploads/watermark.png';
    // $handle->image_watermark_x = 125;
    // $handle->image_watermark_y = 0;
    $handle->process('uploads/car');
   
    $handle->processed;
    return $photo;
}

function cropImageToThisSize($handle, $post_id, $width, $height, $name, $feature = 'No' ) {
    
    $ext                            = 'jpg';
    $handle->file_new_name_body     = $name .'_'. $width;
    $handle->allowed                = array('image/*');
    
    $handle->image_resize           = true;
    $handle->image_x                = $width;   // width 
    $handle->image_y                = $height;  // Height 
    $handle->image_ratio            = true;
    $handle->image_ratio_fill       = true;
    $handle->image_background_color = '#000000';
    $handle->file_new_name_ext      = 'jpg';
    
    $handle->image_watermark = dirname( BASEPATH ).'/assets/theme/new/images/whitetext-logo.png';
	
    $photo                          = $handle->file_new_name_body .'.'. $ext;  
    $handle->process( dirname( BASEPATH )  . '/uploads/car/' );   
     
    
    if ($handle->processed){
        $data['post_id']    = $post_id;
        $data['photo']      = $photo;
        $data['size']       = $width;
        $data['featured']   = $feature;    
        return $data;        
    } else {
        return [ 'post_id' => $post_id, 'photo' => 'Problem', 'size' => 0, 'featured' => 'No'];
    }    
}