<!-- product-details-area start  -->
<div class="product-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <h1 class="product-title"><?php echo($title); ?></h1>
                <ul class="preview-list">
                    <li class="left">
                        <span>#ID-<?php echo sprintf('%05d', $id); ?> (<?php echo GlobalHelper::getVehicleByPostId($id); ?>)</span>
                        <h4><img src="assets/theme/new/images/icons/map.png" alt="image"> <?php echo $location; ?></h4>
                    </li>
                    <li class="right">
                        <span>PRICE</span>
                        <h4><?php echo GlobalHelper::getPrice($priceinnaira, $priceindollar, $pricein) ?></h4>
                    </li>
                </ul>
                <div class="preview-wrapper">

                    <?php echo Modules::run('posts/posts_frontview/getSlider', $id, 875,getShortContentAltTag($title,60)); ?>

                </div>
                <h4 class="share-title">Share this product</h4>
                <ul class="share-items">
                    <li><a class="facebook" target="_blank"
                           href="https://www.facebook.com/sharer/sharer.php?u=<?php echo site_url('post/' . $post_slug); ?>"><i
                                    class="fa fa-facebook"></i></a></li>
                    <li><a class="twitter"
                           href="http://twitter.com/share?text=<?php echo $title; ?>&url=<?php echo site_url('post/' . $post_slug); ?>"><i
                                    class="fa fa-twitter"></i></a></li>
                    <li><a class="linkedin" target="_blank" href="https://wa.me/?text=<?php echo site_url('post/'.$post_slug); ?>">
                            <i class="fa fa-whatsapp"></i></a>
                    </li>
                </ul>
                <?php if ($type_id != 4 && $post_type != 'Automech') : ?>
                    <h4 class="details-title">Details</h4>
                    <div class="row">
                        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                            <div class="details-item">
                                <div class="details-icon">
                                    <img src="assets/theme/new/images/icons/preview/icon1.png" alt="image">
                                </div>
                                <div class="details-content">
                                    <span>Brand</span>
                                    <strong><?php getVhecileDetails($brand_id); ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                            <div class="details-item">
                                <div class="details-icon">
                                    <img src="assets/theme/new/images/icons/preview/icon2.png" alt="image">
                                </div>
                                <div class="details-content">
                                    <span>Fuel Type</span>
                                    <strong><?php getVhecileDetails($fuel_id); ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                            <div class="details-item">
                                <div class="details-icon">
                                    <img src="assets/theme/new/images/icons/preview/icon3.png" alt="image">
                                </div>
                                <div class="details-content">
                                    <span>Driven</span>
                                    <strong><?php getVhecileDetails($mileage); ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                            <div class="details-item">
                                <div class="details-icon">
                                    <img src="assets/theme/new/images/icons/preview/icon4.png" alt="image">
                                </div>
                                <div class="details-content">
                                    <span>Color</span>
                                    <strong><?php getVhecileDetails($color); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-4 col-12">
                <ul class="preview-sidebar-btn">
                    <li>
                        <button class="btnPreview" data-toggle="modal" data-target="#contact_seller"
                                data-backdrop="static">CONTACT SELLER
                        </button>
                    </li>
                    <li>
                        <a class="btnPreview offermake"
                                onclick="get_quote(<?php echo $id . ',' . $user_id . ',\'' . $post_slug; ?>')">MAKE AN
                            OFFER
                        </a>
                    </li>
                    <?php if (array_key_exists($type_id, loan_vehicle()) && ($post_type != 'Automech' && $post_type != 'Towing')) : ?>
                    <li>
                        <a href="car-loan/<?php echo $post_slug; ?>" class="btnPreview">FINANCE</a>
                    </li>
                    <li>
                        <a href="car-insurance/<?php echo $post_slug; ?>" class="btnPreview">INSURANCE</a>
                    </li>
                        <li>
                            <form action="review" method="post">
                                <input type="hidden" name="title" value="<?php echo $title; ?>">
                                <input type="hidden" name="vehicle_type_id" value="<?php echo $type_id; ?>">
                                <input type="hidden" name="brand_id" value="<?php echo $brand; ?>">
                                <input type="hidden" name="model_id" value="<?php echo  $model_id; ?>">
                                <button type="submit" class="btnPreview">REVIEW</button>
                            </form>
                        </li>
                    <?php endif; ?>
                    <li><a href="post/compare?from_slug=<?php echo  $post_slug; ?>&type=detail&to_slug=0"
                           class="btnPreview">COMPARE</a>
                    </li>
                </ul>
                <div class="preview-sidebar">
                    <?php echo GlobalHelper::getSellerInfo($user_id); ?>
                </div>
                <button class="chat btnPreview mb-5 mt-5">
                    <i class="fa fa-commenting-o"></i>
                    Chat
                </button>
            </div>
            <div class="col-lg-9 col-12">
                <ul class="nav preview-tabs">
                    <li><a class="active" href="#description" data-toggle="tab">Description
                        </a></li>
                    <?php if ($type_id != 4 && ($post_type != 'Automech' && $post_type != 'Towing')) : ?>
                        <li><a href="#registration_info" data-toggle="tab">Registration Info</a></li>
                    <?php endif; ?>
                    <li><a href="#others_info" data-toggle="tab">Others Info</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="description">
                        <div class="discription"><?php echo $description; ?></div>
                    </div>
                    <?php if ($type_id != 4 && ($post_type != 'Automech' && $post_type != 'Towing')) : ?>
                        <div class="tab-pane" id="registration_info">
                            <ul class="discription-info">
                                <li><strong>Registration Number</strong>
                                    <span><?php getVhecileDetails($registration_no); ?></span></li>
                                <li><strong>Registration Date </strong>
                                    <span><?php getVhecileDetails($registration_date); ?></span></li>
                                <li><strong>Brand Name </strong> <span><?php getVhecileDetails($brand_id); ?></span>
                                </li>
                                <li><strong>Model Name</strong> <span><?php getVhecileDetails($model_name); ?></span>
                                </li>
                                <li><strong>Engine Size</strong>
                                    <span><?php getVhecileDetails($enginesize_id); ?></span></li>
                                <li><strong>Body Type</strong> <span><?php getVhecileDetails($body_type); ?></span></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="tab-pane" id="others_info">
                        <ul class="discription-info">
                            <?php if ($post_type == 'Automech') : ?>
                                <li><strong>Specialism</strong>
                                    <span><?php echo GlobalHelper::getSpecialismView($specialism_id); ?></span></li>
                                <li><strong>Repair type</strong>
                                    <span><?php echo GlobalHelper::getRepairTypeView($repair_type_id); ?></span></li>
                                <li><strong>Service type</strong> <span><?php echo $service_type; ?></span></li>
                                <li><strong>Brand</strong> <span><?php echo GlobalHelper::postBrand($id); ?></span></li>
                            <?php endif; ?>
                            <li><strong>Product Type</strong> <span><?php getVhecileDetails($vehicle_type_id); ?></span>
                            </li>
                            <li><strong>Fuel Type</strong> <span><?php getVhecileDetails($fuel_id); ?></span></li>
                            <li><strong>Color</strong> <span><?php getVhecileDetails($color); ?></span></li>
                            <li><strong>Alloy wheels</strong> <span><?php getVhecileDetails($alloywheels); ?></span>
                            </li>
                            <li><strong>Gear Box</strong> <span><?php getVhecileDetails($gear_box_type); ?></span></li>
                            <li><strong>Owners</strong> <span><?php getVhecileDetails($owners); ?></span></li>
                            <li><strong>Service history</strong>
                                <span><?php getVhecileDetails($service_history); ?></span></li>
                            <li><strong>Condition</strong> <span><?php $condition; ?></span></li>
                        </ul>
                    </div>
                </div>
                <?php if ($vehicle_type_id != 2 && ($post_type != 'Automech' && $post_type != 'Towing')): ?>
                    <div class="row mt-80 featured-items">
                        <div class="col-12">
                            <h3 class="title"><span>Special</span> Features</h3>
                        </div>
                        <div class="col-12"><?php echo $get_features; ?></div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-3">
                <div class="car-delar">
                    <h4><img src="assets/theme/new/images/icons/icon.png" alt="image">
                        <?php if ($post_type == 'Automech') { ?>
                            Automech
                        <?php } else if ($post_type == 'Towing') { ?>
                            Towing
                        <?php } else if ($vehicle_type_id_int == 4) { ?>
                            Spare parts
                        <?php } else { ?>
                            Cars
                        <?php } ?>
                        From This Dealer
                    </h4>
                    <?php echo Modules::run('post/posts_frontview/getFromThisSeller', $user_id); ?>
                </div>
                <!-- <div class="location-map">
                    <h5>Location Map</h5>
                    <?php echo initGoogleMap($lat, $lng, 'Location of the Product'); ?>
                   <img src="assets/images/map.png" alt="image">
                </div> -->
            </div>
        </div>
    </div>
