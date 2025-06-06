<?php

/**
 * Description of Posts_frontview
 *
 * @author Kanny
 */
class Posts_frontview extends Frontend_controller {

    //put your code here    
    function __construct() {
        parent::__construct();
        $this->load->model('Posts_model');
        $this->load->helper('posts');
    }
    


    public function _rules(){
        $this->form_validation->set_rules('senderEmail', 'Sender email', 'trim|required|valid_email');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        $this->form_validation->set_rules('senderName', 'Name', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
	

    public function getPosts( $page_slug = null ) {        
        
      

        // $page_slug == page slug as search, auction-car, van etc
        $page_slug      = is_null($page_slug) ? $this->input->get('page_slug') : $page_slug;
        $location_id    = intval($this->input->get('location_id'));        
        $type           = GlobalHelper::getTypeIdByPageSlug( $page_slug ); // for get method 
        $type_id        = ($type == 0) ? intval($this->input->get('type_id')) : intval($type);	
        $brand_id       = intval($this->input->get('brand_id'));
        $model_id       = intval($this->input->get('model_id'));
        $body_type      = intval($this->input->get('body_type'));
        $age_from       = intval($this->input->get('age_from'));
        $age_to         = intval($this->input->get('age_to'));
        $price_from     = intval($this->input->get('price_from'));
        $price_to       = intval($this->input->get('price_to'));
        $mileage_from   = intval($this->input->get('mileage_from'));
        $mileage_to     = intval($this->input->get('mileage_to'));
        $condition      = $this->input->get('condition');       // product condition new, used
        $fuel_type      = intval($this->input->get('fuel_type'));
        $engine_size    = intval($this->input->get('engine_size'));
        $gear_box       = intval($this->input->get('gear_box'));
        $seats          = intval($this->input->get('seats'));
        $color          = intval($this->input->get('color_id'));
        $parts_id       = intval($this->input->get('parts_id'));
        $parts_for       = intval($this->input->get('parts_for'));
        
        
        $specialist       = intval($this->input->get('specialist'));
        $repair_type       = intval($this->input->get('repair_type'));       
        $service     = $this->input->get('service');
        
        $category_id    = intval($this->input->get('category_id'));
        $parts_description    = intval($this->input->get('parts_description'));
        $wheelbase      = intval($this->input->get('wheelbase'));        
        $year           = intval($this->input->get('year'));        
        $seller         = $this->input->get('seller');             // Business or Private
        $conditions = ['expiry_date >=' => date('Y-m-d')];
                
        $conditions = ($location_id)    ? array_merge($conditions, ['location_id' => $location_id]) : $conditions;
        // brand id will change with page slug
        // $conditions = ($brand_id)       ? array_merge($conditions, ['brand_id' => $brand_id]) : $conditions;
        $conditions = ($model_id)       ? array_merge($conditions, ['model_id' => $model_id]) : $conditions;
        $conditions = ($type_id)        ? array_merge($conditions, ['vehicle_type_id' => $type_id]) : $conditions;
        $conditions = ($body_type)      ? array_merge($conditions, ['body_type' => $body_type]) : $conditions;
        $conditions = ($age_from)       ? array_merge($conditions, ['car_age >=' => $age_from]) : $conditions;
        $conditions = ($age_to)         ? array_merge($conditions, ['car_age <=' => $age_to]) : $conditions;
        $conditions = ($price_from)     ? array_merge($conditions, ['priceinnaira >=' => $price_from]) : $conditions;
        $conditions = ($price_to)       ? array_merge($conditions, ['priceinnaira <=' => $price_to]) : $conditions;
        $conditions = ($mileage_from)   ? array_merge($conditions, ['mileage >=' => $mileage_from]) : $conditions;
        $conditions = ($mileage_to)     ? array_merge($conditions, ['mileage <=' => $mileage_to]) : $conditions;
        $conditions = ($condition)      ? array_merge($conditions, ['condition' => $condition]) : $conditions;
        
       $conditions     = ($fuel_type)   ? array_merge($conditions, ['fuel_id' => $fuel_type]) : $conditions;
       $conditions     = ($engine_size) ? array_merge($conditions, ['enginesize_id' => $engine_size]) : $conditions;
       $conditions     = ($gear_box)    ? array_merge($conditions, ['gear_box_type' => $gear_box]) : $conditions;
       $conditions     = ($seats)       ? array_merge($conditions, ['seats' => $seats]) : $conditions;
       $conditions     = ($color)       ? array_merge($conditions, ['color' => $color]) : $conditions;
       $conditions     = ($year)        ? array_merge($conditions, ['manufacture_year' => $year]) : $conditions;
       $conditions     = ($parts_id)    ? array_merge($conditions, ['parts_description' => $parts_id]) : $conditions;
       $conditions     = ($parts_for)    ? array_merge($conditions, ['parts_for' => $parts_for]) : $conditions;
       
       
       $conditions     = ($specialist)    ? array_merge($conditions, ['specialism_id' => $specialist]) : $conditions;
       $conditions     = ($repair_type)    ? array_merge($conditions, ['repair_type_id' => $repair_type]) : $conditions;
       $conditions     = ($service)    ? array_merge($conditions, ['service_type' => $service]) : $conditions;
                 
           
       
       $conditions     = ($parts_description)    ? array_merge($conditions, ['parts_description' => $parts_description]) : $conditions;
       $conditions     = ($category_id)    ? array_merge($conditions, ['category_id' => $category_id]) : $conditions;
       $conditions     = ($wheelbase)   ? array_merge($conditions, ['alloywheels' => $wheelbase]) : $conditions;
       $conditions     = ($seller)      ? array_merge($conditions, ['listing_type' => $seller]) : $conditions;
                       
       // "lat" : 9.096838999999999,
       // "lng" : 7.4812937
        

        $address    = $this->input->get('address');
        $lat        = $this->input->get('lat'); //  32.7554883;             --- Fort+Worth,+TX,+United+States
        $lng        = $this->input->get('lng');  // -97.33076579999999;     --- Fort+Worth,+TX,+United+States
        
        
        //$this->db->from();
        if($lat && $lng){ 
            $sql_str = '( 3959 * acos( cos( radians( '.  $lat .') ) * cos( radians( lat ) ) 
                    * cos( radians( lng ) - radians('. $lng .') ) + sin( radians('.  $lat .') ) 
                    * sin( radians( lat ) ) ) ) AS Radius';

            if( $page_slug == 'automech-search') {
            $this->db->select('brand_meta.brand, posts.*, '. $sql_str );
            } else {
                $this->db->select('posts.*, '. $sql_str );
            }
            
            $this->db->having('Radius <=', 100 );
       
        }      
        
        if( $page_slug == 'automech-search') {
            $this->db->join('brand_meta', 'brand_meta.post_id = posts.id', 'LEFT');
            $conditions = ($brand_id)       ? array_merge($conditions, ['brand_meta.brand' => $brand_id]) : $conditions;
             $this->db->where('posts.post_type', 'Automech');
        } else {
            $this->db->where('posts.post_type', 'General');
            $conditions = ($brand_id)       ? array_merge($conditions, ['brand_id' => $brand_id]) : $conditions;
        }
        
       $this->db->where($conditions);
       $this->db->group_by('posts.id');
       $this->db->where('posts.status', 'Active');
      
       $total = $this->db->get('posts')->num_rows(); 
      
      
        $html   = '';
        
        $limit  = 25;        
        $page   = $this->input->get('page');
        $start  = startPointOfPagination($limit,$page);                
        $target = $this->my_ajax_paination( $page_slug );    

        $html  .= '<div class="row"><div class="col-md-12">';        
        $html  .= $this->create_search_tags( $page_slug );                                
        $html  .= '</div><div class="clearfix"></div></div>';
        
        $html  .= '<div class="row"><div class="col-md-12">';
        $html  .= getAjaxPaginator( $total, $page, $target, $limit );
        $html  .= '</div><div class="clearfix"></div></div>';
                       
        $order          = $this->shortCase( $this->input->get('short') );
        $order_column   = $order['column'];
        $order_by       = $order['order_by'];                      
        

        $this->db->from('posts');
        if($lat && $lng){ 
            $sql_str = '( 3959 * acos( cos( radians( '.  $lat .') ) * cos( radians( lat ) ) 
                    * cos( radians( lng ) - radians('. $lng .') ) + sin( radians('.  $lat .') ) 
                    * sin( radians( lat ) ) ) ) AS Radius';

