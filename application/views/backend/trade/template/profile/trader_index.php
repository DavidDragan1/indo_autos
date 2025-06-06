<?php
    $profile_url = '';
?>
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<form id="personalProfile" class="card-wrap personalProfile mb-35">
    <div class="d-flex flex-wrap justify-content-between mb-20">
        <h3 class="card-title tooltip mb-0">Personal Information <span
                class="edit_profile badge-wrap theme-badge ml-10" style="cursor: pointer;">Edit</span>
        </h3>
    </div>
    <div class="upload-img-wrap mb-30">
        <p>Profile Picture</p>
        <div class="upload-img">
            <img class="preview_profile" id="upload" src="<?php echo empty($user_profile_image) ? 'assets/theme/new/images/backend/img.svg' : ($oauth_provider == 'web' ? base_url() . "uploads/users_profile/" .$user_profile_image : $user_profile_image) ?>" alt="">
            <button class="upload_btn-wrap">
                Upload
                <input 
                       <?php if ($role_id == 14){
                         echo  empty($user_profile_image) ? 'required':'';
                       }?>
                type="file" id="profile_pic" name="profile_pic" />
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
            <div class="input-field mb-30">
                <input id="first_name" value="<?php echo $first_name;?>" name="first_name" type="text" readonly required>
                <label for="first_name"><span>First Name</span></label>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="input-field mb-30">
                <input id="last_name" value="<?php echo $last_name;?>" name="last_name" type="text" readonly required>
                <label for="last_name"><span>last Name</span></label>
            </div>
        </div>
        <?php if ($role_id == 8): ?>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input id="company_name" value="<?php echo @$mechanic->company_name;?>" name="company_name" type="text" readonly required>
                    <label for="company_name"><span>Company Name</span></label>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="input-field mb-30">
                <input id="user_email" value="<?php echo $email;?>" name="user_email" type="email" readonly required>
                <label for="user_email"><span>Email Address</span></label>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="input-field mb-30">
                <input id="contact" value="<?php echo $contact;?>" onkeypress="return DegitOnly(event)" name="contact" type="text" readonly required>
                <label for="contact"><span>Personal Phone Number</span></label>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="input-field mb-30">
                <input id="add_line" value="<?php echo $add_line1;?>" name="userAddress1" type="text" readonly required>
                <label for="add_line"><span>Address Line</span></label>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mt-2">
            <div class="select2-style mb-30">
                <select  class="browser-default" name="country" id="country_select" onchange="countryChangeState(this.value)" >
                    <?php echo getDropDownCountries($country_id); ?>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="select2-style  mb-30">
                <select  name="location_id" id="location_id" class="browser-default" onchange="getCity()">
                    <?php if (empty($state)) :?>
                    <option value="" disabled selected>Select State</option>
                    <?php endif ;?>
                    <?php echo GlobalHelper::all_location($state,'Select State',$country_id); ?>

                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="select2-style mb-30">
                <select  id="city" name="userCity" class="browser-default" required>
                    <?php if (empty($city)) :?>
                        <option value="" disabled selected>Select Location</option>
                    <?php else :?>
                        <?php echo GlobalHelper::all_city($state,$city); ?>
                    <?php endif;?>
                </select>
            </div>
        </div>
<!--        <div class="col-lg-4 col-md-6 col-12 mt-2">-->
<!--            <div class="input-field mb-30">-->
<!--                <input id="state" value="--><?php //echo $state;?><!--" name="state" type="text" readonly required>-->
<!--                <label for="state"><span>Region</span></label>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-lg-4 col-md-6 col-12 mt-2">
            <div class="input-field mb-30">
                <input id="postcode" value="<?php echo $postcode;?>" name="userPostCode" type="text" readonly >
                <label for="postcode"><span>Post Code</span></label>
            </div>
        </div>
        <?php if ($role_id == 17):?>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <?php
                    $verifier_slug = empty(@$verifiers->slug) ? slugify($first_name.' '.$last_name) : @$verifiers->slug
                    ?>
                    <input id="slug"  name="slug" value="<?=$verifier_slug?>" type="text" readonly required>
                    <label for="slug"><span>Verifier Public Profile</span></label>
                    <p id="url_link" style="text-decoration:underline;cursor: pointer;"><?php echo base_url().'hire-verifier/'.$verifier_slug;?></p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input class="number" id="whatsapp_number_verifier" value="<?=@$verifiers->whatsapp?>" name="whatsapp_number_verifier"
                           type="text" readonly required>
                    <label for="whatsapp_number_verifier"><span>Whatsapp Number</span></label>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-field mb-30">
                            <textarea id="about_verifier" class="materialize-textarea" name="about_verifier"  required
                                      readonly><?=@$verifiers->about?></textarea>
                    <label for="about_verifier"><span>About Verifier</span></label>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-field mb-30">
                            <textarea id="service_details" class="materialize-textarea" name="service_details"  required
                                      readonly> <?=@$verifiers->service_details?></textarea>
                    <label for="service_details"><span>Service Details</span></label>
                </div>
            </div>
        <?php endif;?>
        <?php if ($role_id == 14) : ?>
        <?php
            $driver_slug = empty(@$driver->driver_slug) ? slugify($first_name.' '.$last_name).'-'.$id : @$driver->driver_slug;
            ?>
            <div class="col-lg-4 col-md-6 col-12 ">
                <div class="input-field mb-30">
                    <input id="driver_slug" value="<?=$driver_slug?>" name="driver_slug"
                           type="text" readonly required>
                    <label for="driver_slug"><span>Driver Public Profile</span></label>
                    <p id="url_link" style="text-decoration:underline;cursor: pointer;"><?php echo base_url().'driver-details/'.$driver_slug;?></p>
                </div>
            </div>
