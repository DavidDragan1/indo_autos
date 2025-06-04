<?php


/* mails */
$route['admin/mails']                 = 'mails';
$route['admin/mails']                 = 'mails';
$route['admin/mails/create']          = 'mails/create';
$route['admin/mails/create_action']   = 'mails/create_action';
$route['admin/mails/read/(:any)']     = 'mails/read/$1';
$route['admin/mails/read-mail/(:any)/(:any)']     = 'mails/trader_read/$1/$2';
$route['admin/mails/delete/(:num)']          = 'mails/delete/$1';
$route['admin/mails/update/(:any)']   = 'mails/update/$1';

$route['admin/mails/update_important_ajax'] = 'mails/update_important_ajax';
$route['admin/mails/reply_mail']            = 'mails/reply_mail';
$route['admin/mails/forward_mail']          = 'mails/forward_mail';
$route['admin/mails/reply_mail_action']     = 'mails/reply_mail_action';
$route['admin/mails/reply_mail_action_trader']     = 'mails/reply_mail_action_trader';
$route['admin/mails/sent']                  = 'mails/sent';

$route['admin/mails/report']                = 'mails/report';
$route['admin/mails/change_status']['post'] = 'mails/changeStatus';
//$route['admin/mails/getMakeAnOfferRequest']   = 'mails/getMakeAnOfferRequest';