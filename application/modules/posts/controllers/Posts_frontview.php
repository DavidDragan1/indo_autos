<?php

/**
 * Description of Posts_frontview
 *
 * @author Kanny
 */
use Illuminate\Database\Capsule\Manager as DB;

class Posts_frontview extends Frontend_controller
{

    //put your code here
    function __construct()
    {
        // GlobalHelper::access_log();
        parent::__construct();
        $this->load->model('Posts_model');
        $this->load->helper('posts');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('senderEmail', 'Sender email', 'trim|required|valid_email');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        $this->form_validation->set_rules('senderName', 'Name', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function getPosts($page_slug = null)
    {
        // $page_slug == page slug as search, auction-car, van etc
        $page_slug = is_null($page_slug) ? $this->input->get('page_slug') : $page_slug;
        $location_slug = $this->input->get('location');
        $type = GlobalHelper::getTypeIdByPageSlug($page_slug); // for get method
        $type_id = ($type == 0) ? intval($this->input->get('type_id')) : intval($type);
        $brand_slug = $this->input->get('brand');
        $model_slug = $this->input->get('model');
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
        $gear_box = ($this->input->get('gear_box'));
        $seats = intval($this->input->get('seats'));
        $color = intval($this->input->get('color_id'));
        $parts_id = intval($this->input->get('parts_id'));
        $s_parts_id = $this->input->get('s_parts_id');
        $parts_for = intval($this->input->get('parts_for'));
        $globalSearch = $this->input->get('global_search');

        $specialist = intval($this->input->get('specialist'));
        $repair_type = intval($this->input->get('repair_type'));
        $service = $this->input->get('service');

        // Towing
        $towing_service_id = intval($this->input->get('towing_service_id'));
        $vehicle_type = intval($this->input->get('vehicle_type'));
        $type_of_service = $this->input->get('type_of_service');
        $availability = $this->input->get('availability');


        $category_id = intval($this->input->get('category_id'));
        $parts_description = intval($this->input->get('parts_description'));
        $wheelbase = intval($this->input->get('wheelbase'));
        $year = intval($this->input->get('year'));
        $from_year = intval($this->input->get('from_year'));
        $to_year = intval($this->input->get('to_year'));
        $seller = $this->input->get('seller');             // Business or Private
        $conditions = ['expiry_date >=' => date('Y-m-d')];

        //
        $brand = $this->db->from('brands')->where('slug', $brand_slug)->get()->row();
        $model = $this->db->from('brands')->where('slug', $model_slug)->get()->row();

//        $conditions = ($location_slug) ? array_merge($conditions, ['location_id' => $location_slug]) : $conditions;
        // brand id will change with page slug
        // $conditions = ($$brand_slug)       ? array_merge($conditions, ['brand_id' => $$brand_slug]) : $conditions;
        $conditions = ($type_id) ? array_merge($conditions, ['vehicle_type_id' => $type_id]) : $conditions;
        $conditions = ($body_type) ? array_merge($conditions, ['body_type' => $body_type]) : $conditions;
        $conditions = ($age_from) ? array_merge($conditions, ['car_age >=' => $age_from]) : $conditions;
        $conditions = ($age_to) ? array_merge($conditions, ['car_age <=' => $age_to]) : $conditions;
        $conditions = ($price_from) ? array_merge($conditions, ['priceinnaira >=' => $price_from]) : $conditions;
        $conditions = ($price_to) ? array_merge($conditions, ['priceinnaira <=' => $price_to]) : $conditions;
        $conditions = ($mileage_from) ? array_merge($conditions, ['mileage >=' => $mileage_from]) : $conditions;
        $conditions = ($mileage_to) ? array_merge($conditions, ['mileage <=' => $mileage_to]) : $conditions;
        $conditions = ($condition) ? array_merge($conditions, ['condition' => $condition]) : $conditions;

        $conditions = ($fuel_type) ? array_merge($conditions, ['fuel_id' => $fuel_type]) : $conditions;
        $conditions = ($engine_size) ? array_merge($conditions, ['enginesize_id' => $engine_size]) : $conditions;
        $conditions = ($gear_box) ? array_merge($conditions, ['gear_box_type' => $gear_box]) : $conditions;
        $conditions = ($seats) ? array_merge($conditions, ['seats' => $seats]) : $conditions;
        $conditions = ($color) ? array_merge($conditions, ['color' => $color]) : $conditions;
        $conditions = ($year) ? array_merge($conditions, ['manufacture_year' => $year]) : $conditions;

        $conditions = ($from_year) ? array_merge($conditions, ['manufacture_year >=' => $from_year]) : $conditions;
        $conditions = ($to_year) ? array_merge($conditions, ['manufacture_year <=' => $to_year]) : $conditions;


        $conditions = ($parts_id) ? array_merge($conditions, ['parts_description' => $parts_id]) : $conditions;
        $conditions = ($s_parts_id) ? array_merge($conditions, ['parts_id' => $s_parts_id]) : $conditions;
        $conditions = ($parts_for) ? array_merge($conditions, ['parts_for' => $parts_for]) : $conditions;


        $conditions = ($specialist) ? array_merge($conditions, ['specialism_id' => $specialist]) : $conditions;
        $conditions = ($repair_type) ? array_merge($conditions, ['repair_type_id' => $repair_type]) : $conditions;
        $conditions = ($service) ? array_merge($conditions, ['service_type' => $service]) : $conditions;


        $conditions = ($parts_description) ? array_merge($conditions, ['parts_description' => $parts_description]) : $conditions;
        $conditions = ($category_id) ? array_merge($conditions, ['category_id' => $category_id]) : $conditions;
        $conditions = ($wheelbase) ? array_merge($conditions, ['alloywheels' => $wheelbase]) : $conditions;
        $conditions = ($seller) ? array_merge($conditions, ['listing_type' => $seller]) : $conditions;


        // "lat" : 9.096838999999999,
        // "lng" : 7.4812937


        // Towing
        $conditions = ($towing_service_id) ? array_merge($conditions, ['towing_service_id' => $towing_service_id]) : $conditions;
        $conditions = ($type_of_service) ? array_merge($conditions, ['towing_type_of_service_id' => $type_of_service]) : $conditions;
        $conditions = ($vehicle_type) ? array_merge($conditions, ['vehicle_type' => $vehicle_type]) : $conditions;
        $conditions = ($availability) ? array_merge($conditions, ['availability' => $availability]) : $conditions;


        $address = $this->input->get('address');
        $lat = $this->input->get('lat'); //  32.7554883;             --- Fort+Worth,+TX,+United+States
        $lng = $this->input->get('lng');  // -97.33076579999999;     --- Fort+Worth,+TX,+United+States
        $checkAllState = $this->db->where('parent_id', 1111111111)->where('type', 'state')->get('post_area')->row();
        $locPar = $this->db->where('slug', $location_slug)->where('type', 'state')->get('post_area')->row();
        $checkAllLocation = $this->db->where('parent_id', $checkAllState->id)->where('type', 'location')->get('post_area')->row();

        if ($location_slug && $locPar->parent_id != 1111111111) {
            $this->db->group_start()
                ->where('location_id', $locPar->id)
                ->or_where('location_id', $checkAllState->id)
                ->group_end();
        }

        //$this->db->from();
        if ($lat && $lng) {
            $sql_str = '( 3959 * acos( cos( radians( ' . $lat . ') ) * cos( radians( lat ) ) 
                    * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) 
                    * sin( radians( lat ) ) ) ) AS Radius';

            if ($page_slug == 'automech-search') {
                $this->db->select('brand_meta.brand, posts.*, ' . $sql_str);
            } else {
                $this->db->select('posts.*, ' . $sql_str);
            }

            $this->db->having('Radius <=', 100);

        } else {
            if ($address && $address != $checkAllLocation->name) {
                $this->db->group_start()
                    ->like('posts.location', ucfirst(str_replace('-', ' ', $address)))
                    ->or_like('posts.location', $checkAllLocation->name)
                    ->group_end();
            }
        }

        if ($page_slug == 'automech-search') {
            $this->db->where('posts.post_type', 'Automech');
            $this->db->where($conditions);
            if ($brand_slug && $brand->id != 2214) {
                $this->db->group_start()
                    ->where('brand_id', $brand->id)
                    ->or_where('brand_id', 2214)
                    ->group_end();
            }
        } else if ($page_slug == 'towing-search') {
            $this->db->where('posts.post_type', 'Towing');
            $this->db->where($conditions);
        } else {
            $this->db->where('posts.post_type', 'General');
            $this->db->where($conditions);
            if ($brand_slug && $brand->id != 2214) {
                $this->db->group_start()
                    ->where('brand_id', $brand->id)
                    ->or_where('brand_id', 2214)
                    ->group_end();
            }
        }
        if ($model_slug && $model->id != 2223) {
            $this->db->group_start()
                ->where('model_id', $model->id)
                ->or_where('model_id', 2223)
                ->group_end();
        }

        if (!empty($globalSearch)) {
            $this->db->group_start()
                ->like('title', $globalSearch)
                ->or_like('location', $globalSearch)
                ->group_end();
        }
        $this->db->where('posts.status', 'Active');
        $this->db->where('posts.activation_date IS NOT NULL');
        $this->db->where('posts.expiry_date >=', date('Y-m-d'));
        $this->db->group_by('posts.id');
        $total = $this->db->get('posts')->num_rows();


        $html = '';

        $limit = 30;
        $page = $this->input->get('page');
        $start = startPointOfPagination($limit, $page);
        $target = $this->my_ajax_paination($page_slug);
//
//        $html .= '<div class="col-12"><div class="row">';
//        $html .= '<div class="col-lg-3  col-12">
//                        <h3 class="subtitle"><img src="assets/theme/new/images/icons/bar.png" alt="image"> Filter Result</h3>
//                    </div>
//                    <div class="col-lg-9 col-12">
//                        <ul class="tagList" >';
        // TODO:: Hide for new design
        //$html .= $this->create_search_tags($page_slug);
//        $html .= '</ul></div></div></div>';

//        $html .= '<div class="row"><div class="col-md-12">';
//        $html .= getAjaxPaginator($total, $page, $target, $limit);
//        $html .= '</div><div class="clearfix"></div></div>';

        $sortP = $this->input->get('short');
        $order = $this->shortCase($this->input->get('short'));
        $order_column = $order['column'];
        $order_by = $order['order_by'];

        if ($location_slug && $locPar->parent_id != 1111111111) {
            $this->db->group_start()
                ->where('location_id', $locPar->id)
                ->or_where('location_id', $checkAllState->id)
                ->group_end();
        }

        $this->db->from('posts');
        if ($lat && $lng) {
            $sql_str = '( 3959 * acos( cos( radians( ' . $lat . ') ) * cos( radians( lat ) ) 
                    * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) 
                    * sin( radians( lat ) ) ) ) AS Radius';

            if ($page_slug == 'automech-search') {
                $this->db->select('brand_meta.brand, posts.*, ' . $sql_str);
            } else {
                $this->db->select('posts.*, ' . $sql_str);
            }


            $this->db->having('Radius <=', 100);
        } else {
            if ($address && $address != $checkAllLocation->name) {
                $this->db->group_start()
                    ->like('posts.location', $address)
                    ->or_like('posts.location', $checkAllLocation->name)
                    ->group_end();
            }
        }

        if ($page_slug == 'automech-search') {
            $this->db->where('posts.post_type', 'Automech');
            $this->db->where($conditions);
            if ($brand_slug && $brand->id != 2214) {
                $this->db->group_start()
                    ->where('brand_id', $brand->id)
                    ->or_where('brand_id', 2214)
                    ->group_end();
            }
        } else if ($page_slug == 'towing-search') {
            $this->db->where('posts.post_type', 'Towing');
            $this->db->where($conditions);
        } else {
            $this->db->where('posts.post_type', 'General');
            $this->db->where($conditions);
            if ($brand_slug && $brand->id != 2214) {
                $this->db->group_start()
                    ->where('brand_id', $brand->id)
                    ->or_where('brand_id', 2214)
                    ->group_end();
            }
        }
        if ($model_slug && $model->id != 2223) {
            $this->db->group_start()
                ->where('model_id', $model->id)
                ->or_where('model_id', 2223)
                ->group_end();
        }

        if (!empty($globalSearch)) {
            $this->db->group_start()
                ->like('title', $globalSearch)
                ->or_like('location', $globalSearch)
                ->group_end();
        }
//        $this->db->order_by('posts.is_featured', 'DESC');
        $this->db->where('posts.activation_date IS NOT NULL');
        $this->db->where('posts.expiry_date >=', date('Y-m-d'));
        $this->db->where('posts.status', 'Active');
        $this->db->group_by('posts.id');

        if (($sortP == "PriceASC" || $sortP == "PriceDESC") && $order_by == "DESC") {
            $this->db->order_by('is_featured', 'DESC');
            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('posts.activation_date', 'DESC');
            $this->db->order_by('priceindollar', $order_by);
        } else if (($sortP == "PriceASC" || $sortP == "PriceDESC") && $order_by == "ASC") {
            $this->db->order_by('is_featured', 'DESC');
            $this->db->order_by('priceindollar', $order_by);
            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('posts.activation_date', 'DESC');
        } else {
            $this->db->order_by('is_featured', 'DESC');
            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('id', 'DESC');
        }
        $this->db->limit($limit, $start);
        $results = $this->db->get()->result();

        // echo $this->db->last_query();

        $query_string = ''; //<pre>'. $this->db->last_query() . '</pre>';


        // $html .= $this->getFeaturedPost( $this->input->get('type_id') );


        if ($this->input->get('device_code', TRUE)) {
            $method = $_SERVER['REQUEST_METHOD'];
            if (DEVICE_AUTH == $this->input->get('device_code', TRUE) && $method == 'GET') {
                json_output(200, $results);
            }
            exit;
        }


        foreach ($results as $post) {
            $html .= $this->_per_post_view($post);
        }

        $html .= getAjaxPaginator($total, $page, $target, $limit);

        if ($total == 0) {

                $brandName = !empty($brand) ? $brand->name : '';
                $modelName = !empty($model) ? $model->name : '';
                $html .=  '<div class="col-12"><div class="notfoundProductWrap">
                        <h2>The Product '.$brandName.' '.$modelName.' you are looking for is not
                                                                                    available at the moment </h2>
                        <form>
                            <input type="text" name="email" class="browser-default" id="newsletter_email_temp" placeholder="please enter your email">
                            <button id="btn_subscribe_n" class="waves-effect" type="button">Subscribe</button>
                            <span id="newsletter-msg-t" class="text-danger text-center"></span>
                            <span id="msg-t" class="text-success text-center"></span>
                            <span><strong>Note:</strong> Please subscribe to be the first to know when the product becomes
            available </span>';


            $html .=  '<p>Do you have similar product for sale? Start to by <a href="admin/posts/create">listing</a> it for sale, buyers are waiting.</p>
                        </form>
                    </div></div>';
        }


        if ($this->input->is_ajax_request()) {
            $json = [
                'result' => $html,
                'count' => $total,
                'sql' => $query_string,
                'orderBy' => GlobalHelper::getShortBy($sortP, $page_slug)
            ];
            echo json_encode($json);

        } else {
            echo $query_string;
            echo $html;
        }


    }

    private function getFeaturedPost($type_id = null)
    {

        $html = '';

        if ($type_id) {
            $this->db->where('vehicle_type_id', $type_id);
        }
        $this->db->where('expiry_date >=', date('Y-m-d'));
        $this->db->where('is_featured', 'Yes');
        $this->db->where('status', 'Active');
        $this->db->order_by('id', 'RAND');
        $results = $this->db->get('posts')->result();

        foreach ($results as $post) {
            $html .= $this->_featured_per_post_view($post);
        }
        return $html;

    }

    private function _per_post_view($post = [])
    {
//        $logged_user = intval(getLoginUserData('user_id'));
//        if ($post->is_featured == 'Yes') {
//            $class = 'product-list-wrap product-list-wrap-featured';
//        } else {
//            $class = 'product-list-wrap';
//        }
        $html = '';
//
//        $html .= '<div class="'.$class.'">';
//        $html .= '<div class="row">';
//        $html .= '<div class="col-lg-5 col-12">';
//        $html .= '<div class="product-list-img"><a href="post/' . $post->post_slug . '">' . GlobalHelper::getPostFeaturedPhoto($post->id, 'midium', null, 'grayscale lazyload',getShortContentAltTag(($post->title), 60)) . '</div>';
//        $html .= '</a></div>';
//        $html .= '<div class="col-lg-7 col-12 product-list-content">';
//        $html .= '<h3><a href="post/' . $post->post_slug . '">' . getShortContent(($post->title), 33) . '</a></h3>';
//        $html .= '<div class="product-list-info">';
//        $html .= '<ul class="list">';
//        $html .= '<li><strong>ID:</strong> ' . sprintf("%'.05d", $post->id) . ' (' . GlobalHelper::getVehicleByPostId($post->id) . ')</li>';
//        $html .= '<li><strong>Published:</strong>' . globalDateFormat($post->activation_date) . '</li>';
//        $html .= '<li><strong>Brand:</strong>' . getBrandNameById($post->brand_id) . '</li>';
//        $html .= '<li><strong>Condition:</strong>' . $post->condition . '</li>';
//        $html .= '<li><strong>Location:</strong>' . getShortContent($post->location, 30) . '</li>';
//        $html .= '</ul>';
//        $html .= '<h5><span>PRICE</span>' . GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) . '</h5>';
//        $html .= GlobalHelper::getSellerTags($post->user_id);
//        $html .= '</div>';
//        $html .= '<ul class="btnWrap">';
//        $html .= '<li class="report" onclick="manage_report(' . $post->id . ', \'' . $post->post_slug . '\');"><a href="javascript:void(0)"><img src="assets/theme/new/images/icons/report.png" alt="image">Report this Advert</a></li>';
//        $html .= '<li class="details"><a href="post/' . $post->post_slug . '">More Details</a></li>';
//        $html .= '<li class="quote"><a href="javascript:void(0)" onclick="get_quote(' . $post->id . ',' . $post->user_id . ', \'' . $post->post_slug . '\')">Get a Quote</a></li>';
//        $html .= '</ul>';
//        $html .= '</div>';
//        $html .= '</div>';
//        $html .= ' </div>';
        $is_financing = '';


        if (isset($post->is_verified)) {
            $is_verified = $post->is_verified == 'Verified seller' ? "<img src=\"assets/new-theme/images/icons/verify-new.svg\"  title=\"Verified\" alt=\"\">" : "";
        } else {
            $is_verified = '';
        }


        $milage = in_array($post->vehicle_type_id, [1,3]) ? "<li class=\"km\">".number_shorten($post->mileage)." Miles</li>" : '';
        $html .= "<div class=\"col-12 col-md-6 col-xl-4\">
                            <div class=\"carPost-wrap\">
                                <a class=\"carPost-img\" href=\"post/$post->post_slug\">
                                    ". GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, 'grayscale lazyload post-img',getShortContentAltTag(($post->title), 60)) ."
                                    $is_financing
                                </a>
                                <div class=\"carPost-content\">
                                    <span class=\"level\">$post->condition</span>
                                    <h4><a href=\"post/$post->post_slug\">". getShortContent(($post->title), 20) ."</a>" . $is_verified . "</h4>
                                    <ul class=\"post-price\">
                                        <li class=\"price\">". GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) ."</li>
                                        $milage
                                    </ul>
                                    <span class=\"location\">$post->location</span>
                                </div>
                            </div>
                        </div>";

        return $html;
    }

    private function _featured_per_post_view($post = [])
    {
        $logged_user = intval(getLoginUserData('user_id'));

        $html = '';
        $html .= '<div class="search-box featured_posts">';

        $html .= '<div class="col-md-4 nopadding search-box-image"><a href="post/' . $post->post_slug . '">' . GlobalHelper::getPostFeaturedPhoto($post->id, 'medium', null, 'grayscale lazyload',getShortContentAltTag(($post->title), 60)) . '</a></div>';

        $html .= '<div class="col-md-8 search-box-content">';
        $html .= '<h2><a href="post/' . $post->post_slug . '">' . getShortContent(($post->title), 35) . '</a></h2>';
        $html .= '<div class="col-md-8 search-box-content-left">';

        $html .= '<p style=" color:#ef5c26;">#ID-' . sprintf("%'.05d", $post->id) . '<span style="color: #b6b6b6;">(' . GlobalHelper::getVehicleByPostId($post->id) . ')</span> </p>';
        $html .= '<p><i class="fa fa-calendar" ></i> Published: ' . globalDateTimeFormat($post->created) . '</p>';
        $html .= '<p><i class="fa fa-bookmark-o" aria-hidden="true"></i> Brand: ' . getBrandNameById($post->brand_id) . '</p>';
        $html .= '<p><i class="fa fa-cog" aria-hidden="true"></i>Condition: ' . ($post->condition) . '</p>';
        $html .= '<p class="seach-box-location"><i class="fa fa-map-marker" aria-hidden="true"></i> ' . getShortContent($post->location, 30) . '</p>';

        $html .= '</div>';
        $html .= '<div class="col-md-4 search-box-content-right text-right">';
        $html .= '<p>Price</p>';
        $html .= '<p class="listing-prices"> ' . GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) . '</p>';
        $html .= GlobalHelper::getSellerTags($post->user_id);

        $html .= '</div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div class="col-md-12 search-box-content-last">';
        $html .= '<div class="col-md-4 listing-report nopadding">';
        $html .= '<span class="listing-report" onclick="manage_report(' . $post->id . ', \'' . $post->post_slug . '\');"><i class="fa fa-ban"></i> Report This Advert</span>';
        $html .= '</div>';
        $html .= '<div class="col-md-8 no-padding text-right">';
        $html .= '<a href="post/' . $post->post_slug . '" class="btn btn-default greenstil">More Details <i class="fa fa-mail-forward" aria-hidden="true"></i></a>';
        $html .= '<button type="button" onclick="get_quote(' . $post->id . ',' . $post->user_id . ', \'' . $post->post_slug . '\')" class="btn btn-default">Get a Quote <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
        $html .= '</div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '</div>';
        return $html;
    }

