<?php
$name = ucfirst(str_replace('-', ' ', $this->uri->segment(2)));

$text = '';
$new_icon = '';
$nigeria_used_icon = '';
$foreign_used_icon = '';
if ($this->uri->segment(2) == 'car'){
    $text = 'Find New and Used Cars';
    $new_icon = 'directions_car';
    $nigeria_used_icon = 'local_taxi';
    $foreign_used_icon = 'local_taxi';
} elseif ($this->uri->segment(2) == 'motorbike'){
    $text = 'Find New and Used Motorbikes';
    $new_icon = 'two_wheeler';
    $nigeria_used_icon = 'electric_bike';
    $foreign_used_icon = 'electric_bike';
} elseif ($this->uri->segment(2) == 'spare-parts'){
    $text = 'Buy New and Used Spare Parts for Cars and Motorbike';
    $new_icon = 'miscellaneous_services';
    $nigeria_used_icon = 'settings';
    $foreign_used_icon = 'settings';
}
?>
<span class="category-filtar">
    <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0.53575 2.67825H0.611826C0.728765 3.1377 0.995454 3.54509 1.36976 3.83606C1.74407 4.12703 2.20465 4.285 2.67875 4.285C3.15285 4.285 3.61343 4.12703 3.98774 3.83606C4.36205 3.54509 4.62873 3.1377 4.74567 2.67825H15.5367C15.6788 2.67825 15.8151 2.6218 15.9156 2.52133C16.0161 2.42086 16.0725 2.28459 16.0725 2.1425C16.0725 2.00041 16.0161 1.86414 15.9156 1.76367C15.8151 1.66319 15.6788 1.60675 15.5367 1.60675H4.74567C4.62873 1.1473 4.36205 0.739907 3.98774 0.448935C3.61343 0.157964 3.15285 0 2.67875 0C2.20465 0 1.74407 0.157964 1.36976 0.448935C0.995454 0.739907 0.728765 1.1473 0.611826 1.60675H0.53575C0.39366 1.60675 0.25739 1.66319 0.156918 1.76367C0.0564449 1.86414 0 2.00041 0 2.1425C0 2.28459 0.0564449 2.42086 0.156918 2.52133C0.25739 2.6218 0.39366 2.67825 0.53575 2.67825ZM2.67875 1.071C2.89067 1.071 3.09784 1.13384 3.27404 1.25158C3.45025 1.36932 3.58759 1.53666 3.66869 1.73245C3.74979 1.92824 3.77101 2.14369 3.72966 2.35154C3.68832 2.55939 3.58627 2.75031 3.43641 2.90016C3.28656 3.05002 3.09564 3.15207 2.88779 3.19341C2.67994 3.23475 2.4645 3.21354 2.2687 3.13244C2.07291 3.05134 1.90557 2.914 1.78783 2.73779C1.67009 2.56158 1.60725 2.35442 1.60725 2.1425C1.60725 1.85832 1.72014 1.58578 1.92108 1.38483C2.12203 1.18389 2.39457 1.071 2.67875 1.071ZM15.5367 6.96425H15.4607C15.3437 6.5048 15.077 6.09741 14.7027 5.80644C14.3284 5.51546 13.8678 5.3575 13.3937 5.3575C12.9197 5.3575 12.4591 5.51546 12.0848 5.80644C11.7105 6.09741 11.4438 6.5048 11.3268 6.96425H0.53575C0.39366 6.96425 0.25739 7.02069 0.156918 7.12117C0.0564449 7.22164 0 7.35791 0 7.5C0 7.64209 0.0564449 7.77836 0.156918 7.87883C0.25739 7.9793 0.39366 8.03575 0.53575 8.03575H11.3268C11.4438 8.4952 11.7105 8.90259 12.0848 9.19356C12.4591 9.48454 12.9197 9.6425 13.3937 9.6425C13.8678 9.6425 14.3284 9.48454 14.7027 9.19356C15.077 8.90259 15.3437 8.4952 15.4607 8.03575H15.5367C15.6788 8.03575 15.8151 7.9793 15.9156 7.87883C16.0161 7.77836 16.0725 7.64209 16.0725 7.5C16.0725 7.35791 16.0161 7.22164 15.9156 7.12117C15.8151 7.02069 15.6788 6.96425 15.5367 6.96425ZM13.3937 8.5715C13.1818 8.5715 12.9747 8.50866 12.7985 8.39092C12.6222 8.27318 12.4849 8.10584 12.4038 7.91004C12.3227 7.71425 12.3015 7.49881 12.3428 7.29096C12.3842 7.08311 12.4862 6.89219 12.6361 6.74233C12.7859 6.59248 12.9769 6.49043 13.1847 6.44909C13.3926 6.40774 13.608 6.42896 13.8038 6.51006C13.9996 6.59116 14.1669 6.7285 14.2847 6.90471C14.4024 7.08091 14.4652 7.28808 14.4652 7.5C14.4652 7.78418 14.3524 8.05672 14.1514 8.25766C13.9505 8.45861 13.6779 8.5715 13.3937 8.5715ZM15.5367 12.3217H10.1032C9.98623 11.8623 9.71955 11.4549 9.34524 11.1639C8.97093 10.873 8.51035 10.715 8.03625 10.715C7.56215 10.715 7.10157 10.873 6.72726 11.1639C6.35295 11.4549 6.08627 11.8623 5.96933 12.3217H0.53575C0.39366 12.3217 0.25739 12.3782 0.156918 12.4787C0.0564449 12.5791 0 12.7154 0 12.8575C0 12.9996 0.0564449 13.1359 0.156918 13.2363C0.25739 13.3368 0.39366 13.3933 0.53575 13.3933H5.96933C6.08627 13.8527 6.35295 14.2601 6.72726 14.5511C7.10157 14.842 7.56215 15 8.03625 15C8.51035 15 8.97093 14.842 9.34524 14.5511C9.71955 14.2601 9.98623 13.8527 10.1032 13.3933H15.5367C15.6788 13.3933 15.8151 13.3368 15.9156 13.2363C16.0161 13.1359 16.0725 12.9996 16.0725 12.8575C16.0725 12.7154 16.0161 12.5791 15.9156 12.4787C15.8151 12.3782 15.6788 12.3217 15.5367 12.3217ZM8.03625 13.929C7.82433 13.929 7.61716 13.8662 7.44096 13.7484C7.26475 13.6307 7.12741 13.4633 7.04631 13.2675C6.96521 13.0718 6.94399 12.8563 6.98534 12.6485C7.02668 12.4406 7.12873 12.2497 7.27858 12.0998C7.42844 11.95 7.61936 11.8479 7.82721 11.8066C8.03506 11.7652 8.2505 11.7865 8.44629 11.8676C8.64209 11.9487 8.80943 12.086 8.92717 12.2622C9.04491 12.4384 9.10775 12.6456 9.10775 12.8575C9.10775 13.1417 8.99486 13.4142 8.79391 13.6152C8.59297 13.8161 8.32043 13.929 8.03625 13.929Z" fill="#F05C26"/>
    </svg>
    <span>Filter</span>
