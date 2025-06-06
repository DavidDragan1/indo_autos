<?php

defined('BASEPATH') or exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 8th Oct 2016
 */

use Illuminate\Database\Capsule\Manager as DB;

class Profile extends Admin_controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Profile_model');
        $this->load->helper('profile');

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        $user_id = getLoginUserData('user_id');

        $user_data = $this->db->get_where('users', ['id' => $user_id])->row();
        $user_meta_data = $this->db->where(['user_id' => $user_id])->get('user_meta')->result();
        $user_meta = [];
        foreach ($user_meta_data as $m) {
            $user_meta[$m->meta_key] = $m->meta_value;
        }
        $businessInfo = $this->db->select('id,post_title,post_url,content,thumb')->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row_array();

        $businessHours['businessHours'] = Profile_helper::userMetaValue('business_hours');


        $businessHours['businessHours'] = json_decode($businessHours['businessHours'] ?? '', TRUE);
        $data = array_merge((array)$user_data, (array)$user_meta, (array)$businessInfo, (array)$businessHours, ['is_complete' => empty($businessInfo) ? 0 : 1]);
        $role_id = getLoginUserData('role_id');
        if ($role_id == 1 or $role_id == 2) {
            $this->viewAdminContent('index', $data);
        }  elseif ($role_id == 4) {

            $data['is_complete'] = !empty($businessInfo) ? 1 : 0;
            $this->viewAdminContentPrivate('backend/trade/template/profile/trader_index', $data);
        } else {
            $data['is_complete'] = 0;
            $this->viewAdminContentPrivate('backend/trade/template/profile/trader_index', $data);
        }
    }

    public function update()
    {
        ajaxAuthorized();
        $user_id = getLoginUserData('user_id');
        $role_id = getLoginUserData('role_id');
        $datas = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'contact' => $this->input->post('contact'),
            'contact1' => $this->input->post('contact1'),
            'contact2' => $this->input->post('contact2'),
            'country_id' => $this->input->post('country'),
            'add_line1' => $this->input->post('userAddress1'),
            'add_line2' => $this->input->post('userAddress2'),
            'city' => $this->input->post('userCity'),
            'state' => $this->input->post('location_id'),
            'postcode' => $this->input->post('userPostCode'),
            'email' => $this->input->post('user_email'),

        ];
        $this->profilePicture($user_id);
        $this->db->where('id', $user_id)->update('users', $datas);

        if ($role_id == 14) {
            $exist = $this->db->get_where('drivers', ['user_id' => $user_id])->row();
            $slug = slugify($this->input->post('driver_slug'));
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
        }
        if ($role_id == 17) {
            $exist = $this->db->get_where('verifiers', ['user_id' => $user_id])->row();
            $slug = slugify($this->input->post('slug'));
            $is_exist_slug = $this->db->get_where('verifiers', ['user_id !=' => $user_id, 'slug' => $slug])->row();
            if (!empty($is_exist_slug)) {
                $slug = $slug . '-' . rand(1000, 9999);
            }
            $verifierData = [
                'slug' => $slug,
                'whatsapp' => $this->input->post('whatsapp_number_verifier', true),
                'about' => $this->input->post('about_verifier', true),
                'service_details' => $this->input->post('service_details', true),
                'user_id' => $user_id,
                'state_id' => $this->input->post('location_id', true)
            ];
            if (empty($exist)) {
                $this->db->insert('verifiers', $verifierData);
            } else {
                $this->db->where('user_id', $user_id)->update('verifiers', $verifierData);
            }
        }

        if ($role_id == 8) {
            $exist = $this->db->get_where('mechanic', ['user_id' => $user_id])->row();
            $slug = slugify($this->input->post('mechanic_slug'));
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
                'mobile_service_availability' => !empty($this->input->post('mobile_service_availability')) ? implode(',', $this->input->post('mobile_service_availability')) : '',
                'specialism' => !empty($this->input->post('specialism')) ? implode(',', $this->input->post('specialism')) : '',
                'is_provide_mobile_service' => $this->input->post('is_provide_mobile_service'),
                'service_type' => !empty($this->input->post('service_type')) ? implode(',', $this->input->post('service_type')) : '',
                'company_name' => $this->input->post('company_name'),
                'show_company' => $this->input->post('show_company') == 'on' ? 1 : 0,
            ];
            if (empty($exist)) {
                $this->db->insert('mechanic', $mechanic_data);
            } else {
                $this->db->where('user_id', $user_id)->update('mechanic', $mechanic_data);
            }
        }

        $before_cookie = json_decode(base64_decode($this->input->cookie('fm_login_data', false)));

        $before_cookie->user_mail = $datas['email'];

        $cookie = [
            'name' => 'login_data',
            'value' => base64_encode(json_encode($before_cookie)),
            'expire' => (60 * 60 * 24 * 7),
            'secure' => false
        ];
        $this->input->set_cookie($cookie);

        if (getLoginUserData('role_id') == 5) {
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
        }

        echo ajaxRespond('OK', '<p class="ajax_success">Profile Updated Successfully<p>');
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

    public function api_profile($user_id = 0)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $user_id = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        if (empty($user_id)) {
            json_output_display(200, ['status' => 0, 'message' => 'No record found']);
            die;
        }
        $user_id = $user_id->user_id;

        is_token_match($user_id, $token);
        $data = $this->db->where('id', $user_id)->get('users')->row();
