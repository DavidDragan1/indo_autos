<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Brands_model extends Fm_model
{

    public $table = 'brands';
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
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('parent_id', $q);
	$this->db->or_like('name', $q);
	$this->db->or_like('type', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('parent_id', $q);
	$this->db->or_like('name', $q);
	$this->db->or_like('type', $q);
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
    
    // get by Brand
    function get_all_brand($vehicle_type_id){
        $this->db->where('type', 'Brand')->order_by($this->id, 'ASC');
        //$this->db->where('type', 'Brand')->where_in('type_id', $vehicle_type_id)->order_by($this->id, 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    // get model name by brand
    function getModelByBrand($brand_id = NULL, $vehicle_type_id = NULL){
        $this->db->where('parent_id', $brand_id)->where('type_id', $vehicle_type_id)->where('type', 'Model')
                 ->order_by($this->id, 'ASC');
        return $this->db->get($this->table)->result();
    }
    
	
}