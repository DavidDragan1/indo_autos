<h2 class="breadcumbTitle">Notifications</h2>
<!-- cars-area start -->
<h5 class="notification-note"><strong>Notification Settings :</strong> (Be the first to know when your
    prefered product
    is posted on )</h5>
<div class="card-wrap-style-two">
    <h3 class="card-header-withbtn">My Notifications <button data-toggle="modal"
                                                             data-target="#notificationAdd" class="header-btn">Add Notifications</button>
    </h3>
    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Vehicle</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Location</th>
                <th>Year</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $count = $this->input->get('start');
            $count = $count + 1;
            foreach($notifications as $notification ) : ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><strong><?php echo GlobalHelper::getProductTypeById($notification->type_id); ?></strong> </td>
                <td><?php echo GlobalHelper::getBrandNameById($notification->brand_id); ?>
                    <?php if($notification->parts_description) :  ?>
                        <br> Parts: <?php  echo GlobalHelper::getParts_description($notification->parts_description); ?>
                    <?php endif; ?></td>
                <td><?php echo GlobalHelper::getBrandNameById($notification->model_id); ?></td>
                <td><?php echo GlobalHelper::getLocationById($notification->location_id); ?></td>
                <td><?php echo $notification->year; ?></td>
                <td>
                    <ul class="actionsbtn">
                        <li><a href="admin/delete-notification/<?php echo $notification->id; ?>"
                               onclick="javasciprt: return confirm('Do you really want to delete this item?')"><i class="fa fa-trash"></i></a></li>
                    </ul>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        if (count($notifications) == 0) {
            echo '<p class="alert alert-warning">Sorry! You do not have any listing.</p>';
        } else {
            echo $pagination;
        }
        ?>
    </div>
</div>
<!-- cars-area end -->

<div class="modal fade modalWrapper" id="notificationAdd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <form class="row" method="post" action="admin/add-notification">
                <div class="col-12 text-center">
                    <h3 class="title-add-car">Notification add</h3>
                </div>
                <div class="col-md-6 col-12">
                    <label class="input-label">Vehicle</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="type_id" id="type_id" onChange="vehicle_change(this.value);">
                            <?php echo GlobalHelper::getDropDownVehicleType(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label class="input-label"> Brand</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="brand_id" id="brand_id" onChange="get_model(this.value);">
                            <?php echo GlobalHelper::get_brands_by_vechile(0, 0); ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <label class="input-label"> Model</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="model_id" id="model_id">
                            <option value="" disabled selected>Model</option>
                            <?php  echo GlobalHelper::get_brands_by_vehicle_model(0, 0);   ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <label class="input-label"> Location</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="location_id" id="location_id">
                            <?php echo GlobalHelper::all_location(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <label class="input-label"> Years</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="year" id="year">
                            <option value="">Please Select</option>
                            <?php echo numericDropDown(2000, date('Y'), 1, 0); ?>
                        </select>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button class="btn-wrap btn-big float-none"> Set Alert</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    var $ = jQuery;

    function delete_notification( id ){
        jQuery.ajax({
            url: 'my_account/delete_notification',
            type: "POST",
            dataType: 'json',
            data: { id: id },
            success: function ( jsonRespond ) {
                if( jsonRespond.Status === 'OK'){
                    jQuery('#response').html( jsonRespond.Msg );
                    setTimeout(function(){
                        location.href = 'my_account?tab=notifications';
                    }, 1000);
                } else {
                    jQuery('.formresponse').html( jsonRespond.Msg );
                }
            }
        });

    }

    $("#type_id").change(function(){
        var type_id = jQuery(this).val();
        if(type_id  == 4){
            $('.spare_parts').slideDown();
            $('#parts_description').load('parts/parts_frontview/get_parts_description2/');
        } else{
            $('.spare_parts').slideUp();
        }

    });

    function vehicle_change(vehicle_type_id) {
        jQuery.ajax({
            url: 'brands/brands_frontview/get_brands_by_vechile?type_id='+vehicle_type_id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                jQuery('#brand_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#brand_id').html(response);
            }
        });
    }

    function get_model(id) {
        var vehicle_type_id = $('#type_id').val();

        jQuery.ajax({
            url: 'brands/brands_frontview/brands_by_vehicle_model?type_id='+vehicle_type_id+'&brand_id='+id,
            type: "GET",
            dataType: "text",
            data: {id: id, vehicle_type_id: vehicle_type_id},
            beforeSend: function () {
                jQuery('#model_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#model_id').html(response);
            }
        });
    }

</script>
