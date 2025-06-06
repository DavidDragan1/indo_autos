<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Settings  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/settings') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/settings">Settings</a></li>
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
                    <label for="label" class="col-md-2 control-label">Label :</label>
                    <div class="col-md-10">                    
                        <input type="text" class="form-control" name="label" id="label" placeholder="Label" value="<?php echo $label; ?>" />
                        <?php echo form_error('label') ?>
                    </div>
                </div>
                <div class="form-group">        
                    <label for="value" class="col-md-2 control-label">Value :</label>
                    <div class="col-md-10">
                        <textarea class="form-control" rows="3" name="value" id="value" placeholder="Value"><?php echo $value; ?></textarea>
                        <?php echo form_error('value') ?>
                    </div>
                </div>
                <div class="col-md-12 text-right">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                    <a href="<?php echo site_url('admin/settings') ?>" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>