<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/parts']                  = 'parts';
$route['admin/parts/create']           = 'parts/create';
$route['admin/parts/update/(:any)']    = 'parts/update/$1';
$route['admin/parts/read/(:any)']      = 'parts/read/$1';
$route['admin/parts/delete/(:any)']    = 'parts/delete/$1';
$route['admin/parts/create_action']    = 'parts/create_action';
$route['admin/parts/update_action']    = 'parts/update_action';

$route['admin/parts/category']                  = 'parts/category';
$route['admin/parts/category/create']           = 'parts/category/create';
$route['admin/parts/category/update/(:any)']    = 'parts/category/update/$1';
$route['admin/parts/category/read/(:any)']      = 'parts/category/read/$1';
$route['admin/parts/category/delete/(:any)']    = 'parts/category/delete/$1';
$route['admin/parts/category/create_action']    = 'parts/category/create_action';
$route['admin/parts/category/update_action']    = 'parts/category/update_action';


$route['admin/parts/get_parts_description/(:any)']    = 'parts/get_parts_description/$1';
