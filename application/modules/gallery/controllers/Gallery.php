<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-10-03
 */

class Gallery extends Admin_controller {

    const PhotoCaption = false;
    const AlbumCaption = true;

    // Setting Name         = array( Width, Height);
    public $AlbumThumb      = array(208, 200); // Width x Height
    public $PhotoThumb      = array(205, 170); // Width x Height
    public $LightBoxSize    = array(850, 550); // Width x Height
    
//    private $user_id;
//    private $role_id;
    private $canManageAlbum;

    function __construct() {
        parent::__construct();
        $this->load->model('Gallery_model');
        $this->load->library('form_validation');
        $this->load->helper('gallery');


//        $this->role_id        = getLoginUserData('role_id');
//        $this->user_id        = getLoginUserData('user_id');
        $this->manageAlbums         = checkPermission('gallery/albums', $this->role_id);        
        $this->settingPermission    = checkPermission('gallery/settings', $this->role_id);        
    }

    public function index() {
        
        $q          = urldecode($this->input->get('q', TRUE)??'');
        $user_id    = urldecode($this->input->get('user_id', TRUE)??'');
        $album_id   = urldecode($this->input->get('album_id', TRUE)??'');
        $start      = intval($this->input->get('start'));
        $type       = 'Photo';


        $config['first_url'] = Backend_URL 
                . 'gallery/?user_id=' . ($user_id) .'&'
                . 'album_id=' . ($album_id)  .'&'
                . 'q=' . urlencode($q);
        
        $config['base_url'] = Backend_URL
                . 'gallery/?user_id=' . ($user_id) .'&'
                . 'album_id=' . ($album_id)  .'&'
                . 'q=' . urlencode($q);
 
        
        $config['per_page'] = 20;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Gallery_model->total_rows($user_id, $album_id, $type, $q);        
        $gallery_photo = $this->Gallery_model->get_limit_data($config['per_page'], $start, $user_id, $album_id, $type, $q);

        $data = array(
            'manageAlbums'          => $this->manageAlbums,
            'settingPermission'     => $this->settingPermission,
            'user_id'               => $user_id,
            'album_id'              => $album_id,
            'start'                 => $start,
            'total_rows'            => $config['total_rows'],
            'gallery_photo_data'    => $gallery_photo,
        );

		$role_id = getLoginUserData('role_id');

		if ($role_id == 1 or $role_id == 2) {
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $this->viewAdminContent('gallery/index', $data);
        } else {
            $config['query_string_segment'] = 'start';

            $config['num_links'] = 1;

            $config['full_tag_open'] = '<ul class="pagination-wrap">';
            $config['full_tag_close'] = '</ul>';

            $config['first_link'] = false;
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';

            $config['last_link'] = false;
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';

            $config['next_link'] = '<i class="fa fa-angle-right"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li><span class="active">';
            $config['cur_tag_close'] = '</span></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $this->viewNewAdminContent('gallery/trader_index', $data);
        }
    }
    

    public function video() {
        
        $q          = urldecode($this->input->get('q', TRUE)??'');
        $user_id    = urldecode($this->input->get('user_id', TRUE)??'');
        $album_id   = urldecode($this->input->get('album_id', TRUE)??'');
        $start      = intval($this->input->get('start'));
        $type       = 'Video';


        $config['first_url'] = Backend_URL 
                . 'gallery/video?user_id=' . ($user_id) .'&'
                . 'album_id=' . ($album_id)  .'&'
                . 'q=' . urlencode($q);
        
        $config['base_url'] = Backend_URL
                . 'gallery/video?user_id=' . ($user_id) .'&'
                . 'album_id=' . ($album_id)  .'&'
                . 'q=' . urlencode($q);
 
        
        $config['per_page'] = 20;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Gallery_model->total_rows($user_id, $album_id, $type, $q);
         
        $gallery_photo = $this->Gallery_model->get_limit_data($config['per_page'], $start, $user_id, $album_id, $type, $q);
       

        $this->load->library('pagination');        

        $this->pagination->initialize($config);

        $data = array(
            'user_id'               => $user_id,
            'album_id'              => $album_id,
            'start'                 => $start,
            'total_rows'            => $config['total_rows'],
            'pagination'            => $this->pagination->create_links(),
            'gallery_photo_data'    => $gallery_photo,
        );

        $role_id = getLoginUserData('role_id');

        if ($role_id == 1 or $role_id == 2) {
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $this->viewAdminContent('gallery/video', $data);
        } else {
            $config['query_string_segment'] = 'start';

            $config['num_links'] = 1;

            $config['full_tag_open'] = '<ul class="pagination-wrap">';
            $config['full_tag_close'] = '</ul>';

            $config['first_link'] = false;
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';

            $config['last_link'] = false;
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';

            $config['next_link'] = '<i class="fa fa-angle-right"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li><span class="active">';
            $config['cur_tag_close'] = '</span></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $this->viewNewAdminContent('gallery/trader_video', $data);
        }

    }
    
