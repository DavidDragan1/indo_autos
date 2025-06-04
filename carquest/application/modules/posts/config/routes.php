<?php defined('BASEPATH') OR exit('No direct script access allowed');
$route['admin/posts'] = 'posts';
$route['admin/posts/index'] = 'posts/index';
$route['admin/posts/create'] = 'posts/create';
$route['admin/posts/create_action'] = 'posts/create_action';
$route['admin/posts/delete/(:any)'] = 'posts/delete/$1';
$route['admin/posts/update_general/(:num)'] = 'posts/update_general/$1';
$route['admin/posts/update_post_detail/(:num)'] = 'posts/update_post_detail/$1';
$route['admin/posts/update_general_action'] = 'posts/update_general_action';
$route['admin/posts/update_post_detail_action/(:any)'] = 'posts/update_post_detail_action/$1';
$route['admin/posts/get_service_photo_reload/(:any)'] = 'posts/get_service_photo_reload/$1';
$route['admin/posts/statusUpdate'] = 'posts/statusUpdate';/* Post Photo upload and mark as feeature and deleting*/
$route['admin/posts/homepagePositionUpdate'] = 'posts/homepagePositionUpdate';/* Post Photo upload and mark as feeature and deleting*/
$route['admin/posts/update_photo/(:num)'] = 'posts/update_photo/$1';
$route['admin/posts/upload_service_photo/(:num)'] = 'posts/upload_service_photo/$1';
$route['admin/posts/mark_as_feature'] = 'posts/mark_as_feature';
$route['admin/posts/delete_service_photo'] = 'posts/delete_service_photo';
$route['admin/posts/mark_featured'] = 'posts/mark_featured';
$route['admin/posts/bulk_action'] = 'posts/bulk_action';
$route['admin/posts/bulk_delete'] = 'posts/delete_bulks';
$route['admin/posts/bill'] = 'posts/listing_bill';
$route['admin/posts/bill/preview/(:any)'] = 'posts/listing_bill/preview/$1';
$route['admin/posts/bill/update/(:any)'] = 'posts/listing_bill/update/$1';
$route['admin/posts/motor_asscocation'] = 'posts/motor_asscocation';
$route['admin/posts/driver_hire'] = 'posts/driver_hire';
$route['admin/posts/change_publish_date'] = 'posts/change_publish_date';
$route['admin/posts/make_position_add'] = 'posts/make_position_add';
$route['admin/posts/create_post']['post'] = 'posts/create_post';
$route['admin/posts/get-car-valuation']['post'] = 'posts/get_car_valuation';
$route['admin/posts/buy-post-package']['post'] = 'posts/buyPostPackage';
$route['admin/posts/trade-post-update/(:num)']['get'] = 'posts/tradePostUpdate/$1';



$route['admin/posts/tags']                  = 'posts/tags';
$route['admin/posts/tags/create']           = 'posts/tags/create';
$route['admin/posts/tags/update/(:num)']    = 'posts/tags/update/$1';
$route['admin/posts/tags/read/(:num)']      = 'posts/tags/read/$1';
$route['admin/posts/tags/delete/(:num)']    = 'posts/tags/delete/$1';
$route['admin/posts/tags/create_action']    = 'posts/tags/create_action';
$route['admin/posts/tags/update_action']    = 'posts/tags/update_action';
$route['admin/posts/tags/delete_action/(:num)']    = 'posts/tags/delete_action/$1';




// new routes
$route['admin/posts/update_valuation/(:num)'] = 'posts/update_valuation/$1';
$route['admin/posts/update_valuation_action'] = 'posts/update_valuation_action';
$route['get-post-titles']['post'] = 'posts/posts_frontview/getTitles';
$route['admin/posts/change_status']['post'] = 'posts/changeStatus';
$route['admin/posts/repost_advert/(:num)']['get'] = 'posts/repostAdvert/$1';
$route['admin/posts/delete_car_post']['post'] = 'posts/delete_car_post';
// Note:: Api Routes
$route['api/get-post-compare-list']['post'] = 'posts/posts_frontview/getPostCompareList';
$route['api/get-similar-post']['get'] = 'posts/posts_frontview/getSimilarPosts';
$route['api/delete-product/(:num)']['delete'] = 'posts/posts_frontview/api_delete_product/$1';




//$route['automech'] = 'posts/posts_frontview/automech';
//$route['automech-search'] = 'posts/posts_frontview/automech_search';
//$route['parts'] = 'posts/posts_frontview/spare_parts';
//$route['buy-motorbike'] = 'posts/posts_frontview/buy_motorbike';
//$route['spare-parts'] = 'posts/posts_frontview/spare_parts_search';
//$route['towing'] = 'posts/posts_frontview/towing';
//$route['towing-search'] = 'posts/posts_frontview/towing_search';
$route['favourite/(:any)'] = 'posts/posts_frontview/favourite/$1';
$route['products/(:any)'] = 'posts/posts_frontview/product/$1';




