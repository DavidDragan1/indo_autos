<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller']    = 'frontend';

$route['maintenance']                   = 'frontend/maintenance';
$route['my-account'] = 'my_account/index';
$route['google-login']['get']    = 'auth/google_login';
$route['google-login']['post']    = 'auth/google_login_ontap';
$route['forget-password']    = 'auth/forget_password';
$route['facebook-login']    = 'auth/facebook_login';
$route['faq/(:any)']            = 'frontend/faq/$1';
$route['submit_faq']            = 'frontend/submit_faq';
$route['submit_expert']            = 'frontend/submit_expert';

$route['comment']['post']                  =  'frontend/comment';
$route['auth/check_email']['post']       = 'auth/check_email';
$route['all-city']     = 'frontend/all_city';
$route['all-city-slug']     = 'frontend/all_city_slug';
$route['private-seller/(:num)']     = 'frontend/privetSeller/$1';

$route['car-valuation']            = 'frontend/car_valuation';
$route['get_vehicle_variant']            = 'frontend/get_vehicle_variant';
$route['get_body_condition']            = 'frontend/get_body_condition';
$route['get_brands']            = 'frontend/get_brands';
$route['get_car_valuation_price']            = 'frontend/get_car_valuation_price';
$route['diagnostic_search']['post']            = 'frontend/getDiagnostics';
$route['diagnostic_search_inspection']['post']            = 'frontend/getSearchInspaction';
$route['diagnostic_search_solution']['post']            = 'frontend/getSearchSolution';
$route['get-diagnostics-question']['post']           = 'frontend/getQuestion';
$route['get-diagnostics-problem']['post']           = 'frontend/getProblem';
$route['get-diagnostics-inspection']['post']           = 'frontend/getInspection';
$route['get-diagnostics-solution']['post']           = 'frontend/getSolution';
$route['submit_diagnostic']            = 'frontend/submit_diagnostic';
$route['tag/(:any)']            = 'frontend/tag/$1';
$route['diagnostic-rating-submit']            = 'frontend/diagnosticRatingSubmit';


$route['admin']                 = 'dashboard';
$route['admin/dashboard/report']                 = 'dashboard/report';
$route['admin/login']           = 'auth/login_form';
$route['admin/logout']          = 'auth/logout';
$route['email-verification/(:any)']  = 'frontend/email_verification/$1';
$route['re_send_email']['get']  = 'frontend/re_send_email';

$route['post/(:any)']           = 'posts/posts_frontview/single/$1';
$route['product-add']['post']           = 'posts/posts_frontview/productAdd';
//$route['review']['post']          = 'frontend/review';
$route['finance']           = 'frontend/finance';


$route['car_valuation_ajax']           = 'frontend/car_valuation_ajax';

$route['404_override']          = 'frontend';

$route['translate_uri_dashes'] 	= FALSE;

$route['unsubscribe']           = 'newsletter_subscriber/newsletter_frontend_subscriber/unsubscribe';


// Searching List Route
$route['buy/(:any)'] = "posts/Posts_frontview/buy/$1";
$route['buy/(:any)/search'] = "posts/Posts_frontview/search_list/$1";
//Buy Import car route
$route['buy-import/(:any)'] = 'posts/posts_frontview/import_buy/$1';
$route['buy-import/(:any)/search'] = "posts/Posts_frontview/import_search_list/$1";

/* Users Management [ Admin, Editor, Vendor, Customer etc everyone ] */

define('ModuleRoutePrefix', APPPATH . '/modules/');
define('ModuleRouteSuffix', '/config/routes.php');

require_once ( ModuleRoutePrefix . 'settings' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'users' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'acls' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'cms' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'blog' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'email_templates' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'profile' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'module' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'cms_options' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'db_sync' . ModuleRouteSuffix);
//require_once ( ModuleRoutePrefix . 'mail_folders' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'mails' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'newsletter_subscriber' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'notification' . ModuleRouteSuffix);



