<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1> Post_photos  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/post_photos') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/post_photos">Post_photos</a></li>
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
                    <label for="int" class="col-sm-2 control-label">Post Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="post_id" id="post_id" placeholder="Post Id" value="<?php echo $post_id; ?>" />
                        <?php echo form_error('post_id') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="varchar" class="col-sm-2 control-label">Photo :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="photo" id="photo" placeholder="Photo" value="<?php echo $photo; ?>" />
                        <?php echo form_error('photo') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="enum" class="col-sm-2 control-label">Featured :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="featured" id="featured" placeholder="Featured" value="<?php echo $featured; ?>" />
                        <?php echo form_error('featured') ?>
                    </div>
                </div>
	<div class="col-md-12 text-right">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('admin/post_photos') ?>" class="btn btn-default">Cancel</a>
	</div></form>
	</div></div></section>