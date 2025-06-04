<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin/notification']    = 'notification/notification_view';
$route['admin/add-notification']    = 'notification/add_notification';
$route['admin/delete-notification/(:num)']    = 'notification/delete_notification/$1';

