<?php defined('BASEPATH') OR exit('No direct script access allowed');
   
/* Author: Khairul Azam
 * Date : 2016-10-11
 */

class Cms extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Cms_model');
        $this->load->model('Admin_review');
        $this->load->helper('cms');
        $this->load->library('form_validation');
    }

    public function index(){
        $q      = urldecode($this->input->get('q', TRUE)??'');
        $start  = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = Backend_URL. 'cms/?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'cms/?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'cms/';
            $config['first_url'] = Backend_URL . 'cms/';
        }

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Cms_model->total_rows($q);
        $cms = $this->Cms_model->get_limit_data($config['per_page'], $start, $q);

        
       
        
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'cms_data' => $cms,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
       
        
        $this->viewAdminContent('cms/index', $data);
    }

    

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/cms/create_action'),
	    'id' => set_value('id'),
	    'user_id' => set_value('user_id'),
	    'parent_id' => set_value('parent_id'),
	    'post_type' => set_value('post_type'),
	    'menu_name' => set_value('menu_name'),
	    'post_title' => set_value('post_title'),
	    'post_url' => set_value('post_url'),
	    'content' => set_value('content'),
	    'seo_title' => set_value('seo_title'),
	    'seo_keyword' => set_value('seo_keyword'),
	    'seo_description' => set_value('seo_description'),
	    'thumb' => set_value('thumb'),
	    'template' => set_value('template'),
	    'created' => set_value('created'),
	    'modified' => set_value('modified'),
	    'status' => set_value('status'),
	    'page_order' => set_value('page_order'),
	);
        $this->viewAdminContent('cms/form', $data);
    }
    
    public function create_action(){

        $handle = new Verot\Upload\Upload($_FILES['thumb']);
        if ($handle->uploaded) {
            $handle->file_name_body_pre = '';
            $handle->file_new_name_body = 'cms_photo_' . date('Y-m-d-H-i-s_') . rand(0, 9);
            $handle->allowed = array('image/*');
            $handle->image_resize = true;
            $handle->image_x = 810;
            $handle->image_ratio_y = true;

            $photo = $handle->file_name_body_pre . $handle->file_new_name_body . '.' . $handle->file_src_name_ext;


            $handle->process('uploads/cms_photos/');
            if ($handle->processed) {
                $photo = $photo;
                $handle->clean();
            } else {
                echo ajaxRespond('Fail', $handle->error);
            }
        }
        if (empty($_FILES['thumb']['name'])) {            
            $photo = 'default.jpg'; 
        } else {
            $photo = $photo;
        }       

        $data = array(
            'user_id'       => $this->input->post('user_id',TRUE),
            'parent_id'     => $this->input->post('parent_id',TRUE),
            'post_type'     => 'page',
            'menu_name'     => $this->input->post('post_title',TRUE),
            'post_title'    => $this->input->post('post_title',TRUE),
            'post_url'      => $this->input->post('post_url',TRUE),
            'content'       => $this->input->post('content',TRUE),
            'seo_title'     => $this->input->post('seo_title',TRUE),
            'seo_keyword'   => $this->input->post('seo_keyword',TRUE),
            'seo_description' => $this->input->post('seo_description',TRUE),
            'thumb'         => $photo,
            'template'      => $this->input->post('template',TRUE),
            'created'       => date('Y-m-d h:i:s'),
            'modified'      => date('Y-m-d h:i:s'),
            'status'        => $this->input->post('status',TRUE),
            'page_order'    => $this->input->post('page_order',TRUE),
        );

        $this->Cms_model->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('cms'));
            
    }
    
    public function update($id){
        $row = $this->Cms_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'cms/update_action'),
		'id' => set_value('id', $row->id),
		'user_id' => set_value('user_id', $row->user_id),
		'parent_id' => set_value('parent_id', $row->parent_id),
		'post_type' => set_value('post_type', $row->post_type),
		'menu_name' => set_value('menu_name', $row->menu_name),
		'post_title' => set_value('post_title', $row->post_title),
		'post_url' => set_value('post_url', $row->post_url),
		'content' => set_value('content', $row->content),
		'seo_title' => set_value('seo_title', $row->seo_title),
		'seo_keyword' => set_value('seo_keyword', $row->seo_keyword),
		'seo_description' => set_value('seo_description', $row->seo_description),
		'thumb' => set_value('thumb', $row->thumb),
		'template' => set_value('template', $row->template),		
		'status' => set_value('status', $row->status),
		'page_order' => set_value('page_order', $row->page_order),
	    );
            $this->viewAdminContent('cms/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cms'));
        }
    }
    
    public function update_action(){

        $page_id = $this->input->post('id',TRUE);
        
        $handle = new Verot\Upload\Upload($_FILES['thumb']);
        if ($handle->uploaded) {
            $handle->file_name_body_pre = '';
            $handle->file_new_name_body = 'cms_photo_' . date('Y-m-d-H-i-s_') . rand(0, 9);
            $handle->allowed = array('image/*');
            $handle->image_resize = true;
            $handle->image_x = 810;
            $handle->image_ratio_y = true;

            $photo = $handle->file_name_body_pre . $handle->file_new_name_body . '.' . $handle->file_src_name_ext;


            $handle->process('uploads/cms_photos/');
            if ($handle->processed) {
                    $photo = $photo;
                    $handle->clean();
                } else {
                    echo ajaxRespond('Fail', $handle->error);
                }
            }
            
            if (empty($_FILES['thumb']['name'])) {
                $page_pic = $this->db->get_where('cms', ['id' => $this->input->post('id')])->row();
                $photo = $page_pic->thumb;
            } else {
                $photo = $photo;
            }
        
            $content = $this->input->post('content');
            $search  = array('&lt;', '&gt;');
            $replace = array('<', '>');            
            $content = str_replace($search, $replace, $content);
            
            
        
            $data = array(
		'user_id' => $this->input->post('user_id',TRUE),
		'parent_id' => $this->input->post('parent_id',TRUE),
		'post_type' => 'page',		
		'menu_name' => $this->input->post('post_title',TRUE),
		'post_title' => $this->input->post('post_title',TRUE),
		'post_url' => $this->input->post('post_url',TRUE),
		'content' => $content,
		'seo_title' => $this->input->post('seo_title',TRUE),
		'seo_keyword' => $this->input->post('seo_keyword',TRUE),
		'seo_description' => $this->input->post('seo_description',TRUE),
		'thumb' => $photo,
		'template' => $this->input->post('template',TRUE),
		'modified' => date('Y-m-d h:i:s'),
		'status' => $this->input->post('status',TRUE),
		'page_order' => intval( $this->input->post('page_order',TRUE)),
	    );

            $this->Cms_model->update( $page_id, $data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Update Record Success<br/></p>');
            redirect(site_url( Backend_URL . 'cms/update/' . $page_id ));
        //}
    }
    
    public function delete($id){
        $row = $this->Cms_model->get_by_id($id);

        if ($row) {
            $this->Cms_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('cms/posts'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cms/posts'));
        }
    }

       
	
	
    // for using blog post 
    public function posts(){
        $q = urldecode($this->input->get('q', TRUE)??'');
        $start = intval($this->input->get('start'));
        if ($q <> '') {
            $config['base_url'] = base_url() . 'admin/cms/posts/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'admin/cms/posts/?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'admin/cms/posts/';
            $config['first_url'] = base_url() . 'admin/cms/posts/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
       $config['total_rows'] = $this->Cms_model->total_rows_post($q);

   
        $cms = $this->Cms_model->get_data_for_post($config['per_page'], $start, $q);
   
       
        
        $this->load->library('pagination');
        $this->pagination->initialize($config);

  
        $data = array(
            'post_data' => $cms,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        
        $this->viewAdminContent('cms/posts', $data);
    }

    public function update_status(){
        $post_id    = intval( $this->input->post('post_id') );
        $status     = $this->input->post('status');
        
        $this->db->set('status', $status)->where('id', $post_id)->update('cms');
        
        switch ($status){
            case 'Publish':
                $status = '<i class="fa fa-check"></i> Publish';
                $class = 'btn-success';
                break;
            case 'Trash':
                $status = '<i class="fa fa-trash-o"></i> Trash';
                $class = 'btn-danger';                
                break;
            case 'Draft':
                $status = '<i class="fa fa-file-o" ></i> Draft';
                $class = 'btn-default';
                break;
        }
           
        //echo  ajaxRespond('OK', $status);
        echo json_encode( ['Status' => $status . ' &nbsp; <i class="fa fa-angle-down"></i>', 'Class' => $class ]);
    }






    public function new_post(){
        $review = $this->db->where(['type' => 'category', 'name' => 'Review'])->get('cms_options')->row()->id;
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'cms/create_action_post'),
            'id' => set_value('id'),
            'user_id' => set_value('user_id'),
            'parent_id' => set_value('parent_id'),
            'post_type' => set_value('post_type'),
            'menu_name' => set_value('menu_name'),
            'post_title' => set_value('post_title'),
            'post_url' => set_value('post_url'),
            'content' => set_value('content'),
            'seo_title' => set_value('seo_title'),
            'seo_keyword' => set_value('seo_keyword'),
            'seo_description' => set_value('seo_description'),
            'thumb' => set_value('thumb'),
            'template' => set_value('template'),
            'created' => set_value('created'),
            'modified' => set_value('modified'),
            'status' => set_value('status'),
            'page_order' => set_value('page_order'),
            'review_id' => $review,
	);
        $this->viewAdminContent('cms/post_form', $data);
    }
    
    public function create_action_post(){
        $user_id = getLoginUserData('user_id');
        $handle = new Verot\Upload\Upload($_FILES['thumb']);

        if ($handle->uploaded) {
            $handle->file_name_body_pre = '';
            $handle->file_new_name_body = 'cms_photo_' . date('Y-m-d-H-i-s_') . rand(0, 9);
            $handle->allowed = array('image/*');
            $handle->image_resize = true;
            $handle->image_x = 450;
            $handle->image_ratio_y = true;

            $photo = $handle->file_name_body_pre . $handle->file_new_name_body . '.' . $handle->file_src_name_ext;


            $handle->process('uploads/cms_photos/');
            if ($handle->processed) {
                $photo = $photo;
                $handle->clean();
            } else {
                echo ajaxRespond('Fail', $handle->error);
            }
        }
        if (empty($_FILES['thumb']['name'])) {
            //$cat_pic = $this->db->get_where('cms_options', ['id' => $this->input->post('id')])->row();
            $photo = 'default.jpg'; //$cat_pic->thumb;
        } else {
            $photo = $photo;
        }

        $data = array(
            'user_id' => $user_id,
            'parent_id' => $this->input->post('parent_id',TRUE),
            'post_type' => 'post',
            'menu_name' => $this->input->post('post_title',TRUE),
            'post_title' => $this->input->post('post_title',TRUE),
            'post_url' => $this->input->post('post_url',TRUE),
            'content' => $this->input->post('content',TRUE),
            'seo_title' => $this->input->post('seo_title',TRUE),
            'seo_keyword' => $this->input->post('seo_keyword',TRUE),
            'seo_description' => $this->input->post('seo_description',TRUE),
            'thumb' => $photo,
            /// 'template' => $this->input->post('template',TRUE),
            'created' => date('Y-m-d h:i:s'),
            'modified' => date('Y-m-d h:i:s'),
            'status' => $this->input->post('status',TRUE),
            // 'page_order' => $this->input->post('page_order',TRUE),
	    );

        $is_inserted = $this->Cms_model->insert($data);

        $review = $this->db->where(['type' => 'category', 'name' => 'Review'])->get('cms_options')->row()->id;

        if ($is_inserted && $this->input->post('parent_id',TRUE) == $review) {
            $review_data = array(
                'cms_id' => $is_inserted,
                'vehicle_type_id' => $this->input->post('vehicle_id',TRUE),
                'brand_id' => $this->input->post('brand_id',TRUE),
                'model_id' => $this->input->post('model_id',TRUE),
            );
        }

        $this->Admin_review->insert($review_data);

        $this->session->set_flashdata('message', 'Create Record Success');

        redirect(site_url('cms/posts'));
    }
    
    public function update_post($id){
        $row = $this->Cms_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'cms/update_action_post'),
		'id' => set_value('id', $row->id),
		'user_id' => set_value('user_id', $row->user_id),
		'parent_id' => set_value('parent_id', $row->parent_id),
		'post_type' => set_value('post_type', $row->post_type),
		'menu_name' => set_value('menu_name', $row->menu_name),
		'post_title' => set_value('post_title', $row->post_title),
		'post_url' => set_value('post_url', $row->post_url),
		'content' => set_value('content', $row->content),
		'seo_title' => set_value('seo_title', $row->seo_title),
		'seo_keyword' => set_value('seo_keyword', $row->seo_keyword),
		'seo_description' => set_value('seo_description', $row->seo_description),
		'thumb' => set_value('thumb', $row->thumb),
		//'template' => set_value('template', $row->template),
		'created' => set_value('created', $row->created),
		'modified' => set_value('modified', $row->modified),
		'status' => set_value('status', $row->status),
		//'page_order' => set_value('page_order', $row->page_order),
	    );
            $this->viewAdminContent('cms/post_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cms'));
        }
    }
    
    public function update_action_post(){
            
        
        $handle = new Verot\Upload\Upload($_FILES['thumb']);
        if ($handle->uploaded) {
            $handle->file_name_body_pre = '';
            $handle->file_new_name_body = 'cms_photo_' . date('Y-m-d-H-i-s_') . rand(0, 9);
            $handle->allowed = array('image/*');
            $handle->image_resize = true;
            $handle->image_x = 450;
            $handle->image_ratio_y = true;

            $photo = $handle->file_name_body_pre . $handle->file_new_name_body . '.' . $handle->file_src_name_ext;


            $handle->process('uploads/cms_photos/');
            if ($handle->processed) {
                $photo = $photo;
                $handle->clean();
            } else {
                echo ajaxRespond('Fail', $handle->error);
            }
        }
        if (empty($_FILES['thumb']['name'])) {
            $blog_pic = $this->db->get_where('cms', ['id' => $this->input->post('id')])->row();
            $photo =  $blog_pic->thumb;
        } else {
            $photo = $photo;
        }
                                
        
            $data = array(
		'user_id' => $this->input->post('user_id',TRUE),
		'parent_id' => $this->input->post('parent_id',TRUE),
		'post_type' => 'post',
		'menu_name' => $this->input->post('post_title',TRUE),
		'post_title' => $this->input->post('post_title',TRUE),
		'post_url' => $this->input->post('post_url',TRUE),
		'content' => $this->input->post('content',TRUE),
		'seo_title' => $this->input->post('seo_title',TRUE),
		'seo_keyword' => $this->input->post('seo_keyword',TRUE),
		'seo_description' => $this->input->post('seo_description',TRUE),
		'thumb' => $photo,
		//'template' => $this->input->post('template',TRUE),
		//'created' => $this->input->post('created',TRUE),
		'modified' => date('Y-m-d h:i:s'),
		'status' => $this->input->post('status',TRUE),
		//'page_order' => $this->input->post('page_order',TRUE),
	    );

            
            
            $this->Cms_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('cms/posts'));
            
    }
    public function search_page(){
        $data = [];
        $data['data'] = $this->db->get('meta_title')->result();
        $this->viewAdminContent('cms/search_page', $data);
    }
    public function search_page_add(){
        $data['id'] = 0;
        $data['var'] = [];
        $data['title'] = '';
        $data['button'] = 'Create';
        $this->viewAdminContent('cms/search_page_form', $data);
    }

    public function search_page_update($id){
        $data = [];
        $exit = $this->db->where('id', $id)->get('meta_title')->row();
        if (!empty($exit)){
            $data['id'] = $id;
            $data['var'] = explode(',', $exit->var);
            $data['title'] = $exit->title;
            $data['button'] = 'Update';
            $this->viewAdminContent('cms/search_page_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Data Not Found');
            redirect(site_url(Backend_URL.'cms/search-page'));
        }

    }

    public function search_page_add_action(){
        $var = 'type';
        $fields = [];
        $id = $this->input->post('id');
        $this->db->where('id !=',$id);
        foreach ($this->input->post() as $k => $v){
            if ($v != 'no' && !in_array($k, ['id', 'meta_title'])){
                $var .= ','.$v;
                $fields[$k] = 1;
                $this->db->where($k,1);
            }

        }

        $exit = $this->db->get('meta_title')->row();

        if (empty($exit)){
            $this->db->where('id', $id);
            $this->db->delete('meta_title');

                $this->db->insert('meta_title', array_merge(['var' => $var, 'title' => $_POST['meta_title']],$fields));
                $this->session->set_flashdata('message', 'Search Seo Saved');
                redirect(site_url(Backend_URL.'cms/search-page'));

        } else {
            $this->session->set_flashdata('message', 'Same Search Seo Exist');
            redirect(site_url(Backend_URL.'cms/search-page'));
        }
    }

    public function search_page_delete($id){
        $this->db->where('id', $id);
        $this->db->delete('meta_title');
        $this->session->set_flashdata('message', 'The Search Seo Deleted');
        redirect(site_url(Backend_URL.'cms/search-page'));
    }

    

    public  function sidebarMenus(){
        return buildMenuForMoudle([
                    'module'    => 'CMS',
                    'icon'      => 'fa-users',
                    'href'      => 'cms',                    
                    'children'  => [
                        [
                            'title' => 'All Page',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'cms'
                        ],            
                        [
                            'title' => 'New Page',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'cms/create'
                        ],
                        [
                            'title' => 'All Post',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'cms/posts'
                        ],            
                        [
                            'title' => 'New Post',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'cms/new_post'
                        ],            
                        [
                            'title' => 'Category',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'cms/category'
                        ], 
                        [
                            'title' => 'CMS Menu',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'cms/menu'
                        ],
                        [
                            'title' => 'Search Page Seo',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'cms/search-page'
                        ],
                    ]        
                ]); 
    }
    


}