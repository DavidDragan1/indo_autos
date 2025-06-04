<style>
    .temp {
        font-size: 13px;
        color: #ff0000;
        background: #ffb0b0;
        font-weight: 400;
        padding: 2px 15px;
        border-radius: 3px;
        margin-top: 1px;
        line-height: 27px;
    }
</style>

<div class="account-area">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1">
                <h2 class="account-title">Sign Up For Free Account</h2>
                <div id="sign_up_respond"></div>
                <form class="form-horizontal" action="auth/sign_up" id="sign_up_form" method="post">
                <div class="account-wrapper">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-input">
                                <label for="first">First Name*</label>
                                <input type="text" placeholder="Type your first name" name="first_name" id="first_name">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-input">
                                <label for="last">last Name*</label>
                                <input type="text" placeholder="Type your last name" name="last_name" id="last_name">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-input">
                                <label for="email">Your Email*</label>
                                <input type="email" placeholder="Type your your email" name="your_email" id="your_email" onchange="checkEmail()">
                                <p class='form-error' id='your_email_error' style='display: none'></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-input">
                                <label for="phone">Contact Phone Number</label>
                                <input type="phone" placeholder="Type your contact number" name="your_contact" onKeyPress="return DegitOnly(event);" id="your_contact">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-input">
                                <label for="password">Password*</label>
                                <input type="password" placeholder="Type your password" name="password" id="password">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-input">
                                <label for="password">Confirm Password*</label>
                                <input type="password" placeholder="Type your confirm password" name="passconf" id="passconf">
                            </div>
                        </div>
                    </div>

                    <div class="account-type" style="margin-bottom: 1px;">
                        <h3>Account type :</h3>
                        <ul class="account-type-items">
                            <li>
                                <input type="radio" id="trade" name="role_id" value="04">
                                <label for="trade">Dealer</label>
                            </li>
                            <li>
                                <input type="radio" id="private" name="role_id" value="05">
                                <label for="private">Private Seller</label>
                            </li>
                            <li>
                                <input type="radio" id="buyer" name="role_id" value="06">
                                <label for="buyer">Buyer </label>
                            </li>
                            <li>
                                <input type="radio" id="automech" name="role_id" value="08">
                                <label for="automech">Automech Professional </label>
                            </li>
                        </ul>
                    </div>
                    <label id="role-id-error" class="error temp" for="role_id" style="width: 50%; display: none;"></label>

                    <div class="g-recaptcha" data-sitekey="<?php echo config_item('site_key'); ?>" style="margin-top: 30px;"></div>

                    <h4 class="click-login">
                        <a href="my-account">Click here </a>to login
                    </h4>
                    <div class="text-center">
                        <button type="submit" name="sign_up" class="account-btn" id="js_sign_up">Sign Up</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="assets/lib/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">

function DegitOnly(e){
	var unicode = e.charCode ? e.charCode : e.keyCode;
	if (unicode!=8 && unicode!=9)
	{ 
		if (unicode<46||unicode>57||unicode==47) 
		return false
	}
}

$(function(){
    $("#sign_up_form").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            your_contact: "required",
            role_id:{
                required: true,
            },
            your_email:{
                required: true,
                email:true,
            },
            password: {
                required: true,
                minlength: 6
            },
            passconf:{
                required: true,
                minlength: 6,
                equalTo: "#password"
            }
        },
        messages: {
            first_name: "First Name can not be empty",
            last_name: "Last Name can not be empty",
            your_contact: "Contact Number can not be empty",
            role_id: {
                required:'Please select account type.',
            },
            your_email: {
                required:'E-mail can not be empty',
                email:'Please enter a valid email address'
            },
            password:{
                required:'Password can not be empty',
                minlength:'Password minimum length 6',
            },
            passconf:{
                required:'Confirm password can not be empty',
                minlength:'Confirm Password minimum length 6',
            }
            
        },
    submitHandler: function(form) {
        var userData = jQuery('#sign_up_form').serialize(); 
            jQuery.ajax({
            url: 'auth/sign_up',
            type: 'POST',
            dataType: 'json',
            data: userData,
            beforeSend: function(){
                jQuery('#sign_up_respond').removeClass('alert-danger alert-success').addClass('alert alert-info').html( '<p class="ajax_processing">Loading...</p>' );
            },
            success: function(jsonRespond ){
                jQuery('#sign_up_respond').removeClass('alert-danger alert-info').addClass('alert alert-success').html( jsonRespond.your_email );
                
                if ( jsonRespond.Status === 'OK' ){
                    window.location.href = 'admin';
                } else {
                    grecaptcha.reset();
                    jQuery('#sign_up_respond').removeClass('alert-success alert-info').addClass('alert alert-danger').html( jsonRespond.Msg );
                }
            }
        });          
    }});	
});


function checkEmail () {
    var email =  jQuery("#your_email").val();

    jQuery.ajax({
        url: 'auth/check_email',
        type: 'POST',
        dataType: 'json',
        data: {
            "email" : email
        },
        success: function(jsonRespond ){
            if( jsonRespond.Status === 'OK' ){
                jQuery("#your_email_error").css('display', 'block');
                jQuery("#your_email_error").html( jsonRespond.Msg);

                return 1;
            } else {
                jQuery("#your_email_error").css('display', 'none');
                return 0;
            }
        }
    });
}

</script>

