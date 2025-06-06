<link rel="stylesheet" href="assets/new-theme/css/rating.min.css">
<script type="text/javascript" src="assets/new-theme/js/rating.min.js"></script>

<!-- breadcumb_search-area start  -->
<?php include_once dirname(APPPATH) . "/application/views/frontend/new/template/global_search.php"; ?>
<!-- breadcumb_search-area end  -->

<!-- .company-details-area start  -->
<div class="company-details-area pb-75">
    <div class="container">
        <div class="company-details-info">
            <div class="seller-details-wrap">
                <div class="seller-details-info">
                    <?php if ($user['role_id'] != 5) : ?>
                        <?php echo GlobalHelper::getProfilePhoto($user['profile_photo'], $seller['post_title'], 'seller-logo'); ?>
                    <?php else : ?>
                        <?php echo GlobalHelper::getPrivateProfilePhoto($user['user_profile_image'], 'Image', $user['oauth_provider'], 'seller-logo'); ?>
                    <?php endif; ?>
                    <h1><?= GlobalHelper::company_name($user['id']) . ' ' . GlobalHelper::seller_badge($user['id'])?> </h1>
                </div>
                <ul class="seller-contact">
                    <li><span class="material-icons">location_on</span> <?= GlobalHelper::address($user['id']) ?></li>
                    <?php $contact = GlobalHelper::contact_no($user['id']) ?>
                    <li><a href="tel:<?= $contact ?>"><span class="material-icons"> call</span>
                            <?= $contact ?></a></li>
                    <li><a href="https://wa.me/<?php echo GlobalHelper::wahtsAppNo($user['id']) ?>"><i
                                    class="fa fa-whatsapp"></i> WhatsApp Message</a></li>
                </ul>
            </div>
            <div class="about-company">
                <h5 class="fs-16 fw-500 color-seconday">About Us</h5>
                <p><?php echo $seller['content']; ?></p>
            </div>
        </div>
        <ul class="post_info-tabs tabs">
            <li class="tab">
                <a class="active waves-effect" href="#cars">Cars (<?= count($cars) ?>)</a>
            </li>
            <li class="tab">
                <a class="waves-effect" href="#motorbikes">Motorbikes (<?= count($bikes) ?>)</a>
            </li>
            <li class="tab">
                <a class="waves-effect" href="#spare_parts">Spare (<?= count($parts) ?>)</a>
            </li>
            <li class="tab">
                <a class="waves-effect" href="#reviews">Reviews (<?= count($reviews) ?>)</a>
            </li>
        </ul>
        <div id="cars">
            <div class="row">
                <?php foreach ($cars as $k => $post) { ?>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="carPost-wrap">
                            <a class="carPost-img" href="post/<?= $post->post_slug ?>">
                                <?= GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, 'grayscale lazyload post-img', getShortContentAltTag(($post->title), 60)) ?>
                                <?php
                                if ($post->is_financing) {
                                    echo "<span class=\"badge\">
                                        <span class=\"material-icons\">verified_user</span>
                                        Financing
                                    </span>";
                                }
                                ?>
                            </a>
                            <div class="carPost-content">
                                <span class="level"><?= $post->condition ?></span>
                                <h4>
                                    <a href="post/<?= $post->post_slug ?>"><?= getShortContent(($post->title), 20) ?></a>
                                    <?php if ($post->is_verified == 'Verified seller') { ?>
                                        <img src="assets/new-theme/images/icons/verify-new.svg" title="Verified" alt="">
                                    <?php } ?>
                                </h4>
                                <ul class="post-price">
                                    <li class="price"><?= GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) ?></li>
                                    <?php
                                    if ($post->vehicle_type_id == 1) {
                                        echo "<li class=\"km\">" . number_shorten($post->mileage) . " Miles</li>";
                                    }
                                    ?>
                                </ul>
                                <span class="location"><?= $post->location ?>, <?= $post->state_name ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div id="motorbikes">
            <div class="row">
                <?php foreach ($bikes as $k => $post) { ?>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="carPost-wrap">
                            <a class="carPost-img" href="post/<?= $post->post_slug ?>">
                                <?= GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, 'grayscale lazyload post-img', getShortContentAltTag(($post->title), 60)) ?>
                                <?php
                                if ($post->is_financing) {
                                    echo "<span class=\"badge\">
                                        <span class=\"material-icons\">verified_user</span>
                                        Financing
                                    </span>";
                                }
                                ?>
                            </a>
                            <div class="carPost-content">
                                <span class="level"><?= $post->condition ?></span>
                                <h4>
                                    <a href="post/<?= $post->post_slug ?>"><?= getShortContent(($post->title), 20) ?></a>
                                </h4>
                                <ul class="post-price">
                                    <li class="price"><?= GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) ?></li>
                                    <?php
                                    if ($post->vehicle_type_id == 1) {
                                        echo "<li class=\"km\">" . number_shorten($post->mileage) . " Miles</li>";
                                    }
                                    ?>
                                </ul>
                                <span class="location"><?= $post->location ?>, <?= $post->state_name ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div id="spare_parts">
            <div class="row">
                <?php foreach ($parts as $k => $post) { ?>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="carPost-wrap">
                            <a class="carPost-img" href="post/<?= $post->post_slug ?>">
                                <?= GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, 'grayscale lazyload post-img', getShortContentAltTag(($post->title), 60)) ?>
                                <?php
                                if ($post->is_financing) {
                                    echo "<span class=\"badge\">
                                        <span class=\"material-icons\">verified_user</span>
                                        Financing
                                    </span>";
                                }
                                ?>
                            </a>
                            <div class="carPost-content">
                                <span class="level"><?= $post->condition ?></span>
                                <h4>
                                    <a href="post/<?= $post->post_slug ?>"><?= getShortContent(($post->title), 20) ?></a>
                                </h4>
                                <ul class="post-price">
                                    <li class="price"><?= GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) ?></li>
                                    <?php
                                    if ($post->vehicle_type_id == 1) {
                                        echo "<li class=\"km\">" . number_shorten($post->mileage) . " Miles</li>";
                                    }
                                    ?>
                                </ul>
                                <span class="location"><?= $post->location ?>, <?= $post->state_name ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div id="reviews" class="rating_lists">
            <?php foreach ($reviews as $review) { ?>
                <div class="rating-item">
                    <span class="rating_info" id="rating_<?= $review->id ?>"></span>
                    <p><?= $review->review ?></p>
                    <h5 class="fs-16 fw-400 mb-0">
                        <a href="javascript:void(0)"><?= empty($review->user_name) ? 'Unknown' : $review->user_name ?> <?= !empty($review->city) ? ', ' . $review->city : '' ?></a>
                    </h5>
                    <?php if (!empty($review->child_review)) { ?>
                        <div class="ml-20">
                            <?= $review->child_review ?>
                        </div>
                    <?php } ?>
                </div>
                <script>
                    $("#rating_" + '<?=$review->id?>').rateYo({
                        ratedFill: "#FFC20D",
                        readOnly: true,
                        rating: parseFloat('<?=$review->rate?>'),
                        spacing: "5px",
                        starWidth: "15px",
                        normalFill: "#DBDBDB"
                    });
                </script>
            <?php } ?>
            <?php if ($write_review_permission != 'no') { ?>
                <div class="post-review">
                    <h5 class="fw-500 fs-16 color-theme mb-20">Write a Review for this Seller</h5>
                    <form id="review-submit" method="post" action="add-review">
                        <div class="input-field">
                            <textarea class="browser-default" id="review_message" name="review"
                                      placeholder="Type here"></textarea>
                        </div>
                        <input type="hidden" name="vendor_id" value="<?php echo $user['id']; ?>"/>
                        <input type="hidden" name="rate" id="rate" value="" required/>
                        <input type="hidden" name="url" value="<?php if ($this->uri->segment(2) == null) {
                            echo $this->uri->segment(1);
                        } else {
                            echo $this->uri->segment(1) . "/" . $this->uri->segment(2);
                        } ?>"/>
                        <div class="rating-input">
                            <span class="rating_input"></span>
                            <span class="rate-seller">Rate Seller</span>
                            <span class="rate-seller" style="color: red" id="review-msg"></span>
                        </div>
                        <div class="text-right">
                            <button <?= $write_review_permission == 'ask' ? "type='button' onClick='openQuestion()'" : ($write_review_permission == 'yes' ? "type='submit'" : "type='button'") ?>
                                    id="submit-button"
                                    class="waves-effect btnStyle <?= $write_review_permission == 'login' ? "login-required" : "review-submit" ?>">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- .company-details-area end  -->


