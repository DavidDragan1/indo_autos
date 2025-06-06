<?php

/* This helper only for front end view */

use Illuminate\Database\Capsule\Manager as DB;

class GlobalHelper
{
    static public function getShortBy($selected = null, $page = 'search')
    {

        $prefix = self::my_ajax_paination($page);
        $options = [

            'all' => 'Sort By',
//            'PriceASC' => 'Price (Lowest to Highest)',
//            'PriceDESC' => 'Price (Highest to Lowest)',
            //'MakeASC'        => 'Make',
            //'ModelASC'       => 'Model',
//            'MileageASC' => 'Mileage (Lowest to Highest)',
            //'MileageDESC'    => 'Mileage (Highest to Lowest)',
            'PostDateASC' => 'Oldest Post',
            'PostDateDESC' => 'Latest Post'
        ];

        if ($page != "spare-parts" && $page != 'automech-search' && $page != 'towing-search') {
            $options['MileageASC'] = 'Mileage (Lowest to Highest)';
        }

        if ($page != 'automech-search' && $page != 'towing-search') {
            $options['PriceASC'] = 'Price (Lowest to Highest)';
            $options['PriceDESC'] = 'Price (Highest to Lowest)';
        }

        $html = '';
        foreach ($options as $key => $option) {
            $html .= '<option value="' . $prefix . '&short=' . $key . '"';
            $html .= ($selected == $key) ? ' selected ' : '';
            $html .= '>' . $option . '</option>';
        }
        return $html;
    }

    static public function getVehicleTypes($id = 0, $label = 'Product Type')
    {
        // $types = DB::table('vehicle_types')->select('id','name')->get();
        $allows = [1, 2, 3];
        $types = DB::table('vehicle_types')->select('id', 'name')->whereIn('vehicle_types.id', $allows)->get();

        $html = '<option value="0"> ' . $label . ' </option> ';
        foreach ($types as $type) {
            $html .= '<option value="' . $type->id . '"';
            $html .= ($id == $type->id) ? ' selected ' : '';
            $html .= '>' . $type->name . '</option>';
        }
        return $html;
    }
    static public function getVehicleTypesSlug($slug = null, $label = 'Type')
    {
        // $types = DB::table('vehicle_types')->select('id','name')->get();
        $allows = [1, 2, 3];
        $types = DB::table('vehicle_types')->select('slug', 'name')->whereIn('vehicle_types.id', $allows)->get();

        $html = '<option value=""> ' . $label . ' </option> ';
        foreach ($types as $type) {
            $html .= '<option value="' . $type->slug . '"';
            $html .= ($slug == $type->slug) ? ' selected ' : '';
            $html .= '>' . $type->name . '</option>';
        }
        return $html;
    }

    static public function getHomeVehicleTypes($id = 0, $label = 'Product Type')
    {
        // $allows = [1,2];
        // ->whereIn('vehicle_types.id', $allows)
        $types = DB::table('vehicle_types')->select('id', 'name')->get();

        $html = '<option value="0"> ' . $label . '  </option> ';
        foreach ($types as $type) {
            $html .= '<option value="' . $type->id . '"';
            $html .= ($id == $type->id) ? ' selected ' : '';
            $html .= '>' . $type->name . '</option>';
        }
        return $html;
    }

