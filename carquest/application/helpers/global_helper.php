<?php  defined('BASEPATH') OR exit('No direct script access allowed');

function getShortContent($long_text = '', $show = 100) {


    $filtered_text = strip_tags(isset($long_text)?$long_text:'');

    if ($show < strlen($filtered_text)) {
        return substr($filtered_text, 0, $show) . '...';
    } else {
        return $filtered_text;
    }
}


function getShortContentAltTag($long_text = '', $show = 100) {

    $filtered_text = strip_tags($long_text);
    if ($show < strlen($filtered_text)) {
        return substr($filtered_text, 0, $show);
    } else {
        return $filtered_text;
    }
}
//
function showMoreTxtBtn($text, $limit = 200, $id = 1, $link = 'faq') {
    $html       = '';
    $plain_txt  = strip_tags($text);
    $leanth     = strlen($plain_txt);
    $short_txt  = substr($plain_txt, 0, $limit);

    if($leanth > $limit){
        $html .= $short_txt;
        $html .= '....&nbsp;<a href="'. site_url($link. '/'. $id ).'">Read Details >></a>';
    } else {
        $html .= $short_txt;
    }

    return $html;
}

function newShowMoreTxtBtn($text, $limit = 200, $title = '', $id = 1, $link = 'faq') {
    $html       = '';
    $plain_txt  = strip_tags($text);
    $leanth     = strlen($plain_txt);
    $short_txt  = substr($plain_txt, 0, $limit);

    if($leanth > $limit){
        $html .= $short_txt;
        $url = url($title).'-'.$id ;
        $html .= '....&nbsp;<a href="'. site_url($link. '/'. $url).'">Read Details >></a>';
    } else {
        $html .= $short_txt;
    }

    return $html;
}


function url($url) {
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
    $url = trim($url, "-");
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url);

    return $url;
}

/*
function showMoreTxtBtn2($text, $limit = 200, $id = 1, $link = 'faq') {
    $html       = '';
    $plain_txt  = $text;
    $leanth     = strlen($plain_txt);
    $short_txt  = substr($plain_txt, 0, $limit);

    if($leanth > $limit){
        $html .= $short_txt;
        $html .= '....&nbsp;<a class="btn btn-info btn-xs" href="'. site_url($link. '/'. $id ).'">Read Details &rarr;</a>';
    } else {
        $html .= $short_txt;;
    }

    return $html;
}
*/

function getPostStatusDropdown($selected = 0){
    $status = [
        '0'         => '--Select--',
        'Active'    => 'Active',
        'Inactive'  => 'Inactive',
        'Pending'   => 'Pending',
        'Sold'   => 'Sold'
    ];

    $row = '';
    foreach ($status as $key => $option) {
        $row .= '<option value="' . $key . '"';
        $row .= ($selected === $key) ? ' selected' : '';
        $row .= '>' . $option . '</option>';
    }
    return $row;
}
function globalStatus($selected = 0) {
    $status = [
        '0'         => '--Select--',
        'Active'    => 'Active',
        'Inactive'  => 'Inactive',
        'Pending'   => 'Pending'
    ];

    $row = '';
    foreach ($status as $key => $option) {
        $row .= '<option value="' . $key . '"';
        $row .= ($selected === $key) ? ' selected' : '';
        $row .= '>' . $option . '</option>';
    }
    return $row;
}





function getGlobalStatus( $status = 'Active'){
    // <span class="label label-success"></span>

    switch ( $status ){
        case 'Active':
        case 'Publish':
            return '<span class="label label-success"> <i class="fa fa-check-square-o"></i> '. $status . '</span>';

        case 'Draft':
            return '<span class="label label-info"><i class="fa fa-file-o" ></i> '. $status . '</span>';

        case 'Pending':
            return '<span class="label label-default"><i class="fa fa-hourglass-1"></i> '. $status . '</span>';

        case 'Locked':
            return '<span class="label label-warning"><i class="fa fa-lock"></i> '. $status . '</span>';

        case 'Trash':
            return '<span class="label label-danger"> <i class="fa fa-trash-o"></i> '. $status . '</span>';

        default :
            return '<span class="label label-info"> '. $status . '</span>';
    }
}


function getLoginUserData( $key = ''){
    //key: user_id, user_mail, role_id, name, photo
    $data   =& get_instance();

    //$prefix = $data->config->item('cookie_prefix');

    if (empty($data->input->cookie('fm_login_data', false))) {
        return null;
    }

    $global = json_decode(base64_decode($data->input->cookie('fm_login_data', false)));

    return isset($global->$key) ? $global->$key : null;

    //dd( $data->session->all_userdata() );

    /*
    $array_items = array('username', 'email');
    $data->session->unset_userdata($array_items);
    */
}

// Geting Role name from role ID
function getRoleName($role_id = 0)
{
    $ci = &get_instance();
    $role = $ci->db
        ->select('role_name')
        ->get_where('roles', ['id' => $role_id])
        ->row_array();
    if ($role) {
        return $role['role_name'];
    } else {
        return '<span class="text-red">Unknown</span>';
    }
}

function getSessionUserData( $key = ''){
    if(!empty($_SESSION) && !empty($_SESSION['value'])){
        $session_value = $_SESSION['value'];
    }else{
        $session_value ='';
    }
    $data   =& get_instance();
    $global = json_decode(base64_decode($session_value));

    return isset($global->$key) ? $global->$key : null;

    //dd( $data->session->all_userdata() );

    /*
    $array_items = array('username', 'email');
    $data->session->unset_userdata($array_items);
    */
}


function session(){
    $data   =& get_instance();
    dd( $data );
}

//numeric_dropdown
//numericDropDown(10000,200000, 5000);

function numericDropDown($i=0,$end=12,$incr=1,$selected=0, $descOrder = true){
    $option = '';
    if ($descOrder) {
        for($end; $end >= $i; $end--) {
            //$option .= '<option value="'. sprintf('%02d', $i)  .'"';
            $option .= '<option';
            $option .= ( $selected == $end) ? ' selected' : '';
            $option .= '>'. sprintf('%02d', $end) .'</option>';
        }
    } else {
        for($i; $i <= $end; $i+=$incr) {
            //$option .= '<option value="'. sprintf('%02d', $i)  .'"';
            $option .= '<option';
            $option .= ( $selected == $i) ? ' selected' : '';
            $option .= '>'. sprintf('%02d', $i) .'</option>';
        }
    }

    return $option;
}
function numericDropDownApi($i=0,$end=12,$incr=1,$selected=0){
    $option = [];
    for($i; $i <= $end; $i+=$incr) {
        $option[] =  sprintf('%02d', $i) ;
    }
    return $option;
}

function numericDropDown_li_a($i=0,$end=12,$incr=1,$selected=0, $descOrder = true, $event = ''){
    $option = '';
    if ($descOrder) {
        for($end; $end >= $i; $end--) {
            $active = $selected == $end ? 'active' : '';
            $option .= "<li data-year='$end' class='$active' $event><a href='javascript:void(0)'>";
            $option .= sprintf('%02d', $end) .'</a></li>';
        }
    } else {
        for($i; $i <= $end; $i+=$incr) {
            $active = $selected == $end ? 'active' : '';
            $option .= "<li data-year='$end' class='$active'><a href='javascript:void(0)'>";
            $option .= sprintf('%02d', $end) .'</a></li>';
        }
    }

    return $option;
}

function month_to_li_a($selected = 0, $event = ''){
    $month = array(1 => "Jan",2 => "Feb",3 => "Mar",4 =>"Apr",5 => "May",6 => "Jun",7 => "Jul",8 => "Aug",9 => "Sept",10 => "Oct",11 => "Nov",12 =>"Dec");
    $option = '';
    foreach ($month as $k => $m){
        $active = $selected == $k ? 'active' : '';
        $option .= "<li data-month='$k' class='$active' $event><a href='javascript:void(0)'>";
        $option .= $m .'</a></li>';
    }
    return $option;
}


function week_to_li_a($selected = 0, $event = ''){
    $week = [
        1 => '1st Week',
        2 => '2nd Week',
        3 => '3rd Week',
        4 => '4th Week',
    ];
    $option = '';
    foreach ($week as $k => $m){
        $active = $selected == $k ? 'active' : '';
        $option .= "<li data-week='$k' class='$active' $event><a href='javascript:void(0)'>";
        $option .= $m .'</a></li>';
    }
    return $option;
}


