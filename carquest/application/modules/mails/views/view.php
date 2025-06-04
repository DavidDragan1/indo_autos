
<link rel="stylesheet" href="assets/lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<section class="content-header">
    <h1> Read Mail</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>            
        <li> <a href="<?php echo Backend_URL; ?>/mails"> Mail Box </a></li>
        <li class="active">Read</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-3">
            <?php $this->load->view('mails_sidebar') ?>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Read Mail</h3>
                  <div class="box-tools pull-right">
                    <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                    <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
                  </div>
                </div>
                <div class="box-body no-padding">
                  
                  <div class="mailbox-read-info">
                    <h3><?php echo $subject; ?></h3>
                    <h5>From: <?php echo $mail_from; ?></h5>
                    <h5>To: <?php echo $mail_to; ?> <span class="mailbox-read-time pull-right"><?php echo $created; ?></span></h5>
                  </div> 
                                                                        
                  <div class="mailbox-read-message"><?php echo mail_header($subject).$body.mail_footer(); ?></div>
                  
                  <hr>
                  <?php 
                  $replyMails =  Modules::run('mails/getReplyMails', $id); ?>
                  
                  <?php if($replyMails): ?>
                  <?php foreach($replyMails as $replyMail): ?>
                  <div class="mailbox-read-info">
                    <h3><em>Re: </em><?php echo $replyMail->subject; ?></h3>
                    <h5>From: <?php echo $replyMail->mail_from; ?></h5>
                    <h5>To: <?php echo $replyMail->mail_to; ?> <span class="mailbox-read-time pull-right"><?php echo $replyMail->created; ?></span></h5>
                  </div> 
                                                                        
                  <div class="mailbox-read-message"><?php echo $replyMail->body; ?></div>
                  
                  <?php endforeach;  ?>
                  <?php endif;  ?>
                </div>
                
                <div class="box-footer hidden"><?php // getAttachment($mail_id); ?></div>
                
                <div class="replay_box" style="display: none;">
                    <hr>
                    <form role="form" method="POST" id="mail_reply_form" action="">
                        <div class="box-body">
                            <div class="form-group">
                                <input class="form-control" name="subject" placeholder="" readonly="" value="Reply: <?php echo $subject; ?>">                                 
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="mail_to" placeholder="" readonly="" value="<?php echo $mail_from; ?>">                                 
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="mail_from" placeholder="" readonly="" value="<?php echo $mail_to; ?>">                                 
                            </div>
                            <div class="form-group">
                                <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px"></textarea>
                            </div>                           
                        </div>
                        <input type="hidden" name="parent_id" value="<?php echo $id; ?>" />
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="pull-right">
                                <!--<button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>-->
        <!--                        <button type="submit" class="btn btn-primary" onclick="submitForm('admin/mails/reply_mail_action')"><i class="fa fa-envelope-o"></i> Reply</button>-->
                                <button type="button" class="btn btn-primary" onclick="submitForm()"><i class="fa fa-envelope-o"></i> Send</button>
                                <a href="<?php echo base_url(uri_string()); ?>"><button class="btn btn-default"><i class="fa fa-print"></i> Cancel</button></a>
                            </div>
                            <!--<button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>-->
                        </div>
                    </form>
                </div>
                
                <div class="box-footer text-right reply_div">                  
                    <button class="btn btn-default reply_btn"><i class="fa fa-reply"></i> Reply</button>
                    <button class="btn btn-default"><i class="fa fa-print"></i> Print</button>
                </div>
                <div id="msg"></div>
              </div>


        </div>

    </div>

</section>
    
<script src="assets/lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>
    var $ = jQuery; 
    $(function () {      
        $("#compose-textarea").wysihtml5();
    });
    
    

$('.reply_btn').click(function(){
    $('.replay_box').slideDown('slow');
    $('.reply_div').fadeOut('slow');
});

function submitForm(){
    var formData = $('#mail_reply_form').serialize();
    jQuery.ajax({
                type: "POST",      
   
                // url: "mail/subscribe",
                url: "admin/mails/reply_mail_action",
                dataType: 'json',
                data: formData,
                success: function(jsonData) {
                    jQuery('#msg').html( jsonData.Msg ).slideDown('slow');
                    if(jsonData.Status === 'OK'){
                        jQuery('#msg').delay(1000).slideUp('slow');                        
                    } else {
                         jQuery('#msg').delay(5000).slideUp('slow');
                    }

                }
            });
}
</script>