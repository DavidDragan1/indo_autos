<?php defined('BASEPATH') OR exit('No direct script access allowed');


function isActive( $folder = 'inbox' ){
    $ci =& get_instance();  
    $auto = ($ci->uri->segment(3)) ? $ci->uri->segment(3) : 'inbox';                 
    echo ( $folder == $auto) ? ' class="active"' : '';
}

function whichFolder(){
    $ci =& get_instance();  
    return ($ci->uri->segment(3)) ? $ci->uri->segment(3) : 'Inbox';                     
}

function getAttachment( $mail_id = 0 ){
    echo $mail_id;
}

function getUserNameById($id= null){
    $CI         =& get_instance();
    $user_id    = intval($id);
    $user       = $CI->db->select('first_name,last_name')
                        ->get_where('users', ['id' => $user_id])
                        ->row();
    return ($user) 
		? $user->first_name.' '.$user->last_name
		: 'Unknown user';
}

function getUserEmailById($id= null){
    $CI =& get_instance();
    $user_id  = intval($id);
    $user = $CI->db->select('email')->from('users')->where('id',$id)->get()->row();
    
    return isset($user->email) ? $user->email : false;
}
function getUserIdByEmail($email= ''){
    $CI =& get_instance();
        if($user =$CI->db->select('id')->from('users')->where('email',$email)->get()->row()){
            return $id = $user->id;
        }else{
            return $id = 0;
        }

}
function get_all_attachments($id= null){
    $CI =& get_instance();
    $mail_id  = intval($id);
//    $file = $CI->db->select('filename')->from('mail_attachs')->where('mail_id ',$id)->get()->row();
    $file = $CI->db->select('*') ->get_where('mail_attachs', ['mail_id ' => $mail_id])->result();
    if(count($file)>0){
        return $file;
    }
    return $file = null;
}
function unread_mail(){
    $CI  =& get_instance();
    $id  = getLoginUserData( 'user_id' );
    return $CI->db->select('*') ->get_where('mails', ['reciever_id ' => $id, 'status' => 'Unread'])->num_rows();
}


function insert_into_attachs($data){
    $CI =& get_instance();
    $CI->db->insert('mail_attachs', $data);
    return $id = $CI->db->insert_id();
}


