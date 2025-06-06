<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-10-14
 */
use Illuminate\Database\Capsule\Manager as DB;
class Posts extends Admin_controller {

    function __construct() {
        //  GlobalHelper::access_log();
        parent::__construct();
        $this->load->model('Posts_model');
        $this->load->helper('posts');
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->load->library('session');
        $this->session->keep_flashdata(array('status', 'message'));
    }

    public function index() {

        $user_id = getLoginUserData('user_id');
        $role_id = getLoginUserData('role_id');

        $manage_all_post = checkPermission('posts/manage_all', $role_id);

        //$manage_all_post = 0; //checkPermission('manage_all_posts', $role_id);


        //var_dump($user_id);


        $q = urldecode($this->input->get('q', TRUE)?$this->input->get('q', TRUE):'');

        $start = intval($this->input->get('start'));

        $status	 	= urldecode($this->input->get('status', TRUE)?$this->input->get('status', TRUE):'');
        $id = urldecode($this->input->get('id', TRUE)?$this->input->get('id', TRUE):'');
        $name = urldecode($this->input->get('name', TRUE)?$this->input->get('name', TRUE):'');
        $range = urldecode($this->input->get('range', TRUE)?$this->input->get('range', TRUE):'');
        $fd = urldecode($this->input->get('fd', TRUE)?$this->input->get('fd', TRUE):'');
        $td = urldecode($this->input->get('td', TRUE)?$this->input->get('td', TRUE):'');




        $sortInput = $this->input->get('sortBy');

        if ($q <> '' || $range <> '' || $status <> '' || $id <> '' || $name <> '' || $fd <> '' || $td <> '') {
            $config['base_url'] = Backend_URL . 'posts/?q=' . urlencode($q).'&range='.urlencode($range).'&id='.urlencode($id).'&name='.urlencode($name).'&status='.urlencode($status).'&fd='.urlencode($fd).'&td='.urlencode($td);
            $config['first_url'] = Backend_URL . 'posts/?q=' . urlencode($q).'&range='.urlencode($range).'&id='.urlencode($id).'&name='.urlencode($name).'&status='.urlencode($status).'&fd='.urlencode($fd).'&td='.urlencode($td);
        } else {
            $config['base_url'] = Backend_URL . 'posts';
            $config['first_url'] = Backend_URL . 'posts';

            if (!empty($sortInput) && $sortInput !== 'All'){
                $config['base_url'] = Backend_URL . 'posts?sortBy='.$sortInput;
                $config['first_url'] = Backend_URL . 'posts?sortBy='.$sortInput;
            }
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;


        if ($manage_all_post == true) {

            $config['total_rows'] = $this->Posts_model->total_rows($q,$range , $id,$name,$status, $fd, $td );

            $posts = $this->Posts_model->get_limit_data($config['per_page'], $start, $q, $range,$id, $name, $status , $fd, $td );
        } else {
            $config['total_rows'] = $this->Posts_model->total_rows_byVender($q, $user_id);
            $posts = $this->Posts_model->get_limit_data_byVender($config['per_page'], $start, $q, $user_id);
            if (!empty($sortInput) && $sortInput !== 'All'){
                $config['total_rows'] = $this->Posts_model->total_rows_byVenderWithSorting($q, $user_id,$sortInput);
                $posts = $this->Posts_model->get_limit_data_byVenderWithSorting($config['per_page'], $start, $q, $user_id,$sortInput);
            }
//            pp($config['total_rows']);
            $config['query_string_segment'] = 'start';

            $config['num_links'] = 1;

            $config['full_tag_open'] = '<ul class="pagination-wrap">';
            $config['full_tag_close'] = '</ul>';

            $config['first_link'] = false;
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';

            $config['last_link'] = false;
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';

            $config['next_link'] = '<i class="fa fa-angle-right"></i>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';

            $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li><span class="active">';
            $config['cur_tag_close'] = '</span></li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
        }

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'posts' => $posts,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'access' => $manage_all_post,
            'name'=>$name,
            'id'=>$id,
            'range'=>$range,
            'fd'=>$fd,
            'td'=>$td
        );

       // echo  $this->db->last_query();

        if ($role_id == 1 or $role_id == 2) {
            $this->viewAdminContent('posts/index', $data);
        } else {
            $sort = [
                'sortValue'=> !empty($sortInput) ? $sortInput : 'All'
            ];
            $data  = array_merge($data,$sort);
            $this->viewAdminContentPrivate('backend/trade/template/post_list', $data);
        }
    }

    // ============== XXXXXXX ===============
    public function create() {
        $role_id = getLoginUserData('role_id');
        $post_type = $this->input->get('post_type');

        if ($role_id == 6){
            $this->viewAdminContentPrivate('backend/trade/template/buyer_to_seller_notification', []);
            return false;
        }

        if (empty($post_type) && !in_array($role_id, [1,2])){
            $this->viewAdminContentPrivate('backend/trade/template/create_post');
            return false;
        }

        $data = array(
            'button'  => 'Create',
            'action' => site_url(Backend_URL . 'posts/create_action'),
        );
//        if($post_type == 'Automech'){
//            if ($role_id == 1 or $role_id == 2) {
//                $this->viewAdminContent('posts/create_automech', $data);
//            } else {
//                $data['action'] = site_url(Backend_URL . 'posts/create_post');
//                $this->viewNewAdminContent('posts/trader_create_automech', $data);
//            }
//        } else if($post_type == 'Towing'){
//            if ($role_id == 1 or $role_id == 2) {
//                $this->viewAdminContent('posts/create_towing', $data);
//            } else {
//                $data['action'] = site_url(Backend_URL . 'posts/create_post');
//                $this->viewNewAdminContent('posts/trader_create_towing', $data);
//            }
//        } else {
            if ($role_id == 1 or $role_id == 2) {
                $this->viewAdminContent('posts/create', $data);
            } else {
                $data['action'] = site_url(Backend_URL . 'posts/create_post');
                if(isset($_GET['post_type'])  && $_GET['post_type'] === 'import-car'){
                    $this->viewAdminContentPrivate('backend/trade/template/create_import_car_post_form', $data);
                }else{
                    $this->viewAdminContentPrivate('backend/trade/template/create_post_form', $data);
                }

            }
       // }
    }

    public function create_action() {
        $posType = $this->input->post('post_type');
        if(  $posType == 'Automech' ) {
            $post_type = 'Automech';
        } else if($posType == 'Towing'){
           $post_type = 'Towing';
        } else {
            $post_type = 'General';
        }

        $data = array(
            'user_id'           => getLoginUserData('user_id'),
            'vehicle_type_id'   => $this->input->post('vehicle_type_id', TRUE),
            'location'          => $this->input->post('location', TRUE),
            'location_id'       => $this->input->post('location_id', TRUE),
            'lat'               => $this->input->post('lat', TRUE),
            'lng'               => $this->input->post('lng', TRUE),
            'package_id'        => $this->input->post('package_id', TRUE),
            'registration_date' => '0000-00-00',
            'advert_type'       => $this->input->post('advert_type', TRUE),
            'condition'         => $this->input->post('condition', TRUE),
            'post_slug'         => 'ad_'.time(),
            'post_type'         => $post_type,
            'created'           => date('Y-m-d h:i:s'),
            'modified'          => date('Y-m-d h:i:s'),
        );

        $this->Posts_model->insert($data);
        $insert_id = $this->db->insert_id();

        $package_data = array(
            'listing_id' => $insert_id,
            'user_id' => getLoginUserData('user_id'),
            'package_id' => $this->input->post('package_id', TRUE),
            'price' => getPackagePrice($this->input->post('package_id')),
            'payment_status' => 'Unpaid',
            'status' => 'Pending',
            'created' => date('Y-m-d h:i:s'),
        );

        $this->db->insert('listing_package', $package_data);

         Modules::run('mail/add_post_notice',$insert_id );

        redirect(site_url(Backend_URL . 'posts/update_post_detail/' . $insert_id));
    }

    // ============== For Step 1 ===============

