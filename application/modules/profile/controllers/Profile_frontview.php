<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 8th Oct 2016
 */

class Profile_frontview extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Profile_model');
        $this->load->helper('profile');

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }


    public function business(){
        $user_id        = getLoginUserData('user_id');         
        $data['user']   = $this->db->get_where('users', ['id' => $user_id])->row_array();
        $data['meta']   = $this->db->select('meta_key,meta_value')->get_where('user_meta', ['user_id' => $user_id])->result_array();

//        $data['meta_title']        = $data['user']['first_name'].' '.$data['user']['last_name'];
//        $data['meta_description']  = getShortContent($post->description, 120);
//        $data['meta_keywords']     = 'Buy old and New Car';
                
        // $data           = (object) array_merge( (array) $user_data, (array) $user_meta_data );                     
        // dd( Profile_helper::userMetaValue('companyEmail', $data['meta'] ) );
        // dd($data);
                                     
        $this->viewAdminContent('business', $data );
    }
    
    
    
    
    
    public function getAllVideoGallery($user_id){
        $videos = $this->db->select('*')
                ->get_where('gallery', ['user_id' => $user_id, 'type' => 'Video', 'status' => 'Active'])
                ->result();  
        $data = [ 'videos' => $videos ];
        $this->load->view('frontend/template/seller_video_gallery', $data);                  
    }
    
    public function getAllPhotoGallery($user_id){
        $photoes = $this->db->select('*')
                ->get_where('gallery', ['user_id' => $user_id, 'type' => 'Photo', 'status' => 'Active'])
                ->result();  
        $data = [ 'photoes' => $photoes ];
        $this->load->view('frontend/template/seller_photo_gallery', $data);                  
    }
    
    public function getVideo($user_id, $video_id){
        
        $video = $this->db->select('*')
                ->get_where('gallery', [ 'user_id' => $user_id,  'id' => $video_id, 'type' => 'Video', 'status' => 'Active' ])
                ->row();   
       
        echo  '<iframe width="100%" height="350" src="https://www.youtube.com/embed/'.$video->photo.'?autoplay=1" frameborder="0" allowfullscreen=""></iframe>';
    }
    public function getPhoto($user_id, $picID){
        
        $picture = $this->db->select('*')
                ->get_where('gallery', [ 'user_id' => $user_id,  'id' => $picID, 'type' => 'Photo', 'status' => 'Active' ])
                ->row();   
       $big = str_replace('.jpg', '_1.jpg', $picture->photo);
        
        echo  '<img src="uploads/gallery/'.$big.'" class="img-responsive lazyload" />';
    }
    
        public function getUserInfo($user_id){
        $data['user']   = $this->db->get_where('users', ['id' => $user_id])->row_array();
        $cms_data = $this->db->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business' ])->row_array();
        $user_meta  = $this->db->select('meta_key,meta_value')->get_where('user_meta', ['user_id' => $user_id])->result_array();
        
        if($cms_data){
            $data['cms']   = $cms_data;
        }
        if($user_meta){
            $data['meta']    = $user_meta;
        }
        
        $data['CompanyInfo'] = Profile_helper::userMetaValue($user_id, 'CompanyInfo', $data['meta'] );
        $data['CompanySocialLinks'] = Profile_helper::userMetaValue($user_id, 'CompanySocialLinks', $data['meta'] );
        
//        echo '<pre>';
//        dd( $data['CompanySocialLinks'] );
         
        $data['CompanyInfo'] = json_decode($data['CompanyInfo']);
        $data['CompanySocialLinks'] = json_decode($data['CompanySocialLinks']);
        
        return $data;
    }
    
    
    
    

//    public function company_info_view($user_id){        
//       
//         $user_data         = $this->db->get_where('users', ['id' => $user_id])->row();
//         $user_cms_data     = $this->db->get_where('cms', ['user_id' => $user_id, 'post_type'=> 'business'])->row();
//         $user_meta_data    = $this->db->get_where('user_meta', ['user_id' => $user_id])->result_array();
//         
//         $data = [ 
//                    'user_data' => $user_data, 
//                    'meta_data' => $user_meta_data,
//                    'cms_data' => $user_cms_data,
//                 ];
//        
//         //$data = (object) array_merge( (array) $user_data, (array) $user_meta_data );
//         return $data;
//    }
//    
//    
    
    
    
    
                
}
