<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2017-02-01
 */

class Listing_bill extends Admin_controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Listing_bill_model');
        $this->load->helper('listing_package');

        $this->user_id = getLoginUserData('user_id');
        $this->role_id = getLoginUserData('role_id');
        $this->manage_all = checkPermission('posts/manage_all', $this->role_id);
    }

    public function index() {
        if ($this->manage_all == true) {
            $this->user_id = 0;
        }

        $start = intval($this->input->get('start'));
        $q = urldecode($this->input->get('q', TRUE)?$this->input->get('q', TRUE):'');

        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'posts/bill/?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'posts/bill/?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'posts/bill/';
            $config['first_url'] = Backend_URL . 'posts/bill/';
        }

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Listing_bill_model->total_rows($this->user_id);
        $listing_bill = $this->Listing_bill_model->get_limit_data($config['per_page'], $this->user_id, $start);
        $role_id = getLoginUserData('role_id');

        if ($role_id == 1 || $role_id == 2) {
            $this->load->library('pagination');
            $this->pagination->initialize($config);

            $data = array(
                'listing_bill_data' => $listing_bill,
                'pagination' => $this->pagination->create_links(),
                'total_rows' => $config['total_rows'],
                'start' => $start,
            );

            $this->viewAdminContent('listing_bill/index', $data);
        } else {
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

            $config['per_page'] = 10;

            $config['total_rows'] = $this->db->where('user_id', $this->user_id);

            if ($q) {
                $config['total_rows'] = $config['total_rows']->like('price', $q)->or_like('id', $q)->or_like('payment_status', $q);
            }

            $config['total_rows'] = $config['total_rows']->from('listing_package');
            $config['total_rows'] = $config['total_rows']->count_all_results();

            $listing_bill =  $this->db->where('user_id', $this->user_id)->order_by('listing_id', 'DESC');

            if ($q) {
                $listing_bill = $listing_bill->like('price', $q)->or_like('id', $q)->or_like('payment_status', $q);
            }

            $listing_bill = $listing_bill->limit($config['per_page'], $start)->get('listing_package')->result();

            $this->load->library('pagination');
            $this->pagination->initialize($config);

            $data = array(
                'listing_bill_data' => $listing_bill,
                'pagination' => $this->pagination->create_links(),
                'total_rows' => $config['total_rows'],
                'start' => $start,
            );

            $this->viewNewAdminContent('listing_bill/trader_index', $data);
        }
    }

    public function preview($id) {
        $row = $this->Listing_bill_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'listing_id' => $row->listing_id,
                'package_id' => $row->package_id,
                'payment_status' => $row->payment_status,
                'price' => $row->price,
                'payment_method' => $row->payment_method,
                'payment_details' => $row->payment_details,
                'status' => $row->status,
                'created' => $row->created,
                'modified' => $row->modified,
            );
            $role_id = getLoginUserData('role_id');

            if ($role_id == 1 || $role_id == 2) {
                $this->viewAdminContent('listing_bill/view', $data);
            } else {
                $this->viewNewAdminContent('listing_bill/trader_view', $data);
            }

        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'listing_bill'));
        }
    }

    public function update($id) {
        $this->db->update('listing_package', array('payment_status' => 'Paid'), array('id' => $id));
        $this->session->set_flashdata('message', '<p class="ajax_success">Successfully Updated.</p>');
        redirect(site_url(Backend_URL . 'posts/bill'));
        //$row = $this->Listing_bill_model->get_by_id($id);
    }
}
