<?php

function getDropDownAlbums($id, $type) {
    $CI = &get_instance();
    $albums = $CI->db->get_where('gallery_albums', ['type' => $type ])->result();
    $html = '<option value="0">Select Album</option>';
    foreach ($albums as $album) {
        $html .= '<option value="' . $album->id . '"';
        $html .= ($id == $album->id ) ? ' selected="selected"' : '';
        $html .= '>' . $album->name . '</option>';
    }
    return $html;
}
function getDropDownUsers($id) {
    $CI = &get_instance();
    $users = $CI->db->select('id,first_name,last_name')->get('users')->result();
    $html = '';
    foreach ($users as $user) {
        $html .= '<option value="' . $user->id . '"';
        $html .= ($id == $user->id ) ? ' selected="selected"' : '';
        $html .= '>' . $user->first_name .' '. $user->last_name . '</option>';
    }
    return $html;
}


// Move to Global Helper

//function getUserNameByUserId($id) {
//    $CI = &get_instance();
//    $user = $CI->db->select('first_name,last_name')->get_where('users', ['id' => $id ])->row();
//    if($user){
//        return $user->first_name .' '. $user->first_name;
//    } else {
//        return 'Unknown';
//    }    
//}



function getGalleryThumb($thumb = null, $size = 'tiny', $attrs = array() ) {

    
    $attribute = '';
    
    foreach($attrs as $key => $value ){
        $attribute .= $key .' = "'. $value . '"';
    }    
    
    
    if ($thumb && file_exists(GalleryFolder . $thumb)) {
        return '<img '. $attribute .' src="' .  GalleryFolder . $thumb . '"  alt="Thumb"/>';
    } else {        
        return '<img '. $attribute .' src="' .  GalleryFolder . 'no-thumb.gif" alt="Thumb"/>';
    }
}

function getAlbumThumb($thumb = null, $size = 'tiny', $attrs = array() ) {    
    $attribute = '';
    
    foreach($attrs as $key => $value ){
        $attribute .= $key .' = "'. $value . '"';
    } 
    
    if ($thumb && file_exists(AlbumFolder . $thumb)) {
        return '<img '. $attribute .' src="' .  AlbumFolder . $thumb . '"  alt="Thumb"/>';
    } else {        
        return '<img '. $attribute .' src="' .  AlbumFolder . 'no-thumb.gif" alt="Thumb"/>';
    }
}


function getAlbum($album_id = 0) {
    $CI         = & get_instance();
    $album_id   = intval($album_id);
    $result     = $CI->db->select('*')->get_where('gallery_albums', ['id' => $album_id])->row();
    return @$result->name;
}



//function isCheck($checked = 0, $match = 1) {
//    $checked = ($checked);
//    return ($checked == $match) ? 'checked="checked"' : '';
//}


function switchWatermakrPosition($position = 'center') {
    switch ($position) {
        case 'TL' :
            $css = 'style="top:0; left:0"';
            break;
        case 'TR' :
            $css = 'style="top:0; right:0"';
            break;
        case 'BL' :
            $css = 'style="bottom:0; left:0"';
            break;
        case 'BR' :
            $css = 'style="bottom:0; right:0"';
            break;
        default :
            $css = 'style="top: 30%; left: 28%;';
    }
    return $css;
}



function albumType($selected = null) {
    $type = ['Photo', 'Video'];
    $options = '';
    foreach ($type as $row) {
        $options .= '<option value="' . $row . '" ';
        $options .= ($row == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $row . '</option>';
    }
    return $options;
}


/*
 * function get_selected_radio_value($id, $name) {

    $options = '';
    $options .= '<label><input type="radio"   value="' . $id . '"';
    $options .= '<label><input type="radio"   value="' . $id . '"';
    $options .= ($id == 1) ? "checked" : "checked";
    $options .= ' name="" >  <small>()</small></label> &nbsp;';
    return $options;
}
 */