/* Only For Car Posting */
require_once ( ModuleRoutePrefix . 'gallery' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'posts' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'parts' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'post_area' . ModuleRouteSuffix);

require_once ( ModuleRoutePrefix . 'body_types' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'brands' . ModuleRouteSuffix);

require_once ( ModuleRoutePrefix . 'color' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'engine_sizes' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'fuel_types' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'port' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'vehicle_types' . ModuleRouteSuffix);

require_once ( ModuleRoutePrefix . 'chat' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'login_history' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'help' . ModuleRouteSuffix);

require_once ( ModuleRoutePrefix . 'files' . ModuleRouteSuffix);


require_once ( ModuleRoutePrefix . 'vehicle_variants' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'vehicle_valuation_settings' . ModuleRouteSuffix);

require_once ( ModuleRoutePrefix  . 'pricing' . ModuleRouteSuffix);

$route['api/send-offer']['post']      = 'mail/api_send_offer';
$route['api/contact-us']['post']      = 'mail/send_a_message';
$route['api/report-spam']['post']     = 'mail/report_spam';

$route['api/contact-to-seller']['post']= 'mail/api_contact_to_seller';

$route['admin/api/update-post-general/(:any)']['get']= 'posts/api_update_general_data/$1';
$route['admin/api/update-post-general']['post']     = 'posts/api_update_general';
$route['admin/api/get-post-detail/(:any)']['get']    = 'posts/api_get_post_detail/$1';
$route['admin/api/update-post-detail/(:num)']['post']    = 'posts/api_update_post_detail/$1';
$route['admin/api/update-post-photos/(:any)']['post']    = 'posts/api_update_post_photos/$1';
$route['admin/api/uploaded-post-photos/(:any)']['get']    = 'posts/api_get_service_photo/$1';
$route['admin/api/post-photo-delete']['get']            = 'posts/api_delete_service_photo';

$route['api/page/(:any)']['get']= 'frontend/api_cms_page/$1';

// Post helper
$route['api/post-step-1']['get']                = 'posts/posts_frontview/first_page';
$route['api/post-step-2']['get']                = 'posts/posts_frontview/second_page';
$route['api/towing-service-id/(:num)']['get']   = 'posts/posts_frontview/get_towing_service_ids/$1';

$route['api/filter']['get']                     = 'posts/posts_frontview/fiter_api';
$route['api/min_year']['get']                   = 'posts/posts_frontview/min_max_year';
$route['api/min_price']['get']                  = 'posts/posts_frontview/min_max_price';
$route['api/get_parts_desc']['get']             = 'posts/posts_frontview/get_parts_desc';

$route['api/seller_info/(:num)']['get']              = 'posts/posts_frontview/api_seller_info/$1';
$route['api/seller_post/(:num)']['get']              = 'posts/posts_frontview/api_seller_post/$1';








// /sign-in:: New API added by Debu for Mobile APPs

$route['api/sign-in']['post'] = 'auth/ApiAuth/signIn';
$route['api/user-delete']['delete'] = 'auth/ApiAuth/user_delete';
$route['api/social-sign-in']['post'] = 'auth/ApiAuth/social_login_api';
$route['api/sign-up']['post'] = 'auth/ApiAuth/signUp';
$route['api/sign-out']['get'] = 'auth/ApiAuth/logout';
$route['api/verify-email']['post'] = 'auth/ApiAuth/verifyEmail';
$route['api/resend-email-verification-code']['get'] = 'auth/ApiAuth/resendEmailVerificationCode';
$route['api/forget-password']['post'] = 'auth/ApiAuth/api_forgot_pass';
$route['api/reset-password']['post'] = 'auth/ApiAuth/api_reset_pass';

$route['api/profile']['get'] = 'profile/ApiProfile/api_profile';
$route['api/profile/update']['post'] = 'profile/ApiProfile/api_update';
$route['api/profile/update-password']['post'] = 'profile/ApiProfile/api_update_password';
$route['api/profile/update-profile-image']['post'] = 'profile/ApiProfile/updateProfileImage';

