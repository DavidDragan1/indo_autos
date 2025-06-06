<style>
    .text-primary{
        color: #007bff!important;
    }
</style>
<div class="row">
    <div class="col-12 mb-20">
        <ul class="table-header d-flex flex-wrap align-items-center justify-content-end">
            <li class="short-search d-flex align-items-center mr-20">
                <span>Mark Selected as:</span>
                <select name="status" id="status" class="browser-default">
                    <option value="Pending">Pending</option>
                    <option value="Verified">Verified</option>
                    <option value="Rejected">Rejected</option>
                    <option value="Accepted">Accepted</option>
                </select>
                <button  type="button" id="change-status">Done</button>
            </li>
            <li class="short-search d-flex align-items-center">
                <span>Sort by:</span>
                <select name="order" id="order" class="browser-default">
                    <option value="DESC" <?=@$_GET['order'] == 'DESC' ? 'selected' : ''?>>New Requests</option>
                    <option value="ASC" <?=@$_GET['order'] == 'ASC' ? 'selected' : ''?>>Old Requests</option>
                </select>
            </li>
        </ul>
    </div>
    <div class="col-12">
        <div class="bg-white br-5 shadow p-30 mb-30">
            <table id="databale" class="table-wrapper">
                <thead>
                <tr>
                    <th class="all">
                        <label class="checkbox-style checkbox-style-small d-inline-flex">
                            <input type="checkbox" class="filled-in checkedAll" />
                            <span class="h-20"></span>
                        </label>
                        Name
                    </th>
                    <th class="desktop desktop-1">Type</th>
                    <th class="desktop desktop-1">Request Date</th>
                    <th class="desktop desktop-1">Shipped Date</th>
                    <th class="desktop desktop-1">Status</th>
                    <th class="desktop desktop-1">Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($recentRequest as $history) :
                    $class = '';
                    if ($history->status == 'Pending'){
                        $class = 'text-primary';
                    } elseif ($history->status == 'Verified'){
                        $class = 'text-success';
                    } elseif ($history->status == 'Rejected'){
                        $class = 'text-danger';
                    } else {
                        $class = 'text-info';
                    }
                    ?>
                    <tr <?php if ($history->is_read == 0):?> style="background: #ededed" <?php endif;?>>
                        <td>
                            <label class="checkbox-style checkbox-style-small d-inline-flex">
                                <input type="checkbox" value="<?=$history->id?>" class="filled-in checkSingle" />
                                <span class="h-20"></span>
                            </label>
                            <a class="fw-500 modal-trigger" href="#customerDetails<?=$history->id?>" onclick="changeReadStatus(<?php echo $history->id;?>,<?php echo $history->is_read;?>)"><?=GlobalHelper::getBrandNameById($history->brand_id).' '.GlobalHelper::getModelNameById($history->model_id).' '.$history->manufacture_year?></a>
                        </td>
                        <td><?=GlobalHelper::getVehicleNamebyId($history->vehicle_type_id)?></td>
                        <td><?=date('j/n/y', strtotime($history->request_date))?></td>
                        <td><?=$history->verification_date ? date('j/n/y', strtotime($history->verification_date)):'-'?></td>
                        <td class="fw-500  <?php echo $class; ?>"><?=$history->status?></td>
                        <td class="fw-500 color-theme"><?=GlobalHelper::getPrice($history->amount, 0, 'NGR')?>
                            <?php if ($history->is_read == 0):?>
                                <span style="color: #999;font-size: 10px;">new</span>
                            <?php endif;?>
                        </td>

                    </tr>
                    <div id="customerDetails<?=$history->id?>" class="modal modal-wrapper" style="min-height: 80%;min-width: 700px" >
                        <span class="material-icons modal-close">close</span>
                        <h4 class="fs-18 fw-500 ">Request Details</h4>
                        <p class="mb-15">Vehicle ID:#<?php echo $history->post_id;?></p>
                        <div class="customer_details-wrap d-flex flex-wrap">
                            <div class="customer_details-img">
                                <?=GlobalHelper::getPostFeaturedPhoto($history->post_id, 'featured', null, '','Don\'t Need')?>
                            </div>
                            <ul class="customer_details-list">
                                <li>
                                    <span>Amount</span>
                                    <h4 class="fs-16 fw-500 color-theme mb-0"><?=GlobalHelper::getPrice($history->amount, 0, 'NGR')?></h4>
                                </li>
                                <li>
                                    <span class="d-block">Status</span>
                                    <span class="<?php echo $class; ?> color-white br-5"><?=$history->status?></span>
                                </li>
                                <li>
                                    <span>Client Name</span>
                                    <h4 class="fs-16 fw-500 mb-0"><?=$history->client_name?></h4>
                                </li>
                                <li>
                                    <span>Brand</span>
                                    <h4 class="fs-16 fw-500 mb-0"><?=GlobalHelper::getBrandNameById($history->brand_id)?></h4>
                                </li>
                                <li class="email">
                                    <span>Email</span>
                                    <h4 class="fs-16 fw-500 mb-0"><?=$history->client_email?></h4>
                                </li>
                                <li>
                                    <span>Condition</span>
                                    <h4 class="fs-16 fw-500 mb-0"><?=$history->vehicle_condition?></h4>
                                </li>
                                <li>
                                    <span>Request Date</span>
                                    <h4 class="fs-16 fw-500 mb-0"><?=$history->request_date ? date('j/n/y', strtotime($history->request_date)):'-'?></h4>
                                </li>
                                <li>
                                    <span>Model</span>
                                    <h4 class="fs-16 fw-500 mb-0"><?php echo GlobalHelper::getModelNameById($history->model_id); ?></h4>
                                </li>
                                <li>
                                    <span>Verified Date</span>
                                    <h4 class="fs-16 fw-500 mb-0"><?=$history->verification_date ? date('j/n/y', strtotime($history->verification_date)):'-'?></h4>
                                </li>
                                <li>
                                    <span>Year</span>
                                    <h4 class="fs-16 fw-500 mb-0"><?=$history->manufacture_year?></h4>
                                </li>
                                <li>
                                    <span>Dealer's Phone</span>
                                    <h4 class="fs-16 fw-500 mb-0"><?=$history->dellers_phone?></h4>
                                </li>
                                <li>
                                    <span>Vehicle's Location</span>
                                    <h4 class="fs-16 fw-500 mb-0"><?=$history->address.', '.GlobalHelper::getLocationById($history->location_id).', '.getCountryName($history->country_id)?></h4>
                                </li>
                            </ul>
                        </div>
                    </div>

                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?=$pagination?>
    </div>
