<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1> Brands  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/brands') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL; ?>brands">Brands</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Update Brand Name</h3>
        </div>
        
        <div class="box-body">
        <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
            
            <div class="col-md-8 col-md-offset-2">
                 <div class="form-group">
                <label for="varchar">Brand Name</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" placeholder="Name" />
            </div>
                <div class="form-group">
                    <label for="slug">Brand slug</label>
                    <input type="text" class="form-control" name="slug" id="slug" value="<?php echo $slug; ?>" placeholder="slug" />
                </div>
            <div class="form-group">
                <label for="enum">Vehicle type</label>
                <?php echo vehicleTypeCheckBox($type_id); ?>
            </div>
	
            </div>
           
            <div class="col-md-8 col-md-offset-2  " style="padding: 0;">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('admin/brands') ?>" class="btn btn-default">Cancel</a>
	</div></form>
	</div></div></section>