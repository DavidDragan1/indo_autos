<!-- featured area  -->
<?php
$vehicleId = 0;
$listingType = 'Personal';

if (getLoginUserData('role_id') == 4 || getLoginUserData('role_id') == 8) $listingType = 'Business';

switch ($this->input->get('post_type', TRUE)) {
    case "car":
        $vehicleId = 1;
        break;
    case "vans":
        $vehicleId = 2;
        break;
    case "motorbike":
        $vehicleId = 3;
        break;
    case "spare-parts":
        $vehicleId = 4;
        break;
    case "import-car":
        $vehicleId = 5;
        break;
    case "auction-cars":
        $vehicleId = 6;
        break;
    default:
}


?>
<div class="row">
    <div id="add_product_container" class="col-xl-10 offset-xl-1">
        <h2 class="fs-18 fw-500 color-seconday mb-25">Add a Product</h2>
        <form id="add_product" class="add_product-wrapper" action="<?php echo $action; ?>"
              enctype="multipart/form-data">
            <h3><span class="type_change_name">Vehicle</span> Details</h3>
            <fieldset class="step-wrapper">
                <div class="row">
                    <div class="col-12">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block"><span class="type_change_name">Vehicle</span> Type</span>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="input-field">
                            <input id="title" name="title" type="text" class="input-change">
                            <label for="title"><span>Title</span></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style mb-15">
                            <select name="vehicle_type_id" id="vehicle_type_id" onChange="vehicle_change(this.value);"
                                    class="browser-default input-change">
                                <?php echo GlobalHelper::dropDownVehicleList($this->input->get('post_type')); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style  mb-15">
                            <select id="condition" name="condition" class="browser-default input-change">
                                <?php echo GlobalHelper::getConditions(0); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-12">
                        <div class="input-field slug_icon" >
                            <input id="post_url" name="post_url" type="text" class="input-change" required>
                            <i class="fa fa-globe"> Post Url</i>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block"><span class="type_change_name">Vehicle</span> Specification</span>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style  mb-15">
                            <select id="brand_id" onChange="get_model(this.value);" name="brand_id"
                                    class="browser-default input-change">
                                <option value="" disabled selected>Brand</option>
                                <?php echo Modules::run('brands/all_brands_for_automech', 0, $vehicleId); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style  mb-15">
                            <select id="model_id" name="model_id"
                                    class="browser-default input-change">
                                <option value="" disabled selected>Model</option>
                                <?php echo GlobalHelper::get_brands_by_vehicle_model(0, 0); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style  mb-15">
                            <select onchange="changeToYear(this.value)" name="manufacture_year" id="manufacture_year" class="browser-default input-change">
                                <option value="" disabled selected>Year of Manufacture</option>
                                <?php echo numericDropDown(1950, date('Y'), 1); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 parts">
                        <div class="select2-style  mb-15">
                            <select name="to_year" id="to_year" class="browser-default input-change">
                                <option value="" disabled selected>To Year</option>
<!--                                --><?php //echo numericDropDown(1950, date('Y'), 1); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="input-field">
                            <input id="reg_date" name="reg_date" type="date" class="datepicker input-change"
                                   placeholder="Registration Date">
                            <label for="title"><span>Registration Date</span></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12  car motorbike">
                        <div class="select2-style  mb-15">
                            <select id="fuel_type" name="fuel_id" class="browser-default input-change">
                                <option value="" disabled selected>Fuel Type</option>
                                <?php echo GlobalHelper::createDropDownFromTable($tbl = 'fuel_types', $col = 'fuel_name', 0); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="select2-style  mb-15">
                            <select name="enginesize_id" id="engine_size"
                                    class="browser-default input-change" >
<!--                                <option value="" disabled selected>Engine Size</option>-->
<!--                                --><?php //echo GlobalHelper::createDropDownFromTable($tbl = 'engine_sizes', $col = 'engine_size', 0); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car">
                        <div class="select2-style  mb-15">
                            <select name="seats" id="seats" class="browser-default input-change">
                                <?php echo GlobalHelper::seat(NULL, 'Seats'); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="select2-style  mb-15">
                            <select id="body_type" name="body_type" class="browser-default input-change">
                                <option value="" disabled selected>Body Type</option>