//    private function _per_post_view($post = []) {
//        $logged_user = intval( getLoginUserData('user_id') );
//        $html  ='';
//        $html .= '<div class="post_row clearfix"><div class="col-md-12">';
//        $html .= '<div class="row">';
//        $html .= '<div class="col-md-12 result-big-box">';
//
//
//        $html .= '<div class="col-md-3 no-padding">' . GlobalHelper::getPostFeaturedPhoto( $post->id, 'midium') .'</div>';
//
//        // Box - 3 - start
//        $html .= '<div class="col-md-6">';
//        $html .= '<h3>' . GlobalHelper::showLetest( $post->created )
//                . '<a href="post/' . $post->post_slug . '">' . $post->title . '</a></h3>'
//                . '<h6>#ID-' . sprintf("%'.05d", $post->id) . '</h6>';
//        $html .= '<p>Brand: '. getBrandNameById($post->brand_id) . '</p>';
//        $html .= '<p>Condition: '. ($post->condition) . '</p>';
//        $html .= '<p><i class="fa fa-map-marker"></i> ' . $post->location . '</p>';
//        //$html .= '<p>' . getShortContent($post->description, 120) . '</p>';
//        $html .= '</div>';
//        // Box - 3 - End
//
//        $html .= '<div class="col-md-3 no-padding text-right">';
//        $html .= '<div class="post-price">'
//                . '<p>Price</p>'
//                . '<h2>' . GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein ) . '</h2>'
//                . '</div><br/>'
//                . GlobalHelper::getSellerTags( $post->user_id ) ;
//        $html .= '</div>';
//        $html .= '</div>'; // col-md-12 end
//
//        $html .= '</div>'; // row end
//
//        $html .= '<div class="row">';
//        $html .= '<div class="col-md-12 result-small-box">';
//
//        $html .= '<div class="col-md-6 no-padding">'
//                . '<span style="cursor: pointer;" onclick="manage_report('. $post->id .');">'
//                . 'Report This Advert'
//                . '</span>'
//                . '</div>';
//
//        $html .= '<div class="col-md-5 no-padding pull-right text-right">';
//        $html .= '<p><a href="post/' . $post->post_slug . '">More Details</a> | ';
//        $html .= '<a style="cursor: pointer;"  onclick="get_quote('.$post->id.','. $post->user_id.', \''.$post->post_slug.'\')">Make an Offer</a></p>';
//        $html .= '</div>';
//        $html .= '<div class="clearfix"></div>'; // end col-md-12
//        $html .= '</div>  <!--  end col-md-12 --> ';
//
//        $html .= '</div>'; // end row
//        $html .= '</div></div>';
//        return $html;
//    }

    private function my_ajax_paination()
    {

        $array = $_GET;
        $url = $this->uri->uri_string(). '?';

        unset($array['page']);
        unset($array['_']);

        if ($array) {
            $url .= \http_build_query($array);
        }
        $url .= '&page';
        return $url;

    }

    private function create_search_tags($page_url = null)
    {

        $tags = [
            'location_id' => [
                'tbl' => 'post_area',
                'col' => 'name',
                'lebel' => 'Area: '
            ],
            'address' => [
                'tbl' => 'no-tbl',
                'value' => $this->input->get('address'),
                'lebel' => 'Location: '
            ],
            'type_id' => [
                'tbl' => 'vehicle_types',
                'col' => 'name',
                'lebel' => 'Vehicle Type: '
            ],
            'brand_id' => [
                'tbl' => 'brands',
                'col' => 'name',
                'lebel' => 'Brand: '
            ],
            'model_id' => [
                'tbl' => 'brands',
                'col' => 'name',
                'lebel' => 'Model: '
            ],
            'body_type' => [
                'tbl' => 'body_types',
                'col' => 'type_name',
                'lebel' => 'Body Type: '
            ],
            'fuel_type' => [
                'tbl' => 'fuel_types',
                'col' => 'fuel_name',
                'lebel' => 'Fuel Type: '
            ],
            'engine_size' => [
                'tbl' => 'engine_sizes',
                'col' => 'engine_size',
                'lebel' => 'Eng.Size: '
            ],
            'color_id' => [
                'tbl' => 'color',
                'col' => 'color_name',
                'lebel' => 'Colour: '
            ],

            'parts_id' => [
                'tbl' => 'parts_description',
                'col' => 'name',
                'lebel' => 'Parts Description: '
            ],

            'seller' => [
                'tbl' => 'no-tbl',
                'value' => $this->input->get('seller'),
                'lebel' => 'Seller Type: '
            ],
            'condition' => [
                'tbl' => 'no-tbl',
                'value' => $this->input->get('condition'),
                'lebel' => 'Condition: '
            ],
            'age_from' => [
                'tbl' => 'range',
                'value' => '',
                'lebel' => 'Age: ' . $this->input->get('age_from') . ' - ' . $this->input->get('age_to')
            ],
            'price_to' => [
                'tbl' => 'range',
                'value' => '',
                'lebel' => 'Price: ' . ($this->input->get('price_from')) . ' - ' . ($this->input->get('price_to'))
            ],
            'mileage_from' => [
                'tbl' => 'range',
                'value' => '',
                'lebel' => 'Mileage: ' . ($this->input->get('mileage_from')) . ' - ' . ($this->input->get('mileage_to'))
            ],
            'wheelbase' => [
                'tbl' => 'no-tbl',
                'value' => $this->input->get('wheelbase'),
                'lebel' => 'Wheelbase: '
            ],
            'gear_box' => [
                'tbl' => 'no-tbl',
                'value' => $this->input->get('gear_box'),
                'lebel' => 'Gear box: '
            ],
            'year' => [
                'tbl' => 'no-tbl',
                'value' => $this->input->get('year'),
                'lebel' => 'Manufacture year: '
            ],
            'global_search' => [
                'tbl' => 'no-tbl',
                'value' => $this->input->get('global_search'),
                'lebel' => 'Search Key: '
            ],

        ];

        $html = '<ul class="tagList">';
        foreach ($tags as $key => $attr) {
            $id = $this->input->get($key);
            if ($id) {
                if ($attr['tbl'] == 'no-tbl') {
                    $html .= $this->buiildTag($attr['lebel'], $attr['value']);
                } elseif ($attr['tbl'] == 'range') {
                    $html .= $this->buiildTag($attr['lebel'], $attr['value']);
                } else {
                    $html .= $this->getName($attr['tbl'], $attr['col'], $id, $attr['lebel']);
                }
            }
        }

        if ($html) {
            $page_url = is_null($page_url) ? 'search' : $page_url;
            $html .= '<li><a href="' . $page_url . '">Reset</a></li>';
        }

        $html .= '</ul>';

        return $html;
    }

    private function getName($table = '', $column = '', $id = 0, $tag = 'Tag: ')
    {

        $result = $this->db->select($column)->get_where($table, ['id' => $id])->row();
        $html = '<li><span>';
        $html .= $tag;
        $html .= isset($result->$column) ? $result->$column : 'Empty';
        //$html .= ' <i class="fa fa-times-circle"></i>';
        $html .= '</span></li> &nbsp;';

        return $html;
    }

    private function buiildTag($tag, $value)
    {
        return '<li><span>' . $tag .': '. $value . '</span></li> &nbsp;';
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

    public function single($slug = null)
    {
        if (!$slug) {
            redirect(site_url('search'));
        } else {
            if ($slug == 'compare') {
                $this->getCompare();
            } else {
                $this->db->select('p.*');
                $this->db->select('pa.name as state_name, IF(c.id IS NOT NULL, 1, 0) as is_financing, t.name as tag_name, t.slug as tag_slug');
                $this->db->from('posts as p');
                $this->db->join('post_area as pa', "pa.id = p.location_id AND pa.type = 'state'", 'LEFT');
                $this->db->join('product_tags as t', "t.id = p.tag_id", 'LEFT');
                $this->db->join(
                    'car_list as c',
                    "c.vehicle_type = p.vehicle_type_id AND
             (FIND_IN_SET(p.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
              (FIND_IN_SET(p.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= p.manufacture_year AND
              c.to_year >= p.manufacture_year AND
              (FIND_IN_SET(p.condition,c.car_condition) OR FIND_IN_SET('All',c.car_condition)) AND
              (FIND_IN_SET(p.location_id,c.location_id) OR FIND_IN_SET('41',c.location_id)) AND
              (c.min_price <= IF(p.pricein = 'USD', p.priceindollar, p.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(p.pricein = 'USD', p.priceindollar, p.priceinnaira) OR c.max_price = 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan' AND
              (c.seller_id = '' OR c.seller_id IS NULL OR FIND_IN_SET(p.user_id, c.seller_id) <> 0 OR FIND_IN_SET('0', c.seller_id) <> 0)
              ",
                    'LEFT'
                );

                $this->db->join('users', 'users.id = p.user_id');
                $this->db->where('users.status', 'Active');
                $this->db->where('p.post_slug', $slug);
                if (!in_array(getLoginUserData('role_id'), [1, 2, 3])) {
                    $this->db->where('p.expiry_date >=', date('Y-m-d'));
                }
                $post = $this->db->get()->row();
                if ($post) {
                    $data = array(
                        'id' => $post->id,
                        'user_id' => $post->user_id,
                        'vehicle_type_id' => getProductTypeById($post->vehicle_type_id),
                        'type_id' => $post->vehicle_type_id,
                        'vehicle_type_id_int' => ($post->vehicle_type_id),
                        'condition' => $post->condition,
                        'title' => $post->title,
                        'post_slug' => $post->post_slug,
                        'description' => $post->description,
                        'postFeaturedThumb' => getFeatImageById($post->id),
                        'location' => $post->location,
                        'location_id' => $post->location_id,
                        'country_id' => $post->country_id,
                        'lat' => $post->lat,
                        'lng' => $post->lng,
                        'pricein' => $post->pricein,
                        'priceindollar' => $post->priceindollar,
                        'priceinnaira' => $post->priceinnaira,
                        'price' => $post->pricein == 'USD' ? $post->priceindollar : $post->priceinnaira,
                        'advert_type' => $post->advert_type,
                        'mileage' => $post->mileage,
                        'brand' => $post->brand_id,
                        'brand_id' => getBrandNameById($post->brand_id),
                        'model_name' => getModelNameById($post->model_id, $post->brand_id),
                        'model_id' => $post->model_id,
                        'car_age' => getCarAgeById($post->car_age),
                        'alloywheels' => getAllowWheelById($post->alloywheels),
                        'fuel_id' => getFuelNameById($post->fuel_id),
                        'enginesize_id' => getEngineSizesById($post->enginesize_id),
                        'gear_box_type' => $post->gear_box_type,
                        'seats' => getSeatById($post->seats),
                        'color' => getColorNameById($post->color),
                        'body_type' => getBodyTypeById($post->body_type),
                        'registration_date' => $post->registration_date,
                        'post_type' => $post->post_type,
                        'specialism_id' => $post->specialism_id,
                        'repair_type_id' => $post->repair_type_id,
                        'service_type' => $post->service_type,
                        'listing_url' => site_url('post/' . $post->id),

                        'is_financing' => $post->is_financing,
                        'state_name' => $post->state_name,
                        'tag_name' => $post->tag_name,
                        'tag_slug' => $post->tag_slug,


                        'manufacture_year' => $post->manufacture_year,
                        'to_year' => $post->to_year,
                        'registration_no' => $post->registration_no,
                        'get_features' => getFeatureById($post->feature_ids),
                        'get_tags' => getTagsById($post->tag_id),
                        'owners' => getOwnerById($post->owners),
                        'hit' => hit_counter($post->id, $post->hit, $post->user_id, $post->status, getLoginUserData('user_id')),
                        'status' => $post->status,
                        'service_history' => getServiceHistoryById($post->service_history),
                        'expiry_date' => $post->expiry_date,
                        'contact_no' => getUserDataByUserId($post->user_id, 'contact'),

                        'towing_service_id' => ($post->towing_service_id) ? $post->towing_service_id : null,
                        'towing_type_of_service_id' => ($post->towing_type_of_service_id) ? $post->towing_type_of_service_id : null,
                        'availability' => ($post->availability) ? $post->availability : null,
                        'vehicle_type' => ($post->vehicle_type) ? $post->vehicle_type : null,

                        'towing_service_name' => ($post->towing_service_id) ? GlobalHelper::get_towing_services($post->towing_service_id) : null,
                        'towing_type_of_service_name' => ($post->towing_type_of_service_id) ? GlobalHelper::get_towing_type_of_services($post->towing_type_of_service_id) : null,
                        'vehicle_type_name' => ($post->vehicle_type) ? GlobalHelper::get_DropDownVehicleTypeTowing($post->vehicle_type) : null,
                        'breads' => [
                            'Search',
                            $post->title
                        ]


                    );
                    $logged_user = getLoginUserData('user_id');

                    $data['is_liked'] = $this->db->get_where('post_likes', ['post_id' => $post->id, 'user_id' => $logged_user])->num_rows();

                    $meta['meta_title'] = $post->title;
                    $meta['meta_description'] = getShortContent($post->description, 120);
                    $meta['meta_keywords'] = 'Buy old and New Car';
                    //$this->load->view('frontend/new/header', $meta);
                    $ltv =  $this->db->select('AVG(ltv) as ltv')->get_where('car_list', ['type' => 'loan'])->row();
                    $interest = $this->db->select('AVG(interest_in_percent) as interest')->get_where('periods', ['type' => 'loan'])->row();
                    $data['ltv'] = $ltv->ltv;
                    $data['interest'] = $interest->interest;
                    $user = $this->db->get_where('users', ['id' => $logged_user])->row_array();


                    // echo time();

                    $data['current_status'] = (!empty($user) && ($user['current_status'] == 'Online') && ($user['last_access'] > time())) ? 'online' : 'offline';
                    $data['last_status'] = (!empty($user) && ($user['current_status'] == 'Online') && ($user['last_access'] > time())) ? 'Online' : 'Offline';
                    // $data['user_id'] = $logged_user;


                    $review = $this->db->where(['vehicle_type' => $post->vehicle_type_id, 'brand_id' => $post->brand_id, 'model_id' => $post->model_id])->get('car_review')->row();

                    $user_id = getLoginUserData('user_id');
                    if ($post->status != 'Active' && empty($user_id)) {
                        $this->load->view('frontend/404', $data);
                    } else {
                       // $this->load->view('frontend/new/template/single', $data);
                        if ($post->post_type == 'import-car'){
                            $other_cost = $this->db->where('post_id', $post->id)->get('post_other_cost')->row();
                            $this->viewFrontContentNew('frontend/new/template/import_single', array_merge($data, $meta, ['review' => $review], ['other_cost' => $other_cost]));
                        } else {
                            $this->viewFrontContentNew('frontend/new/template/single', array_merge($data, $meta, ['review' => $review]));
                        }

                    }

                    //$this->load->view('frontend/new/footer');
                } else {
                    redirect(site_url('buy/car'));
                }
            }
        }
    }

    /*
     * related post by vichle_type_id
     * int type_id
     */
    public function getRelatedPost($model_id = 0, $post_id = 0)
    {

        $current_type = $this->db->select('vehicle_type_id, post_type')->where('id', $post_id)->get('posts')->row();

        if ($current_type->vehicle_type_id == 4) {

            $related_posts = $this->db
                ->select('posts.*')
                ->order_by('posts.id', 'RANDOM')
                ->join('users', 'users.id = posts.user_id')
                ->where('users.status', 'Active')
                ->where('posts.expiry_date >=', date('Y-m-d'))
                ->where('posts.activation_date <=', date('Y-m-d'))
                ->get_where('posts', ['posts.vehicle_type_id' => 4, 'posts.status' => 'Active', 'posts.id <>' => $post_id], 10, 0)
                ->result();

        } else if ($current_type->post_type == 'Automech') {

            $related_posts = $this->db
                ->select('posts.*')
                ->order_by('posts.id', 'RANDOM')
                ->join('users', 'users.id = posts.user_id')
                ->where('users.status', 'Active')
                ->where('posts.expiry_date >=', date('Y-m-d'))
                ->where('posts.activation_date <=', date('Y-m-d'))
                ->get_where('posts', ['posts.post_type' => 'Automech', 'posts.status' => 'Active', 'posts.id <>' => $post_id], 10, 0)
                ->result();

        } else {
            $related_posts = $this->db
                ->select('posts.*, IF(c.id IS NOT NULL, 1, 0) as is_financing, um.meta_value as is_verified')
                ->order_by('posts.id', 'RANDOM')
                ->join('users', 'users.id = posts.user_id')
                ->join('user_meta as um', 'users.id = um.user_id and um.meta_key = "seller_tag"', 'left')
                ->join(
                    'car_list as c',
                    "c.vehicle_type = posts.vehicle_type_id AND
                    (FIND_IN_SET(posts.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
                    (FIND_IN_SET(posts.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= posts.manufacture_year AND
              c.to_year >= posts.manufacture_year AND
              (FIND_IN_SET(posts.condition,c.car_condition) OR FIND_IN_SET('All',c.car_condition)) AND
              (FIND_IN_SET(posts.location_id,c.location_id) OR FIND_IN_SET('41',c.location_id)) AND
              (c.min_price <= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.max_price = 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan' AND
              (c.seller_id = '' OR c.seller_id IS NULL OR FIND_IN_SET(posts.user_id, c.seller_id) <> 0 OR FIND_IN_SET('0', c.seller_id) <> 0)
              ",
                    'LEFT'
                )
                ->where('users.status', 'Active')
                ->where('posts.expiry_date >=', date('Y-m-d'))
                ->where('posts.activation_date <=', date('Y-m-d'))
                ->group_by('posts.id')
                ->get_where('posts', ['posts.model_id' => $model_id, 'posts.post_type' => 'General', 'posts.status' => 'Active', 'posts.id <>' => $post_id], 10, 0)
                ->result();
        }


        $html = '';
        if ($related_posts) {
            $html .= '<div class="similar_cars-area pb-45">';
            $html .= '<div class="container">';
            $html .= '<div class="row">';
            $html .= '<div class="col-12">';
            $html .= '<h2 class="section-title-two">';
            if ($current_type->vehicle_type_id == 4) {
                $html .= '<span>Similar </span> Spare Parts ';
            } else if ($current_type->post_type == 'Automech') {
                $html .= '<span>Similar </span> Automech';
            } else {
                $html .= '<span>Similar </span> Car';
            }
            $html .= '</h2> </div>';
            $count =  count($related_posts);
            $extra_class = '';
            if ($count > 4){
                $html .= '<div class="col-12"><div class="row related_post_slider">';
            } else {
                $extra_class = 'col-lg-4 col-md-6 col-xl-3 col-12';
            }

            foreach ($related_posts as $post) {
                $html .= "<div class=\"col-12 $extra_class\">
                            <div class=\"carPost-wrap\">
                                <a class=\"carPost-img\" href=\"post/$post->post_slug\">
                                    ". GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, 'grayscale lazyload post-img',getShortContentAltTag(($post->title), 60));
                    if ($post->is_financing){
                        $html .=  "";
                    }

                $html .= "</a>
                                <div class=\"carPost-content\">
                                    <span class=\"level\">$post->condition</span>
                                    <h4><a href=\"post/$post->post_slug\">". getShortContent($post->title, 20) ."</a>" .
                    ($post->is_verified == 'Verified seller' ? "<img src=\"assets/new-theme/images/icons/verify-new.svg\" title=\"Verified\" alt=\"\">" : "")
                    . "</h4>
                                    <ul class=\"post-price\">
                                        <li class=\"price\">". GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) ."</li>
                                        <li class=\"km\">".number_shorten($post->mileage)." Miles</li>
                                    </ul>
                                    <span class=\"location\">$post->location</span>
                                </div>
                            </div>
                        </div>";
            }
            if ($count > 4){
                $html .= '</div></div>';
            }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        return $html;
    }

    /*
     * related post by vichle_type_id
     * int type_id
     */
    public function getFromThisSeller($user_id = 0)
    {

        $expiry_date = date('Y-m-d');
        $more_posts = $this->db
            ->order_by('id', 'RANDOM')
            ->get_where('posts', ['user_id' => $user_id, 'expiry_date >=' => $expiry_date, 'status' => 'Active'], 5, 0)
            ->result();

        $html = '';

        foreach ($more_posts as $post) {
            $html .= '<a class="car-dealer-item" href="post/' . $post->post_slug . '">';
            $html .= '<div class="car-dealer-img">';
            $html .= GlobalHelper::getPostFeaturedPhoto($post->id, 'tiny',null,null,getShortContentAltTag($post->title, 60));
            $html .= '</div>';
            $html .= '<div class="car-dealer-content">';
            $html .= '<h5>' . getShortContent($post->title, 40) . '</h5>';
            $html .= '<span>' . GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) . '</span>';
            $html .= '</div>';
            $html .= '</a>';
        }

        return $html;
    }


    public function getFromTradeSeller($user_id = 0)
    {

        $total_row = $this->db
            ->from('posts')
            ->where('user_id', $user_id)
            ->where('status', 'Active')
            ->where('expiry_date >=', date('Y-m-d'))
            ->get()
            ->num_rows();

        $html = '';
        $page = intval($this->input->get('start'));
        $limit = 6;
        $posts = $this->db
            ->from('posts')
            ->limit($limit, $page)
            ->where('user_id', $user_id)
            ->where('status', 'Active')
            ->where('expiry_date >=', date('Y-m-d'))
            ->order_by('is_featured', 'DESC')
            ->order_by('id', 'DESC')
            ->get()
            ->result();

        foreach ($posts as $post) {
            $html .= $this->_per_post_seller_page($post);
        }

        if (empty($total_row)) {
            $html .= '<p class="ajax_notice">No Record Found</p>';
        } else {
            $Purl = "";

            if ($this->uri->segment(2)) {
                $Purl = $this->uri->segment(1)."/".$this->uri->segment(2);
            } else {
                $Purl = $this->uri->segment(1);
            }
            $config['base_url'] = base_url($Purl);
            $config['first_url'] = base_url($Purl);
            $config['per_page'] = $limit;
            $config['page_query_string'] = TRUE;

            $config['total_rows'] = $total_row;

            $config['query_string_segment'] = 'start';

            $config['num_links'] = 1;

            $config['full_tag_open'] = '<div class="col-12 text-center"><ul class="pagination-wrap float-none">';
            $config['full_tag_close'] = '</ul></div>';

            $config['first_link'] = false;
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';

            $config['last_link'] = false;
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';

            $config['next_link'] = '<i class="fa fa-angle-right"></i>';
            $config['next_tag_open'] = '<li class="prev">';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
            $config['prev_tag_open'] = '<li class="next">';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li><a class="active">';
            $config['cur_tag_close'] = '</a></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';

            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $pagination = $this->pagination->create_links();
            $html .= $pagination;
        }

        return $html;
    }

    private function _per_post_seller_page($post = [])
    {
        $html = '';

        $html .= '<ul class="seller-product-wrap">
                       <li class="seller-product-item">
                            <div class="seller-product-img"><a href="post/' . $post->post_slug . '">';
        $html .= GlobalHelper::getPostFeaturedPhoto($post->id, 'medium', null, 'grayscale lazyload',getShortContentAltTag($post->title, 60)) . '</a></div>
                                    <div class="seller-product-content"> 
                                    <h4><a href="post/' . $post->post_slug . '">'.$post->title.'</a></h4>
                                    <h3>' . GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) . '</h3>
                                    </div>
                                </li>
                            </ul>';
        return $html;
    }

    public function getSellerDetails($user_id)
    {

        $seller = $this->db->get_where('users', ['id' => $user_id])->row_array();
        $metas = $this->db->select('meta_key,meta_value')->get_where('user_meta', ['user_id' => $user_id])->result();
        foreach ($metas as $meta) {
            $seller[$meta->meta_key] = $meta->meta_value;
        }

        $html = '';
        $html .= '<h4>' . $this->issetKey('companyName', $seller) . '</h4>';
        //$html .= '<h4>Location</h4>';
        $html .= '<p><i class="fa fa-map-marker"></i> ' . $this->issetKey('serllerLocation', $seller) . '</p>';
        //$html .= '<h4>Contact Number</h4>';
        $html .= '<p><i class="fa fa-phone-square"></i> ' . $this->issetKey('serllerLocation', $seller) . '</p>';

        return $html;
    }

    private function issetKey($key = '', $seller = array())
    {
        return isset($seller[$key]) ? $seller[$key] : $key;
    }


    public function getSlider($post_id = 0, $size = 875, $alt = null)
    {
        $photos = $this->db
            ->where_in('size',[$size, 0])
            ->get_where('post_photos', ['post_id' => $post_id], 10, 0)
            ->result();

        $first_part = '';
        $second_part = '';

            foreach ($photos as $row) {
                $first_part .= "<a class='post-preview-image popup-img' href='".GlobalHelper::photo($row->photo, 'medium', 'img-responsive')."'>".GlobalHelper::getPostPhoto($row->photo, 'medium', 'img-responsive lazyload',$alt)."</a>";
                $second_part .= "<div class='post-preview-thumb-img''>".GlobalHelper::getPostPhoto($row->photo, 'medium', 'img-responsive lazyload',$alt)."</div>";

                if ($row->left_photo != null && $row->left_photo != "") {
                    $first_part .= "<a class='post-preview-image popup-img' href='".GlobalHelper::photo($row->left_photo, 'medium', 'img-responsive')."'>".GlobalHelper::getPostPhoto($row->left_photo, 'medium', 'img-responsive lazyload',$alt)."</a>";
                    $second_part .= "<div class='post-preview-thumb-img''>".GlobalHelper::getPostPhoto($row->left_photo, 'medium', 'img-responsive lazyload',$alt)."</div>";
                }

                if ($row->right_photo != null && $row->right_photo != "") {
                    $first_part .= "<a class='post-preview-image popup-img' href='".GlobalHelper::photo($row->right_photo, 'medium', 'img-responsive')."'>".GlobalHelper::getPostPhoto($row->right_photo, 'medium', 'img-responsive lazyload',$alt)."</a>";
                    $second_part .= "<div class='post-preview-thumb-img''>".GlobalHelper::getPostPhoto($row->right_photo, 'medium', 'img-responsive lazyload',$alt)."</div>";
                }

                if ($row->back_photo != null && $row->back_photo != "") {

                    $first_part .= "<a class='post-preview-image popup-img' href='".GlobalHelper::photo($row->back_photo, 'medium', 'img-responsive')."'>".GlobalHelper::getPostPhoto($row->back_photo, 'medium', 'img-responsive lazyload',$alt)."</a>";
                    $second_part .= "<div class='post-preview-thumb-img''>".GlobalHelper::getPostPhoto($row->back_photo, 'medium', 'img-responsive lazyload',$alt)."</div>";
                }
            }


        return "<div class='post-preview-slider-active'>$first_part</div><div class='post-preview-thumb-slider'>$second_part</div>";
    }


    public function get_post_by_user($user_id = null)
    {
        return $user_posts = $this->db->get_where('posts', ['user_id' => $user_id], 5, 0)->result();
    }


    public function report_spam()
    {

        $prams = [
            'post_id' => intval($this->input->get('post_id')),
            'your_email' => getLoginUserData('user_mail')
        ];
        $this->load->view('report_spam', $prams);
    }

    public function getQuote()
    {

        $user_id = getLoginUserData('user_id');
        $user_mail = getLoginUserData('user_mail');
        $post_id = intval($this->input->get('post_id'));
        $post = $this->db->where('id', $post_id)->get('posts')->row();
        $price = GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein);
        $prams = [
            'post_id' => $post_id,
            'seller_id' => intval($this->input->get('seller_id')),
            'post_slug' => $this->input->get('slug'),
            'price' => $price,
            'offer_currency' => ($post->pricein == 'NGR') ? '₦ ' : '$ '
        ];

        if ($user_id) {
            if (!empty($user_mail)){
                $this->load->view('make_an_offer', $prams);
            } else {
                $this->load->view('empty_email_message');
            }

        } else {
            $this->load->view('login_message');
        }

    }

    public function getCompare()
    {
        $temp = getCmsPage('vehicle-compare');

        $data = [];
        $vehicle_type = $this->input->get('vehicle');
        $vehicle_id = GlobalHelper::getVehicleIdbySlug($vehicle_type);
        if (empty($vehicle_id)){
            $this->viewFrontContentNew('frontend/404');
            return false;
        }

        $first_section = [];
        $second_section = [];
        $third_section = [];

        $first = $this->input->get('first');
        $second = $this->input->get('second');
        $third = $this->input->get('third');

        if (!empty($first)){
            $first_section = $this->_getComparePost($first);
            if (!empty($first_section)){
                $temp['meta_title'] .= ' '.$first_section->title;
            }
        }

        if (!empty($second)){
            $second_section = $this->_getComparePost($second);
            if (!empty($second_section)){
                $temp['meta_title'] .= ' vs '.$second_section->title;
            }
        }

        if (!empty($third)){
            $third_section = $this->_getComparePost($third);
            if (!empty($third_section)){
                $temp['meta_title'] .= ' vs '.$third_section->title;
            }
        }

        $data = array(
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
            'first_section' => $first_section,
            'second_section' => $second_section,
            'third_section' => $third_section,
            'vehicle_id' => $vehicle_id,
            'vehicle_slug' => $vehicle_type
        );
        $this->viewFrontContentNew('frontend/new/template/car_compare', $data);
    }

    public function _getComparePost($post_slug){
        $result = $this->db->select('p.*, cr.slug as car_review_slug, cr.total_rating as car_review_rating')
            ->from('posts as p')
            ->join('car_review as cr', 'cr.vehicle_type = p.vehicle_type_id AND cr.brand_id = p.brand_id AND cr.model_id = p.model_id', 'LEFT')
            ->where('p.post_slug', $post_slug)
            ->where('p.activation_date IS NOT NULL')
            ->where('p.expiry_date >=', date('Y-m-d'))->get()->row();

        if (!empty($result)) return $result;
        return [];

    }

    public function getTitles() {
        $vehicle_type_id = $this->input->post('vehicle_type_id');
        $brandId = $this->input->post('brand_id');
        $modelId = $this->input->post('model_id');
        $year = $this->input->post('year');
        $type = $this->input->post('type');
        $gets = $this->input->post('gets');
        $befor_params = json_decode($gets, true);
        $html = '';

        $conditions = ['status' => 'Active'];
        $conditions = ($vehicle_type_id) ? array_merge($conditions, ['vehicle_type_id' => $vehicle_type_id]) : $conditions;
        $conditions = ($brandId) ? array_merge($conditions, ['brand_id' => $brandId]) : $conditions;
        $conditions = ($modelId) ? array_merge($conditions, ['model_id' => $modelId]) : $conditions;
        $conditions = ($year) ? array_merge($conditions, ['manufacture_year' => $year]) : $conditions;

        $to_car = $this->db->select('title, post_slug, priceinnaira, priceindollar, pricein, id')
            ->from('posts')
            ->where($conditions)
            ->where('posts.activation_date IS NOT NULL')
            ->where('posts.expiry_date >=', date('Y-m-d'))
            ->order_by('created', 'DESC')
            ->get()->result();

        if (isset($to_car[0])) {
            foreach ($to_car  as $k => $post){
                $befor_params[$type] = $post->post_slug;
                $new_url = 'post/compare?'.http_build_query($befor_params);
                $price = GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein);
                $img = GlobalHelper::getPostThumbPhotoById($post->id,$post->title,'');
                $html .= "<li>$img<div class=\"content\">
                <h5 class=\"fs-18 fw-500 mb-5\">$post->title</h5>
                <h6 class=\"fs-16 fw-500 color-theme mb-5\">$price</h6>
                <a href='$new_url' class=\"btnStyle\" type=\"button\">compare</a>
            </div>
        </li>";
            }
        } else {
            $html = '<p class="text-center">No car is available according to your requirement.</p>';
        }




        echo returnJSON(['status' => 'success', 'data' => $html]);
    }

    // for parts
    public function spare_parts()
    {
        $temp = getCmsPage('parts');

        $data = array(
            'cms' => $temp['cms'],
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
        );

        $this->viewFrontContent('frontend/template/spare_parts', $data);
    }

    // Buy Motorbike
    public function buy_motorbike(){
        $temp = getCmsPage('buy-motorbike');

        $data = array(
            'cms' => $temp['cms'],
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
        );

        $this->viewFrontContent('frontend/template/motorbike', $data);
    }

    public function spare_parts_search()
    {
        $data = [];
//                $user_id = getLoginUserData('user_id');
//                if( $post->status != 'Active' && empty($user_id) ){
//                    $this->load->view('frontend/404', $data);
//                } else {
        //dd( $data );
        $this->viewFrontContent('frontend/template/spare_parts_search', $data);
        // }
    }

    // for Automech
    public function automech()
    {
        $temp = getCmsPage('automech');

        $data = array(
            'cms' => $temp['cms'],
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
        );

        $this->viewFrontContent('frontend/template/automech', $data);
    }

    public function automech_search()
    {
        $data = [];
        $this->viewFrontContent('frontend/template/automech_search', $data);

    }

    // for Towing


    public function towing()
    {
        $temp = getCmsPage('towing');

        $data = array(
            'cms' => $temp['cms'],
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
        );
        $this->viewFrontContent('frontend/template/towing', $data);
    }

    public function towing_search()
    {
        $data = [];
        $this->viewFrontContent('frontend/template/towing_search', $data);

    }


    // get all post  for  API


    public function getSliderApi($post_id = 0)
    {
        $CI =& get_instance();
        $CI->load->config('config');
        $photo_url = $CI->config->item('base_url' . 'uploads/car/');
        $photos = $this->db->where('post_id', $post_id)
            ->where('size', 875)
            ->get('post_photos')
            ->result();

        $new_photos = array();
        foreach ($photos as $photo) {
            $new_photos[280][] = $photo_url . $photo->photo;
        }
        return $new_photos;
    }

    // related spare
    private function api_related_post($type_id = 0, $model_id = 0, $post_id = 0)
    {

        $base_url = base_url('uploads/car/');
        $site_url = base_url('/post/');
        $photo = "SELECT CONCAT('{$base_url}', photo) FROM `post_photos` WHERE `size` = 875 AND `post_id` = `posts`.`id` LIMIT 1";

        $this->db->limit(4, 0)
            ->join('vehicle_types as vt', 'vt.id=posts.vehicle_type_id', 'LEFT')
            ->select('posts.id,title,pricein,priceindollar,priceinnaira,location as address')
            ->select('vt.name as type')
            ->select("({$photo}) as photo")
            ->select("CONCAT('{$site_url}', post_slug) as post_url")
            ->order_by('posts.id', 'RANDOM')
            ->where(['status' => 'Active', 'posts.id !=' => $post_id, 'expiry_date >=' => date('Y-m-d')]);

        if ($type_id == 4) {
            $this->db->where('vehicle_type_id', 4);
        } else {
            $this->db->where(['model_id' => $model_id, 'post_type' => 'General']);
        }
        $posts = $this->db->get('posts')->result();


        $data = [];
        foreach ($posts as $post) {
            $data[] = [
                'id' => $post->id,
                'title' => $post->title,
                'address' => $post->address,
                'type' => $post->type,
                'price' => apiCurrency($post->pricein, $post->priceindollar, $post->priceinnaira),
                'photos' => $post->photo,
                'post_url' => $post->post_url,
            ];
        }
        return $data;
    }


    private function getSellerType($user_id = 0)
    {
        $role = $this->db->query("SELECT role_id,profile_photo FROM `users` WHERE id = '{$user_id}'")->row();
        if (!$role) {
            return NULL;
        }
        if ($role->role_id == 4) {
            return [
                'seller_id' => $user_id,
                'logo' => $this->api_get_logo($role->profile_photo),
            ];
        }
    }


    public function sidebar_text()
    {
        $html = '<div class="panel panel-default">';
        $html .= '<div class="panel-body general-txt">';
        $html .= '<p><a href="mechanic"><i class="fa fa-sign-in"></i> Contact Online Mechanics to Resolve your care issues</a></p>';
        $html .= '<p><a href="towing"><i class="fa fa-sign-in"></i> Looking to Join Our car Association to reduce hassle of problem when your car breakdown</a></p>';
        $html .= '<p><a href="driver-hire"><i class="fa fa-sign-in"></i> Looking to Hire a certified, policed checked and background checked drivers</a></p>';
        $html .= '<p><a href="mechanic"><i class="fa fa-sign-in"></i> Mobile Mechanics and Mobile tyre fixers</a></p>';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    public function towing_type_of_services()
    {

        $cat_id = (isset($_GET['cat_id'])) ? $_GET['cat_id'] : 0;
        $selected = (isset($_GET['selected'])) ? $_GET['selected'] : 0;

        $services = $this->db->where('parent_id', $cat_id)->get('towing_categories')->result();
        if ($cat_id != 0) {
            $options = '<option value="0"> -- Select Service -- </option>';
            foreach ($services as $service) {
                $options .= '<option value="' . $service->id . '" ';
                $options .= ($service->id == $selected) ? 'selected="selected"' : '';
                $options .= '>' . $service->name . '</option>';
            }
        } else {
            $options = '<option value="0">Select Category First</option>';
        }
        echo $options;
    }

    public function towing_type_of_services_for_service()
    {

        $cat_id = (isset($_GET['cat_id'])) ? explode(",", $_GET['cat_id']) : ['-1'];
        $cat_id = !empty($cat_id[0]) ? $cat_id : ['-1'];
        $selected = (isset($_GET['selected'])) ? explode(",", $_GET['selected']) : ['-1'];



        $services = $this->db->where_in('parent_id', $cat_id)->get('towing_categories')->result();
        if ($cat_id != 0) {
            $options = '<option value="0"> -- Select Service -- </option>';
            foreach ($services as $service) {
                $options .= '<option value="' . $service->id . '" ';
                $options .= ($service->id == $selected) ? 'selected="selected"' : '';
                $options .= '>' . $service->name . '</option>';
            }
        } else {
            $options = '<option value="0">Select Category First</option>';
        }
        echo $options;
    }


    // related spare
    public function getRelatedSearch($model_id = 0, $post_id = 0)
    {

        $related_posts = $this->db->select('posts.*,IF(c.id IS NOT NULL, 1, 0) as is_financing,c.id as car_id, um.meta_value as is_verified')
             ->from('posts')
            ->join(
                'car_list as c',
                "c.vehicle_type = posts.vehicle_type_id AND
              (FIND_IN_SET(posts.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
              (FIND_IN_SET(posts.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= posts.manufacture_year AND
              c.to_year >= posts.manufacture_year AND
              (FIND_IN_SET(posts.condition,c.car_condition) OR FIND_IN_SET('All',c.car_condition)) AND
              (FIND_IN_SET(posts.location_id,c.location_id) OR FIND_IN_SET('41',c.location_id)) AND
              (c.min_price <= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.max_price = 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan' AND
              (c.seller_id = '' OR c.seller_id IS NULL OR FIND_IN_SET(posts.user_id, c.seller_id) <> 0 OR FIND_IN_SET('0', c.seller_id) <> 0)
              ",
                'LEFT'
            )
            ->join('users', 'users.id = posts.user_id')
            ->join('user_meta as um', 'users.id = um.user_id and um.meta_key = "seller_tag"', 'left')
            ->where('users.status', 'Active')
            ->where('posts.expiry_date >=', date('Y-m-d'))
            ->where('posts.activation_date <=', date('Y-m-d'))
//            ->where('posts.vehicle_type_id', 4)
            ->where('posts.status', 'Active')
            ->where('posts.id <>', $post_id)
             ->limit(10)
             ->offset(0)
            ->group_by('posts.id')->order_by('posts.id', 'RANDOM')->get()->result();
        $count =  count($related_posts);
        $html = '';
        if ($related_posts) {
            $html .= '<div class="similar_cars-area pb-45">';
            $html .= '<div class="container">';
            $html .= '<div class="row">';
            $html .= '<div class="col-12">';
            $html .= '<h2 class="section-title-two">Others search for these items</h2>';
            $html .= '</div>';
            $extra_class = '';
            if ($count > 4){
                $html .= '<div class="col-12"><div class="row related_post_slider">';
            } else {
                $extra_class = 'col-lg-4 col-md-6 col-xl-3 col-12';
            }
            foreach ($related_posts as $post) {
                $html .= "<div class=\"col-12 $extra_class\">
                            <div class=\"carPost-wrap\">
                                <a class=\"carPost-img\" href=\"post/$post->post_slug\">
                                    ". GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, 'grayscale lazyload post-img',getShortContentAltTag(($post->title), 60));
                if ($post->is_financing){
                    $html .=  "";
                }

                $html .= "</a>
                                <div class=\"carPost-content\">
                                    <span class=\"level\">$post->condition</span>
                                    <h4><a href=\"post/$post->post_slug\">". getShortContent(($post->title), 20) ."</a>" .
                    ($post->is_verified == 'Verified seller' ? "<img src=\"assets/new-theme/images/icons/verify-new.svg\" title=\"Verified\" alt=\"\">" : "")
                    . "</h4>
                                    <ul class=\"post-price\">
                                        <li class=\"price\">". GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) ."</li>
                                        <li class=\"km\">".number_shorten($post->mileage)." Miles</li>
                                    </ul>
                                    <span class=\"location\">$post->location</span>
                                </div>
                            </div>
                        </div>";
            }
            if ($count > 4){
                $html .= '</div></div>';
            }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        return $html;
    }

    public function getSamePriceRangeCar( $priceField, $priceAmount, $post_id = 0)
    {

        $current_type = $this->db->select('vehicle_type_id, post_type')->where('id', $post_id)->get('posts')->row();

        if ($current_type->vehicle_type_id == 4) {

            $related_posts = $this->db
                ->select('posts.*')
                ->order_by('posts.id', 'RANDOM')
                ->join('users', 'users.id = posts.user_id')
                ->where('users.status', 'Active')
                ->where('posts.expiry_date >=', date('Y-m-d'))
                ->where('posts.activation_date <=', date('Y-m-d'))
                ->get_where('posts', ['posts.vehicle_type_id' => 4, 'posts.'.$priceField => $priceAmount, 'posts.status' => 'Active', 'posts.id <>' => $post_id], 10, 0)
                ->result();

        } else if ($current_type->post_type == 'Automech') {

            $related_posts = $this->db
                ->select('posts.*')
                ->order_by('posts.id', 'RANDOM')
                ->join('users', 'users.id = posts.user_id')
                ->where('users.status', 'Active')
                ->where('posts.expiry_date >=', date('Y-m-d'))
                ->where('posts.activation_date <=', date('Y-m-d'))
                ->get_where('posts', ['posts.post_type' => 'Automech', 'posts.'.$priceField => $priceAmount, 'posts.status' => 'Active', 'posts.id <>' => $post_id], 10, 0)
                ->result();

        } else {
            $related_posts = $this->db
                ->select('posts.*, IF(c.id IS NOT NULL, 1, 0) as is_financing, um.meta_value as is_verified')
                ->order_by('posts.id', 'RANDOM')
                ->join('users', 'users.id = posts.user_id')
                ->join('user_meta as um', 'users.id = um.user_id and um.meta_key = "seller_tag"', 'left')
                ->join(
                    'car_list as c',
                    "c.vehicle_type = posts.vehicle_type_id AND
                    (FIND_IN_SET(posts.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
                    (FIND_IN_SET(posts.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= posts.manufacture_year AND
              c.to_year >= posts.manufacture_year AND
              (FIND_IN_SET(posts.condition,c.car_condition) OR FIND_IN_SET('All',c.car_condition)) AND
              (FIND_IN_SET(posts.location_id,c.location_id) OR FIND_IN_SET('41',c.location_id)) AND
              (c.min_price <= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.max_price = 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan' AND
              (c.seller_id = '' OR c.seller_id IS NULL OR FIND_IN_SET(posts.user_id, c.seller_id) <> 0 OR FIND_IN_SET('0', c.seller_id) <> 0)
              ",
                    'LEFT'
                )
                ->where('users.status', 'Active')
                ->where('posts.expiry_date >=', date('Y-m-d'))
                ->where('posts.activation_date <=', date('Y-m-d'))
                ->group_by('posts.id')
                ->get_where('posts', ['posts.'.$priceField => $priceAmount, 'posts.post_type' => 'General', 'posts.status' => 'Active', 'posts.id <>' => $post_id], 10, 0)
                ->result();
        }
        $html = '';
        if ($related_posts) {
            $html .= '<div class="similar_cars-area pb-45">';
            $html .= '<div class="container">';
            $html .= '<div class="row">';
            $html .= '<div class="col-12">';
            $html .= '<h2 class="section-title-two">Cars in the same Price Range</h2>';
            $html .= '</div>';
            $extra_class = '';
            $count =  count($related_posts);
            if ($count > 4){
                $html .= '<div class="col-12"><div class="row related_post_slider">';
            } else {
                $extra_class = 'col-lg-4 col-md-6 col-xl-3 col-12';
            }

            foreach ($related_posts as $post) {
                $html .= "<div class=\"col-12 $extra_class\">
                            <div class=\"carPost-wrap\">
                                <a class=\"carPost-img\" href=\"post/$post->post_slug\">
                                    ". GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, 'grayscale lazyload post-img',getShortContentAltTag(($post->title), 60));
                if ($post->is_financing){
                    $html .=  "";
                }

                $html .= "</a>
                                <div class=\"carPost-content\">
                                    <span class=\"level\">$post->condition</span>
                                    <h4><a href=\"post/$post->post_slug\">". getShortContent(($post->title), 20) ."</a>" .
                    ($post->is_verified == 'Verified seller' ? "<img src=\"assets/new-theme/images/icons/verify-new.svg\" title=\"Verified\" alt=\"\">" : "")
                    . "</h4>
                                    <ul class=\"post-price\">
                                        <li class=\"price\">". GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) ."</li>
                                        <li class=\"km\">".number_shorten($post->mileage)." Miles</li>
                                    </ul>
                                    <span class=\"location\">$post->location</span>
                                </div>
                            </div>
                        </div>";
            }
            if ($count > 4){
                $html .= '</div></div>';
            }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        return $html;
    }


    // Api  Helper  function
    public function first_page()
    {

        $post_id = $this->input->get('id');
        $postData = $this->db->select('location, location_id, lat, lng, package_id, advert_type, condition,vehicle_type_id')->where('id', $post_id)->get('posts')->row();

        $post_data = ($post_id) ? $postData : null;

        $post_areas = $this->db->select('id, name')->get('post_area')->result();
        $types = $this->db->where_not_in('id', [7])->get('vehicle_types')->result();
        $packages = $this->db->order_by('id', 'ASC')->get('packages')->result();
//        $conditions = array(
//            '0'             => 'Any Condition',
//            'New'           => 'New',
//            'Nigerian used' => 'Nigerian Used',
//            'Foreign used'  => 'Foreign Used'
//        );
        $conditions = [
//            [
//               "id" => "0",
//                "name" => "Select Condition",
//                "slug" => "Select Condition"
//            ],
            [
                "id" => "New",
                "name" => "New",
                "slug" => "New"
            ], [
                "id" => "Nigerian used",
                "name" => "Nigerian used",
                "slug" => "Nigerian used"
            ], [
                "id" => "Foreign used",
                "name" => "Foreign used",
                "slug" => "Foreign used"
            ]
        ];


        $listing_type = [
            '0' => 'Please Select',
            'Business' => 'Trade Seller',
            'Personal' => 'Private Seller',
        ];


        $api_data = [
            'post_data' => $post_data,
            'post_areas' => $post_areas,
            'vehicle_types' => $types,
            'condition' => $conditions,
            'listing_type' => $listing_type,
            'package_id' => $packages,
        ];
        json_output(200, $api_data);
    }

    public function second_page()
    {
        $post_id = $this->input->get('id');

        // if(mileage >= 1, mileage, null ) as millage

        $this->db->select('title, post_slug, pricein as currency');
        $this->db->select('priceindollar, priceinnaira');
        $this->db->select('parts_description, manufacture_year,description,registration_no');

        $this->db->select('if(vehicle_type_id >= 1, vehicle_type_id, null ) as vehicle_type_id');
        $this->db->select('if(category_id >= 1, category_id, null ) as category_id');
        $this->db->select('if(parts_for >= 1, parts_for, null ) as parts_for');
        $this->db->select('if(fuel_id >= 1, fuel_id, null ) as fuel_id');
        $this->db->select('if(mileage >= 1, mileage, null ) as mileage');
        $this->db->select('if(seats >= 1, seats, null ) as seats');
        $this->db->select('if(body_type >= 1, body_type, null ) as body_type');
        $this->db->select('if(color >= 1, color, null ) as color');
        $this->db->select('if(brand_id >= 1, brand_id, null ) as brand_id');
        $this->db->select('if(model_id >= 1, model_id, null ) as model_id');
        $this->db->select('if(owners >= 1, owners, null ) as owners');

        $this->db->select('gear_box_type, feature_ids');
        $postData = $this->db->where('id', $post_id)->get('posts')->row();


        $post_data = ($post_id) ? $postData : null;

        $features = $this->db->get('special_features')->result();
        $parts = $this->db->get_where('parts_categories')->result();
        $parts_desc = $this->db->select('id,name')->get_where('parts_description')->result();

        $repair_types = $this->db->get('repair_types')->result();
        $specialisms = $this->db->get('specialism')->result();
        $towing_services = $this->db->where('parent_id', 0)->get('towing_categories')->result();
        $fuel_types = $this->db->from('fuel_types')->get()->result();
        $engine_sizes = $this->db->from('engine_sizes')->get()->result();
        $body_types = $this->db->from('body_types')->get()->result();
        $color = $this->db->from('color')->get()->result();
        $seats = [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',
            '11' => 'More that 10',
        ];
        $price = [
            'NGR' => 'Currency:  ₦ NGN (Recommended)',
            'USD' => 'Currency:  $ USD (Optional)',
        ];
        $services = [
            'Delivery' => 'Delivery',
            'Pickup' => 'Pickup'
        ];
        $automech_vehicle_types = [
            '7' => 'Car',
            '6' => 'Van',
            '1' => 'Trucks',
            '1' => 'HEAVY /Earth Moving Vehicles',
        ];
        $ages = [
            '0' => '0 years old',
            '1' => '1 years old',
            '2' => '2 years old',
            '3' => '3 years old',
            '4' => '4 years old',
            '5' => '5 years old',
            '6' => '6 years old',
            '7' => '7 years old',
            '8' => '8 years old',
            '9' => '9 years old',
            '10' => '10 years old',
            '11' => 'More than 10 years old',
        ];
        $service_history = [
            '1' => 'First service is not due',
            '2' => 'Full service history',
            '3' => 'Part service history',
            '4' => 'No service history',
        ];
        $availability = [
            '24 hrs' => '24 hrs',
            '9am-5PM' => '9am-5PM',
            '6am-10PM' => '6am-10PM'
        ];
        $gears = [
            'Automatic' => 'Automatic',
            'Sami Automatic' => 'Semi Automatic',
            'Manual' => 'Manual'
        ];
        $owners = [
            '1' => '1st',
            '2' => '2nd',
            '3' => '3rd',
            '4' => '4th',
            '5' => '5th',
            '6' => '6th',
            '7' => '7th',
        ];
        $wheels = [
            '1' => '13" Alloy Wheels',
            '2' => '14" Alloy Wheels',
            '3' => '15" Alloy Wheels',
            '4' => '16" Alloy Wheels',
            '5' => '17" Alloy Wheels',
            '6' => '18" Alloy Wheels',
            '7' => '19" Alloy Wheels',
        ];
        $api_data = [
            'post_data' => $post_data,
            'pricein' => $price,
            'car_age' => $ages,
            'feature_ids' => $features,
            'category_id' => $parts,
            'parts_desc' => $parts_desc,
            'repair_type_id' => $repair_types,
            'parts_for' => $repair_types,
            'specialism_id' => $specialisms,
            'service_type' => $services,
            'manufacture_year' => numericDropDownApi2(date('Y'), 1950, 1, 0),
            'towing_service_id' => $towing_services,
            'vehicle_type' => $automech_vehicle_types,
            'availability' => $availability,
            'fuel_id' => $fuel_types,
            'enginesize_id' => $engine_sizes,
            'seats' => $seats,
            'gear_box_type' => $gears,
            'body_type' => $body_types,
            'color' => $color,
            'regiday' => numericDropDownApi(1, 31, 1, 0),
            'regimonth' => numericDropDownApi(1, 12, 1, 0),
            'regiyear' => numericDropDownApi2(date('Y'), 1950, 1, 0),
            'service_history' => $service_history,
            'alloywheels' => $wheels,
            'owners' => $owners,
        ];
        $api_data['post_data']->feature_ids = empty($post_data->feature_ids) ? NULL : explode(',', $post_data->feature_ids);

        json_output(200, $api_data);
    }

    public function get_brand_ids($vechile_id = 0)
    {
        $api_data = [
            'brand_id' => Modules::run('brands/brands_frontview/all_brands_by_vehicle_api', $vechile_id),
        ];
        json_output(200, $api_data);
    }

    public function get_model_ids($brand_id = 0)
    {
        $api_data = [
            'model_id' => Modules::run('brands/brands_frontview/brands_by_vehicle_model_api', $brand_id),
        ];
        json_output(200, $api_data);
    }

    public function get_towing_service_ids($cat_id = 0)
    {
        $services = $this->db->where('parent_id', $cat_id)->get('towing_categories')->result();

        $api_data = [
            'services' => $services
        ];
        json_output(200, $api_data);
    }

    public function fiter_api()
    {

        $categories = $this->db->select('id,name')->get('vehicle_types')->result();
        $post_area = $this->db->select('id,name')->order_by('name', 'ASC')->get('post_area')->result();
        $transmission = [
            'Automatic' => 'Automatic',
            'Sami Automatic' => 'Semi Automatic',
            'Manual' => 'Manual'
        ];
        $color = $this->db->select('id,color_name')->get('color')->result();
        $fuel = $this->db->get('fuel_types')->result();
        $from_year = getYearRangeApi();
        $to_year = getYearRangeApi();

        // For Spare Parts
        $parts_vehicle_type = $this->db->select('id,name')->where_not_in('id', [4, 5, 6])->get('vehicle_types')->result();
        $parts_categories = $this->db->select('id,category as name')->get_where('parts_categories')->result();;
        // from_year
        // to_year

        $shot_by = [
            'PriceASC' => 'By Relevance',
            'PostDateDESC' => 'By Price',
        ];
        $api_data = [
            'type_id' => $categories,
            'parts_type_id' => $parts_vehicle_type,
            'parts_categories' => $parts_categories,
            'region' => $post_area,
            'shot_by' => $shot_by,
            'color' => $color,
            'from_year' => $from_year,
            'to_year' => $to_year,
            'min_price' => minPrice(),
            'max_price' => minPrice(),
            'transmission' => $transmission,
            'fuel' => $fuel,
            'condition' => GlobalHelper::getConditionsApi(),
        ];
        json_output(200, $api_data);
    }

    public function get_parts_desc()
    {

        $parent_id = (int)$this->input->get('type_id');
        if (!$parent_id) {
            $parent_id = 1;
        }

        $this->db->select('id,name');
        $this->db->where("parent_id LIKE '%#{$parent_id}#%'");
        $descriptions = $this->db->get('parts_description')->result();

        echo json_output(200, $descriptions);
    }


    public function min_max_year()
    {
        $min_year = ($this->input->get('min_year')) ? $this->input->get('min_year') : 0;

        $year = [];
        if ($min_year) {
            for ($i = date('Y'); $i >= $min_year; $i--) {
                $year[sprintf('%02d', $i)] = sprintf('%02d', $i);
            }
        }
        $api_data = [
            'to_year' => $year
        ];
        json_output(200, $api_data);
    }

    public function min_max_price()
    {
        $min_price = ($this->input->get('min_price'))
            ? $this->input->get('min_price')
            : 0;

        $price = [100000, 150000, 250000];
//        if($min_price){
//            for($i=1000000; $i <= $min_price; $i+=100000) {
//                $price[] = $i;
//            }
//        }
        $api_data = [
            'max_price' => $price
        ];
        json_output(200, $api_data);
    }


    // ---------- X ------------

    private function api_get_logo($logo)
    {
        $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $logo;
        if ($logo && file_exists($photofile)) {
            return site_url('/uploads/company_logo/' . $logo);
        } else {
            return site_url('uploads/no-company-logo.jpg');
        }
    }

    private function api_get_banner($logo)
    {
        $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $logo;
        if ($logo && file_exists($photofile)) {
            return site_url('/uploads/company_logo/' . $logo);
        } else {
            return null;
        }
    }


    public function api_seller_info($id = 0)
    {

        $this->db->select('user_id as id,post_title as company,content,thumb as banner');
        $this->db->select('first_name,last_name,profile_photo as logo,email,contact,contact1,contact2');
        $this->db->select('add_line1,add_line2,city,state,postcode,country_id');
        $this->db->from('cms');
        $this->db->join('users', 'cms.user_id=users.id', 'LEFT');
        $this->db->where('cms.user_id', $id);
        $seller = $this->db->get()->row();


        $address = "{$seller->add_line1}";
        if ($seller->add_line2) {
            $address .= ", {$seller->add_line2}";
        }
        if ($seller->city) {
            $address .= ", {$seller->city}";
        }
        if ($seller->state) {
            $address .= ", {$seller->state}";
        }
        if ($seller->postcode) {
            $address .= ", {$seller->postcode}";
        }
        $address .= ', ' . getCountryName($seller->country_id);


        $data = [
            'id' => $seller->id,
            'company' => $seller->company,
            'logo' => $this->api_get_logo($seller->logo),
            'content' => strip_tags($seller->content),
            'banner' => $this->api_get_banner($seller->banner),

            'name' => ucwords("{$seller->first_name} {$seller->last_name}"),
            // 'email'     => $seller->email,
            'contact' => $seller->contact,
            'contact1' => $seller->contact1,
            'contact2' => $seller->contact2,
            'address' => $address
        ];
        $data['meta'] = $this->api_serler_meta_data($id);

        json_output(200, $data);

    }

    private function api_serler_meta_data($user_id = 0)
    {

        $this->db->where('user_id', $user_id);
        $this->db->where_in('meta_key', ['lat', 'lng', 'business_hours']);
        $this->db->select('meta_key,meta_value');
        $metas = $this->db->get('user_meta')->result();
        $data = [];
        foreach ($metas as $meta) {
            if ($meta->meta_key == 'business_hours') {
                $data[$meta->meta_key] = $this->format_business_hrs($meta->meta_value);
            } else {
                $data[$meta->meta_key] = $meta->meta_value;
            }
        }
        return $data;
    }

    private function format_business_hrs($data)
    {

        $json = json_decode($data);
        $new_array = [];
        foreach ($json as $day => $hrs) {
            $new_array[] = array(
                'day' => $day,
                'time' => ($hrs->selected == 'off')
                    ? 'Close'
                    : "{$hrs->open_hh}:{$hrs->open_mm} {$hrs->open_am_pm}"
                    . " - {$hrs->close_hh}:{$hrs->close_mm} {$hrs->close_am_pm}",
            );
        }
        return $new_array;
    }

    public function api_seller_post($user_id = 0)
    {
        $this->benchmark->mark('code_start');

        $this->__search_seller_post($user_id);
        $total = $this->db->count_all_results('posts');

        $limit = 25;
        $page = $this->input->get('page');
        $start = startPointOfPagination($limit, $page);
        $data['total'] = $total;
        $data['next_page_url'] = next_page_url($page, $limit, $total);

        $base_url = base_url('uploads/car/');
        $photo = "SELECT CONCAT('{$base_url}', photo) FROM `post_photos` WHERE `size` = 875 AND `post_id` = `posts`.`id` LIMIT 1";

        $this->db->limit($limit, $start)
            ->join('vehicle_types as vt', 'vt.id=posts.vehicle_type_id', 'LEFT')
            ->select('posts.id,title,location as address')
            ->select('vt.name as type')
            ->select('pricein,priceindollar,priceinnaira')
            ->select("({$photo}) as photo")
            ->order_by('is_featured', 'DESC')
            ->order_by('id', 'DESC');
        $this->__search_seller_post($user_id);
        $posts = $this->db->get('posts')->result(); // FORMAT(priceinnaira)

        foreach ($posts as $post) {
            $data['posts'][] = [
                'id' => $post->id,
                'title' => $post->title,
                'address' => $post->address,
                'type' => $post->type,
                'price' => apiCurrency($post->pricein, $post->priceindollar, $post->priceinnaira),
                'photos' => $post->photo,
            ];
        }

        json_output(200, $data);
    }

    private function __search_seller_post($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 'Active');
        $this->db->where('expiry_date >=', date('Y-m-d'));
    }

    public function getUserMetaData($user_id = 0)
    {
        $uid = intval($user_id);
        $CI =& get_instance();
        $metas = $CI->db->select('meta_key,meta_value')->get_where('user_meta', ['user_id' => $uid])->result();

        $data = [];
        foreach ($metas as $meta) {
            $data[$meta->meta_key] = $meta->meta_value;
        }

        return $data;
    }

    public function productAdd() {
        $regiday = $this->input->post('regiday');
        $regimonth = $this->input->post('regimonth');
        $regiyear = $this->input->post('regiyear');

        $pricein = $this->input->post('pricein');
        $pricevalue = $this->input->post('pricevalue');

        $vehicleId = $this->input->post('vehicle_type_id', TRUE);

        $data = array(
            'user_id'           => getLoginUserData('user_id'),
            'vehicle_type_id'   => $vehicleId,
            'location'          => $this->input->post('location', TRUE),
            'location_id'       => $this->input->post('location_id', TRUE),
            'lat'               => $this->input->post('lat', TRUE),
            'lng'               => $this->input->post('lng', TRUE),
            'package_id'        => 0,
            'advert_type'       => $this->input->post('advert_type', TRUE),
            'condition'         => $this->input->post('condition', TRUE),
            'post_slug'         => 'ad_'.time(),
            'post_type'         => "General",
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
            'registration_date' => $regiyear . '-' . $regimonth . '-' . $regiday,
            'manufacture_year' => $this->input->post('manufacture_year', TRUE),
            'registration_no' => $this->input->post('registration_no', TRUE),
            'owners' => $this->input->post('owners', TRUE),
            'service_history' => $this->input->post('service_history', TRUE),
            'status' => "Pending",
            'created'           => date('Y-m-d h:i:s'),
            'modified'          => date('Y-m-d h:i:s'),
        );

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

            $vehicle['mileage']         =  $this->input->post('mileage', TRUE);
            $vehicle['car_age']         =  $this->input->post('car_age', TRUE);
            $vehicle['alloywheels']     =  $this->input->post('alloywheels', TRUE);
            $vehicle['fuel_id']         =  $this->input->post('fuel_id', TRUE);
            $vehicle['enginesize_id']   =  $this->input->post('enginesize_id', TRUE);
            $vehicle['color']           =  $this->input->post('color', TRUE);
            $vehicle['registration_date'] =  $regiyear . '-' . $regimonth . '-' . $regiday;
            $vehicle['registration_no'] =  $this->input->post('registration_no', TRUE);
            $vehicle['feature_ids']     =  $feature_ids;

            $data = $data + $vehicle;
        }

        // only Parts
        else if ($vehicleId == 4) {
            $parts = array(
                'parts_description' => $this->input->post('parts_description', TRUE),
                'parts_for' => $this->input->post('parts_for', TRUE),
                'repair_type_id' => $this->input->post('repair_type_id', TRUE),
                'category_id' => $this->input->post('category_id', TRUE),
                'parts_id' => $this->input->post('parts_id', TRUE),
            );
            $data = $data + $parts;
        }

        // only Car, van, Auction car, import car
        elseif ($vehicleId != 3 && $vehicleId != 4) {
            $features = $this->input->post('feature_ids');

            if($features && count($features)){
                $feature_ids['feature_ids'] = implode(',', $features);
                $data = $data + $feature_ids;
            }

        }

        $data = $data + $price;

        $this->Posts_model->insert($data);
        $insert_id = $this->db->insert_id();
        $front = new \Verot\Upload\Upload($_FILES['front_img']);
        $back = new \Verot\Upload\Upload($_FILES['back_img']);
        $left = new \Verot\Upload\Upload($_FILES['left_img']);
        $right = new \Verot\Upload\Upload($_FILES['right_img']);

        $photo_data     = [];
        $rand = rand(00000, 99999);
        $photo_data[]   = $this->postPhotoUpload($insert_id, 75,  65, $front, $back, $left, $right, $rand);
        $photo_data[]   = $this->postPhotoUpload($insert_id, 280, 180, $front, $back, $left, $right, $rand);
        $photo_data[]   = $this->postPhotoUpload($insert_id, 285, 235, $front, $back, $left, $right, $rand);
        $photo_data[]   = $this->postPhotoUpload($insert_id, 875, 540, $front, $back, $left, $right, $rand);

        $this->db->insert_batch('post_photos', $photo_data);
        $this->setDefaultFeatured($insert_id);

//        if (isset($_FILES['fileselect']['name']) && is_array($_FILES['fileselect']['name'])) {
//            $file_ary = $this->reArrayFiles($_FILES['fileselect']);
//
//            foreach ($file_ary as $image) {
//                $this->upload_service_photo($image, $insert_id, 'No');
//            }
//        }

        Modules::run('mail/add_post_notice',$insert_id );

        echo ajaxRespond('success', 'Product added successfully.');
    }

    private function postPhotoUpload($post_id, $width, $height, $front, $back, $left, $right, $rand) {
        $data = [];
        $photoName = $post_id . '_photo_' . $rand. '_' . $width;

        if (!empty($front) && $front->uploaded) {
            $front->file_name_body_pre = '';
            $front->file_new_name_body = $photoName;
            $front->allowed = array('image/*');
            $front->image_resize = true;
            $front->image_x = $width;  // width
            $front->image_y = $height;  // Height
            $front->image_ratio = true;
            $front->image_ratio_fill = true;
            $front->image_background_color = '#000000';
            $front->image_watermark = dirname( BASEPATH ).'/assets/theme/new/images/whitetext-logo.png';


            $frontImg = $front->file_name_body_pre . $front->file_new_name_body . '.' . $front->file_src_name_ext;

            $front->process(dirname( BASEPATH )  .'/uploads/car/');

            if ($front->processed){
                $data['photo']      = $frontImg;
            } else {
                $data['photo']      = "Problem";
            }
        } else {
            $data['photo']      =  "";
        }

        $photoNameBack = $post_id . '_photo_back_' . $rand. '_' . $width;

        if (!empty($back) && $back->uploaded) {
            $back->file_name_body_pre = '';
            $back->file_new_name_body = $photoNameBack;
            $back->allowed = array('image/*');
            $back->image_resize = true;
            $back->image_x = $width;  // width
            $back->image_y = $height;  // Height
            $back->image_ratio = true;
            $back->image_ratio_fill = true;
            $back->image_background_color = '#000000';
            $back->image_watermark = dirname( BASEPATH ).'/assets/theme/new/images/whitetext-logo.png';


            $backIm = $back->file_name_body_pre . $back->file_new_name_body . '.' . $back->file_src_name_ext;

            $back->process(dirname( BASEPATH )  .'/uploads/car/');

            if ($back->processed){
                $data['back_photo']      = $backIm;
            } else {
                $data['back_photo']      = "Problem";
            }
        } else {
            $data['back_photo']      =  "";
        }

        $photoNameLeft = $post_id . '_photo_left_' . $rand. '_' . $width;
        if (!empty($left) && $left->uploaded) {
            $left->file_name_body_pre = '';
            $left->file_new_name_body = $photoNameLeft;
            $left->allowed = array('image/*');
            $left->image_resize = true;
            $left->image_x = $width;  // width
            $left->image_y = $height;  // Height
            $left->image_ratio = true;
            $left->image_ratio_fill = true;
            $left->image_background_color = '#000000';
            $left->image_watermark = dirname( BASEPATH ).'/assets/theme/new/images/whitetext-logo.png';


            $leftIm = $left->file_name_body_pre . $left->file_new_name_body . '.' . $left->file_src_name_ext;

            $left->process( dirname( BASEPATH )  .'/uploads/car/');

            if ($left->processed){
                $data['left_photo']      = $leftIm;
            } else {
                $data['left_photo']      = "Problem";
            }
        } else {
            $data['left_photo']      =  "";
        }

        $photoNameRight = $post_id . '_photo_right_' . $rand. '_' . $width;
        if (!empty($right) && $right->uploaded) {
            $right->file_name_body_pre = '';
            $right->file_new_name_body = $photoNameRight;
            $right->allowed = array('image/*');
            $right->image_resize = true;
            $right->image_x = $width;  // width
            $right->image_y = $height;  // Height
            $right->image_ratio = true;
            $right->image_ratio_fill = true;
            $right->image_background_color = '#000000';
            $right->image_watermark = dirname( BASEPATH ).'/assets/theme/new/images/whitetext-logo.png';


            $rightIm = $right->file_name_body_pre . $right->file_new_name_body . '.' . $right->file_src_name_ext;

            $right->process(dirname( BASEPATH )  .'/uploads/car/');

            if ($right->processed){
                $data['right_photo']      = $rightIm;
            } else {
                $data['right_photo']      = "Problem";
            }
        } else {
            $data['right_photo']      =  "";
        }

        $data['post_id']    = $post_id;
        $data['size']       = $width;
        $data['featured']   = 'No';

        return $data;
    }

    private function setDefaultFeatured( $post_id ){
        $count = $this->db->get_where('post_photos', ['post_id' => $post_id ])->num_rows();
        if($count == 4 ){
            $this->db->set('featured', 'Yes')
                ->where('post_id', $post_id)
                ->where('size', 285)
                ->update('post_photos');
        }
    }

    public function apiAddProduct() {
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
        if (isset($user) && (!in_array($user->role_id, array(4, 5, 1, 2)))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer or Private Seller to list your car.',
                'data' => null
            ]);
        }

        if ($user->role_id == 4) {
            $sellerPage = $this->db->where('user_id', $user->id)->where('post_type', 'business')->get('cms')->row();
            if (!$sellerPage) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Please update your business profile first to list your car from app.',
                    'data' => null
                ]);
            }
        }

        $requestData = $this->input->post();
        $regiday = isset($requestData['regiday']) ? $requestData['regiday'] : "0";
        $regimonth = isset($requestData['regimonth']) ? $requestData['regimonth'] : "0";
        $regiyear = isset($requestData['regiyear']) ? $requestData['regiyear'] : "0";

        $pricein = isset($requestData['pricein']) ? $requestData['pricein'] : "0";
        $pricevalue = $requestData['pricevalue'];

        $vehicleId = $requestData['vehicle_type_id'];

        $data = array(
            'user_id' => $user_id,
            'vehicle_type_id' => $vehicleId,
            'location' => $requestData['location'],
            'location_id'       => $requestData['location_id'],
            'lat' => isset($requestData['lat']) ? $requestData['lat'] : "0",
            'lng' => isset($requestData['lng']) ? $requestData['lng'] : "0",
            'package_id' => 0,
            'advert_type' => $requestData['advert_type'],
            'condition' => $requestData['condition'],
            'post_slug' => 'ad_' . time(),
            'post_type' => "General",
            'title' => $requestData['title'],
            'description' => $requestData['description'],
            'pricein' => $pricein,
            'mileage' => isset($requestData['mileage']) ? $requestData['mileage'] : "",
            'brand_id' => $requestData['brand_id'],
            'model_id' => $requestData['model_id'],
            'car_age' => isset($requestData['car_age']) ? $requestData['car_age'] : "0",
            'alloywheels' => isset($requestData['alloywheels']) ? $requestData['alloywheels'] : "",
            'fuel_id' => isset($requestData['fuel_id']) ? $requestData['fuel_id'] : "" ,
            'enginesize_id' => isset($requestData['enginesize_id']) ? $requestData['enginesize_id'] : "",
            'gear_box_type' => isset($requestData['gear_box_type']) ? $requestData['gear_box_type'] : "",
            'seats' => isset($requestData['seats']) ? $requestData['seats'] : "",
            'color' => isset($requestData['color']) ? $requestData['color'] : "",
            'body_type' => isset($requestData['body_type']) ? $requestData['body_type'] : "",
            'registration_date' => $regiyear . '-' . $regimonth . '-' . $regiday,
            'manufacture_year' => isset($requestData['manufacture_year']) ? $requestData['manufacture_year'] : "",
            'registration_no' => isset($requestData['registration_no']) ? $requestData['registration_no'] : "",
            'owners' => isset($requestData['owners']) ? $requestData['owners'] : "",
            'service_history' => isset($requestData['service_history']) ? $requestData['service_history'] : "",
            'status' => "Pending",
            'created' => date('Y-m-d h:i:s'),
            'modified' => date('Y-m-d h:i:s'),
        );

        $price = [];
        if ($pricein == 'NGR') {
            $price['priceinnaira'] = $pricevalue;
        } else {
            $price['priceindollar'] = $pricevalue;
        }

        // only MotorBike
        $vehicle = [];
        if ($vehicleId == 2) {
            if (isset($requestData['feature_ids'])) {
                $features = $requestData['feature_ids'];
                $feature_ids = ($features) ? implode(',', $features) : null;
            } else {
                $feature_ids = null;
            }


            $vehicle['mileage']         =  isset($requestData['mileage']) ? $requestData['mileage'] : "";
            $vehicle['car_age']         =  isset($requestData['car_age']) ? $requestData['car_age'] : "";
            $vehicle['alloywheels']     =  isset($requestData['alloywheels']) ? $requestData['alloywheels'] : "";
            $vehicle['fuel_id']         =  isset($requestData['fuel_id']) ? $requestData['fuel_id'] : "";
            $vehicle['enginesize_id']   =  isset($requestData['enginesize_id']) ? $requestData['enginesize_id'] : "";
            $vehicle['color']           =  isset($requestData['color']) ? $requestData['color'] : "";
            $vehicle['registration_date'] =  $regiyear . '-' . $regimonth . '-' . $regiday;
            $vehicle['registration_no'] =  isset($requestData['registration_no']) ? $requestData['registration_no'] : "";
            $vehicle['feature_ids']     =  $feature_ids;

            $data = $data + $vehicle;
        }

        // only Parts
        else if ($vehicleId == 4) {
            $parts = array(
                'parts_description' => isset($requestData['parts_description']) ? $requestData['parts_description'] : "",
                'parts_for' => isset($requestData['parts_for']) ? $requestData['parts_for'] : "",
                'category_id' => isset($requestData['category_id']) ? $requestData['category_id'] : "",
            );
            $data = $data + $parts;
        }

        // only Car, van, Auction car, import car
        elseif ($vehicleId != 3 && $vehicleId != 4) {
            if (isset($requestData['feature_ids'])) {
                $features = $requestData['feature_ids'];
            } else {
                $features = null;
            }
            if($features && count($features)){
                $feature_ids['feature_ids'] = implode(',', $features);
                $data = $data + $feature_ids;
            }

        }
        $data = $data + $price;

        $this->Posts_model->insert($data);
        $insert_id = $this->db->insert_id();
        $photo_data = [];
        if (isset($_FILES['front_img'])) {
            $rand = rand(00000, 99999);
            $photoName = $insert_id . '_photo_' . $rand.'.jpg';
            $stamp = imagecreatefrompng(dirname(BASEPATH) . '/assets/theme/new/images/whitetext-logo.png');
            $im = imagecreatefromstring(file_get_contents($_FILES['front_img']['tmp_name']));

            $sx = imagesx($stamp);
            $sy = imagesy($stamp);

            imagecopy($im, $stamp, (imagesx($im) - $sx)/2, (imagesy($im) - $sy)/2, 0, 0, imagesx($stamp), imagesy($stamp));
            ob_start();
            imagepng($im);
            $contents =  ob_get_contents();
            ob_end_clean();
            imagedestroy($im);
            $photo_data[100]['photo'] = GlobalHelper::uploadImageToCloudfare($contents, $photoName, true);
            $photo_data[100]['post_id'] = $insert_id;
            $photo_data[100]['size'] = 0;
            $photo_data[100]['featured'] = 'Yes';
        }

        if (isset($_FILES['images']['name']) && is_array($_FILES['images']['name'])) {
            $file_ary = $this->reArrayFiles($_FILES['images']);

            foreach ($file_ary as $key => $image) {
                $rand = rand(00000, 99999);
                $photoName = $insert_id . '_photo_' . $rand.'.jpg';
                $stamp = imagecreatefrompng(dirname(BASEPATH) . '/assets/theme/new/images/whitetext-logo.png');
                $im = imagecreatefromstring(file_get_contents($image['tmp_name']));

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
                $photo_data[$key]['featured'] = 'No';
            }
        }

        $this->db->insert_batch('post_photos', $photo_data);

        Modules::run('mail/add_post_notice', $insert_id, $user_id);

        return apiResponse([
            'status' => true,
            'message' => 'Product added successfully.',
            'data' => null
        ]);
    }

    public function reArrayFiles(&$file_post)
    {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }


    public function upload_service_photo($file, $post_id, $featured) {
        $rand = rand(0000, 9999);
        $photo_name     = $post_id . '_photo_' . $rand;
        $handle = new \Verot\Upload\Upload($file);

        $photo_data     = [];
        $photo_data[]   = $this->cropImageToThisSize($handle, $post_id,  75,  65, $photo_name, 'No' );
        $photo_data[]   = $this->cropImageToThisSize($handle, $post_id, 280, 180, $photo_name, 'No' );
        $photo_data[]   = $this->cropImageToThisSize($handle, $post_id, 285, 235, $photo_name, $featured);
        $photo_data[]   = $this->cropImageToThisSize($handle, $post_id, 875, 540, $photo_name, 'NO' );

        $this->db->insert_batch('post_photos', $photo_data);

        return true;
    }

    function cropImageToThisSize($handle, $post_id, $width, $height, $name, $feature = 'No' ) {

        $ext                            = 'jpg';
        $handle->file_new_name_body     = $name .'_'. $width;
        $handle->allowed                = array('image/*');

        $handle->image_resize           = true;
        $handle->image_x                = $width;   // width
        $handle->image_y                = $height;  // Height
        $handle->image_ratio            = true;
        $handle->image_ratio_fill       = true;
        $handle->image_background_color = '#000000';
        $handle->file_new_name_ext      = 'jpg';

        $photo                          = $handle->file_new_name_body .'.'. $ext;
        $handle->image_watermark = 'uploads/watermark.png';
        $handle->process( dirname( BASEPATH )  . '/uploads/car/' );


        if ($handle->processed){
            $data['post_id']    = $post_id;
            $data['photo']      = $photo;
            $data['size']       = $width;
            $data['featured']   = $feature;
            return $data;
        } else {
            return [ 'post_id' => $post_id, 'photo' => 'Problem', 'size' => 0, 'featured' => 'No'];
        }
    }

    public function apiUpdateProduct() {
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

        $user_data = $this->db->where('id', $user_id)->get('users')->row();
        if (isset($user_data) && ((!in_array($user_data->role_id, array(4, 5, 1, 2))))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer or Private Seller to list your car.',
                'data' => null
            ]);
        }

        if ($user_data->role_id == 4) {
            $sellerPage = $this->db->where('user_id', $user_data->id)->where('post_type', 'business')->get('cms')->row();
            if (!$sellerPage) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Please update your business profile first to list your car from app.',
                    'data' => null
                ]);
            }
        }

        $requestData = $this->input->post();
        $postId = isset($requestData['post_id']) ? $requestData['post_id'] : "";

        if (empty($postId)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid Post.',
                'data' => null
            ]);
        }

        $postId = intval($postId);
        $post = $this->db->where('id', $postId)->where('user_id', $user_id)->get('posts')->row();

        if (!isset($post)) {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid Post.',
                'data' => null
            ]);
        }

        $regiday = isset($requestData['regiday']) ? $requestData['regiday'] : "0";
        $regimonth = isset($requestData['regimonth']) ? $requestData['regimonth'] : "0";
        $regiyear = isset($requestData['regiyear']) ? $requestData['regiyear'] : "0";

        $pricein = isset($requestData['pricein']) ? $requestData['pricein'] : "0";
        $pricevalue = $requestData['pricevalue'];

        $vehicleId = $requestData['vehicle_type_id'];

        $data = array(
            'user_id' => $user_id,
            'vehicle_type_id' => $vehicleId,
            'location' => $requestData['location'],
            'location_id'       => $requestData['location_id'],
            'lat' => isset($requestData['lat']) ? $requestData['lat'] : "0",
            'lng' => isset($requestData['lng']) ? $requestData['lng'] : "0",
            'package_id' => 0,
            'advert_type' => $requestData['advert_type'],
            'condition' => $requestData['condition'],
            'title' => $requestData['title'],
            'description' => $requestData['description'],
            'pricein' => $pricein,
            'brand_id' => $requestData['brand_id'],
            'model_id' => $requestData['model_id'],
            'car_age' => isset($requestData['car_age']) ? $requestData['car_age'] : "0",
            'alloywheels' => isset($requestData['alloywheels']) ? $requestData['alloywheels'] : "",
            'enginesize_id' => isset($requestData['enginesize_id']) ? $requestData['enginesize_id'] : "",
            'seats' => isset($requestData['seats']) ? $requestData['seats'] : "",
            'color' => isset($requestData['color']) ? $requestData['color'] : "",
            'body_type' => isset($requestData['body_type']) ? $requestData['body_type'] : "",
            'mileage' => isset($requestData['mileage']) ? $requestData['mileage'] : "",
            'fuel_id' => isset($requestData['fuel_id']) ? $requestData['fuel_id'] : "" ,
            'gear_box_type' => isset($requestData['gear_box_type']) ? $requestData['gear_box_type'] : "",
            'registration_date' => $regiyear . '-' . $regimonth . '-' . $regiday,
            'manufacture_year' => $requestData['manufacture_year'],
            'registration_no' => isset($requestData['registration_no']) ? $requestData['registration_no'] : "",
            'owners' => isset($requestData['owners']) ? $requestData['owners'] : "",
            'service_history' => isset($requestData['service_history']) ? $requestData['service_history'] : "",
            'modified' => date('Y-m-d h:i:s'),
        );

        $price = [];
        if ($pricein == 'NGR') {
            $price['priceinnaira'] = $pricevalue;
        } else {
            $price['priceindollar'] = $pricevalue;
        }

        // only MotorBike
        $vehicle = [];
        if ($vehicleId == 2) {
            if (isset($requestData['feature_ids'])) {
                $features = $requestData['feature_ids'];
                $feature_ids = ($features) ? implode(',', $features) : null;
            } else {
                $feature_ids = null;
            }

            $vehicle['mileage']         =  isset($requestData['mileage']) ? $requestData['mileage'] : "";
            $vehicle['car_age']         =  isset($requestData['car_age']) ? $requestData['car_age'] : "";
            $vehicle['alloywheels']     =  isset($requestData['alloywheels']) ? $requestData['alloywheels'] : "";
            $vehicle['fuel_id']         =  isset($requestData['fuel_id']) ? $requestData['fuel_id'] : "";
            $vehicle['enginesize_id']   =  isset($requestData['enginesize_id']) ? $requestData['enginesize_id'] : "";
            $vehicle['color']           =  isset($requestData['color']) ? $requestData['color'] : "";
            $vehicle['registration_date'] =  $regiyear . '-' . $regimonth . '-' . $regiday;
            $vehicle['registration_no'] =  isset($requestData['registration_no']) ? $requestData['registration_no'] : "";
            $vehicle['feature_ids']     =  $feature_ids;

            $data = $data + $vehicle;
        }

        // only Parts
        else if ($vehicleId == 4) {
            $parts = array(
                'parts_description' => $requestData['parts_description'],
                'parts_for' => $requestData['parts_for'],
                'category_id' => $requestData['category_id'],
            );
            $data = $data + $parts;
        }

        // only Car, van, Auction car, import car
        elseif ($vehicleId != 3 && $vehicleId != 4) {
            if (isset($requestData['feature_ids'])) {
                $features = $requestData['feature_ids'];
            } else {
                $features = null;
            }
            if($features && count($features)){
                $feature_ids['feature_ids'] = implode(',', $features);
                $data = $data + $feature_ids;
            }

        }
        $data = $data + $price;

        $this->Posts_model->update($postId, $data);
        $this->db->where('post_id', $postId)->delete('post_photos');
        $insert_id = $postId;
        $photo_data = [];
        if (isset($_FILES['front_img'])) {
            $rand = rand(00000, 99999);
            $photoName = $insert_id . '_photo_' . $rand.'.jpg';
            $stamp = imagecreatefrompng(dirname(BASEPATH) . '/assets/theme/new/images/whitetext-logo.png');
            $im = imagecreatefromstring(file_get_contents($_FILES['front_img']['tmp_name']));

            $marge_right = 10;
            $marge_bottom = 10;
            $sx = imagesx($stamp);
            $sy = imagesy($stamp);

            imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
            ob_start();
            imagepng($im);
            $contents =  ob_get_contents();
            ob_end_clean();
            imagedestroy($im);
            $photo_data[100]['photo'] = GlobalHelper::uploadImageToCloudfare($contents, $photoName, true);
            $photo_data[100]['post_id'] = $insert_id;
            $photo_data[100]['size'] = 0;
            $photo_data[100]['featured'] = 'Yes';
        }

        if (isset($_FILES['images']['name']) && is_array($_FILES['images']['name'])) {
            $file_ary = $this->reArrayFiles($_FILES['images']);

            foreach ($file_ary as $key => $image) {
                $rand = rand(00000, 99999);
                $photoName = $insert_id . '_photo_' . $rand.'.jpg';
                $stamp = imagecreatefrompng(dirname(BASEPATH) . '/assets/theme/new/images/whitetext-logo.png');
                $im = imagecreatefromstring(file_get_contents($image['tmp_name']));

                $marge_right = 10;
                $marge_bottom = 10;
                $sx = imagesx($stamp);
                $sy = imagesy($stamp);

                imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
                ob_start();
                imagepng($im);
                $contents =  ob_get_contents();
                ob_end_clean();
                imagedestroy($im);
                $photo_data[$key]['photo'] = GlobalHelper::uploadImageToCloudfare($contents, $photoName, true);
                $photo_data[$key]['post_id'] = $insert_id;
                $photo_data[$key]['size'] = 0;
                $photo_data[$key]['featured'] = 'No';
            }
        }

        $this->db->insert_batch('post_photos', $photo_data);

        return apiResponse([
            'status' => true,
            'message' => 'Product update successfully.',
            'data' => null
        ]);

    }

    public function getDropDownData()
    {
        $locations = GlobalHelper::all_api_location();
        $vehicleType = GlobalHelper::dropDownVehicleListApi();
        $vehicleConditions = GlobalHelper::getVehicleCondition();
        $packageList = GlobalHelper::apiPackageList();
        $fuelType = GlobalHelper::getDropDownFromTable($tbl = 'fuel_types', $col = 'fuel_name');
        $currency = GlobalHelper::getCurrencyApi();
        $gearbox = GlobalHelper::getApiGearBox();
        $bodyType = GlobalHelper::getDropDownFromTable($tbl = 'body_types', $col = 'type_name');
        $colors = GlobalHelper::getDropDownFromTable($tbl = 'color', $col = 'color_name');
        $manufacturingYear = numericDropDownApi2(date('Y'), 1950, 1, 0);
        $seats = GlobalHelper::getSeatApi();
        $owner = GlobalHelper::getOwnerApi();
        $allFeatures = GlobalHelper::all_features_api();
        $partsCategories = GlobalHelper::parts_categories_api();
        $partsFor = GlobalHelper::parts_for_api();
        $parts_description_api = GlobalHelper::parts_description_api();
        $get_car_age_api = GlobalHelper::get_car_age_api();
        $engine_sizes = $this->db->from('engine_sizes')->get()->result();
        $body_types = $this->db->from('body_types')->get()->result();
        $wheels = [
            '1' => '13" Alloy Wheels',
            '2' => '14" Alloy Wheels',
            '3' => '15" Alloy Wheels',
            '4' => '16" Alloy Wheels',
            '5' => '17" Alloy Wheels',
            '6' => '18" Alloy Wheels',
            '7' => '19" Alloy Wheels',
        ];
        $service_history = [
            '1' => 'First service is not due',
            '2' => 'Full service history',
            '3' => 'Part service history',
            '4' => 'No service history',
        ];

        $license_type = [
            1 => [
                'name' => "Class A",
                "details" => "Motorcycle"
            ],
            2 => [
                'name' => "Class B",
                "details" => "Motor vehicle of less than 3 tones gross weight other than motorcycle, taxi, stage carriage or omnibus (Omnibus can be understood as any vehicle using motors that can carry fewer than six passengers.)"
            ],
            3 => [
                'name' => "Class C",
                "details" => "A motor vehicle of less than 3 tones gross weight, other than motorcycle"
            ],
            4 => [
                'name' => "Class D",
                "details" => "Motor vehicle other than motorcycle, taxi, stage carriage or omnibus excluding an articulated vehicle or vehicle drawing a trailer."
            ],
            5 => [
                'name' => "Class E",
                "details" => "Motor vehicle other than a motorcycle or articulated vehicle"
            ],
            6 => [
                'name' => "Class F",
                "details" => "Agricultural machines and tractors"
            ],
            7 => [
                'name' => "Class G",
                "details" => "Articulated vehicles"
            ],
            8 => [
                'name' => "Class H",
                "details" => "Earth moving vehicles"
            ],
            9 => [
                'name' => "Class J",
                "details" => "Special, for physically handicapped persons."
            ],
            10 => [
                'name' => "Class V",
                "details" => "Convoy driving (This type of license is issued for individuals who drive holders of political and government officials for the convoying purpose.)"
            ]
        ];

        $education_type = [
            1 => "Primary",
            2 => "Secondary",
            3 => "NCE",
            4 => "OND",
            5 => "HND",
            6 => "Degree",
        ];

        $driver_marital_status = [
            1 => "Single",
            2 => "Married",
            3 => "Divorced"
        ];

        $driver_status = [
            0 => "Inactive",
            1 => "Available",
            2 => "Hired",
            3 => "Requested To Hire",
        ];

        $driver_service_types = [
            1 => "Recruitment",
            2 => "Outsourcing",
        ];

        $driver_hire_periods = [
            1 => "1 week",
            2 => "1 month",
            3 => "6 months",
            4 => "1 year",
        ];
        $mechanic_service_type = [
            'Delivery' => 'Delivery',
            'Pickup' => 'Pickup'
        ];
        $mechanic_repair_types = $this->db->get('repair_types')->result();
        $mechanic_specialisms = $this->db->get('specialism')->result();
        $mobile_mechanic_categories = $this->db->where('parent_id', 0)->get('towing_categories')->result();
        $mobile_mechanic_availability = $types = [
            '24 hrs' => '24 hrs',
            '9am-5PM' => '9am-5PM',
            '6am-10PM' => '6am-10PM'
        ];
        $ci = &get_instance();
        $insurance_providers = $ci->db->where(['type' => 'insurance'])->get('company_profile')->result();

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'locations' => $locations,
                'vehicle_types' => $vehicleType,
                'vehicle_conditions' => $vehicleConditions,
                'packages' => $packageList,
                'fuels' => $fuelType,
                'currency' => $currency,
                'gearbox' => $gearbox,
                'manufacturing_years' => $manufacturingYear,
                'body_type' => $bodyType,
                'colors' => $colors,
                'seats' => $seats,
                'owner_type' => $owner,
                'all_features' => $allFeatures,
                'parts' => $partsCategories,
                'parts_for' => $partsFor,
                'parts_description' => $parts_description_api,
                'ages' => $get_car_age_api,
                'engine_sizes' => $engine_sizes,
                'body_types' => $body_types,
                'wheels' => $wheels,
                'service_history' => $service_history,
                'education_type' => $education_type,
                'vehicle_types_for_drivers' => DB::table('vehicle_types')->whereIn('id', [1, 2, 3, 7])->get(),
                'license_type' => $license_type,
                'driver_location' => DB::table('post_area')->where('id', "!=", "39")->where("id", "!=", "40")->get(),
                'driver_marital_status' => $driver_marital_status,
                'driver_status' => $driver_status,
                'driver_service_types' => $driver_service_types,
                'driver_hire_periods' => $driver_hire_periods,
                'mechanic_service_type' => $mechanic_service_type,
                'mechanic_repair_types' => $mechanic_repair_types,
                'mechanic_specialisms' => $mechanic_specialisms,
                'mobile_mechanic_categories' => $mobile_mechanic_categories,
                'mobile_mechanic_availability' => $mobile_mechanic_availability,
                'insurance_providers' => $insurance_providers,
                'destination_port' => GlobalHelper::PortDropdownApi(),
                'country' => getDropDownCountries_api()
            ]
        ]);
    }

    public function getBrandsByVehicle()
    {
        $vehicle_type_id = $_REQUEST['vehicle_type_id'];
        $ci = &get_instance();
        $brands = $ci->db->query("SELECT * FROM brands where FIND_IN_SET('$vehicle_type_id',type_id) and type='Brand'")->result();

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'brands' => $brands
            ]
        ]);
    }

    public function getModelByBrands()
    {
        $brand_id = $_REQUEST['brand_id'];

        $ci = &get_instance();
        $models = $ci->db->from('brands')
            ->where('parent_id', $brand_id)
            ->where('type', 'Model')
            ->get()
            ->result();

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'models' => $models
            ]
        ]);
    }

    public function my_posts() {
        $token = $this->input->server('HTTP_TOKEN');
        $user = null;
        if ($token) {
            $user = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }
        $user_id = ($user) ? $user->user_id : 0;
        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }

        $user_data = $this->db->where('id', $user_id)->get('users')->row();
        if (isset($user_data) && ((!in_array($user_data->role_id, array(4, 5, 1, 2))))) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Login or Sign Up as Dealer or Private Seller to list your car.',
                'data' => null
            ]);
        }

        is_token_match($user_id, $token);

        $posts = $this->Posts_model->get_limit_data_byVenderApi(0, 0, '', $user_id);
        $data = array(
            'status' => true,
            'data' => [
                'posts' => $posts,
            ]
        );

        return apiResponse($data);
    }

    public function public_posts()
    {
        $page_slug = $this->input->get('post_slug');
        $type = GlobalHelper::getTypeIdByPageSlug($page_slug); // for get method
        $type_id = ($type == 0) ? intval($this->input->get('type_id')) : intval($type);
        $location_id = intval($this->input->get('location_id'));
//        $type_id = intval($this->input->get('type_id'));         // CategoryID
        $brand_id = intval($this->input->get('brand_id'));
        $model_id = intval($this->input->get('model_id'));
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
        $parts_for = intval($this->input->get('parts_for'));
        $from_year = intval($this->input->get('from_year'));
        $to_year = intval($this->input->get('to_year'));

        $specialist = intval($this->input->get('specialist'));
        $repair_type = intval($this->input->get('repair_type'));
        $service = $this->input->get('service');

        $category_id = intval($this->input->get('category_id'));
        $parts_description = intval($this->input->get('parts_description'));
        $wheelbase = intval($this->input->get('wheelbase'));
        $year = intval($this->input->get('year'));
        $seller = $this->input->get('seller');             // Business or Private
        $conditions['expiry_date >='] = date('Y-m-d');

        if ($location_id) {
            $conditions['location_id'] = $location_id;
        }
        if ($model_id) {
            $conditions['model_id'] = $model_id;
        }
        if ($body_type) {
            $conditions['body_type'] = $body_type;
        }
        if ($age_from) {
            $conditions['car_age >='] = $age_from;
        }
        if ($age_to) {
            $conditions['car_age <='] = $age_to;
        }
        if ($price_from) {
            $conditions['priceinnaira >='] = $price_from;
        }
        if ($price_to) {
            $conditions['priceinnaira <='] = $price_to;
        }
        if ($mileage_from) {
            $conditions['mileage >='] = $mileage_from;
        }
        if ($mileage_to) {
            $conditions['mileage <='] = $mileage_to;
        }
        if ($condition) {
            $conditions['condition'] = $condition;
        }

        if ($from_year) {
            $conditions['manufacture_year >='] = $from_year;
        }
        if ($to_year) {
            $conditions['manufacture_year <='] = $to_year;
        }

        if ($fuel_type) {
            $conditions['fuel_id'] = $fuel_type;
        }
        if ($engine_size) {
            $conditions['enginesize_id'] = $engine_size;
        }
        if ($gear_box) {
            $conditions['gear_box_type'] = $gear_box;
        }
        if ($seats) {
            $conditions['seats'] = $seats;
        }
        if ($color) {
            $conditions['color'] = $color;
        }
        if ($year) {
            $conditions['manufacture_year'] = $year;
        }
        if ($parts_id) {
            $conditions['parts_description'] = $parts_id;
        }
        if ($parts_for) {
            $conditions['parts_for'] = $parts_for;
        }

        if ($specialist) {
            $conditions['specialism_id'] = $specialist;
        }
        if ($repair_type) {
            $conditions['repair_type_id'] = $repair_type;
        }
        if ($service) {
            $conditions['service_type'] = $service;
        }

        if ($parts_description) {
            $conditions['parts_description'] = $parts_description;
        }
        if ($category_id) {
            $conditions['category_id'] = $category_id;
        }
        if ($wheelbase) {
            $conditions['alloywheels'] = $wheelbase;
        }
        if ($seller) {
            $conditions['listing_type'] = $seller;
        }
        if ($brand_id) {
            $conditions['brand_id'] = $brand_id;
        }
        if ($type_id) {
            $conditions['vehicle_type_id'] = $type_id;
        }

        if ($page_slug == 'automech-search') {
//            $this->db->select('posts.*,brand_meta.brand');
//            $this->db->join('brand_meta', 'brand_meta.post_id = posts.id', 'LEFT');
//            $conditions = ($brand_id) ? array_merge($conditions, ['brand_meta.brand' => $brand_id]) : $conditions;
            $this->db->where('posts.post_type', 'Automech');
        } else if ($page_slug == 'towing-search') {
            $this->db->where('posts.post_type', 'Towing');
        } else {
//            $this->db->select("brands.name as brand_name, models.name as model_name");
//            $this->db->join('brands', 'brands.id=posts.brand_id AND and brands.type="Brand"', 'LEFT');
//            $this->db->join('brands as models', 'models.id=posts.model_id AND and models.type="Model"', 'LEFT');
            $this->db->where('posts.post_type', 'General');
//            $conditions = ($brand_id) ? array_merge($conditions, ['brand_id' => $brand_id]) : $conditions;
        }

        if ($page_slug == 'spare-parts') {
            $this->db->select('parts_description.name as parts_description_name');
            $this->db->join('parts_description', 'parts_description.id=posts.parts_description');
        }

        if ($page_slug == 'towing-search') {
            $this->db->select('towing_categories.name as towing_type_of_service_name');
            $this->db->join('towing_categories', 'towing_categories.id=posts.towing_type_of_service_id');
        }

        $baseUrl = base_url();
        $this->db->select('posts.id');
//        $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.photo) as photo");
//        $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.left_photo) as left_photo");
//        $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.right_photo) as right_photo");
//        $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.back_photo) as back_photo");
//        $this->db->select("GROUP_CONCAT('" . $baseUrl . "uploads/car/', post_photos.photo) as images");
//        $this->db->join('post_photos', 'post_photos.post_id=posts.id AND post_photos.size=875', 'LEFT');
        //$this->db->join('users', 'users.id=posts.user_id');
        $this->db->where($conditions);
        $this->db->where('posts.status', 'Active');
        $this->db->where('posts.activation_date IS NOT NULL');
        $this->db->where('posts.expiry_date >=', date('Y-m-d'));
        $this->db->group_by('posts.id');
        $total = $this->db->get('posts')->num_rows();

        $limit = 25;
        $page = $this->input->get('page');
        $start = startPointOfPagination($limit, $page);

        if ($this->input->get('sort_by') == 'price') {
            $order_column = 'posts.priceinnaira';
        } else {
            $order_column = 'posts.id';
        }

        if ($this->input->get('order_by') == 'asc') {
            $order_by = 'ASC';
        } else {
            $order_by = 'DESC';
        }

        $this->db->from('posts');
        if ($page_slug == 'automech-search') {
//            $this->db->select('posts.*,brand_meta.brand');
//            $this->db->join('brand_meta', 'brand_meta.post_id = posts.id', 'LEFT');
//            $conditions = ($brand_id) ? array_merge($conditions, ['brand_meta.brand' => $brand_id]) : $conditions;
            $this->db->where('posts.post_type', 'Automech');
        } else if ($page_slug == 'towing-search') {
            $this->db->where('posts.post_type', 'Towing');
        } else {
//            $this->db->select("brands.name as brand_name, models.name as model_name");
//            $this->db->join('brands', 'brands.id=posts.brand_id AND and brands.type="Brand"');
//            $this->db->join('brands as models', 'models.id=posts.model_id AND and models.type="Model"');
            $this->db->where('posts.post_type', 'General');
 //           $conditions = ($brand_id) ? array_merge($conditions, ['brand_id' => $brand_id]) : $conditions;
        }
        if ($page_slug == 'spare-parts') {
            $this->db->select('parts_description.name as parts_description_name');
            $this->db->join('parts_description', 'parts_description.id=posts.parts_description');
        }

        if ($page_slug == 'towing-search') {
            $this->db->select('towing_categories.name as towing_type_of_service_name');
            $this->db->join('towing_categories', 'towing_categories.id=posts.towing_type_of_service_id');
        }

        $baseUrl = base_url();
        $this->db->select('posts.id, posts.is_featured, posts.title, posts.location_id, posts.location, posts.pricein, posts.priceindollar, posts.priceinnaira');
        $this->db->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo)) as photo");
