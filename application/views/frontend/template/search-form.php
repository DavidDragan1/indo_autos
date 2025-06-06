<style>
    .select2-wrapper .select2-container .selection .select2-selection .select2-selection__rendered {
         color: black;
    }

    .search-sidebar-header select {
        width: 150px;
        color: #011a39;
        height: 40px;
        background: #fff;
        font-size: 14px;
        padding: 0px 10px;
        border-radius: 5px;
        border: 1px solid #727b82;
        -webkit-appearance: none;
    }

</style>
<aside class="rearch-result-sidebar">
    <div class="search-sidebar-header">
        <span>City / Town</span>
<!--        <input type="text" id="autocomplete" name="address"-->
<!--               value="--><?php //echo $this->input->get('address'); ?><!--">-->
            <select name="address" id="location">
                <?php echo GlobalHelper::all_city(0, $this->input->get('address')); ?>
            </select>
        <input type="hidden" name="lat" id="latitude" value="">
        <input type="hidden" name="lng" id="longitude" value="">
    </div>
    <div class="accordion" id="accordionExample">
        <?php
        echo Modules::run('post_area/post_area_frontview/index',$this->input->get('location_id'));
        if ($this->uri->segment(1) == 'spare-parts') :
            echo Modules::run('parts/parts_frontview/widgetPartsFor', $this->input->get('parts_for'));
            echo Modules::run('parts/parts_frontview/widgetCategories', $this->input->get('category_id'));
        endif;

        if ($this->uri->segment(1) == 'automech-search') :
            echo Modules::run('parts/parts_frontview/widgetPartsFor', $this->input->get('parts_for'));
        endif;
        echo Modules::run('brands/brands_frontview/vehicle_widget');

        if ($this->uri->segment(1) != 'spare-parts' && $this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') :
            echo Modules::run('body_types/body_types_frontview/widget');
        endif;

        if ($this->uri->segment(1) == 'spare-parts') :
            echo Modules::run('parts/parts_frontview/widget', $this->input->get('parts_description'));
            // echo Modules::run('parts/parts_frontview/widgetPartsFor', $this->input->get('parts_for'));
        endif;


        // Auto Mech serach  options
        if ($this->uri->segment(1) == 'automech-search') :

            // echo Modules::run('parts/parts_frontview/widgetPartsFor', $this->input->get('parts_for'));
            echo Modules::run('specialism/specialism_frontview/specialist', $this->input->get('specialist'));
            echo Modules::run('specialism/specialism_frontview/widgetRepair_type', $this->input->get('repair_type'));
            echo Modules::run('specialism/specialism_frontview/widgetService', $this->input->get('service'));
        endif;


        // Towing Search Options
        if ($this->uri->segment(1) == 'towing-search') :
            // echo Modules::run('parts/parts_frontview/widgetPartsFor', $this->input->get('parts_for'));
            echo Modules::run('vehicle_types/vehicle_types_frontview/services', $this->input->get('towing_service_id'));
            echo Modules::run('vehicle_types/vehicle_types_frontview/vehicle_types', $this->input->get('vehicle_type'));
            echo Modules::run('vehicle_types/vehicle_types_frontview/type_of_services', $this->input->get('type_of_service'));
            echo Modules::run('vehicle_types/vehicle_types_frontview/availability', $this->input->get('availability'));
        endif;


        ?>
        <?php if ($this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') : ?>
            <div class="search-product">
                <button type="button" id="manufactureHeading" data-toggle="collapse"
                        data-target="#manufactureCollaps" aria-expanded="false"
                        aria-controls="manufactureCollaps">
                                    <span class="image">
                                        <img class="unselect" src="assets/theme/new/images/icons/search/calendar.png"
                                             alt="image">
                                        <img class="select" src="assets/theme/newimages/icons/search/calendar-h.png"
                                             alt="image">
                                    </span>
                    Manufacture Year
                    <i class="fa fa-angle-right"></i>
                </button>
                <div id="manufactureCollaps" class="collapse" aria-labelledby="manufactureHeading"
                     data-parent="#accordionExample">
                    <div class="search-item">
                        <label for="#">Form</label>
                        <div class="select2-wrapper">
                        <select class="input-style" id="from_year" name="from_year">
                            <option value="0">--Any--</option>
                            <?php echo getYearRange($this->input->get('from_year')); ?>
                        </select>
                        </div>
                        <label for="#">To</label>
                        <div class="select2-wrapper">
                        <select class="input-style" id="to_year" name="to_year">
                            <option value="0">--Any--</option>
                            <?php echo getYearRange($this->input->get('to_year')); ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>
        <?php if ($this->uri->segment(1) != 'spare-parts' && $this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') : ?>
            <div class="search-product">
                <button type="button" id="ageHeading" data-toggle="collapse" data-target="#ageCollaps"
                        aria-expanded="false" aria-controls="ageCollaps">
                                    <span class="image">
                                        <img class="unselect" src="assets/theme/new/images/icons/search/age.png" alt="image">
                                        <img class="select" src="assets/theme/new/images/icons/search/age-h.png" alt="image">
                                    </span>
                    Age
                    <i class="fa fa-angle-right"></i>
                </button>
                <div id="ageCollaps" class="collapse" aria-labelledby="ageHeading"
                     data-parent="#accordionExample">
                    <div class="search-item">
                        <label for="#">Form</label>
                        <div class="select2-wrapper">
                        <select class="input-style" id="age_from" style="width: 100%;" name="age_from">
                            <option value="0">Select From</option>
                            <?php echo ageDropDown(1, 10, 1, $this->input->get('age_from')); ?>
                        </select>
                        </div>
                        <label for="#">To</label>
                        <div class="select2-wrapper">
                        <select class="input-style" id="age_to" name="age_to">
                            <option value="0">Select To</option>
                            <?php echo ageDropDown(1, 10, 1, $this->input->get('age_to')); ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') : ?>
            <div class="search-product">
                <button type="button" id="conditionHeading" data-toggle="collapse"
                        data-target="#conditionCollaps" aria-expanded="false"
                        aria-controls="conditionCollaps">
                                    <span class="image">
                                        <img class="unselect" src="assets/theme/new/images/icons/search/condition.png"
                                             alt="image">
                                        <img class="select" src="assets/theme/new/images/icons/search/condition-h.png"
                                             alt="image">
                                    </span>
                    Condition
                    <i class="fa fa-angle-right"></i>
                </button>
                <div id="conditionCollaps" class="collapse" aria-labelledby="conditionHeading"
                     data-parent="#accordionExample">
                    <div class="search-item">
                        <div class="select2-wrapper">
                        <select class="input-style" id="condition" name="condition">
                            <?php echo GlobalHelper::getConditions($this->input->get('condition')); ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($this->uri->segment(1) != 'spare-parts' && $this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') : ?>
            <?php echo Modules::run('fuel_types/fuel_types_frontview/widget'); ?>
        <?php endif; ?>



        <?php if ($this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') : ?>
            <div class="search-product">
                <button type="button" id="priceHeading" data-toggle="collapse"
                        data-target="#priceCollaps" aria-expanded="false" aria-controls="priceCollaps">
                                    <span class="image">
                                        <img class="unselect" src="assets/theme/new/images/icons/search/price.png"
                                             alt="image">
                                        <img class="select" src="assets/theme/new/images/icons/search/price-h.png"
                                             alt="image">
                                    </span>
                    Price
                    <i class="fa fa-angle-right"></i>
                </button>
                <div id="priceCollaps" class="collapse" aria-labelledby="priceHeading"
                     data-parent="#accordionExample">
                    <div class="search-item">
                        <label for="#">Form</label>
                        <div class="select2-wrapper">
                        <select class="input-style" id="price_from" name="price_from">
                            <option value="0">Any</option>
                            <?php echo getNewPriceDropDown($this->input->get('price_from')); ?>
                        </select>
                        </div>
                        <label for="#">To</label>
                        <div class="select2-wrapper">
                        <select class="input-style" id="price_to" name="price_to">
                            <option value="0">Any</option>
                            <?php echo getNewPriceDropDown($this->input->get('price_to')); ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if ($this->uri->segment(1) != 'spare-parts' && $this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') : ?>
            <div class="search-product">
                <button type="button" id="mileageHeading" data-toggle="collapse"
                        data-target="#mileageCollaps" aria-expanded="false" aria-controls="mileageCollaps">
                                    <span class="image">
                                        <img class="unselect" src="assets/theme/new/images/icons/search/mileage.png"
                                             alt="image">
                                        <img class="select" src="assets/theme/new/images/icons/search/mileage-h.png"
                                             alt="image">
                                    </span>
                    Mileage
                    <i class="fa fa-angle-right"></i>
                </button>
                <div id="mileageCollaps" class="collapse" aria-labelledby="mileageHeading"
                     data-parent="#accordionExample">
                    <div class="search-item">
                        <label for="#">Form</label>
                        <div class="select2-wrapper">
                        <select class="input-style" id="mileage_from" name="mileage_from">
                            <option value="0">Select From</option>
                            <?php echo numericDropDown(1000, 100000, 1000, $this->input->get('mileage_from')); ?>
                        </select>
                        </div>
                        <label for="#">To</label>
                        <div class="select2-wrapper">
                        <select class="input-style" id="mileage_to" name="mileage_to">
                            <option value="0">Select To</option>
                            <?php echo numericDropDown(1000, 100000, 1000, $this->input->get('mileage_to')); ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if ($this->uri->segment(1) != 'spare-parts' && $this->uri->segment(1) != 'motorbike' && $this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') : ?>
            <?php echo Modules::run('engine_sizes/engine_sizes_frontview/widget'); ?>
        <?php endif; ?>
        <?php if ($this->uri->segment(1) != 'spare-parts' && $this->uri->segment(1) != 'motorbike' && $this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') : ?>
            <div class="search-product">
                <button type="button" id="gearboxHeading" data-toggle="collapse"
                        data-target="#gearboxCollaps" aria-expanded="false" aria-controls="gearboxCollaps">
                                    <span class="image">
                                        <img class="unselect" src="assets/theme/new/images/icons/search/gearbox.png"
                                             alt="image">
                                        <img class="select" src="assets/theme/new/images/icons/search/gearbox-h.png"
                                             alt="image">
                                    </span>
                    Gearbox
                    <i class="fa fa-angle-right"></i>
                </button>
                <div id="gearboxCollaps" class="collapse" aria-labelledby="gearboxHeading"
                     data-parent="#accordionExample">
                    <div class="search-item">
                        <div class="select2-wrapper">
                        <select class="input-style" id="gear_box" name="gear_box">
                            <?php echo GlobalHelper::gearBox($this->input->get('gear_box', 'Any Gear Box')); ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-product">
                <button type="button" id="seatHeading" data-toggle="collapse" data-target="#seatCollaps"
                        aria-expanded="false" aria-controls="seatCollaps">
                                    <span class="image">
                                        <img class="unselect" src="assets/theme/new/images/icons/search/seat.png"
                                             alt="image">
                                        <img class="select" src="assets/theme/new/images/icons/search/seat-h.png"
                                             alt="image">
                                    </span>
                    Seats
                    <i class="fa fa-angle-right"></i>
                </button>
                <div id="seatCollaps" class="collapse" aria-labelledby="seatHeading"
                     data-parent="#accordionExample">
                    <div class="search-item">
                        <div class="select2-wrapper">
                        <select class="input-style" id="seats" name="seats">
                            <?php echo GlobalHelper::seat($this->input->get('seats'), '--Any--'); ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if ($this->uri->segment(1) != 'spare-parts' && $this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') : ?>
            <?php echo Modules::run('color/color_frontview/widget'); ?>
        <?php endif; ?>
        <?php if ($this->uri->segment(1) != 'spare-parts' && $this->uri->segment(1) != 'motorbike' && $this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') : ?>
            <div class="search-product">
                <button type="button" id="wheelbaseHeading" data-toggle="collapse"
                        data-target="#wheelbaseCollaps" aria-expanded="false"
                        aria-controls="wheelbaseCollaps">
                                    <span class="image">
                                        <img class="unselect" src="assets/theme/new/images/icons/search/wheel.png"
                                             alt="image">
                                        <img class="select" src="assets/theme/new/images/icons/search/wheel-h.png"
                                             alt="image">
                                    </span>
                    Wheelbase
                    <i class="fa fa-angle-right"></i>
                </button>
                <div id="wheelbaseCollaps" class="collapse" aria-labelledby="wheelbaseHeading"
                     data-parent="#accordionExample">
                    <div class="search-item">
                        <div class="select2-wrapper">
                        <select class="input-style" id="wheelbase" name="wheelbase">
                            <?php echo GlobalHelper::wheel_list(intval($this->input->get('wheelbase')), '--Any--'); ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <?php if ($this->uri->segment(1) != 'automech-search' && $this->uri->segment(1) != 'towing-search') : ?>
            <div class="search-product">
                <button type="button" id="privateHeading" data-toggle="collapse"
                        data-target="#privateCollaps" aria-expanded="false" aria-controls="privateCollaps">
                                    <span class="image">
                                        <img class="unselect" src="assets/theme/new/images/icons/search/private.png"
                                             alt="image">
                                        <img class="select" src="assets/theme/new/images/icons/search/private-h.png"
                                             alt="image">
                                    </span>
                    Private & Trade
                    <i class="fa fa-angle-right"></i>
                </button>
                <div id="privateCollaps" class="collapse" aria-labelledby="privateHeading"
                     data-parent="#accordionExample">
                    <div class="search-item">
                        <div class="select2-wrapper">
                        <select class="input-style" id="seller" name="seller">
                            <?php echo getTradeorPrivate($this->input->get('seller')); ?>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
            <div class="search-item">
                        <input type="text" class="normal-input-style" id="global_search" name="global_search"
                               value="<?php echo $this->input->get('global_search'); ?>" placeholder="Search Keyword">
            </div>
        <input type="hidden" name="page_slug" value="<?php echo $this->uri->segment(1); ?>"/>
    </div>
</aside>


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
