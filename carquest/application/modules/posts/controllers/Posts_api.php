<?php
use Illuminate\Database\Capsule\Manager as DB;
class Posts_api extends Frontend_controller
{

    //put your code here
    function __construct()
    {
        // GlobalHelper::access_log();
        parent::__construct();
        $this->load->model('Posts_model');
        $this->load->helper('posts');
    }

    function post_details($post_id = 0)
    {
        $token = $this->input->server('HTTP_TOKEN');
        $logged_user = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $logged_user = ($u) ? $u->user_id : 0;
        }

        $baseUrl = base_url();
        $this->db->select('posts.*');
        $this->db->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Medium'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo)) as photo");
        $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.left_photo) as left_photo");
        $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.right_photo) as right_photo");
        $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.back_photo) as back_photo");
        $this->db->select("GROUP_CONCAT(IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Medium'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo))) as images");
        $this->db->join('post_photos', 'post_photos.post_id=posts.id AND (post_photos.size=0 OR post_photos.size = 875)', 'LEFT');

        $this->db->from('posts');

        $this->db->select('cms.post_url as seller_slug');
        $this->db->select('users.contact as seller_contact_number');
        $this->db->select('IF(users.role_id = 4, cms.post_title, CONCAT(users.first_name," ", users.last_name)) as seller_name');
        $this->db->join('users', 'users.id=posts.user_id');
        $this->db->join('cms', 'cms.user_id=posts.user_id AND cms.post_type="business"', 'LEFT');
        // $this->db->where('posts.status', 'Active');
        //$this->db->where('posts.activation_date IS NOT NULL');
        //$this->db->where('posts.expiry_date >=', date('Y-m-d'));
        $this->db->where('posts.id', $post_id);
        $this->db->group_by('posts.id');

        $this->db->select("brands.name as brand_name, models.name as model_name");
        $this->db->join('brands', 'brands.id=posts.brand_id AND and brands.type="Brand"', 'LEFT');
        $this->db->join('brands as models', 'models.id=posts.model_id AND and models.type="Model"', 'LEFT');


        // auto mech
