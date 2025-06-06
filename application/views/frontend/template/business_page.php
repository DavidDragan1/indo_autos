<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.css">-->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/dot-luv/jquery-ui.css" />
<link rel="stylesheet" href="assets_chat/css/chat.css">
<script src="assets_chat/css/date.js" type="text/javascript"></script>
<style>
    .rating {
        border: none;
        float: left;
    }
    .rating > input { display: none; }
    .rating > label:before {
        margin: 5px;
        font-size: 1.25em;
        font-family: FontAwesome;
        display: inline-block;
        content: "\f005";
    }
    .rating > .half:before {
        content: "\f089";
        position: absolute;
    }
    .rating > label {
        color: #ddd;
        float: right;
    }
    .rating > input:checked ~ label,
    .rating:not(:checked) > label:hover,
    .rating:not(:checked) > label:hover ~ label { color: #f05c26;  }

    .rating {
        border: none;
        float: left;
    }
    .rating-box {
        margin-bottom: 8px;
    }
    .our-events-advert .rating {
        padding-left: 15px;
    }
    .rating  {
        color: #f05c26;
    }
    .rating i {
        font-size: 16px;
    }
    .rating .fa , .profile-image .fa, .listing_rating .fa {
        margin: 0 5px;
    }

    .tostfyMessage {
        position: fixed;
        right: 5px;
        opacity: 0;
        visibility: hidden;
        -webkit-box-shadow: 0 2px 7px 0 rgba(0, 0, 0, 0.2);
        box-shadow: 0 2px 7px 0 rgba(0, 0, 0, 0.2);
        top: -100%;
        min-width: 280px;
        min-height: 50px;
        z-index: 9999;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        padding: 5px 20px;
        color: #fff;
        text-transform: capitalize;
        border-radius: 2px;
        -webkit-transition: all .4s ease-in-out 0s;
        transition: all .4s ease-in-out 0s;
    }

    .tostfyMessage .tostfyClose {
        position: absolute;
        right: 5px;
        top: 0px;
        font-size: 20px;
        cursor: pointer;
    }

    .write h5 {
        text-transform: capitalize;
        font-size: 18px;
        font-style: italic;
        color: #f5941e;
        -webkit-transition: all 0.4s ease-in-out 0s;
        transition: all 0.4s ease-in-out 0s;
        margin-bottom: 30px;
    }
</style>
<?php if($this->session->flashdata('status')):
    if ($this->session->flashdata('status') == 'success') :?>
        <div class="tostfyMessage bg-success" style="top: 5px; visibility: visible; opacity: 1">
            <span class="tostfyClose">&times;</span>
            <div class="messageValue" id="session_msg">
                <?php echo $this->session->flashdata('message'); ?>
            </div>
        </div>
    <?php else : ?>
        <div class="tostfyMessage bg-danger" style="top: 5px; visibility: visible; opacity: 1">
            <span class="tostfyClose">&times;</span>
            <div class="messageValue" id="session_msg">
                <?php echo $this->session->flashdata('message'); ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- visit-seller-area start  -->
<div class="visit-seller-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="seller-title">The Seller</h2>
            </div>
            <div class="col-lg-3">
                <div class="seller-author-wrap">
                    <div class="seller-author-img">
                        <?php if ($user['role_id'] != 5) : ?>
                        <?php echo GlobalHelper::getProfilePhoto($user['profile_photo']); ?>
                        <?php else : ?>
                            <?php echo GlobalHelper::getPrivateProfilePhoto($user['user_profile_image'],'Image', $user['oauth_provider']); ?>
                        <?php endif; ?>
                        <span class="user-badge">
                            <?php $status = GlobalHelper::getSellerTagsNew($seller['user_id']);
                            if ($status == 1) : ?>
                                <img src="assets/theme/new/images/active.png" alt="image">
                            <?php else : ?>
                                <img src="assets/theme/new/images/warning.png" alt="image">
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php if ($user['role_id'] != 5) : ?>
                    <?php echo GlobalHelper::getCompanyInfo( $user, $meta, $seller );?>
                    <?php else : ?>
                    <h4><?php echo $user['first_name']." ".$user['last_name']; ?></h4>
                    <ul>
                        <li class="seller_user_id"><span>Contact Number</span><br><?php echo $user['contact']; ?></li>
                    </ul>
                    <?php endif; ?>
                </div>
                <div class="review-rating">
                    <h4>REVIEWS</h4>
                    <h2><?php echo reviewsAvgCountByUserId($user['id']); ?></h2>
                    <span onclick="smoothScroll(document.getElementById('review_items'))" class="total_review"><?php echo reviewsCountByUserId($user['id']); ?> total</span>
                </div>
                <button class="chat btnPreview mb-5 mt-5">
                    <i class="fa fa-commenting-o"></i>
                    Chat
                </button>

                <?php if ($user['role_id'] != 5) : ?>
                <div class="business-houre">
                    <h3>Business Hour</h3>
                    <?php echo getBusinessHours(@$meta['business_hours']); ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-9 col-12">
                <?php if ($user['role_id'] != 5) : ?>
                <div class="banner-wrap">
                    <?php echo GlobalHelper::getrCoverPhoto($seller['thumb']); ?>
                </div>
                <?php endif; ?>
                <div class="who-we-are-wrap">
                    <h4>WHO WE ARE</h4>
                    <p>
                        <?php echo $seller['content'];?>
                    </p>
                </div>

                <?php if ($user['role_id'] != 5) : ?>
                <div class="video-review-wrapper">
                    <h3>Videos</h3>
                    <div class="row">
                    <?php foreach ($videos as $vid) : ?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="video-review-item">
                                <a class="video-popup" href="https://www.youtube.com/watch?v=<?php echo $vid->photo ?>">
                                    <img src="https://img.youtube.com/vi/<?php echo $vid->photo ?>/1.jpg">
                                    <i class="fa fa-play"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php $user_id = getLoginUserData('user_id');
                if ($user_id != null && $user_id != $user['id']) :?>
                <div class="write-review-wrap">
                    <h5>Write a review</h5>
                    <form class="review-form" method="post" action="add-review" style="display: none;">
                        <div class="row">
                            <div class="col-md-8 col-12">
                                <textarea placeholder="type your message" name="review"></textarea>
                                <button class="default-btn">Post</button>
                            </div>
                            <input type="hidden" name="vendor_id" value="<?php echo $user['id']; ?>" />
                            <input type="hidden" name="url" value="<?php if ($this->uri->segment(2) == null) {
                                echo $this->uri->segment(1);
                            } else {
                                echo $this->uri->segment(1)."/".$this->uri->segment(2);
                            } ?>" />
                            <div class="col-md-4 col-12">
                                <h4>Rate this Trade Seller</h4>
                                <fieldset class="rating">
                                    <input type="radio" id="star5" name="rate" value="5.00" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                    <input type="radio" id="star4half" name="rate" value="4.50" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                    <input type="radio" id="star4" name="rate" value="4.00" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                    <input type="radio" id="star3half" name="rate" value="3.50" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                    <input type="radio" id="star3" name="rate" value="3.00" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                    <input type="radio" id="star2half" name="rate" value="2.50" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                    <input type="radio" id="star2" name="rate" value="2.00" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                    <input type="radio" id="star1half" name="rate" value="1.50" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                    <input type="radio" id="star1" name="rate" value="1.00" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                    <input type="radio" id="starhalf" name="rate" value=".50" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="seller-wrapper">
                            <h2>Cars From This Seller</h2>
                            <?php echo Modules::run('posts/posts_frontview/getFromTradeSeller', $seller['user_id'] ); ?>
                        </div>
                    </div>
                    <div  id="review_items" class="col-lg-4 col-12">
                        <div class="reviews-wrapper">
                            <div class="reviews-header">
                                <h4>Reviews</h4>
                                <select onchange="sortReview(this.value)">
                                    <option selected disabled>Sort by</option>
                                    <option value="recent">Recent</option>
                                    <option value="old">Old</option>
                                    <option value="height">Height Rating</option>
                                    <option value="lowest">Lowest Rating</option>
                                </select>
                            </div>
                            <ul class="seller-review-items" id="sortReview">
                            <?php echo $getReviewsByUserId = Modules::run('reviews/reviews_frontview/getReviewsByUserId', $user['id']);?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- visit-seller-area end  -->