<div id="checkEligibilityModal" class="modal modal-wrapper">
    <span class="material-icons modal-close">close</span>
    <div class="eligibility-modal-wrap">
        <h2 class="fw-500 fs-20 mb-30 text-center modal-title">Ans The Question</h2>
        <div id="eligibility_modal_data">
            <form class="eligibility-wrap">
                <div id="checkEligibilityData">
                    <div class="eligibility-wrap">
                        <h5>Which medium did you use to communicate with this seller?</h5>
                        <select class="browser-default" id="ans">
                            <option value="0">No Medium</option>
                            <option value="1">whatsup</option>
                            <option value="2">Direct Call</option>
                        </select>
                    </div>


                </div>
                <ul class="eligibility-modal-btn">
                    <li>
                        <button type="button" class="submit-btn submitBtn nextQuestion waves-effect">Submit</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>
<?php include_once dirname(APPPATH) . "/application/views/frontend/new/template/login_modal.php"; ?>
<script type="text/javascript">


    $(document).on('click', '.login-required', function () {
        // var loginMode = $(this).attr('login-mode');

        createCookie('review', JSON.stringify({
            'message': $('#review_message').val(),
            'redirect': window.location.href,
            'rate': $('#rate').val(),
            'table': 'reviews'
        }), 2);

        // if (loginMode == 'web') {
        //     $('#loginBoxModal').modal('show');
        // } else if (loginMode == 'facebook') {
        //     window.location.href = facebook_auth_url
        // } else if (loginMode == 'google') {
        //     window.location.href = google_auth_url
        // } else if (loginMode == 'twitter') {
        //     window.location.href = twitter_auth_url
        // }

    })
    $('#review-submit').on('click', function () {
        document.cookie = 'review=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    });


    $(document).ready(function () {
        var cookie_review = JSON.parse(readCookie('review'));
        var rate = 0;
        if (cookie_review) {
            $('#review_message').val(cookie_review.message);
            $('#rate').val(cookie_review.rate);
            rate = cookie_review.rate;
        }

        $('.rating_input').rateYo({
            ratedFill: "#FFC20D",
            spacing: "5px",
            starWidth: "25px",
            normalFill: "#DBDBDB",
            rating: rate,
            onSet: function (rating, rateYoInstance) {
                $('#rate').val(rating);
            }
        });

    })

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function createCookie(name, value, hours) {
        if (hours) {
            var date = new Date();
            date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        } else var expires = "";
        document.cookie = name + "=" + value + expires + "; path=/;";
    }


    function openQuestion() {
        $('#checkEligibilityModal').modal('open')
    }

    $(document).on('click', '.submitBtn', function () {
        var ans = parseInt($('#ans').val());
        if (ans) {
            $('#review-submit').submit();
        } else {
            $('#submit-button').attr('disabled', 'disabled');
            $('#review-msg').text('You are not Eligible To add Review');
            $('#checkEligibilityModal').modal('close');
        }
    })
</script>
