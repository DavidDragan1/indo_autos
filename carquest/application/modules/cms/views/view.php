<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>Cms  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/cms">Cms</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Single View</h3>
        </div>
        <table class="table table-striped">
	    <tr><td width="150">User Id</td><td width="5">:</td><td><?php echo $user_id; ?></td></tr>
	    <tr><td width="150">Parent Id</td><td width="5">:</td><td><?php echo $parent_id; ?></td></tr>
	    <tr><td width="150">Post Type</td><td width="5">:</td><td><?php echo $post_type; ?></td></tr>
	    <tr><td width="150">Menu Name</td><td width="5">:</td><td><?php echo $menu_name; ?></td></tr>
	    <tr><td width="150">Post Title</td><td width="5">:</td><td><?php echo $post_title; ?></td></tr>
	    <tr><td width="150">Post Url</td><td width="5">:</td><td><?php echo $post_url; ?></td></tr>
	    <tr><td width="150">Content</td><td width="5">:</td><td><?php echo $content; ?></td></tr>
	    <tr><td width="150">Seo Title</td><td width="5">:</td><td><?php echo $seo_title; ?></td></tr>
	    <tr><td width="150">Seo Keyword</td><td width="5">:</td><td><?php echo $seo_keyword; ?></td></tr>
	    <tr><td width="150">Seo Description</td><td width="5">:</td><td><?php echo $seo_description; ?></td></tr>
	    <tr><td width="150">Thumb</td><td width="5">:</td><td><?php echo $thumb; ?></td></tr>
	    <tr><td width="150">Template</td><td width="5">:</td><td><?php echo $template; ?></td></tr>
	    <tr><td width="150">Created</td><td width="5">:</td><td><?php echo $created; ?></td></tr>
	    <tr><td width="150">Modified</td><td width="5">:</td><td><?php echo $modified; ?></td></tr>
	    <tr><td width="150">Status</td><td width="5">:</td><td><?php echo $status; ?></td></tr>
	    <tr><td width="150">Page Order</td><td width="5">:</td><td><?php echo $page_order; ?></td></tr>
	    <tr><td></td><td></td><td><a href="<?php echo site_url('cms') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
	</div></section>