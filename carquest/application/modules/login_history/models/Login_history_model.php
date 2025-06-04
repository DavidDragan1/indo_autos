<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Login_history_model extends Fm_model{

    public $table = 'login_history';
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
    function total_rows($most_login = NULL, $browser = NULL , $device = NULL, $role_id  = 0 , $range = null, $fd = null, $td = null  ) {
       
        if($most_login == 'yes') {            
            $this->db->group_by('user_id');
        }
        if($browser) {           
            $this->db->where('browser', $browser );
        }
        if($device) {     
            $this->db->where('device', $device );
        }
        if($role_id) {           
            $this->db->where('role_id', $role_id );
        }  
        if($fd && $td){            
            $this->db->where("`login_time` BETWEEN '$fd' AND '$td'");
        }      
        if($range){
            if($range != 'Custom'){
                $this->db->where('login_time >=', $range);
            }            
        }
        
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $most_login = NULL, $browser = NULL , $device = NULL, $role_id  = 0, $range = null, $fd = null, $td = null  ) {
        
        
        if($most_login == 'yes') {
            $this->db->select('*, COUNT(user_id) as visit');
            $this->db->order_by('visit', 'DESC');
            $this->db->group_by('user_id');
        }
        if($browser) {           
            $this->db->where('browser', $browser );
        }
        if($device) {           
            $this->db->where('device', $device );
        }       
        if($role_id) {           
            $this->db->where('role_id', $role_id );
        } 
        if($fd && $td){            
            $this->db->where("`login_time` BETWEEN '$fd' AND '$td'");
        }      
        if($range){
            if($range != 'Custom'){
                $this->db->where('login_time >=', $range);
            }            
        }
        
	$this->db->order_by('id', 'DESC');
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