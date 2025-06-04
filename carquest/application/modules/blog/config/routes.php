<?php
$route['admin/blog'] = 'blog/Blog';
$route['admin/blog/create'] = 'blog/new_post';
$route['admin/blog/create_action_post'] = 'blog/create_action_post';
$route['admin/blog/update_action_post'] = 'blog/update_action_post';
$route['admin/blog/update/(:num)'] = 'blog/update_post/$1';
$route['admin/blog/update_status'] = 'blog/update_status';
$route['admin/blog/get_tags'] = 'blog/get_tag';


$route['admin/blog/category'] = 'blog/blog_category';
$route['admin/blog/category/create'] = 'blog/blog_category/create';
$route['admin/blog/category/update/(:num)'] = 'blog/blog_category/update/$1';

$route['admin/blog/category/create_action'] = 'blog/blog_category/create_action';
$route['admin/blog/category/update_action'] = 'blog/blog_category/update_action';

$route['admin/blog/category/delete/(:num)'] = 'blog/update_post/$1';


// Public Page
$route['blog'] = 'blog/Blog_frontend';
$route['blog/category/?(:any)?'] = 'blog/Blog_frontend/category/$1';
$route['blog/tag/(:any)'] = 'blog/Blog_frontend/tag/$1';
$route['blog-detail/(:any)'] = 'blog/Blog_frontend/single/$1'; // post mean news post or blog post