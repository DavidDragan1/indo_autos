<?php

class backup {
    
    
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

    public function sendEmailToSellerAjax($to, $Slug, $array = [], $cc = false, $bcc = false, $from = '', $company_name = ''){
        $data       = $this->getEmailBody($Slug);
        $Body       = @$data->template;
        $Subject    = @$data->title;
        $from       = $array['Sender'];
        $Body       = self::filterEmailBody($Body, $array);
        if($this->sendEmailAjax($to, $Subject, $Body, $cc, $bcc, $from, $company_name)){
            return true;
        }
        return false;
    }
    public function sendOfferAjax($to, $Slug, $array = [], $cc = false, $bcc = false, $from = '', $company_name = ''){
        $data       = $this->getEmailBody($Slug);
        $Body       = @$data->template;
        $Subject    = $array['Subject'];
        $from       = $array['SenderEmail'];
        $Body       = self::filterEmailBody($Body, $array);
        if($this->sendEmailAjax($to, $Subject, $Body, $cc, $bcc, $from, $company_name)){
            return true;
        }
        return false;
    }
    public function sendOfferAckknoledgeAjax($to, $Slug, $array = [], $cc = false, $bcc = false, $from = '', $company_name = ''){
        $data       = $this->getEmailBody($Slug);
        $Body       = @$data->template;
        $Subject    = $array['Subject'];
        $Body       = self::filterEmailBody($Body, $array);
        if($this->sendEmailAjax($to, $Subject, $Body, $cc, $bcc, $from, $company_name)){
            return true;
        }
        return false;
    }


    public function contact_us() {

        $this->_rules();
        /*if($this->form_validation->run() == FALSE) {
            var_dump( form_error('senderName') );
            var_dump( form_error('senderEmail') );
            var_dump( form_error('message') );
        } else {
            echo 'True';
            var_dump( form_error('message') );
        }
        dd($_POST);
        exit;*/
        if ($this->form_validation->run() == FALSE) {
            $this->viewFrontContent('frontend/template/contact-us');
        }else{
            $sender_name = $this->input->post('senderName');
            $sender_email = $this->input->post('senderEmail');
            $message = $this->input->post('message');
            $reciever_email = 'ramenkbiswas@gmail.com';
            $subject        = 'Contact Us Request';
            $mail_type        = 'ContactUsRequest';

            $filter = ['Name' => $sender_name, 'Reciever' => $reciever_email, 'Sender' => $sender_email, 'Message' => $message,'Subject' => $subject,'Mail_type' => $mail_type];
            //dd($filter);
            if ($this->sendEmailToSellerAjax($reciever_email, 'FrontEndMailTemplate', $filter)) {
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
                insert_into_mails($data);
                if ($this->sendOfferAckknoledgeAjax($sender_email, 'FrontEndMailNotificationTemplate', $filter)) {
                    $this->session->set_flashdata('message', 'Contact Request Sent. Please Check Your Email');
                    redirect(site_url('contact-us'));
                } else {
                    $this->session->set_flashdata('message', 'Contact Request Sent');
                    redirect(site_url('contact-us'));
                }
            }else {
                $this->session->set_flashdata('message', 'Contact Request Failed to Sent');
                redirect(site_url('contact-us'));
            }
        }


    }
    
    public function contact_seller() {
        $sender_name = $this->input->post('senderName');
        $reciever_email = $this->input->post('reciever');
        $sender_email = $this->input->post('email');
        $message = $this->input->post('message');
        $subject        = 'Contact Seller Request';
        $mail_type        = 'ContactSellerRequest';
        $filter = ['Name' => $sender_name, 'Reciever' => $reciever_email, 'Sender' => $sender_email, 'Message' => $message,'Subject' => $subject,'Mail_type' => $mail_type];
        //dd($filter);
        if ($this->sendEmailToSellerAjax($reciever_email, 'EmailToSeller', $filter)) {
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
                insert_into_mails($data);

                 echo ajaxRespond('OK', 'Successfully Sent!');
        }else {
            echo ajaxRespond('Fail', 'Message Not Sent. Please Try Again.');
        }
    }

    public function make_an_offer() {
        $sender_email = $this->input->post('sender');
        $reciever_email = $this->input->post('reciever');
        $subject = $this->input->post('subject');
        $message = $this->input->post('offer_message');
        $mail_type        = 'MakeAnOfferRequest';
        $filter = ['SenderEmail' => $sender_email, 'RecieverEmail' => $reciever_email, 'Subject' => $subject, 'Message' => $message];
        if ($this->sendOfferAjax($reciever_email, 'MakeAnOffer', $filter)) {
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
            insert_into_mails($data);
            if ($this->sendOfferAckknoledgeAjax($sender_email, 'OfferAcknowledgement', $filter)) {
                echo ajaxRespond('SUCCESS', 'Inquiry Sent. Please Check your email..');
            } else {
                echo ajaxRespond('SUCCESS', 'Inquiry Sent.');
            }
        } else {
            echo ajaxRespond('Fail', 'Inquiry Not Sent. Please Try Again.');
        }
    }
}