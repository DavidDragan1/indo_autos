<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend_controller extends MX_Controller {

    public function __construct() {
        date_default_timezone_set("Europe/London");
        parent::__construct();

        $maintenance = getSettingItem('Maintenance');
        if(!empty($maintenance) && $this->uri->segment(1) != 'maintenance' && $this->uri->segment(1) != 'adb-login') {
            $maintenance_value = maintenanceValue($maintenance);

            if($maintenance_value[1]) {
                if(!empty($maintenance_value[2]) && $maintenance_value[2] > date('Y-m-d H:i:s')) {
                    redirect('maintenance', 'refresh');
                }
                else {
                    redirect('maintenance', 'refresh');
                }
            }
            else {
                redirect('/', 'refresh');
            }
        }
    }

    public function index(){

        $PageSlug   = empty($this->uri->segment(1)) ? 'home' : $this->uri->segment(1);
        $MatchSearchTemplate = ['auction-cars', 'import-car', 'motorbike', 'spare-parts','vans',   'automech-search'];
        $PageSlug   = in_array($PageSlug, $MatchSearchTemplate) ?  'search' : $PageSlug ;

        $cms        = $this->db->get_where('cms', ['post_url' => $PageSlug])->row_array();
        $post_type  = isset($cms['post_type'])?$cms['post_type']:'';
//        var_dump($post_type);
//        die();
        if( $post_type == 'page') {
            $this->getCmsPage($cms, $PageSlug);
        } elseif($post_type == 'business' ){
            $this->getBusinessPage($cms);
        }  else {
           $this->viewFrontContent( 'frontend/404' );
        }
    }

    private function getBusinessPage( $seller_page = [] ){

        // $seller_page primary content coming form cms tbl
        $this->load->helper('reviews/reviews');
        $this->load->library('session');
        $this->session->keep_flashdata(array('status', 'message'));

        if(!$seller_page){
           $this->viewFrontContentNew('frontend/404' );
        } else {
            $user_id        = $seller_page['user_id'];
            $seller_user    = $this->db->get_where('users', ['id' => $user_id])->row_array();
            if ($seller_user['status'] != 'Active'){
                $this->viewFrontContentNew('frontend/404' );
                return false;
            }
            $seller_meta    = GlobalHelper::getUserMetaData($user_id);
            $videos = $this->db->select('*')
                ->where(['user_id' => $user_id, 'type' => 'Video', 'status' => 'Active'])
                ->order_by('id', 'DESC')
                ->limit(3)
                ->get('gallery')
                ->result();

            $seller = [
                'seller' => $seller_page,
                'user' => $seller_user,
                'meta' => $seller_meta,
                'videos' => $videos,
                'cars' => $this->getData(1, $user_id),
                'bikes' => $this->getData(3, $user_id),
                'parts' => $this->getData(4, $user_id),
              ];

            if (getLoginUserData('user_id') != $user_id){
                //adding impression
                impression_increase(array_map(function($o) {
                    return is_object($o) ? $o->id : $o['id'];
                }, $seller['cars']));
                impression_increase(array_map(function($o) {
                    return is_object($o) ? $o->id : $o['id'];
                }, $seller['bikes']));
                impression_increase(array_map(function($o) {
                    return is_object($o) ? $o->id : $o['id'];
                }, $seller['parts']));
            }

            $this->db->select('reviews.*, child.review as child_review, child.id as child_id, users.city')
                ->select("CONCAT(CONCAT(users.first_name, ' ') , users.last_name) as user_name")
                ->where('reviews.status','Approve');
            $this->db->order_by('reviews.id', 'ASC');
            $this->db->where('reviews.vendor_id', $user_id);
            $this->db->join('users', 'users.id = reviews.customer_id', 'Left');
            $this->db->join('reviews as child', 'child.parent_id = reviews.id', 'left');
            $seller['reviews'] = $this->db->get('reviews')->result();


            $seller['meta_title']        = $seller_page['post_title'];
            $seller['meta_description']  = getShortContent($seller_page['seo_description'], 120);
            $seller['meta_keywords']     = $seller_page['seo_keyword'];

            $write_review_status = 'no';
            $logged_user = getLoginUserData('user_id');

            $this->db->select('reviews.id');
            $this->db->where('reviews.vendor_id', $user_id);
            $this->db->where('reviews.customer_id', $logged_user);
            $befor_review = $this->db->get('reviews')->row();

            if (empty($logged_user)){
                $write_review_status = 'login';
            } elseif (!empty($befor_review)){
                $write_review_status = 'no';
            } elseif ($logged_user == $user_id){
                $write_review_status = 'ask';
            } else {

                $msg = $this->db->query('select message.id from message 
                                     where (sender = ' . $logged_user . ' and receiver = ' . $user_id . ') or (sender = ' . $user_id . ' and receiver = ' . $logged_user . ')')->row();
                if (!empty($msg)){
                    $write_review_status = 'yes';
                } else {
                    $mails = $this->db->query("select mails.id from mails 
                                     where (sender_id = '$logged_user' and reciever_id = '$user_id') or (sender_id = '$user_id' and reciever_id = '$logged_user')")->row();
                    if (empty($mails)){
                        $write_review_status = 'ask';
                    } else {
                        $write_review_status = 'yes';
                    }
                }
            }

            $seller['write_review_permission'] = $write_review_status;// $write_review_status;

            $seller['breads'] = [
                'Seller',
                $seller_page['post_title']
            ];

//            $this->viewFrontContent('frontend/template/business_page', $seller );
            $this->viewFrontContentNew('frontend/new/template/business_page', $seller);
        }
    }

    private function getData($vehicle_type_id, $user_id){
        $this->db->select('p.condition, p.location, p.pricein, p.priceindollar, p.priceinnaira, p.mileage, p.gear_box_type, p.vehicle_type_id, p.id, p.post_slug, p.title, um.meta_value as is_verified');
        $this->db->select('pa.name as state_name, IF(c.id IS NOT NULL, 1, 0) as is_financing');
        $this->db->from('posts as p');
        $this->db->join('post_area as pa', "pa.id = p.location_id AND pa.type = 'state'");
        $this->db->join('user_meta as um', 'p.user_id = um.user_id and um.meta_key = "seller_tag"', 'left');
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
        $this->db->where('p.vehicle_type_id', $vehicle_type_id);
        $this->db->where('p.user_id', $user_id);
        $this->db->order_by('p.id', 'DESC');
        $this->db->group_by('p.id');
        return $this->db->get()->result();
    }

    private function getCmsPage( $cms, $PageSlug = ''){
        $cms_page                       = [ 'cms' => $cms ] ;
        $cms_page['meta_title']         = $cms['seo_title'];
        $cms_page['meta_description']   = getShortContent($cms ['seo_description'], 120);
        $cms_page['meta_keywords']      = $cms ['seo_keyword'];
        // Try to hack simple page views
        if (in_array($PageSlug, ['home', 'diagnostic', 'mobile-services', 'online-mechanic', 'about-us', 'ask-an-expert'])){
            $viewTeamplatePath  = APPPATH . '/views/frontend/new/template/' . $PageSlug . '.php';
            $viewPath  = (file_exists( $viewTeamplatePath ))
                ? ('new/template/' .   $PageSlug )
                : 'new/template/page';

            if ($PageSlug == 'home') {
                $cms_page['recentBikes'] = GlobalHelper::getHomePageRecentBikeList(4);
                $cms_page['recentSpareParts'] = GlobalHelper::getHomePageRecentSpareParts(4);
                $cms_page['recentCars'] = GlobalHelper::getHomePageRecentCar(4);
//                 pp($cms_page['recentCars']);
                impression_increase(array_map(function ($o) {
                    return is_object($o) ? $o->id : $o['id'];
                }, json_decode(json_encode($cms_page['recentBikes']))));
                impression_increase(array_map(function ($o) {
                    return is_object($o) ? $o->id : $o['id'];
                }, json_decode(json_encode($cms_page['recentSpareParts']))));
                impression_increase(array_map(function ($o) {
                    return is_object($o) ? $o->id : $o['id'];
                }, json_decode(json_encode($cms_page['recentCars']))));
            }

            $this->viewFrontContentNew( 'frontend/' . $viewPath, $cms_page );
        } else {
            $viewTeamplatePath  = APPPATH . '/views/frontend/template/' . $PageSlug . '.php';
//            $viewPath  = (file_exists( $viewTeamplatePath ))
//                ? ('template/' .   $PageSlug )
//                : 'template/page';
            if (file_exists( $viewTeamplatePath )){
                $this->viewFrontContentNew( 'frontend/template/' . $PageSlug, $cms_page );
            } else {
                $this->viewFrontContentNew( 'frontend/404', [] );
            }

        }







       // dd($cms_page);



    }


    public function viewMemberContent($view, $data = []){
       echo $this->load->view('frontend/header');
       echo $this->load->view($view, $data);
       echo $this->load->view('frontend/footer');
    }

    public function viewFrontContent($view, $data = []){
        if ($view === "frontend/404") {
            $this->load->view("frontend/404");
        } else {
            $this->load->view('frontend/header', $data);
            $this->load->view($view, $data);
            $this->load->view('frontend/footer');
        }
    }

    public function viewFrontContentNew($view, $data = []){
        if ($view === "frontend/404") {
            $this->load->view("frontend/404");
        } else {
            $this->load->view('frontend/new/header', $data);
            $this->load->view($view, $data);
            $this->load->view('frontend/new/footer');
        }
    }

    public function privetSeller($id){
        // $seller_page primary content coming form cms tbl
        $this->load->helper('reviews/reviews');
        $this->load->library('session');
        $this->session->keep_flashdata(array('status', 'message'));

        if(!$id){
            $this->viewFrontContentNew('frontend/404' );
        } else {
            $user_id        = $id;
            $seller_user    = $this->db->get_where('users', ['id' => $user_id])->row_array();
            $seller_meta    = GlobalHelper::getUserMetaData($user_id);
            $seller_page['user_id'] = $id;
            $seller_page['content'] = isset($seller_meta['content']) ? $seller_meta['content'] : "";

            $seller = [
                'seller' => $seller_page,
                'user' => $seller_user,
                'meta' => $seller_meta,
                'videos' => null,
                'cars' => $this->getData(1, $user_id),
                'bikes' => $this->getData(3, $user_id),
                'parts' => $this->getData(4, $user_id),
            ];

            $this->db->select('reviews.*, child.review as child_review, child.id as child_id, users.city')
                ->select("CONCAT(CONCAT(users.first_name, ' ') , users.last_name) as user_name")
                ->where('reviews.status','Approve');
            $this->db->order_by('reviews.id', 'ASC');
            $this->db->where('reviews.vendor_id', $user_id);
            $this->db->join('users', 'users.id = reviews.customer_id', 'Left');
            $this->db->join('reviews as child', 'child.parent_id = reviews.id', 'left');
            $seller['reviews'] = $this->db->get('reviews')->result();


            $seller['meta_title']        = $seller_user['first_name'].' '. $seller_user['last_name'];
            $seller['meta_description']  = $seller_user['first_name'].' '. $seller_user['last_name'];
            $seller['meta_keywords']     = $seller_user['first_name'].' '. $seller_user['last_name'];

            $write_review_status = 'no';
            $logged_user = getLoginUserData('user_id');

            $this->db->select('reviews.id');
            $this->db->where('reviews.vendor_id', $user_id);
            $this->db->where('reviews.customer_id', $logged_user);
            $befor_review = $this->db->get('reviews')->row();

            if (empty($logged_user)){
                $write_review_status = 'no';
            } elseif (!empty($befor_review)){
                $write_review_status = 'no';
            } elseif ($logged_user == $user_id){
                $write_review_status = 'no';
            } else {

                $msg = $this->db->query('select message.id from message 
                                     where (sender = ' . $logged_user . ' and receiver = ' . $user_id . ') or (sender = ' . $user_id . ' and receiver = ' . $logged_user . ')')->row();
                if (!empty($msg)){
                    $write_review_status = 'yes';
                } else {
                    $mails = $this->db->query("select mails.id from mails 
                                     where (sender_id = '$logged_user' and reciever_id = '$user_id') or (sender_id = '$user_id' and reciever_id = '$logged_user')")->row();
                    if (empty($mails)){
                        $write_review_status = 'ask';
                    } else {
                        $write_review_status = 'yes';
                    }
                }
            }

            $seller['write_review_permission'] = $write_review_status;// $write_review_status;

            $seller['breads'] = [
                'Seller',
                $seller_user['first_name'].' '.$seller_user['last_name']
            ];

//            $this->viewFrontContent('frontend/template/business_page', $seller );
            $this->viewFrontContentNew('frontend/new/template/business_page', $seller);
        }
    }
}
