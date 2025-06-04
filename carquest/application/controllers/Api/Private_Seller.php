<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Private_Seller extends Frontend_controller
{
    public function getPrivateSeller()
    {
        $seller_id = $this->uri->segment(3);
        if (empty($seller_id)){
            return apiResponse([
                'status' => false,
                'message' => 'Invalid Request',
                'data' => []
            ]);
        }
        $this->db->select('id,contact,add_line1');
        $this->db->select("CONCAT(users.first_name, ' ', users.last_name) as name");
        $this->db->select("IF(users.user_profile_image IS null OR users.user_profile_image = '' , '', IF(users.oauth_provider = 'web', CONCAT('" . base_url() . "', 'uploads/users_profile/',users.user_profile_image), '')) as user_profile_image");
        $this->db->from('users');
        $this->db->where('id', $seller_id);
        $users = $this->db->get()->row();

        if (!isset($users) && empty($users)){
            return apiResponse([
                'status' => false,
                'message' => 'Invalid User',
                'data' => []
            ]);
        }

        $data['seller'] = $users;
        $data['more_from_seller'] = $this->getMoreFromSeller($seller_id);
        $data['avg_rating'] = $this->reviewsAvgCountByUserId($seller_id);
        $data['total_rating'] = $this->db->from('reviews')->where(['vendor_id' => $seller_id, 'status' => 'Approve'])->count_all_results();
        $seller_meta    = GlobalHelper::getUserMetaData($seller_id);
        $data['seller']->content = isset($seller_meta['content']) ? $seller_meta['content'] : "";

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $data
        ]);
    }

    private function getMoreFromSeller($user_id)
    {
        $page = intval($this->input->get('start'));
        $limit = 6;
        $baseURL = base_url();
        $posts = $this->db
            ->from('posts')
            ->select('posts.title, posts.id, posts.post_slug, posts.pricein, posts.priceindollar, posts.priceinnaira')
            ->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Featured'), CONCAT('$baseURL', 'uploads/car/', post_photos.photo)) as photo")
            ->join('post_photos', 'post_photos.post_id=posts.id AND (post_photos.size=0 OR post_photos.size = 285)', 'LEFT')
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

    private function reviewsAvgCountByUserId( $user_id = 0 ){
        $ci =& get_instance();
        $avr_rating = $ci->db
            ->select("AVG(rate) as Rating")->where('status', 'Approve')
            ->get_where('reviews', ['vendor_id' => $user_id])
            ->row();
        return isset($avr_rating->Rating) ? number_format($avr_rating->Rating, 1) : 0.0 ;
    }

}