//        $this->db->select('posts.*,brand_meta.brand');
//        $this->db->join('brand_meta', 'brand_meta.post_id = posts.id', 'LEFT');
//        $conditions = ($brand_id) ? array_merge($conditions, ['brand_meta.brand' => $brand_id]) : $conditions;
//        $this->db->where('posts.post_type', 'Automech');

        // towing
        $this->db->select('towing_categories.name as towing_type_of_service_name');
        $this->db->join('towing_categories', "towing_categories.id=posts.towing_type_of_service_id AND posts.post_type = 'Towing'", 'LEFT');

        // spare and parts
        $this->db->select('parts_description.name as parts_description_name');
        $this->db->join('parts_description', 'parts_description.id=posts.parts_description', 'LEFT');

        $results = $this->db->get()->row();

        if (!empty($results)) {
            $results->hit = hit_counter($results->id, $results->hit, $results->user_id, $results->status, $logged_user);
            return apiResponse([
                'status' => true,
                'message' => '',
                'data' => $results
            ]);
        }

        return apiResponse([
            'status' => false,
            'message' => 'No Data Found',
            'data' => new stdClass()
        ]);
    }

    function post_details_v1($post_id = 0)
    {
        $token = $this->input->server('HTTP_TOKEN');
        $logged_user = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $logged_user = ($u) ? $u->user_id : 0;
        }

        $baseUrl = base_url();
        $this->db->select('posts.*');

        $this->db->from('posts');

        $this->db->select('cms.post_url as seller_slug');
        $this->db->select('users.contact as seller_contact_number');
        $this->db->select('IF(users.role_id = 4, cms.post_title, CONCAT(users.first_name," ", users.last_name)) as seller_name');
        $this->db->join('users', 'users.id=posts.user_id');
        $this->db->join('cms', 'cms.user_id=posts.user_id AND cms.post_type="business"', 'LEFT');
        $this->db->where('posts.id', $post_id);
        $this->db->group_by('posts.id');

        $this->db->select("brands.name as brand_name, models.name as model_name");
        $this->db->join('brands', 'brands.id=posts.brand_id AND and brands.type="Brand"', 'LEFT');
        $this->db->join('brands as models', 'models.id=posts.model_id AND and models.type="Model"', 'LEFT');

        // spare and parts
        $this->db->select('parts_description.name as parts_description_name');
        $this->db->join('parts_description', 'parts_description.id=posts.parts_description', 'LEFT');
        $this->db->where('users.status', 'Active');

        $results = $this->db->get()->row();


        if (!empty($results)) {
            $results->hit = hit_counter($results->id, $results->hit, $results->user_id, $results->status, $logged_user);

            $this->db->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Medium'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo)) as photo, back_photo, right_photo, left_photo");
            $this->db->from('post_photos');
            $this->db->where('post_photos.post_id', $post_id);
            $this->db->where_in('post_photos.size', ['875', '0']);
            $this->db->order_by('post_photos.featured', 'DESC');
            $photo = $this->db->get()->result();
            $results->photo = [];
            foreach ($photo as $pic){
                array_push($results->photo, $pic->photo);
                if ($pic->left_photo != null && $pic->left_photo != "") {
                    array_push($results->photo, base_url().'uploads/car/'.$pic->left_photo);
                }

                if ($pic->right_photo != null && $pic->right_photo != "") {
                    array_push($results->photo, base_url().'uploads/car/'.$pic->right_photo);
                }

                if ($pic->back_photo != null && $pic->back_photo != "") {
                    array_push($results->photo, base_url().'uploads/car/'.$pic->back_photo);
                }

            }
//            $results->photo = array_map(function ($o) {
//                return is_object($o) ? $o->photo : $o['photo'];
//            }, $photo);

            $results->related_posts = $this->getRelatedPost($post_id);

            $other_cost = $this->db->where('post_id', $results->id)->get('post_other_cost')->row();
            $results->other_cost = empty($other_cost) ? new stdClass() : $other_cost;

            if (!empty($other_cost)){
                $results->other_cost->total_amount =  $other_cost->shipping_amount + $other_cost->ground_logistics_amount + $other_cost->customs_amount + $other_cost->clearing_amount + $other_cost->vat_amount;
            }

            $results->is_liked = $this->db->get_where('post_likes', ['post_id' => $results->id, 'user_id' => $logged_user])->num_rows();
            return apiResponse([
                'status' => true,
                'message' => '',
                'data' => $results
            ]);
        }

        return apiResponse([
            'status' => false,
            'message' => 'No Data Found',
            'data' => new stdClass()
        ]);
    }


    function home()
    {
        $baseUrl = base_url();
        $this->db->select('p.condition,   p.priceinnaira,
             p.mileage, p.vehicle_type_id,  p.id, p.post_slug, p.title
             , p.featured_position, p.post_type, p.manufacture_year');
        $this->db->select("IF(p.post_type = 'import-car', CONCAT(post_area.name, ', ', countries.name), CONCAT(p.location, ', ', post_area.name)) as location");
        $this->db->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo)) as photo");
        $this->db->from('posts as p');
        $this->db->join('post_photos', "post_photos.post_id = p.id AND post_photos.featured = 'Yes' AND (post_photos.size=0 OR post_photos.size = 285)", 'LEFT');
        $this->db->join("countries", "countries.id = p.country_id AND p.post_type = 'import-car'", 'LEFT');
        $this->db->join("post_area", "post_area.id = p.location_id", 'LEFT');
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        //$this->db->where('p.vehicle_type_id', 1);
        $this->db->order_by('p.id', 'DESC');
        $this->db->limit(3);
        $this->db->group_by('p.id');

        $data = $this->db->get()->result();
        impression_increase(array_map(function ($o) {
            return is_object($o) ? $o->id : $o['id'];
        }, $data));

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'cars' => $this->home_helper(1, 3, 0),
                'bikes' => $this->home_helper(3, 3, 0),
                'spare_parts' => $this->home_helper(4, 3, 0),
            ]
        ]);
    }

    function latest_vehicle_api()
    {
        $limit = 30;
        $page = $this->input->get('page');
        $start = startPointOfPagination($limit, $page);
        $vehicle_id = $this->input->get('vehicle_type_id');

        if (empty($vehicle_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Vehicle Type ID could not empty',
                'data' => []
            ]);
        }

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $this->home_helper($vehicle_id, $limit, $start)
        ]);
    }

    private function home_helper($vehicle_id, $limit, $start = 0)
    {
        $baseUrl = base_url();
        $this->db->select('p.condition,   p.priceinnaira,
             p.mileage, p.vehicle_type_id,  p.id, p.post_slug, p.title
             , p.featured_position, p.post_type, p.manufacture_year');
        $this->db->select("IF(p.post_type = 'import-car', CONCAT(post_area.name, ', ', countries.name), CONCAT(p.location, ', ', post_area.name)) as location");
        $this->db->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo)) as photo");
        $this->db->from('posts as p');
        $this->db->join('post_photos', "post_photos.post_id = p.id AND post_photos.featured = 'Yes' AND (post_photos.size=0 OR post_photos.size = 285)", 'LEFT');
        $this->db->join("countries", "countries.id = p.country_id AND p.post_type = 'import-car'", 'LEFT');
        $this->db->join("post_area", "post_area.id = p.location_id", 'LEFT');
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        $this->db->where('p.post_type', 'General');
        $this->db->where('p.vehicle_type_id', $vehicle_id);
        $this->db->order_by('p.id', 'DESC');
        $this->db->limit($limit, $start);
        $this->db->group_by('p.id');
        $this->db->join('users', 'users.id = p.user_id');
        $this->db->where('users.status', 'Active');

        $data = $this->db->get()->result();
        impression_increase(array_map(function ($o) {
            return is_object($o) ? $o->id : $o['id'];
        }, $data));

        return $data;
    }

    public function search_list_v1()
    {
        $vehicle_type = $this->input->get('vehicle_type');
        $vehicle_type_id = GlobalHelper::getTypeIdByPageSlug($vehicle_type);
        $post_type = $this->input->get('post_type');

        $country_id = $this->input->get('country_id');

        $location = $this->input->get('state_id');
        $brand_id = $this->input->get('brand_id');
        $model_id = $this->input->get('model_id');
        $body_type = intval($this->input->get('body_type'));
        $age_from = intval($this->input->get('age_from'));
        $age_to = intval($this->input->get('age_to'));
        $price_from = intval($this->input->get('price_from'));
        $price_to = intval($this->input->get('price_to'));
        $mileage_from = intval($this->input->get('mileage_from'));
        $mileage_to = intval($this->input->get('mileage_to'));
        $condition = $this->input->get('condition');       // product condition new, used
        $fuel_type = intval($this->input->get('fuel_type'));
        $engine_size = intval($this->input->get('engine_size'));
        $gear_box = ($this->input->get('transmission'));
        $seats = intval($this->input->get('seats'));
        $color = intval($this->input->get('color_id'));
        $parts_id = intval($this->input->get('parts_id'));
        $s_parts_id = $this->input->get('s_parts_id');
        $parts_for = intval($this->input->get('parts_for'));
        $globalSearch = $this->input->get('global_search');
        $category_id = intval($this->input->get('category_id'));
        $parts_description = intval($this->input->get('parts_description'));
        $wheelbase = intval($this->input->get('wheelbase'));
        $year = intval($this->input->get('year'));
        $from_year = intval($this->input->get('from_year'));
        $to_year = intval($this->input->get('to_year'));
        $seller = $this->input->get('seller');
        $address = $this->input->get('location');// Business or Private

        $conditions = ['expiry_date >=' => date('Y-m-d')];

        $conditions = ($country_id) ? array_merge($conditions, ['posts.country_id' => $country_id]) : $conditions;
        $conditions = ($post_type) ? array_merge($conditions, ['post_type' => $post_type]) : $conditions;
        $conditions = ($vehicle_type_id) ? array_merge($conditions, ['posts.vehicle_type_id' => $vehicle_type_id]) : $conditions;
        $conditions = ($body_type) ? array_merge($conditions, ['posts.body_type' => $body_type]) : $conditions;
        $conditions = ($age_from) ? array_merge($conditions, ['posts.car_age >=' => $age_from]) : $conditions;
        $conditions = ($age_to) ? array_merge($conditions, ['posts.car_age <=' => $age_to]) : $conditions;
        $conditions = ($price_from) ? array_merge($conditions, ['posts.priceinnaira >=' => $price_from]) : $conditions;
        $conditions = ($price_to) ? array_merge($conditions, ['posts.priceinnaira <=' => $price_to]) : $conditions;
        $conditions = ($mileage_from) ? array_merge($conditions, ['posts.mileage >=' => $mileage_from]) : $conditions;
        $conditions = ($mileage_to) ? array_merge($conditions, ['posts.mileage <=' => $mileage_to]) : $conditions;
        $conditions = ($condition) ? array_merge($conditions, ['posts.condition' => $condition]) : $conditions;

        $conditions = ($fuel_type) ? array_merge($conditions, ['posts.fuel_id' => $fuel_type]) : $conditions;
        $conditions = ($engine_size) ? array_merge($conditions, ['posts.enginesize_id' => $engine_size]) : $conditions;
        $conditions = ($gear_box) ? array_merge($conditions, ['posts.gear_box_type' => $gear_box]) : $conditions;
        $conditions = ($seats) ? array_merge($conditions, ['posts.seats' => $seats]) : $conditions;
        $conditions = ($color) ? array_merge($conditions, ['posts.color' => $color]) : $conditions;
        $conditions = ($year) ? array_merge($conditions, ['posts.manufacture_year' => $year]) : $conditions;


        $conditions = ($parts_id) ? array_merge($conditions, ['posts.parts_description' => $parts_id]) : $conditions;
        $conditions = ($s_parts_id) ? array_merge($conditions, ['posts.parts_id' => $s_parts_id]) : $conditions;
        $conditions = ($parts_for) ? array_merge($conditions, ['posts.parts_for' => $parts_for]) : $conditions;


        $conditions = ($parts_description) ? array_merge($conditions, ['posts.parts_description' => $parts_description]) : $conditions;
        $conditions = ($category_id) ? array_merge($conditions, ['posts.category_id' => $category_id]) : $conditions;
        $conditions = ($wheelbase) ? array_merge($conditions, ['posts.alloywheels' => $wheelbase]) : $conditions;
        $conditions = ($seller) ? array_merge($conditions, ['posts.listing_type' => $seller]) : $conditions;


        $condition_str = "posts.activation_date IS NOT NULL";


        if ($vehicle_type == 'spare-parts') {
            if (!empty($from_year) && !empty($to_year)) {
                $condition_str .= "AND (((posts.to_year >= '$to_year' AND posts.manufacture_year <= '$to_year') OR (posts.to_year >= '$from_year' AND posts.manufacture_year <= '$from_year')) OR (posts.to_year <= '$to_year' AND posts.manufacture_year >= '$from_year'))";
            } else {
                $condition_str .= empty($to_year) ? '' : "AND (posts.to_year >= '$to_year' AND posts.manufacture_year <= '$to_year')";
                $condition_str .= empty($from_year) ? '' : "AND (posts.to_year >= '$from_year' AND posts.manufacture_year <= '$from_year')";
            }

        } else {
            $conditions = ($from_year) ? array_merge($conditions, ['posts.manufacture_year >=' => $from_year]) : $conditions;
            $conditions = ($to_year) ? array_merge($conditions, ['posts.manufacture_year <=' => $to_year]) : $conditions;
        }


        $checkAllState = $this->db->where('parent_id', 1111111111)->where('type', 'state')->get('post_area')->row();

        $checkAllLocation = $this->db->where('parent_id', $checkAllState->id)->where('type', 'location')->get('post_area')->row();

        $locPar = $this->db->where('id', $location)->where('type', 'state')->get('post_area')->row();
        if ($locPar && $locPar->parent_id != 1111111111) {
            $condition_str .= " AND (posts.location_id = '$locPar->id' OR posts.location_id = '$checkAllState->id')";
        }

        if ($address && $address != $checkAllLocation->name) {
            $condition_str .= " AND (posts.location LIKE '%$address%' OR posts.location LIKE '%$checkAllLocation->name%')";
        }

        $brand = $this->db->from('brands')->where('id', $brand_id)->get()->row();
        $model = $this->db->from('brands')->where('id', $model_id)->get()->row();

        if ($brand_id && $brand->id != 2214) {
            $condition_str .= " AND (posts.brand_id = $brand->id OR posts.brand_id = '2214')";
        }

        if ($model_id && $model->id != 2223) {
            $condition_str .= " AND (posts.model_id = $model->id OR posts.model_id = '2223')";
        }

        if (!empty($globalSearch)) {
            $condition_str .= " AND (posts.title LIKE '%$globalSearch%' OR posts.location LIKE '%$globalSearch%')";
        }

        $conditions = array_merge($conditions, ['posts.status' => 'Active', 'posts.expiry_date >=' => date('Y-m-d')]);

        //pp($conditions);

//    ----------------xxxxxxx-----All Condition Part End-----xxxxxxx---------------

//---------------- Getting Total Data--------------
//        $this->db->where($conditions);
//        $this->db->where($condition_str);
//        $this->db->group_by('posts.id');
//        $total = $this->db->get('posts')->num_rows();
//----------ending total data ----------------------

        $html = '';

//--------------- Start limit start target section --------------
        $limit = 30;
        $page = !empty(intval($this->input->get('page'))) ? $this->input->get('page') : 1;
        $start = startPointOfPagination($limit, $page);

//--------------- End limit start target section --------------
        $baseUrl = base_url();
//--------------- Start Before Featured Post Count ------------
        $featured_posts = [];
        if (empty($this->input->get('condition')) || !empty($brand_id) || !empty($model_id)) {
            $section = empty($this->input->get()) ? 'General' : (!empty($model_slug) ? 'Model' : 'Brand');
            $before_pages = $page - 1;
            if ($before_pages) {
                $this->db->where($conditions);
                $this->db->where($condition_str);
                $this->db->where('posts.featured_page !=', 0);
                $this->db->where('posts.featured_page <=', $before_pages);
                $this->db->where('posts.featured_section', $section);
                $this->db->group_by('posts.id');
                $this->db->join('users', 'users.id = posts.user_id');
                $this->db->where('users.status', 'Active');
                $start = $start - $this->db->get('posts')->num_rows();
            }

            $this->db->from('posts');
            $this->db->select('posts.condition,   posts.priceinnaira,
             posts.mileage, posts.vehicle_type_id,  posts.id, posts.post_slug, posts.title
             , posts.featured_position, posts.post_type, posts.manufacture_year');
            $this->db->select("IF(posts.post_type = 'import-car', CONCAT(post_area.name, ', ', countries.name), CONCAT(posts.location, ', ', post_area.name)) as location")
            ->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo)) as photo");
            $this->db->join('post_photos', "post_photos.post_id = posts.id AND post_photos.featured = 'Yes' AND (post_photos.size=0 OR post_photos.size = 285)", 'LEFT');
            $this->db->join("countries", "countries.id = posts.country_id AND posts.post_type = 'import-car'", 'LEFT');
            $this->db->join("post_area", "post_area.id = posts.location_id", 'LEFT');
            $this->db->join('users', 'users.id = posts.user_id');
            $this->db->where('users.status', 'Active');
            $this->db->order_by('posts.featured_position', 'ASC');
            $this->db->where($conditions);
            $this->db->where($condition_str);
            $this->db->where('posts.featured_page', $page);
            $this->db->where('posts.featured_section', $section);
            $this->db->group_by('posts.id');

            $featured_posts = $this->db->get()->result();
            $limit = $limit - count($featured_posts);
            // Adding Impression
            impression_increase(array_column($featured_posts, 'id'));
        }

