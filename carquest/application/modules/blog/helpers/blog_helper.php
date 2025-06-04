<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

function blogStatus($selected = 'Draft')
{
    $status = ['Publish', 'Draft', 'Trash'];
    $options = '';
    foreach ($status as $row) {
        $options .= '<option value="' . $row . '" ';
        $options .= ($row == $selected) ? 'selected="selected"' : '';
        $options .= '>' . $row . '</option>';
    }
    return $options;
}

// meat value from meta key
function CategoryDropDown($selected = null)
{

    $CI = &get_instance();
    $categories = $CI->db->select('*')->get_where('blog_category')->result();

    $row = '';
    $row = '<option value="0">Select Category</option>';
    foreach ($categories as $category) {
        $row .= '<option value="' . $category->id . '"';
        $row .= ($selected == $category->id) ? ' selected' : '';
        $row .= '>' . $category->name . '</option>';
    }
    return $row;
}

function getTagsList($select = [])
{
    $ci = &get_instance();
    $query = $ci->db->get('blog_tags')->result();
    $options = '';
    foreach ($query as $row) {
        $options .= '<option value="' . $row->id . '" ';
        $options .= in_array($row->id, $select) ? 'selected="selected"' : '';
        $options .= '>' . $row->name . '</option>';
    }
    return $options;
}


function getBlogFeaturedThumb($thumb = null, $size = 'small', $alt = "images", $class = '')
{

    switch ($size) {
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
        case 'no_size':
            $size = '';
            break;
        default :
            $size = 'width="350" height="300"';
    }

    $filepath = dirname(BASEPATH) . '/uploads/blog_photos/' . $thumb;
    if ($thumb && file_exists($filepath)) {
        return '<img class="'.$class.'" src="uploads/blog_photos/' . $thumb . '" ' . $size . ' alt="' . $alt . '"/>';
    } else {
        return '<img class="'.$class.'" src="assets/theme/new/images/no-photo.png" ' . $size . '  alt="' . $alt . '"/>';
    }

}







