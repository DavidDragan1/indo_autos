<?php  load_module_asset('profile', 'css'); ?>
<?php //load_module_asset('profile', 'js'); ?>
<?php load_module_asset('users', 'css'); ?>
<?php load_module_asset('users', 'js'); ?>


<section class="content-header">
    <h1>Trade Seller <small>Update page</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-user"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL . 'users/' ?>"><i class="fa fa-dashboard"></i> User</a></li>
        <li class="active">Business</li>
    </ol>
</section>

<section class="content">
    <?php echo Users_helper::makeTab($this->uri->segment('4'), 'business'); ?>
    <div class="box no-border">
        <div class="box-body">
            <div id="response_upload"></div>
            <form id="update_company_info" name="business_profile" action="" method="POST">
                <div class="row">

                    <div class="col-md-8">

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> User/Seller ID </span>
                            <input type="text" class="form-control" name="user_id" readonly="readonly" value="<?php echo $user['id']; ?>">
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> Company Name </span>
                            <input type="text" class="form-control" id="companyName" name="companyName" value="<?php echo @$cms_data['post_title']; ?>">
                        </div>


                        <div class="input-group">
                            <input type="hidden" class="field" name="lat" id="latitude" value="<?php echo Profile_helper::userMetaValue('lat'); ?>">
                            <input type="hidden" class="field"  name="lng" id="longitude" value="<?php echo Profile_helper::userMetaValue('lng'); ?>">

                            <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp; Company Address</span>
                            <input type="text" name="userLocation" id="autocomplete" class="form-control" value="<?php echo Profile_helper::userMetaValue('userLocation'); ?>" placeholder="Office/showroom address" autocomplete="off">
                        </div>


                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-cog"></i> Seller Page URL </span>
                            <input type="text" class="form-control" name="user_slug" value="<?php echo @$cms_data['post_url']; ?>" id="user_slug" >
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-globe"></i> Website</span>
                            <input placeholder="https://www.xxxx.com/" type="text" class="form-control" name="companyWebsite" value="<?php echo Profile_helper::userMetaValue('companyWebsite'); ?>">

                        </div>

                        <?php /*
                          <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-cog"></i> T&AMP;C Page</span>
                          <input type="text" class="form-control" name="companyTandC" value="<?php echo Profile_helper::userMetaValue('companyTandC'); ?>">
                          </div>

                         */ ?>





                        <h3> About Company </h3>
                        <textarea class="form-control ckeditor" name="companyOverview" id="ckeditor1"><?php echo @$cms_data['content']; ?></textarea>


                        <div class="social_links">
                            <h4 class="title"><b>Business Hour</b></h4>
                            <?php echo businessHours( $business_hours ); ?>
                        </div>



                    </div>

                    <div class="col-md-4">


                        <div class="thumbnail upload_image">
                            <?php echo GlobalHelper::getUserProfilePhoto($user['profile_photo']); ?>
                        </div>

                        <div class="btn btn-default btn-file" style="margin: 0 auto; display: table;">
                            <i class="fa fa-picture-o"></i> Upload Logo
                            <input type="file"  id="company_img" name="company_logo" onChange="instantShowUploadImage(this, '.upload_image')">
                        </div>

                        <hr>

                        <div class="thumbnail cover_image">
                            <?php echo GlobalHelper::getSellrCoverPhoto($cms_data['thumb']); ?>
                        </div>




                        <div class="btn btn-default btn-file">
                            <i class="fa fa-picture-o"></i> Upload Cover
                            <input type="file"  id="cover_img" name="cover_image" onChange="instantShowUploadImage(this, '.cover_image')">
                        </div>







                        <div class="social_links">

                            <h4 class="title"><b>Social Link</b></h4>

                            <div class="form-group clearfix">
                                <label for="Facebook" class="col-md-2 control-label text-right"><i class="fa fa-2x fa-facebook-square" data-toggle="tooltip" data-placement="top" title="Facebook"></i></label>
                                <div class="col-md-10 no-padding">
                                    <input placeholder="https://facebook.com/xxxx" id="Facebook" type="text" class="form-control" name="Facebook" value="<?php echo Profile_helper::sellerSocialLinks($social_links, 'Facebook'); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="Twitter" class="col-md-2 control-label text-right"><i class="fa fa-2x fa-twitter-square" data-toggle="tooltip" data-placement="top" title="Twitter"></i></label>
                                <div class="col-md-10 no-padding">
                                    <input placeholder="https://www.twitter.com/xxxx" type="text" id="Twitter" class="form-control" name="Twitter" value="<?php echo Profile_helper::sellerSocialLinks($social_links, 'Twitter'); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="Youtube" class="col-md-2 control-label text-right"><i class="fa fa-2x fa-youtube-square" data-toggle="tooltip" data-placement="top" title="Youtube"></i></label>
                                <div class="col-md-10 no-padding">
                                    <input placeholder="https://www.youtube.com/xxxx" id="Youtube" type="text" class="form-control" name="Youtube" value="<?php echo Profile_helper::sellerSocialLinks($social_links, 'Youtube'); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="Snapchat" class="col-md-2 control-label text-right"><i class="fa  fa-snapchat " aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Snapchat"></i></label>
                                <div class="col-md-10 no-padding">
                                    <input placeholder="https://www.snapchat.com/xxxx" type="text" class="form-control" name="Snapchat" id="Snapchat" value="<?php echo Profile_helper::sellerSocialLinks($social_links, 'Snapchat'); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label for="Instragram" class="col-md-2 control-label text-right"><i class="fa fa-2x fa-instagram" data-toggle="tooltip" data-placement="top" title="Instragram"></i></label>
                                <div class="col-md-10 no-padding">
                                    <input placeholder="https://www.instagram.com/xxxx" type="text" class="form-control" name="Instragram" id="Instragram" value="<?php echo Profile_helper::sellerSocialLinks($social_links, 'Instragram'); ?>">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>




                <div class="row" style="margin-top: 15px; ">
                    <div class="col-md-12 text-right">
                        <button type="submit"  class="btn btn-primary"><i class="fa fa-cloud-upload"></i> Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




</section>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBOKy0BTRCMXke5lOw6YhaPmVy4L8d1xq0"></script>
<script src="assets/lib/plugins/ckeditor/ckeditor.js"></script>

<script>
    $('#update_company_info').on('submit', function () {
        updateBeforeSend();
        var formData = $('#update_company_info').serialize();

        $.ajax({
            url: "admin/users/user_business_update", // Url to which the request is send
            type: "POST",               // Type of request to be send, called as method
            data: new FormData(this),   // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            dataType: 'json',           // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,         // The content type used when sending data to the server.
            cache: false,               // To unable request pages to be cached
            processData: false,
            beforeSend: function () {
                $('#response_upload')
                        .css('display', 'block')
                        .html('<p class="ajax_processing">Loading...</p>');
            },
            success: function (jsonRespond) {
                $('#response_upload').html(jsonRespond.Msg);

                if (jsonRespond.Status === 'OK') {
                    setTimeout(function () {
                        $('#response_upload').slideUp('slow');
                    }, 2000);
                }
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
    function instantShowCoverImage(input, target) {
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

//        for (var component in componentForm) {
//            document.getElementById(component).value = '';
//            document.getElementById(component).disabled = false;
//        }

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
    function updateBeforeSend() {
        for (instance in CKEDITOR.instances)
            CKEDITOR.instances[instance].updateElement();
    }



    $('#user_slug').bind('keyup blur change', function (){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        $('#user_slug').val(Text);
    });

    $('#companyName').bind('keyup blur change', function (){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        $('#user_slug').val(Text);
    });
</script>