//--------------- End Before Featured Post Count ------------

//--------------- start Order Related work --------------
        if ($this->input->get('sort_by') == 'price') {
            $order_column = 'posts.priceinnaira';
        } else if($this->input->get('sort_by') == 'date'){
            $order_column = 'posts.activation_date';
        } else {
            $order_column = 'posts.id';
        }

        if ($this->input->get('order_by') == 'asc') {
            $order_by = 'ASC';
        } else {
            $order_by = 'DESC';
        }
//--------------- End Order Related work --------------

//--------------- start Taking data with limit offset --------------
        $this->db->from('posts');
        $this->db->select('posts.condition,  posts.priceinnaira,
             posts.mileage, posts.vehicle_type_id,  posts.id, posts.post_slug, posts.title
             , posts.featured_position, posts.post_type, posts.manufacture_year')
            ->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo)) as photo");
        $this->db->select("IF(posts.post_type = 'import-car', CONCAT(post_area.name, ', ', countries.name), CONCAT(posts.location, ', ', post_area.name)) as location");
        $this->db->join('post_photos', "post_photos.post_id = posts.id AND post_photos.featured = 'Yes' AND (post_photos.size=0 OR post_photos.size = 285)", 'LEFT');
        $this->db->join("countries", "countries.id = posts.country_id AND posts.post_type = 'import-car'", 'LEFT');
        $this->db->join("post_area", "post_area.id = posts.location_id", 'LEFT');
        $this->db->join('users', 'users.id = posts.user_id');
        $this->db->where('users.status', 'Active');
        $this->db->order_by('posts.is_featured', 'DESC');
        $this->db->where($conditions);
        $this->db->where($condition_str);
        $this->db->where('posts.featured_page', 0);
        $this->db->group_by('posts.id');

            $this->db->order_by($order_column, $order_by);

        $this->db->limit($limit, $start);
        $results = $this->db->get()->result();


        impression_increase(array_column($results, 'id'));
        //pp($this->db->last_query());
