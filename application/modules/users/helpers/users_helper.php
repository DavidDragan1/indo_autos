<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Capsule\Manager as DB;

class Users_helper {

    public static function Delete($id = 1, $status = 'Unlocked') {

        if ($status == 'Unlocked') {
            return '<span onClick="delete_role(' . $id . ')" class="btn btn-danger btn-sm"> <i class="fa fa-trash-o"></i> Delete</span>';
        } else {
            return '<span class="btn btn-default btn-sm disabled"> <i class="fa fa-lock"></i> Locked</span>';
        }
    }

    public static function getModules($array = [], $role_id=null) {
        $html = '';
        if (!empty($array)) {
            foreach ($array as $row) {
                $html .= '<input type="hidden" name="role_id" value="' . $role_id . '">';
                $html .= '<div class="acl_module_name">' . $row['module_name'] . '</div>';
                $html .= self::getAcls($row['moulde_acls'], $role_id);
            }
        }
        return $html;
    }

    public static function getAcls($array = [], $role_id = 0) {
        $html = '<ul>';
        foreach ($array as $row) {
            $html .= '<li><label><input type="checkbox" name="acl_id[]"';
            $html .= (self::isCheck($role_id, $row->id)) ? ' checked ' : '';
            $html .= 'value="' . $row->id . '"';
            $html .= '/>&nbsp;' . $row->permission_name . '</lable></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public static function isCheck($role_id = 0, $acl_id = 0) {

        $ci = & get_instance();
        $query = $ci->db->select('access')
                ->from('role_permissions')
                ->where('role_id', $role_id)
                ->where('acl_id', $acl_id)
                ->get()
                ->row();

        //echo $ci->db->last_query();
        return ($query);
    }

    public static function makeTab($id, $active_tab) {
        //$ci =& get_instance();
        //$ci->uri->segment('4');

        $role_id = self::getRoleIdByUserId($id);

        $html = '<ul class="tabsmenu">';

        $tabs['profile']        = 'User Profile';
        $tabs['update']         = 'Update User Info';
        $tabs['mails']          = 'Mail History';
        if($role_id == 4){
           $tabs['business']    = 'Business Profile';
           $tabs['video']       = 'Manage Videos';
        }
        $tabs['password']       = 'Reset Password';
        $tabs['delete']         = 'Delete Account';
        if($role_id == 14){
            $tabs['availability']    = 'Availability';
        }


        foreach ($tabs as $link => $tab) {
            $onclick_javascript = $link == 'delete' ? 'onclick="return confirm(\'Are you sure\')"' : '';
            $html .= '<li><a '.$onclick_javascript.' href="' . Backend_URL . 'users/' . $link . '/' . $id . '"';
            $html .= ($link === $active_tab ) ? ' class="active"' : '';
            $html .= '> ' . $tab . '</a></li>';
        }


        $html .= '<li>'. self::getBusinessPageURL( $id ) . '</li>';
        $html .= '</ul>';

        return $html;
    }





    public static  function getBusinessPageURL( $id ){
        $ci =& get_instance();
        $page = $ci->db->get_where('cms', ['user_id' => $id, 'post_type' => 'business'])->row();

        if($page){
            return '<a target="_blank" href="' .$page->post_url . '">View Page <i class="fa fa-external-link"></i></a>';
        } else {
            return '<a href="javascript::void(0)"> Page Incomplete <sup>*</sup></a>';
        }

    }

    public static  function getNewBusinessPageURL( $id ){
        $ci =& get_instance();
        $page = $ci->db->get_where('cms', ['user_id' => $id, 'post_type' => 'business'])->row();

        if($page){
            return '<a target="_blank" href="' .$page->post_url . '" class="preview">View Page</a>';
        } else {
            return '<a href="javascript::void(0)" class="preview" data-toggle="tooltip" title="Please enter your company name, Seller Page URL, logo, business hours, location to complete the page."> Page Incomplete <sup>*</sup></a>';
        }

    }

    public static function getTitleName($title = 0) {

        $status = ['', 'Mr.', 'Miss.', 'Mrs.', 'Sir.', 'Ms.', 'Dr.', 'Prof.', ' Barrister', 'Lord'];
        $options = '';
        foreach ($status as $row) {
            $options .= '<option value="' . $row . '" ';
            $options .= ($row == $title ) ? 'selected="selected"' : '';
            $options .= '>' . $row . '</option>';
        }
        return $options;
    }

    public static function getDropDownRoleName($role_id = 0) {
        $ci = & get_instance();

        $ci->db->where('user_id', 0);
        $query = $ci->db->get(' roles');


        $options = '';
        foreach ($query->result() as $row) {
            $options .= '<option value="' . $row->id . '" ';
            $options .= ($row->id == $role_id ) ? 'selected="selected"' : '';
            $options .= '>' . $row->role_name . '</option>';
        }
        return $options;
    }

    static public function getUserProfilePhoto($photo = null) {

        $photofile = dirname(BASEPATH) . '/uploads/users_profile/' . $photo;
        if ($photo && file_exists($photofile)) {
            return 'uploads/users_profile/' . $photo;
        } else {
            return 'uploads/no-photo.jpg';
        }
    }

    public static function userMetaValue($meta_key = '', $user_id = 0 ) {
            $CI        	= & get_instance();
            $data       = $CI->db->select('*')
                                ->get_where('user_meta', ['user_id' => $user_id, 'meta_key' => $meta_key])
                                ->row();
            return @$data->meta_value;
    }

    static public function getTotalPostByUserID($user_id = 0) {
        return DB::table('posts')->where('user_id', '=', $user_id)->count('id');
    }

    static public function getRoleNameByID($role_id = 0) {
        $result = DB::table('roles')->where('id', '=', $role_id)->first();
        return $result->role_name;
    }

    static public function getRoleIdByUserId($user_id = 0) {
        $result = DB::table('users')->where('id', '=', $user_id)->first();
        return $result->role_id;
    }

    static public function getRegistraionRange($range = '') {

        $status = array(
            '0' => '--Any--',
            date('Y-m-d') => 'Today',
            date('Y-m-d', strtotime("-1 Day")) => 'Last 2 Days',
            date('Y-m-d', strtotime("-3 Day")) => 'Last 3 Days',
            date('Y-m-d', strtotime("-7 Day")) => 'Last 7 Days',
            date('Y-m-d', strtotime("-1 Month")) => 'Last 1 Month',
            date('Y-m-d', strtotime("-3 Month")) => 'Last 3 Months',
            date('Y-m-d', strtotime("-6 Month")) => 'Last 6 Months',
            'Custom' => 'Custom'
        );
        $row = '';
        foreach ($status as $key => $option) {
            $row .= '<option value="' . $key . '"';
            if ($range == $key) {
                $row .= ' selected';
            }
            $row .= '>' . $option . '</option>';
        }
        return $row;
    }


    static public function getRoles($seleted = '') {

        $CI = & get_instance();
        $roles = $CI->db->get_where('roles')->result();
        $row = '<option value="0">--Any--</option>';
        foreach ($roles as $role) {
            $row .= '<option value="' . $role->id . '"';
            if ($seleted == $role->id) {
                $row .= ' selected';
            }
            $row .= '>' . $role->role_name . '</option>';
        }
        return $row;
    }
}
