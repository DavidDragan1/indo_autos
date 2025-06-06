<!-- hero-area start -->
<div class="hero-area hero-parts-area" style="background: url(assets/theme/new/images/parts.jpg)no-repeat center center / cover">
    <div class="hero-content-wrap" onload="initialize()">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-content">
                        <h1 class="animation">FIND YOUR GENUINE <span>SPARE PARTS</span></h1>
                    </div>
                </div>
                <div class="col-12">
                    <div class="search-wrapper">
                        <form action="spare-parts" method="get">
                        <div class="row">
                            <div class="col-lg-3 col-12">
                                <div class="select2-wrapper">
                                <select class="input-style" name="parts_for" id="home_type_id" onchange="getBrand(this.value);">
                                    <?php echo parts_for(0, '--Select Vehicle Type--' ); ?>
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-9 col-12">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="select2-wrapper">
                                        <select class="input-style" name="parts_description" id="parts_description">
                                            <option value="0">Part Name</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="select2-wrapper">
                                        <select class="input-style " id="home_brand_id" name="brand_id" onChange="getModels(this.value);">
                                            <?php echo GlobalHelper::getBrand( 1 );?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="select2-wrapper">
                                        <select class="input-style" id="home_model_id" name="model_id">
                                            <option value="0">Select Model</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 col-12">
                                        <div class="select2-wrapper">
                                        <select class="input-style" name="category_id" id="category_id">
                                            <?php echo GlobalHelper::parts_categories(); ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <input type="text" class="input-style2" name="s_parts_id" id="s_parts_id" placeholder="Parts Id">
                            </div>
                            <div class="col-12">
                                <span class="advanceSearch">Advanced Search</span>
                            </div>
                            <div class="col-12 advance-searchWrap">
                                <div class="row">
                                    <div class="col-lg-5 col-12">
                                        <div class="row">
                                            <div class="col-sm-6 col-12">
                                                <div class="select2-wrapper">
                                                <select class="input-style" id="from_year_h" name="from_year">
                                                    <option value="0">--Any Year--</option>
                                                    <?php echo getYearRange($this->input->get('from_year')); ?>
                                                </select>
                                                </div>
                                            </div>
                                            <div class=" col-sm-6 col-12">
                                                <div class="select2-wrapper">
                                                <select class="input-style" id="to_year_h" name="to_year">
                                                    <option value="0">--Any Year--</option>
                                                    <?php echo getYearRange($this->input->get('to_year')); ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-12">
                                        <div class="row">
                                            <div class=" col-sm-6 col-12">
                                                <div class="select2-wrapper">
                                                <select class="input-style" name="location_id" onchange="getCity()" id="location_id">
                                                    <?php echo GlobalHelper::all_location(0, 'Select Location'); ?>
                                                </select>
                                                </div>
                                            </div>
                                            <div class=" col-sm-6 col-12">
                                                <div class="select2-wrapper">
                                                    <select class="input-style" name="address" id="location">
                                                        <?php echo GlobalHelper::all_city(); ?>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="lat" id="latitude" value="">
                                                <input type="hidden" name="lng" id="longitude" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4  col-sm-6 col-12">
                                        <div class="select2-wrapper">
                                        <select class="input-style" name="condition">
                                            <?php echo GlobalHelper::getConditions(); ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4  col-sm-6 col-12">
                                        <div class="select2-wrapper">
                                        <select class="input-style" name="price_from">
                                            <option value="0">Min Price</option>
                                            <?php echo getPriceDropDown(500000, 20000000, 500000, 0, 100000) ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4  col-sm-6 col-12">
                                        <div class="select2-wrapper">
                                        <select class="input-style" name="price_to" id="callMaximum">
                                            <option value="0">Max Price</option>
                                            <?php echo getPriceDropDown(500000, 20000000, 500000, 0, 100000) ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn-search">Search</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- hero-area end -->