//--------------- End Taking data with limit offset --------------

        $rearranged_data = array();

        $last_key = -1;
        for ($i = 0; $i <= 29; $i++) {
            $featured_key = array_search($i + 1, array_column($featured_posts, 'featured_position'));
            if (is_numeric($featured_key)) {
                $rearranged_data[] = $featured_posts[$featured_key];
            } else {
                if ($last_key < 0 && isset($results[0])) {
                    $rearranged_data[] = $results[0];
                    $last_key = 0;
                } else {
                    $last_key++;
                    if (isset($results[$last_key])) {
                        $rearranged_data[] = $results[$last_key];
                    }
                }
            }
        }

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $rearranged_data
        ]);

    }

    private function shortCase($shortType = '')
    {
        switch ($shortType) {
            case 'PriceASC':
                return ['column' => 'priceinnaira', 'order_by' => 'ASC'];
            case 'PriceDESC':
                return ['column' => 'priceinnaira', 'order_by' => 'DESC'];
            case 'MileageASC':
                return ['column' => 'mileage', 'order_by' => 'ASC'];
            case 'PostDateASC':
                return ['column' => 'activation_date', 'order_by' => 'ASC'];
            case 'PostDateDESC':
                return ['column' => 'activation_date', 'order_by' => 'DESC'];
            case 'all':
                return ['column' => 'activation_date', 'order_by' => 'DESC'];
            default :
                return ['column' => 'posts.activation_date', 'order_by' => 'DESC'];
        }
    }

    public function getRelatedPost($post_id = 0)
    {

        $current_type = $this->db->select('vehicle_type_id, post_type, model_id')->where('id', $post_id)->get('posts')->row();
        $baseUrl = base_url();
        $this->db->from('posts');
        $this->db->select('posts.condition,  posts.priceinnaira,
             posts.mileage, posts.vehicle_type_id,  posts.id, posts.post_slug, posts.title
             , posts.featured_position, posts.post_type, posts.manufacture_year')
        ->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo)) as photo");
        $this->db->select("IF(posts.post_type = 'import-car', CONCAT(post_area.name, ', ', countries.name), CONCAT(posts.location, ', ', post_area.name)) as location");
        $this->db->join('post_photos', "post_photos.post_id = posts.id AND post_photos.featured = 'Yes' AND (post_photos.size=0 OR post_photos.size = 285)", 'LEFT');        $this->db->join("countries", "countries.id = posts.country_id AND posts.post_type = 'import-car'", 'LEFT');
        $this->db->join("post_area", "post_area.id = posts.location_id", 'LEFT');
        $this->db->order_by('posts.id', 'RANDOM');
        $this->db->where('posts.id !=', $post_id);
        $this->db->where('posts.status', 'Active');
        $this->db->where('posts.activation_date IS NOT NULL');
        $this->db->where('posts.expiry_date >=', date('Y-m-d'));
        $this->db->where('posts.post_type', $current_type->post_type);
        $this->db->where('posts.vehicle_type_id', $current_type->vehicle_type_id);
        if ($current_type->vehicle_type_id != 4) {
            $this->db->where('posts.model_id', $current_type->model_id);
        }
        $this->db->group_by('posts.id');
        $this->db->limit(4);
        return $this->db->get()->result();
    }

    public function likeOrUnlike()
    {
        $token = $this->input->server('HTTP_TOKEN');
        $logged_user = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $logged_user = ($u) ? $u->user_id : 0;
        }

        if (empty($logged_user)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login',
                'data' => []
            ]);
        }

        $post_id = $this->input->post('post_id');
        $type = empty($this->input->post('type')) ? 'post' : $this->input->post('type');
        $msg = '';

        if (empty($post_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Select Post',
                'data' => []
            ]);
        }

        $exit = $this->db->get_where('post_likes', ['post_id' => $post_id, 'user_id' => $logged_user])->num_rows();
        if (!empty($exit)) {
            $this->db->where(['post_id' => $post_id, 'user_id' => $logged_user]);
            $this->db->delete('post_likes');
            $msg = 'Removed From Favourite';
        } else {
            $data = [
                'post_id' => $post_id,
                'user_id' => $logged_user,
                'type' => $type,
                'created' => date('Y-m-d')
            ];
            $this->db->insert('post_likes', $data);
            $msg = 'Added To Favourite';
        }

        return apiResponse([
            'status' => true,
            'message' => $msg,
            'data' => []
        ]);
    }

    public function favourite()
    {

        $token = $this->input->server('HTTP_TOKEN');
        $logged_user = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $logged_user = ($u) ? $u->user_id : 0;
        }

        if (empty($logged_user)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login',
                'data' => []
            ]);
        }

        $limit = 30;
        $page = !empty(intval($this->input->get('page'))) ? $this->input->get('page') : 1;
        $start = startPointOfPagination($limit, $page);
        $baseUrl = base_url();
        $this->db->select('p.condition,  p.priceinnaira,
             p.mileage,  p.id, p.post_slug, p.title
             , p.featured_position, p.post_type, p.vehicle_type_id, p.manufacture_year');
        $this->db->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo)) as photo");
        $this->db->select("IF(p.post_type = 'import-car', CONCAT(post_area.name, ', ', countries.name), CONCAT(p.location, ', ', post_area.name)) as location");
        $this->db->join('post_photos', "post_photos.post_id = p.id AND post_photos.featured = 'Yes' AND (post_photos.size=0 OR post_photos.size = 285)", 'LEFT');
        $this->db->join("countries", "countries.id = p.country_id AND p.post_type = 'import-car'", 'LEFT');
        $this->db->join("post_area", "post_area.id = p.location_id", 'LEFT');
        $this->db->select('post_area.name as state_name, IF(c.id IS NOT NULL, 1, 0) as is_financing');
        $this->db->from('posts as p');
        $this->db->join('post_likes', "p.id = post_likes.post_id AND post_likes.type = 'post'");
        $this->db->join(
            'car_list as c',
            "c.vehicle_type = p.vehicle_type_id AND
             (FIND_IN_SET(p.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
             (FIND_IN_SET(p.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= p.manufacture_year AND
              c.to_year >= p.manufacture_year AND
              (FIND_IN_SET(p.condition,c.car_condition)) AND
              (FIND_IN_SET(p.location_id,c.location_id)) AND
              (c.min_price <= IF(p.pricein = 'USD', p.priceindollar, p.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(p.pricein = 'USD', p.priceindollar, p.priceinnaira) OR c.max_price = 0) AND
              (c.seller_id IS NULL OR c.seller_id = '' OR find_in_set(p.user_id, c.seller_id) <> 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan'
              ",
            'LEFT'
        );
        $this->db->where('post_likes.user_id', $logged_user);
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        $this->db->order_by('p.id', 'DESC');
        $this->db->group_by('p.id');

        $count = $this->db->count_all_results('', FALSE);

        $this->db->limit($limit, $start);
        $data_posts = $this->db->get()->result();


        impression_increase(array_map(function ($o) {
            return is_object($o) ? $o->id : $o['id'];
        }, $data_posts));

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'total' => $count,
                'data' => $data_posts
            ]
        ]);

    }

    public function create_update_post()
    {
        $token = $this->input->server('HTTP_TOKEN');
        $logged_user = 0;
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
            $logged_user = ($u) ? $u->user_id : 0;
        }

        if (empty($logged_user)) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login',
                'data' => []
            ]);
        }

        $user = $this->db->where('id', $logged_user)->get('users')->row();
        if (isset($user) && (!in_array($user->role_id, array(4, 5, 1, 2)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer or Private Seller to list your car.',
                'data' => []
            ]);
        }

        $post_id = !empty($this->input->post('id')) ? $this->input->post('id') : 0;
        $posType = $this->input->post('post_type');

        $oldPostData = new stdClass();
        if (!empty($post_id)) {
            $oldPostData = $this->db->from('posts')->where('id' , $post_id)->get()->row();
        }

        if ($posType === 'import-car') {
            $post_type = 'import-car';
            $pricein = $this->input->post('pricein');
        } else {
            $post_type = 'General';
            $pricein = $this->input->post('pricein');
        }


        $pricevalue = $this->input->post('pricevalue', true);

        $vehicleId = $this->input->post('vehicle_type_id', TRUE);

        if (empty($post_id)) {
            $postSlug = slugify($this->input->post('title', TRUE));
            $hasSlugCount = $this->db->where([
                'post_slug' => $postSlug])
                ->where('id !=', $post_id)
                ->from('posts')->get()->num_rows();
            $postSlug = empty($hasSlugCount) ? $postSlug : $postSlug . '-' . mt_rand(0000, 9999);
        } else {
            $postSlug = $oldPostData->post_slug;
        }



        $data = array(
            'user_id' => $logged_user,
            'vehicle_type_id' => $vehicleId,
            'location' => $this->input->post('location', TRUE),
            'location_id' => $this->input->post('location_id', TRUE),
            'country_id' => $this->input->post('country_id', TRUE) ?: 0,
            'lat' => $this->input->post('lat', TRUE),
            'lng' => $this->input->post('lng', TRUE),
            'advert_type' => $this->input->post('advert_type', TRUE),
            'condition' => $this->input->post('condition', TRUE),

            'post_type' => $post_type,
            'listing_type' => $user->role_id == 4 ? 'Business' : 'Personal',  //$this->input->post('listing_type', TRUE) removing

            'title' => $this->input->post('title', TRUE),
            'description' => $this->input->post('description', TRUE),
            'pricein' => $pricein,
            'mileage' => $this->input->post('mileage', TRUE),
            'brand_id' => $this->input->post('brand_id', TRUE),
            'model_id' => $this->input->post('model_id', TRUE),
            'car_age' => $this->input->post('car_age', TRUE),
            'alloywheels' => $this->input->post('alloywheels', TRUE),
            'fuel_id' => $this->input->post('fuel_id', TRUE),
            'enginesize_id' => $this->input->post('enginesize_id', TRUE),
            'gear_box_type' => $this->input->post('gear_box_type', TRUE),
            'seats' => $this->input->post('seats', TRUE),
            'color' => $this->input->post('color', TRUE),
            'body_type' => $this->input->post('body_type', TRUE),
            'registration_date' => $this->input->post('reg_date', TRUE),
            'manufacture_year' => $this->input->post('manufacture_year', TRUE),
            'to_year' => $this->input->post('to_year', TRUE),
            'registration_no' => $this->input->post('registration_no', TRUE),
            'owners' => $this->input->post('owners', TRUE),
            'service_history' => $this->input->post('service_history', TRUE),
            'address' => $this->input->post('address', TRUE),
            'post_slug' => $postSlug,
        );