    static public function getFeaturedPost($vehicle_type = null)
    {
        // Used Laravel DB Query.... to get in touch :)
        $query = DB::table('posts')
            ->select('id', 'title', 'post_slug', 'condition', 'listing_type', 'user_id', 'pricein', 'priceindollar', 'priceinnaira', 'listing_type')
            ->where('status', '=', 'Active')
            ->where('is_featured', '=', 'Yes')
            ->where('expiry_date', '>=', date('Y-m-d'));
        if ($vehicle_type) {
            $query->where('vehicle_type_id', 4);
        }
        $query->take(25);
        $posts = $query->get();

        $html = '';

        foreach ($posts as $post) {
            $html .= '<div class="col-12">';
            $html .= '<a class="featured-adverts-wrap" href="post/' . $post->post_slug . '">';
            $html .= '<div class="featured-adverts-img">' . self::getPostFeaturedPhoto($post->id, 'tiny', null, null, getShortContentAltTag(($post->title), 60)) . '</div>';
            $html .= '<div class="featured-adverts-content">';
            $html .= '<h3>' . getShortContent($post->title, 20) . '</h3>';
            $html .= '<p>' . self::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) . '</p>';
            $html .= '</div>';
            $html .= '</a>';
            $html .= '</div>';
        }
        return $html;
    }

    static public function getAutoMechFeaturedPost()
    {
        // Used Laravel DB Query.... to get in touch :)


        $query = DB::table('posts');
        $query->select('id', 'title', 'post_slug', 'condition', 'listing_type', 'user_id', 'pricein', 'priceindollar', 'priceinnaira', 'listing_type');
        $query->where('status', 'Active');
        $query->where('is_featured', 'Yes');
        $query->where('expiry_date', '>=', date('Y-m-d'));
        $query->where('post_type', 'Automech');

        /*
        if($vehicle_type){
            $query->where('vehicle_type_id', 4 );
        } */

        $query->take(25);
        //  $query->orderBy( 'id', 'DESC' );


        $posts = $query->get();

        $html = '';
        foreach ($posts as $post) {
            $html .= '<div class="col-12">';
            $html .= '<a class="featured-adverts-wrap" href="post/' . $post->post_slug . '">';
            $html .= '<div class="featured-adverts-img">' . self::getPostFeaturedPhoto($post->id, 'tiny', null, null, getShortContentAltTag(($post->title), 60)) . '</div>';
            $html .= '<div class="featured-adverts-content">';
            $html .= '<h3>' . getShortContent($post->title, 40) . '</h3>';
            $html .= '<p>' . self::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) . '</p>';
            $html .= '</div>';
            $html .= '</a>';
            $html .= '</div>';
        }
        return $html;
    }

    static public function getTowingFeaturedPost()
    {
        // Used Laravel DB Query.... to get in touch :)


        $query = DB::table('posts');
        $query->select('id', 'title', 'post_slug', 'condition', 'listing_type', 'user_id', 'pricein', 'priceindollar', 'priceinnaira', 'listing_type');
        $query->where('status', 'Active');
        $query->where('is_featured', 'Yes');
        $query->where('expiry_date', '>=', date('Y-m-d'));
        $query->where('post_type', 'Towing');

        /*
        if($vehicle_type){
            $query->where('vehicle_type_id', 4 );
        } */

        $query->take(25);
        $posts = $query->get();
        $html = '';
        foreach ($posts as $post) {
            $html .= '<div class="col-12">';
            $html .= '<a class="featured-adverts-wrap" href="post/' . $post->post_slug . '">';
            $html .= '<div class="featured-adverts-img">' . self::getPostFeaturedPhoto($post->id, 'tiny', null, null, getShortContentAltTag(($post->title), 60)) . '</div>';
            $html .= '<div class="featured-adverts-content">';
            $html .= '<h3>' . $post->title . '</h3>';
            $html .= '<p>' . self::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) . '</p>';
            $html .= '</div>';
            $html .= '</a>';
            $html .= '</div>';
        }
        return $html;
    }

    public static function getPostFeaturedPhoto($post_id = 0, $size = 'tiny', $is_featured = null, $class = null, $alt = "image")
    {
        switch ($size) {
            case 'tiny':
                $width_height = '75';
                break;
            case 'small':
                $width_height = '280';;
                break;
            case 'medium':
                $width_height = '875';
                break;
            case 'featured':
                $width_height = '285';
                break;
            default :
                $width_height = '875';
                $size = 'medium';
        }

        $CI =& get_instance();
        $id = intval($post_id);
        $result = $CI->db->select('photo')
            ->where_in('size', [$width_height, 0])
            ->get_where('post_photos', ['post_id' => $id, 'featured' => 'Yes'])
            ->row();

        $photo = isset($result->photo) ? $result->photo : 'no-photo.jpg';

        if ($is_featured == 'Yes') {
            $rapper = '<div class="ribbon"><span>Featured </span></div>';
        } elseif ($is_featured == 'No') {
            $rapper = '<div class="ribbon"><span class="free">Free Ads </span></div>';
        } else {
            $rapper = '';
        }

        return $rapper . self::getPostPhoto($photo, $size, $class, $alt);

    }

    public static function getPostPhoto($photo = null, $size = 'medium', $class = 'thumbnail', $alt = "image")
    {
        $filename = dirname(APPPATH) . '/uploads/car/' . $photo;
        if (filter_var($photo, FILTER_VALIDATE_URL)){
            $photo = str_replace('/public', '/' . ucfirst($size), $photo);
            return '<img class="'.$class.'" src="' . $photo . '" alt="' . $alt . '">';
        }elseif ($photo && file_exists($filename)) {

            return '<img class="' . $class . '" src="uploads/car/' . $photo . '" alt="' . $alt . '">';
        } else {
            return '<img class="' . $class . '" src="assets/theme/new/images/no-photo.png" alt="' . $alt . '">';
        }
    }

    public static function photo($photo = null, $size = 'medium', $class = 'thumbnail')
    {


        switch ($size) {
            case 'tiny':
                $width_height = self::getPhotoNameBySize($photo, 75);
                break;
            case 'small':
                $width_height = self::getPhotoNameBySize($photo, 280);;
                break;
            case 'medium':
                $width_height = self::getPhotoNameBySize($photo, 875);
                break;
            case 'featured':
                $width_height = self::getPhotoNameBySize($photo, 285);
                break;
            default :
                $width_height = self::getPhotoNameBySize($photo, 875);
                $size = 'medium';
        }


        $filename = dirname(APPPATH) . '/uploads/car/' . $width_height;

        if (filter_var($photo, FILTER_VALIDATE_URL)){
            return str_replace('/public', '/' . ucfirst($size), $photo);
        }elseif ($photo && file_exists($filename)) {
            return base_url() . '/uploads/car/' . $width_height;
        } else {
            return "assets/theme/new/images/no-photo.png";
        }
    }

    public static function getPhotoNameBySize($string = null, $size = 75)
    {
        $split = str_replace('_875', '_' . $size, $string);
        return $split;
    }

    public static function getPostFeaturedPhotoApi($post_id = 0, $size = 'tiny', $is_featured = null, $class = null)
    {
        $CI =& get_instance();
        $id = intval($post_id);
        $result = $CI->db->select('photo')
            ->get_where('post_photos', ['post_id' => $id, 'featured' => 'Yes'])
            ->row();
        $photo = isset($result->photo) ? $result->photo : 'no-photo.jpg';

        if ($is_featured == 'Yes') {
            $rapper = 'Featured';
        } elseif ($is_featured == 'No') {
            $rapper = 'Free Ads';
        } else {
            $rapper = '';
        }

        return $rapper . self::getPostPhotoApi($photo, $size, $class);

    }

    public static function getPostPhotoApi($photo = null, $size = 'medium', $class = 'thumbnail')
    {

        switch ($size) {
            case 'tiny':
                $width_height = self::getPhotoNameBySize($photo, 75);
                break;
            case 'small':
                $width_height = self::getPhotoNameBySize($photo, 280);;
                break;
            case 'medium':
                $width_height = self::getPhotoNameBySize($photo, 850);
                break;
            case 'featured':
                $width_height = self::getPhotoNameBySize($photo, 285);
                break;
            default :
                $width_height = self::getPhotoNameBySize($photo, 875);
        }


        $filename = dirname(APPPATH) . '/uploads/car/' . $photo;
        if ($photo && file_exists($filename)) {
            return base_url('/') . 'uploads/car/' . $width_height;
        } else {
            return base_url('/') . 'uploads/no-photo.jpg';
        }
    }

    public static function getPostFeaturedPhotoRestApi($post_id = 0)
    {
        $CI =& get_instance();
        $id = intval($post_id);
//        $result     = $CI->db->select('photo')
//                        ->get_where('post_photos', ['post_id' => $id, 'featured' => 'Yes'])
//                        ->row();
        $result = $CI->db->select('photo')
            ->get_where('post_photos', ['post_id' => $id, 'size' => '875'])
            ->row();
        $photo = isset($result->photo) ? $result->photo : 'no-photo.jpg';


        return self::getPostPhotoRestApi($photo);
    }

    public static function getPostPhotoRestApi($photo = null, $size = 875)
    {

        switch ($size) {
            case 'tiny':
                $width_height = self::getPhotoNameBySize($photo, 75);
                break;
            case 'small':
                $width_height = self::getPhotoNameBySize($photo, 280);;
                break;
            case 'medium':
                $width_height = self::getPhotoNameBySize($photo, 850);
                break;
            case 'featured':
                $width_height = self::getPhotoNameBySize($photo, 285);
                break;
            default :
                $width_height = self::getPhotoNameBySize($photo, 875);
        }


        $filename = dirname((APPPATH)) . '/uploads/car/' . $photo;

        if (filter_var($photo, FILTER_VALIDATE_URL)){
            return str_replace('/public', '/' . ucfirst($size), $photo);
        }elseif ($photo && file_exists($filename)) {
            return ('https://carquest.com/uploads/car/' . $width_height);
        } else {
            return ('https://carquest.com/uploads/no-photo.jpg');
        }
    }

    public static function getPrice($NGR = 0, $USD = 0, $show = 'USD')
    {

        if (!$NGR && !$USD) {
            return 'Negotiable';
        } else {
            return ($show == 'NGR')
                ? '$ ' . self::priceFormat($NGR)
                : '$ ' . self::priceFormat($USD);
        }
    }

    public static function priceFormat($price = 0)
    {
        return ($price) ? number_format($price, 0) : 0;
    }

    public static function getArea($url = 'search', $vehicle_type = 0)
    {
        //spare-parts
        $CI =& get_instance();
        $areas = $CI->db
            ->where(['is_home' => 'Yes'])
            ->where('type', 'state')
            ->get('post_area')
            ->result();

        //echo $CI->db->last_query();

        $html = '';
//        $html .= '<div class="title-product">Location</div>';
//        $html .= '<div class="list-group">';

//        foreach ($areas as $area) {
//            $html .= '<a  class="list-group-item" href="' . $url . '?location_id=' . intval($area->id) . '">';
//            $html .= '<i class="fa fa-map-marker"></i> &nbsp;' . $area->name;
//            $html .= '<span> &nbsp;' . self::countPostByState($area->id, $vehicle_type) . '</span> <i class="fa fa-angle-right pull-right"></i></a>';
//        }
//        $html .= '</ul>';
        foreach ($areas as $area) {
            $html .= '<li><a href="' . $url . '?location_id=' . intval($area->id) . '">' . $area->name . ' <span>' . self::countPostByState($area->id, $vehicle_type) . '</span></a></li>';
        }
        return $html;
    }

    public static function countPostByState($state_id = 0, $vehicle_type = 0)
    {
        $CI =& get_instance();

        $CI->db->select('id');
        $CI->db->where('expiry_date >=', date('Y-m-d'));
        $CI->db->where('status', 'Active');
        $CI->db->where('location_id', $state_id);
        if ($vehicle_type) {
            $CI->db->where('vehicle_type_id', $vehicle_type);
        }

        return $CI->db->get('posts')->num_rows();
    }

    public static function all_location($id = 0, $label = 'Select State',$countryId = 0)
    {
        $ci =& get_instance();
        // $id = intval( $ci->input->get('location_id') );
        if ($countryId) {
            $post_areas = DB::table('post_area')->where(['type'=>'state','country_id'=>$countryId])->get();
        } else {
            $post_areas = DB::table('post_area')->where(['type'=>'state'])->get();
        }

        if ($post_areas) {
            $html = '';
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->id . '"';
                $html .= ($id == $area->id) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }
    }
    public static function all_location_multiple($id = [], $label = 'Select State',$countryId = 155)
    {

        $countryId = empty($countryId) ? 155 : $countryId;
        $ci =& get_instance();
        // $id = intval( $ci->input->get('location_id') );
        $post_areas = DB::table('post_area')->where(['type'=>'state','country_id'=>$countryId])->get();
        if ($post_areas) {
            $html = '';
            if (empty($id)){
                $html .='<option value="" disabled selected>select State</option>';
            }
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->id . '"';
                $html .= (!empty($id) && in_array($area->id,$id) ) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }
    }
    public static function state_for_profile($id = [], $label = 'Select State',$countryId = 155)
    {
        $ci =& get_instance();
        $post_areas = DB::table('post_area')->where(['type'=>'state','country_id'=>$countryId])->get();

        if ($post_areas) {
            $html = '';
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->id . '"';
                $html .= (in_array($area->id, $id)) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }
    }

    public static function state_for_profile_frontend($id = [0])
    {
        $ci =& get_instance();
        $post_areas = DB::table('post_area')->whereIn('id', $id)->where(['type'=>'state'])->get();

        if ($post_areas) {
            $html = '';
            foreach ($post_areas as $area) {
                $html .= '<li><span class="material-icons">check_circle</span>' . $area->name . '</li>';
            }
            return $html;
        } else {
            return '<li>No Data</li>';
        }
    }

    public static function state_for_profile_API($id = [0])
    {
        $ci =& get_instance();
        $post_areas = DB::table('post_area')->whereIn('id', $id)->where(['type'=>'state'])->get();

        if ($post_areas) {
            $html = [];
            foreach ($post_areas as $k=>$area) {
                $html[$k] = $area->name ;
            }
            return $html;
        } else {
            return [];
        }
    }

    public static function all_location_loan($id = 0, $label = 'Select State')
    {
        $ci =& get_instance();
        // $id = intval( $ci->input->get('location_id') );
        if ($id != 44) {
            $post_areas = DB::table('post_area')->where('type', 'state')->where('id', $id)->get();
        } else {
            $post_areas = DB::table('post_area')->where('type', 'state')->get();
        }

        if ($post_areas) {
            $html = '<option value="" selected disabled>'.$label.'</option>';
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->id . '"';
                $html .= ($id == $area->id) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }
    }

    public static function all_location_loan_frontview($id = 0, $label = 'Select State')
    {
        $ci =& get_instance();
        // $id = intval( $ci->input->get('location_id') );
        if ($id != 41) {
            $post_areas = DB::table('post_area')->where('type', 'state')->where('id', $id)->get();
        } else {
            $post_areas = DB::table('post_area')
                ->where('id','!=',$id)
                ->where('type', 'state')->get();
        }
        if ($post_areas) {
            $html = '<option value="" selected disabled>'.$label.'</option>';
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->id . '"';
                $html .= ($id == $area->id) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }
    }
    public static function all_location_select($id = 0, $label = 'Select State', $country_id = 155)
    {
        $ci =& get_instance();
        $post_areas = DB::table('post_area')
            ->where('type', 'state')
            ->where('country_id', $country_id)
            ->orderBy('name', 'ASC')->get();


        if ($post_areas) {
            $html = '<option value="" selected disabled>'.$label.'</option>';
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->slug . '"';
                $html .= ($id === $area->slug) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }
    }

    public static function all_location_select_by_id($id = 0, $label = 'Select State', $country_id = 155)
    {
        $ci =& get_instance();
        $post_areas = DB::table('post_area')
            ->where('type', 'state')
            ->where('country_id', $country_id)
            ->orderBy('name', 'ASC')->get();


        if ($post_areas) {
            $html = '<option value="" selected disabled>'.$label.'</option>';
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->id . '"';
                $html .= ($id == $area->id) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }
    }

    public static function all_city($state_id = 0, $city= '', $label = 'Select Location')
    {
        $ci =& get_instance();
        // $id = intval( $ci->input->get('location_id') );
        if (!in_array($state_id, [0, 41])) {
            $post_areas = DB::table('state_towns')->whereRaw("FIND_IN_SET('2',state_towns.type) <> 0")->where('state_id', $state_id)->get();
        } else {
            $post_areas = DB::table('state_towns')->whereRaw("FIND_IN_SET('2',state_towns.type) <> 0")->get();
        }

        if ($post_areas) {
            $html = '<option value="" selected disabled>' . $label . '</option>';
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->name . '"';
                $html .= ($city === $area->name) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }
    }

    public static function all_city_slug($id = 0, $label = 'Select Location')
    {
        $ci =& get_instance();
        // $id = intval( $ci->input->get('location_id') );
        if ($id != 0) {
            $post_areas = DB::table('state_towns')->whereRaw("FIND_IN_SET('2',state_towns.type) <> 0")->where('state_id', $id)->get();
        } else {
            $post_areas = DB::table('state_towns')->whereRaw("FIND_IN_SET('2',state_towns.type) <> 0")->get();
        }

        if ($post_areas) {
            $html = '<option value="" selected disabled>' . $label . '</option>';
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->slug . '"';
                $html .= ($id === $area->name) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }
    }
    public static function location_for_profile($id = [], $state = [])
    {
        $ci =& get_instance();

        if (!empty($state)) {
            $post_areas = DB::table('post_area')
                ->whereIN('parent_id', $state)
                ->where('type', 'location')
                ->get();
        } else {
            $post_areas = DB::table('post_area')->where('type', 'location')->get();
        }

        if ($post_areas) {
            $html = '';
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->id . '"';
                $html .= (in_array($area->id, $id)) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }
    }

    public static function location_for_profile_frontend($id = [0])
    {
        $ci =& get_instance();

        if (!empty($id)) {
            $post_areas = DB::table('post_area')
                ->whereIN('id', $id)
                ->where('type', 'location')
                ->get();
        }

        if ($post_areas) {
            $html = '';
            foreach ($post_areas as $area) {
                $html .= '<li><span class="material-icons">check_circle</span>' . $area->name . '</li>';
            }
            return $html;
        } else {
            return '<li>No data</li>';
        }
    }

    public static function location_for_profile_API($id = [0])
    {
        $ci =& get_instance();
        if (!empty($id)) {
            $post_areas = DB::table('post_area')
                ->whereIN('id', $id)
                ->where('type', 'location')
                ->get();
        }

        if ($post_areas) {
            $html = [];
            foreach ($post_areas as $k => $area) {
                $html[$k] = $area->name ;
            }
            return $html;
        } else {
            return [];
        }
    }

    public static function all_city_mechanic($slug = 0, $state_slug = null, $label = 'Select Location')
    {
        $ci =& get_instance();
        // $id = intval( $ci->input->get('location_id') );
        if (!empty($state_slug)) {
            $post_areas = DB::table('state_towns')
                ->select('state_towns.*')
                ->join('post_area as parent', 'parent.id','=','state_towns.state_id')
                ->whereRaw("FIND_IN_SET('2',state_towns.type) <> 0")
                ->where('parent.slug', $state_slug)
                ->get();
        } else {
            $post_areas = DB::table('state_towns')->get();
        }

        if ($post_areas) {
            $html = '<option value="" selected disabled>' . $label . '</option>';
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->name . '"';
                $html .= ($slug == $area->name) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }
    }

    public static function getDropDownVehicleType($id = 0, $col = 'id')
    {
        $types = DB::table('vehicle_types')->whereNotIn('id', [7])->get();

        if ($types) {
            $html = '<option value="0">--Select Type--</option>';

            foreach ($types as $type) {
                $html .= '<option value="' . $type->{$col} . '"';
                $html .= ($type->{$col} == $id) ? ' selected="selected"' : '';
                $html .= '>' . $type->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }

    }

    // using  in  driver  hire page
    public static function getDropDownVehicleType2()
    {
        $types = [
            'Cars' => 'Cars',
            'Lorry' => 'Lorry',
            'Bus/Van' => 'Bus/Van',
            'Motorbike' => 'Motorbike',
            'Heavy Vehicles' => 'Heavy Vehicles'
        ];

        $html = '<option value="0">--Select Type--</option>';

        foreach ($types as $k => $type) {
            $html .= '<option value="' . $type . '"';
            // $html .= ($ ) ? ' selected="selected"' : '';
            $html .= '>' . $type . '</option>';
        }
        return $html;


    }

    public static function showLetest($post_date = null, $latest = 7)
    {
        if ($post_date && $post_date != '0000-00-00') {

            $post_day_before = ceil((time() - strtotime($post_date)) / 86400);
            if ($latest >= $post_day_before) {
                return '<span>Latest</span> ';
            }
        }
    }

    static private function my_ajax_paination($page = 'search')
    {
        $ci =& get_instance();

        $array = $_GET;
        $url = ($page) . '?';

        unset($array['page']);
        unset($array['_']);

        if ($array) {
            $url .= \http_build_query($array);
        }
        $url .= '&page';
        return $url;

    }

    static public function getUserMetaData($user_id = 0)
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

    static public function getUserProfilePhoto($photo = null, $alt = "image")
    {

        $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $photo;
        if ($photo && file_exists($photofile)) {
            return '<img alt="' . $alt . '" class="img-responsive lazyload" src="uploads/company_logo/' . $photo . '"/>';
        } else {
            return '<img alt="' . $alt . '"
             class="img-responsive lazyload" src="assets/theme/new/images/no-photo.png"/>';
        }

    }

    static public function getProfilePhoto($photo = null, $alt = "image", $class = '')
    {

        $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $photo;
        if ($photo && file_exists($photofile)) {
            return '<img alt="' . $alt . '" class="'.$class.'" src="uploads/company_logo/' . $photo . '"/>';
        } else {
            return '<img alt="' . $alt . '" class="'.$class.'" src="assets/theme/new/images/no-photo.png"/>';
        }

    }

    static public function getPrivateProfilePhoto($photo = null, $alt = "image", $oauth_provider = 'web', $class = '')
    {
        $photofile = $oauth_provider == 'web' ? (($photo) ? dirname(BASEPATH) . '/uploads/users_profile/' . $photo : 'assets/theme/new/images/no-photo.png') : $photo;

        if ($photo && file_exists($photofile)) {
            return '<img  class="lazyload '.$class.'" alt="' . $alt . '" src="uploads/users_profile/' . $photo . '"/>';
        } else {
            return '<img  class="lazyload '.$class.'" alt="' . $alt . '" src="assets/theme/new/images/no-photo.png"/>';
        }

    }

    static public function getNewUserProfilePhoto($photo = null, $alt = "image")
    {

        $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $photo;
        if ($photo && file_exists($photofile)) {
            return '<img alt="' . $alt . '" class="img-responsive lazyload" src="uploads/company_logo/' . $photo . '"/>';
        } else {
            return '<img alt="' . $alt . '" class="img-responsive lazyload" src="assets/theme/new/images/backend/img.svg"/>';
        }

    }

    static public function getSellrCoverPhoto($photo = null, $alt = "image")
    {

        $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $photo;
        if ($photo && file_exists($photofile)) {
            return '<img alt="' . $alt . '" class="img-responsive lazyload" src="uploads/company_logo/' . $photo . '"/>';
        } else {
            return '<img alt="' . $alt . '" class="img-responsive lazyload" src="uploads/company_logo/no_cover.png"/>';
        }

    }

    static public function getrCoverPhoto($photo = null, $alt = "image")
    {

        $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $photo;
        if ($photo && file_exists($photofile)) {
            return '<img class="lazyload" alt="' . $alt . '" src="uploads/company_logo/' . $photo . '"/>';
        } else {
            return '<img class="lazyload" alt="' . $alt . '" src="assets/theme/new/images/banner2.jpg"/>';
        }

    }

    static public function getNewSellrCoverPhoto($photo = null, $alt = "image")
    {

        $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $photo;
        if ($photo && file_exists($photofile)) {
            return '<img  alt="' . $alt . '" class="img-responsive lazyload" src="uploads/company_logo/' . $photo . '"/>';
        } else {
            return '<img  alt="' . $alt . '" class="img-responsive lazyload" src="assets/theme/new/images/backend/img.svg"/>';
        }

    }

    static public function getSellrCompanyPhoto($photo = null, $alt = "image", $class = 'img-responsive lazyload')
    {

        $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $photo;
        if ($photo && file_exists($photofile)) {
            return '<img  alt="' . $alt . '" class="' . $class . '" src="uploads/company_logo/' . $photo . '"/>';
        } else {
            return '<img  alt="' . $alt . '" class="' . $class . '" src="assets/theme/new/images/no-photo.png"/>';
        }

    }

    static public function getUserPhoto($photo = null, $alt = "image", $class = 'img-responsive lazyload')
    {

        $photofile = dirname(BASEPATH) . '/uploads/users_profile/' . $photo;
        if ($photo && file_exists($photofile)) {
            return '<img  alt="' . $alt . '" class="' . $class . '" src="uploads/users_profile/' . $photo . '"/>';
        } else {
            return '<img  alt="' . $alt . '" class="' . $class . '" src="assets/theme/new/images/no-photo.png"/>';
        }

    }

    static public function getSellrSocialLinks($meta = null)
    {

        $social_links = isset($meta['social_links'])
            ? json_decode($meta['social_links'], true)
            : null;

        if (is_array($social_links)) {
            $links = [
                'icon_fb' => ($social_links['Facebook']),
                'icon_tw' => ($social_links['Twitter']),
                'icon_yt' => ($social_links['Youtube']),
                'icon_sc' => ($social_links['Snapchat']),
                'icon_ig' => ($social_links['Instragram']),
                'icon_sn' => ($social_links['Snapchat']),
                'icon_sk' => ($social_links['Skype']),
                'icon_in' => ($social_links['Linkedin']),
            ];

            $html = '';
            $html .= '<ul class="social-ul">';
            foreach ($links as $key => $link) {
                if ($link != '') {
                    $html .= '<li class="social-li"><a href="' . $link . '">';
                    $html .= '<img class="lazyload" alt="image" src="assets/theme/images/social/' . $key . '.png">';
                    $html .= '</a></li>';
                }
            }
            $html .= '</ul>';
            return $html;
        }
    }


    static public function getSellerInfo($user_id = 0, $title=null, $post_slug=null, $post_id=null)
    {
        $ci =& get_instance();

        $role_id = $ci->db->select('role_id')->where('id', $user_id)->get('users')->row();


        if ($role_id && $role_id->role_id == 5) {
            $ci->db->from('users');
            $ci->db->select('users.id, first_name,last_name,add_line1,add_line2,email,contact,contact1,contact2,role_id,user_profile_image');
            $ci->db->join('user_meta', 'user_meta.user_id = users.id', 'left');
            //  $ci->db->join('cms', 'cms.user_id = users.id', 'left');
            //  $ci->db->where('meta_key', 'userLocation');
            $ci->db->where('users.id', $user_id);
            $seller = $ci->db->get()->row();

        } else {
            $ci->db->from('users');
            $ci->db->select('users.id, first_name,last_name,add_line1,add_line2,email,meta_value,contact,contact1,contact2,role_id, profile_photo, post_title, post_url, thumb');
            $ci->db->join('user_meta', 'user_meta.user_id = users.id', 'left');
            $ci->db->join('cms', 'cms.user_id = users.id', 'left');
            $ci->db->where('meta_key', 'userLocation');
            $ci->db->where('users.id', $user_id);
            $seller = $ci->db->get()->row();

            $meta_data = self::getUserMetaData($user_id);

        }

        //dd($seller);
        //exit;


        /*
        $address = ($seller->meta_value)
                        ? $seller->meta_value
                        : $seller->add_line1 .'<br/>'. $seller->add_line2;
        */

        // dd($seller);

        $html = '';
        if ($seller) {
            $pic = 'assets/new-theme/images/logo-c.svg';
            if ($seller->role_id == 4){
                $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $seller->profile_photo;
                if ($seller->profile_photo && file_exists($photofile)) {
                    $pic = base_url(). '/uploads/company_logo/' . $seller->profile_photo;
                }
            } else {
                $photofile = dirname(BASEPATH) . '/uploads/users_profile/' . $seller->user_profile_image;
                if ($seller->user_profile_image && file_exists($photofile)) {
                    $pic = base_url(). '/uploads/users_profile/' . $seller->user_profile_image;
                }
            }
            if ($seller->role_id == 4 || $seller->role_id == 8) {
                $whatsapp = "onclick="."\"window.open('https://wa.me/" . GlobalHelper::wahtsAppNo($user_id) . "/?text=" . $title . " " . urldecode(site_url("post/" . $post_slug)) . "')\"";
                $getQuote = "onclick=\"get_quote(" . $post_id . "," . $user_id . ",'" . $post_slug . "')\"";
                $html .= "<div class='seller-details-wrap'>
                        <div class='seller-details-top'>
                            <span>Seller Details</span>
                            <a class='waves-effect btnStyle btnStyleOutline modal-trigger' href='javascript:void(0)' id='get_quote' >Make
                                an
                                Offer</a>
                        </div>
                        <div class='seller-details-info'>
                            <a href='" . @$seller->post_url . "' class='seller-logo'>
                                <img src='" . $pic . "' alt=''>
                            </a>
                            <h4><a href='" . @$seller->post_url . "'>" . $seller->post_title . "</a>". GlobalHelper::seller_badge($user_id) ."</h4>
                        </div>
                        <ul class='seller-contact'>
                            <li><span class='material-icons'>location_on</span> " . $seller->add_line1 . '<br/>' . $seller->add_line2 . "</li>
                            <li><a href='tel:" . $seller->contact . "'><span class='material-icons'> call</span>" . $seller->contact . "</a></li>
                            <li><a href='javascript:void(0)' " . $whatsapp . " ><i class='fa fa-whatsapp'></i> WhatsApp Message</a></li>
                        </ul>
                        <div class='p20'>
                            <a class='btnStyle waves-effect modal-trigger' href='#contactSeller'>Contact Seller</a>
                        </div>
                    </div>";

            } elseif ($seller->role_id == 5) {


                $whatsapp = "onclick=\"window.open('https://wa.me/" . GlobalHelper::wahtsAppNo($user_id) . "/?text=" . $title . " " . urldecode(site_url('post/' . $post_slug)) . "')\"";
                $html .= "<div class='seller-details-wrap'>
                        <div class='seller-details-top'>
                            <span>Seller Details</span>
                            <a class='waves-effect btnStyle btnStyleOutline modal-trigger' href='#makeAnOffer' id='get_quote' >Make
                                an
                                Offer</a>
                        </div>
                        <div class='seller-details-info'>
                            <a href='" . site_url('private-seller/' . $seller->id) . "' class='seller-logo'>
                                <img src='" . $pic . "' alt=''>
                            </a>
                            <h4><a href='" . site_url('private-seller/' . $seller->id) . "'>" . $seller->first_name . " " . $seller->last_name . "</a></h4>
                        </div>
                        <ul class='seller-contact'>
                            <li><span class='material-icons'>location_on</span> " . $seller->add_line1 . '<br/>' . $seller->add_line2 . "</li>
                            <li><a href='tel:" . $seller->contact . "'><span class='material-icons'> call</span>" . $seller->contact . "</a></li>
                            <li><a href='javascript:void(0)' " . $whatsapp . " ><i class='fa fa-whatsapp'></i> WhatsApp Message</a></li>
                        </ul>
                        <div class='p20'>
                            <a class='btnStyle waves-effect modal-trigger' href='#contactSeller'>Contact Seller</a>
                        </div>
                    </div>";

            } else {

                $whatsapp = "onclick=\"window.open('https://wa.me/" . GlobalHelper::wahtsAppNo($user_id) . "/?text=" . $title . " " . urldecode(site_url('post/' . $post_slug)) . ")";
                $html .= "<div class='seller-details-wrap'>
                        <div class='seller-details-top'>
                            <span>Seller Details</span>
                            <a class='waves-effect btnStyle btnStyleOutline  modal-trigger' href='#makeAnOffer'>Make
                                an
                                Offer</a>
                        </div>
                        <div class='seller-details-info'>
                            <a href='javascript:void(0)' class='seller-logo'>
                                <img src='" . $pic . "' alt=''>
                            </a>
                            <h4><a href='javascript:void(0)'>" . $seller->first_name . " " . $seller->last_name . "</a></h4>
                        </div>
                        <ul class='seller-contact'>
                            <li><span class='material-icons'>location_on</span> " . $seller->add_line1 . '<br/>' . $seller->add_line2 . "</li>
                            <li><a href='tel:" . $seller->contact . "'><span class='material-icons'> call</span>" . $seller->contact . "</a></li>
                            <li><a href='javascript:void(0)' " . $whatsapp . " ><i class='fa fa-whatsapp'></i> WhatsApp Message</a></li>
                        </ul>
                        <div class='p20'>
                            <a class='btnStyle waves-effect modal-trigger' href='#contactSeller'>Contact Seller</a>
                        </div>
                    </div>";
            }
        }
        return $html;

    }

    static function getSellerNumber($seller_id){
        $ci =& get_instance();

        $ci->db->from('users');
        $ci->db->select('users.id, first_name,last_name,add_line1,add_line2,email,contact,contact1,contact2,role_id');
        $ci->db->join('user_meta', 'user_meta.user_id = users.id', 'left');
        $ci->db->where('users.id', $seller_id);
        $seller = $ci->db->get()->row();

        if (empty($seller)){
            return  false;
        }

        if (!empty($seller->business_phone)){
            return $seller->business_phone;
        } else {
            return $seller->contact;
        }

    }


    static public function getSellerInfoAdmin($user_id = 0)
    {
        $ci =& get_instance();

        $role_id = $ci->db->select('role_id')->where('id', $user_id)->get('users')->row();


        if ($role_id && $role_id->role_id == 5) {
            $ci->db->from('users');
            $ci->db->select('users.id, first_name,last_name,add_line1,add_line2,email,contact,contact1,contact2,role_id');
            $ci->db->join('user_meta', 'user_meta.user_id = users.id', 'left');
            $ci->db->where('users.id', $user_id);
            $seller = $ci->db->get()->row();

        } else {
            $ci->db->from('users');
            $ci->db->select('users.id, first_name,last_name,add_line1,add_line2,email,meta_value,contact,contact1,contact2,role_id, profile_photo, post_title, post_url, thumb');
            $ci->db->join('user_meta', 'user_meta.user_id = users.id', 'left');
            $ci->db->join('cms', 'cms.user_id = users.id', 'left');
            $ci->db->where('meta_key', 'userLocation');
            $ci->db->where('users.id', $user_id);
            $seller = $ci->db->get()->row();

        }
        $html = '';
        if ($seller) {


            if ($seller->role_id == 4 || $seller->role_id == 8) {

                $html .= "<div class='seller-details-wrap bg-white'>
                        <div class='seller-details-top'>
                            <span>Seller Details</span>
                            <a class='waves-effect btnStyle btnStyleOutline modal-trigger' href='javascript:void(0)' >Make
                                an
                                Offer</a>
                        </div>
                        <div class='seller-details-info'>
                            <a href='javascript:void(0)' class='seller-logo'>
                                <img src='assets/new-theme/images/logo-c.svg' alt=''>
                            </a>
                            <h4><a href='javascript:void(0)'>" . $seller->post_title . "</a></h4>
                        </div>
                        <ul class='seller-contact'>
                            <li><span class='material-icons'>location_on</span> " . $seller->add_line1 . '<br/>' . $seller->add_line2 . "</li>
                            <li><a href='javascript:void(0)'><span class='material-icons'> call</span>" . $seller->contact . "</a></li>
                            <li><a href='javascript:void(0)'><i class='fa fa-whatsapp'></i> WhatsApp Message</a></li>
                        </ul>
                        <div class='p20'>
                            <a class='btnStyle waves-effect modal-trigger' href='javascript:void(0)'>Contact Seller</a>
                        </div>
                    </div>";

            } elseif ($seller->role_id == 5) {
                $html .= "<div class='seller-details-wrap bg-white'>
                        <div class='seller-details-top'>
                            <span>Seller Details</span>
                            <a class='waves-effect btnStyle btnStyleOutline  modal-trigger' href='javascript:void(0)'>Make
                                an
                                Offer</a>
                        </div>
                        <div class='seller-details-info'>
                            <a href='javascript:void(0)' class='seller-logo'>
                                <img src='assets/new-theme/images/logo-c.svg' alt=''>
                            </a>
                            <h4><a href='javascript:void(0)'>" . $seller->first_name . " " . $seller->last_name . "</a></h4>
                        </div>
                        <ul class='seller-contact'>
                            <li><span class='material-icons'>location_on</span> " . $seller->add_line1 . '<br/>' . $seller->add_line2 . "</li>
                            <li><a href='javascript:void(0)'><span class='material-icons'> call</span>" . $seller->contact . "</a></li>
                            <li><a href='javascript:void(0)'  ><i class='fa fa-whatsapp'></i> WhatsApp Message</a></li>
                        </ul>
                        <div class='p20'>
                            <a class='btnStyle waves-effect modal-trigger' href='javascript:void(0)'>Contact Seller</a>
                        </div>
                    </div>";

            } else {
                $html .= "<div class='seller-details-wrap bg-white'>
                        <div class='seller-details-top'>
                            <span>Seller Details</span>
                            <a class='waves-effect btnStyle btnStyleOutline  modal-trigger' href='javascript:void(0)'>Make
                                an
                                Offer</a>
                        </div>
                        <div class='seller-details-info'>
                            <a href='javascript:void(0)' class='seller-logo'>
                                <img src='assets/new-theme/images/logo-c.svg' alt=''>
                            </a>
                            <h4><a href='javascript:void(0)'>" . $seller->first_name . " " . $seller->last_name . "</a></h4>
                        </div>
                        <ul class='seller-contact'>
                            <li><span class='material-icons'>location_on</span> " . $seller->add_line1 . '<br/>' . $seller->add_line2 . "</li>
                            <li><a href='tel:javascript:void(0)'><span class='material-icons'> call</span>" . $seller->contact . "</a></li>
                            <li><a href='javascript:void(0)' ><i class='fa fa-whatsapp'></i> WhatsApp Message</a></li>
                        </ul>
                        <div class='p20'>
                            <a class='btnStyle waves-effect modal-trigger' href='javascript:void(0)'>Contact Seller</a>
                        </div>
                    </div>";
            }
        }
        return $html;

    }


    static public function isVerified($user_id = 0)
    {
        $ci =& get_instance();
        $data = $ci->db->select('meta_value')
            ->where('user_id', $user_id)
            ->where('meta_key', 'seller_tag')
            ->get('user_meta')->row();
        if ($data) {
            return ucwords($data->meta_value);
        } else {
            return NULL;
        }
    }

    static public function getCompanyInfo($user = null, $meta = null, $seller = null)
    {
        $title = isset($seller['post_title']) ? $seller['post_title'] : '';
        $id = sprintf('%05d', $seller['user_id']);
        $location = isset($meta['userLocation']) ? $meta['userLocation'] : '';
        $contact = isset($user['contact']) ? $user['contact'] : '';
        $html = '<h4>' . $title . '</h4>
                    <ul>
                        <li  class="seller_user_id" data-seller_user_id="' . $seller['user_id'] . '">ID# ' . $id . '</li>
                        <li>' . $location . '</li>
                        <li>' . $contact . '</li>
                    </ul>';

        return $html;

    }

    static public function getSellers()
    {
        $ci =& get_instance();
        $q = $ci->input->get('q');

        $ci->db->from('cms');
        $ci->db->order_by('users.id', 'ASC');
        $ci->db->join('users', 'users.id = cms.user_id', 'left');
        $ci->db->join('user_meta', 'user_meta.user_id = users.id', 'left');
        $ci->db->where('post_type', 'business');
        $ci->db->where('meta_key', 'userLocation');
        $ci->db->where('users.status', 'Active');

        if ($q) {
            $ci->db->group_start();
            $ci->db->like('email', $q);
            $ci->db->or_like('contact', $q);
            $ci->db->or_like('users.id', $q);
            $ci->db->or_like('first_name', $q);
            $ci->db->or_like('last_name', $q);
            $ci->db->or_like('meta_value', $q);
            $ci->db->or_like('post_title', $q);
            $ci->db->group_end();
        }

        $ci->db->group_by('users.id');
        $config['total_rows'] = $ci->db->get()->num_rows();

        $limit = 21;
        $start = intval($ci->input->get('start'));
        $config['base_url'] = site_url('seller?q=' . $q . '&');
        $config['first_url'] = site_url('seller?q=' . $q . '&');
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
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

        $ci->db->from('cms');
        $ci->db->select('cms.user_id,profile_photo as logo,first_name,last_name,email,contact,post_title,post_url,thumb,users.created,user_meta.meta_value,user_meta.meta_key');
        $ci->db->order_by('users.id', 'ASC');
        $ci->db->limit($limit, $start);
        $ci->db->join('users', 'users.id = cms.user_id', 'left');
        $ci->db->join('user_meta', 'user_meta.user_id = users.id', 'left');
        $ci->db->where('post_type', 'business');
        $ci->db->where('meta_key', 'userLocation');
        $ci->db->where('users.status', 'Active');

        if ($q) {
            $ci->db->group_start();
            $ci->db->like('email', $q);
            $ci->db->or_like('contact', $q);
            $ci->db->or_like('users.id', $q);
            $ci->db->or_like('first_name', $q);
            $ci->db->or_like('last_name', $q);
            $ci->db->or_like('meta_value', $q);
            $ci->db->or_like('post_title', $q);
            $ci->db->group_end();
        }

        $ci->db->group_by('users.id');
        $sellers = $ci->db->get()->result();

        $ci->load->library('pagination');
        $ci->pagination->initialize($config);

        return ['sellers' => $sellers, 'pagination' => $ci->pagination->create_links()];
    }

//    static public function getSellers()
//    {
//
//        $ci =& get_instance();
//        $q = $ci->input->get('q');
//
//
//        $ci->db->from('cms');
//        $ci->db->order_by('users.id', 'ASC');
//        $ci->db->join('users', 'users.id = cms.user_id', 'left');
//        $ci->db->join('user_meta', 'user_meta.user_id = users.id', 'left');
//        $ci->db->where('post_type', 'business');
//        $ci->db->where('meta_key', 'userLocation');
//        $ci->db->where('users.status', 'Active');
//        if ($q) {
//            $ci->db->where("( email LIKE '%$q%' ESCAPE '!'");
//            $ci->db->or_like('contact', $q);
//            $ci->db->or_like('first_name', $q);
//            $ci->db->or_like('last_name', $q);
//            $ci->db->or_like('meta_value', $q);
//            $ci->db->or_like('cms.user_id', $q);
//            $ci->db->where("cms.post_title LIKE '%$q%' ESCAPE '!')");
//        }
//        $ci->db->group_by('users.id');
//        $total_row = $ci->db->get()->num_rows();
//
//
//        $page = intval($ci->input->get('page'));
//        $limit = 20;
//
//
//        $targetpath = 'seller?q=' . $q . '&page';
//        $start = startPointOfPagination($limit, $page);
//        $html = getPaginator($total_row, $page, $targetpath, $limit);
//
//        $start = intval($ci->input->get('seller'));
//        $config['base_url'] =  site_url('seller');
//        $config['first_url'] = site_url('seller');
//        $config['per_page'] = $limit;
//        $config['page_query_string'] = TRUE;
//        $config['query_string_segment'] = 'start';
//
//        $config['num_links'] = 1;
//
//        $config['full_tag_open'] = '<div class="col-12 text-center"><ul class="pagination-wrap float-none">';
//        $config['full_tag_close'] = '</ul></div>';
//
//        $config['first_link'] = false;
//        $config['first_tag_open'] = '<li>';
//        $config['first_tag_close'] = '</li>';
//
//        $config['last_link'] = false;
//        $config['last_tag_open'] = '<li>';
//        $config['last_tag_close'] = '</li>';
//
//        $config['next_link'] = '<i class="fa fa-angle-right"></i>';
//        $config['next_tag_open'] = '<li class="prev">';
//        $config['next_tag_close'] = '</li>';
//
//        $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
//        $config['prev_tag_open'] = '<li class="next">';
//        $config['prev_tag_close'] = '</li>';
//
//        $config['cur_tag_open'] = '<li><a class="active">';
//        $config['cur_tag_close'] = '</a></li>';
//
//        $config['num_tag_open'] = '<li>';
//        $config['num_tag_close'] = '</li>';
//
//        $ci->load->library('pagination');
//        $ci->pagination->initialize($config);
//
//        $ci->db->from('cms');
//        $ci->db->select('cms.user_id,profile_photo as logo,first_name,last_name,email,contact,post_title,post_url,thumb,users.created,user_meta.meta_value,user_meta.meta_key');
//        $ci->db->order_by('users.id', 'ASC');
//        $ci->db->limit($limit, $start);
//        $ci->db->join('users', 'users.id = cms.user_id', 'left');
//        $ci->db->join('user_meta', 'user_meta.user_id = users.id', 'left');
//        $ci->db->where('post_type', 'business');
//        $ci->db->where('meta_key', 'userLocation');
//        $ci->db->where('users.status', 'Active');
//
//        if ($q) {
//            $ci->db->where("( email LIKE '%$q%'");
//            $ci->db->or_like('contact', $q);
//            $ci->db->or_like('users.id', $q);
//            $ci->db->or_like('first_name', $q);
//            $ci->db->or_like('last_name', $q);
//            $ci->db->or_like('meta_value', $q);
//            $ci->db->where("cms.post_title LIKE '%$q%')");
//        }
//        $ci->db->group_by('users.id');
//
//        $sellers = $ci->db->get()->result();
//
//        //echo '<pre>';
//        //print_r( $ci->db->last_query() );
//
//        return ['sellers' => $sellers, 'pagination' => $html];
//    }

    static public function countSellerListing($seller_id = 0)
    {
        $user_id = intval($seller_id);
        return DB::table('posts')
            ->where('user_id', '=', $user_id)
            ->where('expiry_date', '>=', date('Y-m-d'))
            ->where('status', '=', 'Active')
            ->count('id');
    }

    static public function getTypeIdByPageSlug($page_slug = '')
    {

        $type = DB::table('vehicle_types')->where('slug', '=', $page_slug)->first();
        return ($type) ? $type->id : 0;

    }

    static public function getConditions($selected = '', $label = 'Condition')
    {

        $conditions = array(
            'New' => 'New',
            'Foreign used' => 'Used'
        );

        $html = '<option value="" selected disabled>' . $label . '</option>';
        foreach ($conditions as $key => $condition) {
            $html .= '<option value="' . $key . '"';
            $html .= ($key === $selected) ? ' selected' : '';
            $html .= '>' . $condition . '</option>';
        }
        return $html;
    }
    static public function getImportCarConditions($selected = '', $label = 'Condition')
    {

        $conditions = array(
            'New' => 'New',
            'Foreign used' => 'Foreign Used'
        );

        $html = '<option value="" selected disabled>' . $label . '</option>';
        foreach ($conditions as $key => $condition) {
            $html .= '<option value="' . $key . '"';
            $html .= ($key === $selected) ? ' selected' : '';
            $html .= '>' . $condition . '</option>';
        }
        return $html;
    }
    static public function getConditionsLoan($selected = '', $label = 'Any Condition')
    {

        $conditions = array(
            'All' => 'All',
            'New' => 'New',
            'Foreign used' => 'Foreign Used'
        );

        $html = '<option value="" selected disabled>' . $label . '</option>';
        foreach ($conditions as $key => $condition) {
            $html .= '<option value="' . $key . '"';
            $html .= ($key === $selected) ? ' selected' : '';
            $html .= '>' . $condition . '</option>';
        }
        return $html;
    }
    static public function getConditionsLoanMultiple($selected = [], $label = 'Any Condition')
    {

        $conditions = array(
            'All' => 'All',
            'New' => 'New',
            'Foreign used' => 'Foreign Used'
        );
        $html  = '';
        if (empty($selected)){
            $html .= '<option value="" selected disabled>' . $label . '</option>';
        }
        foreach ($conditions as $key => $condition) {
            $html .= '<option value="' . $key . '"';
            $html .= ( !empty($selected) && in_array($key,$selected)) ? ' selected' : '';
            $html .= '>' . $condition . '</option>';
        }
        return $html;
    }
    static public function getConditionsApi($selected = '', $label = 'Any Condition')
    {

        $conditions = array(
            'New' => 'New',
            'Foreign used' => 'Foreign Used'
        );
        return $conditions;
    }

    public static function switchStatus($status = 'Active')
    {
        switch ($status) {
            case 'Active':
                $status = ['<i class="fa fa-check-square-o"></i>', 'Active', 'success'];
                break;
            case 'Inactive':
                $status = ['<i class="fa fa-ban"></i>', 'Inactive', 'warning'];
                break;
            case 'Pending':
                $status = ['<i class="fa fa-hourglass-start"></i>', 'Pending', 'info'];
                break;
            case 'Sold':
                $status = ['<i class="fa fa-dollar"></i>', 'Sold', 'danger'];
                break;
            default :
                $status = ['<i class="fa fa-ban"></i>', 'Inactive', 'default'];
        }
        return '<span class="label label-' . $status[2] . '">' . $status[0] . ' ' . $status[1] . '</span>';

        /*
        $CI =& get_instance();
        return ($CI->input->is_ajax_request()) ?  $status : $status[0] .' '. $status[1];
         *
         */
    }

    public static function getNewStatus($status = 'Active')
    {
        switch ($status) {
            case 'Active':
                $status = ['<i class="fa fa-check-square-o"></i>', 'Active', 'success'];
                break;
            case 'Inactive':
                $status = ['<i class="fa fa-ban"></i>', 'Inactive', 'warning'];
                break;
            case 'Pending':
                $status = ['<i class="fa fa-hourglass-start"></i>', 'Pending', 'info'];
                break;
            case 'Sold':
                $status = ['<i class="fa fa-dollar"></i>', 'Sold', 'danger'];
                break;
            default :
                $status = ['<i class="fa fa-ban"></i>', 'Inactive', 'default'];
        }

        return $status;
    }

    public static function newSwitchStatus($status = 'Active')
    {
        switch ($status) {
            case 'Active':
                $status = ['Active', 'active'];
                break;
            case 'Inactive':
                $status = ['<i class="fa fa-ban"></i>', 'Inactive', 'warning'];
                break;
            case 'Pending':
                $status = ['Pending', 'pending'];
                break;
            case 'Sold':
                $status = ['Sold', 'success'];
                break;
            default :
                $status = ['Inactive', 'danger'];
        }
        return '<span class="badge-wrap bg-' . $status[1] . '">' . $status[0] . '</span>';
    }

    // This Function Not in use...
    public static function getStatus($status = 'Pending', $post_id = 0, $access = false)
    {

        $currentStatus = GlobalHelper::switchStatus($status);
        if ($access) {
            $string = "<div class='dropdown'>
                        <button class='btn btn-default btn-xs' id='active_status_$post_id' type='button' data-toggle='dropdown'>
                             $currentStatus &nbsp; <i class='fa fa-angle-down'></i>
                        </button>
                        <ul class='dropdown-menu'>
                            <li><a onclick=\"statusUpdate( $post_id, 'Active');\"> <i class='fa fa-check'></i> Active</a></li>
                            <li><a onclick=\"statusUpdate( $post_id, 'Inactive');\"> <i class='fa fa-ban'></i> Inactive</a></li>
                            <li><a onclick=\"statusUpdate( $post_id, 'Pending');\"> <i class='fa fa-hourglass-start'></i> Pending</a></li>
                            <li><a onclick=\"statusUpdate( $post_id, 'Sold');\"> <i class=\"fa fa-dollar\"></i> Sold</a></li>
                        </ul>
                    </div>";

        } else {
            $string = $currentStatus;
        }

        return $string;
    }


    // this function also not in use...
    public static function isFeatured($is_featured = 'No', $post_id = 0, $access = false)
    {
        $html = '';

        $html .= "<span id='featured_" . $post_id . "' class='btn  btn-xs ";
        $html .= ($is_featured == 'Yes')
            ? "btn-success'"
            : "btn-default'";
        $html .= ($access) ? "onClick='mark_featured(" . $post_id . ")'" : '';
        $html .= '>';
        $html .= ($is_featured == 'Yes')
            ? '<i class="fa fa-check-square-o"></i> Featured Listing'
            : '<i class="fa fa-ban"></i> Regular Listing';
        $html .= '</span>';
        return $html;
    }

    public static function createDropDownFromTable($table = null, $column = 'color_name', $selected = 0, $option_name = 'Select')
    {
        $ci =& get_instance();
        $results = $ci->db->from($table)->get()->result();

        $html = '';
        foreach ($results as $row) {
            $html .= '<option value="' . $row->id . '"';
            $html .= ($selected == $row->id) ? ' selected' : '';
            $html .= '>' . $row->$column . '</option>';
        }
        return $html;
    }
    public static function getVehicleBodyTypeDropdown($vehicleType = 1,$selected =0): string
    {
        $vehicleTypeName = '';
        switch ($vehicleType){
            case 1:
                $vehicleTypeName = 'Car';
                break;
            case 2:
                $vehicleTypeName = 'Van';
                break;
            case 3:
                $vehicleTypeName = 'Motorbike';
                break;
            case 4:
                $vehicleTypeName = 'Spare Parts';
                break;
            default:
                $vehicleTypeName = 'Car';
        }
        $ci =& get_instance();
        $results = $ci->db->from('body_types')->where('vehicle_type',$vehicleTypeName)->get()->result();
        $html = '';
        foreach ($results as $row) {
            $html .= '<option value="' . $row->id . '"';
            $html .= ($selected == $row->id) ? ' selected' : '';
            $html .= '>' . $row->type_name . '</option>';
        }
        return $html;
    }
    public static function getEngineTypeDropdown($vehicleType = 1,$selected = 0){
        $ci =& get_instance();
        $results = $ci->db->from('engine_sizes')->where('vehicle_type_id',$vehicleType)->get()->result();
        $html = '';
        foreach ($results as $row) {
            $html .= '<option value="' . $row->id . '"';
            $html .= ($selected == $row->id) ? ' selected' : '';
            $html .= '>' . $row->engine_size . '</option>';
        }
        return $html;
    }
    public static function getData($table = null, $selected = 0, $column = 'color_name')
    {
        $ci =& get_instance();
        $results = $ci->db->from($table)->where('id', $selected)->get()->row();

        return isset($results) ? $results->$column : "";
    }

    public static function gearBox($selected = NULL, $label = 'Transmission')
    {
        $gears = [
            'Automatic' => 'Automatic',
            'Sami Automatic' => 'Semi Automatic',
            'Manual' => 'Manual'
        ];

        $options = '<option value="" disabled selected>' . $label . '</option>';
        foreach ($gears as $key => $row) {
            $options .= '<option value="' . $key . '" ';
            $options .= ($key == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row . '</option>';
        }
        return $options;
    }

    public static function seat($selected = NULL, $label = '--Select--')
    {
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

        $options = '<option value="" disabled selected>' . $label . '</option>';
        foreach ($seats as $key => $row) {
            $options .= '<option value="' . $key . '" ';
            $options .= ($key == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row . '</option>';
        }
        return $options;
    }

    public static function wheel_list($selected = NULL, $label = '--Select Wheel Size--')
    {
        $wheels = [
            '1' => '13" Alloy Wheels',
            '2' => '14" Alloy Wheels',
            '3' => '15" Alloy Wheels',
            '4' => '16" Alloy Wheels',
            '5' => '17" Alloy Wheels',
            '6' => '18" Alloy Wheels',
            '7' => '19" Alloy Wheels',
        ];


        $options = '';
        foreach ($wheels as $key => $row) {
            $options .= '<option value="' . $key . '" ';
            $options .= ($key == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row . '</option>';
        }
        return $options;
    }

    public static function seller_status($id = NULL, $label = '--Select--')
    {

        $ci =& get_instance();
        $seller_tag = $ci->db->get_where('user_meta', ['user_id' => $id, 'meta_key' => 'seller_tag'])->row();
        $selected = isset($seller_tag) ? $seller_tag->meta_value : '';
        $status = [
            'Verified seller' => 'Verified seller',
            'Top seller' => 'Top seller'
        ];

        $options = '<option value="0">' . $label . '</option>';
        foreach ($status as $key => $row) {
            $options .= '<option value="' . $key . '" ';
            $options .= ($key == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row . '</option>';
        }
        return $options;
    }

    public static function seller_badge($user_id){
        $ci =& get_instance();
        $seller_tag = $ci->db->get_where('user_meta', ['user_id' => $user_id, 'meta_key' => 'seller_tag'])->row();
        $selected = !empty($seller_tag) ? $seller_tag->meta_value : '';
        if ($selected == 'Verified seller') {
//            return '<span style="color:green" class="material-icons ml-10">check_circle</span>';
            return '<img src="assets/new-theme/images/icons/verify-new.svg" title="Verified" alt="">';
        } elseif ($selected == 'Top seller') {
            return '<span style="color:blue" class="material-icons ml-10">check_circle</span>';
        } else{
            return '';
        }
    }
    public static function getSellerTags($user_id = null)
    {
        $ci =& get_instance();
        $seller_tag = $ci->db->get_where('user_meta', ['user_id' => $user_id, 'meta_key' => 'seller_tag'])->row();
        $status = isset($seller_tag)
            ? $seller_tag->meta_value
            : 0;
        if ($status) {
            return '<string> <i class="fa fa-check-square-o"></i> ' . $seller_tag->meta_value . '</string>';
        };

    }

    public static function getSellerTagsNew($user_id = null)
    {
        $ci =& get_instance();
        $seller_tag = $ci->db->get_where('user_meta', ['user_id' => $user_id, 'meta_key' => 'seller_tag'])->row();
        $status = isset($seller_tag)
            ? 1
            : 0;

        return $status;
    }

//    public static function postByTypeId($type_id){
//        $ci =& get_instance();
//        if($type_id){
//            $ci->db->where('vehicle_type_id', $type_id);
//        }
//        $ci->db->where('status', 'Active');
//        $ci->db->where('expiry_date >=', date('Y-m-d'));
//        return $ci->db->count_all_results('posts');
//    }

    public static function postByTypeId()
    {

        $ci =& get_instance();
        $page_slug = $ci->uri->segment('1');

        if ($page_slug == 'search') {
            @$type_id = 0;
        } else {
            $type = DB::table('vehicle_types')->where('slug', '=', $page_slug)->first();
            @$type_id = $type->id;
        }

        $ci->db->select('id');
        if ($type_id) {
            $ci->db->where('vehicle_type_id', $type_id);
        }
        $ci->db->where('status', 'Active');
        $ci->db->where('expiry_date >=', date('Y-m-d'));
        return $ci->db->count_all_results('posts');
        //return $ci->db->last_query();
    }

    public static function getAllUser($selected = 0)
    {

        $ci =& get_instance();


        $ci->db->select('first_name, last_name');
        $ci->db->where('status', 'Active');
        $ci->db->where('role_id', 5);
        $ci->db->where('role_id !=', 4);
        $users = $ci->db->get('users')->result();

        $options = '<option value="0">--Select--</option>';
        foreach ($users as $row) {
            $options .= '<option value="' . $row->id . '" ';
            $options .= ($row->id == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row->first_name . ' ' . $row->last_name . '</option>';
        }
        return $options;
    }

    static public function getBrand($type_id = 1, $selected = 0)
    {
        $ci =& get_instance();
        //$models  = $ci->db->get_where('brands', ['parent_id' => $type_id ])->result();
        //$models  = $ci->db->query('brands', ['parent_id' => $type_id ])->result();

        $models = $ci->db->query("SELECT * FROM `brands` WHERE FIND_IN_SET('$type_id',type_id) AND `type`='Brand'")->result();

        $options = '<option value="0"> Brand</option>';
        foreach ($models as $model) {
            $options .= '<option value="' . $model->id . '" ';
            $options .= ($model->id == $selected ) ? 'selected' : '';
            $options .= '>' . $model->name . '</option>';
        }
        return $options;
    }

    static public function getBrandsByType($type_id = 1)
    {
        $ci =& get_instance();

        $models = $ci->db->query("SELECT * FROM `brands` WHERE FIND_IN_SET('$type_id',type_id) AND `type`='Brand'")->result();

        $options = '<option value="0"> -- Select Brand -- </option>';
        foreach ($models as $model) {
            $options .= '<option value="' . $model->id . '" ';
            // $options .= ($model->id == $model_id ) ? 'selected="selected"' : '';
            $options .= '>' . $model->name . '</option>';
        }
        return $options;
    }

    static public function getModel($brand_id = 0)
    {
        $ci =& get_instance();
        //$models  = $ci->db->get_where('brands', ['parent_id' => $type_id ])->result();
        //$models  = $ci->db->query('brands', ['parent_id' => $type_id ])->result();

        $models = $ci->db->get_where('brands', ['type' => 'Model', 'parent_id' => $brand_id])->result();

        $options = '<option value="0"> -- Select Model -- </option>';
        foreach ($models as $model) {
            $options .= '<option value="' . $model->id . '" ';
            // $options .= ($model->id == $model_id ) ? 'selected="selected"' : '';
            $options .= '>' . $model->name . '</option>';
        }
        return $options;
    }

    static public function parts_description($selected = 0)
    {
        $ci =& get_instance();
        $parts = $ci->db->get_where('parts_description')->result();

        $options = '';
        foreach ($parts as $row) {
            $options .= '<option value="' . $row->id . '" ';
            $options .= ($row->id == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row->name . '</option>';
        }
        return $options;
    }

    static public function getParts_description($selected = 0)
    {
        $ci =& get_instance();
        $part = $ci->db->get_where('parts_description', ['id' => $selected])->row();
        return ($part) ? $part->name : 'No data';

    }

    static public function parts_categories($selected = 0, $label = 'Part Category')
    {
        $ci =& get_instance();
        $parts = $ci->db->get_where('parts_categories')->result();

        $html = '';
        foreach ($parts as $part) {
            $html .= '<option value="' . $part->id . '"';
            $html .= ($part->id == $selected) ? ' selected' : '';
            $html .= '>' . $part->category . '</option>';
        }
        return $html;
    }

    static public function all_parts_description($selected = 0, $label = 'Part Category')
    {
        $ci =& get_instance();
        $parts = $ci->db->get_where('parts_description')->result();

        return $parts;
    }

    static public function getParts_categories($selected = 0)
    {
        $ci =& get_instance();
        $part = $ci->db->get_where('parts_categories', ['id' => $selected])->row();
        if ($part) {
            return $part->category;
        } else {
            return 'No data';
        }
    }

    // Automech  functionality
    static public function getRepairType($id = 0, $label = 'Repair Type')
    {
        $id = !empty($id) ? $id : [];
        if (!is_array($id)){
            $id = [$id];
        }
        $ci =& get_instance();
        $repair_types = $ci->db->get('repair_types')->result();

        $html = '<option value="0">' . $label . '</option>';
        foreach ($repair_types as $repair_type) {
            $html .= '<option value="' . $repair_type->id . '"';
            $html .= (in_array($repair_type->id, $id)) ? ' selected' : '';
            $html .= '>' . $repair_type->title . '</option>';
        }
        return $html;
    }

    static public function getRepairTypeForFront($id = [0])
    {
        $ci =& get_instance();
        $repair_types = $ci->db->where_in('id', $id)->get('repair_types')->result();

        $html = '';
        foreach ($repair_types as $repair_type) {
            $html .= '<li><span class="material-icons">check_circle</span>' . $repair_type->title . '</li>';
        }
        return $html;
    }

    static public function getRepairTypeForAPI($id = [0])
    {
        $ci =& get_instance();
        $repair_types = $ci->db->where_in('id', $id)->get('repair_types')->result();

        $html = [];
        foreach ($repair_types as $k=>$repair_type) {
            $html[$k] = $repair_type->title;
        }
        return $html;
    }

    static public function getRepairTypeName($id = 0)
    {
        $ci =& get_instance();
        $repair_type = $ci->db->get_where('repair_types', ['id' => $id])->row();

        if ($repair_type) {
            return $repair_type->title;
        } else {
            return 'No data';
        }
    }

    static public function getSpecialism($id = 0, $label = 'Select Specialism')
    {
        $ci =& get_instance();
        $specialisms = $ci->db->get('specialism')->result();

        $html = '<option value="0">' . $label . '</option>';
        foreach ($specialisms as $specialism) {
            $html .= '<option value="' . $specialism->id . '"';
            $html .= ($id == $specialism->id) ? ' selected' : '';
            $html .= '>' . $specialism->title . '</option>';
        }
        return $html;
    }

    static public function getSpecialismForProfile($id = [], $label = 'Select Specialism')
    {
        $ci =& get_instance();
        $specialisms = $ci->db->get('specialism')->result();

        $html = '';
        foreach ($specialisms as $specialism) {
            $html .= '<option value="' . $specialism->id . '"';
            $html .= (in_array($specialism->id, $id)) ? ' selected' : '';
            $html .= '>' . $specialism->title . '</option>';
        }
        return $html;
    }

    static public function getSpecialismForFront($id = [0])
    {
        $ci =& get_instance();
        $specialisms = $ci->db->where_in('id', $id)->get('specialism')->result();

        $html = '';
        foreach ($specialisms as $specialism) {
            $html .= '<li><span class="material-icons">check_circle</span>' . $specialism->title . '</li>';
        }
        return !empty($html) ? $html : '<li>No Data</li>';
    }

    static public function getSpecialismForAPI($id = [0])
    {
        $ci =& get_instance();
        $specialisms = $ci->db->where_in('id', $id)->get('specialism')->result();

        $html = [];
        foreach ($specialisms as $k => $specialism) {
            $html[$k] = $specialism->title;
        }
        return $html;
    }

    static public function getSpecialismName($id = 0)
    {
        $ci =& get_instance();
        $specialism = $ci->db->get_where('specialism', ['id' => $id])->row();

        if ($specialism) {
            return $specialism->title;
        } else {
            return 'No data';
        }

    }

    static public function getServiceType($id = null, $label = 'Select Service')
    {
        $ci =& get_instance();
        $services = [
            'workshop' => 'Workshop',
            'service_spot' => 'Service Spot'
        ];

        $id = is_array($id) ? $id : [$id];

        $html = '<option value="0">' . $label . '</option>';
        foreach ($services as $key => $service) {
            $html .= '<option value="' . $key . '"';
            $html .= (in_array($key, $id)) ? ' selected' : '';
            $html .= '>' . $service . '</option>';
        }
        return $html;
    }

    static public function getServiceTypeName($id = 0)
    {
        $services = [
            'workshop' => 'Workshop',
            'service_spot' => 'Service Spot'
        ];

        foreach ($services as $key => $service) {
            if ($key == $id) {
                $ser = $service;
            } else {
                $ser = 'No data';
            }
        }

        return $ser;
    }


    static public function getDropDownVehicleTypeAutoMech($id = 0)
    {
        $types = [
            '1' => 'Cars/Vans',
            '3' => 'Motorcycles',
            '7' => 'Trucks/Heavy Vehicles',
        ];
        $html = '<option value="0">--Select Type--</option>';
        foreach ($types as $key => $type) {
            $html .= '<option value="' . $key . '"';
            $html .= ($key == $id) ? ' selected="selected"' : '';
            $html .= '>' . $type . '</option>';
        }
        return $html;
    }

    // with checkbox
    static public function brand_checkbox($post_id = NULL)
    {
        $ci = &get_instance();


        $selected_brands = array();
        if ($post_id) {
            $brands = $ci->db->select('brand')
                ->where('post_id', $post_id)
                ->get('brand_meta')->result();

            foreach ($brands as $brand) {
                $selected_brands[] = $brand->brand;
            }
        }


        $brands = $ci->db->where('type', 'brand')
            ->order_by('name', 'ASC')
            ->get('brands')->result();
        $options = '';
        $i = 1;
        foreach ($brands as $brand) {

            $options .= '<label class="checkbox" style="margin:0; margin-bottom:5px;"><input type="checkbox" name="brand_id[]" value="' . $brand->id . '"';
            $options .= (in_array($brand->id, $selected_brands)) ? 'checked' : '';

            $options .= '> ' . $brand->name . '</label>';
            $i++;
        }
        return $options;
    }

    static public function postBrand($post_id = 0)
    {
        $ci = &get_instance();
        $brands = $ci->db->get_where('brand_meta', ['post_id' => $post_id])->result();

        $html = '<ul class="brandListView">';
        foreach ($brands as $brand) {
            $html .= '<li><div class="label label-primary">' . getBrandNameById($brand->brand) . '</div></li>';
        }
        $html .= '</ul>';
        return @$html;
    }


    static public function getRepairTypeView($id = 0, $label = 'Select Repair Type')
    {
        $ci =& get_instance();

        $repair_type = $ci->db->get_where('repair_types', ['id' => $id])->row();
        if ($repair_type) {
            return $repair_type->title;
        } else {
            return 'No data';
        }
    }

    static public function getSpecialismView($id = 0)
    {
        $ci =& get_instance();
        $specialism = $ci->db->get_where('specialism', ['id' => $id])->row();
        if ($specialism) {
            return $specialism->title;
        } else {
            return 'No data';
        }

    }

    static public function getVehicleByPostId($post_id = 0)
    {
        $ci = &get_instance();
        $ci->db->select('vehicle_types.name');
        $ci->db->from('posts');
        $ci->db->join('vehicle_types', 'vehicle_types.id = posts.vehicle_type_id', 'LEFT');
        $ci->db->where('posts.id', $post_id);
        $post = $ci->db->get()->row();
        return ($post) ? $post->name : null;
    }


    static public function get_brands_by_vechile($vehicle_type_id = 1, $selected = 0)
    {
        $ci = &get_instance();
        $brands = $ci->db->query("SELECT * FROM brands where FIND_IN_SET('$vehicle_type_id',type_id) and type='Brand'")->result();
        $options = '';
        $options .= '';
        foreach ($brands as $row) {
            $options .= '<option value="' . $row->id . '" ';

            if ($row->id == intval($selected)) {
                $options .= ' selected="selected"';
            }
            $options .= '>' . $row->name . '</option>';
        }
        echo $options;
    }
    static public function get_brands_by_vechile_multiple($vehicle_type_id = 1, $selected = [])
    {
        $ci = &get_instance();
        $brands = $ci->db->query("SELECT * FROM brands where FIND_IN_SET('$vehicle_type_id',type_id) and type='Brand'")->result();
        $options = '';
        if (empty($selected)){
            $options .= '<option value="" disabled selected>Select Brand</option>';
        }
        foreach ($brands as $row) {
            $options .= '<option value="' . $row->id . '" ';

            if ( !empty($selected) && in_array($row->id,$selected)) {
                $options .= ' selected="selected"';
            }
            $options .= '>' . $row->name . '</option>';
        }
        echo $options;
    }
    static public function get_brands_for_select($vehicle_type_id = 1, $selected = 0)
    {
        $ci = &get_instance();
        $brands = $ci->db->query("SELECT * FROM brands where FIND_IN_SET('$vehicle_type_id',type_id) and type='Brand'")->result();
        $options = '';
        $options .= '';

        foreach ($brands as $row) {
            $options .= '<option value="' . $row->slug . '" ';

            if ($row->slug === $selected) {
                $options .= ' selected="selected"';
            }
            $options .= '>' . $row->name . '</option>';
        }
        echo $options;
    }

    static public function get_brands_for_profile($selected = [])
    {
        $ci = &get_instance();
        $brands = $ci->db->query("SELECT * FROM brands where type='Brand'")->result();
        $options = '';
        $options .= '';

        foreach ($brands as $row) {
            $options .= '<option value="' . $row->id . '" ';

            if (in_array($row->id, $selected)) {
                $options .= ' selected="selected"';
            }
            $options .= '>' . $row->name . '</option>';
        }
        return $options;
    }

    static public function get_brands_by_vehicle_model($type_id = 1, $brand_id = 0, $selected = 0)
    {
        $ci = &get_instance();
        $models = $ci->db->from('brands')
            ->where('parent_id', $brand_id)
            ->where('type', 'Model')
            ->get()
            ->result();

        $options = '';

        foreach ($models as $model) {
            $options .= '<option value="' . $model->id . '" ';

            if ($model->id == intval($selected)) {
                $options .= ' selected="selected"';
            }
            $options .= '>' . $model->name . '</option>';
        }
        echo $options;
    }

    static public function get_brands_by_vehicle_model_multiple($type_id = 1, $brand_id = [], $selected = [])
    {
        $ci = &get_instance();
        if (!empty($brand_id)){
            $models = $ci->db->from('brands')
                ->where_in('parent_id', $brand_id)
                ->where('type', 'Model')
                ->get()
                ->result();
        }


        $options = '';
        if (empty($selected)){
            $options .= '<option value="" disabled selected>Select Model</option>';
        }
        if (!empty($models)){
            foreach ($models as $model) {
                $options .= '<option value="' . $model->id . '" ';

                if (!empty($selected) && in_array($model->id,$selected)) {
                    $options .= ' selected="selected"';
                }
                $options .= '>' . $model->name . '</option>';
            }
        }

        echo $options;
    }

    static public function get_model_for_select($type_id = 1, $brand_id = 0, $selected = 0)
    {
        $ci = &get_instance();
        $models = $ci->db->from('brands')
            ->where('parent_id', $brand_id)
            ->where('type', 'Model')
            ->order_by('name', 'DESC')
            ->get()
            ->result();

        $options = '';
        foreach ($models as $model) {
            $options .= '<option value="' . $model->slug . '" ';

            if ($model->slug === $selected) {
                $options .= ' selected="selected"';
            }
            $options .= '>' . $model->name . '</option>';
        }
        echo $options;
    }

    static public function getCustomers($selected = 0)
    {
        $ci = &get_instance();
        $users = $ci->db->select('id, first_name, last_name')->where('role_id', 6)->get('users')->result();

        $html = '<option value="">--Subscriber--</option>';

        foreach ($users as $user) {
            $html .= '<option value="' . $user->id . '"';
            $html .= ($selected == $user->id) ? ' selected' : '';
            $html .= '>' . $user->first_name . ' ' . $user->last_name . '</option>';
        }
        return $html;
    }

    // using for mail
    static public function getProductTypeById($id)
    {
        $CI = &get_instance();
        $result = $CI->db->select('name')->get_where('vehicle_types', ['id' => $id])->row();
        return ($result) ? $result->name : '';
    }

    static public function getBrandNameById($id)
    {
        $CI = &get_instance();
        $brand_id = intval($id);
        $result = $CI->db->select('name')->from('brands')->where('id ', $brand_id)->get()->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }

    }

    static public function getModelNameById($model_id = null)
    {
        $CI = &get_instance();
        $result = $CI->db->select('name')->from('brands')->where('id ', $model_id)->get()->row();
        return ($result) ? $result->name : null;
    }

    static public function getAllBrand($model_id = 1, $brand_id = 0)
    {
        $ci =& get_instance();
        $models = $ci->db->get_where('brands', ['parent_id' => $brand_id])->result();

        $options = '<option value="0"> -- Select Model -- </option>';
        foreach ($models as $model) {
            $options .= '<option value="' . $model->id . '" ';
            $options .= ($model->id == $model_id) ? 'selected="selected"' : '';
            $options .= '>' . $model->name . '</option>';
        }
        return $options;
    }

    static public function getAllBrands($type = 0, $model_id = 1)
    {
        $ci =& get_instance();
        if ($type) {
            $models = $ci->db->get_where('brands', ['type' => 'Brand'])->result();

            $options = '<option value="0"> Select Brand </option>';
            foreach ($models as $model) {
                $options .= '<option value="' . $model->id . '" ';
                $options .= ($model->id == $model_id) ? 'selected="selected"' : '';
                $options .= '>' . $model->name . '</option>';
            }
            return $options;
        } else {
            return $options = '<option value="0"> -- Select Vehicle -- </option>';
        }
    }

    static public function getLocationById($id = 0)
    {
        $ci =& get_instance();
        $loc = $ci->db->get_where('post_area', ['id' => $id])->row();
        if ($loc) {
            return $loc->name;
        } else {
            return null;
        }

    }
    static public function getLocationByIdMultiple($id = [])
    {
        $ci =& get_instance();
        $allId = explode(',',$id);
        $loc = $ci->db->where_in('id',$allId)->get('post_area')->result();
        if ($loc) {
            $name = [];
            foreach ($loc as $r){
                $name[] = $r->name;
            }
            return implode(',',$name);
        } else {
            return null;
        }

    }
    public static function dropDownVehicleList($selected = null)
    {

        $id = 0;
        if (is_numeric($selected)) {
            $id = $selected;
        } else {
            switch ($selected) {
                case "car":
                    $id = 1;
                    break;
                case "vans":
                    $id = 2;
                    break;
                case "motorbike":
                    $id = 3;
                    break;
                case "spare-parts":
                    $id = 4;
                    break;
                case "import-car":
                    $id = 5;
                    break;
                case "auction-cars":
                    $id = 6;
                    break;
                default:
            }
        }

        $types = DB::table('vehicle_types')->whereNotIn('id', [7, 6,5])->get();

        if ($types) {
            $html = '<option value="" disabled selected>Select Vehicle Type</option>';

            foreach ($types as $type) {
                $html .= '<option value="' . $type->id . '"';
                $html .= ($type->id == $id) ? ' selected="selected"' : '';
                $html .= '>' . $type->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }

    }

    public static function dropDownVehicleListDiagnose($selected = null)
    {

        $id = 0;
        if (is_numeric($selected)) {
            $id = $selected;
        } else {
            switch ($selected) {
                case "car":
                    $id = 1;
                    break;
                case "vans":
                    $id = 2;
                    break;
                case "motorbike":
                    $id = 3;
                    break;
                default:
            }
        }

        $types = DB::table('vehicle_types')->whereIn('id', [1,2,3])->get();

        if ($types) {
            $html = '<option value="" selected>Select Vehicle Type</option>';

            foreach ($types as $type) {
                $html .= '<option value="' . $type->id . '"';
                $html .= ($type->id == $id) ? ' selected="selected"' : '';
                $html .= '>' . $type->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }

    }

    public static function dropDownVehicleListForMechanic($selected = null, $return = 'slug')
    {

        $id = 0;
        if (is_numeric($selected)) {
            $id = $selected;
        } else {
            switch ($selected) {
                case "car":
                    $id = 1;
                    break;
                case "vans":
                    $id = 2;
                    break;
                case "motorbike":
                    $id = 3;
                    break;
                default:
            }
        }

        $types = DB::table('vehicle_types')->whereIn('id', [1,2,3])->get();

        if ($types) {
            $html = '<option value="" disabled selected>Vehicle Type</option>';

            foreach ($types as $type) {
                $html .= '<option value="' . $type->$return . '"';
                $html .= ($type->id == $id) ? ' selected="selected"' : '';
                $html .= '>' . $type->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }

    }


    // ---- 01.05.2018 ---------
    public static function towing_services($selected = 0)
    {
        $ci =& get_instance();
        $services = $ci->db->where('parent_id', 0)->get('towing_categories')->result();

        $options = '<option value="0">Category</option>';
        foreach ($services as $service) {
            $options .= '<option value="' . $service->id . '" ';
            $options .= ($service->id == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $service->name . '</option>';
        }
        return $options;
    }

    public static function towing_service_for_profile($selected = [])
    {
        $ci =& get_instance();
        $services = $ci->db->where('parent_id', 0)->get('towing_categories')->result();

        $options = '';
        foreach ($services as $service) {
            $options .= '<option value="' . $service->id . '" ';
            $options .= (in_array($service->id, $selected)) ? 'selected="selected"' : '';
            $options .= '>' . $service->name . '</option>';
        }
        return $options;
    }

    public static function towing_service_for_frontend($selected = [0])
    {
        $ci =& get_instance();
        $services = $ci->db->where('parent_id', 0)->where_in('id', $selected)->get('towing_categories')->result();

        $options = '';
        foreach ($services as $service) {
            $options .= '<li><span class="material-icons">check_circle</span>' . $service->name . '</li>';
        }
        return !empty($options) ? $options:'<li>No Data </li>';
    }

    public static function towing_service_for_API($selected = [0])
    {
        $ci =& get_instance();
        $services = $ci->db->where('parent_id', 0)->where_in('id', $selected)->get('towing_categories')->result();

        $options = [];
        foreach ($services as $k => $service) {
            $options[$k] = $service->name ;
        }
        return $options;
    }

    public static function get_towing_services($id = 0)
    {
        $ci =& get_instance();
        $service = $ci->db->where('id', $id)->get('towing_categories')->row();
        return ($service) ? $service->name : null;
    }

    public static function towing_type_of_services($cat_id = 0, $selected = 0)
    {
        $ci =& get_instance();
        $services = $ci->db->where('parent_id', $cat_id)->get('towing_categories')->result();

        $options = '<option value="0">Select Service</option>';
        foreach ($services as $service) {
            $options .= '<option value="' . $service->id . '" ';
            $options .= ($service->id == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $service->name . '</option>';
        }
        return $options;
    }

    public static function towing_type_of_service_for_profile($cat_id = [], $selected = [])
    {
        $cat_id = empty($cat_id[0]) ? ['-1'] : $cat_id;
        $ci =& get_instance();
        $services = $ci->db->where_in('parent_id', $cat_id)->get('towing_categories')->result();

        $options = '';
        foreach ($services as $service) {
            $options .= '<option value="' . $service->id . '" ';
            $options .= (in_array($service->id, $selected)) ? 'selected="selected"' : '';
            $options .= '>' . $service->name . '</option>';
        }
        return $options;
    }

    public static function towing_type_of_service_for_frontend($selected = [-1])
    {
        $ci =& get_instance();
        $services = $ci->db->where_in('id', $selected)->get('towing_categories')->result();

        $options = '';
        foreach ($services as $service) {
            $options .= '<li><span class="material-icons">check_circle</span>' . $service->name . '</li>';
        }
        return $options;
    }

    public static function towing_type_of_service_for_API($selected = [-1])
    {
        $ci =& get_instance();
        $services = $ci->db->where_in('id', $selected)->get('towing_categories')->result();

        $options = [];
        foreach ($services as $k => $service) {
            $options[$k] =  $service->name ;
        }
        return $options;
    }

    public static function get_towing_type_of_services($id = 0)
    {
        //  $ci      =& get_instance();
        $services = [
            1 => 'Towing and Recovery',
            2 => 'Vulcanising',
            3 => 'Replacement of Tyres',
            4 => 'Repair of Tyres',
            5 => 'Cluth',
            6 => 'Brake ',
            7 => 'Engine Problem',
            8 => 'Car Battery replacement',
        ];
        return @$services[$id];
    }

    public static function getDropDownVehicleTypeTowing($id = 0)
    {
        $types = [
            '7' => 'Car',
            '6' => 'Van',
            '1' => 'Trucks',
            '1' => 'HEAVY /Earth Moving Vehicles',
        ];
        $html = '<option value="0">--Select Type--</option>';
        foreach ($types as $key => $type) {
            $html .= '<option value="' . $key . '"';
            $html .= ($key == $id) ? ' selected="selected"' : '';
            $html .= '>' . $type . '</option>';
        }
        return $html;
    }

    public static function get_DropDownVehicleTypeTowing($id = 0)
    {
        $types = [
            '7' => 'Car',
            '6' => 'Van',
            '1' => 'Trucks',
            '1' => 'HEAVY /Earth Moving Vehicles',
        ];
        return $types[$id];
    }

    public static function getDropDownAvailability($selected = null)
    {
        $types = [
            '24 hrs' => '24 hrs',
            '9am-5PM' => '9am-5PM',
            '6am-10PM' => '6am-10PM'
        ];
        $html = '<option value="0">Availability</option>';
        foreach ($types as $key => $type) {
            $html .= '<option value="' . $key . '"';
            $html .= ($key == $selected) ? ' selected="selected"' : '';
            $html .= '>' . $type . '</option>';
        }
        return $html;
    }

    public static function getDropDownAvailabilityForProfile($selected = null)
    {
        $types = [
            '24 hrs' => '24 hrs',
            '9am-5PM' => '9am-5PM',
            '6am-10PM' => '6am-10PM'
        ];
        $html = '<option value="0">--Availability--</option>';
        foreach ($types as $key => $type) {
            $html .= '<option value="' . $key . '"';
            $html .= ($key == $selected) ? ' selected="selected"' : '';
            $html .= '>' . $type . '</option>';
        }
        return $html;
    }


    // towing end

    // Diagnostic
    public static function diagnostic_type_of_cars($selected = 0)
    {
        $types = [
            1 => 'Cars',
            8 => 'Lorries',
            7 => 'Heavy equipment/Trucks '
        ];
        $html = '<option value="0">Select Type</option>';
        foreach ($types as $key => $type) {
            $html .= '<option value="' . $key . '"';
            $html .= ($key == $selected) ? ' selected="selected"' : '';
            $html .= '>' . $type . '</option>';
        }
        return $html;


    }


    public function getChatPackages($service_rate = 0)
    {
        $CI = &get_instance();
        $html = '';
        $regular = '';
        $featured = '';
        $packages = $CI->db->order_by('id', 'ASC')->get('packages')->result();
        foreach ($packages as $package) {
            if ($package->package_type == 'Featured') {
                $featured .= '<option value="' . $package->id . '"';
                $featured .= ($service_rate == $package->id) ? ' selected' : '';
                $featured .= '>' . $package->title . '( ' . $package->duration . ' days)</option>';
            } else {
                $regular .= '<option value="' . $package->id . '"';
                $regular .= ($service_rate == $package->id) ? ' selected' : '';
                $regular .= '>' . $package->title . '( ' . $package->duration . ' days)</option>';
            }
        }
        $html = "<optgroup label='Regular'>$regular</optgroup><optgroup label='Featured'>$featured</optgroup>";
        return $html;
    }


    // for use   driver hire  page
    public function driverVehicles($selected = null)
    {
        $cars = [
            'Cars' => 'Cars',
            'Van' => 'Van',
            'Bus' => 'Bus',
            'Trucks' => 'Trucks',
            'Earth Moving Vehicles' => 'Earth Moving Vehicles',
        ];
    }

    public function mechanicVehicles($selected = null)
    {

    }


    public static function wahtsAppNo($user_id = 0)
    {
        $contact = '+2348152683517';
        $ci =& get_instance();
        $ci->db->select('contact, role_id');
        $ci->db->where('id', $user_id);
        $user = $ci->db->get('users')->row();
        if ($user && $user->contact) {
            $first = substr($user->contact, 0, 1);
            $contact = ($first == '+') ? $user->contact : '+234' . $user->contact;
        }
        if ($user && $user->role_id == 4){
            $metas = $ci->db->select('meta_key,meta_value')->get_where('user_meta', ['user_id' => $user_id, 'meta_key' => 'whatsapp_number'])->row();
            if ($metas && !empty($metas->whatsapp_number)){
                $first = substr($metas->whatsapp_number, 0, 1);
                $contact = ($first == '+') ? $metas->whatsapp_number : '+234' . $metas->whatsapp_number;
            }
        }

        return $contact;
    }


    public static function contact_no($user_id = 0)
    {
        $contact = '+2348152683517';
        $ci =& get_instance();
        $ci->db->select('contact, role_id');
        $ci->db->where('id', $user_id);
        $user = $ci->db->get('users')->row();
        if ($user && $user->contact) {
            $first = substr($user->contact, 0, 1);
            $contact = ($first == '+') ? $user->contact : '+234' . $user->contact;
        }
        if ($user && $user->role_id == 4){
            $metas = $ci->db->select('meta_key,meta_value')->get_where('user_meta', ['user_id' => $user_id, 'meta_key' => 'business_phone'])->row();
            if ($metas && !empty($metas->business_phone)){
                $first = substr($metas->business_phone, 0, 1);
                $contact = ($first == '+') ? $metas->business_phone : '+234' . $metas->business_phone;
            }
        }

        return $contact;
    }

    public static function address($user_id = 0)
    {
        $address = '';
        $ci =& get_instance();
        $ci->db->select('add_line1, role_id');
        $ci->db->where('id', $user_id);
        $user = $ci->db->get('users')->row();
        if ($user && $user->add_line1) {
            $address = $user->add_line1;
        }
        if ($user && $user->role_id == 4){
            $metas = $ci->db->select('meta_key,meta_value')->get_where('user_meta', ['user_id' => $user_id, 'meta_key' => 'userLocation'])->row();
            if ($metas && !empty($metas->userLocation)){
                $address = $metas->userLocation;
            }
        }

        return $address;
    }

    public static function company_name($user_id = 0)
    {
        $name = '';
        $ci =& get_instance();
        $ci->db->select('first_name, last_name, role_id');
        $ci->db->where('id', $user_id);
        $user = $ci->db->get('users')->row();
        if ($user) $name = $user->first_name.' '.$user->last_name;
        if ($user && $user->role_id == 4){
            $business_name = $ci->db->get_where('cms', ['user_id' => $user_id, 'post_type' => 'business'])->row();
            if (!empty($business_name)){
                $name = $business_name->post_title;
            }
        }elseif ($user && $user->role_id == 16){
            $business_name = $ci->db->get_where('clearing', ['user_id' => $user_id])->row();
            if (!empty($business_name)){
                $name = $business_name->companyName;
            }
        }elseif ($user && $user->role_id == 15){
            $business_name = $ci->db->get_where('shipping', ['user_id' => $user_id])->row();
            if (!empty($business_name)){
                $name = $business_name->companyName;
            }
        }

        return $name;
    }

    public static function profile_pic($user_id = 0)
    {
        $pic = 'assets/new-theme/images/logo-c.svg';
        $ci =& get_instance();
        $ci->db->select('profile_photo, user_profile_image, role_id');
        $ci->db->where('id', $user_id);
        $user = $ci->db->get('users')->row();
        if ($user && $user->role_id == 4){
            $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $user->profile_photo;
            if ($user->profile_photo && file_exists($photofile)) {
                $pic = base_url(). '/uploads/company_logo/' . $user->profile_photo;
            }
        } else {
            $photofile = dirname(BASEPATH) . '/uploads/users_profile/' . $user->user_profile_image;
            if ($user->user_profile_image && file_exists($photofile)) {
                $pic = base_url(). '/uploads/users_profile/' . $user->user_profile_image;
            }
        }

        return $pic;
    }

    public static function access_log()
    {
        $log_path = FCPATH . '/logs/access_log.txt';
        $access_log = date('Y-m-d H:i:s A') . ' | ' . $_SERVER['REMOTE_ADDR'] . ' | ' . site_url($_SERVER['REQUEST_URI']) . ' ----- ' . $_SERVER['REQUEST_METHOD'] . "\r\n";
        @file_put_contents($log_path, $access_log, FILE_APPEND);
    }

    public static function all_brands_for_automech($selected = 0, $type_id = 0)
    {
        $CI = &get_instance();

        $CI->db->where('type', 'Brand');
        if ($type_id) {
            $CI->db->group_start();
            $CI->db->like('type_id', $type_id);
            $CI->db->group_end();
        }
        $brnads = $CI->db->get('brands')->result();

        $option = '';
        foreach ($brnads as $brand) {
            $option .= '<option value="' . $brand->id . '"';
            $option .= ($brand->id == $selected) ? ' selected' : '';
            $option .= '>' . $brand->name . '</option>';
        }
        return $option;
    }

    public static function advert_type($selected = NULL)
    {
        $ci = &get_instance();
        // $settings = $ci->db->get_where('')->result();
        $types = [
            'Free' => 'Free  Membership ₦0',
            // 'Regular' => 'Featured listing ₦'.get_option('RegularPrice'),
            //  'Featured' => 'Featured listing ₦'.get_option('FeaturedPrice')
        ];


        $options = '';
        foreach ($types as $key => $row) {
            $options .= '<option value="' . $key . '" ';
            $options .= ($key == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row . '</option>';
        }
        return $options;
    }

    public static function car_age($selected = NULL)
    {
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


        $options = '';
        foreach ($ages as $key => $row) {
            $options .= '<option value="' . $key . '" ';
            $options .= ($key == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row . '</option>';
        }
        return $options;
    }

    public static function all_features_new($selected = [])
    {
        $ci = &get_instance();
        $html = '';
        $features = $ci->db->order_by('title', 'ASC')->get('special_features')->result();

        foreach ($features as $feature) {
            $selectedClass = in_array($feature->id, $selected) ? 'selected' : '';
            $html .= "<option value=\"$feature->id\" $selectedClass>$feature->title</option>";

//            $html .= '<div class="col-lg-2 col-md-3 col-sm-4 col-6"><div class="spacial-featured-btn">';
//            $html .= '<input type="checkbox" name="feature_ids[]"';
//            $html .= 'value="' . $feature->id . '" ';
//            $html .= 'id="' . $feature->id . '" onclick="fFeature(' . $feature->id . ')" data-txt="' . $feature->title . '">';
//            $html .= '<label for="' . $feature->id . '">' . $feature->title . '</label>';
//            $html .= '</div></div>';
        }

        return $html;
    }

    public static function features($checked = null, $li = false, $p = false)
    {
        $ci = &get_instance();
        $features = $ci->db->order_by('title', 'ASC')->get('special_features')->result();
        $selected = is_null($checked) ? array(0) : explode(',', $checked);
        $html = '';

        foreach ($features as $feature) {
            if ($li){
                $html .= in_array($feature->id, $selected) ? '<li>'.$feature->title . '</li>' : '';
            } elseif ($p){
                $html .= in_array($feature->id, $selected) ? '<p>'.$feature->title . '</p>' : '';
            } else {
                $html .= in_array($feature->id, $selected) ? $feature->title . ', ' : '';
            }
        }

        return empty($html) ? '' : $html;
    }

    public static function service_history($selected = NULL)
    {
        $services = [
            '1' => 'First service is not due',
            '2' => 'Full service history',
            '3' => 'Part service history',
            '4' => 'No service history',
        ];

        $options = '';
        foreach ($services as $key => $row) {
            $options .= '<option value="' . $key . '" ';
            $options .= ($key == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row . '</option>';
        }
        return $options;
    }

    public static function owners($selected = NULL)
    {
        $owners = [
            '1' => '1st',
            '2' => '2nd',
            '3' => '3rd',
            '4' => '4th',
            '5' => '5th',
            '6' => '6th',
            '7' => '7th',
        ];


        $options = '';
        foreach ($owners as $key => $row) {
            $options .= '<option value="' . $key . '" ';
            $options .= ($key == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row . '</option>';
        }
        return $options;
    }

    public static function parts_for($selected = NULL, $label = '--Select--')
    {
        $ci = &get_instance();
        $query = $ci->db->where_not_in('id', [4, 5, 6])->get('vehicle_types')->result();

        $row = '';
        foreach ($query as $option) {
            $row .= '<option value="' . $option->id . '"';
            $row .= ($selected === $option->id) ? ' selected' : '';
            $row .= '>' . $option->name . '</option>';
        }
        return $row;
    }

    public static function dropDownVehicleListForVariants($selected = null)
    {
        $id = 0;

        switch ($selected) {
            case "Car":
                $id = 1;
                break;
            case "Van":
                $id = 2;
                break;
            default:
        }

        $types = DB::table('vehicle_types')->whereIn('id', [1, 2])->get();

        if ($types) {
            $html = '<option value="">--Select Type--</option>';

            foreach ($types as $type) {
                $html .= '<option value="' . $type->id . '"';
                $html .= ($type->id == $id) ? ' selected="selected"' : '';
                $html .= '>' . $type->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }

    }

    public static function getDropDownVehicleTypeForVariants($id = 0, $col = 'id')
    {
        $types = DB::table('vehicle_types')->whereIn('id', [1, 2])->get();

        if ($types) {
            $html = '<option value="0">--Select Type--</option>';

            foreach ($types as $type) {
                $html .= '<option value="' . $type->{$col} . '"';
                $html .= ($type->{$col} == $id) ? ' selected="selected"' : '';
                $html .= '>' . $type->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }

    }


    public static function driver_location($id = 0, $label = 'Select State')
    {
        $post_areas = DB::table('post_area')->where('id', "!=", "39")->where("id", "!=", "40")->get();

        if ($post_areas) {
            $html = '<option value="">' . $label . '</option>';
            foreach ($post_areas as $area) {
                $html .= '<option value="' . $area->id . '"';
                $html .= ($id == $area->id) ? ' selected' : '';
                $html .= '>' . $area->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }

    }

    public static function license_type($id = 0, $label = 'License Type')
    {
        $types = [
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

        $html = '<option value="">--' . $label . '--</option>';
        foreach ($types as $key => $value) {
            $html .= '<option title="' . $value["details"] . '"value="' . $key . '"';
            $html .= ($id == $key) ? ' selected' : '';
            $html .= '>' . $value["name"] . '</option>';
        }
        return $html;

    }

    public static function education_type($id = 0, $label = 'Select Education Type')
    {
        $types = [
            1 => "Primary",
            2 => "Secondary",
            3 => "NCE",
            4 => "OND",
            5 => "HND",
            6 => "Degree",
        ];

        $html = '<option value="">--' . $label . '--</option>';
        foreach ($types as $key => $value) {
            $html .= '<option title="' . $value . '"value="' . $key . '"';
            $html .= ($id == $key) ? ' selected' : '';
            $html .= '>' . $value . '</option>';
        }
        return $html;

    }

    public static function driver_marital_status($id = 0, $label = 'Select Marital Status')
    {
        $types = [
            1 => "Single",
            2 => "Married",
            3 => "Divorced"
        ];

        $html = '<option value="">--' . $label . '--</option>';
        foreach ($types as $key => $value) {
            $html .= '<option title="' . $value . '"value="' . $key . '"';
            $html .= ($id == $key) ? ' selected' : '';
            $html .= '>' . $value . '</option>';
        }
        return $html;
    }

    public static function getProblem($type)
    {
        $ci =& get_instance();
        $parts = $ci->db->where('type', $type)->where('status', 'Published')->get('diagnostics_question_type')->result();

        return $parts;
    }

    public static function driver_exam_status($id = 0, $label = 'Select')
    {
        $types = [
            1 => "Yes",
            0 => "No"
        ];

        $html = '<option value="">--' . $label . '--</option>';
        foreach ($types as $key => $value) {
            $html .= '<option title="' . $value . '"value="' . $key . '"';
            $html .= ($id == $key) ? ' selected' : '';
            $html .= '>' . $value . '</option>';
        }
        return $html;
    }

    public static function driver_status($id = 0, $label = 'Select Status')
    {
        $types = [
            0 => "Inactive",
            1 => "Available",
            2 => "Hired",
            3 => "Requested To Hire",
        ];

        $html = '<option value="">--' . $label . '--</option>';
        foreach ($types as $key => $value) {
            $html .= '<option title="' . $value . '"value="' . $key . '"';
            $html .= ($id == $key) ? ' selected' : '';
            $html .= '>' . $value . '</option>';
        }
        return $html;
    }

    public static function driverServiceType($id = 0, $label = 'Select Service')
    {
        $types = [
            1 => "Recruitment",
            2 => "Outsourcing",
        ];

        $html = '<option value="">--' . $label . '--</option>';
        foreach ($types as $key => $value) {
            $html .= '<option title="' . $value . '"value="' . $key . '"';
            $html .= ($id == $key) ? ' selected' : '';
            $html .= '>' . $value . '</option>';
        }
        return $html;
    }

    public static function driver_hire_periods($id = 0, $label = 'Select Time')
    {
        $types = [
            1 => "1 week",
            2 => "1 month",
            3 => "6 months",
            4 => "1 year",
        ];

        $html = '<option value="">--' . $label . '--</option>';
        foreach ($types as $key => $value) {
            $html .= '<option title="' . $value . '"value="' . $key . '"';
            $html .= ($id == $key) ? ' selected' : '';
            $html .= '>' . $value . '</option>';
        }
        return $html;
    }

    public static function all_api_location()
    {
        return DB::table('post_area')->get();
    }


    public static function dropDownVehicleListApi()
    {
        return DB::table('vehicle_types')->whereNotIn('id', [5,6,7])->get();
    }

    public static function getVehicleCondition()
    {
        $conditions = [
            'New' => 'New',
            'Foreign used' => 'Foreign Used'
        ];

        return $conditions;
    }

    public static function apiPackageList()
    {
        $types = [
            'Free' => 'Free  Membership ₦0',
            // 'Regular' => 'Featured listing ₦'.get_option('RegularPrice'),
            //  'Featured' => 'Featured listing ₦'.get_option('FeaturedPrice')
        ];

        return $types;
    }

    public static function getDropDownFromTable($table = null, $column = 'color_name')
    {
        $ci =& get_instance();
        $results = $ci->db->from($table)->get()->result();

        return $results;
    }

    public static function getCurrency()
    {
        $data = [
            'NGR' => 'Currency:  &#x20A6; NGN (Recommended )',
            'USD' => 'Currency:  &dollar; USD (Optional)'
        ];

        return $data;
    }

    public static function getApiGearBox()
    {
        $gears = [
            'Automatic' => 'Automatic',
            'Sami Automatic' => 'Semi Automatic',
            'Manual' => 'Manual'
        ];

        return $gears;
    }

    public static function getSeatApi()
    {
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

        return $seats;
    }

    public static function getOwnerApi()
    {
        $owners = [
            '1' => '1st',
            '2' => '2nd',
            '3' => '3rd',
            '4' => '4th',
            '5' => '5th',
            '6' => '6th',
            '7' => '7th',
        ];

        return $owners;
    }

    public static function all_features_api()
    {
        $ci = &get_instance();
        $features = $ci->db->order_by('title', 'ASC')->get('special_features')->result();

        return $features;
    }

    static public function parts_categories_api()
    {
        $ci =& get_instance();
        $parts = $ci->db->get_where('parts_categories')->result();

        return $parts;
    }

    public static function parts_for_api()
    {
        $ci = &get_instance();
        $query = $ci->db->where_not_in('id', [4, 5, 6])->get('vehicle_types')->result();

        return $query;
    }

    static public function parts_description_api()
    {
        $ci =& get_instance();
        $parts = $ci->db->get_where('parts_description')->result();

        return $parts;
    }

    public static function get_car_age_api()
    {
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

        return $ages;
    }

    public static function getCurrencyApi()
    {
        $data = [
            'NGR' => 'Currency:  ₦ NGN (Recommended)',
//            'USD' => 'Currency:  $ USD (Optional)',
        ];

        return $data;
    }

    public static function dropDownVehicleListForDriverHire($id = null)
    {
        $types = DB::table('vehicle_types')->whereIn('id', [1, 2, 3, 7])->get();

        if ($types) {
            $html = '<option value="">Select Vehicle Type</option>';

            foreach ($types as $type) {
                $html .= '<option value="' . $type->id . '"';
                $html .= ($type->id == $id) ? ' selected="selected"' : '';
                $html .= '>' . $type->name . '</option>';
            }
            return $html;
        } else {
            return null;
        }

    }

    public static function randomNumber($length = 10)
    {
        $x = '123456789';
        $c = strlen($x) - 1;
        $response = '';
        for ($i = 0; $i < $length; $i++) {
            $y = rand(0, $c);
            $response .= substr($x, $y, 1);
        }

        return $response;
    }

    public static function getGalleryThumb($thumb = null, $size = 'tiny', $attrs = array())
    {


        $attribute = '';

        foreach ($attrs as $key => $value) {
            $attribute .= $key . ' = "' . $value . '"';
        }


        if ($thumb && file_exists(GalleryFolder . $thumb)) {
            return '<img ' . $attribute . ' src="' . GalleryFolder . $thumb . '"  alt="Thumb"/>';
        } else {
            return '<img ' . $attribute . ' src="' . GalleryFolder . 'no-thumb.gif" alt="Thumb"/>';
        }
    }


    /*------------------------------------------------------------------------------------------------------------------
     *  New Design Start
     * -----------------------------------------------------------------------------------------------------------------
     */


    public static function all_city_for_search($slug = '', $label = 'Select Location')
    {
        $slug = !empty($slug) ? explode(',', $slug) : [-1];
        $ci =& get_instance();
        // $id = intval( $ci->input->get('location_id') );
        if (!empty($slug) && !in_array('all-states-41', $slug)) {
            $post_areas = $ci->db->select('state_towns.name, state_towns.slug')
                ->join('post_area as parent', 'state_towns.state_id = parent.id', 'INNER')
                ->where_in('parent.slug', $slug)
                ->where("FIND_IN_SET('2',state_towns.type) <>", 0)
                ->get('state_towns')
                ->result();
        } else {
            $post_areas = DB::table('state_towns')->get();
        }

        if ($post_areas) {
            $html = '<li><a href="' . search_link_builder($ci->input->get(), 'address', 0) . '">' . $label . '</a></li>';
            foreach ($post_areas as $area) {
                $class = $area->slug == $ci->input->get('address') ? 'selected active' : '';
                $html .= '<li class="' . $class . '"><a href="' . search_link_builder($ci->input->get(), 'address', $area->slug) . '" >' . $area->name . '</a></li>';
            }
            return $html;
        } else {
            return null;
        }
    }

    public static function all_location_for_search($id = 0, $label = 'Select State', $country_id = 155)
    {
        $ci =& get_instance();
        // $id = intval( $ci->input->get('location_id') );
        $ci->db->select('post_area.*')->from('post_area')
            ->join('countries','countries.id = post_area.country_id')
            ->where('post_area.type', 'state');
        if (is_numeric($country_id)){
            $ci->db->where('country_id', $country_id);
        }else{
            $ci->db->where('countries.slug',$country_id);
        }
        $post_areas =  $ci->db->get()->result();

        if ($post_areas) {
            $html = '<li><a href="' . search_link_builder($ci->input->get(), 'location', 0) . '">' . $label . '</a></li>';
            $state_array = !empty($ci->input->get('location')) ? explode(',', $ci->input->get('location')) : [];
            foreach ($post_areas as $area) {
                $class = in_array($area->slug, $state_array) ? 'selected active' : '';
                $html .= '<li class="' . $class . '"><a href="' . search_link_state_builder($ci->input->get(), 'location', $area->slug, $state_array) . '" >' . $area->name . '</a></li>';
            }
            return $html;
        } else {
            return null;
        }
    }
    public static function all_country_for_search($id = 0, $label = 'Select Country')
    {
        $ci =& get_instance();
        // $id = intval( $ci->input->get('location_id') );
        $post_areas = DB::table('countries')
            ->where('type', '1')
            ->get();

        if ($post_areas) {
            $html = '<li><a href="' . search_link_builder($ci->input->get(), 'country', 0) . '">' . $label . '</a></li>';
            foreach ($post_areas as $area) {
                $class = !empty($ci->input->get('country')) && $area->slug == $ci->input->get('country') ? 'selected active' : '';
                $html .= '<li class="' . $class . '"><a href="' . search_link_builder($ci->input->get(), 'country', $area->slug) . '" >' . $area->name . '</a></li>';
            }
            return $html;
        } else {
            return null;
        }
    }

    public static function all_brand_for_search($label = "Select Brand")
    {
        $ci =& get_instance();
        $type_id = GlobalHelper::getTypeIdByPageSlug($ci->uri->segment(2));
        $brands = $ci->db->query("SELECT * FROM brands where FIND_IN_SET($type_id,type_id) and type='Brand'")->result();
        if ($brands) {
            $html = '<li><a href="' . search_link_builder($ci->input->get(), 'brand', 0) . '">' . $label . '</a></li>';
            foreach ($brands as $brand) {
                $class = $brand->slug == $ci->input->get('brand') ? 'selected active' : '';
                $html .= '<li class="' . $class . '"><a href="' . search_link_builder($ci->input->get(), 'brand', $brand->slug) . '" >' . $brand->name . '</a></li>';
            }
            return $html;
        } else {
            return null;
        }
    }

    public static function all_model_for_search($label = "Select Model")
    {
        $ci =& get_instance();
        $brand_slug = $ci->input->get('brand');
        $brands = [];
        if (!empty($brand_slug)) {
            $brands = $ci->db->select('brands.name, brands.slug')
                ->join('brands as parent', 'parent.id = brands.parent_id')
                ->get_where('brands', ['parent.slug' => $brand_slug, 'brands.type' => 'Model'])
                ->result();
        }
        $html = '<li><a href="' . search_link_builder($ci->input->get(), 'model', 0) . '">' . $label . '</a></li>';

        if ($brands) {
            foreach ($brands as $brand) {
                $class = $brand->slug == $ci->input->get('model') ? 'selected active' : '';
                $html .= '<li class="' . $class . '"><a href="' . search_link_builder($ci->input->get(), 'model', $brand->slug) . '" >' . $brand->name . '</a></li>';
            }

        }
        return $html;
    }

    public static function yearRange_for_search($name = 'from_year')
    {
        $html = '';
        $ci =& get_instance();
        for ($i = date('Y'); $i >= 1960; $i--) {
            $class = $i == $ci->input->get($name) ? 'selected active' : '';
            $html .= '<li class="' . $class . '"><a href="' . search_link_builder($ci->input->get(), $name, $i) . '">' . sprintf('%02d', $i) . '</a></li>';
        }
        return $html;
    }

    public static function get_short_for_search($page = 'search')
    {
        $ci = &get_instance();
        $$page = $ci->uri->segment('2');
        $options = [

            'all' => 'Sort By',
            'PostDateASC' => 'Oldest Post',
            'PostDateDESC' => 'Latest Post'
        ];

        if ($page != "spare-parts" && $page != 'automech-search' && $page != 'towing-search') {
            $options['MileageASC'] = 'Mileage (Lowest to Highest)';
        }

        if ($page != 'automech-search' && $page != 'towing-search') {
            $options['PriceASC'] = 'Price (Lowest to Highest)';
            $options['PriceDESC'] = 'Price (Highest to Lowest)';
        }

        $html = '';

        foreach ($options as $k => $p) {
            $class = $k == $ci->input->get('order_by') ? 'selected active' : '';
            $html .= '<li class="' . $class . '"><a href="' . search_link_builder($ci->input->get(), 'order_by', $k) . '">' . $p . '</a></li>';
        }
        return $html;
    }

    public static function get_price_for_search($i = 0, $end = 12, $incr = 1, $name = 0)
    {
        $option = '';
        $ci = &get_instance();

        for ($i; $i <= $end; $i += $incr) {
            $class = $i == $ci->input->get($name) ? 'active' : '';
            $option .= '<li class="' . $class . '"><a href="' . search_link_builder($ci->input->get(), $name, $i) . '">&#x20A6;' . number_format($i, 0) . '</a></li>';
        }
        return $option;
    }

    public static function transmission_for_search()
    {
        $ci = &get_instance();
        $html = '';
        $gears = [
            'Automatic' => 'Automatic',
            'Sami Automatic' => 'Semi Automatic',
            'Manual' => 'Manual'
        ];
        foreach ($gears as $key => $row) {
            $checked = $key == $ci->input->get('transmission') ? 'active' : '';
            $html .= "<li class='$checked'><a href='" . search_link_builder($ci->input->get(), 'transmission', $key) . "'>$row</a> </li>";
        }
        return $html;
    }

    public static function engine_search_for_search()
    {
        $ci = &get_instance();
        $html = '';
        $ci->db->order_by('id', 'DESC');
        $sizes = $ci->db->get('engine_sizes')->result();
        foreach ($sizes as $key => $row) {
            $checked = $row->id == $ci->input->get('engine_size') ? 'active' : '';
            $html .= "<li class='$checked'><a href='" . search_link_builder($ci->input->get(), 'engine_size', $row->id) . "'>$row->engine_size</a> </li>";
        }
        return $html;
    }

    /**
     * @return string
     * this function only for search page
     */
    public static function fuel_type_for_search()
    {
        $ci = &get_instance();
        $html = '';
        $ci->db->order_by('id', 'DESC');
        $sizes = $ci->db->get('fuel_types')->result();
        foreach ($sizes as $key => $row) {
            $checked = $row->id == $ci->input->get('fuel_type') ? 'checked active' : '';
            $html .= "<li class='$checked'><a href='" . search_link_builder($ci->input->get(), 'fuel_type', $row->id) . "'>$row->fuel_name</a></li>";
        }
        return $html;
    }

    /**
     * @return string
     * this function only for search page
     */
    public static function color_for_search()
    {
        $ci = &get_instance();
        $html = '';
        $ci->db->order_by('id', 'DESC');
        $sizes = $ci->db->get('color')->result();
        foreach ($sizes as $key => $row) {
            $checked = $row->id == $ci->input->get('color_id') ? 'active' : '';
            $html .= "<li class='$checked'><a href='" . search_link_builder($ci->input->get(), 'color_id', $row->id) . "'>
                                            $row->color_name</a></li>";
        }
        return $html;
    }

    /**
     * @param array $not
     * @return mixed Array || ArrayObject
     * this function call from search insurance list page
     */
    public static function otherInsuranceProvider($not = [])
    {
        $not = empty($not) ? [0] : $not;
        $ci = &get_instance();
        return $ci->db->select('logo, slug, name')->where('type', 'insurance')->where_not_in('user_id', $not)->limit(6)->get('company_profile')->result();
    }

    /**
     * @param array $not
     * @return mixed Array || ArrayObject
     * this function call from search loan list page
     */
    public static function otherLoanProvider($not = [])
    {
        $not = empty($not) ? [0] : $not;
        $ci = &get_instance();
        return $ci->db->select('logo, slug, name')->where('type', 'loan')->where_not_in('user_id', $not)->limit(6)->get('company_profile')->result();
    }

    public static function get_car_valuation($vehicel_type_id = 0, $condition = null, $brand_id = 0, $model_id = 0)
    {
        if (empty($vehicel_type_id) || empty($condition) || empty($brand_id) || empty($model_id)) {
            return json_encode(['priceinnaira' => 0, 'priceindollar' => 0]);
        }

        $ci = &get_instance();
        $average_amount = $ci->db->select('AVG(priceinnaira) as priceinnaira, AVG(priceindollar) as priceindollar')
            ->where(['vehicle_type_id' => $vehicel_type_id, 'condition' => $condition, 'brand_id' => $brand_id, 'model_id' => $model_id])
            ->get('posts')
            ->result();

        if (!empty($average_amount)) {
            return json_encode([
                'priceinnaira' => !empty($average_amount[0]->priceinnaira) ? number_format($average_amount[0]->priceinnaira) : 0,
                'priceindollar' => !empty($average_amount[0]->priceindollar) ? number_format($average_amount[0]->priceindollar) : 0,
            ]);
        }
        return json_encode(['priceinnaira' => 0, 'priceindollar' => 0]);
    }

    /**
     * @param int $limit
     * @return mixed Array || ArrayObject
     * this function call from homepage recent bike list
     */
    public static function getHomePageRecentBikeList($limit = 0)
    {
        $recentBikes = DB::table('posts')
            ->where('posts.status', 'Active')
            ->where('users.status', 'Active')
            ->where('posts.vehicle_type_id', 3)
            ->whereDate('posts.expiry_date', '>=', date('Y-m-d'))
            ->whereDate('posts.activation_date', '<=', date('Y-m-d'))
            ->orderByDesc('posts.activation_date')
            ->select('posts.condition', 'posts.title', 'posts.location', 'posts.priceinnaira', 'posts.mileage', 'posts.post_slug', 'posts.id', 'posts.priceinnaira', 'posts.priceindollar', 'posts.pricein', 'um.meta_value as is_verified')
            ->limit($limit)
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('user_meta as um', function ($join) {
                $join->on('users.id', '=', 'um.user_id');
                $join->where('um.meta_key', '=', "seller_tag");
            })
            ->get();

        return $recentBikes;
    }

    /**
     * @param int $limit
     * @return mixed Array || ArrayObject
     * this function call from homepage recent Spare Parts list
     */
    public static function getHomePageRecentSpareParts($limit = 0)
    {
        $recentSpareParts = DB::table('posts')
            ->where('posts.status', 'Active')
            ->where('users.status', 'Active')
            ->where('posts.vehicle_type_id', 4)
            ->whereDate('posts.expiry_date', '>=', date('Y-m-d'))
            ->whereDate('posts.activation_date', '<=', date('Y-m-d'))
            ->orderByDesc('posts.activation_date')
            ->select('posts.condition', 'posts.title', 'posts.location', 'posts.priceinnaira', 'posts.mileage', 'posts.post_slug', 'posts.id', 'posts.priceinnaira', 'posts.priceindollar', 'posts.pricein')
            ->orderByDesc('posts.created')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->limit($limit)
            ->get();
        return $recentSpareParts;
    }

    /**
     * @param int $limit
     * @return mixed Array || ArrayObject
     * this function call from homepage recent Car list
     */
    public static function getHomePageRecentCar($limit = 0)
    {
        $recentCar = DB::table('posts')
            ->where('posts.status', 'Active')
            ->where('users.status', 'Active')
            ->where('posts.vehicle_type_id', 1)
            ->whereNotNull('posts.position')
            ->whereDate('posts.expiry_date', '>=', date('Y-m-d'))
            ->whereDate('posts.activation_date', '<=', date('Y-m-d'))
            ->orderBy('posts.position', 'ASC')
            ->orderByDesc('posts.hit')
            ->select('posts.condition', 'posts.title', 'posts.location', 'posts.mileage', 'posts.post_slug', 'posts.id', 'posts.priceinnaira', 'posts.priceindollar', 'posts.pricein', 'um.meta_value as is_verified')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->leftJoin('user_meta as um', function ($join) {
                $join->on('users.id', '=', 'um.user_id');
                $join->where('um.meta_key', '=', "seller_tag");
            })
            ->limit($limit)
            ->get();
        return $recentCar;
    }

    public static function getPostThumbPhotoById($post_id = null, $post_title = null, $class = 'post-img', $variant = 'featured')
    {
        $photo = 'no-photo.jpg';
        if ($post_id) {
            $CI =& get_instance();
            $post_id = intval($post_id);
            $result = $CI->db->select('photo')
                ->get_where('post_photos', ['post_id' => $post_id, 'featured' => 'Yes'])
                ->row();
            $photo = isset($result->photo) ? $result->photo : 'no-photo.jpg';
        }
        $filename = 'uploads/car/' . $photo;
        if (filter_var($photo, FILTER_VALIDATE_URL)){
            $photo = str_replace('/public', '/' . ucfirst($variant), $photo);
            return '<img class="'.$class.'" src="' . $photo . '" alt="' . $post_title . '">';
        }elseif ($photo && file_exists($filename)) {
            return '<img class="'.$class.'" src="' . $filename . '" alt="' . $post_title . '">';
        } else {
            return '<img class="'.$class.'" src="assets/theme/new/images/no-photo.png" alt="' . $post_title . '">';
        }
    }

    public static function get_post_like($post_id = 0){
        $ci = &get_instance();
        return $ci->db->get_where('post_likes', ['post_id' => $post_id])->num_rows();
    }

//    public static function getMailThumbImage($id = 0,$alt = '',$class = ''){
//        $user = DB::table('users')
//            ->where('id','=',$id)
//            ->first();
//        $photo = $user->profile_photo;
//        $photofile = dirname(BASEPATH) . '/uploads/company_logo/' . $photo;
//        if ($photo && file_exists($photofile)) {
//            return '<img  alt="' . $alt . '" class="' . $class . '" src="uploads/company_logo/' . $photo . '"/>';
//        } else {
//            return '<img  alt="' . $alt . '" class="' . $class . '" src="assets/theme/new/images/no-photo.png"/>';
//        }
//
//    }

    static public function getVehicleIdbySlug($slug)
    {
        $ci = &get_instance();
        $type = $ci->db->from('vehicle_types')->select('id')->where('vehicle_types.slug', $slug)->get()->row();
        if (!empty($type)) return $type->id;
        return 0;
    }

    static public function getVehicleNamebySlug($slug)
    {
        $ci = &get_instance();
        $type = $ci->db->from('vehicle_types')->select('name')->where('vehicle_types.slug', $slug)->get()->row();
        if (!empty($type)) return $type->name;
        return '';
    }

    static public function getVehicleSlugbyId($id)
    {
        $ci = &get_instance();
        $type = $ci->db->from('vehicle_types')->select('slug')->where('vehicle_types.id', $id)->get()->row();
        if (!empty($type)) return $type->slug;
        return '';
    }

    static public function getVehicleNamebyId($id)
    {
        $ci = &get_instance();
        $type = $ci->db->from('vehicle_types')->select('name')->where('vehicle_types.id', $id)->get()->row();
        if (!empty($type)) return $type->name;
        return '';
    }

    static public function homeBrands(){
        $ci = &get_instance();
        $types = $ci->db->select('brands.*, count(posts.id) as count')
            ->from('brands')
            ->join('posts', 'posts.brand_id = brands.id')
            ->where(['type' => 'Brand', 'FIND_IN_SET(1, type_id) >' => 0])
            ->order_by('count', 'desc')
            ->limit(40)
            ->group_by('posts.brand_id')
            ->get()
            ->result();

        $html = '';
        foreach ($types as $type){
            $html .= "<li><a href=\"buy/car/search?brand=$type->slug\">$type->name</a></li>";
        }
        return $html;
    }

    static function mostViewedCar(){
        $ci = &get_instance();

        $ci->db->select('p.condition, p.location, p.pricein, p.priceindollar, p.priceinnaira, p.mileage, p.gear_box_type, p.vehicle_type_id, p.id, p.post_slug, p.title, um.meta_value as is_verified, p.user_id');
        $ci->db->select('pa.name as state_name, IF(c.id IS NOT NULL, 1, 0) as is_financing');
        $ci->db->from('posts as p');
        $ci->db->join('post_area as pa', "pa.id = p.location_id AND pa.type = 'state'");
        $ci->db->join('user_meta as um', 'p.user_id = um.user_id and um.meta_key = "seller_tag"', 'left');
        $ci->db->join(
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
              c.deleted_at = 0 AND
              c.type = 'loan'
              ",
            'LEFT'
        );
        $ci->db->where('p.activation_date IS NOT NULL');
        $ci->db->where('p.expiry_date >=', date('Y-m-d'));
        $ci->db->where('p.status', 'Active');
        $ci->db->where('p.vehicle_type_id', 1);
        $ci->db->order_by('p.hit', 'DESC');
        $ci->db->limit(4);
        $ci->db->group_by('p.id');

        $data =  $ci->db->get()->result();

        impression_increase(array_map(function($o) {
            return is_object($o) ? $o->id : $o['id'];
        }, json_decode(json_encode($data))));
        return $data;
    }

    static function ask_expert($limit = 12){
        $ci = &get_instance();
        $ci->db->limit($limit);
        $ci->db->order_by('id', 'DESC');
        $ci->db->where('status', 'Published');

        return $ci->db->get('ask_expert')->result();
    }

    static function repair_type(){
        $ci = &get_instance();
        $ci->db->order_by('title', 'ASC');

        return $ci->db->get('repair_types')->result();
    }

    static function repair_type_by_ids($ids = []){
        $ids = !empty($ids) ? $ids : [0];
        $ci = &get_instance();
        $ci->db->select('group_concat(title SEPARATOR  ", ") as title');
        $ci->db->order_by('title', 'ASC');
        $ci->db->where_in('id', $ids);

        $data = $ci->db->get('repair_types')->row();
        if (!empty($data)){
            return $data->title;
        }
        return '';
    }

    static function diagnostic_question(){
        $data_array = [
            [
                'image' => 'assets/new-theme/images/icons/mobile/hear.svg',
                'title' => 'I can hear it'
            ],
            [
                'image' => 'assets/new-theme/images/icons/mobile/nose.svg',
                'title' => 'I can smell it'
            ],
            [
                'image' => 'assets/new-theme/images/icons/mobile/hand.svg',
                'title' => 'I can feel it'
            ],
            [
                'image' => 'assets/new-theme/images/icons/mobile/eye.svg',
                'title' => 'I can see it'
            ],
            [
                'image' => 'assets/new-theme/images/icons/mobile/service.svg',
                'title' => 'It won’t start'
            ],
        ];

        return $data_array;
    }

    static function diagnostic_issue_type(){
        $data_array = [
            1 => 'Known',
            2 => 'Unknown',
        ];

        return $data_array;
    }

    static function diagnostics_question_type_dropdown($selected = null){
        $html = '';
        foreach (self::diagnostic_question() as $key => $type) {
            $value = $key + 1;
            $html .= "<option value='$value' ".($value == $selected ? ' selected' : '')." >". $type['title'] ."</option>";
        }
        return $html;
    }

    static function diagnostics_issue_type_dropdown($selected = null){
        $html = '';
        foreach (self::diagnostic_issue_type() as $key => $type) {
            $value = $key;
            $html .= "<option value='$value' ".($value == $selected ? ' selected' : '')." >". $type ."</option>";
        }
        return $html;
    }

    static  function getPortNameById($id = 0)
    {
        $ci =& get_instance();
        $repair_type = $ci->db->get_where('ports', ['id' => $id])->row();

        if ($repair_type) {
            return strtoupper($repair_type->name);
        } else {
            return 'No data';
        }
    }

    static  function PortDropdown($id = null){
        $ci =& get_instance();
        $ports = $ci->db->where('type', 'Destination')->get('ports')->result();
        $html = '';
        if (!empty($ports)){
            foreach ($ports as $port) {
                $html .= "<option value='$port->id' ".($port->id == $id ? ' selected' : '')." >".strtoupper($port->name)."</option>";
            }
        }
        return $html;
    }

    static  function PortDropdownApi(){
        $ci =& get_instance();
        return $ci->db->select('id, name')->where('type', 'Destination')->get('ports')->result();
    }

    static  function shippingPortDropdown($id = null){
        $ci =& get_instance();
        $ports = $ci->db->get('ports')->result();
        $html = '';
        if (!empty($ports)){
            foreach ($ports as $port) {
                $html .= "<option value='$port->id' ".($port->id == $id ? ' selected' : '')." >$port->name</option>";
            }
        }
        return $html;
    }

    public static function array_element_not_empty($get_array = [], $key = ''){
        $response = false;
        if (isset($get_array[$key]) && !empty($get_array[$key])){
            $response = true;
        }
        foreach ($get_array as $k => $value){
            if ($key != $k){
                if (!empty($value)){
                    $response = false;
                    break;
                }
            }
        }

        return $response;
    }

    public static function uploadImageToCloudfare($imageData, $fileName, $base = false)
    {
        $uploadPath = dirname(BASEPATH) . '/uploads/car/';

        // Ensure directory exists
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $filePath = $uploadPath . $fileName;

        // Save the image data to file
        file_put_contents($filePath, $imageData);

        // Return the relative or absolute path based on your needs
        return $fileName;
    }

    public static function get_new_price_for_search($name = 0)
    {
        $prices = [
            0,
            500000,
            1000000,
            1500000,
            2000000,
            2500000,
            3000000,
            3500000,
            4000000,
            4500000,
            5000000,
            5500000,
            6000000,
            6500000,
            7000000,
            7500000,
            8000000,
            8500000,
            9000000,
            9500000,
            10000000,
            15000000,
            20000000,
            25000000,
            30000000,
            35000000,
            40000000,
            45000000,
            50000000,
            55000000,
            60000000,
            65000000,
            70000000,
            75000000,
            80000000,
            85000000,
            90000000,
            95000000,
            100000000,
            150000000,
            200000000,
            500000000,
        ];

        $option = '';
        $ci = &get_instance();

        foreach ($prices as $price) {
            $class = $price == $ci->input->get($name) ? 'active' : '';
            $option .= '<li class="' . $class . '"><a href="' . search_link_builder($ci->input->get(), $name, $price) . '">&#x20A6;' . number_format($price, 0) . '</a></li>';
        }
        return $option;
    }

    public static function getHomePagePosition($position = '1', $post_id = 0, $access = false)
    {

        $currentStatus = GlobalHelper::switchHomePagePosition($position);
        if ($access) {
            $string = "<div class='dropdown'>
                        <button class='btn btn-default btn-xs' id='active_status_$post_id' type='button' data-toggle='dropdown'>
                             $currentStatus &nbsp; <i class='fa fa-angle-down'></i>
                        </button>
                        <ul class='dropdown-menu'>
                            <li><a onclick=\"homepagePositionUpdate( $post_id, '1');\"> <i class='fa fa-sort'></i> 1</a></li>
                            <li><a onclick=\"homepagePositionUpdate( $post_id, '2');\"> <i class='fa fa-sort'></i> 2</a></li>
                            <li><a onclick=\"homepagePositionUpdate( $post_id, '3');\"> <i class='fa fa-sort'></i> 3</a></li>
                            <li><a onclick=\"homepagePositionUpdate( $post_id, '4');\"> <i class=\"fa fa-sort\"></i> 4</a></li>
                        </ul>
                    </div>";

        } else {
            $string = $currentStatus;
        }

        return $string;
    }

    public static function switchHomePagePosition($position = '0')
    {
        switch ($position) {
            case '1':
                $position = ['<i class="fa fa-sort"></i>', '1', 'default'];
                break;
            case '2':
                $position = ['<i class="fa fa-sort"></i>', '2', 'default'];
                break;
            case '3':
                $position = ['<i class="fa fa-sort"></i>', '3', 'default'];
                break;
            case '4':
                $position = ['<i class="fa fa-sort"></i>', '4', 'default'];
                break;
            default :
                $position = ['<i class="fa fa-sort"></i>', '0', 'default'];
        }
        return '<span class="label label-' . $position[2] . '">' . $position[0] . ' ' . $position[1] . '</span>';

        /*
        $CI =& get_instance();
        return ($CI->input->is_ajax_request()) ?  $status : $status[0] .' '. $status[1];
         *
         */
    }

    public static function getTotalCarsOfADriver($userId)
    {
        $ci =& get_instance();
        $cars = $ci->db->where('user_id', $userId)->where('status', 'Available')->get('driver_car')->num_rows();

        return $cars;
    }

    public static function all_tags($selected = [])
    {
        $ci = &get_instance();
        $html = '';
        $tags = $ci->db->order_by('name', 'ASC')->get('product_tags')->result();

        foreach ($tags as $tag) {
            $selectedClass = in_array($tag->id, $selected) ? 'selected' : '';
            $html .= "<option value=\"$tag->id\" $selectedClass>$tag->name</option>";
        }

        return $html;
    }

    public static function mechanicVerificationStatus($id = NULL, $label = '--Select--')
    {
        $ci =& get_instance();
        $seller_tag = $ci->db->get_where('mechanic', ['user_id' => $id])->row();
        $selected = isset($seller_tag) ? $seller_tag->badge : '';
        $status = [
            'Verified' => 'Verified',
            'Unverified' => 'Unverified'
        ];

        $options = '<option value="0">' . $label . '</option>';
        foreach ($status as $key => $row) {
            $options .= '<option value="' . $key . '" ';
            $options .= ($key == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row . '</option>';
        }
        return $options;
    }
}
