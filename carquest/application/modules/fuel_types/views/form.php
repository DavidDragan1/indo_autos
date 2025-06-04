<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<section class="content-header">
    <h1> Fuel Types  <small><?php echo $button ?></small> <a href="<?php echo site_url( Backend_URL . 'fuel_types') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL; ?>/fuel_types">Fuel Types</a></li>
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
                    <label for="fuel_name" class="col-sm-2 control-label">Fuel Name :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="fuel_name" id="fuel_name" placeholder="Fuel Name" value="<?php echo $fuel_name; ?>" />
                        <?php echo form_error('fuel_name') ?>
                    </div>
                </div>
	<div class="col-md-12 text-right">    
            <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url( Backend_URL . 'fuel_types') ?>" class="btn btn-default">Cancel</a>
	</div></form>
	</div></div></section>