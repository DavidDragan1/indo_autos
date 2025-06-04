<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h2 class="breadcumbTitle">All Advert</h2>
<!-- advert-area start  -->
<div class="datatable-responsive">
    <div class="datatable-header">
        <a class="btn-wrap" href="<?php echo Backend_URL; ?>posts/create">Add New</a>
        <form action="<?php echo site_url( Backend_URL .'posts/'); ?>" class="form-inline" method="get" id="search_form">
            <input type="text" class="search" name="q" placeholder="Search By Title" value="<?php echo $q; ?>" id="search"
               onchange="search()">
        </form>
    </div>
    <form method="POST" id="all_posts_select">
        <table id="advert" class="datatable-wrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th></th>
                <th>Photo</th>
                <th>Short Details</th>
                <th>Expired at</th>
                <th>Total View</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
            <tbody>
            <?php foreach ($posts as $post) { ?>
                <tr>
                    <td>
                        <input class="styled-checkbox" id="<?php echo $post->id; ?>" type="checkbox" name="post_id[]" value="<?php echo $post->id; ?>">
                        <label for="<?php echo $post->id; ?>"><?php echo $post->id; ?></label>
                    </td>
                    <td><?php echo GlobalHelper::getPostFeaturedPhoto($post->id, 'tiny', '', 'image'); ?></td>
                    <td>
                        <ul class="short-details-item">
                            <li>
                                <strong>Vehicle Type: </strong>
                                <?php echo getTagName('vehicle_types', 'name', $post->vehicle_type_id); ?>
                            </li>
                            <li>
                                <strong>Listing Type: </strong>
                                <?php echo $post->advert_type ?>
                            </li>
                            <li>
                                <?php echo getPackageName($post->package_id); ?>
                            </li>
                        </ul>
                    </td>
                    <td><?php echo globalDateFormat($post->expiry_date); ?></td>
                    <td><?php echo $post->hit; ?></td>
                    <td><?php echo GlobalHelper::newSwitchStatus($post->status); ?></td>
                    <td>
                        <ul class="actions">
                            <li><a href="<?php echo site_url('post/' . $post->post_slug); ?>" target="_blank"><img
                                        src="assets/theme/new/images/backend/icons/view.svg" alt="image"></a></li>
                            <li><a href="<?php echo site_url('admin/posts/update_general/' . $post->id); ?>"><img
                                        src="assets/theme/new/images/backend/icons/edit.svg" alt="image"></a></li>
                            <li><a href="<?php echo site_url('admin/posts/delete/' . $post->id); ?>"
                                   onclick="javasciprt: return confirm('Are You Sure ?')"><img
                                        src="assets/theme/new/images/backend/icons/delete.svg" alt="image"></a></li>
                        </ul>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php
        if (count($posts) == 0) {
            echo '<p class="alert alert-warning">Sorry! You do not have any listing.</p>';
        }
        ?>
        <div id="ajax_respond" class="text-center"></div>
        <?php echo $pagination; ?>
        <div class="row">
            <div class="col-lg-2">
                <div class="mark-all-wrap">
                    <input class="styled-checkbox" type="checkbox" name="checkall" onclick="checkedAll();" id="markall">
                    <label for="markall">Mark all</label>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="datatable-footer">
                    <select class="datatable-footer-select" name="action" onchange="setExpireDate(this.value)"
                            id="bulk">
                        <option value="0">--Bulk Action--</option>
                        <option value="Sold">Mark as Sold</option>
                        <option value="Delete">Delete</option>
                    </select>
                    <p class="btn-wrap">Total Record <?php echo $total_rows; ?></p>
                </div>
            </div>
        </div>
    </form>
</div>

<?php load_module_asset('posts', 'js'); ?>

<script>
    jQuery(document).ready(function () {
        var table = jQuery('#advert').DataTable({
            "paginate": false,
            "searching": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": false,
            "responsive": false,
            'select': {
                'style': 'multi'
            },
            'order': [
                [1, 'asc']
            ]
        });
    });
</script>

<script type="text/javascript">

    function search() {
        jQuery('search_form').submit();
    }

    jQuery('#bulk').on('click', function(){
        if (jQuery('#bulk').val() == 0) {
            return ;
        }

        var formData = jQuery('#all_posts_select').serialize();

        jQuery.ajax({
            url: 'admin/posts/bulk_action',
            type: "POST",
            dataType: "json",
            data: formData,
            beforeSend: function () {
                jQuery('#ajax_respond').html('<p class="ajax_processing">Loading....</p>');
            },
            success: function (jsonRepond ) {
                if(jsonRepond.Status === 'OK'){
                    jQuery('#ajax_respond').html( jsonRepond.Msg );
                    setTimeout(function() {
                            jQuery('#ajax_respond').fadeOut();
                            location.reload();},
                        2000);

                } else {
                    jQuery('#ajax_respond').html( jsonRepond.Msg );
                }
            }
        });

    });

</script>