<!-- product-area start -->
<div class="product-area product-parts-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title parts-section-title">OUR <span>PRODUCTS</span></h2>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="products-wrap">
                        <span class="product-icon">
                            <img class="normal" src="assets/theme/new/images/icons/products/parts/icon1.png" alt="Find Your Specialist Automech in the world">
                            <img class="hover" src="assets/theme/new/images/icons/products/parts/icon1-h.png" alt="Find Your Specialist Automech in the world">
                        </span>
                    <h3><a href="automech">Find Your Specialist <br>Automech in the world</a></h3>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="products-wrap">
                        <span class="product-icon">
                            <img class="normal" src="assets/theme/new/images/icons/products/parts/icon2.png" alt="FIND NEW & USED CARS">
                            <img class="hover" src="assets/theme/new/images/icons/products/parts/icon2-h.png" alt="FIND NEW & USED CARS">
                        </span>
                    <h3><a href="<?php echo base_url('/'); ?>">FIND NEW & USED<br> CARS</a></h3>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="products-wrap">
                        <span class="product-icon">
                            <img class="normal" src="assets/theme/new/images/icons/products/parts/icon3.png" alt="Buy Trucks/Heavy Vehicles Spare parts">
                            <img class="hover" src="assets/theme/new/images/icons/products/parts/icon3-h.png" alt="Buy Trucks/Heavy Vehicles Spare parts">
                        </span>
                    <h3><a href="spare-parts">Buy Trucks/Heavy Vehicles Spare parts</a></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product-area end -->
<!-- cta-area start  -->
<div class="cta-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 offset-lg-1 col-md-8 col-12">
                <p>Every 60 Seconds Someone Chooses To Sell</p>
            </div>
            <div class="col-lg-3 col-md-4 col-12">
                <a href="admin/posts/create" class="find-more-btn">Find out more</a>
            </div>
        </div>
    </div>
</div>
<!-- cta-area end  -->
<!-- featured-adverts-area start -->
<div class="featured-adverts-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title parts-section-title">FEATURED PARTS <span>ADVERTS</span></h2>
            </div>
        </div>
        <div class="featured-adverts-active row">
            <?php echo GlobalHelper::getFeaturedPost('parts'); ?>
            <div class="col-12">
                <a class="featured-adverts-wrap featured-adverts-all-products" href="#">
                    All Products
                </a>
            </div>
        </div>
    </div>
</div>
<!-- featured-adverts-area end -->

<!-- featured-area start  -->
<div class="featured-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="featured-wrapper">
                    <h2 class="featured-title">Make</h2>
                    <ul class="featured-list">
                        <li>
                            <a href="spare-parts?brand_id=270">
                                <img src="assets/theme/new/images/featured/toyota.jpg" alt="image">
                                <span>Toyota</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?brand_id=225">
                                <img src="assets/theme/new/images/featured/mazda.jpg" alt="image">
                                <span>Mazda</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?brand_id=275">
                                <img src="assets/theme/new/images/featured/valkwa.jpg" alt="image">
                                <span>Volkswagen</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?brand_id=201">
                                <img src="assets/theme/new/images/featured/honda.jpg" alt="image">
                                <span>Honda</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?brand_id=215">
                                <img src="assets/theme/new/images/featured/jugear.jpg" alt="image">
                                <span>Landrover</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?brand_id=145">
                                <img src="assets/theme/new/images/featured/BMW.jpg" alt="image">
                                <span>BMW</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?brand_id=241">
                                <img src="assets/theme/new/images/featured/peuge.jpg" alt="image">
                                <span>Peugeot</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?brand_id=171">
                                <img src="assets/theme/new/images/featured/audi.jpg" alt="image">
                                <span>Audi</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?brand_id=232">
                                <img src="assets/theme/new/images/featured/mitsubisi.jpg" alt="image">
                                <span>Mitsubishi
                                    </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="featured-wrapper featured-wrapper-body-type">
                    <h2 class="featured-title">PARTS CATEGORY</h2>
                    <ul class="featured-list">
                        <li>
                            <a href="spare-parts?category_id=1">
                                <img src="assets/theme/new/images/featured/parts/icon1.png" alt="image">
                                <span>Engines</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?category_id=2">
                                <img src="assets/theme/new/images/featured/parts/icon2.png" alt="image">
                                <span>Transmissions</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?category_id=3">
                                <img src="assets/theme/new/images/featured/parts/icon3.png" alt="image">
                                <span>Body Parts & Accessories</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?category_id=4">
                                <img src="assets/theme/new/images/featured/rewire.png" alt="image">
                                <span>Brake, Suspensions & Steering</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?category_id=5">
                                <img src="assets/theme/new/images/featured/parts/icon4.png" alt="image">
                                <span>Cooling Systems/AC</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?category_id=6">
                                <img src="assets/theme/new/images/featured/parts/icon5.png" alt="image">
                                <span>Tyres & Wheels</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts?category_id=7">
                                <img src="assets/theme/new/images/featured/parts/icon7.png" alt="image">
                                <span>Others</span>
                            </a>
                        </li>
                        <li>
                            <a href="spare-parts">
                                <img src="assets/theme/new/images/featured/parts/icon8.png" alt="image">
                                <span>All categories</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="featured-wrapper featured-wrapper-location">
                    <h2 class="featured-title">location</h2>
                    <ul class="location-list">
                        <?php echo GlobalHelper::getArea('spare-parts', 4); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- featured-area end  -->

