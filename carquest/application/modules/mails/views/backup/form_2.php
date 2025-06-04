<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1> Mails  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/mails') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/mails">Mails</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Record</h3>
        </div>
        
        <div class="box-body">
        <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
                    <label for="parent_id" class="col-sm-2 control-label">Parent Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="parent_id" id="parent_id" placeholder="Parent Id" value="<?php echo $parent_id; ?>" />
                        <?php echo form_error('parent_id') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="sender_id" class="col-sm-2 control-label">Sender Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="sender_id" id="sender_id" placeholder="Sender Id" value="<?php echo $sender_id; ?>" />
                        <?php echo form_error('sender_id') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="reciever_id" class="col-sm-2 control-label">Reciever Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="reciever_id" id="reciever_id" placeholder="Reciever Id" value="<?php echo $reciever_id; ?>" />
                        <?php echo form_error('reciever_id') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="subject" class="col-sm-2 control-label">Subject :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="<?php echo $subject; ?>" />
                        <?php echo form_error('subject') ?>
                    </div>
                </div>
	    <div class="form-group">        
                    <label for="body" class="col-sm-2 control-label">Body :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="body" id="body" placeholder="Body"><?php echo $body; ?></textarea>
                        <?php echo form_error('body') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" />
                        <?php echo form_error('status') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="important" class="col-sm-2 control-label">Important :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="important" id="important" placeholder="Important" value="<?php echo $important; ?>" />
                        <?php echo form_error('important') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="log" class="col-sm-2 control-label">Log :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="log" id="log" placeholder="Log" value="<?php echo $log; ?>" />
                        <?php echo form_error('log') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="created" class="col-sm-2 control-label">Created :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="created" id="created" placeholder="Created" value="<?php echo $created; ?>" />
                        <?php echo form_error('created') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="folder_id" class="col-sm-2 control-label">Folder Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="folder_id" id="folder_id" placeholder="Folder Id" value="<?php echo $folder_id; ?>" />
                        <?php echo form_error('folder_id') ?>
                    </div>
                </div>
	<div class="col-md-12 text-right">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('admin/mails') ?>" class="btn btn-default">Cancel</a>
	</div></form>
	</div></div></section>