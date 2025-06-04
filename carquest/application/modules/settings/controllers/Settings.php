<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-11-17
 */

class Settings extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Settings_model');
        $this->load->helper('settings');        
    }

    public function index(){
       
        $data = ['settings_data' => $this->Settings_model->get_all()];                
        $this->viewAdminContent('settings/index', $data);
    }
    public function items(){
       
        $data = ['settings_data' => $this->Settings_model->get_all()];                
        $this->viewAdminContent('settings/list', $data);
    }
   
    
    public function update(){        
        ajaxAuthorized();        
        $settings = $this->input->post('data');                
        
        foreach($settings as $label=>$value ){

            if($label == 'Maintenance') {

                if($value == '1') {
                    $value = '|1|';
                    if(!empty($settings[$label.'_time'])) {
                        $maintenance_datetime = date('Y-m-d H:i:s',strtotime($settings[$label.'_time']));
                        $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $maintenance_datetime, $this->input->post('local_time_zone_offset', TRUE));
                        $date->setTimezone('UTC');
                        $maintenance_datetime = $date->format('Y-m-d H:i:s');
                        $value = '|1|'.$maintenance_datetime.'|';
                    }
                }
                else {
                    $value = '';
                }
            }

            $this->db->where('label', $label)->update('settings', ['value' => $value ]);
        }        
        echo ajaxRespond('OK', '<p class="ajax_success"> <b>Settings!</b> saved successfully.</p>');        
    }


    public function fbCallback()
    {
        if (!session_id()) {
            session_start();
        }
        $fb = new Facebook\Facebook([
            'app_id' => FB_App_ID,
            'app_secret' => FB_App_Secret,
            'default_graph_version' => FB_App_Version
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in
        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3>Metadata</h3>';
        var_dump($tokenMetadata);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId($config['app_id']);
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();


        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                exit;
            }

            var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

        $this->session->set_flashdata('message', '<p class="ajax_success">Facebook access token set</p>');
        redirect(site_url('/admin/settings'));
    }
    
   
    


}