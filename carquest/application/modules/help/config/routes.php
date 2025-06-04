<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/help']                  = 'help';
$route['admin/help/create']           = 'help/create';
$route['admin/help/update/(:num)']    = 'help/update/$1';
$route['admin/help/read/(:num)']      = 'help/read/$1';
$route['admin/help/create_action']    = 'help/create_action';
$route['admin/help/update_action']    = 'help/update_action';
$route['admin/help/delete/(:num)']    = 'help/delete/$1';