//        pp($data);
        $customizeData = [];
        if (!empty($post_id)) {
            $customizeData = [
                'modified' => date('Y-m-d h:i:s'),
            ];
        } else {
            $customizeData = [
                'package_id' => 0,                      // TODO::Need Dynamic Next $this->input->post('package_id', TRUE),
                'status' => "Pending",
                'created' => date('Y-m-d h:i:s'),
                'modified' => date('Y-m-d h:i:s'),
            ];
        }

        $data = $data + $customizeData;

        $price = [];
        if ($pricein == 'NGR') {
            $price['priceinnaira'] = $pricevalue;
        } else {
            $price['priceindollar'] = $pricevalue;
        }

        // only MotorBike
        $vehicle = [];
        if ($vehicleId == 2) {
            $features = $this->input->post('feature_ids');
            $feature_ids = ($features) ? implode(',', $features) : null;

            $vehicle['mileage'] = $this->input->post('mileage', TRUE);
            $vehicle['car_age'] = $this->input->post('car_age', TRUE);
            $vehicle['alloywheels'] = $this->input->post('alloywheels', TRUE);
            $vehicle['fuel_id'] = $this->input->post('fuel_id', TRUE);
            $vehicle['enginesize_id'] = $this->input->post('enginesize_id', TRUE);
            $vehicle['color'] = $this->input->post('color', TRUE);
            $vehicle['registration_date'] = $this->input->post('reg_date', TRUE);
            $vehicle['registration_no'] = $this->input->post('registration_no', TRUE);
            $vehicle['feature_ids'] = $feature_ids;

            $data = $data + $vehicle;
        } // only Parts
        else if ($vehicleId == 4) {
            $parts = array(
                'parts_description' => $this->input->post('parts_description', TRUE),
                'parts_for' => $this->input->post('parts_for', TRUE),
                'repair_type_id' => $this->input->post('repair_type_id', TRUE),
                'category_id' => $this->input->post('category_id', TRUE),
                'parts_id' => $this->input->post('parts_id', TRUE),
            );
            $data = $data + $parts;
        } else if ($vehicleId != 3 && $vehicleId != 4) {
            $features = $this->input->post('feature_ids');
            if ($features && count($features)) {
                $feature_ids['feature_ids'] = implode(',', $features);
                $data = $data + $feature_ids;
            }

        }

        $data = $data + $price;

        if (!empty($post_id)) {
            //pp('in');
            $this->db->where('id', $post_id);
            $this->db->update('posts', $data);
//            $this->Posts_model->update($post_id,$data);
            $insert_id = $post_id;
            $response_message = 'The Product was updated successfully';
        } else {
            //pp('out');
            $this->Posts_model->insert($data);
            $insert_id = $this->db->insert_id();
            $response_message = 'The Product was added successfully';
        }

        if (!empty($insert_id) && $posType === 'import-car') {
            $importCar['shipping_amount'] = !empty($this->input->post('shipping_amount')) ? $this->input->post('shipping_amount') : 0;
            $importCar['ground_logistics_amount'] = !empty($this->input->post('ground_logistics_amount')) ? $this->input->post('ground_logistics_amount') : 0;
            $importCar['customs_amount'] = !empty($this->input->post('customs_amount')) ? $this->input->post('customs_amount'): 0;
            $importCar['clearing_amount'] = !empty($this->input->post('clearing_amount')) ? $this->input->post('clearing_amount') : 0;
            $importCar['vat_amount'] = !empty($this->input->post('vat_amount')) ? $this->input->post('vat_amount') : 0;
            $importCar['is_third_party'] = $this->input->post('is_third_party');
            $otherCosts = DB::table('post_other_cost')->where(['post_id' => $insert_id])->first();
            if (!empty($otherCosts)) {
                DB::table('post_other_cost')->where(['post_id' => $insert_id])->update($importCar);
            } else {
                $importCar['post_id'] = $insert_id;
                DB::table('post_other_cost')->insert($importCar);
            }
//            $this->db->createCommand()

        }

        $photo_data = [];
        $size_list = [
            ['width' => 75, 'height' => 65],
            ['width' => 280, 'height' => 180],
            ['width' => 285, 'height' => 235],
            ['width' => 875, 'height' => 540],
        ];

        $files = array();
        foreach ($_FILES['images'] as $k => $l) {
            foreach ($l as $i => $v) {
                if (!array_key_exists($i, $files))
                    $files[$i] = array();
                $files[$i][$k] = $v;
            }
        }
        if (!empty($post_id)) {
            $this->db->where('post_id', $post_id);
            $this->db->delete('post_photos');
        }

        foreach ($files as $key => $img) {

            $rand = rand(00000, 99999);
            $photoName = $insert_id . '_photo_' . $rand.'.jpg';
            $stamp = imagecreatefrompng(dirname(BASEPATH) . '/assets/theme/new/images/whitetext-logo.png');
            $im = imagecreatefromstring(file_get_contents($img['tmp_name']));

            $sx = imagesx($stamp);
            $sy = imagesy($stamp);

            imagecopy($im, $stamp, (imagesx($im) - $sx)/2, (imagesy($im) - $sy)/2, 0, 0, imagesx($stamp), imagesy($stamp));
            ob_start();
            imagepng($im);
            $contents =  ob_get_contents();
            ob_end_clean();
            imagedestroy($im);
            $photo_data[$key]['photo'] = GlobalHelper::uploadImageToCloudfare($contents, $photoName, true);
            $photo_data[$key]['post_id'] = $insert_id;
            $photo_data[$key]['size'] = 0;
            $photo_data[$key]['featured'] = $key == 0 ? 'Yes' : 'No';
        }

        //pp($photo_data);
        if (!empty($photo_data)) {
            $this->db->insert_batch('post_photos', $photo_data);
        }

        if (empty($post_id)) {
            Modules::run('mail/add_post_notice', $insert_id, $logged_user);
        }

        return apiResponse([
            'status' => true,
            'message' => $response_message,
            'data' => []
        ]);
    }

    public function towing_type_of_services_for_service()
    {
        $cat_id = !empty($_GET['cat_id']) ? $_GET['cat_id'] : ['-1'];

        $services = $this->db->where_in('parent_id', $cat_id)->get('towing_categories')->result();
        return apiResponse([
            'status' => true,
            'message' => '',
            'data' =>  $services
        ]);
    }

    public function getBrandsByVehicle_v1()
    {
        $vehicle_type_id = !empty($this->input->get('vehicle_type_id')) ? $this->input->get('vehicle_type_id') : [-1];
        $ci = &get_instance();
        $ci->db->where('type', 'Brand');
        $ci->db->group_start();
        foreach ($vehicle_type_id as $key =>  $vehicle_id){
            if ($key == 0){
                $ci->db->where("FIND_IN_SET('$vehicle_id',type_id) > 0");
            } else {
                $ci->db->or_where("FIND_IN_SET('$vehicle_id',type_id) > 0");
            }
        }
        $ci->db->group_end();
        $brands =  $ci->db->get('brands')->result();
        //$brands = $ci->db->query("SELECT * FROM brands where FIND_IN_SET('$vehicle_type_id',type_id) and type='Brand'")->result();
        //pp($ci->db->last_query());
        return apiResponse([
            'status' => true,
            'message' => '',
            'data' =>  $brands
        ]);
    }
}
