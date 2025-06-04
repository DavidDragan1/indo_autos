<?php

$route['admin/cms']                 = 'cms';
$route['admin/cms/create']          = 'cms/create';
$route['admin/cms/delete/(:num)']   = 'cms/delete/$1';

$route['admin/cms/create_action']   = 'cms/create_action';
$route['admin/cms/update_action']   = 'cms/update_action';

$route['admin/cms/update/(:num)']   = 'cms/update/$1';

$route['admin/cms/menus']           = 'cms/menus';
$route['admin/cms/update_status']   = 'cms/update_status';



/* ======== For Post ========== */
$route['admin/cms/posts']             	= 'cms/posts';
$route['admin/cms/new_post']      	= 'cms/new_post';

$route['admin/cms/create_action_post']  = 'cms/create_action_post';
$route['admin/cms/update_action_post']  = 'cms/update_action_post';
$route['admin/cms/update_post/(:any)']  = 'cms/update_post/$1';



$route['admin/cms/search-page']  = 'cms/search_page';
$route['admin/cms/search-page/add']  = 'cms/search_page_add';
$route['admin/cms/search-page/update/(:num)']  = 'cms/search_page_update/$1';
$route['admin/cms/search-page/delete/(:num)']  = 'cms/search_page_delete/$1';
$route['admin/cms/search-page/add_action']  = 'cms/search_page_add_action';