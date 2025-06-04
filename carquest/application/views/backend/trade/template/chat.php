<!-- chat-area start  -->
<div class="row">
    <div class="col-xl-3 col-12">
        <div class="bg-white p-20 br-5 chat_list-wrap">
            <div class="chat_list-header">
                <span class="material-icons"> search</span>
                <input type="text" id="searchChat" class="browser-default" placeholder="Search Chats">
            </div>
            <div class="scrollbar-inner">
                <ul id="chat_list" class="chat_list-items">
                    <?php foreach ($chats as $chat) { ?>
                        <li class="chat_item" data-user_id="<?php echo $chat->otherUserId; ?>">
                            <div class="chat-img">
                                <img src="<?=!empty($chat->otherUserProfileImage) ? $chat->otherUserProfileImage : 'assets/theme/new/images/backend/avatar.png'?>" alt="user">
                            </div>
                            <div class="chat-content">
                                <h5><?=$chat->otherUserName?></h5>
                                <span><?=$chat->otherUserRoleName?></span>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-12">
        <div class="chat_default-box bg-white p-20 br-5 d-flex justify-content-center">
            <span class="material-icons"> chat</span>
            <p>Select a chat to continue conversation</p>
        </div>
        <div class="chat_box-wrap bg-white p-20 br-5 d-none">
            <div class="chatbox-header d-flex justify-content-between align-items-center">
                <div id="chatbox_header" class="chatbox_header-content">

                </div>
                <span class="delete material-icons" style="cursor: pointer">delete</span>
            </div>
            <div class="scrollbar-inner scrollbar">
                <div class="chat-items">

                </div>
            </div>
            <form id="chat_form" class="chat_input-box">
                <input name="chat_message" autocomplete="off"  id="chat_message" type="text" class="browser-default"
                       placeholder="Type your message...">

                <button class="material-icons"> send</button>
            </form>
        </div>
    </div>
</div>
<!-- chat-area end  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
$get_logged_company_info = get_logged_company_info();
$owner_img = GlobalHelper::profile_pic(getLoginUserData('user_id'));
?>
<script>
var owner_img = '<?=$owner_img?>'

let userId = "<?php echo getLoginUserData('user_id'); ?>";

    $(document).ready(function () {

        $('.delete').on('click', function (){
            if (confirm("Are You Sure To Delete")){
                const who_delete = "<?php echo getLoginUserData('user_id'); ?>";
                const whom_delete = $(".chat_item.active").data("user_id");


                $.ajax({
                    url: 'admin/chat/delete-chat-full',
                    type: "POST",
                    data: {who_delete, whom_delete},
                    beforeSend: function () {
                    },
                    success: function (response) {

                        response = JSON.parse(response)
                        if (response.Status == 'ERROR'){
                            tosetrMessage('error', response.Msg)
                        } else {
                            tosetrMessage('success', 'The Message Deleted')

                            $(".chat_item.active").hide();
                            $('.chat_item').removeClass('.active');

                            $('.chat_box-wrap').removeClass('d-block');
                            $('.chat_box-wrap').addClass('d-none');
                            $('.chat_default-box').removeClass('d-none');
                            $('.chat_default-box').addClass('d-flex');

                        }
                    }
                });
            }
        })

        $("#searchChat").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#chat_list li").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
    function nameSplit(str) {
        let names = str.split(' '),
            initials = names[0].substring(0, 1).toUpperCase();
        if (names.length > 1) {
            initials += names[names.length - 1].substring(0, 1).toUpperCase();
        }
        return initials;
    };

    $(document.body).on("click", ".chat_item", function () {
        $(".chat_item").removeClass("active");
        $(this).addClass("active");
        $('.chat_box-wrap').addClass('d-block');
        $('.chat_box-wrap').removeClass('d-none');
        $('.chat_default-box').addClass('d-none');
        $('.chat_default-box').removeClass('d-flex');
        let html = $(this).html();
        $('#chatbox_header').html(html);
        let name = $(this).find('.chat-content h5').text();
        $('.chat-item-right .avatar_name_chat').text(nameSplit(name));
        getConnection($(this).data('user_id'));
    });

    function givenText(input, time) {
        const html = "<div class=\"chat-item-right chat-item\">\n" +
            "                                    <div class=\"chat-item-content\">\n" +
            "                                        <p>" + input.value + "</p>\n" +
            "                                        <span>" + time + "</span>\n" +
            "                                    </div>\n" +
            "                                    <img class=\"avatar_image_chat\" src=\"assets/new-theme/images/logos/logo1.png\" alt=\"\">\n" +
            "                                </div>";
        if (input.value !== '') {
            $('.chat-items').append(html);
            $('.scrollbar').animate({ scrollTop: $(document).height() + '100px' }, 'slow');
        }
    }

    $("#chat_form").submit(function (e) {
        e.preventDefault();
        appendSenderMessage()
        return false;
    });





var lastDate = '';
var last_sender_message = '';
var last_receiver_message = '';

    function getConnection(otherUser)
    {
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

                        var is_date = chat_message_format(item);
                        if (is_date){
                            chatHtml += `<p class="chat-devaidar"><span>${is_date}</span></p>`
                        }
                        lastDate = moment(moment.utc(item.timestamp).toDate()).format('MMM Do YY')

                        if (item.sender == userId) {
                            last_receiver_message = '';
                            var extented_class = last_sender_message === moment(moment.utc(item.timestamp).toDate()).format('llll') ? 'reduce-margin' : '';

                            chatHtml += "<div class=\"chat-item-right chat-item "+extented_class+"\">\n" +
                                "                                    <div class=\"chat-item-content\">\n" +
                                "                                        <span>" + moment(moment.utc(item.timestamp).toDate()).format('LT') + "</span>\n" +
                                "                                        <p>" + item.message + "</p>\n" +
                                "                                    </div>\n" +
                                "                                    <img class=\"avatar_image_chat\" src=\""+owner_img+"\" alt=\"\">\n" +
                                "                                </div>";
                            last_sender_message = moment(moment.utc(item.timestamp).toDate()).format('llll')
                        } else {
                            last_sender_message = '';
                            var extented_class = last_receiver_message === moment(moment.utc(item.timestamp).toDate()).format('llll') ? 'reduce-margin' : '';
                            chatHtml += "<div class=\"chat-item-left chat-item "+extented_class+"\">\n" +
                                "                                    <img class=\"avatar_image_chat\" src=\""+$('.chat_item.active div.chat-img img').attr('src')+"\" alt=\"\">\n" +
                                "                                    <div class=\"chat-item-content\">\n" +
                                "                                        <span>" + moment(moment.utc(item.timestamp).toDate()).format('LT') + "</span>\n" +
                                "                                        <p>" + item.message + "</p>\n" +
                                "                                    </div>\n" +
                                "                                </div>";
                            last_receiver_message = moment(moment.utc(item.timestamp).toDate()).format('llll')
                        }
                    });

                    $('.chat-items').html(chatHtml);
                } else {
                    $('.chat-items').html(`<div class="chat_processing">
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
        if (lastDate !== moment().format('MMM Do YY')){
            $('.chat-body').append(`<p class="chat-devaidar"><span>Today</span></p>`);
            lastDate = moment().format('MMM Do YY')
        }

        last_receiver_message = '';
        var extented_class = last_sender_message === moment(time).format('llll') ? 'reduce-margin' : '';
        $('.chat_processing').html('');
        $('.chat-items').append("<div class=\"chat-item-right chat-item "+ extented_class +"\">\n" +
            "                                    <div class=\"chat-item-content\">\n" +
            "                                        <span>" + moment(time).format('LT') + "</span>\n" +
            "                                        <p>" + message + "</p>\n" +
            "                                    </div>\n" +
            "                                    <img class=\"avatar_image_chat\" src=\""+owner_img+"\" alt=\"\">\n" +
            "                                </div>");

        last_sender_message = moment(time).format('llll')

        $('.scrollbar').animate({ scrollTop: $(document).height() + '100px' }, 'slow');
        document.getElementById("chat_form").reset();
    }
    let receiver = $(".chat_item.active").data("user_id");
    $.ajax({
        url: 'admin/chat/send_chat_message',
        type: "POST",
        data: {message: message, receiver: receiver},
        success: function (response) {
        }
    });
}
</script>
