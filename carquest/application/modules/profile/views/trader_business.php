<?php load_module_asset('profile', 'js' );?>

<h2 class="breadcumbTitle">My Account</h2>
<!-- .account-area start  -->
<div class="account-area">
    <?php echo Profile_helper::makeNewTab('business'); ?>
    <div class="tab-content">
        <div id="response_upload" class="text-center text-success"></div>
        <div class="tab-pane fade show active">
            <form id="update_company_info" name="business_profile" method="POST">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Company Name</label>
                                    <input type="text" class="inputbox-style" name="companyName" value="<?php echo @$cms_data['post_title']; ?>" placeholder="Type Company Name" id="companyName">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-style">
                                    <input type="hidden" class="field" name="lat" id="latitude" value="<?php echo Profile_helper::userMetaValue('lat'); ?>">
                                    <input type="hidden" class="field"  name="lng" id="longitude" value="<?php echo Profile_helper::userMetaValue('lng'); ?>">
                                    <label class="input-label">Company Address</label>
                                    <input type="text" name="userLocation" class="inputbox-style" value="<?php echo Profile_helper::userMetaValue('userLocation'); ?>" placeholder="Office/showroom address" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Website URL</label>
                                    <input placeholder="https://www.xxxx.com/" type="text" class="inputbox-style" name="companyWebsite" value="<?php echo Profile_helper::userMetaValue('companyWebsite'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Seller Page URL</label>
                                    <input placeholder="https://www.xxxx.com/" type="text" class="inputbox-style" name="user_slug" value="<?php echo @$cms_data['post_url']; ?>" id="user_slug" >
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="input-label">Description</label>
                                <textarea name="companyOverview" id="editor" placeholder="About Company"><?php echo @$cms_data['content']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="file-upload-wrap">
                            <div class="upload-img upload_image">
                                <?php echo GlobalHelper::getNewUserProfilePhoto($user['profile_photo']); ?>
                            </div>
                            <div class="upload-btn-wrapper">
                                <button>Upload Logo</button>
                                <input type="file" id="company_img" name="company_logo" onChange="instantShowUploadImage(this, '.upload_image')">
                            </div>
                        </div>
                        <div class="file-upload-wrap">
                            <div class="upload-img cover_image">
                                <?php echo GlobalHelper::getNewSellrCoverPhoto($cms_data['thumb']); ?>
                            </div>
                            <div class="upload-btn-wrapper">
                                <button>Upload Cover</button>
                                <input type="file"  id="cover_img" name="cover_image" onChange="instantShowUploadImage(this, '.cover_image')">
                            </div>
                        </div>
                    </div>
                    <?php if($user['role_id'] == 4 || $user['role_id'] == 2 || $user['role_id'] == 1 || $user['role_id'] == 8 ): ?>
                        <div class="col-12">
                            <h3 class="business-title">Business Hour</h3>
                            <ul class="business-hour-items">
                                <?php echo newBusinessHours( $business_hours  ); ?>
                            </ul>
                        </div>
                    <?php endif;  ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3 class="business-title">Social Link</h3>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12" data-toggle="tooltip" data-placement="top" title="Facebook">
                        <input placeholder="https://fb.com/xxxx" id="Facebook" type="text" class="inputbox-style" name="Facebook" value="<?php echo Profile_helper::sellerSocialLinks($social_links, 'Facebook'); ?>">
                    </div>
                    <div class="col-lg-4 col-md-6 col-12" data-toggle="tooltip" data-placement="top" title="Twitter">
                        <input placeholder="https://www.twitter.com/XXXXX" type="text" id="Twitter" class="inputbox-style" name="Twitter" value="<?php echo Profile_helper::sellerSocialLinks($social_links,'Twitter'); ?>">
                    </div>
                    <div class="col-lg-4 col-md-6 col-12" data-toggle="tooltip" data-placement="top" title="Youtube">
                        <input placeholder="https://www.youtube.com/XXXXX" id="Youtube" type="text" class="inputbox-style" name="Youtube" value="<?php echo Profile_helper::sellerSocialLinks($social_links, 'Youtube'); ?>">
                    </div>
                    <div class="col-lg-4 col-md-6 col-12" data-toggle="tooltip" data-placement="top" title="Snapchat">
                        <input placeholder="https://www.snapchat.com/XXXXX" type="text" class="inputbox-style" name="Snapchat" id="Snapchat" value="<?php echo Profile_helper::sellerSocialLinks($social_links,'Snapchat'); ?>">
                    </div>
                    <div class="col-lg-4 col-md-6 col-12" data-toggle="tooltip" data-placement="top" title="Instragram">
                        <input placeholder="https://www.instagram.com/XXXXX" type="text" class="inputbox-style" name="Instragram" id="Instragram" value="<?php echo Profile_helper::sellerSocialLinks($social_links,'Instragram'); ?>">
                    </div>
                    <div class="col-12 text-right">
                        <button type="submit"  class="btn-wrap btn-big">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: ['120px'],
        customConfig: 'assets/theme/new/js/ckeditor/config.js',
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });


    // $("#update_company_info").validate({
    //     rules: {
    //         companyName: 'required',
    //         userLocation: 'required',
    //         companyWebsite: 'required',
    //         user_slug: 'required',
    //     },
    //     messages: {
    //         companyName: 'Company name can not be empty',
    //         userLocation: 'Company Location can not be empty',
    //         companyWebsite: 'Company Website can not be empty',
    //         user_slug: 'user slug can not be empty',
    //     },
    //     submitHandler: function (form) {
    //         var newFormData = new FormData($('#update_company_info')[0]);
    //         $.ajax({
    //             url: "admin/profile/business_update",
    //             type: "POST",
    //             data: newFormData,
    //             dataType: 'json',
    //             contentType: false,
    //             cache: false,
    //             processData: false,
    //             beforeSend: function () {
    //                 $('#response_upload')
    //                     .css('display','block')
    //                     .html('<p class="ajax_processing">Loading...</p>');
    //             },
    //             success: function ( jsonRespond ) {

    //                 if( jsonRespond.Status === 'OK'){
    //                     $('#response_upload').html( jsonRespond.Msg );
    //                 } else {
    //                     $('#response_upload').html( jsonRespond.Msg );
    //                 }
    //             }
    //         });

    //         return false;
    // }});

$(function(){
    $("#update_company_info").validate({
        rules: {
            companyName: 'required',
            userLocation: 'required',
            user_slug: 'required',
        },
        messages: {
            companyName: 'Company name can not be empty',
            userLocation: 'Company Location can not be empty',
            user_slug: 'user slug can not be empty',
        },
        submitHandler: function(form) {
            var newFormData = new FormData($('#update_company_info')[0]);
            newFormData.append('companyOverview', CKEDITOR.instances['editor'].getData())

            $.ajax({
                url: "admin/profile/business_update",
                type: "POST",
                data: newFormData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('#response_upload')
                        .css('display','block')
                        .html('<p class="ajax_processing">Loading...</p>');
                },
                success: function ( jsonRespond ) {

                    if( jsonRespond.Status === 'OK'){
                        $('#response_upload').html( jsonRespond.Msg );
                    } else {
                        $('#response_upload').html( jsonRespond.Msg );
                    }
                }
            });
    }});
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


    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    $("#companyName").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        $("#user_slug").val(Text);
    });

    $("#user_slug").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        $("#postSlug").val(Text);
    });
</script>
