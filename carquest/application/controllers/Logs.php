<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {
    
    function index(){
        
        $file = APPPATH .'logs/data.txt';
        $data = file_get_contents( $file );
        //echo '<pre>';
        print_r($data);
        //echo '</pre>';
    }
    
    function callback(){
        
        $file = APPPATH .'logs/access_log.txt';
        $data = file_get_contents( $file );
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    
}
