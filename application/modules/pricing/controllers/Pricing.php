<?php
class Pricing extends Admin_controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function create()
    {
        $data =[
            'button'=>'Create',
            'action'=>'asf',
            'name'=>'',
            'id'=>0
        ];
        $this->viewAdminContent('pricing/create',$data);
    }

    public function create_action()
    {

            $name = $this->input->post('name',true);
            $packageType = $this->input->post('package_type',true);
            $duration = $this->input->post('duration',true);
            $price = $this->input->post('price',true);
            $description = $this->input->post('description',true);
            $featureDescription = $this->input->post('feature_description',true);
            $featureExtra = $this->input->post('feature_extra',true);
            $features = [];
            if (!empty($featureDescription)){
                for ($i = 0; $i < count($featureDescription);$i++){
                    $x = [
                        'feature_description'=>@$featureDescription[$i],
                        'feature_extra'=>@$featureExtra[$i]
                    ];
                    $features[] = $x;
                }
            }
            $data = [
                'name'=>$name,
                'package_type'=>$packageType,
                'duration'=>$duration,
                'price'=>$price,
                'description'=>$description,
                'feature_description'=>json_encode($features),
                'created'=>date('Y-m-d')
            ];
            $this->db->insert('pricing',$data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'pricing'));
        }

//    private function _rules(){
//        $this->form_validation->set_rules('name', 'name', 'trim|required');
//        $this->form_validation->set_rules('package_type', 'Package type', 'trim|required');
//        $this->form_validation->set_rules('duration', 'Duration', 'trim|required');
//        $this->form_validation->set_rules('price', 'Price', 'trim|required');
//        $this->form_validation->set_rules('description', 'Description', 'trim|required');
//        $this->form_validation->set_rules('id', 'id', 'trim');
//        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
//    }
}