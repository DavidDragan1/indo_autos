<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Vehicle_valuation_settings extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Vehicle_valuation_settings_model');
        $this->load->model('Vehicle_valuation_percentage_settings_model');
        $this->load->model('Vehicle_valuation_grade_percentage_settings');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->db->select('vehicle_valuation_settings.*, vehicle_types.name as type_name, brands.name as brand_name, model.name as model_name, vehicle_variants.variant_name');
        $this->db->from('vehicle_valuation_settings');
        $this->db->join('vehicle_types', 'vehicle_types.id = vehicle_valuation_settings.vehicle_type_id', 'LEFT');
        $this->db->join('brands', 'brands.id = vehicle_valuation_settings.brand_id', 'LEFT');
        $this->db->join('brands as model', 'model.id = vehicle_valuation_settings.model_id', 'LEFT');
        $this->db->join('vehicle_variants', 'vehicle_variants.id = vehicle_valuation_settings.variant_id', 'LEFT');
        $vehicle_valuation_settings = $this->db->get()->result();

        $data = array(
            'vehicle_valuation_settings_data' => $vehicle_valuation_settings
        );

        $this->viewAdminContent('vehicle_valuation_settings/index', $data);
    }

    public function read($id)
    {
        $row = $this->Vehicle_valuation_settings_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'name' => $row->name,
            );
            $this->viewAdminContent('vehicle_valuation_settings/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'vehicle_valuation_settings'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'vehicle_valuation_settings/create_action'),
            'id' => set_value('id'),
            'name' => set_value('name'),
        );
        $this->viewAdminContent('vehicle_valuation_settings/form', $data);
    }

    public function create_action()
    {
        $data = array(
            'variant_id' => $this->input->post('vehicle_variant', TRUE),
            'vehicle_type_id' => $this->input->post('vehicle_type_id', TRUE),
            'vehicle_condition' => $this->input->post('vehicle_condition', TRUE),
            'brand_id' => $this->input->post('brand_id', TRUE),
            'model_id' => $this->input->post('model_id', TRUE),
            'manufacturing_year' => $this->input->post('manufacturing_year', TRUE),
            'minimum_price' => $this->input->post('minimum_price', TRUE),
            'maximum_price' => $this->input->post('maximum_price', TRUE),
        );

        $this->Vehicle_valuation_settings_model->insert($data);
        $this->session->set_flashdata('success', 'Create Record Success');
        redirect(site_url(Backend_URL . 'vehicle_valuation_settings'));
    }

    public function update($id)
    {
        $row = $this->Vehicle_valuation_settings_model->get_by_id($id);

        if ($row) {
            $ci = &get_instance();
            $mileages = $ci->db->where('vehicle_valuation_id', $id)->get('vehicle_valuation_percentage_settings')->result();
            $ci = &get_instance();
            $grades = $ci->db->where('vehicle_valuation_id', $id)->get('vehicle_valuation_grade_percentage_settings')->result();
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'vehicle_valuation_settings/update_action'),
                'id' => set_value('id', $row->id),
                'variant_id' => set_value('vehicle_variant', $row->variant_id),
                'vehicle_type_id' => set_value('vehicle_type_id', $row->vehicle_type_id),
                'vehicle_condition' => set_value('vehicle_condition', $row->vehicle_condition),
                'brand_id' => set_value('brand_id', $row->brand_id),
                'model_id' => set_value('model_id', $row->model_id),
                'manufacturing_year' => set_value('manufacturing_year', $row->manufacturing_year),
                'minimum_price' => set_value('minimum_price', $row->minimum_price),
                'maximum_price' => set_value('maximum_price', $row->maximum_price),
                'mileages' => $mileages,
                'grades' => $grades,
            );
            $this->viewAdminContent('vehicle_valuation_settings/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'vehicle_valuation_settings'));
        }
    }

    public function update_action()
    {
        $data = array(
            'variant_id' => $this->input->post('vehicle_variant', TRUE),
            'vehicle_type_id' => $this->input->post('vehicle_type_id', TRUE),
            'vehicle_condition' => $this->input->post('vehicle_condition', TRUE),
            'brand_id' => $this->input->post('brand_id', TRUE),
            'model_id' => $this->input->post('model_id', TRUE),
            'manufacturing_year' => $this->input->post('manufacturing_year', TRUE),
            'minimum_price' => $this->input->post('minimum_price', TRUE),
            'maximum_price' => $this->input->post('maximum_price', TRUE),
        );

        $this->Vehicle_valuation_settings_model->update($this->input->post('id', TRUE), $data);
        $this->session->set_flashdata('message', 'Update Record Success');
        redirect(site_url(Backend_URL . 'vehicle_valuation_settings'));
    }

    public function delete($id)
    {
        $row = $this->Vehicle_valuation_settings_model->get_by_id($id);

        if ($row) {
            $this->Vehicle_valuation_settings_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url(Backend_URL . 'vehicle_valuation_settings'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'vehicle_valuation_settings'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('name', 'name', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
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

    public function millage_settings_action()
    {
        $data = [];
        for ($i = 1; $i <= $this->input->post('total_rows', TRUE); $i++) {
            $fromFiled = 'from_' . $i;
            $toFiled = 'to_' . $i;
            $percentageFiled = 'percentage_' . $i;
            $mileageFiled = 'mileage_' . $i;
            if (!empty($this->input->post($fromFiled, TRUE)) && !empty($this->input->post($toFiled, TRUE)) && !empty($this->input->post($percentageFiled, TRUE))) {
                if (!empty($this->input->post($mileageFiled, TRUE))) {
                    $this->db->set('from', $this->input->post($fromFiled, TRUE));
                    $this->db->set('to', $this->input->post($toFiled, TRUE));
                    $this->db->set('percentage', $this->input->post($percentageFiled, TRUE));
                    $this->db->where('id', $this->input->post($mileageFiled, TRUE));
                    $this->db->update('vehicle_valuation_percentage_settings');
                } else {
                    $data[] = [
                        'vehicle_valuation_id' => $this->input->post('valuation_id', TRUE),
                        'from' => $this->input->post($fromFiled, TRUE),
                        'to' => $this->input->post($toFiled, TRUE),
                        'percentage' => $this->input->post($percentageFiled, TRUE),
                    ];
                }
            }
        }

        if (!empty($data)) {
            $this->db->insert_batch('vehicle_valuation_percentage_settings', $data);
        }

        redirect(site_url(Backend_URL . 'vehicle_valuation_settings/update/' . $this->input->post('valuation_id', TRUE)));
    }

    public function remove_millage_settings_action()
    {
        $id = $this->input->post('mileage_id', TRUE);
        $row = $this->Vehicle_valuation_percentage_settings_model->get_by_id($id);

        if ($row) {
            $this->Vehicle_valuation_percentage_settings_model->delete($id);

            echo json_encode([
               'status' => true,
               'message' =>'Deleted successfully'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }
    }

    public function grade_settings_action()
    {
        $data = [];
        for ($i = 1; $i <= $this->input->post('total_grade_rows', TRUE); $i++) {
            $nameFiled = 'name_' . $i;
            $percentageFiled = 'percentage_' . $i;
            $mileageFiled = 'grade_' . $i;
            if (!empty($this->input->post($nameFiled, TRUE)) && !empty($this->input->post($percentageFiled, TRUE))) {
                if (!empty($this->input->post($mileageFiled, TRUE))) {
                    $this->db->set('name', $this->input->post($nameFiled, TRUE));
                    $this->db->set('percentage', $this->input->post($percentageFiled, TRUE));
                    $this->db->where('id', $this->input->post($mileageFiled, TRUE));
                    $this->db->update('vehicle_valuation_grade_percentage_settings');
                } else {
                    $data[] = [
                        'vehicle_valuation_id' => $this->input->post('valuation_id', TRUE),
                        'name' => $this->input->post($nameFiled, TRUE),
                        'percentage' => $this->input->post($percentageFiled, TRUE),
                    ];
                }
            }
        }

        if (!empty($data)) {
            $this->db->insert_batch('vehicle_valuation_grade_percentage_settings', $data);
        }

        redirect(site_url(Backend_URL . 'vehicle_valuation_settings/update/' . $this->input->post('valuation_id', TRUE)));
    }

    public function remove_grade_settings_action()
    {
        $id = $this->input->post('grade_id', TRUE);
        $row = $this->Vehicle_valuation_grade_percentage_settings->get_by_id($id);

        if ($row) {
            $this->Vehicle_valuation_grade_percentage_settings->delete($id);

            echo json_encode([
                'status' => true,
                'message' =>'Deleted successfully'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }
    }
}