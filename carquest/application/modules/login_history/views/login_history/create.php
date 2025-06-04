<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Login_history  <small><?php echo $button ?></small> <a href="<?php echo site_url( Backend_URL .'login_history') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li><li><a href="<?php echo Backend_URL ?>login_history">Login_history</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Create New Login_history</h3>
        </div>
        
        <div class="box-body">
        <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
                    <label for="user_id" class="col-sm-2 control-label">User Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="user_id" id="user_id" placeholder="User Id" value="<?php echo $user_id; ?>" />
                        <?php echo form_error('user_id') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="login_time" class="col-sm-2 control-label">Login Time :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="login_time" id="login_time" placeholder="Login Time" value="<?php echo $login_time; ?>" />
                        <?php echo form_error('login_time') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="logout_time" class="col-sm-2 control-label">Logout Time :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="logout_time" id="logout_time" placeholder="Logout Time" value="<?php echo $logout_time; ?>" />
                        <?php echo form_error('logout_time') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="ip" class="col-sm-2 control-label">Ip :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="ip" id="ip" placeholder="Ip" value="<?php echo $ip; ?>" />
                        <?php echo form_error('ip') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="location" class="col-sm-2 control-label">Location :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="location" id="location" placeholder="Location" value="<?php echo $location; ?>" />
                        <?php echo form_error('location') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="browser" class="col-sm-2 control-label">Browser :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="browser" id="browser" placeholder="Browser" value="<?php echo $browser; ?>" />
                        <?php echo form_error('browser') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="device" class="col-sm-2 control-label">Device :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="device" id="device" placeholder="Device" value="<?php echo $device; ?>" />
                        <?php echo form_error('device') ?>
                    </div>
                </div>
	<div class="col-md-12 text-right">
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url( Backend_URL .'login_history') ?>" class="btn btn-default">Cancel</a>
	</div>
</form>
	</div></div></section>