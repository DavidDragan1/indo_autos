<!--Banner with Search Box-->
<style>
    @media(min-width: 992px){
        .padding-right-0 { padding-right: 0; }
        .padding-left-0 { padding-left: 0; }
    }
</style>
<div class="new-partsparts">
<div class="col-md-12 homeBanner nopadding">

    <div class="banner-text banner_up">

        <h1>Find your Genuine spare parts in the world</h1>

    </div>

    

    <div class="home-search-form-bg" onload="initialize()">

        <form class="banner-menu-option" action="spare-parts" method="get">

            <div class="row top_col">

                <div class="col-md-12">



                    <div class="col-md-4 half-padding">

                        <div class="form-group">                            

                            <select  class="form-control home-input" name="parts_for" id="home_type_id" onchange="getBrand(this.value);">

                                <?php //echo GlobalHelper::getVehicleTypes(0, 'Vehicle Type'); ?>

                                <?php echo parts_for(0, '--Select Vehicle Type--' ); ?>

                            </select>

                        </div>

                    </div>

                   

               



                    <div class="col-md-2 half-padding">

                        <div class="form-group">

                            <select class="form-control home-input" id="home_brand_id" name="brand_id" onChange="getModels(this.value);">

                                

                                <?php echo GlobalHelper::getBrand( 1 );?>

                            </select>

                        </div>

                    </div>



                    <div class="col-md-2 half-padding">

                        <div class="form-group">



                            <select class="form-control home-input" id="home_model_id" name="model_id">

                                <option value="0">Select Model</option>

                            </select>

                        </div>

                    </div>



                    <div class="col-md-2 half-padding">

                        

                        <!-- part category -->

                        <select name="category_id" class="form-control home-input" id="category_id">

                            <?php echo GlobalHelper::parts_categories(); ?>

                        </select>

                        

                        

                    </div>

                    <div class="col-md-2 half-padding">

                        <!-- part description -->

                        <select name="parts_description" class="form-control home-input" id="parts_description">

                            <option value="0">Part Name</option>

                            <?php // echo GlobalHelper::parts_description(); ?>

                        </select>

                    </div>





                    <div class="clearfix"></div>



                </div>



              

            </div> 

            <div class="row search_adv">

               

                    <div class="col-md-4">

                        <div class="row">
                            <div class="col-md-6 padding-left-0">
                                <div class="form-group">
                                    <select class="form-control home-input" id="from_year_h" name="from_year">
                                        <option value="0">--Any Year--</option>
                                        <?php echo getYearRange($this->input->get('from_year')); ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 padding-right-0">
                                <div class="form-group">
                                    <select class="form-control home-input" id="to_year_h" name="to_year">
                                        <option value="0">--Any Year--</option>
                                        <?php echo getYearRange($this->input->get('to_year')); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4">

                        <select name="location_id" class="form-control home-input">

                            <?php echo GlobalHelper::all_location(0, 'Select Location'); ?>

                        </select>                       

                    </div>

                <div class="col-md-4">

                    <div class="form-group">

                        <input type="text" class="form-control home-input" id="autocomplete" name="address" placeholder="City / Town" autocomplete="off">

                        <input type="hidden" name="lat" id="latitude" value="">

                        <input type="hidden" name="lng" id="longitude" value="">

                    </div>

                </div>

                <div class="clearfix bottom_margin"></div>

                

                    <div class="col-md-4">

                        <select name="condition" class="form-control home-input"><?php echo GlobalHelper::getConditions(); ?></select>                       

                    </div>

                

             

                        

                    <div class="col-md-4">

                        <select name="price_from" class="form-control home-input" >

                            <option value="0">Min Price</option>                                

                            <?php echo getPriceDropDown(500000, 20000000, 500000, 0, 100000) ?>

                        </select>

                    </div>

                    <div class="col-md-4">

                        <select name="price_to" class="form-control home-input" id="callMaximum">

                            <option value="0">Max Price</option>

                            <?php echo getPriceDropDown(500000, 20000000, 500000, 0, 100000) ?>                    

                        </select>

                        

                    </div>

                    

            </div>          





            <div class="row">

                <div class="col-md-4">                        

                   

                </div>

                <div class="col-md-4">                        

                    <button type="submit" class=" btn home-input btn-primary btn-search"><i class="fa fa-search"></i> Search</button>

                   

                </div>

                <div class="col-md-4 text-right">                        

                    <button class="btn btn-sm adv_search" type="button">Advanced Search</button>

                </div>

            </div>









        </form>



    </div>



    <script>

        jQuery('.adv_search').click(function () {

            jQuery('.search_adv').slideToggle(("slow", function(){

                jQuery('.banner-text').toggleClass( "banner_up banner_down" );

               // jQuery('.banner-text').slideDown( "slow" );

            }));

            //jQuery('.top_adv_btn').slideToggle();

        });

    </script>



