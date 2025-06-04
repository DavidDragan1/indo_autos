<?php

$route['admin/brands']                  = 'brands';
$route['admin/brands/create']           = 'brands/create';
$route['admin/brands/update/(:any)']    = 'brands/update/$1';
$route['admin/brands/read/(:any)']      = 'brands/read/$1';
$route['admin/brands/delete/(:any)']    = 'brands/delete/$1';
$route['admin/brands/create_action']    = 'brands/create_action';
$route['admin/brands/update_action']    = 'brands/update_action';



$route['admin/brands/brand_create_action']           = 'brands/brand_create_action';
$route['admin/brands/brand_update_action']           = 'brands/brand_update_action';
$route['admin/brands/brands_by_vehicle_model']       = 'brands/brands_by_vehicle_model';
$route['admin/brands/brands_by_vehicle_type']         = 'brands/brands_by_vehicle';