</div>

<?php echo Modules::run('posts/posts_frontview/getRelatedPost', $model_id, $id); ?>
<?php echo Modules::run('posts/posts_frontview/getRelatedSearch', $model_id, $id); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js" type="text/javascript"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>-->
<!--<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/dot-luv/jquery-ui.css" />-->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>

<link rel="stylesheet" href="assets_chat/css/chat.css">
<script src="assets_chat/css/date.js" type="text/javascript"></script>
<script src="assets/theme/new/js/slick.min.js"></script>

<div class="modal fade modalWrapper" id="contact_seller" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <h2 class="modal-title">Contact Seller</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="contactSeller-wrap">
                <ul class="contact-btns">
                    <li>
                        <a href="tel:<?php echo $contact_no; ?>" class="contact-sell-btn phone">
                            <img class="normal" src="assets/theme/new/images/phone.png" alt="image">
                            <img class="hover" src="assets/theme/new/images/phone-h.png" alt="image">
                            Phone
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)"
                           onclick="window.open('https://wa.me/<?php echo GlobalHelper::wahtsAppNo($user_id); ?>/?text=<?php echo $title . ' ' . urldecode(site_url('post/' . $post_slug)); ?>')"
                           class="contact-sell-btn whatsapp">
                            <img class="normal" src="assets/theme/new/images/whatsapp.png" alt="image">
                            <img class="hover" src="assets/theme/new/images/whatsapp-h.png" alt="image">
                            Whatsapp
                        </a>
                    </li>
                    <li class="chat">
                        <a data-name='C'
                           data-label="live chat"
                           src="<?php echo base_url('/chat-form?vendor=' . $user_id . '&token=' . rand(1000, 9999)) ?>"
                            class="contact-sell-btn chat-btn <?php echo $current_status; ?>">
                            <img class="normal" src="assets/theme/new/images/chat.png" alt="image">
                            <img class="hover" src="assets/theme/new/images/chat-h.png" alt="image">
                            Chat
                        </a>
                    </li>
                </ul>
                <form role="form" id="ContactSellerForm">
                    <input type="hidden" name="seller_id" value="<?php echo $user_id; ?>"/>
                    <input type="hidden" name="post_id" value="<?php echo $id; ?>"/>
                    <input type="hidden" name="listing_url" value="<?php echo $post_slug; ?>"/>
                    <div id="ajax_respond2"></div>
                    <div class="modalInput">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="senderName" value="<?php echo getLoginUserData('name'); ?>" placeholder="Your Name">
                        <div id="name_msg" class="text-warning" style="display: none;"></div>
                    </div>
                    <div class="modalInput">
                        <label for="email">Your Email</label>
                        <input type="text" id="InputEmail" name="email" placeholder="Enter Email" value="<?php echo getLoginUserData('user_mail'); ?>" required="">
                        <div id="email_msg" class="text-warning" style="display: none;"></div>
                    </div>
                    <div class="modalInput">
                        <label for="email">Your Phone</label>
                        <input type="text" id="InputPhone" name="phone" placeholder="Enter Phone" value="<?php echo getUserDataByUserId(getLoginUserData('user_id'), 'contact'); ?>">
                        <div id="phone_msg" class="text-warning" style="display: none;"></div>
                    </div>
                    <div class="modalTextarea">
                        <label for="message">message</label>
                        <textarea name="message" id="InputMessage" rows="5" required="" placeholder="message">I saw this ads for sale at <?php echo base_url('post/' . $post_slug); ?>. I have an offer for the deal and want to discuss with you further. Would you please contact me as soon as possible?</textarea>
                        <div id="message_msg" class="text-warning" style="display: none;"></div>
                    </div>
                    <ul class="contact-sell-btn-wrap">
                        <li><button class="close-btn default-btn" type="button" data-dismiss="modal"
                                    aria-label="Close">Close</button></li>
                        <li><button class="default-btn" type="submit" id="sendToSeller">Send</button></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="getQuote">