    public function create() {              
        $data = [
            'page_title' => 'Upload New Photo',
            'button'        => 'Create',
            'action'        => site_url( Backend_URL . 'gallery/upload_photo'),
            'id'            => set_value('id'),
            'album_id'   => set_value('album_id'),
            'title'         => set_value('title'),
            'photo'         => set_value('photo'),
            'photo_description' => set_value('photo_description'),
            'gallery_albums'    => $this->db->get('gallery_albums')->result()
        ];

        $role_id = getLoginUserData('role_id');

        if ($role_id == 1 or $role_id == 2) {
            $this->viewAdminContent('gallery/upload_photo', $data);
        } else {
            $this->viewNewAdminContent('gallery/trader_upload_photo', $data);
        }
    }
    
    public function create_video() {
        $role_id = getLoginUserData('role_id');

        $data = [
            'page_title' => 'Upload New Video',
            'type' => 'create',
            'button'        => 'Create',
            'canManageAlbum' => $this->canManageAlbum,
            'action'        => site_url( Backend_URL . 'gallery/upload_video'),
            'id'            => set_value('id'),
            'album_id'      => set_value('album_id'),
            'title'         => set_value('title'),
            'caption'       => set_value('caption'),
            'video_id'      => set_value('video_id'),
            'gallery_albums'=> $this->db->get('gallery_albums')->result()
        ];

        if ($role_id == 1 or $role_id == 2) {
            $this->viewAdminContent('gallery/upload_video', $data);
        } else {
            $this->viewNewAdminContent('gallery/trader_upload_video', $data);
        }
    }
    
    public function upload_video() {
        ajaxAuthorized();
        
        $video_code     = $this->input->post('video_code');
        
        if (!$video_code){
            echo ajaxRespond('Fail','<p class="ajax_error">Video Code is Empty</p>');
            exit;
        }
        
        $album_id               = intval($this->input->post('album_id'));
        
        $data['user_id']        = getLoginUserData('user_id');
        $data['album_id']       = $album_id;
        $data['title']          = $this->input->post('title');
        $data['description']    = $this->input->post('caption');
        $data['photo']          = $video_code;
        $data['created']        = date('Y-m-d H:i:s');
        $data['type']           = 'Video';
        $data['status']         = 'Active';
        
        
        $this->Gallery_model->insert($data);
        $this->updateAlbumQty( $album_id );
        
        echo ajaxRespond('OK', '<p class="ajax_success"><b>Success!</b> Video uploaded.</p>');
    }
    
    
    public function saveSettings( ) {
                                        
        if ($this->input->post('btn')) {
                                                
            // If select new 
            // Then upload new one.... 
            $this->uploadNewWatermark();
                        
            // Re-generate Watermark
            $this->copy_from_original( $this->input->post('watermark_opacity') );
            
            // Update Seeting.json file
            // Path ../root/application/modules/gallery/config/settings.json
            $this->updateSettingJson();                                                                 
        }
        $this->session->set_flashdata('message', 'Setting Saved Successfully');
        redirect(site_url( Backend_URL . 'gallery/settings'));
    }

