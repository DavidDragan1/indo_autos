<?php

$route['admin/gallery']                 = 'gallery/index';
$route['admin/gallery/settings']        = 'gallery/settings';
$route['admin/gallery/upload_photo']    = 'gallery/upload_photo';
$route['admin/gallery/saveSettings']    = 'gallery/saveSettings';
$route['admin/gallery/create']          = 'gallery/create';

$route['admin/gallery/delete']          = 'gallery/delete';
$route['admin/gallery/albums']          = 'gallery/albums';
$route['admin/gallery/video']           = 'gallery/video';
$route['admin/gallery/update/(:any)']   = 'gallery/update/$1';

$route['admin/gallery/create_album']        = 'gallery/create_album';
$route['admin/gallery/edit_album/(:num)']   = 'gallery/edit_album/$1';
$route['admin/gallery/update_album']        = 'gallery/update_album';
$route['admin/gallery/delete_album']        = 'gallery/delete_album';
$route['admin/gallery/update_action']       = 'gallery/update_action';


$route['admin/gallery/create_video']       = 'gallery/create_video';
$route['admin/gallery/upload_video']       = 'gallery/upload_video';
$route['admin/gallery/update_video/(:num)']= 'gallery/update_video/$1';
$route['admin/gallery/update_video_action']= 'gallery/update_video_action';


$route['admin/gallery/album_update_action'] = 'gallery/album_update_action';
$route['admin/gallery/album_update/(:any)'] = 'gallery/album_update/$1';

//$route['album']                 = 'gallery/view_gallery';
//$route['album/(:any)']          = 'gallery/view_album';
//$route['album/(:any)/(:any)']   = 'gallery/album';