<div aria-hidden="true" data-backdrop="static" class="modal fade chatModalViewWrap" id="chatModalView"
     tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button aria-label="Close" class="close modalClose" data-dismiss="modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="chatBox_wrap_saller">
                <div class="chatbox-header">
                    <h3>John Du</h3>
                </div>
                <div class="scrollbar-inner" id="your_div">
                    <div class="chat-items">
                        <div class="chat-item-left chat-item">
                            <div class="chat-item-img">
                                <img src="assets/images/chat/img3.png" alt="image">
                            </div>
                            <div class="chat-item-content">
                                <span>Mical Black, 10:30PM, London.</span>
                                <p>Lorem ipsum dolor sit amet</p>
                            </div>
                        </div>
                        <div class="chat-item-right chat-item">
                            <div class="chat-item-content">
                                <span>10:45PM</span>
                                <p>Lorem ipsum dolor sit amet</p>
                            </div>
                        </div>
                        <div class="chat-item-left chat-item">
                            <div class="chat-item-img">
                                <img src="assets/images/chat/img3.png" alt="image">
                            </div>
                            <div class="chat-item-content">
                                <span>Mical Black, 10:30PM, London.</span>
                                <p>Lorem ipsum dolor sit amet</p>
                            </div>
                        </div>
                        <div class="chat-item-right chat-item">
                            <div class="chat-item-content">
                                <span>10:45PM</span>
                                <p>Lorem ipsum dolor sit amet</p>
                            </div>
                        </div>
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
                <h4><a href="my-account?goto=<?php echo $this->uri->segment(1) ?>">Login</a> or <a href="sign-up">Sign Up</a></h4>
            </div>
        </div>
    </div>
