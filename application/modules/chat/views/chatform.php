<?php

$user_id = (isset($_GET['vendor']))  ? $_GET['vendor'] :  0 ; 
$token = (isset($_GET['token']))  ? $_GET['token'] :  0 ; 

?>

<script type="text/javascript" src="https://js.pusher.com/4.0/pusher.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>


<script type="text/javascript" src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="assets_chat/css/date.js" type="text/javascript"></script> 
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<?php load_module_asset('chat', 'css'); ?>

<?php $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

<?php $seller = Modules::run('profile/profile_frontview/getUserInfo', $user_id); 

?>


<div class="full_chat_box">
	<div class="frontend_chat_left">
            <?php if( $seller['user']['current_status'] == 'Online'): ?>
		<ul class="messages frontend_msg"> </ul>
		
                <form action="" method="POST" id="chatForm">
                        <input type="hidden" name="chatid" value="<?php echo @$chat->id; ?>"/>     
                        <input type="hidden" name="ip" value="<?php echo @$_SERVER['REMOTE_ADDR']; ?>"/>
                        <input type="hidden" name="stay_url" value="<?php echo @$actual_link; ?>"/>

                        <div class="bottom_wrapper frontend_chatForm clearfix">
                            <div class="message_input_wrapper">	  
                                <input class="message_input" required="" name="message" id="" placeholder="Type your message here..." /></div>
                            <div class="send_message">
                                <button type="submit">Send <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </form>
    <?php else: ?>     
                <div class="messages frontend_msg offline_messages">
                    <h2 id="success_report"></h2>
                    <form name="" id="off_message" method="post" action="">
                            <p>Our chat agents are not available at the moment, please leave us a message and we will get back to you as soon as  possible</p><br><br>

                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="name" name="name" class="form-control" required="" id="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" class="form-control" required="" id="email">
                                <input type="hidden" name="vendor_id"  value="<?php echo $user_id; ?>">
                            </div>

                            <div class="form-group">
                                <label for="message">Message:</label>
                                <textarea name="message" rows="5" class="form-control" required="" id="message"></textarea>
                            </div>

                            <button type="button" onclick="offline_msg()" class="btn btn-success">Submit</button>

                        </form>
                    
                    
                </div>  
    <?php endif; ?>

	</div>
	<div class="frontend_chat_right">
		<div class="vendor_company_logo">
			<?php echo GlobalHelper::getUserProfilePhoto($seller['user']['profile_photo']); ?>
			<h3><?php 
                            echo @$seller['cms']['post_title']; ?></h3>
                        
		</div>
		
		<div class="vendor_company_details">
			<h4>Address:</h4>
			<p><?php echo $seller['user']['add_line1']; ?></p>
			<p><?php echo $seller['user']['add_line2']; ?></p>
			<p><?php echo $seller['user']['city']; ?></p>
			<p><?php echo $seller['user']['state']; ?></p>
                        <p><?php echo getCountryName($seller['user']['country_id']); ?> </p>
		</div>
		<div class="vendor_company_details">
			<h4>Tel:</h4>
			<p><?php echo $seller['user']['contact']; ?></p>
		</div>
		<div class="vendor_company_details">
			<h4>Email:</h4>
			<p><?php echo $seller['user']['email']; ?></p>
		</div>
	</div>
</div>









<script>

$('<audio id="chatAudio"><source src="<?php echo base_url(); ?>assets_chat/notify.mp3" type="audio/ogg"><source src="<?php echo base_url(); ?>assets_chat/notify.mp3" type="audio/mpeg"><source src="<?php echo base_url(); ?>assets_chat/notify.wav" type="audio/wav"></audio>').appendTo('body');
    var myAudio = $("#chatAudio")[0];
    var time = new Date().toString("hh:mm tt");
// Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('<?php echo PUSHER_APP_KEY;  ?>', {
        encrypted: true
    });

    var channel = pusher.subscribe('my-channel-<?php echo $token; ?>');
    channel.bind('my-event-<?php echo $token; ?>', function (data) {
        // alert(data.message);


        if (channel) {
            var side = 'right';
            myAudio.play();
        } else {
            var side = 'left';           
        }

        var html = '<li class="message ' + side + ' appeared">' +
                '<div class="msg_left"><div class="avatar">' + data.name+ '<span>'+ time +'</span></div></div>' +
                '<div class="text_wrapper">' +
                '<div class="text">' + data.message + '</div>' +
                '</div>' +
                '</li>';
        $('.messages').append(html);


        $('.messages').animate({scrollTop: $(document).height()}, 'slow');




    });


    function givenText(input, time) {

<?php $logged =  getLoginUserData('user_id');
if(empty($logged) || $logged ==  null) {
   $chatUser = 'Guest';
} else {
     $chatUser = getFirstNameByUserId($logged);
} ?>
      
        
        var html = '<li class="message left appeared">' +
                '<div class="msg_left"><div class="avatar"> <?php echo $chatUser; ?> <span>'+ time +'</span></div></div>' +
                '<div class="text_wrapper">' +
                '<div class="text">' + input.value + '</div>' +
                '</div>' +
                '</li>';
        $('.messages').append(html);
        // $('.messages').animate({scrollTop: $(document).height()}, 'slow');
        $('.messages').animate({scrollTop: $(document).height() + '100px' }, 'slow');

    }

    $("#chatForm").submit(function () {
        givenText($(".message_input").get(0), time);
        send_msg();
        document.getElementById("chatForm").reset();
        return false;
    });

    

    function send_msg() {

        var message = $('.message_input').val();
       
        $.ajax({
            url: '<?php echo base_url(); ?>chat/chat_frontview/chat_message_send',
            type: "POST",
            dataType: "json",
            data: {send_to: '<?php echo $user_id; ?>' , message: message, token: '<?php echo $token; ?>' },

        });
       

    }

  
function offline_msg(){
var formData = $('#off_message').serialize();
	
	var name = $('#name').val();
	var email = $('#email').val();
	var message = $('#message').val();
	if(name && email && message) {
    $.ajax({
        url: '<?php echo base_url(); ?>chat/chat_frontview/offline_message_send',
        type: "POST",
        dataType: "text",
        cache: false,
        data: formData,
        beforeSend: function(){
            $('#off_message').slideUp('fast');
            // $('#success_report').html('<img src="loading.gif"> loading...');	
        },
        success: function(msg){
        
                $('#success_report').html( msg );  
                
                close_fn();
                setTimeout(function() {	
                   // location.reload();
                  //$("#dialog").dialog("close");
                  // $('#MainPopupIframe').hide();
                   //$('.ui-dialog-titlebar-close').click();
                   
                   //$( ".ui-dialog-titlebar-close" ).trigger( "click" );
                   
                   // window.location.href = "<?php // echo base_url(uri_string()); ?>";
                }, 1000);		
			
            
        }

    });
	} else {
		alert('Please fill all field');
	}
}

function close_fn() {
    setTimeout(function() {	
     $('#dialog').dialog('close');
     }, 3000);
}

</script>















