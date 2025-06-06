<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2017-11-25
 */

class Diagnostics extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('diagnostics_model');
        $this->load->helper('diagnostics');
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->load->library('session');
        $this->session->keep_flashdata(array('status', 'message'));
    }

    public function index(){
        $q = urldecode($this->input->get('q', TRUE)??'');
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'diagnostics/?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'diagnostics/?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'diagnostics/';
            $config['first_url'] = Backend_URL . 'diagnostics/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->diagnostics_model->total_rows($q);
        $diagnostics = $this->diagnostics_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'diagnostics_data' => $diagnostics,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );

        $role_id = getLoginUserData('role_id');

        if ($role_id == 1 || $role_id == 2) {
            $this->viewAdminContent('diagnostics/diagnostics/index', $data);
        } else {
            $this->viewQuestionTypeList();
        }

    }


    public function read($id){
        $row = $this->diagnostics_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'title' => $row->title,
		'content' => $row->content,
		'problem' => $row->problem,
		'inspection' => $row->inspection,
		'qustion_by_name' => $row->qustion_by_name,
		'question_by_email' => $row->question_by_email,
		'created' => $row->created,
		'status' => $row->status,
		'modified' => $row->modified,
	    );
            $this->viewAdminContent('diagnostics/diagnostics/read', $data);
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'diagnostics'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'diagnostics/create_action'),
	    'id' => set_value('id'),
	    'title' => set_value('title'),
	    'status' => set_value('status',  'Draft'),
	    'content' => set_value('content'),
	    'problem' => set_value('problem'),
	    'inspection' => set_value('inspection'),
	    'vehicle_type' => set_value('vehicle_type'),
	    'brand_id' => set_value('brand_id'),
	    'model_id' => set_value('model_id'),
	    'category_id' => set_value('category_id'),
	);
        $this->viewAdminContent('diagnostics/diagnostics/create', $data);
    }

    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'vehicle_type' => $this->input->post('vehicle_type',TRUE),
		'brand_id' => $this->input->post('brand_id',TRUE),
		'model_id' => $this->input->post('model_id',TRUE),
		'category_id' => $this->input->post('category_id',TRUE),
		'title' => $this->input->post('title',TRUE),
		'slug' => $this->make_slug($this->input->post('title',TRUE)),
		'content' => $this->input->post('content',TRUE),
		'problem' => $this->input->post('problem',TRUE),
		'inspection' => $this->input->post('inspection',TRUE),
		'status' => $this->input->post('status',TRUE),
                'qustion_by_name' => '',
		'question_by_email' => '',
		'created' => date('Y-m-d'),
		'modified' => date('Y-m-d')
	    );

            $this->diagnostics_model->insert($data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Create Record Success</p>');
            redirect(site_url( Backend_URL. 'diagnostics'));
        }
    }

    public function update($id){
        $row = $this->diagnostics_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'diagnostics/update_action'),
		'id' => set_value('id', $row->id),


		'vehicle_type' => set_value('vehicle_type', $row->vehicle_type),
		'brand_id' => set_value('brand_id', $row->brand_id),
		'model_id' => set_value('model_id', $row->model_id),
		'category_id' => set_value('category_id', $row->category_id),
		'title' => set_value('title', $row->title),
		'content' => set_value('content', $row->content),
		'problem' => set_value('problem', $row->problem),
		'inspection' => set_value('inspection', $row->inspection),
		'qustion_by_name' => set_value('qustion_by_name', $row->qustion_by_name),
		'question_by_email' => set_value('question_by_email', $row->question_by_email),
		'status' => set_value('status', $row->status),
	    );
            $this->viewAdminContent('diagnostics/diagnostics/update', $data);
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'diagnostics'));
        }
    }

    public function update_action(){
        $this->_rules();

        $notify = ($this->input->post('send_notify')) ? $this->input->post('send_notify') : false;
        $email  = $this->input->post('email',TRUE);

        $id = $this->input->post('id', TRUE);
        if ($this->form_validation->run() == FALSE) {
            $this->update( $id );
        } else {
            $data = array(
                'vehicle_type' => $this->input->post('vehicle_type',TRUE),
		'brand_id' => $this->input->post('brand_id',TRUE),
		'model_id' => $this->input->post('model_id',TRUE),
		'category_id' => $this->input->post('category_id',TRUE),
		'title'     => $this->input->post('title',TRUE),
		'content'   => $this->input->post('content',TRUE),
		'problem'   => $this->input->post('problem',TRUE),
		'inspection'   => $this->input->post('inspection',TRUE),
		'status'    => $this->input->post('status',TRUE),
		'modified'  => date('Y-m-d')
	    );

            $this->diagnostics_model->update($id, $data);

            $this->notify_to_visitor( $notify, $email, $data, $id );

            $this->session->set_flashdata('message', '<p class="ajax_success">Data Updated Successlly</p>');
            redirect(site_url( Backend_URL. 'diagnostics/update/'. $id ));
        }
    }


    private function notify_to_visitor( $notify, $email, $data, $id ){
        if($notify){

            $mail_body_html =  '<h3><b>Your Question:</b> ' . $data['title'] . '</h3>';
            $mail_body_html .= 'Answer:</b><br/> ' . $data['content'];
            $mail_body_html .= '<p><br/><br/><b>FAQ Link:</b> ' . site_url( 'faq/' . $id) . '</p>';

            Modules::run('mail/send_faq_notify_to_visitor',$mail_body_html, $email);
        }
    }



    public function delete($id){
        $row = $this->diagnostics_model->get_by_id($id);

        if ($row) {
            $this->diagnostics_model->delete($id);
            $this->session->set_flashdata('message', '<p class="ajax_success">Delete Record Success</p>');
            redirect(site_url( Backend_URL. 'diagnostics'));
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url( Backend_URL. 'diagnostics'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('title', 'title', 'trim|required');
	$this->form_validation->set_rules('content', 'content', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    private function make_slug($text = null) {
        $rand = rand(1000,9999);
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            $text = $rand;
        }

        $isExist = $this->db->where('slug', $text )->count_all_results('diagnostics');
        if($isExist){
            return $text.'-'. $rand;
        }else {
            return $text;
        }
    }

    public function viewQuestionTypeList() {
        $config['page_query_string'] = TRUE;

        $config['query_string_segment'] = 'start';
        $config['num_links'] = 1;
        $config['full_tag_open'] = '<ul class="pagination-wrap">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = false;
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-angle-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li><span class="active">';
        $config['cur_tag_close'] = '</span></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $user_id = getLoginUserData('user_id');
        $start = intval($this->input->get('start'));
        $q = urldecode($this->input->get('q', TRUE));
        $config['per_page'] = 10;

        if ($q <> '') {
            $config['base_url'] = 'admin/diagnostics/?q=' . urlencode($q);
            $config['first_url'] = 'admin/diagnostics/?q=' . urlencode($q);
        } else {
            $config['base_url'] = 'admin/diagnostics';
            $config['first_url'] = 'admin/diagnostics';
        }

        $config['total_rows'] = $this->db;

        if ($q) {
            $config['total_rows']->like('title', $q)->or_like('status', $q)->or_like('type', $q);
        }

        $config['total_rows'] = $config['total_rows']->from('diagnostics_question_type')->count_all_results();

        $getQuestions = $this->db;

        if ($q) {
            $getQuestions = $getQuestions->like('title', $q)->or_like('status', $q)->or_like('type', $q);
        }
        $getQuestions = $getQuestions->order_by('id', 'DESC')
                        ->limit($config['per_page'], $start)
                        ->get('diagnostics_question_type')->result();

        $this->pagination->initialize($config);

        $data = array(
            'q' => $q,
            'questions' => $getQuestions,
            'pagination' => $this->pagination->create_links(),
        );

        $this->viewNewAdminContent('diagnostics/diagnostics/new/question_type', $data);
    }

    public function questionType() {
        $type = $this->input->post('type',TRUE);
        $title = $this->input->post('title',TRUE);
        $status = $this->input->post('status',TRUE);
        $id = intval($this->input->post('id',TRUE));

        $this->form_validation->set_rules('type', 'type', 'required');
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');

        if ($this->form_validation->run() != FALSE) {
            if ($id != 0) {
                $is_exist = $this->db->where(['id' => $id])->get('diagnostics_question_type')->row();

                if ($is_exist) {
                    $this->db->where(['id' => $id])->update('diagnostics_question_type',
                        [
                            'type' => $type,
                            'title' => $title,
                            'status' => $status,
                        ]
                    );

                    $this->session->set_flashdata(['status' => 'success', 'message' => 'Question type updated Successfully.']);
                } else {
                    $this->session->set_flashdata(['status' => 'error', 'message' => 'Invalid item.']);
                }

                redirect('admin/diagnostics', 'refresh');

            } else {

                $this->db->insert('diagnostics_question_type',
                    [
                        'type' => $type,
                        'title' => $title,
                        'status' => $status,
                        'created_by' => getLoginUserData('user_id'),
                    ]);

                $this->session->set_flashdata(['status' => 'success', 'message' => 'Question type Added Successfully.']);
            }

            redirect('admin/diagnostics', 'refresh');
        }

        $this->session->set_flashdata(['status' => 'error', 'message' => 'Please fill the form correctly.']);

        redirect('admin/diagnostics', 'refresh');
    }

    public function deleteQuestionType($id)
    {
        $is_exist = $this->db->where(['id' => $id])->get('diagnostics_question_type')->row();

        if ($is_exist) {
            $this->db->where(['id' => $id])->delete('diagnostics_question_type');
            $this->session->set_flashdata(['status' => 'success', 'message' => 'Delete Successfully.']);
        } else {
            $this->session->set_flashdata(['status' => 'error', 'message' => 'Item does not exist.']);
        }

        redirect('admin/diagnostics', 'refresh');
    }

    public function viewQuestionList() {
        $config['page_query_string'] = TRUE;

        $user_id = getLoginUserData('user_id');
        $start = intval($this->input->get('start'));
        $q = urldecode($this->input->get('q', TRUE)??'');
        $config['per_page'] = 20;

        if ($q <> '') {
            $config['base_url'] = 'admin/diagnostics/questions/?q=' . urlencode($q);
            $config['first_url'] = 'admin/diagnostics/questions/?q=' . urlencode($q);
        } else {
            $config['base_url'] = 'admin/diagnostics/questions';
            $config['first_url'] = 'admin/diagnostics/questions';
        }

        $config['total_rows'] = $this->db;

        if ($q) {
            $config['total_rows']->like('question', $q)->or_like('status', $q);
        }

        $config['total_rows'] = $config['total_rows']->from('diagnostics_question')->count_all_results();

        $getQuestions = $this->db;

        if ($q) {
            $getQuestions = $getQuestions->like('question', $q)->or_like('status', $q);
        }
        $getQuestions = $getQuestions->order_by('id', 'DESC')
            ->limit($config['per_page'], $start)
            ->get('diagnostics_question')->result();

        $this->pagination->initialize($config);

        $data = array(
            'q' => $q,
            'questions' => $getQuestions,
            'pagination' => $this->pagination->create_links(),
        );

        $this->viewAdminContent('diagnostics/diagnostics/question', $data);
    }

    public function questionUpdate() {
        $vehicle = $this->input->post('vehicle_type_id',TRUE);
        $brand = $this->input->post('brand_id',TRUE);
        $model = $this->input->post('model_id',TRUE);
        $type = $this->input->post('type',TRUE);
        $issue_type = $this->input->post('issue_type',TRUE);
        $meta_title = $this->input->post('meta_title',TRUE);
        $meta_description = $this->input->post('meta_description',TRUE);
        $meta_keyword = $this->input->post('meta_keyword',TRUE);
        $title = $this->input->post('question',TRUE);
        $status = $this->input->post('status',TRUE);
        $id = intval($this->input->post('id',TRUE));

        $this->form_validation->set_rules('vehicle_type_id', 'vehicle_type_id', 'trim|required|integer|greater_than[0]');
        $this->form_validation->set_rules('brand_id', 'brand_id', 'trim|required|integer');
        $this->form_validation->set_rules('model_id', 'model_id', 'trim|required|integer');
        $this->form_validation->set_rules('type', 'type', 'trim|required|integer');
        $this->form_validation->set_rules('issue_type', 'issue_type', 'trim|required|integer');
        $this->form_validation->set_rules('question', 'question', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');

        if ($this->form_validation->run() != FALSE) {
            if ($id != 0) {
                $is_exist = $this->db->where(['id' => $id])->get('diagnostics_question')->row();

                if ($is_exist) {
                    $this->db->where(['id' => $id])->update('diagnostics_question',
                        [
                            'vehicle_type_id' => $vehicle,
                            'brand_id' => $brand,
                            'model_id' => $model,
                            'question_type_id' => $type,
                            'issue_type' => $issue_type,
                            'meta_title' => $meta_title,
                            'meta_description' => $meta_description,
                            'meta_keyword' => $meta_keyword,
                            'question' => $title,
                            'status' => $status,
                        ]
                    );

                    $this->session->set_flashdata(['status' => 'success', 'message' => 'Question updated Successfully.']);
                } else {
                    $this->session->set_flashdata(['status' => 'error', 'message' => 'Invalid item.']);
                }

                redirect('admin/diagnostics/questions', 'refresh');

            } else {

                $this->db->insert('diagnostics_question',
                    [
                        'vehicle_type_id' => $vehicle,
                        'brand_id' => $brand,
                        'model_id' => $model,
                        'question_type_id' => $type,
                        'issue_type' => $issue_type,
                        'meta_title' => $meta_title,
                        'meta_description' => $meta_description,
                        'meta_keyword' => $meta_keyword,
                        'question' => $title,
                        'status' => $status,
                        'created_by' => getLoginUserData('user_id'),
                    ]);

                $this->session->set_flashdata(['status' => 'success', 'message' => 'Question Added Successfully.']);
            }

            redirect('admin/diagnostics/questions', 'refresh');
        }

        $this->session->set_flashdata(['status' => 'error', 'message' => 'Please fill the form correctly.']);

        redirect('admin/diagnostics/questions', 'refresh');
    }

    public function deleteQuestion($id)
    {
        $is_exist = $this->db->where(['id' => $id])->get('diagnostics_question')->row();

        if ($is_exist) {
            $this->db->where(['id' => $id])->delete('diagnostics_question');
            $this->session->set_flashdata(['status' => 'success', 'message' => 'Delete Successfully.']);
        } else {
            $this->session->set_flashdata(['status' => 'error', 'message' => 'Item does not exist.']);
        }

        redirect('admin/diagnostics/questions', 'refresh');
    }

    public function viewProblemList() {
        $config['page_query_string'] = TRUE;

        $config['query_string_segment'] = 'start';
        $config['num_links'] = 1;
        $config['full_tag_open'] = '<ul class="pagination-wrap">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = false;
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-angle-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li><span class="active">';
        $config['cur_tag_close'] = '</span></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $user_id = getLoginUserData('user_id');
        $start = intval($this->input->get('start'));
        $q = urldecode($this->input->get('q', TRUE));
        $config['per_page'] = 10;

        if ($q <> '') {
            $config['base_url'] = 'admin/diagnostics/problem/?q=' . urlencode($q);
            $config['first_url'] = 'admin/diagnostics/problem/?q=' . urlencode($q);
        } else {
            $config['base_url'] = 'admin/diagnostics/problem';
            $config['first_url'] = 'admin/diagnostics/problem';
        }

        $config['total_rows'] = $this->db;

        if ($q) {
            $config['total_rows']->like('problem', $q)->or_like('status', $q)->or_like('description', $q);
        }

        $config['total_rows'] = $config['total_rows']->from('diagnostics_problem')->count_all_results();

        $getQuestions = $this->db;

        if ($q) {
            $getQuestions = $getQuestions->like('problem', $q)->or_like('status', $q)->or_like('description', $q);
        }
        $getQuestions = $getQuestions->order_by('id', 'DESC')
            ->limit($config['per_page'], $start)
            ->get('diagnostics_problem')->result();

        $this->pagination->initialize($config);

        $data = array(
            'q' => $q,
            'questions' => $getQuestions,
            'pagination' => $this->pagination->create_links(),
        );

        $this->viewNewAdminContent('diagnostics/diagnostics/new/problem', $data);
    }

    public function problemUpdate() {
        $description = $this->input->post('description',TRUE);
        $problem = $this->input->post('problem',TRUE);
        $question = $this->input->post('question',TRUE);
        $status = $this->input->post('status',TRUE);
        $id = intval($this->input->post('id',TRUE));

        $this->form_validation->set_rules('question', 'question', 'trim|required|integer');
        $this->form_validation->set_rules('problem', 'problem', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');

        if ($this->form_validation->run() != FALSE) {
            if ($id != 0) {
                $is_exist = $this->db->where(['id' => $id])->get('diagnostics_problem')->row();

                if ($is_exist) {
                    $this->db->where(['id' => $id])->update('diagnostics_problem',
                        [
                            'description' => $description,
                            'problem' => $problem,
                            'question_id' => $question,
                            'status' => $status,
                        ]
                    );

                    $this->session->set_flashdata(['status' => 'success', 'message' => 'Problem updated Successfully.']);
                } else {
                    $this->session->set_flashdata(['status' => 'error', 'message' => 'Invalid item.']);
                }

                redirect('admin/diagnostics/problem', 'refresh');

            } else {

                $this->db->insert('diagnostics_problem',
                    [
                        'description' => $description,
                        'problem' => $problem,
                        'question_id' => $question,
                        'status' => $status,
                        'created_by' => getLoginUserData('user_id'),
                    ]);

                $this->session->set_flashdata(['status' => 'success', 'message' => 'Problem Added Successfully.']);
            }

            redirect('admin/diagnostics/problem', 'refresh');
        }

        $this->session->set_flashdata(['status' => 'error', 'message' => 'Please fill the form correctly.']);

        redirect('admin/diagnostics/problem', 'refresh');
    }

    public function deleteProblem($id)
    {
        $is_exist = $this->db->where(['id' => $id])->get('diagnostics_problem')->row();

        if ($is_exist) {
            $this->db->where(['id' => $id])->delete('diagnostics_problem');
            $this->session->set_flashdata(['status' => 'success', 'message' => 'Delete Successfully.']);
        } else {
            $this->session->set_flashdata(['status' => 'error', 'message' => 'Item does not exist.']);
        }

        redirect('admin/diagnostics/problem', 'refresh');
    }

    public function viewInspectionList() {
        $config['page_query_string'] = TRUE;

        $config['query_string_segment'] = 'start';
        $config['num_links'] = 1;
        $config['full_tag_open'] = '<ul class="pagination-wrap">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = false;
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '<i class="fa fa-angle-right"></i>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-angle-left"></i>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li><span class="active">';
        $config['cur_tag_close'] = '</span></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $user_id = getLoginUserData('user_id');
        $start = intval($this->input->get('start'));
        $q = urldecode($this->input->get('q', TRUE));
        $config['per_page'] = 10;

        if ($q <> '') {
            $config['base_url'] = 'admin/diagnostics/inspection/?q=' . urlencode($q);
            $config['first_url'] = 'admin/diagnostics/inspection/?q=' . urlencode($q);
        } else {
            $config['base_url'] = 'admin/diagnostics/inspection';
            $config['first_url'] = 'admin/diagnostics/inspection';
        }

        $config['total_rows'] = $this->db;

        if ($q) {
            $config['total_rows']->like('inspection', $q)->or_like('status', $q)->or_like('description', $q);
        }

        $config['total_rows'] = $config['total_rows']->from('diagnostics_inspection')->count_all_results();

        $getQuestions = $this->db;

        if ($q) {
            $getQuestions = $getQuestions->like('inspection', $q)->or_like('status', $q)->or_like('description', $q);
        }
        $getQuestions = $getQuestions->order_by('id', 'DESC')
            ->limit($config['per_page'], $start)
            ->get('diagnostics_inspection')->result();

        $this->pagination->initialize($config);

        $data = array(
            'q' => $q,
            'questions' => $getQuestions,
            'pagination' => $this->pagination->create_links(),
        );

        $this->viewNewAdminContent('diagnostics/diagnostics/new/inspection', $data);
    }

    public function inspectionUpdate() {
        $description = $this->input->post('description',TRUE);
        $problem = $this->input->post('inspection',TRUE);
        $question = $this->input->post('problem',TRUE);
        $status = $this->input->post('status',TRUE);
        $id = intval($this->input->post('id',TRUE));

        $this->form_validation->set_rules('problem', 'problem', 'trim|required|integer');
        $this->form_validation->set_rules('inspection', 'inspection', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');

        if ($this->form_validation->run() != FALSE) {
            if ($id != 0) {
                $is_exist = $this->db->where(['id' => $id])->get('diagnostics_inspection')->row();

                if ($is_exist) {
                    $this->db->where(['id' => $id])->update('diagnostics_inspection',
                        [
                            'description' => $description,
                            'inspection' => $problem,
                            'problem_id' => $question,
                            'status' => $status,
                        ]
                    );

                    $this->session->set_flashdata(['status' => 'success', 'message' => 'Inspection updated Successfully.']);
                } else {
                    $this->session->set_flashdata(['status' => 'error', 'message' => 'Invalid item.']);
                }

                redirect('admin/diagnostics/inspection', 'refresh');

            } else {

                $this->db->insert('diagnostics_inspection',
                    [
                        'description' => $description,
                        'inspection' => $problem,
                        'problem_id' => $question,
                        'status' => $status,
                        'created_by' => getLoginUserData('user_id'),
                    ]);

                $this->session->set_flashdata(['status' => 'success', 'message' => 'Inspection Added Successfully.']);
            }

            redirect('admin/diagnostics/inspection', 'refresh');
        }

        $this->session->set_flashdata(['status' => 'error', 'message' => 'Please fill the form correctly.']);

        redirect('admin/diagnostics/inspection', 'refresh');
    }

    public function deleteInspection($id)
    {
        $is_exist = $this->db->where(['id' => $id])->get('diagnostics_inspection')->row();

        if ($is_exist) {
            $this->db->where(['id' => $id])->delete('diagnostics_inspection');
            $this->session->set_flashdata(['status' => 'success', 'message' => 'Delete Successfully.']);
        } else {
            $this->session->set_flashdata(['status' => 'error', 'message' => 'Item does not exist.']);
        }

        redirect('admin/diagnostics/inspection', 'refresh');
    }

    public function viewSolutionList() {
        $config['page_query_string'] = TRUE;

        $user_id = getLoginUserData('user_id');
        $start = intval($this->input->get('start'));
        $q = urldecode($this->input->get('q', TRUE)??'');
        $config['per_page'] = 10;

        if ($q <> '') {
            $config['base_url'] = 'admin/diagnostics/solution/?q=' . urlencode($q);
            $config['first_url'] = 'admin/diagnostics/solution/?q=' . urlencode($q);
        } else {
            $config['base_url'] = 'admin/diagnostics/solution';
            $config['first_url'] = 'admin/diagnostics/solution';
        }

        $config['total_rows'] = $this->db;

        if ($q) {
            $config['total_rows']->like('solution', $q)->or_like('status', $q)->or_like('description', $q);
        }

        $config['total_rows'] = $config['total_rows']->from('diagnostics_solution')->count_all_results();

        $getQuestions = $this->db;

        if ($q) {
            $getQuestions = $getQuestions->like('solution', $q)->or_like('status', $q)->or_like('description', $q);
        }
        $getQuestions = $getQuestions->order_by('id', 'DESC')
            ->limit($config['per_page'], $start)
            ->get('diagnostics_solution')->result();

        $this->pagination->initialize($config);

        $data = array(
            'q' => $q,
            'questions' => $getQuestions,
            'pagination' => $this->pagination->create_links(),
        );

        $this->viewAdminContent('diagnostics/diagnostics/solution', $data);
    }

    public function solutionUpdate() {
        $description = $this->input->post('description',TRUE);
        $problem = $this->input->post('solution',TRUE);
        $question = $this->input->post('question',TRUE);
        $status = $this->input->post('status',TRUE);
        $id = intval($this->input->post('id',TRUE));

        $this->form_validation->set_rules('question', 'question', 'trim|required|integer');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('solution', 'solution', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');

        if ($this->form_validation->run() != FALSE) {
            if ($id != 0) {
                $is_exist = $this->db->where(['id' => $id])->get('diagnostics_solution')->row();

                if ($is_exist) {
                    $this->db->where(['id' => $id])->update('diagnostics_solution',
                        [
                            'description' => $description,
                            'solution' => $problem,
                            'question_id' => $question,
                            'status' => $status,
                        ]
                    );

                    $this->session->set_flashdata(['status' => 'success', 'message' => 'Solution updated Successfully.']);
                } else {
                    $this->session->set_flashdata(['status' => 'error', 'message' => 'Invalid item.']);
                }

                redirect('admin/diagnostics/solution', 'refresh');

            } else {

                $this->db->insert('diagnostics_solution',
                    [
                        'description' => $description,
                        'solution' => $problem,
                        'question_id' => $question,
                        'status' => $status,
                        'created_by' => getLoginUserData('user_id'),
                    ]);

                $this->session->set_flashdata(['status' => 'success', 'message' => 'Solution Added Successfully.']);
            }

            redirect('admin/diagnostics/solution', 'refresh');
        }

        $this->session->set_flashdata(['status' => 'error', 'message' => 'Please fill the form correctly.']);

        redirect('admin/diagnostics/solution', 'refresh');
    }

    public function deleteSolution($id)
    {
        $is_exist = $this->db->where(['id' => $id])->get('diagnostics_solution')->row();

        if ($is_exist) {
            $this->db->where(['id' => $id])->delete('diagnostics_solution');
            $this->session->set_flashdata(['status' => 'success', 'message' => 'Delete Successfully.']);
        } else {
            $this->session->set_flashdata(['status' => 'error', 'message' => 'Item does not exist.']);
        }

        redirect('admin/diagnostics/solution', 'refresh');
    }

    public function solutionReview()
    {
        $q 		= urldecode($this->input->get('q', TRUE));
        $start 	= intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'diagnostics/solution/review?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'diagnostics/solution/review?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'diagnostics/solution/review';
            $config['first_url'] = Backend_URL . 'diagnostics/solution/review';
        }

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $this->db->select('users.first_name, users.last_name, diagnostics_solution_rating.*, users.email')
            ->join('users', 'diagnostics_solution_rating.user_id = users.id')
            ->from('diagnostics_solution_rating');
        if (!empty($q)){
            $this->db->like('users.first_name', $q)
                ->or_like('diagnostics_solution_rating.comment', $q)
                ->or_like('users.last_name', $q);
        }

        $config['total_rows'] = $this->db->count_all_results('', false);
        $items = $this->db->order_by('diagnostics_solution_rating.created_at', 'DESC')->limit($config['per_page'],  $start)->get()->result();

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'items' => $items,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );

        $this->viewAdminContent('diagnostics/diagnostics/reviews', $data);
    }
}
