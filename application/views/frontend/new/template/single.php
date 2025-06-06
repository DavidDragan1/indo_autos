<!-- breadcumb_search-area start  -->
<?php include_once dirname(APPPATH) . "/application/views/frontend/new/template/global_search.php"; ?>
<!-- breadcumb_search-area end  -->

<div class="post-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-12 mb-50">
                <?php echo Modules::run('posts/posts_frontview/getSlider', $id, 875, getShortContentAltTag($title, 60)); ?>
            </div>
            <div class="col-lg-5 col-12 mb-50">
                <div class="post-details-info">
                    <div class="post-details-info-top">
                        <div class="post-details-info-top-left">
                            <ul class="product-info">
                                <li class="product-id">ID: #<?= $id ?></li>
                                <li><span><?= $manufacture_year ?><?php echo @$to_year ? ' - ' . $to_year : '' ?></span>
                                </li>
                                <li><span><?= $condition ?></span></li>
                            </ul>
                            <h1><?= $title ?> <?= GlobalHelper::seller_badge($user_id) ?></h1>
                        </div>
                        <div class="post-details-info-top-right">
                            <div>
                                    <span class="like <?= empty($is_liked) ? '' : 'active' ?>">
                                        <span class="material-icons"> <?= empty($is_liked) ? 'favorite_border' : 'favorite' ?></span>
                                        <span class="count-value"><?= GlobalHelper::get_post_like($id) ?> </span> Likes
                                    </span>
                            </div>
                        </div>
                    </div>
                    <ul class="post-details-price">

                        <li>
                            <span>Price</span>
                            <h4><?php echo GlobalHelper::getPrice($priceinnaira, $priceindollar, $pricein) ?></h4>
                        </li>

                        <?php if (in_array($vehicle_type_id_int, [1, 3])) { ?>
                            <li>
                                <span>Mileage</span>
                                <h4><?= number_shorten($mileage, 1) ?> Miles</h4>
                            </li>
                        <?php } ?>
                    </ul>
                    <ul class="post-details-location">
                        <li><span class="material-icons">location_on</span> <?= $location ?></li>
                       
                    </ul>
                    <ul class="post-details-location">
                        <li><span>Product: </span><?= ($tag_name) ? "<a href='products/$tag_slug'>$tag_name</a>" : '' ?>
                        </li>
                        <li><span>Location: </span><span style="color: #f05c26; margin-left: 5px"><?= $state_name ?></span></li>
                    </ul>
                    <a class="compare-car"
                               href="post/compare?first=<?= $post_slug ?>&vehicle=<?= GlobalHelper::getVehicleSlugbyId($vehicle_type_id_int) ?>">
                                <?php
                                    if ($vehicle_type_id_int == 3) {
                                        echo "Compare Motorbike";
                                    } elseif ($vehicle_type_id_int == 4) {
                                        echo "Compare Spare Parts";
                                    } else {
                                        echo "Compare Car";
                                    }
                                ?>

                                <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.700159 11.2998C0.516826 11.1165 0.425159 10.8831 0.425159 10.5998C0.425159 10.3165 0.516826 10.0831 0.700159 9.8998L4.57516 5.9998L0.700159 2.0998C0.516826 1.91647 0.420826 1.68747 0.412159 1.4128C0.403493 1.13814 0.499492 0.900471 0.700159 0.699804C0.883492 0.516471 1.11683 0.424805 1.40016 0.424805C1.68349 0.424805 1.91683 0.516471 2.10016 0.699804L6.70016 5.2998C6.80016 5.3998 6.87116 5.50814 6.91316 5.6248C6.95516 5.74147 6.97583 5.86647 6.97516 5.9998C6.97516 6.13314 6.95449 6.25814 6.91316 6.3748C6.87183 6.49147 6.80083 6.5998 6.70016 6.6998L2.10016 11.2998C1.91683 11.4831 1.68783 11.5791 1.41316 11.5878C1.13849 11.5965 0.900826 11.5005 0.700159 11.2998ZM7.30016 11.2998C7.11683 11.1165 7.02516 10.8831 7.02516 10.5998C7.02516 10.3165 7.11683 10.0831 7.30016 9.8998L11.1752 5.9998L7.30016 2.0998C7.11683 1.91647 7.02083 1.68747 7.01216 1.4128C7.00349 1.13814 7.09949 0.900471 7.30016 0.699804C7.48349 0.516471 7.71683 0.424805 8.00016 0.424805C8.28349 0.424805 8.51683 0.516471 8.70016 0.699804L13.3002 5.2998C13.4002 5.3998 13.4712 5.50814 13.5132 5.6248C13.5552 5.74147 13.5758 5.86647 13.5752 5.9998C13.5752 6.13314 13.5542 6.25814 13.5122 6.3748C13.4702 6.49147 13.3995 6.5998 13.3002 6.6998L8.70016 11.2998C8.51683 11.4831 8.28783 11.5791 8.01316 11.5878C7.73849 11.5965 7.50083 11.5005 7.30016 11.2998Z" fill="#F05C26"/>
                                </svg>

                            </a>
                    <?php echo GlobalHelper::getSellerInfo($user_id, $title, $post_slug, $id); ?>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php
                if (in_array($vehicle_type_id_int, [1, 3])) {
                    ?>
                    <div class="vehicle-overview-wrap">
                        <h5>Vehicle overview</h5>
                        <ul class="vehicle-overview-list">
                            <li class="vehicle-overview">
                                <div class="vehicle-overview-icon">
                                    <img src="assets/new-theme/images/icons/details/icon1.svg" alt="">
                                </div>
                                <div class="vehicle-overview-content">
                                    <span>Body Colour</span>
                                    <p><?php getVhecileDetails($color); ?></p>
                                </div>
                            </li>
                            <li class="vehicle-overview">
                                <div class="vehicle-overview-icon">
                                    <img src="assets/new-theme/images/icons/details/icon2.svg" alt="">
                                </div>
                                <div class="vehicle-overview-content">
                                    <span>Body Type</span>
                                    <p><?= getVhecileDetails($body_type) ?></p>
                                </div>
                            </li>
                            <?php if ($vehicle_type_id_int == 1) { ?>
                                <li class="vehicle-overview">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon3.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Seat</span>
                                        <p><?php getVhecileDetails($seats); ?></p>
                                    </div>
                                </li>

                                <li class="vehicle-overview">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon4.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Engine</span>
                                        <p><?php getVhecileDetails($enginesize_id); ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                            <li class="vehicle-overview">
                                <div class="vehicle-overview-icon">
                                    <img src="assets/new-theme/images/icons/details/icon5.svg" alt="">
                                </div>
                                <div class="vehicle-overview-content">
                                    <span>Fuel Type</span>
                                    <p><?php getVhecileDetails($fuel_id); ?></p>
                                </div>
                            </li>
                            <?php if ($vehicle_type_id_int == 1) { ?>
                                <li class="vehicle-overview">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon6.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Transmission</span>
                                        <p><?php getVhecileDetails($gear_box_type); ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <ul class="post_info-tabs tabs">
                    <li class="tab">
                        <a class="active waves-effect" href="#description">Description</a>
                    </li>
                    <?php
                    if (in_array($vehicle_type_id_int, [1, 3])) {
                        ?>
                        <?php if ($vehicle_type_id_int == 1) { ?>
                            <li class="tab">
                                <a class="waves-effect" href="#features">Features</a>
                            </li>
                        <?php } ?>
                        <li class="tab">
                            <a class="waves-effect" href="#reviews">Reviews</a>
                        </li>
                    <?php } ?>
                </ul>
                <div id="description" class="description-wrap">
                    <?= $description ?>
                </div>
                <?php
                if (in_array($vehicle_type_id_int, [1, 3])) {
                    ?>
                    <ul id="features" class="features-wrap">
                        <?php echo $get_features; ?>
                    </ul>
                    <div id="reviews" class="reviews-wrap">
                        <?php if (!empty($review)) : ?>
                            <p><?= $review->overview ?></p>
                            <a href="review/<?= $review->slug ?>" class="btnStyle waves-effect btnStyleOutline mt-20">See
                                Full
                                Review</a>
                        <?php endif; ?>
                    </div>
                <?php } ?>
                <div class="tags-wrapper">
                    <h3 class="title">Tags</h3>
                    <ul class="tag-items">
                        <?php echo $get_tags; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- similar-cars start  -->
<?php echo Modules::run('posts/posts_frontview/getRelatedPost', $model_id, $id); ?>
<?php if (in_array($vehicle_type_id_int, [1, 3])) { ?>
    <?php echo Modules::run('posts/posts_frontview/getSamePriceRangeCar', $pricein == 'USD' ? 'priceindollar' : 'priceinnaira', $pricein == 'USD' ? $priceindollar : $priceinnaira, $id); ?>
    <?php echo Modules::run('posts/posts_frontview/getRelatedSearch', $model_id, $id); ?>
<?php } ?>


<!-- contact seller modal -->
<!-- Modal Structure -->
<div id="contactSeller" class="modal modal-wrapper">
    <span class="material-icons modal-close">close</span>
    <div class="contact_seller-modal">
        <h4>Contact Seller</h4>
        <p>Send a direct message to the seller on the platform</p>
        <form role="form" id="contactSellerForm">
            <input type="hidden" name="seller_id" value="<?php echo $user_id; ?>"/>
            <input type="hidden" name="post_id" value="<?php echo $id; ?>"/>
            <input type="hidden" name="listing_url" value="<?php echo $post_slug; ?>"/>
            <div id="ajax_respond2"></div>
            <div class="input-field">
                <input type="text" id="name" name="senderName" value="<?php echo getLoginUserData('name'); ?>"
                       placeholder="Your Name" required>
                <label class="active" for="name"><span>Name</span></label>
            </div>
            <div class="input-field">
                <input type="text" name="email" placeholder="Enter Email"
                       value="<?php echo getLoginUserData('user_mail'); ?>" required>
                <label class="active" for="email"><span>Email</span></label>
            </div>
            <div class="input-field">
                <input id="phone" name="phone" type="tel" placeholder="Phone Number" required>
            </div>
            <div class="input-field">
                <textarea name="message" class="materialize-textarea" id="InputMessage" rows="5" required
                          placeholder="message">I saw this ads for sale at <?php echo base_url('post/' . $post_slug); ?>. I have an offer for the deal and want to discuss with you further. Would you please contact me as soon as possible?</textarea>
                <label class="active" for="message"><span>Message</span></label>
            </div>

            <ul class="footer-modal">
                <li>
                    <button class="modal-close">Cancel</button>
                </li>
                <li>
                    <button type="submit" class="btnStyle" id="sendToSeller">Send</button>
                </li>
            </ul>
        </form>
    </div>
</div>


<div id="makeAnOffer" class="modal modal-wrapper small-modal-wrapper open">

</div>

<!-- chat box wrapper -->
<div class="seller-popup">
    <button>Chat with Seller</button>
</div>


<div class="pupup_chat_box-wrap">
    <div class="pupup_chat_box-header">
        <div class="image">
            <img src="<?= GlobalHelper::profile_pic($user_id) ?>" alt="<?= GlobalHelper::company_name($user_id) ?>">
            <span></span>
        </div>
        <span class="name"><?= GlobalHelper::company_name($user_id) ?></span>
        <span class="material-icons">
                keyboard_arrow_down
            </span>
    </div>
    <div class="chat_box-scrollbar scrollbar">
        <div class="pupup_chat_box-chat-wrap chat-body">

        </div>

    </div>
    <div id="chatForm" class="pupup_chat_box-input">
        <input name="chat_message" autocomplete="off"  id="chat_message" autocomplete="off" type="text" class="browser-default"
               placeholder="Type your message...">
        <button type="button" onclick="appendSenderMessage()" class="material-icons"> send</button>
    </div>
</div>

<script type="text/javascript" src="assets/new-theme/js/intlTelInput.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/slick.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php include_once dirname(APPPATH) . "/application/views/frontend/new/template/login_modal.php"; ?>

<script>
    var logged_user = parseInt('<?=getLoginUserData('user_id')?>');
    $(document).ready(function () {
        /*Contact Seller*/

        /*End Contact Seller*/
    });

    function get_quote(post_id, seller_id, post_slug) {

        // $('#getQuote').load('posts/Posts_frontview/getQuote/?post_id=' + post_id + '&seller_id=' + seller_id + '&slug=' + post_slug, function () {
        //     $('#makeAnOffer').modal('open');
        // });

    }

    $('#get_quote').on('click', function () {
        if (logged_user) {
            $('#makeAnOffer').load('posts/Posts_frontview/getQuote/?post_id=' + '<?=$id?>' + '&seller_id=' + '<?=$user_id?>' + '&slug=' + '<?=$post_slug?>');
            $('#makeAnOffer').modal('open');
        } else {
            tosetrMessage('error', 'Please Login to Make an Offer');
            $('#loginModal').modal('open')
        }
    })

    $(document).on('submit', '#get_quote', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var error = 0;

        var offer_message = $('[name=offer_message]').val();
        if (!offer_message) {
            $('[name=offer_message]').addClass('required');
            error = 1;
        } else {
            $('[name=offer_message]').removeClass('required');
        }

        if (!error) {
            jQuery.ajax({
                url: 'mail/send_offer',
                type: "POST",
                dataType: "json",
                data: formData,
                beforeSend: function () {
                    tosetrMessage('warning', 'Sending offer');
                },
                success: function (jsonRepond) {

                    if (jsonRepond.Status === 'OK') {
                        tosetrMessage('success', jsonRepond.Msg);
                        setTimeout(function () {
                            $('.modal').modal('close');
                        }, 2000);
                    } else {
                        tosetrMessage('error', jsonRepond.Msg);
                    }
                }
            });
        }

    })


    $('.seller-popup').on('click', function () {
        if (logged_user) {
            if (logged_user != <?=$user_id?>) {
                $(this).hide();
                $('.pupup_chat_box-wrap').addClass('active');
                getConnection()
                $('.chat_box-scrollbar').animate(
                    {
                        scrollTop: $(document).height() + '100px'
                    },
                    'slow');
            } else {
                tosetrMessage('error', 'You can not chat with you')
            }
        } else {
            tosetrMessage('error', 'Please Login to chat');
            $('#loginModal').modal('open')
        }
    })
    $('.pupup_chat_box-header').on('click', function () {
        $(this).parent().removeClass('active');
        $('.seller-popup').show()
    })


    $("#phone").intlTelInput({
        allowDropdown: true,
        autoHideDialCode: true,
        autoPlaceholder: "polite",
        customPlaceholder: true,
        dropdownContainer: null,
        formatOnDisplay: true,
        initialCountry: "us",
        nationalMode: true,
        onlyCountries: [],
        placeholderNumberType: "MOBILE",
        preferredCountries: ["us", "gb"],
        separateDialCode: true,
        utilsScript: ""
    });
    $("#contactSellerForm").validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules: {
            email: {
                required: true,
                email: true
            },
            name: 'required',
            phone: 'required',
            message: 'required'
        },
        messages: {
            email: {
                required: 'Email can not be empty',
                email: 'please provide a valid email address'
            },
            name: "Name can not be empty",
            phone: "Phone can not be empty",
            message: "Message can not be empty",
        },
        submitHandler :function (form, evernt) {
            evernt.preventDefault();
            jQuery.ajax({
                type: "POST",
                //url: "contact_seller",
                url: "mail/contact_seller",
                dataType: 'json',
                data: jQuery('#contactSellerForm').serialize(),
                beforeSend: function () {
                    tosetrMessage('warning', 'Sending');
                },
                success: function (jsonData) {
                    console.log(jsonData);
                    jQuery('#ajax_respond2').html(jsonData.Msg);
                    if (jsonData.Status === 'OK') {
                        tosetrMessage('success', 'Sent');
                        document.getElementById("contactSellerForm").reset();
                        setTimeout(function () {
                            jQuery('#ajax_respond2').slideUp();
                        }, 2500);
                        setTimeout(function () {
                            jQuery('#contact_seller').modal('toggle');
                        }, 3000);
                    } else {
                        tosetrMessage('error', jsonData.Msg);
                    }
                }
            });
        }
    });
    $('.make_an_offer-submit').hide();
    $('.enter-amount').hide();
    $('#makeOfferBtn').on('click', function () {
        if ($('.number').val() === "") {
            $('.enter-amount').text('amount can not be empty');
            $('.enter-amount').show();
        } else {
            $('.make_an_offer-submit').show();
            $('.make_an_offer-form').hide();
        }
    })

    $(document).on('click', '.like', function () {
        if (logged_user) {
            let text = parseInt($(this).find('.count-value').text());
            $(this).toggleClass('active');
            if ($(this).hasClass('active')) {
                $(this).find('.material-icons').text('favorite');
                $(this).find('.count-value').text(text + 1);
            } else {
                $(this).find('.material-icons').text('favorite_border');
                $(this).find('.count-value').text(text - 1);
            }
            jQuery.ajax({
                url: 'posts/posts_frontview/likeOrUnlike',
                type: "POST",
                dataType: "json",
                data: {
                    'user_id': logged_user,
                    'post_id': '<?=$id?>',
                },
                beforeSend: function () {
                },
                success: function (jsonRepond) {
                    tosetrMessage('success', jsonRepond.msg)
                }
            });

        } else {
            tosetrMessage('error', 'Please Login To Like');
            $('#loginModal').modal('open');
        }

    })

    $('.post-preview-slider-active').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.post-preview-thumb-slider'
    });
    $('.post-preview-thumb-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.post-preview-slider-active',
        dots: false,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }
        ]
    });
    var lastDate = '';
    var last_sender_message = '';
    var last_receiver_message = '';

    if (logged_user) {

        function getConnection() {

            $.ajax({
                url: 'admin/chat/get_user_chat',
                type: "GET",
                data: {id: <?=$user_id?>},
                beforeSend: function () {
                    $('.chat-body').html(`<div class="chat_processing">
                        <p>Processing...</p>
                    </div>`);
                },
                success: function (response) {
                    $('.chat-body').html("");

                    let jsonResponse = JSON.parse(response);

                    if (jsonResponse.data.chats != undefined && jsonResponse.data.chats != "") {
                        let chatHtml = "";
                        jsonResponse.data.chats.forEach(function (item) {
                            var is_date = chat_message_format(item);
                            if (is_date) {
                                chatHtml += `<p class="chat-devaidar"><span>${is_date}</span></p>`
                            }
                            lastDate = moment(moment.utc(item.timestamp).toDate()).format('MMM Do YY')
                            if (item.sender == logged_user) {
                                last_receiver_message = '';
                                var extented_class = last_sender_message === moment(moment.utc(item.timestamp).toDate()).format('llll') ? 'reduce-margin' : '';
                                chatHtml += '<div class="pupup_chat_box-chat pupup_chat_box-chat-right  ' + extented_class + '">' +
                                    '                <div class="content-chat">' +
                                    '                    <span>' + moment(moment.utc(item.timestamp).toDate()).format('LT') + '</span>' +
                                    '                    <p>' + item.message + '</p>' +
                                    '                </div>' +
                                    '            </div>';
                                last_sender_message = moment(moment.utc(item.timestamp).toDate()).format('llll')
                            } else {
                                last_sender_message = '';
                                var extented_class = last_receiver_message === moment(moment.utc(item.timestamp).toDate()).format('llll') ? 'reduce-margin' : '';
                                chatHtml += '<div class="pupup_chat_box-chat pupup_chat_box-chat-left ' + extented_class + '">' +
                                    '                <div class="content-chat">' +
                                    '                    <span>' + moment(moment.utc(item.timestamp).toDate()).format('LT') + '</span>' +
                                    '                    <p>' + item.message + '</p>' +
                                    '                </div>' +
                                    '            </div>';
                                last_receiver_message = moment(moment.utc(item.timestamp).toDate()).format('llll')
                            }
                        });

                        $('.chat-body').html(chatHtml);
                    } else {
                        $('.chat-body').html(`<div class="chat_processing">
                        <p>No Conversation Yet</p>
                    </div>`);
                    }

                    $('.scrollbar').animate(
                        {
                            scrollTop: $(document).height() + '100px'
                        },
                        'slow');
                }
            });
        }


        function appendSenderMessage() {
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ];
            let message = $("#chat_message").val();
            let date = new Date();
            let time = date.getDate() + " " + monthNames[date.getMonth()] + ", " + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes();
            if (message != "") {
                $.ajax({
                    url: 'admin/chat/send_chat_message',
                    type: "POST",
                    data: {message: message, receiver: <?=$user_id?>},
                    success: function (response) {
                    }
                });
                if (lastDate !== moment().format('MMM Do YY')) {
                    $('.chat-body').append(`<p class="chat-devaidar"><span>Today</span></p>`);
                    lastDate = moment().format('MMM Do YY')
                }

                last_receiver_message = '';
                var extented_class = last_sender_message === moment(time).format('llll') ? 'reduce-margin' : '';
                $('.chat_processing').html('');
                $('.chat-body').append('<div class="pupup_chat_box-chat pupup_chat_box-chat-right ' + extented_class + '">' +
                    '                <div class="content-chat">' +
                    '                    <span>' + moment(time).format('LT') + '</span>' +
                    '                    <p>' + message + '</p>' +
                    '                </div>' +
                    '            </div>');

                last_sender_message = moment(time).format('llll')

                $('.scrollbar').animate({scrollTop: $(document).height() + '100px'}, 'slow');
                $("#chat_message").val('')
            }
        }


    }

    $('#chat_message').on('keyup', function (event) {
        // Number 13 is the "Enter" key on the keyboard
        event.preventDefault();
        if (event.keyCode === 13) {
            // Cancel the default action, if needed

            // Trigger the button element with a click
            appendSenderMessage()
        }
    })

    $('.related_post_slider').slick({
        slidesToShow: 4,
        slidesToScroll: 4,
        dots: false,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                }
            },            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
</script>
