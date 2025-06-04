<?php if ($this->uri->segment(1) !== 'track-your-application') {?>
<!-- download-apps-area start  -->
<div class="download-apps-area pb-75">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Download Our App</h4>
                <p>Buy and sell new or used cars, motorbikes, and spare parts on the go. </p>
                <p>Download it now.</p>
                <ul class="app_play-btns">
                    <li><a target="_blank" href="https://apps.apple.com/us/app/"><img src="assets/new-theme/images/apple-store.png" alt="app"></a></li>
                    <li><a target="_blank" href="https://play.google.com/store/apps/"><img src="assets/new-theme/images/play-store.png" alt="play"></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- download-apps-area end  -->

<?php } ?>

<!-- footer-area start  -->
<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-4 col-md-6 col-12">
                <div class="footer-contact">
                    <form id="sendMail">
                        <h3 class="footer-title">SEND A MESSAGE</h3>
                        <div class="text-danger" id="SendMail_name_msg" style="display: none"></div>
                        <input type="text" id="SendMail_name" name="name" placeholder="Name">
                        <div class="text-danger" id="SendMail_mail_msg" style="display: none"></div>
                        <input type="email" id="SendMail_email" name="email" required="" placeholder="Email">
                        <div class="text-danger" id="SendMail_comments_msg" style="display: none"></div>
                        <div class="w-100 hidden">
                            <textarea id="SendMail_comments" name="message" rows="6" placeholder="Comments"></textarea>
                        </div>
                        <div class="g-recaptcha" data-sitekey="<?php echo config_item('site_key'); ?>"></div>
                        <div id="ajax_respond" class="text-danger"></div>
                        <button  type="button" id="SendNow" style="margin-top: 15px;">send</button>
                    </form>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-md-6 col-12">
                <div class="footer-menu">
                    <h3 class="footer-title">COMPANY INFO</h3>
                    <ul>
                        <!-- <li><a href="seller">Dealers</a></li> -->
                        <li><a href="about-us"> About Us</a></li>
                        <li><a href="contact-us"> Contact Us</a></li>
                        <li><a href="blog">Blog</a></li>
                        <li><a href="privacy-policy"> Privacy Policy</a></li>
                        <li><a href="terms-and-conditions"> Terms and Conditions</a></li>
                        <!-- <li><a href="we-are-hiring-join-us"> We are hiring - join us</a></li> -->

                        <li><a href="car-valuation"> Car Valuation</a></li>
<!--                        <li><a href="vehicle-review"> Review</a></li>-->
                        <!-- <li><a href="part-exchange"> Part exchange</a></li> -->
                        <li><a href="faq"> FAQ</a></li>
                        <!-- <li><a href="how-it-work"> How It Works</a></li> -->
                    </ul>
                </div>
            </div>
            <div class="col-lg-5 col-12">
                <div class="newsLetter">
                    <h3 class="footer-title">NEWSLETTER</h3>
                    <p>Subscribe to our Newsletter.</p>
                    <div id="msg" class="" style="display: none;"></div>
                    <div class="text-danger" id="newsletter-msg" style="display: none"></div>
                    <form class="newsLetter-form">
                        <input  id="newsletter_email" type="email" name="ne" placeholder="Email">
                        <button type="button" id="btn_subscribe_no" class="btn_subscribe">Submit</button>
                    </form>
                </div>
                <div class="contactwrap">
                    <div class="contact-info">
                        <h3>CONTACT US</h3>
                        <ul>
                            <li><span class="material-icons">
                                        local_phone
                                    </span> +123 (0) 01234567891</li>
                            <li><i class="fa fa-whatsapp"></i> +123 (0) 98765432190</li>
                            <li>
                                    <span class="material-icons">
                                        alternate_email
                                    </span>
                                <a href="mailto:info@carquest.com">info@carquest.com</a> </li>
                        </ul>
                    </div>
                </div>
                <ul class="social-links">
                    <li> <a target="_blank" href="https://facebook.com/"><i class="fa fa-facebook"></i></a></li>
                    <li> <a target="_blank" href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                    <li> <a target="_blank" href="https://www.linkedin.com/"><i class="fa fa-linkedin"></i></a></li>
                    <li> <a target="_blank" href="https://www.youtube.com/"><i class="fa fa-youtube"></i></a></li>
                    <li> <a target="_blank" href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a></li>
                </ul>
            </div>
            <div class="col-12">
                <p class="copyright"> Copyright &copy; <script>
                document.write(new Date().getFullYear());


                </script> CarQuest. All Rights Reserved.
                </p>
            </div>
        </div>

    </div>
</footer>

<button class="scrollTopBtn waves-effect">
        <span class="material-icons">
            keyboard_capslock
        </span>
</button>
<!-- footer-area end  -->
<?php if (empty(getLoginUserData('user_id'))) { ?>
<div id="g_id_onload"
     data-client_id="<?=$this->config->item('google_client_id')?>"
     data-login_uri="<?=$this->config->item('google_redirect_uri')?>"
     data-context="signin"
</div>
<?php } ?>


<!--<script type="text/javascript" src="assets/new-theme/js/jquery-3.2.1.min.js?t=--><?php //echo time(); ?><!--"></script>-->
<script type="text/javascript" src="assets/new-theme/js/materialize.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/intlTelInput.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.scrollbar.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/slick.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/select2.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/scripts.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/custom.js"></script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script type="text/javascript" src='https://www.google.com/recaptcha/api.js' async defer ></script>


<script>
    var last_date_time = '';
    function chat_message_format(chat_date) {

        var utc_now = moment(moment.utc(chat_date.timestamp).toDate()).format('MMM Do YY');
        if (utc_now === moment().format('MMM Do YY')){
            if (last_date_time !== utc_now){
                last_date_time = utc_now;
                return 'Today';
            }
        } else {
            if (last_date_time !== utc_now) {
                last_date_time = utc_now;
                if (moment().subtract(1, 'days').format('MMM Do YY') === utc_now) {
                    return 'Yesterday'
                } else if (moment().subtract(2, 'days').format('MMM Do YY') === utc_now) {
                    return moment(chat_date.timestamp).format('dddd')
                } else if (moment().subtract(3, 'days').format('MMM Do YY') === utc_now) {
                    return moment(chat_date.timestamp).format('dddd')
                } else if (moment().subtract(4, 'days').format('MMM Do YY') === utc_now) {
                    return moment(chat_date.timestamp).format('dddd')
                } else if (moment().subtract(5, 'days').format('MMM Do YY') === utc_now) {
                    return moment(chat_date.timestamp).format('dddd')
                } else if (moment().subtract(6, 'days').format('MMM Do YY') === utc_now) {
                    return moment(chat_date.timestamp).format('dddd')
                } else {
                    return utc_now
                }
            }
        }
    }
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
</body>

</html>