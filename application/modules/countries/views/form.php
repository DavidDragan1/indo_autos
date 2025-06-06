<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1> Countries  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/countries') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/countries">Countries</a></li>
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
                    <label for="name" class="col-sm-2 control-label">Name :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />
                        <?php echo form_error('name') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="type" class="col-sm-2 control-label">Type :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="type" id="type" placeholder="Type" value="<?php echo $type; ?>" />
                        <?php echo form_error('type') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" />
                        <?php echo form_error('status') ?>
                    </div>
                </div>
	<div class="col-md-12 text-right">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('admin/countries') ?>" class="btn btn-default">Cancel</a>
	</div></form>
	</div></div></section>