    public function update_general($id = null) {
        $row = $this->Posts_model->get_by_id($id);

        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'posts/update_general_action'),
            'id' => $row->id,
            'user_id' => $row->user_id,
            'package_id' => $row->package_id,
            'vehicle_type_id' => $row->vehicle_type_id,
            'advert_type' => $row->advert_type,
            'condition' => $row->condition,
            'location_id' => $row->location_id,
            'listing_type' => $row->listing_type,
            'post_type' => $row->post_type,
            'location' => $row->location,
            'activation_date'   => $row->activation_date,
            'lat' => $row->lat,
            'lng' => $row->lng,
        );

        $role_id = getLoginUserData('role_id');

        if ($role_id == 1 or $role_id == 2) {
            $this->viewAdminContent('posts/update_general', $data);
        } else {
            $this->viewNewAdminContent('posts/trader_update_general', $data);
        }
		// $this->session->set_flashdata('message', '<p class="ajax_success">Post Saved</p>');
    }

    public function update_general_action() {

        $this->db->select('user_id, status');
        $this->db->where('id',  $this->input->post('id', TRUE));
        $post_user = $this->db->get('posts')->row();
        $roleID = getLoginUserData('role_id');
        $userID = getLoginUserData('user_id');
        if($roleID == 4 || $roleID == 5) {
            if($userID == $post_user->user_id){
                $status = 'Pending';
            }
        } else {
            $status = $post_user->status;
        }



        $post_id = $this->input->post('id', TRUE);

        $data = array(
            'id' => $this->input->post('id', TRUE),
            'vehicle_type_id' => $this->input->post('vehicle_type_id', TRUE),
            'advert_type' => $this->input->post('advert_type', TRUE),
            'condition' => $this->input->post('condition', TRUE),
            'location_id' => $this->input->post('location_id', TRUE),
            'listing_type' => $this->input->post('listing_type', TRUE),
            'location' => $this->input->post('location', TRUE),
            'package_id' => $this->input->post('package_id', TRUE),
            'lat' => $this->input->post('lat', TRUE),
            'lng' => $this->input->post('lng', TRUE),
            'status' => $status,
            'modified' => date('Y-m-d H:i:s'),
        );

        if(in_array($roleID, [1,2,3])){
            $data['activation_date'] = $this->input->post('activation_date', TRUE);

            if (!empty($data['activation_date']) && $data['activation_date'] != '0000-00-00') {
                $data['status'] = 'Active';
                $data['expiry_date'] = date('Y-m-d', strtotime('+30 days'));
            } else {
                $data['activation_date'] = null;
            }
        }

       //  dd($data);

        $this->Posts_model->update($post_id, $data);


        $package_data = array(
            'listing_id' => $this->input->post('id', TRUE),
            'user_id' => getLoginUserData('user_id'),
            'package_id' => $this->input->post('package_id', TRUE),
            'price' => getPackagePrice($this->input->post('package_id')),
            'payment_status' => 'Unpaid',
        );

        $check_listing_package = $this->db->get_where('listing_package', ['listing_id' => $this->input->post('id')])->row();

        if ($check_listing_package) {
            $this->db->update('listing_package', $package_data, ['listing_id' => $this->input->post('id')]);
        } else {
            $this->db->insert('listing_package', $package_data);
        }


        redirect(site_url(Backend_URL . 'posts/update_post_detail/' . $post_id));
    }

    // ============== For Step 1 ===============

    public function update_valuation($id = null) {
        $row = $this->Posts_model->get_by_id($id);

        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'posts/update_valuation_action'),
            'id' => $row->id,
            'user_id' => $row->user_id,
            'package_id' => $row->package_id,
            'vehicle_type_id' => $row->vehicle_type_id,
            'advert_type' => $row->advert_type,
            'condition' => $row->condition,
            'location_id' => $row->location_id,
            'listing_type' => $row->listing_type,
            'post_type' => $row->post_type,
            'location' => $row->location,
            'activation_date'   => $row->activation_date,
            'lat' => $row->lat,
            'lng' => $row->lng,
        );

        $role_id = getLoginUserData('role_id');

        if ($role_id == 1 or $role_id == 2) {
            $this->viewAdminContent('posts/update_valuation', $data);
        } else {
            $this->viewNewAdminContent('posts/trader_create', $data);
        }
        // $this->session->set_flashdata('message', '<p class="ajax_success">Post Saved</p>');
    }

    public function update_valuation_action() {

        $this->db->select('user_id, status');
        $this->db->where('id',  $this->input->post('id', TRUE));
        $post_user = $this->db->get('posts')->row();

        $roleID = getLoginUserData('role_id');
        $userID = getLoginUserData('user_id');
        if($roleID == 4 || $roleID == 5) {
            if($userID == $post_user->user_id){
                $status = 'Pending';
            }
        } else {
            $status = $post_user->status;
        }



        $post_id = $this->input->post('id', TRUE);

        $data = array(
            'id' => $this->input->post('id', TRUE),
            'vehicle_type_id' => $this->input->post('vehicle_type_id', TRUE),
            'advert_type' => $this->input->post('advert_type', TRUE),
            'condition' => $this->input->post('condition', TRUE),
            'location_id' => $this->input->post('location_id', TRUE),
            'listing_type' => $this->input->post('listing_type', TRUE),
            'location' => $this->input->post('location', TRUE),
            'package_id' => $this->input->post('package_id', TRUE),
            'lat' => $this->input->post('lat', TRUE),
            'lng' => $this->input->post('lng', TRUE),
            'status' => $status,
            'modified' => date('Y-m-d H:i:s'),
        );

        if(in_array($userID, [1,2,3])){
            $data['activation_date'] = $this->input->post('activation_date', TRUE);
        }

        //  dd($data);

        $this->Posts_model->update($post_id, $data);


        $package_data = array(
            'listing_id' => $this->input->post('id', TRUE),
            'user_id' => getLoginUserData('user_id'),
            'package_id' => $this->input->post('package_id', TRUE),
            'price' => getPackagePrice($this->input->post('package_id')),
            'payment_status' => 'Unpaid',
        );

        $check_listing_package = $this->db->get_where('listing_package', ['listing_id' => $this->input->post('id')])->row();

        if ($check_listing_package) {
            $this->db->update('listing_package', $package_data, ['listing_id' => $this->input->post('id')]);
        } else {
            $this->db->insert('listing_package', $package_data);
        }


        redirect(site_url(Backend_URL . 'posts/update_post_detail/' . $post_id));
    }
    // ============== For Step 2 ===============
    public function update_post_detail($id) {

        $row = $this->Posts_model->get_by_id($id);

        if( $row->post_type == 'Automech' ) {
           $vehicleID =  '0';
        } else if( $row->post_type == 'Towing' ) {
           $vehicleID =  '0';
        } else {
            $vehicleID =  $row->vehicle_type_id;
        }


        if ($row) {
            $tags = $this->db->select('name, id')->get('product_tags')->result();
            $data = array(
                'button'        => 'Update',
                'action'        => site_url(Backend_URL . 'posts/update_post_detail_action/' . $vehicleID ),
                'id'            => set_value('id', $row->id),
                'vehicle_type_id' => set_value('vehicle_type_id', $row->vehicle_type_id),
                'location_id'      => set_value('location', $row->location_id),
                'condition'      => set_value('location', $row->condition),
                'title'         => set_value('title', $row->title),
                'post_slug'     => set_value('post_slug', $row->post_slug),
                'description'   => set_value('description', $row->description),
                'towing_service_id'   => set_value('towing_service_id', $row->towing_service_id),
                'towing_type_of_service_id'   => set_value('towing_type_of_service_id', $row->towing_type_of_service_id),
                'availability'   => set_value('availability', $row->availability),
                'vehicle_type'   => set_value('vehicle_type', $row->vehicle_type),

                'pricein'       => set_value('pricein', $row->pricein),
                'priceindollar' => set_value('priceindollar', $row->priceindollar),
                'priceinnaira'  => set_value('priceinnaira', $row->priceinnaira),
                'price'         => ($row->pricein == 'USD')
                                        ? set_value('priceindollar', $row->priceindollar)
                                        : set_value('priceinnaira', $row->priceinnaira),


                'mileage'       => set_value('mileage', $row->mileage),
                'brand_id'      => set_value('brand_id', $row->brand_id),
                'model_id'      => set_value('model_id', $row->model_id),
                'car_age'       => set_value('car_age', $row->car_age),
                'alloywheels'   => set_value('alloywheels', $row->alloywheels),
                'fuel_id'       => set_value('fuel_id', $row->fuel_id),
                'enginesize_id' => set_value('enginesize_id', $row->enginesize_id),
                'gear_box_type' => set_value('gear_box_type', $row->gear_box_type),
                'seats'         => set_value('seats', $row->seats),
                'color'         => set_value('color', $row->color),
                'post_type'         => set_value('post_type', $row->post_type),
                'parts_description' => set_value('parts_description', $row->parts_description),
                'parts_id' => set_value('parts_id', $row->parts_id),
                'parts_for' => set_value('parts_for', $row->parts_for),
                'repair_type_id' => set_value('repair_type_id', $row->repair_type_id),
                'category_id' => set_value('category_id', $row->category_id),
                'specialism_id' => set_value('specialism_id', $row->specialism_id),
                'service_type' => set_value('service_type', $row->service_type),
                'body_type'         => set_value('body_type', $row->body_type),
                'registration_date' => set_value('registration_date', $row->registration_date),
                'manufacture_year'  => set_value('manufacture_year', $row->manufacture_year),
                'registration_no'   => set_value('registration_no', $row->registration_no),
                'feature_ids'       => set_value('feature_ids', $row->feature_ids),
                'owners'            => set_value('owners', $row->owners),
                'service_history'   => set_value('service_history', $row->service_history),
                'modified'          => set_value('modified', $row->modified),
                'tag_id'          => set_value('tag_id', $row->tag_id),
                'tags' => $tags,
                'tags_id'          => explode(',', (string)$row->tag_id),
            );

            $role_id = getLoginUserData('role_id');

            if ($role_id == 1 or $role_id == 2) {
                $this->viewAdminContent('posts/update_post_detail', $data);
            } else {
                $this->viewNewAdminContent('posts/trader_update_post_detail', $data);
            }
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'posts'));
        }
    }

    public function update_post_detail_action($vehicle_id  ) {



	$this->db->select('user_id, status, post_type ');
        $this->db->where('id',  $this->input->post('id', TRUE) );
        $post_user = $this->db->get('posts')->row();


        $post_type = $post_user->post_type;

//        echo  '<pre>';
//        print_r($_POST);
//        echo  '</pre>';
//        die;

        $roleID = getLoginUserData('role_id');
        $userID = getLoginUserData('user_id');
        if($roleID == 4 || $roleID == 5) {
            if($userID == $post_user->user_id){
                $status = 'Pending';
            }
        } else {
            $status = $post_user->status;
        }


	// type_id = 2  [ MotorBike ]
	// type_id = 4  [ Parts  ]


        $regiday = $this->input->post('regiday');
        $regimonth = $this->input->post('regimonth');
        $regiyear = $this->input->post('regiyear');

        $pricein = $this->input->post('pricein');
        $pricevalue = $this->input->post('pricevalue');

        $price = [];
        if ($pricein == 'NGR') {
            $price['priceinnaira'] = $pricevalue;
        } else {
            $price['priceindollar'] = $pricevalue;
        }




        $data = array(
            'title' => $this->input->post('title', TRUE),
            'post_slug' => $this->duplicateURLremove($this->input->post('post_slug', TRUE), $this->input->post('id', TRUE)),
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
            'modified' => date('Y-m-d h:i:s'),
            'status' => $status,
//            'tag_id' => $this->input->post('tag_id', TRUE),
        );

        // only MotorBike
        $vehicle = [];
        if ($vehicle_id == 2) {
            $feature_ids                = $this->input->post('feature_ids');

            $vehicle['mileage']         =  $this->input->post('mileage', TRUE);
            $vehicle['car_age']         =  $this->input->post('car_age', TRUE);
            $vehicle['alloywheels']     =  $this->input->post('alloywheels', TRUE);
            $vehicle['fuel_id']         =  $this->input->post('fuel_id', TRUE);
            $vehicle['enginesize_id']   =  $this->input->post('enginesize_id', TRUE);
            $vehicle['color']           =  $this->input->post('color', TRUE);
            $vehicle['registration_date'] =  $regiyear . '-' . $regimonth . '-' . $regiday;
            $vehicle['registration_no'] =  $this->input->post('registration_no', TRUE);

            if($feature_ids && count($feature_ids) > 0) {
                $vehicle['feature_ids'] = implode(',', $feature_ids); ;
            }

            $data = $data + $vehicle;
        }




        // only Parts
        else if ($vehicle_id == 4) {
            $parts = array(
                'parts_description' => $this->input->post('parts_description', TRUE),
                'parts_for' => $this->input->post('parts_for', TRUE),
                'repair_type_id' => $this->input->post('repair_type_id', TRUE),
                'category_id' => $this->input->post('category_id', TRUE),
                'parts_id' => $this->input->post('parts_id', TRUE),
            );
            $data = $data + $parts;
        } else if( $post_type == 'Automech' ) {
            $automech = array(
                'category_id' => $this->input->post('category_id', TRUE),
                'repair_type_id' => $this->input->post('repair_type_id', TRUE),
                'parts_for' => $this->input->post('parts_for', TRUE),
                'specialism_id' => $this->input->post('specialism_id', TRUE),
                'service_type' => $this->input->post('service_type', TRUE),
            );
            $data = $data + $automech;
        } else if( $post_type == 'Towing' ) {
            $towing = array(
                'towing_service_id' => $this->input->post('towing_service_id', TRUE),
                'towing_type_of_service_id' => $this->input->post('towing_type_of_service_id', TRUE),
                'availability' => $this->input->post('availability', TRUE),
                'vehicle_type' => $this->input->post('vehicle_type', TRUE),
            );
            $data = $data + $towing;
        }


		// only Car, van, Auction car, import car
        elseif ($vehicle_id != 3 && $vehicle_id != 4) {
            $features = $this->input->post('feature_ids');

            if($features && count($features) > 0){
                $feature_ids['feature_ids'] = implode(',', $features);
                $data = $data + $feature_ids;
            }

            $tags = $this->input->post('tag_id');
            if($tags && count($tags)){
                $tag_ids['tag_id'] = implode(',', $tags);
                $data = $data + $tag_ids;
            }
        }



        $data = $data + $price;

//        echo '<pre>';
//        print_r($data);
//        die;

        $this->db->select('user_id, status');
        $this->db->where('id',  $this->input->post('id', TRUE));
        $post_user = $this->db->get('posts')->row();

        $roleID = getLoginUserData('role_id');
        $userID = getLoginUserData('user_id');
        if($roleID == 4 || $roleID == 5) {
            if($userID == $post_user->user_id){
                $status = 'Pending';
            }
        } else {
            $status = $post_user->status;
        }

        $data['status'] = $status;

        $this->Posts_model->update($this->input->post('id', TRUE), $data);


        $continue   = $this->input->post('update_continue');

        if($continue){

            redirect(site_url(Backend_URL . 'posts/update_photo/' . $this->input->post('id')));
        } else {
            redirect(site_url(Backend_URL . 'posts/update_post_detail/' . $this->input->post('id')));
        }

    }

    private function duplicateURLremove( $slug = null, $post_id = 0 ){

        $this->db->select('id');
        $this->db->from('posts');
        $this->db->where('post_slug', $slug);
        $this->db->where('id !=', $post_id);
        $num_results = $this->db->count_all_results();

        if($num_results){
            $slug  = $slug . rand(1000, 9999);
            $this->duplicateURLremove($slug,$post_id);
        }
        return $slug;
    }

    // ============== XXXXXXX ===============
    // ============== For Step 2 ===============
    public function update_photo($id) {
        $role_id = getLoginUserData('role_id');

        if ($role_id == 1 or $role_id == 2) {
            $this->viewAdminContent('posts/update_photo');
        } else {
            $photo = $this->db->where('post_id', $id)->where('left_photo !=', null)->where('right_photo !=', null)->where('back_photo !=', null)->where('size', 875)->get('post_photos')->row();
            $photos = $this->db->where('post_id', $id)->where('left_photo', null)->where('right_photo', null)->where('back_photo', null)->where('size', 875)->get('post_photos')->result();

            $data = array(
              'photos' => $photos,
              'photo' => $photo,
            );

            $this->viewNewAdminContent('posts/trader_update_photo', $data);
        }

//        $this->viewAdminContent('posts/update_photo');
    }

    // Incompelte
    public function delete($id) {
        $row = $this->Posts_model->get_by_id($id);

        if ($row) {
            $this->Posts_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('posts'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'posts'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('user_id', 'user id', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function sidebarMenus() {
        return buildMenuForMoudle([
            'module' => 'Post Advert',
            'icon' => 'fa-file-o',
            'href' => 'posts',
            'children' => [
                    [
                    'title' => 'All Adverts',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'posts'
                ],[
                    'title' => 'Add Car',
                    'icon' => 'fa fa-car',
                    'href' => 'posts/create?post_type=Car'
                ],[
                    'title' => 'Add Motorbike',
                    'icon' => 'fa fa-motorcycle',
                    'href' => 'posts/create?post_type=Motorbike'
                ],[
                    'title' => 'Add Parts',
                    'icon' => 'fa fa-wrench',
                    'href' => 'posts/create?post_type=Parts'
                ],[
                    'title' => 'Add Import Car',
                    'icon' => 'fa fa-car',
                    'href' => 'posts/create?post_type=Import-car'
                ],[
                    'title' => 'Motor association',
                    'icon' => 'fa fa-users',
                    'href' => 'posts/motor_asscocation'
                ],[
                    'title' => 'Post Settings',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'posts/settings'
                ],
                [
                    'title' => 'Listing Bill',
                    'icon' => 'fa fa-list',
                    'href' => 'posts/bill'
                ],
                [
                    'title' => 'Product Tags',
                    'icon' => 'fa fa-list',
                    'href' => 'posts/tags'
                ],
            ]
        ]);
    }

    public function newSidebarMenus() {
        return buildNewMenuForMoudle([
            'module' => 'Post Advert',
            'img' => 'assets/theme/new/images/backend/sidebar/post.svg',
            'hover' => 'assets/theme/new/images/backend/sidebar/post-h.svg',
            'href' => 'posts',
            'id' => 'postAdvert',
            'children' => [
                [
                    'title' => 'All Adverts',
                    'img' => 'assets/theme/new/images/backend/sidebar/adverts-a.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/adverts-h.svg',
                    'href' => 'posts'
                ],[
                    'title' => 'Add Car',
                    'img' => 'assets/theme/new/images/backend/sidebar/car.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/car-h.svg',
                    'href' => 'posts/create?post_type=Car'
                ],[
                    'title' => 'Add Van',
                    'img' => 'assets/theme/new/images/backend/sidebar/van.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/van-h.svg',
                    'href' => 'posts/create?post_type=Van'
                ],[
                    'title' => 'Add Motorbike',
                    'img' => 'assets/theme/new/images/backend/sidebar/motorbike.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/motorbike-h.svg',
                    'href' => 'posts/create?post_type=Motorbike'
                ],[
                    'title' => 'Add Parts',
                    'img' => 'assets/theme/new/images/backend/sidebar/parts.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/parts-h.svg',
                    'href' => 'posts/create?post_type=Parts'
                ],[
                    'title' => 'Add Import Car',
                    'img' => 'assets/theme/new/images/backend/sidebar/car2.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/car2-h.svg',
                    'href' => 'posts/create?post_type=Import-car'
                ],[
                    'title' => 'Add Auction Car',
                    'img' => 'assets/theme/new/images/backend/sidebar/car.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/car-h.svg',
                    'href' => 'posts/create?post_type=Auction-car'
                ],[
                    'title' => 'Add Towing Vehicle Listing',
                    'img' => 'assets/theme/new/images/backend/sidebar/van2.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/van2-h.svg',
                    'href' => 'posts/create?post_type=Towing'
                ],[
                    'title' => 'Add Auto Mechanic Listing',
                    'img' => 'assets/theme/new/images/backend/sidebar/van.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/van-h.svg',
                    'href' => 'posts/create?post_type=Automech'
                ],[
                    'title' => 'Motor association',
                    'img' => 'assets/theme/new/images/backend/sidebar/users.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/users-h.svg',
                    'href' => 'posts/motor_asscocation'
                ],[
                    'title' => 'Post Settings',
                    'img' => 'assets/theme/new/images/backend/sidebar/bill.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/bill-h.svg',
                    'href' => 'posts/settings'
                ],
                [
                    'title' => 'Listing Bill',
                    'img' => 'assets/theme/new/images/backend/sidebar/bill.svg',
                    'hover' => 'assets/theme/new/images/backend/sidebar/bill-h.svg',
                    'href' => 'posts/bill'
                ],
            ]
        ]);
    }

    function getChart() {
        $day = [];
        for ($i = -30; $i <= 0; $i++) {
            $day[] = date('d M y', strtotime("+$i days "));
        }
        return json_encode($day);
    }

    function getChartExpiry() {
        $data = [];
        for ($i = -30; $i <= 0; $i++) {

            $day = date('Y-m-d', strtotime("+$i days "));
            $data[] = $this->db->select('id')->get_where('posts', ['expiry_date' => $day])->num_rows();
        }
        return json_encode($data);
    }

    function getChartPost() {
        $data = [];
        for ($i = -30; $i <= 0; $i++) {

            $day = date('Y-m-d', strtotime("+$i days "));
            $data[] = $this->db->select('id')->get_where('posts', ['created' => $day])->num_rows();
        }
        return json_encode($data);
    }

    // uploads\car
    public function upload_service_photo() {
        ajaxAuthorized();

        $post_id = $this->input->post('post_id');
        $service_id = $post_id;
        $file   = $_FILES['file'];
        $rotate   = $this->input->post('rotate');



        if ( empty($_FILES['file']['name']) ) {
            echo ajaxRespond('Fail','<p class="ajax_error"> Please Select Photo Before Upload </p>');
            exit;
        }

        $rand = rand(0000, 9999);
        $photo_name     = $post_id . '_photo_' . $rand;

        $handle = new  \Verot\Upload\Upload($file);



        $photo_data     = [];
        $photo_data[]   = cropImageToThisSize($handle, $post_id,  75,  65, $photo_name, $rotate );
        $photo_data[]   = cropImageToThisSize($handle, $post_id, 280, 180, $photo_name, $rotate );
        $photo_data[]   = cropImageToThisSize($handle, $post_id, 285, 235, $photo_name, $rotate );
        $photo_data[]   = cropImageToThisSize($handle, $post_id, 875, 540, $photo_name, $rotate );

        $this->db->insert_batch('post_photos', $photo_data);
        $this->setDefaultFeatured( $post_id );



        $this->db->select('user_id, status');
        $this->db->where('id',  $post_id);
        $post_user = $this->db->get('posts')->row();

        $roleID = getLoginUserData('role_id');
        $userID = getLoginUserData('user_id');
        if($roleID == 4 || $roleID == 5) {
            if($userID == $post_user->user_id){
                $status = 'Pending';
            }
        } else {
            $status = $post_user->status;
        }


        $this->db->set('status', $status);
        $this->db->where('id', $post_id);
        $this->db->update('posts');

        echo ajaxRespond('OK', '');

//        echo $this->get_service_photo($post_id);
    }

//    // uploads\car
//    public function upload_service_photo() {
//
//        ajaxAuthorized();
//
//
//        $post_id        = $this->input->post('post_id');
//        $base           = $_POST['encoded'];
//
//        $rand           = rand(1000,9999);
//        $photo_name     = $post_id . '_photo_' . $rand;
//
//        //$handle         = new upload( $_FILES['file'] );
//
//        $base = str_replace('data:image/png;base64,', '', $base);
//        $base = str_replace(' ', '+', $base);
//        $base = base64_decode($base);
//        $file = 'uploads/temp/'. getLoginUserData('user_id') . '.png';
//        $success = file_put_contents($file, $base);
//
//        $handle = new upload($file);
//        //dd( $handle );
//
//        $photo_data     = [];
//        $photo_data[]   = cropImageToThisSize($handle, $post_id,  75,  65, $photo_name );
//        $photo_data[]   = cropImageToThisSize($handle, $post_id, 280, 180, $photo_name );
//        $photo_data[]   = cropImageToThisSize($handle, $post_id, 285, 235, $photo_name );
//        $photo_data[]   = cropImageToThisSize($handle, $post_id, 875, 540, $photo_name );
//
//        $this->db->insert_batch('post_photos', $photo_data);
//        $this->setDefaultFeatured( $post_id );
//
//        $remove_file = dirname(BASEPATH) . '/uploads/temp/' . getLoginUserData('user_id').'.png';
//
//        if (file_exists($remove_file)) { unlink($remove_file);  }
//
//
//
//         $this->db->select('user_id, status');
//        $this->db->where('id',  $post_id);
//        $post_user = $this->db->get('posts')->row();
//
//        $roleID = getLoginUserData('role_id');
//        $userID = getLoginUserData('user_id');
//        if($roleID == 4 || $roleID == 5) {
//            if($userID == $post_user->user_id){
//                $status = 'Pending';
//            }
//        } else {
//            $status = $post_user->status;
//        }
//
//
//        $this->db->set('status', $status);
//$this->db->where('id', $post_id);
//$this->db->update('posts');
//
//
//
//
//
//        echo $this->get_service_photo($post_id);
//    }

    private function setDefaultFeatured( $post_id ){
        $count = $this->db->get_where('post_photos', ['post_id' => $post_id ])->num_rows();
        if($count == 4 ){
            $this->db->set('featured', 'Yes')
                    ->where('post_id', $post_id)
                    ->where('size', 285)
                    ->update('post_photos');
        }
    }


    private function add_service_photo($post_id, $photo, $size) {

        $data = [
            'post_id' => $post_id,
            'photo' => $photo,
            'size' => $size,
            'featured' => 'No'
        ];
        $this->db->insert('post_photos', $data);





    }

    public function get_service_photo($post_id = 0) {
        //return $post_id;

        $photos = $this->db
                ->select('id,post_id,photo,featured')
                ->get_where('post_photos', ['post_id' => $post_id, 'size' => 285])
                ->result();
        $html = '<div class="clearfix">';
        $html .= '<ul class="thumbPhotos clearfix" id="car">';
        foreach ($photos as $photo) {
            $html .= '<li id="photo_' . $photo->id . '">';
            $html .= '<span class="btn btn-primary btn-xs markActive" onclick="markActive(' . $photo->id  .',\'' . $photo->photo . '\');">';


            $html .= ($photo->featured == 'Yes')
                            ? '&radic; Featured'
                            : '<i class="fa fa-check-square-o"></i>  Feature This';

            $html .= '</span>';
            $html .= $this->getPhoto($photo->photo);
            $html .= '<b class="btn btn-danger btn-xs deletePhoto" onclick="deletePhoto(' . $photo->id . ',\'' . $photo->photo . '\');">';
            $html .= '<i class="fa fa-trash-o"></i> Trash </b>';
            $html .= '</li>';
        }
        $html .= '</ul>';
        $html .= '</div>';
        return $html;

    }

    public function get_service_photo_reload($post_id = 0) {
//        $post_id = $this->input->get('post_id');
        echo $this->get_service_photo($post_id);
    }

    private function getPhoto($photo = '') {
        $filename = dirname(BASEPATH) . '/uploads/car/' . $photo;
        if ($photo && file_exists($filename)) {
            return '<img src="uploads/car/' . $photo . '" width="100%">';
        } else {
            return '<img src="uploads/no-thumb.jpg" width="100%">';
        }
    }

    public function delete_service_photo() {
        ajaxAuthorized();
        $id = $this->input->post('id');
        $photo = $this->input->post('photo');

        if (filter_var($photo, FILTER_VALIDATE_URL)){
            $this->db->where('photo', $photo);
        }else{
            $replace = !empty($this->input->post('replace')) ? $this->input->post('replace') : '_285.jpg';
            $img_75 = str_replace($replace, '_75.jpg', $photo);
            $img_280 = str_replace($replace, '_280.jpg', $photo);
            $img_285 = str_replace($replace, '_285.jpg', $photo);
            $img_875 = str_replace($replace, '_875.jpg', $photo);

            $file_75 = dirname(BASEPATH) . '/uploads/car/' . $img_75;
            $file_280 = dirname(BASEPATH) . '/uploads/car/' . $img_280;
            $file_285 = dirname(BASEPATH) . '/uploads/car/' . $img_285;
            $file_875 = dirname(BASEPATH) . '/uploads/car/' . $img_875;

            if ($img_75 && file_exists($file_75)) { unlink($file_75);  }
            if ($img_280 && file_exists($file_280)) { unlink($file_280);  }
            if ($img_285 && file_exists($file_285)) { unlink($file_285);  }
            if ($img_875 && file_exists($file_875)) { unlink($file_875);  }

            $photos = array($img_75,$img_280, $img_285, $img_875);
            $this->db->where_in('photo', $photos);
        }


        $this->db->delete('post_photos');



        //'status' => $status,


        echo ajaxRespond('OK', 'Photo Deleted Successfully');
    }

    public function mark_as_feature() {
        ajaxAuthorized();
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $post_id = $this->input->post('post_id');

        $img_75 = str_replace('_285', '_75', $name);
        $img_280 = str_replace('_285', '_280', $name);
        $img_285 = str_replace('_285', '_285', $name);
        $img_875 = str_replace('_285', '_875', $name);

        $this->db->update('post_photos', ['featured' => 'No'], ['post_id' => $post_id]);

        $this->db->where('post_id', $post_id);
        $this->db->where_in('photo', [ $img_75, $img_280, $img_285, $img_875]);
        $this->db->update('post_photos', ['featured' => 'Yes']);
        echo ajaxRespond('OK', 'Featured Set');
    }

    public function post_count($location) {
        $this->db->select('id');
        $this->db->from('posts');
        $this->db->where('location_id', $location);
        return $num_results = $this->db->count_all_results();
    }

    public function statusUpdate() {
        ajaxAuthorized();

        $status = $this->input->post('status', TRUE);


        $post_id = $this->input->post('post_id', TRUE);
        $date = globalDateFormat($this->setExpiryDate($post_id));
        $getStatus = GlobalHelper::getNewStatus($status);
        $temp = GlobalHelper::switchStatus($status);

        $this->db->set('status', $getStatus[1]);
        if ($status == 'Active') {
            $this->db->set('activation_date', date('Y-m-d'));
        }
        $this->db->where('id', $post_id);
        $this->db->update('posts');

        if ($status == 'Active') {
            $this->db->select('title, post_slug');
            $post = $this->db->where('id', $post_id)->get('posts')->row();
//            TODO::uncomment when get credential
//            if (!empty($post)){
//                $this->sendTwitterFeed($post->title, $post->post_slug);
//                $this->sendFacebookFeed($post->title, $post->post_slug);
//            }

        }

        echo json_encode(['status' =>$temp."<i class='fa fa-angle-down'>", 'expiry_date' => $date]);
    }

    private function getExpiryDate($post_id = 0) {
        $data = $this->db->select('expiry_date')->get_where('posts', ['id' => $post_id])->row();
        $result = isset($data->expiry_date) ? $data->expiry_date : false;
        //dd($result);
        return $result;
    }

    private function setExpiryDate($post_id = 0) {
        $getExpiryDate = $this->getExpiryDate($post_id);
        $setDate = date('Y-m-d', strtotime('+1 Month'));

        if ($getExpiryDate === false) {
            $this->db->set('expiry_date', $setDate);
            $this->db->where('id', $post_id);
            $this->db->update('posts');
            return $setDate;
        } else {
            return $getExpiryDate;
        }
    }

    public  function change_publish_date(){
        $date = $this->input->post('date');
        $post_id = $this->input->post('post_id');

        $this->db->set('expiry_date', date_format(date_create($date), 'Y-m-d'));
        $this->db->where('id', $post_id);
        $this->db->update('posts');
        echo ajaxRespond('OK', '<p class="ajax_success">Expire date changed successfully</p>');
    }

    public function make_position_add(){
        $post_id = $this->input->post('post_id');
        $featured_section = $this->input->post('featured_section');
        $featured_page = $this->input->post('featured_page');
        $featured_position = $this->input->post('featured_position');
        $brand_id = $this->input->post('brand_id');
        $model_id = $this->input->post('model_id');

        $this->db->where('activation_date IS NOT NULL');
        $this->db->where('expiry_date >=', date('Y-m-d'));
        $this->db->where('status', 'Active');
        $this->db->where('id !=', $post_id);
        if ($featured_section == 'Brand'){
            $this->db->where('brand_id', $brand_id);
        } elseif ($featured_section == 'Model'){
            $this->db->where('brand_id', $brand_id);
            $this->db->where('model_id', $model_id);
        }
        $exit = $this->db->get_where('posts', ['featured_section' => $featured_section, 'featured_page' => $featured_page, 'featured_position' => $featured_position])->row();
        if (!empty($exit)){
            echo ajaxRespond('OK', '<p class="ajax_error">Same Position AD Already Exist</p>');die();
        }
        $this->db->where('id',$post_id);
        $this->db->update('posts', ['featured_section' => $featured_section, 'featured_page' => $featured_page, 'featured_position' => $featured_position]);
        echo ajaxRespond('OK', '<p class="ajax_success">AD Placed</p>');die();
    }

    public function mark_featured( ) {
        ajaxAuthorized();

        $post_id = $this->input->post('post_id');

        $featured = $this->db->select('is_featured')->get_where('posts', ['id' => $post_id] )->row();

        if($featured->is_featured == 'Yes'){
            $new_featured = 'No';
            $ajax_return = '<i class="fa fa-ban"></i> Regular Listing';
        } else {
            $new_featured = 'Yes';
            $ajax_return = '<i class="fa fa-check-square-o"></i> Featured Listing';
        }

        $this->db->set('is_featured', $new_featured)->where('id', $post_id )->update('posts');
        echo ajaxRespond('OK', $ajax_return );
    }

    public function  bulk_action(){
        //dd($_POST);

        ajaxAuthorized();

        $post_ids = $this->input->post('post_id', TRUE);
        $action = $this->input->post('action', TRUE);

        if(is_null($post_ids) or count($post_ids) == 0 or empty($action) ){
            $message = '<p class="ajax_error">Please select at least one item and action.</p>';
            echo ajaxRespond('Fail', $message );
            exit;
        }


        $extended_date = $this->input->post('extended_date', TRUE);

        switch ( $action ){
            case  'Active':
            case  'Inactive':
            case  'Sold':
            case  'Pending':
                $this->updateStatus($action, $post_ids);
                $message = '<p class="ajax_success">Status Updated Successfully.</p>';
                break;
            case  'ActiveFor30D':
                $this->ActiveFor30D($post_ids);
                $message = '<p class="ajax_success">Listing Activation Successful.</p>';
                break;
            case 'Yes':
            case 'No':
                $this->updateFeatured($action, $post_ids);
                $message = '<p class="ajax_success">Post Featured Updated Successfully.</p>';
                break;
            case 'Delete':
                $this->deletePosts($post_ids);
                $message = '<p class="ajax_success">Marked Post Deleted Successfully</p>';
                break;
            case 'Extended':
                $this->updateExtendedDate($post_ids, $extended_date);
                $message = '<p class="ajax_success">Extended Date Update Successfully</p>';
                break;
        }
        echo ajaxRespond('OK', $message );

    }

    private function ActiveFor30D( $post_ids = []){
        foreach ($post_ids as $post_id ){
            $this->db->set('status', 'Active');
            $this->db->set('activation_date', date('Y-m-d') );
            $this->db->set('expiry_date', date('Y-m-d', strtotime('+30 days')) );
            $this->db->where('id', $post_id);
            $this->db->update('posts');

            Modules::run('mail/activation_notice',$post_id );

        }
    }

    private function updateStatus($status = 'Active', $post_ids = []){
        foreach ($post_ids as $post_id ){
            $this->db->set('status', $status);
            $this->db->where('id', $post_id);
            $this->db->update('posts');
        }
    }

    private function updateFeatured($status = 'No', $post_ids = []){
        foreach ($post_ids as $post_id ){
            $this->db->set('is_featured', $status);
            $this->db->where('id', $post_id);
            $this->db->update('posts');
        }
    }

    private function updateExtendedDate($post_ids = [], $extended_date=null){
        foreach ($post_ids as $post_id ){
            $this->db->set('expiry_date', $extended_date);
            $this->db->where('id', $post_id);
            $this->db->update('posts');
        }
    }

    private function deletePosts($post_ids = []){
        foreach ($post_ids as $post_id ){
            $this->removePhotoFileFromFolder($post_id);
            $this->removePhotoFileFromDB($post_id);
            $this->removePost($post_id);
        }
    }

    public function delete_bulks(){
        $this->deletePosts(json_decode($this->input->post('ids')));
        die(json_encode(['status' => true]));
    }

    private function removePhotoFileFromFolder($post_id){
        $photos = $this->db->get_where('post_photos', ['post_id' => $post_id])
                ->result();

        foreach ($photos as $photo) {
            $fileName   = $photo->photo;
            $filePath   = dirname(BASEPATH) . '/uploads/car/' . $fileName;
            if ($fileName && file_exists($filePath)) {
               @unlink($filePath);
            }
        }
    }

    private function removePhotoFileFromDB( $post_id = 0){
        $this->db->where('post_id', $post_id )->delete('post_photos');
    }
    private function removePost( $post_id = 0){
        $this->db->where('id', $post_id)->delete('posts');
    }

    // Motor association and a tab for Driver hire
    public function motor_asscocation(){
        redirect(site_url('motor-association'));
    }

    public function driver_hire(){
        redirect(site_url('driver-hire'));
    }

    public function api_index() {
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $user = $this->db->select('users.role_id, user_tokens.user_id')
                    ->join('users', 'users.id = user_tokens.user_id', 'LEFT')
                    ->where('user_tokens.token', $token)
                    ->get('user_tokens')
                    ->row();
        }

        if (empty($user)) {
            json_output_display(200, ['status' => 0, 'message' => 'Not Found']);
            die;
        }
        $user_id = ($user) ? $user->user_id : 0 ;

        is_token_match($user_id, $token);

        $manage_all_post = checkPermission('posts/manage_all', $user->role_id);
        $q = urldecode($this->input->get('q', TRUE));
        $page   = $this->input->get('page');
        $start = intval($this->input->get('start'));

        $range = urldecode($this->input->get('range', TRUE));
        $status = urldecode($this->input->get('status', TRUE));
        //  $role_id	= urldecode($this->input->get('role_id', TRUE));

        $fd = urldecode($this->input->get('fd', TRUE));
        $td = urldecode($this->input->get('td', TRUE));

        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'posts/?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'posts/?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'posts/';
            $config['first_url'] = Backend_URL . 'posts/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;

        $config['total_rows'] = $this->Posts_model->total_rows_byVender($q, $user_id);
        $posts = $this->Posts_model->get_limit_data_byVenderApi($config['per_page'], $start, $q, $user_id);

        // dd($this->db->last_query());


        $data = array(
            'status' => 1,
            'start' => $start,
            'next_page_url'  => next_page_url($page, $config['per_page'], $config['total_rows']),
            'total_rows' => $config['total_rows'],
            'result' => [
                'posts' => $posts,
                'access' => $manage_all_post
            ]
        );

        json_output(200, $data);
    }

    public function api_create_action() {


            $token = $this->input->server('HTTP_TOKEN');
            if ($token) {
                $user_id = $this->db->get_where('user_tokens', ['token' => $token])->row();
            }
            $user_id = ($user_id) ? $user_id->user_id : 0;

        is_token_match($user_id, $token);

        $posType = $this->input->post('post_type');
        if(  $posType == 'Automech' ) {
            $post_type = 'Automech';
        } else if($posType == 'Towing'){
           $post_type = 'Towing';
        } else {
            $post_type = 'General';
        }

        $data = array(
            'user_id'           => $user_id,
            'vehicle_type_id'   => $this->input->post('vehicle_type_id', TRUE),
            'location'          => $this->input->post('location', TRUE),
            'location_id'       => $this->input->post('location_id', TRUE),
            'lat'               => $this->input->post('lat', TRUE),
            'lng'               => $this->input->post('lng', TRUE),
            'package_id'        => $this->input->post('package_id', TRUE),
            'registration_date' => '0000-00-00',
            'advert_type'       => $this->input->post('advert_type', TRUE),
            'condition'         => $this->input->post('condition', TRUE),
            'post_slug'         => 'ad_'.time(),
            'post_type'         => $post_type,
            'created'           => date('Y-m-d H:i:s'),
            'modified'          => date('Y-m-d H:i:s'),
        );

        $this->Posts_model->insert($data);
        $insert_id = $this->db->insert_id();

        $package_data = array(
            'listing_id' => $insert_id,
            'user_id' => $user_id,
            'package_id' => $this->input->post('package_id', TRUE),
            'price' => getPackagePrice($this->input->post('package_id')),
            'payment_status' => 'Unpaid',
            'status' => 'Pending',
            'created' => date('Y-m-d h:i:s'),
        );

        $this->db->insert('listing_package', $package_data);

         Modules::run('mail/add_post_notice', $insert_id, $user_id );

         json_output(200, ['status' => 1, 'message' => 'Update Successfully', 'continue' => 'Yes', 'post_id' => $insert_id]);


    }

    public function api_update_general_data($id){

        $token = $this->input->server('HTTP_TOKEN');
            if ($token) {
                 $user = $this->db->select('users.role_id, user_tokens.user_id')
                   ->join('users', 'users.id = user_tokens.user_id', 'LEFT')
                   ->where('user_tokens.token' , $token)
                   ->get('user_tokens')->row();
            }

            $user_id = ($user) ? $user->user_id : 0;
            is_token_match($user_id, $token);

        $row = $this->Posts_model->get_by_id($id);

        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'posts/update_general_action'),
            'id' => $row->id,
            'user_id' => $row->user_id,
            'package_id' => $row->package_id,
            'vehicle_type_id' => $row->vehicle_type_id,
            'advert_type' => $row->advert_type,
            'condition' => $row->condition,
            'location_id' => $row->location_id,
            'listing_type' => $row->listing_type,
            'post_type' => $row->post_type,
            'location' => $row->location,
            'lat' => $row->lat,
            'lng' => $row->lng,
        );
        $response = [
            'status' => 1,
            'message' => '',
            'data' => $data
        ];
        json_output(200, $response);

    }

    public function api_update_general() {
        $token = $this->input->server('HTTP_TOKEN');
            if ($token) {
                 $user = $this->db->select('users.role_id, user_tokens.user_id')
                   ->join('users', 'users.id = user_tokens.user_id', 'LEFT')
                   ->where('user_tokens.token' , $token)
                   ->get('user_tokens')->row();
            }

            $user_id = ($user) ? $user->user_id : 0;
            is_token_match($user_id, $token);

        $this->db->select('user_id, status');
        $this->db->where('id',  $this->input->post('id', TRUE));
        $post_user = $this->db->get('posts')->row();

        $roleID = $user->role_id;
        $userID = $user->user_id;
        if($roleID == 4 || $roleID == 5) {
            if($userID == $post_user->user_id){
                $status = 'Pending';
            }
        } else {
            $status = $post_user->status;
        }

        $post_id = $this->input->post('id', TRUE);

        $data = array(
            'id' => $this->input->post('id', TRUE),
            'vehicle_type_id' => $this->input->post('vehicle_type_id', TRUE),
            'advert_type' => $this->input->post('advert_type', TRUE),
            'condition' => $this->input->post('condition', TRUE),
            'location_id' => $this->input->post('location_id', TRUE),
            'listing_type' => $this->input->post('listing_type', TRUE),
            'location' => $this->input->post('location', TRUE),
            'package_id' => $this->input->post('package_id', TRUE),
            'lat' => $this->input->post('lat', TRUE),
            'lng' => $this->input->post('lng', TRUE),
            'status' => $status,
            'modified' => date('Y-m-d H:i:s'),
        );

        $this->Posts_model->update($post_id, $data);


        $package_data = array(
            'listing_id' => $this->input->post('id', TRUE),
            'user_id' => getLoginUserData('user_id'),
            'package_id' => $this->input->post('package_id', TRUE),
            'price' => getPackagePrice($this->input->post('package_id')),
            'payment_status' => 'Unpaid',
        );

        $check_listing_package = $this->db->get_where('listing_package', ['listing_id' => $this->input->post('id')])->row();

        if ($check_listing_package) {
            $this->db->update('listing_package', $package_data, ['listing_id' => $this->input->post('id')]);
        } else {
            $this->db->insert('listing_package', $package_data);
        }
        json_output(200, ['status' => 1, 'message' => 'Update Successfully', 'continue' => 'Yes']);
    }

    public function api_update_post_photos($id = 0){
         $token = $this->input->server('HTTP_TOKEN');

            if ($token) {
                 $u = $this->db->select('user_id')
                   ->where('token' , $token)
                   ->get('user_tokens')
                   ->row();
            }
            $user_id = ($u) ? $u->user_id : 0 ;
            is_token_match($user_id, $token);

	$this->db->select('user_id, status, post_type ');
        $this->db->where('id',  $id );
        $post_user = $this->db->get('posts')->row();

        $this->api_upload_service_photo($id);

        echo json_output(200, ['status' => 1, 'message' => 'Update Successfully', 'continue' => 'Yes']);

    }

    public function api_get_post_detail($id = 0){
        $user_id = 0;
        $token = $this->input->server('HTTP_TOKEN');
            if ($token) {
                 $user = $this->db->select('users.role_id , user_tokens.user_id')
                   ->join('users', 'users.id = user_tokens.user_id', 'LEFT')
                   ->where('user_tokens.token' , $token)
                   ->get('user_tokens')
                   ->row();
                 $user_id = ($user) ? $user->user_id : 0 ;
            }

            is_token_match($user_id, $token);


            $row = $this->Posts_model->get_by_id($id);

        if( $row->post_type == 'Automech' ) {
           $vehicleID =  '0';
        } else if( $row->post_type == 'Towing' ) {
           $vehicleID =  '0';
        } else {
            $vehicleID =  $row->vehicle_type_id;
        }


        if ($row) {
            $data = array(
                'button'        => 'Update',
                'action'        => site_url(Backend_URL . 'posts/update_post_detail_action/' . $vehicleID ),
                'id'            => set_value('id', $row->id),
                'vehicle_type_id' => set_value('vehicle_type_id', $row->vehicle_type_id),
                'location_id'      => set_value('location', $row->location_id),
                'condition'      => set_value('location', $row->condition),
                'title'         => set_value('title', $row->title),
                'post_slug'     => set_value('post_slug', $row->post_slug),
                'description'   => set_value('description', $row->description),
                'towing_service_id'   => set_value('towing_service_id', $row->towing_service_id),
                'towing_type_of_service_id'   => set_value('towing_type_of_service_id', $row->towing_type_of_service_id),
                'availability'   => set_value('availability', $row->availability),
                'vehicle_type'   => set_value('vehicle_type', $row->vehicle_type),

                'pricein'       => set_value('pricein', $row->pricein),
                'priceindollar' => set_value('priceindollar', $row->priceindollar),
                'priceinnaira'  => set_value('priceinnaira', $row->priceinnaira),
                'price'         => ($row->pricein == 'USD')
                                        ? set_value('priceindollar', $row->priceindollar)
                                        : set_value('priceinnaira', $row->priceinnaira),


                'mileage'       => set_value('mileage', $row->mileage),
                'brand_id'      => set_value('brand_id', $row->brand_id),
                'model_id'      => set_value('model_id', $row->model_id),
                'car_age'       => set_value('car_age', $row->car_age),
                'alloywheels'   => set_value('alloywheels', $row->alloywheels),
                'fuel_id'       => set_value('fuel_id', $row->fuel_id),
                'enginesize_id' => set_value('enginesize_id', $row->enginesize_id),
                'gear_box_type' => set_value('gear_box_type', $row->gear_box_type),
                'seats'         => set_value('seats', $row->seats),
                'color'         => set_value('color', $row->color),
                'post_type'         => set_value('post_type', $row->post_type),
                'parts_description' => set_value('parts_description', $row->parts_description),
                'parts_for' => set_value('parts_for', $row->parts_for),
                'repair_type_id' => set_value('repair_type_id', $row->repair_type_id),
                'category_id' => set_value('category_id', $row->category_id),
                'specialism_id' => set_value('specialism_id', $row->specialism_id),
                'service_type' => set_value('service_type', $row->service_type),
                'body_type'         => set_value('body_type', $row->body_type),
                'registration_date' => set_value('registration_date', $row->registration_date),
                'manufacture_year'  => set_value('manufacture_year', $row->manufacture_year),
                'registration_no'   => set_value('registration_no', $row->registration_no),
                'features'          => $this->getFeaturesOptions(),
                'feature_ids'       => set_value('feature_ids', $row->feature_ids),
                'owners'            => set_value('owners', $row->owners),
                'service_history'   => set_value('service_history', $row->service_history),
                'modified'          => set_value('modified', $row->modified)
            );

        }

        $response = [
            'status' => 1,
            'details' => $data
        ];
        json_output(200, $response);

    }

    private function getFeaturesOptions(){
        $features = $this->db->get('special_features')->result();
        $return = [];
        foreach($features as $opt ){
            $return[$opt->id] = $opt->title;
        }
        return $return;
    }

    public function api_update_post_detail($vehicle_id  ) {

//        $_POST['TYPE_ID'] = $vehicle_id;
//        $post = json_encode($_POST) . "\r\n";
//        $file = APPPATH .'/logs/data.txt';
//        file_put_contents($file, $post, FILE_APPEND);

        $user_id = 0;
        $token = $this->input->server('HTTP_TOKEN');
        if ($token) {
            $user = $this->db->select('users.role_id, user_tokens.user_id')
               ->join('users', 'users.id = user_tokens.user_id', 'LEFT')
               ->where('user_tokens.token' , $token)
               ->get('user_tokens')
               ->row();
            $user_id = $user->user_id;
        }

        is_token_match($user_id, $token);

        $post_id = (int) $this->input->post('id', TRUE);

	$this->db->select('post_type');
        $this->db->where('id', $post_id  );
        $post_user = $this->db->get('posts')->row();

        $post_type  = $post_user->post_type;

        $regiday    = $this->input->post('regiday');
        $regimonth  = $this->input->post('regimonth');
        $regiyear   = $this->input->post('regiyear');


        $feature_ids = NULL;
        if(in_array($vehicle_id, [1,2,5,6])){
            $ids = $this->input->post('feature_ids');
            if($ids){
                $feature_ids  = implode(',', $ids );
            } else {
                $feature_ids  = null;
            }
        }

        $data = array(
            'title'         => $this->input->post('title', TRUE),
            'post_slug'     => $this->duplicateURLremove($this->input->post('post_slug', TRUE), $this->input->post('id', TRUE)),
            'description'   => $this->input->post('description', TRUE),
            'category_id'   => (int) $this->input->post('category_id'),
            'parts_for'     => $this->input->post('parts_for', TRUE),
            'mileage'       => $this->input->post('mileage', TRUE),
            'brand_id'      => $this->input->post('brand_id', TRUE),
            'model_id'      => $this->input->post('model_id', TRUE),
            'car_age'       => $this->input->post('car_age', TRUE),
            'alloywheels'   => $this->input->post('alloywheels', TRUE),
            'fuel_id'       => $this->input->post('fuel_id', TRUE),
            'enginesize_id' => $this->input->post('enginesize_id', TRUE),
            'gear_box_type' => $this->input->post('gear_box_type', TRUE),
            'seats'         => $this->input->post('seats', TRUE),
            'color'         => $this->input->post('color', TRUE),
            'body_type'     => $this->input->post('body_type', TRUE),
            'registration_date' => $regiyear . '-' . $regimonth . '-' . $regiday,
            'manufacture_year' => $this->input->post('manufacture_year', TRUE),
            'registration_no' => $this->input->post('registration_no', TRUE),
            'owners'        => $this->input->post('owners', TRUE),
            'feature_ids'   => $feature_ids,
            'service_history' => $this->input->post('service_history', TRUE),
            'modified'      => date('Y-m-d h:i:s'),
            'status'        => 'Pending',
        );

        // only Parts
        if ($vehicle_id == 4) {
            $data['parts_description']  = $this->input->post('parts_description', TRUE);
            $data['parts_for']          = $this->input->post('parts_for', TRUE);
            $data['repair_type_id']     = $this->input->post('repair_type_id', TRUE);
            $data['category_id']        = $this->input->post('category_id', TRUE);
        }

        if( $post_type == 'Automech' ) {
            $data['category_id']    = $this->input->post('category_id', TRUE);
            $data['repair_type_id'] = $this->input->post('repair_type_id', TRUE);
            $data['parts_for']      = $this->input->post('parts_for', TRUE);
            $data['specialism_id']  = $this->input->post('specialism_id', TRUE);
            $data['service_type']   = $this->input->post('service_type', TRUE);
        }

        if( $post_type == 'Towing' ) {
            $data['towing_service_id'] = $this->input->post('towing_service_id', TRUE);
            $data['towing_type_of_service_id'] = $this->input->post('towing_type_of_service_id', TRUE);
            $data['availability']   = $this->input->post('availability', TRUE);
            $data['vehicle_type']   = $this->input->post('vehicle_type', TRUE);
        }

        $pricein    = $this->input->post('pricein');
        $pricevalue = $this->input->post('price');

        if ($pricein == 'NGR') {
            $data['priceinnaira']   = $pricevalue;
        } else {
            $data['priceindollar']  = $pricevalue;
        }
        $data['pricein']        = $pricein;

        $this->Posts_model->update($post_id, $data);


        json_output(200, ['status' => 1, 'message' => 'Update Successfully', 'continue' => 'Yes']);
    }

    // Api  uploads\car
    public function api_upload_service_photo($post_id = 0) {
        // ajaxAuthorized();

        // $post_id = $this->input->post('post_id');
        //$service_id = $post_id;
        $file   = $_FILES['file'];
        $rotate   = $this->input->post('rotate');

        if ( empty($_FILES['file']['name']) ) {
            echo json_output(200, ['Status' => 0, 'message' => 'Please Select Photo Before Upload']);
            exit;
        }

        $rand = rand(0000, 9999);
        $photo_name     = $post_id . '_photo_' . $rand;
        $handle         = new upload($file);

        $photo_data     = [];
        $photo_data[]   = cropImageToThisSize($handle, $post_id,  75,  65, $photo_name, $rotate );
        $photo_data[]   = cropImageToThisSize($handle, $post_id, 280, 180, $photo_name, $rotate );
        $photo_data[]   = cropImageToThisSize($handle, $post_id, 285, 235, $photo_name, $rotate );
        $photo_data[]   = cropImageToThisSize($handle, $post_id, 875, 540, $photo_name, $rotate );

        $this->db->insert_batch('post_photos', $photo_data);
        $this->setDefaultFeatured( $post_id );


        $this->db->select('user_id, status');
        $this->db->where('id',  $post_id);
        $post_user = $this->db->get('posts')->row();

        $roleID = $this->role_id;
        $userID = $this->user_id;
        if($roleID == 4 || $roleID == 5) {
            if($userID == $post_user->user_id){
                $status = 'Pending';
            }
        } else {
            $status = $post_user->status;
        }

        $this->db->set('status', $status);
        $this->db->where('id', $post_id);
        $this->db->update('posts');

        echo json_output(200, ['status' => 1]);

    }

    public function api_get_service_photo($post_id = 0) {
        //return $post_id;
        // 'size' => 285
        $photos = $this->db
                ->select('id,post_id,photo,featured')
                ->get_where('post_photos', ['post_id' => $post_id, 'size' => 285 ])
                ->result();
       $featured = [];
       $data_img = [];
        foreach ($photos as $photo) {
            $featured[] = ($photo->featured == 'Yes')
                            ? ' Featured'
                            : 'Feature This';
            $data_img[]= base_url('uploads/car/'.$photo->photo);
        }

        if($data_img){
            echo json_output(200, ['status' => 1, 'message' => 'successfully uploaded', 'data_img' => $data_img, 'featured' => $featured]);
        } else {
            echo json_output(200, ['status' => 0, 'message' => 'No photo found', 'data_img' => $data_img, 'featured' => $featured]);
        }
    }

    public function api_delete_service_photo() {

        $id = $this->input->get('id');
        $photo_url = $this->input->get('photo'); // 'https://.com/uploads/test/d_285.jpg';

        $split_url = explode('/', $photo_url);
        $photo = end($split_url);

        $img_75 = str_replace('_285.jpg', '_75.jpg', $photo);
        $img_280 = str_replace('_285.jpg', '_280.jpg', $photo);
        $img_285 = str_replace('_285.jpg', '_285.jpg', $photo);
        $img_875 = str_replace('_285.jpg', '_875.jpg', $photo);

        $file_75 = dirname(BASEPATH) . '/uploads/car/' . $img_75;
        $file_280 = dirname(BASEPATH) . '/uploads/car/' . $img_280;
        $file_285 = dirname(BASEPATH) . '/uploads/car/' . $img_285;
        $file_875 = dirname(BASEPATH) . '/uploads/car/' . $img_875;

        if ($img_75 && file_exists($file_75)) { unlink($file_75);  }
        if ($img_280 && file_exists($file_280)) { unlink($file_280);  }
        if ($img_285 && file_exists($file_285)) { unlink($file_285);  }
        if ($img_875 && file_exists($file_875)) { unlink($file_875);  }

        $photos = array($img_75,$img_280, $img_285, $img_875);
        $this->db->where_in('photo', $photos);

        $del = $this->db->delete('post_photos');

        if($del){
        json_output(200, ['status' => 1, 'message' => 'Photo Deleted Successfully']);
        }else {
            json_output(200, ['status' => 0, 'message' => 'Photo Not Delete']);
        }

    }

    //

    public function create_post() {



        $post_id = !empty($this->input->post('id')) ? $this->input->post('id') : 0;
        $posType = $this->input->post('post_type');

        if(  $posType === 'Automech' ) {
            $post_type = 'Automech';
            $pricein = "NGR";
        } else if($posType ==='Towing'){
            $post_type = 'Towing';
            $pricein = "NGR";
        }else if($posType === 'import-car'){
            $post_type = 'import-car';
            $pricein = "NGR";
        }
        else {
            $post_type = 'General';
            $pricein = $this->input->post('pricein');
        }


        $pricevalue = $this->input->post('vehicle_amount',true);

        $vehicleId = $this->input->post('vehicle_type_id', TRUE);

        $postSlug = slugify($this->input->post('post_url', TRUE));
        $hasSlugCount = $this->db->where([
            'post_slug' => $postSlug])
            ->where('id !=',$post_id)
            ->from('posts')->get()->num_rows();
        $postSlug = empty($hasSlugCount) ? $postSlug : $postSlug.'-'.mt_rand(0000,9999);


        $data = array(
            'user_id'           => getLoginUserData('user_id'),
            'vehicle_type_id'   => $vehicleId,
            'location'          => $this->input->post('location', TRUE),
            'location_id'       => $this->input->post('location_id', TRUE),
            'country_id'        => $this->input->post('country_id', TRUE) ? : 0,
            'lat'               => $this->input->post('lat', TRUE),
            'lng'               => $this->input->post('lng', TRUE),
            'advert_type'       => $this->input->post('advert_type', TRUE),
            'condition'         => $this->input->post('condition', TRUE),

            'post_type'         => $post_type,
            'listing_type' => $this->input->post('listing_type', TRUE),

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
            'post_slug'         => $postSlug,
        );
//        pp($data);
        $customizeData = [];
        if (!empty($post_id)){
            $customizeData = [
                'modified'          => date('Y-m-d h:i:s'),
                'status' => "Pending",
            ];
        } else {
            $customizeData = [
                'package_id' => 0,                      // TODO::Need Dynamic Next $this->input->post('package_id', TRUE),
                'status' => "Pending",
                'created'           => date('Y-m-d h:i:s'),
                'modified'          => date('Y-m-d h:i:s'),
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
            $features = $this->input->post('features');
            $feature_ids = ($features) ? implode(',', $features) : null;

            $tags = $this->input->post('tags');
            $tag_ids = ($tags) ? implode(',', $tags) : null;

            $vehicle['mileage']         =  $this->input->post('mileage', TRUE);
            $vehicle['car_age']         =  $this->input->post('car_age', TRUE);
            $vehicle['alloywheels']     =  $this->input->post('alloywheels', TRUE);
            $vehicle['fuel_id']         =  $this->input->post('fuel_id', TRUE);
            $vehicle['enginesize_id']   =  $this->input->post('enginesize_id', TRUE);
            $vehicle['color']           =  $this->input->post('color', TRUE);
            $vehicle['registration_date'] =  $this->input->post('reg_date', TRUE);
            $vehicle['registration_no'] =  $this->input->post('registration_no', TRUE);
            $vehicle['feature_ids']     =  $feature_ids;
            $vehicle['tag_id']     =  $tag_ids;

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
        } else if( $post_type == 'Automech' ) {
            $automech = array(
                'category_id' => $this->input->post('category_id', TRUE),
                'repair_type_id' => $this->input->post('repair_type_id', TRUE),
                'parts_for' => $this->input->post('parts_for', TRUE),
                'specialism_id' => $this->input->post('specialism_id', TRUE),
                'service_type' => $this->input->post('service_type', TRUE),
            );
            $data = $data + $automech;
        } else if( $post_type == 'Towing' ) {
            $towing = array(
                'towing_service_id' => $this->input->post('towing_service_id', TRUE),
                'towing_type_of_service_id' => $this->input->post('towing_type_of_service_id', TRUE),
                'availability' => $this->input->post('availability', TRUE),
                'vehicle_type' => $this->input->post('vehicle_type', TRUE),
            );
            $data = $data + $towing;
        }

        // only Car, van, Auction car, import car
        else if ($vehicleId != 3 && $vehicleId != 4) {
            $features = $this->input->post('features');
            if($features && count($features)){
                $feature_ids['feature_ids'] = implode(',', $features);
                $data = $data + $feature_ids;
            }

            $tags = $this->input->post('tags');
            if($tags && count($tags)){
                $tag_ids['tag_id'] = implode(',', $tags);
                $data = $data + $tag_ids;
            }

        }

        $data = $data + $price;



        if (!empty($post_id)){
            //pp('in');
            $this->db->where('id', $post_id);
            $this->db->update('posts', $data);
//            $this->Posts_model->update($post_id,$data);
            $insert_id = $post_id;
        } else {
            //pp('out');
            $this->Posts_model->insert($data);
            $insert_id = $this->db->insert_id();
        }

        if (!empty($insert_id) && $posType === 'import-car'){
            $importCar['shipping_amount'] = !empty($this->input->post('shipping_amount'))  ? $this->input->post('shipping_amount') : 0;
            $importCar['ground_logistics_amount'] = !empty($this->input->post('ground_logistics_amount')) ? $this->input->post('ground_logistics_amount'):0;
            $importCar['customs_amount'] = !empty($this->input->post('customs_amount')) ? $this->input->post('customs_amount'): 0;
            $importCar['clearing_amount'] = !empty($this->input->post('clearing_amount')) ? $this->input->post('clearing_amount') : 0;
            $importCar['vat_amount'] = !empty($this->input->post('vat_amount')) ? $this->input->post('vat_amount'): 0;
            $importCar['is_third_party'] = $this->input->post('suggest_check') == 'on' ? 1 : 0;
            $otherCosts = DB::table('post_other_cost')->where(['post_id'=>$insert_id])->first();
            if (!empty($otherCosts)){
                DB::table('post_other_cost')->where(['post_id'=>$insert_id])->update($importCar);
            }else{
                $importCar['post_id'] = $insert_id;
                DB::table('post_other_cost')->insert($importCar);
            }
//            $this->db->createCommand()

        }

        $photo_data     = [];
        $size_list = [
            ['width' => 75, 'height' => 65],
            ['width' => 280, 'height' => 180],
            ['width' => 285, 'height' => 235],
            ['width' => 875, 'height' => 540],
        ];
        foreach ($_REQUEST['img'] as $key => $img){
            if (!empty($post_id) && isset($img['before_uploaded']) && !empty($img['before_uploaded'])){
                if (filter_var($img['name'], FILTER_VALIDATE_URL)) {
                    $this->db->where('photo', $img['name']);
                } else {
                    $img_75 = str_replace('_875.jpg', '_75.jpg', $img['name']);
                    $img_280 = str_replace('_875.jpg', '_280.jpg', $img['name']);
                    $img_285 = str_replace('_875.jpg', '_285.jpg', $img['name']);
                    $img_875 = str_replace('_875.jpg', '_875.jpg', $img['name']);
                    $this->db->where_in('photo', [$img_75, $img_280, $img_285, $img_875]);
                }

                $this->db->where('post_id', $post_id);
                $this->db->update('post_photos', ['featured' => isset($img['is_featured']) && !empty($img['is_featured']) ? 'Yes' : 'No']);
            } else {
                $splited = explode(',', substr( $img['path'] , 5 ) , 2);
                $mime = explode(';', explode('/', $splited[0])[1])[0];
                $mime = $mime == 'jpeg' ? 'jpg' : $mime;
                if (isset($splited[1]) && !empty($splited[1])) {
                    $rand = rand(00000, 99999);
                    $photoName = $insert_id . '_photo_' . $rand.'.'.$mime;
                    $stamp = imagecreatefrompng(dirname(BASEPATH) . '/assets/theme/new/images/whitetext-logo.png');
                    $im = imagecreatefromstring(base64_decode($splited[1]));

                    $sx = imagesx($stamp);
                    $sy = imagesy($stamp);

                    imagecopy($im, $stamp, (int) ((imagesx($im) - $sx)/2), (int) ((imagesy($im) - $sy)/2), 0, 0, imagesx($stamp), imagesy($stamp));
                    ob_start();
                    imagepng($im);
                    $contents =  ob_get_contents();
                    ob_end_clean();
                    imagedestroy($im);
                    $photo_data[$key]['photo'] = GlobalHelper::uploadImageToCloudfare($contents, $photoName, true);
                    $photo_data[$key]['post_id'] = $insert_id;
                    $photo_data[$key]['size'] = 0;
                    $photo_data[$key]['featured'] = isset($img['is_featured']) && !empty($img['is_featured']) ? 'Yes' : 'No';
                }
            }

        }

        //pp($photo_data);
        if (!empty($photo_data)){
            $this->db->insert_batch('post_photos', $photo_data);
            $this->setDefaultFeaturedPost($insert_id);
        }
//        if (isset($_FILES['fileselect']['name']) && is_array($_FILES['fileselect']['name'])) {
//            $file_ary = $this->reArrayFiles($_FILES['fileselect']);
//
//            foreach ($file_ary as $image) {
//                $this->upload_service($image, $insert_id, 'No');
//            }
//        }

//        $package_data = array(
//            'listing_id' => $insert_id,
//            'user_id' => getLoginUserData('user_id'),
//            'package_id' => $this->input->post('package_id', TRUE),
//            'price' => getPackagePrice($this->input->post('package_id')),
//            'payment_status' => 'Unpaid',
//            'status' => 'Pending',
//            'created' => date('Y-m-d h:i:s'),
//        );
//
//        $this->db->insert('listing_package', $package_data);

        //$this->session->set_flashdata(['status' => 'success', 'message' => 'Post added Successfully.']);
        if (empty($post_id)){
            Modules::run('mail/add_post_notice',$insert_id );
        }

//        redirect(site_url(Backend_URL . 'posts/create?post_type='.$vehicleName));
        echo json_encode(['post_id' => $insert_id]);die();
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

    public function upload_service($file, $post_id, $featured) {
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

    private function setDefaultFeaturedPost( $post_id ){
        $count = $this->db->get_where('post_photos', ['post_id' => $post_id ])->num_rows();
        if($count == 4 ){
            $this->db->set('featured', 'Yes')
                ->where('post_id', $post_id)
                ->where('size', 285)
                ->update('post_photos');
        }
    }

    private function _facebook_share(){

    }

    private function sendTwitterFeed($title, $post_url)
    {
        $CONSUMER_KEY = TW_CONSUMER_KEY;
        $CONSUMER_SECRET = TW_CONSUMER_SECRET;
        $access_token = TW_Access_Token;
        $access_token_secret = TW_Access_Token_Secret;

        $connection = new Abraham\TwitterOAuth\TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $access_token, $access_token_secret);
        $content = $connection->get("account/verify_credentials");

        $statues = $connection->post("statuses/update", ["status" => $title.' '.site_url('post/'.$post_url)]);

        if ($connection->getLastHttpCode() == 200) {
            return true;
        } else {
            return false;
        }
    }

    private function sendFacebookFeed($title, $post_url)
    {
        $fb = new Facebook\Facebook([
            'app_id' => FB_App_ID,
            'app_secret' => FB_App_Secret,
            'default_graph_version' => FB_App_Version
        ]);

        $linkData = [
            'link' => site_url('post/'.$post_url),
            'message' => $title,
        ];

        try {
            // Returns a `Facebook\FacebookResponse` object

            $response = $fb->post('/me/feed', $linkData, $_SESSION['fb_access_token']);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // echo 'Graph returned an error: ' . $e->getMessage();
            // exit;
            // print_r($e->getMessage());
            return false;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // echo 'Facebook SDK returned an error: ' . $e->getMessage();
            // exit;
            // print_r($e->getMessage());
            return false;
        }

        // $graphNode = $response->getGraphNode();

        // return $graphNode['id'];

        return true;
    }

   public function get_car_valuation(){
        $vehicle_type_id = $this->input->post('vehicle_type_id');
        $condition = $this->input->post('condition');
        $brand_id = $this->input->post('brand_id');
        $model_id = $this->input->post('model_id');
        echo GlobalHelper::get_car_valuation($vehicle_type_id, $condition, $brand_id, $model_id);die();
   }

    public function changeStatus()
    {   $postId = array();
        $postId = $this->input->post('post_id');
        if (!empty($postId)){
            $markAs = $this->input->post('mark_as');
            if ($markAs === 'Sold'){
               $check =  DB::table('posts')
                    ->whereIn('id',$postId)
                    ->where('status','!=','Pending')
                    ->update(['status'=>$markAs,'sold_date'=>\Carbon\Carbon::now()]);
            }else if($markAs ==='Active'){
                $check =  DB::table('posts')
                    ->whereIn('id',$postId)
                    ->where('status','!=','Pending')
                    ->where('expiry_date','!=',NULL)
                    ->whereDate('expiry_date','>',date('Y-m-d'))
                    ->update(['status'=>'Active','sold_date'=>NULL]);
            }else{
                $check =  DB::table('posts')
                    ->whereIn('id',$postId)
                    ->where('status','!=','Pending')
                    ->update(['status'=>$markAs,'sold_date'=>NULL]);
            }
//            pp($check);
            if ($this->input->is_ajax_request()){
                if ($check){
                    echo json_encode(['msg'=>'ok']);
                    die();
                }else{
                    echo json_encode(['msg'=>'error']);
                    die();
                }
            }else{
                redirect(site_url(Backend_URL . 'posts' ));
            }

        }else{
            if ($this->input->is_ajax_request()){
                echo json_encode(['msg'=>'ok']);
                die();
            }else{
                redirect(site_url(Backend_URL . 'posts' ));
            }

        }
    }

    public function repostAdvert($id)
    {

        if (!empty($id)){
            $data = DB::table('posts')
                ->where(['id'=>$id])
                ->update([
                    'status'=>'Pending',
                    'activation_date'=>NULL,
                    'featured_section' => NULL,
                    'featured_position' => 0,
                    'featured_page' => 0,
                    'created'=>\Carbon\Carbon::now()
                ]);
            if ($data){
                $this->session->set_flashdata(['status'=>'success','message' =>'Repost advert successful']);
            }else{
                $this->session->set_flashdata(['status'=>'success','message' =>'Repost advert successful']);
            }
            redirect(site_url(Backend_URL . 'posts' ));
        }else{
            $this->session->set_flashdata(['status' =>'error','message' =>'Record Not Found']);
            redirect(site_url(Backend_URL . 'posts' ));
        }
    }

    public function buyPostPackage(){
        $this->db->where('id', $this->input->post('post_id'));
        $update = $this->db->update('posts', ['package_id' => $this->input->post('packageId'),'advert_type'=>'Paid']);
        if ($update){
            echo json_encode(['status' => true]);die();
        }else{
            echo json_encode(['status' => false]);die();
        }

    }

    public function tradePostUpdate($post_id){

        $baseURL = base_url();
        $row = $this->db->get_where('posts', ['id' => $post_id])->row();
        $this->db->select("IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', post_photos.photo, CONCAT('$baseURL', 'uploads/car/', post_photos.photo)) as path, photo as name, IF(featured = 'Yes', 1 , 0) as is_featured, '1' as before_uploaded");
        $post_photo = $this->db->where_in('size', [0,875])->get_where('post_photos', ['post_id' => $post_id])->result_array();

        if ($row) {
            $data = array(
                'button'        => 'Update',
                'action'        => site_url(Backend_URL . 'posts/create_post' ),
                'id'            => set_value('id', $row->id),
                'vehicle_type_id' => set_value('vehicle_type_id', $row->vehicle_type_id),
                'location_id'      => set_value('location', $row->location_id),
                'country_id'      => set_value('location', $row->country_id),
                'condition'      => set_value('location', $row->condition),
                'title'         => set_value('title', $row->title),
                'post_slug'         => set_value('post_slug', $row->post_slug),
                'description'   => set_value('description', $row->description),
                'towing_service_id'   => set_value('towing_service_id', $row->towing_service_id),
                'towing_type_of_service_id'   => set_value('towing_type_of_service_id', $row->towing_type_of_service_id),
                'availability'   => set_value('availability', $row->availability),
                'vehicle_type'   => set_value('vehicle_type', $row->vehicle_type),
                'listing_type'   => set_value('listing_type', $row->listing_type),

                'pricein'       => set_value('pricein', $row->pricein),
                'priceindollar' => set_value('priceindollar', $row->priceindollar),
                'priceinnaira'  => set_value('priceinnaira', $row->priceinnaira),
                'vehicle_amount'         => ($row->pricein == 'USD')
                    ? set_value('priceindollar', $row->priceindollar)
                    : set_value('priceinnaira', $row->priceinnaira),


                'mileage'       => set_value('mileage', $row->mileage),
                'brand_id'      => set_value('brand_id', $row->brand_id),
                'model_id'      => set_value('model_id', $row->model_id),
                'car_age'       => set_value('car_age', $row->car_age),
                'alloywheels'   => set_value('alloywheels', $row->alloywheels),
                'fuel_id'       => set_value('fuel_id', $row->fuel_id),
                'enginesize_id' => set_value('enginesize_id', $row->enginesize_id),
                'gear_box_type' => set_value('gear_box_type', $row->gear_box_type),
                'seats'         => set_value('seats', $row->seats),
                'color'         => set_value('color', $row->color),
                'post_type'         => set_value('post_type', $row->post_type),
                'parts_description' => set_value('parts_description', $row->parts_description),
                'parts_id' => set_value('parts_id', $row->parts_id),
                'parts_for' => set_value('parts_for', $row->parts_for),
                'repair_type_id' => set_value('repair_type_id', $row->repair_type_id),
                'category_id' => set_value('category_id', $row->category_id),
                'specialism_id' => set_value('specialism_id', $row->specialism_id),
                'service_type' => set_value('service_type', $row->service_type),
                'body_type'         => set_value('body_type', $row->body_type),
                'reg_date' => set_value('registration_date', $row->registration_date),
                'manufacture_year'  => set_value('manufacture_year', $row->manufacture_year),
                'to_year'  => set_value('to_year', $row->to_year),
                'registration_no'   => set_value('registration_no', $row->registration_no),
                'feature_ids'       => set_value('feature_ids', $row->feature_ids),
                'features'          => explode(',', (string)$row->feature_ids),
                'tags'          => explode(',', (string)$row->tag_id),
                'owners'            => set_value('owners', $row->owners),
                'service_history'   => set_value('service_history', $row->service_history),
                'modified'          => set_value('modified', $row->modified),
                'address'          => set_value('address', $row->address),
                'location'          => set_value('location', $row->location),
                'post_url'          => set_value('post_slug', $row->post_slug),
                'package_id'          => set_value('package_id', $row->package_id),
                'img' => $post_photo
            );

            $role_id = getLoginUserData('role_id');
            if ($role_id == 1 or $role_id == 2) {
                $this->viewAdminContent('posts/update_post_detail', $data);
            } else {
                //pp(json_encode($data));
                if ($data['post_type'] === 'import-car'){
                    $postOtherCost = (array) DB::table('post_other_cost')->where(['post_id'=>$data['id']])->first();
                    $data = $data + $postOtherCost;
                    $this->viewAdminContentPrivate('backend/trade/template/update_import_car_post_form', ['data' => $data]);
                }else{
                    $this->viewAdminContentPrivate('backend/trade/template/update_post_form', ['data' => $data]);
                }

            }
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'posts'));
        }
    }

    public function delete_car_post(){

    }

    public function homepagePositionUpdate() {
        ajaxAuthorized();

        $position = $this->input->post('position', TRUE);
        $post_id = $this->input->post('post_id', TRUE);

        $this->db->set('position', null);
        $this->db->where('position', $position);
        $this->db->update('posts');

        $this->db->set('position', $position);
        $this->db->where('id', $post_id);
        $this->db->update('posts');

        echo json_encode(['position' => $position . "<i class='fa fa-angle-down'>"]);
    }
}
/*
 public function statusUpdate(){
        ajaxAuthorized();

        $status 	= $this->input->post('status', TRUE);
		$post_id 	= $this->input->post('post_id', TRUE);

		// $this is available is no need to use get_instance;
        // $CI = & get_instance();
        // $CI->load->database();

        // if($status == 'Active'){
            // $date = date('Y-m-d', strtotime('+1 month'));
            // $CI->db->set('expiry_date', $date);
        // }


        $this->db->set('status', $status);
        $this->db->where('id', $post_id);
        $this->db->update('posts');
		$date = globalDateFormat( $this->setExpiryDate($post_id) );

		echo json_encode(['status' => $status, 'expiry_date' => $date ]);

        // $row = $CI->db->query("SELECT expiry_date, status FROM posts WHERE id='$post_id'")->row();
        // sleep(1);

        // $json = [
            // 'expiry_date' =>$row->expiry_date,
            // 'status' => $row->status
                // ];

        //echo $row->expiry_date;

    }
*/