    private function uploadNewWatermark() {
        if ($_FILES['watermark_logo']['name']) {
            $handle = new upload($_FILES['watermark_logo']);

            if ($handle->uploaded) {
                $handle->image_resize           = true;
                $handle->image_x                = 150;
                $handle->image_ratio            = true;
                $handle->image_convert          = 'png';
                //$handle->file_new_name_ext      = 'png';
                //$handle->file_force_extension   = true;
                $handle->file_overwrite         = true;                
                $handle->file_new_name_body     = 'watermark';                                
                $handle->process('uploads/');                
            }
        }
            
    }
    
    private function copy_from_original( $opacity = 0.5 ){
        $src                          = dirname( BASEPATH ) . '/uploads/watermark_org.png'; 
        $handle                       = new upload( $src ); 
        $handle->file_overwrite       = true;
        $handle->file_new_name_body   = 'watermark';
        $handle->image_opacity        = ceil($opacity * 100 );
        $handle->process('uploads/');
    }
    
    private function updateSettingJson(){
        $data                       = [];
        $data['limit']              = $this->input->post('limit');
        $data['caption']            = $this->input->post('caption');
        $data['description']        = $this->input->post('description');

        $data['thumb_width']        = $this->input->post('thumb_width');
        $data['thumb_height']       = $this->input->post('thumb_height');

        $data['medium_width']       = $this->input->post('medium_width');
        $data['medium_height']      = $this->input->post('medium_height');

        $data['large_width']        = $this->input->post('large_width');
        $data['large_height']       = $this->input->post('large_height');

        $data['watermark']          = $this->input->post('watermark');          // Yes / No
        $data['watermark_logo']     = 'watermark.png';            

        $data['watermark_opacity']  = $this->input->post('watermark_opacity');
        $data['position']           = $this->input->post('position');

        $json_data = \json_encode($data);
        file_put_contents(__DIR__ . '/../config/settings.json', $json_data);
    }
        


    public function albums() {
        // SELECT a.*, count(g.id) as photos FROM `gallery_albums` as a
        // LEFT JOIN gallery as g  ON g.album_id = a.id GROUP by g.album_id
        
        $gallery_albums_data = $this->db->get('gallery_albums')->result();                
        $this->viewAdminContent('gallery/albums', ['gallery_albums_data' => $gallery_albums_data]);
    }
    public function albums_list() {        
        $data = $this->db->get('gallery_albums')->result();
        return $data;
    }

    public function create_album() {
        ajaxAuthorized();
        
        $name       = $this->input->post('album_name');      
        $type       = $this->input->post('type');
        $slug       = ($this->input->post('slug')) ? $this->input->post('slug') : 'auto_'.time() .'_'. rand( 0,100);
        $created    = date('Y-m-d H:i:s');
        
        if( $this->isDuplicateAlbumSlug( $slug ) ){
            $slug = $slug . rand(0,999);
        }
                
        if ( $name == null ) {                               
            echo ajaxRespond('Fail','<p class="ajax_error"> Please Enter Album Name </p>');
            exit;                
        }
        
        if (empty($_FILES['thumb']['name'])) {
            echo ajaxRespond('Fail','<p class="ajax_error">Please Select Album Thumb</p>');
            exit;
        }
                       
        $data       = ['name' => $name, 'slug' => $slug, 'type' => $type, 'created' => $created ];
        $query      = $this->db->insert('gallery_albums', $data);
        $insert_id  = $this->db->insert_id();        
        $file_name = $this->uploadPhoto($_FILES['thumb'], 'gallery/albums', $insert_id); // File, Path/to/upload/location
        //dd($_FILES['file_ext']);
        $data = [ 'thumb' => $file_name ];
        //dd($data);
        $this->db->where('id', $insert_id );
        $this->db->update('gallery_albums', $data);
        
        echo ajaxRespond('OK', '<p class="ajax_success">New Abum Added Successfully</p>');
    }
    
    private function isDuplicateAlbumSlug( $slug = ''){
        $count = $this->db->get_where('gallery_albums')->num_rows();
        return $count;
        
    }


