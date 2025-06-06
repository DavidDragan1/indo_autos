<!DOCTYPE html>
<html>
<head>
    <base href="<?php echo base_url(); ?>"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" href="assets/new-theme/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="assets/new-theme/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/new-theme/css/magnific-popup.css" />
    <link rel="stylesheet" href="assets/new-theme/css/slick.css" />
    <link rel="stylesheet" href="assets/new-theme/css/default.css?t=<?=time()?>" />
    <link rel="stylesheet" href="assets/new-theme/css/intlTelInput.min.css">
    <link rel="stylesheet" href="assets/new-theme/css/jquery.scrollbar.css">
    <link rel="stylesheet" href="assets/new-theme/css/material-grid.css">
    <link rel="stylesheet" href="assets/new-theme/css/style.css?t=<?=time()?>" />
    <link rel="stylesheet" href="assets/new-theme/css/theme.css?t=<?=time()?>" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-83128659-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-83128659-1');
    </script>
    <style>
        .choose-profile-list li label{
            cursor: pointer !important;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php
        echo isset($meta_title) ? $meta_title : 'Auction Cars Online | Vehicle Auction';
        ?>
    </title>
    <meta name="description" content="<?php  echo isset($meta_description) ? $meta_description: 'Online Car & Vehicle Auctions Buy salvage vehicles, repairable vehicles, used cars online in our online auction.'; ?>" />
    <meta name="keywords" content="<?php  echo isset($meta_keywords) ? $meta_keywords: ''; ?>" />
    <meta name="author" content="Jimi">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <meta name="apple-itunes-app" content="app-id=0000">
    <meta name="google-play-app" content="">

    <link rel="icon" href="assets/new-theme/images/favicon.png" sizes="20x20">
    <script type="text/javascript" src="assets/new-theme/js/jquery-3.2.1.min.js"></script>
</head>


<body>
<!-- login area start  -->
<div class="tostfyMessage">
    <span class="tostfyClose">&times;</span>
    <div class="messageValue"></div>
</div>
<header class="login-header-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="<?=base_url()?>">

                    <img src="assets/new-theme/images/car-logo.svg" alt="CarQuest" class="login-logo">
                </a>
            </div>
        </div>
    </div>
</header>
<div class="login-area">
    <img class="shape-login" src="assets/new-theme/images/shapes/shape1.svg" alt="">
    <img class="shape-login2" src="assets/new-theme/images/shapes/shape2.svg" alt="">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-12">
                <div class="login-content">
                    <?php
                    if (isset($_GET['profile']) && $_GET['profile'] == 'seller') {
                    ?>
                        <h1>Dealer's  Finance with Lendigo</h1>
                    <?php } else { ?>
                        <h1>Your one place for all thing AUTO</h1>
                    <?php } ?>
                    <ul class="login-info">
                        <li>Buy and sell cars and motorbike</li>
                        <li>Buy and sell spare parts</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-5 col-12">
                <div class="login-wrapper">
                    <h4>Get Started with CarQuest</h4>
                    <ul class=" login-tabs">
                        <li>
                            <a class="<?=empty($_GET['mode']) ? 'active' : ''?> waves-effect" href="my-account">Log in</a>
                        </li>
                        <li>
                            <a id="sign_tab" class="waves-effect <?=@$_GET['mode'] == 'signup' ? 'active' : ''?>" href="my-account?mode=signup">Sign up</a>
                        </li>
                    </ul>

                    <?php if (@$_GET['mode'] == 'signup') {?>
                    <div id="signup">
                        <form class="signup-form-wrap" id="signupForm">
                            <div class="choose-profile-wrapper">
                                <h5>Choose a Profile</h5>
                                <ul class="choose-profile-list">
                                    <li>
                                        <input name="choose_profile" id="buyer" type="radio" value="6">
                                        <label for="buyer">Buyer</label>
                                    </li>
                                    <li>
                                        <input name="choose_profile" id="seller" type="radio" value="seller">
                                        <label for="seller">Seller</label>
                                    </li>
                                </ul>
<!--                                <button type="button"-->
<!--                                        class="loginBtn chooseProfileBtn waves-effect mt-20">Continue</button>-->

                            </div>
                            <div class="signup-form-wrapper">
                                <div class="select-style buyer-select">
                                    <select class="browser-default " name="seller_role" id="seller_role_signup_dropdown" required>
                                        <option value="4">Trade Seller/Dealers</option>
                                        <option value="5">Private Seller</option>
                                    </select>
                                </div>
                                <div class="input-field">
                                    <input id="f_name" name="first_name" type="text" required>
                                    <label for="f_name"><span>First Name</span></label>
                                </div>
                                <div class="input-field">
                                    <input id="l_name" name="last_name" type="text" required>
                                    <label for="l_name"><span>Last Name</span></label>
                                </div>
                                <div class="input-field">
                                    <input id="email_phone" name="your_email" type="email" required>
                                    <label for="email_phone"><span>Email Address</span></label>
                                </div>
                                <div class="input-field">
                                    <input id="contact" name="your_contact" type="phone" onKeyPress="return DegitOnly(event);" required placeholder="Contact Phone Number">
                                    <!-- <label for="contact"><span>Contact Phone Number</span></label> -->
                                </div>
                                <div class="input-field input-password mb-10">
                                    <input id="password-sign-up" name="password" type="password" required>
                                    <label for="password-sign-up"><span>Password</span></label>
                                    <i class="material-icons show-password">visibility</i>
                                </div>
                                <div class="g-recaptcha" data-sitekey="<?php echo config_item('site_key'); ?>"></div>
                                <button type="submit" class="loginBtn waves-effect mt-20">Sign up</button>

                            </div>
                        </form>
                    </div>
                    <?php } else { ?>
                        <div id="logIn">
                            <form id="loginForm" action="auth/login" method="post">
                                <div class="input-field">
                                    <input id="email" name="username" type="email" required>
                                    <label for="email"><span>Email</span></label>
                                </div>
                                <div class="input-field input-password mb-10">
                                    <input id="password" name="password" type="password" required>
                                    <label for="password"><span>Password</span></label>
                                    <i class="material-icons show-password">visibility</i>
                                </div>
                                <div class="g-recaptcha" data-sitekey="<?php echo config_item('site_key'); ?>"></div>
                                <div class="text-right">
                                    <a class="forgot-password" href="forget-password">Forgot Password?</a>
                                </div>
                                <button type="submit" class="loginBtn waves-effect mt-20">Log in</button>
                                <p class="login-with">Or log in with</p>
                                <ul class="social-login">
                                    <li>
                                        <a class="waves-effect google" href="<?=$google_auth_url?>">
                                            <i class="fa fa-google"></i>
                                            Google
                                        </a>
                                    </li>
                                    <li>
                                        <a class="waves-effect facebook" href="<?=$facebook_auth_url?>">
                                            <i class="fa fa-facebook"></i>
                                            Facebook
                                        </a>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    <?php } ?>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- login area end  -->
<script type="text/javascript" src="assets/new-theme/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/materialize.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/select2.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.scrollbar.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/scripts.js"></script>
<script type="text/javascript" src='https://www.google.com/recaptcha/api.js' async defer ></script>
<script>

    function tosetrMessage(type, message) {
        $('.tostfyMessage').css({ "bottom": "5px", "visibility": "visible", "opacity": 1 });
        $('.tostfyMessage').find('.messageValue').text(message);
        if (type === 'success') {
            $('.tostfyMessage').css('background', 'rgb(76, 175, 80)')
        } else if (type === 'warning') {
            $('.tostfyMessage').css('background', 'rgb(255, 152, 0)')
        } else if (type === 'error') {
            $('.tostfyMessage').css('background', 'rgb(244, 67, 54)')
        }
        setTimeout(function () {
            $('.tostfyMessage').css({ "bottom": "-100%", "visibility": "hidden", "opacity": 0 })
        }, 5000);
        $('.tostfyClose').on('click', function () {
            $('.tostfyMessage').css({ "bottom": "-100%", "visibility": "hidden", "opacity": 0 })
        })
    }

    function DegitOnly(e){
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if (unicode!=8 && unicode!=9)
        {
            if (unicode<46||unicode>57||unicode==47)
                return false
        }
    }

    $("#signupForm").validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            email_phone: {
                required: true,
                email: true
            },
            f_name: 'required',
            l_name: 'required',
        },
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            email_phone: "Please provide a email or phone number",
            f_name: "Please provide first name",
            l_name: "Please provide last name",
        },
        submitHandler: function(form) {
            var userData = jQuery('#signupForm').serialize();
            jQuery.ajax({
                url: 'auth/sign_up',
                type: 'POST',
                dataType: 'json',
                data: userData,
                beforeSend: function(){
                    tosetrMessage('warning', 'Wait! We are saving your data')
                },
                success: function(jsonRespond ){


                    if ( jsonRespond.Status === 'OK' ){
                        tosetrMessage('success', 'Login Success')
                        $('#signup').html('<div class="signup-successfuly-wrapper">'+
                            '                        <img src="assets/new-theme/images/icons/check.svg" alt="">'+
                            '                        <h4>Sign up Successful</h4>'+
                            '                        <a href="admin/profile" class="loginBtn waves-effect">Complete my Profile</a>'+
                            '                        <div class="text-center">'+
                            '                            <a href="admin">Skip to Dashboard</a>'+
                            '                        </div>'+
                            '                    </div>');
                    } else {
                        if (window.grecaptcha) grecaptcha.reset();
                        tosetrMessage('error', jsonRespond.Msg)
                    }
                }
            });
        }
    });
    $("#loginForm").validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            email: {
                required: true,
                email: true
            },
        },
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            email: "Please enter a valid email address",
        },
        submitHandler: function(form) {
        var userData = jQuery('#loginForm').serialize();
        jQuery.ajax({
            url: 'auth/login',
            type: "POST",
            dataType: "json",
            cache: false,
            data: userData,
            beforeSend: function(){
                tosetrMessage('waring', 'Please Wait... Checking....');
            },
            success: function( jsonData ){
                if(jsonData.Status === 'OK'){
                    tosetrMessage('success', jsonData.Msg);
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
                    if (window.grecaptcha) grecaptcha.reset();
                    tosetrMessage('error', jsonData.Msg);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                tosetrMessage('success', XMLHttpRequest);
            }
        });
    }
    });
    $('.signup-form-wrapper').hide()
    $(function () {
        // $(".chooseProfileBtn").click(function () {
        //     if ($('input[type=radio][name=choose_profile]:checked').length == 0) {
        //         tosetrMessage('warning', 'Please select at least one');
        //         return false;
        //     }
        //     else {
        //         // tosetrMessage('success', 'Successfuly Selected');
        //         $('.signup-form-wrapper').show();
        //         $('.choose-profile-wrapper').hide();
        //     }
        // });

        $('input[type=radio][name=choose_profile]').on('click', function () {
            var role = $(this).val();
            if (role == 'seller'){
                $('.buyer-select').show();
            } else {
                $('.buyer-select').hide();
            }

            $('.signup-form-wrapper').show();
            $('.choose-profile-wrapper').hide();
        })

        <?php
            if (isset($_GET['profile']) && $_GET['profile'] == 'seller') {
        ?>
            let radios = $('input:radio[name=choose_profile]');
            radios.filter('[value=seller]').trigger('click');
            $("#seller_role_signup_dropdown").prop('disabled', true);
            $('<input>').attr({
                type: 'hidden',
                name: 'seller_role',
                value: 4,
            }).appendTo('#signupForm');
        <?php } ?>
    });
    $('#sign_tab').on('click',function (){
        if ($(this).hasClass('active')){
            window.location.href = '<?php echo base_url(); ?>my-account?mode=signup';
            window.location.reload();
        }
    })
</script>
</body>

</html>
