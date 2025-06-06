<link rel="stylesheet" href="assets/theme/new/css/jquery-ui.min.css"/>
<style>
    .preview-list li.right h4 span {
        font-weight: 600;
        color: #f05c26;
    }

    .preview-list li h4 span{
        font-size: 25px;
        font-weight: 400;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        color: #1e1e1e
    }
</style>
<?php defined('BASEPATH') OR exit('No direct script access allowed');

load_module_asset('posts', 'css');
load_module_asset('posts', 'js');

$roleID = getLoginUserData('role_id');

?>

<?php
$user_id = getLoginUserData('user_id');
$role_id = getLoginUserData('role_id');

if ($user_id) {
    $user = $this->db->where('id', $user_id)->get('users')->row();
} else {
    $user = null;
}

?>
<?php if($this->session->flashdata('status')):
    if ($this->session->flashdata('status') == 'success') :?>
        <div class="tostfyMessage bg-success" style="top: 5px; visibility: visible; opacity: 1">
            <span class="tostfyClose">&times;</span>
            <div class="messageValue" id="session_msg">
                <?php echo $this->session->flashdata('message'); ?>
            </div>
        </div>
    <?php else : ?>
        <div class="tostfyMessage bg-danger" style="top: 5px; visibility: visible; opacity: 1">
            <span class="tostfyClose">&times;</span>
            <div class="messageValue" id="session_msg">
                <?php echo $this->session->flashdata('message'); ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<h2 class="breadcumbTitle">Add Auto Mechanic</h2>
