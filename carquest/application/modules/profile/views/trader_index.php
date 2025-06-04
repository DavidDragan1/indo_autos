<?php load_module_asset('profile', 'js' );?>

<h2 class="breadcumbTitle">My Account</h2>
<!-- .account-area start  -->
<div class="account-area">
    <?php echo Profile_helper::makeNewTab('#'); ?>
    <div class="tab-content">
        <div id="ajax_respond" class="text-center text-success"></div>
        <div class="tab-pane fade show active">
            <form method="post" id="update_profile_info">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="file-upload-wrap">
                            <div class="upload-img upload_image">
                                <img id="upload" src="<?php echo empty($user_profile_image) ? 'assets/theme/new/images/backend/img.svg' : ($oauth_provider == 'web' ? base_url() . "uploads/users_profile/" .$user_profile_image : $user_profile_image) ?>" alt="your image">
                            </div>
                            <div class="upload-btn-wrapper">
                                <button>Upload Profile Picture</button>
                                <input type="file" id="profile_pic" name="profile_pic" onChange="instantShowUploadImage(this, '.upload_image')">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-12">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">First Name</label>
                                    <input type="text" class="inputbox-style" id="first_name" name="first_name" value="<?php echo $first_name; ?>" placeholder="type first name">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Last Name</label>
                                    <input type="text" class="inputbox-style" id="last_name" name="last_name" value="<?php echo $last_name; ?>" placeholder="type last name">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Country</label>
                                    <div class="select2-wrapper">
                                        <select name="country" class="input-style">
                                            <?php echo getDropDownCountries($country_id); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-style">
                                    <label class="input-label">Contact Number 1</label>
                                    <input type="text" class="inputbox-style" name="contact" value="<?php echo $contact; ?>" placeholder="type contact number">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="form-style">
                            <label class="input-label">Address Line 1</label>
                            <input type="text" class="inputbox-style" id="text" name="userAddress1" value="<?php echo $add_line1; ?>" placeholder="type address">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="input-label">Address Line 2</label>
                        <input type="text" class="inputbox-style" id="text" name="userAddress2" value="<?php echo $add_line2; ?>" placeholder="type address">
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="input-label">Contact Email</label>
                        <input type="email" id="email" class="inputbox-style <?=getLoginUserData('role_id') == 6 && empty($email) ? '' : 'readonly'?>" name="user_email" <?=getLoginUserData('role_id') == 6 && empty($email) ? '' : 'readonly="readonly"'?>  value="<?php echo $email; ?>" placeholder="type  email">
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="input-label">City</label>
                        <input type="text" class="inputbox-style" id="text" name="userCity" value="<?php echo $city; ?>"  placeholder="type city">
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="input-label">State/Region</label>
                        <input type="text" class="inputbox-style" id="text" name="state" value="<?php echo $state; ?>" placeholder="type state/region">
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="input-label">Post Code</label>
                        <input type="text" class="inputbox-style" id="text" name="userPostCode" value="<?php echo $postcode; ?>" placeholder="type post code">
                    </div>
                    <?php $role_id = getLoginUserData('role_id');
                          if ($role_id == 5) : ?>
                    <div class="col-lg-12 col-md-12 col-12">
                        <label class="input-label">About You</label>
                        <textarea id="editor" placeholder="About yourself"><?php echo @$content; ?></textarea>
                    </div>
                    <?php endif; ?>
                    <div class="col-12 text-right">
                        <button type="submit"  class="btn-wrap btn-big update-profile">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script>
    $("#update_profile_info").validate({
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            contact: {
                required: true,
            },
            email: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: 'First Name can not be empty',
            },
            last_name: {
                required: 'Last Name can not be empty',
            },
            contact: {
                required: 'Contact can not be empty',
            },
            email: {
                required: 'Email can not be empty',
            },

        },
        submitHandler: function (form) {
            var newFormData = new FormData($('#update_profile_info')[0]);
            var role = "<?php echo getLoginUserData('role_id'); ?>";

            if (role === "5") {
                newFormData.append('content', CKEDITOR.instances.editor.document.getBody().getText())
            }

            jQuery.ajax({
                url: 'admin/profile/update',
                type: "POST",
                data: newFormData,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    jQuery('#ajax_respond')
                        .html('<p class="ajax_processing">Loading...</p>')
                        .css('display','block');
                },
                success: function ( jsonRespond ) {
                    jQuery('#ajax_respond').html( jsonRespond.Msg );
                    if(jsonRespond.Status === 'OK'){
                        setTimeout(function () {
                            jQuery('#ajax_respond').slideUp( );
                        }, 2000);
                    }
                }
            });
        }
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

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

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor', {
        height: ['120px'],
    })
</script>