function numericDropDownApi2($i=0,$end=12,$incr=1,$selected=0){
    $option = [];
    for($end; $end <= $i; $i-=$incr) {
        $option[] =  sprintf('%02d', $i) ;
    }
    return $option;
}
function getYearRange($selected=0){
    $option = '';
    for($i=date('Y'); $i >= 1960; $i--) {
        $option .= '<option';
        $option .= ( $selected == $i) ? ' selected' : '';
        $option .= '>'. sprintf('%02d', $i) .'</option>';
    }
    return $option;
}
function getYearRangeApi($selected = 0){

    $year = [];
    for($i=date('Y'); $i >= 1960; $i--) {
        $year[sprintf('%02d', $i)] = sprintf('%02d', $i);
    }
    return $year;
}
function getFirstNameByUserId($id) {
    $CI = &get_instance();
    $user = $CI->db->select('first_name,last_name')->get_where('users', ['id' => $id ])->row();
    if($user){
        return $user->first_name ;
    } else {
        return 'Guest';
    }
}
function getTimeDropDown( $selected='PM' ){
    $times = [
        'AM'  => 'AM',
        'PM'  => 'PM',
    ];

    $row = '';
    foreach ($times as $key=>$option) {
        $row .= '<option value="' . $key . '"';
        $row .= ($selected === $key) ? ' selected' : '';
        $row .= '>' . $option . '</option>' . "\r\n";
    }
    return $row;
}

function minPrice(){
    // 1000000, 10000000, 100000
    $price = [];
    for($i=1000000; $i <= 10000000; $i+=500000) {
        $price[] = $i;
    }
    return $price;
}


function businessHours( $json_string = null ){
    $times = [
        'Monday'    => [
            'selected'       => 'null',
            'open_hh'       => '09',
            'open_mm'       => '15',
            'open_am_pm'    => 'AM',
            'close_hh'       => '08',
            'close_mm'       => '00',
            'close_am_pm'    => 'PM',
        ],

        'Tuesday'   => [
            'selected'       => 'null',
            'open_hh'       => '09',
            'open_mm'       => '00',
            'open_am_pm'    => 'AM',
            'close_hh'       => '08',
            'close_mm'       => '00',
            'close_am_pm'    => 'PM',
        ],

        'Wednesday' => [
            'selected'       => 'null',
            'open_hh'       => '09',
            'open_mm'       => '00',
            'open_am_pm'    => 'AM',
            'close_hh'       => '08',
            'close_mm'       => '00',
            'close_am_pm'    => 'PM',
        ],

        'Thusday'   => [
            'selected'       => 'null',
            'open_hh'       => '09',
            'open_mm'       => '00',
            'open_am_pm'    => 'AM',
            'close_hh'       => '08',
            'close_mm'       => '00',
            'close_am_pm'    => 'PM',
        ],

        'Friday'    => [
            'selected'       => 'null',
            'open_hh'       => '09',
            'open_mm'       => '00',
            'open_am_pm'    => 'AM',
            'close_hh'       => '08',
            'close_mm'       => '00',
            'close_am_pm'    => 'PM',
        ],

        'Saturday'  => [
            'selected'       => 'on',
            'open_hh'           => '09',
            'open_mm'           => '00',
            'open_am_pm'        => 'AM',
            'close_hh'          => '08',
            'close_mm'          => '00',
            'close_am_pm'       => 'PM',
        ],

        'Sunday'    => [
            'selected'       => 'on',
            'open_hh'           => '09',
            'open_mm'           => '00',
            'open_am_pm'        => 'AM',
            'close_hh'          => '08',
            'close_mm'          => '00',
            'close_am_pm'       => 'PM',
        ],
    ];



    if($json_string){
        $times = json_decode($json_string, true );
    }



    $html = '';
    foreach ($times as $day=>$time) {

        $selected = isset($time['selected']) ? $time['selected'] : 'off';
        if($selected == 'off'){
            $checked    = 'checked';
            $hidden     = 'style="opacity:0.2"';
        } else {
            $checked    = '';
            $hidden     = '';
        }

        // dd( $time );

        $html .= '<div class="input-group">
            
            <span class="input-group-addon small"><i class="fa fa-clock-o"></i> '. $day .'</span>
            
            <span class="input-group-addon small_day">                                    
                <label> <input type="checkbox" name="'. $day .'" onclick="isCheck(\''. $day . '\' );" '. $checked .'> Day Off</label>                
            </span>
            

            <div class="col-md-6 no-padding">
                <div class="row no-margin '. $day .'" '. $hidden.' >
                    <div class="col-sm-4 no-padding">
                        <select name="'. $day .'_open_hh" class="form-control">
                            '.  numericDropDown(0, 12, 1, $time['open_hh']) .'
                        </select></div>  
                    <div class="col-sm-4 no-padding">
                        <select name="'. $day .'_open_mm" class="form-control">
                            '.  numericDropDown(0, 45, 15, $time['open_mm'])  .'
                        </select>
                    </div>
                    <div class="col-sm-4 no-padding">
                        <select name="'. $day .'_open_am_pm" class="form-control">
                           '.  getTimeDropDown(  $time['open_am_pm'] )  .'
                        </select>
                    </div>
                </div>

            </div>


            <div class="col-md-6" style="padding-right:0">
               <div class="row no-margin '. $day .'" '. $hidden.'>
                    <div class="col-sm-4 no-padding">
                        <select name="'. $day .'_close_hh" class="form-control">
                           '.  numericDropDown(0, 12, 1, $time['close_hh'])  .'
                        </select></div>  
                    <div class="col-sm-4 no-padding">
                        <select name="'. $day .'_close_mm" class="form-control">
                            '.  numericDropDown(0, 45, 15, $time['close_mm'])   .'
                        </select>
                    </div>
                    <div class="col-sm-4 no-padding">
                        <select name="'. $day .'_close_am_pm" class="form-control">
                            '.  getTimeDropDown( $time['close_am_pm']) .'
                        </select>
                    </div>
                </div>
            </div>


        </div>';

    }
    return $html;
}

