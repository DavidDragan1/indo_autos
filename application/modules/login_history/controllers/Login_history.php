<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2017-08-01
 */

class Login_history extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Login_history_model');
        $this->load->helper('login_history');
        $this->load->library('form_validation');
    }

    public function index(){
        // $q = urldecode($this->input->get('q', TRUE));
        $most_login = urldecode($this->input->get('most_login', TRUE)?$this->input->get('most_login', TRUE):'');
        $device = urldecode($this->input->get('device', TRUE)?$this->input->get('device', TRUE):'');
        $browser = urldecode($this->input->get('browser', TRUE)?$this->input->get('browser', TRUE):'');
        $role_id = urldecode($this->input->get('role_id', TRUE)?$this->input->get('role_id', TRUE):'');
        
        $range = urldecode($this->input->get('range', TRUE)?$this->input->get('range', TRUE):'');
        $fd = urldecode($this->input->get('fd', TRUE)?$this->input->get('fd', TRUE):'');
        $td = urldecode($this->input->get('td', TRUE)?$this->input->get('td', TRUE):'');
        
        $start = intval($this->input->get('start'));
        
        if ( $most_login <> '' || $device <> '' || $browser <> '' || $role_id <> '' || $range <> '' || $fd <> '' || $td <> '' ) {
            $config['base_url']  = Backend_URL . 'login_history/?most_login=' . $most_login . '&browser=' . $browser . '&device=' . $device . '&role_id=' . $role_id . '&range=' . $range. '&fd=' . $fd. '&td=' . $td ;
            $config['first_url'] = Backend_URL . 'login_history/?most_login=' . $most_login . '&browser=' . $browser . '&device=' . $device . '&role_id=' . $role_id . '&range=' . $range. '&fd=' . $fd. '&td=' . $td ;
        } else {
            $config['base_url'] = Backend_URL . 'login_history/';
            $config['first_url'] = Backend_URL . 'login_history/';
        }

        $config['per_page'] = 22;
        $config['page_query_string'] = TRUE;   
        $config['total_rows'] = $this->Login_history_model->total_rows( $most_login, $browser, $device, $role_id, $range, $fd, $td );
        $login_history = $this->Login_history_model->get_limit_data($config['per_page'], $start, $most_login, $browser, $device, $role_id, $range, $fd, $td );

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'login_history_data' => $login_history,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('login_history/login_history/index', $data);
    }

    
    
    
    
    public function read($id){
        $row = $this->Login_history_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'user_id' => $row->user_id,
		'login_time' => $row->login_time,
		'logout_time' => $row->logout_time,
		'ip' => $row->ip,
		'location' => $row->location,
		'browser' => $row->browser,
		'device' => $row->device,
	    );
            $this->viewAdminContent('login_history/login_history/read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'login_history'));
        }
    }

    /*
    public function create(){
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'login_history/create_action'),
	    'id' => set_value('id'),
	    'user_id' => set_value('user_id'),
	    'login_time' => set_value('login_time'),
	    'logout_time' => set_value('logout_time'),
	    'ip' => set_value('ip'),
	    'location' => set_value('location'),
	    'browser' => set_value('browser'),
	    'device' => set_value('device'),
	);
        $this->viewAdminContent('login_history/login_history/create', $data);
    }
    
    public function create_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'user_id' => $this->input->post('user_id',TRUE),
		'login_time' => $this->input->post('login_time',TRUE),
		'logout_time' => $this->input->post('logout_time',TRUE),
		'ip' => $this->input->post('ip',TRUE),
		'location' => $this->input->post('location',TRUE),
		'browser' => $this->input->post('browser',TRUE),
		'device' => $this->input->post('device',TRUE),
	    );

            $this->Login_history_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'login_history'));
        }
    }
    
    public function update($id){
        $row = $this->Login_history_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'login_history/update_action'),
		'id' => set_value('id', $row->id),
		'user_id' => set_value('user_id', $row->user_id),
		'login_time' => set_value('login_time', $row->login_time),
		'logout_time' => set_value('logout_time', $row->logout_time),
		'ip' => set_value('ip', $row->ip),
		'location' => set_value('location', $row->location),
		'browser' => set_value('browser', $row->browser),
		'device' => set_value('device', $row->device),
	    );
            $this->viewAdminContent('login_history/login_history/update', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'login_history'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'user_id' => $this->input->post('user_id',TRUE),
		'login_time' => $this->input->post('login_time',TRUE),
		'logout_time' => $this->input->post('logout_time',TRUE),
		'ip' => $this->input->post('ip',TRUE),
		'location' => $this->input->post('location',TRUE),
		'browser' => $this->input->post('browser',TRUE),
		'device' => $this->input->post('device',TRUE),
	    );

            $this->Login_history_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL. 'login_history'));
        }
    }

    */
    public function delete($id){
        $row = $this->Login_history_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'user_id' => $row->user_id,
		'login_time' => $row->login_time,
		'logout_time' => $row->logout_time,
		'ip' => $row->ip,
		'location' => $row->location,
		'browser' => $row->browser,
		'device' => $row->device,
	    );
            $this->viewAdminContent('login_history/login_history/delete', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'login_history'));
        }
    }


    public function delete_action($id){
        $row = $this->Login_history_model->get_by_id($id);

        if ($row) {
            $this->Login_history_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'login_history'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'login_history'));
        }
    }

    public function _rules(){
	$this->form_validation->set_rules('user_id', 'user id', 'trim|required');
	$this->form_validation->set_rules('login_time', 'login time', 'trim|required');
	$this->form_validation->set_rules('logout_time', 'logout time', 'trim|required');
	$this->form_validation->set_rules('ip', 'ip', 'trim|required');
	$this->form_validation->set_rules('location', 'location', 'trim|required');
	$this->form_validation->set_rules('browser', 'browser', 'trim|required');
	$this->form_validation->set_rules('device', 'device', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    

    public function graph_view(){
        
        $this->db->select( '*, COUNT(id) as count' );
        $this->db->from( 'login_history' );
        $this->db->group_by( 'browser' );
        $browsers  = $this->db->get()->result();
        
        $this->db->select( 'role_id,browser, id, COUNT(id) as role' );
        $this->db->from( 'login_history' );
        $this->db->group_by( 'role_id' );
        $roles = $this->db->get()->result();
        
    
        
        $this->db->select( 'device, COUNT(id) as devices' );
        $this->db->from( 'login_history' );
        $this->db->group_by( 'device' );
        $devices = $this->db->get()->result();
        
     
        
        $data['browsers'] = $browsers;
        $data['roles'] = $roles;
        $data['devices'] = $devices;
        
        $this->viewAdminContent('login_history/login_history/graph_view', $data);
        
        
    }

    
    public function getChart() {
        $day = [];
        for ($i = -15; $i <= 0; $i++) {
            $day[] = date('d M y', strtotime("+$i days "));
        }
        return json_encode($day);
    }

    public function getChartVendor() {
        $data = [];
        for ($i = -15; $i <= 0; $i++) {

            $date  = date('Y-m-d', strtotime("+$i day "));
            $data[] =  $this->countLoginVendor(3, $date );
        }
        return json_encode($data);
    }

    
    private function countLoginVendor($role_id = 0, $date = '0000-00-00'){
        
        $this->db->where('role_id', $role_id);
        $this->db->where('login_time <=', $date  . ' 23:59:59');
        $this->db->where('login_time <=', $date  . ' 23:59:59');
        return $this->db->get('login_history')->num_rows();
        
        
    }

        public function getChartCustomer() {
        $data = [];
        for ($i = -15; $i <= 0; $i++) {

            $date = date('Y-m-d', strtotime("+$i days "));
            $data[] = $this->countLoginVendor(4, $date );
        }
        return json_encode($data);
    }

    
    public function  bulk_action(){
       
        ajaxAuthorized();

        $log_ids = $this->input->post('log_id', TRUE);
        $action = $this->input->post('action', TRUE);
        
        if(count($log_ids) == 0 or empty($action) ){
            $message = '<p class="ajax_error">Please select at least one item and action.</p>';
            echo ajaxRespond('Fail', $message );
            exit;
        }
        
        switch ( $action ){            
            case 'Delete':                
                $this->deleteLogs($log_ids); 
                $message = '<p class="ajax_success">Marked Log Deleted Successfully</p>';
                break;           
        }
        echo ajaxRespond('OK', $message );
        
    }
    
    private function deleteLogs($log_ids = []){
        foreach ($log_ids as $log_id ){        
            $this->db->where('id', $log_id);
            $this->db->delete('login_history'); 
        }                
    }
    
    
    
}