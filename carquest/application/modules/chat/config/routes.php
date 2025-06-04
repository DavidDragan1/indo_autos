<?php

$route['admin/chat']  = 'chat/index';
$route['admin/chat/chat_message_send']  = 'chat/chat_message_send';
$route['admin/chat/delete_chat']  = 'chat/delete_chat';
$route['admin/chat/chat_notice']  = 'chat/chat_notice';

//$route['chat-form']  = 'chat/chat_frontview/chat_form';
$route['machanic-chat-form']  = 'chat/chat_frontview/machanic_chat_form';

$route['admin/chat/request']  = 'chat/request';
$route['admin/chat/request-action']  = 'chat/chat_frontview/request_action';

$route['admin/chat/chat_status_update']  = 'chat/chat_status_update';
$route['admin/chat/chat_status_delete']  = 'chat/chat_status_delete';

$route['chat']  = 'chat/chat_frontview/chat';


$route['admin/chat/get_user_chat']  = 'chat/Chat_frontview/get_user_chat';
$route['admin/chat/send_chat_message']  = 'chat/Chat_frontview/send_chat_message';
$route['admin/chat/delete-chat-full']  = 'chat/deleteChatFull';




//NOTE:: API Routes

$route['api/get-chat-user-list']  = 'chat/ChatApi/chat_user_list';
$route['api/get-user-chat']  = 'chat/ChatApi/get_user_chat';
$route['api/send-chat-message']  = 'chat/ChatApi/send_chat_message';
$route['api/store-chat-message']  = 'chat/ChatApi/store_chat_message';