function newBusinessHours( $json_string = null ){
    $times = [
        'Monday'    => [
            'selected'       => 'null',
            'open_hh'       => '09',
            'open_mm'       => '15',
            'open_am_pm'    => 'AM',
            'close_hh'       => '08',
            'close_mm'       => '00',
            'close_am_pm'    => 'PM',
        ],

        'Tuesday'   => [
            'selected'       => 'null',
            'open_hh'       => '09',
            'open_mm'       => '00',
            'open_am_pm'    => 'AM',
            'close_hh'       => '08',
            'close_mm'       => '00',
            'close_am_pm'    => 'PM',
        ],

        'Wednesday' => [
            'selected'       => 'null',
            'open_hh'       => '09',
            'open_mm'       => '00',
            'open_am_pm'    => 'AM',
            'close_hh'       => '08',
            'close_mm'       => '00',
            'close_am_pm'    => 'PM',
        ],

        'Thusday'   => [
            'selected'       => 'null',
            'open_hh'       => '09',
            'open_mm'       => '00',
            'open_am_pm'    => 'AM',
            'close_hh'       => '08',
            'close_mm'       => '00',
            'close_am_pm'    => 'PM',
        ],

        'Friday'    => [
            'selected'       => 'null',
            'open_hh'       => '09',
            'open_mm'       => '00',
            'open_am_pm'    => 'AM',
            'close_hh'       => '08',
            'close_mm'       => '00',
            'close_am_pm'    => 'PM',
        ],

        'Saturday'  => [
            'selected'       => 'on',
            'open_hh'           => '09',
            'open_mm'           => '00',
            'open_am_pm'        => 'AM',
            'close_hh'          => '08',
            'close_mm'          => '00',
            'close_am_pm'       => 'PM',
        ],

        'Sunday'    => [
            'selected'       => 'on',
            'open_hh'           => '09',
            'open_mm'           => '00',
            'open_am_pm'        => 'AM',
            'close_hh'          => '08',
            'close_mm'          => '00',
            'close_am_pm'       => 'PM',
        ],
    ];



    if($json_string){
        $times = json_decode($json_string, true );
    }



    $html = '';
    foreach ($times as $day=>$time) {

        $selected = isset($time['selected']) ? $time['selected'] : 'off';
        if($selected == 'off'){
            $checked    = 'checked';
            $hidden     = 'style="opacity:0.2"';
        } else {
            $checked    = '';
            $hidden     = '';
        }

        $html .= '<li class="business-hour-item">
                        <div class="business-hour-left">
                             <span class="day">'. $day .'</span>
                             <span class="check">
                                  <input class="styled-checkbox" type="checkbox" id="'. $day . '" name="'. $day .'" onclick="isCheck(\''. $day . '\' );" '. $checked .'>
                                  <label for="'. $day . '">Day off</label>
                             </span>
                        </div>
                        <div class="business-hour-middle" '. $hidden.'>
                             <div class="dropper"></div>
                              <select name="'. $day .'_open_hh">
                                   '.  numericDropDown(0, 12, 1, $time['open_hh']) .'
                              </select>
                              <select name="'. $day .'_open_mm">
                                   '.  numericDropDown(0, 45, 15, $time['open_mm'])  .'
                              </select>
                              <select name="'. $day .'_open_am_pm">
                                   '.  getTimeDropDown(  $time['open_am_pm'] )  .'
                              </select>
                        </div>
                        <div class="business-hour-bottom business-hour-middle" '. $hidden.'>
                           <div class="dropper"></div>
                            <select name="'. $day .'_close_hh">
                                 '.  numericDropDown(0, 12, 1, $time['close_hh'])  .'
                            </select>
                            <select name="'. $day .'_close_mm">
                                 '.  numericDropDown(0, 45, 15, $time['close_mm'])   .'
                            </select>
                            <select name="'. $day .'_close_am_pm">
                                 '.  getTimeDropDown( $time['close_am_pm']) .'
                            </select>
                        </div>
                  </li>';

    }
    return $html;
}


function getBusinessHours( $json_string = null ){
    $html = '';

    if($json_string){

        $array = json_decode($json_string);
        $html .= '<ul class="business-hour-list">';
        foreach($array as $day => $times ){
            $html .= '<li>';
            $html .= '<span>'. $day .'</span>';
            $html .= '<span>' . formatTimes( $times )  .'</span>';
            $html .= '</li>';
        }

        $html .= '</ul>';



    } else {
        $html .= '<div style="padding:15px;">Business Hour Not Set</div>';
    }




    return $html;
}


function formatTimes( $times ){

    if($times->selected == 'off'){
        return '<span style="color:#f05c26;">Close</span>';
    } else{
        $open =  $times->open_hh .':'.  $times->open_mm .' '.  $times->open_am_pm;
        $close =  $times->close_hh .':'.  $times->close_mm .' '.  $times->close_am_pm;

        return $open .' - '. $close;
    }
}







function ageDropDown($i=0,$end=12,$incr=1,$selected=0){
    $option = '';
    for($i; $i <= $end; $i+=$incr) {
        $option .= '<option value="'. sprintf('%02d', $i)  .'"';
        $option .= ( $selected == $i) ? ' selected' : '';
        $option .= '>'. sprintf('%02d', $i) .' Years</option>';
    }
    return $option;
}

function getPriceDropDown($i=0,$end=12,$incr=1,$selected=0, $first = 0 ){
    $option = '';

    if($first){
        $option .= '<option value="'. $first .'"';
        $option .= ( $selected == $first ) ? ' selected' : '';
        $option .= '>&#x20A6; '. number_format($first, 0 ) .'  &nbsp;</option>';
    }

    for($i; $i <= $end; $i+=$incr) {
        $option .= '<option value="'. $i .'"';
        $option .= ( $selected == $i) ? ' selected' : '';
        $option .= '>&#x20A6; '. number_format($i, 0 ) .' &nbsp;</option>';
    }
    return $option;
}

function getTradeorPrivate($selected = 0){

    $types = [
        '0'         => '--Any--',
        'Personal'  => 'Private',
        'Business'  => 'Trade',
    ];

    $row = '';
    foreach ($types as $key=>$option) {
        $row .= '<option value="' . $key . '"';
        $row .= ($selected === $key) ? ' selected' : '';
        $row .= '>' . $option . '</option>' . "\r\n";
    }
    return $row;
}


function htmlRadio($name = 'input_radio', $selected = '', $array = ['Male' => 'Male', 'Female' => 'Female' ], $class = ''){
    $radio      = '';
    $id         = 0;

    if(count($array)){
        foreach($array as $key=>$value ){
            $id++;
            $radio .= '<label>';
            $radio .= '<input type="radio" class="'.$class.'" name="'.$name.'" id="'.$name .'_'. $id.'"';
            $radio .= ( $selected == $key) ? ' checked ' : '';
            $radio .= 'value="'. $key .'" /> ' . $value;
            $radio .= '&nbsp;&nbsp;&nbsp;</label>';
        }
    }
    return $radio;
}


/*
 * We will use it into header.php or footer.php or any view page
 * to load module wise css or js file
 */
function load_module_asset( $module = null, $type = 'css', $script = null ){

    $file = ($type == 'css') ? 'style.css.php' : 'script.js.php';
    if($script){ $file = $script; }

    $path = APPPATH . '/modules/'. $module . '/assets/' . $file;
    if( $module && file_exists( $path )){ include ($path); }
}

function load_new_module_asset( $module = null, $file = ''){
    $path = APPPATH . '/modules/'. $module . '/assets/' . $file;

    if( $module && file_exists( $path )){ include ($path); }
}

//$limit    = 2;
//$start    = getPaginatorStart($limit);
//showPaginator($total_rows, 'admin.php?page=list&p', $limit);


function startPointOfPagination($limit=25,$page=0){
    return ($page) ? ($page - 1) * $limit : 0;
}


function getPaginator($total_row = 100, $currentPage = 2, $targetpath = '#&p', $limit=25){

    $stages 	= 2;
    $page 		= intval($currentPage);
    $start 		= ($page) ? ($page - 1) * $limit : 0;

    // Initial page num setup
    $page 		= ($page == 0) ? 1 : $page;
    $prev 		= $page - 1;
    $next 		= $page + 1;
    $lastpage 	= ceil($total_row/$limit);
    $LastPagem1     = $lastpage - 1;
    $paginate 	= '';

    if($lastpage > 1){
        $paginate .= '<div class="row">';
        $paginate .= '<div class="col-md-12">';
        $paginate .= '<ul class="pagination low-margin">';
        $paginate .= '<li class="disabled"><a>Total: '. $total_row.'</a></li>';
        // Previous
        $paginate .= ($page > 1)
            ? "<li><a href='$targetpath=$prev'>&lt; Pre</a></li>"
            : "<li class='disabled'><a> &lt; Pre</a></li>";
        // Pages
        if ($lastpage < 7 + ($stages * 2)){
            for ($counter = 1; $counter <= $lastpage; $counter++){
                $paginate .= ($counter == $page)
                    ? "<li class='active'><a>$counter</a></li>"
                    : "<li><a href='$targetpath=$counter'>$counter</a></li>";
            }
        } elseif($lastpage > 5 + ($stages * 2)){
            // Beginning only hide later pages
            if($page < 1 + ($stages * 2)){
                for ($counter = 1; $counter < 4 + ($stages * 2); $counter++){
                    $paginate .= ($counter == $page)
                        ? "<li class='active'><a>$counter</a></li>"
                        : "<li><a href='$targetpath=$counter'>$counter</a></li>";
                }
                $paginate.= "<li class='disabled'><span class=\"material-icons\">
                                        more_horiz
                                    </span></li>";
                $paginate.= "<li><a href='$targetpath=$LastPagem1'>$LastPagem1</a></li>";
                $paginate.= "<li><a href='$targetpath=$lastpage'>$lastpage</a></li>";
            }

            // Middle hide some front and some back
            elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2)){
                $paginate.= "<li><a href='$targetpath=1'>1</a></li>";
                $paginate.= "<li><a href='$targetpath=2'>2</a></li>";
                $paginate.= "<li><span class=\"material-icons\">
                                        more_horiz
                                    </span></li>";
                for ($counter = $page - $stages; $counter <= $page + $stages; $counter++){
                    $paginate .= ($counter == $page)
                        ? "<li class='active'><a>$counter</a></li>"
                        : "<li><a href='$targetpath=$counter'>$counter</a></li>";
                }
                $paginate.= "<li><span class=\"material-icons\">
                                        more_horiz
                                    </span></li>";
                $paginate.= "<li><a href='$targetpath=$LastPagem1'>$LastPagem1</a></li>";
                $paginate.= "<li><a href='$targetpath=$lastpage'>$lastpage</a><li>";
            } else {
                // End only hide early pages
                $paginate.= "<li><a href='$targetpath=1'>1</a></li>";
                $paginate.= "<li><a href='$targetpath=2'>2</a></li>";
                $paginate.= "<li><span class=\"material-icons\">
                                        more_horiz
                                    </span></li>";

                for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++){
                    $paginate .=  ($counter == $page)
                        ? "<li class='active'><a>$counter</a></li>"
                        : "<li><a href='$targetpath=$counter'>$counter</a></li>";
                }
            }
        }

        // Next
        $paginate .= ($page < $counter - 1)
            ? "<li><a href='$targetpath=$next'>Next &gt;</a></li>"
            : "<li class='disabled'><a>Next &gt;</a></li>";

        $paginate .= "</ul>";
        $paginate .= "<div class='clearfix'></div>";
        $paginate .= "</div>";
        $paginate .= "</div>";
    }

    return $paginate;

}


