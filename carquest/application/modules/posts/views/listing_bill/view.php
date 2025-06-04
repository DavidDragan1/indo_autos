<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>Bill  <small>Preview</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'listing_package') ?>">Listing_package</a></li>
        <li class="active">Preview</li>
    </ol>
</section>

<section class="content">       
    <div class="box box-primary">
        
        <table class="table table-striped">
            <tr><td width="150"><h3>Listing id</h3></td><td width="5"><h3>:</h3></td><td><h3>#<?php echo $listing_id; ?></h3></td></tr>
            <tr><td width="150">Package Id</td><td width="5">:</td><td><?php echo $package_id; ?></td></tr>
            <tr><td width="150">Payment Status</td><td width="5">:</td><td><?php echo $payment_status; ?></td></tr>
            <tr><td width="150">Price</td><td width="5">:</td><td><?php echo $price; ?></td></tr>
            <tr><td width="150">Payment Method</td><td width="5">:</td><td><?php echo $payment_method; ?></td></tr>
            <tr><td width="150">Payment Details</td><td width="5">:</td><td><?php echo $payment_details; ?></td></tr>
            <tr><td width="150">Status</td><td width="5">:</td><td><?php echo $status; ?></td></tr>
            <tr><td width="150">Created</td><td width="5">:</td><td><?php echo $created; ?></td></tr>
            <tr><td width="150">Modified</td><td width="5">:</td><td><?php echo $modified; ?></td></tr>
            <tr><td></td><td></td><td><a href="<?php echo site_url(Backend_URL . 'posts/bill') ?>" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> Back</a></td></tr>
        </table>
    </div></section>