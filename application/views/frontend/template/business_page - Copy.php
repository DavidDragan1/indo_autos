<?php

//dd($seller);
//dd($user);
//dd($meta);

?>

<style type="text/css">
    span.inner { color: #999; }
    span.outer {  color: red;text-decoration: line-through;    }
</style>

<section>
    <div class="container">
        <div class="inner-page service_page">
            <div class="col-md-3">
                 
                <div class="logo"> 
					
                    <?php echo GlobalHelper::getUserProfilePhoto($user['profile_photo']); ?>
                </div>


                <div class="panel-heading">
                    <h4> <b>COMPANY INFORMATION</b></h4>
                </div>
                <ul class="list-group">
                    <li class="list-group-item list-with-no-border"> <i class="fa fa-phone" aria-hidden="true"></i> <?php echo @$company_number; ?> </li>
                    <li class="list-group-item list-with-no-border"> <i class="fa fa-envelope" aria-hidden="true"></i> <?php echo @$company_email; ?></li>
                    <li class="list-group-item list-with-no-border" style="min-height: 130px;"> <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <label>Company Address</label>
                        <br>
                        <div style="margin-left: 22px;"> <?php echo @$user_loaction; ?></div>
                    </li>
                </ul>
              
<!-- 
                <div class="panel panel-default borderall">
                    <div class="panel-heading">
                        <h4><b>Location Map</b></h4>
                    </div>
                    <div class="panel-body text-center">
                        <div class="locationimgeau">
                            <div style="height: 280px;" id="map-container"></div>
                            <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBOKy0BTRCMXke5lOw6YhaPmVy4L8d1xq0"></script> 
                            <script>
                                function init_map() {
                                    var var_location = new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $lat; ?>);

                                    var var_mapoptions = {
                                        center: var_location,
                                        zoom: 14
                                    };

                                    var var_marker = new google.maps.Marker({
                                        position: var_location,
                                        map: var_map,
                                        title: "6185-105 Boul Taschereau  Brossard, QC  Canada  J4Z 0E4"});

                                    var var_map = new google.maps.Map(document.getElementById("map-container"),
                                            var_mapoptions);
                                    var_marker.setMap(var_map);
                                }

                                google.maps.event.addDomListener(window, 'load', init_map);

                            </script> 

                        </div>
                    </div>
                </div> -->
            </div>
            <div class="col-md-9 listingleft">
                <div class="panel panel-primary borderall">
                    <div class="top_banner"> 
                        <?php if(!empty($user_data['cms_data']->thumb)):  ?>
                            <img src="uploads/company_logo/<?php echo $user_data['cms_data']->thumb;  ?>" class="img-responsive lazyload">
                         <?php else:  ?>
                            <img src="uploads/company_logo/no_cover.png" class="img-responsive lazyload">
                         <?php endif;  ?>                       
                    </div>
                    <div class="panel-body " style="    padding: 9px !important;">
                        <div class="col-md-12">
                            <ul class="social-ul">
                                <li class="social-li"><a href="<?php echo @$fb; ?>"><img class="social-icon" src="assets/theme/images/social/fb.png"></a></li>
                                <li class="social-li"><a href="<?php echo @$linkedin; ?>"><img class="social-icon" src="assets/theme/images/social/linked_in.png"></a></li>
                                <li class="social-li"><a href="<?php echo @$twitter; ?>"><img class="social-icon" src="assets/theme/images/social/twitter.png"></a></li>
                                <li class="social-li"><a href="<?php echo @$googlePlus; ?>"><img class="social-icon" src="assets/theme/images/social/google_plus.png"></a></li>
                                <li class="social-li"><a href="<?php echo @$youtube; ?>"><img class="social-icon" src="assets/theme/images/social/you_tube.png"></a></li>
                            </ul>
                        </div>
                    
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                              
                        <h4>WHO WE ARE</h4>                          
                        <div class="panel-body">
                            <p> We have the largest number of used cars in our showroom, 
                                it is also the biggest showroom in Dhaka City. We also sell 
                                re-condition vehicles. We are committed to our customer to 
                                deliver the best car. We are open everyday. Visit us soon, 
                                we are waiting to meet you. Drive your dream car from 
                                M.S.M CAR CENTER </p>
                        </div>

                    </div>
                 
                    <div class="col-md-12">                                                  
                        <h2>Seller Company Adverts</h2>                                                    
                        <?php echo Modules::run('posts/posts_frontview/getFromTradeSeller', 'flickmedialtd'); ?>                         
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