</div>


<div aria-hidden="true" data-backdrop="static" class="modal fade chatModalViewWrap" id="chatModalView"
     tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button aria-label="Close" class="close modalClose" data-dismiss="modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="chatBox_wrap_saller">
                <div class="chatbox-header">
                    <h3 class="chat-company-name">John Du</h3>
                </div>
                <div class="scrollbar-inner" id="your_div">
                    <div class="chat-items">

                    </div>
                </div>
                <div class="modal-chat-input">
                    <input id="message" type="text" placeholder="Type your message...">
                    <button id="send-message"><i class="fa fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>


<div aria-hidden="true" data-backdrop="static" class="modal fade chatModalViewWrap" id="loginModalView"
     tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button aria-label="Close" class="close modalClose" data-dismiss="modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
             <div class="user-info-login">
                <h3>Please Login or Sign Up first to Continue Chat</h3>
                <h4><a href="my-account?goto=post/<?php echo $post_slug; ?>">Login</a> or <a href="sign-up">Sign Up</a></h4>
            </div>
        </div>
    </div>
</div>


<script>

    $('.special-featured-active').not('.slick-initialized').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        dots: false,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    arrows: true,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    infinite: true,
                    arrows: false,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                }
            },
        ]
    });

    var $ = jQuery;
    if ($(window).width() > 768) {
        $("#dialog").dialog({
            width: 943,
            height: 683,
            autoOpen: false
        });
    } else {
        $("#dialog").dialog({
            width: 320,
            height: $(window).height() - 100,
            autoOpen: false
        });
    }

    $("#dialog").resizable();
    $(".chatButton").click(function () {
        $("#loader").show();
        var url = $(this).attr('src');
        $("#dialog").dialog("open");
        $('#MainPopupIframe').attr('src', url);
        $('#MainPopupIframe').on('load', function () {
            $("#loader").hide();
            $('#MainPopupIframe').show();
        });
    });
    $('.ui-dialog-titlebar-close').click(function () {
        $('#MainPopupIframe').attr('src', 'blank.php');
        $('#MainPopupIframe').hide();
    });
    var topBar = '<div class="dia_full">\n\
<div class="diaLeftSide"></div> <div class="diaRightSide"><a  class="minimize" role="button"><img src="<?php echo base_url('assets_chat/'); ?>minimize.png" /></a><a href="<?php echo base_url(uri_string()); ?>" class="ui-dialog-titlebar-close ui-corner-all" role="button"><img src="<?php echo base_url('assets_chat/'); ?>close_btn.png" /></a></div></div>';
    $(".ui-dialog-titlebar").html(topBar);

    $('.minimize').on('click', function () {
        $('.ui-draggable.ui-resizable').css('display', 'none');
        $('.minmize_bar').show();
    });

    $('.pop-chat').click(function () {
        $('#contact_seller').modal('hide');
    });

    $('.product-slider-active').not('.slick-initialized').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.product-details-thumbnil'
    });
    $('.product-details-thumbnil').not('.slick-initialized').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.product-slider-active',
        dots: false,
        focusOnSelect: true
    });

