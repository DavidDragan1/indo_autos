<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Users Management [ Admin, Editor, Vendor, Customer etc everyone ] */
$route['admin/users']                   = 'users';

$route['admin/users/profile/(:num)']    = 'users/profile/$1';
$route['admin/users/create']            = 'users/create';
$route['admin/users/create_action']     = 'users/create_action';
$route['admin/users/mails/(:num)']      = 'users/mails/$1';
$route['admin/users/update/(:num)']     = 'users/update/$1';
$route['admin/users/update_action']     = 'users/update_action';
$route['admin/users/delete/(:num)']     = 'users/delete/$1';


$route['admin/users/document_list/(:num)'] = 'users/document_list/$1';
$route['admin/users/document_create/(:num)'] = 'users/document_create/$1';
$route['admin/users/document_create_action'] = 'users/document_create_action';
$route['admin/users/document_edit/(:num)'] = 'users/document_update/$1';
$route['admin/users/document_update_action'] = 'users/document_update_action';
$route['admin/users/document_delete/(:num)'] = 'users/document_delete/$1';

/* Roles Controller */
$route['admin/users/roles']         = 'users/roles';
$route['admin/users/roles/create']  = 'users/roles/create';
$route['admin/users/roles/rename']  = 'users/roles/rename';
$route['admin/users/roles/delete']  = 'users/roles/delete';
$route['admin/users/roles/update']  = 'users/roles/update';
$route['admin/users/roles/getAcl']  = 'users/roles/getAcl';
$route['admin/users/countUser']     = 'users/countUser';


$route['admin/role_permissions']          = 'role_permissions';
$route['admin/users/roles/update_acl']    = 'users/roles/update_acl';
$route['admin/users/seller_status']    = 'users/seller_status';
$route['admin/users/mechanic-verification-status-change']    = 'users/mechanicVerificationStatusChange';



$route['admin/users/password/(:num)']    = 'users/password/$1';
$route['admin/users/reset_password']    = 'users/reset_password';


$route['admin/users/business/(:num)']  = 'users/business/$1';
$route['admin/users/business_update']  = 'users/business_update';
$route['admin/users/user_business_update']  = 'users/user_business_update';

$route['admin/users/video/(:num)']      = 'users/video/$1';
$route['admin/users/video_update']      = 'users/video_update';

$route['admin/users/notification']      = 'users/notification';
$route['admin/users/notification/delete/(:any)']      = 'users/notification/delete/$1';
$route['admin/users/notification/delete_action/(:any)']      = 'users/notification/delete_action/$1';



$route['admin/users/change-profile-status/(:num)/(:any)']         = 'users/change_profile_status/$1/$2';



$route['admin/users/clearing-agent-product/(:num)']         = 'users/Clearing_user/index/$1';
$route['admin/users/clearing-agent-product/delete/(:num)']         = 'users/Clearing_user/delete/$1';
$route['admin/users/clearing-agent-product/update/(:num)']         = 'users/Clearing_user/update/$1';
$route['admin/users/clearing-agent-product/create-action']['post']         = 'users/Clearing_user/create_action';

$route['admin/users/verifier-agent-product/(:num)']         = 'users/Verifier_user/index/$1';
$route['admin/users/verifier-agent-product/delete/(:num)']         = 'users/Verifier_user/delete/$1';
$route['admin/users/verifier-agent-product/update/(:num)']         = 'users/Verifier_user/update/$1';
$route['admin/users/verifier-agent-product/create-action']['post']         = 'users/Verifier_user/create_action';


$route['admin/users/shipping-agent-product/(:num)']         = 'users/Shipping_user/index/$1';
$route['admin/users/shipping-agent-product/delete/(:num)']         = 'users/Shipping_user/delete/$1';
$route['admin/users/shipping-agent-product/update/(:num)']         = 'users/Shipping_user/update/$1';
$route['admin/users/shipping-agent-product/create-action']['post']         = 'users/Shipping_user/create_action';

$route['admin/users/availability/(:num)']['get']         = 'users/Driver/availability/$1';
$route['admin/users/add-availability/(:num)']['get']         = 'users/Driver/addAvailability/$1';
$route['admin/users/availability-add-action']['post']         = 'users/Driver/addAvailabilityAction';
$route['admin/users/availability-update/(:num)']['get']         = 'users/Driver/availabilityUpdate/$1';
$route['admin/users/availability-update-action']['post']         = 'users/Driver/availabilityUpdateAction';
$route['admin/users/availability-delete/(:num)']['get']         = 'users/Driver/availabilityDelete/$1';
$route['admin/users/availability-status-change/(:num)']['get']         = 'users/Driver/changeAvailabilityStatus/$1';















