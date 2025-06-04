<style>
    .ajax_error {
        color: red;
    }
    .ajax_success {
        color: green;
    }
</style>
<div class="account-area">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1  login-box-body  js_login">
                <h2 class="account-title">Sign in your account</h2>
                <div class="account-wrapper">
                     <div id="respond"></div>
                    <form id="credential" action="auth/login" method="post">
                        <div class="form-input">
                            <label for="email">Email</label>
                            <input type="text" placeholder="Type your email address" id="username" name="username">
                        </div>
                        <div class="form-input">
                            <label for="email">Password</label>
                            <input type="password" placeholder="Type your  password" name="password" id="password" autocomplete="off">
                        </div>
                        <div class="g-recaptcha" data-sitekey="<?php echo config_item('site_key'); ?>"></div>
                        <div class="account-link ">
                            <a class="js_forgot">Forgot password?</a>
                        </div>

                        <div class="text-center">
                            <button class="account-btn" type="submit" id="signin">Sign In</button>
                            <strong style="display: block;text-align: center;margin-bottom: 10px;margin-top:25px;color:#5c5c5c">Login with</strong>
                            <ul style="margin-top:10px" class="facebook-google-login">
                                <li><a class="google" href="<?php echo $google_auth_url; ?>"><i class="fa fa-google"></i> Google</a></li>
                                <li><a class="facebook" href="<?php echo $facebook_auth_url; ?>"><i class="fa fa-facebook"></i> Facebook</a></li>
                            </ul>
                            <div>
                                <a class="other-page" href="sign-up">register now!</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 js_forget_password" style="display: none; ">
                <h2 class="account-title">Forgot Password</h2>
                <div class="account-wrapper">
                    <div id="maingReport"></div>
                    
                    <form action="auth/forgot_password" method="post" id="forgotForm">
                        <div class="form-input mb-0">
                            <label for="email">Forgot Password</label>
                            <input type="text" placeholder="Type your  email address" name="forgot_mail" id="forgot_mail">
                            <div class="formresponse"></div>
                        </div>
                        <div class="account-link ">
                            <a class="js_back_login">Back to Sign in</a>
                        </div>
                        <div class="text-center">
                            <button class="account-btn" id="forgot_pass" type="button">Send Request</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/lib/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">

    jQuery('.js_forgot').on('click', function(){
        jQuery('.js_login').slideUp('slow');
        jQuery('.js_forget_password').slideDown('slow');
    });
    jQuery('.js_back_login').on('click', function(){
        jQuery('.js_forget_password').slideUp('slow');
        jQuery('.js_login').slideDown('slow');
        
    });
    
    
    jQuery('#forgot_pass').click(function(){
        var formData = jQuery('#forgotForm').serialize();
        
        var email = jQuery('#forgot_mail').val();
        jQuery.ajax({
            url: 'auth/forgot_pass',
            type: "POST",
            dataType: 'json',
            data: formData,
            beforeSend: function () {
                jQuery('.formresponse')
                        .html('<p class="ajax_processing">Checking user...</p>')
                        .css('display','block');
            },
            success: function ( jsonRespond ) {
               
                if( jsonRespond.Status === 'OK'){
                     
                    jQuery('.formresponse').html( jsonRespond.Msg );
                     
                    jQuery('#maingReport').load( 'mail/send_pwd_mail/?email=' + email +'&_token=' + jsonRespond._token );
                                    
                } else {
                    jQuery('.formresponse').html( jsonRespond.Msg );
                }                
            }
        });
        return false;
    });


$(function(){
    $("#credential").validate({
        rules: {
            username: {
                required: true,
                email: true,
                
            },
            password: {
                required: true,
                minlength: 6
            },
        },
        messages: {
            password:{
                required:'Password can not be empty',
                minlength:'Password minimum length 6',
            },
            username: {
                required:'E-mail can not be empty',
                email:'Please enter a valid email address'
            }
            
        },
        submitHandler: function(form) {
            var userData = jQuery('#credential').serialize(); 
            jQuery.ajax({
                url: 'auth/login',
                type: "POST",
                dataType: "json",
                cache: false,
                data: userData,
                beforeSend: function(){
                    jQuery('#respond').removeClass('alert-danger alert-success').addClass('alert alert-info').html('<p class="ajax_processing text-warning">Please Wait... Checking....</p>');
                },
                success: function( jsonData ){
                    if(jsonData.Status === 'OK'){
                        jQuery('#respond').removeClass(' alert-danger alert-info').addClass('alert alert-success').html( jsonData.Msg );   
                        <?php $goto = @$_GET['goto']; ?>
                        <?php if(@$_SERVER['HTTP_REFERER'] && (@$_SERVER['HTTP_REFERER'] == site_url('driver-hire'))){ ?>
                                window.location.href = '<?php echo  @$_SERVER['HTTP_REFERER']; ?>';
                        <?php } elseif($goto == 'mechanic'){ ?>
                            window.location.href = '<?php echo  site_url('mechanic'); ?>'
                    <?php  } elseif($goto == 'admin/posts/create'){ ?>
                            window.location.href = '<?php echo  site_url('admin/posts/create'); ?>'
                        <?php  } elseif(!empty($goto)) { ?>
                            window.location.href = '<?php echo  site_url($goto); ?>'
                        <?php  } else { ?>
                                location.reload();
                        <?php } ?>
                                    
                    } else {
                        grecaptcha.reset();
                        jQuery('#respond').removeClass('alert-success alert-info').addClass('alert alert-danger').html( jsonData.Msg );    
                    }                                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    jQuery('#respond').removeClass('alert-success alert-info').addClass('alert alert-danger').html( '<p> XML: '+ XMLHttpRequest + '</p>' );
                    jQuery('#respond').append( '<p>  Status: '+textStatus + '</p>' );
                    jQuery('#respond').append( '<p> Error: '+ errorThrown + '</p>' );            
                }  
            });
    }});	
});

</script>