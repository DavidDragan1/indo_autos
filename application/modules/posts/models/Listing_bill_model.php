<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Listing_bill_model extends Fm_model
{

    public $table = 'listing_package';
    public $id = 'id';
    public $order = 'DESC';

    function __construct(){
        parent::__construct();
    }

    // get all
    function get_all( ){
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id){
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($user_id = 0) {
        
        if($user_id){
            $this->db->where('user_id', $user_id);
        }      

        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $user_id = 0,  $start = 0, $q = NULL) {
        
        if($user_id){
            $this->db->where('user_id', $user_id);
        }  
        
        $this->db->order_by($this->id, $this->order);        
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    
}