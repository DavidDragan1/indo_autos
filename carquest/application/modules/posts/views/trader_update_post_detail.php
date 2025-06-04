<style>
    .hidden {
        display: none!important;
    }
    .required {
        border: 1px solid red;
    }
    .addcar-tab-menu li {
        margin-right: 70px;
    }
</style>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

load_module_asset('posts', 'css');
$roleID = getLoginUserData('role_id');
$getType = $post_type;
?>

<h2 class="breadcumbTitle">Add Car</h2>
<!-- add-product-area start  -->
<!-- Nav tabs -->
<?php echo postUpdateTabsTrader('update_post_detail', $this->uri->segment(4)); ?>

<div class="tab-pane" id="productInfo">
    <h2 class="add-product-title">Update Product Information</h2>
    <form action="<?php echo $action; ?>" method="post"  onload="initialize()" id="post_details">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Title</label>
                <input type="text" name="title" id="title" class="inputbox-style" placeholder="eg new toyota camry 2016" value="<?php echo $title; ?>" required="">
            </div>

            <?php
            //  $roleID != 8 &&
            if ($getType != 'Automech' && $getType != 'Towing') :
            ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Currency</label>
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-8" style="padding-right: 0px;">
                        <div class="select2-wrapper">
                            <select name="pricein" class="input-style" id="currency" required="required">
                                <option value="USD" <?php echo ($pricein == 'USD') ? ' selected' : ''; ?> >Currency:  &dollar; USD </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-4" style="padding-left: 0px;">
                        <input  name="pricevalue" type="text" onKeyPress="return DegitOnly(event);" class="inputbox-style" required=""  value="<?php echo $price; ?>"/>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php
            // $roleID != 8 &&
            if ($getType != 'Automech' && $getType != 'Towing') :
            ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Age</label>
                <div class="select2-wrapper">
                    <select class="input-style" name="car_age" id="car_age">
                        <?php echo car_age($car_age); ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label"> Page-link </label>
                <input type="text" name="post_slug" class="inputbox-style" value="<?php echo $post_slug; ?>" id="postSlug" required=""  placeholder="https://example.com/">

                <?php if (in_array($vehicle_type_id, [1, 2, 3, 5, 6])) : ?>
                <label class="input-label">Registration Number</label>
                    <input type="text" class="inputbox-style" placeholder="type registration number" id="RegistrationNumber" name="registration_no" value="<?php echo $registration_no; ?>">
                <?php endif; ?>

            </div>
            <div class="col-lg-8">
                <label class="input-label">Description</label>
                <textarea class="form-control" name="description" required="" id="description"><?php echo $description; ?></textarea>
            </div>

            <?php if ($vehicle_type_id == 4 || $getType == 'Automech') : ?>
            <?php if ($getType == 'General') : ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Part Category </label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="category_id" name="category_id" required="">
                            <?php echo GlobalHelper::parts_categories($category_id); ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($vehicle_type_id != 4): ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Repair Type </label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="repair_type_id" name="repair_type_id" required="">
                            <?php echo GlobalHelper::getRepairType($repair_type_id); ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-lg-4 col-md-6 col-12">
                <?php $typeLabel = ($getType == 'Automech') ? 'Automech For' : 'Parts For'; ?>
                <label class="input-label"><?php echo $typeLabel; ?> </label>
                <div class="select2-wrapper">
                    <select class="input-style" id="parts_for" name="parts_for" required="">
                        <?php echo parts_for($parts_for); ?>
                    </select>
                </div>
            </div>

            <?php if ($getType != 'General') : ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Specialism </label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="specialism_id" name="specialism_id" required="">
                            <?php echo GlobalHelper::getSpecialism($specialism_id); ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Service </label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="service_type" name="service_type" required="">
                            <?php echo GlobalHelper::getServiceType($service_type); ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>

                <?php if ($getType != 'Automech') :?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="input-label">Parts Name </label>
                        <div class="select2-wrapper">
                            <select class="input-style" id="parts_description" name="parts_description" required="">
                                <option value="">Please Select</option>
                                <?php echo parts_description($parts_description); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="input-label">Parts Id</label>
                        <input placeholder="Parts Id" name="parts_id" type="text" class="inputbox-style required" value="<?php echo $parts_id; ?>"/>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

            <?php if ($getType == 'General') : ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Year of Manufacture </label>
                <div class="select2-wrapper">
                    <select required="" name="manufacture_year" class="input-style" id="manufacture_year">
                        <option value="">Please Select</option>
                        <?php echo numericDropDown(1950, date('Y'), 1, $manufacture_year); ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Brand Name</label>
                <div class="select2-wrapper">
                    <select class="input-style" id="brandName" required="" onChange="get_model(this.value, <?php echo $vehicle_type_id; ?>);" name="brand_id">
                        <option value="0">Select a brand</option>
                        <?php echo Modules::run('brands/all_brands_for_automech', $brand_id, $vehicle_type_id); ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Model Name</label>
                <div class="select2-wrapper">
                    <select class="input-style" id="model_id" name="model_id" required="">
                        <?php echo getBrand($model_id, $brand_id); ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($getType == 'Towing') : ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Category </label>
                    <div class="select2-wrapper">
                        <select required="" class="input-style" onchange="towing_servic(this)" id="towing_service_id" name="towing_service_id">
                            <?php echo GlobalHelper::towing_services($towing_service_id); ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Vehicle Type </label>
                    <div class="select2-wrapper">
                        <select required="" class="input-style" id="vehicle_type" name="vehicle_type">
                            <?php echo GlobalHelper::getDropDownVehicleTypeTowing($vehicle_type); ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Type of Service </label>
                    <div class="select2-wrapper">
                        <select required="" class="input-style" id="towing_type_of_service_id" name="towing_type_of_service_id">
                            <?php echo GlobalHelper::towing_type_of_services($towing_service_id, $towing_type_of_service_id); ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($getType == 'Automech' || $getType == 'Towing') :?>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Brand Name </label>
                    <div class="select2-wrapper">
                        <select required="" id="towing_brandName" name="brand_id" class="input-style">
                            <option value="0">Select a brand</option>
                            <?php echo GlobalHelper::all_brands_for_automech($brand_id); ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($getType == 'Towing') : ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Availability </label>
                    <div class="select2-wrapper">
                        <select required="" id="availability" name="availability" class="input-style">
                            <?php echo GlobalHelper::getDropDownAvailability($availability); ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>


            <?php if (in_array($vehicle_type_id, [1, 2, 3, 5, 6])) : ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Fuel Type</label>
                <div class="select2-wrapper">
                    <select class="input-style" id="fueltype" name="fuel_id" required="">
                        <?php echo GlobalHelper::createDropDownFromTable($tbl = 'fuel_types', $col = 'fuel_name', $fuel_id); ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Engine Size</label>
                <div class="select2-wrapper">
                    <select name="enginesize_id" class="input-style" id="Enginesize">
                        <?php echo GlobalHelper::createDropDownFromTable($tbl = 'engine_sizes', $col = 'engine_size', $enginesize_id); ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <?php if (in_array($vehicle_type_id, [1, 2, 5, 6])) : ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Seats</label>
                <div class="select2-wrapper">
                    <select class="input-style" name="seats" id="seats" required="">
                        <?php echo GlobalHelper::seat($seats, 'Select Seats'); ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <?php if (in_array($vehicle_type_id, [1, 2, 3, 5, 6])) : ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Gearbox</label>
                <div class="select2-wrapper">
                    <select class="input-style" id="gearBox" name="gear_box_type" required="">
                        <?php echo GlobalHelper::gearBox($gear_box_type); ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Body Type</label>
                <div class="select2-wrapper">
                    <select class="input-style" id="Bodytype" name="body_type" required="">
                        <?php echo GlobalHelper::createDropDownFromTable($tbl = 'body_types', $col = 'type_name', $body_type); ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <?php if (in_array($vehicle_type_id, [1, 2, 3, 5, 6])) : ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Colour </label>
                <div class="select2-wrapper">
                    <select class="input-style"  name="color" id="color" required="">
                        <?php echo GlobalHelper::createDropDownFromTable($tbl = 'color', $col = 'color_name', $color); ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <?php if (in_array($vehicle_type_id, [1, 2, 3, 5, 6])) : ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">1st Registration Date </label>
                <?php $reg_date = explode('-', $registration_date); ?>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-3" style="padding-right: 0px;">
                        <div class="select2-wrapper">
                            <select name="regiday" class="input-style" id="regiday">
                                <option value="00">DD</option>
                                <?php echo numericDropDown(1, 31, 1, $reg_date[2]); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-3" style="padding-right: 0px; padding-left: 0px;">
                        <div class="select2-wrapper">
                            <select name="regimonth" class="input-style" id="regimonth">
                                <option value="00">MM</option>
                                <?php echo numericDropDown(1, 12, 1, $reg_date[1]); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6" style="padding-left: 0px;">
                        <div class="select2-wrapper">
                            <select name="regiyear" class="input-style" id="regiyear">
                                <option value="0000">YYYY</option>
                                <?php echo numericDropDown(1950, date('Y'), 1, $reg_date[0]); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Service History</label>
                <div class="select2-wrapper">
                    <select class="input-style" id="Servicehistory" name="service_history">
                        <option value="0">Please Select</option>
                        <?php echo service_history($service_history); ?>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <?php if (in_array($vehicle_type_id, [1, 2, 3, 5, 6])) { ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Alloy Wheels</label>
                <div class="select2-wrapper">
                    <select class="input-style" id="alloywheels" name="alloywheels">
                        <?php echo GlobalHelper::wheel_list($alloywheels); ?>
                    </select>
                </div>
            </div>
            <?php } ?>

            <?php
            // $roleID != 8 &&
            if ($getType != 'Automech' && $getType != 'Towing') :
            ?>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label"> Owner</label>
                <div class="select2-wrapper">
                    <select class="input-style" id="owners" name="owners">
                        <option value="0">Please Select</option>
                        <?php echo owners($owners); ?>
                    </select>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
            </div>
            <?php endif; ?>

            <?php if (in_array($vehicle_type_id, [1, 2, 3, 5, 6])) : ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label"> Mileage (Miles)</label>
                    <input type="number" class="inputbox-style" id="mileage" name="mileage" value="<?php echo $mileage; ?>"  onKeyPress="return DegitOnly(event);">
                </div>
            <?php endif; ?>

            <?php if (in_array($vehicle_type_id, [1, 2, 5, 6])) : ?>
                <div class="col-12">
                    <h3 class="featured-title">Special Features</h3>
                    <ul class="special-featured-lists spfeatures" id="morefName">
                        <?php echo Modules::run('special_features/all_features_new', $feature_ids); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="text-left" style="float: left;">
                    <button class="btn-wrap btn-big" name="update_only" value="stay" type="submit">Update &AMP; Stay Here</button>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="text-right">
                    <button class="btn-wrap btn-big" name="update_continue" value="continue" type="submit">Save &AMP; Goto Next Step</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description', {
        height: ['70px'],
        customConfig: '<?php echo site_url('assets/theme/new/js/ckeditor/config.js'); ?>',
    });
</script>

<script><?php echo load_module_asset('posts', 'js', 'tooltip.js'); ?></script>
<?php load_module_asset('posts', 'js'); ?>

<script type="text/javascript">
    $("#title").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        $("#postSlug").val(Text);
        $(".pageSlug").text(Text);
    });
</script>