/**
 * @param int $total_row
 * @param int $currentPage
 * @param string $targetpath
 * @param int $limit
 * @return string
 */
function getAjaxPaginator($total_row = 100, $currentPage = 2, $targetpath = '#&p', $limit=25){


    //$page         = 2; //isset($_GET['p']) ? intval($_GET['p']) : 0;
    //$page         = intval($currentPage);

    $stages 	= 1; // 0, 1, 2
    $page 		= intval($currentPage);
    $start 		= ($page) ? ($page - 1) * $limit : 0;

    // Initial page num setup
    $page 		= ($page == 0) ? 1 : $page;
    $prev 		= $page - 1;
    $next 		= $page + 1;
    $lastpage 	= ceil($total_row/$limit);
    $LastPagem1     = $lastpage - 1;
    $paginate 	= '';

    if($lastpage > 1){
        $paginate .= '<div class="col-12" style="padding: 0px">';
        $paginate .= '<ul class="pagination-wrap">';
//        $paginate .= '<li class="disabled"><a>Total: '. $total_row.'</a></li>';
        // Previous
        $paginate .= ($page > 1)
            ? "<li class='prev'><a href='$targetpath=$prev'><i class='fa fa-angle-left'></i></a></li>"
            : "<li class='disabled prev'><a><i class='fa fa-angle-left'></i></a></li>";
        // Pages
        if ($lastpage < 7 + ($stages * 2)){
            for ($counter = 1; $counter <= $lastpage; $counter++){
                $paginate .= ($counter == $page)
                    ? "<li ><a class='active'>$counter</a></li>"
                    : "<li><a href='$targetpath=$counter'>$counter</a></li>";
            }
        } elseif($lastpage > 5 + ($stages * 2)){
            // Beginning only hide later pages
            if($page < 1 + ($stages * 2)){
                for ($counter = 1; $counter < 4 + ($stages * 2); $counter++){
                    $paginate .= ($counter == $page)
                        ? "<li ><a class='active'>$counter</a></li>"
                        : "<li><a href='$targetpath=$counter'>$counter</a></li>";
                }
                $paginate.= "<li class='disabled'><span class=\"material-icons\">
                                        more_horiz
                                    </span></li>";
                $paginate.= "<li><a href='$targetpath=$LastPagem1'>$LastPagem1</a></li>";
                $paginate.= "<li><a href='$targetpath=$lastpage'>$lastpage</a></li>";
            }

            // Middle hide some front and some back
            elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2)){
                $paginate.= "<li><a href='$targetpath=1'>1</a></li>";
                //  $paginate.= "<li><span onclick='getResult(\"$targetpath=2\");'>2</a></li>";
                $paginate.= "<li><span class=\"material-icons\">
                                        more_horiz
                                    </span></li>";
                for ($counter = $page - $stages; $counter <= $page + $stages; $counter++){
                    $paginate .= ($counter == $page)
                        ? "<li ><a class='active'>$counter</a></li>"
                        : "<li><a href='$targetpath=$counter'>$counter</a></li>";
                }
                $paginate.= "<li><span class=\"material-icons\">
                                        more_horiz
                                    </span></li>";
                $paginate.= "<li><a href='$targetpath=$LastPagem1'>$LastPagem1</a></li>";
                $paginate.= "<li><a href='$targetpath=$lastpage'>$lastpage</a><li>";
            } else {
                // End only hide early pages
                $paginate.= "<li><a href='$targetpath=1'>1</a></li>";
                $paginate.= "<li><a href='$targetpath=2'>2</a></li>";
                $paginate.= "<li><span class=\"material-icons\">
                                        more_horiz
                                    </span></li>";

                for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++){
                    $paginate .=  ($counter == $page)
                        ? "<li ><a class='active'>$counter</a></li>"
                        : "<li><a href='$targetpath=$counter'>$counter</a></li>";
                }
            }
        }

        // Next
        $paginate .= ($page < $counter - 1)
            ? "<li class='next'><a href='$targetpath=$next'><i class='fa fa-angle-right'></i></a></li>"
            : "<li class='disabled next'><a><i class='fa fa-angle-right'></i></a></li>";

        $paginate .= "</ul>";
        $paginate .= "</div>";
    }

    return $paginate;

}


function ageCalculator( $date = null ){
    if($date){
        $tz  = new DateTimeZone('Europe/London');
        $age = DateTime::createFromFormat('Y-m-d', $date, $tz)
            ->diff(new DateTime('now', $tz))
            ->y;
        return $age . ' years';
    } else {
        return 'Unknown';
    }
}

function sinceCalculator( $date = null ){

    if($date){

        $date = date('Y-m-d', strtotime($date));
        $tz  = new DateTimeZone('Europe/London');
        $age = DateTime::createFromFormat('Y-m-d', $date, $tz)
            ->diff(new DateTime('now', $tz));

        $result = '';
        $result .= ($age->y) ? $age->y . 'y ' : '';
        $result .= ($age->m) ? $age->m . 'm ' : '';
        $result .= ($age->d) ? $age->d . 'd ' : '';
        $result .= ($age->h) ? $age->h . 'h ' : '';
        return $result;

    } else {
        return 'Unknown';
    }
}


function password_encription( $string = ''){

    return password_hash( $string, PASSWORD_BCRYPT);
}




function initGoogleMap( $lat = 0, $lng = 0, $divID = 'map-container', $title = 'Not Defiend' ){
    $script = '';
    if($lat && $lng){

        $script .= '<div style="height: 280px;" id="'. $divID .'"></div>' . "\r\n";

        $script .= <<<EOT
            <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBOKy0BTRCMXke5lOw6YhaPmVy4L8d1xq0"></script> 
            <script type="text/javascript">
            function init_map() {
                var var_location = new google.maps.LatLng($lat, $lng);

                var var_mapoptions = {
                    center: var_location,
                    zoom: 14
                };

                var var_marker = new google.maps.Marker({
                    position: var_location,
                    map: var_map,
                    title: "$title"});

                var var_map = new google.maps.Map(document.getElementById("$divID"),
                        var_mapoptions);
                var_marker.setMap(var_map);
            }

            google.maps.event.addDomListener(window, 'load', init_map);
        </script>        
EOT;

    } else {
        $script .= '<noscript> Lat, and lng are empty </noscript>';
        $script .= $title;
    }

    return $script;

}


function get_admin_email(){
    return getSettingItem( 'IncomingEmail');
}


function getSettingItem( $setting_key = null ){
    $ci      =& get_instance();
    $setting = $ci->db->get_where('settings', ['label' => $setting_key ])->row();
    return isset($setting->value) ? $setting->value : false;
}

