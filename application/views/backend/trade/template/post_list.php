<!-- All Adverts  -->
<div class="bg-white br-5 p-30 mb-50 products-statistics-wrap">
    <form method="POST" id="all_posts_select" action="admin/posts/change_status">
    <div class="card-top d-flex align-items-center flex-wrap justify-content-between mb-20">
        <h2 class="fs-18 fw-500 color-seconday mb-0">All Adverts</h2>
        <ul class="table-header d-flex flex-wrap align-items-center justify-content-end ">
            <li class="short-search d-flex flex-wrap align-items-center">
                <span>Mark Selected as:</span>
                <select name="mark_as" class="browser-default">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Sold">Sold</option>
                </select>
                <button type="submit">Done</button>
                <button type="button" id="delete_post" class="bg-danger">Delete</button>
            </li>
            <li class="short-search d-flex align-items-center ml-10">
                <span>Filter By:</span>
                <select  class="browser-default" onchange="sortFilter(this.value)">
                    <option <?php echo $sortValue === 'All' ? 'selected' :''?> value="All">All</option>
                    <option <?php echo $sortValue === 'Active' ? 'selected' :''?> value="Active">Active</option>
                    <option <?php echo $sortValue === 'Sold' ? 'selected' :''?> value="Sold">Sold</option>
                    <option <?php echo $sortValue === 'Pending' ? 'selected' :''?> value="Pending">Pending</option>
                    <option <?php echo $sortValue === 'Inactive' ? 'selected' :''?> value="Inactive">Inactive</option>
                </select>
            </li>
            <!-- <li class="search-toggle"><span class="material-icons">search</span></li> -->
        </ul>
    </div>

    <table id="all_adverts" class="table-wrapper ">
        <thead>
        <tr>
            <th class="all">
                <label class="checkbox-style checkbox-style-small d-inline-flex">
                    <input type="checkbox" class="filled-in checkedAll" />
                    <span class="h-20"></span>
                </label>
                Name
            </th>
            <th class="desktop desktop-1">Vehicle Type</th>
            <th class="desktop desktop-1">Type</th>
            <th class="desktop">Impressions</th>
            <th class="mobile">Views</th>
            <th class="desktop">Date Posted</th>
            <th class="desktop">Date Sold</th>
            <th class="desktop desktop-1">Status</th>
            <th>Amount</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($posts as $key => $post) {
            $text = 'success';
            if ($post->status == 'Active'){
                $text = 'info';
            } elseif ($post->status == 'Inactive'){
                $text = 'danger';
            } elseif ($post->status == 'Pending'){
                $text = 'warning';
            } else {
                $text = 'success';
            }
            ?>
        <tr>
            <td>
                <div class="d-flex align-items-center">
                    <label class="checkbox-style checkbox-style-small d-inline-flex">
                        <input id="<?php echo $post->id; ?>" type="checkbox" name="post_id[]" value="<?php echo $post->id; ?>" class="filled-in checkSingle" />
                        <span class="h-20"></span>
                    </label>
                    <div>
                        <?php if ($post->advert_type == 'Paid' && $post->status == 'Active'):?>
                            <!--                        <label style="padding: 0;margin0;display: flex;font-size: 9px;color: #f05c26;" for=""></label>-->
                            <div>
                                <span style="padding: 2px 5px;line-height: 14px; min-height: 15px;font-size: 10px;min-width: 50px;" class="badge-wrap theme-badge ">promoted</span>
                            </div>
                        <?php endif;?>
                        <a class=" fw-500" href="post/<?=$post->post_slug?>"><?=$post->title?></a>
                    </div>
                </div>
            </td>
            <td><?php echo getTagName('vehicle_types', 'name', $post->vehicle_type_id); ?></td>
            <td><?php echo $post->post_type; ?></td>
            <td class="text-center"><?php echo $post->impressions;?></td>
            <td class="text-center"><?php echo $post->hit;?></td>
            <td><?php echo globalDateFormat($post->created); ?></td>
            <td><?php echo globalDateFormat($post->sold_date); ?></td>
            <td>
                <ul class="table-header d-flex align-items-center justify-content-start ">
                    <li class="short-search d-flex align-items-center">
                        <select  class="browser-default " onchange="changeIndividualPostStatus(<?php echo $post->id?>,this.value)">
                            <option <?php echo $post->status == 'Active' ? 'selected' : ''?> value="Active">Active</option>
                            <option <?php echo $post->status == 'Pending' ? 'selected' : ''?> value="Pending">Pending</option>
                            <option <?php echo $post->status == 'Sold' ? 'selected' : ''?> value="Sold">Sold</option>
                            <option <?php echo $post->status == 'Inactive' ? 'selected' : ''?> value="Inactive">Inactive</option>
                        </select>
                </li>
                </ul>
            </td>
            <td class="fw-500 color-theme"><?=GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein)?></td>
            <td>
                <div class="action">
                                    <span class="material-icons">
                                        more_vert
                                    </span>
                    <ul class="action-dropdown">
                        <li><a href="<?php echo site_url('admin/posts/repost_advert/'.$post->id)?>" onclick="return confirm('Are you want to Repost Advert?')">Repost Advert</a></li>
                        <li><a href="<?php echo site_url('admin/posts/trade-post-update/' . $post->id); ?>" >Edit</a> </li>
                        <?php if ($post->advert_type == 'Free' && $post->status == 'Active' || $post->status == 'Pending'):?>
                            <li><a onclick="selectPlan('<?php echo $post->id;?>')" href="">Promote</a></li>
                        <?php endif;?>
                        <li><a href="<?php echo site_url('admin/posts/delete/' . $post->id); ?>" onclick="alert('Are you want to delete?')">Delete</a> </li>
                    </ul>
                </div>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
        <?php echo $pagination; ?>
    </form>
    <div id="selectPlanModal" class="modal modal-wrapper small-modal-wrapper">
        <span class="material-icons modal-close">close</span>
        <div class="text-center">
            <img class="mb-15" src="assets/new-theme/images/icons/car4.svg" alt="">
            <h4 class="fw-500 fs-18 mb-10">Select a Plan</h4>
            <p class="fw-400 fs-14 mb-15">Choose a Plan that best fits your need</p>
            <div class="select-style">
                <select class="browser-default packageId">
                    <?php echo getPostPackages(0); ?>
                </select>
            </div>
            <input type="hidden" name="post_id_package" value="0">
            <button id="selectPlanAction" style="min-height: 35px;min-width: 100px;" class="btnStyle waves-effect">Proceed to
                Payment
            </button>
            <span class="fw-400 fs-14 d-block mt-15">You will be redirected to paystack</span>
        </div>
    </div>
