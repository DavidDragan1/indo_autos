<!-- featured area  -->
<?php
$vehicleId = $data['vehicle_type_id'];
?>
<div class="row">
    <div id="add_product_container" class="col-xl-10 offset-xl-1">
        <h2 class="fs-18 fw-500 color-seconday mb-25">Add a Product</h2>
        <form id="add_product" class="add_product-wrapper" action="<?php echo $data['action']; ?>"
              enctype="multipart/form-data">
            <h3>Vehicle Details</h3>
            <fieldset class="step-wrapper">
                <div class="row">
                    <div class="col-12">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block">Vehicle Type</span>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="input-field">
                            <input id="title" name="title" value="<?=$data['title']?>" type="text" class="input-change">
                            <label for="title"><span>Title</span></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style mb-15">
                            <select disabled name="vehicle_type_id" id="vehicle_type_id" onChange="vehicle_change(this.value);"
                                    class="browser-default input-change">
                                <?php echo GlobalHelper::dropDownVehicleList($vehicleId); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style  mb-15">
                            <select id="condition" name="condition" class="browser-default input-change">
                                <?php echo GlobalHelper::getImportCarConditions($data['condition']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-12">
                        <div class="input-field slug_icon" >
                            <input id="post_url" name="post_url" type="text" class="input-change" value="<?php echo $data['post_slug'];?>">
                            <i class="fa fa-globe"> Post Url</i>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block">Vehicle Specification</span>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style  mb-15">
                            <select id="brand_id" onChange="get_model(this.value);" name="brand_id"
                                    class="browser-default input-change">
                                <option value="" disabled selected>Brand</option>
                                <?php echo Modules::run('brands/all_brands_for_automech', $data['brand_id'], $vehicleId); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style  mb-15">
                            <select id="model_id" name="model_id"
                                    class="browser-default input-change">
                                <option value="" disabled selected>Model</option>
                                <?php echo GlobalHelper::get_brands_by_vehicle_model(0, $data['brand_id'], $data['model_id']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style  mb-15">
                            <select onchange="changeToYear(this.value)" name="manufacture_year" id="manufacture_year" class="browser-default input-change">
                                <option value="" disabled selected>Year of Manufacture</option>
                                <?php echo numericDropDown(1950, date('Y'), 1, $data['manufacture_year']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 parts">
                        <div class="select2-style  mb-15">
                            <select name="to_year" id="to_year" class="browser-default input-change">
                                <option value="" disabled selected>To Year</option>
                                <?php echo numericDropDown(1950, date('Y'), 1, $data['to_year']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="input-field">
                            <input id="reg_date" value="<?=$data['reg_date']?>" name="reg_date" type="date" class="datepicker input-change"
                                   placeholder="Registration Date">
                            <label for="title"><span>Registration Date</span></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12  car motorbike">
                        <div class="select2-style  mb-15">
                            <select id="fuel_type" name="fuel_id" class="browser-default input-change">
                                <option value="" disabled selected>Fuel Type</option>
                                <?php echo GlobalHelper::createDropDownFromTable($tbl = 'fuel_types', $col = 'fuel_name', $data['fuel_id']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="select2-style  mb-15">
                            <select name="enginesize_id" id="engine_size"
                                    class="browser-default input-change">
                                <option value="" disabled selected>Engine Size</option>
                                <?php echo GlobalHelper::getEngineTypeDropdown($data['vehicle_type_id'],$data['enginesize_id']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car">
                        <div class="select2-style  mb-15">
                            <select name="seats" id="seats" class="browser-default input-change">
                                <?php echo GlobalHelper::seat($data['seats'], 'Seats'); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="select2-style  mb-15">
                            <select id="body_type" name="body_type" class="browser-default input-change">
                                <option value="" disabled selected>Body Type</option>
                                <?php echo GlobalHelper::getVehicleBodyTypeDropdown($data['vehicle_type_id'], $data['body_type']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="select2-style  mb-15">
                            <select name="color" id="color" class="browser-default input-change">
                                <option value="" disabled selected>Color</option>
                                <?php echo GlobalHelper::createDropDownFromTable($tbl = 'color', $col = 'color_name', $data['color']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car">
                        <div class="select2-style  mb-15">
                            <select id="gear_box" name="gear_box_type" class="browser-default input-change">
                                <?php echo GlobalHelper::gearBox($data['gear_box_type']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car">
                        <div class="select2-style  mb-15">
                            <select id="service_history" name="service_history" class="browser-default input-change">
                                <option value="" disabled selected>Service History</option>
                                <?php echo GlobalHelper::service_history($data['service_history']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car">
                        <div class="select2-style  mb-15">
                            <select id="alloywheels" name="alloywheels" class="browser-default input-change">
                                <option value="" disabled selected>Alloy Wheels</option>
                                <?php echo GlobalHelper::wheel_list($data['alloywheels']); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12 car">
                        <div class="select2-style  mb-15">
                            <select id="owners" name="owners" class="browser-default input-change">
                                <option value="" disabled selected>Owner</option>
                                <?php echo GlobalHelper::owners($data['owners']); ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="input-field">
                            <input id="mileage" value="<?=$data['mileage']?>" name="mileage" type="number" class="input-change">
                            <label for="mileage"><span>Mileage</span></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car">
                        <div class="input-field">
                            <input id="registration_no" value="<?=$data['registration_no']?>" name="registration_no" type="number" class="input-change">
                            <label for="registration_no"><span>Registration Number</span></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 car motorbike">
                        <div class="select2-style  mb-15">
                            <select id="car_age" name="car_age" class="browser-default input-change">
                                <option value="" disabled selected>Age</option>
                                <?php echo GlobalHelper::car_age($data['car_age']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 parts">
                        <div class="select2-style  mb-15">
                            <select id="category_id" name="category_id" class="browser-default input-change">
                                <option value="" disabled selected>Part Category</option>
                                <?php echo GlobalHelper::parts_categories($data['category_id']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 parts">
                        <div class="input-field">
                            <input name="parts_id" value="<?=$data['parts_id']?>" id="parts_id" type="text" class="input-change">
                            <label for="title"><span>Parts Id</span></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 parts">
                        <div class="select2-style  mb-15">
                            <select id="parts_description" name="parts_description"
                                    class="browser-default input-change">
                                <option value="" disabled selected>Parts Name</option>
                                <?php echo GlobalHelper::parts_description($data['parts_description']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 parts">
                        <div class="select2-style  mb-15">
                            <select id="parts_for" name="parts_for" class="browser-default input-change">
                                <option value="" disabled selected>Parts For</option>
                                <?php echo GlobalHelper::parts_for($data['parts_for']); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 car">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block">Features</span>
                    </div>
                    <div class=" col-12 car">

                        <div class="select2-tags mb-15">
                            <select multiple="multiple" name="features[]" id="features"
                                    class="browser-default input-change">
                                <?php echo GlobalHelper::all_features_new($data['features']); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block">Description</span>
                    </div>
                    <div class=" col-12">
                        <div class="input-field">
                            <textarea class="materialize-textarea input-change" rows="5" name="description"
                                      id="description" placeholder="Description"><?=$data['description']?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="fs-14 color-seconday fw-500 mb-10 d-block">Location</span>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style mb-15">
                            <select name="country_id" id="country_id" onchange="countryChangeState(this.value)"
                                    class="browser-default input-change">
                                <?php echo getDropDownCountries($data['country_id']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="select2-style mb-15">
                            <select name="location_id" id="location_id" class="browser-default input-change">
                                <option value="" disabled selected>Select State</option>
                                <?php echo GlobalHelper::all_location($data['location_id']); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="input-field">
                            <input id="address" class="input-change" value="<?=$data['address']?>" name="address" type="text">
                            <label for="email"><span>Enter Address</span></label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <h3>Amount</h3>
            <fieldset class="step-wrapper">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6 mt-15">
                        <div class="shadow br-5 p-15">
                            <ul class="post_info-tabs dashboard-tabs tabs">
                                <li class="tab">
                                    <a class="active" href="#amount">Amount</a>
                                </li>
                                <li class="tab">
                                    <a href="#other">Other Costs</a>
                                </li>
                                <li class="tab">
                                    <a href="#calculator">Calculator</a>
                                </li>
                            </ul>
                            <div id="amount">
                                <span class="fs-14 color-seconday fw-500 mb-10 d-block">Enter Vehicle Amount</span>
                                <div class="input-field input-field-icon mb-15">
                                    <span class="field-icon color-theme">$</span>
                                    <input id="vehicle_amount" class="number input-change" value="<?= $data['vehicle_amount'];?>" name="vehicle_amount" type="text" placeholder="Enter Amount"/>
                                </div>
                            </div>
                            <div id="other">
                                <div class="input-field input-field-icon mb-15">
                                    <span class="field-icon color-theme">$</span>
                                    <input id="shipping_amount" class="number input-change" value="<?= $data['shipping_amount'] != 0 ? $data['shipping_amount'] :'';?>"  name="shipping_amount" type="text" placeholder="Shipping Amount"/>
                                </div>
                                <div class="input-field input-field-icon mb-15">
                                    <span class="field-icon color-theme">$</span>
                                    <input id="ground_logistics" class="number input-change" value="<?= $data['ground_logistics_amount'] != 0 ? $data['ground_logistics_amount'] :'';?>"  name="ground_logistics_amount" type="text" placeholder="Ground Logistics Amount"/>
                                </div>
                                <div class="input-field input-field-icon mb-15">
                                    <span class="field-icon color-theme ">$</span>
                                    <input id="customs" class="number input-change"  value="<?= $data['customs_amount'] != 0 ? $data['customs_amount'] :'';?>" name="customs_amount" type="text" placeholder="Customs Amount"/>
                                </div>
                                <div class="input-field input-field-icon mb-15">
                                    <span class="field-icon color-theme">$</span>
                                    <input id="clearing" class="number input-change" value="<?= $data['clearing_amount'] != 0 ? $data['clearing_amount'] :'';?>" name="clearing_amount" type="text" placeholder="Clearing & Forwarding Amount"/>
                                </div>
                                <div class="input-field input-field-icon mb-15">
                                    <span class="field-icon color-theme">$</span>
                                    <input id="vat" class="number input-change" value="<?= $data['vat_amount'] != 0 ? $data['vat_amount'] :'';?>"  name="vat_amount" type="text" placeholder="Vat"/>
                                </div>
                                <div class="col-12">
                                    <label class="checkbox-style">
                                        <input <?php if ($data['is_third_party'] == 1) :?> checked <?php endif;?> id="checkSingle-suggest" type="checkbox" class="filled-in checkSingle-suggest input-change" name="suggest_check"/>
                                        <span> I want to use a third party service</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-xs-12 col-md-6">
                        <div class="shadow p-15 br-5 mt-15">
                            <div class="details-pricing-wrap p-15" style="background: transparent;">
                                <div class="d-flex justify-content-between align-items-center ">
                                    <h4 class="fs-16 fw-500 color-theme">Ammount Summary</h4>
                                </div>
                                <ul class="shipping_summary-list">
                                    <li>
                                        <span>Amount:</span>
                                        <span id="span_amount" class="color-black">$<span><?= $data['vehicle_amount'];?></span></span>
                                    </li>
                                    <li>
                                        <span>Shipping Amount:</span>
                                        <span id="span_shipping_amount" class="color-black">$<span><?php echo $data['shipping_amount'] ?  : 0;?></span></span>
                                    </li>
                                    <li>
                                        <span>Ground Logistics:</span>
                                        <span id="span_ground_logistics" class="color-black">$<span><?php echo  $data['ground_logistics_amount'] ?  : 0;?></span></span>
                                    </li>
                                    <li>
                                        <span>Customs:</span>
                                        <span id="span_customs" class="color-black">$<span><?php echo  $data['customs_amount'] ?  : 0;?></span></span>
                                    </li>
                                    <li>
                                        <span>Clearing:</span>
                                        <span id="span_clearing" class="color-black">$<span><?php echo  $data['clearing_amount'] ?  : 0;?></span></span>
                                    </li>
                                    <li>
                                        <span>VAT(Value-added-tax):</span>
                                        <span id="span_vat" class="color-black">$<span><?php echo  $data['vat_amount'] ?  : 0;?></span></span>
                                    </li>
                                    <li>
                                        <span class="fs-16 fw-500 color-black">Total:</span>
                                        <span id="span_total" class="color-theme fs-24 fw-700">$<span>0</span></span>
                                    </li>
                                </ul>
                                <p class="fs-12 text-left mt-15">
                                    Shipping quotes and tariffs are relevant at the time of Posting and may be adjusted if necessary by tariffs or shippers.
                                </p>
                            </div>
                        </div>
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
                <?php
                foreach ($data['img'] as $k => $img){

                    ?>
                    <div id=""
                         class="d-flex flex-wrap upload_previews_template align-items-center <?=explode('.', $img['name'])[0]?>">
                        <span class="preview"><img src="<?=$img['path']?>"/></span>
                        <div class="preview-content">
                            <div class="preview-top d-flex">
                                <p class="name fs-16 fw-500 color-seconday"><?=$img['name']?></p>
                                <span class="size fs-14"></span>
                                <span class="material-icons" onclick="removePhoto(this,'<?=$img['name']?>', '<?=$data['id']?>')">
                                                close
                                            </span>
                                <label label class="checkbox-style" >
                                    <input name="img" data-feature="<?=$img['name']?>" type="checkbox" class="filled-in checkSingle checkSingle-img" <?=$img['is_featured'] == 1 ? 'checked' : ''?> required>
                                    <span>Make Main Image</span>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
                                    <?php foreach ($data['img'] as $item){ ?>
                                        <li class="splide__slide <?=explode('.', $item['name'])[0]?>"><img src="<?=$item['path']?>" alt=""></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div id="thumbSlider" class="splide">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    <?php foreach ($data['img'] as $item){ ?>
                                        <li class="splide__slide <?=explode('.', $item['name'])[0]?>"><img src="<?=$item['path']?>" alt=""></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-12 mb-50">
                        <div class="post-details-info">
                            <div class="post-details-info-top">
                                <div class="post-details-info-top-left">
                                    <ul class="product-info">
                                        <li class="product-id">ID: #<?=$data['id']?></li>
                                        <li class="car motorbike"><span class="manufacture_year-show"><?=$data['manufacture_year']?></span></li>
                                        <li class="parts"><span><div class="manufacture_year-show d-inline-block mr-5"> <?=$data['manufacture_year']?></div> - <div id="to_year-show" class="ml-5 d-inline-block"><?php echo  $data['to_year'];?></div></span></li>
                                        <li><span id="condition-show"><?=$data['condition']?></span></li>
                                    </ul>
                                    <h1 id="title-show"><?=$data['title']?></h1>
                                </div>
                            </div>
                            <ul class="post-details-price">
                                <li>
                                    <span>Price</span>
                                    <h4><span id="pricein-show"><?=$data['pricein'] == 'NGR' ? '$' : '$'?></span><span id="vehicle_amount-show"><?=$data['vehicle_amount']?></span></h4>
                                </li>
                                <li class="car motorbike">
                                    <span>Mileage</span>
                                    <h4><span id="mileage-show"><?=number_shorten($data['mileage'])?></span> Miles</h4>
                                </li>
                            </ul>
                            <ul class="post-details-location">
                                <li><span class="material-icons">location_on</span> <span id="address-show"><?=$data['address']?></span>
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
                                        <p id="color-show"><?=GlobalHelper::getData('color', $data['color'], 'color_name')?></p>
                                    </div>
                                </li>
                                <li class="vehicle-overview">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon2.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Body Type</span>
                                        <p id="body_type-show"><?=GlobalHelper::getData('body_types', $data['body_type'], 'type_name')?></p>
                                    </div>
                                </li>
                                <li class="vehicle-overview car">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon3.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Seat</span>
                                        <p id="seats-show"><?=$data['seats']?></p>
                                    </div>
                                </li>
                                <li class="vehicle-overview car">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon4.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Engine</span>
                                        <p id="engine_size-show"><?=GlobalHelper::getData('engine_sizes', $data['enginesize_id'], 'engine_size')?></p>
                                    </div>
                                </li>
                                <li class="vehicle-overview">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon5.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Fuel Type</span>
                                        <p id="fuel_type-show"><?=GlobalHelper::getData('fuel_types', $data['fuel_id'], 'fuel_name')?></p>
                                    </div>
                                </li>
                                <li class="vehicle-overview motorcycle car">
                                    <div class="vehicle-overview-icon">
                                        <img src="assets/new-theme/images/icons/details/icon6.svg" alt="">
                                    </div>
                                    <div class="vehicle-overview-content">
                                        <span>Transmission</span>
                                        <p id="gear_box-show"><?=$data['gear_box_type']?></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div id="description" class="description-wrap mb-30">
                            <h4 class="fw-500 fs-18 mb-20">Description</h4>
                            <p id="description-show"><?=$data['description']?></p>
                        </div>
                        <h4 class="fw-500 fs-18 mb-20 car">Features</h4>
                        <ul id="features-show" class="features-wrap car">
                            <?=GlobalHelper::features(implode(',',$data['features']), true)?>
                        </ul>
                    </div>
                    <div class="col-lg-5">
                        <div class="details-pricing-wrap p-15">
                            <div class="bg-white shadow p-15 br-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="fs-16 fw-500 color-theme">Shipping Summary</h4>
                                    <span class="badge-wrap theme-badge">Review Price</span>
                                </div>
                                <ul class="shipping_summary-list">
                                    <li>
                                        <span>Amount:</span>
                                        <span class="color-black">$ <span id="vehicle_amount_show"><?= $data['vehicle_amount'];?></span></span>
                                    </li>
                                    <li>
                                        <span>Shipping Amount:</span>
                                        <span class="color-black">$ <span id="shipping_amount_show"><?= $data['shipping_amount'] ? : 0 ;?></span></span>
                                    </li>
                                    <li>
                                        <span>Ground Logistics:</span>
                                        <span class="color-black">$ <span id="ground_logistics_show"><?= $data['ground_logistics_amount'] ? : 0 ;?></span></span>
                                    </li>
                                    <li>
                                        <span>Customs:</span>
                                        <span class="color-black">$ <span id="customs_show"><?= $data['customs_amount']? : 0 ;?></span></span>
                                    </li>
                                    <li>
                                        <span>Clearing:</span>
                                        <span class="color-black">$<span id="clearing_show"><?= $data['clearing_amount']? : 0 ;?></span></span>
                                    </li>
                                    <li>
                                        <span>VAT(Value-added-tax):</span>
                                        <span class="color-black">$<span id="vat_show"><?= $data['vat_amount'] ? : 0 ;?></span></span>
                                    </li>
                                    <li>
                                        <span class="fs-16 fw-500 color-black">Total</span>
                                        <span class="color-theme fs-24 fw-700" id="span_total_show">$<span>0</span></span>
                                    </li>
                                </ul>
                            </div>
                            <p class="fs-12 text-left mt-15">
                                * Shipping quotes and tariffs are relevant at the time of Posting and may be adjusted if
                                necessary by tariffs or shippers.
                            </p>
                        </div>
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
        <h3 class="fw-500 fs-18 mb-30 text-center">Product Update successfully</h3>

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
<div id="selectPlanModal" class="modal modal-wrapper small-modal-wrapper">
    <span class="material-icons modal-close">close</span>
    <div class="text-center">
        <img class="mb-15" src="assets/new-theme/images/icons/car4.svg" alt="">
        <h4 class="fw-500 fs-18 mb-10">Select a Plan</h4>
        <p class="fw-400 fs-14 mb-15">Choose a Plan that best fits your need</p>
        <div class="select-style">
            <select class="browser-default packageId">
                <?php echo getPostPackages($data['package_id']); ?>
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
    var priceinnaira = 0;
    var priceindoller = 0;
    var post_id = 0;
    var preLoadData = JSON.parse('<?=json_encode($data)?>');
    var suggestCheck = '<?php echo $data['is_third_party'];?>';
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.tabs').tabs();
    });
    function totalAmount(){
        let value = parseInt($('#span_amount span').text().replaceAll(/,/g, "")) +
            parseInt($('#span_shipping_amount span').text().replaceAll(/,/g, "")) +
            parseInt($('#span_ground_logistics span').text().replaceAll(/,/g, "")) +
            parseInt($('#span_customs span').text().replaceAll(/,/g, "")) +
            parseInt($('#span_clearing span').text().replaceAll(/,/g, "")) +
            parseInt($('#span_vat span').text().replaceAll(/,/g, ""));
        $('#span_total span').text(value);
        $('#span_total_show span').text(value);

    }
</script>
<script>

    function changeToYear(val,selected = 0){

        var toYear = $('#to_year');
        toYear.empty();
        var option = '';
        if (val){
            var start = new Date().getFullYear();
            for (start; start >= val; start--){
                if (parseInt(selected) > 0){
                    option += `<option ${selected == start ? 'selected':''} value="${start}">${start}</option>`;
                }else{
                    option += `<option value="${start}">${start}</option>`;
                }

            }
        }
        toYear.append(option);
    }

    $(window).on('load', function () {
        var selected = `<?php echo $data['to_year'];?>`;
        var manufacturingYear = $('#manufacture_year').val();
        changeToYear(manufacturingYear,selected);


        if (parseInt(suggestCheck) === 1){
            $('#other :input[type="text"]').attr('disabled',true);
            $('#other :input[type="text"]').val('');

            $('#span_shipping_amount').children('span').text(0);
            $('#span_ground_logistics').children('span').text(0);
            $('#span_customs').children('span').text(0);
            $('#span_clearing').children('span').text(0);
            $('#span_vat').children('span').text(0);
        }

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
                $('.tabs').tabs();
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
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex) {
                $('#shipping_amount').keyup(function (){
                    updateTextView($(this));
                    var value = $(this).val();
                    if (value !== ''){
                        $('#span_shipping_amount').children('span').text(value);
                    }else{
                        $('#span_shipping_amount').children('span').text(0);
                    }
                    totalAmount();
                });
                $('#vehicle_amount').keyup(function (){
                    updateTextView($(this));
                    var value = $(this).val();
                    if (value !== ''){
                        $('#span_amount').children('span').text(value);
                    }else{
                        $('#span_amount').children('span').text(0);
                    }
                    totalAmount();
                });
                $('#ground_logistics').keyup(function (){
                    updateTextView($(this));
                    var value = $(this).val();
                    if (value !== ''){
                        $('#span_ground_logistics').children('span').text(value);
                    }else{
                        $('#span_ground_logistics').children('span').text(0);
                    }
                    totalAmount();
                });
                $('#customs').keyup(function (){
                    updateTextView($(this));
                    var value = $(this).val();
                    if (value !== ''){
                        $('#span_customs').children('span').text(value);
                    }else{
                        $('#span_customs').children('span').text(0);
                    }
                    totalAmount();
                });
                $('#clearing').keyup(function (){
                    updateTextView($(this));
                    var value = $(this).val();
                    if (value !== ''){
                        $('#span_clearing').children('span').text(value);
                    }else{
                        $('#span_clearing').children('span').text(0);
                    }
                    totalAmount();
                });
                $('#vat').keyup(function (){
                    updateTextView($(this));
                    var value = $(this).val();
                    if (value !== ''){
                        $('#span_vat').children('span').text(value);

                    }else{
                        $('#span_vat').children('span').text(0);
                    }
                    totalAmount();
                });
                $('.checkSingle-suggest').change(function(){
                    if (this.checked){
                        $('#other :input[type="text"]').attr('disabled',true);
                        $('#other :input[type="text"]').val('');

                        $('#span_shipping_amount').children('span').text(0);
                        $('#span_ground_logistics').children('span').text(0);
                        $('#span_customs').children('span').text(0);
                        $('#span_clearing').children('span').text(0);
                        $('#span_vat').children('span').text(0);

                        $('#shipping_amount_show').text(0);
                        $('#ground_logistics_show').text(0);
                        $('#customs_show').text(0);
                        $('#clearing_show').text(0);
                        $('#vat_show').text(0);
                        totalAmount();

                    }else{
                        $('#other :input[type="text"]').attr('disabled',false);
                        totalAmount();
                    }
                });
                totalAmount();

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
                features: 'required',
                brand_id: 'required',
                model_id: 'required',
                manufacture_year: 'required',
                reg_date: 'required',
                seats: 'required',
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
                enginesize_id:{
                    required:{
                        depends:function(){
                                return false;
                        }
                    }
                },
                gear_box: 'required',
                service_history: 'required',
                alloywheels: 'required',
                owners: 'required',
                mileage: 'required',
                registration_no: 'required',
                description: 'required',
                location_id: 'required',
                location: 'required',
                address: 'required',
                car_age: 'required',
                category_id: 'required',
                parts_for: 'required',
                parts_description: 'required',
                vehicle_amount: 'required',
                pricein: 'required',
                shipping_amount:{
                    required:{
                        depends:function(){
                            return !$('#checkSingle-suggest').is(':checked');
                        },
                    },

                },
                ground_logistics_amount:{
                    required:{
                        depends:function(){
                            return !$('#checkSingle-suggest').is(':checked');
                        },
                    },

                },
                customs_amount:{
                    required:{
                        depends:function(){
                            return !$('#checkSingle-suggest').is(':checked');
                        },
                    },

                },
                clearing_amount:{
                    required:{
                        depends:function(){
                            return !$('#checkSingle-suggest').is(':checked');
                        },
                    },

                },
                vat_amount:{
                    required:{
                        depends:function(){
                            return !$('#checkSingle-suggest').is(':checked');
                        },
                    },

                },

                "title-show": 'required',
                "vehicle_type_id-show": 'required',
                "vehicle_type-show": 'required',
                "condition-show": 'required',
                "features-show": 'required',
                "brand_id-show": 'required',
                "model_id-show": 'required',
                "manufacture_year-show": 'required',
                "reg_date-show": 'required',
                "fuel_type-show": 'required',
                "engine_size-show": 'required',
                "seats-show": 'required',
                "body_type-show": 'required',
                "color-show": 'required',
                "gear_box-show": 'required',
                "service_history-show": 'required',
                "alloywheels-show": 'required',
                "owners-show": 'required',
                "mileage-show": 'required',
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
                "pricein-show": 'required',
            },
            messages: {
                vehicle_type: 'vehicle type can not be empty',
                condition: 'condition can not be empty',
                features: 'features can not be empty',
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

        $.validator.addMethod('nonZero', function(value, element, param) {
            return (value != 0) && (value == parseInt(value, 10));
        }, 'Please enter a non zero integer value!');



        $('.select2-style select').select2({
            width: '100%'
        });
        $("#features").select2({
            tags: true,
            placeholder: "Select Features",
            tokenSeparators: [",", " "],

        })
        $('.number').keyup(function (e) {
            if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
            }
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
                    let name = file.name
                    name = name.replace(/ /g, '');
                    let oldData = getCookie();
                    if (!oldData.img) oldData.img = [];
                    oldData.img = [...oldData.img, {'name': name, 'path': URL.createObjectURL(file)}];
                    setStorage(oldData)
                    file._captionBox = Dropzone.createElement("<label label class=\"checkbox-style\" >\n" +
                        "        <input name=\"img\" data-feature='"+name+"' type=\"checkbox\" class=\"filled-in checkSingle checkSingle-img\" required>\n" +
                        "        <span>Make Main Image</span>\n" +
                        "    </label>\"");
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
                    name = file.name.replace(/ /g, '');
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
                }else if(id == 'vehicle_amount'){
                    $('#' + id + '-show').text(value);
                    $('#' + id + '_show').text(value);
                }else {
                    $('#' + id + '-show').text(value)
                }

            }else if( id == 'shipping_amount' || id == 'ground_logistics' || id == 'customs' || id == 'clearing' || id == 'vat') {
                value = value.replace(/,/g, "");
                if (id == 'shipping_amount'){
                    var val = $(this).val();
                    oldData['shipping_amount'] = value;
                }
                if (id == 'ground_logistics'){
                    var val = $(this).val();
                    oldData['ground_logistics_amount'] = value;
                }
                if (id == 'customs'){
                    var val = $(this).val();
                    oldData['customs_amount'] = value;
                }
                if (id == 'clearing'){
                    var val = $(this).val();
                    oldData['clearing_amount'] = value;
                }
                if (id == 'vat'){
                    var val = $(this).val();
                    oldData['vat_amount'] = value;
                }

                if ($('.checkSingle-suggest').prop('checked') === true) {
                    $('#' + id + '_show').text(0);
                    totalAmount();
                } else {
                    $('#' + id + '_show').text(value);
                    totalAmount();
                }

            }else if (id == 'checkSingle-suggest'){
                if($(this).prop('checked') === true){
                    oldData['shipping_amount'] = 0;
                    oldData['ground_logistics_amount'] = 0;
                    oldData['customs_amount'] = 0;
                    oldData['clearing_amount'] = 0;
                    oldData['vat_amount'] = 0;
                    oldData[name] = 'on';
                }else{
                    oldData[name] = '';
                }
            } else {
                $('#' + id + '-show').text($('#' + id + ' option:selected').text());
            }
            // delete oldData['suggest_check'];
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

                    $('.suggestion-amount-avg').text(priceinnaira)

                }
            });
        });

        $('.checkSingle-amount').change(function () {
            var aaammooouunnnt = $('.suggestion-amount-avg').first().text();
            if ($(this).is(':checked')) {
                $('#vehicle_amount').val(aaammooouunnnt).prop('disabled', true);
                $('#vehicle_amount-show').text(aaammooouunnnt);

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


    $(document).ready(function () {
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
                    jQuery.post('<?=$data['action']?>', data, function (e) {
                        e = JSON.parse(e);
                        post_id = e.post_id;
                        $('#waitingModal').modal('close');
                        $('#successModal').modal('open');
                    });
                }
            })(0);


        });
        if (vehicle_type_id) {
            preLoadData['suggest_check'] = (suggestCheck == 1 ? 'on':'');
            setStorage(preLoadData);
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
        if (vehicle_id === "4") {
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
        if (vehicle_type_id === "4") {
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
                jQuery('#model_id-show').html(response);
            }
        });

    }
    function removePhoto(e, imgName, post_id){
        $('.'+imgName.split('.')[0]).remove();

        let oldData = getCookie();
        oldData['img'] = oldData.img.filter(e => e.name != imgName);
        setStorage(oldData)

        jQuery.ajax({
            url: 'admin/posts/delete_service_photo',
            type: "POST",
            dataType: "JSON",
            data: {
                'id' : post_id,
                'photo' : imgName,
                'replace' : '_875.jpg'
            },
            success: function (response) {
            }
        });
    }
</script>
<script>
    function setStorage(value = {}) {
        localStorage.setItem("import_car", (JSON.stringify(value) || ""));
    }

    function getCookie() {
        return JSON.parse(localStorage.getItem("import_car"));
    }

    function eraseCookie() {
        localStorage.removeItem("import_car");
    }
</script>

<script>


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



    function countryChangeState(countryId){

        if (countryId !== ''){
            $.ajax({
                url: 'post_area/Post_area_frontview/get_state_by_country?countryId='+countryId,
                type: "GET",
                dataType: "text",
                success: function (response) {
                    $('#location_id').html(response);
                }
            });
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