function getUserDataByUserId($user_id = '', $fild_name = 0) {
    $CI = & get_instance();
    $data = $CI->db->select($fild_name)
        ->get_where('users', ['id' => $user_id])
        ->row();
    return ($data) ? $data->$fild_name : null;
}

function getUserNameByUserId($id) {
    $CI = &get_instance();
    $user = $CI->db->select('first_name,last_name')->get_where('users', ['id' => $id ])->row();
    if($user){
        return $user->first_name .' '. $user->first_name;
    } else {
        return 'Unknown';
    }
}





// API  helper

function json_output($statusHeader, $response = array()){
    $ci =& get_instance();
    $ci->output
        ->set_status_header($statusHeader)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT ));
    // ->_display();
}

function json_output_display($statusHeader, $response = array()){
    $ci =& get_instance();
    $ci->output
        ->set_status_header($statusHeader)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT ))
        ->_display();
}

function make_token($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return base64_encode(hash_hmac('sha256', $randomString, $characters));
//    return $randomString;
}

function is_token_match($user_id =0, $token = null) {

    if (empty($token)) {
        $res = [
            'status' => 0,
            'message' => 'Failed, token mismatch, please try again',
        ];
        json_output_display(200, $res);
        exit();
    }

    $ci = & get_instance();
    $user = $ci->db->select('*')
        ->where('token', $token)
        ->get('user_tokens')->row();

    if(empty($user)){
        $res = [
            'status' => 0,
            'message' => 'Failed, token mismatch, please try again',
        ];
        json_output_display(200, $res);
        exit();
    }

}

function next_page_url($page, $limit, $total) {
    $current_page = ($page <= 0) ? 1 : $page;
    $next = $current_page + 1;
    $last = ceil($total / $limit);
    return ($current_page >= $last) ? null : "p={$next}";
}

function build_pagination_url( $link = 'search', $page = 'page' ){
    $array = $_GET;
    $url = $link . '?';
    unset($array[$page]);
    unset($array['_']);

    if($array){
        $url .= \http_build_query($array);
    }
    $url .= "&{$page}";
    return $url;
}

function get_brand_by_id($id) {
    $CI = & get_instance();
    $brand_id = intval($id);
    if ($result = $CI->db->select('name')->from('brands')->where('id ', $brand_id)->get()->row()) {
        return $result->name;
    }
    return "No Data";
}

function get_brand_by_id_multiple($brand_id) {
    $CI = & get_instance();
    $brand_id = explode(',',$brand_id);
    if ($result = $CI->db->select('name')->from('brands')->where_in('id ', $brand_id)->get()->result()) {
        $name = [];
        foreach ($result as $r){
            $name[] = $r->name;
        }
        return implode(',',$name);
    }
    return "No Data";
}

function get_model_name_by_id($model_id = null, $parent_id = null) {
    $CI = & get_instance();
    $color_id = intval($model_id);
    if ($result = $CI->db->select('name')->from('brands')->where('parent_id ', $parent_id)->where('id ', $model_id)->get()->row()) {
        return $result->name;
    }
    return "No Data";
}
function get_model_name_by_id_multiple($model_id = null, $parent_id = null) {
    $CI = & get_instance();
    $model_id = explode(',',$model_id);
    $parent_id = explode(',',$parent_id);
    if ($result = $CI->db->select('name')->from('brands')->where_in('parent_id ', $parent_id)->where_in('id ', $model_id)->get()->result()) {
        $name = [];
        foreach ($result as $r){
            $name[] = $r->name;
        }
        return implode(',',$name);
    }
    return "No Data";
}
function mail_footer() {
    $email= get_admin_email();
    $html =  '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>

                <table border="0" cellpadding="0" cellspacing="0" id="email-footer"
                    style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;background: #1b1b1b;padding: 20px 40px;border-top: 1px solid #fff;">
                    <tr>
                        <td align="right">
                            <!-- email-footer-top start -->
                            <table class="email-footer-top" border="0" cellpadding="0" cellspacing="0"
                                style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;padding-bottom: 15px;border-bottom: 1px solid #333;margin-bottom: 15px;">
                                <tr>
                                    <td id="footer-logo">
                                        <img width="220px" src="'.base_url('assets/theme/new/images/backend/email/logo.png').'" alt="logo">
                                    </td>
                                    <td align="right">
                                        <p style="color: #fff;">You can be part of our journey.</p>
                                    </td>
                                </tr>
                            </table>
                    
                            <table class="email-footer-bottom" border="0" cellpadding="0" cellspacing="0"
                                style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
                                <tr>
                                    <td><strong
                                            style="color: #f05c26;text-transform: uppercase;font-size: 16px; letter-spacing: 2px;">JOIN
                                            NOW!</strong>
                                    </td>
                                    <td align="right">
                                        <a style="color: #fff;"
                                            href="mailto:'.$email.'">'.$email.'</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>

</html>';

    return $html;
}

function mail_header($title="Welcome to CarQuest") {

    $html = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email template</title>
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
        rel="stylesheet">
    <style>
    body {
        font-family: "Roboto", sans-serif;
        }

        @media only screen and (max-width: 480px) {}
    </style>
</head>

<body bgcolor="#ffffff" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">

    <table border="0" cellpadding="0" cellspacing="0" id="emailContainer"
        style="max-width:800px;width:800px;margin:0 auto;" bgcolor="#f6f6fc">
        <tr>
            <td align="center" valign="top" id="emailContainerCell">

                <table border="0" cellpadding="0" cellspacing="0" id="email-header-bottom"
                    style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;background: #011a39; padding: 15px 40px;">
                    <tr>
                        <td id="main-logo">
                            <img width="220px" src="'.base_url('assets/theme/new/images/backend/email/logo.png').'" alt="logo">
                        </td>
                        <td align="right">
                            <ul style="list-style: none;margin: 0;padding: 0;">
                                <li style="display: inline-block;margin-right: 15px;"><a href="https://facebook.com/"><img
                                            src="'.base_url('assets/theme/new/images/backend/email/facebook.png').'" alt="facebook"></a></li>
                                <li style="display: inline-block;margin-right: 15px;"><a href="https://twitter.com/"><img src="'.base_url('assets/theme/new/images/backend/email/twitter.png').'"
                                            alt="twitter"></a></li>
                                <li style="display: inline-block;"><a href="https://www.instagram.com/"><img src="'.base_url('assets/theme/new/images/backend/email/instagram.png').'"
                                            alt="instagram"></a></li>
                            </ul>
                        </td>
                    </tr>
                </table>
            
                <table border="0" cellpadding="0" cellspacing="0" style="margin: 60px 30px; background: #f5f5f5;">
                    <tr>
                        <td colspan="5">
                            <table border="0" cellpadding="0" cellspacing="0"
                                style="width: 700px;background: #fff; border-radius: 10px; padding: 30px;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h2 style="color: #f05c26;font-size: 35px; margin-top: 0; margin-bottom: 30px;">'
        .$title.'</h2>';

    return $html;
}

function getUserDataById($id) {
    $CI = &get_instance();
    $user = $CI->db->get_where('users', ['id' => $id ])->row();

    return $user;
}

