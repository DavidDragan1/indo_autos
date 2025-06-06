<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Shipping_user extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library("pagination");
        $this->user_id = getLoginUserData('user_id');
    }

    public function index($id){
        $start = intval($this->input->get('start'));
        $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'DESC';
        $config['per_page'] = 10;
        $config['base_url'] = Backend_URL . 'users/shipping-agent-product/'.$id;
        $config['first_url'] = Backend_URL . 'users/shipping-agent-product/'.$id;
        $this->db->from('shipping_product')->where(['user_id' => $id]);
        $config['total_rows'] = $this->db->count_all_results('', FALSE);
        $products = $this->db->order_by('id', $order)->limit($config['per_page'], $start)->get()->result();

        $this->pagination->initialize($config);
        $data = [
            'products' => $products,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows']
        ];
        $this->viewAdminContent('users/shipping/index', $data);
    }

    public function product_create(){
        $data = [
            'action' => 'admin/shipping/product_create_action',
            'vehicle_type_id' => 1,
            'title' => '',
            'shipping_port' => 0,
            'destination_port' => 0,
            'condition' => '',
            'year' => date('Y'),
            'to_year' => date('Y'),
            'description' => '',
            'shipping_amount' => 0,
            'clearing_amount' => 0,
            'ground_logistics_amount' => 0,
            'vat_amount' => 0,
            'total_amount' => 0,
            'id' => 0,
            'brand_id' => 0,
            'model_id' => 0

        ];
        $this->viewAdminContentPrivate('clearing/product_form', $data);
    }

    public function update($id){
        $row = $this->db->get_where('shipping_product', ['id' => $id])->row();
        if (!empty($row)){
            $data = [
                'action' => 'admin/users/shipping-agent-product/create-action',
                'vehicle_type_id' => $row->vehicle_type_id,
                'title' => $row->title,
                'shipping_port' => $row->shipping_port,
                'destination_port' => $row->destination_port,
                'condition' => $row->condition,
                'year' => $row->year,
                'to_year' => $row->to_year,
                'description' => $row->description,
                'clearing_amount' => $row->clearing_amount,
                'shipping_amount' => $row->shipping_amount,
                'ground_logistics_amount' => $row->ground_logistics_amount,
                'vat_amount' => $row->vat_amount,
                'total_amount' => $row->total_amount,
                'id' => $row->id,
                'brand_id' => $row->brand_id,
                'model_id' => $row->model_id,
                'user_id' => $row->user_id,
                'product_status' => $row->product_status,

            ];
            $this->viewAdminContent('users/shipping/update', $data);
        } else {
            $this->session->set_flashdata(['status' => 'error', 'message' => 'No Data Found']);
            redirect(site_url( Backend_URL. 'shipping/product'));
        }

    }

    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('shipping_product');
        $this->session->set_flashdata('message', 'The Row Deleted');
        redirect($_SERVER['HTTP_REFERER']);
    }

    function create_action (){
        $msg = '';
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $shipping_port = $this->input->post('shipping_port');
        $destination_port = $this->input->post('destination_port');
        $vehicle_type_id = $this->input->post('vehicle_type_id');
        $condition = $this->input->post('condition');
        $brand_id = $this->input->post('brand_id');
        $model_id = $this->input->post('model_id');
        $year = $this->input->post('year');
        $to_year = $this->input->post('to_year');
        $description = $this->input->post('description');
        $clearing_amount = $this->input->post('clearing_amount');
        $shipping_amount = $this->input->post('shipping_amount');
        $ground_logistics_amount = $this->input->post('ground_logistics_amount');
        $vat_amount = $this->input->post('vat_amount');
        $total_amount = $clearing_amount + $ground_logistics_amount + $vat_amount + $shipping_amount;

        $data = [
            'title' => $title,
            'user_id' => $this->input->post('user_id'),
            'product_status' => $this->input->post('product_status'),
            'shipping_port' => $shipping_port,
            'destination_port' => $destination_port,
            'vehicle_type_id' => $vehicle_type_id,
            'condition' => $condition,
            'brand_id' => $brand_id,
            'model_id' => $model_id,
            'year' => $year,
            'to_year' => $to_year,
            'description' => $description,
            'clearing_amount' => $clearing_amount,
            'shipping_amount' => $shipping_amount,
            'ground_logistics_amount' => $ground_logistics_amount,
            'vat_amount' => $vat_amount,
            'total_amount' => $total_amount
        ];

        if (!empty($id)){
            $this->db->where('id', $id);
            $this->db->update('shipping_product', $data);
            $msg = 'Product Updated';
        } else {
            $this->db->insert('shipping_product', $data);
            $msg = 'Product created';
        }

        $this->session->set_flashdata('message' , $msg);
        redirect(site_url( Backend_URL. 'users/shipping-agent-product/'.$data['user_id']));
    }


}