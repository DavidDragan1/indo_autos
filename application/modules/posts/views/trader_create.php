<link rel="stylesheet" href="assets/theme/new/css/jquery-ui.min.css"/>
<style>
    .preview-list li.right h4 span {
        font-weight: 600;
        color: #f05c26;
    }

    .preview-list li h4 span{
        font-size: 25px;
        font-weight: 400;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        color: #1e1e1e
    }
</style>
<?php defined('BASEPATH') OR exit('No direct script access allowed');

load_module_asset('posts', 'css');
load_module_asset('posts', 'js');

$roleID = getLoginUserData('role_id');

?>

<?php
$user_id = getLoginUserData('user_id');
$role_id = getLoginUserData('role_id');

if ($user_id) {
    $user = $this->db->where('id', $user_id)->get('users')->row();
} else {
    $user = null;
}

$vehicleId = $this->input->get('post_type', TRUE);

if ($vehicleId == 'Car') {
    $vehicleId = 1;
} else if ($vehicleId == 'Van') {
    $vehicleId = 2;
} else if ($vehicleId == 'Motorbike') {
    $vehicleId = 3;
} else if ($vehicleId == 'Parts') {
    $vehicleId = 4;
} else if ($vehicleId == 'Import-car') {
    $vehicleId = 5;
} else if ($vehicleId == 'Auction-car') {
    $vehicleId = 6;
}
?>
<?php if($this->session->flashdata('status')):
    if ($this->session->flashdata('status') == 'success') :?>
        <div class="tostfyMessage bg-success" style="top: 5px; visibility: visible; opacity: 1">
            <span class="tostfyClose">&times;</span>
            <div class="messageValue" id="session_msg">
                <?php echo $this->session->flashdata('message'); ?>
            </div>
        </div>
    <?php else : ?>
        <div class="tostfyMessage bg-danger" style="top: 5px; visibility: visible; opacity: 1">
            <span class="tostfyClose">&times;</span>
            <div class="messageValue" id="session_msg">
                <?php echo $this->session->flashdata('message'); ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<h2 class="breadcumbTitle">Add Advert</h2>
