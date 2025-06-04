<?php

function isDeadSystem(){
    if(!function_exists('system')){
        echo ajaxRespond('Fail', '<p class="ajax_error">System Function is Off</p>');
        exit;
    }
}



function getTableTruncateButton($table = null) {


    $tables = array(
        'users', 'user_meta', 'settings', 'roles', 'role_permissions', 'modules', 'acls', 'countries',
        'branch', 'db_sync', 'product_brands', 'product_categories', 'products', 'customers'
    );


    if ($table && in_array($table, $tables)) {
        return '<button class="btn btn-xs btn-default disabled"> - - - - -</button>';
    } else {
        return '<button class="btn btn-xs btn-danger" onclick="truncateDialog(\'' . $table . '\');"><i class="fa fa-trash-o"></i> Clean </button>';
    }
}