//        $countries = $this->db->get_where('countries', [ 'status' => 'Active' ])->result();
        $countries = $this->db->get_where('countries', ['status' => 'Active', 'type' => 1, 'parent_id' => '0'])->result();
        $res = [
            'status' => 1,
            'result' => $data,
            'country_id' => $countries,
        ];
        if ($data) {
            json_output(200, $res);
        } else {
            json_output(200, ['status' => 0, 'message' => 'Something went worng, Please try agian']);
        }
    }

    public function api_update()
    {
        // ajaxAuthorized();
        $method = $_SERVER['REQUEST_METHOD'];
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $user_id = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }

        if (empty($user_id)) {
            json_output_display(200, ['status' => 0, 'Message' => 'No record found']);
            die;
        }
        $user_id = $user_id->user_id;

        is_token_match($user_id, $token);

        $datas = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'contact' => $this->input->post('contact'),
            'contact1' => $this->input->post('contact1'),
            'contact2' => $this->input->post('contact2'),
            'country_id' => $this->input->post('country'),
            'add_line1' => $this->input->post('userAddress1'),
            'add_line2' => $this->input->post('userAddress2'),
            'city' => $this->input->post('userCity'),
            'state' => $this->input->post('state'),
            'postcode' => $this->input->post('userPostCode')
        ];

        $update = $this->db->where('id', $user_id)->update('users', $datas);
        $res = [
            'status' => 1,
            'message' => 'Profile Updated Successfully'
        ];
        if ($update) {
            json_output(200, $res);
        } else {
            json_output(200, ['status' => 0, 'message' => 'Something went worng, Please try agian']);
        }
    }

    public function password()
    {
        $role_id = getLoginUserData('role_id');

        if ($role_id == 1 or $role_id == 2) {
            $this->viewAdminContent('password');
        } elseif ($role_id == 14) {
            viewAdminDriverNew('backend/trade/template/change_password');
        } elseif ($role_id == 9) {
            viewAdminMechanicNew('backend/trade/template/change_password');
        } else {
            $this->viewAdminContentPrivate('backend/trade/template/change_password');
        }
    }

    public function update_password()
    {

        $old_pass = $this->input->post('old_pass');
        $new_pass = $this->input->post('new_pass');
        $con_pass = $this->input->post('con_pass');

        if ($new_pass != $con_pass) {
            echo ajaxRespond('Fail', 'Confirm Password Not Match');
            exit;
        }


        $user_id = getLoginUserData('user_id');
        $user = $this->db->select('password')
            ->get_where('users', ['id' => $user_id])
            ->row();

        $db_pass = $user->password;
        $verify = password_verify($old_pass, $db_pass);

        if ($verify == true) {

            $hass_pass = password_hash($new_pass, PASSWORD_BCRYPT, ["cost" => 12]);
            $this->db->update('users', ['password' => $hass_pass], ['id' => $user_id]);

            echo ajaxRespond('OK', 'Password Reset Successfully');
        } else {
            echo ajaxRespond('Fail', 'Old Password not match, please try again.');
        }
    }

    public function api_update_password()
    {

        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }
        $user_id = ($u) ? $u->user_id : 0;

        is_token_match($user_id, $token);

        $old_pass = $this->input->post('old_pass');
        $new_pass = $this->input->post('new_pass');
        $con_pass = $this->input->post('con_pass');

        if ($new_pass != $con_pass) {
            json_output_display(200, ['status' => 0, 'message' => 'Confirm Password Not Match']);
            exit;
        }
        $user = $this->db->select('password')
            ->get_where('users', ['id' => $user_id])
            ->row();

        $db_pass = $user->password;
        $verify = password_verify($old_pass, $db_pass);


        if (strlen($new_pass) >= 12) {
            json_output_display(200, ['status' => 0, 'message' => 'Password must be  less than 12  character']);
            exit;
        }

        if ($verify == true) {
            $hass_pass = password_hash($new_pass, PASSWORD_BCRYPT, ["cost" => 12]);
            $this->db->update('users', ['password' => $hass_pass], ['id' => $user_id]);

            echo json_output(200, ['status' => 1, 'message' => 'Password Reset Successfully']);
        } else {
            echo json_output(200, ['status' => 0, 'message' => 'Old Password not match, please try again.']);
        }
    }

    public function video()
    {
//         $user_id        = getLoginUserData('user_id');
//         $data['user']   = $this->db->get_where('users', ['id' => $user_id])->row_array();
        $role_id = getLoginUserData('role_id');

        if ($role_id == 1 or $role_id == 2) {
            $this->viewAdminContent('video');
        } else {
            $this->viewNewAdminContent('trader_video');
        }
    }

    public function video_update()
    {
        $user_id = getLoginUserData('user_id');
        // $data['user']   = $this->db->get_where('users', ['id' => $user_id])->row_array();


        $videos[] = $this->input->post('video_id', TRUE);
        $user_id = $user_id;


        $this->db->where('user_id', $user_id);
        $this->db->delete('video_gallery');
        // for insert

        foreach (current($videos) as $data) {
            $data_in = array(
                'user_id' => $user_id,
                'video' => $data,
                'type' => 'Video'
            );
            $this->db->insert('video_gallery', $data_in);
        }

        echo ajaxRespond('OK', '<p class="ajax_success">Profile Updated Successfully<p>');
        // $this->viewAdminContent('video' );
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
        $user_id = getLoginUserData('user_id');
        $data['user'] = $this->db->get_where('users', ['id' => $user_id])->row_array();
        $data['meta'] = $this->db->select('meta_key,meta_value')->get_where('user_meta', ['user_id' => $user_id])->result_array();
        $data['cms_data'] = $this->db->select('id,post_title,post_url,content,thumb')->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row_array();

        $data['social_links'] = Profile_helper::userMetaValue('social_links');
        $data['business_hours'] = Profile_helper::userMetaValue('business_hours');

        $role_id = getLoginUserData('role_id');
        if ($role_id == 1 or $role_id == 2) {
            $this->viewAdminContent('business', $data);
        } else {
            $this->viewNewAdminContent('trader_business', $data);
        }

//        $this->viewAdminContent('business', $data);
    }

    // update Company profile
    public function business_update()
    {

        $user_id = getLoginUserData('user_id');
        $page_slug = slugify($this->input->post('user_slug', TRUE));

        // for user profile logo as company logo
        $this->companyLogo($user_id);

        if (getLoginUserData('role_id') == 4) {

            $page_id = $this->update_seller_page($user_id);
            $exist = $this->isExistsBusinessPage($page_slug, $page_id);

//            if ($exist) {
//                echo ajaxRespond('Fail', '<p class="ajax_error">Page URL already exist. Please change it</p>');
//                exit;
//            }//        $this->companyCover($page_id, $user_id);
            $this->update_user_meta($user_id);
        } else {
            $this->clearing_shipping_profile($user_id, $page_slug);
        }

        echo ajaxRespond('OK', '<p class="ajax_success">Page Update Successfully</p>');
    }

    public function clearing_shipping_profile($user_id, $page_slug)
    {
        $role_id = getLoginUserData('role_id');
        $table = $role_id == 16 ? 'clearing' : 'shipping';
        $before_data = $this->db->get_where($table, ['user_id' => $user_id])->row();
        $id = !empty($before_data) ? $before_data->id : 0;

        $before_slug = $this->db->get_where($table, ['post_url' => $page_slug, 'id !=' => $id])->row();

        $page_slug = !empty($before_slug) ? $page_slug . '-' . rand(0000, 9999) : $page_slug;

        $data = [
            'user_id' => getLoginUserData('user_id'),
            'companyName' => $this->input->post('companyName', TRUE),
            'companyOverview' => $this->input->post('companyOverview', TRUE),
            'companyWebsite' => $this->input->post('companyWebsite', TRUE),
            'whatsapp_number' => $this->input->post('whatsapp_number', TRUE),
            'business_phone' => $this->input->post('business_phone', TRUE),
            'userLocation' => $this->input->post('userLocation', TRUE),
            'post_url' => $page_slug
        ];

        if (!empty($id)) {
            $this->db->where('id', $id);
            $this->db->update($table, $data);
        } else {
            $this->db->insert($table, $data);
        }

    }

    private function isExistsBusinessPage($slug = '', $page_id = 0)
    {

        $page = $this->db->select('id')->get_where('cms', ['post_url' => $slug, 'id !=' => $page_id])->row();
        return ($page) ? $page->id : 0;
    }

    private function update_seller_page($user_id)
    {

        $page_id = $this->getSellerPageID($user_id);

        $page_slug = $this->input->post('user_slug', TRUE);
        $existSlug = $this->isExistsBusinessPage($page_slug, $page_id);
        $page_slug = $existSlug > 0 ? $page_slug . '-' . rand(11, 99999) : $page_slug;
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
            $page_id = $this->db->insert_id();
        }
        return $page_id;
        //echo ajaxRespond('OK', '<p class="ajax_success">Page Update Successfully</p>');
    }

    private function getSellerPageID($user_id = 0)
    {

        $page = $this->db->select('id')->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row();
        return ($page) ? $page->id : 0;
    }

    /* company logo used users table for for save profile logo */

    private function companyLogo($user_id)
    {
        $logo = '';
        $handle = new \Verot\Upload\Upload($_FILES['company_logo']);
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
        $cover = new \Verot\Upload\Upload($_FILES['cover_image']);
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
        $user_id = intval($user_id);


        $business_hours = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thusday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day) {
            if (!empty($_POST[$day])) {
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
        }

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

        $rows = array('userLocation', 'lat', 'lng', 'social_links', 'companyWebsite', 'business_hours', 'whatsapp_number', 'business_phone');


        $this->db->where('user_id', $user_id);
        $this->db->where_in('meta_key', $rows);
        $this->db->delete('user_meta');

//      echo '<pre>';
//      print_r($user_mata_data);
//      exit;

        return $this->db->insert_batch('user_meta', $user_mata_data);
    }

    public function company_info_view($user_id)
    {

        $user_data = $this->db->get_where('users', ['id' => $user_id])->row();
        $user_meta_data = $this->db->get_where('user_meta', ['user_id' => $user_id])->result_array();
        $data = ['user_data' => $user_data, 'meta_data' => $user_meta_data];

        //$data = (object) array_merge( (array) $user_data, (array) $user_meta_data );
        return $data;
    }


    public function switchAccountType()
    {
        $userId = getLoginUserData('user_id');
        $role = $this->input->post('role');

        $this->db->update('users', ['role_id' => $role], ['id' => $userId]);

        $user = $this->db->where('id', $userId)->get('users')->row();
        $cookie_data = json_encode([
            'user_id' => $user->id,
            'user_mail' => $user->email,
            'role_id' => $user->role_id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'photo' => $user->user_profile_image,
            'oauth_uid' => $user->oauth_uid,
            'oauth_provider' => $user->oauth_provider
        ]);

        $cookie = [
            'name' => 'login_data',
            'value' => base64_encode($cookie_data),
            'expire' => (60 * 60 * 24 * 7),
            'secure' => false
        ];
        $this->input->set_cookie($cookie);
        $this->session->set_userdata($cookie);

        $this->session->set_flashdata('success', 'Your account type has been changed successfully');

        redirect('my-account');
    }
}
