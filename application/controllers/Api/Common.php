<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Common extends Frontend_controller
{
    function version(){
        $setting = $this->db->select('*')
            ->where_in('label', ['AndroidVersion','IosVersion','AndroidForceUpdate','IosForceUpdate','AndroidAppStoreLink', 'IosAppLink'])
            ->get('settings')->result();
        $merge_data = [];
        foreach ($setting as $set){
            if ($set->label == 'AndroidVersion'){
                $merge_data['android_version'] = $set->value;
            }elseif($set->label == 'IosVersion'){
                $merge_data['ios_version'] = $set->value;
            }elseif($set->label == 'AndroidForceUpdate'){
                $merge_data['android_force_update'] = $set->value === 'Yes';
            }elseif($set->label == 'IosForceUpdate'){
                $merge_data['ios_force_update'] = $set->value === 'Yes';
            }elseif($set->label == 'AndroidAppStoreLink'){
                $merge_data['android_app_link'] = $set->value;
            }elseif($set->label == 'IosAppLink'){
                $merge_data['ios_app_link'] = $set->value;
            }
        }
        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $merge_data
        ]);
    }
}