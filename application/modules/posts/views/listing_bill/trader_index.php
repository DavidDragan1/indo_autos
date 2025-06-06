<h2 class="breadcumbTitle">Listing Bill </h2>
<!-- advert-area start  -->

<?php
$q = $this->input->get('q');
?>

<div class="datatable-responsive">
    <div class="datatable-header justify-content-end">
        <form method="get" action="admin/posts/bill/">
            <input type="text" class="search" placeholder="Search" name="q" value="<?php echo $q; ?>">
        </form>
    </div>
    <table id="advert" class="datatable-wrap" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th class="all">#</th>
            <th class="all">Created</th>
            <th class="all">Listing ID</th>
            <th class="all ">Service Name</th>
            <th class="mobile-l">User Name</th>
            <th class="mobile-l">Package</th>
            <th class="all">Price</th>
            <th class="mobile-l">Payment Status</th>
            <th class="desktop">Paid Date</th>
            <th class="all"> Action</th>
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
            $paid_link = "<a href=".site_url(Backend_URL . 'posts/bill/update/' . $listing_bill->id)." style='background: #f05c26; color: #fff; border-color: #f05c26;'>Mark as Paid</a>";
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
                <ul class="action-wrapper">
                    <li><a href="<?php echo site_url(Backend_URL . 'posts/bill/preview/' . $listing_bill->id); ?>">Preview</a></li>
                    <li><?php echo $paid_link ?></li>
                </ul>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
        if(count($listing_bill_data) != false){
            echo $pagination;
        }
        ?>
</div>
<!-- advert-area start  -->

<script>
    $(document).ready(function () {
        var table = $('#advert').DataTable({
            "language": {
                "paginate": {
                    "previous": '<i class="fa fa-angle-double-left" > </i>',
                    "next": '<i class="fa fa-angle-double-right" > </i>',
                },
            },
            "searching": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": false,
            "responsive": true,
            'select': {
                'style': 'multi'
            },
            'order': false
        });
    });
</script>