<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/ask_expert']                  = 'ask_expert';
$route['admin/ask_expert/create']           = 'ask_expert/create';
$route['admin/ask_expert/update/(:num)']    = 'ask_expert/update/$1';
$route['admin/ask_expert/read/(:num)']      = 'ask_expert/read/$1';
$route['admin/ask_expert/create_action']    = 'ask_expert/create_action';
$route['admin/ask_expert/update_action']    = 'ask_expert/update_action';
$route['admin/ask_expert/delete/(:num)']    = 'ask_expert/delete/$1';
