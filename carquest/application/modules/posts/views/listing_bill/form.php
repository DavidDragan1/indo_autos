<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Listing_package  <small><?php echo $button ?></small> <a href="<?php echo site_url( Backend_URL .'listing_bill') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>listing_package">Listing_package</a></li>
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
                    <label for="listing_id" class="col-sm-2 control-label">Listing Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="listing_id" id="listing_id" placeholder="Listing Id" value="<?php echo $listing_id; ?>" />
                        <?php echo form_error('listing_id') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="package_id" class="col-sm-2 control-label">Package Id :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="package_id" id="package_id" placeholder="Package Id" value="<?php echo $package_id; ?>" />
                        <?php echo form_error('package_id') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="payment_status" class="col-sm-2 control-label">Payment Status :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="payment_status" id="payment_status" placeholder="Payment Status" value="<?php echo $payment_status; ?>" />
                        <?php echo form_error('payment_status') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="price" class="col-sm-2 control-label">Price :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="price" id="price" placeholder="Price" value="<?php echo $price; ?>" />
                        <?php echo form_error('price') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="payment_method" class="col-sm-2 control-label">Payment Method :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="payment_method" id="payment_method" placeholder="Payment Method" value="<?php echo $payment_method; ?>" />
                        <?php echo form_error('payment_method') ?>
                    </div>
                </div>
	    <div class="form-group">        
                    <label for="payment_details" class="col-sm-2 control-label">Payment Details :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="payment_details" id="payment_details" placeholder="Payment Details"><?php echo $payment_details; ?></textarea>
                        <?php echo form_error('payment_details') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" />
                        <?php echo form_error('status') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="created" class="col-sm-2 control-label">Created :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="created" id="created" placeholder="Created" value="<?php echo $created; ?>" />
                        <?php echo form_error('created') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="modified" class="col-sm-2 control-label">Modified :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="modified" id="modified" placeholder="Modified" value="<?php echo $modified; ?>" />
                        <?php echo form_error('modified') ?>
                    </div>
                </div>
	<div class="col-md-12 text-right">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url( Backend_URL .'listing_bill') ?>" class="btn btn-default">Cancel</a>
	</div></form>
	</div></div></section>