$route['api/add-product']['post'] = 'posts/posts_frontview/apiAddProduct';
$route['api/update-product']['post'] = 'posts/posts_frontview/apiUpdateProduct';
$route['api/get-dropdown-data']['get'] = 'posts/posts_frontview/getDropDownData';
$route['api/get-brands']['get'] = 'posts/posts_frontview/getBrandsByVehicle';
$route['api/get-models']['get'] = 'posts/posts_frontview/getModelByBrands';
$route['api/my-posts']['get'] = 'posts/posts_frontview/my_posts';
$route['api/posts']['get'] = 'posts/posts_frontview/public_posts';
$route['api/post-details/(:any)']['get'] = 'posts/posts_api/post_details/$1';

$route['api/get_vehicle_variant'] = 'Api/Car_Valuation/get_vehicle_variant';
$route['api/get_body_condition'] = 'Api/Car_Valuation/get_body_condition';
$route['api/get_car_valuation_price'] = 'Api/Car_Valuation/get_car_valuation_price';


$route['api/trade-seller/(:any)'] = 'Api/Trade_Seller/getTradeSeller';
$route['api/contact-to-us']['post']      = 'mail/send_message_to_admin';

$route['api/my-inbox']['get']= 'mails/ApiMails/api_index';
$route['api/read-email/(:num)']['get']= 'mails/ApiMails/api_read/$1';
$route['api/read-email-details/(:num)']['get']= 'mails/ApiMails/read_email_details/$1';
$route['api/email-reply']['post']= 'mails/ApiMails/api_reply_mail_action';
$route['api/email-delete']['post']= 'mails/ApiMails/mail_delete';

$route['api/join-driver'] = 'Api/DriversApi/driver_join';
$route['api/driver-requirement-service'] = 'Api/DriversApi/driver_requirement_service';
$route['api/driver-hire-request'] = 'Api/DriversApi/driver_hire_request';
$route['api/driver-list'] = 'Api/DriversApi/driver_list';
$route['api/driver-hire/(:num)'] = 'Api/DriversApi/hire_driver/$1';

$route['api/get-all-city'] = 'api/get_all_city';
$route['api/v1/get-all-state-city'] = 'api/get_all_state_city';
$route['api/get-parts-name'] = 'api/get_parts_name';

$route['api/update-business-page']['post'] = 'profile/ApiProfile/businessUpdate';
$route['api/update-company-logo']['post'] = 'profile/ApiProfile/companyLogo';
$route['api/update-company-cover']['post'] = 'profile/ApiProfile/companyCover';
$route['api/update-video-gallery']['post'] = 'profile/ApiProfile/videoUpdate';
$route['api/video-gallery']['get'] = 'profile/ApiProfile/video';
$route['api/video-edit']['post'] = 'profile/ApiProfile/videoEdit';
$route['api/video-delete']['post'] = 'profile/ApiProfile/videoDelete';
$route['api/business-page']['get'] = 'profile/ApiProfile/business';
$route['api/business-hours']['get'] = 'profile/ApiProfile/businessHours';
$route['api/business-hours-update']['post'] = 'profile/ApiProfile/businessHoursUpdate';



$route['api/push']['get']= 'mails/ApiMails/push';
$route['api/check-push-on-off']['get']= 'mails/ApiMails/checkPushOnOff';
$route['api/push-on-off']['post']= 'mails/ApiMails/pushOnOff';


$route['api/private-seller/(:any)']['get'] = 'Api/Private_Seller/getPrivateSeller';


include_once 'api_routes.php';

$route['api/v1/version']['get'] = 'Api/Common/version';


$route['sitemap.xml'] = "Sitemap";

$route['sitemap/general.xml'] = "Sitemap/general";
$route['sitemap/seller.xml'] = "Sitemap/seller";
$route['sitemap/post-(:any)'] = "Sitemap/sitemapView";
$route['sitemap/tags.xml'] = "Sitemap/tags";

