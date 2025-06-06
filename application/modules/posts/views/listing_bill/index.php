<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Listing Bill  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Event Listing</li>
        <li class="active">Bill</li>
    </ol>
</section>

<section class="content">       
    <div class="box box-primary">            
        <div class="box-body">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th width="40">#</th>
                            <th width="100">Created</th>
                            <th>Listing ID</th>
                            <th>Service Name</th>
                            <th>User Name</th>
                            <th>Package</th>                            
                            <th class="text-right">Price</th>
                            <th width="120">Payment Status</th>
                            <th width="130">Paid Date</th>
                            <th width="200">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                        if(count($listing_bill_data) == false){
                            echo '<tr><td colspan="9"><p class="ajax_notice">No Record Found</p></td></tr>';
                        }

                        foreach ($listing_bill_data as $listing_bill) {
                            $payment_status = $listing_bill->payment_status;
                            if($payment_status == 'Unpaid') {
                                $paid_link = anchor(site_url(Backend_URL . 'posts/bill/update/' . $listing_bill->id), '<i class="fa fa-fw fa-external-link"></i> Mark as Paid', 'class="btn btn-xs btn-primary"');
                            } else {
                                $paid_link = '';
                            }
                            ?>
                            <tr>
                               <td><?php echo $listing_bill->listing_id ?></td>
                                <td><?php echo globalDateFormat($listing_bill->created) ?></td>
                                <td><?php echo $listing_bill->id ?></td>
                                <td><?php echo serviceName($listing_bill->listing_id) //listingName($listing_bill->id) ?></td>
                                <td><?php echo getUserNameByUserId($listing_bill->user_id) ?></td>
                                <td><?php echo getPackageNameNew($listing_bill->package_id ) ?></td>
                                
                                <td class="text-right"><?php echo globalCurrencyFormatPackageNew($listing_bill->price) ?></td>
                                <td><?php echo $listing_bill->payment_status ?></td>
                                <!-- td><?php echo $listing_bill->payment_method ?></td -->  
                                <td><?php echo globalDateTimeFormat($listing_bill->modified) ?></td>
                                <td>
                                    <?php echo anchor(site_url(Backend_URL . 'posts/bill/preview/' . $listing_bill->id), '<i class="fa fa-fw fa-external-link"></i> Preview', 'class="btn btn-xs btn-default"'); ?>
                                    <!--<button class="btn btn-xs btn-primary" onclick="return confirm('Are You Sure?');">Mark as Paid</button>-->
                                    <?php echo $paid_link; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="row">                
                <div class="col-md-6">
                    <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>                
            </div>
        </div>
    </div>
</section>