</div>



<div class="clearfix"></div>

<!--End of Banner with Search Box-->



<!-- Under Search -->

<div class="wrapper banner-bottom">

    <div class="container">

        <div class="top-service-box row">

            <!-- <div class="col-md-3">

                 <div class="icon-image"><img class="img-responsive" src="assets/theme/images/search-img.png"></div>

                 <a class="title-text-car" href="search?type_id=1">Buy Used & New Car</a>

                 <div class="text-short">Buy smarter and make most out of your budget.</div>

                 <div class="red-more"><a href="search?type_id=1">Find Out More</a></div>

             </div>

             <div class="col-md-1 arro-center"><img class="" src="assets/theme/images/a-aro.png"></div>

             <div class="col-md-3">

                 <div class="icon-image"><img class="img-responsive" src="assets/theme/images/round-img.png"></div>

                 <a class="title-text-car" href="sign_up">Sell My Motorbike</a>

                 <div class="text-short">Get The Best Deal For<br>

                     Your Motorbike.</div>

                 <div class="red-more"><a href="sign_up">Find Out More</a></div>

             </div>

             <div class="col-md-1 arro-center"><img class="" src="assets/theme/images/a-aro.png"></div>

             <div class="col-md-3">

                 <div class="icon-image"><img class="img-responsive" src="assets/theme/images/email-img.png"></div>

                 <a class="title-text-car" href="sign_up">Get a Quote</a>

                 <div class="text-short">Get A Quote By following simple and Easy steps.</div>

                 <div class="red-more"><a href="sign_up">Find Out More</a></div>

             </div>-->




            <div class="col-md-4">

                <a href="<?php echo base_url('/'); ?>"><div class="hedingtop-img vehicle">

                        <img class="img-responsive topnoba" src="assets/theme/images/topbox1.png">

                        <img style="display:none;" class="img-responsive tophover" src="assets/theme/images/parts_topbox1hover.png">
                        
                        <h4>FIND NEW & USED<br> CARS</h4>
                        </div>

                </a>

            </div>

            <div class="col-md-4">

                <a href="spare-parts"><div class="hedingtop-img lasttopbox">

                        <img class="img-responsive topnoba" src="assets/theme/images/topbox3.png">

                        <img style="display:none;" class="img-responsive tophover" src="assets/theme/images/parts_topbox3hover.png">

                        <h4>Buy Trucks/Heavy Vehicles Spare parts</h4>
                        
                        </div>

                </a>

            </div>

            <div class="clearfix"></div>

        </div>

    </div>

</div>

<!---->

<div class="find-box">

    <div class="wrapper">        

        <div class="find-text">Every 60 seconds someone chooses to sell</div>

        <div class="find-more-baton"><a href="<?php echo base_url(); ?>admin/posts/create">Find out more</a></div>

        <div class="clearfix"></div>

    </div>

</div>

<!---->



<!--post advert area start-->

<script src="assets/lib/plugins/bxSlider/jquery.bxslider.min.js"></script>

<link href="assets/lib/plugins/bxSlider/jquery.bxslider.css" rel="stylesheet" />   

<link href="assets/theme/css/featured-home.css" rel="stylesheet" />   



<script type="text/javascript">

            jQuery.noConflict();

            jQuery(document).ready(function () {

                jQuery("#featuredListing").bxSlider({

                    slideWidth: 1140,

                    minSlides: 4,

                    maxSlides: 4,

                    moveSlides: 1,

                    auto: true

                });

            });

</script>

<div class="home-feature-advert">

    <div class="container">

        <div class="col-md-12">

            <center> <h1>Featured Parts Adverts</h1> </center>

        </div>



        <div class="col-md-12 no-padding">        

            <?php echo GlobalHelper::getFeaturedPost('parts'); ?>

        </div>    

    </div>

</div>









<!--end of post advert area-->

