<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Posts_model extends Fm_model
{
    public $table = 'posts';
    public $id = 'id';
    public $post_slug = 'post_slug';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, 'ASC');
        return $this->db->get($this->table)->result();
    }

    // count all
    public function record_count()
    {
        return $this->db->count_all($this->table);
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get data by post slug
    function get_by_slug($url)
    {
        $this->db->where($this->post_slug, $url);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL,$range= NULL,$id = 0 ,$name= NULL,$status= NULL, $fd= NULL, $td= NULL)
    {
        $this->db->select('posts.*');
        if ($q) {
            $this->db->group_start();
            $this->db->like('posts.id', $q);
            $this->db->or_like('posts.title', $q);
            $this->db->or_like('posts.description', $q);
            $this->db->or_like('posts.location', $q);
            $this->db->or_like('posts.priceindollar', $q);
            $this->db->or_like('posts.priceinnaira', $q);
            $this->db->or_like('posts.advert_type', $q);
            $this->db->or_like('posts.mileage', $q);
            $this->db->or_like('posts.brand_id', $q);
            $this->db->or_like('posts.model_id', $q);
            $this->db->or_like('posts.car_age', $q);
            $this->db->or_like('posts.alloywheels', $q);
            $this->db->group_end();
        }
        if ($id){
            $this->db->where('posts.user_id', $id);
        }

        if($status){
            $this->db->where('posts.status', $status);
        }
        if (!empty($name)){
            $this->db->join('users','users.id = posts.user_id','INNER');
//            $this->db->join('cms','cms.user_id = users.id AND users.role_id = 4','INNER');
            $this->db->group_start();
            $this->db->like('users.first_name',$name);
            $this->db->or_like('users.last_name',$name);
//            $this->db->or_like('cms.post_title',$name);
            $this->db->group_end();
        }

        if ($range){
            if ($range == 'Custom'){
                if (!empty($fd) && !empty($td)){
                    $this->db->where('DATE(posts.created) >=', $fd);
                    $this->db->where('DATE(posts.created) <=', $td);
                }elseif (!empty($fd)){
                    $this->db->where('DATE(posts.created) >=',$fd);
                }else{
                    $this->db->where('DATE(posts.created) <=',$td);
                }
            }else{
                $this->db->where('DATE(posts.created) >=',$range);
            }
        }
        $this->db->group_by('posts.id');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL,$range = NULL,$id = 0,$name=NULL,$status=NULL , $fd=NULL, $td=NULL)
    {
        $this->db->select('posts.*');
        $this->db->order_by('posts.'.$this->id, $this->order);
        if ($q) {
            $this->db->group_start();
            $this->db->like('posts.id', $q);
            $this->db->or_like('posts.title', $q);
            $this->db->or_like('posts.description', $q);
            $this->db->or_like('posts.location', $q);
            $this->db->or_like('posts.priceindollar', $q);
            $this->db->or_like('posts.priceinnaira', $q);
            $this->db->or_like('posts.advert_type', $q);
            $this->db->or_like('posts.mileage', $q);
            $this->db->or_like('posts.brand_id', $q);
            $this->db->or_like('posts.model_id', $q);
            $this->db->or_like('posts.car_age', $q);
            $this->db->or_like('posts.alloywheels', $q);
            $this->db->group_end();
        }
        if ($id){
            $this->db->where('posts.user_id', $id);
        }

        if($status){
            $this->db->where('posts.status', $status);
        }
        if (!empty($name)){
            $this->db->join('users','users.id = posts.user_id','INNER');
//            $this->db->join('cms','cms.user_id = users.id AND users.role_id = 4','LEFT');
            $this->db->group_start();
            $this->db->like('users.first_name',$name);
            $this->db->or_like('users.last_name',$name);
//            $this->db->or_like('cms.post_title',$name);
            $this->db->group_end();
        }

        if ($range){
            if ($range == 'Custom'){
                if (!empty($fd) && !empty($td)){
                    $this->db->where('DATE(posts.created) >=', $fd);
                    $this->db->where('DATE(posts.created) <=', $td);
                }elseif (!empty($fd)){
                    $this->db->where('DATE(posts.created) >=',$fd);
                }else{
                    $this->db->where('DATE(posts.created) <=',$td);
                }
            }else{
                $this->db->where('DATE(posts.created) >=',$range);
            }
        }

        $this->db->group_by('posts.id');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    // get total rows
    function total_rows_byVender($q = NULL, $user_id = 0)
    {
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        if ($q) {
            $this->db->like('title', $q);
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    function total_rows_byVenderWithSorting($q = NULL, $user_id = 0,$sorting = ''){
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        if ($q) {
            $this->db->like('title', $q);
        }
        if ($sorting){
            $this->db->where('status', $sorting);
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    // get data with limit and search
    function get_limit_data_byVender($limit, $start = 0, $q = NULL, $user_id = 0)
    {
        $this->db->select('posts.*, post_photos.photo');
        $this->db->where('posts.user_id', $user_id);
        $this->db->order_by('posts.id', $this->order);
        if ($q) {
            $this->db->like('title', $q);
        }
        $this->db->join('post_photos', 'post_photos.post_id=posts.id', 'LEFT');
        $this->db->limit($limit, $start);
        $this->db->group_by('posts.id');
        return ($this->db->get($this->table)->result());
    }
    function get_limit_data_byVenderWithSorting($limit, $start = 0, $q = NULL, $user_id = 0,$sorting = ''){
        $this->db->select('posts.*, post_photos.photo');
        $this->db->where('posts.user_id', $user_id);
        $this->db->where('posts.status', $sorting);
        $this->db->order_by('posts.id', $this->order);
        if ($q) {
            $this->db->like('title', $q);
        }
        $this->db->join('post_photos', 'post_photos.post_id=posts.id', 'LEFT');
        $this->db->limit($limit, $start);
        $this->db->group_by('posts.id');
        return ($this->db->get($this->table)->result());
    }
    function get_limit_data_byVenderApi($limit, $start = 0, $q = NULL, $user_id = 0)
    {
        $baseUrl = base_url();
        $this->db->select('posts.*');
        $this->db->select("CASE WHEN post_photos.photo IS NULL or post_photos.photo = '' THEN null ELSE IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo)) END  as photo");
        $this->db->select("CASE WHEN post_photos.left_photo IS NULL or post_photos.left_photo = '' THEN null ELSE IF(post_photos.left_photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.left_photo, '/public', '/featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.left_photo)) END  as left_photo");
        $this->db->select("CASE WHEN post_photos.right_photo IS NULL or post_photos.right_photo = '' THEN null ELSE IF(post_photos.right_photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.right_photo, '/public', '/featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.right_photo)) END  as right_photo");
        $this->db->select("CASE WHEN post_photos.back_photo IS NULL or post_photos.back_photo = '' THEN null ELSE IF(post_photos.back_photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.back_photo, '/public', '/featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.back_photo)) END  as back_photo");
        $this->db->select("GROUP_CONCAT(IF(post_photos.photo REGEXP '^(https?://|www\\.)[\.A-Za-z0-9\-]+\\.[a-zA-Z]', REPLACE(post_photos.photo, '/public', '/Featured'), CONCAT('$baseUrl', 'uploads/car/', post_photos.photo))) as images");
        $this->db->select("brands.name as brand_name, models.name as model_name");
        $this->db->select("packages.title as package_name");
        $this->db->select('cms.post_url as seller_slug');
        if (!empty($user_id)) {
            $this->db->where('posts.user_id', $user_id);
        }
        // $this->db->where('post_photos.size', 285);
        $this->db->order_by('posts.id', $this->order);
        //$this->db->like('title', $q);
        $this->db->join('post_photos', 'post_photos.post_id=posts.id AND (post_photos.size=875 OR post_photos.size=0)', 'LEFT');
        $this->db->join('brands', 'brands.id=posts.brand_id AND and brands.type="Brand"', 'LEFT');
        $this->db->join('brands as models', 'models.id=posts.model_id AND and models.type="Model"', 'LEFT');
        $this->db->join('packages', 'packages.id=posts.package_id', 'LEFT');
        $this->db->join('cms', 'cms.user_id=posts.user_id AND cms.post_type="business"', 'LEFT');
        if (!empty($limit)){
            $this->db->limit($limit, $start);
        }
        $this->db->group_by('posts.id');

        return ($this->db->get($this->table)->result());
    }
}
