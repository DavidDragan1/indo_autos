<style>
    .hidden {
        display: none!important;
    }
    .required {
        border: 1px solid red;
    }
    .addcar-tab-menu li {
        margin-right: 70px;
    }
</style>
<?php defined('BASEPATH') OR exit('No direct script access allowed');

load_module_asset('posts', 'css');
?>

<h2 class="breadcumbTitle">Add Car</h2>
<!-- add-product-area start  -->
<!-- Nav tabs -->
<?php echo postUpdateTabsTrader('update_photo', $this->uri->segment(4)); ?>

<div class="tab-pane" id="productPhoto">
    <h2 class="add-product-title">Your Picture</h2>
    <form method="post" id="new_post" name="fileinfo" enctype="multipart/form-data">
        <input type="hidden" name="post_id" value="<?php echo $this->uri->segment(4); ?>">
        <input type="hidden" value="" name="encoded" id="encoded">
        <div class="row">
            <div class="col-xl-3 col-md-6 col-12">
                <p class="upload-label">Front</p>
                <label for="uploadimg_front" class="upload-img-wrap front" style="background: url(assets/theme/new/images/icons/upload/front.png) no-repeat center center">
                    <img id="front" src="<?php echo (isset($photo) && !empty($photo->photo)) ?  (base_url(). "uploads/car/" . $photo->photo) :  'image'; ?>" alt="image">
                    <input
                            onchange="document.getElementById('front').src = window.URL.createObjectURL(this.files[0])"
                            type="file" id="uploadimg_front">
                </label>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <p class="upload-label">Back</p>
                <label for="uploadimg_back" class="upload-img-wrap" style="background: url(assets/theme/new/images/icons/upload/back.png) no-repeat center center;">
                    <img id="back" src="<?php echo (isset($photo) && !empty($photo->back_photo)) ?  (base_url(). "uploads/car/" . $photo->back_photo) :  'image'; ?>" alt="image">
                    <input
                            onchange="document.getElementById('back').src = window.URL.createObjectURL(this.files[0])"
                            type="file" id="uploadimg_back">
                </label>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <p class="upload-label">Left Side</p>
                <label for="uploadimg_left" class="upload-img-wrap" style=" background: url(assets/theme/new/images/icons/upload/left.png) no-repeat center center;">
                    <img id="left" src="<?php echo (isset($photo) && !empty($photo->left_photo)) ?  (base_url(). "uploads/car/" . $photo->left_photo) :  'image'; ?>" alt="image">
                    <input
                            onchange="document.getElementById('left').src = window.URL.createObjectURL(this.files[0])"
                            type="file" id="uploadimg_left">
                </label>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <p class="upload-label">Right Side</p>
                <label for="uploadimg_right" class="upload-img-wrap" style=" background: url(assets/theme/new/images/icons/upload/right.png) no-repeat center center;">
                    <img id="right" src="<?php echo (isset($photo) && !empty($photo->right_photo)) ?  (base_url(). "uploads/car/" . $photo->right_photo) :  'image'; ?>" alt="image">
                    <input
                            onchange="document.getElementById('right').src = window.URL.createObjectURL(this.files[0])"
                            type="file" id="uploadimg_right">
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
        <div class="text-right">
            <button class="btn-wrap btn-big">Upload</button>
        </div>
    </form>
</div>

<!-- <script src="assets/theme/new/js/multi-image-upload.js"></script> -->
<script>

    var $ = jQuery;
    $("#profilePic").change(function () {

        var file        = this.files[0];
        var imagefile   = file.type;
        var match       = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile === match[0]) || (imagefile === match[1]) || (imagefile === match[2]))){
            $('#previewing1').attr('src', 'noimage.png');
            return false;
        } else {
            var reader      = new FileReader();
            reader.onload   = imageIsLoaded1;
            reader.readAsDataURL(this.files[0]);
        }
    });


    function imageIsLoaded1(e) {
        $("#profilePic").css("color", "green");
        $('#image_preview1').css("display", "block");
        $('#previewing1').attr('src', e.target.result);

        var width = $(window).width();

        if( width <= 767 ){
            $('#previewing1').attr('width', '100%');
        }else{
            $('#previewing1').attr('width', '60%');
        }
    }

    function rotateImage(degree) {
        $('#previewing1').animate({  transform: degree }, {
            step: function(now,fx) {
                $(this).css({
                    '-webkit-transform':'rotate('+now+'deg)',
                    '-moz-transform':'rotate('+now+'deg)',
                    'transform':'rotate('+now+'deg)'
                });
            }
        });
    }

    function startUpload() {
        //alert(imageData);
        var imageData = $('#previewing1').attr('src');
        //alert(imageData);
        $('#encoded').attr('value',imageData);

        var post_id = <?php echo $this->uri->segment(4); ?>;
        var fd = new FormData(document.getElementById("new_post"));



        jQuery.ajax({
            url: "<?php echo Backend_URL; ?>posts/upload_service_photo/"+post_id,
            type: "POST",
            dataType: "json",
            data: fd,
            enctype: 'multipart/form-data',
            beforeSend: function () {
                jQuery('#respondImg')
                    .css('display', 'block');
            },
            success: function (jsonData) {
                jQuery('#respondImg').css('display','none');
                jQuery('#ajax_respond').html(jsonData.Msg);

                if (jsonData.Status === 'OK') {
                    jQuery('#respondImg').css('display','none');
                    jQuery('#get_service_photos').html(jsonData);
                    jQuery('#get_service_photos').load('posts/get_service_photo_reload/'+post_id);

                }
            },

            processData: false, // tell jQuery not to process the data
            contentType: false   // tell jQuery not to set contentType
        });
        return false;
    }
    $(document).on('click','#dropzone',function(){
        if($('#output ul li').length >= 4){
            alert('You can uploaded more then 8 images')
        }
    })
    function deletePhoto( id, photo ){

        var yes     = confirm ('Are you sure?');
        //alert( id );

        if( yes ){
            jQuery.ajax({
                url: "<?php echo Backend_URL; ?>posts/delete_service_photo",
                type: "POST",
                dataType: 'json',
                data: {id: id, photo: photo},
                beforeSend: function () {
                    jQuery('#photo_' + id ).css( 'opacity', '0.5');
                },
                success: function (jsonRepond) {
                    if( jsonRepond.Status === 'OK' ){
                        jQuery('#photo_' + id ).fadeOut(1000);
                    } else {
                        alert('Something went wrong! Please check');
                    }
                }
            });
        }

    }

    function markActive( id ){
        var post_id  = <?php echo $this->uri->segment(4); ?>;

        jQuery.ajax({
            url: "<?php echo Backend_URL; ?>posts/mark_as_feature",
            type: "POST",
            dataType: 'json',
            data: {id: id, post_id: post_id},
            beforeSend: function () {
                jQuery(".markActive").html("<i class=\"fa fa-check-square-o\"></i> Feature This");
                jQuery('#photo_' + id +' span' ).text( 'Loading...');
            },
            success: function (data) {
                jQuery('#photo_' + id +' span' ).html( '&radic; Featured' );
            }
        });
    }



    function showBox(){
        $('.showBox').slideDown('slow');
    }

</script>