<!-- add-product-area start  -->
<div class="product-list-edit-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form class="add-product-wrapper" id="list-add" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
                    <h3>General info </h3>
                    <fieldset class="step-wrapper form-wrapper"  id="general_info">
                        <h2><span>Upload</span> Vehicle For Sale</h2>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">State</label>
                                    <div class="select2-wrapper select2-wrapper-black">
                                        <select class="input-style required" name="location_id" id="location_id" onchange="getCity()">
                                            <?php echo GlobalHelper::all_location(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Location of the Product</label>
                                    <div class="select2-wrapper select2-wrapper-black">
                                        <select class="input-style required" name="location" id="location">
                                            <?php echo GlobalHelper::all_city(); ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="lat" id="latitude" value="">
                                    <input type="hidden" name="lng" id="longitude" value="">
                                </div>
                            </div>
                            <input type="hidden" name="post_type" value="Automech">
                            <input type="hidden" name="condition" value="Nigerian used">
                            <?php if (getLoginUserData('role_id') == 4): ?>
                                <input type="hidden" name="listing_type" value="Business">
                            <?php elseif (getLoginUserData('role_id') == 5): ?>
                                <input type="hidden" name="listing_type" value="Personal">
                            <?php endif; ?>
                            <input type="hidden" name="vehicle" value="<?php echo $this->input->get('post_type', TRUE); ?>">

                            <div class="col-lg-8 col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Listing Package</label>
                                    <div class="select2-wrapper select2-wrapper-black">
                                        <select class="input-style required" id="package_id" name="package_id">
                                            <?php echo getPostPackages(0); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <h3>Product info</h3>
                    <fieldset class="step-wrapper form-wrapper" id="product_info">
                        <h2><span>Update</span> Product Information</h2>
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <div class="form-style">
                                    <label class="input-label">Title</label>
                                    <input type="text" name="title" id="title" class="inputbox-style required" placeholder="eg new toyota camry 2016">
                                </div>
                                <div class="form-style">
                                    <label class="input-label">Page-Link</label>
                                    <input type="text" name="post_slug" class="inputbox-style required" id="postSlug" placeholder="Your link">
                                </div>
                                <div class="form-style">
                                </div>
                                <div class="form-style">
                                </div>
                                <div class="form-style">

                                </div>
                            </div>
                            <div class="col-lg-8 col-12">
                                <div class="form-style">
                                    <label class="input-label">Description</label>
                                    <textarea class="inputbox-style required" rows="5"  name="description" id="description" placeholder="Description 500/500"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Repair Type</label>
                                    <div class="select2-wrapper select2-wrapper-black">
                                        <select class="input-style required" onchange="towing_servic(this)" id="repair_type_id" name="repair_type_id">
                                            <?php echo GlobalHelper::getRepairType(0); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Automech For</label>
                                    <div class="select2-wrapper select2-wrapper-black">
                                        <select class="input-style required" id="parts_for" name="parts_for">
                                            <?php echo parts_for(0); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Specialism</label>
                                    <div class="select2-wrapper select2-wrapper-black">
                                        <select class="input-style required" id="specialism_id" name="specialism_id">
                                            <?php echo GlobalHelper::getSpecialism(0); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Service</label>
                                    <div class="select2-wrapper select2-wrapper-black">
                                        <select class="input-style required" id="service_type" name="service_type">
                                            <?php echo GlobalHelper::getServiceType(0); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Brand Name</label>
                                    <div class="select2-wrapper select2-wrapper-black">
                                        <select class="input-style required" id="brandName" name="brand_id">
                                            <option value="0">Select a brand</option>
                                            <?php echo GlobalHelper::all_brands_for_automech(0); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </fieldset>
                    <h3>Product photo</h3>
                    <fieldset class="step-wrapper form-wrapper" id="product_photo">
                        <h2><span>Your</span> Pictures</h2>
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-12 sell-front">
                                <p class="upload-label">Front</p>
                                <label for="uploadimg_front" class="upload-img-wrap front">
                                    <img src="image" alt="image">
                                    <input onchange="instantShowUploadImage(this, '.sell-front')"
                                           type="file" id="uploadimg_front" name="front_img">
                                </label>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 sell-back">
                                <p class="upload-label">Back</p>
                                <label for="uploadimg_back" class="upload-img-wrap back">
                                    <img id="back" src="image" alt="image">
                                    <input
                                            onchange="instantShowUploadImage(this, '.sell-back')"
                                            type="file" id="uploadimg_back" name="back_img">
                                </label>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 sell-left">
                                <p class="upload-label">Left Side</p>
                                <label for="uploadimg_left" class="upload-img-wrap left">
                                    <img id="left" src="image" alt="image">
                                    <input
                                            onchange="instantShowUploadImage(this, '.sell-left')"
                                            type="file" id="uploadimg_left" name="left_img">
                                </label>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12 sell-right">
                                <p class="upload-label">Right Side</p>
                                <label for="uploadimg_right" class="upload-img-wrap right">
                                    <img id="right" src="image" alt="image">
                                    <input
                                            onchange="instantShowUploadImage(this, '.sell-right')"
                                            type="file" id="uploadimg_right" name="right_img">
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="file-upload">
                                    <div class="dropezone" id="dropzone-wrapper">
                                        <div class="dropzon-content" id="textbox-wrapper">
                                            <div class="dropzone-info" id=textbox>
                                                <img src="assets/theme/new/images/icons/upload/camera.png" alt="image">
                                            </div>
                                        </div>
                                        <div class="dropzone-trigger" id="dropzone"></div>
                                    </div>
                                    <p class="addmore-product">Add more product</p>
                                    <div id="output">
                                        <ul></ul>
                                    </div>
                                </div>
                                <p class="imgSize">Image Size: To get best view, Image size should be 875
                                    pixel
                                    by 540 pixel</p>

                            </div>
                        </div>
                    </fieldset>
                    <h3>Preview</h3>
                    <fieldset class="step-wrapper form-wrapper">
                        <div id="preview">
                            <h2 id="pre-title"></h2>
                            <div class="row">
                                <div class="col-lg-8 col-12">
                                    <ul class="preview-list">
                                        <li class="left">
                                            <h4><img src="assets/theme/new/images/icons/map.png" alt="image"><span id="pre-location"></span></h4>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-8 col-12">
                                    <div class="preview-wrapper">
                                        <div class="product-slider-active">
                                            <div class="product-img sell-front">
                                                <a class="popup-img" href="">
                                                    <img src="" alt="image">
                                                </a>
                                            </div>
                                            <div class="product-img sell-back">
                                                <a class="popup-img" href="">
                                                    <img src="" alt="image">
                                                </a>
                                            </div>
                                            <div class="product-img sell-left">
                                                <a class="popup-img" href="">
                                                    <img src="" alt="image">
                                                </a>
                                            </div>
                                            <div class="product-img sell-right">
                                                <a class="popup-img" href="">
                                                    <img src="" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-slider-thumbnil">
                                            <div class="product-thumbnil sell-front">
                                                <img src="" alt="image">
                                            </div>
                                            <div class="product-thumbnil sell-back">
                                                <img src="" alt="image">
                                            </div>
                                            <div class="product-thumbnil sell-left">
                                                <img src="" alt="image">
                                            </div>
                                            <div class="product-thumbnil sell-right">
                                                <img src="" alt="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12">
                                    <ul class="preview-wrapper-sidebar">
                                        <li>
                                            <span>Name</span>
                                            <h4><?php echo getLoginUserData('name'); ?></h4>
                                        </li>
                                        <li>
                                            <span>Email</span>
                                            <?php if($user && $user->email) : ?>
                                                <h4><?php echo $user->email; ?></h4>
                                            <?php else : ?>
                                                <h4 id="pre-email"></h4>
                                            <?php endif; ?>
                                        </li>
                                        <li>
                                            <span>City</span>
                                            <?php if($user && $user->city) : ?>
                                                <h4><?php echo $user->city; ?></h4>
                                            <?php else : ?>
                                                <h4 id="pre-city"></h4>
                                            <?php endif; ?>
                                        </li>
                                        <li>
                                            <span>State/Region</span>
                                            <?php if($user && $user->state) : ?>
                                                <h4><?php echo $user->state; ?></h4>
                                            <?php else : ?>
                                                <h4 id="pre-state"></h4>
                                            <?php endif; ?>
                                        </li>
                                        <li>
                                            <span>Phone Number</span>
                                            <?php if($user && $user->contact) : ?>
                                                <h4><?php echo $user->contact; ?></h4>
                                            <?php else : ?>
                                                <h4 id="pre-contact"></h4>
                                            <?php endif; ?>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12">
                                    <h4 class="details-title">Details</h4>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="details-item">
                                                <div class="details-icon">
                                                    <img src="assets/theme/new/images/icons/preview/icon1.png" alt="image">
                                                </div>
                                                <div class="details-content">
                                                    <span>Brand</span>
                                                    <strong id="pre-brand-2">No Data</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="nav preview-tabs">
                                        <li><a class="active" href="javascript:void(0)" data-toggle="tab" data-target="#tab-description">Description
                                            </a></li>
                                        </li>
                                        <li><a href="javascript:void(0)" data-toggle="tab" data-target="#others_info">Other Info</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-description">
                                            <p class="discription" id="pre-description"></p>
                                        </div>
                                        <div class="tab-pane" id="others_info">
                                            <ul class="discription-info">
                                                <li><strong>Product Type</strong> <span id="pre-pro-type">No Data</span>
                                                </li>
                                                <li><strong>Fuel Type </strong> <span id="pre-fuel-2">No Data</span>
                                                </li>
                                                <li><strong>Color </strong> <span id="pre-color-2">No Data</span></li>
                                                <li><strong>Alloy wheels</strong> <span id="pre-alloy">No Data</span></li>
                                                <li><strong>Gear Box</strong> <span id="pre-gear">No Data</span></li>
                                                <li><strong>Owners</strong> <span id="pre-owners">No Data</span></li>
                                                <li><strong>Service history</strong> <span id="pre-ser">No Data</span></li>
                                                <li><strong>Condition</strong> <span id="pre-condition">No Data</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h3><span>Special</span> Features</h3>
                                </div>
                                <div class="col-12">
                                    <ul class="featured-list-item" id="pre-feature">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="assets/theme/new/js/jquery-ui.min.js"></script>
<!-- <script src="assets/theme/new/js/multi-image-upload.js"></script> -->
<script src="assets/theme/new/js/jquery.steps.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script>
    var form = $("#list-add").show();
    form.steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        labels: {
            current: false,
            pagination: "Pagination",
            finish: "Submit",
            next: "Save & Continue",
            previous: "Previous",
            loading: "Loading ..."
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            if (currentIndex < newIndex)
            {
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex){
            if(($('#list-add-p-1').attr('aria-hidden') === 'false') && (window.localStorage.getItem('modalClose') == null)){
                // $('#carValuationModal').modal()
            }
        },
    }).validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
    });
    $(document).on('click','#dropzone',function(){
        if($('#output ul li').length >= 4){
            alert('You can uploaded more then 8 images')
        }
    })
