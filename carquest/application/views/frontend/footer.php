<?php $remove = isMobileDevice(); ?>
<?php if (empty($remove)) { ?>

<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-4 col-12">
                <div class="footer-contact">
                    <form id="sendMail">
                        <h3 class="footer-title">SEND A MESSAGE</h3>
                        <div class="text-danger" id="SendMail_name_msg" style="display: none"></div>
                        <input type="text" id="SendMail_name" name="name" placeholder="Name">
                        <div class="text-danger" id="SendMail_mail_msg" style="display: none"></div>
                        <input type="email" id="SendMail_email" name="email" required="" placeholder="Email">
                        <div class="text-danger" id="SendMail_comments_msg" style="display: none"></div>
                        <textarea id="SendMail_comments" name="message" rows="6" placeholder="Comments"></textarea>
                        <div class="g-recaptcha" data-sitekey="<?php echo config_item('site_key'); ?>"></div>
                        <div id="ajax_respond" class="text-danger"></div>
                        <button  type="button" id="SendNow" style="margin-top: 30px;">send</button>
                    </form>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-12">
                <div class="footer-menu">
                    <h3 class="footer-title">COMPANY INFO</h3>
                    <ul>
                        <li><a href="seller">Dealers</a></li>
                        <li><a href="about-us"> About Us</a></li>
                        <li><a href="contact-us"> Contact Us</a></li>
                        <li><a href="blog">Blog</a></li>
                        <li><a href="privacy-policy"> Privacy Policy</a></li>
                        <li><a href="terms-and-conditions"> Terms and Conditions</a></li>
                        <!-- <li><a href="we-are-hiring-join-us"> We are hiring - join us</a></li> -->
                        <li><a href="car-finance">Finance</a></li>
                        <li><a href="insurance-for-car">Insurance</a></li>
                        <li><a href="car-valuation"> Car Valuation</a></li>
                        <li><a href="search-review"> Review</a></li>
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
                        <button type="button" class="btn_subscribe">Submit</button>
                    </form>
                </div>
                <div class="contactwrap">
                    <div class="contact-info">
                        <h3>CONTACT US</h3>
                        <ul>
                            <li><img src="assets/theme/new/images/icons/phone.png" alt="image"> +234 (0) 9055566881</li>
                            <li><img src="assets/theme/new/images/icons/whatsapp.png" alt="image">  +234 (0)
                                8152683517</li>
                            <li><img src="assets/theme/new/images/icons/email.png" alt="image"> <a
                                        href="mailto:info@carquest.com">info@carquest.com</a> </li>
                        </ul>
                    </div>
                    <ul class="download-app">
                        <li><a target="_blank" href="https://apps.apple.com/"><img src="assets/theme/new/images/app.png" alt="image"></a></li>
                        <li><a target="_blank" href="https://play.google.com/"><img src="assets/theme/new/images/play.png" alt="image"></a></li>
                    </ul>
                </div>
                <ul class="social-links">
                    <li> <a target="_blank" href="https://twitter.com/"><img src="assets/theme/new/images/icons/social/tw.png" alt="image"></a></li>
                    <li> <a target="_blank" href="https://facebook.com/"><img src="assets/theme/new/images/icons/social/fa.png" alt="image"></a></li>
                    <li> <a target="_blank" href="https://www.linkedin.com/company/"><img src="assets/theme/new/images/icons/social/li.png" alt="image"></a></li>
                    <li> <a  target="_blank" href="https://www.youtube.com/channel/UCmyfx9PyVYxg8G1N0hkabjQ"><img src="assets/theme/new/images/icons/social/yo.png" alt="image"></a></li>
                    <li> <a target="_blank" href="https://www.instagram.com/"><img src="assets/theme/new/images/icons/social/ins.png" alt="image"></a></li>
                </ul>
            </div>
            <div class="col-12">
                <p class="copyright"> Copyright  &copy; <script>document.write(new Date().getFullYear());</script> to CarQuest. All rights reserved.</p>
            </div>
        </div>

    </div>
</footer>

<button class="scrollTopBtn">&#8593;</button>
<!-- footer-area end  -->
<?php } ?>


<script type="text/javascript" src="assets/theme/new/js/popper.min.js"></script>
<script type="text/javascript" src="assets/theme/new/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/theme/new/js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="assets/theme/new/js/jquery.smoothscroll.min.js"></script>
<script type="text/javascript" src="assets/theme/new/js/jquery.scrollbar.min.js"></script>
<script type="text/javascript" src="assets/theme/new/js/slick.min.js"></script>
<script type="text/javascript" src="assets/theme/new/js/jquery-steps.min.js"></script>
<script type="text/javascript" src="assets/theme/new/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/theme/new/js/select2.min.js"></script>
<script type="text/javascript" src="assets/theme/new/js/jquery.smartbanner.js"></script>
<script type="text/javascript" src="assets/theme/new/js/jquery.scrollbar.min.js"></script>
<script src="assets/theme/new/js/lazysizes.min.js"></script>
<!-- <script src="assets/theme/new/js/jquery.watermark.min.js"></script> -->
<script type="text/javascript" src="assets/theme/new/js/script.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/theme/js/custom.js"></script>
<script type="text/javascript" src='https://www.google.com/recaptcha/api.js' async defer ></script>

<script>
    $(document).on('click', '.quicklink', function () {
        $(this).toggleClass('active')
        $('.quickmenu-wrapper').toggleClass('active')
        $('.moremenu-area').removeClass('active');
        $('.search-area').removeClass('active');
        $('.menu-trigger').removeClass('active');
    })
    $('.moremenu,.responsive-trigger').on('click', function () {
        $('.moremenu-area').toggleClass('active');
        $('.search-area').removeClass('active');
        $('.search-btn').removeClass('active');
    })
</script>
<script>

$(function () {
    if ( !(/(iPad|iPhone|iPod).*OS [6-7].*AppleWebKit.*Mobile.*Safari/.test(navigator.userAgent)) ) {
        $.smartbanner({
            title: 'CarQuest- Buy & Sell Car',
            author: 'CarQuest',
            price: 'FREE',
            appStoreLanguage: 'us',
            GooglePlayParams: null,
            icon: 'assets/theme/new/images/app-icon-appstore.png',
            daysHidden: 30,
            daysReminder: 0,
            appendToSelector: 'body',
            layer: true,
            button: 'View',
            hideOnInstall: false,
            speedIn: 0,
            scale: 'auto',
        });
    }
})
function getModels(brand_id) {
    var type_id = $('#home_type_id').val();
    $.ajax({
        url: 'brands/brands_frontview/brands_by_vehicle_model/?type_id=' + type_id + '&brand_id=' + brand_id,
        type: "GET",
        dataType: "text",
        beforeSend: function () {
            $('#home_model_id').html('<option value="0">Loading..</option>');
        },
        success: function (response) {
            $('#home_model_id').html(response);
        }
    });
}

    $(function(){
    $("#subscribeForm").validate({
        rules: {
            subscribe_email:{
                required: true,
                email:true,
            },
        },
        messages: {
            subscribe_email: {
                required:'E-mail can not be empty',
                email:'Please enter a valid email address'
            }
        },
    submitHandler: function(form) {

    }});
});
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5b92655aafc2c34e96e85035/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
</body>

</html>
