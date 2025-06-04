<!-- .compare-area start  -->
<div class="compare-area bg-white ptb-75">
    <div class="container">
        <h1 class="fw-500 mb-20 fs-24"><?=$meta_title?></h1>
        <div class="compare_list-wrapper d-flex flex-wrap color-seconday">
            <?php if (!(empty($first_section) && empty($second_section) && empty($third_section))) {?>
            <ul class="compare_list-left">
                <li id="top_height"></li>
                <li>Pricing</li>
                <li>Overall Rating</li>
                <li>Vehicle Condition</li>
                <li>State</li>
                <li>Location</li>
                <li>Mileage</li>
                <li>Age</li>
                <li>Alloy Wheels</li>
                <li>Fuel Type</li>
                <li>Engine Size</li>
                <li>Body Type</li>
                <li>Transmission</li>
                <li>Seats</li>
                <li>Color</li>
                <li>Part Category</li>
                <li>Parts Description</li>
                <li>Parts For</li>
                <li>Owners</li>
                <li>Registration No</li>
                <li>Features</li>
            </ul>
            <?php } ?>
            <div class="compare_list-right d-flex flex-wrap-wrap">
                <div class="compare_list-wrap">
                    <?php if(empty($first_section)) : ?>
                        <a  href="javascript:void(0)" onclick="openModal('first')"
                                class="waves-effect add_vehicle-btn d-flex align-items-center justify-content-center bg-white w-100 mb-20 modal-trigger">
                            <span class="material-icons">add</span>Add a vehicle</a>
                    <?php else: ?>
                    <ul class="compare_list">
                        <li class="compare_list-top p-20">
                            <h4 class="fs-16 fw-500 mb-5">
                                <a class="color-theme" href="post/<?=$first_section->post_slug?>"><?=$first_section->title?></a>
                            </h4>
                            <p class="mb-10 color-seconday"><?=set_no_data('gear_box_type', $first_section); ?></p>
                            <?php echo GlobalHelper::getPostThumbPhotoById($first_section->id,$first_section->title,'w-100 obj-cover br-5')?>
                        </li>
                        <li class="price fs-24 fw-500 color-theme"><?=GlobalHelper::getPrice($first_section->priceinnaira, $first_section->priceindollar,$first_section->pricein)?></li>
                        <li class="rating"><a class="d-flex align-items-center" href="<?=!empty($first_section->car_review_slug) ? 'review/'.$first_section->car_review_slug : 'javascript:void(0)'?>"><span class="material-icons">stars</span> <?=!empty($first_section->car_review_rating) ? $first_section->car_review_rating : '0'?>/10</a></li>
                        <li><?=set_no_data('condition', $first_section); ?></li>
                        <li><?php echo GlobalHelper::getData($tbl = 'post_area', set_no_data('location_id', $first_section), $col = 'name'); ?></li>
                        <li><?php echo set_no_data('location', $first_section); ?></li>
                        <li><?php echo set_no_data('mileage', $first_section); ?></li>
                        <li><?php echo set_no_data('car_age', $first_section); ?></li>
                        <li><?php echo set_no_data('alloywheels', $first_section); ?></li>
                        <li><?php echo GlobalHelper::getData($tbl = 'fuel_types', set_no_data('fuel_id', $first_section), $col = 'fuel_name'); ?></li>
                        <li><?php echo GlobalHelper::getData($tbl = 'engine_sizes', set_no_data('enginesize_id', $first_section), $col = 'engine_size'); ?></li>
                        <li><?php echo GlobalHelper::getData($tbl = 'body_types', set_no_data('body_type', $first_section), $col = 'type_name'); ?></li>
                        <li><?php echo set_no_data('gear_box_type', $first_section); ?></li>
                        <li><?php echo set_no_data('seats', $first_section); ?></li>
                        <li><?php echo GlobalHelper::getData($tbl = 'color', set_no_data('color', $first_section), $col = 'color_name'); ?></li>
                        <li><?php echo GlobalHelper::getData($tbl = 'parts_categories', set_no_data('category_id', $first_section), $col = 'category'); ?></li>
                        <li><?php echo GlobalHelper::getData($tbl = 'parts_description', set_no_data('parts_description', $first_section), $col = 'name'); ?></li>
                        <li><?php echo GlobalHelper::getData($tbl = 'vehicle_types', set_no_data('parts_for', $first_section), $col = 'name'); ?></li>
                        <li><?php echo set_no_data('owners', $first_section); ?></li>
                        <li><?php echo GlobalHelper::features(set_no_data('feature_ids', $first_section), false); ?></li>
                    </ul>
                    <?php endif; ?>
                </div>
                <div class="compare_list-wrap">
                    <?php if(empty($second_section)) : ?>
                        <a  href="javascript:void(0)" onclick="openModal('second')"
                            class="waves-effect add_vehicle-btn d-flex align-items-center justify-content-center bg-white w-100 mb-20 modal-trigger">
                            <span class="material-icons">add</span>Add a vehicle</a>
                    <?php else: ?>
                        <ul class="compare_list">
                            <li class="compare_list-top p-20">
                                <h4 class="fs-16 fw-500 mb-5">
                                    <a class="color-theme" href="post/<?=$second_section->post_slug?>"><?=$second_section->title?></a>
                                </h4>
                                <p class="mb-10 color-seconday"><?=set_no_data('gear_box_type', $second_section); ?></p>
                                <?php echo GlobalHelper::getPostThumbPhotoById($second_section->id,$second_section->title,'w-100 obj-cover br-5')?>
                            </li>
                            <li class="price fs-24 fw-500 color-theme"><?=GlobalHelper::getPrice($second_section->priceinnaira, $second_section->priceindollar,$second_section->pricein)?></li>
                            <li class="rating"><a class="d-flex align-items-center" href="<?=!empty($second_section->car_review_slug) ? 'review/'.$second_section->car_review_slug : 'javascript:void(0)'?>"><span class="material-icons">stars</span> <?=!empty($second_section->car_review_rating) ? $second_section->car_review_rating : '0'?>/10</a></li>
                            <li><?=set_no_data('condition', $second_section); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'post_area', set_no_data('location_id', $second_section), $col = 'name'); ?></li>
                            <li><?php echo set_no_data('location', $second_section); ?></li>
                            <li><?php echo set_no_data('mileage', $second_section); ?></li>
                            <li><?php echo set_no_data('car_age', $second_section); ?></li>
                            <li><?php echo set_no_data('alloywheels', $second_section); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'fuel_types', set_no_data('fuel_id', $second_section), $col = 'fuel_name'); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'engine_sizes', set_no_data('enginesize_id', $second_section), $col = 'engine_size'); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'body_types', set_no_data('body_type', $second_section), $col = 'type_name'); ?></li>
                            <li><?php echo set_no_data('gear_box_type', $second_section); ?></li>
                            <li><?php echo set_no_data('seats', $second_section); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'color', set_no_data('color', $second_section), $col = 'color_name'); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'parts_categories', set_no_data('category_id', $second_section), $col = 'category'); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'parts_description', set_no_data('parts_description', $second_section), $col = 'name'); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'vehicle_types', set_no_data('parts_for', $second_section), $col = 'name'); ?></li>
                            <li><?php echo set_no_data('owners', $second_section); ?></li>
                            <li><?php echo GlobalHelper::features(set_no_data('feature_ids', $second_section), false); ?></li>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="compare_list-wrap">
                    <?php if(empty($third_section)) : ?>
                        <a  href="javascript:void(0)" onclick="openModal('third')"
                            class="waves-effect add_vehicle-btn d-flex align-items-center justify-content-center bg-white w-100 mb-20 modal-trigger">
                            <span class="material-icons">add</span>Add a vehicle</a>
                    <?php else: ?>
                        <ul class="compare_list">
                            <li class="compare_list-top p-20">
                                <h4 class="fs-16 fw-500 mb-5">
                                    <a class="color-theme" href="post/<?=$third_section->post_slug?>"><?=$third_section->title?></a>
                                </h4>
                                <p class="mb-10 color-seconday"><?=set_no_data('gear_box_type', $third_section); ?></p>
                                <?php echo GlobalHelper::getPostThumbPhotoById($third_section->id,$third_section->title,'w-100 obj-cover br-5')?>
                            </li>
                            <li class="price fs-24 fw-500 color-theme"><?=GlobalHelper::getPrice($third_section->priceinnaira, $third_section->priceindollar,$third_section->pricein)?></li>
                            <li class="rating"><a class="d-flex align-items-center" href="<?=!empty($third_section->car_review_slug) ? 'review/'.$third_section->car_review_slug : 'javascript:void(0)'?>"><span class="material-icons">stars</span> <?=!empty($third_section->car_review_rating) ? $third_section->car_review_rating : '0'?>/10</a></li>
                            <li><?=set_no_data('condition', $third_section); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'post_area', set_no_data('location_id', $third_section), $col = 'name'); ?></li>
                            <li><?php echo set_no_data('location', $third_section); ?></li>
                            <li><?php echo set_no_data('mileage', $third_section); ?></li>
                            <li><?php echo set_no_data('car_age', $third_section); ?></li>
                            <li><?php echo set_no_data('alloywheels', $third_section); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'fuel_types', set_no_data('fuel_id', $third_section), $col = 'fuel_name'); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'engine_sizes', set_no_data('enginesize_id', $third_section), $col = 'engine_size'); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'body_types', set_no_data('body_type', $third_section), $col = 'type_name'); ?></li>
                            <li><?php echo set_no_data('gear_box_type', $third_section); ?></li>
                            <li><?php echo set_no_data('seats', $third_section); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'color', set_no_data('color', $third_section), $col = 'color_name'); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'parts_categories', set_no_data('category_id', $third_section), $col = 'category'); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'parts_description', set_no_data('parts_description', $third_section), $col = 'name'); ?></li>
                            <li><?php echo GlobalHelper::getData($tbl = 'vehicle_types', set_no_data('parts_for', $third_section), $col = 'name'); ?></li>
                            <li><?php echo set_no_data('owners', $third_section); ?></li>
                            <li><?php echo GlobalHelper::features(set_no_data('feature_ids', $third_section), false); ?></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .compare-area end  -->



