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
load_module_asset('posts', 'js');

$roleID =  getLoginUserData('role_id');
$getType = $post_type;

?>

<h2 class="breadcumbTitle">Update Advert</h2>
<!-- add-product-area start  -->
<!-- Nav tabs -->
<?php echo postUpdateTabsTrader('update_general', $this->uri->segment(4)); ?>
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="generalInfo">
        <h2 class="add-product-title">Upload Vehicle For Sale</h2>
        <form class="form-horizontal" id="upload_new" action="<?php echo $action; ?>" method="post" onsubmit="return upload_new_post();">
            <input type="hidden" name="lat" id="latitude" value="<?php echo $lat; ?>">
            <input type="hidden" name="lng" id="longitude" value="<?php echo $lng; ?>">
        <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">State</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="location_id" id="location_id" onchange="getCity()">
                            <?php echo GlobalHelper::all_location($location_id); ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Location of the Product</label>
                    <div class="select2-wrapper">
                        <select class="input-style required" name="location" id="location">
                            <?php echo GlobalHelper::all_city(); ?>
                        </select>
                    </div>
                </div>

            <?php
            //  $roleID != 8 &&
            if( $getType == 'General' ) : ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Vehicle Category</label>
                    <div class="select2-wrapper">
                        <select name="vehicle_type_id" id="vehicle_type_id" required class="input-style">
                            <?php echo GlobalHelper::getDropDownVehicleType($vehicle_type_id); ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Vehicle Condition </label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="condition" name="condition" required>
                            <?php echo GlobalHelper::getConditions($condition, 'Select'); ?>
                        </select>
                    </div>
                </div>
            <?php endif;  ?>

                <?php if (getLoginUserData('role_id') == 4): ?>
                    <input type="hidden" name="listing_type" value="Business">
                <?php elseif (getLoginUserData('role_id') == 5): ?>
                    <input type="hidden" name="listing_type" value="Personal">
                <?php elseif (getLoginUserData('role_id') == 8): ?>
                    <input type="hidden" name="listing_type" value="Business">
                <?php else: ?>

            <?php
            // $roleID != 8 &&
            if(  $getType == 'General' ) : ?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="input-label">Seller Type </label>
                        <div class="select2-wrapper">
                            <select class="input-style" id="listing_type" name="listing_type">
                                <?php echo listing_type($listing_type); ?>
                            </select>
                        </div>
                    </div>
            <?php endif; ?>
                <?php endif; ?>

<!--                <div class="col-lg-4 col-md-6 col-12 hidden">-->
<!--                    <label class="input-label">Listing Package</label>-->
<!--                    <div class="select2-wrapper">-->
<!--                        <select class="input-style" id="advert_type" name="advert_type">-->
<!--                            --><?php //echo advert_type($advert_type); ?>
<!--                        </select>-->
<!--                    </div>-->
<!--                </div>-->

                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Listing Package</label>
                    <div class="select2-wrapper">
                        <select name="package_id" class="input-style">
                            <?php echo getPostPackages($package_id); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="text-left" style="float: left;">
                        <a class="btn-wrap btn-big" href="<?php echo site_url('admin/posts') ?>">Cancel</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="text-right">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <button class="btn-wrap btn-big" type="submit">Submit & Continue</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- add-product-area start  -->

<script>
    function getCity() {
        var id = $("#location_id").val();
        jQuery.ajax({
            url: 'all-city?id='+id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                jQuery('#location').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#location').html(response);
            }
        });
    }
</script>
