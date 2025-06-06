<?php defined('BASEPATH') OR exit('No direct script access allowed');

#==============================================================================================#
# Version Controlling System API #
#==============================================================================================#
$route['api/v1/get-multiple-city-by-multiple-state'] = 'api/get_multiple_city_by_multiple_states';

// V1 API's
$route['api/v1/sign-up']['post'] = 'auth/ApiAuth/signUp_v1';
$route['api/v1/sign-in']['post'] = 'auth/ApiAuth/signIn_v1';


$route['api/v1/home']['get']= 'posts/Posts_api/home';
$route['api/v1/latest-vehicle']['get']= 'posts/Posts_api/latest_vehicle_api';
$route['api/v1/post-details/(:any)']['get']= 'posts/Posts_api/post_details_v1/$1';
$route['api/v1/posts']['get']= 'posts/Posts_api/search_list_v1';
$route['api/v1/like-unlike-post']['post']= 'posts/Posts_api/likeOrUnlike';
$route['api/v1/favourite']['get']= 'posts/Posts_api/favourite';
$route['api/v1/add-product']['post'] = 'posts/Posts_api/create_update_post';
$route['api/v1/get-mobile-mechanic-multiple-service-by-catgory']['get'] = 'posts/Posts_api/towing_type_of_services_for_service';
$route['api/v1/get-multiple-brand-by-multiple-vehicle']['get'] = 'posts/Posts_api/getBrandsByVehicle_v1';

$route['api/v1/get-car-valuation-price'] = 'Api/Car_Valuation/car_valuation_v1';


$route['api/v1/trade-seller/(:any)']['get'] = 'Api/Trade_Seller/getTradeSeller_v1/$1';



$route['api/v1/business-profile']['get'] = 'profile/ApiProfile/api_bussiness_v1';
$route['api/v1/business-profile-update']['post'] = 'profile/ApiProfile/business_update_v1';
$route['api/v1/basic-profile-update']['post'] = 'profile/ApiProfile/basic_profile_update';
$route['api/v1/driver-profile-update']['post'] = 'profile/ApiProfile/driver_profile_update';
$route['api/v1/verifier-profile-update']['post'] = 'profile/ApiProfile/verifier_profile_update';
$route['api/v1/mechanic-profile-update']['post'] = 'profile/ApiProfile/mechanic_profile_update';
$route['api/v1/private-seller-profile-update']['post'] = 'profile/ApiProfile/private_seller_profile_update';


//$route['api/v1/review-reply-add-edit']['post'] = 'reviews/Review_api/add_edit_reply_v1';
//$route['api/v1/review-list']['get'] = 'reviews/Review_api/review_list_v1';


$route['api/v1/role-list']['get'] = 'Api/Trade_Seller/role_list_v1';
