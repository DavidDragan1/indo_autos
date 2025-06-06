<?php defined('BASEPATH') OR exit('No direct script access allowed');


class DriversApi extends Frontend_controller
{
    public function driver_join() {
        try {
            $data = $_POST;
            $email = $this->db->where('email', $data['email'])->get('drivers')->row();
            if ($email) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Email already exists.',
                    'data' => null
                ]);
            }
            $phone = $this->db->where('phone', $data['phone'])->get('drivers')->row();
            if ($phone) {
                return apiResponse([
                    'status' => false,
                    'message' => 'Phone number already exists.',
                    'data' => null
                ]);
            }
            $salary = explode("-", $data['salary']);
            $age = explode("-", $data['age']);
            $code = "CD-" . GlobalHelper::randomNumber(6);
            $data = array(
                'name' => $data['name'],
                'years_of_experience' => $data['years_of_experience'],
                'min_age' => $age[0],
                'max_age' => $age[1],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'min_salary' => $salary[0],
                'max_salary' => $salary[1],
                'vehicle_type_id' => $data['vehicle_type_id'],
                'license_type' => $data['license_type'],
                'city' => $data['location_id'],
                'marital_status' => $data['married'],
                'education_type' => $data['education_type'],
                'driver_track_id' => $code
            );

            $this->db->insert('drivers', $data);
            Modules::run('mail/driver_join_request', $data);

            return apiResponse([
                'status' => true,
                'message' => 'Application successfully submitted. One of our agents will contact you for the next step.',
                'data' => null
            ]);
        } catch (\Exception $exception) {
            return apiResponse([
                'status' => false,
                'message' => 'Something went wrong',
                'data' => null
            ]);
        }
    }

    public function driver_list(){
        $data = $_GET;
        if (isset($data['search'])) {
            $driver_marital_status = [
                1 => "Single",
                2 => "Married",
                3 => "Divorced"
            ];
            $education_type_array = [
                1 => "Primary",
                2 => "Secondary",
                3 => "NCE",
                4 => "OND",
                5 => "HND",
                6 => "Degree",
            ];
            $keys = explode(" ", $data['search']);
            $this->db->select('drivers.*, post_area.name as location_name');
            $this->db->where('status', 1);
            if ($keys[0] != "") {
                foreach ($keys as $value) {
                    $marital_status = $this->arrayLikeSearch($driver_marital_status, $value);
                    $education_type = $this->arrayLikeSearch($education_type_array, $value);
                    if (!empty($marital_status)) {
                        $this->db->where('drivers.marital_status', $marital_status);
                    }
                    if (!empty($education_type)) {
                        $this->db->where('drivers.education_type', $education_type);
                    }
                    $this->db->group_start();
                    $this->db->like('drivers.email', $value, 'both');
                    $this->db->or_like('drivers.phone', $value, 'both');
                    $this->db->or_like('drivers.name', $value, 'both');
                    $this->db->or_like('driver_track_id', $value, 'both');
                    $this->db->or_like('post_area.name', $value, 'both');
                    $this->db->group_end();
                }
            }
            $results = $this->db->join('post_area', 'drivers.city = post_area.id', 'LEFT')
                ->order_by('drivers.name', 'ASC')->get('drivers')->result();
        }  elseif (!empty($data))  {
            $search = [
                'passed_theory_test' => $data['theory_test'],
                'medical_check_passed' => $data['medical_check_passed'],
                'driver_background_screening' => $data['driver_background_screening'],
                'background_screening' => $data['background_screening'],
                'education_type' => $data['education_type'],
                'vehicle_type_id' => $data['vehicle_type_id'],
            ];
            $age = explode("-", $data['age']);
            $salary = explode("-", $data['search_salary_range']);
            $results = $this->db->select('drivers.*, post_area.name as location_name')
                ->where($search)
                ->where('min_age >=', (int) $age[0])
                ->where('min_age <=', (int) $age[1])
                ->where('max_age >=', (int) $age[0])
                ->where('max_age <=', (int) $age[1])
                ->where('min_salary >=', (int) $salary[0])
                ->where('min_salary <=', (int) $salary[1])
                ->where('max_salary >=', (int) $salary[0])
                ->where('max_salary <=', (int) $salary[1])
                ->where('status', 1)
                ->join('post_area', 'drivers.city = post_area.id', 'LEFT')
                ->order_by('name', 'ASC')->get('drivers')->result();
        } else {
            $results = $this->db->select('drivers.*, post_area.name as location_name')
                ->where('status', 1)
                ->join('post_area', 'drivers.city = post_area.id', 'LEFT')
                ->order_by('name', 'ASC')->get('drivers')->result();
        }
        $result['drivers'] = $results;

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $result
        ]);
    }

    public function hire_driver($id)
    {
        $code = "CH-" . GlobalHelper::randomNumber(6);
        $token = $this->input->server('HTTP_TOKEN');
        $dbToken = null;
        if ($token) {
            $dbToken = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }
        $user_id = ($dbToken) ? $dbToken->user_id : 0;
        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }
        $user = $this->db->get_where('users', ['id' => $user_id])->row();
        $userId = $user_id;
        $email = $user->email;
        $this->db->where(['id' => $id])->update('drivers', ['status' => 3, 'hired_by' => $userId, 'driver_hire_tracking_id' => $code]);
        Modules::run('mail/driver_hire_request', ['code' => $code, 'email' => $email]);

        return apiResponse([
            'status' => true,
            'message' => 'Your driver hire request has been submitted successfully',
            'data' => null
        ]);
    }

    public function driver_requirement_service()
    {
        $data = $this->db->where('label', 'RequirementService')->get('settings')->row();
        $value = "";
        if (!empty($data)) {
            $value = $data->value;
        }

        return apiResponse([
            'status' => true,
            'message' => '',
            'data' => $value
        ]);
    }

    public function driver_hire_request()
    {
        $code = "CH-" . GlobalHelper::randomNumber(6);
        $data = $_POST;
        $token = $this->input->server('HTTP_TOKEN');
        $dbToken = null;
        if ($token) {
            $dbToken = $this->db->get_where('user_tokens', ['token' => $token])->row();
        }
        $user_id = ($dbToken) ? $dbToken->user_id : 0;
        if (empty($user_id)) {
            return apiResponse([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null
            ]);
        }
        $user = $this->db->get_where('users', ['id' => $user_id])->row();
        $userId = $user_id;
        $email = $user->email;
        $insert = [
            'user_id' => $userId,
            'age' => $data['age'],
            'vehicle_type_id' => $data['vehicle_type_id'],
            'service_type' => $data['service_type'],
            'marital_status' => $data['marital_status'],
            'education_type' => $data['education_type'],
            'years_of_experience' => $data['year_of_experience'],
            'periods' => $data['periods'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'number_of_drivers' => $data['number_of_drivers'],
            'accommodation' => $data['accommodation'],
            'driver_hire_tracking_id' => $code
        ];

        if ($data['accommodation']) {
            $insert['state'] = $data['state'];
            $insert['city'] = $data['city'];
        }

        $this->db->insert('driver_hire_request', $insert);
        Modules::run('mail/driver_hire_request', ['email' => $email, 'code' => $code]);

        return apiResponse([
            'status' => true,
            'message' => 'Your driver hire request has been submitted successfully',
            'data' => null
        ]);
    }

    private function arrayLikeSearch($array = [], $search = "")
    {
        $result = array_filter($array, function ($item) use ($search) {
            if (preg_match('/\b' . preg_quote($search) . '\b/', $item)) {
                return true;
            }
            return false;
        });

        return empty(array_keys($result)) ? null : array_keys($result)[0];
    }
}
