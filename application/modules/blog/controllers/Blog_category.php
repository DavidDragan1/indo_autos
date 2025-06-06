<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Mukul Hosen
 * Date : 2021-11-02
 */

class Blog_category extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->load->model('BlogCategory_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $cms_options = $this->BlogCategory_model->get_cats();

        $data = array(
            'blog_categories' => $cms_options
        );

        $this->viewAdminContent('blog/category/index', $data);
    }

    public function create() {
        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'cms/category/create_action'),
            'id' => set_value('id'),
            'parent' => set_value('parent'),
            'type' => set_value('type'),
            'name' => set_value('name'),
            'url' => set_value('url'),
            'template' => set_value('template'),
            'description' => set_value('description'),
            'thumb' => set_value('thumb'),
        );
        $this->viewAdminContent('cms_options/form', $data);
    }
    private function isDuplicateSlug( $slug = '', $not = 0 ){
        return $this->db->get_where('blog_category', ['slug' => $slug, 'id !=' => $not])->num_rows();
    }
    public function create_action() {
         $this->_rules();
        if ($this->form_validation->run() == FALSE) {
         $this->create();
         } else {
        $slug = slugify($this->input->post('slug', TRUE));

            if( $this->isDuplicateSlug( $slug ) ){
                $slug = $slug . rand(0000,9999);
            }


        $data = array(
            'name' => $this->input->post('name', TRUE),
            'slug' => $slug,
            'menu_order' => $this->input->post('menu_order', TRUE),
            'seo_title' => $this->input->post('seo_title', TRUE),
            'seo_keyword' => $this->input->post('seo_keyword', TRUE),
            'seo_description' => $this->input->post('seo_description', TRUE),
        );

        $this->BlogCategory_model->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url(Backend_URL . 'blog/category'));

         }
    }

    public function update($id) {
        $row = $this->BlogCategory_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'blog/category/update_action'),
                'id' => set_value('id', $row->id),
                'name' => set_value('name', $row->name),
                'slug' => set_value('url', $row->slug),
                'menu_order' => set_value('menu_order', $row->menu_order),
                'seo_title' => set_value('seo_title', $row->seo_title),
                'seo_keyword' => set_value('seo_keyword', $row->seo_keyword),
                'seo_description' => set_value('seo_description', $row->seo_description),
            );
            $this->viewAdminContent('blog/category/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'cms/category'));
        }
    }

    public function update_action() {
         $this->_rules();
          if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {

              $slug = slugify($this->input->post('slug', TRUE));

              if( $this->isDuplicateSlug( $slug , $this->input->post('id', TRUE)) ){
                  $slug = $slug .'-'. rand(0000,9999);
              }

        $data = array(
            'name' => $this->input->post('name', TRUE),
            'slug' => $slug,
            'menu_order' => $this->input->post('menu_order', TRUE),
            'seo_title' => $this->input->post('seo_title', TRUE),
            'seo_keyword' => $this->input->post('seo_keyword', TRUE),
            'seo_description' => $this->input->post('seo_description', TRUE),
        );
        

        $this->BlogCategory_model->update($this->input->post('id', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url(Backend_URL . 'blog/category'));
         }
    }

    public function delete($id) {
        $row = $this->BlogCategory_model->get_by_id($id);

        if ($row) {
            $this->BlogCategory_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url(Backend_URL . 'blog/category'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'blog/category'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('slug', 'slug', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
