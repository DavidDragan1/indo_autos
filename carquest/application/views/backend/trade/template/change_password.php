<div class="row">
    <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12">
        <form id="update_password" class="bg-white br-5 p-30 shadow">
            <h4 class="fs-24 fw-500 mb-30 text-center">Change Password</h4>
            <div class="input-field input-password mb-20">
                <input id="old_password" name="old_pass" type="password" required>
                <label for="old_password"><span>Old Password</span></label>
                <i class="material-icons show-password">visibility</i>
            </div>
            <div class="input-field input-password mb-20">
                <input id="new_password" name="new_pass" type="password" required>
                <label for="new_password"><span>New Password</span></label>
                <i class="material-icons show-password">visibility</i>
            </div>
            <div class="input-field input-password mb-20">
                <input id="confirm_password" name="con_pass" type="password" required>
                <label for="confirm_password"><span>Confirm Password</span></label>
                <i class="material-icons show-password">visibility</i>
            </div>
            <div class="text-center">
                <button type="submit" class="btnStyle waves-effect">Change Password</button>
            </div>
        </form>
    </div>
</div>



<script type="text/javascript" src="assets/new-theme/js/jquery.validate.min.js"></script>
<script>
    $("#update_password").validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules: {
            old_password: {
                required: true,
                minlength: 8
            },
            new_password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                minlength: 8,
                equalTo: "#mew_password"
            },
        },
        messages: {
            old_password: {
                required: "old password can not be empty",
                minlength: "Your password must be at least 8 characters long"
            },
            new_password: {
                required: "new password can not be empty",
                minlength: "Your password must be at least 8 characters long"
            },
            confirm_password: {
                required: "confirm password can not be empty",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "password dose not match"
            },
        },
        submitHandler : function () {
            var formData = jQuery('#update_password').serialize();
            jQuery.ajax({
                url: 'admin/profile/update_password',
                type: "post",
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    tosetrMessage('warning', 'Wait! We are saving your data')
                },
                success: function (jsonRespond) {
                    if(jsonRespond.Status === 'OK'){
                        tosetrMessage('success', 'Your Password Changed');
                        window.location.reload();
                    } else {
                        tosetrMessage('error', jsonRespond.Msg)
                    }
                }
            });
        }
    });
</script>