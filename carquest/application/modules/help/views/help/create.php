<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="assets/lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="assets/lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script> $(function () { $("#content").wysihtml5(); }); </script>


<section class="content-header">
    <h1> Help  <small><?php echo $button ?></small> <a href="<?php echo site_url(Backend_URL . 'help') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li><li><a href="<?php echo Backend_URL ?>help">Help</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Create New Help</h3>
        </div>

        <div class="box-body">
            <?php echo form_open($action, array('class' => 'form-horizontal', 'method' => 'post')); ?>
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Question :</label>
                <div class="col-sm-10">                    
                    <input type="text" class="form-control" name="title" id="title" placeholder="Question" value="<?php echo $title; ?>" />
                    <?php echo form_error('title') ?>
                </div>
            </div>
            <div class="form-group">        
                <label for="content" class="col-sm-2 control-label">Answer :</label>
                <div class="col-sm-10">                    
                    <textarea class="form-control" rows="10" name="content" id="content" placeholder="Answer"><?php echo $content; ?></textarea>
                    <?php echo form_error('content') ?>
                </div>
            </div>
            <div class="form-group">        
                <label for="content" class="col-sm-2 control-label">Status :</label>
                <div class="col-sm-10" style="padding-top: 8px;">
                   <?php echo htmlRadio('status', $status, array('Published' => 'Published', 'Draft' => 'Draft') ); ?>
                </div>
            </div>
            <div class="form-group">        
                <label for="content" class="col-sm-2 control-label">Top FAQ :</label>
                <div class="col-sm-10" style="padding-top: 8px;">
                   <?php echo htmlRadio('featured', $featured, array('Yes' => 'Yes', 'No' => 'No') ); ?>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                <a href="<?php echo site_url(Backend_URL . 'help') ?>" class="btn btn-default">Cancel</a>
            </div>
            </form>
        </div>
    </div>
</section>
<script src="assets/lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

