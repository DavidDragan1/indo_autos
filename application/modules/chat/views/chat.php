<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('chat', 'css'); ?>

<h2 class="breadcumbTitle">Chat</h2>


<!-- chat-area start  -->
<div class="chat-area">
    <div class="row">
        <div class="col-xl-3 col-md-4 col-12">
            <div class="chat-list-wrap">
                <div class="chat-list-header">
                    <h3>Chats</h3>
                    <input id="chatInputBox" onkeyup="searchChat()" type="text" placeholder="search chats">
                </div>
                <div class="scrollbar-inner">
                    <ul id="chatItems" class="chat-list-items">
                        <?php foreach ($chats as $chat) { ?>
                            <li class="chat-item" data-user_id="<?php echo $chat->otherUserId; ?>">
                                <div class="chat-img">
                                    <img src="assets/theme/new/images/backend/avatar.png" alt="image">
                                </div>
                                <div class="chat-content">
                                    <p id="userName"><?php echo $chat->otherUserName;?></p>
                                    <span><?php echo $chat->message;?></span>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-md-8 col-12 responsiveChatBox">
            <div class="chat-default-box">
                <img src="assets/theme/new/images/backend/icons/chat.svg">
                <p>Select a chat to continue conversation</p>
            </div>
            <div class="chat-box-wrap" style="display: none;">
                <div class="chatbox-header">
                    <span class="chatTrigger">
                        <i class="fa fa-angle-double-left"></i>
                    </span>
                    <span class="images">
                        <img src="assets/theme/new/images/backend/avatar.png" alt="image">
                    </span>
                    <div class="chatbox-header-content">
                        <h3 id="user_name"></h3>
                    </div>
                </div>
                <div class="scrollbar-inner" id="your_div">
                    <div class="chat-items">
                    </div>
                </div>
                <div class="chat-input">
                    <div class="chat-input-wrap">
                        <input id="message" type="text" placeholder="Type your message...">
                        <button id="send-message" type="button"><i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- chat-area end  -->
<?php load_module_asset('chat', 'js'); ?>
<script>

    function searchChat() {
        let searchInput, filter, chatItems, chatItem, searchContent, i, txtValue;
        searchInput = document.getElementById("chatInputBox");
        filter = searchInput.value.toUpperCase();
        chatItems = document.getElementById("chatItems");
        chatItem = chatItems.getElementsByClassName("chat-item");
        for (i = 0; i < chatItem.length; i++) {
            searchContent = chatItem[i].getElementsByTagName("p")[0];
            txtValue = searchContent.textContent || searchContent.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                chatItem[i].style.display = "";
            } else {
                chatItem[i].style.display = "none";
            }
        }
    }

    $("#message").keyup(function (e) {
        let message = $("#message").val();
        if (message != "") {
            let code = e.keyCode || e.which;
            if (code == 13) { //Enter keycode
                appendSenderMessage();
            }
        }
    });

    $("#send-message").click(function () {
        appendSenderMessage();
    });

    $(".chat-item").click(function () {
        let name = $(this).find("#userName").text();
        $("#user_name").text(name);
       getConnection($(this).data('user_id'));
    });

    $(document).on("click", ".chat-item", function () {
        if (!$(this).hasClass("active")) {
            $(".chat-item.active").removeClass("active");
            $(this).addClass("active");
        };
        $('.chat-box-wrap').addClass('active')

    });
    $(document).on("click", ".crose-btn", function () {
        $('.chat-box-wrap').removeClass('active')
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
        let receiver = $(".chat-item.active").data("user_id");
        // $.ajax({
        //     url: 'admin/chat/send_chat_message',
        //     type: "POST",
        //     data: {message: message, receiver: receiver},
        //     success: function (response) {
        //     }
        // });
    }
    if($('body').innerWidth() < 767){
        $('.responsiveChatBox').hide()
        $('.responsiveChatBox').css('marginBottom','40px')
        $(document).on('click','#chatItems .chat-item',function(){
            $('.responsiveChatBox').show()
            $('.chat-list-wrap').hide()
        })  
         $(document).on('click','.chatTrigger',function(){
            $('.responsiveChatBox').hide()
            $('.chat-list-wrap').show()
        })
    }
</script>

<script>
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
                        let userNameDada  = item.otherUserName.split(' ')
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
                                "                                                <span><span id=\"userNameChat\">\n" + userNameDada[0] + "</span>" + item.timestamp + "</span>\n" +
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
                $('#your_div').animate({
                        scrollTop: $('#your_div')[0].scrollHeight
                    });
            }
        });
    }
    

</script>