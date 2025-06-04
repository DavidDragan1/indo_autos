<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends Frontend_controller {
    // every thing coming form Frontend Controller

    public function preview( $slug ){
        $this->viewFrontContent( 'frontend/template/single' );
    }

    // business function moved to
    // app/core/frontend_controller.php as getBusinessPage();


    public function post( $slug = null ){
        $post    = $this->db->get_where('cms', ['post_url' => $slug, 'post_type' => 'post'])->row();



        if($post){

            $search  = array('&lt;', '&gt;');
            $replace = array('<', '>');
            $content = str_replace($search, $replace, $post->content);


            $new_post = array(
		'id' => $post->id,
		'user_id' => $post->user_id,
		'parent_id' => $post->parent_id,
		'post_type' => $post->post_type,
		'post_title' => $post->post_title,
		'post_url' => $post->post_url,
		'content' => $content,
		'seo_title' => $post->seo_title,
		'seo_keyword' => $post->seo_keyword,
		'seo_description' => $post->seo_description,
		'thumb' => $post->thumb,
		'created' => $post->created,
		'status' => $post->status,

	    );

            $this->viewFrontContent('frontend/post_single', $new_post );
        } else {
            $this->viewFrontContent('frontend/404' );
        }
    }

    public function getBrand(){
        $type_id  = $this->input->post('type_id');
        echo  GlobalHelper::getBrand( $type_id );
    }
    public function getModel(){
        // $type_id  = $this->input->post('type_id');
        $brand_id  = $this->input->post('brand_id');
        echo  GlobalHelper::getModel( $brand_id );
    }



    public function  cron(){

        $sql = "SELECT p.id, p.vehicle_type_id, p.brand_id, p.model_id , n.user_id, p.title, p.post_slug, 
                 u.email, u.first_name, n.location_id, n.year   FROM posts as p
                LEFT JOIN user_notifications as n ON (n.brand_id = p.brand_id AND n.type_id = p.vehicle_type_id AND n.model_id = p.model_id AND n.location_id = p.location_id AND n.year = p.manufacture_year )
                LEFT JOIN users as u ON n.user_id = u.id
                WHERE DATE(p.activation_date) = DATE(NOW() - INTERVAL 1 DAY) GROUP BY p.id" ;


        $new_posts = $this->db->query( $sql )->result();



        foreach ( $new_posts as $post ){

            $data = [
                'type_id' => GlobalHelper::getProductTypeById($post->vehicle_type_id),
                'brand_id' => GlobalHelper::getBrandNameById($post->brand_id),
                'model_id' => GlobalHelper::getModelNameById($post->model_id),
                'location_id' => GlobalHelper::getLocationById($post->location_id),
                'year' => $post->year,
                'title' => $post->title,
                'post_slug' => base_url('/post/').$post->post_slug,
                'email' => $post->email,
                'username' => $post->first_name,
            ];

            Modules::run('mail/subscribtion_notification', $data );
        }

    }




}
