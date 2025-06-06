<style>
    .search {
        border: none;
        border-radius: 0;
        width: 100%;
        height: 45px;
        color: #fff;
        cursor: pointer;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        background: #f05c26;
        border-left: 1px solid #ffffff;
        border-radius: 5px;
    }
</style>
<?php
$from_price = isset($from['car']) ? ((set_no_data('pricein', $from['car']) == 'USD')
    ? set_no_data('priceindollar', $from['car'])
    : set_no_data('priceinnaira', $from['car'])) : '';

$to_price = isset($to['car']) ? ((set_no_data('pricein', $to['car']) == 'USD')
    ? set_no_data('priceindollar', $to['car'])
    : set_no_data('priceinnaira', $to['car'])) : '';
?>

<div class="deviceCompaire">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav compareSwitcher">
                    <li>
                        <a class="active" data-toggle="tab" href="#full" aria-selected="true">Full</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#differences" aria-selected="false">Differences</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="full">
                        <div class="DeviceCompareWrap">
                            <div class="compareSingle topHeaderCompare">
                                <div class="cpmtitle">
                                    <p class="cmpmodetext">
                                        <i class="fa fa-exclamation-circle"></i> Change compare mode </p>
                                </div>
                                <div class="cpmItem">
                                    <div class="productCmpSearch">
                                        <strong>Compare With</strong>
                                        <div class="searchCompair">
                                            <div class="select2-wrapper select2-wrapper-black">
                                                <select class="input-style" id="from_brand_id" name="from_brand_id" onChange="get_model_com(this.value);">
                                                    <?php echo GlobalHelper::get_brands_by_vechile($vehicle_type_id, $from['brand_id']); ?>
                                                </select>
                                            </div>
                                            <div class="select2-wrapper select2-wrapper-black">
                                                <select class="input-style" id="from_model_id" name="from_model_id">
                                                    <?php  echo GlobalHelper::get_brands_by_vehicle_model($vehicle_type_id, $from['brand_id'], $from['model_id']); ?>
                                                </select>
                                            </div>
                                            <div class="select2-wrapper select2-wrapper-black">
                                                <select name="from_manufacture_year" class="input-style" id="from_manufacture_year">
                                                    <option value="0">Select Year</option>
                                                    <?php echo numericDropDown(1950, date('Y'), 1, $from['year']); ?>
                                                </select>
                                            </div>
                                            <input type="hidden" name="vehicle_type_id" id="vehicle_type_id" value="<?php echo $vehicle_type_id; ?>">
                                            <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
                                            <input type="hidden" name="slug" id="slug" value="<?php echo $from['slug']; ?>">
                                            <button class="btn-default search" type="button" onclick="getFromTitleModal(this)">Search Post</button>
                                        </div>
                                    </div>
                                    <div class="proCmpDevice">
                                        <?php echo GlobalHelper::getPostFeaturedPhoto($from['id'], 'tiny'); ?>
                                        <div class="links">
                                            <a href="post/<?php echo $from['slug']; ?>" target="_blank">View Details</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="cpmItem">
                                    <div class="productCmpSearch">
                                        <strong>Compare With</strong>
                                        <div class="searchCompair">
                                            <div class="select2-wrapper select2-wrapper-black">
                                                <select class="input-style" id="to_brand_id" name="to_brand_id" onChange="to_get_model(this.value);">
                                                    <?php echo GlobalHelper::get_brands_by_vechile($vehicle_type_id, $to['brand_id']); ?>
                                                </select>
                                            </div>
                                            <div class="select2-wrapper select2-wrapper-black">
                                                <select class="input-style" id="to_model_id" name="to_model_id">
                                                    <?php  echo GlobalHelper::get_brands_by_vehicle_model($vehicle_type_id, $to['brand_id'], $to['model_id']); ?>
                                                </select>
                                            </div>
                                            <div class="select2-wrapper select2-wrapper-black">
                                                <select name="to_manufacture_year" class="input-style" id="to_manufacture_year">
                                                    <option value="0">Select Year</option>
                                                    <?php echo numericDropDown(1950, date('Y'), 1, $to['year']); ?>
                                                </select>
                                            </div>
                                            <input type="hidden" name="to_slug" id="to_slug" value="<?php echo $to['slug']; ?>">
                                            <button class="btn-default search" type="button" onclick="getToTitleModal(this)">Search Post</button>
                                        </div>
                                    </div>
                                    <div class="proCmpDevice">
                                        <?php if($to['brand_id'] != 0) : ?>
                                        <?php echo GlobalHelper::getPostFeaturedPhoto($to['id'], 'tiny'); ?>
                                        <?php endif; ?>
                                        <?php if(isset($to['slug'])) : ?>
                                            <div class="links">
                                                <a href="post/<?php echo $to['slug']; ?>" target="_blank">View Details</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle topBorder">
                                    <strong>General Info</strong>
                                    <span>Vehicle Category</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'vehicle_types', set_no_data('vehicle_type_id', $from['car']), $col = 'name'); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'vehicle_types', set_no_data('vehicle_type_id', $to['car']), $col = 'name'); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Vehicle Condition</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('condition', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('condition', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>State</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'post_area', set_no_data('location_id', $from['car']), $col = 'name'); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'post_area', set_no_data('location_id', $to['car']), $col = 'name'); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Location of the Product</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('location', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('location', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <strong>Product Info</strong>
                                    <span>Price</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo $from_price.' '.set_no_data('pricein', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo $to_price.' '.set_no_data('pricein', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Mileage</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('mileage', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('mileage', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Car Age</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('car_age', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('car_age', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Alloy Wheels</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('alloywheels', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('alloywheels', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Fuel Type</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'fuel_types', set_no_data('fuel_id', $from['car']), $col = 'fuel_name'); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'fuel_types', set_no_data('fuel_id', $to['car']), $col = 'fuel_name'); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Engine Size</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'engine_sizes', set_no_data('enginesize_id', $from['car']), $col = 'engine_size'); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'engine_sizes', set_no_data('enginesize_id', $to['car']), $col = 'engine_size'); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Body Type</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'body_types', set_no_data('body_type', $from['car']), $col = 'type_name'); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'body_types', set_no_data('body_type', $to['car']), $col = 'type_name'); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Gear Box</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo  set_no_data('gear_box_type', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo  set_no_data('gear_box_type', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Seats</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('seats', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('seats', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Color</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'color', set_no_data('color', $from['car']), $col = 'color_name'); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'color', set_no_data('color', $to['car']), $col = 'color_name'); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Part Category</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'parts_categories', set_no_data('category_id', $from['car']), $col = 'category'); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'parts_categories', set_no_data('category_id', $to['car']), $col = 'category'); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Parts Description</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'parts_description', set_no_data('parts_description', $from['car']), $col = 'name'); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'parts_description', set_no_data('parts_description', $to['car']), $col = 'name'); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Parts For</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'vehicle_types', set_no_data('parts_for', $from['car']), $col = 'name'); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::getData($tbl = 'vehicle_types', set_no_data('parts_for', $to['car']), $col = 'name'); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Owners</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('owners', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('owners', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>1st Registration Date</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('registration_date', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('registration_date', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Registration No</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('registration_no', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('registration_no', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Service History</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('service_history', $from['car']); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo set_no_data('service_history', $to['car']); ?></p>
                                </div>
                            </div>
                            <div class="compareSingle">
                                <div class="cpmtitle">
                                    <span>Special Features</span>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::features(set_no_data('feature_ids', $from['car'])); ?></p>
                                </div>
                                <div class="cpmItem">
                                    <p><?php echo GlobalHelper::features(set_no_data('feature_ids', $to['car'])); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="differences">
                            <div class="DeviceCompareWrap">
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <p class="cmpmodetext">
                                            <i class="fa fa-exclamation-circle"></i> Change compare mode </p>
                                    </div>
                                    <div class="cpmItem">
                                        <div class="productCmpSearch">
                                            <strong>Compare With</strong>
                                            <div class="searchCompair">
                                                <div class="select2-wrapper select2-wrapper-black">
                                                    <select class="input-style" id="from_brand_id_diff" name="from_brand_id" onChange="get_model_diff(this.value);">
                                                        <?php echo GlobalHelper::get_brands_by_vechile($vehicle_type_id, $from['brand_id']); ?>
                                                    </select>
                                                </div>
                                                <div class="select2-wrapper select2-wrapper-black">
                                                    <select class="input-style" id="from_model_id_diff" name="from_model_id">
                                                        <?php  echo GlobalHelper::get_brands_by_vehicle_model($vehicle_type_id, $from['brand_id'], $from['model_id']); ?>
                                                    </select>
                                                </div>
                                                <div class="select2-wrapper select2-wrapper-black">
                                                    <select name="from_manufacture_year" class="input-style" id="from_manufacture_year_diff">
                                                        <option value="0">Select Year</option>
                                                        <?php echo numericDropDown(1950, date('Y'), 1, $from['year']); ?>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="vehicle_type_id" id="vehicle_type_id" value="<?php echo $vehicle_type_id; ?>">
                                                <input type="hidden" name="type" id="type_diff" value="<?php echo $type; ?>">
                                                <input type="hidden" name="slug" id="slug" value="<?php echo $from['slug']; ?>">
                                                <button class="btn-default search" type="button" onclick="getFromTitleModal(this)">Search Post</button>
                                            </div>
                                        </div>
                                        <div class="proCmpDevice">
                                            <?php echo GlobalHelper::getPostFeaturedPhoto($from['id'], 'tiny'); ?>
                                            <div class="links">
                                                <a href="post/<?php echo $from['slug']; ?>" target="_blank">View Details</a>
                                                <!--                                            <a href="">Read Review</a>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cpmItem">
                                        <div class="productCmpSearch">
                                            <strong>Compare With</strong>
                                            <div class="searchCompair">
                                                <div class="select2-wrapper select2-wrapper-black">
                                                    <select class="input-style" id="to_brand_id_diff" name="to_brand_id" onChange="to_get_model_diff(this.value);">
                                                        <?php echo GlobalHelper::get_brands_by_vechile($vehicle_type_id, $to['brand_id']); ?>
                                                    </select>
                                                </div>
                                                <div class="select2-wrapper select2-wrapper-black">
                                                    <select class="input-style" id="to_model_id_diff" name="to_model_id">
                                                        <?php  echo GlobalHelper::get_brands_by_vehicle_model($vehicle_type_id, $to['brand_id'], $to['model_id']); ?>
                                                    </select>
                                                </div>
                                                <div class="select2-wrapper select2-wrapper-black">
                                                    <select name="to_manufacture_year" class="input-style" id="to_manufacture_year_diff">
                                                        <option value="0">Select Year</option>
                                                        <?php echo numericDropDown(1950, date('Y'), 1, $to['year']); ?>
                                                    </select>
                                                </div>
                                                <button class="btn-default search" type="button" onclick="getToTitleModal(this)">Search Post</button>
                                            </div>
                                        </div>
                                        <div class="proCmpDevice">
                                            <?php if($to['brand_id'] != 0) : ?>
                                                <?php echo GlobalHelper::getPostFeaturedPhoto($to['id'], 'tiny'); ?>
                                            <?php endif; ?>
                                            <?php if(isset($to['slug'])) : ?>
                                                <div class="links">
                                                    <a href="post/<?php echo $to['slug']; ?>" target="_blank">View Details</a>
                                                    <!--                                            <a href="">Read Review</a>-->
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if (set_no_data('vehicle_type_id', $from['car']) != set_no_data('vehicle_type_id', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <strong>General Info</strong>
                                        <span>Vehicle Category</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'vehicle_types', set_no_data('vehicle_type_id', $from['car']), $col = 'name'); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'vehicle_types', set_no_data('vehicle_type_id', $to['car']), $col = 'name'); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('condition', $from['car']) != set_no_data('condition', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Vehicle Condition</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('condition', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('condition', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('location_id', $from['car']) != set_no_data('location_id', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>State</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'post_area', set_no_data('location_id', $from['car']), $col = 'name'); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'post_area', set_no_data('location_id', $to['car']), $col = 'name'); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('location', $from['car']) != set_no_data('location', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Location of the Product</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('location', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('location', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if ($from_price != $to_price) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <strong>Product Info</strong>
                                        <span>Price</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo $from_price.' '.set_no_data('pricein', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo $to_price.' '.set_no_data('pricein', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('mileage', $from['car']) != set_no_data('mileage', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Mileage</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('mileage', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('mileage', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('car_age', $from['car']) != set_no_data('car_age', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Car Age</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('car_age', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('car_age', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('alloywheels', $from['car']) != set_no_data('alloywheels', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Alloy Wheels</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('alloywheels', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('alloywheels', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('fuel_id', $from['car']) != set_no_data('fuel_id', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Fuel Type</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'fuel_types', set_no_data('fuel_id', $from['car']), $col = 'fuel_name'); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'fuel_types', set_no_data('fuel_id', $to['car']), $col = 'fuel_name'); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('enginesize_id', $from['car']) != set_no_data('enginesize_id', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Engine Size</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'engine_sizes', set_no_data('enginesize_id', $from['car']), $col = 'engine_size'); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'engine_sizes', set_no_data('enginesize_id', $to['car']), $col = 'engine_size'); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('body_type', $from['car']) != set_no_data('body_type', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Body Type</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'body_types', set_no_data('body_type', $from['car']), $col = 'type_name'); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'body_types', set_no_data('body_type', $to['car']), $col = 'type_name'); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if ( set_no_data('gear_box_type', $from['car']) != set_no_data('gear_box_type', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Gear Box</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo  set_no_data('gear_box_type', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('gear_box_type', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('seats', $from['car']) != set_no_data('seats', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Seats</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('seats', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('seats', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('color', $from['car']) != set_no_data('color', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Color</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'color', set_no_data('color', $from['car']), $col = 'color_name'); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'color', set_no_data('color', $to['car']), $col = 'color_name'); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('category_id', $from['car']) != set_no_data('category_id', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Part Category</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'parts_categories', set_no_data('category_id', $from['car']), $col = 'category'); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'parts_categories', set_no_data('category_id', $to['car']), $col = 'category'); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('parts_description', $from['car']) != set_no_data('parts_description', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Parts Description</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'parts_description', set_no_data('parts_description', $from['car']), $col = 'name'); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'parts_description', set_no_data('parts_description', $to['car']), $col = 'name'); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('parts_for', $from['car']) != set_no_data('parts_for', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Parts For</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'vehicle_types', set_no_data('parts_for', $from['car']), $col = 'name'); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::getData($tbl = 'vehicle_types', set_no_data('parts_for', $to['car']), $col = 'name'); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('owners', $from['car']) != set_no_data('owners', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Owners</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('owners', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('owners', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('registration_date', $from['car']) != set_no_data('registration_date', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>1st Registration Date</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('registration_date', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('registration_date', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('registration_no', $from['car']) != set_no_data('registration_no', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Registration No</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('registration_no', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('registration_no', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('service_history', $from['car']) != set_no_data('service_history', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Service History</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('service_history', $from['car']); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo set_no_data('service_history', $to['car']); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (set_no_data('feature_ids', $from['car']) != set_no_data('feature_ids', $to['car'])) : ?>
                                <div class="compareSingle">
                                    <div class="cpmtitle">
                                        <span>Special Features</span>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::features(set_no_data('feature_ids', $from['car'])); ?></p>
                                    </div>
                                    <div class="cpmItem">
                                        <p><?php echo GlobalHelper::features(set_no_data('feature_ids', $to['car'])); ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                            </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade modalWrapper" id="getAllPostData" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <h2 class="modal-title">Search Listing</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="getPostDataModal" id="modal_title">

            </div>
        </div>
    </div>
</div>
<script>
    function getToTitleModal(element){
        var vehicle_type_id = $('#vehicle_type_id').val();
        var brand = $("#to_brand_id").val();
        var model = $("#to_model_id").val();
        var year = $("#to_manufacture_year").val();
        var from_slug = $("#slug").val();
        var type = "to";
        var data = {
            vehicle_type_id:vehicle_type_id,
            brand_id: brand,
            model_id: model,
            year: year,
            from_slug: from_slug,
            type: type,
        };
        $.ajax({
            url: 'get-post-titles',
            type: "POST",
            dataType: 'json',
            data: data,
            success: function ( jsonRespond ) {
                if (jsonRespond.status == "success") {
                   $("#modal_title").html(jsonRespond.data);
                    $('#getAllPostData').modal('show')
                }
            }
        });
    }

    function getFromTitleModal(element) {
        var vehicle_type_id = $('#vehicle_type_id').val();
        var brand = $("#from_brand_id").val();
        var model = $("#from_model_id").val();
        var year = $("#from_manufacture_year").val();
        var from_slug = $("#to_slug").val();
        var type = "from";

        var data = {
            vehicle_type_id:vehicle_type_id,
            brand_id: brand,
            model_id: model,
            year: year,
            from_slug: from_slug,
            type: type,
        };
        $.ajax({
            url: 'get-post-titles',
            type: "POST",
            dataType: 'json',
            data: data,
            success: function ( jsonRespond ) {
                if (jsonRespond.status == "success") {
                    $("#modal_title").html(jsonRespond.data);
                    $('#getAllPostData').modal('show')
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

    function to_get_model(id) {
        var vehicle_type_id = $('#vehicle_type_id').val();

        jQuery.ajax({
            url: 'brands/brands_frontview/brands_by_vehicle_model?type_id='+vehicle_type_id+'&brand_id='+id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                jQuery('#to_model_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#to_model_id').html(response);
            }
        });
    }

    function get_model_diff(id) {
        var vehicle_type_id = $('#vehicle_type_id').val();

        jQuery.ajax({
            url: 'brands/brands_frontview/brands_by_vehicle_model?type_id='+vehicle_type_id+'&brand_id='+id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                jQuery('#from_model_id_diff').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#from_model_id_diff').html(response);
            }
        });
    }

    function to_get_model_diff(id) {
        var vehicle_type_id = $('#vehicle_type_id').val();

        jQuery.ajax({
            url: 'brands/brands_frontview/brands_by_vehicle_model?type_id='+vehicle_type_id+'&brand_id='+id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                jQuery('#to_model_id_diff').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#to_model_id_diff').html(response);
            }
        });
    }
</script>

