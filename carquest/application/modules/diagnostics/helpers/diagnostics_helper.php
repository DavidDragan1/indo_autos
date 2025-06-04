<?php defined('BASEPATH') OR exit('No direct script access allowed');

function helpTabs($id, $active_tab) {
	$html = '<ul class="tabsmenu">';
	$tabs = [
                'read'   => 'Details',        
                'update' => 'Update',                
            ];

	foreach ($tabs as $link => $tab) {
		$html .= '<li> <a href="' . Backend_URL .'diagnostics/'. $link .'/'. $id .'"';
		$html .= ($link == $active_tab ) ? ' class="active"' : '';
		$html .= '> ' . $tab . '</a></li>';
	}
	$html .= '</ul>';
	return $html;
}

function getQuestionBy($diagnostics){
    if($diagnostics->question_by_email){
        return $diagnostics->qustion_by_name .'| '.  $diagnostics->question_by_email;
    } else {
        return 'Post by Admin';
    }                
}

function makeQuestionType($user_id)
{
    $ci = &get_instance();
    $periods = $ci->db->where(['status' => 'Published'])->order_by('id', 'DESC')->get('diagnostics_question_type')->result();

    $options = '<option value="">Select Question Type</option>';

    foreach ($periods as $period) {
        $options .= '<option value="' . $period->id . '" ';
        $options .= '>' . $period->title . '</option>';
    }
    return $options;
}

function makeQuestion($user_id = null)
{
    $ci = &get_instance();
    $periods = $ci->db->where(['status' => 'Published'])->order_by('id', 'DESC')->get('diagnostics_question')->result();

    $options = '<option value="">Select Question</option>';

    foreach ($periods as $period) {
        $options .= '<option value="' . $period->id . '" ';
        $options .= '>' . $period->question . '</option>';
    }
    return $options;
}

function makeProblem($user_id)
{
    $ci = &get_instance();
    $periods = $ci->db->where(['status' => 'Published'])->order_by('id', 'DESC')->get('diagnostics_problem')->result();

    $options = '<option value="">Select Question</option>';

    foreach ($periods as $period) {
        $options .= '<option value="' . $period->id . '" ';
        $options .= '>' . $period->problem . '</option>';
    }
    return $options;
}

function makeInspection($user_id)
{
    $ci = &get_instance();
    $periods = $ci->db->where(['status' => 'Published'])->order_by('id', 'DESC')->get('diagnostics_inspection')->result();

    $options = '<option value="">Select Question</option>';

    foreach ($periods as $period) {
        $options .= '<option value="' . $period->id . '" ';
        $options .= '>' . $period->inspection . '</option>';
    }
    return $options;
}