function create_search_tags($page_url = null)
{
    $CI = &get_instance();
    $tags = [
        'address' => [
            'tbl' => 'post_area',
            'value' => $CI->input->get('address'),
            'lebel' => 'Address: '
        ],
        'gear_box' => [
            'tbl' => 'no-tbl',
            'value' =>  $CI->input->get('gear_box'),
            'lebel' => 'Gear box: '
        ],
        'seller' => [
            'tbl' => 'no-tbl',
            'value' =>  $CI->input->get('seller'),
            'lebel' => $CI->input->get('seller').' Seller'
        ],
        'color_id' => [
            'tbl' => 'color',
            'col' => 'color_name',
            'lebel' => 'Colour: '
        ],
        'condition' => [
            'tbl' => 'no-tbl',
            'value' =>  $CI->input->get('condition'),
            'lebel' => 'Condition: '
        ],
        'fuel_type' => [
            'tbl' => 'fuel_types',
            'col' => 'fuel_name',
            'lebel' => 'Fuel Type: '
        ],
        'price_from' => [
            'tbl' => 'range',
            'value' => '',
            'lebel' => ((($CI->input->get('price_from') > 0) ?  '&#x20A6;'.( $CI->input->get('price_from')) : '')),
        ],
        'price_to' => [
            'tbl' => 'range',
            'value' => '',
            'lebel' => ((($CI->input->get('price_from') > 0) ?  ' - ' : '')) . '&#x20A6;'.( $CI->input->get('price_to'))
        ],
        'from_year' => [
            'tbl' => 'range',
            'value' => '',
            'lebel' => $CI->input->get('from_year') . (($CI->input->get('to_year') == 0) ? '' : ' - ' .  $CI->input->get('to_year')),
        ],
        'model_id' => [
            'tbl' => 'brands',
            'col' => 'name',
            'lebel' => 'Model: '
        ],
        'brand_id' => [
            'tbl' => 'brands',
            'col' => 'name',
            'lebel' => 'Brand: '
        ],

        'body_type' => [
            'tbl' => 'body_types',
            'col' => 'type_name',
            'lebel' => 'Body Type: '
        ],

        'engine_size' => [
            'tbl' => 'engine_sizes',
            'col' => 'engine_size',
            'lebel' => 'Eng.Size: '
        ],

        'parts_id' => [
            'tbl' => 'parts_description',
            'col' => 'name',
            'lebel' => 'Parts Description: '
        ],
        'mileage_from' => [
            'tbl' => 'range',
            'value' => '',
            'lebel' => 'Mileage: ' . ( $CI->input->get('mileage_from')) . ' - ' . ( $CI->input->get('mileage_to'))
        ],
        'wheelbase' => [
            'tbl' => 'no-tbl',
            'value' =>  $CI->input->get('wheelbase'),
            'lebel' => 'Wheelbase: '
        ],
        'year' => [
            'tbl' => 'no-tbl',
            'value' =>  $CI->input->get('year'),
            'lebel' => 'Manufacture year: '
        ],
        'type_id' => [
            'tbl' => 'vehicle_types',
            'col' => 'name',
            'lebel' => 'Vehicle Type: '
        ],
    ];

    $html = '';
    foreach ($tags as $key => $attr) {
        $id =  $CI->input->get($key);
        if ($id) {
            if ($key == 'color_id' ||$key == 'fuel_type' || $key == 'location_id' || $key == 'brand_id' || $key == 'model_id'|| $key == 'type_id') {
                $html .= getName($attr['tbl'], $attr['col'], $id, $attr['lebel']);
            } else if ($key == 'address' || $key == 'gear_box'||$key == 'condition') {
                $html .= $attr['value']." ";
            } else if ($key == 'price_from' || $key == 'price_to' || $key == 'from_year'|| $key == 'seller') {
                $html .= $attr['lebel']." ";
            };
        }
    }

    if ($html == '') {
        $html .= 'Latest vehicles for sale news & Used cars';
    } else {
        $html .= ' for Sale ';

        $id =  $CI->input->get('location_id');
        if ($id) {
            $html .= 'in '.getName('post_area', 'name', $id, 'Area');
        } else {
            $html .= '';
        }
    }

    return $html;
}

function create_search_auto($page_url = null)
{
    $CI = &get_instance();
    $tags = [
        'service' => [
            'tbl' => 'post_area',
            'value' => $CI->input->get('service'),
            'lebel' => 'Service: '
        ],
        'address' => [
            'tbl' => 'post_area',
            'value' => $CI->input->get('address'),
            'lebel' => 'Address: '
        ],
        'repair_type' => [
            'tbl' => 'repair_types',
            'col' => 'title',
            'lebel' => 'Repair Type: '
        ],
        'brand_id' => [
            'tbl' => 'brands',
            'col' => 'name',
            'lebel' => 'Brand: '
        ],
        'parts_for' => [
            'tbl' => 'vehicle_types',
            'col' => 'name',
            'lebel' => 'Vehicle Type: '
        ],
        'specialist' => [
            'tbl' => 'specialism',
            'col' => 'title',
            'lebel' => 'Specialist: '
        ],
    ];

    $html = '';
    foreach ($tags as $key => $attr) {
        $id =  $CI->input->get($key);
        if ($id) {
            if ($key == 'repair_type' ||$key == 'parts_for' || $key == 'location_id' || $key == 'brand_id' || $key == 'specialist'|| $key == 'type_id') {
                $html .= getName($attr['tbl'], $attr['col'], $id, $attr['lebel']);
            } else if ($key == 'address' || $key == 'service'||$key == 'condition') {
                $html .= $attr['value']." ";
            } else if ($key == 'price_from' || $key == 'price_to' || $key == 'from_year'|| $key == 'seller') {
                $html .= $attr['lebel']." ";
            };
        }
    }

    if ($html == '') {
        $html .= 'Vehicles';
    }

    $html .= ' Auto Mechanics ';
    $id =  $CI->input->get('location_id');
    if ($id) {
        $html .= 'in '.getName('post_area', 'name', $id, 'Area');
    } else {
        $html .= '';
    }

    return $html;
}

function create_search_parts($page_url = null)
{
    $CI = &get_instance();
    $tags = [
        'price_from' => [
            'tbl' => 'range',
            'value' => '',
            'lebel' => ((($CI->input->get('price_from') > 0) ?  '&#x20A6;'.( $CI->input->get('price_from')) : '')),
        ],
        'price_to' => [
            'tbl' => 'range',
            'value' => '',
            'lebel' => ((($CI->input->get('price_from') > 0) ?  ' - ' : '')) . '&#x20A6;'.( $CI->input->get('price_to'))
        ],
        'condition' => [
            'tbl' => 'no-tbl',
            'value' =>  $CI->input->get('condition'),
            'lebel' => 'Condition: '
        ],
        'address' => [
            'tbl' => 'post_area',
            'value' => $CI->input->get('address'),
            'lebel' => 'Address: '
        ],
        'from_year' => [
            'tbl' => 'range',
            'value' => '',
            'lebel' => $CI->input->get('from_year') . (($CI->input->get('to_year') == 0) ? '' : ' - ' .  $CI->input->get('to_year')),
        ],
        'category_id' => [
            'tbl' => 'parts_categories',
            'col' => 'category',
            'lebel' => 'Parts Category: '
        ],
        'model_id' => [
            'tbl' => 'brands',
            'col' => 'name',
            'lebel' => 'Model: '
        ],
        'brand_id' => [
            'tbl' => 'brands',
            'col' => 'name',
            'lebel' => 'Brand: '
        ],
        'parts_description' => [
            'tbl' => 'parts_description',
            'col' => 'name',
            'lebel' => 'Parts Description: '
        ],
        'parts_for' => [
            'tbl' => 'vehicle_types',
            'col' => 'name',
            'lebel' => 'Vehicle Type: '
        ],
    ];

    $html = '';
    foreach ($tags as $key => $attr) {
        $id =  $CI->input->get($key);
        if ($id) {
            if ($key == 'parts_description' ||$key == 'category_id' || $key == 'location_id' || $key == 'brand_id' || $key == 'model_id'|| $key == 'parts_for') {
                $html .= getName($attr['tbl'], $attr['col'], $id, $attr['lebel']);
            } else if ($key == 'address'||$key == 'condition') {
                $html .= $attr['value']." ";
            } else if ($key == 'price_from' || $key == 'price_to' || $key == 'from_year'|| $key == 'seller') {
                $html .= $attr['lebel']." ";
            };
        }
    }
    if ($html == '') {
        $html .= 'Vehicles';
    }
    $html .= ' Spareparts for Sale ';
    $id =  $CI->input->get('location_id');
    if ($id) {
        $html .= 'in '.getName('post_area', 'name', $id, 'Area');
    } else {
        $html .= '';
    }

    return $html;
}

