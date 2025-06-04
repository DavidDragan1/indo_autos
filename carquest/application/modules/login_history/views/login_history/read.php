<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users','css'); ?>
<section class="content-header">
    <h1>Login_history  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li><li><a href="<?php echo site_url( Backend_URL .'login_history' )?>">Login_history</a></li>
        <li class="active">Details</li>
    </ol>
</section>

<section class="content">
    <?php echo login_historyTabs($id, 'read'); ?>
    <div class="box no-border">
        <div class="box-header with-border">
            <h3 class="box-title">Details View</h3>
        </div>
        <table class="table table-striped">
	    <tr><td width="150">User Name</td><td width="5">:</td><td><?php echo getUserName( $user_id ) ; ?></td></tr>
	    <tr><td width="150">Login Time</td><td width="5">:</td><td><?php echo globalDateTimeFormat($login_time); ?></td></tr>
	    <tr><td width="150">Logout Time</td><td width="5">:</td><td><?php echo globalDateTimeFormat($logout_time); ?></td></tr>
	    <tr><td width="150">Ip</td><td width="5">:</td><td><?php echo $ip; ?></td></tr>
	    <?php /* <tr><td width="150">Location</td><td width="5">:</td><td><?php echo $location; ?></td></tr> */?>
	    <tr><td width="150">Browser</td><td width="5">:</td><td><?php echo $browser; ?></td></tr>
	    <tr><td width="150">Device</td><td width="5">:</td><td><?php echo $device; ?></td></tr>
	    <tr><td></td><td></td><td><a href="<?php echo site_url( Backend_URL .'login_history') ?>" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> Back</a>
                    </td></tr>
	</table>
	</div></section>