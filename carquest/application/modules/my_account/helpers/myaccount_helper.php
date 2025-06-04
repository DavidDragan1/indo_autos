<?php

defined('BASEPATH') OR exit('No direct script access allowed');



function count_my_mails(){
    $CI  =& get_instance();
    $id  = getLoginUserData( 'user_id' );
    $count_mail = $CI->db->select('id')->get_where('mails', ['reciever_id' => $id])->num_rows();
    return $count_mail;
}

function total_send_mails(){
    $CI  =& get_instance();
    $id  = getLoginUserData( 'user_id' );
    $count_mail = $CI->db->select('id')->get_where('mails', ['sender_id' => $id])->num_rows();
    return $count_mail;
}

function unread_mails(){
    $CI  =& get_instance();
    $id  = getLoginUserData( 'user_id' );
    $count_mail = $CI->db->select('id')->get_where('mails', ['reciever_id' => $id, 'status' => 'Unread'])->num_rows();
    return $count_mail;
}