<div id="addCar" class="modal modal-wrapper small-modal-wrapper">
    <span class="material-icons modal-close">close</span>
    <h3 class="fs-18 fw-500 mb-15">List of cars</h3>
    <ul class="compare_car-list">
    </ul>
</div>

<div id="compareModal" class="modal modal-wrapper small-modal-wrapper">
    <span class="material-icons modal-close">close</span>
    <form id="compareForm">
        <div class="make_an_offer-form">
            <h4>Add a Vehicle</h4>
            <div class="select2-style mb-15">
                <select id="from_brand_id" name="from_brand_id" onChange="get_model_com(this.value);" class="browser-default">
                    <option value="" disabled selected>Select Make</option>
                    <?php echo GlobalHelper::get_brands_by_vechile($vehicle_id); ?>
                </select>
            </div>
            <div class="select2-style mb-15">
                <select id="from_model_id" name="from_model_id" class="browser-default">
                    <option value="" disabled selected>Select Model</option>
                </select>
            </div>
            <div class="select2-style mb-15">
                <select name="from_manufacture_year" id="from_manufacture_year" class="browser-default">
                    <option value="" disabled selected>Select Year</option>
                    <?php echo numericDropDown(1950, date('Y'), 1, $from['year']); ?>
                </select>
            </div>
            <input type="hidden" name="vehicle_type_id" id="vehicle_type_id" value="<?php echo $vehicle_id; ?>">
            <button type="button" onclick="getFromTitleModal(this)" class="btnStyle addVahicleBtn waves-effect w-100">Search Post</button>
        </div>
    </form>
