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

<?php defined('BASEPATH') OR exit('No direct script access allowed');

load_module_asset('posts', 'css');
load_module_asset('posts', 'js');

$roleID = getLoginUserData('role_id');

?>

<h2 class="breadcumbTitle">Add Advert</h2>
<!-- add-product-area start  -->
<!-- Nav tabs -->
<?php echo postUpdateTabsTrader('create'); ?>
<!-- Tab panes -->
<div class="tab-content">
    <div class="tab-pane active" id="generalInfo">
        <h2 class="add-product-title">Upload Vehicle For Sale</h2>
        <form id="upload_new" action="<?php echo $action; ?>" method="post"
              onsubmit="return upload_new_post();">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">State</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="location_id" id="location_id">
                            <?php echo GlobalHelper::all_location(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Location of the Product</label>
                    <div class="select2-wrapper">
                        <input type="text" class="inputbox-style" name="location" id="autocomplete"
                               placeholder="Google Postcode"/>
                        <input type="hidden" name="lat" id="latitude" value="">
                        <input type="hidden" name="lng" id="longitude" value="">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Vehicle Category</label>
                    <div class="select2-wrapper">
                        <select <?php echo ($this->input->get('post_type')) ? 'readonly' : ''; ?>
                                class="input-style" name="vehicle_type_id" id="vehicle_type_id">
                            <?php echo GlobalHelper::dropDownVehicleList($this->input->get('post_type')); ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Vehicle Condition </label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="condition" name="condition">
                            <?php echo GlobalHelper::getConditions(0, 'Select'); ?>
                        </select>
                    </div>
                </div>

                <?php if (getLoginUserData('role_id') == 4): ?>
                    <input type="hidden" name="listing_type" value="Business">
                <?php elseif (getLoginUserData('role_id') == 5): ?>
                    <input type="hidden" name="listing_type" value="Personal">
                <?php elseif (getLoginUserData('role_id') == 8): ?>
                    <input type="hidden" name="listing_type" value="Business">
                <?php else: ?>

                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Seller Type </label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="listing_type" name="listing_type">
                            <?php echo listing_type(); ?>
                        </select>
                    </div>
                </div>

                <?php endif; ?>

                <div class="col-lg-4 col-md-6 col-12 hidden">
                    <label class="input-label">Listing Package</label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="advert_type" name="advert_type">
                            <?php echo advert_type(); ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <label class="input-label">Listing Package</label>
                    <div class="select2-wrapper">
                        <select name="package_id" class="input-style">
                            <?php echo getPostPackages(0); ?>
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
                        <button class="btn-wrap btn-big" type="submit">Submit & Continue</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- add-product-area start  -->

<?php $this->load->view('google_map_script'); ?>

