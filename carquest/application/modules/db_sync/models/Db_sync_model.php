<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Db_sync_model extends Fm_model{

    public $table   = 'db_sync';
    public $id      = 'id';
    public $order   = 'DESC';

    function __construct(){
        parent::__construct();
    }

    // get all
    function get_all(){
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

           
    // insert data
    function insert($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
   

    // delete data
    function delete($id){
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}