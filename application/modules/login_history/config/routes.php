<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/login_history']                  = 'login_history';
$route['admin/login_history/graph_view']       = 'login_history/graph_view';
/* $route['admin/login_history/create']        = 'login_history/create';
$route['admin/login_history/update/(:num)']    = 'login_history/update/$1'; */
$route['admin/login_history/read/(:num)']      = 'login_history/read/$1';
$route['admin/login_history/delete/(:num)']    = 'login_history/delete/$1';
/* $route['admin/login_history/create_action'] = 'login_history/create_action';
$route['admin/login_history/update_action']    = 'login_history/update_action'; */
$route['admin/login_history/delete_action/(:num)']    = 'login_history/delete_action/$1';
$route['admin/login_history/bulk_action']    = 'login_history/bulk_action';