function create_search_towing($page_url = null)
{
    $CI = &get_instance();
    $tags = [
        'address' => [
            'tbl' => 'post_area',
            'value' => $CI->input->get('address'),
            'lebel' => 'Address: '
        ],
        'availability' => [
            'tbl' => 'post_area',
            'value' => $CI->input->get('availability'),
            'lebel' => 'Availability: '
        ],
        'brand_id' => [
            'tbl' => 'brands',
            'col' => 'name',
            'lebel' => 'Brand: '
        ],
        'vehicle_type' => [
            'tbl' => 'vehicle_types',
            'col' => 'name',
            'lebel' => 'Vehicle Type: '
        ],
        'type_of_service' => [
            'tbl' => 'towing_categories',
            'col' => 'name',
            'lebel' => 'Type of Service: '
        ],
        'towing_service_id' => [
            'tbl' => 'towing_categories',
            'col' => 'name',
            'lebel' => 'Type of Service: '
        ],
    ];

    $html = '';
    foreach ($tags as $key => $attr) {
        $id =  $CI->input->get($key);
        if ($id) {
            if ($key == 'parts_description' ||$key == 'vehicle_type' || $key == 'location_id' || $key == 'brand_id' || $key == 'type_of_service'|| $key == 'towing_service_id') {
                $html .= getName($attr['tbl'], $attr['col'], $id, $attr['lebel']);
            } else if ($key == 'address'||$key == 'condition'||$key == 'availability') {
                $html .= $attr['value']." ";
            } else if ($key == 'price_from' || $key == 'price_to' || $key == 'from_year'|| $key == 'seller') {
                $html .= $attr['lebel']." ";
            };
        }
    }

    if ($html == '') {
        $html .= 'Vehicles';
    }

    $html .= ' Towing Service ';
    $id =  $CI->input->get('location_id');
    if ($id) {
        $html .= 'in '.getName('post_area', 'name', $id, 'Area');
    } else {
        $html .= '';
    }

    return $html;
}

function getName($table = '', $column = '', $id = 0, $tag = 'Tag: ')
{
    $CI = &get_instance();
    $result =  $CI->db->select($column)->get_where($table, ['id' => $id])->row();
    $html = isset($result->$column) ? $result->$column.' ' : '';

    return $html;
}

function getNewBusinessPageURL( $id ){
    $ci =& get_instance();
    $page = $ci->db->get_where('cms', ['user_id' => $id, 'post_type' => 'business'])->row();

    if($page){
        return '<a target="_blank" href="' .$page->post_url . '" class="preview">View Page</a>';
    } else {
        return '<a href="javascript::void(0)" class="preview" data-toggle="tooltip" title="Please enter your company name, Seller Page URL, logo, business hours, location to complete the page."> Page Incomplete <sup>*</sup></a>';
    }

}

function set_no_data($field, $variable){
    return isset($variable) ? (isset($variable->$field) ? $variable->$field : 'No Data') : '';
}

function ddd($variable){
    echo '<pre>';
        print_r($variable);
    echo "</pre>";
    die();
}

function apiResponse($data = [], $code = 200)
{
    $CI = &get_instance();

    return $CI->output
        ->set_content_type('application/json')
        ->set_status_header($code)
        ->set_output(json_encode($data));
}

function next_page_api_url($page, $limit, $total, $url, $query = null) {
    $current_page = ($page <= 0) ? 1 : $page;
    $next = $current_page + 1;
    $last = ceil($total / $limit);
    if ($query) {
        $addString = "?$query&page={$next}";
    } else {
        $addString = "?page={$next}";
    }

    return ($current_page >= $last) ? null : site_url() . "$url" . $addString;
}

function prev_page_api_url($page, $url, $query = null) {
    $current_page = ($page <= 0) ? 1 : $page;
    $prev = $current_page - 1;
    if ($query) {
        $addString = "?$query&page={$prev}";
    } else {
        $addString = "?page={$prev}";
    }

    return ($prev) ? site_url() . "$url" . $addString : null ;
}

function getCmsPage($url){
    $CI = &get_instance();
    $cms  = $CI->db->get_where('cms', ['post_url' => $url])->row_array();

    if (!empty($url)) {
        $cms_page = ['cms' => $cms];
        $cms_page['meta_title'] = @$cms['seo_title'];
        $cms_page['meta_description'] = getShortContent(@$cms['seo_description'], 120);
        $cms_page['meta_keywords'] = @$cms ['seo_keyword'];
        return $cms_page;
    }
    $cms_page = ['cms' => []];
    $cms_page['meta_title'] = '';
    $cms_page['meta_description'] = '';
    $cms_page['meta_keywords'] = '';
    return $cms_page;
}

function checkRecaptcha()
{
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $secret = config_item('secret_key');
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response'];
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
            echo "\n<br />";
            $contents = '';
        } else {
            curl_close($ch);
        }
//        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
        $responseData = json_decode($contents);
        if ($responseData->success) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function loan_vehicle(){
    $vehicle = array(
        "1" => "Car",
        "2" => "Van",
        "3" => "Motorbike",
        "5" => "Import Car",
        "6" => "Auction Cars",
    );

    return $vehicle;
}

function loan_vehicle_dropdown($selected = '', $label = 'Any Vehicle')
{
    $html = '<option value="" disabled selected>' . $label . '</option>';
    foreach (loan_vehicle() as $key => $condition) {
        $html .= '<option value="' . $key . '"';
        $html .= ($key === $selected) ? ' selected' : '';
        $html .= '>' . $condition . '</option>';
    }

    return $html;
}

function get_vehicle_name_by_id( $selected = 0 ){
    $ci     =& get_instance();
    $type = $ci->db->get_where('vehicle_types', [ 'id' => $selected ])->row();

    return $type->name;
}

function send_push_to_app($user_id = 0, $title = '', $type = 'mail', $message = '', $sender_photo = null,$key = '', $value = ''){

    if (ENVIRONMENT != 'production'){
        return false;
    }

    $ci = &get_instance();
    $ci->db->select('device_token');
    $ci->db->from('user_tokens');
    if ($user_id) {
        $ci->db->where('user_id', $user_id);
    }
    $ci->db->where('is_on', 1);
    $data = $ci->db->get('')->result_array();

    $device_tokens = array_column($data, 'device_token');

    if (isset($device_tokens) && !empty($device_tokens)){
        $to = array_filter(array_unique($device_tokens));
        $payload = array(
            'type' => $type,
            'mail_id' => '0',
            'sender_id' => '0',
            'sender_photo' => $sender_photo,
            'sender_name' => $type == 'chat' ? $title : ''
        );
        if (!empty($key) && !empty($value)){
            $payload[$key] = strval($value);
        }
        $ci->load->library('fcm');
        $ci->fcm->setTitle($title);
        $ci->fcm->setMessage($message);
        $ci->fcm->setPayload($payload);
        $json = $ci->fcm->getPush();
        $ci->fcm->sendMultiple(($to[0]), $json);
        //print_r($ci->fcm->sendMultiple(array_values($to), $json));
    }

}

function role_dropdown($selected = '')
{
    $ci = &get_instance();
    $data = $ci->db->get_where('roles', ['user_id' => getLoginUserData('user_id')])->result();
    $html = '';
    foreach ($data as $key => $condition) {
        $html .= '<option value="' . $condition->id . '"';
        $html .= ($condition->id === $selected) ? ' selected' : '';
        $html .= '>' . $condition->role_name . '</option>';
    }

    return $html;
}
function getRoleDropdown($selected = '')
{
    $ci = &get_instance();
    $data = $ci->db->get_where('roles', ['user_id'=> 0])->result();
    $html = '<option value="">--Select Role--</option>';
    foreach ($data as $key => $condition) {
        $html .= '<option value="' . $condition->id . '"';
        $html .= ($condition->id === $selected) ? ' selected' : '';
        $html .= '>' . $condition->role_name . '</option>';
    }

    return $html;
}
function getPricingDuration($selected = '')
{
    $html = '<option value="">--Select Duration--</option>';
    foreach (PRICING_DURATION as $key => $condition) {
        $html .= '<option value="' . $condition . '"';
        $html .= ($condition === $selected) ? ' selected' : '';
        $html .= '>' . $condition . '</option>';
    }
    return $html;
}

function get_logged_user_photo_link(){

    $logged_method = getLoginUserData('oauth_provider');
    $picture = getLoginUserData('photo');

    if (empty($picture)) return 'assets/theme/new/images/backend/avatar.png';

    if ($logged_method == 'web') return base_url() . "uploads/users_profile/" .$picture;

    return $picture;

}

