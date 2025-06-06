<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2017-11-16
 */

class Files extends Admin_controller {

    private $manage_all = false;

    function __construct() {
        parent::__construct();
        $this->load->model('Files_model');
        $this->load->helper('files');
        $this->load->library('form_validation');
        $this->manage_all = checkPermission('files/manage_all', $this->role_id);
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE)??'');
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'files/?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'files/?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'files/';
            $config['first_url'] = Backend_URL . 'files/';
        }

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Files_model->total_rows($q);
        $files = $this->Files_model->get_limit_data($config['per_page'], $start, $q);

        if(in_array($this->role_id, [1,2])){
            $this->load->library('pagination');
            $this->pagination->initialize($config);
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
        }
        $data = array(
            'files' => $files,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        
        if(in_array($this->role_id, [1,2])){
            $this->viewAdminContent('files/files/index', $data);
        } else {
            $this->viewNewAdminContent('files/files/trader_index', $data);
        }
        
    }
    
    
    
    public function download() {
        $file   = urldecode($this->input->get('file', TRUE));        
        if(empty($file)){  redirect( 'admin/files' ); }
        
        $this->load->helper('download');        
        $content = file_get_contents( dirname(BASEPATH) . '/' . $file );                
        force_download($file,$content);          
    }

    //Create
    //Update
    public function create() {
        
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'files/upload'),
	    'id' => set_value('id'),
	    'user_id' => set_value('user_id', $this->user_id),
	    // 'category' => set_value('category'),
	    'title' => set_value('title'),
	    'attach' => set_value('attach'),
	    'attach_size' => set_value('attach_size'),
	    'created' => set_value('created'),
	    'modified' => set_value('modified'),
	);
        $this->viewAdminContent('files/files/create', $data);
    }

    
    
    public function upload() {
        $file_location = '';
        $path = 'uploads/files/' . date('Y/m/');
        

        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $handle = new Verot\Upload\Upload($_FILES['file']);
            if ($handle->uploaded) {
                $handle->file_new_name_body = 'file_' . time();                
                $handle->process($path);
                if ($handle->processed) {
                    $file_location = $handle->file_dst_pathname;
                    $handle->clean();
                }
            }            
            
            $data = array(
                'user_id' => $this->user_id,
                'title' => $this->input->post('title', TRUE),
                // 'category' => $this->input->post('category', TRUE),
                'attach' => $file_location,
                'attach_size' => $handle->file_src_size,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            );

            $this->Files_model->insert($data);
            $this->session->set_flashdata('message', '<p class="ajax_success">File Upload Success</p>');
            redirect(site_url( Backend_URL. 'files'));
        }  
    }

    //Read
    public function preview() {
        $id = $this->input->post('id');
        $row = $this->Files_model->get_by_id($id);
        if ($row) {
            echo $this->preview_attachment($row->attach);
        } else {
            echo 'Not Found.';
        }
    }

    function preview_attachment($file = '') {
        if (empty($file)) {
            return '<p>No File Attachment</p>';
        } else {
            $ext = findexts($file);
            $file_path = urlencode(FCPATH . $file);

            if (file_exists(FCPATH . $file)) {
                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png') {
                    return '<div class="content" style="overflow: auto;"><img class="img-thumbnail img-responsive lazyload" src="' . base_url($file) . '"/><a href="' . base_url() . 'uploads/download.php?file=' . base_url(urlencode($file)) . '" class="btn btn-default" title="Download Image"><i class="fa fa-download" aria-hidden="true"></i></a></div>';
                } elseif ($ext == 'doc' || $ext == 'xls' || $ext == 'xlsx' || $ext == 'pdf' || $ext == 'docx' || $ext == 'odt' || $ext == 'txt' || $ext == 'sql') {
                    return '<div class="embed-responsive embed-responsive-4by3"><iframe src="http://docs.google.com/viewer?url=' . $file_path . '&embedded=true" width="100%" height="450"></iframe></div>';
                } elseif ($ext == 'mp4' || $ext == 'avi' || $ext == '3gp') {
                    return "<i class='fa fa-video-camera' aria-hidden='true'></i>"
                            . "It is a video file please <strong><i class='fa fa-download' aria-hidden='true'></i> " . download_attachment($file) . "</strong> to preview.";
                } elseif ($ext == 'zip' || $ext == 'rar') {
                    return "<i class='fa fa-file-archive-o' aria-hidden='true'>"
                            . "</i> It is a compress file please <strong><i class='fa fa-download' aria-hidden='true'></i> " . download_attachment($file) . "</strong> it.";
                } else {
                    return "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Unknown File Format to preview.";
                }
            } else {
                return 'File Not Exists';
            }
        }
    }

    //Update
    public function update($id) {
        $row = $this->Files_model->get_by_id($id);
        $data = array(
            'action'    => site_url( Backend_URL . 'files/update_action'),
            'id'        => $row->id,
            'user_id'   => $row->user_id,
            // 'category'  => $row->category,
            'title'     => $row->title,
            'attach'    => $row->attach,
        );
        $this->viewAdminContent('files/files/update', $data);
    }

    public function update_action() {
        $file_location = '';
        $path = 'uploads/files/' . date('Y/m/');
        $handle = new Verot\Upload\Upload($_FILES['file']);
        if ($handle->uploaded) {
            $handle->file_new_name_body = 'file_' . time();
            $handle->process($path);
            if ($handle->processed) {
                $file_location = $handle->file_dst_pathname;
                $handle->clean();
            }
        }
                
        $data = array(
            'title'     => $this->input->post('title'),
            // 'category'  => $this->input->post('category', TRUE),
            'attach'    => $file_location ? $file_location : $this->input->post('old_attach'),
            'attach_size' => $handle->file_src_size,
            'modified'  => date('Y-m-d H:i:s')
        );

        if (!empty($file_location)) {
            $this->delete_file($this->input->post('old_attach'));
        }

        $id = $this->input->post('id');
        $this->Files_model->update($id, $data);

        $this->session->set_flashdata('message', '<p class="ajax_success">Data Updated Successlly</p>');
        redirect(site_url( Backend_URL. 'files/update/'. $id ));
        
    }

    //Delete
    public function delete( $id ) {                
        $row = $this->Files_model->get_by_id($id);               
        if ($row) {
            $this->delete_file($row->attach);
            $this->Files_model->delete($id);
            $this->session->set_flashdata('message', '<p class="ajax_success">Delete Record Success</p>');
            redirect(site_url( Backend_URL. 'files'));
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'files'));
        }
                
    }

    private function delete_file($file = null) {
        $file_path = dirname(BASEPATH) . '/' . $file;
        if ($file && file_exists($file_path)) {
            unlink($file_path);
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('title', 'title', 'trim|required');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    
    
    
    public  function menus(){
       
            return buildMenuForMoudle([
                'module'    => 'Vehicle Price Guide',
                'icon'      => 'fa fa-file',
                'href'      => 'files',                    
                'children'  => [
                    [
                        'title' => 'All Files',
                        'icon'  => 'fa fa-bars',
                        'href'  => 'files'
                    ],
                    [
                        'title' => ' |__ Upload New',
                        'icon'  => 'fa fa-plus',
                        'href'  => 'files/create'
                    ] 
                ]
            ]); 
       
    }

    public  function newMenus(){

        return buildNewMenuForMoudle([
            'module'    => 'Vehicle Price Guide',
            'img'      => 'assets/theme/new/images/backend/sidebar/gallery.svg',
            'hover'      => 'assets/theme/new/images/backend/sidebar/gallery-h.svg',
            'href'      => 'files',
            'id'      => 'Guide',
            'children'  => [
                [
                    'title' => 'All Files',
                    'img'  => 'assets/theme/new/images/backend/sidebar/photo.svg',
                    'hover'  => 'assets/theme/new/images/backend/sidebar/photo-h.svg',
                    'href'  => 'files'
                ],
                [
                    'title' => ' |__ Upload New',
                    'img'  => 'assets/theme/new/images/backend/sidebar/photo.svg',
                    'hover'  => 'assets/theme/new/images/backend/sidebar/photo-h.svg',
                    'href'  => 'files/create'
                ]
            ]
        ]);

    }
}
