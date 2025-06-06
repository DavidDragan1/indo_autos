<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Cms_model extends Fm_model
{

    public $table = 'cms';
    public $id = 'id';
    public $status = 'status';
    public $post_type = 'post_type';
    public $order = 'ASC';

    function __construct(){
        parent::__construct();
    }

    // get all
    function get_all(){
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id){
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        
        if(!empty($q)) {
            $this->db->like('id', $q);
            $this->db->or_like('user_id', $q);
            $this->db->or_like('parent_id', $q);
            $this->db->or_like('post_type', $q);
            $this->db->or_like('menu_name', $q);
            $this->db->or_like('post_title', $q);
            $this->db->or_like('post_url', $q);
            $this->db->or_like('content', $q);
            $this->db->or_like('seo_title', $q);
            $this->db->or_like('seo_keyword', $q);
            $this->db->or_like('seo_description', $q);
            $this->db->or_like('thumb', $q);
            $this->db->or_like('template', $q);
            $this->db->or_like('created', $q);
            $this->db->or_like('modified', $q);
            $this->db->or_like('status', $q);
            $this->db->or_like('page_order', $q);
        }
        $this->db->where('post_type', 'page');
	$this->db->from($this->table);
        
         return $this->db->count_all_results();
       // echo $this->db->last_query();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        
        $this->db->where('post_type', 'page');
        $this->db->order_by('page_order', 'ASC'); 
         if(!empty($q)) {
            $this->db->like('id', $q);
            $this->db->or_like('user_id', $q);
            $this->db->or_like('parent_id', $q);
            $this->db->or_like('post_type', $q);
            $this->db->or_like('menu_name', $q);
            $this->db->or_like('post_title', $q);
            $this->db->or_like('post_url', $q);
            $this->db->or_like('content', $q);
            $this->db->or_like('seo_title', $q);
            $this->db->or_like('seo_keyword', $q);
            $this->db->or_like('seo_description', $q);
            $this->db->or_like('thumb', $q);
            $this->db->or_like('template', $q);
            $this->db->or_like('created', $q);
            $this->db->or_like('modified', $q);
            $this->db->or_like('status', $q);
            $this->db->or_like('page_order', $q);

            $this->db->limit($limit, $start);           
             
         }
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data){
        $this->db->insert($this->table, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    // update data
    function update($id, $data){
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id){
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
            
    // get data with limit and search
    function get_data_for_post($limit, $start = 0, $q = NULL) {
        $this->db->where('post_type', 'post');
        $this->db->order_by("id", "DESC");
        if($q){
            $this->db->like('post_title', $q);
        }
        $this->db->limit($limit, $start);

        return $this->db->get($this->table)->result();
    }
    
    
    // get total rows in post
    function total_rows_post($q = NULL) {
       $this->db->where('post_type', 'post');
        if($q){
            $this->db->like('post_title', $q);
        }
	    $this->db->from($this->table);
        return $this->db->count_all_results();        
    }
    
    
    
    // for frontend view
    
    
        // get data with limit and search
    function get_data_frontend($limit, $start = 0, $q = NULL) {
        $this->db->where('post_type', 'post')->where('status', 'Publish'); 
        if($q!=NULL){
            $this->db->order_by($this->id, $this->order);      
            $this->db->like('post_title', $q);
            $this->db->limit($limit, $start);        
        }
       
        return $this->db->get($this->table)->result();
    }
    
    
    
    // get total rows in post
    function total_rows_frontend($q = NULL) {
       $this->db->where('post_type', 'post')->where('status', 'Publish'); 
	$this->db->like('post_title', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }
    

}