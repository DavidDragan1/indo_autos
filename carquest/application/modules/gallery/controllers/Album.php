<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 25th Oct 2016
 * From : inside Egale Poribahan ( :P )
 */

die('File Not in Use');

class Album extends Admin_controller {

    const PhotoCaption = false;
    const AlbumCaption = true;

    // Setting Name         = array( Width, Height);
    public $AlbumThumb      = array(208, 200); // Width x Height
    public $PhotoThumb      = array(205, 170); // Width x Height
    public $LightBoxSize    = array(850, 550); // Width x Height

    function __construct() {
        parent::__construct();
        $this->load->model('Gallery_model');
        $this->load->library('form_validation');
        $this->load->helper('gallery');        
    }

    public function index() {
        $gallery_albums_data = $this->db->get('gallery_albums')->result();
        $this->viewAdminContent('gallery/albums', ['gallery_albums_data' => $gallery_albums_data]);
    }

    public function create_album() {
        ajaxAuthorized();
        
        $name = $this->input->post('album_name');
        $slug = ($this->input->post('slug')) ? $this->input->post('slug') : 'auto_'.time() .'_'. rand( 0,100);
        $created = date('Y-m-d H:i:s');
        
        if ( $name == null ) {
            $msg = 'Please Enter Proper Name.';           
        } else {
           
           if (empty($_FILES['photo']['name'])) {
            die(json_encode([
                'status' => 'Fail',
                'msg' => '<div class="alert alert-danger"><strong>Fail!</strong> File is emapty </div>']));
        }

             $uploadPath = 'albums';
             $files_name = $this->uploadPhoto($_FILES['thumb'], $uploadPath);
            
            
            
            $data   = ['name' => $name, 'slug' => $slug,'thumb'=>$files_name, 'created' => $created ];
            $query  = $this->db->insert('gallery_albums', $data);
            $msg    = ($query)  
                        ? 'New Abum Added Successfully'                
                        : 'Album  Not Add! Please Try Again';            
        } 
        echo ajaxRespond('OK', $msg);
    }
   

    public function delete_album() {
        ajaxAuthorized();
        $id = $this->input->post('id');
        $this->db->delete('gallery_albums', ['id' => $id]);
        echo ajaxRespond('OK', 'Album Deleted Successfully');
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


    /* Autho Rabita
     * Date: 06th Oct 2016
     * Photo Gallery
     * Photo Upload Method
     */
    public function view_album() {
        $this->viewPublicContent('gallery/view_album');
    }    
}
