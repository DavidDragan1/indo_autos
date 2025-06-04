<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function filesTabs($id, $active_tab) {
    $html = '<ul class="tabsmenu">';
    $tabs = [
        'read' => 'Details',
        'update' => 'Update',
        'delete' => 'Delete',
    ];

    foreach ($tabs as $link => $tab) {
        $html .= '<li> <a href="' . Backend_URL . 'files/' . $link . '/' . $id . '"';
        $html .= ($link === $active_tab ) ? ' class="active"' : '';
        $html .= '> ' . $tab . '</a></li>';
    }
    $html .= '</ul>';
    return $html;
}


function deleteFile($file = false, $folder = 'images/') {
    $file_path = dirname(BASEPATH) . '/uploads/' . $folder . $file;

    if ($file && file_exists($file_path)) {
        unlink($file_path);
    }
}

function file_action($id) {        
    $html = '<span class="ajax_preview btn btn-xs btn-success preview_file_note" data-id="' . $id . '" title="Preview"><i class="fa fa-search-plus"></i></span>&nbsp;';    
    return $html;
}

function download_attachment($file) {            
    $btn = '';
    if ($file && file_exists(dirname(BASEPATH) . '/' . $file)) {
        $url = site_url( 'my_account/download/?file=' . urlencode($file) );
        $btn .= '<a class="btn btn-primary btn-xs" href="'.$url.'"';
        $btn .= ' title=" Download File - ' . $file . '"';
        $btn .= '><i class="fa fa-download" aria-hidden="true"></i> Download</a>';
    } else {
        $btn .= '<em>File Not Exist</em>';
    }
    return $btn;     
}

function admin_download_attachment($file) {            
    $btn = '';
    if ($file && file_exists(dirname(BASEPATH) . '/' . $file)) {
        $url = site_url( 'admin/files/download?file=' . urlencode($file) );
        $btn .= '<a class="btn btn-primary btn-xs" href="'.$url.'"';
        $btn .= ' title=" Download File - ' . $file . '"';
        $btn .= '><i class="fa fa-download" aria-hidden="true"></i> Download</a>';
    } else {
        $btn .= '<em>File Not Exist</em>';
    }
    return $btn;     
}

function admin_new_download_attachment($file) {
    $btn = '';
    if ($file && file_exists(dirname(BASEPATH) . '/' . $file)) {
        $url = site_url( 'admin/files/download?file=' . urlencode($file) );
        $btn .= '<a href="'.$url.'"';
        $btn .= '>Download</a>';
    } else {
        $btn .= '<em>File Not Exist</em>';
    }
    return $btn;
}

function findexts($filename) {
    $filename   = strtolower($filename);
    $exts       = explode('.', $filename);
    $n          = count($exts) - 1;
    $exts       = $exts[$n];
    return $exts;
}

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 