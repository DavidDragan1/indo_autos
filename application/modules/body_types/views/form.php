<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1> Body Types  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/body_types') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/body_types">Body Types</a></li>
        <li class="active">Update</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Update Record</h3>
        </div>
        
        <div class="box-body">
        <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
            <div class="form-group">
                <label for="vehicle_type" class="col-sm-2 control-label">Vehicle Type</label>
                <div class="col-sm-10">
                    <select class="form-control" name="vehicle_type" id="vehicle_type" placeholder="Vehicle Type">
                        <option <?php echo $vehicle_type == 'Car' ? 'selected' : ''; ?> value="Car">Car</option>
                        <option <?php echo $vehicle_type == 'Motorbike' ? 'selected' : ''; ?> value="Motorbike">Motorbike</option>
                    </select>
                </div>

            </div>
	    <div class="form-group">
                    <label for="type_name" class="col-sm-2 control-label">Type Name :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="type_name" id="type_name" placeholder="Type Name" value="<?php echo $type_name; ?>" />
                        <?php echo form_error('type_name') ?>
                    </div>
                </div>

	<div class="col-md-12 text-right">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('admin/body_types') ?>" class="btn btn-default">Cancel</a>
	</div></form>
	</div></div></section>