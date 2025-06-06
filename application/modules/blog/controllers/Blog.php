<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-10-11
 */

class Blog extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->helper('blog');
        $this->load->library('form_validation');
    }

    // for using blog post
    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE)??'');
        $start = intval($this->input->get('start'));
        if ($q <> '') {
            $config['base_url'] = base_url() . 'admin/blog/?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'admin/blog/?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'admin/blog/';
            $config['first_url'] = base_url() . 'admin/blog/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Blog_model->total_rows($q);


        $cms = $this->Blog_model->get_limit_data($config['per_page'], $start, $q);


        $this->load->library('pagination');
        $this->pagination->initialize($config);


        $data = array(
            'post_data' => $cms,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );

        $this->viewAdminContent('blog/posts', $data);
    }

    public function update_status()
    {
        $post_id = intval($this->input->post('post_id'));
        $status = $this->input->post('status');

        $this->db->set('status', $status)->where('id', $post_id)->update('blogs');

        switch ($status) {
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
        echo json_encode(['Status' => $status . ' &nbsp; <i class="fa fa-angle-down"></i>', 'Class' => $class]);
    }

    public function new_post()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'blog/create_action_post'),
            'id' => set_value('id'),
            'user_id' => set_value('user_id'),
            'category_id' => set_value('category_id'),
            'post_title' => set_value('post_title'),
            'post_url' => set_value('post_url'),
            'description' => set_value('description'),
            'seo_title' => set_value('seo_title'),
            'seo_keyword' => set_value('seo_keyword'),
            'seo_description' => set_value('seo_description'),
            'thumb' => set_value('thumb'),
            'created' => set_value('created'),
            'modified' => set_value('modified'),
            'status' => set_value('status'),
            'is_featured' => '0',
            'tags' => []
        );

        $this->viewAdminContent('blog/post_form', $data);
    }


    private function isDuplicateSlug($slug = '', $not = 0)
    {
        return $this->db->get_where('blogs', ['post_url' => $slug, 'id !=' => $not])->num_rows();
    }

    public function create_action_post()
    {

        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Please Input Required Field');
            redirect(site_url('admin/blog'));
        } else {
            $user_id = getLoginUserData('user_id');
            $handle = new Verot\Upload\Upload($_FILES['thumb']);

            if ($handle->uploaded) {
                $handle->file_name_body_pre = '';
                $handle->file_new_name_body = 'blog_photo_' . date('Y-m-d-H-i-s_') . rand(0, 9);
                $handle->allowed = array('image/*');
                $handle->image_resize = true;
                $handle->image_x = 450;
                $handle->image_ratio_y = true;

                $photo = $handle->file_name_body_pre . $handle->file_new_name_body . '.' . $handle->file_src_name_ext;


                $handle->process('uploads/blog_photos/');
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

            $slug = slugify($this->input->post('post_url', TRUE));

            if ($this->isDuplicateSlug($slug)) {
                $slug = $slug . rand(0000, 9999);
            }

            $data = array(
                'user_id' => $user_id,
                'category_id' => $this->input->post('category_id', TRUE),
                'post_title' => $this->input->post('post_title', TRUE),
                'post_url' => $slug,
                'description' => $this->input->post('description', TRUE),
                'seo_title' => $this->input->post('seo_title', TRUE),
                'seo_keyword' => $this->input->post('seo_keyword', TRUE),
                'seo_description' => $this->input->post('seo_description', TRUE),
                'thumb' => $photo,
                'created' => date('Y-m-d h:i:s'),
                'modified' => date('Y-m-d h:i:s'),
                'status' => $this->input->post('status', TRUE),
                'is_featured' => $this->input->post('is_featured', TRUE),
            );

            $blog_id = $this->Blog_model->insert($data);

            $tags = $this->input->post('tags');
            $tags_array = [];
            if ($tags[0] != '') {
                foreach ($tags as $tag) {
                    if (!is_numeric($tag)) {
                        $tag = $this->_create_tag($tag);
                    }
                    $tags_array[] = [
                        'blog_id' => $blog_id,
                        'tag_id' => $tag
                    ];
                }
                $this->db->insert_batch('blog_tag_ids', $tags_array);
            } else {
                $tags = [];
            }

            $this->session->set_flashdata('message', 'Create Record Success');

            redirect(site_url('admin/blog'));
        }
    }

    private function _create_tag($input)
    {
        $CI = &get_instance();
        $CI->db->from('blog_tags')->where('slug', slugify($input));
        $slug = $this->db->count_all_results();
        if ($slug != 0) {
            return false;
        }
        $data = array(
            'name' => $input,
            'slug' => slugify($input),
            'meta_title' => $input . ' News - Latest Breaking news and top headlines',
            'meta_description' => 'catch up with all the latest news , breaking stories, top headlines and opinion about ' . $input
        );
        $CI->db->insert('blog_tags', $data);
        $tag_id = $CI->db->insert_id();

        return $tag_id;
    }

    public function update_post($id)
    {
        $row = $this->Blog_model->get_by_id($id);

        if ($row) {
            $tags = $this->db->select('tag_id')->get_where('blog_tag_ids', ['blog_id' => $id])->result_array();
            $tags_array = array_map('current', $tags);
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'blog/update_action_post'),
                'id' => set_value('id', $row->id),
                'user_id' => set_value('user_id', $row->user_id),
                'category_id' => set_value('category_id', $row->category_id),
                'post_title' => set_value('post_title', $row->post_title),
                'post_url' => set_value('post_url', $row->post_url),
                'description' => set_value('description', $row->description),
                'seo_title' => set_value('seo_title', $row->seo_title),
                'seo_keyword' => set_value('seo_keyword', $row->seo_keyword),
                'seo_description' => set_value('seo_description', $row->seo_description),
                'thumb' => set_value('thumb', $row->thumb),
                'created' => set_value('created', $row->created),
                'modified' => set_value('modified', $row->modified),
                'status' => set_value('status', $row->status),
                'is_featured' => set_value('is_featured', $row->is_featured),
                'tags' => set_value('tags', $tags_array),
            );
            $this->viewAdminContent('blog/post_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/blog'));
        }
    }

    public function update_action_post()
    {

        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Please Input Required Field');
            redirect(site_url('admin/blog'));
        } else {
            $handle = new Verot\Upload\Upload($_FILES['thumb']);
            if ($handle->uploaded) {
                $handle->file_name_body_pre = '';
                $handle->file_new_name_body = 'blog_photo_' . date('Y-m-d-H-i-s_') . rand(0, 9);
                $handle->allowed = array('image/*');
                $handle->image_resize = true;
                $handle->image_x = 450;
                $handle->image_ratio_y = true;

                $photo = $handle->file_name_body_pre . $handle->file_new_name_body . '.' . $handle->file_src_name_ext;


                $handle->process('uploads/blog_photos/');
                if ($handle->processed) {
                    $photo = $photo;
                    $handle->clean();
                } else {
                    echo ajaxRespond('Fail', $handle->error);
                }
            }
            if (empty($_FILES['thumb']['name'])) {
                $blog_pic = $this->db->get_where('blogs', ['id' => $this->input->post('id')])->row();
                $photo = $blog_pic->thumb;
            } else {
                $photo = $photo;
            }


            $slug = slugify($this->input->post('post_url', TRUE));

            if ($this->isDuplicateSlug($slug, $this->input->post('id', TRUE))) {
                $slug = $slug . rand(0000, 9999);
            }

            $data = array(
                'user_id' => $user_id,
                'category_id' => $this->input->post('category_id', TRUE),
                'post_title' => $this->input->post('post_title', TRUE),
                'post_url' => $slug,
                'description' => $this->input->post('description', TRUE),
                'seo_title' => $this->input->post('seo_title', TRUE),
                'seo_keyword' => $this->input->post('seo_keyword', TRUE),
                'seo_description' => $this->input->post('seo_description', TRUE),
                'thumb' => $photo,
                'modified' => date('Y-m-d h:i:s'),
                'status' => $this->input->post('status', TRUE),
                'is_featured' => $this->input->post('is_featured', TRUE),
            );

            $this->db->where('blog_id', $this->input->post('id', TRUE));
            $this->db->delete('blog_tag_ids');
            $tags = $this->input->post('tags');
            $tags_array = [];
            if ($tags[0] != '') {
                foreach ($tags as $tag) {
                    if (!is_numeric($tag)) {
                        $tag = $this->_create_tag($tag);
                    }
                    $tags_array[] = [
                        'blog_id' => $this->input->post('id', TRUE),
                        'tag_id' => $tag
                    ];
                }
                $this->db->insert_batch('blog_tag_ids', $tags_array);
            } else {
                $tags = [];
            }


            $this->Blog_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/blog'));
        }

    }


    public function sidebarMenus()
    {
        return buildMenuForMoudle([
            'module' => 'Blog',
            'icon' => 'fa-users',
            'href' => 'blog',
            'children' => [
                [
                    'title' => 'Blog',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'blog'
                ],
                [
                    'title' => 'New Blog',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'blog/create'
                ],
                [
                    'title' => 'Category',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'blog/category'
                ]
            ]
        ]);
    }

    function get_tag()
    {
        if (!isset($_GET['term'])) {
            echo json_encode([]);
            return false;
        }
        $search = $_GET['term'];
        $ci = &get_instance();
        $ci->db->like('name', $search);
        $ci->db->limit(10);
        $query = $ci->db->get('blog_tags')->result();
        echo json_encode($query);
    }

    private function _rules()
    {
        $this->form_validation->set_rules('category_id', 'category_id', 'trim|required');
        $this->form_validation->set_rules('post_title', 'post_title', 'trim|required');
        $this->form_validation->set_rules('post_url', 'post_url', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


}