//        $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.left_photo) as left_photo");
//        $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.right_photo) as right_photo");
//        $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.back_photo) as back_photo");
//        $this->db->select("GROUP_CONCAT('" . $baseUrl . "uploads/car/', post_photos.photo) as images");
        $this->db->join('post_photos', "post_photos.post_id = posts.id AND post_photos.featured = 'Yes' AND (post_photos.size=0 OR post_photos.size = 285)", 'LEFT');


        //$this->db->join('users', 'users.id=posts.user_id');
        $this->db->where('posts.status', 'Active');
        $this->db->where('posts.activation_date IS NOT NULL');
        $this->db->where('posts.expiry_date >=', date('Y-m-d'));
        $this->db->where($conditions);
        $this->db->limit($limit, $start);
        $this->db->group_by('posts.id');

        if ($this->input->get('sort_by') == 'price' && $this->input->get('order_by') != 'asc') {
            $this->db->order_by('is_featured', 'DESC');
            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('posts.activation_date', 'DESC');
            $this->db->order_by('priceindollar', $order_by);
        } else if ($this->input->get('sort_by') == 'price' && $this->input->get('order_by') == 'asc') {
            $this->db->order_by('is_featured', 'DESC');
            $this->db->order_by('priceindollar', $order_by);
            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('posts.activation_date', 'DESC');
        } else {
            $this->db->order_by('is_featured', 'DESC');
            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('posts.id', 'DESC');
        }

        $results = $this->db->get()->result();

        $api_data['status'] = true;
        $api_data['total'] = $total;
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
        $api_data['next_page_url'] = next_page_api_url($page, $limit, $total, 'api/posts', $queryString);
        $api_data['prev_page_url'] = prev_page_api_url($page, 'api/posts', $queryString);
        $api_data['posts'] = array();
        $api_data['posts'] = $results;

        return apiResponse($api_data);
    }

    public function getPostCompareList()
    {
        $vehicle_type_id = $this->input->post('vehicle_type_id');
        $brandId = $this->input->post('brand_id');
        $modelId = $this->input->post('model_id');
        $year = $this->input->post('year');
        $limit = 25;
        $page = $this->input->get('page');
        $start = startPointOfPagination($limit, $page);

        $conditions = [];
        $conditions = ($vehicle_type_id) ? array_merge($conditions, ['vehicle_type_id' => $vehicle_type_id]) : $conditions;
        $conditions = ($brandId) ? array_merge($conditions, ['brand_id' => $brandId]) : $conditions;
        $conditions = ($modelId) ? array_merge($conditions, ['model_id' => $modelId]) : $conditions;
        $conditions = ($year) ? array_merge($conditions, ['manufacture_year' => $year]) : $conditions;

        $total = $this->db->select('posts.*')
            ->select("CONCAT('" . base_url() . "uploads/car/', post_photos.photo) as photo")
            ->select("brands.name as brand_name, models.name as model_name")
            ->join('post_photos', "post_photos.post_id = posts.id AND post_photos.featured = 'Yes' AND post_photos.size = '875'", 'LEFT')
            ->join('brands', 'brands.id=posts.brand_id AND and brands.type="Brand"', 'LEFT')
            ->join('brands as models', 'models.id=posts.model_id AND and models.type="Model"', 'LEFT')
            ->from('posts')->group_by('posts.id')->where($conditions)->count_all_results();

        $this->db->select('posts.*');
        $this->db->select("CONCAT('" . base_url() . "uploads/car/', post_photos.photo) as photo");
        $this->db->select("brands.name as brand_name, models.name as model_name");
        $this->db->join('post_photos', "post_photos.post_id = posts.id AND post_photos.featured = 'Yes' AND post_photos.size = '875'", 'LEFT');
        $this->db->join('brands', 'brands.id=posts.brand_id AND and brands.type="Brand"', 'LEFT');
        $this->db->join('brands as models', 'models.id=posts.model_id AND and models.type="Model"', 'LEFT');
        $to_car = $this->db->from('posts')->where($conditions)->order_by('created', 'DESC')->group_by('posts.id')
            ->limit($limit, $start)
                ->get()->result();

        $next_page_url = next_page_api_url($page, $limit, $total, 'api/get-post-compare-list');
        $prev_page_url = prev_page_api_url($page, 'api/get-post-compare-list');

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'posts' => $to_car,
                'next_page_url' => $next_page_url,
                'prev_page_url' => $prev_page_url,
                'total' => $total,
            ]
        ]);
    }

    public function getSimilarPosts()
    {
        $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 0;
        $model_id = isset($_GET['model_id']) ? $_GET['model_id'] : 0;
        $current_type = $this->db->select('vehicle_type_id, post_type')->where('id', $post_id)->get('posts')->row();
        if (empty($current_type)) {
            return apiResponse([
                'status' => false,
                'message' => 'No Similar Post',
                'data' => []
            ]);
        }

        if ($current_type->vehicle_type_id == 4) {
            $this->db->order_by('posts.id', 'DESC')->where(['vehicle_type_id' => 4, 'posts.id <>' => $post_id]);
        } else if ($current_type->post_type == 'Automech') {
            $this->db->order_by('posts.id', 'DESC')->where(['posts.id <>' => $post_id]);
        } else {
            $this->db->order_by('posts.id', 'DESC')->where(['model_id' => $model_id, 'posts.id <>' => $post_id]);
        }

        if ($current_type->post_type == 'Automech') {
            $this->db->select('posts.*,brand_meta.brand');
            $this->db->join('brand_meta', 'brand_meta.post_id = posts.id', 'LEFT');
            $this->db->where('posts.post_type', 'Automech');
        } else {
            $baseUrl = base_url();
            $this->db->select('posts.*');
            $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.photo) as photo");
            $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.left_photo) as left_photo");
            $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.right_photo) as right_photo");
            $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.back_photo) as back_photo");
            $this->db->select("GROUP_CONCAT('" . $baseUrl . "uploads/car/', post_photos.photo) as images");
            $this->db->select("brands.name as brand_name, models.name as model_name");
            $this->db->join('brands', 'brands.id=posts.brand_id AND and brands.type="Brand"', 'LEFT');
            $this->db->join('brands as models', 'models.id=posts.model_id AND and models.type="Model"', 'LEFT');
            $this->db->join('post_photos', 'post_photos.post_id=posts.id AND post_photos.size=875', 'LEFT');
            $this->db->where('posts.post_type', 'General');
        }


        $this->db->join('users', 'users.id=posts.user_id');
        $this->db->where('posts.status', 'Active');
        $this->db->where('posts.activation_date IS NOT NULL');
        $this->db->where('posts.expiry_date >=', date('Y-m-d'));
        $this->db->group_by('posts.id');
        $total = $this->db->get('posts')->num_rows();

        $limit = 25;
        $page = $this->input->get('page');
        $start = startPointOfPagination($limit, $page);

        if ($this->input->get('sort_by') == 'price') {
            $order_column = 'posts.priceinnaira';
        } else {
            $order_column = 'posts.id';
        }

        if ($this->input->get('order_by') == 'asc') {
            $order_by = 'ASC';
        } else {
            $order_by = 'DESC';
        }

        $this->db->from('posts');
        if ($current_type->vehicle_type_id == 4) {
            $this->db->order_by('posts.id', 'DESC')->where(['vehicle_type_id' => 4, 'posts.id <>' => $post_id]);
        } else if ($current_type->post_type == 'Automech') {
            $this->db->order_by('posts.id', 'DESC')->where(['posts.id <>' => $post_id]);
        } else {
            $this->db->order_by('posts.id', 'DESC')->where(['model_id' => $model_id, 'posts.id <>' => $post_id]);
        }
        if ($current_type->post_type == 'Automech') {
            $this->db->select('posts.*,brand_meta.brand');
            $this->db->join('brand_meta', 'brand_meta.post_id = posts.id', 'LEFT');
            $this->db->where('posts.post_type', 'Automech');
        } else {
            $baseUrl = base_url();
            $this->db->select('posts.*');
            $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.photo) as photo");
            $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.left_photo) as left_photo");
            $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.right_photo) as right_photo");
            $this->db->select("CONCAT('" . $baseUrl . "uploads/car/', post_photos.back_photo) as back_photo");
            $this->db->select("GROUP_CONCAT('" . $baseUrl . "uploads/car/', post_photos.photo) as images");
            $this->db->select("brands.name as brand_name, models.name as model_name");
            $this->db->join('brands', 'brands.id=posts.brand_id AND and brands.type="Brand"', 'LEFT');
            $this->db->join('brands as models', 'models.id=posts.model_id AND and models.type="Model"', 'LEFT');
            $this->db->join('post_photos', 'post_photos.post_id=posts.id AND post_photos.size=875', 'LEFT');
            $this->db->where('posts.post_type', 'General');
        }

        $this->db->join('users', 'users.id=posts.user_id');
        $this->db->where('posts.status', 'Active');
        $this->db->where('posts.activation_date IS NOT NULL');
        $this->db->where('posts.expiry_date >=', date('Y-m-d'));
        $this->db->limit($limit, $start);
        $this->db->group_by('posts.id');
        $this->db->order_by($order_column, $order_by);
        $results = $this->db->get()->result();

        $api_data['status'] = true;
        $api_data['total'] = $total;
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
        $api_data['next_page_url'] = next_page_api_url($page, $limit, $total, 'api/posts', $queryString);
        $api_data['prev_page_url'] = prev_page_api_url($page, 'api/posts', $queryString);
        $api_data['posts'] = array();
        $api_data['posts'] = $results;

        return apiResponse($api_data);
    }

    public function import_search_list($page_slug = null)
    {

        $cms  = get_cms_with_dynamic_meta('search-vehicle', [
            'type' => ucfirst(str_replace('-', ' ', $page_slug))
        ]);


        $data['meta_title']         = $cms['meta_title'];
        $data['meta_description']   = getShortContent($cms['meta_description'], 120);
        $data['meta_keywords']      = $cms['meta_keywords'];

        $page_slug = is_null($page_slug) ? $this->input->get('page_slug') : $page_slug;

        $country_slug = $this->input->get('country');

        $location_slug = !empty($this->input->get('location')) ? explode(',', $this->input->get('location')) : [-1];
        $location_name = '';
        $location_array = [];


        $type = GlobalHelper::getTypeIdByPageSlug($page_slug); // for get method
        $type_id = ($type == 0) ? intval($this->input->get('type_id')) : intval($type);
        $brand_slug = $this->input->get('brand');
        $model_slug = $this->input->get('model');
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
        $specialist = intval($this->input->get('specialist'));
        $repair_type = intval($this->input->get('repair_type'));
        $service = $this->input->get('service');

        // Towing
        $towing_service_id = intval($this->input->get('towing_service_id'));
        $vehicle_type = intval($this->input->get('vehicle_type'));
        $type_of_service = $this->input->get('type_of_service');
        $availability = $this->input->get('availability');


        $category_id = intval($this->input->get('category_id'));
        $parts_description = intval($this->input->get('parts_description'));
        $wheelbase = intval($this->input->get('wheelbase'));
        $year = intval($this->input->get('year'));
        $from_year = intval($this->input->get('from_year'));
        $to_year = intval($this->input->get('to_year'));
        $seller = $this->input->get('seller');
        $address = $this->input->get('address');// Business or Private
        $conditions = ['posts.expiry_date >=' => date('Y-m-d'),'posts.post_type'=>'import-car'];

        //
        $brand = $this->db->from('brands')->where('slug', $brand_slug)->get()->row();
        $model = $this->db->from('brands')->where('slug', $model_slug)->get()->row();
        $locPar = $this->db->where_in('slug', $location_slug)->where('type', 'state')->get('post_area')->result();
        $couPar = $this->db->where('slug', $country_slug)->where('type', '1')->get('countries')->row();
        $prepared_address = ucfirst(str_replace('-', ' ', isset($address)?$address:''));

        if (!empty($locPar)){
            $location_name = implode(', ', array_column($locPar, 'name'));
            $location_array = implode(',',array_column($locPar, 'id'));

        }

        $get_array = array_filter($this->input->get());
        if (!empty($page_slug)) $get_array['type'] = ucfirst(str_replace('-', ' ', $page_slug));
        if (!empty($country_slug) && !empty($couPar)) $get_array['country_name'] = $couPar->name;
        if (!empty($location_slug) && !empty($location_array)) $get_array['location_name'] = $location_name;
        if (!empty($address)) $get_array['address'] = $address;
        if (!empty($brand_slug) && !empty($brand)) $get_array['brand_name'] = $brand->name;
        if (!empty($model_slug) && !empty($model)) $get_array['model_name'] = $model->name;
        if (!empty($body_type)){
            $body = $this->db->from('body_types')->where('id', $body_type)->get()->row();
            if (!empty($body)) $get_array['body_name'] = $body->type_name;
        }
        if (!empty($fuel_type)){
            $fuel = $this->db->from('fuel_types')->where('id', $fuel_type)->get()->row();
            if (!empty($fuel)) $get_array['fuel_name'] = $fuel->fuel_name;
        }
        if (!empty($engine_size)){
            $engine = $this->db->from('engine_sizes')->where('id', $engine_size)->get()->row();
            if (!empty($engine)) $get_array['engine_name'] = $engine->engine_size;
        }
        if (!empty($color)){
            $c = $this->db->from('color')->where('id', $color)->get()->row();
            if (!empty($c)) $get_array['color_name'] = $c->color_name;
        }
        if (!empty($category_id)){
            $category = $this->db->from('parts_categories')->where('id', $category_id)->get()->row();
            if ($category) $get_array['parts_category'] = $category->category;
        }


        if (!empty($this->input->get())) {
            $this->db->select('title, var');
            foreach (array_keys(array_filter($this->input->get())) as $k => $v) {
                if (!in_array($v, ['page', 'order_by'])) {
                    $this->db->where($v, 1);
                }
            }
            $meta_title = $this->db->get('meta_title')->row();
            $data['meta_title'] = '';
            if (!empty($meta_title)) {
                $var_array = explode(',', $meta_title->var);
                foreach ($var_array as $d => $k) {
                    $meta_title->title = str_replace('%' . $k . '%', !empty($get_array[$k]) ? $get_array[$k] : '', $meta_title->title);
                }
                $data['meta_title'] = $meta_title->title;
            }
        }


        $conditions = ($couPar) ? array_merge($conditions, ['posts.country_id' => $couPar->id]) : $conditions;
       // $conditions = ($locPar) ? array_merge($conditions, ['posts.location_id' => $locPar->id]) : $conditions;

        // brand id will change with page slug
        // $conditions = ($$brand_slug)       ? array_merge($conditions, ['brand_id' => $$brand_slug]) : $conditions;
        $conditions = ($type_id) ? array_merge($conditions, ['posts.vehicle_type_id' => $type_id]) : $conditions;
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

        $conditions = ($from_year) ? array_merge($conditions, ['posts.manufacture_year >=' => $from_year]) : $conditions;


        $conditions = ($parts_id) ? array_merge($conditions, ['posts.parts_description' => $parts_id]) : $conditions;
        $conditions = ($s_parts_id) ? array_merge($conditions, ['posts.parts_id' => $s_parts_id]) : $conditions;
        $conditions = ($parts_for) ? array_merge($conditions, ['posts.parts_for' => $parts_for]) : $conditions;


        $conditions = ($specialist) ? array_merge($conditions, ['posts.specialism_id' => $specialist]) : $conditions;
        $conditions = ($repair_type) ? array_merge($conditions, ['posts.repair_type_id' => $repair_type]) : $conditions;
        $conditions = ($service) ? array_merge($conditions, ['posts.service_type' => $service]) : $conditions;


        $conditions = ($parts_description) ? array_merge($conditions, ['posts.parts_description' => $parts_description]) : $conditions;
        $conditions = ($category_id) ? array_merge($conditions, ['posts.category_id' => $category_id]) : $conditions;
        $conditions = ($wheelbase) ? array_merge($conditions, ['posts.alloywheels' => $wheelbase]) : $conditions;
        $conditions = ($seller) ? array_merge($conditions, ['posts.listing_type' => $seller]) : $conditions;


        // "lat" : 9.096838999999999,
        // "lng" : 7.4812937


        // Towing
        $conditions = ($towing_service_id) ? array_merge($conditions, ['towing_service_id' => $towing_service_id]) : $conditions;
        $conditions = ($type_of_service) ? array_merge($conditions, ['towing_type_of_service_id' => $type_of_service]) : $conditions;
        $conditions = ($vehicle_type) ? array_merge($conditions, ['vehicle_type' => $vehicle_type]) : $conditions;
        $conditions = ($availability) ? array_merge($conditions, ['availability' => $availability]) : $conditions;

        $condition_str = "posts.activation_date IS NOT NULL";


        if ($page_slug == 'spare-parts') {
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


        $lat = $this->input->get('lat'); //  32.7554883;             --- Fort+Worth,+TX,+United+States
        $lng = $this->input->get('lng');  // -97.33076579999999;     --- Fort+Worth,+TX,+United+States
        $checkAllState = $this->db->where('parent_id', 1111111111)->where('type', 'state')->get('post_area')->row();

        $checkAllLocation = $this->db->where('parent_id', $checkAllState->id)->where('type', 'location')->get('post_area')->row();

        if ($location_slug && !empty($location_array)) {
            $condition_str .= " AND (posts.location_id IN ($location_array) OR posts.location_id = '$checkAllState->id')";
        }

        if ($address && $address != $checkAllLocation->name) {

            $condition_str .= " AND (posts.location LIKE '%$prepared_address%' OR posts.location LIKE '%$checkAllLocation->name%')";
        }


        if ($page_slug == 'automech-search') {
            $conditions = array_merge($conditions, ['posts.post_type' => 'Automech']);
            if ($brand_slug && $brand->id != 2214) {
                $condition_str .= " AND (posts.brand_id = $brand->id OR posts.brand_id = '2214')";
            }
        } else if ($page_slug == 'towing-search') {
            $conditions = array_merge($conditions, ['posts.post_type' => 'Towing']);
        } else {
            $conditions = array_merge($conditions, ['posts.post_type' => 'import-car']);
            if ($brand_slug && $brand->id != 2214) {
                $condition_str .= " AND (posts.brand_id = $brand->id OR posts.brand_id = '2214')";
            }
        }



        if ($model_slug && $model->id != 2223) {
            $condition_str .= " AND (posts.model_id = $model->id OR posts.model_id = '2223')";
        }

        if (!empty($globalSearch)) {
            $condition_str .= " AND (posts.title LIKE '%$globalSearch%' OR posts.location LIKE '%$globalSearch%')";
        }

        $conditions = array_merge($conditions, ['posts.status' => 'Active', 'posts.expiry_date >=' => date('Y-m-d')]);

//    ----------------xxxxxxx-----All Condition Part End-----xxxxxxx---------------
//        pp($conditions);
//---------------- Getting Total Data--------------
        $this->db->where($conditions);
        $this->db->where($condition_str);
        $this->db->group_by('posts.id');
        $this->db->join('users', 'users.id = posts.user_id');
        $this->db->where('users.status', 'Active');
        $total = $this->db->get('posts')->num_rows();
//----------ending total data ----------------------

        $html = '';

//--------------- Start limit start target section --------------
        $limit = 30;
        $page = !empty(intval($this->input->get('page'))) ? $this->input->get('page') : 1;
        $start = startPointOfPagination($limit, $page);
        $target = $this->my_ajax_paination();
//--------------- End limit start target section --------------

//--------------- Start Before Featured Post Count ------------
        $featured_posts = [];
        if (GlobalHelper::array_element_not_empty($this->input->get(), 'condition') || !empty($brand_slug) || !empty($model_slug)){
            $section = GlobalHelper::array_element_not_empty($this->input->get(), 'condition') ? 'General' : (!empty($model_slug) ? 'Model' : 'Brand');
            $before_pages = $page - 1;
            if ($before_pages){
                $this->db->where($conditions);
                $this->db->where($condition_str);
                $this->db->where('posts.featured_page !=', 0);
                $this->db->where('posts.featured_page <=', $before_pages);
                $this->db->where('posts.featured_section', $section);
                $this->db->group_by('posts.id');
                $this->db->join('users', 'users.id = posts.user_id');
                $this->db->where('users.status', 'Active');
                $start =$start - $this->db->get('posts')->num_rows();
            }

            $this->db->from('posts');
            $this->db->select('IF(c.id IS NOT NULL, 1, 0) as is_financing');
            $this->db->select('posts.condition,  posts.location,  posts.pricein,  posts.priceindollar,  posts.priceinnaira,
             posts.mileage, posts.gear_box_type, posts.vehicle_type_id,  posts.id, posts.post_slug, posts.title
             , posts.featured_position');

            $this->db->join(
                'car_list as c',
                "c.vehicle_type = posts.vehicle_type_id AND
             (FIND_IN_SET(posts.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
            (FIND_IN_SET(posts.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= posts.manufacture_year AND
              c.to_year >= posts.manufacture_year AND
              (FIND_IN_SET(posts.condition,c.car_condition)) AND
              (FIND_IN_SET(posts.location_id,c.location_id)) AND
              (c.min_price <= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.max_price = 0) AND
              (c.seller_id IS NULL OR c.seller_id = '' OR find_in_set(posts.user_id, c.seller_id) <> 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan'
              ",
                'LEFT'
            );
            $this->db->order_by('posts.featured_position', 'ASC');
            $this->db->where($conditions);
            $this->db->where($condition_str);
            $this->db->where('posts.featured_page', $page);
            $this->db->where('posts.featured_section', $section);
            $this->db->group_by('posts.id');
            $this->db->join('users', 'users.id = posts.user_id');
            $this->db->where('users.status', 'Active');

            $featured_posts = $this->db->get()->result();
            $limit = $limit - count($featured_posts);
            // Adding Impression
            impression_increase(array_column($featured_posts, 'id'));
        }

//--------------- End Before Featured Post Count ------------

//--------------- start Order Related work --------------
        $sortP = $this->input->get('order_by');
        $order = $this->shortCase($this->input->get('order_by'));
        $order_column = $order['column'];
        $order_by = $order['order_by'];
//--------------- End Order Related work --------------

//--------------- start Taking data with limit offset --------------
        $this->db->from('posts');
        $this->db->select('IF(c.id IS NOT NULL, 1, 0) as is_financing');
        $this->db->select('posts.condition,  posts.location,  posts.pricein,  posts.priceindollar,  posts.priceinnaira,
             posts.mileage, posts.gear_box_type, posts.vehicle_type_id,  posts.id, posts.post_slug, posts.title
             , posts.featured_position');
        $this->db->join(
            'car_list as c',
            "c.vehicle_type = posts.vehicle_type_id AND
             (FIND_IN_SET(posts.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
            (FIND_IN_SET(posts.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= posts.manufacture_year AND
              c.to_year >= posts.manufacture_year AND
              (FIND_IN_SET(posts.condition,c.car_condition)) AND
              (FIND_IN_SET(posts.location_id,c.location_id)) AND
              (c.min_price <= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.max_price = 0) AND
              (c.seller_id IS NULL OR c.seller_id = '' OR find_in_set(posts.user_id, c.seller_id) <> 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan'
              ",
            'LEFT'
        );
        $this->db->order_by('posts.is_featured', 'DESC');
        $this->db->where($conditions);
        $this->db->where($condition_str);
        $this->db->where('posts.featured_page', 0);
        $this->db->group_by('posts.id');
        $this->db->join('users', 'users.id = posts.user_id');
        $this->db->where('users.status', 'Active');

        if (($sortP == "PriceASC" || $sortP == "PriceDESC") && $order_by == "DESC") {
//            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('posts.activation_date', 'DESC');
            $this->db->order_by('posts.priceinnaira', $order_by);
        } else if (($sortP == "PriceASC" || $sortP == "PriceDESC") && $order_by == "ASC") {
            $this->db->order_by('posts.priceinnaira', $order_by);
            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('posts.activation_date', 'DESC');
        } else {
            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('posts.id', 'DESC');
        }
        $this->db->limit($limit, $start);
        $results = $this->db->get()->result();
        impression_increase(array_column($results, 'id'));
        //pp($this->db->last_query());
//--------------- End Taking data with limit offset --------------

        $query_string = ''; //<pre>'. $this->db->last_query() . '</pre>';


        // $html .= $this->getFeaturedPost( $this->input->get('type_id') );
        $last_key = -1;
        for ($i = 0; $i <= 29; $i++){
            $featured_key = array_search($i+1, array_column($featured_posts, 'featured_position'));
            if (is_numeric($featured_key)){
                $html .= $this->_per_post_view($featured_posts[$featured_key]);
            } else {
                if ($last_key < 0 && isset($results[0])){
                    $html .= $this->_per_post_view($results[0]);
                    $last_key = 0;
                } else {
                    $last_key++;
                    if (isset($results[$last_key])){
                        $html .= $this->_per_post_view($results[$last_key]);
                    }
                }
            }
        }
//        foreach ($results as $post) {
//            $html .= $this->_per_post_view($post);
//        }

        $html .= getAjaxPaginator($total, $page, $target, $limit);

        if ($total == 0) {

            $brandName = !empty($brand) ? $brand->name : '';
            $modelName = !empty($model) ? $model->name : '';
            $html .=  '<div class="col-12"><div class="notfoundProductWrap">
                        <h2>The Product '.$brandName.' '.$modelName.' you are looking for is not
                                                                                    available at the moment </h2>
                        <form>
                            <input class="browser-default"  type="text" name="email" id="newsletter_email_temp" placeholder="please enter your email">
                            <button id="btn_subscribe_n" class="waves-effect" type="button">Subscribe</button>
                            <span id="newsletter-msg-t" class="text-danger text-center"></span>
                            <span id="msg-t" class="text-success text-center"></span>
                            <span><strong>Note:</strong> Please subscribe to be the first to know when the product becomes
            available </span>';


            $html .=  '<p>Do you have similar product for sale? Start to by <a href="admin/posts/create">listing</a> it for sale, buyers are waiting.</p>
                        </form>
                    </div></div>';
        }



        $data['query_string'] = $query_string;
        $data['html'] =  $html;
        $data['total'] =  $total;
        $data['vehicle_type_id'] = $type_id;
        $data['breads'] = ['Search'];

        if (!empty($brandName)){
            array_push($data['breads'], $brandName);
        }

        if (!empty($modelName)){
            array_push($data['breads'], $modelName);
        }

        $this->viewFrontContentNew( 'frontend/new/template/import_search', $data );

    }
    public function search_list($page_slug = null){
        $cms  = get_cms_with_dynamic_meta('search-vehicle', [
            'type' => ucfirst(str_replace('-', ' ', $page_slug))
        ]);


        $data['meta_title']         = $cms['meta_title'];
        $data['meta_description']   = getShortContent($cms['meta_description'], 120);
        $data['meta_keywords']      = $cms['meta_keywords'];

        // $page_slug == page slug as search, auction-car, van etc
        $page_slug = is_null($page_slug) ? $this->input->get('page_slug') : $page_slug;

        $location_slug = !empty($this->input->get('location')) ? explode(',', $this->input->get('location')) : [-1];
        $location_name = '';
        $location_array = [];

        $type = GlobalHelper::getTypeIdByPageSlug($page_slug); // for get method
        $type_id = ($type == 0) ? intval($this->input->get('type_id')) : intval($type);
        $brand_slug = $this->input->get('brand');
        $model_slug = $this->input->get('model');
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

        $specialist = intval($this->input->get('specialist'));
        $repair_type = intval($this->input->get('repair_type'));
        $service = $this->input->get('service');

        // Towing
        $towing_service_id = intval($this->input->get('towing_service_id'));
        $vehicle_type = intval($this->input->get('vehicle_type'));
        $type_of_service = $this->input->get('type_of_service');
        $availability = $this->input->get('availability');


        $category_id = intval($this->input->get('category_id'));
        $parts_description = intval($this->input->get('parts_description'));
        $wheelbase = intval($this->input->get('wheelbase'));
        $year = intval($this->input->get('year'));
        $from_year = intval($this->input->get('from_year'));
        $to_year = intval($this->input->get('to_year'));
        $seller = $this->input->get('seller');
        $address = $this->input->get('address');// Business or Private
        $conditions = ['expiry_date >=' => date('Y-m-d'),'post_type'=>'General'];


        //
        $brand = $this->db->from('brands')->where('slug', $brand_slug)->get()->row();
        $model = $this->db->from('brands')->where('slug', $model_slug)->get()->row();
        $locPar = $this->db->where_in('slug', $location_slug)->where('type', 'state')->get('post_area')->result();
        $prepared_address = ucfirst(str_replace('-', ' ', $address?$address:''));

        if (!empty($locPar)){
            $location_name = implode(', ', array_column($locPar, 'name'));
            $location_array = implode(',',array_column($locPar, 'id'));

        }


        $get_array = array_filter($this->input->get());
        if (!empty($page_slug)) $get_array['type'] = ucfirst(str_replace('-', ' ', $page_slug));
        if (!empty($location_slug) && !empty($location_array)) $get_array['location_name'] = $location_name;
        if (!empty($address)) $get_array['address'] = $address;
        if (!empty($brand_slug) && !empty($brand)) $get_array['brand_name'] = $brand->name;
        if (!empty($model_slug) && !empty($model)) $get_array['model_name'] = $model->name;
        if (!empty($body_type)){
            $body = $this->db->from('body_types')->where('id', $body_type)->get()->row();
            if (!empty($body)) $get_array['body_name'] = $body->type_name;
        }
        if (!empty($fuel_type)){
            $fuel = $this->db->from('fuel_types')->where('id', $fuel_type)->get()->row();
            if (!empty($fuel)) $get_array['fuel_name'] = $fuel->fuel_name;
        }
        if (!empty($engine_size)){
            $engine = $this->db->from('engine_sizes')->where('id', $engine_size)->get()->row();
            if (!empty($engine)) $get_array['engine_name'] = $engine->engine_size;
        }
        if (!empty($color)){
            $c = $this->db->from('color')->where('id', $color)->get()->row();
            if (!empty($c)) $get_array['color_name'] = $c->color_name;
        }
        if (!empty($category_id)){
            $category = $this->db->from('parts_categories')->where('id', $category_id)->get()->row();
            if ($category) $get_array['parts_category'] = $category->category;
        }

        if (!empty($this->input->get())) {
            $this->db->select('title, var');
            foreach (array_keys(array_filter($this->input->get())) as $k => $v) {
                if (!in_array($v, ['page', 'order_by'])) $this->db->where($v, 1);
            }
            $meta_title = $this->db->get('meta_title')->row();
            $data['meta_title'] = '';
            if (!empty($meta_title)) {
                $var_array = explode(',', $meta_title->var);
                foreach ($var_array as $d => $k) {
                    $meta_title->title = str_replace('%' . $k . '%', !empty($get_array[$k]) ? $get_array[$k] : '', $meta_title->title);
                }
                $data['meta_title'] = $meta_title->title;
            }
        }

//        $conditions = ($location_slug) ? array_merge($conditions, ['location_id' => $location_slug]) : $conditions;
        // brand id will change with page slug
        // $conditions = ($$brand_slug)       ? array_merge($conditions, ['brand_id' => $$brand_slug]) : $conditions;
        $conditions = ($type_id) ? array_merge($conditions, ['posts.vehicle_type_id' => $type_id]) : $conditions;
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

        $conditions = ($from_year) ? array_merge($conditions, ['posts.manufacture_year >=' => $from_year]) : $conditions;


        $conditions = ($parts_id) ? array_merge($conditions, ['posts.parts_description' => $parts_id]) : $conditions;
        $conditions = ($s_parts_id) ? array_merge($conditions, ['posts.parts_id' => $s_parts_id]) : $conditions;
        $conditions = ($parts_for) ? array_merge($conditions, ['posts.parts_for' => $parts_for]) : $conditions;


        $conditions = ($specialist) ? array_merge($conditions, ['posts.specialism_id' => $specialist]) : $conditions;
        $conditions = ($repair_type) ? array_merge($conditions, ['posts.repair_type_id' => $repair_type]) : $conditions;
        $conditions = ($service) ? array_merge($conditions, ['posts.service_type' => $service]) : $conditions;


        $conditions = ($parts_description) ? array_merge($conditions, ['posts.parts_description' => $parts_description]) : $conditions;
        $conditions = ($category_id) ? array_merge($conditions, ['posts.category_id' => $category_id]) : $conditions;
        $conditions = ($wheelbase) ? array_merge($conditions, ['posts.alloywheels' => $wheelbase]) : $conditions;
        $conditions = ($seller) ? array_merge($conditions, ['posts.listing_type' => $seller]) : $conditions;


        // "lat" : 9.096838999999999,
        // "lng" : 7.4812937


        // Towing
        $conditions = ($towing_service_id) ? array_merge($conditions, ['towing_service_id' => $towing_service_id]) : $conditions;
        $conditions = ($type_of_service) ? array_merge($conditions, ['towing_type_of_service_id' => $type_of_service]) : $conditions;
        $conditions = ($vehicle_type) ? array_merge($conditions, ['vehicle_type' => $vehicle_type]) : $conditions;
        $conditions = ($availability) ? array_merge($conditions, ['availability' => $availability]) : $conditions;

        $condition_str = "posts.activation_date IS NOT NULL";

        if ($vehicle_type === 'spare-parts') {
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

        $lat = $this->input->get('lat'); //  32.7554883;             --- Fort+Worth,+TX,+United+States
        $lng = $this->input->get('lng');  // -97.33076579999999;     --- Fort+Worth,+TX,+United+States
        $checkAllState = $this->db->where('parent_id', 1111111111)->where('type', 'state')->get('post_area')->row();

        $checkAllLocation = $this->db->where('parent_id', $checkAllState->id)->where('type', 'location')->get('post_area')->row();

        if ($location_slug && !empty($location_array)) {
            $condition_str .= " AND (posts.location_id IN ($location_array) OR posts.location_id = '$checkAllState->id')";
        }

            if ($address && $address != $checkAllLocation->name) {

                $condition_str .= " AND (posts.location LIKE '%$prepared_address%' OR posts.location LIKE '%$checkAllLocation->name%')";
            }


        if ($page_slug == 'automech-search') {
            $conditions = array_merge($conditions, ['posts.post_type' => 'Automech']);
            if ($brand_slug && $brand->id != 2214) {
                $condition_str .= " AND (posts.brand_id = $brand->id OR posts.brand_id = '2214')";
            }
        } else if ($page_slug == 'towing-search') {
            $conditions = array_merge($conditions, ['posts.post_type' => 'Towing']);
        } else {
            $conditions = array_merge($conditions, ['posts.post_type' => 'General']);
            if ($brand_slug && $brand->id != 2214) {
                $condition_str .= " AND (posts.brand_id = $brand->id OR posts.brand_id = '2214')";
            }
        }



        if ($model_slug && $model->id != 2223) {
            $condition_str .= " AND (posts.model_id = $model->id OR posts.model_id = '2223')";
        }

        if (!empty($globalSearch)) {
            $condition_str .= " AND (posts.title LIKE '%$globalSearch%' OR posts.location LIKE '%$globalSearch%')";
        }

        $conditions = array_merge($conditions, ['posts.status' => 'Active', 'posts.expiry_date >=' => date('Y-m-d')]);

//    ----------------xxxxxxx-----All Condition Part End-----xxxxxxx---------------

//---------------- Getting Total Data--------------
        $this->db->where($conditions);
        $this->db->where($condition_str);
        $this->db->group_by('posts.id');
        $this->db->join('users', 'users.id = posts.user_id');
        $this->db->where('users.status', 'Active');
        $total = $this->db->get('posts')->num_rows();
//----------ending total data ----------------------

        $html = '';

//--------------- Start limit start target section --------------
        $limit = 30;
        $page = !empty(intval($this->input->get('page'))) ? $this->input->get('page') : 1;
        $start = startPointOfPagination($limit, $page);
        $target = $this->my_ajax_paination();
//--------------- End limit start target section --------------

//--------------- Start Before Featured Post Count ------------
        $featured_posts = [];
        if (GlobalHelper::array_element_not_empty($this->input->get(), 'condition') || !empty($brand_slug) || !empty($model_slug)){
            $section = GlobalHelper::array_element_not_empty($this->input->get(), 'condition') ? 'General' : (!empty($model_slug) ? 'Model' : 'Brand');
            $before_pages = $page - 1;
            if ($before_pages){
                $this->db->where($conditions);
                $this->db->where($condition_str);
                $this->db->where('posts.featured_page !=', 0);
                $this->db->where('posts.featured_page <=', $before_pages);
                $this->db->where('posts.featured_section', $section);
                $this->db->group_by('posts.id');
                $this->db->join('users', 'users.id = posts.user_id');
                $this->db->where('users.status', 'Active');
                $start =$start - $this->db->get('posts')->num_rows();
            }

            $this->db->from('posts');
            $this->db->select('IF(c.id IS NOT NULL, 1, 0) as is_financing');
            $this->db->select('posts.condition,  posts.location,  posts.pricein,  posts.priceindollar,  posts.priceinnaira,
             posts.mileage, posts.gear_box_type, posts.vehicle_type_id,  posts.id, posts.post_slug, posts.title
             , posts.featured_position');



            $this->db->join(
                'car_list as c',
                "c.vehicle_type = posts.vehicle_type_id AND
              (FIND_IN_SET(posts.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
              (FIND_IN_SET(posts.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= posts.manufacture_year AND
              c.to_year >= posts.manufacture_year AND
              (FIND_IN_SET(posts.condition,c.car_condition)) AND
              (FIND_IN_SET(posts.location_id,c.location_id)) AND
              (c.min_price <= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.max_price = 0) AND
              (c.seller_id IS NULL OR c.seller_id = '' OR find_in_set(posts.user_id, c.seller_id) <> 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan'
              ",
                'LEFT'
            );

            $this->db->order_by('posts.featured_position', 'ASC');
            $this->db->where($conditions);
            $this->db->where($condition_str);
            $this->db->where('posts.featured_page', $page);
            $this->db->where('posts.featured_section', $section);
            $this->db->join('users', 'users.id = posts.user_id');
            $this->db->where('users.status', 'Active');
            $this->db->group_by('posts.id');

            $featured_posts = $this->db->get()->result();
            $limit = $limit - count($featured_posts);
            // Adding Impression
            impression_increase(array_column($featured_posts, 'id'));
        }

//--------------- End Before Featured Post Count ------------

//--------------- start Order Related work --------------
        $sortP = $this->input->get('order_by');
        $order = $this->shortCase($this->input->get('order_by'));
        $order_column = $order['column'];
        $order_by = $order['order_by'];
//--------------- End Order Related work --------------

//--------------- start Taking data with limit offset --------------
        $this->db->from('posts');
        $this->db->select('IF(c.id IS NOT NULL, 1, 0) as is_financing');
        $this->db->select('posts.condition,  posts.location,  posts.pricein,  posts.priceindollar,  posts.priceinnaira,
             posts.mileage, posts.gear_box_type, posts.vehicle_type_id,  posts.id, posts.post_slug, posts.title
             , posts.featured_position, um.meta_value as is_verified, posts.user_id');
        $this->db->join(
            'car_list as c',
            "c.vehicle_type = posts.vehicle_type_id AND
              (FIND_IN_SET(posts.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
              (FIND_IN_SET(posts.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= posts.manufacture_year AND
              c.to_year >= posts.manufacture_year AND
              (FIND_IN_SET(posts.condition,c.car_condition) OR FIND_IN_SET('All',c.car_condition)) AND
              (FIND_IN_SET(posts.location_id,c.location_id) OR FIND_IN_SET('41',c.location_id)) AND
              (c.min_price <= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(posts.pricein = 'USD', posts.priceindollar, posts.priceinnaira) OR c.max_price = 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan' AND 
              (c.seller_id = '' OR c.seller_id IS NULL OR FIND_IN_SET(posts.user_id, c.seller_id) <> 0 OR FIND_IN_SET('0', c.seller_id) <> 0)
              ",
            'LEFT'
        );
        $this->db->order_by('posts.is_featured', 'DESC');
        $this->db->where($conditions);
        $this->db->where($condition_str);
        $this->db->where('posts.featured_page', 0);
        $this->db->join('users', 'users.id = posts.user_id');
        $this->db->join('user_meta as um', 'users.id = um.user_id and um.meta_key = "seller_tag"', 'left');
        $this->db->where('users.status', 'Active');
        $this->db->group_by('posts.id');

        if (($sortP == "PriceASC" || $sortP == "PriceDESC") && $order_by == "DESC") {
//            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('posts.activation_date', 'DESC');
            $this->db->order_by('posts.priceinnaira', $order_by);
        } else if (($sortP == "PriceASC" || $sortP == "PriceDESC") && $order_by == "ASC") {
            $this->db->order_by('posts.priceinnaira', $order_by);
            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('posts.activation_date', 'DESC');
        } else {
            $this->db->order_by($order_column, $order_by);
            $this->db->order_by('posts.id', 'DESC');
        }
        $this->db->limit($limit, $start);
        $results = $this->db->get()->result();
        impression_increase(array_column($results, 'id'));
        //pp($this->db->last_query());
//--------------- End Taking data with limit offset --------------


        $query_string = ''; //<pre>'. $this->db->last_query() . '</pre>';


        // $html .= $this->getFeaturedPost( $this->input->get('type_id') );
    $last_key = -1;
        for ($i = 0; $i <= 29; $i++){
            $featured_key = array_search($i+1, array_column($featured_posts, 'featured_position'));
            if (is_numeric($featured_key)){
                $html .= $this->_per_post_view($featured_posts[$featured_key]);
            } else {
                if ($last_key < 0 && isset($results[0])){
                    $html .= $this->_per_post_view($results[0]);
                    $last_key = 0;
                } else {
                    $last_key++;
                    if (isset($results[$last_key])){
                        $html .= $this->_per_post_view($results[$last_key]);
                    }
                }
            }
        }
//        foreach ($results as $post) {
//            $html .= $this->_per_post_view($post);
//        }

        $html .= getAjaxPaginator($total, $page, $target, $limit);

        if ($total == 0) {

            $brandName = !empty($brand) ? $brand->name : '';
            $modelName = !empty($model) ? $model->name : '';
            $html .=  '<div class="col-12"><div class="notfoundProductWrap">
                        <h2>The Product '.$brandName.' '.$modelName.' you are looking for is not
                                                                                    available at the moment </h2>
                        <form>
                            <input class="browser-default" type="text" name="email" id="newsletter_email_temp" placeholder="please enter your email">
                            <button id="btn_subscribe_n" class="waves-effect" type="button">Subscribe</button>
                            <span id="newsletter-msg-t" class="text-danger text-center"></span>
                            <span id="msg-t" class="text-success text-center"></span>
                            <span><strong>Note:</strong> Please subscribe to be the first to know when the product becomes
            available </span>';


            $html .=  '<p>Do you have similar product for sale? Start to by <a href="admin/posts/create">listing</a> it for sale, buyers are waiting.</p>
                        </form>
                    </div></div>';
        }



            $data['query_string'] = $query_string;
            $data['html'] =  $html;
            $data['total'] =  $total;
            $data['vehicle_type_id'] = $type_id;
            $data['breads'] = ['Search'];

            if (!empty($brandName)){
                array_push($data['breads'], $brandName);
            }

            if (!empty($modelName)){
                array_push($data['breads'], $modelName);
            }

        $this->viewFrontContentNew( 'frontend/new/template/search', $data );

}
    /**
     * @param $post_id
     * @return mixed
     * Delete Method request
     */
    function api_delete_product($post_id){
        // checking request method
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            return apiResponse([
                'status' => false,
                'message' => 'Method not allowed',
                'data' => null
            ]);
        }
    // retrive token
        $token = $this->input->server('HTTP_TOKEN');
        // check token and if exist taking user data. if not sending msg to clint
        if ($token) {
            $u = $this->db->get_where('user_tokens', ['token' => $token])->row();
        } else {
            return apiResponse([
                'status' => false,
                'message' => 'Invalid Request',
                'data' => null
            ]);
        }
        // indentify user id
        $user_id = ($u) ? $u->user_id : 0;
        // if user id empty
        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }
        // taking post info
        $post = $this->db->where('id', $post_id)->get('posts')->row();
        // check post is exist
        if (empty($post)){
            return apiResponse([
                'status' => false,
                'message' => 'Product Not Found',
                'data' => null
            ]);
        }
        // is this post his/her
        if ($user_id != $post->user_id){
            return apiResponse([
                'status' => false,
                'message' => 'Access Deny',
                'data' => null
            ]);
        }
        // taking all photo this photo related
        $photos = $this->db->get_where('post_photos', ['post_id' => $post_id])
            ->result();
        // removing photo one by one
        foreach ($photos as $photo) {
            $fileName   = $photo->photo;
            $filePath   = dirname(BASEPATH) . '/uploads/car/' . $fileName;
            if ($fileName && file_exists($filePath)) {
                @unlink($filePath);
            }
        }
        // removing photos path from photos table
        $this->db->where('post_id', $post_id )->delete('post_photos');
        //removing post from post table
        $this->db->where('id', $post_id)->delete('posts');
        // finally sending the desire result
        return apiResponse([
            'status' => true,
            'message' => 'The Product is Deleted',
            'data' => null
        ]);
    }

    public function buy($page_slug){

        $data = [];
        $vehicle_type_id = 0;
        if ($page_slug == 'car'){
            $vehicle_type_id = 1;
        } elseif ($page_slug == 'motorbike'){
            $vehicle_type_id = 3;
        } elseif ($page_slug == 'spare-parts'){
            $vehicle_type_id = 4;
        } else {
            $this->viewFrontContentNew( 'frontend/404');
            return false;

        }
        $data['vehicle_type_id'] = $vehicle_type_id;
        $this->db->select('p.condition, p.location, p.pricein, p.priceindollar, p.priceinnaira, p.mileage, p.gear_box_type, p.vehicle_type_id, p.id, p.post_slug, p.title, um.meta_value as is_verified, p.user_id');
        $this->db->select('pa.name as state_name, IF(c.id IS NOT NULL, 1, 0) as is_financing');
        $this->db->from('posts as p');
        $this->db->join('post_area as pa', "pa.id = p.location_id AND pa.type = 'state'");
        $this->db->join('users', 'users.id = p.user_id');
        $this->db->join('user_meta as um', 'users.id = um.user_id and um.meta_key = "seller_tag"', 'left');
        $this->db->join(
            'car_list as c',
            "c.vehicle_type = p.vehicle_type_id AND
              (FIND_IN_SET(p.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
              (FIND_IN_SET(p.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= p.manufacture_year AND
              c.to_year >= p.manufacture_year AND
              (FIND_IN_SET(p.condition,c.car_condition) OR FIND_IN_SET('All',c.car_condition)) AND
              (FIND_IN_SET(p.location_id,c.location_id) OR FIND_IN_SET('41',c.location_id)) AND
              (c.min_price <= IF(p.pricein = 'USD', p.priceindollar, p.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(p.pricein = 'USD', p.priceindollar, p.priceinnaira) OR c.max_price = 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan' AND 
              (c.seller_id = '' OR c.seller_id IS NULL OR FIND_IN_SET(p.user_id, c.seller_id) <> 0 OR FIND_IN_SET('0', c.seller_id) <> 0)
              ",
            'LEFT'
        );
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        $this->db->where('users.status', 'Active');
        $this->db->where('p.post_type', 'General');
        $this->db->where('p.vehicle_type_id', $vehicle_type_id);
        $this->db->order_by('p.hit', 'DESC');
        $this->db->limit(8);
        $this->db->group_by('p.id');


        $data['trending'] = $this->db->get()->result();

// adding impression
        impression_increase(array_map(function($o) {
            return is_object($o) ? $o->id : $o['id'];
        }, $data['trending']));


        $this->db->select('p.condition, p.location, p.pricein, p.priceindollar, p.priceinnaira, p.mileage, p.gear_box_type, p.vehicle_type_id, p.id, p.post_slug, p.title, um.meta_value as is_verified, p.user_id');
        $this->db->select('pa.name as state_name, IF(c.id IS NOT NULL, 1, 0) as is_financing');
        $this->db->from('posts as p');
        $this->db->join('post_area as pa', "pa.id = p.location_id AND pa.type = 'state'");
        $this->db->join(
            'car_list as c',
            "c.vehicle_type = p.vehicle_type_id AND
             (FIND_IN_SET(p.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
              (FIND_IN_SET(p.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= p.manufacture_year AND
              c.to_year >= p.manufacture_year AND
              (FIND_IN_SET(p.condition,c.car_condition) OR FIND_IN_SET('All',c.car_condition)) AND
              (FIND_IN_SET(p.location_id,c.location_id) OR FIND_IN_SET('41',c.location_id)) AND
              (c.min_price <= IF(p.pricein = 'USD', p.priceindollar, p.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(p.pricein = 'USD', p.priceindollar, p.priceinnaira) OR c.max_price = 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan' AND
              (c.seller_id = '' OR c.seller_id IS NULL OR FIND_IN_SET(p.user_id, c.seller_id) <> 0 OR FIND_IN_SET('0', c.seller_id) <> 0)
              ",
            'LEFT'
        );
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        $this->db->where('p.post_type', 'General');
        $this->db->where('p.vehicle_type_id', $vehicle_type_id);
        $this->db->order_by('p.activation_date', 'DESC');
        $this->db->join('users', 'users.id = p.user_id');
        $this->db->join('user_meta as um', 'users.id = um.user_id and um.meta_key = "seller_tag"', 'left');
        $this->db->where('users.status', 'Active');
        $this->db->limit(8);
        $this->db->group_by('p.id');

        $data['latest'] = $this->db->get()->result();
        impression_increase(array_map(function($o) {
            return is_object($o) ? $o->id : $o['id'];
        }, $data['latest']));

        $temp = getCmsPage('buy-'.$page_slug);
        if (!empty($temp)) {
            $data = array_merge($data, array(
                'meta_title' => $temp['meta_title'],
                'meta_description' => $temp['meta_description'],
                'meta_keywords' => $temp['meta_keywords'],
            ));
        }
//        pp($data);

        $this->viewFrontContentNew( 'frontend/new/template/buy', $data );
    }

    public function import_buy($page_slug){
        $data = [];
        $vehicle_type_id = 0;
        if ($page_slug == 'car'){
            $vehicle_type_id = 1;
        } elseif ($page_slug == 'motorbike'){
            $vehicle_type_id = 3;
        } elseif ($page_slug == 'spare-parts'){
            $vehicle_type_id = 4;
        } else {
            $this->viewFrontContentNew( 'frontend/404');
            return false;

        }
        $data['vehicle_type_id'] = $vehicle_type_id;
        $this->db->select('p.condition, p.location, p.pricein, p.priceindollar, p.priceinnaira, p.mileage, p.gear_box_type, p.vehicle_type_id, p.id, p.post_slug, p.title');
        $this->db->select('pa.name as state_name');
        $this->db->from('posts as p');
        $this->db->join('post_area as pa', "pa.id = p.location_id AND pa.type = 'state'");
        $this->db->join('users', 'users.id = p.user_id');
        $this->db->where('users.status', 'Active');
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        $this->db->where('p.post_type', 'import-car');
        $this->db->where('p.vehicle_type_id', $vehicle_type_id);
        $this->db->order_by('p.hit', 'DESC');
        $this->db->limit(8);
        $this->db->group_by('p.id');

        $data['trending'] = $this->db->get()->result();
// adding impression
        impression_increase(array_map(function($o) {
            return is_object($o) ? $o->id : $o['id'];
        }, $data['trending']));


        $this->db->select('p.condition, p.location, p.pricein, p.priceindollar, p.priceinnaira, p.mileage, p.gear_box_type, p.vehicle_type_id, p.id, p.post_slug, p.title');
        $this->db->select('pa.name as state_name');
        $this->db->from('posts as p');
        $this->db->join('post_area as pa', "pa.id = p.location_id AND pa.type = 'state'");
        $this->db->join('users', 'users.id = p.user_id');
        $this->db->where('users.status', 'Active');
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        $this->db->where('p.post_type', 'import-car');
        $this->db->where('p.vehicle_type_id', $vehicle_type_id);
        $this->db->order_by('p.id', 'DESC');
        $this->db->limit(8);
        $this->db->group_by('p.id');

        $data['latest'] = $this->db->get()->result();
        impression_increase(array_map(function($o) {
            return is_object($o) ? $o->id : $o['id'];
        }, $data['latest']));

        $temp = getCmsPage('buy-import-'.$page_slug);
        if (!empty($temp)) {
            $data = array_merge($data, array(
                'meta_title' => $temp['meta_title'],
                'meta_description' => $temp['meta_description'],
                'meta_keywords' => $temp['meta_keywords'],
            ));
        }

        $this->viewFrontContentNew( 'frontend/new/template/import_buy', $data );
    }


    public function likeOrUnlike(){
        $post_id = $this->input->post('post_id');
        $user_id = $this->input->post('user_id');
        $type = empty($this->input->post('type')) ? 'post' : $this->input->post('type');
        $msg = '';

        $exit = $this->db->get_where('post_likes', ['post_id' => $post_id, 'user_id' => $user_id])->num_rows();
        if (!empty($exit)){
            $this->db->where(['post_id' => $post_id, 'user_id' => $user_id]);
            $this->db->delete('post_likes');
            $msg = 'You give Unlike Successfully ';
        } else {
            $data = [
                'post_id' => $post_id,
                'user_id' => $user_id,
                'type' => $type,
                'created' => date('Y-m-d')
            ];
            $this->db->insert('post_likes', $data);
            $msg = 'You give Like Successfully ';
        }

        echo json_encode(['status' => 'success', 'msg' => $msg]);die();
    }


    public function favourite($type = 'car'){

        $vehicle_type_id = 0;
        if ($type == 'car'){
            $vehicle_type_id = 1;
        } elseif ($type == 'motorbike'){
            $vehicle_type_id = 3;
        } elseif ($type == 'spare-parts'){
            $vehicle_type_id = 4;
        } else {
            $this->viewFrontContentNew( 'frontend/404');
            return false;

        }

        $logged_user = getLoginUserData('user_id');
        $limit = 10;
        $page = !empty(intval($this->input->get('page'))) ? $this->input->get('page') : 1;
        $start = startPointOfPagination($limit, $page);
        $target = $this->my_ajax_paination();

        $this->db->select('p.condition, p.location, p.pricein, p.priceindollar, p.priceinnaira, p.mileage, p.gear_box_type, p.vehicle_type_id, p.id, p.post_slug, p.title, p.manufacture_year');
        $this->db->select('pa.name as state_name, IF(c.id IS NOT NULL, 1, 0) as is_financing');
        $this->db->from('posts as p');
        $this->db->join('post_area as pa', "pa.id = p.location_id AND pa.type = 'state'");
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
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        $this->db->where('post_likes.user_id', $logged_user);
        $this->db->where('p.vehicle_type_id', $vehicle_type_id);
        $this->db->order_by('p.id', 'DESC');
        $this->db->group_by('p.id');

        $count = $this->db->count_all_results('', FALSE);

        $this->db->limit($limit, $start);
        $data_posts = $this->db->get()->result();


        impression_increase(array_map(function($o) {
            return is_object($o) ? $o->id : $o['id'];
        }, $data_posts));

        $temp = getCmsPage('favourite');

        $data = array(
            'cms' => $temp['cms'],
            'meta_title' => $temp['meta_title'].' '.$type,
            'meta_description' => $temp['meta_description'].' '.$type,
            'meta_keywords' => $temp['meta_keywords'].' '.$type,
            'pagination' => getAjaxPaginator($count, $page, $target, $limit),
            'data_posts' => $data_posts,
            'breads' => [
                'Favourite'
            ]
        );
        $this->viewFrontContentNew( 'frontend/new/template/favourite', $data );
    }

    function product($tag_slug){
        $tag = $this->db->get_where('product_tags', ['slug' => $tag_slug])->row();
        if (empty($tag)){
            $this->viewFrontContentNew( 'frontend/404' );
            return false;
        }
        $limit = 10;
        $page = !empty(intval($this->input->get('page'))) ? $this->input->get('page') : 1;
        $start = startPointOfPagination($limit, $page);
        $target = $this->my_ajax_paination();

        $this->db->select('p.condition, p.location, p.pricein, p.priceindollar, p.priceinnaira, p.mileage, p.gear_box_type, p.vehicle_type_id, p.id, p.post_slug, p.title, p.manufacture_year');
        $this->db->select('pa.name as state_name, IF(c.id IS NOT NULL, 1, 0) as is_financing');
        $this->db->from('posts as p');
        $this->db->join('post_area as pa', "pa.id = p.location_id AND pa.type = 'state'");
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
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        $this->db->where('p.tag_id', $tag->id);
        $this->db->order_by('p.id', 'DESC');
        $this->db->group_by('p.id');

        $count = $this->db->count_all_results('', FALSE);

        $this->db->limit($limit, $start);
        $data_posts = $this->db->get()->result();


        impression_increase(array_map(function($o) {
            return is_object($o) ? $o->id : $o['id'];
        }, $data_posts));
        $html = '';

        foreach ($data_posts as $post){
            $html .= $this->_per_post_view($post);
        }

        $html .= getAjaxPaginator($count, $page, $target, $limit);

        $data = array(
            'meta_title' => $tag->meta_title,
            'meta_description' => $tag->meta_description,
            'html' => $html,
            'total' => $count,
            'breads' => [
                $tag->name
            ]
        );

        $this->viewFrontContentNew( 'frontend/new/template/product', $data );
    }
}