</script>


<?php $this->load->view('frontend/script_js'); ?>
<script>

    jQuery(document).ready(function () {
        /*Contact Seller*/
        jQuery("#sendToSeller").click(function (event) {
            event.preventDefault();
            var formData = jQuery('#ContactSellerForm').serialize();

            var senderNamex = jQuery('[name=senderName]').val();
            var emailx = jQuery('[name=email]').val();
            var phonex = jQuery('[name=phone]').val();
            var messagex = jQuery('[name=message]').val();
            var error = 0;

            if (validateEmail(emailx) === false || !emailx) {
                jQuery('#email_msg').html('Invalid Email.').show();
                jQuery('#InputEmail').addClass('required');
                error = 1;
            } else {
                jQuery('#email_msg').hide();
                jQuery('#InputEmail').removeClass('required');
            }
            if (!messagex) {
                jQuery('#message_msg').html('Please enter your message.').show();
                jQuery('#InputMessage').addClass('required');
                error = 1;
            } else {
                jQuery('#message_msg').hide();
                jQuery('#InputMessage').removeClass('required');
            }
            if (!senderNamex) {
                jQuery('#name_msg').html('Pleae enter your name').show();
                jQuery('#senderName').addClass('required');
                error = 1;
            } else {
                jQuery('#name_msg').hide();
                jQuery('#senderName').removeClass('required');
            }
            if (!phonex) {
                jQuery('#phone_msg').html('Pleae enter your Phone Number').show();
                jQuery('#InputPhone').addClass('required');
                error = 1;
            } else {
                jQuery('#phone_msg').hide();
                jQuery('#InputPhone').removeClass('required');
            }
            if (!error) {
                jQuery.ajax({
                    type: "POST",
                    //url: "contact_seller",
                    url: "mail/contact_seller",
                    dataType: 'json',
                    data: formData,
                    beforeSend: function () {
                        jQuery('#ajax_respond2')
                            .html('<p class="ajax_processing"> Sending...</p>')
                            .css('display', 'block');
                    },
                    success: function (jsonData) {
                        jQuery('#ajax_respond2').html(jsonData.Msg);
                        if (jsonData.Status === 'OK') {
                            document.getElementById("ContactSellerForm").reset();
                            setTimeout(function () {
                                jQuery('#ajax_respond2').slideUp();
                            }, 2500);
                            setTimeout(function () {
                                jQuery('#contact_seller').modal('toggle');
                            }, 3000);
                        }
                    }
                });
            }
            return false;
        });
        /*End Contact Seller*/
    });

    function submit_getQuote() {

        var formData = jQuery('#get_quote').serialize();
        var error = 0;


        var offer_message = jQuery('[name=offer_message]').val();
        if (!offer_message) {
            jQuery('[name=offer_message]').addClass('required');
            error = 1;
        } else {
            jQuery('[name=offer_message]').removeClass('required');
        }

        if (!error) {
            jQuery.ajax({
                url: 'mail/send_offer',
                type: "POST",
                dataType: "json",
                data: formData,
                beforeSend: function () {
                    jQuery('#ajax_respond').html('<p class="ajax_processing">Loading...</p>');
                },
                success: function (jsonRepond) {

                    if (jsonRepond.Status === 'OK') {
                        jQuery('#ajax_respond').html(jsonRepond.Msg);
                        setTimeout(function () {
                            jQuery('#manageReport').modal('hide');
                            jQuery('#ajax_respond').html('');
                            jQuery('#getQuote').modal('toggle');
                        }, 2000);
                    } else {
                        jQuery('.report_respond').html(jsonRepond.Msg);
                    }
                }
            });
        }

    }


    // Get  Quote
    function get_quote(post_id, seller_id, post_slug) {
        jQuery('#getQuote').load('posts/Posts_frontview/getQuote/?post_id=' + post_id + '&seller_id=' + seller_id + '&slug=' + post_slug);
    }

