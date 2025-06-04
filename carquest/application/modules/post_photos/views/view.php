<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>Post_photos  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/post_photos">Post_photos</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Single View</h3>
        </div>
        <table class="table table-striped">
	    <tr><td width="150">Post Id</td><td width="5">:</td><td><?php echo $post_id; ?></td></tr>
	    <tr><td width="150">Photo</td><td width="5">:</td><td><?php echo $photo; ?></td></tr>
	    <tr><td width="150">Featured</td><td width="5">:</td><td><?php echo $featured; ?></td></tr>
	    <tr><td></td><td></td><td><a href="<?php echo site_url('post_photos') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
	</div></section>