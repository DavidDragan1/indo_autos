<div class="row">
    <div id="add_product_container" class="col-xl-10 offset-xl-1">
        <h2 class="fs-18 fw-500 color-seconday mb-25">Add a Product</h2>
        <form id="verifier_product_add" method="POST"  action="<?php echo $action; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div>
                <div class="bg-white p-30 shadow br-5 mb-20">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="input-field mb-15">
                                <input id="title" name="title" type="text" value="<?php echo $title; ?>" class="input-change">
                                <label for="title"><span>Title</span></label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="select2-style mb-15">
                                <select  id="country_id" onchange="countryChangeState(this.value)"
                                        class="browser-default input-change">
                                    <?php echo getDropDownCountries($country_id); ?>
                                </select>
                                <input name="country_id" type="hidden" value="<?php echo $country_id;?>" >
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-12">
                            <div class="select2-style mb-15">
                                <select name="location_id" id="location_id" class="browser-default input-change">
                                    <option disabled value=""  selected>Select State</option>
                                    <?php echo GlobalHelper::all_location($location_id, 'Select State', $country_id); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 col-lg-6">
                            <span class="fs-14 color-black fw-500 mb-10 d-block">Amount</span>
                            <div id="other">
                                <div class="input-field input-field-icon mb-15">
                                    <span class="field-icon color-theme">₦</span>
                                    <input id="total_amount" class="number input-change" value="<?=$total_amount?>"  name="total_amount" type="number" placeholder="Total Amount"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 ">
                            <div class="input-field">
                                <span class="fs-14 color-black fw-500 mb-10 d-block">Description</span>
                                <textarea placeholder="Enter Description" id="description" class="materialize-textarea" name="description"  required><?=$description?></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="ext-right mt-30 text-right">
                                <button class="btnStyle" type="submit"><?=$button?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="assets/new-theme/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/select2.min.js"></script>

<script>
    $(window).on('load',function (){
        $('.select2-style select').select2({
            width: '100%'
        });
        $('#country_id').select2({'disabled':true});
    });
    function countryChangeState(countryId){

        if (countryId !== ''){
            $.ajax({
                url: 'post_area/Post_area_frontview/get_state_by_country?countryId='+countryId,
                type: "GET",
                dataType: "text",
                success: function (response) {
                    $('#location_id').html(response);
                }
            });
        }
    }



</script>
<script>
    $('#verifier_product_add').validate({
        errorElement: 'span',
        errorClass: 'error-message',
        rules: {
            title: {
                required: true,
            },
            location_id:{
                required: true,
            },
            total_amount:{
                required: true,
            },
            description:{
                required: true,
            },
        },
        messages: {
            title: {
                required: 'Title can not be empty',
            },
            location_id:{
                required: 'State can not be empty',
            },
            total_amount:{
                required: 'Amount can not be empty',
            },
            description:{
                required: 'Description can not be empty',
            },
        },
        submitHandler:function (error) {
            document.getElementById('verifier_product_add').submit();
            // $('#verifier_product_add').submit();
        }
    });
</script>
