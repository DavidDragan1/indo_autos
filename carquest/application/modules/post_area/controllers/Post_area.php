<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-11-16
 */

class Post_area extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Post_area_model');
        $this->load->helper('post_area');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $post_areas = $this->Post_area_model->get_all();

//       
//        $post_areas = $this->db
//                    ->select('post_area.*, count(posts.location_id) as countPost')
//                    ->from('post_area')
//                    ->join('posts', 'post_area.id = posts.location_id', 'inner')
//                    ->group_by('posts.location_id')
//                    ->get()
//                    ->result();
        $data = ['states' => $post_areas];


        $this->viewAdminContent('post_area/index', $data);
    }


    public function read($id)
    {
        $row = $this->Post_area_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'name' => $row->name,
                'post_qty' => $row->post_qty,
                'is_home' => $row->is_home,
            );
            $this->viewAdminContent('post_area/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'post_area'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'post_area/create_action'),
            'id' => set_value('id'),
            'name' => set_value('name'),
            'post_qty' => set_value('post_qty'),
            'is_home' => set_value('is_home'),
            'country_id' => set_value('country_id'),
        );
        $this->viewAdminContent('post_area/form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $old = $this->db->where('slug', slugify($this->input->post('slug', TRUE)))->get('post_area')->row();
            if (!empty($old)) {
                $this->session->set_flashdata('error', 'Slug Already in use');
                redirect(site_url(Backend_URL . 'post_area'));
            } else {
                $data = array(
                    'name' => $this->input->post('name', TRUE),
                    'post_qty' => $this->input->post('post_qty', TRUE),
                    'is_home' => $this->input->post('is_home', TRUE),
                    'slug' => slugify($this->input->post('slug', TRUE)),
                    'country_id' => slugify($this->input->post('country_id', TRUE)),
                );

                $this->Post_area_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url(Backend_URL . 'post_area'));
            }

        }
    }

    public function create_location()
    {
        $this->_rules_location();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $old = $this->db->where('slug', slugify($this->input->post('slug', TRUE)))->get('post_area')->row();
            if (!empty($old)) {
                $this->session->set_flashdata('error', 'Slug Already in use');
                redirect(site_url(Backend_URL . 'post_area'));
            } else {
                $data = array(
                    'name' => $this->input->post('name', TRUE),
                    'post_qty' => 0,
                    'is_home' => "No",
                    'parent_id' => $this->input->post('parent_id', TRUE),
                    'type' => 'location',
                    'slug' => slugify($this->input->post('slug', TRUE))
                );

                $this->Post_area_model->insert($data);

                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url(Backend_URL . 'post_area'));
            }

        }
    }

    public function update($id)
    {
        $row = $this->Post_area_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'post_area/update_action'),
                'id' => set_value('id', $row->id),
                'name' => set_value('name', $row->name),
                'post_qty' => set_value('post_qty', $row->post_qty),
                'is_home' => set_value('is_home', $row->is_home),
                'type' => set_value('type', $row->type),
                'parent_id' => set_value('parent_id', $row->parent_id),
                'slug' => set_value('slug', $row->slug),
            );
            $this->viewAdminContent('post_area/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'post_area'));
        }
    }

    public function update_action()
    {
        $old = $this->db->where('slug', slugify($this->input->post('slug', TRUE)))->where('id !=', $this->input->post('id', TRUE))->get('post_area')->row();
        if (!empty($old)) {
            $this->session->set_flashdata('error', 'Slug Already in use');
            redirect(site_url(Backend_URL . 'post_area'));
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'post_qty' => $this->input->post('post_qty', TRUE),
                'is_home' => $this->input->post('is_home', TRUE),
                'type' => $this->input->post('type', TRUE),
                'parent_id' => $this->input->post('parent_id', TRUE),
                'slug' => slugify($this->input->post('slug', TRUE)),
                'country_id' => slugify($this->input->post('country_id', TRUE)),
            );

            $this->Post_area_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url(Backend_URL . 'post_area'));
        }
    }

    public function delete($id)
    {
        $row = $this->Post_area_model->get_by_id($id);

        if ($row) {
            $this->Post_area_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url(Backend_URL . 'post_area'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'post_area'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('post_qty', 'post qty', 'trim|required');
        $this->form_validation->set_rules('is_home', 'is home', 'trim|required');
        $this->form_validation->set_rules('slug', 'Slug', 'trim|required');
        $this->form_validation->set_rules('country_id', 'country_id', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    public function _rules_location()
    {
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('parent_id', 'parent_id', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}