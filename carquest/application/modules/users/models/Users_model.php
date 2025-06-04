<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Users_model extends Fm_model
{

    public $table = 'users';
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
    function total_rows($q = NULL,$range = NULL,$status = NULL,$role = 0, $fd = NULL, $td = NULL) {
        $this->db->select('*');
        if(!empty($q)){
            $this->db->group_start();
            $this->db->like('id', $q);
            $this->db->or_like('role_id', $q);
            $this->db->or_like('title', $q);
            $this->db->or_like('first_name', $q);
            $this->db->or_like('last_name', $q);
            $this->db->or_like('email', $q);
            $this->db->or_like('password', $q);
            $this->db->or_like('contact', $q);
            $this->db->or_like('dob', $q);
            $this->db->or_like('add_line1', $q);
            $this->db->or_like('add_line2', $q);
            $this->db->or_like('city', $q);
            $this->db->or_like('state', $q);
            $this->db->or_like('postcode', $q);
            $this->db->or_like('country_id', $q);
            $this->db->or_like('created', $q);
            $this->db->or_like('last_access', $q);
            $this->db->or_like('profile_photo', $q);
            $this->db->or_like('status', $q);
            $this->db->group_end();
        }

        if($role != 0){

            $this->db->where('role_id', $role );
        }

        if($status){
            $this->db->where('status', $status);
        }
        if($range){
            if ($range == 'Custom'){
                if (!empty($fd) && !empty($td)){
                    $this->db->where('DATE(created) >=', $fd);
                    $this->db->where('DATE(created) <=', $td);
                }elseif (!empty($fd)){
                    $this->db->where('DATE(created) >=',$fd);
                }else{
                    $this->db->where('DATE(created) <=',$td);
                }
            }else{
                $this->db->where('DATE(created) >=',$range);
            }
        }
	    $this->db->from($this->table);
	    $this->db->group_by('users.id');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $range= NULL,$status = NULL,$role = 0, $fd = NULL, $td = NULL) {
        $this->db->order_by($this->id, $this->order);
        if(!empty($q)){
            $this->db->group_start();
            $this->db->like('id', $q);
            $this->db->or_like('role_id', $q);
            $this->db->or_like('title', $q);
            $this->db->or_like('first_name', $q);
            $this->db->or_like('last_name', $q);
            $this->db->or_like('email', $q);
            $this->db->or_like('password', $q);
            $this->db->or_like('contact', $q);
            $this->db->or_like('dob', $q);
            $this->db->or_like('add_line1', $q);
            $this->db->or_like('add_line2', $q);
            $this->db->or_like('city', $q);
            $this->db->or_like('state', $q);
            $this->db->or_like('postcode', $q);
            $this->db->or_like('country_id', $q);
            $this->db->or_like('created', $q);
            $this->db->or_like('last_access', $q);
            $this->db->or_like('profile_photo', $q);
            $this->db->or_like('status', $q);
            $this->db->group_end();
        }
        if($role != 0){
            $this->db->where('role_id', $role );
        }

        if($status){
            $this->db->where('status', $status);
        }
        if ($range){
            if ($range == 'Custom'){
                if (!empty($fd) && !empty($td)){
                    $this->db->where('DATE(created) >=', $fd);
                    $this->db->where('DATE(created) <=', $td);
                }elseif (!empty($fd)){
                    $this->db->where('DATE(created) >=',$fd);
                }else{
                    $this->db->where('DATE(created) <=',$td);
                }
            }else{
                $this->db->where('DATE(created) >=',$range);
            }
        }
        $this->db->group_by('users.id');
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
    
    
    // get user name by ID
    function get_name_by_id($id){
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

}