<!--        <div class="col-lg-4 col-md-6 col-12 mt-2">-->
<!--            <div class="select2-style">-->
<!--                <select class="browser-default" name="state_id" id="state_id">-->
<!--                    --><?php //echo GlobalHelper::driver_location($driver->state_id); ?>
<!--                </select>-->
<!--            </div>-->
<!--        </div>-->
            <div class="col-lg-4 col-md-6 col-12 mt-2">
                <div class="select2-style mb-30">
                    <select class="browser-default" name="vehicle_type_id" id="vehicle_type_id">
                        <?php echo GlobalHelper::dropDownVehicleListForDriverHire(@$driver->vehicle_type_id); ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12 mt-2">
                <div class="select2-style mb-30">
                    <select class="browser-default" name="license_type" id="license_type">
                        <?php echo GlobalHelper::license_type(@$driver->license_type); ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12 mt-2">
                <div class="select2-style mb-30">
                    <select class="browser-default" name="marital_status" id="marital_status">
                        <?php echo GlobalHelper::driver_marital_status(@$driver->marital_status); ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12 mt-2">
                <div class="select2-style mb-30">
                    <select class="browser-default" name="education_type" id="education_type">
                        <?php echo GlobalHelper::education_type(@$driver->education_type); ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12 mt-2">
                <div class="input-field mb-30">
                    <input id="years_of_experience" value="<?=@$driver->years_of_experience?>" name="years_of_experience" type="number" readonly required>
                    <label for="years_of_experience"><span>Experience</span></label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12 mt-2">
                <div class="input-field mb-30">
                    <input id="age" value="<?=@$driver->age?>" name="age" type="number" readonly required>
                    <label for="age"><span>age</span></label>
                </div>
            </div>

            <div class="col-12">
                <div class="input-field mb-30">
                    <input id="description" value="<?=@$driver->description?>" name="description" type="text" readonly required>
                    <label for="description"><span>Short Description</span></label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input class="salary" id="one_day" value="<?=@$driver->one_day?>" name="one_day" type="number" readonly >
                    <label for="one_day"><span>1 Day Salary</span></label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input class="salary" id="first_week" value="<?=@$driver->first_week?>" name="first_week" type="number" readonly >
                    <label for="first_week"><span>1 Week Salary</span></label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input class="salary" id="second_week" value="<?=@$driver->second_week?>" name="second_week" type="number" readonly >
                    <label for="second_week"><span>2 Week Salary</span></label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input class="salary" id="third_week" value="<?=@$driver->third_week?>" name="third_week" type="number" readonly >
                    <label for="third_week"><span>3 Week Salary</span></label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input class="salary" id="fourth_week" value="<?=@$driver->fourth_week?>" name="fourth_week" type="number" readonly >
                    <label for="fourth_week"><span>4 Week Salary</span></label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input class="salary" id="month" value="<?=@$driver->month?>" name="month" type="number" readonly >
                    <label for="month"><span>Monthly Salary</span></label>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-12">
                <input style="visibility: hidden;height: 0;margin: 0;padding: 0" class="salary-field mt-0"  name="salary" type="number"  required>
            </div>
        <?php endif; ?>

        <?php if ($role_id == 8) : ?>
        <?php
            $mechanic_slug = empty(@$mechanic->mechanic_slug) ? slugify($first_name.' '.$last_name) : @$mechanic->mechanic_slug;
            ?>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input id="mechanic_slug" value="<?php echo $mechanic_slug?>" name="mechanic_slug"
                           type="text" readonly required>
                    <label for="mechanic_slug"><span>Mechanic Profile Page</span></label>
                    <p id="url_link" style="text-decoration:underline;cursor: pointer;"><?php echo  base_url().'mechanic-details/'.$mechanic_slug ;?></p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input id="years_of_experience" value="<?=@$mechanic->years_of_experience?>" name="years_of_experience" type="number" readonly required>
                    <label for="years_of_experience"><span>Experience</span></label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input id="age" value="<?=@$mechanic->age?>" name="age" type="number" readonly required>
                    <label for="age"><span>age</span></label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="select2-tags mb-30">
                    <label for="vehicle_type_id" class="fs-14 fw-500 mb-10 color-seconday">Vehicle Type</label>
                    <select class="browser-default" name="vehicle_type_id[]" id="vehicle_type_id" multiple>
                        <<?php echo GlobalHelper::dropDownVehicleListForDriverHire(@$mechanic->vehicle_type_id); ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="select2-tags mb-30">
                    <label for="brand" class="fs-14 fw-500 mb-10 color-seconday">Brand</label>
                    <select class="browser-default" name="brand[]" id="brand" multiple>
                        <<?php echo GlobalHelper::get_brands_for_profile(explode(',',@$mechanic->brand)); ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12 ">
                <div class="select2-tags mb-30">
                    <label for="specialism" class="fs-14 fw-500 mb-10 color-seconday">Specialism</label>
                    <select class="browser-default" name="specialism[]" id="specialism" multiple>
                        <?php echo GlobalHelper::getSpecialismForProfile(explode(',',@$mechanic->specialism)); ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="select2-tags mb-30">
                    <label for="services" class="fs-14 fw-500 mb-10 color-seconday">Repair Type</label>
                    <select class="browser-default" name="services[]" id="services" multiple>
                        <?php echo GlobalHelper::getRepairType(explode(',',@$mechanic->services)); ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12">
                <div class="select2-tags  mb-30">
                    <label for="state_id" class="fs-14 fw-500 mb-10 color-seconday">Service State</label>
                    <select  name="state_id[]" id="state_id" class="browser-default" multiple>
                        <?php echo GlobalHelper::state_for_profile(explode(',',@$mechanic->state_id)) ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12">
                <div class="select2-tags  mb-30">
                    <label for="city_id" class="fs-14 fw-500 mb-10 color-seconday">Service Location</label>
                    <select  name="city_id[]" id="city_id" class="browser-default" multiple>
                        <?php echo GlobalHelper::location_for_profile(explode(',',@$mechanic->city_id), explode(',',@$mechanic->state_id)) ?>
                    </select>
                </div>
            </div>


            <div class="col-md-4 col-sm-6 col-12">
                <div class="select2-tags mb-30">
                    <label for="service_type" class="fs-14 fw-500 mb-10 color-seconday">Service</label>
                    <select  name="service_type[]" id="service_type" class="browser-default" multiple>
                        <?php echo GlobalHelper::getServiceType(explode(',', @$mechanic->service_type)) ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12">
                <div class="select2-style mb-30">
                    <label for="is_provide_mobile_service" class="fs-14 fw-500 mb-10 color-seconday">Do you provide mobile services</label>
                    <select  name="is_provide_mobile_service" id="is_provide_mobile_service" class="browser-default">
                        <option value="0" <?=@$mechanic->is_provide_mobile_service == 0 ? 'selected' : ''?>>No</option>
                        <option value="1" <?=@$mechanic->is_provide_mobile_service == 1 ? 'selected' : ''?>>Yes</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12 mobile-services <?=@$mechanic->is_provide_mobile_service == 1 ? 'show' : 'd-none'?>">
                <div class="select2-tags mb-30">
                    <label for="mobile_service_category" class="fs-14 fw-500 mb-10 color-seconday">Mobile Service Category</label>
                    <select  name="mobile_service_category[]" id="mobile_service_category" class="browser-default" multiple>
                        <?php echo GlobalHelper::towing_service_for_profile(explode(',',@$mechanic->mobile_service_category)) ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 col-12 mobile-services <?=@$mechanic->is_provide_mobile_service == 1 ? 'show' : 'd-none'?>">
                <div class="select2-tags mb-30">
                    <label for="mobile_services" class="fs-14 fw-500 mb-10 color-seconday">Services</label>
                    <select  name="mobile_services[]" id="mobile_services" class="browser-default" multiple>
                        <?php echo GlobalHelper::towing_type_of_service_for_profile(explode(',',@$mechanic->mobile_service_category), explode(',',@$mechanic->mobile_services)) ?>
                    </select>
                </div>
            </div>
            <?php if ($role_id == 8): ?>
                <div class="col-4">
                    <div style="margin-top: 50px;">
                        <label>
                            <input name="show_company" type="checkbox" class="filled-in" <?= @$mechanic->show_company == 1 ? 'checked':'' ?> readonly />
                            <span>Show Company Name</span>
                        </label>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-12">
                <div class="input-field mb-30">
                    <input id="description1" class="browser-default" value="<?=@$mechanic->description?>" name="description" type="text">
                    <label for="description1"><span>Short Description</span></label>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-12">
            <div class="edit__btn  text-right mt-30">
                <button class="btnStyle" id="update_profile" type="submit">Submit profile</button>
            </div>
        </div>
    </div>