<!-- add-product-area start  -->
<div class="product-list-edit-area">
    <div class="row">
        <div class="col-12">
            <form class="add-product-wrapper" id="list-add" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
                <h3>General info </h3>
                <fieldset class="step-wrapper form-wrapper"  id="general_info">
                    <h2><span>Upload</span> Vehicle For Sale</h2>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-style">
                                <label class="input-label">State</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" name="location_id" id="location_id" onchange="getCity()">
                                        <?php echo GlobalHelper::all_location(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-style">
                                <label class="input-label">Location of the Product</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" name="location" id="location">
                                        <?php echo GlobalHelper::all_city(); ?>
                                    </select>
                                </div>
                                <input type="hidden" name="lat" id="latitude" value="">
                                <input type="hidden" name="lng" id="longitude" value="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-style">
                                <label class="input-label">Vehicle Category</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" name="vehicle_type_id" id="vehicle_type_id" onChange="vehicle_change(this.value);">
                                        <?php echo GlobalHelper::dropDownVehicleList($this->input->get('post_type')); ?>
                                    </select>
                                </div>
                                <input type="hidden" name="post_type" value="<?php echo $this->input->get('post_type');?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-style">
                                <label class="input-label" id="v_con">Vehicle Condition</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" id="condition" name="condition">
                                        <?php echo GlobalHelper::getConditions(0, 'Select'); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php if (getLoginUserData('role_id') == 4): ?>
                            <input type="hidden" name="listing_type" value="Business">
                        <?php elseif (getLoginUserData('role_id') == 5): ?>
                            <input type="hidden" name="listing_type" value="Personal">
                        <?php elseif (getLoginUserData('role_id') == 8): ?>
                            <input type="hidden" name="listing_type" value="Business">
                        <?php else: ?>
                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Seller Type </label>
                                    <div class="select2-wrapper select2-wrapper-black">
                                        <select class="input-style required" id="listing_type" name="listing_type">
                                            <?php echo listing_type(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="col-lg-8 col-md-6 col-12">
                            <div class="form-style">
                                <label class="input-label">Listing Package</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" id="package_id" name="package_id">
                                        <?php echo getPostPackages(0); ?>
                                    </select>
                                    <input type="hidden" name="advert_type" value="Free">
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <h3>Product info</h3>
                <fieldset class="step-wrapper form-wrapper" id="product_info">
                    <h2><span>Update</span> Product Information</h2>
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <div class="form-style">
                                <label class="input-label">Title</label>
                                <input type="text" name="title" id="title" class="inputbox-style required" placeholder="eg new toyota camry 2016">
                            </div>
                            <div class="form-style">
                                <label class="input-label">Listing-Link(URL)</label>
                                <input type="text" name="post_slug" class="inputbox-style required" id="postSlug" placeholder="Your link">
                            </div>
                            <div class="form-style">
                                <label class="input-label">Currency</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select name="pricein" class="input-style required" id="currency" onchange="fCurrency(this.value)">
                                        <option value="USD">Currency:  &dollar; USD </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-style">
                                <label class="input-label">Price</label>
                                <input placeholder="Price" name="pricevalue" type="text" onKeyPress="return DegitOnly(event);" class="inputbox-style required"
                                        onchange="document.getElementById('pre-pricevalue').innerHTML = priceFormat(this.value)"/>
                            </div>
                            <div class="form-style">

                            </div>
                        </div>
                        <div class="col-lg-8 col-12">
                            <div class="form-style">
                                <label class="input-label">Description</label>
                                <textarea class="inputbox-style required" rows="5"  name="description" id="description" placeholder="Description"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-style">
                                <label class="input-label">Age</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style" name="car_age" id="car_age">
                                        <option value="">Select car age</option>
                                        <?php echo GlobalHelper::car_age(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12" id="category_id_div" style="display: none">
                            <div class="form-style">
                                <label class="input-label">Part Category</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" id="category_id" name="category_id">
                                        <?php echo GlobalHelper::parts_categories(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12" id="parts_for_div" style="display: none">
                            <div class="form-style">
                                <label class="input-label">Parts For</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" id="parts_for" name="parts_for">
                                        <?php echo GlobalHelper::parts_for(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12" id="parts_description_div" style="display: none">
                            <div class="form-style">
                                <label class="input-label">Parts Name</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" id="parts_description" name="parts_description">
                                        <?php echo GlobalHelper::parts_description(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12" id="parts_id_div" style="display: none">
                            <div class="form-style">
                                <label class="input-label">Parts Id</label>
                                <input placeholder="Parts Id" name="parts_id" type="text" class="inputbox-style"/>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12" id="registration_number_div">
                            <div class="form-style">
                                <label class="input-label">Registration Number</label>
                                <input type="text" placeholder="Registration Number" class="inputbox-style" id="RegistrationNumber" name="registration_no"
                                        onchange="document.getElementById('pre-registration_no').innerHTML = this.value">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12" id="mileage_div">
                            <div class="form-style">
                                <label class="input-label">Mileage (Miles)</label>
                                <input type="number" placeholder="Type your car mileage (miles)" class="inputbox-style" id="mileage" name="mileage"
                                        onKeyPress="return DegitOnly(event);" onchange="document.getElementById('pre-mileage').innerHTML = this.value">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-style">
                                <label class="input-label">Year of Manufacture</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select name="manufacture_year" class="input-style required" id="manufacture_year">
                                        <option value="">Please Select</option>
                                        <?php echo numericDropDown(1950, date('Y'), 1); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-style">
                                <label class="input-label">Brand Name</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" id="brand_id" onChange="get_model(this.value);" name="brand_id">
                                        <option value="0">Select a brand</option>
                                        <?php echo Modules::run('brands/all_brands_for_automech', $brand_id, $vehicleId); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-style">
                                <label class="input-label">Model Name</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" id="model_id" name="model_id" onchange="fmodel()">
                                        <option value="" disabled selected>Model</option>
                                        <?php  echo GlobalHelper::get_brands_by_vehicle_model(0, 0);   ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12" id="fuel_type_div">
                            <div class="form-style">
                                <label class="input-label">Fuel Type</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" id="fueltype" name="fuel_id">
                                        <?php echo GlobalHelper::createDropDownFromTable($tbl = 'fuel_types', $col = 'fuel_name', 0); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12" id="engine_size_div">
                            <div class="form-style">
                                <label class="input-label">Engine Size</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select name="enginesize_id" class="input-style" id="Enginesize" onchange="fEnginesize()">
                                        <?php echo GlobalHelper::createDropDownFromTable($tbl = 'engine_sizes', $col = 'engine_size', 0); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12" id="seats_div">
                            <div class="form-style">
                                <label class="input-label">Seats</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style" name="seats" id="seats">
                                        <?php echo GlobalHelper::seat(NULL, 'Select Seats'); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12" id="gear_box_div">
                            <div class="form-style">
                                <label class="input-label">Gearbox</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style required" id="gearBox" name="gear_box_type">
                                        <?php echo GlobalHelper::gearBox(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12" id="body_type_div">
                            <div class="form-style">
                                <label class="input-label">Body Type</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style" id="Bodytype" name="body_type" onchange="fBodytype()">
                                        <?php echo GlobalHelper::createDropDownFromTable($tbl = 'body_types', $col = 'type_name'); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12" id="color_div">
                            <div class="form-style">
                                <label class="input-label">Colour</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style"  name="color" id="color">
                                        <?php echo GlobalHelper::createDropDownFromTable($tbl = 'color', $col = 'color_name'); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12" id="regiday_div">
                            <div class="form-style">
                                <label class="input-label">Registration Date</label>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-3" style="padding-right: 0px;">
                                        <div class="select2-wrapper select2-wrapper-black">
                                            <select name="regiday" class="input-style" id="regiday">
                                                <option value="">DD</option>
                                                <?php echo numericDropDown(1, 31, 1); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-3" style="padding-right: 0px; padding-left: 0px;">
                                        <div class="select2-wrapper select2-wrapper-black">
                                            <select name="regimonth" class="input-style" id="regimonth">
                                                <option value="">MM</option>
                                                <?php echo numericDropDown(1, 12, 1); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6" style="padding-left: 0px;">
                                        <div class="select2-wrapper select2-wrapper-black">
                                            <select name="regiyear" class="input-style" id="regiyear">
                                                <option value="">YYYY</option>
                                                <?php echo numericDropDown(1950, date('Y'), 1); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12" id="service_history_div">
                            <div class="form-style">
                                <label class="input-label">Service History</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style" id="Servicehistory" name="service_history">
                                        <option value="">Please Select</option>
                                        <?php echo GlobalHelper::service_history(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12" id="alloywheels_div">
                            <div class="form-style">
                                <label class="input-label">Alloy Wheels</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style" id="alloywheels" name="alloywheels">
                                        <?php echo GlobalHelper::wheel_list(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="form-style">
                                <label class="input-label">Owner</label>
                                <div class="select2-wrapper select2-wrapper-black">
                                    <select class="input-style" id="owners" name="owners">
                                        <option value="">Please Select</option>
                                        <?php echo GlobalHelper::owners(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="spf">
                        <div class="col-12">
                            <h3><span>Special</span> Features</h3>
                        </div>
                        <?php echo GlobalHelper::all_features_new() ; ?>
                    </div>
                </fieldset>
                <h3>Product photo</h3>
                <fieldset class="step-wrapper form-wrapper" id="product_photo">
                    <h2><span>Your</span> Pictures</h2>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12 sell-front">
                            <p class="upload-label">Front</p>
                            <label for="uploadimg_front" class="upload-img-wrap front">
                                <img src="image" alt="image">
                                <input required onchange="instantShowUploadImage(this, '.sell-front')"
                                        type="file" id="uploadimg_front" name="front_img">
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 sell-back">
                            <p class="upload-label">Back</p>
                            <label for="uploadimg_back" class="upload-img-wrap back">
                                <img id="back" src="image" alt="image">
                                <input required onchange="instantShowUploadImage(this, '.sell-back')"
                                        type="file" id="uploadimg_back" name="back_img">
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 sell-left">
                            <p class="upload-label">Left Side</p>
                            <label for="uploadimg_left" class="upload-img-wrap left">
                                <img id="left" src="image" alt="image">
                                <input required onchange="instantShowUploadImage(this, '.sell-left')"
                                        type="file" id="uploadimg_left" name="left_img">
                            </label>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12 sell-right">
                            <p class="upload-label">Right Side</p>
                            <label for="uploadimg_right" class="upload-img-wrap right">
                                <img id="right" src="image" alt="image">
                                <input required onchange="instantShowUploadImage(this, '.sell-right')"
                                        type="file" id="uploadimg_right" name="right_img">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="file-upload">
                                <div class="dropezone" id="dropzone-wrapper">
                                    <div class="dropzon-content" id="textbox-wrapper">
                                        <div class="dropzone-info" id=textbox>
                                            <img src="assets/theme/new/images/icons/upload/camera.png" alt="image">
                                        </div>
                                    </div>
                                    <div class="dropzone-trigger" id="dropzone"></div>
                                </div>
                                <p class="addmore-product">Add more photos</p>
                                <div id="output">
                                    <ul></ul>
                                </div>
                            </div>
                            <p class="imgSize">Image Size: To get best view, Image size should be 875
                                pixel
                                by 540 pixel</p>

                        </div>
                    </div>
                </fieldset>
                <h3>Preview</h3>
                <fieldset class="step-wrapper form-wrapper">
                    <div id="preview">
                        <h2 id="pre-title"></h2>
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <ul class="preview-list">
                                    <li class="left">
                                        <h4><img src="assets/theme/new/images/icons/map.png" alt="image"><span id="pre-location"></span></h4>
                                    </li>
                                    <li class="right">
                                        <span>PRICE</span>
                                        <h4><span id="pre-price-icon">&#x20A6;</span><span id="pre-pricevalue"></span></h4>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-8 col-12">
                                <div class="preview-wrapper">
                                    <div id="productSlider" class="product-slider-active2">
                                        <div class="product-img sell-front">
                                            <a class="popup-img" href="">
                                                <img src="" alt="image">
                                            </a>
                                        </div>
                                        <div class="product-img sell-back">
                                            <a class="popup-img" href="">
                                                <img src="" alt="image">
                                            </a>
                                        </div>
                                        <div class="product-img sell-left">
                                            <a class="popup-img" href="">
                                                <img src="" alt="image">
                                            </a>
                                        </div>
                                        <div class="product-img sell-right">
                                            <a class="popup-img" href="">
                                                <img src="" alt="image">
                                            </a>
                                        </div>
                                    </div>
                                    <div id="productThumb" class="product-slider-thumbnil2">
                                        <div class="product-thumbnil sell-front">
                                            <img src="" alt="image">
                                        </div>
                                        <div class="product-thumbnil sell-back">
                                            <img src="" alt="image">
                                        </div>
                                        <div class="product-thumbnil sell-left">
                                            <img src="" alt="image">
                                        </div>
                                        <div class="product-thumbnil sell-right">
                                            <img src="" alt="image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <ul class="preview-wrapper-sidebar">
                                    <li>
                                        <span>Name</span>
                                        <h4><?php echo getLoginUserData('name'); ?></h4>
                                    </li>
                                    <li>
                                        <span>Email</span>
                                        <?php if($user && $user->email) : ?>
                                            <h4><?php echo $user->email; ?></h4>
                                        <?php else : ?>
                                            <h4 id="pre-email"></h4>
                                        <?php endif; ?>
                                    </li>
                                    <li>
                                        <span>City</span>
                                        <?php if($user && $user->city) : ?>
                                            <h4><?php echo $user->city; ?></h4>
                                        <?php else : ?>
                                            <h4 id="pre-city"></h4>
                                        <?php endif; ?>
                                    </li>
                                    <li>
                                        <span>State/Region</span>
                                        <?php if($user && $user->state) : ?>
                                            <h4><?php echo $user->state; ?></h4>
                                        <?php else : ?>
                                            <h4 id="pre-state"></h4>
                                        <?php endif; ?>
                                    </li>
                                    <li>
                                        <span>Phone Number</span>
                                        <?php if($user && $user->contact) : ?>
                                            <h4><?php echo $user->contact; ?></h4>
                                        <?php else : ?>
                                            <h4 id="pre-contact"></h4>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <h4 class="details-title">Details</h4>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="details-item">
                                            <div class="details-icon">
                                                <img src="assets/theme/new/images/icons/preview/icon1.png" alt="image">
                                            </div>
                                            <div class="details-content">
                                                <span>Brand</span>
                                                <strong id="pre-brand-2">No Data</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="details-item">
                                            <div class="details-icon">
                                                <img src="assets/theme/new/images/icons/preview/icon2.png" alt="image">
                                            </div>
                                            <div class="details-content">
                                                <span>Fuel Type</span>
                                                <strong id="pre-fuel">No Data</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="details-item">
                                            <div class="details-icon">
                                                <img src="assets/theme/new/images/icons/preview/icon3.png" alt="image">
                                            </div>
                                            <div class="details-content">
                                                <span>Driven</span>
                                                <strong id="pre-mileage">No Data</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="details-item">
                                            <div class="details-icon">
                                                <img src="assets/theme/new/images/icons/preview/icon4.png" alt="image">
                                            </div>
                                            <div class="details-content">
                                                <span>Color</span>
                                                <strong id="pre-color">No Data</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <ul class="nav preview-tabs">
                                    <li><a class="active" href="javascript:void(0)" data-toggle="tab" data-target="#tab-description">Description
                                        </a></li>
                                    <li><a href="javascript:void(0)" data-toggle="tab" data-target="#registration_info">Registration Info</a>
                                    </li>
                                    <li><a href="javascript:void(0)" data-toggle="tab" data-target="#others_info">Other Info</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-description">
                                        <p class="discription" id="pre-description"></p>
                                    </div>
                                    <div class="tab-pane" id="registration_info">
                                        <ul class="discription-info">
                                            <li><strong>Registration Number</strong> <span id="pre-registration_no">No Data</span>
                                            </li>
                                            <li><strong>Registration Date </strong>
                                                <span id="pre-registration-date">
                                                    <span id="pre-year" style="margin-left: 0px;">0000</span>
                                                    <span style="margin-left: 0px;">-</span>
                                                    <span id="pre-month" style="margin-left: 0px;">00</span>
                                                    <span style="margin-left: 0px;">-</span>
                                                    <span id="pre-day" style="margin-left: 0px;">00</span>
                                                </span>
                                            </li>
                                            <li><strong>Brand Name </strong> <span id="pre-brand">No Data</span></li>
                                            <li><strong>Model Name</strong> <span id="pre-model">No Data</span></li>
                                            <li><strong>Engine Size</strong> <span id="pre-engine">No Data</span></li>
                                            <li><strong>Body Type</strong> <span id="pre-body-type">No</span></li>
                                        </ul>
                                    </div>
                                    <div class="tab-pane" id="others_info">
                                        <ul class="discription-info">
                                            <li><strong>Product Type</strong> <span id="pre-pro-type">No Data</span>
                                            </li>
                                            <li><strong>Fuel Type </strong> <span id="pre-fuel-2">No Data</span>
                                            </li>
                                            <li><strong>Color </strong> <span id="pre-color-2">No Data</span></li>
                                            <li><strong>Alloy wheels</strong> <span id="pre-alloy">No Data</span></li>
                                            <li><strong>Gear Box</strong> <span id="pre-gear">No Data</span></li>
                                            <li><strong>Owners</strong> <span id="pre-owners">No Data</span></li>
                                            <li><strong>Service history</strong> <span id="pre-ser">No Data</span></li>
                                            <li><strong>Condition</strong> <span id="pre-condition">No Data</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h3><span>Special</span> Features</h3>
                            </div>
                            <div class="col-12">
                                <ul class="featured-list-item" id="pre-feature">
                                </ul>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modalWrapper" id="carValuationModal"  data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close carValuationModalClose" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="carValuationModalInfo">
                <h3>Do you want to get a valuation for your car?</h3>
                <ul class="yesNoBtn">
                    <li id="yesBtn">YES</li>
                    <li class="carValuationModalClose" id="noBtn">NO</li>
                </ul>
            </div>
            <form class="row" id="modalCarValuationForm" style="display:none">
                <div class="col-12">
                    <h1 class="review-title">Tell us about your car</h1>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-style">
                        <label class="input-label">Car Type</label>
                        <div class="select2-wrapper select2-wrapper-black">
                            <select class="input-style" id="vehicle_type_id_modal">
                                <?php echo GlobalHelper::dropDownVehicleListForVariants($this->input->get('post_type')); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-style">
                        <label class="input-label">Search Brand</label>
                        <div class="select2-wrapper select2-wrapper-black">
                            <select class="input-style" onChange="get_model(this.value);" id="brandName">
                                <?php echo GlobalHelper::getAllBrands(1); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-style">
                        <label class="input-label">Search Model</label>
                        <div class="select2-wrapper select2-wrapper-black">
                            <select class="input-style" id="model_id_modal" name="model_id_modal">
                                <option value="">Select Model</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-style">
                        <label class="input-label">Manufacturing Years</label>
                        <div class="select2-wrapper select2-wrapper-black">
                            <select class="input-style" id="manufacture_year_modal">
                                <option value="">Please Select Year</option>
                                <?php echo numericDropDown(1950, date('Y'), 1, 0, true); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-style">
                        <label class="input-label">Car Variant</label>
                        <div class="select2-wrapper select2-wrapper-black">
                            <select class="input-style" id="vehicle_variant">
                                <option value="">Select Variant</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-style">
                        <label class="input-label">Mileage (KM)</label>
                        <div id="mileageSlider" class="rangeSlider"></div>
                        <input class="range-slider-input" type="text" id="mileageRange" readonly>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-style">
                        <label class="input-label">Body Condition</label>
                        <div class="select2-wrapper select2-wrapper-black">
                            <select class="input-style" id="body_condition">
                                <option value="">Select Body Condition</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button type="button"
                            class="btn-wrap get-valuation-btn" id="car_valuation_button">Get
                        a Valuation</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade modalWrapper" id="vehicleInfo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="valuationResult">
                <h3>Your Car Value is: <span class="car-value"></span></h3>
            </div>
        </div>
    </div>
</div>
<script src="assets/theme/new/js/jquery-3.4.1.min.js"></script>
<script src="assets/theme/new/js/jquery-ui.min.js"></script>
<!-- <script src="assets/theme/new/js/multi-image-upload.js"></script> -->
<script src="assets/theme/new/js/jquery.steps.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script src="assets/theme/new/js/slick.min.js"></script>

<script>
    var form = $("#list-add").show();
    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        labels: {
            current: false,
            pagination: "Pagination",
            finish: "Submit",
            next: "Save & Continue",
            previous: "Previous",
            loading: "Loading ..."
        },
        onStepChanging: function (event, currentIndex, newIndex){
            if (currentIndex > newIndex){
                return true;
            }
            if (newIndex === 3 && Number($("#age-2").val()) < 18){
                return false;
            }
            if (currentIndex < newIndex){
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex){
            if(($('#list-add-p-1').attr('aria-hidden') === 'false') && (window.localStorage.getItem('modalClose') == null)){
                $('#carValuationModal').modal()
            }
            if($('#list-add-p-3').hasClass('current')){
                setTimeout(function(){ 
                    $('#preview #productSlider').not('.slick-initialized').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                        fade: true,
                        asNavFor: '#preview #productThumb'
                    });
                    $('#preview #productThumb').not('.slick-initialized').slick({
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        asNavFor: '#preview #productSlider',
                        dots: false,
                        focusOnSelect: true
                    });
                    $('.popup-img').magnificPopup({
                        type: 'image',
                        gallery: {
                            enabled: true
                        },
                    });
                 }, 1000);
                
            }
        },
        }).validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
        });

        $(document).on('click','.carValuationModalClose',function(){
            $('#carValuationModal').modal('hide');
            window.localStorage.setItem('modalClose', true);
        })

        $(document).on('click','#yesBtn',function(){
            $('#modalCarValuationForm').show();
            $('.carValuationModalInfo').hide();
        })
        $(document).on('click','#dropzone',function(){
            if($('#output ul li').length >= 4){
                alert('You can uploaded more then 8 images')
            }
        })
</script>
<script>
    $(function () {
        $("#mileageSlider").slider({
            range: true,
            min: 0,
            max: 120000,
            values: [0, 120000],
            slide: function (event, ui) {
                $("#mileageRange").val(ui.values[0] + " - " + ui.values[1]);
            }
        });
        $("#mileageRange").val(
            $("#mileageSlider").slider("values", 0) + " - " +
            $("#mileageSlider").slider("values", 1)
        );
    });
    $("#vehicle_type_id, #brandName, #model_id_modal, #manufacture_year_modal").change(function () {
        let vehicle_type_id = $("#vehicle_type_id").val();
        let brandName = $("#brandName").val();
        let model_id = $("#model_id_modal").val();
        let manufacture_year = $("#manufacture_year_modal").val();

        jQuery.ajax({
            url: 'get_vehicle_variant/',
            type: "POST",
            dataType: "text",
            data: {
                vehicle_type_id: vehicle_type_id,
                brandName: brandName,
                model_id: model_id,
                manufacture_year: manufacture_year
            },
            beforeSend: function () {
                jQuery('#vehicle_variant').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#vehicle_variant').html(response);
            }
        });
    });


    $("#vehicle_type_id, #brandName, #model_id_modal, #manufacture_year_modal, #vehicle_variant").change(function () {
        let vehicle_type_id = $("#vehicle_type_id").val();
        let brandName = $("#brandName").val();
        let model_id = $("#model_id_modal").val();
        let manufacture_year = $("#manufacture_year_modal").val();
        let vehicle_variant = $("#vehicle_variant").val();

        jQuery.ajax({
            url: 'get_body_condition/',
            type: "POST",
            dataType: "text",
            data: {
                vehicle_type_id: vehicle_type_id,
                brandName: brandName,
                model_id: model_id,
                manufacture_year: manufacture_year,
                vehicle_variant: vehicle_variant
            },
            beforeSend: function () {
                jQuery('#body_condition').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#body_condition').html(response);
            }
        });
    });

    function get_model(id) {
        jQuery.ajax({
            url: 'get_brands',
            type: "POST",
            dataType: "text",
            data: {id: id},
            beforeSend: function () {
                jQuery('#model_id_modal').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#model_id_modal').html(response);
            }
        });
    }

    $("#car_valuation_button").click(function () {
        let vehicle_type_id = $("#vehicle_type_id").val();
        let brandName = $("#brandName").val();
        let model_id = $("#model_id_modal").val();
        let manufacture_year = $("#manufacture_year_modal").val();
        let vehicle_variant = $("#vehicle_variant").val();
        let mileage_range = $("#mileageRange").val();
        let body_condition = $("#body_condition").val();
        if (vehicle_type_id == 0 || vehicle_type_id == null) {
            tosetrMessage('error', 'Select car type');
            return;
        }

        if (brandName == 0 || brandName == null) {
            tosetrMessage('error', 'Select brand name');
            return;
        }
        if (model_id == 0 || model_id == null) {
            tosetrMessage('error', 'Select model');
            return;
        }

        if (manufacture_year == 0 || manufacture_year == null) {
            tosetrMessage('error', 'Select manufacture year');
            return;
        }

        if (vehicle_variant == 0 || vehicle_variant == null) {
            tosetrMessage('error', 'Select variant');
            return;
        }

        jQuery.ajax({
            url: 'get_car_valuation_price',
            type: "POST",
            dataType: "text",
            data: {
                vehicle_type_id: vehicle_type_id,
                brandName: brandName,
                model_id: model_id,
                manufacture_year: manufacture_year,
                vehicle_variant: vehicle_variant,
                mileage_range: mileage_range,
                body_condition: body_condition,
            },
            success: function (response) {
                response = JSON.parse(response);
                $(".car-value").text(response.message);
                //from_year=1963&to_year=0&fuel_type=0&condition=0&color_id=0&gear_box=0&address=&lat=&lng=&post_slug=search%3F&page=
                let queryString = "search?type_id=" + vehicle_type_id + "&brand_id=" + brandName + "&model_id=" + model_id + "&from_year=" + manufacture_year;
                $("#go-to-list").attr('href', queryString);
                $("#vehicleInfo").modal();
                $('#carValuationModal').modal('hide')
                window.localStorage.setItem('modalClose', true);
            }
        });

        function tosetrMessage(type, message) {
            $('.tostfyMessage').css({ "top": "5px", "visibility": "visible", "opacity": 1 });
            $('.tostfyMessage').find('.messageValue').text(message);
            if (type == 'success') {
                $('.tostfyMessage').addClass('bg-success')
            } else if (type == 'warning') {
                $('.tostfyMessage').addClass('bg-warning')
            } else if (type == 'error') {
                $('.tostfyMessage').addClass('bg-danger')
            }
            setTimeout(function () {
                $('.tostfyMessage').css({ "top": "-100%", "visibility": "hidden", "opacity": 0 })
            }, 10000);
            $('.tostfyClose').on('click', function () {
                $('.tostfyMessage').css({ "top": "-100%", "visibility": "hidden", "opacity": 0 })
            })
        }
    });
</script>
<script>
    $(document).ready(function () {
        $("#title").on('keyup keypress blur change', function () {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            var regExp = /\s+/g;
            Text = Text.replace(regExp, '-');
            $("#postSlug").val(Text);
            $(".pageSlug").text(Text);

            $("#pre-title").html($("#title").val());
        });

        $("#postSlug").on('keyup keypress blur change', function () {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            var regExp = /\s+/g;
            Text = Text.replace(regExp, '-');
            $("#postSlug").val(Text);
            $(".pageSlug").text(Text);
        });

        $("#regiday").on('change', function () {
            $("#pre-day").html($( "#regiday option:selected" ).text());
        });

        $("#regimonth").on('change', function () {
            $("#pre-month").html($( "#regimonth option:selected" ).text());
        });

        $("#regiyear").on('change', function () {
            $("#pre-year").html($( "#regiyear option:selected" ).text());
        });

        $("#fueltype").on('change', function () {
            $("#pre-fuel").html($( "#fueltype option:selected" ).text());
            $("#pre-fuel-2").html($( "#fueltype option:selected" ).text());
        });

        $("#color").on('change', function () {
            $("#pre-color").html($( "#color option:selected" ).text());
            $("#pre-color-2").html($( "#color option:selected" ).text());
        });

        $("#alloywheels").on('change', function () {
            $("#pre-alloy").html($( "#alloywheels option:selected" ).text());
        });

        $("#gearBox").on('change', function () {
            $("#pre-gear").html($( "#gearBox option:selected" ).text());
        });

        $("#owners").on('change', function () {
            $("#pre-owners").html($( "#owners option:selected" ).text());
        });

        $("#Servicehistory").on('change', function () {
            $("#pre-ser").html($( "#Servicehistory option:selected" ).text());
        });

        $("#condition").on('change', function () {
            $("#pre-condition").html($( "#condition option:selected" ).text());
        });

        $("#description").on('change blur', function () {
            $("#pre-description").html($("#description").val());
        });

    });

    function fFeature(id) {
        if ($("#"+id).is(":checked")) {
            var text = $("#"+id).data('txt');
            $html = "<li id='pre-"+id+"'>"+text+"</li>";
            $("#pre-feature").append($html)
        } else {
            $("#pre-"+id).css('display', 'none');
        }
    }

    function get_model(id) {
        var vehicle_type_id = $('#vehicle_type_id').val();

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

        $( "#pre-brand" ).html($( "#brand_id option:selected" ).text());
        $( "#pre-brand-2" ).html($( "#brand_id option:selected" ).text());

    }

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

    function instantShowUploadImage(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(target + ' img').attr('src', e.target.result);
                $(target + ' a').attr('href', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
        $(target).show();
    }

    function fCurrency(value) {
        if (value === 'USD') {
            $("#pre-price-icon").html("$");
        } else {
            $("#pre-price-icon").html("&#x20A6;");
        }
    }

    function fmodel() {
        $( "#pre-model" ).html($( "#model_id option:selected" ).text());
    }

    function fEnginesize() {
        $( "#pre-engine" ).html($( "#Enginesize option:selected" ).text());
    }

    function fBodytype() {
        $( "#pre-body-type" ).html($( "#Bodytype option:selected" ).text())
    }

    function number_format (number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    function priceFormat(price) {
        if (price) {
            return number_format(price, 0);
        }

        return 0;
    }

    $('.actions ul li a[href="#finish"]').on('click', function () {
        $("#list-add").submit();
    });

    // $('#list-add').on('submit', function (e) {
    //     e.preventDefault();
    //
    //     $.ajax({
    //         url: "product-add", // Url to which the request is send
    //         type: "POST",               // Type of request to be send, called as method
    //         data: new FormData(this),   // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    //         dataType: 'json',
    //         cache:false,
    //         contentType: false,
    //         processData: false,// Data sent to server, a set of key/value pairs (i.e. form fields and values)
    //         success: function (jsonRespond) {
    //             $('#response_upload').html(jsonRespond.Msg);
    //
    //             if (jsonRespond.Status === 'SUCCESS') {
    //                 tosetrMessage('success', jsonRespond.Msg);
    //                 setTimeout(function () {
    //                     window.location.reload();
    //                 }, 2000);
    //             }
    //         }
    //     });
    //
    // });

    function tosetrMessage(type, message) {
        $('.tostfyMessage').css({ "top": "5px", "visibility": "visible", "opacity": 1 });
        $('.tostfyMessage').find('.messageValue').text(message);
        if (type == 'success') {
            $('.tostfyMessage').addClass('bg-success')
        } else if (type == 'warning') {
            $('.tostfyMessage').addClass('bg-warning')
        } else if (type == 'error') {
            $('.tostfyMessage').addClass('bg-danger')
        }
        setTimeout(function () {
            $('.tostfyMessage').css({ "top": "-100%", "visibility": "hidden", "opacity": 0 })
        }, 10000);
        $('.tostfyClose').on('click', function () {
            $('.tostfyMessage').css({ "top": "-100%", "visibility": "hidden", "opacity": 0 })
        })
    }

    $(document).ready(function () {
        setTimeout(function () {
                var vehicle_type_id = "<?php echo $vehicleId;?>";

                if (vehicle_type_id === "4") {
                    $("#category_id_div").css('display', 'block');
                    $("#parts_for_div").css('display', 'block');
                    $("#parts_description_div").css('display', 'block');
                    $("#parts_id_div").css('display', 'block');
                    $("#registration_number_div").css('display', 'none');
                    $("#mileage_div").css('display', 'none');
                    $("#fuel_type_div").css('display', 'none');
                    $("#engine_size_div").css('display', 'none');
                    $("#body_type_div").css('display', 'none');
                    $("#gear_box_div").css('display', 'none');
                    $("#color_div").css('display', 'none');
                    $("#regiday_div").css('display', 'none');
                    $("#service_history_div").css('display', 'none');
                    $("#alloywheels_div").css('display', 'none');
                    $("#v_con").html("Parts Condition");
                } else {
                    $("#category_id_div").css('display', 'none');
                    $("#parts_for_div").css('display', 'none');
                    $("#registration_number_div").css('display', 'block');
                    $("#mileage_div").css('display', 'block');
                    $("#fuel_type_div").css('display', 'block');
                    $("#engine_size_div").css('display', 'block');
                    $("#body_type_div").css('display', 'block');
                    $("#gear_box_div").css('display', 'block');
                    $("#color_div").css('display', 'block');
                    $("#regiday_div").css('display', 'block');
                    $("#service_history_div").css('display', 'block');
                    $("#alloywheels_div").css('display', 'block');
                    $("#parts_description_div").css('display', 'none');
                    $("#parts_id_div").css('display', 'none');
                    $("#v_con").html("Vehicle Condition");
                }

                if (vehicle_type_id === "4" || vehicle_type_id === "3") {
                    $("#spf").css('display', 'none');
                    $("#seats_div").css('display', 'none');
                } else {
                    $("#spf").css('display', 'flex');
                    $("#seats_div").css('display', 'block');
                }

            $("#pre-pro-type").html($( "#vehicle_type_id option:selected" ).text());
        }, 2000);
    });

    function vehicle_change() {
        var vehicle_type_id = $("#vehicle_type_id").val();

        if (vehicle_type_id === "4") {
            $("#category_id_div").css('display', 'block');
            $("#parts_for_div").css('display', 'block');
            $("#parts_description_div").css('display', 'block');
            $("#parts_id_div").css('display', 'block');
            $("#registration_number_div").css('display', 'none');
            $("#mileage_div").css('display', 'none');
            $("#fuel_type_div").css('display', 'none');
            $("#engine_size_div").css('display', 'none');
            $("#body_type_div").css('display', 'none');
            $("#gear_box_div").css('display', 'none');
            $("#color_div").css('display', 'none');
            $("#regiday_div").css('display', 'none');
            $("#service_history_div").css('display', 'none');
            $("#alloywheels_div").css('display', 'none');
            $("#v_con").html("Parts Condition");
        } else {
            $("#category_id_div").css('display', 'none');
            $("#parts_for_div").css('display', 'none');
            $("#registration_number_div").css('display', 'block');
            $("#mileage_div").css('display', 'block');
            $("#fuel_type_div").css('display', 'block');
            $("#engine_size_div").css('display', 'block');
            $("#body_type_div").css('display', 'block');
            $("#gear_box_div").css('display', 'block');
            $("#color_div").css('display', 'block');
            $("#regiday_div").css('display', 'block');
            $("#service_history_div").css('display', 'block');
            $("#alloywheels_div").css('display', 'block');
            $("#parts_description_div").css('display', 'none');
            $("#parts_id_div").css('display', 'none');
            $("#v_con").html("Vehicle Condition");
        }

        if (vehicle_type_id === "4" || vehicle_type_id === "3") {
            $("#spf").css('display', 'none');
            $("#seats_div").css('display', 'none');
        } else {
            $("#spf").css('display', 'flex');
            $("#seats_div").css('display', 'block');
        }

        $("#pre-pro-type").html($( "#vehicle_type_id option:selected" ).text());

    }

</script>


