<?php
    $user = getUserDataById(getLoginUserData('user_id'));
?>

<!-- .account-area start  -->
<div class="row">
    <div class="col-12 col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-sm-10 offset-sm-1">
        <div class="bg-white p-30 shadow br-5 text-center">
            <h2 class="fs-18 fw-500 mb-20">Email Verification</h2>

            <img class="verify_email-icon" src="assets/theme/new/images/backend/email.png" alt="image">
            <p class="fs-14">It looks like your email address is not verified. Please verify
                you account to get all access.</p>
            <p class="fs-14"> Please click the verification link in the email
                "<?php echo $user->email; ?>" We just sent to either inbox or spam.</p>
            <p class="fs-14 mb-20">Email did not arrive?</p>
            <a class="btnStyle" href="javascript:void" id="re_send">Resend email!</a>
            <p id="ajax_response" class="text-success"></p>
        </div>
    </div>
</div>
<!-- .account-area end  -->

<script>
    $('#re_send').on('click', function () {
        $.ajax({
            url: '<?php echo base_url('re_send_email'); ?>',
            type: "GET",
            dataType: "json",
            success: function (response) {
                $('#ajax_response').html(response.Msg);
            }
        });
    });
</script>