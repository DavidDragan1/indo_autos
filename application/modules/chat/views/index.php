<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('chat', 'css'); ?>

<style>
    .messages { min-height: 400px; max-height: 420px;}
	.chat_user_list {
    border: 1px solid #ddd;
    margin-left: 15px;
    margin-top: 14px;
    max-height: 800px;
    overflow-y: auto;
    padding-top: 9px;
    text-align: center;
}
.delete_chat {
    position: absolute;
    right: 37px;
    top: 22px;
}
</style>
<section class="content-header">
    <h1> Chats  <small>Control panel</small> <?php //echo anchor(site_url(Backend_URL . 'invoice/create'), ' + Add New', 'class="btn btn-default"');   ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Chats</li>
    </ol>
</section>

<section class="content"> 

    <div class="panel panel-default">
        <div class="panel-body no-padding">
            <div class="row">
                <div class="col-sm-3">
                    <div id="notice">
                        <div class="chat_user_list">
                        <ul>
                            <?php if ($guests):
                                foreach ($guests as $guest) :
                                    ?>
                            <li class="<?php echo( $this->input->get('client_id') == $guest->sender_id ) ? 'active' : '';  ?>" id="guestID_<?php echo $guest->sender_id;  ?>" >
                                <a href="<?php echo base_url('admin/chat?client_id=' . $guest->sender_id); ?>">Guest ID-<?php echo $guest->sender_id; ?></a>
                            </li>  

                                <?php endforeach;
                            else :
                                ?>
                                <p>No Chat history found</p>
<?php endif; ?>

                        </ul>
                    </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="message_list">

                        <div class="chat_window">
                            <div class="top_menu">
                                <div class="buttons">
                                    <div class="button close"></div>
                                    <div class="button minimize"></div>
                                    <div class="button maximize"></div>
                                </div>
                                <div class="title">Chat</div>
                                <button  id="delete-chat"  delete-chat="<?php echo $this->input->get('client_id');  ?>" class="btn btn-xs btn-danger delete_chat">Delete chat</button>
                            </div>
                            <?php if($this->input->get('client_id')) : ?>
                            <ul class="messages"> 
                                <?php if ($chats): ?>
                                    <?php foreach ($chats as $chat) : ?>
                                
                                       <?php 
                                       //echo $chat->sender_id;
                                        if($chat->match_id == $chat->vendor_id && $chat->match_id != $chat->sender_id ) { 
                                           $name = getFirstNameByUserId( $chat->sender_id )    ; 
                                           $side = 'left';
                                        } else{ 
                                           $name =  getFirstNameByUserId( $chat->guest_user_id ); 
                                           $side = 'right';
                                        } 
                                        $currentDateTime = $chat->created_at;
$newDateTime = date('h:i A', strtotime($currentDateTime));
                                        ?>


                                        <li class="message <?php echo $side; ?> appeared">
                                            <div class="avatar"> <?php echo $name; ?>  <span><?php echo $newDateTime; ?></span></div>
                                           
                                            <div class="text_wrapper">
                                                <div class="text"> <?php echo $chat->message; ?> </div>
                                            </div>
                                        </li>

                                    <?php endforeach ?>
                                <?php else : ?>
                                    <p>No Chat history found</p>
                                <?php endif; ?>
                                    
                            </ul>
                                
                            <form action="" method="POST" id="chatForm">
                                <div class="bottom_wrapper clearfix">
                                    <div class="message_input_wrapper">	  
                                        <input class="message_input" required="" name="message" placeholder="Type your message here..." /></div>
                                    <div class="send_message">
                                        <div class="icon"></div>
                                        <button type="submit"><div class="text"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</div></button>

                                    </div>
                                </div>
                            </form>
                                <?php else :  ?>
                            <div class="messages"><h2 class="">Please select a Guest from left side</h2></div>
                            
                            <?php endif; ?>

                            


                        </div>
                        <div class="message_template">
                            <li class="message">
                                <div class="avatar"></div>
                                <div class="text_wrapper">
                                    <div class="text"></div>
                                </div>
                            </li>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div> 

</section>

<script type="text/javascript" src="assets_chat/css/date.js" type="text/javascript"></script> 
<script type="text/javascript" src="https://js.pusher.com/4.0/pusher.min.js"></script>
<script>

$('<audio id="chatAudio"><source src="<?php echo base_url(); ?>assets_chat/notify.mp3" type="audio/ogg"><source src="<?php echo base_url(); ?>assets_chat/notify.mp3" type="audio/mpeg"><source src="<?php echo base_url(); ?>assets_chat/notify.wav" type="audio/wav"></audio>').appendTo('body');
    var myAudio = $("#chatAudio")[0];
    
    var time = new Date().toString("hh:mm tt"); //startTime();
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('<?php echo PUSHER_APP_KEY; ?>', {
        encrypted: true
    });

    var channel = pusher.subscribe('my-channel-<?php echo getLoginUserData('user_id'); ?>');
    
    channel.bind('my-event-<?php echo $this->input->get('client_id'); ?>', function (data) {
         // $('#guestID_'+ data.name ).addClass('new_notice');
        
        if (channel) {
            var side = 'right';
            myAudio.play();
        } else {
            var side = 'left';
        }
  
         

        var html = '<li class="message ' + side + ' appeared">' +
                '<div class="avatar">' + data.name + '<span>'+ time +'</span></div>' +
                '<div class="text_wrapper">' +
                '<div class="text">' + data.message + '</div>' +
                '</div>' +
                '</li>';
        $('.messages').append(html);


        $('.messages').animate({scrollTop: $(document).height()}, 'slow');




    });


    function givenText(input, time) {
        

        var html = '<li class="message left appeared">' +
                '<div class="avatar"> <?php echo getFirstNameByUserId( getLoginUserData('user_id') ) ; ?>'+'<span>'+ time +'</span>'+'</div>' +
                '<div class="text_wrapper">' +
                '<div class="text">' + input.value + '</div>' +
                '</div>' +
                '</li>';
        $('.messages').append(html);
        $('.messages').animate({scrollTop: $(document).height() + '100px' }, 'slow');

    }

    $("#chatForm").submit(function () {
        givenText($(".message_input").get(0), time );
        send_msg();
        document.getElementById("chatForm").reset();
        return false;
    });

    function send_msg() {

        var message = $('.message_input').val();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/chat/chat_message_send',
            type: "POST",
            dataType: "json",
            data: {message: message, send_to: '<?php echo $this->input->get('client_id'); ?>'}


        });

    }

<?php foreach($guests as $gus) : ?>
 channel.bind('my-event-<?php echo $gus->match_id; ?>', function (data) {
      myAudio.play();
          $('#guestID_<?php echo $gus->sender_id; ?>'  ).addClass('new_notice');
    });
    <?php endforeach;  ?>


  
function startTime(){
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds(); 
  return [ h, m, s ].join(':')
}



setInterval(function(){ 
   // 
   $.ajax({
            url: '<?php echo base_url(); ?>admin/chat/chat_notice',
            type: "POST",
            dataType: "text",
            cache : false,
            data: {  selected: '<?php  echo $this->input->get('client_id'); ?>' },
            success: function(msg){
                    $('#notice').html( msg );				
            }
        });
}, 120000);


$('#delete-chat').click(function(){
 if(confirm('Confirm!')) {
 var  del = $(this).attr('delete-chat');
 
 window.location = '<?php echo Backend_URL; ?>chat/delete_chat?delete='+del;

  } 
  
  
 });

</script>


<?php load_module_asset('chat', 'js'); ?>