function get_logged_company_info(){
    $ci = &get_instance();
    $user_id = getLoginUserData('user_id');
    return $ci->db->select('IF(users.role_id = 4, cms.post_title, CONCAT(users.first_name," ", users.last_name)) as post_title,IF(users.role_id = 4,users.profile_photo,users.user_profile_image) as profile_photo')
        ->join('cms', "users.id = cms.user_id AND cms.post_type = 'business'", 'LEFT')
        ->where('users.id', $user_id)
        ->get('users')->row();


}

function slugify($text)
{
    if (empty($text)) {
        return $text;
    }
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

function search_link_builder($old_array,$new_key,$new_value){
    $ci = &get_instance();
    if (!empty($new_value)){
        $old_array[$new_key] = $new_value;
    } else {

        unset($old_array[$new_key]);
    }
    return base_url(). $ci->uri->segment(1).'/'.$ci->uri->segment(2).'/'.$ci->uri->segment(3).'?'.http_build_query($old_array, '', '&', PHP_QUERY_RFC3986);
}

function search_link_state_builder($old_array , $new_key, $new_value, $state_array){

    $ci = &get_instance();
    if (!empty($new_value)){
        if (($key = array_search($new_value, $state_array)) !== false) {
            unset($state_array[$key]);
        } else {
            $state_array[] = $new_value;
        }
        $old_array[$new_key] = implode(',', $state_array);
    } else {
        unset($old_array[$new_key]);
    }
    return base_url(). $ci->uri->segment(1).'/'.$ci->uri->segment(2).'/'.$ci->uri->segment(3).'?'.http_build_query($old_array, '', '&', PHP_QUERY_RFC3986);
}

// Shortens a number and attaches K, M, B, etc. accordingly
function number_shorten($number, $precision = 1, $divisors = null) {

    // Setup default $divisors if not provided
    if (!isset($divisors)) {
        $divisors = array(pow(1000, 0)
             => '', // 1000^0 == 1
            pow(1000, 1) => 'K', // Thousand
            pow(1000, 2) => 'M', // Million
            pow(1000, 3) => 'B', // Billion
            pow(1000, 4) => 'T', // Trillion
            pow(1000, 5) => 'Qa', // Quadrillion
            pow(1000, 6) => 'Qi', // Quintillion
        );
    }

    // Loop through each $divisor and find the
    // lowest amount that matches
    foreach ($divisors as $divisor => $shorthand) {
        if (abs($number??0) < ($divisor * 1000)) {
            // We found a match!
            break;
        }
    }

    // We found our match, or there were no matches.
    // Either way, use the last defined value for $divisor.
    return number_format($number / $divisor, $precision) . $shorthand;
}

/**
 * @param string | array $ids
 */
function impression_increase($ids = ''){
    if (!empty($ids)){
        $ci = &get_instance();
        if (is_array($ids)){
            $ci->db->where_in('id', $ids);
        } else {
            $ci->db->where('id', $ids);
        }
        $ci->db->set('impressions', 'impressions+1', FALSE);
        $ci->db->update('posts');
    }

}

function pp($data= []){
    echo "<pre>";
    print_r($data);die();
}

function viewAdminDriverNew($view, $data = [])
{
    $ci = &get_instance();
    $user_id = getLoginUserData('user_id');
    $user = $ci->db->where('id', $user_id)->get('users')->row();
    if ($user->email_verification_status === 'pending') {
        $ci->load->view('drivers/new/header');
        $ci->load->view('frontend/template/email_verification');
        $ci->load->view('drivers/new/footer');
    } else {
        if ($ci->input->is_ajax_request()) {
            $ci->load->view($view, $data);
        } else {
            $ci->load->view('drivers/new/header');

            $acl_text = !empty($ci->uri->segment(2)) ? $ci->uri->segment(2) : '';
            $acl_text .= !empty($ci->uri->segment(3)) ? '/' . $ci->uri->segment(3) : '';
            if ($view === 'backend/trade/template/inbox_detail' || checkPermission($acl_text, getLoginUserData('role_id'))) {
                $ci->load->view($view, $data);
            } else {
                $ci->load->view('backend/restrict');
            }

            $ci->load->view('drivers/new/footer');
        }
    }

}function viewAdminMechanicNew($view, $data = [])
{
    $ci = &get_instance();
    $user_id = getLoginUserData('user_id');
    $user = $ci->db->where('id', $user_id)->get('users')->row();
    if ($user->email_verification_status === 'pending') {
        $ci->load->view('mechanic/new/header');
        $ci->load->view('frontend/template/email_verification');
        $ci->load->view('mechanic/new/footer');
    } else {
        if ($ci->input->is_ajax_request()) {
            $ci->load->view($view, $data);
        } else {
            $ci->load->view('mechanic/new/header');

            $acl_text = !empty($ci->uri->segment(2)) ? $ci->uri->segment(2) : '';
            $acl_text .= !empty($ci->uri->segment(3)) ? '/' . $ci->uri->segment(3) : '';
            if ($view === 'backend/trade/template/inbox_detail' || checkPermission($acl_text, getLoginUserData('role_id'))) {

                $ci->load->view($view, $data);
            } else {
                $ci->load->view('backend/restrict');
            }

            $ci->load->view('mechanic/new/footer');
        }
    }

}

function build_data_files($boundary, $files){
    $data = '';
    $eol = "\r\n";

    $delimiter = '-------------' . $boundary;


    foreach ($files as $name => $content) {
        $data .= "--" . $delimiter . $eol
            . 'Content-Disposition: form-data; name="' . 'file' . '"; filename="' . $name . '"' . $eol
            //. 'Content-Type: image/png'.$eol
            . 'Content-Transfer-Encoding: binary'.$eol
        ;

        $data .= $eol;
        $data .= $content . $eol;
    }
    $data .= "--" . $delimiter . "--".$eol;

    return $data;
}

function maintenanceValue($value)
{
    $maintenance_value = (!empty($value)) ? array_filter(explode('|', $value)) : '';

    return $maintenance_value;
}


function get_cms_with_dynamic_meta($slug, $where_array = []){
    $ci = &get_instance();
    $ci->db->where('post_url', $slug);
    $ci->db->from('cms');
    $row = $ci->db->get()->row();
    $data = [
        'meta_title'    => $row ? $row->seo_title : '',
        'meta_description'  => $row ? $row->seo_description : '',
        'meta_keywords'     => $row ? $row->seo_keyword : '',
    ];
    if (!empty($row)){
        foreach ($where_array as $k => $d){
            $data = [
                'meta_title'    => str_replace('%' . $k . '%', $d, $data['meta_title']),
                'meta_description'  => str_replace('%' . $k . '%', $d, $data['meta_description']),
                'meta_keywords'     => str_replace('%' . $k . '%', $d, $data['meta_keywords']),
            ];
        }
    }

    return $data;
}

function getNewPriceDropDown($selected = 0)
{
    $prices = [
        0,
        500000,
        1000000,
        1500000,
        2000000,
        2500000,
        3000000,
        3500000,
        4000000,
        4500000,
        5000000,
        5500000,
        6000000,
        6500000,
        7000000,
        7500000,
        8000000,
        8500000,
        9000000,
        9500000,
        10000000,
        15000000,
        20000000,
        25000000,
        30000000,
        35000000,
        40000000,
        45000000,
        50000000,
        55000000,
        60000000,
        65000000,
        70000000,
        75000000,
        80000000,
        85000000,
        90000000,
        95000000,
        100000000,
        150000000,
        200000000,
        500000000,
    ];
    $option = '';

    foreach ($prices as $price) {
        $option .= '<option value="'. $price .'"';
        $option .= ( $selected == $price) ? ' selected' : '';
        $option .= '>$ '. number_format($price, 0 ) .' &nbsp;</option>';
    }

    return $option;
}
function getRoleSwitchDropdown($selected = '')
{
    $ci = &get_instance();
    $data = $ci->db->where_in('id', [4, 5, 8, 14, 15, 16, 17])->get('roles')->result();
    $html = '<option value="">Select Account</option>';
    foreach ($data as $key => $condition) {
        $html .= '<option value="' . $condition->id . '"';
        $html .= ($condition->id === $selected) ? ' selected' : '';
        $html .= '>' . $condition->role_name . '</option>';
    }

    return $html;
}
