<?php


$route['admin/acls']                    = 'acls';
$route['admin/acls/create']             = 'acls/create';        
$route['admin/acls/read/(:num)']        = 'acls/read/$1';
$route['admin/acls/delete/(:num)']      = 'acls/delete/$1';
$route['admin/acls/update/(:num)']      = 'acls/update/$1';
$route['admin/acls/create_action']      = 'acls/create_action';
$route['admin/acls/update_action']      = 'acls/update_action';


// admin/users/acls