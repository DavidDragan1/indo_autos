<div class="contact-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="contact-title">
                    <h1>CONTACT DETAILS</h1>
                    <p>Get in Touch</p>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <ul class="contact-info">
                    <li class="contact-info-item">
                        <div class="contact-info-icon">
                            <img src="assets/theme/new/images/icons/contact/map.png" alt="image">
                        </div>
                        <div class="contact-info-content">
                            <h4>Main office</h4>
                            <p>10 Ave, D State, X Country</p>
                        </div>
                    </li>
                    <li class="contact-info-item">
                        <div class="contact-info-icon">
                            <img src="assets/theme/new/images/icons/contact/phone.png" alt="image">
                        </div>
                        <div class="contact-info-content">
                            <h4>Phone Number</h4>
                            <p>
                                <span>+123 (0) 01234567891</span>
                                <span>Whatsapp : +123 (0) 98765432190</span>
                            </p>
                        </div>
                    </li>
                    <li class="contact-info-item">
                        <div class="contact-info-icon">
                            <img src="assets/theme/new/images/icons/contact/email.png" alt="image">
                        </div>
                        <div class="contact-info-content">
                            <h4>Email</h4>
                            <p>info@carquest.com </p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-8 col-12">
                <form  id="C_sendMail" method="post" onsubmit="return SendContactMail(event);">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <input type="text" name="name" value="" id="C_SendMail_name" class="normal-input-style browser-default" placeholder="Type your name" required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="email" name="email" id="C_SendMail_email" value="" class="normal-input-style browser-default" placeholder="Type email" required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="text"  name="contact" id="C_SendMail_contact_no" class="normal-input-style browser-default" placeholder="Type contact number" required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-6 col-12">
                            <input type="text" name="subject" id="C_SendMail_subject" class="normal-input-style browser-default" placeholder="Type subject" required>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-12">
                            <textarea name="message" id="C_SendMail_message" cols="30" rows="15" class="normal-input-style browser-default" requiredz></textarea>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-12">
                            <div class="g-recaptcha" data-sitekey="<?php echo config_item('site_key'); ?>"></div>
                        </div>
                        <div class="col-12">
                            <div id="contact_page_ajax_respond" style="margin-bottom: 20px;"></div>
                            <div class="contact-action">
                                <button class="btnStyle" type="submit" value="Send Message">Send Message</button>
                                <ul class="socil-share">
                                    <li><a href="https://www.facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="https://www.youtube.com/" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function SendContactMail(e) {
        e.preventDefault();

        var formData = jQuery('#C_sendMail').serialize();

        var error = 0;

        var name =  jQuery('#C_SendMail_name').val();
        if(!name){
            jQuery('#C_SendMail_name').addClass('required');
            error = 1;
        } else{
            jQuery('#C_SendMail_name').removeClass('required');
        }

        var email =  jQuery('#C_SendMail_email').val();
        if(!email){
            jQuery('#C_SendMail_email').addClass('required');
            error = 1;
        } else{
            jQuery('#C_SendMail_email').removeClass('required');
        }

        var contact_no =  jQuery('#C_SendMail_contact_no').val();
        if(!contact_no){
            jQuery('#C_SendMail_contact_no').addClass('required');
            error = 1;
        } else{
            jQuery('#C_SendMail_contact_no').removeClass('required');
        }

        var subject =  jQuery('#C_SendMail_subject').val();
        if(!subject){
            jQuery('#C_SendMail_subject').addClass('required');
            error = 1;
        } else{
            jQuery('#C_SendMail_subject').removeClass('required');
        }

        var message =  jQuery('#C_SendMail_message').val();
        if(!message){
            jQuery('#C_SendMail_message').addClass('required');
            error = 1;
        } else{
            jQuery('#C_SendMail_message').removeClass('required');
        }

        if(!error){
            jQuery.ajax({
                type: "POST",
                url: "mail/send_a_message",
                dataType: 'json',
                data: formData,

                beforeSend: function (){
                    jQuery('#contact_page_ajax_respond').html('<p class="ajax_processing text-success">Sending...</p>');
                },
                success: function(jsonData) {
                    if( jsonData.Status === 'OK' ){
                        document.getElementById("C_sendMail").reset();
                        setTimeout(function() {	$('#contact_page_ajax_respond').slideUp('slow') }, 2000);
                    } else {
                        grecaptcha.reset();
                        jQuery('#contact_page_ajax_respond').html( jsonData.Msg );
                        jQuery('#contact_page_ajax_respond').addClass('text-danger');
                    }
                }
            });
        }
    }


</script>
