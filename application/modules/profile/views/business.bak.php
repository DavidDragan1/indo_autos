<section class="content-header">
    <h1>Trade Seller <small>Update page</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php Backend_URL ?>"><i class="fa fa-user"></i> Admin</a></li>
        <li><a href="<?php Backend_URL . '/profile/' ?>"><i class="fa fa-dashboard"></i> Profile</a></li>
        <li class="active">update</li>
    </ol>
</section>

<section class="content">
    <?php echo Profile_helper::makeTab('business'); ?>                                                                                                            
    <div class="box no-border">        
        <div class="box-body">
            <div id="response_upload"></div> 
            <form id="update_company_info" action="" method="POST"  enctype="multipart/form-data">
                <div class="row">

                    <div class="col-sm-8">
                        <div class="all_fields">

                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right no-padding">Company Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="companyName" value="<?php echo @$user['companyName']; ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right no-padding">Contact no</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="companyContact1" value="<?php echo $user['contact']; ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right no-padding">Company Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="companyEmail" value="<?php echo Profile_helper::userMetaValue('companyEmail', $meta ); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right no-padding">Address Line 1</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="text" name="companyAddress1" value="<?php echo $user['add_line1']; ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right no-padding">Address Line 2</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="text" name="companyAddress2" value="<?php echo $user['add_line2']; ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right no-padding">City</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="text" name="companyCity" value="<?php echo $user['city']; ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right no-padding">State/Region</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="text" name="companyStateRegion" value="<?php echo $user['state']; ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right no-padding">Post Code</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="text" name="companyPostCode" value="<?php echo $user['postcode']; ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right no-padding">Country</label>
                                <div class="col-sm-10">
                                    <select name="country" class="form-control" >
                                        <?php echo getDropDownCountries($user['country_id']); ?>
                                    </select>

                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-8 col-sm-offset-2 control-label text-right no-padding">Terms and Condition Link</label>

                            </div>


                        </div>



                        <div class="input-group"> <span class="input-group-addon" style="background-color: #eee;" id="basic-addon1"><i class="fa fa-map-marker" aria-hidden="true"></i> Location / City / Post Code</span>
                            <input type="text" name="userLocation" id="autocomplete" class="form-control" value="<?php echo Profile_helper::userMetaValue('userLocation'); ?>" placeholder="Enter a location" autocomplete="off">
                            <span class="input-group-btn"> </span> </div>
                            <input type="hidden" class="field" name="lat" id="latitude" value="<?php echo Profile_helper::userMetaValue('lat'); ?>">

                            <input type="hidden" class="field"  name="lng" id="longitude" value="<?php echo Profile_helper::userMetaValue('lng'); ?>">



                        <div class="form-group">
                            <h4 for="text"><i class="fa fa-info-circle"></i>Company Overview</h4>
                            <textarea class="form-control ckeditor" rows="10" name="companyOverview" id="ckeditor1" ><?php echo Profile_helper::userMetaValue('companyOverview'); ?></textarea>

                        </div>






                    </div>

                    <div class="col-sm-4">

                        <div class="panel-body">
                            <div class="thumbnail upload_image"> 
                                <img src="uploads/company_logo/<?php echo $user['profile_photo']; ?>" class="img-responsive lazyload" alt="Company Logo"> 
                            </div>
                            
                             

                            
                            <div class="btn btn-default btn-file">
                                <i class="fa fa-picture-o"></i> Upload Logo
                                <input type="file"  id="company_img" name="featured_image" onChange="instantShowUploadImage(this, '.upload_image')">
                            </div>
                            
                            
                        </div>




                        <div class="social_links">
                            <div class="jumbotron well">
                                Social Link
                            </div>
                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right"><i class="fa fa-2x fa-facebook-square" data-toggle="tooltip" data-placement="top" title="Facebook"></i></label>
                                <div class="col-sm-10">
                                    <input placeholder="https://www.facebook.com/xxxx" type="text" class="form-control" id="text" name="companyFacebook" value="<?php echo Profile_helper::userMetaValue('companyFacebook'); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right"><i class="fa fa-2x fa-twitter-square" data-toggle="tooltip" data-placement="top" title="Twitter"></i></label>
                                <div class="col-sm-10">
                                    <input placeholder="https://www.twitter.com/xxxx" type="text" class="form-control" id="text" name="companyTwitter" value="<?php echo Profile_helper::userMetaValue('companyTwitter'); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right"><i class="fa fa-2x fa-youtube-square" data-toggle="tooltip" data-placement="top" title="Youtube"></i></label>
                                <div class="col-sm-10">
                                    <input placeholder="https://www.youtube.com/xxxx" type="text" class="form-control" id="text" name="companyYoutube" value="<?php echo Profile_helper::userMetaValue('companyYoutube'); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right"><i class="fa  fa-snapchat " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Snapchat"></i></label>
                                <div class="col-sm-10">
                                    <input placeholder="https://www.snapchat.com/xxxx" type="text" class="form-control" id="text" name="companySnapchat" value="<?php echo Profile_helper::userMetaValue('companySnapchat'); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right"><i class="fa fa-2x fa-instagram" data-toggle="tooltip" data-placement="top" title="Instragram"></i></label>
                                <div class="col-sm-10">
                                    <input placeholder="https://www.instagram.com/xxxx" type="text" class="form-control" id="text" name="companyInstragram" value="<?php echo Profile_helper::userMetaValue('companyInstragram'); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="inputEmail3" class="col-sm-2 control-label text-right"><i class="fa fa-2x fa-globe" data-toggle="tooltip" data-placement="top" title="Website Link"></i></label>
                                <div class="col-sm-10">
                                    <input placeholder="https://www.xxxx.com/" type="text" class="form-control" id="text" name="companyWebsite" value="<?php echo Profile_helper::userMetaValue('companyWebsite'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit"  class="btn btn-warning">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



      
</section>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBOKy0BTRCMXke5lOw6YhaPmVy4L8d1xq0"></script> 
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script> 

<script>
    $('#update_company_info').on('submit', function () {
        updateBeforeSend();
        var formData = $('#update_company_info').serialize();
                
        $.ajax({
            url: "admin/profile/update_business", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            beforeSend: function () {
                $('#response_upload')
                        .css('display','block')        
                        .html('<p class="alert alert-warning"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></p>');
            },
            success: function ( jsonRespond ) {
                $('#response_upload').html( jsonRespond );                
                setTimeout(function() {	$('#response_upload').slideUp('slow'); }, 4000);               	
            }
        });
        
        return false;
        
    });


    /*------------ Instant Show Preview Image to a targeted place ------------*/
    function instantShowUploadImage(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(target + ' img').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
        $(target).show();
    }

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
        // Create the autocomplete object, restricting the search
        // to geographical location types.
        autocomplete = new google.maps.places.Autocomplete(
                /** @type {HTMLInputElement} */ (document.getElementById('autocomplete')), {
            types: ['geocode']
        });
        // When the user selects an address from the dropdown,
        // populate the address fields in the form.
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            fillInAddress();
        });
    }

// [START region_fillform]
    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        document.getElementById("latitude").value = place.geometry.location.lat();
        document.getElementById("longitude").value = place.geometry.location.lng();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
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

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    function updateBeforeSend(){
        for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
    }



</script>


