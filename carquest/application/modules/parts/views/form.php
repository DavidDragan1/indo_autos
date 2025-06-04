<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Parts Description  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/parts') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/parts_description">Parts Description</a></li>
        <li class="active">Update</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Update Parts Description</h3>
        </div>
        
        <div class="box-body">
        <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
            <div class="form-group">
                <label for="name" class="col-md-2 control-label">Name :</label>
                <div class="col-md-10">                    
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />
                    <?php echo form_error('name') ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="parent_id" class="col-md-2 control-label">Vehicle Type :</label>
                <div class="col-md-10">                  
                        <?php echo parts_for_checkbox($parent_id); ?>                   
                </div>
            </div>
            <div class="col-md-12 text-right">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                <a href="<?php echo site_url('admin/parts') ?>" class="btn btn-default">Cancel</a>
            </div>
        </form>
	</div></div></section>