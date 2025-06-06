<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Mails_frontend extends MX_Controller  {

    function __construct() {
        $this->load->model('Mails_model');
        $this->load->helper('email');
        $this->load->helper('date');
    }

    public function getEmailBody($slug = ''){
        $data = $this->db->get_where('email_templates', ['slug' => $slug])->row();
        return $data;
    }

    public function filterEmailBody($body = '', $arrays = array()){
        if (count($arrays)) {
            foreach ($arrays as $row => $value) {
                $body = str_replace('%' . $row . '%', $value, $body);
            }
        }
        return $body;
    }

    public function sendEmailAjax($to, $subject, $body, $cc = false, $bcc = false, $from = '', $company_name = ''){
        $mail = new PHPMailer;


        $mail->setFrom($from, $company_name);
        $mail->addAddress($to);     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo($from, $company_name);
        $mail->addCC($cc);
        $mail->addBCC($bcc);

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body = $body;

        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }

    public function sendEmailFromFrontend($to, $Slug, $array = [], $cc = false, $bcc = false, $from = '', $company_name = ''){
        $data       = $this->getEmailBody($Slug);
        $Body       = @$data->template;
        $Body       = self::filterEmailBody($Body, $array);

        if(array_key_exists('Subject',$array)){
            $Subject       = $array['Subject'];
        }else{
            $Subject       = @$data->title;
        }

        if(array_key_exists('Sender',$array)){
            $from       = $array['Sender'];
        }else{
            $from       = 'carquest@gmail.com';
        }


        if($this->sendEmailAjax($to, $Subject, $Body, $cc, $bcc, $from, $company_name)){
            return true;
        }
        return false;

    }


    public function create_action_ajax(){
        ajaxAuthorized();
        $message        = $this->input->post('body',TRUE);
        $sender_email        = $this->input->post('email',TRUE);
        $sender_name        = $this->input->post('name',TRUE);
        $subject        = 'Contact Request';
        $mail_type        = 'ContactRequest';


        /*echo $message.$sender_email.$sender_name;
        exit;*/

        // get admin email
        $reciever_email = 'ramenkbiswas@gmail.com';

        //FrontEndMailNotificationTemplate

        $filter = ['Reciever' => $reciever_email, 'Sender' => $sender_email, 'Message' => $message, 'Subject' => $subject];
        if($this->sendEmailFromFrontend($reciever_email, 'FrontEndMailTemplate', $filter)){
            $data = array(
                'parent_id' => 0,
                'mail_type' => $mail_type,
                'sender_id' => 0,
                'reciever_id' => 1, //get admin Id
                'subject' => $subject,
                'body' => $message,
                'status' => 'Unread',
                'important' => 'Unimportant',
                'log' => '',
                'created' => date('Y-m-d H:i:s'),
                'folder_id' => '1'
            );
            if($this->Mails_model->insert($data)){
                $filter = ['Sender_Name' => $sender_name, 'Subject' => $subject];
                if($this->sendEmailFromFrontend($sender_email, 'FrontEndMailNotificationTemplate', $filter)) {
                    echo ajaxRespond('OK', 'Successfully Sent! Check Your Email.');
                }else{
                    echo ajaxRespond('OK', 'Successfully Sent!');
                }
            }else {
                echo ajaxRespond('FAIL', 'Message Not Sent');
            }
        }

    }


}
