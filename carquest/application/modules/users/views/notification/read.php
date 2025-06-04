<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users','css'); ?>
<section class="content-header">
    <h1>Notification  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li><li><a href="<?php echo Backend_URL ?>users">Users</a></li><li><a href="<?php echo site_url( Backend_URL .'users/notification' )?>">Notification</a></li>
        <li class="active">Details</li>
    </ol>
</section>

<section class="content">
    <?php echo notificationTabs($id, 'read'); ?>
    <div class="box no-border">
        
        <div class="box-header with-border">
            <h3 class="box-title">Details View</h3>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
        <table class="table table-striped">
	    <tr><td width="150">User Id</td><td width="5">:</td><td><?php echo $user_id; ?></td></tr>
	    <tr><td width="150">Type Id</td><td width="5">:</td><td><?php echo $type_id; ?></td></tr>
	    <tr><td width="150">Brand Id</td><td width="5">:</td><td><?php echo $brand_id; ?></td></tr>
	    <tr><td width="150">Model Id</td><td width="5">:</td><td><?php echo $model_id; ?></td></tr>
	    <tr><td width="150">Year</td><td width="5">:</td><td><?php echo $year; ?></td></tr>
	    <tr><td></td><td></td><td><a href="<?php echo site_url( Backend_URL .'users/notification') ?>" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> Back</a><a href="<?php echo site_url( Backend_URL .'users/notification/update/'.$id ) ?>" class="btn btn-primary"> <i class="fa fa-edit"></i> Edit</a></td></tr>
	</table>
	</div></section>