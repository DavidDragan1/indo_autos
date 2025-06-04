<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends Frontend_controller {
    // every thing coming form Frontend Controller

    public function preview( $slug ){
        $this->viewFrontContent( 'frontend/template/single' );
    }

    public function maintenance(){
        $maintenance = getSettingItem('Maintenance');
        if (empty($maintenance)) {
            redirect('/', 'refresh');
        }
        if (!empty($maintenance)) {
            $maintenance_value = maintenanceValue($maintenance);
            $date_time = (!empty($maintenance[2])) ? date('Y/m/d H:i:s', strtotime($maintenance[2])) : '';
            if ($maintenance[1] == 0 && ($date_time && $date_time < date('Y-m-d H:i:s'))) {
                redirect('/', 'refresh');
            }
        }
        $this->load->view('frontend/maintenance', ['maintenance' => $maintenance]);
    }
    // business function moved to
    // app/core/frontend_controller.php as getBusinessPage();


    public function getBrand(){
        $type_id  = $this->input->post('type_id');
        echo  GlobalHelper::getBrand( $type_id );
    }

    public function getModel(){
        // $type_id  = $this->input->post('type_id');
        $brand_id  = $this->input->post('brand_id');
        echo  GlobalHelper::getModel( $brand_id );
    }

    public function  cron(){

        $sql = "SELECT p.id, p.vehicle_type_id, p.parts_description, p.brand_id, p.model_id , n.user_id, p.title, p.post_slug, u.id as user_id,
                 u.email, u.first_name, n.location_id, n.year   FROM posts as p
                LEFT JOIN user_notifications as n ON (n.brand_id = p.brand_id OR n.type_id = p.vehicle_type_id OR n.model_id = p.model_id OR n.location_id = p.location_id  OR n.year = p.manufacture_year OR n.parts_description = p.parts_description )
                LEFT JOIN users as u ON n.user_id = u.id
                WHERE DATE(p.activation_date) = DATE(NOW() - INTERVAL 1 DAY) GROUP BY u.id" ;


        $new_posts = $this->db->query( $sql )->result();



        foreach ( $new_posts as $post ){

            $data = [
                'type_id' => GlobalHelper::getProductTypeById($post->vehicle_type_id),
                'brand_id' => GlobalHelper::getBrandNameById($post->brand_id),
                'model_id' => GlobalHelper::getModelNameById($post->model_id),
                'location_id' => GlobalHelper::getLocationById($post->location_id),
                'parts_description' => GlobalHelper::getParts_description($post->parts_description),
                'year' => $post->year,
                'title' => $post->title,
                'post_slug' => base_url('/post/').$post->post_slug,
                'email' => $post->email,
                'username' => $post->first_name,
            ];

            Modules::run('mail/subscribtion_notification', $data );
        }

    }

    public function faq ($url = ''){
        $string = explode('-', $url);
        $id = $string[count($string) - 1];
        $this->db->where('id', $id);
        $this->db->where('status', 'Published');
        $faq =  $this->db->get('help')->row();

        if($faq){
            $data['question']   = $faq->title;
            $data['answer']     = $faq->content;
        } else {
            $data['question']   = '404, Something Went Wrong!';
            $data['answer']     = 'Question Answer Not Found.';
        }

        $data['meta_title'] = $url;

        $this->viewFrontContentNew('frontend/template/faq_details', $data);
    }

    public function submit_faq(){
        ajaxAuthorized();

        $name       = $this->input->post('qustion_by_name',TRUE);
        $email      = $this->input->post('question_by_email',TRUE);
        $question   = $this->input->post('title',TRUE);
        $content    = nl2br($this->input->post('content',TRUE));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please Enter Valide Email Address.</p>');
            exit;
        }

        $data = array(
            'title'     => $question,
            'description'   => $content,
            'created'   => date('Y-m-d'),
            'modified'   => date('Y-m-d'),
            'status'    => 'Draft',
            'qustion_by_name'   => $name,
            'question_by_email' => $email,
            'question_at_date'  => date('Y-m-d'),
        );

        $this->db->insert('help', $data);

        $mail_body_html =  '<p><b>Name:</b> ' . $name . '</p>';
        $mail_body_html .=  '<p><b>Email:</b> ' . $email . '</p>';
        $mail_body_html .=  '<p><b>Question:</b> ' . $question . '</p>';
        $mail_body_html .=  '<p><b>Content:</b> ' . $content . '</p>';

        Modules::run('mail/send_faq_notify_to_admin',$mail_body_html, $email);
        echo ajaxRespond('OK', '<p class="ajax_success" style="font-weight:normal;">Question submitted successfully. You will notify shortly.</p>');
    }

    private function searchSwitch($search = null, $limit = 25){
        if ($search) {
            $this->db->like('title', $search);
            $this->db->or_like('content', $search);
        } else {
            $this->db->where('featured', 'Yes');
        }
        $this->db->limit($limit);
        $this->db->where('status', 'Published');

        return $this->db->get('help')->result();
    }

    public function getFAQs( $search = null ){
        $popular_faqs = $this->searchSwitch($search, 10);

        $html = '<ul class="qs-lists">';
        $i    = 1;
        foreach ($popular_faqs as $faq) {

            $html .= '<li  class="qs-item">
                            <h3>Q:'. $faq->title. '</h3>
                            <p><strong>Ans:</strong>' . newShowMoreTxtBtn($faq->content, 500, $faq->title, $faq->id, 'faq') . '</p></li>';

            $i++;
        }

        $html .= '</ul>';

        return $html;
    }

    public function getSidebarFAQ( ){
        $popular_faqs = $this->searchSwitch( null, $limit = 3 );
        $html = '<ul>';
        $i = 0;

        foreach ($popular_faqs as $faq) {
            $i ++;
            $url = url($faq->title).'-'.$faq->id ;
            $html .= '<li><a href="faq/'.$url . '">' .  $faq->title . '</a></li>';
        }

        $html .= '</ul>';

        return $html;
    }

    // for use  diagonistic

    private function searchDiagonistic($search = null, $limit = 25){
        $word = str_word_count($search['keyword']);
        if($search['keyword'] && $word > 1){
            $this->db->where("MATCH (title,content,problem,inspection) AGAINST ('{$search['keyword']}' IN NATURAL LANGUAGE MODE)", NULL, FALSE);
            $this->db->where('status', 'Published');
        } elseif( $search['keyword'] && $word == 1) {
            $this->db->group_start();
            $this->db->like('title', $search['keyword']);
            $this->db->or_like('content', $search['keyword']);
            $this->db->or_like('problem', $search['keyword']);
            $this->db->or_like('inspection', $search['keyword']);
            $this->db->group_end();
        } else {
           //  $this->db->where('featured', 'Yes');
        }
        if($search['vehicle_type']){ $this->db->where('vehicle_type', $search['vehicle_type']); }
        if($search['brand_id']){ $this->db->where('brand_id', $search['brand_id']); }
        if($search['model_id']){ $this->db->where('model_id', $search['model_id']); }
        if($search['category_id']){ $this->db->where('category_id', $search['category_id']); }
        $this->db->limit($limit);
        $this->db->where('status', 'Published');
        return $this->db->get('diagnostics')->result();
    }

    public function submit_diagnostic(){
        ajaxAuthorized();

        $name       = $this->input->post('qustion_by_name',TRUE);
        $email      = $this->input->post('question_by_email',TRUE);
        $question   = $this->input->post('title',TRUE);
        $content    = nl2br($this->input->post('content',TRUE));
        $problem    = nl2br($this->input->post('problem',TRUE));
        $inspection = nl2br($this->input->post('inspection',TRUE));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please Enter Valide Email Address.</p>');
            exit;
        }

        $data = array(
            'title'     => $question,
            'content'   => $content,
            'problem'   => $problem,
            'inspection'=> $inspection,
            'created'   => date('Y-m-d'),
            'status'    => 'Draft',
            'qustion_by_name'   => $name,
            'question_by_email' => $email,
            'question_at_date'  => date('Y-m-d'),
        );

        $this->db->insert('diagnostics', $data);

        $mail_body_html =  '<p><b>Name:</b> ' . $name . '</p>';
        $mail_body_html .=  '<p><b>Email:</b> ' . $email . '</p>';
        $mail_body_html .=  '<p><b>Question:</b> ' . $question . '</p>';
        $mail_body_html .=  '<p><b>Problem:</b> ' . $problem . '</p>';
        $mail_body_html .=  '<p><b>Inspection:</b> ' . $inspection . '</p>';
        $mail_body_html .=  '<p><b>Solution:</b> ' . $content . '</p>';

        Modules::run('mail/send_faq_notify_to_admin',$mail_body_html, $email);
        echo ajaxRespond('OK', '<p class="ajax_success" style="font-weight:normal;">Question submitted successfully. You will notify shortly.</p>');
    }


     private function searchSwitchDiagnostic($search){
            $this->db->where('vehicle_type', $search['vehicle_type']);
            $this->db->where('brand_id', $search['brand_id']);
            $this->db->where('model_id', $search['model_id']);
            $this->db->where('category_id', $search['category_id']);
            $this->db->group_start();
            $this->db->like('title', $search['keyword']);
            $this->db->or_like('content', $search['keyword']);
            $this->db->or_like('problem', $search['keyword']);
            $this->db->or_like('inspection', $search['keyword']);
            $this->db->group_end();
            $this->db->where('status', 'Published');
            $this->db->limit(1);

        return $this->db->get('diagnostics')->result();
    }

    public function getSidebarDiagnostics( ){
        $popular_faqs = $this->searchSwitchDiagnostic( null, $limit = 15 );
        $html = '<ol class="sidebar_faqs">';
        $i = 0;
        foreach ($popular_faqs as $faq) {
            $i ++;
            $html .= "<li><a href=\"diagnostic/{$faq->slug}\">{$faq->title}</a></li>";

        }
        $html .= '</ol>';
        return $html;
    }



    // Ask an Expert

    private function searchSwitchExpert($search = null, $limit = 25){
        if ($search) {
            $this->db->like('title', $search);
            $this->db->or_like('content', $search);
        } else {
            $this->db->where('featured', 'Yes');
        }
        $this->db->limit($limit);
        $this->db->where('status', 'Published');

        return $this->db->get('ask_expert')->result();
    }

    public function getExperts( $search = null ){
        $popular_faqs = $this->searchSwitchExpert($search, 10);
        $html = '<ul class="qs-lists">';
        $i    = 1;
        foreach ($popular_faqs as $faq) {

            $html .= '<li  class="qs-item">
                            <h3>Q:'. $faq->title. '</h3>
                            <p><strong>Ans:</strong>' . newShowMoreTxtBtn($faq->content, 500, $faq->title, $faq->id, 'ask-an-expert') . '</p></li>';

            $i++;
        }

        return $html;

    }

    public function getSidebarExpert( ){
        $popular_faqs = $this->searchSwitchExpert( null, $limit = 3 );
        $html = '<ul>';
        $i = 0;

        foreach ($popular_faqs as $faq) {
            $i ++;
            $url = url($faq->title).'-'.$faq->id ;
            $html .= '<li><a href="ask-an-expert/'.$url . '">' .  $faq->title . '</a></li>';
        }

        $html .= '</ul>';

        return $html;
    }

    public function submit_expert(){
        ajaxAuthorized();

        $name       = $this->input->post('qustion_by_name',TRUE);
        $email      = $this->input->post('question_by_email',TRUE);
        $question   = $this->input->post('title',TRUE);
        $content    = nl2br($this->input->post('content',TRUE));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please Enter Valide Email Address.</p>');
            exit;
        }

        $data = array(
            'title'     => $question,
            'description'   => $content,
            'created'   => date('Y-m-d'),
            'modified'   => date('Y-m-d'),
            'status'    => 'Draft',
            'qustion_by_name'   => $name,
            'question_by_email' => $email,
            'question_at_date'  => date('Y-m-d'),
        );

        $this->db->insert('ask_expert', $data);

        $mail_body_html =  '<p><b>Name:</b> ' . $name . '</p>';
        $mail_body_html .=  '<p><b>Email:</b> ' . $email . '</p>';
        $mail_body_html .=  '<p><b>Question:</b> ' . $question . '</p>';
        $mail_body_html .=  '<p><b>Content:</b> ' . $content . '</p>';

        Modules::run('mail/send_faq_notify_to_admin',$mail_body_html, $email);
        echo ajaxRespond('OK', '<p class="ajax_success" style="font-weight:normal;">Question submitted successfully. You will notify shortly.</p>');
    }


    private function getIdBySlug($table = null, $slug = null){
        $data = $this->db->select('id')->where('slug', $slug)->get($table)->row();
        return ($data) ? $data->id : 0;
    }

    public function api_cms_page(  $PageSlug = ''){

        $cms        = $this->db->get_where('cms', ['post_url' => $PageSlug])->row_array();
        if(empty($cms)){
            $r = [
                'status' => 0,
                'message' => 'Not Found'
            ];
            json_output_display(200, $r);
            exit;
        }
        $post_type  = $cms['post_type'];


        $cms_page                       = [ 'cms' => $cms ] ;
        $cms_page['meta_title']         = $cms['seo_title'];
        $cms_page['meta_description']   = getShortContent($cms ['seo_description'], 120);
        $cms_page['meta_keywords']      = $cms ['seo_keyword'];

        $data = [
            'status' => 1,
            'result' => $cms_page
        ];

        json_output(200, $data);

    }

    public function finance( $slug = null ){
        $temp = getCmsPage('car-finance');

        $data = array(
            'cms' => $temp['cms'],
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
        );

        $this->viewFrontContent( 'frontend/template/finance', $data);
    }



    public function review( $slug = null ){
        $vehicle_type_id = $this->input->post('vehicle_type_id', TRUE);
        $brand_id = $this->input->post('brand_id', TRUE);
        $model_id = $this->input->post('model_id', TRUE);
        $title = $this->input->post('title', TRUE);

        $brand =  $this->db->where(['vehicle_type_id' => $vehicle_type_id])->where('brand_id', $brand_id)->get('admin_review')->row();
        $model = $this->db->where(['vehicle_type_id' => $vehicle_type_id])->where('brand_id', $brand_id)->where('model_id', $model_id)->get('admin_review')->row();

        $this->db->select('admin_review.id, cms.*')
            ->where(['vehicle_type_id' => $vehicle_type_id]);

        if ($brand) {
            $this->db->where('brand_id', $brand_id);
        } else {
            $this->db->where('brand_id', 2214);
        }

        if ($model) {
            $this->db->where('model_id', $model_id);
        } else {
            $this->db->where('model_id', 2223);
        }

        $review = $this->db->join('cms', 'cms.id=admin_review.cms_id', 'LEFT')
            ->get('admin_review')->row();

         if ($review) {
             $search  = array('&lt;', '&gt;');
             $replace = array('<', '>');
             $content = str_replace($search, $replace, $review->content);
             $noReview = 0;
             $id = $review->id;
             $comments = $this->db->where(['parent_id' => $review->id, 'type' => 'Review'])->get('comment')->result();
             $comment_count = $this->db->from('comment')->where(['parent_id' => $review->id, 'type' => 'Review'])->count_all_results();
         } else {
             $content = "<p class='text-center' style='font-size:x-large;'> No review available. </p>";
             $noReview = 1;
             $id = 0;
             $comments = null;
             $comment_count = 0;
         }

         $temp = getCmsPage('review');

         $data = array(
                'id' => $id,
                'title' => $title,
                'vehicle_type_id' => $vehicle_type_id,
                'brand_id' => $brand_id,
                'model_id' => $model_id,
                'review' => $content,
                'no_review' => $noReview,
                'comments' => $comments,
                'count' => $comment_count,
                 'cms' => $temp['cms'],
                 'meta_title' => (isset($review->seo_title) && !empty($review->seo_title)) ? $review->seo_title : $temp['meta_title'],
                 'meta_description' => (isset($review->seo_description) && !empty($review->seo_description)) ? getShortContent($review->seo_description, 120) : $temp['meta_description'],
                 'meta_keywords' => (isset($review->meta_keywords) && !empty($review->meta_keywords)) ? $review->meta_keywords : $temp['meta_keywords'],
            );

         $this->viewFrontContent( 'frontend/template/review', $data );
    }

    public function comment(){
        $user_id = getLoginUserData('user_id');

        if (is_null($user_id)) {
            echo ajaxRespond('FAIL', 'If you want to comment please login.');
            return false;
        }

        $parent_id = $this->input->post('parent_id', TRUE);
        $type = $this->input->post('type', TRUE);
        $comment = $this->input->post('comment', TRUE);

        $data = array(
            'parent_id' => $parent_id,
            'type' => $type,
            'user_id' => $user_id,
            'comment' => $comment,
        );

        $this->db->insert('comment', $data);
        $id = $this->db->insert_id();
        $inserted_comment = $this->db->where('id', $id)->order_by('created_at', 'ASC')->get('comment')->row();

        $html = '<li class="comment-item">
                                <div class="comment-img">
                                    <img style="width: 40px; height: 40px;" src="assets/theme/new/images/backend/avatar.png" alt="image">
                                </div>
                                <div class="comment-content">
                                    <h4>'.getLoginUserData('name').'</h4>
                                    <span>';
            $date = date_create($inserted_comment->created_at);
           $html .=  date_format($date, 'M d, Y \a\t g:i A ').'</span>
                                    <p>'.$comment.'</p>
                                </div>
                            </li>';

        echo ajaxRespond('OK', $html);
    }

    public function email_verification($code){

            $user_code = $this->db->where('email_verification_code', $code)->get('users')->row();

            if (isset($user_code->email_verification_code) && $user_code->email_verification_code == $code) {
                $this->db->where(['email_verification_code' => $user_code->email_verification_code])->update('users', ['email_verification_status' => 'verified', 'email_verification_code' => '']);
            }

            redirect(base_url('admin'));

    }

    public function re_send_email(){
        $user = getUserDataById(getLoginUserData('user_id'));
        $userData = [
            'role_id'       => $user->role_id,
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'email'         => $user->email,
            'email_verification_code' => $user->email_verification_code,
            'user_id'       => $user->id,
        ];

        Modules::run('mail/verification_mails', $userData );

        echo ajaxRespond('OK', 'Email send successfully.');
        exit;
    }

    private function arrayLikeSearch($array = [], $search = "")
    {
        $result = array_filter($array, function ($item) use ($search) {
            if (preg_match('/\b' . preg_quote($search) . '\b/', $item)) {
                return true;
            }
            return false;
        });

        return empty(array_keys($result)) ? null : array_keys($result)[0];
    }

    public function driver_list(){
        $data = $_POST;
        if (isset($data['search'])) {
            $driver_marital_status = [
                1 => "Single",
                2 => "Married",
                3 => "Divorced"
            ];
            $education_type_array = [
                1 => "Primary",
                2 => "Secondary",
                3 => "NCE",
                4 => "OND",
                5 => "HND",
                6 => "Degree",
            ];
            $keys = explode(" ", $data['search']);
            $this->db->select('drivers.*, post_area.name as location_name');
            $this->db->where('status', 1);
            if ($keys[0] != "") {
                foreach ($keys as $value) {
                    $marital_status = $this->arrayLikeSearch($driver_marital_status, $value);
                    $education_type = $this->arrayLikeSearch($education_type_array, $value);
                    if (!empty($marital_status)) {
                        $this->db->where('drivers.marital_status', $marital_status);
                    }
                    if (!empty($education_type)) {
                        $this->db->where('drivers.education_type', $education_type);
                    }
                    $this->db->group_start();
                    $this->db->like('drivers.email', $value, 'both');
                    $this->db->or_like('drivers.phone', $value, 'both');
                    $this->db->or_like('drivers.name', $value, 'both');
                    $this->db->or_like('driver_track_id', $value, 'both');
                    $this->db->or_like('post_area.name', $value, 'both');
                    $this->db->group_end();
                }
            }
            $results = $this->db->join('post_area', 'drivers.city = post_area.id', 'LEFT')
                ->order_by('drivers.name', 'ASC')->get('drivers')->result();
        } else {
            $search = [
                'passed_theory_test' => $data['theory_test'],
                'medical_check_passed' => $data['medical_check_passed'],
                'driver_background_screening' => $data['driver_background_screening'],
                'background_screening' => $data['background_screening'],
                'education_type' => $data['education_type'],
                'vehicle_type_id' => $data['vehicle_type_id'],
            ];

            $salary = array(
                0 => $data['searchSalaryRange_from'],
                1 => $data['searchSalaryRange_to'],
            );

            $age = array(
                0 => $data['age_from'],
                1 => $data['age_to'],
            );

            $results = $this->db->select('drivers.*, post_area.name as location_name')
                ->where($search)
                ->where('min_age >=', (int) $age[0])
                ->where('min_age <=', (int) $age[1])
                ->where('max_age >=', (int) $age[0])
                ->where('max_age <=', (int) $age[1])
                ->where('min_salary >=', (int) $salary[0])
                ->where('min_salary <=', (int) $salary[1])
                ->where('max_salary >=', (int) $salary[0])
                ->where('max_salary <=', (int) $salary[1])
                ->where('status', 1)
                ->join('post_area', 'drivers.city = post_area.id', 'LEFT')
                ->order_by('name', 'ASC')->get('drivers')->result();
        }

        $data['drivers'] = $results;

        $this->viewFrontContent( 'frontend/template/driver_list', $data);
    }

    public function car_valuation(){
        $temp = getCmsPage('car-valuation');

        $this->db->select('p.condition, p.location, p.pricein, p.priceindollar, p.priceinnaira, p.mileage, p.gear_box_type, p.vehicle_type_id, p.id, p.post_slug, p.title');
        $this->db->select('pa.name as state_name, IF(c.id IS NOT NULL, 1, 0) as is_financing');
        $this->db->from('posts as p');
        $this->db->join('post_area as pa', "pa.id = p.location_id AND pa.type = 'state'");
        $this->db->join(
            'car_list as c',
            "c.vehicle_type = p.vehicle_type_id AND
             (FIND_IN_SET(p.brand_id, c.brand_id) OR FIND_IN_SET('2214',c.brand_id)) AND
             (FIND_IN_SET(p.model_id, c.model_id) OR FIND_IN_SET('2223',c.model_id)) AND
              c.manufacture_year <= p.manufacture_year AND
              c.to_year >= p.manufacture_year AND
              (FIND_IN_SET(p.condition,c.car_condition) OR FIND_IN_SET('All',c.car_condition)) AND
              (FIND_IN_SET(p.location_id,c.location_id) OR FIND_IN_SET('41',c.location_id)) AND
              (c.min_price <= IF(p.pricein = 'USD', p.priceindollar, p.priceinnaira) OR c.min_price = 0) AND
              (c.max_price >= IF(p.pricein = 'USD', p.priceindollar, p.priceinnaira) OR c.max_price = 0) AND
              c.deleted_at = 0 AND
              c.type = 'loan' AND
              (c.seller_id = '' OR c.seller_id IS NULL OR FIND_IN_SET(p.user_id, c.seller_id) <> 0 OR FIND_IN_SET('0', c.seller_id) <> 0)
              ",
            'LEFT'
        );
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        $this->db->where('p.vehicle_type_id', 1);
        $this->db->order_by('p.hit', 'DESC');
        $this->db->limit(4);
        $this->db->group_by('p.id');

        $trending = $this->db->get()->result();



        $data = array(
            'cms' => $temp['cms'],
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
            'trending' => $trending
        );

       // $this->viewFrontContent('frontend/template/car_valuation', $data);
        $this->viewFrontContentNew('frontend/new/template/car_valuation', $data);
    }

    public function get_vehicle_variant()
    {
        $data = [];
        if (!empty($this->input->post('vehicle_type_id', TRUE))) {
            $data['vehicle_type_id'] = $this->input->post('vehicle_type_id', TRUE);
        }

        if (!empty($this->input->post('vehicle_condition', TRUE))) {
            $data['vehicle_condition'] = $this->input->post('vehicle_condition', TRUE);
        }

        if (!empty($this->input->post('brandName', TRUE))) {
            $data['brand_id'] = $this->input->post('brandName', TRUE);
        }

        if (!empty($this->input->post('model_id', TRUE))) {
            $data['model_id'] = $this->input->post('model_id', TRUE);
        }

        if (!empty($this->input->post('manufacture_year', TRUE))) {
            $data['manufacturing_year'] = $this->input->post('manufacture_year', TRUE);
        }
        $results = $this->db->where($data)
            ->order_by('variant_name', 'ASC')->get('vehicle_variants')->result();

        $htmlResult = "<option value=\"0\">Select Variant</option>";
        foreach ($results as $result) {
            $selected = "";
            if (!empty($this->input->post('vehicle_variant', TRUE)) && ($this->input->post('vehicle_variant', TRUE) == $result->id)) {
                $selected = "selected";
            }
            $htmlResult .= "<option value='" . $result->id . "' " . $selected . ">" .  $result->variant_name . "</option>";
        }

        echo $htmlResult;
    }

    public function get_body_condition()
    {
        $data = [];
        if (!empty($this->input->post('vehicle_type_id', TRUE))) {
            $data['vehicle_type_id'] = $this->input->post('vehicle_type_id', TRUE);
        }

        if (!empty($this->input->post('vehicle_condition', TRUE))) {
            $data['vehicle_condition'] = $this->input->post('vehicle_condition', TRUE);
        }

        if (!empty($this->input->post('brandName', TRUE))) {
            $data['brand_id'] = $this->input->post('brandName', TRUE);
        }

        if (!empty($this->input->post('model_id', TRUE))) {
            $data['model_id'] = $this->input->post('model_id', TRUE);
        }

        if (!empty($this->input->post('manufacture_year', TRUE))) {
            $data['manufacturing_year'] = $this->input->post('manufacture_year', TRUE);
        }

        if (!empty($this->input->post('vehicle_variant', TRUE))) {
            $data['variant_id'] = $this->input->post('vehicle_variant', TRUE);
        }

        $results = $this->db->where($data)
            ->join('vehicle_valuation_grade_percentage_settings', 'vehicle_valuation_grade_percentage_settings.vehicle_valuation_id = vehicle_valuation_settings.id')
            ->order_by('percentage', 'ASC')->get('vehicle_valuation_settings')->result();

        $htmlResult = "<option value=\"0\">Select Body Condition</option>";
        foreach ($results as $result) {
            $htmlResult .= "<option value='" . $result->id . "'" . ">" .  $result->name . "</option>";
        }

        echo $htmlResult;
    }

    public function get_brands() {
        $brand_id   = $this->input->post('id',TRUE);
        $models = $this->db
            ->get_where('brands', ['parent_id' => $brand_id, 'type' => 'Model'])
            ->result();
        $options  = '';
        if(count($models) == 0 ){
            $options .= '<option value="0"> No Model Found</option>';
        } else {
            $options  .= '<option value="0">Select Model</option>';
        }
        foreach($models as $model ){
            $options .= '<option value="'.$model->id.'" ';
            $options .= '>'.$model->name .'</option>';
        }

        echo  $options;
    }

    public function get_car_valuation_price()
    {
        $data = [];
        if (!empty($this->input->post('vehicle_type_id', TRUE))) {
            $data['vehicle_type_id'] = $this->input->post('vehicle_type_id', TRUE);
        }

        if (!empty($this->input->post('vehicle_condition', TRUE))) {
            $data['vehicle_condition'] = $this->input->post('vehicle_condition', TRUE);
        }

        if (!empty($this->input->post('brandName', TRUE))) {
            $data['brand_id'] = $this->input->post('brandName', TRUE);
        }

        if (!empty($this->input->post('model_id', TRUE))) {
            $data['model_id'] = $this->input->post('model_id', TRUE);
        }

        if (!empty($this->input->post('manufacture_year', TRUE))) {
            $data['manufacturing_year'] = $this->input->post('manufacture_year', TRUE);
        }

        if (!empty($this->input->post('vehicle_variant', TRUE))) {
            $data['variant_id'] = $this->input->post('vehicle_variant', TRUE);
        }

        $results = $this->db->where($data)->get('vehicle_valuation_settings')->row();
        if (empty($results)) {
            echo json_encode([
                'status' => false,
                'message' => 'No settings found'
            ]);

            return 1;
        }

        $minPrice = $results->minimum_price;
        $maxPrice = $results->maximum_price;

        if (!empty($this->input->post('mileage_range', TRUE)) && !empty($results)) {
            $range = $this->input->post('mileage_range', TRUE);
            $range = explode("-", $range);
            $percentages = $this->db->where(['vehicle_valuation_id' => $results->id])
                ->get('vehicle_valuation_percentage_settings')->result();
            $mileagePercentage = 0;
            foreach ($percentages as $percentage) {
                $mileagePercentage = $percentage->percentage;
                if ($percentage->from <= $range[1] && $percentage->to >= $range[1]) {
                    break;
                }
            }

            if ($mileagePercentage != 0) {
                $minPrice = $minPrice - (($mileagePercentage * $minPrice) / 100);
                $maxPrice = $maxPrice - (($mileagePercentage * $maxPrice) / 100);
            }
        }

        if (!empty($this->input->post('body_condition', TRUE)) && !empty($results)) {
            $condition = $this->input->post('body_condition', TRUE);
            $gradePercentageSettings = $this->db->where([
                'id' => $condition,
                'vehicle_valuation_id' => $results->id
            ])->get('vehicle_valuation_grade_percentage_settings')->row();
            $gradePercentage = 0;
            if (!empty($gradePercentageSettings)) {
                $gradePercentage = $gradePercentageSettings->percentage;
            }

            if ($gradePercentage != 0) {
                $minPrice = $minPrice - (($gradePercentage * $minPrice) / 100);
                $maxPrice = $maxPrice - (($gradePercentage * $maxPrice) / 100);
            }
        }

        echo json_encode([
            'status' => true,
            'message' => "₦ " . $minPrice . " - " . "₦ " . $maxPrice
        ]);
    }

    public function getQuestion(){
        $questionType = $this->input->post('qs_type',TRUE);
        $vehicle_type_id = $this->input->post('vehicle_type_id',TRUE);
        $brand_id = $this->input->post('brand_id',TRUE);
        $model_id = $this->input->post('model_id',TRUE);
        $issue_type = $this->input->post('issue_type',TRUE);

        $questions = $this->db->where(['question_type_id' => $questionType, 'status' => 'Published', 'vehicle_type_id' => $vehicle_type_id, 'issue_type' => $issue_type])
            ->group_start()
            ->where('brand_id', $brand_id)
            ->or_where('brand_id', 2214)
            ->group_end()
            ->group_start()
            ->where('model_id', $model_id)
            ->or_where('model_id', 2223)
            ->group_end()
            ->get('diagnostics_question')->result();

        $html = "<ul class=\"mobile-service-items\">";
        if (isset($questions) && count($questions) > 0) {
            foreach ($questions as $question) {
                $html .= "<li>
                        <a href=\"diagnostic-solution/" . $question->id ."\">
                            <span class=\"info\">
                                <svg class=\"icon\" width=\"24\" height=\"20\" viewBox=\"0 0 24 20\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                                    <path d=\"M6 14.4C6.34 14.4 6.6252 14.2848 6.8556 14.0544C7.0852 13.8248 7.2 13.54 7.2 13.2C7.2 12.86 7.0852 12.5748 6.8556 12.3444C6.6252 12.1148 6.34 12 6 12C5.66 12 5.3748 12.1148 5.1444 12.3444C4.9148 12.5748 4.8 12.86 4.8 13.2C4.8 13.54 4.9148 13.8248 5.1444 14.0544C5.3748 14.2848 5.66 14.4 6 14.4ZM4.8 9.6C4.8 10.2627 5.33726 10.8 6 10.8C6.66274 10.8 7.2 10.2627 7.2 9.6V6C7.2 5.33726 6.66274 4.8 6 4.8C5.33726 4.8 4.8 5.33726 4.8 6V9.6ZM9.6 12C9.6 12.6627 10.1373 13.2 10.8 13.2H18C18.6627 13.2 19.2 12.6627 19.2 12C19.2 11.3373 18.6627 10.8 18 10.8H10.8C10.1373 10.8 9.6 11.3373 9.6 12ZM9.6 7.2C9.6 7.86274 10.1373 8.4 10.8 8.4H18C18.6627 8.4 19.2 7.86274 19.2 7.2C19.2 6.53726 18.6627 6 18 6H10.8C10.1373 6 9.6 6.53726 9.6 7.2ZM2.4 19.2C1.74 19.2 1.1752 18.9652 0.7056 18.4956C0.2352 18.0252 0 17.46 0 16.8V2.4C0 1.74 0.2352 1.1752 0.7056 0.7056C1.1752 0.2352 1.74 0 2.4 0H21.6C22.26 0 22.8252 0.2352 23.2956 0.7056C23.7652 1.1752 24 1.74 24 2.4V16.8C24 17.46 23.7652 18.0252 23.2956 18.4956C22.8252 18.9652 22.26 19.2 21.6 19.2H2.4ZM2.4 11.8C2.4 14.5614 4.63858 16.8 7.4 16.8H16.6C19.3614 16.8 21.6 14.5614 21.6 11.8V7.4C21.6 4.63858 19.3614 2.4 16.6 2.4H7.4C4.63857 2.4 2.4 4.63858 2.4 7.4V11.8Z\" fill=\"#F05C26\"/>
                                </svg>
                                <span>" . $question->question ."</span>
                                <img src=\"assets/new-theme/images/icons/mouse.svg\" alt=\"mouse\">
                            </span>
                            <span class=\"action\">
                                <img src=\"assets/new-theme/images/icons/copy.svg\" alt=\"\">
                            </span>
                        </a>
                    </li>";
            }
        } else {
            $html .= '<li>No question to show.</li>';
        }

        $html .= "</ul>";

        echo returnJSON($html);
    }

    public function getProblem(){
        $questionType = $this->input->post('question',TRUE);

        $questions = $this->db->where('question_id', $questionType)->where('status', 'Published')->get('diagnostics_problem')->result();
        $data = ['status' => 'success', 'data' => $questions];

        if (isset($questions) && count($questions) > 0) {

        } else {
            $data['status'] = 'error';
        }

        echo returnJSON($data);
    }

    public function getInspection(){
        $questionType = $this->input->post('problem_id',TRUE);

        $questions = $this->db->where('problem_id', $questionType)->where('status', 'Published')->get('diagnostics_inspection')->result();
        $html = '';
        if (isset($questions) && count($questions) > 0) {
            $count = 1;
            foreach ($questions as $question) {
                $html .= '<li>
                                    <p><strong>Inspection '.$count++.' :</strong>'.$question->inspection.'</p>
                                    <p>'.$question->description.'</p>
                                    <div class="step-footer">
                                        <button onclick="window.scrollTo(0, 0);" class="next solu" data-id="'.$question->id.'"
                                                data-direction="next">Continue to Solution</button>
                                    </div>
                                </li>';
            }
        } else {
            $html .= '<li>No inspection to show.</li>';
        }

        echo returnJSON($html);
    }

    public function getSolution(){
        $question_id = $this->input->post('question_id',TRUE);

        $questions = $this->db->where('question_id', $question_id)->where('status', 'Published')->get('diagnostics_solution')->result();
        $html = "<ul class=\"mobile-service-items\">";
        if (isset($questions) && count($questions) > 0) {
            foreach ($questions as $k => $question) {
                $count = $k + 1;
                $html .= "<li>
                                    <span>
                                    <span>$count) </span>
                                        <span>$question->solution</span>
                                        <span>$question->description</span>
                                    </span>
                                </li>";
            }
        } else {
            $html .= '<li>No solution to show.</li>';
        }

        $html .= "</ul>";

        echo returnJSON($html);
    }


    public function getDiagnostics(){
        $question = $this->input->post('question',TRUE);
        $problems = $this->db->like('problem', $question)->where('status', 'Published')->get('diagnostics_problem')->result();
        $temp = getCmsPage('diagnostic_search');
        $data = [
            'problems' => $problems,
            'cms' => $temp['cms'],
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
        ];

        $this->viewFrontContent('frontend/template/diagnostic_problem', $data);
    }

    public function getSearchInspaction(){
        $question = $this->input->post('problem_id',TRUE);
        $problems = $this->db->like('problem_id', $question)->where('status', 'Published')->get('diagnostics_inspection')->result();
        $temp = getCmsPage('diagnostic_search_inspection');

        $data = [
            'problems' => $problems,
            'cms' => $temp['cms'],
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
        ];

        $this->viewFrontContent('frontend/template/diagnostic_inspection', $data);
    }

    public function getSearchSolution(){
        $question = $this->input->post('problem_id',TRUE);
        $problems = $this->db->like('inspection_id', $question)->where('status', 'Published')->get('diagnostics_solution')->result();
        $temp = getCmsPage('diagnostic_search_solution');
        $data = [
            'problems' => $problems,
            'cms' => $temp['cms'],
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
        ];

        $this->viewFrontContent('frontend/template/diagnostic_solution', $data);
    }

    public function driver_join() {
        $data = $_POST;
        $email = $this->db->where('email', $data['email'])->get('drivers')->row();
        if ($email) {
            $this->session->set_flashdata('error', 'Email already exists.');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $phone = $this->db->where('phone', $data['phone'])->get('drivers')->row();
        if ($phone) {
            $this->session->set_flashdata('error', 'Phone number already exists.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $salary = array(
            0 => $data['salary_from'],
            1 => $data['salary_to'],
        );

        $age = array(
            0 => $data['age_from'],
            1 => $data['age_to'],
        );

        $code = "CD-" . GlobalHelper::randomNumber(6);
        $data = array(
            'name' => $data['name'],
            'years_of_experience' => $data['years_of_experience'],
            'min_age' => $age[0],
            'max_age' => $age[1],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'min_salary' => $salary[0],
            'max_salary' => $salary[1],
            'vehicle_type_id' => $data['vehicle_type_id'],
            'license_type' => $data['license_type'],
            'city' => $data['location_id'],
            'marital_status' => $data['married'],
            'education_type' => $data['education_type'],
            'driver_track_id' => $code
        );

        $this->db->insert('drivers', $data);
        Modules::run('mail/driver_join_request', $data);

        $this->session->set_flashdata('message', 'Application successfully submitted. One of our agents will contact you for the next step.');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function hire_driver($id)
    {
        $code = "CH-" . GlobalHelper::randomNumber(6);
        $userId = getLoginUserData('user_id');
        $email = getLoginUserData('email');
        $this->db->where(['id' => $id])->update('drivers', ['status' => 3, 'hired_by' => $userId, 'driver_hire_tracking_id' => $code]);
        Modules::run('mail/driver_hire_request', ['code' => $code, 'email' => $email]);

        $this->session->set_flashdata('message', 'Your driver hire request has been submitted successfully');
        redirect(site_url() . "driver-hire");
    }

    public function driver_requirement_service()
    {
        $data = $this->db->where('label', 'RequirementService')->get('settings')->row();
        $value = "";
        if (!empty($data)) {
            $value = $data->value;
        }

        echo json_encode(['data' => $value]);
    }

    public function driver_hire_request()
    {
        $code = "CH-" . GlobalHelper::randomNumber(6);
        $data = $_POST;
        $userId = getLoginUserData('user_id');
        $email = getLoginUserData('email');
        $insert = [
            'user_id' => $userId,
            'age' => $data['age_from']."-".$data['age_to'],
            'vehicle_type_id' => $data['vehicle_type_id'],
            'service_type' => $data['service_type'],
            'marital_status' => $data['marital_status'],
            'education_type' => $data['education_type'],
            'years_of_experience' => $data['year_of_experience_from']."-".$data['year_of_experience_to'],
            'periods' => $data['periods'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'number_of_drivers' => $data['number_of_drivers'],
            'accommodation' => $data['accommodation'],
            'driver_hire_tracking_id' => $code
        ];

        if ($data['accommodation']) {
            $insert['state'] = $data['state'];
            $insert['city'] = $data['city'];
        }

        $this->db->insert('driver_hire_request', $insert);
        Modules::run('mail/driver_hire_request', ['email' => $email, 'code' => $code]);

        echo json_encode(['status' => true, 'message' => 'Your driver hire request has been submitted successfully']);
    }

    public function all_city() {
        $id = $this->input->get('id', true);
        $field = is_numeric($id) ? 'state_towns.state_id' : 'post_area.slug';
        $post_areas = $this->db->select('state_towns.*')
            ->where("FIND_IN_SET('2',state_towns.type) <>", 0)
            ->where($field, $id)->join('post_area', 'post_area.id = state_towns.state_id')
            ->get('state_towns')
            ->result();
        $html = '<option value="" selected disabled>' . "Select Location" . '</option>';

        foreach ($post_areas as $area) {
            $html .= '<option value="' . $area->name . '"';
            $html .= ($id == $area->id) ? ' selected' : '';
            $html .= '>' . $area->name . '</option>';
        }

        echo $html;
    }

    public function all_city_slug()
    {
        $slug = $this->input->get('slug', true);
        $exist = $this->db->where('slug',$slug)->get('post_area')->row();
        if ($exist){
            $post_areas = $this->db->where("FIND_IN_SET('2',state_towns.type) <>", 0)
                ->where(['state_id'=>$exist->id])
                ->get('state_towns')->result();
        }
        $html = '<option value="" selected disabled>' . "Select Location" . '</option>';
        foreach ($post_areas as $area) {
            $html .= '<option value="' . $area->slug . '"';
            $html .= ($slug == $area->slug) ? ' selected' : '';
            $html .= '>' . $area->name . '</option>';
        }

        echo $html;

    }
    public function searchReview() {
        $this->viewFrontContent('frontend/template/search_review');
    }

    public function sign_up() {
        $temp = getCmsPage('sign-up');

        $data = array(
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
        );

        $this->viewFrontContent('frontend/template/sign_up', $data);
    }

    public function car_valuation_ajax(){
        $vehicel_type_id = 1;
        $brand_id = $this->input->post('brand_id');
        $model_id = $this->input->post('model_id');
        $year = $this->input->post('year');
        $millage_from = $this->input->post('millage_from');
        $millage_to = $this->input->post('millage_to');
        $res = [];
        if (!empty($year) && !empty($brand_id) && !empty($model_id)) {
            $brand = $this->db->select('name, slug')->get_where('brands', ['id' => $brand_id])->row();
            $model = $this->db->select('name, slug')->get_where('brands', ['id' => $model_id])->row();

            if (!empty($brand) && !empty($model)){
                $car_name = $brand->name.' '.$model->name.' '.$year;
                $car_search_slug = http_build_query(['brand' => $brand->slug, 'model' => $model->slug]);

                $ci = &get_instance();
                $average_amount = $ci->db->select('MIN(priceinnaira) as min, MAX(priceinnaira) as max, condition')
                    ->where(['vehicle_type_id' => $vehicel_type_id, 'brand_id' => $brand_id, 'model_id' => $model_id, 'manufacture_year' => $year])
                    ->where(['mileage >='=> $millage_from, 'mileage <=' => $millage_to])
                    ->group_by('condition')
                    ->get('posts')
                    ->result();
                if (!empty($average_amount)) {
                    $res = [
                        'status' => 'success',
                        'msg' => false,
                        'data' => [
                            'car_name' => $car_name,
                            'car_search_slug' => $car_search_slug,
                            'val' => $average_amount
                        ]

                    ];
                } else {
                    $res = ['status' => 'error', 'message' => false, 'data' => []];
                }
            } else {
                $res = ['status' => 'error', 'message' => 'Something went wrong', 'data' => []];
            }
        } else {
            $res = ['status' => 'error', 'message' => 'Please Fill All Field', 'data' => []];
        }

        die(json_encode($res));

    }


    public function tag($slug)
    {
        $tag = $this->db->get_where('product_tags', ['slug' => $slug])->row();
        if (empty($tag)) {
            $this->viewFrontContentNew('frontend/404');
            return;
        }

        $limit = 20;
        $this->_getPosts();
        $this->db->where('find_in_set("'.$tag->id.'", p.tag_id)');
        $total = $this->db->count_all_results();
        $page = !empty(intval($this->input->get('page'))) ? $this->input->get('page') : 1;
        $start = startPointOfPagination($limit, $page);
        $target = $this->my_ajax_pagination();
        $data['pagination'] = getAjaxPaginator($total, $page, $target, $limit);
        $this->_getPosts();
        $this->db->where('find_in_set("'.$tag->id.'", p.tag_id)');
        $this->db->limit($limit, $start);
        $data['posts'] = $this->db->get()->result();
        $data['meta_title']         = $tag->meta_title ? $tag->meta_title : $tag->name;
        $data['meta_description']         = $tag->meta_description ? $tag->meta_description : '';
        $data['tag'] = $tag;

        $this->viewFrontContentNew( 'frontend/new/template/tag', $data);
    }

    private function _getPosts()
    {
        $this->db->select('p.condition, p.location, p.pricein, p.priceindollar, p.priceinnaira, p.mileage, p.gear_box_type, p.vehicle_type_id, p.id, p.post_slug, p.title');
        $this->db->select('pa.name as state_name');
        $this->db->from('posts as p');
        $this->db->join('post_area as pa', "pa.id = p.location_id AND pa.type = 'state'");
        $this->db->where('p.activation_date IS NOT NULL');
        $this->db->where('p.expiry_date >=', date('Y-m-d'));
        $this->db->where('p.status', 'Active');
        $this->db->where('p.post_type', 'General');
        $this->db->order_by('p.id', 'DESC');
        $this->db->join('users', 'users.id = p.user_id');
        $this->db->where('users.status', 'Active');
        $this->db->group_by('p.id');
    }

    private function my_ajax_pagination()
    {

        $array = $_GET;
        $url = $this->uri->uri_string(). '?';

        unset($array['page']);
        unset($array['_']);

        if ($array) {
            $url .= \http_build_query($array);
        }
        $url .= '&page';
        return $url;

    }


    public function diagnosticRatingSubmit()
    {
        $data = $_POST;
        $userId = getLoginUserData('user_id');
        $insert = [
            'user_id' => $userId ? $userId : 0,
            'question_id' => $data['question_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment'],
            'created_at' => Carbon\Carbon::now()
        ];
        $this->db->insert('diagnostics_solution_rating', $insert);

        $this->session->set_flashdata('message', 'Your rating has been submitted successfully');
        redirect(site_url() . "driver-hire");
    }
}
