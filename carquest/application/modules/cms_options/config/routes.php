<?php


$route['admin/cms/category']         = 'cms_options';
$route['admin/cms/category/create']          = 'cms_options/create';
$route['admin/cms/category/read/(:any)']     = 'cms_options/read/$1';
$route['admin/cms/category/delete/(:any)']          = 'cms_options/delete/$1';
$route['admin/cms/category/update/(:any)']   = 'cms_options/update/$1';

$route['admin/cms/category/create_action']          = 'cms_options/create_action';
$route['admin/cms/category/update_action']          = 'cms_options/update_action';