</script>


<div class="minmize_bar" style="display: none;">
    <div class="minmize_inner">
        Maximize chat
    </div>
</div>


<script>
    jQuery('.minmize_inner').on('click', function () {
        jQuery('.ui-draggable.ui-resizable').css('display', 'block');
        jQuery('.minmize_bar').hide();
    });
</script>

<script>

    $('#chatModalView').on('hidden.bs.modal', function () {
        let userId = "<?php echo getLoginUserData('user_id'); ?>";
        let channelName = "chat-" + userId + "-" + $(".seller_user_id").data('seller_user_id');
    });

    $(document).on('click', '.chat', function () {
        $("#contact_seller").modal("hide");
        let userId = "<?php echo getLoginUserData('user_id'); ?>";
        if (userId == null || userId == "") {
            $('#loginModalView').modal();
        } else {
            $('#chatModalView').modal();
            $('.chat-company-name').text($('.company-name').text());
            getConnection($(".seller_user_id").data('seller_user_id'));
            $('#your_div').animate({
                scrollTop: $('#your_div')[0].scrollHeight
            }, 500);
        }
    });

    $("#message").keyup(function (e) {
        let message = $("#message").val();
        if (message != "") {
            let code = e.keyCode || e.which;
            if (code == 13) { //Enter keycode
                appendSenderMessage();
            }
        } else {
            console.log("Hello")
        }
    });

    $("#send-message").click(function () {
        appendSenderMessage();
    });

    function appendSenderMessage() {
        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];
        let message = $("#message").val();
        let date = new Date();
        let time = date.getDate() + " " + monthNames[date.getMonth()] + ", " + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes();
        if (message != "") {
            $('.chat-items').append("<div class=\"chat-item-right chat-item\">\n" +
                "                            <div class=\"chat-item-content\">\n" +
                "                                <span>" + time + "</span>\n" +
                "                                <p>" + message + "</p>\n" +
                "                            </div>\n" +
                "                        </div>");
            $('#your_div').animate({
                scrollTop: $('#your_div')[0].scrollHeight
            }, 500);
            $("#message").val('');
        }
        let receiver = $(".seller_user_id").data('seller_user_id');
        // $.ajax({
        //     url: 'admin/chat/send_chat_message',
        //     type: "POST",
        //     data: { message: message, receiver: receiver },
        //     success: function (response) {
        //     }
        // });
    }

    function getConnection(otherUser)
    {
        let userId = "<?php echo getLoginUserData('user_id'); ?>";
        console.log(userId);
        let channelName = "chat-" + userId + "-" + otherUser;

        $.ajax({
            url: 'admin/chat/get_user_chat',
            type: "GET",
            data: {id: otherUser},
            beforeSend: function () {
                $('.chat-items').html(`<div class="chat_processing">
                        <p>Processing...</p>
                    </div>`);
            },
            success: function (response) {
                $('.chat-items').html("");

                let jsonResponse = JSON.parse(response);
                console.log(jsonResponse);
                if (jsonResponse.data.chats != undefined && jsonResponse.data.chats != "") {
                    let chatHtml = "";
                    jsonResponse.data.chats.forEach(function (item) {
                        if (item.sender == userId) {
                            chatHtml += "<div class=\"chat-item-right chat-item\">\n" +
                                "                                        <div class=\"chat-item-content\">\n" +
                                "                                            <span>" + item.timestamp + "</span>\n" +
                                "                                            <p>"+ item.message + "</p>\n" +
                                "                                        </div>\n" +
                                "                                    </div>";
                        } else {
                            console.log(item.timestamp);
                            chatHtml += "<div class=\"chat-item-left chat-item\">\n" +
                                "                                        <div class=\"chat-item-avatar\">\n" +
                                "                                            <div class=\"chat-item-img\">\n" +
                                "                                                <img src=\"assets/theme/new/images/backend/avatar.png\" alt=\"\">\n" +
                                "                                            </div>\n" +
                                "                                            <div class=\"chat-item-content\">\n" +
                                "                                                <span><span>" + item.otherUserName + "</span> " + item.timestamp + "</span>\n" +
                                "                                        <p>" + item.message + "</p>\n" +
                                "                                            </div>\n" +
                                "                                        </div>\n" +

                                "                                    </div>";
                        }
                    });

                    $('.chat-items').html(chatHtml);
                } else {
                    $('.chat-items').html(`<div class="chat_processing">
                        <p>No Conversation Yet</p>
                    </div>`);
                }
            }
        });
    }
</script>