</div>

<script type="text/javascript" src="assets/new-theme/js/dataTables.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/datatable.responsive.min.js"></script>
<script>
    var params = JSON.parse('<?=json_encode((object) $this->input->get())?>');
    $(document).ready(function () {
        $('#databale').dataTable({
            bProcessing: false,
            sAutoWidth: false,
            bDestroy: false,
            iDisplayStart: 10,
            iDisplayLength: 10,
            bPaginate: false,
            bFilter: false,
            bInfo: false,
            responsive: true,
            order : []
        });
        $('.checkedAll').change(function () {
            if (this.checked) {
                $('.checkSingle').each(function () {
                    this.checked = true;
                });
            } else {
                $('.checkSingle').each(function () {
                    this.checked = false;
                });
            }
        });

        $('.checkSingle').click(function () {
            if ($(this).is(':checked')) {
                var isAllChecked = 0;
                $('.checkSingle').each(function () {
                    if (!this.checked) isAllChecked = 1;
                });
                if (isAllChecked == 0) {
                    $('.checkedAll').prop('checked', true);
                }
            } else {
                $('.checkedAll').prop('checked', false);
            }
        });

        $('#order').on('change', function () {
            params.order = $(this).val();
            var paramString = new URLSearchParams(params).toString();
            window.location.href = 'admin/verifier/all_request?'+paramString;
        })

        $('#change-status').on('click', function () {
            var id = '';
            var status = $('#status').val();
            if (!status){
                tosetrMessage('error', 'Please Select Status')
                return false;
            } else {
                $(":checkbox:checked").each(function () {
                    id += $(this).val() + "|";
                });
                if (id === ''){
                    tosetrMessage('error', 'Please Select a Row')
                } else {
                    $.ajax({
                        type: "post",
                        url: "admin/verifier/status-change",
                        data: {id, status},
                        success: function (res) {
                            res = JSON.parse(res)
                            if (res.status == 'success'){
                                tosetrMessage('success', res.message);
                                setTimeout(function () {
                                    window.location.reload()
                                }, 500)
                            }  else {
                                tosetrMessage('error', res.message)
                            }

                        }
                    })
                }
            }


        })
    });

</script>