<!-- client-review-area start -->
<div class="client-review-area">
    <div class="container">
        <h2>USER <span>INSIGHTS</span></h2>
        <div class="client-review-active owl-carousel">
            <p class="review">CarQuest is the best place to find the right deal for foreign used cars
                in the world !
                I’m really happy with the service. I’m definitely using CarQuest now to find the best
                deal for car in town. Bingo! 5 star for CarQuest</p>
            <p class="review">CarQuest is the best place to find the right deal for foreign used cars
                in the world !
                I’m really happy with the service. I’m definitely using CarQuest now to find the best
                deal for car in town. Bingo! 5 star for CarQuest</p>
            <p class="review">CarQuest is the best place to find the right deal for foreign used cars
                in the world !
                I’m really happy with the service. I’m definitely using CarQuest now to find the best
                deal for car in town. Bingo! 5 star for CarQuest</p>
        </div>
    </div>
</div>
<!-- client-review-area end -->

<!-- service-area start  -->
<div class="service-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">OUR <span>SERVICES</span></h2>
            </div>
            <div class="col-lg-4  col-md-6 col-12">
                <a class="service-wrapper" href="diagnostic">
                        <span class="service-icon">
                            <img class="normal" src="assets/theme/new/images/icons/service/icon1.png" alt="image">
                            <img class="hover" src="assets/theme/new/images/icons/service/icon1-hover.png" alt="image">
                        </span>
                    <h3>ONLINE <span>CAR DIAGNOSTIC</span></h3>
                    <p>Diagnose And Troubleshoot Your Car Problems Quickly And Easily</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <a class="service-wrapper service-wrapper-motoring" href="motor-association">
                        <span class="service-icon">
                            <img class="normal" src="assets/theme/new/images/icons/service/icon2.png" alt="image">
                            <img class="hover" src="assets/theme/new/images/icons/service/icon2-hover.png" alt="image">
                        </span>
                    <h3>MOTORING <span>ASSOCIATION</span></h3>
                    <p>Join Our Motor Association And Enjoy 24/7 Towing Service</p>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <a class="service-wrapper service-wrapper-hire" href="driver-hire">
                        <span class="service-icon">
                            <img class="normal" src="assets/theme/new/images/icons/service/icon3.png" alt="image">
                            <img class="hover" src="assets/theme/new/images/icons/service/icon3-hover.png" alt="image">
                        </span>
                    <p>Services(Read More)</p>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- service-area end  -->






