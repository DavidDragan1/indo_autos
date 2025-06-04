<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Driver extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->user_id = getLoginUserData('user_id');
    }

    public function availability($id)
    {
        $start = intval($this->input->get('start'));
        $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'DESC';
        $config['per_page'] = 10;
        $config['base_url'] = Backend_URL . 'users/availability/' . $id;
        $config['first_url'] = Backend_URL . 'users/availability/' . $id;
        $this->db->from('driver_times')->where(['user_id' => $id]);
        $config['total_rows'] = $this->db->count_all_results('', FALSE);
        $items = $this->db->order_by('id', $order)->limit($config['per_page'], $start)->get()->result();
        $this->pagination->initialize($config);
        $driver = $this->db->from('drivers')->where(['user_id' => $id])->get()->row();
        if (empty($driver)) {
            $this->session->set_flashdata('error', 'Driver\'s profile not found.');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $data = [
            'items' => $items,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'user_id' => $id,
            'driver' => $driver,
        ];

        $this->viewAdminContent('users/drivers/availability/index', $data);
    }

    public function addAvailability($id)
    {
        $data = [
            'action' => 'admin/users/availability-add-action',
            'name' => '',
            'user_id' => $id,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'button' => 'Add',
        ];

        $this->viewAdminContent('users/drivers/availability/create', $data);
    }

    public function addAvailabilityAction()
    {
        $data = [
            'name' => $this->input->post('name'),
            'user_id' => $this->input->post('user_id'),
            'term' => $this->input->post('term'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
        ];
        $this->db->insert('driver_times', $data);

        $this->session->set_flashdata('message', 'Availability is added successfully');
        redirect(site_url(Backend_URL . 'users/availability/' . $data['user_id']));
    }


    public function availabilityUpdate($id)
    {
        $row = $this->db->get_where('driver_times', ['id' => $id])->row();
        if (!empty($row)) {
            $data = [
                'action' => 'admin/users/availability-update-action',
                'name' => $row->name,
                'term' => $row->term,
                'start_date' => $row->start_date,
                'end_date' => $row->end_date,
                'id' => $row->id,
                'user_id' => $row->user_id,
                'button' => 'Update',
            ];
            $this->viewAdminContent('users/drivers/availability/update', $data);
        } else {
            $this->session->set_flashdata('error', 'No Data Found');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    function availabilityUpdateAction()
    {
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'user_id' => $this->input->post('user_id'),
            'term' => $this->input->post('term'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
        ];

        $this->db->where('id', $id);
        $this->db->update('driver_times', $data);

        $this->session->set_flashdata('message', 'Availability is updated');
        redirect(site_url(Backend_URL . 'users/availability/' . $data['user_id']));
    }

    public function availabilityDelete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('driver_times');
        $this->session->set_flashdata('message', 'Availability Row Deleted');
        redirect($_SERVER['HTTP_REFERER']);
    }

    function changeAvailabilityStatus($user_id)
    {
        $exist = $this->db->get_where('drivers', ['user_id' => $user_id])->row();

        if ($exist->status != 'Job Running') {
            $this->db->where('id', $exist->id);
            $this->db->update('drivers', ['status' => $exist->status == 'Available' ? 'Unavailable' : 'Available']);
            $this->session->set_flashdata('message', 'Status is updated');
        } else {
            $this->session->set_flashdata('error', 'You can\'t change the status right now');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
}