</form>
<?php if (in_array($role_id,[4, 15, 16])) :?>
    <form id="businessProfile" class="card-wrap personalProfile status_change mb-35" enctype="multipart/form-data">
        <div class="d-flex flex-wrap justify-content-between mb-20">
            <h3 class="card-title tooltip mb-0"><span class="d-flex align-items-center">
                            Business Information
                            <span data-position="right"
                                  data-tooltip="This is the information buyers will if they want to contact you."
                                  class="tooltip-trigger tooltipped">
                                <img src="assets/new-theme/images/icons/info.svg" alt="icon">
                            </span>
                        </span> <span data-hide="business" class="edit_profile badge-wrap theme-badge ml-10"
                                      style="cursor: pointer;">Edit</span>
            </h3>
        </div>
        <div class="upload-img-wrap mb-30">
            <p>Profile Picture</p>
            <div class="upload-img">
                <img class="preview_profile" src="<?php echo empty($profile_photo) ? 'assets/theme/new/images/backend/img.svg' :  base_url() . "uploads/company_logo/" .$profile_photo ?>" alt="" />
                <button class="upload_btn-wrap waves-effect">
                    Upload
                    <input type='file' id="company_logo" name="company_logo"/>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input id="companyName" value="<?php echo @$post_title;?>" name="companyName" type="text"
                           readonly required>
                    <label for="companyName"><span>Business Name </span></label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input id="business_phone" onkeypress="return DegitOnly(event)" value="<?php echo @$business_phone;?>" name="business_phone" type="text"
                    readonly required>
                    <label for="business_phone"><span>Business Phone Number</span></label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input id="whatsapp_number" onkeypress="return DegitOnly(event)" value="<?php echo @$whatsapp_number;?>" name="whatsapp_number"
                           type="text" readonly required>
                    <label for="whatsapp_number"><span>Whatsapp Number</span></label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input id="address" value="<?php echo @$userLocation;?>" name="userLocation"
                           type="text" readonly required>
                    <label for="address"><span>Address</span></label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input id="website" value="<?php echo @$companyWebsite;?>" name="companyWebsite"
                           type="text" readonly>
                    <label for="website"><span>Website URL</span></label>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12">
                <div class="input-field mb-30">
                    <input id="user_slug" value="<?php echo @$post_url;?>" name="user_slug"
                           type="text" readonly required>
                    <label for="user_slug"><span>Seller Page URL</span></label>
                    <p id="url_link" style="text-decoration:underline;cursor: pointer;"><?php echo @$post_url ? base_url().$profile_url.$post_url : '';?></p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="input-field mb-30">
                            <textarea id="about_us" class="materialize-textarea" name="companyOverview"  required
                                      readonly> <?php echo (@$companyOverview);?></textarea>
                    <label for="about_us"><span>About Us</span></label>
                </div>
            </div>
            <?php if ($role_id == 4) :?>
            <div class="col-12">
                <div class="text-right mb-30 business_hour_btn">
                    <button type="button" class="business_houre-btn waves-effect"><span class="material-icons">
                                    add_circle</span> Add Business Hours</button>
                </div>
            </div>
            <div class="col-12" id="businessHoureAppend">
                <?php
                if ($businessHours):
                    foreach ($businessHours as $key => $businessHour):
                        ?>
                        <div class="business-hour-wrap mb-15">
                            <div class="row align-items-center">
                                <div class="col-lg-4 col-12">
                                    <div class="select2-style mb-0">
                                        <select class="browser-default remove-disable" disabled name="<?php echo $key;?>" id="select_day">
                                            <option disabled="" selected="">Select Day</option>
                                            <option <?php if ($key ==='Monday'):?> selected <?php endif;?> value="Monday">Monday</option>
                                            <option <?php if ($key ==='Tuesday'):?> selected <?php endif;?> value="Tuesday">Tuesday</option>
                                            <option <?php if ($key ==='Wednesday'):?> selected <?php endif;?> value="Wednesday">Wednesday</option>
                                            <option <?php if ($key ==='Thusday'):?> selected <?php endif;?> value="Thusday">Thusday</option>
                                            <option <?php if ($key ==='Friday'):?> selected <?php endif;?> value="Friday">Friday</option>
                                            <option <?php if ($key ==='Saturday'):?> selected <?php endif;?> value="Saturday">Saturday</option>
                                            <option <?php if ($key ==='Sunday'):?> selected <?php endif;?> value="Sunday">Sunday</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="time-field">
                                        <span>From:</span>
                                        <div class="select2-style mb-0">
                                            <select class="browser-default remove-disable" disabled name="<?php echo $key;?>_open_hh" id="select_day">
                                                <?php echo numericDropDown(0,12,1,$businessHour['open_hh']);?>
                                            </select>
                                        </div>
                                        <div class="select2-style mb-0">
                                            <select class="browser-default remove-disable" disabled name="<?php echo $key;?>_open_mm" id="select_day">
                                                <?php echo numericDropDown(0,45,15,$businessHour['open_mm']);?>
                                            </select>
                                        </div>
                                        <ul class="time-duration">
                                            <li>
                                                <label>
                                                    <input class=" with-gap remove-disable" disabled value="AM"  name="<?php echo $key?>_open_am_pm" type="radio" <?php if ($businessHour['open_am_pm'] === 'AM'):?> checked <?php endif;?> >
                                                    <span>AM</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <input class=" with-gap remove-disable" disabled value="PM" name="<?php echo $key?>_open_am_pm" type="radio" <?php if ($businessHour['open_am_pm'] === 'PM'):?> checked <?php endif;?> >
                                                    <span>PM</span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div style="border-right: none;" class="time-field">
                                        <span>To:</span>
                                        <div class="select2-style mb-0">
                                            <select class="browser-default remove-disable" disabled name="<?php echo $key;?>_close_hh" id="select_day">
                                                <?php echo numericDropDown(0,12,1,$businessHour['close_hh']);?>
                                            </select>
                                        </div>
                                        <div class="select2-style mb-0">
                                            <select class="browser-default remove-disable" disabled name="<?php echo $key;?>_close_mm" id="select_day">
                                                <?php echo numericDropDown(0,45,15,$businessHour['close_mm']);?>
                                            </select>
                                        </div>
                                        <ul class="time-duration">
                                            <li>
                                                <label>
                                                    <input class="with-gap remove-disable" disabled name="<?php echo $key?>_close_am_pm" value="AM" type="radio" <?php if ($businessHour['close_am_pm'] === 'AM'):?> checked <?php endif;?>  >
                                                    <span>AM</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <input class="with-gap remove-disable" disabled value="PM" name="<?php echo $key?>_close_am_pm" type="radio" <?php if ($businessHour['close_am_pm'] === 'PM'):?> checked <?php endif;?> >
                                                    <span>PM</span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <span class="material-icons remove-houre d-none">
                                remove_circle_outline
                            </span>
                        </div>
                    <?php endforeach;?>
                <?php else:?>
                    <input type="hidden" value="active" id="editActive">
                <?php endif;?>
            </div>
            <?php endif; ?>
            <div class="col-12">
                <div class="edit__btn  text-right mt-30">
                    <button class="btnStyle" type="submit">Submit Business Profile</button>
                </div>
            </div>
        </div>
    </form>
    <style>
        .select2-container .select2-selection--single{
            height: 55px!important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 55px!important;
        }
    </style>

