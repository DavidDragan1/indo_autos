<?php

defined('BASEPATH') or exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 8th Oct 2016
 */

class ApiProfile extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Profile_model');
        $this->load->helper('profile');

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }

    public function api_profile()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $user_id = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'No record found',
                'data' => null
            ]);
        }
        $user_id = $user_id->user_id;

        is_token_match($user_id, $token);
        $data = $this->db->where('id', $user_id)->get('users')->row();
        $countries = $this->db->get_where('countries', ['status' => 'Active', 'type' => 1, 'parent_id' => '0'])->result();
        $data->user_profile_image = $data->oauth_provider == 'web' ? base_url("uploads/users_profile/{$data->user_profile_image}") : $data->user_profile_image;
        $res = [
            'status' => true,
            'data' => $data,
            'countries' => $countries,
            'message' => ""
        ];
        if ($data) {
            return apiResponse($res);
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Something went wrong. Please try again',
                'data' => null
            ]);
        }
    }

    public function api_update()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $user_id = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'No record found',
                'data' => null
            ]);
        }
        $user_id = $user_id->user_id;

        is_token_match($user_id, $token);

        if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) return apiResponse([
            'status' => false,
            'message' => 'Please insert valid email',
            'data' => null
        ]);

        $datas = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'contact' => $this->input->post('contact'),
            'contact1' => $this->input->post('contact1'),
            'contact2' => $this->input->post('contact2'),
            'country_id' => $this->input->post('country'),
            'add_line1' => $this->input->post('address_1'),
            'add_line2' => $this->input->post('address_2'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'postcode' => $this->input->post('post_code'),
            'email' => $this->input->post('email'),
        ];

        $update = $this->db->where('id', $user_id)->update('users', $datas);
        $res = [
            'status' => true,
            'message' => 'Profile Updated Successfully',
            'data' => null
        ];
        if ($update) {
            return apiResponse($res);
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Something went wrong. Please try again',
                'data' => null
            ]);
        }
    }

    public function api_update_password()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }
        $user_id = ($u) ? $u->user_id : 0;
        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        is_token_match($user_id, $token);

        $old_pass = $this->input->post('old_password');
        $new_pass = $this->input->post('new_password');
        $con_pass = $this->input->post('password_confirmation');

        if ($new_pass != $con_pass) {
            return apiResponse([
                'status' => false,
                'message' => 'Confirm Password Not Match',
                'data' => null
            ]);
        }


        $user = $this->db->select('password')
            ->get_where('users', ['id' => $user_id])
            ->row();

        $db_pass = $user->password;
        $verify = password_verify($old_pass, $db_pass);


        if (strlen($new_pass) < 6) {
            return apiResponse([
                'status' => false,
                'message' => 'Password must be greater than 6 character',
                'data' => null
            ]);
        }

        if ($verify == true) {
            $hass_pass = password_hash($new_pass, PASSWORD_BCRYPT, ["cost" => 6]);
            $this->db->update('users', ['password' => $hass_pass], ['id' => $user_id]);

            return apiResponse([
                'status' => true,
                'message' => 'Password is updated successfully',
                'data' => null
            ]);
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Old Password does not match',
                'data' => null
            ]);
        }
    }

    public function video()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        $user_id = ($u) ? $u->user_id : 0;

        $user = $this->db->where('id', $user_id)->get('users')->row();

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        if (isset($user) && (!in_array($user->role_id, array(4)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer to view business page.',
                'data' => null
            ]);
        }

        $videos = $this->db->select('id, user_id, photo as video_id')
            ->get_where('gallery', ['user_id' => $user_id, 'type' => 'Video'])
            ->result();

        if (isset($videos) && count($videos) > 0) {
            return apiResponse([
                'status' => true,
                'data' => $videos
            ]);
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'No data found.',
                'data' => null
            ]);
        }

    }

    public function videoUpdate()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        $user_id = ($u) ? $u->user_id : 0;

        $user = $this->db->where('id', $user_id)->get('users')->row();

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        if (isset($user) && (!in_array($user->role_id, array(4)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer to view business page.',
                'data' => null
            ]);
        }

        $video = $this->input->post('video', TRUE);

        $data = array(
            'user_id' => $user_id,
            'photo' => $video,
            'album_id' => 0,
            'type' => 'Video',
            'status' => 'Active',
            'created' => date('Y-m-d H:i:s')
        );

        $this->db->insert('gallery', $data);

        $videos = $this->db->select('id, user_id, photo as video_id')
            ->get_where('gallery', ['user_id' => $user_id, 'type' => 'Video'])
            ->result();

        return apiResponse([
            'status' => true,
            'message' => 'Videos updated successfully.',
            'data' => $videos
        ]);

    }

    public function videoEdit()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        $user_id = ($u) ? $u->user_id : 0;

        $user = $this->db->where('id', $user_id)->get('users')->row();

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        if (isset($user) && (!in_array($user->role_id, array(4)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer to view business page.',
                'data' => null
            ]);
        }

        $video = $this->input->post('video', TRUE);
        $id = $this->input->post('id', TRUE);

        if (empty($id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Id is required.',
                'data' => null
            ]);
        }

        if (empty($video)) {
            return apiResponse([
                'status' => false,
                'message' => 'Video id is required.',
                'data' => null
            ]);
        }

        $videos = $this->db->select('id, user_id, photo as video_id')
            ->where(['user_id' => $user_id, 'id' => $id, 'type' => 'Video'])->get('gallery')
            ->row();

        if (empty($videos)) {
            return apiResponse([
                'status' => false,
                'message' => 'Id not found.',
                'data' => null
            ]);
        }

        $this->db->where('id', $id);
        $this->db->update('gallery', ['photo' => $video]);

        $videos = $this->db->select('id, user_id, photo as video_id')
            ->get_where('gallery', ['user_id' => $user_id, 'type' => 'Video'])
            ->result();

        return apiResponse([
            'status' => true,
            'message' => 'Videos edited successfully.',
            'data' => $videos
        ]);

    }

    public function videoDelete()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        $user_id = ($u) ? $u->user_id : 0;

        $user = $this->db->where('id', $user_id)->get('users')->row();

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        if (isset($user) && (!in_array($user->role_id, array(4)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer to view business page.',
                'data' => null
            ]);
        }

        $id = $this->input->post('id', TRUE);

        if (empty($id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Id is required.',
                'data' => null
            ]);
        }

        $videos = $this->db->select('id, user_id, photo as video_id')
            ->where(['user_id' => $user_id, 'id' => $id, 'type' => 'Video'])->get('gallery')
            ->row();

        if (empty($videos)) {
            return apiResponse([
                'status' => false,
                'message' => 'Id not found.',
                'data' => null
            ]);
        }

        $this->db->where('id', $id);
        $this->db->delete('gallery');

        $videos = $this->db->select('id, user_id, photo as video_id')
            ->get_where('gallery', ['user_id' => $user_id, 'type' => 'Video'])
            ->result();

        return apiResponse([
            'status' => true,
            'message' => 'Videos deleted successfully.',
            'data' => $videos
        ]);

    }

    public function isExistVideoGalley($user_id)
    {
        $existPhoto = $this->db->where('user_id', $user_id)->where('type', 'Video')->count_all_results('video_gallery');
        return $existPhoto;
    }

    public function getAllVideoGallery($user_id)
    {
        $videos = $this->db->select('*')
            ->get_where('video_gallery', ['user_id' => $user_id, 'type' => 'Video'])
            ->result();
        return $videos;
    }

    public function business()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        $user_id = ($u) ? $u->user_id : 0;

        $user = $this->db->where('id', $user_id)->get('users')->row();

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        if (isset($user) && (!in_array($user->role_id, array(4)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer to view business page.',
                'data' => null
            ]);
        }

        $page = $this->db->select('cms.*')->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row();

        if (empty($page)) {
            return apiResponse([
                'status' => false,
                'message' => 'No business page found.',
                'data' => null
            ]);
        }

        $meta_key = array('userLocation', 'companyWebsite', 'business_hours');
        $metas = $this->db->where('user_id', $user_id)->where_in('meta_key', $meta_key)->get('user_meta')->result();

        $data = [
            'id' => $page->id,
            'user_id' => $user_id,
            'company_name' => $page->post_title,
            'company_overview' => $page->content,
            'slug' => $page->post_url,
            'company_logo' => base_url() . 'uploads/company_logo/' . $user->profile_photo,
            'cover_image' => base_url() . 'uploads/company_logo/' . $page->thumb,
        ];

        foreach ($metas as $meta) {
            $data[$meta->meta_key] = (($meta->meta_key == 'social_links') || ($meta->meta_key == 'business_hours')) ? json_decode($meta->meta_value, true) : $meta->meta_value;
        }

        $socialLinks = $this->db->where('user_id', $user_id)->where('meta_key', 'social_links')->get('user_meta')->row();

        if (isset($socialLinks) && !empty($socialLinks)) {
            $socialLink = json_decode($socialLinks->meta_value, true);
        } else {
            $socialLink = array(
                'Facebook' => "",
                'Twitter' => "",
                'Youtube' => "",
                'Snapchat' => "",
                'Instragram' => "",
                'Skype' => "",
                'Linkedin' => "",
            );
        }
        foreach ($socialLink as $key => $meta) {
            $data[$key] = $meta;
        }

        return apiResponse([
            'status' => true,
            'data' => $data
        ]);
    }

    public function businessHoursUpdate()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        $user_id = ($u) ? $u->user_id : 0;

        $user = $this->db->where('id', $user_id)->get('users')->row();

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        if (isset($user) && (!in_array($user->role_id, array(4)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer to view business page.',
                'data' => null
            ]);
        }

        $buHours = $this->input->post('hours', TRUE);

        if (empty($buHours)) {
            return apiResponse([
                'status' => false,
                'message' => 'Business hours are required.',
                'data' => null
            ]);
        }

        $bHours = json_decode($buHours, true);

        $hours = $this->db->where('user_id', $user_id)->where('meta_key', 'business_hours')->get('user_meta')->row();

        if (!empty($hours)) {
            $this->db->where(['user_id' => $user_id, 'id' => $hours->id])->where('meta_key', 'business_hours')->update('user_meta', ['meta_value' => json_encode($bHours)]);

        } else {
            $data = array(
                'user_id' => $user_id,
                'meta_key' => 'business_hours',
                'meta_value' => json_encode($bHours)
            );

            $this->db->insert('user_meta', $data);
        }

        $hours = $this->db->where('user_id', $user_id)->where('meta_key', 'business_hours')->get('user_meta')->row();

        $hour = json_decode($hours->meta_value, true);

        return apiResponse([
            'status' => true,
            'message' => 'Business hours updated successfully.',
            'data' => $hour,
        ]);

    }

    public function businessHours()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        $user_id = ($u) ? $u->user_id : 0;

        $user = $this->db->where('id', $user_id)->get('users')->row();

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        if (isset($user) && (!in_array($user->role_id, array(4)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer to view business page.',
                'data' => null
            ]);
        }

        $hours = $this->db->where('user_id', $user_id)->where('meta_key', 'business_hours')->get('user_meta')->row();

        if (!empty($hours)) {
            $hour = json_decode($hours->meta_value, true);

            return apiResponse([
                'status' => true,
                'data' => $hour,
            ]);
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'No data found.',
                'data' => null
            ]);
        }
    }

    // update Company profile
    public function businessUpdate()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        $user_id = ($u) ? $u->user_id : 0;

        $user = $this->db->where('id', $user_id)->get('users')->row();

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        if (isset($user) && (!in_array($user->role_id, array(4)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer to update business page.',
                'data' => null
            ]);
        }

        $this->_business_rules();

        if ($this->form_validation->run() == FALSE) {
            return apiResponse([
                'status' => false,
                'message' => validation_errors(),
                'data' => null
            ]);
        } else {
            $companyName = $this->input->post('company_name', TRUE);
            $business = $this->db->select('id')->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row();

            if (empty($business)) {
                $id = 0;
            } else {
                $id = $business->id;
            }

            $slug = $this->createBusinessPageSlug($companyName, $id);
            $page_id = $this->update_seller_page($user_id, $slug, $id);
            $this->update_user_meta($user_id);
            if ($id == 0) {
                $this->businessH($user_id);
            }
            $this->update_user_meta($user_id);
            $page = $this->db->select('cms.*')->get_where('cms', ['id' => $page_id])->row();
            $meta_key = array('userLocation', 'social_links', 'companyWebsite', 'business_hours');
            $metas = $this->db->where('user_id', $user_id)->where_in('meta_key', $meta_key)->get('user_meta')->result();

            $data = [
                'id' => $page_id,
                'user_id' => $user_id,
                'company_name' => $page->post_title,
                'company_overview' => $page->content,
                'slug' => $page->post_url,
                'status' => $page->status,
            ];

            foreach ($metas as $meta) {
                $data[$meta->meta_key] = (($meta->meta_key == 'social_links') || ($meta->meta_key == 'business_hours')) ? json_decode($meta->meta_value, true) : $meta->meta_value;
            }

            return apiResponse([
                'status' => true,
                'message' => 'Page updated successfully.',
                'data' => $data
            ]);
        }
    }

    private function _business_rules()
    {
        $this->form_validation->set_rules('company_name', 'company_name', 'trim|required');
        $this->form_validation->set_rules('company_overview', 'company_overview', 'trim|required');
        $this->form_validation->set_rules('user_location', 'user_location', 'trim|required');
    }

    private function createBusinessPageSlug($companyName, $id)
    {
        $companyName = strtolower($companyName);
        $companyName = preg_replace('/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/', "-", $companyName);
        if ($id) {
            $page = $this->db->select('id')->get_where('cms', ['id !=' => $id, 'post_url' => $companyName])->row();
        } else {
            $page = $this->db->select('id')->get_where('cms', ['post_url' => $companyName])->row();
        }

        if ($page) {
            $companyName = $companyName . "-" . rand(1111, 9999);
        }

        return $companyName;
    }

    public function companyLogo()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        $user_id = ($u) ? $u->user_id : 0;

        $user = $this->db->where('id', $user_id)->get('users')->row();

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        if (isset($user) && (!in_array($user->role_id, array(4)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer to update company logo.',
                'data' => null
            ]);
        }

        if (empty($_FILES['company_logo'])) {
            return apiResponse([
                'status' => false,
                'message' => 'Company logo is required.',
                'data' => null
            ]);
        }

        if ($_FILES['company_logo']['size'] > 2097152) {
            return apiResponse([
                'status' => false,
                'message' => 'Image size is too big. Size should not greater than 2MB',
                'data' => null
            ]);
        }

        if (isset($user->profile_photo) && !empty($user->profile_photo)) {
            $file = dirname(BASEPATH) . '/' . 'uploads/company_logo/' . $user->profile_photo;

            if (file_exists($file)) {
                unlink($file);
            }
        }

        $handle = new \Verot\Upload\Upload($_FILES['company_logo']);

        if ($handle->uploaded) {
            $handle->file_name_body_pre = '';
            $handle->file_new_name_body = 'company_logo_' . date('Y-m-d-H-i-s_') . rand(0, 9);
            $handle->allowed = array('image/*');
            $handle->image_resize = true;
            $handle->image_x = 1024;  // width
            $handle->image_y = 850;  // Height
            $handle->image_ratio = true;
            $handle->image_background_color = '#f9f9f9';

            $logo = $handle->file_name_body_pre . $handle->file_new_name_body . '.' . $handle->file_src_name_ext;

            $handle->process('uploads/company_logo/');
            if ($handle->processed) {

                // if change photo  delete old photo as well
                $this->db->set('profile_photo', $logo)->where('id', $user_id)->update('users');

                $handle->clean();
                $user = $this->db->where('id', $user_id)->get('users')->row();

                return apiResponse([
                    'status' => true,
                    'message' => 'Company Logo updated successfully.',
                    'data' => base_url() . 'uploads/company_logo/' . $user->profile_photo
                ]);
            }
        }

        return apiResponse([
            'status' => false,
            'message' => 'Something went wrong. Please try again later.',
            'data' => null
        ]);
    }

    private function update_seller_page($user_id, $page_slug, $page_id = 0)
    {
        $page_data = array(
            'user_id' => $user_id,
            'post_type' => 'business',
            'post_title' => $this->input->post('company_name', TRUE),
            'post_url' => $page_slug,
            'content' => $this->input->post('company_overview', TRUE),
            'status' => 'Publish'
        );

        if ($page_id) {
            $this->db->where('id', $page_id);
            $this->db->update('cms', $page_data);
        } else {
            $this->db->insert('cms', $page_data);
            $page_id = $this->db->insert_id();
        }

        return $page_id;
    }

    private function getSellerPageID($user_id = 0)
    {

        $page = $this->db->select('id')->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row();
        return ($page) ? $page->id : 0;
    }

    private function isExistsBusinessPage($slug = '', $page_id = 0)
    {

        $page = $this->db->select('id')->get_where('cms', ['post_url' => $slug, 'id !=' => $page_id])->row();
        return ($page) ? $page->id : 0;
    }

    /* company cover photo used cms table for for save company banner */

    public function companyCover()
    {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        $user_id = ($u) ? $u->user_id : 0;

        $user = $this->db->where('id', $user_id)->get('users')->row();

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        if (isset($user) && (!in_array($user->role_id, array(4)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer to update company cover image.',
                'data' => null
            ]);
        }

        if (empty($_FILES['cover_image'])) {
            return apiResponse([
                'status' => false,
                'message' => 'Company cover image is required.',
                'data' => null
            ]);
        }

        if ($_FILES['cover_image']['size'] > 2097152) {
            return apiResponse([
                'status' => false,
                'message' => 'Image size is too big. Size should not greater than 2MB',
                'data' => null
            ]);
        }

        $page = $this->db->where(['user_id' => $user_id, 'post_type' => 'business'])->get('cms')->row();

        if (empty($page)) {
            return apiResponse([
                'status' => false,
                'message' => 'No business page found. Please create business page first.',
                'data' => null
            ]);
        }

        if (isset($page->thumb) && !empty($page->thumb)) {
            $file = dirname(BASEPATH) . '/' . 'uploads/company_logo/' . $page->thumb;

            if (file_exists($file)) {
                unlink($file);
            }
        }

        $cover = new \Verot\Upload\Upload($_FILES['cover_image']);
        if ($cover->uploaded) {
            $cover->file_name_body_pre = '';
            $cover->file_new_name_body = 'cover_photo_' . $user_id . '_' . time();
            $cover->allowed = array('image/*');
            $cover->image_resize = true;
            $cover->image_x = 1024;  // width
            $cover->image_y = 850;  // Height
            $cover->image_background_color = '#f9f9f9';


            $cover_photo = $cover->file_name_body_pre . $cover->file_new_name_body . '.' . $cover->file_src_name_ext;

            $cover->process('uploads/company_logo/');
            if ($cover->processed) {
                $this->db->set('thumb', $cover_photo)->where('id', $page->id)->update('cms');
                $cover->clean();

                $businessPage = $this->db->where(['user_id' => $user_id, 'post_type' => 'business', 'id' => $page->id])->get('cms')->row();

                return apiResponse([
                    'status' => true,
                    'message' => 'Company cover image updated successfully.',
                    'data' => base_url() . 'uploads/company_logo/' . $businessPage->thumb
                ]);
            }
        }

        return apiResponse([
            'status' => false,
            'message' => 'Something went wrong. Please try again later.',
            'data' => null
        ]);
    }

    public function updateProfileImage()
    {
        $token = $this->input->server('HTTP_TOKEN');
        $u = null;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }
        $user_id = ($u) ? $u->user_id : 0;
        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        $file = $_FILES['image'];
        if ($_FILES['image']['size'] > 2097152) {
            return apiResponse([
                'status' => false,
                'message' => 'Image size is too big. Size should not greater than 2MB',
                'data' => null
            ]);
        }
        $handle = new \Verot\Upload\Upload($file);
        $photo = "";
        if ($handle->uploaded) {
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
            $handle->file_new_name_body = 'user_profile_pic_' . date('Y-m-d-H-i-s_') . rand(0, 9);
            $handle->process('uploads/users_profile/');
            if ($handle->processed) {
                $photo = $handle->file_dst_name;
            }
        }

        $this->db->update('users', ['user_profile_image' => $photo], ['id' => $user_id]);

        return apiResponse([
            'status' => true,
            'message' => 'Profile image is uploaded successfully',
            'data' => [
                'image' => base_url() . "uploads/users_profile/" . $photo
            ]
        ]);
    }

    private function update_user_meta($user_id = 0)
    {
        $user_id = intval($user_id);

        $user_mata_data = [
            array(
                'user_id' => $user_id,
                'meta_key' => 'userLocation',
                'meta_value' => $this->input->post('user_location', TRUE)
            ),
            array(
                'user_id' => $user_id,
                'meta_key' => 'social_links',
                'meta_value' => json_encode(array(
                    'Facebook' => $this->input->post('facebook', TRUE),
                    'Twitter' => $this->input->post('twitter', TRUE),
                    'Youtube' => $this->input->post('youtube', TRUE),
                    'Snapchat' => $this->input->post('snapchat', TRUE),
                    'Instragram' => $this->input->post('instragram', TRUE),
                    'Snapchat' => $this->input->post('snapchat', TRUE),
                    'Skype' => $this->input->post('skype', TRUE),
                    'Linkedin' => $this->input->post('linkedin', TRUE),
                ))
            ),

            array(
                'user_id' => $user_id,
                'meta_key' => 'companyWebsite',
                'meta_value' => $this->input->post('companyWebsite', TRUE)
            ),
            array(
                'user_id' => $user_id,
                'meta_key' => 'whatsapp_number',
                'meta_value' => $this->input->post('whatsapp_number', TRUE)
            ),
            array(
                'user_id' => $user_id,
                'meta_key' => 'business_phone',
                'meta_value' => $this->input->post('business_phone', TRUE)
            )
        ];

        $rows = array('userLocation', 'social_links', 'companyWebsite, whatsapp_number, business_phone');

        $this->db->where('user_id', $user_id);
        $this->db->where_in('meta_key', $rows);
        $this->db->delete('user_meta');

        $this->db->insert_batch('user_meta', $user_mata_data);

        return $this->db->where('user_id', $user_id)->where_in('meta_key', $rows)->get('user_meta')->result();
    }

    private function businessH($user_id = 0)
    {
        $user_id = intval($user_id);

        $business_hours = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thusday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day) {
            $business_hours[$day] = [
                'selected' => 'on',
                'open_hh' => "00",
                'open_mm' => "00",
                'open_am_pm' => "00",
                'close_hh' => "00",
                'close_mm' => "00",
                'close_am_pm' => "00",
            ];
        }

        $user_mata_data = [
            array(
                'user_id' => $user_id,
                'meta_key' => 'business_hours',
                'meta_value' => json_encode($business_hours)
            )
        ];

        $rows = array('business_hours');

        $this->db->where('user_id', $user_id);
        $this->db->where_in('meta_key', $rows);
        $this->db->delete('user_meta');

        $this->db->insert_batch('user_meta', $user_mata_data);

        return $this->db->where('user_id', $user_id)->where_in('meta_key', $rows)->get('user_meta')->result();
    }

    public function api_bussiness_v1()
    {
        $token = $this->input->server('HTTP_TOKEN');
        $user_id = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $user_id = ($u) ? $u->user_id : 0;
        }

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login',
                'data' => new stdClass()
            ]);
        }

        $user_data = $this->db->get_where('users', ['id' => $user_id])->row();

        if (empty($user_data)) {
            return apiResponse([
                'status' => false,
                'message' => 'No User Found',
                'data' => new stdClass()
            ]);
        }

        $user_meta_data = $this->db->where(['user_id' => $user_id])->get('user_meta')->result();
        $user_meta = [];
        foreach ($user_meta_data as $m) {
            $user_meta[$m->meta_key] = $m->meta_value;
        }

        $role_id = $user_data->role_id;
        $data =  $user_meta;

        if ($role_id == 4) {
            $businessInfo = $this->db->select('id,post_title,post_url,content,thumb')->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row_array();

            $businessHours['businessHours'] = Profile_helper::userMetaValue('business_hours');
            $businessHours['businessHours'] = json_decode($businessHours['businessHours'], TRUE);

            $data = array_merge((array)$data, (array)$businessInfo, (array)$businessHours, ['is_complete' => empty($businessInfo) ? 0 : 1]);
            $data['photo'] = base_url().'uploads/company_logo/'.$user_data->profile_photo;
        } elseif ($role_id == 14) {
            $exist = $this->db->get_where('drivers', ['user_id' => $user_id])->row_array();
            $data['is_complete'] = !empty($exist) ? 1 : 0;
            $exist = !empty($exist) ? $exist : [];

            $data = array_merge($data,  $exist);
        } elseif ($role_id == 8) {
            $exist = $this->db->get_where('mechanic', ['user_id' => $user_id])->row_array();
            $data['is_complete'] = !empty($exist) ? 1 : 0;
            $exist = !empty($exist) ? $exist : [];

            $data = array_merge($data,  $exist);
        } elseif ($role_id == 17) {
            $exist = $this->db->get_where('verifiers', ['user_id' => $user_id])->row_array();
            $data['is_complete'] = !empty($exist) ? 1 : 0;
            $exist = !empty($exist) ? $exist : [];
            $data = array_merge($data,  $exist);
        } elseif ($role_id == 16) {
            $exist = $this->db->select('clearing.*, companyName as post_title')->get_where('clearing', ['user_id' => $user_id])->row_array();
            $data['is_complete'] = !empty($exist) ? 1 : 0;
            $exist = !empty($exist) ? $exist : [];

            $data = array_merge($data, $exist);
            $data['photo'] = base_url().'uploads/company_logo/'.$user_data->profile_photo;
        } elseif ($role_id == 15) {
            $exist = $this->db->select('shipping.*, companyName as post_title')->get_where('shipping', ['user_id' => $user_id])->row_array();
            $data['is_complete'] = !empty($exist) ? 1 : 0;
            $exist = !empty($exist) ? $exist : [];

            $data = array_merge($data, $exist);
            $data['photo'] = base_url().'uploads/company_logo/'.$user_data->profile_photo;
        }
        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $data
        ]);
    }

    private function profilePicture($user_id)
    {
        $logo = '';
        $handle = new \Verot\Upload\Upload($_FILES['profile_pic']);
        if ($handle->uploaded) {
            $handle->file_name_body_pre = '';
            $handle->file_new_name_body = 'user_profile_pic_' . date('Y-m-d-H-i-s_') . rand(0, 9);
            $handle->allowed = array('image/*');
            $handle->image_resize = true;
            $handle->image_x = 320;  // width
            $handle->image_y = 240;  // Height
            $handle->image_ratio = true;
            $handle->image_ratio_fill = true;
            $handle->image_background_color = '#f9f9f9';

            $logo = $handle->file_name_body_pre . $handle->file_new_name_body . '.' . $handle->file_src_name_ext;

            $handle->process('uploads/users_profile/');

            if ($handle->processed) {

                // if change photo  delete old photo as well
                $this->db->set('user_profile_image', $logo)->where('id', $user_id)->update('users');

                $handle->clean();
            }
        }
    }

    // update Company profile
    public function business_update_v1()
    {

        $token = $this->input->server('HTTP_TOKEN');
        $user_id = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $user_id = ($u) ? $u->user_id : 0;
        }

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login',
                'data' => new stdClass()
            ]);
        }

        $user_data = $this->db->get_where('users', ['id' => $user_id])->row();

        if (empty($user_data)) {
            return apiResponse([
                'status' => false,
                'message' => 'No User Found',
                'data' => new stdClass()
            ]);
        }

        $page_slug = slugify($user_data->first_name . $user_data->last_name);

        // for user profile logo as company logo
       // $this->companyLogo($user_id);

        if ($user_data->role_id == 4) {
            $page = $this->db->select('id')->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row();
            $exist = $this->isExistsBusinessPage($page_slug, !empty($page) ? $page->id : 0);

            if ($exist) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Page URL already exist. Please change it',
                    'data' => new stdClass()
                ]);
            }//        $this->companyCover($page_id, $user_id);
            $this->update_seller_page($user_id, $page_slug, !empty($page) ? $page->id : 0);
            $this->update_user_meta($user_id);
        } else {
            $this->clearing_shipping_profile($user_id, $page_slug, $user_data->role_id);
        }

        return apiResponse([
            'status' => true,
            'message' => 'Page Update Successfully',
            'data' => new stdClass()
        ]);

    }

    public function clearing_shipping_profile($user_id, $page_slug, $role_id)
    {

        $table = $role_id == 16 ? 'clearing' : 'shipping';
        $before_data = $this->db->get_where($table, ['user_id' => $user_id])->row();
        $id = !empty($before_data) ? $before_data->id : 0;

        $before_slug = $this->db->get_where($table, ['post_url' => $page_slug, 'id !=' => $id])->row();

        $page_slug = !empty($before_slug) ? $page_slug . '-' . rand(0000, 9999) : $page_slug;

        $data = [
            'user_id' => $user_id,
            'companyName' => $this->input->post('company_name', TRUE),
            'companyOverview' => $this->input->post('company_overview', TRUE),
            'companyWebsite' => $this->input->post('companyWebsite', TRUE),
            'whatsapp_number' => $this->input->post('whatsapp_number', TRUE),
            'business_phone' => $this->input->post('business_phone', TRUE),
            'userLocation' => $this->input->post('user_location', TRUE),
            'post_url' => $page_slug
        ];

        if (!empty($id)) {
            $this->db->where('id', $id);
            $this->db->update($table, $data);
        } else {
            $this->db->insert($table, $data);
        }

    }

    public function basic_profile_update()
    {
        $token = $this->input->server('HTTP_TOKEN');
        $user_id = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $user_id = ($u) ? $u->user_id : 0;
        }

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login',
                'data' => new stdClass()
            ]);
        }

        $user_data = $this->db->get_where('users', ['id' => $user_id])->row();

        if (empty($user_data)) {
            return apiResponse([
                'status' => false,
                'message' => 'No User Found',
                'data' => new stdClass()
            ]);
        }

        foreach ($this->input->post() as $key => $value) {
            if (!in_array($key, ['postcode'])) {
                if (empty($this->input->post($key))) {
                    return apiResponse([
                        'status' => false,
                        'message' => 'Required Fields Will Not Empty',
                        'data' => []
                    ]);
                }
            }
        }

        $exist_email = $this->db->get_where('users', ['id !=' => $user_id, 'email' => $this->input->post('email')])->row();

        if (!empty($exist_email)) {
            return apiResponse([
                'status' => false,
                'message' => 'Email already exists',
                'data' => new stdClass()
            ]);
        }

        $datas = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'contact' => $this->input->post('contact'),
            'country_id' => $this->input->post('country_id'),
            'add_line1' => $this->input->post('add_line1'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'postcode' => $this->input->post('postcode'),
            'email' => $this->input->post('email'),

        ];
        //$this->profilePicture($user_id);
        $this->db->where('id', $user_id)->update('users', $datas);

        return apiResponse([
            'status' => true,
            'message' => 'Profile Updated Successfully',
            'data' => new stdClass()
        ]);
    }

    public function driver_profile_update()
    {
        $token = $this->input->server('HTTP_TOKEN');
        $user_id = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $user_id = ($u) ? $u->user_id : 0;
        }

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login',
                'data' => new stdClass()
            ]);
        }

        $user_data = $this->db->get_where('users', ['id' => $user_id])->row();

        if (empty($user_data)) {
            return apiResponse([
                'status' => false,
                'message' => 'No User Found',
                'data' => new stdClass()
            ]);
        }
        if ($user_data->role_id != 14) {
            return apiResponse([
                'status' => false,
                'message' => 'Authentication Faild',
                'data' => new stdClass()
            ]);
        }

        foreach ($this->input->post() as $key => $value) {
            if (!in_array($key, ['postcode'])) {
                if (empty($this->input->post($key))) {
                    return apiResponse([
                        'status' => false,
                        'message' => 'Required Fields Will Not Empty',
                        'data' => []
                    ]);
                }
            }
        }

        $exist = $this->db->get_where('drivers', ['user_id' => $user_id])->row();
        $slug = slugify($user_data->first_name . $user_data->last_name);
        $is_exist_slug = $this->db->get_where('drivers', ['user_id !=' => $user_id, 'driver_slug' => $slug])->row();
        if (!empty($is_exist_slug)) {
            $slug = $slug . '-' . rand(1000, 9999);
        }
        $driver_data = [
            'age' => $this->input->post('age'),
            'education_type' => $this->input->post('education_type'),
            'vehicle_type_id' => $this->input->post('vehicle_type_id'),
            'license_type' => $this->input->post('license_type'),
            'state_id' => $this->input->post('location_id'),
            'marital_status' => $this->input->post('marital_status'),
            'years_of_experience' => $this->input->post('years_of_experience'),
            'description' => $this->input->post('description'),
            'one_day' => $this->input->post('one_day'),
            'first_week' => $this->input->post('first_week'),
            'second_week' => $this->input->post('second_week'),
            'third_week' => $this->input->post('third_week'),
            'fourth_week' => $this->input->post('fourth_week'),
            'month' => $this->input->post('month'),
            'user_id' => $user_id,
            'driver_slug' => $slug,
        ];
        if (empty($exist)) {
            $this->db->insert('drivers', $driver_data);
        } else {
            $this->db->where('user_id', $user_id)->update('drivers', $driver_data);
        }

        return apiResponse([
            'status' => true,
            'message' => 'Driver Profile Updated Successfully',
            'data' => []
        ]);
    }

    public function verifier_profile_update()
    {
        $token = $this->input->server('HTTP_TOKEN');
        $user_id = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $user_id = ($u) ? $u->user_id : 0;
        }

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login',
                'data' => new stdClass()
            ]);
        }

        $user_data = $this->db->get_where('users', ['id' => $user_id])->row();

        if (empty($user_data)) {
            return apiResponse([
                'status' => false,
                'message' => 'No User Found',
                'data' => new stdClass()
            ]);
        }
        if ($user_data->role_id != 17) {
            return apiResponse([
                'status' => false,
                'message' => 'Authentication Failed',
                'data' => new stdClass()
            ]);
        }

        foreach ($this->input->post() as $key => $value) {
            if (!in_array($key, ['postcode'])) {
                if (empty($this->input->post($key))) {
                    return apiResponse([
                        'status' => false,
                        'message' => 'Required Fields Will Not Empty',
                        'data' => []
                    ]);
                }
            }
        }


        $exist = $this->db->get_where('verifiers', ['user_id' => $user_id])->row();
        $slug = slugify($this->input->post('verifier_slug'));
        $is_exist_slug = $this->db->get_where('verifiers', ['user_id !=' => $user_id, 'slug' => $slug])->row();
        if (!empty($is_exist_slug)) {
            $slug = $slug . '-' . rand(1000, 9999);
        }
        $verifierData = [
            'slug' => $slug,
            'whatsapp' => $this->input->post('whatsapp', true),
            'about' => $this->input->post('about', true),
            'service_details' => $this->input->post('service_details', true),
            'user_id' => $user_id,
            'state_id' => $this->input->post('state_id', true)
        ];
        if (empty($exist)) {
            $this->db->insert('verifiers', $verifierData);
        } else {
            $this->db->where('user_id', $user_id)->update('verifiers', $verifierData);
        }
        return apiResponse([
            'status' => true,
            'message' => 'Verifier Profile Updated Successfully',
            'data' => []
        ]);
    }

    public function mechanic_profile_update()
    {
        $token = $this->input->server('HTTP_TOKEN');
        $user_id = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $user_id = ($u) ? $u->user_id : 0;
        }

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login',
                'data' => new stdClass()
            ]);
        }

        $user_data = $this->db->get_where('users', ['id' => $user_id])->row();

        if (empty($user_data)) {
            return apiResponse([
                'status' => false,
                'message' => 'No User Found',
                'data' => new stdClass()
            ]);
        }
        if ($user_data->role_id != 8) {
            return apiResponse([
                'status' => false,
                'message' => 'Authentication Failed',
                'data' => new stdClass()
            ]);
        }

        foreach ($this->input->post() as $key => $value) {
            if (!in_array($key, ['is_provide_mobile_service', 'mobile_service_category', 'mobile_services'])) {
                if (empty($this->input->post($key))) {
                    return apiResponse([
                        'status' => false,
                        'message' => 'Required Fields Will Not Empty',
                        'data' => []
                    ]);
                }
            }
        }

        $exist = $this->db->get_where('mechanic', ['user_id' => $user_id])->row();
        $slug = slugify($user_data->first_name . $user_data->last_name);
        $is_exist_slug = $this->db->get_where('mechanic', ['user_id !=' => $user_id, 'mechanic_slug' => $slug])->row();
        if (!empty($is_exist_slug)) {
            $slug = $slug . '-' . rand(1000, 9999);
        }
        $mechanic_data = [
            'age' => $this->input->post('age'),
            'vehicle_type_id' => implode(',', $this->input->post('vehicle_type_id')),
            'state_id' => implode(',', $this->input->post('state_id')),
            'years_of_experience' => $this->input->post('years_of_experience'),
            'description' => $this->input->post('description'),
            'user_id' => $user_id,
            'mechanic_slug' => $slug,
            'services' => !empty($this->input->post('services')) ? implode(',', $this->input->post('services')) : '',
            'brand' => !empty($this->input->post('brand')) ? implode(',', $this->input->post('brand')) : '',
            'city_id' => !empty($this->input->post('city_id')) ? implode(',', $this->input->post('city_id')) : '',
            'mobile_service_category' => !empty($this->input->post('mobile_service_category')) ? implode(',', $this->input->post('mobile_service_category')) : '',
            'mobile_services' => !empty($this->input->post('mobile_services')) ? implode(',', $this->input->post('mobile_services')) : '',
            'specialism' => !empty($this->input->post('specialism')) ? implode(',', $this->input->post('specialism')) : '',
            'is_provide_mobile_service' => $this->input->post('is_provide_mobile_service'),
            'service_type' => !empty($this->input->post('service_type')) ? implode(',', $this->input->post('service_type')) : ''
        ];
        if (empty($exist)) {
            $this->db->insert('mechanic', $mechanic_data);
        } else {
            $this->db->where('user_id', $user_id)->update('mechanic', $mechanic_data);
        }

        return apiResponse([
            'status' => true,
            'message' => 'Mechanic was successfully updated',
            'data' => []
        ]);
    }

    public function private_seller_profile_update()
    {
        $token = $this->input->server('HTTP_TOKEN');
        $user_id = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $user_id = ($u) ? $u->user_id : 0;
        }

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login',
                'data' => new stdClass()
            ]);
        }

        $user_data = $this->db->get_where('users', ['id' => $user_id])->row();

        if (empty($user_data)) {
            return apiResponse([
                'status' => false,
                'message' => 'No User Found',
                'data' => new stdClass()
            ]);
        }
        if ($user_data->role_id != 5) {
            return apiResponse([
                'status' => false,
                'message' => 'Authentication Failed',
                'data' => new stdClass()
            ]);
        }


        if (empty($this->input->post('content', TRUE))) {
            return apiResponse([
                'status' => false,
                'message' => 'Required Fields Will Not Empty',
                'data' => []
            ]);
        }


        $user_meta = $this->db->where(['user_id' => $user_id, 'meta_key' => 'content'])->get('user_meta')->row();

        if ($user_meta) {
            $this->db->where(['user_id' => $user_id, 'meta_key' => 'content'])->update('user_meta', ['meta_value' => $this->input->post('content', TRUE)]);
        } else {
            $this->db->insert('user_meta', [
                'user_id' => $user_id,
                'meta_key' => 'content',
                'meta_value' => $this->input->post('content', TRUE)
            ]);
        }


        return apiResponse([
            'status' => true,
            'message' => 'Profile Updated Successfully',
            'data' => new stdClass()
        ]);

    }
}
