<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller']    = 'frontend';

$route['admin']                 = 'dashboard';
$route['admin/login']           = 'auth/login_form';
$route['admin/logout']          = 'auth/logout';

$route['post/(:any)']           = 'posts/posts_frontview/single/$1';



$route['404_override']          = 'frontend';
$route['blog/(:any)']           = 'frontend/post/$1'; // post mean news post or blog post 
$route['translate_uri_dashes'] 	= FALSE;

$route['unsubscribe']           = 'newsletter_subscriber/newsletter_frontend_subscriber/unsubscribe';
/* Users Management [ Admin, Editor, Vendor, Customer etc everyone ] */

define('ModuleRoutePrefix', APPPATH . '/modules/');
define('ModuleRouteSuffix', '/config/routes.php');

require_once ( ModuleRoutePrefix . 'settings' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'users' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'acls' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'cms' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'email_templates' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'profile' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'module' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'cms_options' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'db_sync' . ModuleRouteSuffix);
//require_once ( ModuleRoutePrefix . 'mail_folders' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'mails' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'newsletter_subscriber' . ModuleRouteSuffix);


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
require_once ( ModuleRoutePrefix . 'special_features' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'vehicle_types' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'package' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'repair_type' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'specialism' . ModuleRouteSuffix);

require_once ( ModuleRoutePrefix . 'chat' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'login_history' . ModuleRouteSuffix);
require_once ( ModuleRoutePrefix . 'reviews' . ModuleRouteSuffix);





// API  routes 


$route['ApiSearch']['get']          = 'posts/posts_frontview/api_getPosts';
$route['ApiSearch/(:any)']['get']   = 'posts/posts_frontview/singlePostApi/$1';

$route['ApiLogin']['post']   = 'auth/login';
$route['ApiRegister']['post']   = 'auth/sign_up';
$route['ApiForgotPassword']['post']   = 'auth/forgot_pass';


$route['ApiSendOffer']['post']   = 'mail/send_offer';
$route['ApiContactUs']['post']   = 'mail/send_a_message';
$route['ApiReportSpam']['post']   = 'mail/report_spam';