<?php endif;?>
<?php // pp($is_complete);?>
<script type="text/javascript" src="assets/new-theme/js/select2.min.js"></script>
<script>
    var role_id = parseInt('<?=$role_id?>');
    var user_id = parseInt('<?=$id?>');
    salaryCheck();
    function in_array(needle, haystack)
    {
        for(var key in haystack)
        {
            if(needle === haystack[key])
            {
                return true;
            }
        }

        return false;
    }

    function countryChangeState(countryId){

        if (countryId){
            $.ajax({
                url: 'post_area/Post_area_frontview/get_state_by_country/<?=!empty($state)? $state : 0?>?countryId='+countryId,
                type: "GET",
                dataType: "text",
                success: function (response) {

                    $('#location_id').html(response).trigger('change.select2');
                }
            });
        }
    }

    function getCity() {
        var id = $("#location_id").val();
        jQuery.ajax({
            url: 'all-city?id=' + id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                //jQuery('#city').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#city').html(response).trigger('change.select2');
            }
        });
    }
    function salaryCheck(){
        var status = 0;
        $('.salary').each(function (){
            if (parseInt($(this).val()) > 0 && status !=1){
                status = 1;
            }
        });
        if (status == 1){
            $('.salary-field').val(1);
        }else{
            $('.salary-field').val(' ');
        }
    }
