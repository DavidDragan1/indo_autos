<!-- breadcumb_search-area start  -->
<?php include_once dirname(APPPATH) . "/application/views/frontend/new/template/global_search.php"; ?>
<!-- breadcumb_search-area end  -->

<div class="post-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-12 mb-50">
                <?php echo Modules::run('posts/posts_frontview/getSlider', $id, 875,getShortContentAltTag($title,60)); ?>
            </div>
            <div class="col-lg-5 col-12 mb-50">
                <div class="post-details-info">
                    <div class="post-details-info-top">
                        <div class="post-details-info-top-left">
                            <ul class="product-info">
                                <li class="product-id">ID: #<?=$id?></li>
                                <li><span><?=$manufacture_year?> <?php echo @$to_year ? ' - '.$to_year :''?></span></li>
                                <li><span><?=$condition?></span></li>
                            </ul>
                            <h1><?=$title?>  <?=GlobalHelper::seller_badge($user_id)?></h1>
                        </div>
                        <div class="post-details-info-top-right">
                            <div>
                                    <span class="like <?= empty($is_liked) ? '' : 'active'?>">
                                        <span class="material-icons"> <?= empty($is_liked) ? 'favorite_border' : 'favorite'?></span>
                                        <span class="count-value"><?=GlobalHelper::get_post_like($id)?> </span> Likes
                                    </span>
                            </div>

                            <a class="compare-car" href="post/compare?first=<?=$post_slug?>&vehicle=<?=GlobalHelper::getVehicleSlugbyId($vehicle_type_id_int)?>">Compare Car</a>
                        </div>
                    </div>
                    <ul class="post-details-price">

                        <li>
                            <span>Price</span>
                            <h4><?php echo GlobalHelper::getPrice($priceinnaira, $priceindollar, $pricein) ?></h4>
                        </li>

                        <?php if (in_array($vehicle_type_id_int, [1,3])) {?>
                        <li>
                            <span>Mileage</span>
                            <h4><?=number_shorten($mileage,1)?> Miles</h4>
                        </li>
                        <?php } ?>
                    </ul>
                    <ul class="post-details-location">
                        <li><span class="material-icons">location_on</span> <?=$state_name?>, <?=getCountryName($country_id)?></li>
                        <li class="car-finance">
                            <a class="btnStyle btnStyleOutline" href="hire-verifier/search/<?=$post_slug?>">Verify this Car</a>
                        </li>
                    </ul>
                    <ul class="post-details-location">
                        <li><span>Product: </span><?=($tag_name) ? "<a href='products/$tag_slug'>$tag_name</a>" : ''?></li>
                        <li class=""><span>Location: </span> <?=getCountryName($country_id)?></li>
                    </ul>
                    <?php echo GlobalHelper::getSellerInfo($user_id, $title, $post_slug, $id); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <?php
                if (in_array($vehicle_type_id_int, [1,3])) {
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
                                <p><?=getVhecileDetails($body_type)?></p>
                            </div>
                        </li>
                        <?php if ($vehicle_type_id_int == 1) {?>
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
                        <?php if ($vehicle_type_id_int == 1) {?>
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
                    if (in_array($vehicle_type_id_int, [1,3])) {
                    ?>
                    <?php if ($vehicle_type_id_int == 1) {?>
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
                    <?=$description?>
                </div>
                <?php
                if (in_array($vehicle_type_id_int, [1,3])) {
                ?>
                <ul id="features" class="features-wrap">
                    <?php echo $get_features; ?>
                </ul>
                <div id="reviews" class="reviews-wrap">
                    <?php if (!empty($review)) :?>
                    <p><?=$review->overview?></p>
                    <a href="review/<?=$review->slug?>" class="btnStyle waves-effect btnStyleOutline mt-20">See Full
                        Review</a>
                    <?php endif; ?>
                </div>
                <?php } ?>
            </div>
            <div class="col-lg-5">
                <div class="details-pricing-wrap p-15">
                    <div class="bg-white shadow p-15 br-5">
                        <div class="before_review">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="fs-16 fw-500 color-theme mb-0">Shipping Summary</h4>
                                <span class="badge-wrap theme-badge review-button cursor-pointer">Review Price</span>
                            </div>
                            <ul class="shipping_summary-list">
                                <li class="">
                                    <span>Amount:</span>
                                    <span class="color-black">$<span class="all-amount total-amout-cout"><?=GlobalHelper::priceFormat($priceinnaira)?></span></span>
                                </li>
                                <?php
                                $total = $priceinnaira;
                                if (empty($other_cost->is_third_party)) :
                                    $total += $other_cost->ground_logistics_amount + $other_cost->shipping_amount + $other_cost->customs_amount + $other_cost->clearing_amount + $other_cost->vat_amount;
                                ?>
                                <li>
                                    <span class="fw-500">Ground Logistics::</span>
                                    <span class="color-black">$<span class="ground_logistics_amount total-amout-cout"><?=GlobalHelper::priceFormat($other_cost->ground_logistics_amount)?></span></span>
                                </li>
                                <li>
                                    <span class="fw-500">Shipping:</span>
                                    <span class="color-black">$<span class="shipping_amount total-amout-cout"><?=GlobalHelper::priceFormat($other_cost->shipping_amount)?></span></span>
                                </li>
                                <li>
                                    <span class="fw-500">Customs:</span>
                                    <span class="color-black">$<span class="customs_amount total-amout-cout"><?=GlobalHelper::priceFormat($other_cost->customs_amount)?></span></span>
                                </li>
                                <li>
                                    <span class="fw-500">Clearing:</span>
                                    <span class="color-black">$<span class="clearing_amount total-amout-cout"><?=GlobalHelper::priceFormat($other_cost->clearing_amount)?></span></span>
                                </li>

                                <li>
                                    <span>VAT (Value-Added-Tax):</span>
                                    <span class="color-black">$<span class="vat_amount total-amout-cout"><?=GlobalHelper::priceFormat($other_cost->vat_amount)?></span></span>
                                </li>
                                <?php endif; ?>
                                <li>
                                    <span class="fs-16 fw-500 color-black">Total:</span>
                                    <span class="color-theme fs-24 fw-700">$<span class="total-amout-sum"><?=GlobalHelper::priceFormat($total)?></span></span>
                                </li>
                            </ul>
                        </div>

                        <div class="after_review d-none">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="fs-16 fw-500 color-theme mb-0">Shipping Summary</h4>
                                <span class="badge-wrap theme-badge cursor-pointer done-button">Done</span>
                            </div>
                            <ul class="shipping_summary-list">
                                <li class="">
                                    <span>Amount:</span>
                                    <span class="color-black">$<span class="all-amount total-amout-cout"><?=GlobalHelper::priceFormat($priceinnaira)?></span></span>
                                </li>
                                <li>
                                    <label class="checkbox-style checkbox-style-small d-inline-flex">
                                        <input type="checkbox" value="ground_logistics_amount" class="filled-in checkedAll" />
                                        <span class="h-20">Ground Logistics:</span>
                                    </label>
                                    <span class="color-black">$<?=GlobalHelper::priceFormat($other_cost->ground_logistics_amount)?></span>
                                </li>
                                <li>
                                    <label class="checkbox-style checkbox-style-small d-inline-flex">
                                        <input type="checkbox" value="shipping_amount" class="filled-in checkedAll" />
                                        <span class="h-20">Shipping:</span>
                                    </label>
                                    <span class="color-black">$<?=GlobalHelper::priceFormat($other_cost->shipping_amount)?></span>
                                </li>
                                <li>
                                    <label class="checkbox-style checkbox-style-small d-inline-flex">
                                        <input type="checkbox" value="customs_amount" class="filled-in checkedAll" />
                                        <span class="h-20">Customs:</span>
                                    </label>
                                    <span class="color-black">$<?=GlobalHelper::priceFormat($other_cost->customs_amount)?></span>
                                </li>
                                <li>
                                    <label class="checkbox-style checkbox-style-small d-inline-flex">
                                        <input type="checkbox" value="clearing_amount" class="filled-in checkedAll" />
                                        <span class="h-20">Clearing:</span>
                                    </label>
                                    <span class="color-black">$<?=GlobalHelper::priceFormat($other_cost->clearing_amount)?></span>
                                </li>
                                <li>
                                    <label class="checkbox-style checkbox-style-small d-inline-flex">
                                        <input type="checkbox" value="vat_amount" class="filled-in checkedAll" />
                                        <span class="h-20">VAT (Value-Added-Tax):</span>
                                    </label>
                                    <span class="color-black">$<?=GlobalHelper::priceFormat($other_cost->vat_amount)?></span>
                                </li>
                                <li>
                                    <span class="fs-16 fw-500 color-black">Total:</span>
                                    <span class="color-theme fs-24 fw-700">$<span class="amount-all-count"><?=GlobalHelper::priceFormat($total)?></span></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <p class="fs-12 text-left mt-15">
                        * Shipping quotes and tariffs are relevant at the time of Posting and may be adjusted if
                        necessary by tariffs or shippers.
                    </p>
                </div>
                <p class="mt-15 color-black text-center">
                    Would you like to use a different shipping and/or clearing agent?
                </p>
                <div class="car_insurance_vailable-wrap br-5 mt-15 p-30">
                    <a href="hire-shipping-agent/search?post_slug=<?php echo $post_slug?>" class="btnStyle waves-effect w-100 mb-10">Hire Shipping Agent</a>
                    <a href="hire-clearing-agent/search?post_slug=<?php echo $post_slug?>" class="btnStyle waves-effect w-100">Hire Clearing and Forwarding Agent</a>
                </div>
            </div>up
        </div>
    </div>
</div>

<!-- similar-cars start  -->
<?php echo Modules::run('posts/posts_frontview/getRelatedPost', $model_id, $id); ?>
<?php  if (in_array($vehicle_type_id_int, [1,3])) { ?>
<?php echo Modules::run('posts/posts_frontview/getSamePriceRangeCar', $pricein == 'USD' ? 'priceindollar' : 'priceinnaira' ,$pricein == 'USD' ? $priceindollar : $priceinnaira, $id); ?>
<?php echo Modules::run('posts/posts_frontview/getRelatedSearch', $model_id, $id); ?>
<?php } ?>



<!-- contact seller modal -->
<!-- Modal Structure -->
<div id="contactSeller" class="modal modal-wrapper">
    <span class="material-icons modal-close">close</span>
    <div class="contact_seller-modal">
        <h4>Contact Seller</h4>
        <p>Send a direct message to the seller on the platform</p>
        <form role="form" id="ContactSellerForm">
            <input type="hidden" name="seller_id" value="<?php echo $user_id; ?>"/>
            <input type="hidden" name="post_id" value="<?php echo $id; ?>"/>
            <input type="hidden" name="listing_url" value="<?php echo $post_slug; ?>"/>
            <div id="ajax_respond2"></div>
            <div class="input-field">
                <input type="text" id="name" name="senderName" value="<?php echo getLoginUserData('name'); ?>" placeholder="Your Name">
                <label for="name"><span>Name</span></label>
            </div>
            <div class="input-field">
                <input type="text" id="InputEmail" name="email" placeholder="Enter Email" value="<?php echo getLoginUserData('user_mail'); ?>" required="">
                <label for="email"><span>Email</span></label>
            </div>
            <div class="input-field">
                <input id="phone" name="phone" type="tel" placeholder="Phone Number">
            </div>
            <div class="input-field">
                <textarea name="message" class="materialize-textarea" id="InputMessage" rows="5" required="" placeholder="message">I saw this ads for sale at <?php echo base_url('post/' . $post_slug); ?>. I have an offer for the deal and want to discuss with you further. Would you please contact me as soon as possible?</textarea>
                <label for="message"><span>Message</span></label>
            </div>

            <ul class="footer-modal">
                <li><button class="modal-close">Cancel</button></li>
                <li><button type="submit" class="btnStyle" id="sendToSeller">Send</button></li>
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
            <img src="<?=GlobalHelper::profile_pic($user_id)?>" alt="<?=GlobalHelper::company_name($user_id)?>">
<!--            <span class="online"></span>-->
        </div>
        <span class="name"><?=GlobalHelper::company_name($user_id)?></span>
        <span class="material-icons">
                keyboard_arrow_down
            </span>
    </div>
    <div class="chat_box-scrollbar scrollbar">
        <div class="pupup_chat_box-chat-wrap chat-body">
            <div class="pupup_chat_box-chat pupup_chat_box-chat-left">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>9:30 AM</span>
                </div>
            </div>
            <div class="pupup_chat_box-chat pupup_chat_box-chat-right">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, quam?</p>
                    <span>9:35 AM</span>
                </div>
            </div>
            <div class="pupup_chat_box-chat pupup_chat_box-chat-left">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>9:30 AM</span>
                </div>
            </div>
            <div class="pupup_chat_box-chat pupup_chat_box-chat-right">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, quam?</p>
                    <span>9:35 AM</span>
                </div>
            </div>
            <div class="pupup_chat_box-chat pupup_chat_box-chat-left">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>9:30 AM</span>
                </div>
            </div>
            <div class="pupup_chat_box-chat pupup_chat_box-chat-right">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, quam?</p>
                    <span>9:35 AM</span>
                </div>
            </div>
            <div class="pupup_chat_box-chat pupup_chat_box-chat-left">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>9:30 AM</span>
                </div>
            </div>
            <div class="pupup_chat_box-chat pupup_chat_box-chat-right">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, quam?</p>
                    <span>9:35 AM</span>
                </div>
            </div>
            <div class="pupup_chat_box-chat pupup_chat_box-chat-left">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>9:30 AM</span>
                </div>
            </div>
            <div class="pupup_chat_box-chat pupup_chat_box-chat-right">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, quam?</p>
                    <span>9:35 AM</span>
                </div>
            </div>
            <div class="pupup_chat_box-chat pupup_chat_box-chat-left">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>9:30 AM</span>
                </div>
            </div>
            <div class="pupup_chat_box-chat pupup_chat_box-chat-right">
                <div class="content-chat">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, quam?</p>
                    <span>9:35 AM</span>
                </div>
            </div>
        </div>

    </div>
    <div id="chatForm" class="pupup_chat_box-input">
        <input name="chat_message" autocomplete="off"  id="chat_message" type="text" class="browser-default"
               placeholder="Type your message...">
        <button type="button" onclick="appendSenderMessage()" class="material-icons"> send</button>
    </div>
</div>

<script type="text/javascript" src="assets/new-theme/js/intlTelInput.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.validate.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/slick.min.js?t=<?php echo time(); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php include_once dirname(APPPATH) . "/application/views/frontend/new/template/login_modal.php"; ?>

<script>
    var logged_user = parseInt('<?=getLoginUserData('user_id')?>');
    socket_receiver_online = <?=$user_id?>;
    jQuery(document).ready(function () {

    });
    function get_quote(post_id, seller_id, post_slug) {
        // jQuery('#getQuote').load('posts/Posts_frontview/getQuote/?post_id=' + post_id + '&seller_id=' + seller_id + '&slug=' + post_slug, function (){
        //     $('#makeAnOffer').modal('open');
        // });
    }
    $('#get_quote').on('click', function (){
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
        if (logged_user){
            $(this).hide();
            $('.pupup_chat_box-wrap').addClass('active');
            getConnection()
            $('.chat_box-scrollbar').animate(
                {
                    scrollTop: $(document).height() + '100px'
                },
                'slow');
        } else {
            tosetrMessage('error', 'Please Login to chat');
            $('#loginModal').modal('open');
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
        initialCountry: "ng",
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
        if (logged_user){
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
                    'user_id' : logged_user,
                    'post_id' : '<?=$id?>',
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
    if (logged_user){

        function getConnection()
        {

            // Join chatroom
            socket.emit('join', {  'project' : project, 'user_id' : logged_user, 'role_id' : "<?=getLoginUserData('role_id')?>" });

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
                            if (is_date){
                                chatHtml += `<p class="chat-devaidar"><span>${is_date}</span></p>`
                            }
                            lastDate = moment(moment.utc(item.timestamp).toDate()).format('MMM Do YY')
                            if (item.sender == logged_user) {
                                last_receiver_message = '';
                                var extented_class = last_sender_message === moment(moment.utc(item.timestamp).toDate()).format('llll') ? 'reduce-margin' : '';
                                chatHtml += '<div class="pupup_chat_box-chat pupup_chat_box-chat-right  '+ extented_class +'">'+
                                    '                <div class="content-chat">'+
                                    '                    <span>' + moment(moment.utc(item.timestamp).toDate()).format('LT') + '</span>'+
                                    '                    <p>' + item.message + '</p>'+
                                    '                </div>'+
                                    '            </div>';
                                last_sender_message = moment(moment.utc(item.timestamp).toDate()).format('llll')
                            } else {
                                last_sender_message = '';
                                var extented_class = last_receiver_message === moment(moment.utc(item.timestamp).toDate()).format('llll') ? 'reduce-margin' : '';
                                chatHtml += '<div class="pupup_chat_box-chat pupup_chat_box-chat-left '+ extented_class +'">'+
                                    '                <div class="content-chat">'+
                                    '                    <span>' + moment(moment.utc(item.timestamp).toDate()).format('LT') + '</span>'+
                                    '                    <p>' + item.message + '</p>'+
                                    '                </div>'+
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

            socket.on('receive_message', (jsonData) =>  {
                if (lastDate !== moment().format('MMM Do YY')){
                    $('.chat-body').append(`<p class="chat-devaidar"><span>Today</span></p>`);
                    lastDate = moment().format('MMM Do YY')
                }
                if (jsonData.message != undefined) {
                    $('.chat_processing').html('');
                    last_sender_message = '';
                    var extented_class = last_receiver_message === moment(moment.utc(jsonData.time).toDate()).format('llll') ? 'reduce-margin' : '';
                    $('.chat-body').append('<div class="pupup_chat_box-chat pupup_chat_box-chat-left '+ extented_class +'">'+
                        '                <div class="content-chat">'+
                        '                    <span>' + moment(moment.utc(jsonData.time).toDate()).format('LT') + '</span>'+
                        '                    <p>' + jsonData.message + '</p>'+
                        '                </div>'+
                        '            </div>')
                    $('.scrollbar').animate({ scrollTop: $(document).height() + '100px' }, 'slow');
                    last_receiver_message = moment(moment.utc(jsonData.time).toDate()).format('llll')
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
                if (lastDate !== moment().format('MMM Do YY')){
                    $('.chat-body').append(`<p class="chat-devaidar"><span>Today</span></p>`);
                    lastDate = moment().format('MMM Do YY')
                }

                last_receiver_message = '';
                var extented_class = last_sender_message === moment(time).format('llll') ? 'reduce-margin' : '';
                $('.chat_processing').html('');
                $('.chat-body').append('<div class="pupup_chat_box-chat pupup_chat_box-chat-right '+ extented_class +'">'+
                    '                <div class="content-chat">'+
                    '                    <span>' + moment(time).format('LT') + '</span>'+
                    '                    <p>' + message + '</p>'+
                    '                </div>'+
                    '            </div>');

                last_sender_message = moment(time).format('llll')

                $('.scrollbar').animate({ scrollTop: $(document).height() + '100px' }, 'slow');
                $("#chat_message").val('')
                socket.emit('send_message', {'project' : project, 'sender_id': logged_user, 'receiver_user_id' : <?=$user_id?> , 'message' : message, 'time' : time})
                //$.ajax({
                //    url: 'admin/chat/send_chat_message',
                //    type: "POST",
                //    data: {message: message, receiver: <?//=$user_id?>//},
                //    success: function (response) {
                //    }
                //});
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

    $('.review-button').on('click', function (event) {
        $('.before_review').addClass('d-none');
        $('.after_review').removeClass('d-none');
    })

    $('.done-button').on('click', function (event) {
        var total = parseInt($('.amount-all-count').text().replace(/\D/g, ""));
        var minus = 0;
        $('.shipping_summary-list li').removeClass('opacity-7')
        $(":checkbox:checked").each(function () {
            var class_name = $(this).val();
            minus += parseInt($('.'+class_name).text().replace(/\D/g, ""));
            $('.'+class_name).parent().parent().addClass('opacity-7');
        });
        $('.total-amout-sum').text(formatNumber(total-minus));
        $('.before_review').removeClass('d-none');
        $('.after_review').addClass('d-none')
    })

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

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
