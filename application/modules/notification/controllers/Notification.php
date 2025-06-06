<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 8th Oct 2016
 */

class Notification extends Admin_controller
{

    function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->load->library('session');
        $this->session->keep_flashdata(array('status', 'message'));
    }

    public function notification_view()
    {
        $user_id = getLoginUserData('user_id');
        $start = intval($this->input->get('start'));
        $config['per_page'] = 10;
        $config['base_url'] = Backend_URL . 'notification';
        $config['first_url'] = Backend_URL . 'notification';
        $config['total_rows'] = $this->db->where(['user_id' => $user_id])->from('user_notifications')->count_all_results();

        $notifications =  $this->db->where(['user_id' => $user_id])
            ->order_by('id', 'DESC')
            ->limit($config['per_page'], $start)
            ->get('user_notifications')->result();

        $this->pagination->initialize($config);


        $data = [
            'notifications' => $notifications,
            'pagination' => $this->pagination->create_links(),
        ];

        $this->viewNewAdminContent('notification/notifications', $data);
    }


    public function delete_notification($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_notifications');

        $this->session->set_flashdata(['status' => 'success', 'message' => 'Delete successfully.']);

        redirect('admin/notification', 'refresh');

    }


    public function add_notification()
    {
        $user_id = getLoginUserData('user_id');

        $type_id = $this->input->post('type_id');
        $brand_id = $this->input->post('brand_id');
        $model_id = $this->input->post('model_id');
        $location_id = $this->input->post('location_id');
        $year = $this->input->post('year');
        $parts_description = $this->input->post('parts_description');


        $check = $this->db->where('user_id', getLoginUserData('user_id'))->count_all_results('user_notifications');
        if ($check >= 2) {
            $this->session->set_flashdata(['status' => 'error', 'message' => 'Your alert limit exceeded. please remove one first']);

            redirect('admin/notification', 'refresh');
        }


        $data = array(
            'user_id' => $user_id,
            'type_id' => $type_id,
            'brand_id' => $brand_id,
            'model_id' => $model_id,
            'location_id' => $location_id,
            'year' => $year,
            'parts_description' => $parts_description
        );

        $this->db->insert('user_notifications', $data);

        $this->session->set_flashdata(['status' => 'success', 'message' => 'Added successfully.']);

        redirect('admin/notification', 'refresh');

    }


}
