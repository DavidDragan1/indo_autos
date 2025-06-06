<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>Mails  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url( Backend_URL .'mails' )?>">Mails</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Single View</h3>
        </div>
        <table class="table table-striped">
	    <tr><td width="150">Parent Id</td><td width="5">:</td><td><?php echo $parent_id; ?></td></tr>
	    <tr><td width="150">Sender Id</td><td width="5">:</td><td><?php echo $sender_id; ?></td></tr>
	    <tr><td width="150">Reciever Id</td><td width="5">:</td><td><?php echo $reciever_id; ?></td></tr>
	    <tr><td width="150">Subject</td><td width="5">:</td><td><?php echo $subject; ?></td></tr>
	    <tr><td width="150">Body</td><td width="5">:</td><td><?php echo $body; ?></td></tr>
	    <tr><td width="150">Status</td><td width="5">:</td><td><?php echo $status; ?></td></tr>
	    <tr><td width="150">Important</td><td width="5">:</td><td><?php echo $important; ?></td></tr>
	    <tr><td width="150">Log</td><td width="5">:</td><td><?php echo $log; ?></td></tr>
	    <tr><td width="150">Created</td><td width="5">:</td><td><?php echo $created; ?></td></tr>
	    <tr><td width="150">Folder Id</td><td width="5">:</td><td><?php echo $folder_id; ?></td></tr>
	    <tr><td></td><td></td><td><a href="<?php echo site_url( Backend_URL .'mails') ?>" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> Back</a><a href="<?php echo site_url( Backend_URL .'mails/update/'.$id ) ?>" class="btn btn-primary"> <i class="fa fa-edit"></i> Edit</a></td></tr>
	</table>
	</div></section>