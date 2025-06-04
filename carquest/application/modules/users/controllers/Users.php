<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-10-05
 */


class Users extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->helper('users');
        $this->load->helper('profile/profile');
        $this->load->library('form_validation');
    }

    public function index()
    {

        $q = urldecode($this->input->get('q', TRUE)?$this->input->get('q', TRUE):'');
        $start = intval($this->input->get('start'));
        $status = urldecode($this->input->get('status', TRUE)?$this->input->get('status', TRUE):'');
        $range = urldecode($this->input->get('range', TRUE)?$this->input->get('range', TRUE):'');
        $fd = urldecode($this->input->get('fd', TRUE)?$this->input->get('fd', TRUE):'');
        $td = urldecode($this->input->get('td', TRUE)?$this->input->get('td', TRUE):'');
        $role = urldecode($this->input->get('role', TRUE)?$this->input->get('role', TRUE):0);
        if ($q <> '' || $range <> '' || $status <> '' || $role <> '' || $fd <> '' || $td <> '') {
            $config['base_url'] = Backend_URL . 'users?q=' . urlencode($q) . '&range=' . urlencode($range) . '&role=' . urlencode($role) . '&status=' . urlencode($status) . '&fd=' . urlencode($fd) . '&td=' . urlencode($td);
            $config['first_url'] = Backend_URL . 'users?q=' . urlencode($q) . '&range=' . urlencode($range) . '&role=' . urlencode($role) . '&status=' . urlencode($status) . '&fd=' . urlencode($fd) . '&td=' . urlencode($td);
        } else {
            $config['base_url'] = Backend_URL . 'users/';
            $config['first_url'] = Backend_URL . 'users/';
        }

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Users_model->total_rows($q, $range, $status, $role, $fd, $td);

        $users = $this->Users_model->get_limit_data($config['per_page'], $start, $q, $range, $status, $role, $fd, $td);
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'users_data' => $users,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'status' => $status,
            'range' => $range,
            'fd' => $fd,
            'td' => $td,
            'role' => $role
        );
        $this->viewAdminContent('users/index', $data);
    }


    public function profile($id)
    {
        $row = $this->Users_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'role_id' => getRoleName($row->role_id),
                'title' => $row->title,
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'email' => $row->email,
                'password' => $row->password,
                'contact' => $row->contact,
                'contact1' => $row->contact1,
                'contact2' => $row->contact2,
                'dob' => $row->dob,
                'add_line1' => $row->add_line1,
                'add_line2' => $row->add_line2,
                'city' => $row->city,
                'state' => $row->state,
                'postcode' => $row->postcode,
                'country_id' => getCountryName($row->country_id),
                'created' => $row->created,
                'last_access' => $row->last_access,
                'profile_photo' => $row->profile_photo,
                'status' => $row->status,
                'role' => $row->role_id
            );
            $row = $this->Users_model->get_by_id($id);


            $this->viewAdminContent('users/profile', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'users'));
        }
    }


    public function mails($id)
    {
        $data = [];
        $this->viewAdminContent('users/mails', $data);
    }

    public function create()
    {
        $this->viewAdminContent('users/add_user');
    }

    public function create_action()
    {
        $yy = $this->input->post('yy');
        $mm = $this->input->post('mm');
        $dd = $this->input->post('dd');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {

            echo ajaxRespond('Fail', form_error('your_email'));

        } else {
            $data = array(
                'role_id' => intval($this->input->post('role_id', TRUE)),
                'first_name' => $this->input->post('first_name', TRUE),
                'last_name' => $this->input->post('last_name', TRUE),
                'email' => $this->input->post('your_email', TRUE),
                'password' => password_encription($this->input->post('password', TRUE)),
                'contact' => $this->input->post('contact', TRUE),
                'contact1' => $this->input->post('contact1', TRUE),
                'contact2' => $this->input->post('contact2', TRUE),
                'dob' => $yy . '-' . $mm . '-' . $dd,
                'add_line1' => $this->input->post('add_line1', TRUE),
                'add_line2' => $this->input->post('add_line2', TRUE),
                'city' => $this->input->post('city', TRUE),
                'state' => $this->input->post('state', TRUE),
                'postcode' => $this->input->post('postcode', TRUE),
                'country_id' => $this->input->post('country_id', TRUE),
                'created' => date("Y-m-d"),
                'status' => $this->input->post('status', TRUE),
            );

            $this->Users_model->insert($data);
            echo ajaxRespond('OK', '<p class="ajax_success">User Registed Successfully</p>');
        }
    }

    public function update($id)
    {
        $row = $this->Users_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('users/update_action'),
                'id' => set_value('id', $row->id),
                'role_id' => set_value('role_id', $row->role_id),
                'title' => set_value('title', $row->title),
                'first_name' => set_value('first_name', $row->first_name),
                'last_name' => set_value('last_name', $row->last_name),
                'email' => set_value('email', $row->email),
                'contact' => set_value('contact', $row->contact),
                'contact1' => set_value('contact1', $row->contact1),
                'contact2' => set_value('contact2', $row->contact2),
                'dob' => set_value('dob', $row->dob),
                'add_line1' => set_value('add_line1', $row->add_line1),
                'add_line2' => set_value('add_line2', $row->add_line2),
                'city' => set_value('city', $row->city),
                'state' => set_value('state', $row->state),
                'postcode' => set_value('postcode', $row->postcode),
                'country_id' => set_value('country_id', $row->country_id),
                'created' => set_value('created', $row->created),
                'last_access' => set_value('last_access', $row->last_access),
                'profile_photo' => set_value('profile_photo', $row->profile_photo),
                'old_img' => set_value('old_img', $row->profile_photo),
                'status' => set_value('status', $row->status),
            );

