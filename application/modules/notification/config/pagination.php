<?php  if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }

$config['page_query_string'] = TRUE;

$config['query_string_segment'] = 'start';
$config['num_links'] = 1;
$config['full_tag_open'] = '<ul class="pagination-wrap">';
$config['full_tag_close'] = '</ul>';

$config['first_link'] = false;
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';

$config['last_link'] = false;
$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';

$config['next_link'] = '<i class="fa fa-angle-right"></i>';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li><span class="active">';
$config['cur_tag_close'] = '</span></li>';

$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';