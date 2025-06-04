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
    <link rel="stylesheet" href="assets/new-theme/css/select2.min.css">
    <link rel="stylesheet" href="assets/new-theme/css/style.css?t=<?=time()?>" />
    <link rel="stylesheet" href="assets/new-theme/css/theme.css?t=<?=time()?>" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-83128659-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-83128659-1');
    </script>
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
    <script src="assets/new-theme/js/select2.min.js"></script>
</head>

<body>
<div class="tostfyMessage" style="visibility:hidden">
    <span class="tostfyClose">&times;</span>
    <div class="messageValue"></div>
</div>
<div class="forgot_password-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <div class="text-center mb-30">
                    <a class="forgot_pass-logo" href="<?php echo base_url(); ?>">
                        <img src="assets/new-theme/images/car-logo.svg" alt="">
                    </a>
                </div>
                <form class="forgot_password-wrap" id="credential" method="post">
                    <input type="hidden" name="verify_token" value="<?php echo $this->input->get('token'); ?>" >
                    <h4 class="fs-16 fw-500 mb-20">Recover Forgotten Password</h4>

                    <div class="input-field">
                        <input type="text" readonly class="form-control" id="email" name="email" required value="<?php echo $this->input->get('email'); ?>">
                        <label for="email"><span>Email</span></label>
                    </div>

                    <div class="input-field">
                        <input type="password" value="" name="new_password" id="new_password"  class="form-control" placeholder="New Password" required>
                        <label for="email"><span>New password</span></label>
                    </div>

                    <div class="input-field">
                        <input type="password" value="" name="retype_password" id="retype_password"  class="form-control" placeholder="Retype password" required>
                        <label for="email"><span>Retype password</span></label>
                    </div>
                    <button type="button" id="reset_pass" class="loginBtn waves-effect mt-20"> Reset & Log in</button>
                </form>
            </div>
        </div>
        <p class="auth-copyright">&copy; copyright to CarQuest. All rights reserved.
                </p>
    </div>
</div>

<div class="d-none maingReport">

</div>

<!--<script type="text/javascript" src="assets/new-theme/js/jquery-3.2.1.min.js?t=--><?php //echo time(); ?><!--"></script>-->
<script type="text/javascript" src="assets/new-theme/js/materialize.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/intlTelInput.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.validate.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.magnific-popup.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.scrollbar.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/slick.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/select2.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/scripts.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/custom.js?t=<?php echo time(); ?>"></script>

<script>
    function tosetrMessage(type, message) {
        $('.tostfyMessage').css({ "bottom" : "auto", "top": "5", "visibility": "visible", "opacity": 1 });
        $('.tostfyMessage').find('.messageValue').text(message);
        if (type === 'success') {
            $('.tostfyMessage').css('background', 'rgb(76, 175, 80)')
        } else if (type === 'warning') {
            $('.tostfyMessage').css('background', 'rgb(255, 152, 0)')
        } else if (type === 'error') {
            $('.tostfyMessage').css('background', 'rgb(244, 67, 54)')
        }
        setTimeout(function () {
            $('.tostfyMessage').css({ "bottom" : "auto", "top": "0", "visibility": "hidden", "opacity": 0 })
        }, 5000);
        $('.tostfyClose').on('click', function () {
            $('.tostfyMessage').css({ "bottom" : "auto", "top": "0", "visibility": "hidden", "opacity": 0 })
        })
    }

    $(document).ready(function () {
        setTimeout(function () {
            $('.tostfyMessage').css({"bottom" : "auto", "top": "0", "visibility": "hidden", "opacity": 0 })
        }, 5000);

        $('.tostfyClose').on('click', function () {
            $('.tostfyMessage').css({ "bottom" : "auto", "top": "0", "visibility": "hidden", "opacity": 0 })
        })
    })

</script>

<script>
    $('#reset_pass').on('click', function () {
        var error = 0;

        var _email = $('#email').val();

        if (!_email) {
            tosetrMessage('error', 'Enter Email address')
            error = 1;
        }

        var new_password = $('#new_password').val();

        if (!new_password) {
            tosetrMessage('error', 'Please enter new password')
            error = 1;
        }

        var retype_password = $('#retype_password').val();

        if (!retype_password) {

            tosetrMessage('error', 'Retype Password')

            error = 1;

        }

        if (error === 0) {

            var formData = jQuery('#credential').serialize();

            jQuery.ajax({

                url: 'auth/reset_password_action',

                type: "post",

                dataType: 'json',

                data: formData,

                beforeSend: function () {

                    tosetrMessage('warning', 'updating')

                },

                success: function (jsonRespond) {

                    if(jsonRespond.Status === 'OK'){
                        tosetrMessage('success', jsonRespond.Msg)
                        setTimeout(function() {
                            window.location.href = "my_account";
                        }, 1000);

                    } else {
                        tosetrMessage('error', jsonRespond.Msg)
                    }
                }

            });
            return false;
        }
    });


</script>
</body>
