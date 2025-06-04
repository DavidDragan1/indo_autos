<style>
    .ajax_error {
        color: red;
    };

    .ajax_success {
        color: green;
    };
</style>
<h2 class="breadcumbTitle">Read Mail</h2>
<!-- read-mail-area start  -->
<div class="read-main-area">
    <div class="readmail-header">
        <h4><?php echo $subject; ?></h4>
        <span>From: <?php echo $mail_from; ?></span>
        <span>To: <?php echo $mail_to; ?> <span class="pull-right"><?php echo $created; ?></span> </span>
    </div>
    <div class="main-box">
        <?php echo $body; ?>
    </div>
    <?php
    $replyMails =  Modules::run('mails/getReplyMails', $id); ?>

    <?php if($replyMails): ?>
        <?php foreach($replyMails as $replyMail): ?>
            <div class="readmail-header">
                <h4>Re: <?php echo $replyMail->subject; ?></h4>
                <span>From: <?php echo $replyMail->mail_from; ?></span>
                <span>To: <?php echo $replyMail->mail_to; ?> <span class="pull-right"><?php echo $replyMail->created; ?></span></span>
            </div>
            <div class="main-box"><?php echo $replyMail->body; ?></div>
        <?php endforeach;  ?>
    <?php endif;  ?>

    <ul class="readmail-btn readmailHiden" style="text-align: right;">
        <li class="replyBtn"><button>Reply</button></li>
        <li><button><i class="fa fa-print"></i> Print</button></li>
        <li><button type="button" onclick="deleteMail(<?php echo $id; ?>)"><i class="fa fa-trash"></i> Delete</button></li>
    </ul>

    <div class="replymail-wrap">
        <form role="form" method="POST" id="mail_reply_form">
            <div class="replymail" style="display: none;">
                <ul class="list-wrap">
                    <li>Reply: <?php echo $subject; ?></li>
                    <?php if ($type === 'Inbox') : ?>
                    <li>To: <?php echo $mail_from; ?></li>
                    <li>From: <?php echo $mail_to; ?></li>
                    <?php else: ?>
                    <li>To: <?php echo $mail_to; ?></li>
                    <li>From: <?php echo $mail_from; ?></li>
                    <?php endif; ?>
                </ul>
                <textarea id="message" name="message" class="replymail-editor"></textarea>
                <input type="hidden" id="parent_id" name="parent_id" value="<?php echo $id; ?>">
                <input type="hidden" id="type" name="type" value="<?php echo $type; ?>">
                <P id="editorError" class="error-message" style="display:none">Message can not be empty</P>
            </div>
        </form>
        <ul class="readmail-btn readmail-Cancle" style="display: none;">
            <li><button onclick="submitForm()" type="submit">Send</button></li>
            <li><a href="<?php echo base_url(uri_string()); ?>" class="readmoreCancel">Cancel</a></li>
        </ul>
        <div id="msg"></div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/ckeditor.js"></script>
<script>
    CKEDITOR.replace('message', {
        height: ['120px'],
        customConfig: '<?php echo site_url(); ?>assets/theme/new/js/ckeditor/config.js',
    });

    function submitForm() {
        if(CKEDITOR.instances.message.getData() === ""){
            $('#editorError').show()
        }else{
            $('#editorError').hide()
            $.ajax({
                type: "POST",
                url: "admin/mails/reply_mail_action_trader",
                dataType: 'json',
                data: {
                    "message": CKEDITOR.instances.message.getData(),
                    'parent_id': $("#parent_id").val(),
                    'type': $("#type").val(),
                },
                success: function(jsonData) {
                    jQuery('#msg').html(jsonData.Msg).slideDown('slow');
                    if(jsonData.Status === 'OK'){
                        jQuery('#msg').delay(1000).slideUp('slow');
                    } else {
                        jQuery('#msg').delay(5000).slideUp('slow');
                    }
                },
            });
            CKEDITOR.instances.message.setData('');
            location.reload();
        }
    }
    
    function deleteMail(id){
        var yes = confirm('Are you sure?');
        var type = "<?php echo $type; ?>";
        if (yes) {
            jQuery.ajax({
                type: "POST",
                url: "admin/mails/delete",
                dataType: 'json',
                data: {
                    "id" : id,
                },
                success: function(jsonData) {
                    jQuery('#msg').html(jsonData.Msg).slideDown('slow');

                    if(jsonData.Status === 'OK'){
                        jQuery('#msg').delay(1000).slideUp('slow');
                        if (type === "Inbox") {
                            window.location.href = '<?php echo  site_url(Backend_URL.'mails'); ?>'
                        } else {
                            window.location.href = '<?php echo  site_url(Backend_URL.'mails/sent'); ?>'
                        }
                    } else {
                        jQuery('#msg').delay(5000).slideUp('slow');
                    }
                }
            });
        }
    }
</script>