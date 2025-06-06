<h2 class="breadcumbTitle">Bill Preview </h2>
<!-- Bill Preview  start  -->
<ul class="bill-preview-items">
    <li><strong class="left">Listing id</strong> <strong>#<?php echo $listing_id; ?></strong></li>
    <li><span class="left">Package Id </span> <span><?php echo $package_id; ?></span></li>
    <li><span class="left">Payment Status </span> <span><?php echo $payment_status; ?></span></li>
    <li><span class="left">Price </span> <span><?php echo $price; ?></span></li>
    <li><span class="left">Payment Method </span> <span><?php echo $payment_method; ?></span></li>
    <li><span class="left">Payment Details </span><span><?php echo $payment_details; ?></span></li>
    <li><span class="left">Status</span> <span><?php echo $status; ?></span></li>
    <li><span class="left">Created </span> <span><?php echo $created; ?></span></li>
    <li><span class="left">Modified </span> <span><?php echo $modified; ?></span></li>
</ul>
<div class="row">
    <div class="col-lg-2">
        <a class="btn-wrap" href="<?php echo site_url(Backend_URL . 'posts/bill') ?>"> Back</a>
    </div>
</div>