<style type="text/css">

    .popupnewsletter h2 {

        color: #ffffff;

        font-family: Open Sans,sans-serif;

        font-size: 30px;

        font-weight: 600;

        line-height: 45px;

        margin-bottom: 44px;

        margin-top: 0;

        text-transform: uppercase;

    }

    .popupnewsletter {

        background-image: url("assets/theme/images/newletter-bg.jpg");

        margin: 0 auto;

        text-align: center;

        width: 700px;

        position:relative;

    }

    .popupnewsletter input[type="email"] {

        border: 0 none;

        border-bottom-left-radius: 5px;

        border-top-left-radius: 5px;

        color: #a3a3a3;

        font-family: arial;

        font-size: 14px;

        line-height: 16px;

        padding: 15px;

        width: 350px;

    }

    .popupnewsletter .btn_subscribe2 {

        background-color: #ef5c26;

        border: 0 none;

        border-bottom-right-radius: 5px;

        border-top-right-radius: 5px;

        color: #fff;

        cursor: pointer;

        font-family: Open Sans Condensed,sans-serif;

        font-size: 20px;

        font-weight: 600;

        margin-left: -4px;

        padding: 9px 15px 14px;

    }

    .pop-text-newsletter {

        padding: 57px 80px 100px;

    }





    .modal {

        text-align: center;

        padding: 0!important;

    }



    .modal:before {

        content: '';

        display: inline-block;

        height: 100%;

        vertical-align: middle;

        margin-right: -4px;

    }



    .modal-dialog {

        display: inline-block;

        text-align: left;

        vertical-align: middle;

    }

    .closepopupb.pull-right {

        position: absolute;

        right: 10px;

        top: 10px;

    }



    .closepopupb i {

        color: #ef5c26;

    }



@media only screen and (max-width: 767px) {

    .popupnewsletter {

        width: 100%;

    }

    .pop-text-newsletter {

        padding: 25px 11px 79px;

    }

    .popupnewsletter h2 {

        font-size: 20px;

        line-height: 26px;

        margin-bottom: 20px;

    }

    .popupnewsletter input[type="email"] {

        line-height: 16px;

        width: 60%;

        float: left;

    }

    .popupnewsletter .btn_subscribe2 {

        line-height: 27px;

        float: left;

    }

}



</style>





<div id="popupSubscribe" class="modal fade">

    <div class="modal-dialog">

        <div class="popupnewsletter">

         <a class="closepopupb pull-right" href="javascript:void(0)"><i class="fa fa-times-circle" aria-hidden="true"></i></a>

         <div class="clearfix"></div>

            <div class="pop-text-newsletter">

            <h2>Subscribe for<br>weekly updates,exclusive offers </h2>

                <div id="msg2" class="" style="display: none;"></div>

                <div class="text-danger" id="newsletter-msg2" style="display: none"></div>

                <form action="" name="newsletter_form" method="post">

                    <input id="newsletter_email" type="email" name="ne" placeholder="Email Address" type="text">

                    <span class="btn_subscribe2">Subscribe</span>

                </form>

            </div>

        </div>

    </div>

</div>





<script type="text/javascript">

    var $ = jQuery;

    $(function($) {

        $('.closepopupb').on('click', function() {

            $(this).parents('.modal').modal('hide');

        });

    });



    var popupSub = readCookie('popupSub');



    (function () {

        if (popupSub === null) {

            $(document).ready(function(){

                setTimeout(function(){

                    // $("#popupSubscribe").modal('show');

                    createCookie('popupSub', 'true', 1);

                }, 10000);

            });

        }

    })();



    function createCookie(name, value, days) {

        var expires = "";

        if (days) {

            var date = new Date();

            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));

            expires = "; expires=" + date.toUTCString();

        }

        document.cookie = name + "=" + value + expires + "; path=/";

    }



    function readCookie(name) {

        var nameEQ = name + "=";

        var ca = document.cookie.split(';');

        for (var i = 0; i < ca.length; i++) {

            var c = ca[i];

            while (c.charAt(0) == ' ') {

                c = c.substring(1, c.length);

            }



            if (c.indexOf(nameEQ) == 0) {

                return c.substring(nameEQ.length, c.length);

            }

        }

        return null;

    }



    jQuery(".btn_subscribe2").click(function(event) {



        event.preventDefault();

        var email       = jQuery("#newsletter_email").val();

        var error       = 0;



        if( validateEmail( email ) == false || !email){

            jQuery('#newsletter-msg2').html( 'Invalid Email' ).show();

            error = 1;

        }else{

            jQuery('#newsletter-msg2').hide();

        }



        if ( error == 0) {

            jQuery.ajax({

                type: "POST",

                url: "newsletter_subscriber/Newsletter_subscriber_frontview/create_action_ajax",

                dataType: 'json',

                data: {email: email},

                success: function(jsonData) {

                    jQuery('#msg2').html( '<p style="color:green">Subscribe Successfully! Check Your Email.</p>' ).slideDown('slow');

                    if(jsonData.Status === 'OK'){

                        jQuery('#msg2').delay(1000).slideUp('slow');

                        jQuery("#newsletter_email").val('');

                    } else {

                         jQuery('#msg2').delay(5000).slideUp('slow');

                    }



                }

            });

        }

    });



