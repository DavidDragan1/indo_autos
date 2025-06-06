<?php defined('BASEPATH') OR exit('No direct script access allowed');

function helpTabs($id, $active_tab) {
	$html = '<ul class="tabsmenu">';
	$tabs = [
                'read'   => 'Details',        
                'update' => 'Update',                
            ];

	foreach ($tabs as $link => $tab) {
		$html .= '<li> <a href="' . Backend_URL .'help/'. $link .'/'. $id .'"';
		$html .= ($link == $active_tab ) ? ' class="active"' : '';
		$html .= '> ' . $tab . '</a></li>';
	}
	$html .= '</ul>';
	return $html;
}

function getQuestionBy($help){
    if($help->question_by_email){
        return $help->qustion_by_name .'| '.  $help->question_by_email;
    } else {
        return 'Post by Admin';
    }                
}