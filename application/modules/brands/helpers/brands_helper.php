<?php


function vehicleType($selected = 0) {
      
        $ci = & get_instance();
        $ci->load->database();
        $query = $ci->db->get('vehicle_types')->result();

     
        $row = '';
        foreach ($query as $option) {
            $row .= '<option value="' . $option->id . '"';
            $row .= ($selected === $option->id) ? ' selected' : '';
            $row .= '>' . $option->name . '</option>';
        }
        return $row;
    }

    
    function vehicleTypeCheckBox($selected = '') {
    
        $ci     =& get_instance();
        $types  = $ci->db->get('vehicle_types')->result();
        $array  = ($selected) ? explode(',', $selected) : [0];
                      
        $html = '';
        foreach ($types as $type) { 
            $html .= '<div class="checkbox"><label><input type="checkbox" name="type_id[]"  value="' . $type->id . '"';
            $html .= (in_array( $type->id, $array )) ? ' checked' : '';
            $html .= '>' . $type->name . '</label></div>'; 
        }
        return $html;
    }
    
    function getVehcileNameById( $selected = 0 ){
        $ci     =& get_instance();
        $type = $ci->db->get_where('vehicle_types', [ 'id' => $selected ])->row();
        return $type->name;
    }
    
    function getBrandModelNameById( $selected = 0 ){
        $ci     =& get_instance();
        $type = $ci->db->get_where('brands', [ 'id' => $selected ])->row();
        return $type->name;
    }
    function getvehicleTypes($selected = 0) {
      
        $ci = & get_instance();
        $query = $ci->db->get('vehicle_types')->result();

     
        $row = '<option value="0">--Select--</option>';
        foreach ($query as $option) {
            $row .= '<option value="' . $option->id . '"';
            $row .= ($selected === $option->id) ? ' selected' : '';
            $row .= '>' . $option->name . '</option>';
        }
        return $row;
    }