            if( $page_slug == 'automech-search') {
            $this->db->select('brand_meta.brand, posts.*, '. $sql_str );
            } else {
                $this->db->select('posts.*, '. $sql_str );
            }
            
            
            $this->db->having('Radius <=', 100 );       
        }
       
        
        if( $page_slug == 'automech-search') {
            $this->db->join('brand_meta', 'brand_meta.post_id = posts.id', 'LEFT');
            $conditions = ($brand_id)       ? array_merge($conditions, ['brand_meta.brand' => $brand_id]) : $conditions;
             $this->db->where('posts.post_type', 'Automech');
        } else {
            $this->db->where('posts.post_type', 'General');
            $conditions = ($brand_id)       ? array_merge($conditions, ['brand_id' => $brand_id]) : $conditions;
        }
        
        $this->db->order_by('posts.is_featured', 'DESC');
        $this->db->order_by($order_column, $order_by);
        $this->db->limit($limit, $start);
        $this->db->where($conditions);
        $this->db->group_by('posts.id');
        
        $this->db->where('posts.status', 'Active');                     
        $results =   $this->db->get()->result();

       // echo $this->db->last_query();
        
       $query_string = ''; // '<pre>'. $this->db->last_query() . '</pre>';
       
       
        // $html .= $this->getFeaturedPost( $this->input->get('type_id') );
       
       
       if($this->input->get('device_code', TRUE)){           
           $method = $_SERVER['REQUEST_METHOD'];
            if( DEVICE_AUTH == $this->input->get('device_code', TRUE) && $method == 'GET' ) {
                json_output(200 , $results) ;
            }
            exit;
        }
       
       
        foreach ($results as $post) { 
           $html .= $this->_per_post_view($post);            
        }

        $html   .= getAjaxPaginator( $total, $page, $target, $limit );
        
        if($total == 0){
            $html .= '<div style="padding-top:20px"><p class="ajax_notice">Sorry, No Record Found! </p></div>';
        }


        
        if( $this->input->is_ajax_request()  ){
           $json = [
                'result'    => $html,
                'count'     => $total,
                'sql'       => $query_string,
                'orderBy'   => GlobalHelper::getShortBy()
            ];
            echo json_encode($json); 
            
        } else {
            echo $query_string;
            echo $html;
        }
        
        
       
    }

    
    
    private function getFeaturedPost($type_id = null  ){
        
        $html = '';
        
        if($type_id ) {
            $this->db->where('vehicle_type_id', $type_id );
        }
        $this->db->where('expiry_date >=', date('Y-m-d') );
        $this->db->where('is_featured', 'Yes');
        $this->db->where('status', 'Active');
        $this->db->order_by('id', 'RAND');
         $results = $this->db->get('posts')->result();
        
        foreach($results as $post){
            $html .= $this->_featured_per_post_view($post);
        }
        return $html;
        
    }
    
    
    private function _per_post_view($post = []) {
        $logged_user = intval( getLoginUserData('user_id') );
        if($post->is_featured == 'Yes') { $class = 'featured_posts'; } else { $class = ''; }
        $html = '';
        $html .= '<div class="search-box '.$class.'">';
        
        $html .= '<div class="col-md-4 nopadding search-box-image"><a href="post/' . $post->post_slug . '">'.GlobalHelper::getPostFeaturedPhoto( $post->id, 'medium', null, 'grayscale lazyload').'</a></div>';
        
        $html .= '<div class="col-md-8 search-box-content">';
		$html .= '<h2><a href="post/' . $post->post_slug . '">' . getShortContent( ($post->title), 33 ) . '</a></h2>';
        $html .= '<div class="col-md-8 search-box-content-left">';
        
        $html .= '<p style=" color:#ef5c26;">#ID-' . sprintf("%'.05d", $post->id ) . ' <span style="color: #b6b6b6;">('. GlobalHelper::getVehicleByPostId($post->id) .')</span> </p>';
        $html .= '<p><i class="fa fa-calendar""></i> Published: ' . globalDateTimeFormat($post->created) . '</p>';
        $html .= '<p><i class="fa fa-bookmark-o" aria-hidden="true"></i> Brand: '. getBrandNameById($post->brand_id) . '</p>';
                $html .= '<p><i class="fa fa-cog" aria-hidden="true"></i>Condition: '. ($post->condition) . '</p>';
                $html .= '<p class="seach-box-location"><i class="fa fa-map-marker" aria-hidden="true"></i> ' . getShortContent($post->location, 30) . '</p>';

                $html .= '</div>';
                $html .= '<div class="col-md-4 search-box-content-right text-right">';
                $html .= '<p>Price</p>';
                $html .= '<p class="listing-prices"> ' . GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein ) . '</p>';
                $html .= GlobalHelper::getSellerTags($post->user_id);

                $html .= '</div>';
                $html .= '<div class="clearfix"></div>';
                    $html .= '<div class="col-md-12 search-box-content-last">';
                    $html .= '<div class="col-md-4 listing-report nopadding">';
                    $html .= '<span class="listing-report" onclick="manage_report('. $post->id .', \''. $post->post_slug .'\');"><i class="fa fa-ban"></i> Report This Advert</span>';
                    $html .= '</div>';
                    $html .= '<div class="col-md-8 no-padding text-right">';
                    $html .= '<a href="post/' . $post->post_slug . '" class="btn btn-default greenstil">More Details <i class="fa fa-mail-forward" aria-hidden="true"></i></a>';
                    $html .= '<button type="button" onclick="get_quote('.$post->id.','. $post->user_id.', \''.$post->post_slug.'\')" class="btn btn-default">Get a Quote <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                    $html .= '</div>';
                    $html .= '<div class="clearfix"></div>';
                $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="clearfix"></div>';
             $html .= '</div>';
             return $html;
    }

       private function _featured_per_post_view($post = []) {
           $logged_user = intval( getLoginUserData('user_id') );

           $html = '';
           $html .= '<div class="search-box featured_posts">';

           $html .= '<div class="col-md-4 nopadding search-box-image"><a href="post/' . $post->post_slug . '">'.GlobalHelper::getPostFeaturedPhoto( $post->id, 'medium', null, 'grayscale lazyload').'</a></div>';

           $html .= '<div class="col-md-8 search-box-content">';
           $html .= '<h2><a href="post/' . $post->post_slug . '">' . getShortContent( ($post->title), 35 ) . '</a></h2>';
           $html .= '<div class="col-md-8 search-box-content-left">';

           $html .= '<p style=" color:#ef5c26;">#ID-' . sprintf("%'.05d", $post->id) . '<span style="color: #b6b6b6;">('. GlobalHelper::getVehicleByPostId($post->id) .')</span> </p>';
           $html .= '<p><i class="fa fa-calendar" ></i> Published: ' . globalDateTimeFormat($post->created) . '</p>';
           $html .= '<p><i class="fa fa-bookmark-o" aria-hidden="true"></i> Brand: '. getBrandNameById($post->brand_id) . '</p>';
           $html .= '<p><i class="fa fa-cog" aria-hidden="true"></i>Condition: '. ($post->condition) . '</p>';
           $html .= '<p class="seach-box-location"><i class="fa fa-map-marker" aria-hidden="true"></i> ' . getShortContent($post->location, 30) . '</p>';

           $html .= '</div>';
           $html .= '<div class="col-md-4 search-box-content-right text-right">';
           $html .= '<p>Price</p>';
           $html .= '<p class="listing-prices"> ' . GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein ) . '</p>';
           $html .= GlobalHelper::getSellerTags($post->user_id);

           $html .= '</div>';
           $html .= '<div class="clearfix"></div>';
           $html .= '<div class="col-md-12 search-box-content-last">';
           $html .= '<div class="col-md-4 listing-report nopadding">';
           $html .= '<span class="listing-report" onclick="manage_report('. $post->id .', \''. $post->post_slug .'\');"><i class="fa fa-ban"></i> Report This Advert</span>';
           $html .= '</div>';
           $html .= '<div class="col-md-8 no-padding text-right">';
           $html .= '<a href="post/' . $post->post_slug . '" class="btn btn-default greenstil">More Details <i class="fa fa-mail-forward" aria-hidden="true"></i></a>';
           $html .= '<button type="button" onclick="get_quote('.$post->id.','. $post->user_id.', \''.$post->post_slug.'\')" class="btn btn-default">Get a Quote <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
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

   
    private function my_ajax_paination( $page = 'search' ){
        
        $array  = $_GET;
        $url    = $page . '?';
        
        unset($array['page']);
        unset($array['_']);
        
        if($array){
           $url .= \http_build_query($array);
        }
        $url    .= '&page';
        return $url;
        
    }
    
    private function create_search_tags( $page_url = null ){
                       
        $tags = [
            'location_id'   => [
                'tbl'   => 'post_area',
                'col'   => 'name',
                'lebel' => 'Area: '
                ],
            'type_id'       => [
                'tbl'   => 'vehicle_types',
                'col'   => 'name',
                'lebel' => 'Vehicle Type: '
                ],
            'brand_id'      => [
                'tbl'   => 'brands',
                'col'   => 'name',
                'lebel' => 'Brand: '
                ],
            'model_id'      => [
                'tbl'   => 'brands',
                'col'   => 'name',
                'lebel' => 'Model: '
                ],
            'body_type'     => [
                'tbl'   => 'body_types',
                'col'   => 'type_name',
                'lebel' => 'Body Type: '
                ],
            'fuel_type'       => [
                'tbl' => 'fuel_types',
                'col'   => 'fuel_name',
                'lebel' => 'Fuel Type: '
                ],
            'engine_size' => [
                'tbl'   => 'engine_sizes',
                'col'   => 'engine_size',
                'lebel' => 'Eng.Size: '
                ],
            'color_id'         => [
                'tbl'   => 'color',
                'col'   => 'color_name',
                'lebel' => 'Colour: '
                ],
            
            'parts_id'         => [
                'tbl'   => 'parts_description',
                'col'   => 'name',
                'lebel' => 'Parts Description: '
                ],
            
            'seller'         => [
                'tbl'   => 'no-tbl',
                'value'   => $this->input->get('seller'),
                'lebel' => 'Seller Type: '
                ],
            'condition'         => [
                'tbl'   => 'no-tbl',
                'value' => $this->input->get('condition'),
                'lebel' => 'Condition: '
                ],
            'age_from'         => [
                'tbl'   => 'range',
                'value' => '',
                'lebel' => 'Age: ' . $this->input->get('age_from') . ' - '. $this->input->get('age_to')
                ],
            'price_to'         => [
                'tbl'   => 'range',
                'value' => '',
                'lebel' => 'Price: ' . ($this->input->get('price_from')) . ' - '. ($this->input->get('price_to'))
                ],
            'mileage_from'         => [
                'tbl'   => 'range',
                'value' => '',
                'lebel' => 'Mileage: ' . ($this->input->get('mileage_from')) . ' - '. ($this->input->get('mileage_to'))
                ],
            'wheelbase'         => [
                'tbl'   => 'no-tbl',
                'value' => $this->input->get('wheelbase'),
                'lebel' => 'Wheelbase: '
                ],
            'gear_box'         => [
                'tbl'   => 'no-tbl',
                'value' => $this->input->get('gear_box'),
                'lebel' => 'Gear box: '
                ],
            'year'         => [
                'tbl'   => 'no-tbl',
                'value' => $this->input->get('year'),
                'lebel' => 'Manufacture year: '
                ],
            
        ];                               
        
        $html = '';
        foreach( $tags as $key=>$attr ){           
            $id = $this->input->get( $key );
            if($id){    
                if($attr['tbl'] == 'no-tbl'){
                    $html .= $this->buiildTag( $attr['lebel'], $attr['value'] );
                    
                } elseif($attr['tbl'] == 'range'){
                    $html .= $this->buiildTag( $attr['lebel'], $attr['value'] );
                } 
                else {
                    $html .= $this->getName( $attr['tbl'], $attr['col'], $id, $attr['lebel'] );
                }
                
                
            }                                   
        }
        if($html){
            $page_url = is_null($page_url) ? 'search' : $page_url;
            $html .= '<a class="badge btn-danger" href="'. $page_url .'">Reset <i class="fa fa-times-circle"></i> </a>';
        }
        
        return $html;
    }
    
    
    private function getName( $table = '', $column = '', $id = 0, $tag = 'Tag: ' ){
                
        $result = $this->db->select($column)->get_where($table, ['id' => $id ])->row();
        
        $html = '';
        $html .= '<span class="badge">';
        $html .= $tag;
        $html .= isset($result->$column) ? $result->$column : 'Empty';
        //$html .= ' <i class="fa fa-times-circle"></i>';
        $html .= '</span> &nbsp;';
        
        return $html;
    }
    
    private function buiildTag( $tag, $value ){
        return '<span class="badge">'. $tag . $value .'</span> &nbsp;';
    }








    private function shortCase( $shortType = ''){
        switch( $shortType ){
            case 'PriceASC':
                return [ 'column' => 'priceinnaira', 'order_by' => 'ASC' ];
            case 'PriceDESC':
                return [ 'column' => 'priceinnaira', 'order_by' => 'DESC' ];
            case 'MileageASC':
                return [ 'column' => 'mileage', 'order_by' => 'ASC' ];
            case 'PostDateASC':
                return [ 'column' => 'created', 'order_by' => 'ASC' ];   
            case 'PostDateDESC':
                return [ 'column' => 'created', 'order_by' => 'DESC' ]; 
            default :
                return [ 'column' => 'posts.id', 'order_by' => 'DESC' ]; 
        }
    }
    
    

    public function single($slug = null) {
        if (!$slug) {
            redirect(site_url('search'));
        } else {
            $post = $this->Posts_model->get_by_slug($slug);
            
            if($post) {
                                
                $data = array(
                    'id'                => $post->id,
                    'user_id'           => $post->user_id,                                        
                    'vehicle_type_id'   => getProductTypeById( $post->vehicle_type_id),
                    'type_id'   =>  $post->vehicle_type_id,
                    'vehicle_type_id_int'   => ( $post->vehicle_type_id),
                    'condition'         => $post->condition,
                    'title'             => $post->title,
                    'post_slug'         => $post->post_slug,
                    'description'       => $post->description,
                    'postFeaturedThumb' => getFeatImageById($post->id),
                    
                    'location'          => $post->location,
                    'location_id'       => $post->location_id,
                    'lat'               => $post->lat,
                    'lng'               => $post->lng,
                    'pricein'           => $post->pricein,
                    'priceindollar'     => $post->priceindollar,
                    'priceinnaira'      => $post->priceinnaira,
                    'advert_type'       => $post->advert_type,
                    'mileage'           => $post->mileage,
                    'brand_id'          => getBrandNameById($post->brand_id),
                    'model_name'        => getModelNameById($post->model_id, $post->brand_id),
                    'model_id'          => $post->model_id,
                    'car_age'           => getCarAgeById($post->car_age),
                    'alloywheels'       => getAllowWheelById($post->alloywheels),
                    'fuel_id'           => getFuelNameById($post->fuel_id),
                    'enginesize_id'     => getEngineSizesById($post->enginesize_id),
                    'gear_box_type'     => $post->gear_box_type,
                    'seats'             => getSeatById($post->seats),
                    'color'             => getColorNameById($post->color),
                    'body_type'         => getBodyTypeById($post->body_type),
                    'registration_date' => $post->registration_date,
                    'post_type' => $post->post_type,
                    'specialism_id' => $post->specialism_id,
                    'repair_type_id' => $post->repair_type_id,
                    'service_type' => $post->service_type,
                    
                    'manufacture_year'  => $post->manufacture_year,
                    'registration_no'   => $post->registration_no,                    
                    'get_features'      => getFeatureById($post->feature_ids),
                    'owners'            => getOwnerById($post->owners),
                    'hit'               => hit_counter($post->id, $post->hit),
                    'status'            => $post->status,
                    'service_history'   => getServiceHistoryById($post->service_history),
                    'expiry_date'       => $post->expiry_date,
                );
                
                $meta['meta_title']        = $post->title;
                $meta['meta_description']  = getShortContent($post->description, 120);
                $meta['meta_keywords']     = 'Buy old and New Car';
                //dd($data);
                $this->load->view('frontend/header', $meta );
                
                $user_id = getLoginUserData('user_id');
                if( $post->status != 'Active' && empty($user_id) ){
                    $this->load->view('frontend/404', $data);
                } else {
                    
                    //dd( $data );
                    
                    $this->load->view('frontend/template/single', $data);
                }
                
                $this->load->view('frontend/footer');
            } else {
                redirect(site_url('search'));
            }         
        }
    }
    
    /*
     * related post by vichle_type_id 
     * int type_id
     */
    public function getRelatedPost(  $model_id = 0, $post_id = 0 ){   
        // $type_id = 0, $post_id = 0, $brand_id = 0,
        //return $type_id .' - '. $post_id;
        
//        $related_posts = $this->db
//                ->order_by('id', 'RANDOM')
//                ->get_where('posts', [ 'vehicle_type_id' => $type_id , 'brand_id' => $brand_id , 'model_id' => $model_id , 'id <>' => $post_id ], 4, 0)
//                ->result();
        
        $related_posts = $this->db
                ->order_by('id', 'RANDOM')
                ->get_where('posts', [ 'model_id' => $model_id, 'id <>' => $post_id ], 4, 0)
                ->result();
		
        $html = '';
        if($related_posts){
        $html .= '<div class="container-fluid white_bg nopadding single-related-post">';
        $html .= '<div class="container">';
        $html .= '<div id="related_post">';
        $html .= '<h3>Similar Vehicles</h3>';
        
        foreach ($related_posts as $post) {         
            $html .= '<div class="col-md-3 nopadding-left">';
            $html .= '<div class="box">';
            $html .= '<a href="post/'.$post->post_slug.'">';                
                $html .= '<div class="thumb_box">'. GlobalHelper::getPostFeaturedPhoto( $post->id, 'small', null, 'thumbnail' ).'</div>';
                $html .= '<div class="caption">';
                $html .= '<h4 class="text-center">'. getShortContent($post->title, 30).'</h4>';
                $html .= '<p class="text-center">' . GlobalHelper::getPrice( $post->priceinnaira,  $post->priceindollar,  $post->pricein ) . '</p> ';
                $html .= '</div>';
            $html .= '</a>';
            $html .= '</div>';
            $html .= '</div>';
        }   
        $html .= '<div class="clearfix"></div>';
        $html .= '</div>';
         $html .= '</div>';
         $html .= '</div>';
         
    }
        return  $html;                                                                                                         
    }
    
    /*
     * related post by vichle_type_id 
     * int type_id
     */
    public function getFromThisSeller( $user_id = 0){
        
        $expiry_date  = date('Y-m-d');        
        $more_posts = $this->db
                ->order_by('id', 'RANDOM')
                ->get_where('posts', ['user_id' => $user_id, 'expiry_date >=' => $expiry_date, 'status' => 'Active' ], 5, 0)                
                ->result();
        
        $html = '';                
               
        foreach($more_posts as $post){ 
        
        $html .= '<div class="row">';
            $html .= '<div class="col-md-4">';
                $html .= GlobalHelper::getPostFeaturedPhoto($post->id, 'tiny');
            $html .= '</div>';
            
            $html .= '<div class="col-md-8 no-padding">';
                $html .= '<p><a href="post/'. $post->post_slug .'">'. getShortContent($post->title, 40) .'</a></p>';
                $html .= '<p class="pricesmore">';
                $html .= GlobalHelper::getPrice($post->priceinnaira,  $post->priceindollar,  $post->pricein);
                $html .= '</p>';
            $html .= '</div>';                    
        $html .= '</div>';
        } 
        
        return $html;
    }

    
    public function getFromTradeSeller( $user_id = 0 ){
        
        $total_row = $this->db
                ->from('posts')
                ->where('user_id', $user_id)
                ->where('status', 'Active')
                ->where('expiry_date >=', date('Y-m-d'))
                ->get()
                ->num_rows();                                               
        $html   = '';        
        $page  = intval($this->input->get('page'));
        $limit = 15;
        $targetpath = $this->uri->segment( 1 ) .'/'. '?page';
        $start = startPointOfPagination($limit,$page);                    
        //$html  .= getPaginator($total_row, $page, $targetpath, $limit);
        
                               
        
        
        $posts = $this->db
                ->from('posts')
                ->limit($limit, $start)
                ->where('user_id', $user_id)
                ->where('status', 'Active')
                ->where('expiry_date >=', date('Y-m-d'))
                ->order_by('is_featured', 'DESC')
                ->order_by('id', 'DESC')
                ->get()
                ->result();
                
        
        
        $html   .= getPaginator($total_row, $page, $targetpath, $limit);
        foreach( $posts as $post ){
            $html .= $this->_per_post_view($post);
        }
        $html   .= getPaginator($total_row, $page, $targetpath, $limit);
        
        if(empty($total_row)){
            $html .= '<p class="ajax_notice">No Record Found</p>';
        }
        
        return $html;
    }

    
    public function getSellerDetails($user_id){
                        
        $seller = $this->db->get_where('users', ['id' => $user_id])->row_array();
        $metas  = $this->db->select('meta_key,meta_value')->get_where('user_meta', ['user_id' => $user_id])->result();
        foreach($metas as $meta ){
            $seller[$meta->meta_key] = $meta->meta_value;
        }
                
        $html  = '';
        $html .= '<h4>'. $this->issetKey('companyName', $seller) .'</h4>';
        //$html .= '<h4>Location</h4>';
        $html .= '<p><i class="fa fa-map-marker"></i> '. $this->issetKey('serllerLocation', $seller) .'</p>';        
        //$html .= '<h4>Contact Number</h4>';
        $html .= '<p><i class="fa fa-phone-square"></i> '. $this->issetKey('serllerLocation', $seller) .'</p>';
        
        return $html;
    }
 
    private function issetKey( $key = '', $seller = array()){
        return isset($seller[$key]) ? $seller[$key] : $key;
    }
    
    
    public function getSlider( $post_id = 0, $size = 875 ){        
        $photos = $this->db
                ->get_where('post_photos', ['post_id' => $post_id, 'size' => $size ], 10, 0)
                ->result();
        
       
        
        $count  = count($photos);
        
        $html   = '<div class="slideshow">';
        $html  .= '<div id="myCarousel" class="carousel slide">';
        //$html  .= $count;
        if($count == 0){
            $html .= 'Zero - ' .  $count;
        } elseif($count == 1 ) {
            $html .=  '<div class="item';
            $html .=  ($sl == 1) ? ' active">' : '">';
            $html .=  GlobalHelper::getPostPhoto($photos[0]->photo, 'big', 'img-responsive lazyload');
            $html .=  '</div>';
        } else {
            $sl = -1;
            $html .=  '<div class="carousel-inner">';            
            foreach($photos as $row ) {
                $sl++;                
                $html .=  '<div class="item';
                $html .=  ($sl == 1) ? ' active">' : '">';
                $html .=  GlobalHelper::getPostPhoto($row->photo, 'big', 'img-responsive lazyload');
                $html .=  '</div>';
            }
            $html .= '</div>';
            
            // Thumb
            $sl = -1;
            $html .=  '<ol class="carousel-indicators">';                
            foreach($photos as $thumb) {
                $sl++;    
                $html .=  '<li data-target="#myCarousel" data-slide-to="'. $sl .'"';
                $html .=  ($sl == 1) ? 'class="active">' : '>';
                $html .=  GlobalHelper::getPostPhoto($thumb->photo, 'tiny', 'img-responsive lazyload');
                $html .=  '</li>';
            }
            $html .=  '</ol>';
            
                                                
            $html .=    '<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </a>';                                               
        }
               
        
        $html .= '</div>';
        
        $html .= '</div>';
        
        return $html;
        
    }

    
              
    public function get_post_by_user($user_id = null){
        return $user_posts = $this->db->get_where('posts', ['user_id' => $user_id], 5, 0)->result();        
    }
    
    
    public function report_spam(){
        
        $prams = [
            'post_id'       => intval( $this->input->get('post_id') ),
            'your_email'    => getLoginUserData('user_mail')            
        ];                         
        $this->load->view('report_spam', $prams );
    }
    
    public function getQuote(){
       
        $user_id = getLoginUserData('user_id');
        $prams = [
            'post_id'       => intval( $this->input->get('post_id') ),            
            'seller_id'     => intval($this->input->get('seller_id')),
            'post_slug'     => $this->input->get('slug'),            
        ];
        
        if($user_id){
            $this->load->view('make_an_offer', $prams );
        } else {
            $this->load->view('login_message' );
        }
        
    }
    
    
    
    
    
    
    // for parts 
    public function spare_parts(){
        $data = [];
        $this->viewFrontContent('frontend/template/spare_parts', $data );     
    }
    public function spare_parts_search(){
        $data = [];
//                $user_id = getLoginUserData('user_id');
//                if( $post->status != 'Active' && empty($user_id) ){
//                    $this->load->view('frontend/404', $data);
//                } else {
        //dd( $data );
        $this->viewFrontContent('frontend/template/spare_parts_search', $data );       
        // }
    }
    
        // for parts 
    public function automech(){
        $data = [];
        $this->viewFrontContent('frontend/template/automech', $data );     
    }
    public function automech_search(){
        $data = [];
        $this->viewFrontContent('frontend/template/automech_search', $data );       
       
    }
    
    
    
    
    
    // get all post  for  API 
    
    
    public function getSliderApi( $post_id = 0 ){            
        $photo_url = base_url('/').'uploads/car/';        
        $photos = $this->db
                    ->where('post_id' , $post_id )                
                    ->get('post_photos')
                    ->result();
        if($photos){
            $new_photos = array();
            foreach($photos as $photo ){
                $new_photos[ $photo->size ][] = $photo_url . $photo->photo;
            }
        }  else {
            $new_photos = base_url('/upload/').'no-photo.jpg';
        }      
        return $new_photos;
    }

    
    
    
    
    
    
    
    
   public function api_getPosts( $page_slug = null ) {        
        
      $method = $_SERVER['REQUEST_METHOD'];
      if($method != 'GET'){
        json_output( 400 , array('status' => 400,'message' => 'Bad request.'));
        exit; 
      } 
                
      

        // $page_slug == page slug as search, auction-car, van etc
        $page_slug      = is_null($page_slug) ? $this->input->get('page_slug') : $page_slug;
        $location_id    = intval($this->input->get('location_id'));        
        $type           = GlobalHelper::getTypeIdByPageSlug( $page_slug ); // for get method 
        $type_id        = ($type == 0) ? intval($this->input->get('type_id')) : intval($type);	
        $brand_id       = intval($this->input->get('brand_id'));
        $model_id       = intval($this->input->get('model_id'));
        $body_type      = intval($this->input->get('body_type'));
        $age_from       = intval($this->input->get('age_from'));
        $age_to         = intval($this->input->get('age_to'));
        $price_from     = intval($this->input->get('price_from'));
        $price_to       = intval($this->input->get('price_to'));
        $mileage_from   = intval($this->input->get('mileage_from'));
        $mileage_to     = intval($this->input->get('mileage_to'));
        $condition      = $this->input->get('condition');       // product condition new, used
        $fuel_type      = intval($this->input->get('fuel_type'));
        $engine_size    = intval($this->input->get('engine_size'));
        $gear_box       = intval($this->input->get('gear_box'));
        $seats          = intval($this->input->get('seats'));
        $color          = intval($this->input->get('color_id'));
        $parts_id       = intval($this->input->get('parts_id'));
        $parts_for       = intval($this->input->get('parts_for'));
        
        
        $specialist       = intval($this->input->get('specialist'));
        $repair_type       = intval($this->input->get('repair_type'));       
        $service     = $this->input->get('service');
        
        $category_id    = intval($this->input->get('category_id'));
        $parts_description    = intval($this->input->get('parts_description'));
        $wheelbase      = intval($this->input->get('wheelbase'));        
        $year           = intval($this->input->get('year'));        
        $seller         = $this->input->get('seller');             // Business or Private
        $conditions = ['expiry_date >=' => date('Y-m-d')];
                
        $conditions = ($location_id)    ? array_merge($conditions, ['location_id' => $location_id]) : $conditions;
        // brand id will change with page slug
        // $conditions = ($brand_id)       ? array_merge($conditions, ['brand_id' => $brand_id]) : $conditions;
        $conditions = ($model_id)       ? array_merge($conditions, ['model_id' => $model_id]) : $conditions;
        $conditions = ($type_id)        ? array_merge($conditions, ['vehicle_type_id' => $type_id]) : $conditions;
        $conditions = ($body_type)      ? array_merge($conditions, ['body_type' => $body_type]) : $conditions;
        $conditions = ($age_from)       ? array_merge($conditions, ['car_age >=' => $age_from]) : $conditions;
        $conditions = ($age_to)         ? array_merge($conditions, ['car_age <=' => $age_to]) : $conditions;
        $conditions = ($price_from)     ? array_merge($conditions, ['priceinnaira >=' => $price_from]) : $conditions;
        $conditions = ($price_to)       ? array_merge($conditions, ['priceinnaira <=' => $price_to]) : $conditions;
        $conditions = ($mileage_from)   ? array_merge($conditions, ['mileage >=' => $mileage_from]) : $conditions;
        $conditions = ($mileage_to)     ? array_merge($conditions, ['mileage <=' => $mileage_to]) : $conditions;
        $conditions = ($condition)      ? array_merge($conditions, ['condition' => $condition]) : $conditions;
        
       $conditions     = ($fuel_type)   ? array_merge($conditions, ['fuel_id' => $fuel_type]) : $conditions;
       $conditions     = ($engine_size) ? array_merge($conditions, ['enginesize_id' => $engine_size]) : $conditions;
       $conditions     = ($gear_box)    ? array_merge($conditions, ['gear_box_type' => $gear_box]) : $conditions;
       $conditions     = ($seats)       ? array_merge($conditions, ['seats' => $seats]) : $conditions;
       $conditions     = ($color)       ? array_merge($conditions, ['color' => $color]) : $conditions;
       $conditions     = ($year)        ? array_merge($conditions, ['manufacture_year' => $year]) : $conditions;
       $conditions     = ($parts_id)    ? array_merge($conditions, ['parts_description' => $parts_id]) : $conditions;
       $conditions     = ($parts_for)    ? array_merge($conditions, ['parts_for' => $parts_for]) : $conditions;
       
       
       $conditions     = ($specialist)    ? array_merge($conditions, ['specialism_id' => $specialist]) : $conditions;
       $conditions     = ($repair_type)    ? array_merge($conditions, ['repair_type_id' => $repair_type]) : $conditions;
       $conditions     = ($service)    ? array_merge($conditions, ['service_type' => $service]) : $conditions;
                 
           
       
       $conditions     = ($parts_description)    ? array_merge($conditions, ['parts_description' => $parts_description]) : $conditions;
       $conditions     = ($category_id)    ? array_merge($conditions, ['category_id' => $category_id]) : $conditions;
       $conditions     = ($wheelbase)   ? array_merge($conditions, ['alloywheels' => $wheelbase]) : $conditions;
       $conditions     = ($seller)      ? array_merge($conditions, ['listing_type' => $seller]) : $conditions;
                       
       // "lat" : 9.096838999999999,
       // "lng" : 7.4812937
        

        $address    = $this->input->get('address');
        $lat        = $this->input->get('lat');     //  32.7554883;             --- Fort+Worth,+TX,+United+States
        $lng        = $this->input->get('lng');     // -97.33076579999999;     --- Fort+Worth,+TX,+United+States        
        
        //$this->db->from();
        if($lat && $lng){ 
            $sql_str = '( 3959 * acos( cos( radians( '.  $lat .') ) * cos( radians( lat ) ) 
                    * cos( radians( lng ) - radians('. $lng .') ) + sin( radians('.  $lat .') ) 
                    * sin( radians( lat ) ) ) ) AS Radius';

            $this->db->select('brand_meta.brand, posts.*, '. $sql_str );
            $this->db->having('Radius <=', 100 );
       
        }      
        
        if( $page_slug == 'automech-search') {
            $this->db->join('brand_meta', 'brand_meta.post_id = posts.id', 'LEFT');
            $conditions = ($brand_id)       ? array_merge($conditions, ['brand_meta.brand' => $brand_id]) : $conditions;
             $this->db->where('posts.post_type', 'Automech');
        } else {
            $this->db->where('posts.post_type', 'General');
            $conditions = ($brand_id)       ? array_merge($conditions, ['brand_id' => $brand_id]) : $conditions;
        }
        
       $this->db->where($conditions);
       $this->db->group_by('posts.id');
       $this->db->where('posts.status', 'Active');
      
       $total = $this->db->get('posts')->num_rows(); 
      
      
        $html   = '';
        
        $limit  = 5;        
        $page   = $this->input->get('page');
        $start  = startPointOfPagination($limit,$page);                
        $target = $this->my_ajax_paination( $page_slug );    

        $html  .= '<div class="row"><div class="col-md-12">';        
        $html  .= $this->create_search_tags( $page_slug );                                
        $html  .= '</div><div class="clearfix"></div></div>';
        
        $html  .= '<div class="row"><div class="col-md-12">';
        $html  .= getAjaxPaginator( $total, $page, $target, $limit );
        $html  .= '</div><div class="clearfix"></div></div>';
                       
        $order          = $this->shortCase( $this->input->get('short') );
        $order_column   = $order['column'];
        $order_by       = $order['order_by'];                      
        

        $this->db->from('posts');
        if($lat && $lng){ 
            $sql_str = '( 3959 * acos( cos( radians( '.  $lat .') ) * cos( radians( lat ) ) 
                    * cos( radians( lng ) - radians('. $lng .') ) + sin( radians('.  $lat .') ) 
                    * sin( radians( lat ) ) ) ) AS Radius';

            $this->db->select('brand_meta.brand, posts.*, '. $sql_str );
            $this->db->having('Radius <=', 100 );       
        }
       
        
        if( $page_slug == 'automech-search') {
            $this->db->join('brand_meta', 'brand_meta.post_id = posts.id', 'LEFT');
            $conditions = ($brand_id)       ? array_merge($conditions, ['brand_meta.brand' => $brand_id]) : $conditions;
             $this->db->where('posts.post_type', 'Automech');
        } else {
            $this->db->where('posts.post_type', 'General');
            $conditions = ($brand_id)       ? array_merge($conditions, ['brand_id' => $brand_id]) : $conditions;
        }
        
        $this->db->order_by('posts.is_featured', 'DESC');
        $this->db->order_by($order_column, $order_by);
        $this->db->limit($limit, $start);
        $this->db->where($conditions);
        $this->db->group_by('posts.id');
        
        $this->db->where('posts.status', 'Active');                     
        $results =   $this->db->get()->result();

    
       
       
       $api_data  = '';
        foreach ($results as $post) { 
           $api_data[]  = [
               'id' => $post->id,
               'user_id' => $post->user_id,
               'seller_status' => GlobalHelper::getSellerTags($post->user_id),
               'username' => getUserName($post->user_id), 
               'package_id' => $post->package_id,
               'package_name' => getPackageNameApi($post->package_id),
               'vehicle_type_id' => getProductTypeById($post->vehicle_type_id), 
               'condition' => $post->condition,
               'listing_type' => $post->listing_type,
               'is_featured' => $post->is_featured,
               'title' => $post->title,
               'post_slug' => $post->post_slug,
               'description' => strip_tags( $post->description ),
               'location_id' => $post->location_id,
               'location_name' => getTagName('post_area', 'name', $post->location_id) , 
               'location' => $post->location,
               'lat' => $post->lat,
               'lng' => $post->lng,
               'pricein' => $post->pricein,
               'priceindollar' => $post->priceindollar,
               'priceinnaira' => $post->priceinnaira,
               'advert_type' => $post->advert_type,
               'expiry_date' => $post->expiry_date,
               'mileage' => $post->mileage,
               'brand_id' => $post->brand_id,
               'brand_name' => getBrandNameById($post->brand_id),  
               'model_id' => $post->model_id,
               'model_name' => getModelNameById($post->model_id), 
               'car_age' => $post->car_age,
               'alloywheels' => $post->alloywheels,
               'alloywheels_name' => getAllowWheelById( $post->alloywheels ),
               'fuel_id' => $post->fuel_id,
               'fuel_name' => getFuelNameById($post->fuel_id), 
               'enginesize_id' => $post->enginesize_id,
               'enginesize_name' => getEngineSizesById($post->enginesize_id),  
               'gear_box_type' => $post->gear_box_type,
               'seats' => $post->seats,
               'color' => $post->color,
               'color_name' => getColorNameById($post->color), 
               'body_type' => $post->body_type,
               'body_type_name' => getBodyTypeById($post->body_type),
               'registration_date' => $post->registration_date,
               'manufacture_year' => $post->manufacture_year,
               'registration_no' => $post->registration_no,
               'feature_ids' => getVicheleFeatures($post->feature_ids), 
               'owner_id' => $post->owners,
               'owner_name' => getOwnerById($post->owners),
               'parts_for_id' => $post->parts_for,
               'parts_for_name' => getPartsFor($post->parts_for),
               'parts_category_id' => $post->category_id,
               'parts_category_name' => GlobalHelper::getParts_categories( $post->category_id ),
               'parts_description_id' => $post->parts_description,
               'parts_description_name' => GlobalHelper::getParts_description( $post->parts_description ),
               'service_history' => getServiceHistoryById($post->service_history),
               'specialism_id' => $post->specialism_id,
               'specialism_name' => GlobalHelper::getSpecialismName( $post->specialism_id ),
               'repair_type_id' => $post->repair_type_id,
               'repair_type_name' => GlobalHelper::getRepairTypeName( $post->repair_type_id ),
               'service_type_id' => $post->service_type,
               'service_type_name' => GlobalHelper::getServiceTypeName( $post->service_type ),
               'post_type' => $post->post_type,
               'thumb' => GlobalHelper::getPostFeaturedPhotoApi( $post->id, 'medium', null ),
               'status' => $post->status,
               'hit' => $post->hit,
               'admin_note' => $post->admin_note,
               'created' => $post->created,
               'modified' => $post->modified
           ];
           
        }

      
       
        if($this->input->get('device_code', TRUE)){
            if( DEVICE_AUTH == $this->input->get('device_code', TRUE) && $method == 'GET' ) {
                json_output(200 , $api_data) ;
            }
        }
        
       
   

       /*  $html   .= getAjaxPaginator( $total, $page, $target, $limit );
        
        if($total == 0){
            $html .= '<div style="padding-top:20px"><p class="ajax_notice">Sorry, No Record Found! </p></div>';
        }

        */

        
       /*  if( $this->input->is_ajax_request()  ){
           $json = [
                'result'    => $html,
                'count'     => $total,
                'sql'       => $query_string,
                'orderBy'   => GlobalHelper::getShortBy()
            ];
            echo json_encode($json); 
            
        } else {
            echo $query_string;
            echo $html;
        }
        */
        
        
       
    }
    
    
    
    public function singlePostApi( $id = 0 ) {
         $user_id = getLoginUserData('user_id');
         
        $method = $_SERVER['REQUEST_METHOD'];
        if($method != 'GET'){
            json_output( 400 , array('status' => 400,'message' => 'Bad request.'));
            exit; 
          } 
          
          
        if (!$id) {
            redirect(site_url('search'));
        } else {
             $post = $this->Posts_model->get_by_id($id);
            
            if($post) {
                
                if(getFeatImageById($post->id)){
                   $postFeaturedThumb =  base_url('/').'uploads/car/'.getFeatImageById($post->id) ;
                } else {
                    $postFeaturedThumb =  base_url('/').'uploads/no-photo.jpg';
                }
                
               
                
                $data =  [
                    'id' => $post->id,
                    'user_id' => $post->user_id,
                    'seller_status' => GlobalHelper::getSellerTags($post->user_id),
                    'username' => getUserName($post->user_id), 
                    'package_id' => $post->package_id,
                    'package_name' => getPackageNameApi($post->package_id),
                    'vehicle_type_id' => getProductTypeById($post->vehicle_type_id), 

                    'type_id'   =>  $post->vehicle_type_id,
                    'vehicle_type_id_int'   => ( $post->vehicle_type_id),     

                    'condition' => $post->condition,
                    'listing_type' => $post->listing_type,
                    'is_featured' => $post->is_featured,
                    'title' => $post->title,
                    'post_slug' => $post->post_slug,
                    'description' =>  strip_tags( $post->description ),
                    'location_id' => $post->location_id,
                    'location_name' => getTagName('post_area', 'name', $post->location_id) , 
                    'location' => $post->location,
                    'lat' => $post->lat,
                    'lng' => $post->lng,
                    'pricein' => $post->pricein,
                    'priceindollar' => $post->priceindollar, 
                    'priceinnaira' => $post->priceinnaira,
                    'mileage'           => $post->mileage,    
                    'advert_type' => $post->advert_type,
                    'expiry_date' => $post->expiry_date,
                    'mileage' => $post->mileage,
                    'brand_id' => $post->brand_id,
                    'brand_name' => getBrandNameById($post->brand_id),  
                    'model_name'        => getModelNameById($post->model_id, $post->brand_id),
                    'model_id' => $post->model_id,
                    'car_age'           => getCarAgeById($post->car_age),
                    'alloywheels' => $post->alloywheels,
                    'alloywheels_name' => getAllowWheelById( $post->alloywheels ),
                    'fuel_id' => $post->fuel_id,
                    'fuel_name' => getFuelNameById($post->fuel_id), 
                    'enginesize_id' => $post->enginesize_id,
                    'enginesize_name' => getEngineSizesById($post->enginesize_id),  
                    'gear_box_type' => $post->gear_box_type,               
                    'seats'             => getSeatById($post->seats),
                    'color' => $post->color,
                    'color_name' => getColorNameById($post->color), 
                    'body_type' => $post->body_type,
                    'body_type'         => getBodyTypeById($post->body_type),
                    'registration_date' => $post->registration_date,


                    'manufacture_year' => $post->manufacture_year,
                    'registration_no' => $post->registration_no,
                    'feature_ids' => getVicheleFeatures($post->feature_ids), 
                    'owner_id' => $post->owners,
                    'owner_name' => getOwnerById($post->owners),
                    'parts_for_id' => $post->parts_for,
                    'parts_for_name' => getPartsFor($post->parts_for),
                    'parts_category_id' => $post->category_id,
                    'parts_category_name' => GlobalHelper::getParts_categories( $post->category_id ),
                    'parts_description_id' => $post->parts_description,
                    'parts_description_name' => GlobalHelper::getParts_description( $post->parts_description ),
                    'service_history' => getServiceHistoryById($post->service_history),
                    'specialism_id' => $post->specialism_id,
                    'specialism_name' => GlobalHelper::getSpecialismName( $post->specialism_id ),
                    'repair_type_id' => $post->repair_type_id,
                    'repair_type_name' => GlobalHelper::getRepairTypeName( $post->repair_type_id ),
                    'service_type_id' => $post->service_type,
                    'service_type_name' => GlobalHelper::getServiceTypeName( $post->service_type ),
                    'post_type' => $post->post_type,
                    'postFeaturedThumb' => $postFeaturedThumb,
                    
                    'slider' => $this->getSliderApi( $post->id ),                    
                    'status' => $post->status,
                    'hit'    => hit_counter($post->id, $post->hit),
                    'admin_note' => $post->admin_note,
                    'created' => $post->created,
                    'modified' => $post->modified
                ];

            }     
        
             
                if( $post->status != 'Active' && empty($user_id) ){
                   $this->load->view('frontend/404');
                } else { 
                   
                    if($this->input->get('device_code', TRUE)){
                        if( DEVICE_AUTH == $this->input->get('device_code', TRUE) && $method == 'GET' ) {
                            json_output(200 , $data) ;
                        }
                    }
        
                    
                    
                }
            
            }
    }
    

    
    
               
}
