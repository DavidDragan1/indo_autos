<?php defined('BASEPATH') OR exit('No direct script access allowed');

class _Frontend_controller extends MX_Controller {
	
    public function index(){
        
        
      
        
        $PageSlug   = empty($this->uri->segment(1)) ? 'home' : $this->uri->segment(1);        
                
        $MatchSearchTemplate = ['auction-cars', 'import-car', 'motorbike', 'spare-parts','vans'];        
        $PageSlug   = in_array($PageSlug, $MatchSearchTemplate) ?  'search' : $PageSlug ; 
	                 
        $cms        = $this->db->get_where('cms', ['post_url' => $PageSlug])->row_array();
        $post_type  = $cms['post_type'];
        

        
        
        if( $post_type == 'page'  ) {
            $this->getCmsPage($cms, $PageSlug);
            
        } elseif($post_type == 'business' ){
            $this->getBusinessPage($cms); 
            
        }  else {
            
           $this->viewFrontContent( 'frontend/404' );    
        }           
    }
    
    private function getBusinessPage( $seller_page = [] ){
        // $seller_page primary content coming form cms tbl 
        
        if(!$seller_page){
           $this->viewFrontContent('frontend/404' );
        } else {
            $user_id        = $seller_page['user_id'];            
            $seller_user    = $this->db->get_where('users', ['id' => $user_id])->row_array();                       
            $seller_meta    = GlobalHelper::getUserMetaData($user_id);
			
            $seller = [
                'seller' => $seller_page, 
                'user' => $seller_user, 
                'meta' => $seller_meta
              ];	
            
            $seller['meta_title']        = $seller_page['post_title'];
            $seller['meta_description']  = getShortContent($seller_page['seo_description'], 120);
            $seller['meta_keywords']     = $seller_page['seo_keyword'];
            
          
            $this->viewFrontContent('frontend/template/business_page', $seller );
        }                    
    }
    
    private function getCmsPage( $cms, $PageSlug = ''){
        
        // Try to hack simple page views      
        $viewTeamplatePath  = APPPATH . '/views/frontend/template/' . $PageSlug . '.php';
        $viewPath  = (file_exists( $viewTeamplatePath ))
                ? ('template/' .   $PageSlug )
                : 'template/page';

        
       
        $cms_page                       = [ 'cms' => $cms ] ;
        $cms_page['meta_title']         = $cms['seo_title'];
        $cms_page['meta_description']   = getShortContent($cms ['seo_description'], 120);
        $cms_page['meta_keywords']      = $cms ['seo_keyword'];
        
       // dd($cms_page);
        
        $this->viewFrontContent( 'frontend/' . $viewPath, $cms_page );    
        
    }


    public function viewMemberContent($view, $data = []){
        $this->load->view('frontend/header');              
        $this->load->view($view, $data);        
        $this->load->view('frontend/footer');
    } 

    
    public function viewFrontContent($view, $data = []){
        $this->load->view('frontend/header', $data);       
        $this->load->view($view, $data);
        $this->load->view('frontend/footer');
    }
            
}