<div class="main-content-area">

    <div class="container advancesearch">



        <div class="row">

            <div class="col-md-4">

                <div class="box_inner">

                    <div class="title-product">Make</div>

                    <div class="row brands_logo">

                        <div class="col-md-4">

                            <div class="product-box"> 

                                <a href="spare-parts?brand_id=270"> 

                                    <img class="img-responsive" src="assets/theme/images/brands/toyota.jpg"> 

                                    <br> Toyota 

                                </a> 

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="product-box"> <a href="spare-parts?brand_id=225"> <img class="img-responsive" src="assets/theme/images/brands/mazda.jpg"><br>

                                    Mazda </a> </div>

                        </div>

                        <div class="col-md-4">

                            <div class="product-box"> <a href="spare-parts?brand_id=275"> <img class="img-responsive" src="assets/theme/images/brands/valkwa.jpg"><br>

                                    Volkswagen</a> </div>

                        </div>

                        <div class="col-md-4">

                            <div class="product-box"> <a href="spare-parts?brand_id=201"> <img class="img-responsive" src="assets/theme/images/brands/honda.jpg"><br>

                                    Honda</a> </div>

                        </div>

                        <div class="col-md-4">

                            <div class="product-box product-box-large">  <a href="spare-parts?brand_id=215"><img class="img-responsive" src="assets/theme/images/brands/jugear.jpg"><br>

                                    Landrover</a></div>

                        </div>

                        <div class="col-md-4">

                            <div class="product-box"> <a href="spare-parts?brand_id=145"> <img class="img-responsive" src="assets/theme/images/brands/BMW.jpg"><br>

                                    BMW</a> </div>

                        </div>



                        <div class="col-md-4">

                            <div class="product-box"> <a href="spare-parts?brand_id=241"> <img class="img-responsive" src="assets/theme/images/brands/peuge.jpg"><br>

                                    Peugeot</a> </div>

                        </div>

                        <div class="col-md-4">

                            <div class="product-box"> <a href="spare-parts?brand_id=171"> <img class="img-responsive" src="assets/theme/images/brands/audi.jpg"><br>

                                    Audi</a> </div>

                        </div>

                        <div class="col-md-4">

                            <div class="product-box"> <a href="spare-parts?brand_id=232"> <img class="img-responsive" src="assets/theme/images/brands/mitsubisi.jpg"><br>

                                    Mitsubishi</a> </div>

                        </div>





                    </div>

                </div>





            </div>
            <div class="col-md-4">
            <div class="box_inner partscategory">
  <div class="title-product">Parts Category</div>
  <div class="list-group">
  <a href="spare-parts?category_id=1" class="list-group-item list-group-item1">Engines</a>
  <a href="spare-parts?category_id=2" class="list-group-item list-group-item2">Transmissions</a>
  <a href="spare-parts?category_id=3" class="list-group-item list-group-item3">Body Parts & Accessories</a>
  <a href="spare-parts?category_id=4" class="list-group-item list-group-item4">Brake, Suspensions & Steering</a>
  <a href="spare-parts?category_id=5" class="list-group-item list-group-item5">Cooling Systems/AC</a>
  <a href="spare-parts?category_id=6" class="list-group-item list-group-item6">Tyres & Wheels</a>
  <a href="spare-parts?category_id=7" class="list-group-item list-group-item7">Others</a>
  <a href="spare-parts" class="list-group-item list-group-item8">All categories</a>
  </div>
