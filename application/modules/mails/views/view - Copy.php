
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Read Mail</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>            
            <li> <a href="<?php echo Backend_URL; ?>/mails"> Mail Box </a></li>
	    <li class="active">Read</li>
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
                        <h3 class="box-title">Read Mail</h3>
                        <div class="box-tools pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply" onclick="submitReply('admin/mails/create')">
                                    <i class="fa fa-reply"></i> Reply
                                </button>
                            </div>
                        </div>
                    </div>

                    <!--RKB-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-group" id="panel-48575">
                                    <div class="panel panel-default">
                                        
                                        <div class="panel-heading">
                                            <a class="panel-title <?php if(count($child_mails)>0){?>collapsed<?php }?>" data-toggle="collapse" data-parent="#panel-<?php echo $id;?>" href="#panel-element-<?php echo $id;?>">
                                                <h5>From: <?php echo '<b>'.$mail_from.'</b>'; ?>
                                                    <span class="mailbox-read-time pull-right">
                                                        <?php echo globalDateTimeFormat($created); ?>
                                                    </span>
                                                </h5>
                                            </a>
                                        </div>
                                        
                                        <div id="panel-element-<?php echo $id;?>" class="panel-collapse collapse <?php if(count($child_mails)==0){?>in<?php }?>">
                                            <div class="panel-body">
                                                <div class="mailbox-controls with-border">
                                                Subject: <span style="font-weight: bold;"><?php echo $subject; ?></span>
                                                </div>
                                                <div class="mailbox-read-message">
                                                    <p><?php echo $body; ?></p>
                                                </div>
                                                <?php if($attachments){?>
                                                    <div class="box-footer">
                                                        <ul class="mailbox-attachments clearfix">
                                                            <?php foreach($attachments as $attachment){
                                                                $ext = strtolower(substr(strrchr($attachment->filename, '.'), 1));
                                                                $link = base_url().'uploads/attachments/'.strtolower(substr(strrchr($attachment->filelocation, '\\'), 1));
                                                                ?>
                                                                <li>
                                                                    <?php if($ext=='pdf'){?>
                                                                        <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                                    <?php }elseif($ext=='doc'||$ext=='docx'){?>
                                                                        <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>
                                                                    <?php }elseif($ext=='txt'){?>
                                                                        <span class="mailbox-attachment-icon"><i class="fe fa-file-text-o"></i></span>
                                                                    <?php }elseif($ext=='zip'||$ext=='rar'){?>
                                                                        <span class="mailbox-attachment-icon"><i class="fa fa-file-zip-o"></i></span>
                                                                    <?php }elseif($ext=='jpg'||$ext=='jpeg'||$ext=='gif'||$ext=='png'||$ext=='bmp'){?>
                                                                        <span class="mailbox-attachment-icon has-img"><img src="<?php echo $link;?>" alt="Attachment"></span>
                                                                    <?php }?>

                                                                    <div class="mailbox-attachment-info">
                                                                        <span class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?php echo $attachment->filename;?></span>
                                                                        <span class="mailbox-attachment-size">
                                                                          <?php echo $attachment->size;?> KB
                                                                          <a href="<?php echo $link;?>" target="new" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                            <?php }?>
                                                        </ul>
                                                    </div>
                                                <?php }?>
                                                <!-- /.box-footer -->
                                            </div>
                                        </div>
                                    </div>

                                    <?php if(count($child_mails)>0){
                                        $total_children=count($child_mails);
                                        $i=1;
                                        foreach($child_mails as $child_mail){
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <a class="panel-title <?php if($i!=$total_children){?>collapsed<?php }?>" data-toggle="collapse" data-parent="#panel-48575" href="#panel-element-<?php echo $child_mail->id; ?>">
                                                <h5>From: <?php echo '<b>'.getUserNameById($child_mail->sender_id).'</b> '.getUserEmailById($child_mail->sender_id).'' ?>
                                                    <span class="mailbox-read-time pull-right"><?php echo globalDateTimeFormat($child_mail->created); ?></span></h5>
                                            </a>
                                        </div>
                                        <div id="panel-element-<?php echo $child_mail->id; ?>" class="panel-collapse collapse <?php if($i==$total_children){?>in<?php }?>">
                                            <div class="panel-body">
                                                Subject: <span style="font-weight: bold;"><?php echo $subject; ?></span>
                                                <p><?php echo $child_mail->body; ?></p>
                                            </div>
                                            <?php if($child_mail->attachments){?>
                                                <div class="box-footer">
                                                    <ul class="mailbox-attachments clearfix">
                                                        <?php foreach($child_mail->attachments as $attachment){
                                                            $ext = strtolower(substr(strrchr($attachment->filename, '.'), 1));
                                                            $link = base_url().'uploads/attachments/'.strtolower(substr(strrchr($attachment->filelocation, '\\'), 1));
                                                            ?>
                                                            <li>

                                                                <?php if($ext=='pdf'){?>
                                                                    <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                                <?php }elseif($ext=='doc'||$ext=='docx'){?>
                                                                    <span class="mailbox-attachment-icon"><i class="fa fa-file-word-o"></i></span>
                                                                <?php }elseif($ext=='txt'){?>
                                                                    <span class="mailbox-attachment-icon"><i class="fe fa-file-word-o"></i></span>
                                                                <?php }elseif($ext=='zip'||$ext=='rar'){?>
                                                                    <span class="mailbox-attachment-icon"><i class="fa fa-file-zip-o"></i></span>
                                                                <?php }elseif($ext=='jpg'||$ext=='jpeg'||$ext=='gif'||$ext=='png'||$ext=='bmp'){?>
                                                                    <span class="mailbox-attachment-icon has-img"><img src="<?php echo $link;?>" alt="Attachment"></span>
                                                                <?php }?>

                                                                <div class="mailbox-attachment-info">
                                                                    <span class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> <?php echo $attachment->filename;?></span>
                                                                    <span class="mailbox-attachment-size">
                                                                      <?php echo $attachment->size;?> KB
                                                                      <a href="<?php echo $link;?>" target="new" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                                                    </span>
                                                                </div>
                                                            </li>
                                                        <?php }?>
                                                    </ul>
                                                </div>
                                            <?php }?>
                                            <!-- /.box-footer -->
                                        </div>
                                    </div>
                                    <?php
                                        $i++; }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--RKB-->

                    <!-- /.box-body -->

                    <div class="box-footer">
                        <div class="pull-right">
                            <form role="form" method="POST" id="mail_reply_form" action="">
                                <input type="hidden" name="mail_type" value="reply">
                                <input type="hidden" name="reciever_id" value="<?php echo $sender_id; ?>">
                                <input type="hidden" name="parent_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="subject" value="<?php echo $subject; ?>">
                            <button type="button" class="btn btn-default" onclick="submitReply('admin/mails/create')"><i class="fa fa-reply"></i> Reply</button>
                            </form>                            
                        </div>
                        
                        
                        <script>
                            function submitReply(action)
                            {
                                document.getElementById('mail_reply_form').action = action;
                                document.getElementById('mail_reply_form').submit();
                            }
                            function submitForward(action)
                            {
                                document.getElementById('mail_forward_form').action = action;
                                document.getElementById('mail_forward_form').submit();
                            }
                        </script>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->