<!-- All Adverts  -->
<div class="bg-white br-5 p-30 mb-50 products-statistics-wrap">

        <div class="card-top d-flex align-items-center justify-content-between mb-20">
            <h2 class="fs-18 fw-500 color-seconday mb-0">Products</h2>
        </div>

        <table id="all_adverts" class="table-wrapper ">
            <thead>
            <tr>
                <th class="desktop desktop-1">Name</th>
                <th class="desktop desktop-1">Country</th>
                <th class="desktop desktop-1">State</th>
                <th class="desktop desktop-1">Amount</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $key => $post) {
                ?>
                <tr>
                    <td class="fw-500"><?=$post->title?></td>
                    <td><?php echo getCountryName($post->country_id); ?></td>
                    <td><?php echo GlobalHelper::getLocationById($post->location_id); ?></td>
                    <td class="fw-500 color-theme"><?=GlobalHelper::getPrice($post->amount, 0, 'NGR')?></td>
                    <td>
                        <div class="action">
                                    <span class="material-icons">
                                        more_vert
                                    </span>
                            <ul class="action-dropdown">
                                <li><a href="<?php echo site_url('admin/verifier/product_update/' . $post->id); ?>" >Update</a> </li>
                                <li><a href="<?php echo site_url('admin/verifier/product_delete/' . $post->id); ?>" onclick="alert('Are you want to delete?')">Delete</a> </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php echo $pagination; ?>
</div>
<!-- All Adverts  -->
<script type="text/javascript" src="assets/new-theme/js/dataTables.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/datatable.responsive.min.js?t=<?php echo time(); ?>"></script>

<script>
    $(document).ready(function () {
        $('#all_adverts').dataTable({
            bPaginate: false,
            bInfo : false,
            processing: false,
            searching: false,
            ordering: false,
            responsive: true,
            bSort: false,
            order: [0, 'asc'],
        });
    });
</script>
