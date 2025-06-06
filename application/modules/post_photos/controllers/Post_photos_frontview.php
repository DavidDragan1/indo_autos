<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-10-21
 */

class Post_photos_frontview extends MX_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Post_photos_model');
        $this->load->library('form_validation');
    }

  
    // No in use 
//    public function getFeaturedPhoto($post_id){
//        $row = $this->db->select('photo')
//                ->get_where('post_photos', ['post_id' => $post_id, 'featured' => 1])
//                ->row();        
//        return (  $row ) ? $row->photo : 'no-photo.jpg';             
//    }  
    
    public function getAllPhoto($post_id, $size = null){
        
        if(!empty($size)){
            $photos = $this->db->select('photo')
                ->where_in('size', [$size, 0])
                ->get_where('post_photos', ['post_id' => $post_id])
                ->result();  
        } else {
           $photos = $this->db->select('photo')
                ->get_where('post_photos', ['post_id' => $post_id])
                ->result();    
        }
             
        return $photos;                   
    } 

    
    
    public function create_action(){
        //$this->_rules();
     
        $file_name = 'no-thumb.jpg';
        $handle = new upload( $_FILES['file'] );

        if($handle->uploaded){
            $handle->file_new_name_body   = 'photo';     
            $handle->process( 'uploads/' );
            if($handle->processed){
              $file_name = $handle->file_dst_name;
            }
        }
        if(empty($this->input->post('featured',TRUE))){
            $featured = '0';
        } else {
           $featured = $this->input->post('featured',TRUE);
        }
        
       
            $data = array(
		'post_id' => $this->input->post('post_id', TRUE),
		'photo' => $file_name,
		'featured' => $featured,
	    );
           
            echo $this->Post_photos_model->insert($data);
            
            $this->session->set_flashdata('message', 'Create Record Success');
            //redirect(site_url('post_photos'));
        
    }
    
    public function get_by_post_id($id){
        $row = $this->Post_photos_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'post_id' => $row->post_id,
		'photo' => $row->photo,
		'featured' => $row->featured,
	    );
            print_r($data);
            
        } 
    }
    
    
    
  

}