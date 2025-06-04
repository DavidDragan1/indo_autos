<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Newsletter_subscriber_model extends Fm_model
{

    public $table = 'newsletter_subscriber';
    public $id = 'id';
    protected $email = 'email';
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
    // get data by id
    function get_by_email($email){
        $this->db->where($this->email, $email);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
        $this->db->or_like('name', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('status', $q);
        $this->db->or_like('created', $q);
        $this->db->or_like('modified', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
        $this->db->or_like('name', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('status', $q);
        $this->db->or_like('created', $q);
        $this->db->or_like('modified', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function check( $email = ''){
        $row = $this->db->get_where($this->table, ['email' =>$email])->row();
        //dd($row->id);
        if($row->status=='Unsubscribe'){
            return $row->id;
        }else{
            return 'Subscribe';
        }
    }
    function isExists($email = ''){
        return $this->db->get_where($this->table, ['email' =>$email])->num_rows();
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
    // update data
    function update_by_email($email, $data){
        $this->db->where($this->email, $email);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id){
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}