//            echo '<pre>';
//            print_r($data);
//            die;
            $this->viewAdminContent('users/edit_user', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
        }
    }

    public function update_action()
    {

        //dd( $_POST );
        // dd( $_FILES );
//        $this->_rules();
//
//        if ($this->form_validation->run() == FALSE) {
//            $this->update($this->input->post('id', TRUE));
//        } else {

        $date = $this->input->post('yy') . '-' . $this->input->post('mm') . '-' . $this->input->post('dd');

        if (!empty($_FILES['profile_photo']['name'])) {
            $img = $this->image_upload($_FILES['profile_photo']);
        } else {
            $img = $this->input->post('old_img');
        }


        $data = array(
            'role_id' => $this->input->post('role_id', TRUE),
            'title' => $this->input->post('title', TRUE),
            'first_name' => $this->input->post('first_name', TRUE),
            'last_name' => $this->input->post('last_name', TRUE),
            'email' => $this->input->post('email', TRUE),
            'contact' => $this->input->post('contact', TRUE),
            'contact1' => $this->input->post('contact1', TRUE),
            'contact2' => $this->input->post('contact2', TRUE),
            'dob' => $date,
            'add_line1' => $this->input->post('add_line1', TRUE),
            'add_line2' => $this->input->post('add_line2', TRUE),
            'city' => $this->input->post('city', TRUE),
            'state' => $this->input->post('state', TRUE),
            'postcode' => $this->input->post('postcode', TRUE),
            'country_id' => $this->input->post('country_id', TRUE),
            'profile_photo' => $img,
            'status' => $this->input->post('status', TRUE),
        );
        $this->Users_model->update($this->input->post('id', TRUE), $data);
        echo '<p class="ajax_success">Update Successfully</p>';
        // }
    }

    public function delete($id)
    {
        $row = $this->Users_model->get_by_id($id);

        $this->db->where('id', $id);
        $this->db->delete('users');

        $post_ids = $this->db->select('id')->where('user_id', $id)->get('posts')->result();

        foreach ($post_ids as $post_id){
            $photos = $this->db->get_where('post_photos', ['post_id' => $post_id->id])
                ->result();

            foreach ($photos as $photo) {
                $fileName   = $photo->photo;
                $filePath   = dirname(BASEPATH) . '/uploads/car/' . $fileName;
                if ($fileName && file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            $this->db->where('post_id', $post_id->id )->delete('post_photos');

            $this->db->where('id', $post_id->id)->delete('posts');

        }

//        $this->viewAdminContent('delete');

        redirect('admin/users');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required');
        $this->form_validation->set_rules('your_email', 'your email', 'trim|valid_email|required|is_unique[users.email]',
            ['is_unique' => 'This email already in used', 'valid_email' => 'Enter a valide email address']);

        $this->form_validation->set_rules('role_id', 'role_id', 'required');
        $this->form_validation->set_rules('password', 'password field', 'required');
        $this->form_validation->set_error_delimiters('<p class="ajax_error">', '</p>');
    }

    private function image_upload($photo, $id = 0)
    {
        $handle = new Verot\Upload\Upload($photo);
        if ($handle->uploaded) {
            $prefix = $id;
            $handle->file_new_name_body = 'user_photo';
            $handle->image_resize = true;
            $handle->image_x = 400;
            $handle->image_ratio_y = true;
            $handle->allowed = array(
                'image/jpeg',
                'image/jpg',
                'image/gif',
                'image/png',
                'image/bmp'
            );
            $handle->file_new_name_body = uniqid($prefix) . '_' . md5(microtime()) . '_' . time();
            $handle->process('uploads/users_profile/');
            $handle->processed;
            return $receipt_img = $handle->file_dst_name;
        }
    }


    public function sidebarMenus()
    {
        return buildMenuForMoudle([
            'module' => 'Users',
            'icon' => 'fa-users',
            'href' => 'users',
            'children' => [
                [
                    'title' => 'All User',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'users'
                ],
                [
                    'title' => 'Add New User',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'users/create'
                ],
                [
                    'title' => 'Role / ACL',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'users/roles'
                ],
                [
                    'title' => 'Noficiations',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'users/notification'
                ],
            ]
        ]);
    }


    public function seller_status()
    {

        $user_id = $this->input->post('user_id');
        $type = $this->input->post('type');
        $data = [
            'user_id' => $user_id,
            'meta_key' => 'seller_tag',
            'meta_value' => $type
        ];

        $exist = $this->db->get_where('user_meta', ['user_id' => $user_id, 'meta_key' => 'seller_tag'])->row();

        if (empty($exist)) {
            $this->db->insert('user_meta', $data);
        } else {
            $this->db->where('user_id', $user_id);
            $this->db->where('meta_key', 'seller_tag');
            $this->db->update('user_meta', $data);

        }


        echo '<p class="ajax_success">Seller Status Updated</p>';

        // echo  $data;
    }


    public function password()
    {
        $this->viewAdminContent('password');
    }

    public function reset_password()
    {

        $user_id = intval($this->input->post('user_id'));
        $new_pass = $this->input->post('new_pass');
        $con_pass = $this->input->post('con_pass');


        if ($new_pass != $con_pass) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Confirm Password Not Match</p>');
            exit;
        }

        $hass_pass = password_encription($new_pass);
        $this->db->update('users', ['password' => $hass_pass], ['id' => $user_id]);
        echo ajaxRespond('OK', '<p class="ajax_success">Password Reset Successfully</p>');
    }


    public function business($id)
    {
        $user_id = $id;
        $data['user'] = $this->db->get_where('users', ['id' => $user_id])->row_array();
        $data['meta'] = $this->db->select('meta_key,meta_value')->get_where('user_meta', ['user_id' => $user_id])->result_array();
        $data['cms_data'] = $this->db->select('id,post_title,post_url,content,thumb')
            ->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])
            ->row_array();

        $data['social_links'] = Users_helper::userMetaValue('social_links', $user_id);
        $data['business_hours'] = Users_helper::userMetaValue('business_hours', $user_id);
        //dd( $data['meta'] );
        //dd( $data['meta'][3]['meta_value'] );
        //dd( $data['social_links'] );
        // dd($data);


        $this->viewAdminContent('business', $data);
    }


    // update Company profile
    public function business_update()
    {

        echo '<pre>';
        print_r($_POST);
        echo '</pre>';

        dd();
        $user_id = intval($this->input->post('user_id'));
        $page_slug = $this->input->post('user_slug', TRUE);

        // for user profile logo as company logo
        $this->companyLogo($user_id);

        $page_id = $this->getSellerPageID($user_id);

        //$this->isExistsBusinessPage( $page_slug, $page_id  );


        $this->saveBusinessPage($user_id, $page_id);


        $this->companyCover($page_id, $user_id);
        $this->update_user_meta($user_id);

        echo ajaxRespond('OK', '<p class="ajax_success">Page Update Successfully</p>');

    }


    public function video($id)
    {

        $videos = $this->db
            ->get_where('video_gallery', ['user_id' => $id, 'type' => 'Video'])
            ->result();
        $this->viewAdminContent('video', ['videos' => $videos]);
    }

    public function video_update()
    {

        ajaxAuthorized();


        $user_id = $this->input->post('user_id');
        $videos[] = $this->input->post('video_id', TRUE);

        dd($videos);

        $this->db->where('user_id', $user_id);
        $this->db->delete('video_gallery');

        $db_videos = [];
        foreach ($videos as $key => $data) {
            $db_videos[$key] = [
                'user_id' => $user_id,
                'video' => $data[$key],
                'type' => 'Video'
            ];
            //$this->db->insert('video_gallery', $data_in);
        }

        dd($db_videos);

        //$this->db->insert_batch('video_gallery', $data_in);


        echo ajaxRespond('OK', '<p class="ajax_success">Profile Updated Successfully<p>');
    }


    private function saveBusinessPage($user_id, $page_id = 0)
    {


        $page_slug = $this->input->post('user_slug', TRUE);


        $page_data = array(
            'user_id' => $user_id,
            'post_type' => 'business',
            'post_title' => $this->input->post('companyName', TRUE),
            'post_url' => $page_slug,
            'content' => $this->input->post('companyOverview', TRUE),
            'status' => 'Publish'
        );

        if ($page_id) {
            $this->db->where('id', $page_id);
            $this->db->update('cms', $page_data);
        } else {
            $this->db->insert('cms', $page_data);
        }
        return $page_id;
    }

    /* company logo used users table for for save profile logo */
    private function companyLogo($user_id)
    {
        $logo = '';
        $handle = new Verot\Upload\Upload($_FILES['company_logo']);
        if ($handle->uploaded) {
            $handle->file_name_body_pre = '';
            $handle->file_new_name_body = 'company_logo_' . date('Y-m-d-H-i-s_') . rand(0, 9);
            $handle->allowed = array('image/*');
            $handle->image_resize = true;
            $handle->image_x = 320;  // width
            $handle->image_y = 240;  // Height
            $handle->image_ratio = true;
            $handle->image_ratio_fill = true;
            $handle->image_background_color = '#f9f9f9';

            $logo = $handle->file_name_body_pre . $handle->file_new_name_body . '.' . $handle->file_src_name_ext;

            $handle->process('uploads/company_logo/');
            if ($handle->processed) {

                // if change photo  delete old photo as well
                $this->db->set('profile_photo', $logo)->where('id', $user_id)->update('users');

                $handle->clean();
            }


        }
    }


    /* company cover photo used cms table for for save company banner */
    private function companyCover($cms_post_id = 0, $user_id = 0)
    {
        if (empty($cms_post_id)) {
            return false;
        }

        $cover_photo = '';
        $cover = new Verot\Upload\Upload($_FILES['cover_image']);
        if ($cover->uploaded) {
            $cover->file_name_body_pre = '';
            $cover->file_new_name_body = 'cover_photo_' . $user_id . '_' . time();
            $cover->allowed = array('image/*');
            $cover->image_resize = true;
            $cover->image_x = 810;  // width
            $cover->image_y = 275;  // Height
            $cover->image_ratio = true;
            $cover->image_ratio_fill = true;
            $cover->image_background_color = '#f9f9f9';

            $cover_photo = $cover->file_name_body_pre . $cover->file_new_name_body . '.' . $cover->file_src_name_ext;


            $cover->process('uploads/company_logo/');
            if ($cover->processed) {
                $this->db->set('thumb', $cover_photo)->where('id', $cms_post_id)->update('cms');
                $cover->clean();
            }
        }
    }

    private function update_user_meta($user_id = 0)
    {
        $business_hours = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thusday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day) {
            $business_hours[$day] = [
                'selected' => isset($_POST[$day]) ? 'off' : 'on',
                'open_hh' => $_POST[$day . '_open_hh'],
                'open_mm' => $_POST[$day . '_open_mm'],
                'open_am_pm' => $_POST[$day . '_open_am_pm'],
                'close_hh' => $_POST[$day . '_close_hh'],
                'close_mm' => $_POST[$day . '_close_mm'],
                'close_am_pm' => $_POST[$day . '_close_am_pm'],
            ];
        }

        $user_id = intval($user_id);
        $user_mata_data = [
            array(
                'user_id' => $user_id,
                'meta_key' => 'userLocation',
                'meta_value' => $this->input->post('userLocation', TRUE)
            ),
            array(
                'user_id' => $user_id,
                'meta_key' => 'lat',
                'meta_value' => $this->input->post('lat', TRUE)
            ),
            array(
                'user_id' => $user_id,
                'meta_key' => 'lng',
                'meta_value' => $this->input->post('lng', TRUE)
            ),
            array(
                'user_id' => $user_id,
                'meta_key' => 'social_links',
                'meta_value' => json_encode(array(
                    'Facebook' => $this->input->post('Facebook', TRUE),
                    'Twitter' => $this->input->post('Twitter', TRUE),
                    'Youtube' => $this->input->post('Youtube', TRUE),
                    'Snapchat' => $this->input->post('Snapchat', TRUE),
                    'Instragram' => $this->input->post('Instragram', TRUE),
                    'Snapchat' => $this->input->post('Snapchat', TRUE),
                    'Skype' => $this->input->post('Skype', TRUE),
                    'Linkedin' => $this->input->post('Linkedin', TRUE),
                ))
            ),

            array(
                'user_id' => $user_id,
                'meta_key' => 'business_hours',
                'meta_value' => json_encode($business_hours)
            ),


            array(
                'user_id' => $user_id,
                'meta_key' => 'companyWebsite',
                'meta_value' => $this->input->post('companyWebsite', TRUE)
            )
        ];

        $rows = array('userLocation', 'lat', 'lng', 'social_links', 'companyWebsite', 'business_hours');

        $this->db->where('user_id', $user_id);
        $this->db->where_in('meta_key', $rows);
        $this->db->delete('user_meta');


        return $this->db->insert_batch('user_meta', $user_mata_data);
    }

    private function getSellerPageID($user_id = 0)
    {

        $page = $this->db->select('id')->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row();
        return ($page) ? $page->id : 0;
    }


    // Not In use
    private function isExistsBusinessPage($slug = '', $page_id = 0)
    {
        $page = $this->db->select('id')->get_where('cms', ['post_url' => $slug, 'id !=' => $page_id])->row();

        if ($page) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Page URL already exist. Please change it</p>');
            exit;
        }
    }


    // update Company profile
    public function user_business_update()
    {
        $user_id = intval($this->input->post('user_id'));

        $page_slug = $this->input->post('user_slug', TRUE);

        // for user profile logo as company logo
        $this->companyLogo($user_id);
        $page_id = $this->getSellerPageID($user_id);
        $exist = $this->isExistsBusinessPage($page_slug, $page_id);

        if ($exist) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Page URL already exist. Please change it</p>');
            exit;
        }

        $this->update_seller_page($user_id);
        $this->companyCover($page_id, $user_id);
        $this->update_user_meta($user_id);

        echo ajaxRespond('OK', '<p class="ajax_success">Page Update Successfully</p>');
    }

    private function update_seller_page($user_id)
    {

        $page_id = $this->getSellerPageID($user_id);

        $page_slug = $this->input->post('user_slug', TRUE);


        $page_data = array(
            'user_id' => $user_id,
            'post_type' => 'business',
            'post_title' => $this->input->post('companyName', TRUE),
            'post_url' => $page_slug,
            'content' => $this->input->post('companyOverview', TRUE),
            'status' => 'Publish'
        );

        if ($page_id) {
            $this->db->where('id', $page_id);
            $this->db->update('cms', $page_data);
        } else {
            $this->db->insert('cms', $page_data);
        }
        return $page_id;
        //echo ajaxRespond('OK', '<p class="ajax_success">Page Update Successfully</p>');
    }

    public function change_profile_status($user_id, $status)
    {
        $this->db->where('id', $user_id);
        $this->db->update('users', ['is_publish' => $status]);
        $this->session->set_flashdata('message', 'User Status Updated');
        redirect(site_url(Backend_URL . 'users'));
    }

    private function document_upload($photo, $user_id = 0)
    {
        $handle = new Verot\Upload\Upload($photo);
        if ($handle->uploaded) {
            $prefix = $user_id;
            $handle->image_resize = true;
            $handle->image_x = 400;
            $handle->image_ratio_y = true;
            $handle->allowed = array(
                'image/jpeg',
                'image/jpg',
                'image/gif',
                'image/png',
                'image/bmp'
            );
            $handle->file_new_name_body = 'user_document_' . uniqid($prefix) . '_' . md5(microtime()) . '_' . time();
            $handle->process('uploads/user_document/');
            $handle->processed;
            return $handle->file_dst_name;
        }
    }

    public function document_list($user_id)
    {
        $start = intval($this->input->get('start'));


        $config['base_url'] = Backend_URL . 'users/document_list/';
        $config['first_url'] = Backend_URL . 'users/document_list/';


        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->db->where('user_id', $user_id)->count_all_results('document_photo');

        $users = $this->db->where('user_id', $user_id)->limit($config['per_page'], $start)->get('document_photo')->result();
//        pp($users);
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $cms = $this->db->where('user_id', $user_id)->where('post_type', 'business')->get('cms')->row();

        $data = array(
            'documents' => $users,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'cms' => $cms
        );
        $this->viewAdminContent('users/document_list', $data);
    }

    public function document_create($user_id)
    {

        $cms = $this->db->where('user_id', $user_id)->where('post_type', 'business')->get('cms')->row();

        $data = array(
            'id' => 0,
            'user_id' => $user_id,
            'name' => '',
            'photo' => '',
            'button' => 'Create',
            'action' => 'admin/users/document_create_action',
            'user_name' => @$cms->post_title
        );
        $this->viewAdminContent('users/document_form', $data);
    }

    public function document_create_action()
    {

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        if (empty($_FILES['photo']['name'])) {
            $this->form_validation->set_rules('photo', 'Photo', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'All Fields Are Required');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $photo = '';
            if (!empty($_FILES['photo']['name'])) {
                $photo = $this->document_upload($_FILES['photo']);
            }

            $data = [
                'user_id' => $this->input->post('user_id'),
                'name' => $this->input->post('name'),
                'photo' => $photo,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ];

            $this->db->insert('document_photo', $data);
        }
        $this->session->set_flashdata('message', 'Document Added');
        redirect(site_url( Backend_URL. 'users/document_list/'.$this->input->post('user_id')));
    }

    public function document_update($id)
    {

        $document = $this->db->where('id', $id)->get('document_photo')->row();
        $cms = $this->db->where('user_id', $document->user_id)->where('post_type', 'business')->get('cms')->row();

        $data = array(
            'id' => $document->id,
            'user_id' => $document->user_id,
            'name' => $document->name,
            'photo' => $document->photo,
            'button' => 'Update',
            'action' => 'admin/users/document_update_action',
            'user_name' => @$cms->post_title
        );
        $this->viewAdminContent('users/document_form', $data);
    }

    public function document_update_action()
    {

        $this->form_validation->set_rules('name', 'Name', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'All Fields Are Required');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $document = $this->db->where('id', $this->input->post('id'))->get('document_photo')->row();
            $data = [
                'user_id' => $this->input->post('user_id'),
                'name' => $this->input->post('name'),
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ];

            if (!empty($_FILES['photo']['name'])) {
                $data['photo'] = $this->document_upload($_FILES['photo']);

                $file = dirname(BASEPATH) . '/uploads/user_document/' . $document->photo;
                if ($file && file_exists($file)) { unlink($file);  }
            }

            $this->db->where('id', $this->input->post('id'));
            $this->db->update('document_photo', $data);
        }
        $this->session->set_flashdata('message', 'Document Edited Successfully');
        redirect(site_url( Backend_URL. 'users/document_list/'.$this->input->post('user_id')));
    }

    public function document_delete($id) {
        $document = $this->db->where('id', $id)->get('document_photo')->row();

        $this->db->where('id', $id);
        $this->db->delete('document_photo');

        if ($document->photo){
            $file = dirname(BASEPATH) . '/uploads/user_document/' . $document->photo;
            if ($file && file_exists($file)) { unlink($file);  }
        }

        $this->session->set_flashdata('message', 'Document Deleted Successfully');
        redirect(site_url( Backend_URL. 'users/document_list/'.$document->user_id));
    }

    public function mechanicVerificationStatusChange()
    {

        $user_id = $this->input->post('user_id');
        $badge = $this->input->post('badge');
        $data = [
            'badge' => $badge
        ];
        $this->db->where('user_id', $user_id);
        $this->db->update('mechanic', $data);


        echo '<p class="ajax_success">Mechanic verification status has been updated</p>';

        // echo  $data;
    }
}