</script>













<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBOKy0BTRCMXke5lOw6YhaPmVy4L8d1xq0"></script>



<script type="text/javascript">

        var $ = jQuery;

        // google location  track

        $("#autocomplete").on('focus', function () {

            geolocate();

        });



        var placeSearch, autocomplete;

        var componentForm = {

            street_number: 'short_name',

            route: 'long_name',

            locality: 'long_name',

            administrative_area_level_1: 'short_name',

            country: 'long_name',

            postal_code: 'short_name'

        };



        function initialize() {

            autocomplete = new google.maps.places.Autocomplete(

                    (document.getElementById('autocomplete')), {

                    types: ['geocode'],

                    componentRestrictions: {country: 'NG'}

                // });



                /*(document.getElementById('autocomplete')), {

                    types: ['geocode'] */

            });

            google.maps.event.addListener(autocomplete, 'place_changed', function () {

                fillInAddress();

            });

        }



        //[START region_fillform]

        function fillInAddress() {

            // Get the place details from the autocomplete object.

            var place = autocomplete.getPlace();



            document.getElementById("latitude").value = place.geometry.location.lat();

            document.getElementById("longitude").value = place.geometry.location.lng();



            for (var component in componentForm) {

                document.getElementById(component).value = '';

                document.getElementById(component).disabled = false;

            }



            for (var i = 0; i < place.address_components.length; i++) {

                var addressType = place.address_components[i].types[0];

                if (componentForm[addressType]) {

                    var val = place.address_components[i][componentForm[addressType]];

                    document.getElementById(addressType).value = val;

                }

            }

        }



        function geolocate() {

            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function (position) {

                    var geolocation = new google.maps.LatLng(

                            position.coords.latitude, position.coords.longitude);



                    var latitude = position.coords.latitude;

                    var longitude = position.coords.longitude;

                    document.getElementById("latitude").value = latitude;

                    document.getElementById("longitude").value = longitude;



                    autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));

                });

            }



        }

        initialize();

</script>







<script>

    function getBrand(type_id) {

        $.ajax({

            url: 'brands/brands_frontview/get_brands_by_vechile/?type_id=' + type_id,

            type: "GET",

            dataType: "text",

            beforeSend: function () {

                $('#home_brand_id').html('<option value="0">Loading..</option>');

            },

            success: function (response) {

                $('#home_brand_id').html(response);

            }

        });

    }



    function getModels(brand_id) {

        var type_id = $('#home_type_id').val();

        $.ajax({

            url: 'brands/brands_frontview/brands_by_vehicle_model/?type_id=' + type_id + '&brand_id=' + brand_id,

            type: "GET",

            dataType: "text",

            beforeSend: function () {

                $('#home_model_id').html('<option value="0">Loading..</option>');

            },

            success: function (response) {

                $('#home_model_id').html(response);

            }

        });

    }





   jQuery("#home_type_id").change(function(){

       var parts_for = jQuery(this).val();

       jQuery('#parts_description').load('parts/parts_frontview/get_parts_description/' + parts_for);



    });

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
