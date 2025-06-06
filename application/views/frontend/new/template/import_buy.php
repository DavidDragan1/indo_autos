<?php
$name = ucfirst(str_replace('-', ' ', $this->uri->segment(2)));

$text = '';
$new_icon = '';
$nigeria_used_icon = '';
$foreign_used_icon = '';
if ($this->uri->segment(2) == 'car'){
    $text = 'Find New and Used Import Cars';
    $new_icon = 'directions_car';
    $nigeria_used_icon = 'local_taxi';
    $foreign_used_icon = 'local_taxi';
} elseif ($this->uri->segment(2) == 'motorbike'){
    $text = 'Find New and Used Import Motorbikes';
    $new_icon = 'two_wheeler';
    $nigeria_used_icon = 'electric_bike';
    $foreign_used_icon = 'electric_bike';
} elseif ($this->uri->segment(2) == 'spare-parts'){
    $text = 'Buy New and Used Import Spare Parts for Cars and Motorbike';
    $new_icon = 'miscellaneous_services';
    $nigeria_used_icon = 'settings';
    $foreign_used_icon = 'settings';
}
?>
<!-- find-car-area start  -->
<div class="find-car-area bg-grey ptb-50 mb-40 pr">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="find-car-wrap">
                    <form method="get" action="buy-import/<?=$this->uri->segment(2)?>/search">
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
                                <a class="waves-effect" href="#foreign_use" onclick="set_condition('Foreign used')">
                                    <span class="material-icons"><?=$foreign_used_icon?></span>
                                   Foreign Used
                                </a>
                            </li>
                        </ul>
                        <ul class="d-flex flex-wrap filter-wrap-search">
                            <div id="condition_section">
                                <!--                                <input name="condition" id="condition" value="" type="hidden">-->
                            </div>
                            <?php if (in_array($vehicle_type_id, [1, 3])) {?>
                            <li>
                                <select name="country" id="country" onchange="countryChangeState(this.value)">
                                    <?php echo getDropDownCountrySlug(-1); ?>
                                </select>
                            </li>
                            <li>
                                <select name="location" id="location">
                                    <?php echo GlobalHelper::all_location_select(); ?>
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
                                    <?php echo getPriceDropDown(1000000, 10000000, 100000);?>
                                </select>
                            </li>
                            <li>
                                <select name="price_to">
                                    <option value="" selected disabled>Max Price</option>
                                    <?php echo getPriceDropDown(1000000, 10000000, 100000);?>
                                </select>
                            </li>
                            <?php } else{ ?>
                                <li class="filter-wrap-advance">
                                    <input name="global_search" class=" default-input" placeholder="Search Parts" type="text">
                                </li>
                                <li class="filter-wrap-advance-show">
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
                                    <div class="input-field">
                                        <input id="parts_id" value="" name="parts_id" type="text">
                                        <label for="parts_id"><span>Parts Id</span></label>
                                    </div>
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
                                    <select name="country" id="country" onchange="countryChangeState(this.value)">
                                        <?php echo getDropDownCountrySlug(-1); ?>
                                    </select>
                                </li>
                                <li>
                                    <select name="location" id="location">
                                        <?php echo GlobalHelper::all_location_select(0, 'Select State'); ?>
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
<!-- find-car-area end  -->


<!-- .buy-area start  -->
<div class="buy-area pt-75 pb-45">
    <div class="container">
        <div class="row mb-20">
            <div class="col-12">
                <div class="title-link d-flex align-items-center justify-content-between pb-10 mb-30 bb-1">
                    <h5 class="mb-0 fs-16 fw-500">Best <?=$name?> Deals This Month</h5>
                    <a class="d-flex align-items-center fs-14 fw-500" href="buy-import/<?=$this->uri->segment(2)?>/search">See All <span
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
                        <h4><a href="post/<?=$post->post_slug?>"><?=getShortContent(($post->title), 20)?></a></h4>
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
                    <a class="d-flex align-items-center fs-14 fw-500" href="buy-import/<?=$this->uri->segment(2)?>/search">See All <span
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
                            <h4><a href="post/<?=$post->post_slug?>"><?=getShortContent(($post->title), 20)?></a></h4>
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
	$('.filter-wrap-search li select').select2({ 
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
        } else {
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
    function countryChangeState(countrySlug){

        if (countrySlug !== ''){
            $.ajax({
                url: 'post_area/Post_area_frontview/get_state_by_country_slug?countrySlug='+countrySlug,
                type: "GET",
                dataType: "text",
                success: function (response) {

                    $('#location').html(response);
                }
            });
        }
    }


</script>