</script>
<script>
    $(document).ready(function () {
        $("#title").on('keyup keypress blur change', function () {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            var regExp = /\s+/g;
            Text = Text.replace(regExp, '-');
            $("#postSlug").val(Text);
            $(".pageSlug").text(Text);

            $("#pre-title").html($("#title").val());
        });

        $("#postSlug").on('keyup keypress blur change', function () {
            var Text = $(this).val();
            Text = Text.toLowerCase();
            var regExp = /\s+/g;
            Text = Text.replace(regExp, '-');
            $("#postSlug").val(Text);
            $(".pageSlug").text(Text);
        });

        $("#description").on('change blur', function () {
            $("#pre-description").html($("#description").val());
        });

    });

    function instantShowUploadImage(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(target + ' img').attr('src', e.target.result);
                $(target + ' a').attr('href', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
        $(target).show();
    }

    $('.actions ul li a[href="#finish"]').on('click', function () {
        $("#list-add").submit();
    });

    function tosetrMessage(type, message) {
        $('.tostfyMessage').css({ "top": "5px", "visibility": "visible", "opacity": 1 });
        $('.tostfyMessage').find('.messageValue').text(message);
        if (type == 'success') {
            $('.tostfyMessage').addClass('bg-success')
        } else if (type == 'warning') {
            $('.tostfyMessage').addClass('bg-warning')
        } else if (type == 'error') {
            $('.tostfyMessage').addClass('bg-danger')
        }
        setTimeout(function () {
            $('.tostfyMessage').css({ "top": "-100%", "visibility": "hidden", "opacity": 0 })
        }, 10000);
        $('.tostfyClose').on('click', function () {
            $('.tostfyMessage').css({ "top": "-100%", "visibility": "hidden", "opacity": 0 })
        })
    }

    function towing_servic(service) {
        var x = (service.value || service.options[service.selectedIndex].value);  //crossbrowser solution =)
        $.ajax({
            url: "posts/posts_frontview/towing_type_of_services?cat_id=" + x,
            type: "GET",
            dataType: "html",
            success: function (html) {
                $('#type_of_service').html(html);
            }
        });
    }

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

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBOKy0BTRCMXke5lOw6YhaPmVy4L8d1xq0"></script>

<script>

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
            (document.getElementById('autocomplete')), {
                types: ['geocode'],
                componentRestrictions: {country: 'NG'}
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


        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                // document.getElementById(addressType).value = val;
            }
        }

        $("#pre-location").html($("#autocomplete").val());
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