</div>

<script src="assets/theme/new/js/jquery.rateyo.js"></script>
<script>
    $(document).ready(function(){
        let sallerName = $('.seller-author-wrap h4').text();
        $('.chatbox-header h3').text(sallerName)
    })
    if($('body').innerWidth() < 991){
        window.smoothScroll = function(target) {
        var scrollContainer = target;
        do { //find scroll container
            scrollContainer = scrollContainer.parentNode;
            if (!scrollContainer) return;
            scrollContainer.scrollTop += 1;
        } while (scrollContainer.scrollTop == 0);
        
        var targetY = 0;
        do { //find the top of target relatively to the container
            if (target == scrollContainer) break;
            targetY += target.offsetTop;
        } while (target = target.offsetParent);
        
        scroll = function(c, a, b, i) {
            i++; if (i > 30) return;
            c.scrollTop = a + (b - a) / 30 * i;
            setTimeout(function(){ scroll(c, a, b, i); }, 20);
        }
        // start scrolling
        scroll(scrollContainer, scrollContainer.scrollTop, targetY, 0);
    }

}
</script>
<script>

    $(document).on('click', '.chat', function () {
        $("#contact_seller").modal("hide");
        let userId = "<?php echo getLoginUserData('user_id'); ?>";
        if (userId == null || userId == "") {
            $('#loginModalView').modal();
        } else {
            $('#chatModalView').modal();
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

                            chatHtml += "<div class=\"chat-item-left chat-item\">\n" +
                                "                                        <div class=\"chat-item-avatar\">\n" +
                                "                                            <div class=\"chat-item-img\">\n" +
                                "                                                <img src=\"assets/theme/new/images/backend/avatar.png\" alt=\"\">\n" +
                                "                                            </div>\n" +
                                "                                            <div class=\"chat-item-content\">\n" +
                                "                                                <span><span>" + item.otherUserName + "</span>" + item.timestamp + "</span>\n" +
                                "                                        <p>" + item.message + "</p>\n" +
                                "                                            </div>\n" +
                                "                                        </div>\n" +

                                "                                    </div>";
                        }
                    });

                    $('.chat-items').html(chatHtml);
                    $('#your_div').animate({
                        scrollTop: $('#your_div')[0].scrollHeight
                    }, 500);
                } else {
                    $('.chat-items').html(`<div class="chat_processing">
                        <p>No Conversation Yet</p>
                    </div>`);
                }
            }
        });
    }

    $('#chatModalView').on('hidden.bs.modal', function () {
        let userId = "<?php echo getLoginUserData('user_id'); ?>";
        let channelName = "chat-" + userId + "-" + $(".seller_user_id").data('seller_user_id');
    });
</script>
<script>
    <?php echo load_new_module_asset('insurance', 'admin/js/script.js'); ?>
    setTimeout(function () {
        $('.tostfyMessage').css({ "top": "-100%", "visibility": "hidden", "opacity": 0 })
    }, 10000);
    $('.tostfyClose').on('click', function () {
        $('.tostfyMessage').css({ "top": "-100%", "visibility": "hidden", "opacity": 0 })
    })

    function sortReview(value) {
        var user_id = "<?php echo $user['id']; ?>";
        jQuery.ajax({
            url: 'sort-review',
            type: "POST",
            dataType: 'text',
            data: {
                user_id: user_id,
                sort: value
            },
            success: function (response) {
                jQuery('#sortReview').html(response);
            }
        });
    }
</script>
