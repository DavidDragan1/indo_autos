<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1> Modules  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/module') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/modules">Modules</a></li>
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
                    <label for="folder" class="col-sm-2 control-label">Folder :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="folder" id="folder" placeholder="Folder" value="<?php echo $folder; ?>" />
                        <?php echo form_error('folder') ?>
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
                    <label for="added_date" class="col-sm-2 control-label">Added Date :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="added_date" id="added_date" value="<?php echo date('Y-m-d H:i:s'); ?>" />
                        
                    </div>
                </div>
	    <div class="form-group">
                    <label for="order" class="col-sm-2 control-label">Order :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="order" id="order" placeholder="Order" value="<?php echo $order; ?>" />
                       
                    </div>
                </div>
	    <div class="form-group">
                    <label for="type" class="col-sm-2 control-label">Type :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="type" value="Module" />
                         
                    </div>
                </div>
	    
	    <div class="form-group">        
                    <label for="description" class="col-sm-2 control-label">Description :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description">Optional</textarea>                        
                    </div>
                </div>
	    <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="Enable" />
                        
                    </div>
                </div>
	<div class="col-md-12 text-right">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('admin/module') ?>" class="btn btn-default">Cancel</a>
	</div></form>
	</div></div></section>