</span>
<!-- find-car-area start  -->
<div class="find-car-area bg-grey ptb-50 mb-40 pr d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="find-car-wrap">
                    <form method="get" action="buy/<?=$this->uri->segment(2)?>/search">
                    <h1 class="fw-500 fs-34 mb-30"><?=$text?></h1>
                    <div class="filter-wrap bg-white p-30 mb-10">
                        <ul class="post_info-tabs tabs">
                            <li class="tab">
                                <a class="active waves-effect" href="#all" onclick="set_condition('')">
                                    <span class="material-icons"><?=$new_icon?></span>
                                    All
                                </a>
                            </li>

                            <li class="tab">
                                <a class="active waves-effect" href="#new_car" onclick="set_condition('New')">
                                    <span class="material-icons"><?=$new_icon?></span>
                                    New
                                </a>
                            </li>

                            <li class="tab">
                                <a class="waves-effect" href="#locally_use" onclick="set_condition('Locally used')">
                                    <span class="material-icons"><?=$nigeria_used_icon?></span>
                                    Locally Used
                                </a>
                            </li>
                            <?php if ($this->uri->segment(2) !== 'spare-parts'):?>
                            <li class="tab">
                                <a class="waves-effect" href="#foreign_use" onclick="set_condition('Foreign used')">
                                    <span class="material-icons"><?=$foreign_used_icon?></span>
                                   Foreign Used
                                </a>
                            </li>
                            <?php endif;?>
                        </ul>
                        <ul class="d-flex flex-wrap filter-wrap-search">
                            <div id="condition_section">

                            </div>
                            <?php if (in_array($vehicle_type_id, [1, 3])) {?>
                            <li>
                                <select name="location" class="location">
                                    <?php echo GlobalHelper::all_location_select(0, 'Select State'); ?>
                                </select>
                            </li>
                            <li>
                                <select name="address" id="address">
                                    <?php echo GlobalHelper::all_city(0,0, 'Select Location'); ?>
                                </select>
                            </li>
                            <li>
                                <select name="brand" class=" brand-selector">
                                    <option value="" disabled selected>Brand</option>
                                    <?=GlobalHelper::get_brands_for_select($vehicle_type_id)?>
                                </select>
                            </li>
                            <li>
                                <select name="model" class=" model-selector">
                                    <option value="" disabled selected>Model</option>
                                    <?=GlobalHelper::get_model_for_select(0, 0);?>
                                </select>
                            </li>
                            <li>
                                <select name="price_from">
                                    <option value="" selected disabled>Min Price</option>
                                    <?php echo getNewPriceDropDown()?>
                                </select>
                            </li>
                            <li>
                                <select name="price_to">
                                    <option value="" selected disabled>Max Price</option>
                                    <?php echo getNewPriceDropDown()?>
                                </select>
                            </li>
                            <?php } else{ ?>
                                <li>
                                    <input name="global_search" class="browser-default default-input" placeholder="Search Parts" type="text">
                                </li>
                                <li>
                                    <select name="brand" class=" brand-selector">
                                        <option value="" disabled selected>Brand</option>
                                        <?=GlobalHelper::get_brands_for_select($vehicle_type_id)?>
                                    </select>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="filter-wrap bg-white p-30 advance-search">
                        <ul class="d-flex flex-wrap filter-wrap-search">
                            <?php if (in_array($vehicle_type_id, [1, 3])) {?>
                            <li>
                                <select name="from_year">
                                    <option value="" selected disabled>From Year</option>
                                    <?php echo numericDropDown(1950, date('Y'), 1); ?>
                                </select>
                            </li>
                            <li>
                                <select name="to_year">
                                    <option value="" selected disabled>To Year</option>
                                    <?php echo numericDropDown(1950, date('Y'), 1); ?>
                                </select>
                            </li>
                            <li>
                                <select name="color_id">
                                    <option value="" selected disabled>Colour</option>
                                    <?php echo GlobalHelper::createDropDownFromTable($tbl = 'color', $col = 'color_name'); ?>
                                </select>
                            </li>
                            <li>
                                <select name="fuel_type">
                                    <option value="" selected disabled>Fuel</option>
                                    <?php echo GlobalHelper::createDropDownFromTable($tbl = 'fuel_types', $col = 'fuel_name', 0); ?>
                                </select>
                            </li>
                            <li>
                                <select name="transmission">
                                    <option value="" selected disabled>Transmission</option>
                                    <?php echo GlobalHelper::gearBox(); ?>
                                </select>
                            </li>
                            <?php } else{ ?>
                                <li>
                                    <input id="parts_id" value="" name="parts_id" type="text" class="browser-default default-input" placeholder="parts id">
                                </li>
                                <li>
                                    <select name="model" class=" model-selector">
                                        <option value="" disabled selected>Model</option>
                                        <?=GlobalHelper::get_model_for_select(0, 0);?>
                                    </select>
                                </li>
                                <li>
                                    <select name="from_year">
                                        <option value="" selected disabled>From Year</option>
                                        <?php echo numericDropDown(1950, date('Y'), 1); ?>
                                    </select>
                                </li>
                                <li>
                                    <select name="to_year">
                                        <option value="" selected disabled>To Year</option>
                                        <?php echo numericDropDown(1950, date('Y'), 1); ?>
                                    </select>
                                </li>
                                <li>
                                    <select name="location" class="location">
                                        <?php echo GlobalHelper::all_location_select(0, 'Select State'); ?>
                                    </select>
                                </li>
                                <li>
                                    <select name="address" id="address">
                                        <?php echo GlobalHelper::all_city(0, 0, 'Select Location'); ?>
                                    </select>
                                </li>
                                <li>
                                    <select name="category_id">
                                        <option value="" selected disabled>Category</option>
                                        <?php echo GlobalHelper::parts_categories(); ?>
                                    </select>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <ul class="d-flex flex-wrap mt-30 align-items-center">
                        <li><button class="btnStyle">Find <?=$name?> <span
                                    class="material-icons ml-10">east</span></button></li>
                        <li><span class="advanceSearchTrigger fw-500 color-seconday">Advance Search</span></li>
                    </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <img class="pa top-50 r-0 d-none d-lg-block" src="assets/new-theme/images/shapes/cars.png" alt="">
</div>

<div class="responsive-filtar-wrap d-block d-lg-none">
    <form method="get" action="buy/<?=$this->uri->segment(2)?>/search">
        <div class="wrapper-filtar">
            <span class="close-filtar">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 1L1 14M1 1L14 14" stroke="#F05C26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <ul class="filtar-tabs tabs">
                <li class="tab">
                    <a class="active waves-effect" href="#all" onclick="set_condition('')">
                        <span class="material-icons"><?=$new_icon?></span>
                        All
                    </a>
                </li>

                <li class="tab">
                    <a class="active waves-effect" href="#new_car" onclick="set_condition('New')">
                        <span class="material-icons"><?=$new_icon?></span>
                        New
                    </a>
                </li>

                <li class="tab">
                    <a class="waves-effect" href="#nigeria_use" onclick="set_condition('Nigerian used')">
                        <span class="material-icons"><?=$nigeria_used_icon?></span>
                        Nigeria Used
                    </a>
                </li>
                <?php if ($this->uri->segment(2) !== 'spare-parts'):?>
                <li class="tab remove-border">
                    <a class="waves-effect" href="#foreign_use" onclick="set_condition('Foreign used')">
                        <span class="material-icons"><?=$foreign_used_icon?></span>
                        Foreign Used
                    </a>
                </li>
                <?php endif;?>
            </ul>
            <ul class="filtar-responsive-search">
                <div id="condition_section_res">

                </div>
                <?php if (in_array($vehicle_type_id, [1, 3])) {?>
                <li>
                    <select name="location" class="location">
                        <?php echo GlobalHelper::all_location_select(0, 'Select State'); ?>
                    </select>
                </li>
                <li>
                    <select name="address" id="address_res">
                        <?php echo GlobalHelper::all_city(0,0, 'Select Location'); ?>
                    </select>
                </li>
                <li>
                    <select name="brand" class=" brand-selector">
                        <option value="" disabled selected>Brand</option>
                        <?=GlobalHelper::get_brands_for_select($vehicle_type_id)?>
                    </select>
                </li>
                <li>
                    <select name="model" class=" model-selector">
                        <option value="" disabled selected>Model</option>
                        <?=GlobalHelper::get_model_for_select(0, 0);?>
                    </select>
                </li>
                <li>
                    <select name="price_from">
                        <option value="" selected disabled>Min Price</option>
                        <?php echo getNewPriceDropDown()?>
                    </select>
                </li>
                <li>
                    <select name="price_to">
                        <option value="" selected disabled>Max Price</option>
                        <?php echo getNewPriceDropDown()?>
                    </select>
                </li>
                <?php } else{ ?>
                    <li>
                        <input name="global_search" class="browser-default default-input" placeholder="Search Parts" type="text">
                    </li>
                    <li>
                        <select name="brand" class=" brand-selector">
                            <option value="" disabled selected>Brand</option>
                            <?=GlobalHelper::get_brands_for_select($vehicle_type_id)?>
                        </select>
                    </li>
                <?php } ?>
            </ul>
            <span class="advance-search-trigger">
                <svg class="icon" width="23" height="26" viewBox="0 0 23 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16.4587 7.0367V5.6055C16.4587 5.47431 16.3514 5.36697 16.2202 5.36697H4.77064C4.63945 5.36697 4.53211 5.47431 4.53211 5.6055V7.0367C4.53211 7.16789 4.63945 7.27523 4.77064 7.27523H16.2202C16.3514 7.27523 16.4587 7.16789 16.4587 7.0367ZM4.77064 9.66055C4.63945 9.66055 4.53211 9.76789 4.53211 9.89908V11.3303C4.53211 11.4615 4.63945 11.5688 4.77064 11.5688H10.2569C10.3881 11.5688 10.4954 11.4615 10.4954 11.3303V9.89908C10.4954 9.76789 10.3881 9.66055 10.2569 9.66055H4.77064ZM9.06422 23.1376H2.14679V2.14679H18.844V12.4037C18.844 12.5349 18.9514 12.6422 19.0826 12.6422H20.7523C20.8835 12.6422 20.9908 12.5349 20.9908 12.4037V0.954128C20.9908 0.426376 20.5644 0 20.0367 0H0.954128C0.426376 0 0 0.426376 0 0.954128V24.3303C0 24.858 0.426376 25.2844 0.954128 25.2844H9.06422C9.19541 25.2844 9.30275 25.1771 9.30275 25.0459V23.3761C9.30275 23.245 9.19541 23.1376 9.06422 23.1376ZM22.3534 24.6732L19.5716 21.8913C20.2365 21.0117 20.633 19.9144 20.633 18.7248C20.633 15.8266 18.2835 13.4771 15.3853 13.4771C12.4872 13.4771 10.1376 15.8266 10.1376 18.7248C10.1376 21.6229 12.4872 23.9725 15.3853 23.9725C16.4528 23.9725 17.4427 23.6534 18.2716 23.1078L21.0952 25.9314C21.1429 25.9791 21.2025 26 21.2622 26C21.3218 26 21.3844 25.9761 21.4291 25.9314L22.3534 25.0071C22.3754 24.9852 22.3929 24.9592 22.4048 24.9305C22.4167 24.9019 22.4228 24.8712 22.4228 24.8401C22.4228 24.8091 22.4167 24.7784 22.4048 24.7497C22.3929 24.7211 22.3754 24.6951 22.3534 24.6732ZM15.3853 22.0642C13.5397 22.0642 12.0459 20.5704 12.0459 18.7248C12.0459 16.8791 13.5397 15.3853 15.3853 15.3853C17.231 15.3853 18.7248 16.8791 18.7248 18.7248C18.7248 20.5704 17.231 22.0642 15.3853 22.0642Z" fill="#F05C26"/>
                </svg>
                Advance Search

                <svg class="arrow" width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.97369 13.0699L13.0043 9.60525L9.03529 6.07019L8.97369 13.0699Z" fill="#F05C26"/>
                    <circle cx="11" cy="10.0876" r="9.5" transform="rotate(-89.4958 11 10.0876)" stroke="#F05C26"/>
                </svg>

            </span>
            <ul class="filtar-responsive-search advance">
                <?php if (in_array($vehicle_type_id, [1, 3])) {?>
                <li>
                    <select name="from_year">
                        <option value="" selected disabled>From Year</option>
                        <?php echo numericDropDown(1950, date('Y'), 1); ?>
                    </select>
                </li>
                <li>
                    <select name="to_year">
                        <option value="" selected disabled>To Year</option>
                        <?php echo numericDropDown(1950, date('Y'), 1); ?>
                    </select>
                </li>
                <li>
                    <select name="color_id">
                        <option value="" selected disabled>Colour</option>
                        <?php echo GlobalHelper::createDropDownFromTable($tbl = 'color', $col = 'color_name'); ?>
                    </select>
                </li>
                <li>
                    <select name="fuel_type">
                        <option value="" selected disabled>Fuel</option>
                        <?php echo GlobalHelper::createDropDownFromTable($tbl = 'fuel_types', $col = 'fuel_name', 0); ?>
                    </select>
                </li>
                <li>
                    <select name="transmission">
                        <option value="" selected disabled>Transmission</option>
                        <?php echo GlobalHelper::gearBox(); ?>
                    </select>
                </li>
                <?php } else{ ?>
                    <li>
                        <input id="parts_id_res" value="" name="parts_id" type="text" class="browser-default default-input" placeholder="parts id">
                    </li>
                    <li>
                        <select name="model" class=" model-selector">
                            <option value="" disabled selected>Model</option>
                            <?=GlobalHelper::get_model_for_select(0, 0);?>
                        </select>
                    </li>
                    <li>
                        <select name="from_year">
                            <option value="" selected disabled>From Year</option>
                            <?php echo numericDropDown(1950, date('Y'), 1); ?>
                        </select>
                    </li>
                    <li>
                        <select name="to_year">
                            <option value="" selected disabled>To Year</option>
                            <?php echo numericDropDown(1950, date('Y'), 1); ?>
                        </select>
                    </li>
                    <li>
                        <select name="location" class="location" >
                            <?php echo GlobalHelper::all_location_select(0, 'Select State'); ?>
                        </select>
                    </li>
                    <li>
                        <select name="address" id="address">
                            <?php echo GlobalHelper::all_city(0, 0, 'Select Location'); ?>
                        </select>
                    </li>
                    <li>
                        <select name="category_id">
                            <option value="" selected disabled>Category</option>
                            <?php echo GlobalHelper::parts_categories(); ?>
                        </select>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <button class="btnStyle">Find <?=$name?> <span class="material-icons ml-10">east</span></button>
    </form>
</div>
<!-- find-car-area end  -->


<!-- .buy-area start  -->
<div class="buy-area pt-75 pb-45">
    <div class="container">
        <div class="row mb-20">
            <div class="col-12">
                <div class="title-link d-flex align-items-center justify-content-between pb-10 mb-30 bb-1">
                    <h5 class="mb-0 fs-16 fw-500">Best <?=$name?> Deals This Month</h5>
                    <a class="d-flex align-items-center fs-14 fw-500" href="buy/<?=$this->uri->segment(2)?>/search">See All <span
                            class="material-icons ml-10 bg-theme br-3 color-white fs-18">east</span></button></a>
                </div>
            </div>
            <?php foreach ($trending as $k => $post) {?>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="carPost-wrap">
                    <a class="carPost-img" href="post/<?=$post->post_slug?>">
                        <?=GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, 'grayscale lazyload post-img',getShortContentAltTag(($post->title), 60))?>
                    </a>
                    <div class="carPost-content">
                        <span class="level"><?=$post->condition?></span>
                        <h4><a href="post/<?=$post->post_slug?>"><?=getShortContent(($post->title), 20)?></a>
                            <?php if ($post->is_verified == 'Verified seller') { ?>
                                <img src="assets/new-theme/images/icons/verify-new.svg" title="Verified" alt="">
                            <?php } ?>
                        </h4>
                        <ul class="post-price">
                            <li class="price"><?=GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein)?></li>
                            <?php
                            if ($post->vehicle_type_id == 1){
                                echo "<li class=\"km\">".number_shorten($post->mileage)." Miles</li>";
                            }
                            ?>
                        </ul>
                        <span class="location"><?=$post->location?>, <?=$post->state_name?></span>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="title-link d-flex align-items-center justify-content-between pb-10 mb-30 bb-1">
                    <h5 class="mb-0 fs-16 fw-500">Recently Posted <?=$name?></h5>
                    <a class="d-flex align-items-center fs-14 fw-500" href="buy/<?=$this->uri->segment(2)?>/search">See All <span
                            class="material-icons ml-10 bg-theme br-3 color-white fs-18">east</span></button></a>
                </div>
            </div>
            <?php foreach ($latest as $k => $post) {?>
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="carPost-wrap">
                        <a class="carPost-img" href="post/<?=$post->post_slug?>">
                            <?=GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, 'grayscale lazyload post-img',getShortContentAltTag(($post->title), 60))?>
                        </a>
                        <div class="carPost-content">
                            <span class="level"><?=$post->condition?></span>
                            <h4><a href="post/<?=$post->post_slug?>"><?=getShortContent(($post->title), 18)?></a>
                                <?php if ($post->is_verified == 'Verified seller') { ?>
                                    <img src="assets/new-theme/images/icons/verify-new.svg" title="Verified" alt="">
                                <?php } ?>
                            </h4>
                            <ul class="post-price">
                                <li class="price"><?=GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein)?></li>
                                <?php
                                if ($post->vehicle_type_id == 1){
                                    echo "<li class=\"km\">".number_shorten($post->mileage)." Miles</li>";
                                }
                                ?>
                            </ul>
                            <span class="location"><?=$post->location?>, <?=$post->state_name?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- .buy-area end  -->
<script type="text/javascript" src="assets/theme/new/js/select2.min.js"></script>
<script>
	$('.filter-wrap-search li select,.wrapper-filtar li select').select2({
        width: '100%',
        selectionCssClass: "filter-wrap-search_section",
        dropdownCssClass: "filter-wrap-search_dropdown"
    });


    $('.advanceSearchTrigger').on('click', function () {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $(this).text('Hide Advance Search')
        } else {
            $(this).text('Advance Search')

        }
        $('.advance-search').toggleClass('active');
        $(this).parents('ul').toggleClass('active');
    })
    function set_condition(value){
        if (value){
            $('#condition_section').html(`<input name="condition" id="condition" value="${value}" type="hidden">`);
            $('#condition_section_res').html(`<input name="condition" id="condition" value="${value}" type="hidden">`);
        } else {
            $('#condition_section_res').html('');
            $('#condition_section').html('');
        }
    }

    $(document).on('change', '.brand-selector', function () {
        var vehicle_type_id = '<?=$vehicle_type_id?>';
        var id = $(this).val();

        jQuery.ajax({
            url: 'brands/brands_frontview/brands_by_vehicle_model_select',
            type: "GET",
            dataType: "text",
            data: {id, vehicle_type_id},
            beforeSend: function () {
                jQuery('.model-selector').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('.model-selector').html(response);
            }
        });
    })

    $('.location').on('change',function(e){
        jQuery.ajax({
            url: 'all-city-slug?slug=' + e.target.value,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                jQuery('#address').html('<option value="0">Loading...</option>');
                jQuery('#address_res').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#address_res').html(response);
                jQuery('#address').html(response);
            }
        });
    })

</script>
