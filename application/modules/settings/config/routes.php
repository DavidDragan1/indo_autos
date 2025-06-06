<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/settings']                  = 'settings';
$route['admin/settings/items']                  = 'settings/items';
$route['admin/settings/create']           = 'settings/create';
$route['admin/settings/update/(:any)']    = 'settings/update/$1';
$route['admin/settings/read/(:any)']      = 'settings/read/$1';
$route['admin/settings/delete/(:any)']    = 'settings/delete/$1';
$route['admin/settings/create_action']    = 'settings/create_action';
$route['admin/settings/update_action']    = 'settings/update_action';
$route['admin/settings/update']           = 'settings/update';

$route['admin/settings/fb-callback']           = 'settings/fbCallback';


