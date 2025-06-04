<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Trade_Seller extends Frontend_controller
{
    public function getTradeSeller()
    {
        $PageSlug = $this->uri->segment(3);

        $MatchSearchTemplate = ['auction-cars', 'import-car', 'motorbike', 'spare-parts', 'vans', 'automech-search'];
        $PageSlug = in_array($PageSlug, $MatchSearchTemplate) ? 'search' : $PageSlug;

        $cms = $this->db->get_where('cms', ['post_url' => $PageSlug])->row_array();
        if (isset($cms["thumb"])) {
            $cms["thumb"] = site_url("uploads/company_logo/" . $cms["thumb"]);
        }
        $data = $this->getBusinessPage($cms);
        $data['more_from_seller'] = $this->getMoreFromSeller($cms['user_id']);
        $data['seller_videos'] = $this->getSellerVideos($cms['user_id']);
        $data['avg_rating'] = reviewsAvgCountByUserId($cms['user_id']);
        $data['total_rating'] = $this->db->from('reviews')->where(['vendor_id' => $cms['user_id'], 'status' => 'Approve'])->count_all_results();

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'seller' => $data
            ]
        ]);
    }

    public function getTradeSeller_v1($seller_id)
    {

        // $seller_page primary content coming form cms tbl
        $this->load->helper('reviews/reviews');

        $seller_user = $this->db->select('id, role_id, first_name, last_name, email, contact, CONCAT(city, ", ", state) as location, profile_photo, user_profile_image')->get_where('users', ['id' => $seller_id])->row_array();

        $seller_page = $this->db->select('user_id, post_title, thumb, content')->get_where('cms', ['user_id' => $seller_id, 'post_type' => 'business'])->row_array();

        if (empty($seller_user)) {
            return apiResponse([
                'status' => false,
                'message' => 'No Seller Found',
                'data' => []
            ]);
        }

        $token = $this->input->server('HTTP_TOKEN');
        $logged_user = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $logged_user = ($u) ? $u->user_id : 0;
        }
        $user_id = $seller_user['id'];

        $seller_meta = GlobalHelper::getUserMetaData($user_id);
        $seller_meta['business_hours'] = $seller_user['role_id'] == 4 ? (!empty(json_decode(@$seller_meta['business_hours'])) ? json_decode(@$seller_meta['business_hours']) : new stdClass()) : new stdClass();


        $seller_data = [
            'seller_name' => $seller_user['role_id'] == 4 ? $seller_page['post_title'] : $seller_user['first_name'] . ' ' . $seller_user['last_name'],
            'content' => $seller_user['role_id'] == 4 ? $seller_page['content'] : @$seller_meta['content'],
            'seller_id' => $seller_user['id'],
            'contact_no' => $seller_user['role_id'] == 4 ? @$seller_meta['business_phone'] : $seller_user['contact'],
            'whatsapp_number' => $seller_user['role_id'] == 4 ? @$seller_meta['whatsapp_number'] : $seller_user['contact'],
            'location' => $seller_user['role_id'] == 4 ? $seller_meta['userLocation'] : $seller_user['location'],
            'seller_type' => $seller_user['role_id'] == 4 ? 'trade_seller' : 'private_seller'
        ];

        if ($seller_user['role_id'] == 4) {
            if (!empty($seller_user["profile_photo"])) {
                $seller_data["logo"] = site_url("uploads/company_logo/" . $seller_user["profile_photo"]);
            } else {
                $seller_data["logo"] = null;
            }
        } else {
            if (!empty($seller_user["user_profile_image"])) {
                $seller_data["logo"] = site_url("uploads/users_profile/" . $seller_user["user_profile_image"]);
            } else {
                $seller_data["logo"] = null;
            }
        }

        $seller = [
            'seller' => $seller_data,
            'meta' => $seller_meta,
            'cars' => $this->getData(1, $user_id),
            'bikes' => $this->getData(3, $user_id),
            'parts' => $this->getData(4, $user_id),
        ];

        if ($logged_user != $user_id) {
            //adding impression
            impression_increase(array_map(function ($o) {
                return is_object($o) ? $o->id : $o['id'];
            }, $seller['cars']));
            impression_increase(array_map(function ($o) {
                return is_object($o) ? $o->id : $o['id'];
            }, $seller['bikes']));
            impression_increase(array_map(function ($o) {
                return is_object($o) ? $o->id : $o['id'];
            }, $seller['parts']));
        }

        $this->db->select('reviews.*, child.review as child_review, child.id as child_id, users.city')
            ->select("CONCAT(CONCAT(users.first_name, ' ') , users.last_name) as user_name")
            ->where('reviews.status', 'Approve');
        $this->db->order_by('reviews.id', 'ASC');
        $this->db->where('reviews.vendor_id', $user_id);
        $this->db->join('users', 'users.id = reviews.customer_id', 'Left');
        $this->db->join('reviews as child', 'child.parent_id = reviews.id', 'left');
        $seller['reviews'] = $this->db->get('reviews')->result();


        $write_review_status = 'no';
        $this->db->select('reviews.id');
        $this->db->where('reviews.vendor_id', $user_id);
        $this->db->where('reviews.customer_id', $logged_user);
        $befor_review = $this->db->get('reviews')->row();

        if (empty($logged_user)) {
            $write_review_status = 'login';
        } elseif (!empty($befor_review)) {
            $write_review_status = 'no';
        } elseif ($logged_user == $user_id) {
            $write_review_status = 'no';
        } else {

            $msg = $this->db->query('select message.id from message 
                                     where (sender = ' . $logged_user . ' and receiver = ' . $user_id . ') or (sender = ' . $user_id . ' and receiver = ' . $logged_user . ')')->row();
            if (!empty($msg)) {
                $write_review_status = 'yes';
            } else {
                $mails = $this->db->query("select mails.id from mails 
                                     where (sender_id = '$logged_user' and reciever_id = '$user_id') or (sender_id = '$user_id' and reciever_id = '$logged_user')")->row();
                if (empty($mails)) {
                    $write_review_status = 'ask';
                } else {
                    $write_review_status = 'yes';
                }
            }
        }

        $seller['write_review_permission'] = $write_review_status;// $write_review_status;
        $seller['seller']['total_rating'] = count($seller['reviews']);
        if (!empty($seller['seller']['total_rating'])) {
            $seller['seller']['avr_rating'] = array_sum(array_column($seller['reviews'], 'rate')) / $seller['seller']['total_rating'];
        } else {
            $seller['seller']['avr_rating'] = 0;
        }


        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $seller
        ]);
    }


    private function getData($vehicle_type_id, $user_id)
    {
        $baseUrl = base_url();
        $this->db->select('p.condition,  p.priceinnaira,
             p.mileage,  p.id, p.post_slug, p.title
             , p.featured_position, p.post_type, p.vehicle_type_id, p.manufacture_year');
        $this->db->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo)) as photo");
        $this->db->select("IF(p.post_type = 'import-car', CONCAT(post_area.name, ', ', countries.name), CONCAT(p.location, ', ', post_area.name)) as location");
        $this->db->join('post_photos', "post_photos.post_id = p.id AND post_photos.featured = 'Yes' AND (post_photos.size = 0 OR post_photos.size = 285)", 'LEFT');
        $this->db->join("countries", "countries.id = p.country_id AND p.post_type = 'import-car'", 'LEFT');
        $this->db->join("post_area", "post_area.id = p.location_id", 'LEFT');
        $this->db->from('posts as p');
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        $this->db->where('p.vehicle_type_id', $vehicle_type_id);
        $this->db->where('p.user_id', $user_id);
        $this->db->order_by('p.id', 'DESC');
        $this->db->group_by('p.id');
        return $this->db->get()->result();
    }


    private function getBusinessPage($seller_page = [])
    {
        $this->load->helper('reviews/reviews');
        $user_id = $seller_page['user_id'];
        $seller_user = $this->db->get_where('users', ['id' => $user_id])->row_array();
        if (isset($seller_user["profile_photo"])) {
            $seller_user["profile_photo"] = site_url("uploads/company_logo/" . $seller_user["profile_photo"]);
        }
        if (isset($seller_user["user_profile_image"])) {
            $seller_user["user_profile_image"] = $seller_user['oauth_provider'] == 'web' ? site_url("uploads/users_profile/" . $seller_user["user_profile_image"]) : $seller_user["user_profile_image"];
        }
        $seller_meta = GlobalHelper::getUserMetaData($user_id);
        $seller_meta['business_hours'] = json_decode($seller_meta['business_hours']);
        $seller = [
            'seller' => $seller_page,
            'user' => $seller_user,
            'meta' => $seller_meta
        ];

        $seller['meta_title'] = $seller_page['post_title'];
        $seller['meta_description'] = getShortContent($seller_page['seo_description'], 120);
        $seller['meta_keywords'] = $seller_page['seo_keyword'];

        return $seller;
    }

    private function getMoreFromSeller($user_id)
    {
        $page = intval($this->input->get('start'));
        $limit = 6;
        $posts = $this->db
            ->from('posts')
            ->select('posts.*')
            ->select("CONCAT('" . base_url() . "uploads/car/', post_photos.photo) as photo")
            ->select("CONCAT('" . base_url() . "uploads/car/', post_photos.left_photo) as left_photo")
            ->select("CONCAT('" . base_url() . "uploads/car/', post_photos.right_photo) as right_photo")
            ->select("CONCAT('" . base_url() . "uploads/car/', post_photos.back_photo) as back_photo")
            ->select("GROUP_CONCAT('" . base_url() . "uploads/car/', post_photos.photo) as images")
            ->select("brands.name as brand_name, models.name as model_name")
            ->join('brands', 'brands.id=posts.brand_id AND and brands.type="Brand"')
            ->join('brands as models', 'models.id=posts.model_id AND and models.type="Model"')
            ->join('post_photos', 'post_photos.post_id=posts.id AND post_photos.size=875', 'LEFT')
            ->select('cms.post_url as seller_slug')
            ->select('users.contact as seller_contact_number')
            ->join('users', 'users.id=posts.user_id')
            ->join('cms', 'cms.user_id=posts.user_id AND cms.post_type="business"')
            ->limit($limit, $page)
            ->where('posts.user_id', $user_id)
            ->where('posts.status', 'Active')
            ->where('posts.expiry_date >=', date('Y-m-d'))
            ->group_by('posts.id')
            ->order_by('is_featured', 'DESC')
            ->order_by('posts.id', 'DESC')
            ->get()
            ->result();

        return $posts;
    }

    private function getSellerVideos($user_id)
    {
        $videos = $this->db->select('*')
            ->select("CONCAT('https://www.youtube.com/watch?v=', photo) as video")
            ->where(['user_id' => $user_id, 'type' => 'Video', 'status' => 'Active'])
            ->order_by('id', 'DESC')
            ->limit(3)
            ->get('gallery')
            ->result();

        return $videos;
    }

    public function role_list_v1(){
        $roles = $this->db->select('id, role_name as name')->where_in('id', [4,5,6,15,16])->get('roles')->result();
        return apiResponse([
            'status' => true,
            'data' => $roles
        ]);
    }

}
