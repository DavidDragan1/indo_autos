<?php load_module_asset('profile', 'js' );?>

<h2 class="breadcumbTitle">My Account</h2>
<!-- .account-area start  -->
<div class="account-area">
    <?php echo Profile_helper::makeNewTab('password'); ?>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="changePassword">
            <div id="ajax_respond" class="text-center text-success"></div>
            <form name="updatePassword" id="update_password" role="form" method="POST">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="form-style">
                            <label class="input-label">Current Password</label>
                            <input type="password" required="" name="old_pass" id="old_pass" class="inputbox-style" placeholder="type password">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="form-style">
                            <label class="input-label">New Password</label>
                            <input type="text" required="" name="new_pass" id="new_pass" class="inputbox-style" placeholder="type new password">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="form-style">
                            <label class="input-label">Confirm New Password</label>
                            <input type="text" required="" name="con_pass" id="con_pass" class="inputbox-style" placeholder="type confirm new password">
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button class="btn-wrap btn-big" type="submit" >Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>

<script>
    function  password_change() {
        var formData = jQuery('#update_password').serialize();
        var error = 0;
        if( !error ) {
            jQuery.ajax({
                url: 'admin/profile/update_password',
                type: "post",
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    jQuery('#ajax_respond')
                        .html('<p class="ajax_processing">Please Wait...</p>')
                        .css('display', 'block');
                },
                success: function (jsonRespond) {
                    if(jsonRespond.Status === 'OK'){
                        jQuery('#ajax_respond').html(jsonRespond.Msg);
                        setTimeout(function() { jQuery('#ajax_respond').slideUp('slow') }, 2000);
                    } else {
                        jQuery('#ajax_respond').html(jsonRespond.Msg);
                    }
                }
            });
        }


        return false;
    };

    $("#update_password").validate({
        rules: {
            old_pass: 'required',
            new_pass: {
                required: true,
                minlength: 6
            },
            con_pass:{
                required: true,
                minlength: 6,
                equalTo: "#new_pass"
            }
        },
        messages: {
            old_pass: {
                required: 'Please enter your old password',
            },
            new_pass:{
                required:'Password can not be empty',
                minlength:'Password minimum length 6',
            },
            con_pass:{
                required:'Confirm password can not be empty',
                minlength:'Confirm Password minimum length 6',
            }

        },
        submitHandler: function (form) {
            password_change()
        }
    });
</script>