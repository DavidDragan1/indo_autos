<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Mailbox
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Mailbox</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <?php $this->load->view('mails_sidebar') ?>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Compose New Message</h3>
                </div>
                <!-- /.box-header -->
                <form role="form" method="POST" id="mail_reply_form" action="" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <?php if($mail_type=='reply'){?>
                        <input class="form-control" placeholder="To:" readonly value="<?php if($reciever_id){ echo getUserNameById($reciever_id).' <'.getUserEmailById($reciever_id).'>';}?>">
                        <?php }else{?>
                        <input class="form-control" name="reciever_email" placeholder="To:" value="">
                        <?php echo form_error('reciever_email') ?>
                        <?php }?>
                        <?php if($parent_id){?>
                        <input name="parent_id" type="hidden" value="<?php  echo $parent_id;?>">
                        <input name="reciever_email" type="hidden" value="<?php  echo getUserEmailById($reciever_id);?>">
                        <?php }?>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="subject" placeholder="Subject:" value="<?php if($subject){ echo $subject;}?>">
                        <?php echo form_error('subject') ?>
                    </div>
                    <div class="form-group">
                    <?php echo form_error('message') ?>
                    <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px">
                        <?php if($body!=''){ echo $body;}?>
                    </textarea>
                    </div>
                    <div class="form-group">
                        <div class="btn btn-default btn-file">
                            <i class="fa fa-paperclip"></i> Attachment
                            <input type="file" name="attachment" multiple>
                        </div>
                        <p class="help-block">Max. 5MB</p>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <!--<button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>-->
<!--                        <button type="submit" class="btn btn-primary" onclick="submitForm('admin/mails/reply_mail_action')"><i class="fa fa-envelope-o"></i> Reply</button>-->
                        <button type="submit" class="btn btn-primary" onclick="submitForm('admin/mails/create_action')"><i class="fa fa-envelope-o"></i>Send</button>
                    </div>
                    <!--<button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>-->
                </div>
                </form>
                <script>
                    function submitForm(action)
                    {
                        /*var reciever_email = jQuery('[name=reciever_email]').val();
                        var subject = jQuery('[name=subject]').val();
                        var error=0;

                        if(admin_validateEmail(reciever_email=='false')){
                            jQuery('#email_msg').html('Invalid Email.').show();
                            error = 1;
                        }
                        if(subject==''){
                            jQuery('#subject_msg').html('Invalid Email.').show();
                            error = 1;
                        }
                        if(error!=0) {*/
                            document.getElementById('mail_reply_form').action = action;
                            document.getElementById('mail_reply_form').submit();
                        /*}*/
                    }
                </script>
                <!-- /.box-footer -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <script>
        $(function () {
            //Add text editor
            $("#compose-textarea").wysihtml5();
        });
    </script>

</section>
<!-- /.content -->