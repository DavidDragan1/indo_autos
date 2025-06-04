<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends Frontend_controller
{
    public function get_all_city()
    {
        $id = (isset($_GET['id'])) ? $_GET['id'] : 0;
        $post_areas = $this->db->select('*, state_id as parent_id')
            ->where("FIND_IN_SET('2',state_towns.type) <>", 0)
            ->where('state_id', $id)->get('state_towns')
            ->result();

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'cities' => $post_areas
            ]
        ]);
    }

    public function get_multiple_city_by_multiple_states()
    {
        $id = (isset($_GET['id'])) ? $_GET['id'] : [-1];
        $post_areas = $this->db->select('*, state_id as parent_id')->where("FIND_IN_SET('2',state_towns.type) <>",0)->where_in('state_id', $id)->get('state_towns')->result();

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' =>  $post_areas
        ]);
    }

    public function get_all_state_city()
    {
        $id = (isset($_GET['id'])) ? $_GET['id'] : 0;
        $type = (!empty($_GET['type'])) ? $_GET['type'] : 'location';
        if ($type == 'location'){
            $post_areas =
                $this->db->select('*, state_id as parent_id')->where( 'state_id', $id)
                    ->where("FIND_IN_SET('2',state_towns.type) <>",0)
                    ->get('state_towns')
                    ->result();
        } else {
            $post_areas =
                $this->db->where( 'country_id', $id)
                    ->where('type', $type)
                    ->get('post_area')
                    ->result();
        }


        return apiResponse([
            'status' => true,
            'message' => '',
            'data' =>  $post_areas
        ]);
    }

    public function get_parts_name()
    {
        $parent_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
        $parts = $this->db->query("SELECT * FROM parts_description WHERE parent_id LIKE '%#" . $parent_id . "#%'")->result();

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'parts' => $parts
            ]
        ]);
    }

    public function get_mobile_services()
    {
        $cat_id = (isset($_GET['id'])) ? $_GET['id'] : 0;
        $services = $this->db->where('parent_id', $cat_id)->get('towing_categories')->result();

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'services' => $services
            ]
        ]);
    }

    public function review( $slug ){
        $this->load->helper('posts/posts');
        $post = $this->db->where('post_slug', $slug)->get('posts')->row();

        $vehicle_type_id = $post->vehicle_type_id;
        $brand_id = $post->brand_id;
        $model_id = $post->model_id;
        $title = $post->title;
        $limit = 25;
        $page = $this->input->get('page');
        $start = startPointOfPagination($limit, $page);

        $brand =  $this->db->where(['vehicle_type_id' => $vehicle_type_id])->where('brand_id', $brand_id)->get('admin_review')->row();
        $model = $this->db->where(['vehicle_type_id' => $vehicle_type_id])->where('brand_id', $brand_id)->where('model_id', $model_id)->get('admin_review')->row();

        $this->db->select('admin_review.id, cms.*')
            ->where(['vehicle_type_id' => $vehicle_type_id]);

        if ($brand) {
            $this->db->where('brand_id', $brand_id);
        } else {
            $this->db->where('brand_id', 2214);
        }

        if ($model) {
            $this->db->where('model_id', $model_id);
        } else {
            $this->db->where('model_id', 2223);
        }

        $review = $this->db->join('cms', 'cms.id=admin_review.cms_id', 'LEFT')
            ->get('admin_review')->row();

        if ($review) {
            $search  = array('&lt;', '&gt;');
            $replace = array('<', '>');
            $content = str_replace($search, $replace, $review->content);
            $id = $review->id;
            $comments = $this->db
                ->from('comment')
                ->select('comment.*')
                ->select("CONCAT(CONCAT(users.first_name, ' ') , users.last_name) as user_name")
                ->select("CONCAT(IF(users.oauth_provider = 'web','" . base_url() . "uploads/users_profile/',''), users.user_profile_image) as user_photo")
                ->where(['parent_id' => $review->id, 'type' => 'Review'])
                ->join('users', 'users.id=comment.user_id', 'LEFT')
                ->limit($limit, $start)
                ->get()
                ->result();

            if (!isset($comments[0])) {
                $comments = null;
            }
            $comment_count = $this->db->from('comment')->where(['parent_id' => $review->id, 'type' => 'Review'])->count_all_results();
            $next_page_url = next_page_api_url($page, $limit, $comment_count, 'api/review/'.$slug);
            $prev_page_url = prev_page_api_url($page, 'api/review/'.$slug);
        } else {
            $content = "No review available.";
            $id = 0;
            $comments = null;
            $comment_count = 0;
            $next_page_url = next_page_api_url($page, $limit, $comment_count, 'api/review/'.$slug);
            $prev_page_url = prev_page_api_url($page, 'api/review/'.$slug);
        }

        $data = array(
            'id' => $id,
            'title' => $title,
            'vehicle_type_id' => $vehicle_type_id,
            'brand_id' => $brand_id,
            'brand_name' => getBrandNameById($brand_id),
            'model_id' => $model_id,
            'model_name' => getModelNameById($model_id, $brand_id),
            'review' => $content,
            'comments' => $comments,
            'next_page_url' => $next_page_url,
            'prev_page_url' => $prev_page_url,
            'total' => $comment_count,
           );

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $data
        ]);
    }

    public function addComment(){
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }
        $user_id = ($u) ? $u->user_id : 0;

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'If you want to comment please login.'
            ]);
        }

        $parent_id = $this->input->post('parent_id', TRUE);
        $type = $this->input->post('type', TRUE);
        $comment = $this->input->post('comment', TRUE);

        $data = array(
            'parent_id' => $parent_id,
            'type' => $type,
            'user_id' => $user_id,
            'comment' => $comment,
        );

        $this->db->insert('comment', $data);

        return apiResponse([
            'status' => true,
            'message' => 'Your comment is added successfully.'
        ]);
    }

    public function reviewAdd() {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }
        $user_id = ($u) ? $u->user_id : 0;

        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please login to give a review.'
            ]);
        }

        $vendor = intval($this->input->post('vendor_id', TRUE));

        $isExist = $this->db->where(['customer_id' => $user_id, 'vendor_id' => $vendor])->get('reviews')->row();
        if ($isExist) {
            return apiResponse([
                'status' => false,
                'message' => 'you have already given review to this page.'
            ]);
        }

        if ($user_id == $vendor) {
            return apiResponse([
                'status' => false,
                'message' => 'Seller can not give review to their own page.'
            ]);
        }

        if ( $this->input->post('rate', TRUE) == null ) {
            return apiResponse([
                'status' => false,
                'message' => 'Please enter your rate.'
            ]);
        }

        if ( floatval($this->input->post('rate', TRUE)) < 0 ) {
            return apiResponse([
                'status' => false,
                'message' => 'Rating should greater than 0.'
            ]);
        }

        if ( floatval($this->input->post('rate', TRUE)) > 5 ) {
            return apiResponse([
                'status' => false,
                'message' => 'Rating should smaller than 5.'
            ]);
        }

        if ( $this->input->post('review', TRUE) == null ) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Enter Your Review.'
            ]);
        }

        $data = array(
            'customer_id' => $user_id,
            'vendor_id' => intval($this->input->post('vendor_id', TRUE)),
            'service_id' => 0,
            'rate' => $this->input->post('rate', TRUE),
            'review' => $this->input->post('review', TRUE),
            'status' => 'Approve',
            'created' => date('Y-m-d H:i:s'),
        );

        $this->db->insert('reviews', $data);
        $insert_id = $this->db->insert_id();

        Modules::run('mail/newReviewNotificationToVendor', $insert_id);

        return apiResponse([
            'status' => true,
            'message' => 'Review is added successfully.'
        ]);
    }

    public function  getReviewList($vendor_id){
        $this->load->helper('reviews/reviews');
        $user_id = intval($vendor_id);
        $sort = $this->input->get('sort', TRUE);
        $limit = 25;
        $page = $this->input->get('page');
        $start = startPointOfPagination($limit, $page);

        if ($sort == 'old') {
            $condition = 'reviews.created';
            $order = 'ASC';

        } elseif ($sort == 'height') {
            $condition = 'reviews.rate';
            $order = 'DESC';

        } elseif ($sort == 'lowest') {
            $condition = 'reviews.rate';
            $order = 'ASC';

        } else {
            $condition = 'reviews.created';
            $order = 'DESC';
        }

        $total = $this->db->from('reviews')->where(['vendor_id' => $user_id, 'status' => 'Approve'])->count_all_results();
        $results = $this->db
            ->from('reviews')
            ->select('reviews.*')
            ->select("CONCAT(CONCAT(users.first_name, ' ') , users.last_name) as user_name")
            ->select("CONCAT(IF(users.oauth_provider = 'web','" . base_url() . "uploads/users_profile/',''), users.user_profile_image) as user_photo")
            ->where(['reviews.vendor_id' => $user_id, 'reviews.status' => 'Approve'])
            ->join('users', 'users.id=reviews.customer_id', 'LEFT')
            ->order_by($condition, $order)
            ->limit($limit, $start)
            ->get()->result();

        $avg = reviewsAvgCountByUserId($user_id);

        $queryString = "";
        foreach ($_GET as $key => $value) {
            if ($key != "page") {
                if (empty($queryString)) {
                    $queryString = $key . "=" . $value;
                } else {
                    $queryString = "&" . $key . "=" . $value;
                }
            }
        }
        $next_page_url = next_page_api_url($page, $limit, $total, 'api/get-review/'.$user_id, $queryString);
        $prev_page_url = prev_page_api_url($page, 'api/get-review/'.$user_id, $queryString);

        if(!isset($results[0])){
            $message = 'No review to show.' ;
            $results = null;
        } else {
            $message = '';
        }

        return apiResponse([
            'status' => true,
            'message' => $message,
            'data' => $results,
            'next_page_url' => $next_page_url,
            'prev_page_url' => $prev_page_url,
            'total' => $total,
            'avg' => $avg
        ]);
    }

}
