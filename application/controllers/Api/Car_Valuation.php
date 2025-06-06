<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Car_Valuation extends Frontend_controller
{
    public function get_vehicle_variant()
    {
        $data = [];
        if (!empty($this->input->post('vehicle_type_id', TRUE))) {
            $data['vehicle_type_id'] = $this->input->post('vehicle_type_id', TRUE);
        }

        if (!empty($this->input->post('brand_id', TRUE))) {
            $data['brand_id'] = $this->input->post('brand_id', TRUE);
        }

        if (!empty($this->input->post('model_id', TRUE))) {
            $data['model_id'] = $this->input->post('model_id', TRUE);
        }

        if (!empty($this->input->post('manufacture_year', TRUE))) {
            $data['manufacturing_year'] = $this->input->post('manufacture_year', TRUE);
        }
        $results = $this->db->select('id, variant_name')->where($data)
            ->order_by('variant_name', 'ASC')->get('vehicle_variants')->result();

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'variants' => $results
            ]
        ]);
    }

    public function get_body_condition()
    {
        $data = [];
        if (!empty($this->input->post('vehicle_type_id', TRUE))) {
            $data['vehicle_type_id'] = $this->input->post('vehicle_type_id', TRUE);
        }

        if (!empty($this->input->post('brand_id', TRUE))) {
            $data['brand_id'] = $this->input->post('brand_id', TRUE);
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

        $results = $this->db->select('vehicle_valuation_grade_percentage_settings.id, vehicle_valuation_grade_percentage_settings.name')->where($data)
            ->join('vehicle_valuation_grade_percentage_settings', 'vehicle_valuation_grade_percentage_settings.vehicle_valuation_id = vehicle_valuation_settings.id')
            ->order_by('percentage', 'ASC')->get('vehicle_valuation_settings')->result();

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => [
                'conditions' => $results
            ]
        ]);
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
            return apiResponse([
                'status' => false,
                'message' => 'No settings found',
                'data' => null
            ]);
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

        return apiResponse([
            'status' => true,
            'message' => "",
            'data' => [
                'min_price' => $minPrice,
                'max_price' => $maxPrice
            ]
        ]);
    }

    public function car_valuation_v1()
    {
        $vehicel_type_id = 1;
        $brand_id = $this->input->post('brand_id');
        $model_id = $this->input->post('model_id');
        $year = $this->input->post('year');
        $millage_from = $this->input->post('millage_from');
        $millage_to = $this->input->post('millage_to');

        if (empty($year) || empty($brand_id) || empty($model_id) || $millage_to < 0 || $millage_from < 0) {
            return apiResponse([
                'status' => false,
                'message' => 'Please Fill All Field',
                'data' => []
            ]);
        }

        $brand = $this->db->select('name, slug')->get_where('brands', ['id' => $brand_id])->row();
        $model = $this->db->select('name, slug')->get_where('brands', ['id' => $model_id])->row();

        if (empty($brand) || empty($model)) {
            return apiResponse([
                'status' => false,
                'message' => 'Something went wrong',
                'data' => []
            ]);
        }

        $ci = &get_instance();
        $average_amount = $ci->db->select('MIN(priceinnaira) as min, MAX(priceinnaira) as max, condition')
            ->where(['vehicle_type_id' => $vehicel_type_id, 'brand_id' => $brand_id, 'model_id' => $model_id, 'manufacture_year' => $year])
            ->where(['mileage >=' => $millage_from, 'mileage <=' => $millage_to])
            ->group_by('condition')
            ->get('posts')
            ->result();
        if (empty($average_amount)) {
            return apiResponse([
                'status' => false,
                'message' => 'No Data Available',
                'data' => []
            ]);
        }

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $average_amount
        ]);

    }
}
