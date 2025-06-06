<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/files']                  = 'files';
$route['admin/files/preview']          = 'files/preview';
$route['admin/files/download']         = 'files/download';

$route['admin/files/create']           = 'files/create';
$route['admin/files/upload']           = 'files/upload';

$route['admin/files/update/(:num)']    = 'files/update/$1';
$route['admin/files/update_action']    = 'files/update_action';
$route['admin/files/delete/(:num)']    = 'files/delete/$1';
$route['admin/files/delete_action/(:num)'] = 'files/delete_action/$1';