</div>
<!-- All Adverts  -->
<script type="text/javascript" src="assets/new-theme/js/dataTables.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/datatable.responsive.min.js?t=<?php echo time(); ?>"></script>

<script>
    function selectPlan(postId){
        event.preventDefault()
        var planModal = $('#selectPlanModal');
        $('input[name="post_id_package"]').val(postId);
        planModal.modal('open');
    }
    $(document).on('click', '#selectPlanAction', function () {
        event.preventDefault();
        var packageId = $('.packageId').val();
        var post_id = $('input[name="post_id_package"]').val();

        jQuery.ajax({
            url: 'admin/posts/buy-post-package',
            type: "POST",
            dataType: "JSON",
            data: {
                packageId, post_id
            },
            success: function (response) {

                if (response.status === true){
                    tosetrMessage('success','Advert promoted successfully')
                }else{
                    tosetrMessage('error','Advert promoted Failed')
                }
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            }
        });
    })
    $(".checkedAll").change(function () {
        if (this.checked) {
            $(".checkSingle").each(function () {
                this.checked = true;
            })
        } else {
            $(".checkSingle").each(function () {
                this.checked = false;
            })
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;
            $(".checkSingle").each(function () {
                if (!this.checked)
                    isAllChecked = 1;
            })
            if (isAllChecked == 0) { $(".checkedAll").prop("checked", true); }
        } else {
            $(".checkedAll").prop("checked", false);
        }
    });

    $("#delete_post").on('click', function () {
        if(confirm("Are you sure you want to delete")){
            var posts = [];
            $('.checkSingle').each(function () {
                if (this.checked) posts.push(this.value);
            })
            if (posts.length !== 0){
                jQuery.ajax({
                    url: 'admin/posts/bulk_delete',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        ids : JSON.stringify(posts)
                    },
                    success: function (response) {

                        if (response.status === true){
                            tosetrMessage('success','The Selected Vehicles Deleted Successfully')
                        }else{
                            tosetrMessage('error','Something Went Wrong')
                        }
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                });
            } else {
                alert('Please Select A Vehicle')
            }
        }
    })
     
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
    function sortFilter(value) {
        var baseUrl = '<?php echo base_url();?>admin/posts?sortBy='+value;
        window.location.href = baseUrl;
        // var sortForm = $('#sort_form');
        // sortForm.attr('action',baseUrl);
        // $('#sort_input').val(value);
        // sortForm.submit();
    }
    function changeIndividualPostStatus(postId,value){

        $.ajax({
            url:'admin/posts/change_status/',
            method:'POST',
            dataType: 'json',
            data:{'post_id':[postId],'mark_as':value},
            success: function(response){
                if (response.msg == 'ok'){
                    tosetrMessage('success','Post status change successfully')
                }else{
                    tosetrMessage('error','Post status not change')
                }
                setTimeout(function () {
                    window.location.reload();
                },500);
            }
        })
    }
</script>
