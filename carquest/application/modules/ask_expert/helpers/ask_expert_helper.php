<?php defined('BASEPATH') OR exit('No direct script access allowed');

function ask_expertTabs($id, $active_tab) {
	$html = '<ul class="tabsmenu">';
	$tabs = [
                'read'   => 'Details',        
                'update' => 'Update',                
            ];

	foreach ($tabs as $link => $tab) {
		$html .= '<li> <a href="' . Backend_URL .'ask_expert/'. $link .'/'. $id .'"';
		$html .= ($link == $active_tab ) ? ' class="active"' : '';
		$html .= '> ' . $tab . '</a></li>';
	}
	$html .= '</ul>';
	return $html;
}

function getQuestionBy($ask_expert){
    if($ask_expert->question_by_email){
        return $ask_expert->qustion_by_name .'| '.  $ask_expert->question_by_email;
    } else {
        return 'Post by Admin';
    }                
}