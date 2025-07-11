<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Files_model extends Fm_model {

    public $table   = 'price_guide';
    public $id      = 'id';
    public $order   = 'DESC';

    function __construct() {
        parent::__construct();
    }

    // get total rows
    function total_rows($q = NULL) {

        if ($q) {                        
            $this->db->or_like('title', $q);
            $this->db->or_like('attach', $q);
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        if ($q) {                        
            $this->db->or_like('title', $q);
            $this->db->or_like('attach', $q);
        }
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    
    
    
    // get all
    function get_all() {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }    
    
    function get_by_id($id) {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // update data
    function update($id, $data) {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
    // delete data
    function delete($id) {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
    
    function insert($data) {
        $this->db->insert($this->table, $data);
    }

}
