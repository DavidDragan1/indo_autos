<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Newsletter_frontend_subscriber
class Newsletter_subscriber_frontview extends Frontend_controller  {

    function __construct() {
        $this->load->model('Newsletter_subscriber_model');               
    }
    
 
    public function create_action_ajax() {
        ajaxAuthorized();
        $email_address = $this->input->post('email', TRUE);

        if ( !filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            echo ajaxRespond('Fail','Invalide Email Address');
            exit;
        }

        $exists=$this->Newsletter_subscriber_model->isExists($email_address);

        if($exists){
                $subscribed = $this->Newsletter_subscriber_model->check($email_address);
                if($subscribed != 'Subscribe') {
                    $data = array(
                        'status' => 'Subscribe',
                        'modified' => date('Y-m-d H:i:s')
                    );
                    $subscribed= intval($subscribed);
                    $this->Newsletter_subscriber_model->update($subscribed, $data);
                }else{
                    echo ajaxRespond('FAIL','Already Subscribed');
                    exit;
                }
        }else{
                $data = array(
                    'email'     => $email_address,
                    'status'    => 'Subscribe',
                    'created'   => date('Y-m-d H:i:s'),
                    'modified'  => date('Y-m-d H:i:s')
                );
                $this->Newsletter_subscriber_model->insert($data);
        }

            $encoded_email= base64_encode($email_address);

        /*$galleryPhotos =  Modules::run('mails/mails_frontend/sendEmailFromFrontend',compact('filter'));*/

//            if($this->sendEmailFromTeamplateWithFilterAjax($email_address, 'onNewsletterSubscription', $filter)){
//            /*if(Modules::run('mails/mails_frontend/sendEmailFromFrontendTest',compact('filter'))){*/
//                
                Modules::run('mail/subscribe', $email_address );
                
                
                echo ajaxRespond('OK','<p class="ajax_success">Subscribe Successfully! Check Your Email.</p>');
//            }else{
//                echo ajaxRespond('OK','Subscribe Successfully');
//            }

    }    
      
    public function unsubscribe() {
        
        $email          = $this->input->get('e', TRUE);
        $encoded_email  = base64_decode($email);
        $user           = $this->Newsletter_subscriber_model->get_by_email($encoded_email);
        
        if($user->status=='Unsubscribe'){
            $message="You are already Unscubscribed";
            $this->viewFrontContent('newsletter_subscriber/unsubscribe',compact('user','message'));
        }else{
            $data = array(
                'status' => 'Unsubscribe'
            );
            
            
            $this->db->set('status', 'Unsubscribe');
            $this->db->where('email', $email );
            $this->db->update('newsletter_subscriber');

          // $this->Newsletter_subscriber_model->update_by_email($encoded_email, $data);
            
            $message = "Successfully Unscubscribed";
            $this->viewFrontContent('newsletter_subscriber/unsubscribe',compact('user','message'));
        }

    }

}
