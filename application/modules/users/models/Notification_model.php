<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Notification_model extends Fm_model{

    public $table = 'user_notifications';
    public $id = 'id';
    public $order = 'DESC';

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
    function total_rows( $type_id = 0 , $brand_id = 0 , $model_id = 0, $user_id = 0  ) {
    
        if($type_id){
            $this->db->where( 'type_id', $type_id );
        }
        if($brand_id){
            $this->db->where( 'brand_id', $brand_id );
        }
        if($model_id){
            $this->db->where( 'model_id', $model_id );
        }
        if($user_id){
            $this->db->where( 'user_id', $user_id );
        }
        
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $type_id = 0 , $brand_id = 0 , $model_id = 0, $user_id = 0   ) {
        $this->db->order_by($this->id, $this->order);
        
         if($type_id){
            $this->db->where( 'type_id', $type_id );
        }
        if($brand_id){
            $this->db->where( 'brand_id', $brand_id );
        }
        if($model_id){
            $this->db->where( 'model_id', $model_id );
        }
        if($user_id){
            $this->db->where( 'user_id', $user_id );
        }
        
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data){
        $this->db->insert($this->table, $data);
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

}