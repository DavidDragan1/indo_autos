<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends Fm_model{

    public $table   = 'gallery'; 
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

    // get data by id
    function get_by_id($id){
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($user_id  = NULL, $album_id  = NULL, $type  = NULL, $q = NULL) {
	if(($user_id)) {
            $this->db->where('user_id', $user_id);
        }
        if(($album_id)) {
            $this->db->where('album_id', $album_id);
        }
        if(($q)) {
            $this->db->like('title', $q);
        }
        $roleCheck = getLoginUserData('role_id');
        $userCheck = getLoginUserData('user_id');
        
        if($roleCheck == 4 || $roleCheck == 5 ){
            $this->db->where('user_id', $userCheck);
        }
        
        
        $this->db->where('type', $type);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $user_id = NULL, $album_id = NULL, $type = NULL, $q = NULL) {

        if(!empty($user_id)) {
            $this->db->where('user_id', $user_id);
        }

        if(!empty($album_id)) {
            $this->db->where('album_id', $album_id);
        }

        if(!empty($q)) {
            $this->db->like('title', $q);
        }
        
        $roleCheck = getLoginUserData('role_id');
        $userCheck = getLoginUserData('user_id');

        if($roleCheck != 1 && $roleCheck != 2 ){
            $this->db->where('user_id', $userCheck);
        }

        $this->db->where('type', $type);
        $this->db->order_by($this->id, $this->order);
	    $this->db->limit($limit, $start);

        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data){
        $this->db->insert($this->table, $data);
    }
    
    function insert_album($data){
        $this->db->insert('gallery_albums', $data);
    }

    // update data
    function update($id, $data){        
        $this->db->update($this->table, $data, [ $this->id => $id ]);
    }

    // delete data
    function delete($id){
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}