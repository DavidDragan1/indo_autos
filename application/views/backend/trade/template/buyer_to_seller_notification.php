<?php
    $user = getUserDataById(getLoginUserData('user_id'));
?>

<!-- .account-area start  -->
<div class="row">
    <div class="col-12 col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-sm-10 offset-sm-1">
        <div class="bg-white p-30 shadow br-5 text-center">
            <h2 class="fs-18 fw-500 mb-20">Do you want to sell a product?</h2>
            <button class="btnStyle" id="re_send">Please register as a seller</button>
            <p id="ajax_response" class="text-success"></p>
        </div>
    </div>
</div>
<!-- .account-area end  -->

<script>
    $('#re_send').on('click', function () {
        $.ajax({
            url: '<?php echo base_url('mail/buyer_seller_request'); ?>',
            type: "GET",
            dataType: "json",
            success: function (response) {
                $('#ajax_response').html('Request Sent to Admin. Please wait');
                window.location.href = '<?=base_url("admin")?>';
            }
        });
    });
</script>