    public function delete_album() {
        ajaxAuthorized();
        $id = $this->input->post('id');
        //dd($id);
        
        $album = $this->db->get_where('gallery_albums', ['id' => $id])->row();
        $photofile = dirname ( BASEPATH ) .'/uploads/gallery/albums/' . $album->thumb;
        if($album->thumb && file_exists($photofile)){
            unlink($photofile);
        }
        
        $this->db->delete('gallery_albums', ['id' => $id]);
        
        echo ajaxRespond('OK', '<p class="ajax_success">Album Deleted Successfully</p>');
    }

    // Edit album form
    public function edit_album($id = null) {
        ajaxAuthorized();
        $album = $this->db->get_where('gallery_albums', ['id' => $id])->row();

        $action_url = base_url() . 'gallery/update_album/';

        $update_form = '<form action="' . $action_url . '" class="form-inline" method="POST" id="update_form">
                <div class="form-group">
                <input name="id" value="' . $id . '" type="hidden">
                <input class="form-control" name="album_name" value="' . $album->name . '" type="text"></div>  
                <button class="btn btn-success btn-sm" onclick="update_album(' . $id . ')" type="button" >Update</button>
            </form>';
        echo $update_form;
    }

    public function update_album() {
        ajaxAuthorized();
        
        $data = [ 'name' => $this->input->post('album_name') ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('gallery_albums', $data);
        
        echo ajaxRespond('OK', '<i class="fa fa-check-circle" aria-hidden="true"></i> ' . $this->input->post('album_name') );
    }

    public function settings() {

        $settings = json_decode(file_get_contents(__DIR__ . '/../config/settings.json'), true);
        $this->viewAdminContent('gallery/settings', [ 'settings' => $settings]);
    }

    
    
    public function upload_photo() {
        ajaxAuthorized();
        
        if (empty($_POST['album_id'])) {
            echo ajaxRespond('Fail','<p class="ajax_error">Please Select Album Name</p>');
            exit;
        }
        if (empty($_POST['title'])) {
            echo ajaxRespond('Fail','<p class="ajax_error">Please Enter Photo Title</p>');
            exit;
        }
        if (empty($_FILES['photo']['name'])) {
            echo ajaxRespond('Fail','<p class="ajax_error">Please Select gallery Photo</p>');
            exit;
        }
        $uploadPath = 'gallery';
        $rand = rand(000000000,999999999);
        $files_name = $this->uploadPhoto($_FILES['photo'], $uploadPath, $rand);

        
        $userRole = getLoginUserData('role_id');
        if(($userRole == 1) || ($userRole == 2) || ($userRole == 3)){
            $userID = $this->input->post( 'user_id' );
        } else {
            $userID = getLoginUserData('user_id');
        }
        
        $album_id = $this->input->post('album_id');
        $data                   = [];
        $data['photo']          = $files_name;
        $data['user_id']        = $userID;
        $data['title']          = $this->input->post('title');
        $data['album_id']       = $this->input->post('album_id');
        $data['description']    = $this->input->post('photo_description');
        $data['created']        = date('Y-m-d H:i:s');

        $this->Gallery_model->insert($data);
        $this->updateAlbumQty( $album_id );
        echo ajaxRespond('OK', '<p class="ajax_success"><b>Success!</b> Photo uploaded.</p>');
        
    }

    public function update($id) {
        $row = $this->Gallery_model->get_by_id($id);
        if ($row) {
            $data = [
                'page_title' => 'Update Photo',
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'gallery/update_action'),
                'id' => set_value('id', $row->id),
                'album_id' => set_value('album_id', $row->album_id),
                'title' => set_value('title', $row->title),
                'photo' => set_value('photo', $row->photo),
                'photo_description' => set_value('photo_description', $row->description),
                'gallery_albums' => $this->db->get('gallery_albums')->result(),
            ];

            $role_id = getLoginUserData('role_id');

            if ($role_id == 1 or $role_id == 2) {
                $this->viewAdminContent('gallery/upload_photo', $data);
            } else {
                $this->viewNewAdminContent('gallery/trader_upload_photo', $data);
            }

        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL . 'gallery'));
        }
    }
    
    public function update_video($id) {
        $row = $this->Gallery_model->get_by_id($id);
        $role_id = getLoginUserData('role_id');
        $canManageAlbum = 1; //checkMenuPermission('mange/all_gallery', $role_id);
        if ($row) {
            $data = [
                'page_title' => 'Update Video',
                'type' => 'update',
                'button'            => 'Update',
                'action'            => site_url( Backend_URL . 'gallery/update_video_action'),
                'id'                => set_value('id', $row->id),
                'title'             => set_value('title', $row->title),
                'caption'           => set_value('caption', $row->description),
                'canManageAlbum'    => $canManageAlbum,
                'album_id'          => set_value('album_id', $row->album_id),
                'video_id'          => set_value('video_id', $row->photo),
                'user_id'          => set_value('user_id', $row->user_id),
                'gallery_albums'    => $this->db->get('gallery_albums')->result(),
            ];
            $role_id = getLoginUserData('role_id');

            if ($role_id == 1 or $role_id == 2) {
                $this->viewAdminContent('gallery/upload_video', $data);
            } else {
                $this->viewNewAdminContent('gallery/trader_upload_video', $data);
            }

        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL . 'gallery'));
        }
    }
    
    public function update_video_action() {

        ajaxAuthorized();
        
        $photo_id           = $this->input->post('id', TRUE); 
        $album_id           = $this->input->post('album_id', TRUE);
        $video_id           = $this->input->post('video_code', TRUE);
        $caption            = $this->input->post('caption', TRUE);
        $title            = $this->input->post('title', TRUE);
        
                
        if (empty($video_id)) {
            echo ajaxRespond('Fail','<p class="ajax_error">Please Enter Video ID</p>');
            exit;
        }
        
        $userRole = getLoginUserData('role_id');
        if(($userRole == 1) || ($userRole == 2) || ($userRole == 3)){
            $userID = $this->input->post( 'user_id' );
        } else {
            $userID = getLoginUserData('user_id');
        }
        
        $data = [
            'album_id'    => $album_id,
            'title'       => $title,
            'photo'       => $video_id,
            'user_id'       => $userID,
            'description' => $caption,
        ];
        $this->Gallery_model->update($photo_id, $data);
        
        echo ajaxRespond('OK', '<p class="ajax_success"><strong>Success!</strong> Video Updated</p>');        
    }

    public function update_action() {

        ajaxAuthorized();
        
        $photo_id           = $this->input->post('id', TRUE); 
        $album_id           = $this->input->post('album_id', TRUE);
        $title              = $this->input->post('title', TRUE);
        $photo_description  = $this->input->post('photo_description', TRUE);
        
        if (empty($album_id)) {
            echo ajaxRespond('Fail','<p class="ajax_error">Please Select Album Name</p>');
            exit;
        }         
        if (empty($title)) {
            echo ajaxRespond('Fail','<p class="ajax_error">Please Enter Photo Title</p>');
            exit;
        }
                                
        if (empty($_FILES['photo']['name'])) {            
             $files_name = $this->input->post('old_img', TRUE);
        } else {
            $files_name = $this->input->post('old_img');                      
            $this->delete_photo_file( $files_name );
            $files_name = $this->uploadPhoto($_FILES['photo'], '/gallery', $photo_id );
        }
        
        $data = [
            'album_id'    => $album_id,
            'title'       => $title,
            'photo'       => $files_name,
            'description' => $photo_description,
        ];
        $this->Gallery_model->update($photo_id, $data);
        // $this->updateAlbumQty( $this->input->post('album_id', TRUE) );
        
        echo ajaxRespond('OK', '<p class="ajax_success"><strong>Success!</strong> Photo uploaded</p>');        
    }
    
    public function updateAlbumQty( $album_id = 0, $action = 'Plus' ){
        if($album_id){
            $albums     = $this->db->get_where('gallery_albums', ['id' => $album_id ])->row();

            $qty        = intval($albums->qty);        
            $new_qty    = ($action == 'Plus')  ? $qty + 1 : $qty - 1;

            $this->db->set('qty', $new_qty );
            $this->db->where('id', $album_id );
            $this->db->update('gallery_albums');
        }
    }
    
    public function album_update($id) {
        $row = $this->db->get_where('gallery_albums', ['id' => $id])->row();
        //dd($row);
        if ($row) {
            $data = [
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'gallery/album_update_action'),
                'id' => set_value('id', $row->id),
                'album_name' => set_value('album_name', $row->name),
                'type' => set_value('type', $row->type),
                'slug' => set_value('slug', $row->slug),
                'thumb' => set_value('thumb', $row->thumb),
                'gallery_albums' => $this->db->get('gallery_albums')->result(),
            ];
            $this->viewAdminContent('gallery/album_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL . 'gallery'));
        }
    }
    
    public function album_update_action() {

        ajaxAuthorized();
        
        $name       = $this->input->post('album_name', TRUE);      
        $type       = $this->input->post('type', TRUE);      
        $slug       = $this->input->post('slug', TRUE);      
        $slug       = ($slug) ? $slug : 'auto_'.time() .'_'. rand( 0,100);
        
        if( $this->isDuplicateAlbumSlug( $slug ) ){
            $slug = $slug . rand(0,999);
        }
                
        if ( $name == null ) {                               
            echo ajaxRespond('Fail','<p class="ajax_error"> Please Enter Album Name </p>');
            exit;                
        }
        
        $photo_id = $this->input->post('id', TRUE); 
                                
        if (empty($_FILES['thumb']['name'])) {            
             $files_name = $this->input->post('thumb_old', TRUE);
        } else {
            $files_name = $this->input->post('thumb_old');                      
            $this->delete_album_photo_file( $files_name );
            $files_name = $this->uploadPhoto($_FILES['thumb'], '/gallery/albums', $photo_id );           
        }
        
        $data = [
            'name'   => $this->input->post('album_name', TRUE),
            'type'   => $type,
            'slug'   => $slug,
            'thumb'  => $files_name,
        ];
        
        //dd($data);
        
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('gallery_albums', $data);
        
        echo ajaxRespond('OK', '<p class="ajax_success"><strong>Success!</strong> Albums uploaded</p>');        
    }
    
    private function delete_album_photo_file( $photo = false){
        $filename = dirname( BASEPATH ) . '/uploads/gallery/albums/'. $photo;
        if( $photo && file_exists($filename) ){
            unlink($filename); 
        }
    }

    public function delete() {        
        ajaxAuthorized();
        $id             = $this->input->post('id');
        $photo          = $this->input->post('photo');        
        $album_id       = $this->input->post('album_id');
        $row            = $this->Gallery_model->get_by_id($id);

        if ($row) {
           $this->Gallery_model->delete($id);
           $this->delete_photo_file( $photo );
           $this->updateAlbumQty( $album_id, 'Less' );
           echo ajaxRespond('OK', '<p class="ajax_success">Photo Deleted Successfully</p>');
        } else {
           echo ajaxRespond('Fail', '<p class="ajax_error">Fail! Photo Not Deleted</p>');
        }
    }

    private function delete_photo_file( $photo = false){
        $filename = dirname( BASEPATH ) . '/uploads/gallery/'. $photo;
        if($photo != 'no-thumb.gif' && $photo && file_exists($filename)){
            unlink($filename); 
        }
    }
   
    


    function getPhotoLink($photoName, $LightBoxSize) {
        return $this->getPhoto($photoName, $LightBoxSize, true);
    }
  

    // Thimthumb.php will be off .... 
    // 
    public function getPhoto($photoName, $PhotoThumb, $link = false) {
    
        $photoDir   = dirname(BASEPATH) . '/uploads/gallery/';
        $width      = $PhotoThumb[0];
        $height     = $PhotoThumb[1];
        $src        = base_url() . 'uploads/gallery/';

        $timthumb   = $src . 'timthumb.php' . '?src=' . $src;

        if ($link) {
            $photoName = ($photoName && file_exists($photoDir . $photoName)) ? $photoName : 'no-thumb.gif';
            return ($timthumb . $photoName . '&w=' . $width . '&h=' . $height);
        }

        if ($photoName && file_exists($photoDir . $photoName)) {
            return '<img src="' . $timthumb . $photoName . '&w=' . $width . '&h=' . $height . '">';
        } else {
            return '<img src="' . $timthumb . 'no-thumb.gif' . '&w=' . $width . '&h=' . $height . '">';
        }
    }
    
}