<!--                                --><?php //echo GlobalHelper::getVehicleBodyTypeDropdown(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="select2-style  mb-15">
                            <select name="color" id="color" class="browser-default input-change">
                                <option value="" disabled selected>Color</option>
                                <?php echo GlobalHelper::createDropDownFromTable($tbl = 'color', $col = 'color_name'); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car">
                        <div class="select2-style  mb-15">
                            <select id="gear_box" name="gear_box_type" class="browser-default input-change" required>
                                <?php echo GlobalHelper::gearBox(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car">
                        <div class="select2-style  mb-15">
                            <select id="service_history" name="service_history" class="browser-default input-change">
                                <option value="" disabled selected>Service History</option>
                                <?php echo GlobalHelper::service_history(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car">
                        <div class="select2-style  mb-15">
                            <select id="alloywheels" name="alloywheels" class="browser-default input-change">
                                <option value="" disabled selected>Alloy Wheels</option>
                                <?php echo GlobalHelper::wheel_list(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12 car">
                        <div class="select2-style  mb-15">
                            <select id="owners" name="owners" class="browser-default input-change">
                                <option value="" disabled selected>Owner</option>
                                <?php echo GlobalHelper::owners(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="input-field">
                            <input id="mileage" name="mileage" type="number" class="input-change">
                            <label for="mileage"><span>Mileage</span></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="input-field">
                            <input id="registration_no" name="registration_no" type="number" class="input-change">
                            <label for="registration_no"><span>Registration Number</span></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car motorbike" >
                        <div class="select2-style  mb-15">
                            <select id="car_age" name="car_age" class="browser-default input-change">
                                <option value="" disabled selected>Age</option>
                                <?php echo GlobalHelper::car_age(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 parts">
                        <div class="select2-style  mb-15">
                            <select id="category_id" name="category_id" class="browser-default input-change">
                                <option value="" disabled selected>Part Category</option>
                                <?php echo GlobalHelper::parts_categories(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 parts">
                        <div class="input-field">
                            <input name="parts_id" id="parts_id" type="text" class="input-change">
                            <label for="title"><span>Parts Id</span></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 parts">
                        <div class="select2-style  mb-15">
                            <select id="parts_description" name="parts_description"
                                    class="browser-default input-change">
                                <option value="" disabled selected>Parts Name</option>
                                <?php echo GlobalHelper::parts_description(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 parts">
                        <div class="select2-style  mb-15">
                            <select id="parts_for" name="parts_for" class="browser-default input-change">
                                <option value="" disabled selected>Parts For</option>
                                <?php echo GlobalHelper::parts_for(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 car ">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block">Features</span>
                    </div>
                    <div class=" col-12 car ">
                        <div class="select2-tags mb-15">
                            <select multiple="multiple" name="features[]" id="features" class="browser-default input-change">
                                <?php echo GlobalHelper::all_features_new(); ?>
                            </select>
                        </div>
                    </div>
                </div>
<!--                <div class="row">-->
<!--                    <div class="col-12 car ">-->
<!--                        <span class="fs-14 color-seconday fw-500 mb-10 d-block">Tags</span>-->
<!--                    </div>-->
<!--                    <div class=" col-12 car ">-->
<!--                        <div class="select2-tags mb-15">-->
<!--                            <select multiple="multiple" name="tags[]" id="tags" class="browser-default input-change">-->
<!--                                --><?php //echo GlobalHelper::all_tags(); ?>
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="row">
                    <div class="col-12">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block">Description</span>
                    </div>
                    <div class=" col-12">
                        <div class="input-field">
                            <textarea class="materialize-textarea input-change" rows="5" name="description"
                                      id="description" placeholder="Description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block">Location</span>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style mb-15">
                            <select name="location_id" id="location_id" onchange="getCity()"
                                    class="browser-default input-change">
                                <option value="" disabled selected>Select State</option>
                                <?php echo GlobalHelper::all_location(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style  mb-15">
                            <select name="location" id="location" class="browser-default input-change">
                                <?php echo GlobalHelper::all_city(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-field">
                            <input id="address" class="input-change" name="address" type="text">
                            <label for="email"><span>Enter Address</span></label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <h3>Amount</h3>
            <fieldset class="step-wrapper">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block">Enter Vehicle Amount</span>
                        <div class="input-field input-field-icon mb-15">
                            <span class="field-icon color-theme">$</span>

                            <input id="vehicle_amount" class="number input-change" name="vehicle_amount" type="text"
                                   placeholder="Enter Amount">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block d-flex align-items-center">Suggested Vehicle Amount
                            <span style="line-height: 0; margin-left: 10px;" data-position="right"
                                              data-tooltip="This is the information buyers will if they want to contact you."
                                              class="tooltip-trigger tooltipped">
                                            <img src="assets/new-theme/images/icons/info.svg" alt="icon">
                                        </span>
                            </span>
                        <h5
                                class="fs-24 fw-500 color-theme d-flex align-items-center suggestion-amount bg-grey br-5 mb-15">
                            <span id="suggest_amount-append"></span>
                        </h5>
                    </div>

                    <div class="col-12">
                        <label class="checkbox-style">
                            <input type="checkbox" class="filled-in checkSingle checkSingle-amount"/>
                            <span> Use Suggested Amount</span>
                        </label>
                    </div>
                </div>
            </fieldset>

            <h3>Add Photo</h3>
            <fieldset class="step-wrapper">
                <!--                <input type="file" id="test-upload">-->
                <span class="fs-14 color-seconday fw-500 mb-10 d-block d-flex align-items-center">Upload
                                Vehicle Images
                                <span style="line-height: 0; margin-left: 10px;" data-position="right"
                                      data-tooltip="This is the information buyers will if they want to contact you."
                                      class="tooltip-trigger tooltipped">
                                    <img src="assets/new-theme/images/icons/info.svg" alt="icon">
                                </span></span>
                <div id="upload_btn" class="file_upload-wrap bg-grey br-5">
                    <span class="material-icons download-icon"> backup</span>
                    <p class="label">Drag file here to upload</p>
                    <span class="d-block mb-10">or</span>
                    <button class="btnStyle" type="button">Browse File</button>
                    <span class="label d-block mt-20">You can upload up to 10 Images at a time. Max Size is
                                    1mb</span>
                </div>
                <div id="upload_previews">
                    <div id="upload_previews_template"
                         class="d-flex flex-wrap upload_previews_template align-items-center">
                        <span class="preview"><img data-dz-thumbnail/></span>
                        <div class="preview-content">
                            <div class="preview-top d-flex">
                                <p class="name fs-16 fw-500 color-seconday" data-dz-name></p>
                                <span class="size fs-14" data-dz-size></span>
                                <span data-dz-remove class="material-icons">
                                                close
                                            </span>
                            </div>
                        </div>
                    </div>

                </div>
            </fieldset>

            <h3>Preview</h3>
            <fieldset class="step-wrapper">
                <div class="row">
                    <div class="col-xl-7 col-12 mb-50">
                        <div id="mainSlider" class="splide">
                            <div class="splide__track">
                                <ul class="splide__list">

                                </ul>
                            </div>
                        </div>
                        <div id="thumbSlider" class="splide">
                            <div class="splide__track">
                                <ul class="splide__list">

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-12 mb-50">
                        <div class="post-details-info">
                            <div class="post-details-info-top">
                                <div class="post-details-info-top-left">
                                    <ul class="product-info">
                                        <li class="product-id">ID: #00000</li>
                                        <li class="car motorbike"><span class="manufacture_year-show"></span></li>
                                        <li class="parts"><span><div class="manufacture_year-show d-inline-block mr-5"> </div> - <div id="to_year-show" class="ml-5 d-inline-block"></div></span></li>
                                        <li><span id="condition-show"></span></li>
                                    </ul>
                                    <h1 id="title-show"></h1>
                                </div>
                            </div>
                            <ul class="post-details-price">
                                <li>
                                    <span>Price</span>
                                    <h4><span id="pricein-show">$</span><span id="vehicle_amount-show">0</span></h4>
                                </li>
                                <li class="car motorbike">
                                    <span>Mileage</span>
                                    <h4><span id="mileage-show">0k</span> Miles</h4>
                                </li>
                            </ul>
                            <ul class="post-details-location">
                                <li><span class="material-icons">location_on</span> <span id="address-show"></span>
                                </li>
                            </ul>
                            <?= GlobalHelper::getSellerInfoAdmin(getLoginUserData('user_id')) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="vehicle-overview-wrap car motorbike">
                            <h5>Vehicle overview</h5>
                            <ul class="vehicle-overview-list">
                                <li class="vehicle-overview">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon1.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Body Colour</span>
                                        <p id="color-show">White</p>
                                    </div>
                                </li>
                                <li class="vehicle-overview motorcycle">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon2.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Body Type</span>
                                        <p id="body_type-show">Sedan</p>
                                    </div>
                                </li>
                                <li class="vehicle-overview car">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon3.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Seat</span>
                                        <p id="seats-show">4</p>
                                    </div>
                                </li>
                                <li class="vehicle-overview car">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon4.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Engine</span>
                                        <p id="engine_size-show"></p>
                                    </div>
                                </li>
                                <li class="vehicle-overview">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon5.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Fuel Type</span>
                                        <p id="fuel_type-show"></p>
                                    </div>
                                </li>
                                <li class="vehicle-overview  car">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon6.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Transmission</span>
                                        <p id="gear_box-show"></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div id="description" class="description-wrap mb-30">
                            <h4 class="fw-500 fs-18 mb-20">Description</h4>
                            <p id="description-show"></p>
                        </div>
                        <h4 class="fw-500 fs-18 mb-20 car">Features</h4>
                        <ul id="features-show" class="features-wrap car">

                        </ul>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<!-- featured area  -->

<div id="successModal" class="modal modal-wrapper small-modal-wrapper">
    <span class="material-icons modal-close">close</span>
    <div class="text-center">
        <img class="mb-15" src="assets/new-theme/images/icons/check2.svg" alt="">
        <h3 class="fw-500 fs-18 mb-30 text-center">Advert has been posted successfully</h3>

        <img class="mb-15" src="assets/new-theme/images/icons/car4.svg" alt="">
        <h4 class="fw-500 fs-18 mb-10">Would you like to feature your advert on the front page?</h4>
        <p class="fw-400 fs-14 mb-15">This will increase your chance to sell a product</p>
        <ul class="d-flex justify-content-center mb-20">
            <li class="mr-20">
                <button style="min-height: 35px;min-width: 100px;" class="modal-close btnStyle btnStyleOutline"
                        type="button">No
                </button>
            </li>
            <li>
                <button id="selectPlan" style="min-height: 35px;min-width: 100px;"
                        class="btnStyle waves-effect">Yes
                </button>
            </li>
        </ul>
        <span class="fw-400 fs-14 d-block">This will attract a fee.</span>
    </div>
</div>
<div id="waitingModal" class="modal modal-wrapper small-modal-wrapper">
    <div class="text-center">
<!--        <img class="mb-15" src="assets/new-theme/images/icons/check2.svg" alt="">-->
        <h3 class="fw-500 fs-18 mb-30 text-center">Please Wait ....</h3>
    </div>
</div>
<div 
 class="modal modal-wrapper small-modal-wrapper">
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
        <button id="selectPlanAction" style="min-height: 35px;min-width: 100px;" class="btnStyle waves-effect">Proceed to
            Payment
        </button>
        <span class="fw-400 fs-14 d-block mt-15">You will be redirected to paystack</span>
    </div>
</div>
<style>
    .slug_icon input[type="text"]{
        position: relative;
        padding-left: 145px!important;
    }
    .slug_icon i {
        position: absolute;
        top: 0;
        left: 0;
        background: #eee;
        padding: 18px 30px;
        font-size: 18px;
        border-bottom: 1px solid #eee;
        border-radius: 4px 0 0 4px;
    }
</style>

<script type="text/javascript" src="assets/new-theme/js/splide.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.steps.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
<script>
    const cookieName = '<?='cookie_name_' . time()?>';
    var vehicle_type_id = parseInt('<?=$vehicleId?>');
    var listing_type = '<?=$listingType?>'
    var priceinnaira = 0;
    var priceindoller = 0;
    var post_id = 0;

</script>
<script>


    $(window).on('load', function () {
        $('.modal-close').on('click', function () {
            window.location.href = 'admin/posts';
        })
        let secondarySlider = new Splide('#thumbSlider', {
            rewind: true,
            fixedHeight: 120,
            fixedWidth: 210,
            isNavigation: true,
            gap: 10,
            perPage: 3,
            focus: 'center',
            pagination: false,
            cover: false,
        }).mount();
        let primarySlider = new Splide('#mainSlider', {
            type: 'fade',
            heightRatio: 0.6,
            fixedWidth: 662,
            fixedHeight: 480,
            pagination: false,
            arrows: false,
            cover: true,
        });
        primarySlider.sync(secondarySlider).mount();

        let form = $("#add_product").show();
        form.steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            transitionEffect: "slideLeft",
            labels: {
                current: false,
                pagination: "Pagination",
                finish: "Submit",
                next: "Next",
                previous: "Previous",
                loading: "Loading ..."
            },
            onStepChanging: function (event, currentIndex, newIndex) {
                if (currentIndex > newIndex) {
                    return true;
                }
                if (currentIndex < newIndex) {
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                if(currentIndex === 1){
                    const get_images = getCookie()
                    if(!get_images.img || get_images.img.length < 2){
                        $('.actions ul li a[href="#next"]').addClass('disabled').removeAttr('href');
                        $('#add_product-p-2').append('<div class="error-message">Image minimum length 2<div>')
                    }else{
                        $('.actions ul li a.disabled').removeClass('disabled').attr('href','#next');
                        $('#add_product-p-2 .error-message').remove();
                    }
                }
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex) {
                if (currentIndex === 2 && priorIndex === 3) {
                    form.steps("previous");
                }

                if (currentIndex > 2) {
                    $('#add_product_container').addClass('col-12 remove-bg');
                    $('#add_product_container').removeClass('col-xl-10 offset-xl-1');
                    let secondarySlider = new Splide('#thumbSlider', {
                        rewind: true,
                        fixedHeight: 120,
                        fixedWidth: 210,
                        isNavigation: true,
                        gap: 10,
                        perPage: 3,
                        focus: 'center',
                        pagination: false,
                        cover: false,
                    }).mount();
                    let primarySlider = new Splide('#mainSlider', {
                        type: 'fade',
                        heightRatio: 0.6,
                        fixedWidth: 662,
                        fixedHeight: 480,
                        pagination: false,
                        arrows: false,
                        cover: true,
                    });
                    primarySlider.sync(secondarySlider).mount();

                    $('.tabs').tabs();

                } else {
                    $('#add_product_container').removeClass('col-12 remove-bg')
                    $('#add_product_container').addClass('col-xl-10 offset-xl-1 ')
                }
            },
            onFinishing: function (event, currentIndex) {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex) {

            }
        }).validate({
            errorPlacement: function errorPlacement(error, element) {
                element.before(error);
            },
            errorElement: 'span',
            errorClass: 'error-message',
            rules: {
                title: 'required',
                vehicle_type_id: 'required',
                vehicle_type: 'required',
                condition: 'required',
                'features[]': 'required',
                brand_id: 'required',
                model_id: 'required',
                manufacture_year: 'required',
                fuel_id:{
                    required:{
                        depends:function(){
                            if ($('#vehicle_type_id').val() == '1'){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                },
                enginesize_id:{
                    required:{
                        depends:function(){
                            return  false;

                        }
                    }
                },
                body_type: {
                    required:{
                        depends:function(){
                            if ($('#vehicle_type_id').val() == '1'){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                },
                color: {
                    required:{
                        depends:function(){
                            if ($('#vehicle_type_id').val() == '1'){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                },
                gear_box: 'required',
                description: 'required',
                car_age: {
                    required:{
                        depends:function(){
                            if ($('#vehicle_type_id').val() == '1'){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                },
                category_id: 'required',
                parts_for: 'required',
                parts_description: 'required',
                vehicle_amount: 'required',
                pricein: 'required',
                location_id:'required',
                location:'required',
                "title-show": 'required',
                "vehicle_type_id-show": 'required',
                "vehicle_type-show": 'required',
                "condition-show": 'required',
                "features-show": 'required',
                "brand_id-show": 'required',
                "model_id-show": 'required',
                "manufacture_year-show": 'required',
                "fuel_type-show": 'required',
                "engine_size-show": 'required',
                "seats-show": 'required',
                "body_type-show": 'required',
                "color-show": 'required',
                "gear_box-show": 'required',
                "registration_no-show": 'required',
                "description-show": 'required',
                "location_id-show": 'required',
                "location-show": 'required',
                "address-show": 'required',
                "car_age-show": 'required',
                "category_id-show": 'required',
                "parts_for-show": 'required',
                "parts_description-show": 'required',
                "vehicle_amount-show": 'required',
                "pricein-show": 'required'
            },
            messages: {
                vehicle_type: 'vehicle type can not be empty',
                condition: 'condition can not be empty',
                'features[]': 'features can not be empty',
                email: "Please enter a valid email address",
            },
            highlight: function (element, errorClass, validClass) {
                var elem = $(element);
                if (elem.hasClass("select2-offscreen")) {
                    elem.parent().addClass('Select2Error');
                } else {
                    elem.parent().addClass(errorClass);
                }
            },
            unhighlight: function (element, errorClass, validClass) {
                var elem = $(element);
                if (elem.parent().hasClass(errorClass))
                    elem.siblings('.error-container').remove();
                if (elem.hasClass("select2-offscreen")) {
                    $("#" + elem.attr("id")).on("change", function () {
                        $(this).parent.removeClass("Select2Error");
                    });
                    elem.parent().removeClass('Select2Error');
                    elem.siblings('.error-container').remove();
                } else {
                    elem.parent().removeClass(errorClass);
                }
            },
        });

        $('.select2-style select').select2({
            width: '100%'
        });
        $("#features").select2({
            tags: true,
            placeholder: "Select Features",
            tokenSeparators: [",", " "],

        })
        // $("#tags").select2({
        //     tags: true,
        //     placeholder: "Select Tags",
        //     tokenSeparators: [",", " "],
        //     createTag: function(params) {
        //         return undefined;
        //     }
        // })
        $('.number').keyup(function (e) {
            if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
            }
        });
        $('#vehicle_amount').on('keyup',function(){
            updateTextView($(this));
        });

        var previewNode = document.querySelector("#upload_previews_template");
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        var myDropzone = new Dropzone(document.body, {
            url: "/test",
            maxFiles: 10,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false,
            keepLocal: true,
            previewsContainer: "#upload_previews",
            clickable: "#upload_btn",
            init: function () {

                this.on("addedfile", function (file) {
                    let name = file.name.replace(/ /g, '');
                    let oldData = getCookie();
                    if (!oldData.img) {
                        oldData.img = [];
                        oldData.img = [...oldData.img, {'name': name, 'path': URL.createObjectURL(file), 'is_featured':1}];
                        setStorage(oldData)

                        file._captionBox = Dropzone.createElement("<label label class=\"checkbox-style\" >\n" +
                            "        <input name=\"img\" checked data-feature='"+name+"' type=\"checkbox\" class=\"filled-in checkSingle checkSingle-img\" required>\n" +
                            "        <span>Make Main Image</span>\n" +
                            "    </label>\"");
                    } else {
                        oldData.img = [...oldData.img, {'name': name, 'path': URL.createObjectURL(file)}];
                        setStorage(oldData)
                        file._captionBox = Dropzone.createElement("<label label class=\"checkbox-style\" >\n" +
                            "        <input name=\"img\" data-feature='"+name+"' type=\"checkbox\" class=\"filled-in checkSingle checkSingle-img\" required>\n" +
                            "        <span>Make Main Image</span>\n" +
                            "    </label>\"");
                    }
                    if(oldData.img.length < 2){
                        $('.actions ul li a[href="#next"]').addClass('disabled').removeAttr('href');
                        $('#add_product-p-2').append('<div class="error-message">Image minimum length 2<div>')
                    }else{
                        $('.actions ul li a.disabled').removeClass('disabled').attr('href','#next');
                        $('#add_product-p-2 .error-message').remove();
                    }
                    file.previewElement.appendChild(file._captionBox);

                    $('ul.splide__list').append('<li class="splide__slide ' + name.split('.')[0] + '"><img src="' + URL.createObjectURL(file) + '" alt=""></li>')
                });

                this.on("removedfile", function (file) {
                    let name = file.name.replace(/ /g, '');
                    let oldData = getCookie();
                    oldData['img'] = oldData.img.filter(e => e.name != name);
                    if(oldData.img.length < 2){
                        $('.actions ul li a[href="#next"]').addClass('disabled').removeAttr('href');
                        $('#add_product-p-2').append('<div class="error-message">Image minimum length 2<div>')
                    }else{
                        $('.actions ul li a.disabled').removeClass('disabled').attr('href','#next');
                        $('#add_product-p-2 .error-message').remove();
                    }
                    setStorage(oldData)
                    $('.'+name.split('.')[0]).remove()
                });
            }
        });

        $("document.body").on('change drop', function (e) {
            e.preventDefault();
            e.stopPropagation();

            alert("Something Changed");
        });


        $('.input-change').on('change', function () {

            var value = $(this).val();
            const name = $(this).attr('name');
            const id = $(this).attr('id');
            const text = $(this).text();
            let oldData = getCookie();
            oldData[name] = $(this).val();

            if (id == 'features') {
                $('#features-show').html()
                var newFeature = '';
                $("#" + id + " option:selected").each(function () {

                    newFeature += "<li>" + $(this).text() + "</li>";
                });
                $('#features-show').html(newFeature)
            } else if (id == 'mileage') {
                $('#mileage-show').text(nFormatter(parseInt(value), 1))
            } else if (id == 'description') {
                $('#description-show').text(value)
            }else if (id == 'manufacture_year') {
                $('.manufacture_year-show').text(value)
            } else if (id == 'title' || id == 'condition' || id == 'address' || id == 'vehicle_amount') {
                if (id == 'vehicle_amount'){
                    var val = $(this).val();
                    oldData['vehicle_amount'] = val.replace(/,/g, "");
                }
                if (id == 'title') {
                    $('#title-show').text(value.toUpperCase())
                } else {
                    $('#' + id + '-show').text(value)
                }

            } else {
                $('#' + id + '-show').text($('#' + id + ' option:selected').text());
            }

            setStorage(oldData)
        });

        $('#vehicle_type_id, #condition, #brand_id, #model_id, #vehicle_type_id-show, #condition-show, #brand_id-show, #model_id-show').on('change', function () {
            const this_id = $(this).attr('id');
            let appendSelector = '';
            if (this_id.search('-show') > 0) {
                appendSelector = '-show'
            }
            jQuery.ajax({
                url: 'admin/posts/get-car-valuation',
                type: "POST",
                dataType: "JSON",
                data: {
                    'vehicle_type_id': $('#vehicle_type_id' + appendSelector).val(),
                    'condition': $('#condition' + appendSelector).val(),
                    'brand_id': $('#brand_id' + appendSelector).val(),
                    'model_id': $('#model_id' + appendSelector).val()
                },
                success: function (response) {
                    priceindoller = parseInt(response.priceindollar);
                    priceinnaira = parseInt(response.priceinnaira);
                    var price =  priceinnaira > 0 ? `<span class="suggestion-amount-pricein">$ </span><span class="suggestion-amount-avg">` + response.priceinnaira + `</span>` : '<span class="suggestion-amount-avg">No suggested price</span>'
                    $('#suggest_amount-append').html(price)
                }
            });
        });

        $('.checkSingle-amount').change(function () {
            var aaammooouunnnt = parseInt($('.suggestion-amount-avg').first().text());
            if ($(this).is(':checked') && aaammooouunnnt > 0) {
                $('#vehicle_amount').val($('.suggestion-amount-avg').first().text()).prop('disabled', true);
                $('#vehicle_amount-show').text($('.suggestion-amount-avg').first().text());
            } else {
                aaammooouunnnt = 0;
                $('#vehicle_amount').val(0).prop('disabled', false);
                $('#vehicle_amount-show').text(0);
            }

            let oldData = getCookie();
            oldData['vehicle_amount'] = aaammooouunnnt;
            setStorage(oldData)
        })

        $(document).on('click', '#selectPlanAction', function () {
            var packageId = $('.packageId').val();
            jQuery.ajax({
                url: 'admin/posts/buy-post-package',
                type: "POST",
                dataType: "JSON",
                data: {
                    packageId, post_id
                },
                success: function (response) {
                    window.location.href = '<?=base_url()?>'+'admin/posts'

                }
            });
        })

        $('#title').on('keyup change keypress blur',function () {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            var regExp = /\s+/g;
            Text = Text.replace(regExp, '-');
            Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
            $("#post_url").val(Text).trigger('change');
        });

    })
    $('#selectPlan').on('click', function () {
        $('#successModal').modal('close');
        $('#selectPlanModal').modal('open');
    });



    function nFormatter(num, digits) {
        var si = [
            {value: 1, symbol: ""},
            {value: 1E3, symbol: "K"},
            {value: 1E6, symbol: "M"},
            {value: 1E9, symbol: "G"},
            {value: 1E12, symbol: "T"},
            {value: 1E15, symbol: "P"},
            {value: 1E18, symbol: "E"}
        ];
        var rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
        var i;
        for (i = si.length - 1; i > 0; i--) {
            if (num >= si[i].value) {
                break;
            }
        }
        return (num / si[i].value).toFixed(digits).replace(rx, "$1") + si[i].symbol;
    }
</script>
<script>

    function changeToYear(val){
        var toYear = $('#to_year');
        toYear.empty();
        var option = '';
        if (val){
            var start = new Date().getFullYear();
            for (start; start >= val; start--){
                option += `<option value="${start}">${start}</option>`;
            }
        }
        toYear.append(option);
    }
    $(document).ready(function () {
        // $(document).on('change','#vehicle_type_id',function (){
        //    let vehicleTypeId = $(this).val();
        //    $.ajax({
        //        url:'',
        //        method: 'GET',
        //        data:{id:vehicleTypeId},
        //        success:function (response){

        //        }
        //    });
        // });


        $('#waitingModal').modal({dismissible: false});
        $(document).on('click', '.actions ul li a[href="#finish"]', function () {
            $('#waitingModal').modal('open');
            var data = getCookie();

            (function loop(index) {
                if (index < data.img.length) {
                    toDataURL(data.img[index].path, function (image) {

                        data.img[index].path = image
                        loop(index + 1);
                    })
                } else {
                    jQuery.post('<?=$action?>', data, function (e) {
                        e = JSON.parse(e);
                        post_id = e.post_id;
                        $('#waitingModal').modal('close');
                        $('#successModal').modal('open');
                    });
                }
            })(0);


        });
        if (vehicle_type_id) {
            setStorage({'vehicle_type_id': vehicle_type_id, 'pricein': 'NGR', 'listing_type' : listing_type, 'advert_type' : 'Free'});
        }

        $(document).on('change', '.checkSingle-img', function () {
            let oldData = getCookie();
            let newData = [];
            if ($(this).is(':checked')) {
                $('.checkSingle-img').each(function (i, e) {
                    $(e).prop('checked', false)
                })
                $(this).prop('checked', true);
                var img_name = $(this).attr('data-feature');
                oldData.img.forEach(function (e, i) {
                    if (e.name == img_name) {
                        e.is_featured = 1;
                    } else {
                        e.is_featured = 0;
                    }
                    newData = [...newData, e];
                })
            } else {
                $(this).prop('checked', false);
            }
            oldData.img = newData
            setStorage(oldData)
        })
    })
    $(document).ready(function () {
        const vehicle_id = '<?=$vehicleId?>';
        vehicle_change_body_type(vehicle_id);
        vehicle_change_engine_type(vehicle_id);
        $('.type_change_name').text('Vehicle');
        if (vehicle_id === "4") {
            $('.type_change_name').text('Spare Parts');
            $('.car').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.motorbike').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.parts').each(function (i, e) {
                $(e).removeClass('d-none');
                $(e).addClass('show');
            })
        } else if(vehicle_id === '3'){
            $('.car').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.parts').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.motorbike').each(function (i, e) {
                $(e).removeClass('d-none');
                $(e).addClass('show');
            })
        }

        else {
            $('.motorbike').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.parts').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.car').each(function (i, e) {
                $(e).removeClass('d-none');
                $(e).addClass('show');
            })
        }
    });

    function vehicle_change(vehicle_type_id) {
        vehicle_change_brand(vehicle_type_id);
        vehicle_change_body_type(vehicle_type_id);
        vehicle_change_engine_type(vehicle_type_id);
        condition_option_remove(vehicle_type_id);
        $('.type_change_name').text('Vehicle');
        if (vehicle_type_id === "4") {
            $('.type_change_name').text('Spare Parts');
            $('.car').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.motorbike').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.parts').each(function (i, e) {
                $(e).removeClass('d-none');
                $(e).addClass('show');
            })
        }else if(vehicle_type_id === '3'){
            $('.car').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.parts').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.motorbike').each(function (i, e) {
                $(e).removeClass('d-none');
                $(e).addClass('show');
            })
        }
        else {
            $('.motorbike').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.parts').each(function (i, e) {
                $(e).removeClass('show');
                $(e).addClass('d-none');
            })
            $('.car').each(function (i, e) {
                $(e).removeClass('d-none');
                $(e).addClass('show');
            })
        }

    }

    function getCity() {
        var id = $("#location_id").val();
        jQuery.ajax({
            url: 'all-city?id=' + id,
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

    function get_model(id) {
        var vehicle_type_id = $('#vehicle_type_id').val();

        jQuery.ajax({
            url: 'brands/brands_frontview/brands_by_vehicle_model?type_id=' + vehicle_type_id + '&brand_id=' + id,
            type: "GET",
            dataType: "text",
            data: {id: id, vehicle_type_id: vehicle_type_id},
            beforeSend: function () {
                jQuery('#model_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#model_id').html(response);
                // jQuery('#model_id-show').html(response);
            }
        });

    }
</script>
<script>
    function setStorage(value = {}) {
        localStorage.setItem("product_add", (JSON.stringify(value) || ""));
    }

    function getCookie() {
        return JSON.parse(localStorage.getItem("product_add"));
    }

    function eraseCookie() {
        localStorage.removeItem("product_add");
    }
</script>

<script>
    var postType = '<?php echo $this->input->get('post_type'); ?>';
    if (postType === 'spare-parts'){
        condition_option_remove(4)
    }

    function toDataURL(src, callback) {
        var xhttp = new XMLHttpRequest();

        xhttp.onload = function () {
            var fileReader = new FileReader();
            fileReader.onloadend = function () {
                callback(fileReader.result);
            }
            fileReader.readAsDataURL(xhttp.response);
        };

        xhttp.responseType = 'blob';
        xhttp.open('GET', src, true);
        xhttp.send(null);
    }
    function vehicle_change_body_type(vehicle_type_id){
        var typeName = '';
        switch(parseInt(vehicle_type_id)){
            case 1:
                typeName = 'Car';
                break;
            case 2:
                typeName = 'Van';
                break;
            case 3:
                typeName = 'Motorbike';
                break;
            case 4:
                typeName = 'Spare Parts';
                break;
            default:
                typeName = 'Car';
        }
        jQuery.ajax({
            url: 'admin/body_types/get_body_type?type_name='+typeName,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                //$('#brand_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                $('#body_type').html(response);
            }
        });
    }
   function vehicle_change_engine_type(vehicle_type_id){
        jQuery.ajax({
            url: 'admin/engine_size/get_engine_size?type_id='+vehicle_type_id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                //$('#brand_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                $('#engine_size').html(response);
            }
        });
    }
    function vehicle_change_brand(vehicle_type_id) {
        var vehicle_type_id = vehicle_type_id;

        jQuery.ajax({
            url: 'brands/brands_frontview/get_brands_by_vechile?type_id='+vehicle_type_id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                //$('#brand_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                $('#brand_id').html(response);
            }
        });
    }
    function condition_option_remove(vehicle_type_id){
        if (vehicle_type_id == 4){
            $('#condition option[value="Nigerian used"]').remove();
        }else{
            $('#condition option[value="Nigerian used"]').remove();
            $('#condition').append('<option value="Nigerian used">Nigerian used</option>');
        }
    }
</script>
<script>
    function updateTextView(_obj){
        var num = getNumber(_obj.val());
        if(num==0){
            _obj.val('');
        }else{
            _obj.val(num.toLocaleString());
        }
    }
    function getNumber(_str){
        var arr = _str.split('');
        var out = new Array();
        for(var cnt=0;cnt<arr.length;cnt++){
            if(isNaN(arr[cnt])==false){
                out.push(arr[cnt]);
            }
        }
        return Number(out.join(''));
    }
</script>
