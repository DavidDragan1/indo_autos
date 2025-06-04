<?php

$route['admin/module']                 = 'module';
$route['admin/module/create']          = 'module/create';
$route['admin/module/create_action']   = 'module/create_action';
$route['admin/module/update_action']   = 'module/update_action';
$route['admin/module/read/(:any)']     = 'module/read/$1';
$route['admin/module/update/(:any)']   = 'module/update/$1';
$route['admin/module/delete/(:any)']   = 'module/delete/$1';
$route['admin/module/add_module_acls']   = 'module/add_module_acls';
