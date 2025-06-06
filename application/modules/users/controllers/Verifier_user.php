<?php

class Verifier_user extends Admin_controller {
    protected $user_id;

    public function __construct()
    {
        parent::__construct();
        $this->user_id = getLoginUserData('user_id');
        $this->load->library('form_validation');
        $this->load->library("pagination");

    }


    public function create_product()
    {
        $verifier = $this->db->get_where('users', ['id' => getLoginUserData('user_id')])->row();
        $data = [
            'action'=>'admin/verifier/product_create_action',
            'button'=>'Create Product',
            'title' => '',
            'description' => '',
            'country_id'=>$verifier->country_id,
            'location_id'=>0,
            'total_amount'=>'',
            'id'=>0
        ];

        $this->viewAdminContentPrivate('backend/trade/template/verifiers/verifier_product_create_form', $data);
    }
    public function create_action()
    {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $country_id = $this->input->post('country_id');
        $location_id = $this->input->post('location_id');
        $total_amount = $this->input->post('total_amount');
        $description = $this->input->post('description');

        $data = [
            'title' => $title,
            'verifier_id' => $this->input->post('verifier_id'),
            'product_status' => $this->input->post('product_status'),
            'country_id' => $country_id,
            'location_id' => $location_id,
            'amount' => $total_amount,
            'description' => $description,
        ];

        if (!empty($id)){
            $this->db->where('id', $id);
            $this->db->update('verifier_product', $data);
            $msg = 'Product Updated';
        } else {

            $this->db->insert('verifier_product', $data);
            $msg = 'Product created';
        }

        $this->session->set_flashdata('message', $msg);
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function update($id)
    {
        $row = $this->db->get_where('verifier_product', ['id' => $id])->row();
//        pp($row);
        if (!empty($row)){
            $data = [
                'button'=>'Update Product',
                'action'=>'admin/users/verifier-agent-product/create-action',
                'title' => $row->title,
                'description' => $row->description,
                'country_id'=>$row->country_id,
                'location_id'=>$row->location_id,
                'total_amount'=>$row->amount,
                'id'=>$row->id,
                'verifier_id' => $row->verifier_id,
                'product_status' => $row->product_status
            ];
            $this->viewAdminContent('users/verifier/update', $data);
        } else {
            $this->session->set_flashdata(['status' => 'error', 'message' => 'No Data Found']);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('verifier_product');
        $this->session->set_flashdata('message' , 'The Row Deleted');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function index($id)
    {
        $start = intval($this->input->get('start'));

        $order = !empty($this->input->get('order')) ? $this->input->get('order') : 'DESC';

        $config['per_page'] = 10;
        $config['base_url'] = Backend_URL . 'users/verifier-agent-product/'.$id;
        $config['first_url'] = Backend_URL . 'users/verifier-agent-product/'.$id;
        $this->db->from('verifier_product')->where(['verifier_id' => $id]);
        $config['total_rows'] = $this->db->count_all_results('', FALSE);
        $products = $this->db->order_by('id', $order)->limit($config['per_page'], $start)->get()->result();

        $this->pagination->initialize($config);
        $data = [
            'products' => $products,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows']
        ];
        $this->viewAdminContent('users/verifier/index', $data);
    }


}