var is_complete = parseInt('<?=$is_complete?>');
    if (!is_complete){
        $('.edit__btn').show();
        $('.upload_btn-wrap').show();
        $('.business_hour_btn').hide()
        $('.status_change').find('.edit__btn').show();
        $('.status_change').find('.business_hour_btn').show();
        $('.status_change').find('.input-field input').removeAttr('readonly')
        $('.status_change').find('.input-field textarea').removeAttr('readonly')
        if (!in_array(role_id, [8, 14])){
            $('#country_select').removeAttr('disabled').trigger("change.select2")
        } else {
            $('#country_select').select2({'disabled' : true});
        }
        $('#services').removeAttr('disabled').trigger("change.select2")
        $('#specialism').removeAttr('disabled').trigger("change.select2")
        $('.status_change').find('.preview_profile').show()
        $('.status_change').addClass('active');
        $('.status_change').find('.upload_btn-wrap').show()
        $('.status_change').find('.edit__btn').show()
        $('.status_change').find('.business_hour_btn').show()

        $('.remove-disable').removeAttr('disabled').trigger("change.select2");
        $('.remove-houre').removeClass('d-none');

        $('input[name="first_name"]').attr('readonly',false);
        $('input[name="last_name"]').attr('readonly',false);
        $('input[name="user_email"]').attr('readonly',false);
        $('input[name="contact"]').attr('readonly',false);
        $('input[name="userAddress1"]').attr('readonly',false);
        // $('input[name="country"]').select2({'disabled' : false});
        //$('input[name="country"]').removeAttr('disabled').trigger("change.select2");
        //$('input[name="userCity"]').attr('readonly',false);
        $('input[name="state"]').attr('readonly',false);
        $('input[name="userPostCode"]').attr('readonly',false);
        $('#personalProfile input[type="text"]').attr('readonly',false);
        $('#personalProfile textarea').attr('readonly',false);
        $('input[type ="number"]').attr('readonly',false);
         $('#location_id').select2({'disabled' : false});
         $('#city').select2({'disabled' : false});

        $('#services').select2();
        $('#specialism').select2();
        $('#state_id').select2();
        $('#city_id').select2();
        $('#service_type').select2();
        $('#is_provide_mobile_service').select2();
        $('#mobile_service_category').select2();
        $('#mobile_service_availability').select2();
        $('#mobile_services').select2();
        $('#vehicle_type_id').select2();
        $('#brand').select2();

    }else{
        $('.preview_profile').show();
        $('.upload_btn-wrap').hide();
        $('.edit__btn').hide()
        $('.business_hour_btn').hide();
        $('#country_select').select2({'disabled' : true});
        $('#location_id').select2({'disabled' : true});
        $('#city').select2({'disabled' : true});
        $('#services').select2({'disabled' : true, multiple : true});
        $('#specialism').select2({'disabled' : true, multiple : true});
        $('#state_id').select2({'disabled' : true});
        $('#city_id').select2({'disabled' : true});
        $('#service_type').select2({'disabled' : true});
        $('#is_provide_mobile_service').select2({'disabled' : true});
        $('#mobile_service_category').select2({'disabled' : true});
        $('#mobile_service_availability').select2({'disabled' : true});
        $('#mobile_services').select2({'disabled' : true});
        $('#vehicle_type_id').select2({'disabled' : true});
        $('#brand').select2({'disabled' : true});
        $('#license_type').select2({'disabled' : true});
        $('#marital_status').select2({'disabled' : true});
        $('#education_type').select2({'disabled' : true});

    }


    $(document).on('click', '.personalProfile .edit_profile', function () {
        $(this).parents('.personalProfile').find('.input-field input').removeAttr('readonly')
        $(this).parents('.personalProfile').find('input[type="radio"]').prop('disabled',false)
        $(this).parents('.personalProfile').find('.input-field textarea').removeAttr('readonly')
        if (in_array(role_id, [8, 14])){
            $(this).parents('.personalProfile').find('.select2-style select:not(#country_select)').select2({'disabled' : false});
        } else {
            $(this).parents('.personalProfile').find('.select2-style select').select2({'disabled' : false});
        }

        $(this).parents('.personalProfile').find('.select2-tags select').select2({'disabled' : false});
        $(this).parents('.personalProfile').find('.preview_profile').show()
        $(this).parents('.personalProfile').addClass('active');
        $(this).parents('.personalProfile').find('.upload_btn-wrap').show()
        $(this).parents('.personalProfile').find('.edit__btn').show()
        $(this).parents('.personalProfile').find('.business_hour_btn').show();

        $('#user_email').attr('readonly', 'readonly')
    })

    $(document).ready(function (){
        $(document).on('keyup','.salary',function (){
            salaryCheck();
        });
        $(document).on('change','.changeName',function (){
            $(this).attr('name',$(this).val());
            $(this).parents('.business-hour-wrap').find('.start_hh').attr('name',$(this).val()+ '_open_hh');
            $(this).parents('.business-hour-wrap').find('.start_mm').attr('name',$(this).val()+ '_open_mm');
            $(this).parents('.business-hour-wrap').find('.am_pm_open').attr('name',$(this).val()+ '_open_am_pm');
            $(this).parents('.business-hour-wrap').find('.close_hh').attr('name',$(this).val()+ '_close_hh');
            $(this).parents('.business-hour-wrap').find('.close_mm').attr('name',$(this).val()+ '_close_mm');
            $(this).parents('.business-hour-wrap').find('.am_pm_close').attr('name',$(this).val()+ '_close_am_pm');
        });
    });

    let businessHoureHtml = "<div class=\"business-hour-wrap mb-15\">\n" +
        "                            <div class=\"row align-items-center\">\n" +
        "                                <div class=\"col-lg-4\">\n" +
        "                                    <div class=\"select2-style mb-0\">\n" +
        "                                        <select class=\"browser-default changeName\" name=\"\" >\n" +
        "                                            <option disabled selected>Select Day</option>\n" +
        "                                            <option value=\"Monday\">Monday</option>\n" +
        "                                            <option value=\"Tuesday\">Tuesday</option>\n" +
        "                                            <option value=\"Wednesday\">Wednesday</option>\n" +
        "                                            <option value=\"Thusday\">Thusday</option>\n" +
        "                                            <option value=\"Friday\">Friday</option>\n" +
        "                                            <option value=\"Saturday\">Saturday</option>\n" +
        "                                            <option value=\"Sunday\">Sunday</option>\n" +
        "                                        </select>\n" +
        "                                    </div>\n" +
        "                                </div>\n" +
        "                                <div class=\"col-lg-4\">\n" +
        "                                    <div class=\"time-field\">\n" +
        "                                        <span>Time From:</span>\n" +
        "                                        <div class=\"select2-style mb-0\">\n" +
        "                                            <select class=\"browser-default start_hh\" name=\"\" >\n" +
        "                                                <?php echo numericDropDown(0,12,1);?>n" +
        "                                            </select>\n" +
        "                                        </div>\n" +
        "                                        <div class=\"select2-style mb-0\">\n" +
        "                                            <select class=\"browser-default start_mm\" name=\"\" >\n" +
        "                                                <?php echo numericDropDown(0,45,15);?>\n" +
        "                                            </select>\n" +
        "                                        </div>\n" +
        "                                        <ul class=\"time-duration\">\n" +
        "                                            <li>\n" +
        "                                                <label>\n" +
        "                                                    <input class=\"with-gap am_pm_open\" value=\"AM\" name=\"\" type=\"radio\" checked />\n" +
        "                                                    <span>AM</span>\n" +
        "                                                </label>\n" +
        "                                            </li>\n" +
        "                                            <li>\n" +
        "                                                <label>\n" +
        "                                                    <input class=\"with-gap am_pm_open\" value=\"PM\" name=\"\" type=\"radio\" />\n" +
        "                                                    <span>PM</span>\n" +
        "                                                </label>\n" +
        "                                            </li>\n" +
        "                                        </ul>\n" +
        "                                    </div>\n" +
        "                                </div>\n" +
        "                                <div class=\"col-lg-4\">\n" +
        "                                    <div style=\"border-right: none;\" class=\"time-field\">\n" +
        "                                        <span>To:</span>\n" +
        "                                        <div class=\"select2-style mb-0\">\n" +
        "                                            <select class=\"browser-default close_hh\" name=\"\" id=\"select_day\">\n" +
        "                                                <?php echo numericDropDown(0,12,1);?>\n" +
        "                                            </select>\n" +
        "                                        </div>\n" +
        "                                        <div class=\"select2-style mb-0\">\n" +
        "                                            <select class=\"browser-default close_mm\" name=\"\" id=\"select_day\">\n" +
        "                                                <?php echo numericDropDown(0,45,15);?>\n" +
        "                                            </select>\n" +
        "                                        </div>\n" +
        "                                        <ul class=\"time-duration\">\n" +
        "                                            <li>\n" +
        "                                                <label>\n" +
        "                                                    <input class=\"with-gap am_pm_close\" value=\"AM\" name=\"\" type=\"radio\" />\n" +
        "                                                    <span>AM</span>\n" +
        "                                                </label>\n" +
        "                                            </li>\n" +
        "                                            <li>\n" +
        "                                                <label>\n" +
        "                                                    <input class=\"with-gap am_pm_close\" value=\"PM\" name=\"\" type=\"radio\" checked />\n" +
        "                                                    <span>PM</span>\n" +
        "                                                </label>\n" +
        "                                            </li>\n" +
        "                                        </ul>\n" +
        "                                    </div>\n" +
        "                                </div>\n" +
        "                            </div>\n" +
        "                            <span class=\"material-icons remove-houre\">\n" +
        "                                remove_circle_outline\n" +
        "                            </span>\n" +
        "                        </div>"


    var count = 0;
    $(document).on('click', '.business_houre-btn', function () {
        count += 1;
        if (count < 8) {
            $('#businessHoureAppend').append(businessHoureHtml)
        } else {
            $(this).off('click');
            tosetrMessage('warning', 'you can add only 7 items')
        }
    })
    $(document).on('click', '.remove-houre', function () {
        $(this).parent('.business-hour-wrap').remove()
    })

    function tosetrMessage(type, message) {
        $('.tostfyMessage').css({ "bottom": "5px", "visibility": "visible", "opacity": 1 });
        $('.tostfyMessage').find('.messageValue').text(message);
        if (type == 'success') {
            $('.tostfyMessage').css('background', 'rgb(76, 175, 80)')
        } else if (type == 'warning') {
            $('.tostfyMessage').css('background', 'rgb(255, 152, 0)')
        } else if (type == 'error') {
            $('.tostfyMessage').css('background', 'rgb(244, 67, 54)')
        }
        setTimeout(function () {
            $('.tostfyMessage').css({ "bottom": "-100%", "visibility": "hidden", "opacity": 0 })
        }, 5000);
        $('.tostfyClose').on('click', function () {
            $('.tostfyMessage').css({ "bottom": "-100%", "visibility": "hidden", "opacity": 0 })
        })
    }