</div>
            
            </div>
            <div class="col-md-4">

                <div class="box_inner">



                   <?php echo GlobalHelper::getArea('spare-parts', 4); ?>




                </div>





            </div>

            <?php /*?><div class="col-md-4">                   

                <div class="box_inner"> 

                    <div class="title-product">BODY TYPE</div>

                    <div class="row vehicle_types">

                        <div class="col-md-4 text-center"> 

                            <a href="search?body_type=8">

                                <img src="assets/theme/images/car1.png" />

                                <br/>Saloons 

                            </a> 

                        </div>



                        <div class="col-md-4 text-center"> 

                            <a href="search?body_type=4">

                                <img src="assets/theme/images/car2.png" />

                                <br/>Hatchbacks 

                            </a> 

                        </div>



                        <div class="col-md-4 text-center"> 

                            <a href="search?body_type=7">

                                <img src="assets/theme/images/car3.png" />

                                <br/>4 Wheel Drives &amp; SUVs 

                            </a> 

                        </div>



                        <div class="col-md-4 text-center"> 

                            <a href="search?body_type=10">

                                <img src="assets/theme/images/car4.png" />

                                <br/>Station Wagons 

                            </a> 

                        </div>



                        <div class="col-md-4 text-center"> 

                            <a href="<?php echo base_url(); ?>motorbike">

                                <img src="assets/theme/images/car6.png" />

                                <br/>Motorbikes 

                            </a>

                        </div>

                        <div class="col-md-4 text-center"> 

                            <a href="search?body_type=1">

                                <img src="assets/theme/images/car7.png" />

                                <br/>Convertibles 

                            </a> 

                        </div>

                        <div class="col-md-4 text-center"> 

                            <a href="search?body_type=2">

                                <img src="assets/theme/images/car1.png" />

                                <br/>Coupe 

                            </a> 

                        </div>

                        <div class="col-md-4 text-center"> 

                            <a href="search?body_type=9">

                                <img src="assets/theme/images/car1.png" />

                                <br/>Unlisted 

                            </a> 

                        </div>

                        <div class="col-md-4 text-center"> 

                            <a href="search?body_type=5">

                                <img src="assets/theme/images/car1.png" />

                                <br/>MPV 

                            </a> 

                        </div>

                        <div class="col-md-4 text-center"> 

                            <a href="search?body_type=3">

                                <img src="assets/theme/images/car1.png" />

                                <br/>Estate 

                            </a> 

                        </div>



                        <div class="col-md-4 text-center"> 

                            <a href="search?body_type=6">

                                <img src="assets/theme/images/car1.png" />

                                <br/>Other 

                            </a> 

                        </div>



                    </div>

                </div>

            </div><?php */?>

            

        </div>

    </div>

</div>    







<div class="user-ins-box">

    <div class="container">

        <div class="row">

            <div class="col-md-12 user-title">

                <h2>User Insights</h2>

            </div>

        </div>

        <div class="row">



            <!-- <div class="col-md-2 user-main-photo">

                <img src="assets/theme/images/testiomonial-defult-img.png" />

                <h5>Adewumi Ojo</h5>

            </div> -->

            <div class="col-md-12">

                <div class="user-botom-tex arrow_box">

                    <!--<p class="testiicon"><img src="assets/theme/images/tetestiomonial-comma.png" /></p>-->

                    <p class="testitext">CarQuest is the best place to find the right deal for foreign used cars in the world ! I’m really happy with the service . I’m definitely using CarQuest now to find the best deal for car in town. Bingo! 5 star for CarQuest</p>

                    <!--<p class="testiicon2"><img src="assets/theme/images/tetestiomonial-comma2.png" /></p>-->

                </div>



            </div>

            <div class="clearfix"></div>

        </div>



    </div>

</div>

<div class="car-service-area">

    <div class="container">

        <div class="col-md-4 service01">

            <div class="car-service-area-box">

                <img src="assets/theme/images/service002.png">



                <h3>Car finance</h3>

                <div class="find-out-box-a"><a href="car-finance">Find out more</a></div>

            </div>

        </div>

        <div class="col-md-4 service02">

            <div class="car-service-area-box">

                <img src="assets/theme/images/service001.png">

                <h3>Part exchange</h3>

                <div class="find-out-box-a"><a href="part-exchange">Find out more</a></div>

            </div>

        </div>

        <div class="col-md-4 service03">

            <div class="car-service-area-box">



                <img src="assets/theme/images/service003.png">

                <h3>Sell your car</h3>

                <div class="find-out-box-a"><a href="admin/posts/create">Find out more</a></div>

            </div>

        </div>

        <div class="clearfix"></div>

    </div>

</div>



<!--<div class="our-partner-box">

    <div class="container">

        <div class="col-md-12">

            <h2>Our Partner</h2>

            

            <img src="assets/theme/images/brands/partner-image.png"> 

        </div>

    </div>

</div>-->

<div id="home-testimonial">

    <h1>Latest News</h1>

    <div class="container">

        <div class="row">



            <?php echo getPostWidgetByCategoryID(2); ?>



            <div class="clearfix"></div>

            <div class="more-news"><a href="<?php echo site_url('/blog') ?>">view all news</a></div>

        </div>



    </div>

</div>


</div>




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

                    $("#popupSubscribe").modal('show');

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

    

    

</script>
