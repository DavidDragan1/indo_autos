<?php  defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_helper{
    
 
    // meta value from meta key
    public static function valueByMetaKey__backup($name) {
            $user_id 	= getLoginUserData('user_id'); 
            $CI        	= & get_instance();   
            $data       = $CI->db->select('*')
                                ->get_where('user_meta', ['user_id' => $user_id, 'meta_key' => $name])
                                ->row();
            return @$data->meta_value; 
    }
    
    public static function userMetaValue($meta_key = '', $array = []) {
           //return $array;
         
            $user_id 	= getLoginUserData('user_id'); 
       
            
            $CI        	= & get_instance();   
            $data       = $CI->db->select('*')
                                ->get_where('user_meta', ['user_id' => $user_id, 'meta_key' => $meta_key])
                                ->row();
            return @$data->meta_value; 
    }
    
  
    
    public static function sellerSocialLinks($json = null, $key = '') {
       
        if($json){
            $data = json_decode($json, true);
            return isset($data[$key]) ? $data[$key] : '';
        }
        
    }
    public static function sellerBusinessHours($json = null, $key = '') {
       
        if($json){
            $data = json_decode($json, true);
            return isset($data[$key]) ? $data[$key] : '';
        }
        
    }
    
    
    // 


    public static function makeTab( $active_tab = '' ){
        $user_id    = getLoginUserData('user_id');
        $role_id    = getLoginUserData('role_id');        
        $access     = checkMenuPermission('profile/business', $role_id);
        
        
        $html   = '<ul class="tabsmenu">';
        $tabs['#']          = '<i class="fa fa-user"></i> &nbsp;My Profile';
        
        if( $access ){
            $tabs['business']   = '<i class="fa fa-suitcase"></i> &nbsp;Trade Seller Page';            
        }
		if( $access ){
            $tabs['video']   = '<i class="fa fa-suitcase"></i> &nbsp;Video Gallery';            
        }
        
        $tabs['password']   = '<i class="fa fa-random"></i> &nbsp;Change Password';
        
        
        foreach( $tabs as $link=>$tab ){
            $html .= '<li><a href="'.  Backend_URL . 'profile/' . $link .'"';
            $html .= ($link  == $active_tab ) ? ' class="active"' : '';
            $html .= '> '. $tab .'</a></li>';
        }
        
        $html .= '<li>'. Users_helper::getBusinessPageURL( $user_id  ) . '</li>';
        $html .= '</ul>';
        return $html;
    }

    public static function makeNewTab( $active_tab = '' ){
        $ci =& get_instance();
        $user_id    = getLoginUserData('user_id');
        $role_id    = getLoginUserData('role_id');
        $access     = checkMenuPermission('profile/business', $role_id);

        $html   = '<ul class="nav account-tab-items">';
        $tabs['#']          = 'My Profile';
        $complete = 1;

        if( $access ){
            $page = $ci->db->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row();
            $complete = 0;
            if ($page) {
                $complete = 1;
            }

            $tabs['business']   = 'Business Details';
        }
        if( $access ){
            $tabs['video']   = 'Video Gallery';
        }

        $tabs['password']   = 'Change Password';


        foreach( $tabs as $link=>$tab ){
            if ($link == 'business' && $complete == 0) {
                $html .= '<li><a style="color: orangered;" href="'.  Backend_URL . 'profile/' . $link .'"';
                $html .= ($link  == $active_tab ) ? ' class="active"' : '';
                $html .= '> '. $tab .'</a></li>';
            } else {
                $html .= '<li><a href="'.  Backend_URL . 'profile/' . $link .'"';
                $html .= ($link  == $active_tab ) ? ' class="active"' : '';
                $html .= '> '. $tab .'</a></li>';
            }
        }

        $html .= '<li>'. getNewBusinessPageURL( $user_id  ) . '</li>';
        $html .= '</ul>';
        if ($complete == 0) {
            $html .= '<p class="text-center" style="color: red; margin-bottom: 40px;">Please update your business page to complete your registration.</p>';
        }

        return $html;
    }

}    