</script>
<script src="assets/new-theme/js/jquery.validate.min.js"></script>
<script>

    $(window).on('load',function (){
        $('.preview_profile').css("display","block");

        //countryChangeState(<?php //echo $country_id ;?>//);
    });
    function DegitOnly(e){
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if (unicode!=8 && unicode!=9)
        {
            if (unicode<46||unicode>57||unicode==47)
                return false
        }
    }
    $('#personalProfile').validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            contact: {
                required: true,
            },
            user_email: {
                required: true,
            },
            add_line:{
                required:true,
            },
            country_select:{
                required:true,
            },
            state:{
                required: true,
            },
            city:{
                required: true,
            },
            state_id:{
                required:true
            },
            vehicle_type_id : {
                required : true
            },
            license_type : {
                required : true
            },
            education_type : {
                required : true
            },
            marital_status : {
                required : true
            },
            salary:{
                required:true
            }
        },
        messages: {
            first_name: {
                required: 'First Name can not be empty',
            },
            last_name: {
                required: 'Last Name can not be empty',
            },
            contact: {
                required: 'Contact can not be empty',
            },
            user_email: {
                required: 'Email can not be empty',
            },
            add_line:{
                required: 'Address Line can not be empty',
            },
            country_select:{
                required: 'Country can not be empty',
            },
            state:{
                required: 'State can not be empty',
            },
            city:{
                required: 'City can not be empty',
            },
            salary:{
                required:'Minimum 1 salary feild is required'
            }

        },
        submitHandler:function (form) {
            var newFormData = new FormData($('#personalProfile')[0]);
            jQuery.ajax({
                url: 'admin/profile/update',
                type: "POST",
                data: newFormData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    tosetrMessage('warning','Please wait...')
                },
                success: function ( jsonRespond ) {
                    if(jsonRespond.Status === 'OK'){
                        tosetrMessage('success','User profile Update Successfully...!!')
                        if (role_id == 14){
                           var firstTime =  localStorage.getItem('first_time_'+user_id);
                           if (firstTime == null || firstTime == ''){
                               localStorage.setItem('first_time_'+user_id,1);
                               window.location.href = '<?php echo base_url(); ?>'+'admin/driver/availability';
                           }
                        }
                    }else{
                        tosetrMessage('error','User profile not Update Successfully...!!')
                    }
                }
            });
        }
    });

    $('#businessProfile').validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules: {
            companyName: {
                required: true,
            },
            business_phone:{
                required :true
            },
            whatsapp_number:{
                required:true
            },
            address:{
                required:true
            },
            user_slug:{
                required:true
            },
            about_us:{
                required:true
            }


        },
        messages: {
            companyName: {
                required: 'Company Nmae can not be empty',
            },
            business_phone: {
                required: 'Business Phone can not be empty',
            },
            whatsapp_number: {
                required: 'Whatsapp Number can not be empty',
            },
            address: {
                required: 'Address can not be empty',
            },
            user_slug: {
                required: 'Seller Page url can not be empty',
            },
            about_us: {
                required: 'About us can not be empty',
            }
        },
        submitHandler:function (form) {
            var newFormData = new FormData($('#businessProfile')[0]);

            jQuery.ajax({
                url: 'admin/profile/business_update',
                type: "POST",
                data: newFormData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    tosetrMessage('warning','Please wait...')
                },
                success: function ( jsonRespond ) {
                    if(jsonRespond.Status === 'OK'){
                        tosetrMessage('success','Business profile Update Successfully...!!')
                    }
                }
            });
        }
    });

    $("#companyName, #user_slug").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        $("#user_slug").val(Text);
        if (Text != ''){
            var baseUrl = '<?php echo base_url(); ?>';
            var profileUrl = '<?php echo $profile_url; ?>';
            $('#url_link').text(baseUrl + profileUrl + Text);
        }else{
            $('#url_link').text('');
        }
    });

    $("#driver_slug").on('keyup keypress change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        if (Text != ''){
            var baseUrl = '<?php echo base_url(); ?>'+'driver-details/';
            $('#url_link').text(baseUrl + Text);
        }else{
            $('#url_link').text('');
        }
    });
    $("#driver_slug").on('blur', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        Text = Text.replace(/\d+/g, '');
        Text = Text + '-'+'<?=$id?>';
        $("#driver_slug").val(Text);
        if (Text != ''){
            var baseUrl = '<?php echo base_url(); ?>'+'driver-details/';
            $('#url_link').text(baseUrl + Text);
        }else{
            $('#url_link').text('');
        }
    });

    $('#mechanic_slug').on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        $("#mechanic_slug").val(Text);
        if (Text != ''){
            var baseUrl = '<?php echo base_url(); ?>'+'mechanic-details/';
            $('#url_link').text(baseUrl + Text);
        }else{
            $('#url_link').text('');
        }
    });
    $('#slug').on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        $("#mechanic_slug").val(Text);
        if (Text != ''){
            var baseUrl = '<?php echo base_url(); ?>'+'hire-verifier/';
            $('#url_link').text(baseUrl + Text);
        }else{
            $('#url_link').text('');
        }
    });
    //Select 2 Js


    $('#url_link').on('click', function(){
        var pageUrl =$(this).text();
        copyToClipboard('#url_link');
        tosetrMessage('success','Url copy to clipboard');
    });
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }

    $('#state_id').on('change', function(){
        var location_id = '<?=@$mechanic->city_id?>';
        var state_id = $(this).val().toString();

        $.ajax({
            url: 'post_area/Post_area_frontview/location_for_profile',
            type: "GET",
            data : { location_id, state_id},
            dataType: "text",
            success: function (response) {

                $('#city_id').html(response).trigger('change.select2');
            }
        });
    })


    $('#mobile_service_category').on('change', function(){
        var selected = '<?=@$mechanic->mobile_services?>'
        var cat_id = $(this).val().toString();

        $.ajax({
            url: 'posts/posts_frontview/towing_type_of_services_for_service',
            type: "GET",
            data : { cat_id, selected},
            dataType: "text",
            success: function (response) {

                $('#mobile_services').html(response).trigger('change.select2');
            }
        });
    })

    $('#is_provide_mobile_service').on('change', function(){
        if ($(this).val() == 1){
            $('.mobile-services').removeClass('d-none')
        } else {
            $('.mobile-services').addClass('d-none')
        }
    })

</script>
