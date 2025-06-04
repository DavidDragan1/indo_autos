<?php use Illuminate\Support\Facades\DB;

defined('BASEPATH') OR exit('No direct script access allowed');

// leave blank for module helper
/* function myHelper(){
    return 'MyHelper';
}
*/

function all_location($id = 0, $label = 'Select Location')
{
    $ci =& get_instance();
    // $id = intval( $ci->input->get('location_id') );
    $post_areas = $ci->db->get('post_area')->result();

    if ($post_areas) {
        $html = '<option value="">--' . $label . '--</option>';
        foreach ($post_areas as $area) {
            $html .= '<option value="' . $area->id . '"';
            $html .= ($id == $area->id) ? ' selected' : '';
            $html .= '>' . $area->name . '</option>';
        }
        return $html;
    } else {
        return null;
    }
}