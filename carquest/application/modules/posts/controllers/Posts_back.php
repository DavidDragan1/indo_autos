<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-10-14
 */

class Posts extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Posts_model');
        $this->load->helper('posts');
        $this->load->library('form_validation');
        $this->load->library("pagination");
    }

    public function index() {

        $user_id = getLoginUserData('user_id');
        $role_id = getLoginUserData('role_id');

        $manage_all_post = checkPermission('posts/manage_all', $role_id);

        //$manage_all_post = 0; //checkPermission('manage_all_posts', $role_id);


        //var_dump($user_id);



        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
       $range	 	= urldecode($this->input->get('range', TRUE));
        $status	 	= urldecode($this->input->get('status', TRUE));
       //  $role_id	= urldecode($this->input->get('role_id', TRUE));
        
        $fd	= urldecode($this->input->get('fd', TRUE));
        $td	= urldecode($this->input->get('td', TRUE));

        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'posts/?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'posts/?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'posts/';
            $config['first_url'] = Backend_URL . 'posts/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;


        if ($manage_all_post == true) {                        
            $config['total_rows'] = $this->Posts_model->total_rows($q,$range , $status, $fd, $td );
            $posts = $this->Posts_model->get_limit_data($config['per_page'], $start, $q, $range , $status , $fd, $td );
        } else {                        
            $config['total_rows'] = $this->Posts_model->total_rows_byVender($q, $user_id);
            $posts = $this->Posts_model->get_limit_data_byVender($config['per_page'], $start, $q, $user_id);
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
        );
        
       // echo  $this->db->last_query();
        
        
        $this->viewAdminContent('posts/index', $data);
    }

    
    // ============== XXXXXXX ===============        
    public function create() {

        $data = array(
            'button'        => 'Create',
            'action'        => site_url(Backend_URL . 'posts/create_action'),           
        );
        $this->viewAdminContent('posts/create', $data);
    }

    public function create_action() {

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
            'post_slug'         => 'ad_'.time(),
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
            'location' => $row->location,
            'lat' => $row->lat,
            'lng' => $row->lng,
        );

		// $this->session->set_flashdata('message', '<p class="ajax_success">Post Saved</p>');
        $this->viewAdminContent('posts/update_general', $data);
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
            'modified' => date('Y-m-d h:i:s'),
        );
        
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
        
        
        
        
        if ($row) {
            $data = array(
                'button'        => 'Update',
                'action'        => site_url(Backend_URL . 'posts/update_post_detail_action/' . $row->vehicle_type_id),
                'id'            => set_value('id', $row->id),
                'vehicle_type_id' => set_value('vehicle_type_id', $row->vehicle_type_id),
                'location_id'      => set_value('location', $row->location_id),
                'condition'      => set_value('location', $row->condition),
                
                'title'         => set_value('title', $row->title),
                
                'post_slug'     => set_value('post_slug', $row->post_slug),
                
                
                'description'   => set_value('description', $row->description),
                
                
                
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
                'parts_description' => set_value('parts_description', $row->parts_description),
                'parts_for' => set_value('parts_for', $row->parts_for),
                'body_type'         => set_value('body_type', $row->body_type),
                'registration_date' => set_value('registration_date', $row->registration_date),
                'manufacture_year'  => set_value('manufacture_year', $row->manufacture_year),
                'registration_no'   => set_value('registration_no', $row->registration_no),                
                'feature_ids'       => set_value('feature_ids', $row->feature_ids),
                'owners'            => set_value('owners', $row->owners),
                'service_history'   => set_value('service_history', $row->service_history),
                'modified'          => set_value('modified', $row->modified)
            );
            $this->viewAdminContent('posts/update_post_detail', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'posts'));
        }
    }

    public function update_post_detail_action($vehicle_id) {

	$this->db->select('user_id, status');
        $this->db->where('id',  $this->input->post('id', TRUE) );
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
        );
           
        // only MotorBike 
        $vehicle = [];
        if ($vehicle_id == 2) {
            $feature_ids                = implode(',', $this->input->post('feature_ids'));
            
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
        else if ($vehicle_id == 4) {
            $parts = array(
                'parts_description' => $this->input->post('parts_description', TRUE),                
                'parts_for' => $this->input->post('parts_for', TRUE),                
            );  
            $data = $data + $parts;
        } 
        
		// only Car, van, Auction car, import car  
        elseif ($vehicle_id != 3 && $vehicle_id != 4) {            
            $features = $this->input->post('feature_ids');
            
            if(count($features)){
                $feature_ids['feature_ids'] = implode(',', $features); 
                $data = $data + $feature_ids;
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
            $slug  = $slug . 2;          
            $this->duplicateURLremove($slug,$post_id);
        }             
        return $slug;
    }

    // ============== XXXXXXX ===============    
    // ============== For Step 2 ===============    
    public function update_photo($id) {


        $this->viewAdminContent('posts/update_photo');
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
                ],
                    [
                    'title' => '+ Add Post',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'posts/create'
                ],
                    [
                    'title' => 'Post Settings',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'posts/settings'
                ],
                [
                    'title' => 'Listing Bill',
                    'icon' => 'fa fa-list',
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
        
        
        $post_id        = $this->input->post('post_id');      
        $base           = $_POST['encoded'];     
        
        $rand           = rand(1000,9999);        
        $photo_name     = $post_id . '_photo_' . $rand;
        
        //$handle         = new upload( $_FILES['file'] );
        
        
$base = str_replace('data:image/png;base64,', '', $base);
$base = str_replace(' ', '+', $base);
$base = base64_decode($base);
$file = 'uploads/temp/'. getLoginUserData('user_id') . '.png';
$success = file_put_contents($file, $base);




        $handle = new upload($file);
        //dd( $handle );
        
        $photo_data     = [];
        $photo_data[]   = cropImageToThisSize($handle, $post_id,  75,  65, $photo_name );
        $photo_data[]   = cropImageToThisSize($handle, $post_id, 280, 180, $photo_name );
        $photo_data[]   = cropImageToThisSize($handle, $post_id, 285, 235, $photo_name );
        $photo_data[]   = cropImageToThisSize($handle, $post_id, 875, 540, $photo_name );
                            
        $this->db->insert_batch('post_photos', $photo_data);
        $this->setDefaultFeatured( $post_id );
        
        $remove_file = dirname(BASEPATH) . '/uploads/temp/' . getLoginUserData('user_id').'.png';
        
        if (file_exists($remove_file)) { unlink($remove_file);  }
        
        
        
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
        
        
        
        
        
        echo $this->get_service_photo($post_id);
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
            $html .= '<span class="btn btn-primary btn-xs markActive" onclick="markActive(' . $photo->id . ');">';

           
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
        $post_id = $this->input->get('post_id');
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
        $this->db->delete('post_photos');

        
        
        //'status' => $status,
        

        echo ajaxRespond('OK', 'Photo Deleted Successfully');
    }

    public function mark_as_feature() {
        ajaxAuthorized();
        $id = $this->input->post('id');
        $post_id = $this->input->post('post_id');

        $this->db->update('post_photos', ['featured' => 'No'], ['post_id' => $post_id]);
        $this->db->update('post_photos', ['featured' => 'Yes'], ['id' => $id]);
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
        $getStatus = GlobalHelper::switchStatus($status);

        $this->db->set('status', $getStatus[1]);
        $this->db->where('id', $post_id);
        $this->db->update('posts');
        
        echo json_encode(['status' => $getStatus[0] . ' ' . $getStatus[1], 'expiry_date' => $date]);
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
        
        if(count($post_ids) == 0 or empty($action) ){
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
    
    private function updateExtendedDate($post_ids = [], $extended_date){
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
    
    private function removePhotoFileFromFolder($post_id){
        $photos = $this->db
                ->get_where('post_photos', ['post_id' => $post_id])
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
