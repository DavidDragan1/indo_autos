<link rel="stylesheet" href="assets/theme/new/css/jquery-ui.min.css"/>
<div class="tostfyMessage bg-success" style="top: 5px; visibility: hidden; height: 70px;">
    <span class="tostfyClose">&times;</span>
    <div class="messageValue" id="session_msg">
        <?php echo $this->session->flashdata('message'); ?>
    </div>
</div>
<!-- carvaluation-area start  -->
<div class="carvaluation-area" >
    <div class="container">
        <form id="car_valuation" class="row">
            <div class="col-12">
                <h1 class="review-title">Get a free car valuation</h1>
                <h3>Find out how much your car is worth</h3>
<!--                <p>See what you could get if you sold your car yourself or part exchanged,or get a guide price if you’re looking to buy.-->
<!--                </p>-->
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="form-style">
                    <label>Car Type</label>
                    <div class="select2-wrapper select2-wrapper-black">
                        <select name="vehicle_type_id" class="input-style" id="vehicle_type_id">
                            <?php echo GlobalHelper::dropDownVehicleListForVariants($this->input->get('post_type')); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="form-style">
                    <label>Search Brand</label>
                    <div class="select2-wrapper select2-wrapper-black">
                        <select name="brand_name" class="input-style" onChange="get_model(this.value);" id="brandName">
                            <?php echo GlobalHelper::getAllBrands(1); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="form-style">
                    <label>Search Model</label>
                    <div class="select2-wrapper select2-wrapper-black">
                        <select name="model_id" class="input-style" id="model_id">
                            <option value="">--Select Brand--</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="form-style">
                    <label>Manufacturing Years</label>
                    <div class="select2-wrapper select2-wrapper-black">
                        <select name="manufacture_year" class="input-style" id="manufacture_year">
                            <option value="">Please Select Year</option>
                            <?php echo numericDropDown(2005, date('Y'), 1, 0, true); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="form-style">
                    <label>Car Variant</label>
                    <div class="select2-wrapper select2-wrapper-black">
                        <select name="vehicle_variant" class="input-style" id="vehicle_variant">
                            <option value="">Select Variant</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="form-style">
                    <label>Mileage (KM)</label>
                    <div id="mileageSlider" class="rangeSlider"></div>
                    <input class="range-slider-input" type="text" id="mileageRange" readonly>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="form-style">
                    <label>Body Condition</label>
                    <div class="select2-wrapper select2-wrapper-black">
                        <select class="input-style" id="body_condition">
                            <option value="">Select Body Condition</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center">
                <button type="submit"
                        class="default-btn get-valuation-btn" id="car_valuation_button">Get
                    a Valuation</button>
            </div>
        </form>

    </div>
</div>
<!-- carvaluation-area end  -->

<div class="modal fade modalWrapper" id="vehicleInfo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="valuationResult">
                <h3>Your Car Value is: <span class="car-value"></span></h3>
                <ul>
                    <li>Do you want to sell this car, begin by listing our
                        site<a href="admin/posts/create">Go to Listing Page</a></li>
                    <li>Do you want to buy this car, here are the list we have
                        available<a href="#" id="go-to-list">Go to list</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<script src="assets/theme/new/js/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>

<script src="assets/theme/new/js/jquery-ui.min.js"></script>
<script>
    $(function () {
        $("#mileageSlider").slider({
            range: true,
            min: 0,
            max: 120000,
            values: [0, 120000],
            slide: function (event, ui) {
                $("#mileageRange").val(ui.values[0] + " - " + ui.values[1]);
            }
        });
        $("#mileageRange").val(
            $("#mileageSlider").slider("values", 0) + " - " +
            $("#mileageSlider").slider("values", 1)
        );
    });
    $("#vehicle_type_id, #brandName, #model_id, #manufacture_year").change(function () {
        let vehicle_type_id = $("#vehicle_type_id").val();
        let brandName = $("#brandName").val();
        let model_id = $("#model_id").val();
        let manufacture_year = $("#manufacture_year").val();

        jQuery.ajax({
            url: 'get_vehicle_variant/',
            type: "POST",
            dataType: "text",
            data: {
                vehicle_type_id: vehicle_type_id,
                brandName: brandName,
                model_id: model_id,
                manufacture_year: manufacture_year
            },
            beforeSend: function () {
                jQuery('#vehicle_variant').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#vehicle_variant').html(response);
            }
        });
    });


    $("#vehicle_type_id, #brandName, #model_id, #manufacture_year, #vehicle_variant").change(function () {
        let vehicle_type_id = $("#vehicle_type_id").val();
        let brandName = $("#brandName").val();
        let model_id = $("#model_id").val();
        let manufacture_year = $("#manufacture_year").val();
        let vehicle_variant = $("#vehicle_variant").val();

        jQuery.ajax({
            url: 'get_body_condition/',
            type: "POST",
            dataType: "text",
            data: {
                vehicle_type_id: vehicle_type_id,
                brandName: brandName,
                model_id: model_id,
                manufacture_year: manufacture_year,
                vehicle_variant: vehicle_variant
            },
            beforeSend: function () {
                jQuery('#body_condition').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#body_condition').html(response);
            }
        });
    });

    function get_model(id) {
        jQuery.ajax({
            url: 'get_brands',
            type: "POST",
            dataType: "text",
            data: {id: id},
            beforeSend: function () {
                jQuery('#model_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#model_id').html(response);
            }
        });
    }

$(function(){
    $("#car_valuation").validate({
        rules: {
            vehicle_type_id:'required',
            brand_name:'required',
            model_id:'required',
            manufacture_year:'required',
            vehicle_variant:'required',
        },
        messages: {
            vehicle_type_id:'vehicle type id can not be empty',
            brand_name:'Brand Name can not be empty',
            model_id:'Modal can not be empty',
            manufacture_year:'manufacture year can not be empty',
            vehicle_variant:'vehicle variant can not be empty',
            
        },
        submitHandler: function(form) {
            let data = $('#car_valuation').serialize()

            let vehicle_type_id = $("#vehicle_type_id").val();
            let brandName = $("#brandName").val();
            let model_id = $("#model_id").val();
            let manufacture_year = $("#manufacture_year").val();
            let vehicle_variant = $("#vehicle_variant").val();
            let mileage_range = $("#mileageRange").val();
            let body_condition = $("#body_condition").val();
            jQuery.ajax({
            url: 'get_car_valuation_price',
            type: "POST",
            dataType: "text",
            data: data,
            success: function (response) {
                response = JSON.parse(response);
                $(".car-value").text(response.message);
                let queryString = "search?type_id=" + vehicle_type_id + "&brand_id=" + brandName + "&model_id=" + model_id + "&from_year=" + manufacture_year;
                $("#go-to-list").attr('href', queryString);
                $("#vehicleInfo").modal();
            }
        });
    }});	
});
</script>