</div>




<script>
    var params = JSON.parse('<?=json_encode((object) $this->input->get())?>');
    var last_click = '';
    $(window).on('load', function () {
        let prosHeight = $('.pros').innerHeight();
        $('#pros_height').height(prosHeight + 20)
        $('.pros').height(prosHeight)
    })

    function openModal(position) {
        last_click = position;
        $('#compareModal').modal('open')
    }

    function getFromTitleModal(element) {
        var vehicle_type_id = $('#vehicle_type_id').val();
        var brand = $("#from_brand_id").val();
        var model = $("#from_model_id").val();
        var year = $("#from_manufacture_year").val();
        var gets = '<?php print_r(json_encode($_GET))?>';

        var data = {
            vehicle_type_id:vehicle_type_id,
            brand_id: brand,
            model_id: model,
            year: year,
            type: last_click,
            gets : gets
        };
        $.ajax({
            url: 'get-post-titles',
            type: "POST",
            dataType: 'json',
            data: data,
            success: function ( jsonRespond ) {
                if (jsonRespond.status == "success") {
                    $(".compare_car-list").html(jsonRespond.data);
                    $('#compareModal').modal('close');
                    $('#addCar').modal('open');
                }
            }
        });
    }

    function get_model_com(id) {
        var vehicle_type_id = $('#vehicle_type_id').val();

        jQuery.ajax({
            url: 'brands/brands_frontview/brands_by_vehicle_model?type_id='+vehicle_type_id+'&brand_id='+id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                jQuery('#from_model_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#from_model_id').html(response);
            }
        });
    }
</script>

<script>
    $(window).on('load', function () {
        // $('.select2-style select').select2({
        //     width: '100%',
        // });
    });
</script>
