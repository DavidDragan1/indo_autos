<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-11-04
 */

class Cms_options extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Cms_options_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $cms_options = $this->Cms_options_model->get_cats();

        $data = array(
            'cms_options_data' => $cms_options
        );

        $this->viewAdminContent('cms_options/index', $data);
    }

    public function read($id) {
        $row = $this->Cms_options_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'parent' => $row->parent,
                'type' => $row->type,
                'name' => $row->name,
                'url' => $row->url,
                'template' => $row->template,
                'description' => $row->description,
                'thumb' => $row->thumb,
            );
            $this->viewAdminContent('cms_options/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'cms_options'));
        }
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

    public function create_action() {
        // $this->_rules();
        //if ($this->form_validation->run() == FALSE) {
        // $this->create();
        // } else {




        $handle = new \Verot\Upload\Upload($_FILES['thumb']);
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

            $photo = 'default.jpg';
        } else {
            $photo = $photo;
        }





        $data = array(
            'parent' => $this->input->post('parent', TRUE),
            'type' => 'category',
            'name' => $this->input->post('name', TRUE),
            'url' => $this->input->post('url', TRUE),
            //'template' => $this->input->post('template',TRUE),
            //'description' => $this->input->post('description',TRUE),
            'thumb' => $photo,
        );

        $this->Cms_options_model->insert($data);
        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url(Backend_URL . 'cms/category'));

        // }
    }

    public function update($id) {
        $row = $this->Cms_options_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'cms/category/update_action'),
                'id' => set_value('id', $row->id),
                'parent' => set_value('parent', $row->parent),
                'type' => set_value('type', $row->type),
                'name' => set_value('name', $row->name),
                'url' => set_value('url', $row->url),
                'template' => set_value('template', $row->template),
                'description' => set_value('description', $row->description),
                'thumb' => set_value('thumb', $row->thumb),
            );
            $this->viewAdminContent('cms_options/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'cms/category'));
        }
    }

    public function update_action() {
        // $this->_rules();
        //  if ($this->form_validation->run() == FALSE) {
        //    $this->update($this->input->post('id', TRUE));
        //} else {

        
      
        $handle = new upload($_FILES['thumb']);
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
            $cat_pic = $this->db->get_where('cms_options', ['id' => $this->input->post('id')])->row();
            $photo = $cat_pic->thumb;
        } else {
            $photo = $photo;
        }




        $data = array(
            'parent' => $this->input->post('parent', TRUE),
            'type' => 'category',
            'name' => $this->input->post('name', TRUE),
            'url' => $this->input->post('url', TRUE),
            //'template' => $this->input->post('template',TRUE),
            'description' => $this->input->post('description', TRUE),
            'thumb' => $photo,
        );
        

        $this->Cms_options_model->update($this->input->post('id', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url(Backend_URL . 'cms/category'));
        // }
    }

    public function delete($id) {
        $row = $this->Cms_options_model->get_by_id($id);

        if ($row) {
            $this->Cms_options_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url(Backend_URL . 'cms/category'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'cms/category'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('parent', 'parent', 'trim|required');
        $this->form_validation->set_rules('type', 'type', 'trim|required');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('url', 'url', 'trim|required');
        $this->form_validation->set_rules('template', 'template', 'trim|required');
        $this->form_validation->set_rules('description', 'description', 'trim|required');
        $this->form_validation->set_rules('thumb', 'thumb', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
