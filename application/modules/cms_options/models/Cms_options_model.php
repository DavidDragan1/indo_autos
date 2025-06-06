<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Cms_options_model extends Fm_model
{

    public $table = 'cms_options';
    public $id = 'id';
    public $type = 'type';
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
    
    // get data type only category
    function get_cats(){
        $this->db->where($this->type, 'category');
        return $this->db->get($this->table)->result();
    }
    
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('parent', $q);
	$this->db->or_like('type', $q);
	$this->db->or_like('name', $q);
	$this->db->or_like('url', $q);
	$this->db->or_like('template', $q);
	$this->db->or_like('description', $q);
	$this->db->or_like('thumb', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('parent', $q);
	$this->db->or_like('type', $q);
	$this->db->or_like('name', $q);
	$this->db->or_like('url', $q);
	$this->db->or_like('template', $q);
	$this->db->or_like('description', $q);
	$this->db->or_like('thumb', $q);
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