<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Notification  <small><?php echo $button ?></small> <a href="<?php echo site_url( Backend_URL .'users/notification') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li><li><a href="<?php echo Backend_URL ?>users">Users</a></li><li><a href="<?php echo Backend_URL ?>users/notification">Notification</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Create New User_notifications</h3>
        </div>
        
        <div class="box-body">
        <?php echo form_open( $action, array('class'=>'form-horizontal', 'method'=>'post')); ?>
	    <div class="form-group">
                    <label for="user_id" class="col-sm-2 control-label">User Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="user_id" id="user_id" placeholder="User Id" value="<?php echo $user_id; ?>" />
                        <?php echo form_error('user_id') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="type_id" class="col-sm-2 control-label">Type Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="type_id" id="type_id" placeholder="Type Id" value="<?php echo $type_id; ?>" />
                        <?php echo form_error('type_id') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="brand_id" class="col-sm-2 control-label">Brand Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="brand_id" id="brand_id" placeholder="Brand Id" value="<?php echo $brand_id; ?>" />
                        <?php echo form_error('brand_id') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="model_id" class="col-sm-2 control-label">Model Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="model_id" id="model_id" placeholder="Model Id" value="<?php echo $model_id; ?>" />
                        <?php echo form_error('model_id') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="year" class="col-sm-2 control-label">Year :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="year" id="year" placeholder="Year" value="<?php echo $year; ?>" />
                        <?php echo form_error('year') ?>
                    </div>
                </div>
	<div class="col-md-12 text-right">
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url( Backend_URL .'users/notification') ?>" class="btn btn-default">Cancel</a>
	</div>
</form>
	</div></div></section>