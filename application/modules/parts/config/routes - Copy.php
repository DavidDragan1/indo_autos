<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/parts']                  = 'parts';
$route['admin/parts/create']           = 'parts/create';
$route['admin/parts/update/(:any)']    = 'parts/update/$1';
$route['admin/parts/read/(:any)']      = 'parts/read/$1';
$route['admin/parts/delete/(:any)']    = 'parts/delete/$1';
$route['admin/parts/create_action']    = 'parts/create_action';
$route['admin/parts/update_action']    = 'parts/update_action';


