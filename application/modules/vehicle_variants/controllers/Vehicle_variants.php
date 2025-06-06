<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Vehicle_variants extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Vehicle_variants_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $vehicle_variants = $this->Vehicle_variants_model->get_all();

        $data = array(
            'vehicle_variants_data' => $vehicle_variants
        );

        $this->viewAdminContent('vehicle_variants/index', $data);
    }

    public function read($id)
    {
        $row = $this->Vehicle_variants_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'name' => $row->name,
            );
            $this->viewAdminContent('vehicle_variants/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'vehicle_variants'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'vehicle_variants/create_action'),
            'id' => set_value('id'),
            'name' => set_value('name'),
        );
        $this->viewAdminContent('vehicle_variants/form', $data);
    }

    public function create_action()
    {
        $data = array(
            'variant_name' => $this->input->post('name', TRUE),
            'vehicle_type_id' => $this->input->post('vehicle_type_id', TRUE),
            'vehicle_condition' => $this->input->post('vehicle_condition', TRUE),
            'brand_id' => $this->input->post('brand_id', TRUE),
            'model_id' => $this->input->post('model_id', TRUE),
            'manufacturing_year' => $this->input->post('manufacturing_year', TRUE),
        );

        $this->Vehicle_variants_model->insert($data);
        $this->session->set_flashdata('success', 'Create Record Success');
        redirect(site_url(Backend_URL . 'vehicle_variants'));
    }

    public function update($id)
    {
        $row = $this->Vehicle_variants_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'vehicle_variants/update_action'),
                'id' => set_value('id', $row->id),
                'variant_name' => set_value('name', $row->variant_name),
                'vehicle_type_id' => set_value('name', $row->vehicle_type_id),
                'vehicle_condition' => set_value('name', $row->vehicle_condition),
                'brand_id' => set_value('name', $row->brand_id),
                'model_id' => set_value('name', $row->model_id),
                'manufacturing_year' => set_value('name', $row->manufacturing_year),
            );
            $this->viewAdminContent('vehicle_variants/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'vehicle_variants'));
        }
    }

    public function update_action()
    {
        $data = array(
            'variant_name' => $this->input->post('name', TRUE),
            'vehicle_type_id' => $this->input->post('vehicle_type_id', TRUE),
            'vehicle_condition' => $this->input->post('vehicle_condition', TRUE),
            'brand_id' => $this->input->post('brand_id', TRUE),
            'model_id' => $this->input->post('model_id', TRUE),
            'manufacturing_year' => $this->input->post('manufacturing_year', TRUE),
        );

        $this->Vehicle_variants_model->update($this->input->post('id', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url(Backend_URL . 'vehicle_variants'));
    }

    public function delete($id)
    {
        $row = $this->Vehicle_variants_model->get_by_id($id);

        if ($row) {
            $this->Vehicle_variants_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url(Backend_URL . 'vehicle_variants'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'vehicle_variants'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('name', 'name', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}