<?php

$route['admin/email_templates']                 = 'email_templates';
$route['admin/email_templates/create']          = 'email_templates/create';
$route['admin/email_templates/create_action']   = 'email_templates/create_action';
$route['admin/email_templates/update_action']   = 'email_templates/update_action';
$route['admin/email_templates/read/(:any)']     = 'email_templates/read/$1';
$route['admin/email_templates/update/(:any)']   = 'email_templates/update/$1';
$route['admin/email_templates/delete/(:any)']   = 'email_templates/delete/$1';
