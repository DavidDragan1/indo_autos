
<div class="panel panel-default">

    <div class="panel-body user_profile_form">
        <div id="success_report"></div>

        <form id="add_product" method="post" class="form-horizontal"  action="<?php echo $action; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
            <input name="isRobot" type="hidden" value="0"/>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label">Title<sup>*</sup> :<?php echo form_error('title') ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo $title; ?>" />

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="shipping_port" class="col-sm-3 control-label">Shipping Port<sup>*</sup> :<?php echo form_error('shipping_port') ?></label>
                        <div class="col-sm-9">
                            <select name="shipping_port" class="form-control" id="shipping_port">
                                <?php echo getDropDownCountries($shipping_port); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="destination_port" class="col-sm-3 control-label">Destination Port<sup>*</sup> :<?php echo form_error('destination_port') ?></label>
                        <div class="col-sm-9">
                            <select name="destination_port" class="form-control" id="destination_port">
                                <?php echo GlobalHelper::PortDropdown($destination_port); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="vehicle_type_id" class="col-sm-3 control-label">Vehicle Type<sup>*</sup> :<?php echo form_error('vehicle_type_id') ?></label>
                        <div class="col-sm-9">
                            <select name="vehicle_type_id" class="form-control" id="vehicle_type_id" onChange="vehicle_change(this.value);">
                                <?php echo GlobalHelper::dropDownVehicleList($vehicle_type_id); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="condition" class="col-sm-3 control-label">Condition<sup>*</sup> :<?php echo form_error('condition') ?></label>
                        <div class="col-sm-9">
                            <select name="condition" class="form-control" id="condition">
                                <?php echo GlobalHelper::getImportCarConditions($condition); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="brand_id" class="col-sm-3 control-label">Brand<sup>*</sup> :<?php echo form_error('brand_id') ?></label>
                        <div class="col-sm-9">
                            <select name="brand_id" class="form-control" id="brand_id" onChange="get_model(this.value);">
                                <?php echo Modules::run('brands/all_brands_for_automech', $brand_id, $vehicle_type_id); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="model_id" class="col-sm-3 control-label">Model<sup>*</sup> :<?php echo form_error('model_id') ?></label>
                        <div class="col-sm-9">
                            <select name="model_id" class="form-control" id="model_id" >
                                <?php echo GlobalHelper::get_brands_by_vehicle_model($vehicle_type_id, $brand_id, $model_id); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="product_status" class="col-sm-3 control-label">Status<sup>*</sup> :<?php echo form_error('product_status') ?></label>
                        <div class="col-sm-9">
                            <select name="product_status" class="form-control" id="product_status">
                                <option value="Active" <?=$product_status == 'Active' ? 'selected' : ''?>>Active</option>
                                <option value="Inactive" <?=$product_status == 'Inactive' ? 'selected' : ''?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="year" class="col-sm-3 control-label">From Year<sup>*</sup> :<?php echo form_error('year') ?></label>
                        <div class="col-sm-9">
                            <select name="year" onchange="changeToYear(this.value)" class="form-control" id="year" >
                                <?php echo numericDropDown(1950, date('Y'), 1, $year); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="to_year" class="col-sm-3 control-label">To Year<sup>*</sup> :<?php echo form_error('to_year') ?></label>
                        <div class="col-sm-9">
                            <select name="to_year" class="form-control" id="to_year" >

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description :<?php echo form_error('description') ?></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="5" name="description"
                                      id="description" placeholder="Description"><?=$description?></textarea>
                        </div> 
                    </div>

                    <div class="form-group">
                        <label for="clearing_amount" class="col-sm-3 control-label">Clearing Amount :<?php echo form_error('clearing_amount') ?></label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="clearing_amount" id="clearing_amount" placeholder="Clearing Amount" value="<?php echo $clearing_amount; ?>" />

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ground_logistics_amount" class="col-sm-3 control-label">Ground Logistics Amount :<?php echo form_error('ground_logistics_amount') ?></label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="ground_logistics_amount" id="ground_logistics_amount" placeholder="Ground Logistics Amount" value="<?php echo $ground_logistics_amount; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="vat_amount" class="col-sm-3 control-label">Vat :<?php echo form_error('vat_amount') ?></label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="vat_amount" id="vat_amount" placeholder="Vat" value="<?php echo $vat_amount; ?>" />
                        </div>
                    </div>

                </div>
            </div>       
            <button type="submit" class="btn btn-primary pull-right">
                <i class="fa fa-save"></i>
                Update
            </button>             
        </form>
    </div>

</div>
</section>

<script type="text/javascript" src="assets/new-theme/js/select2.min.js"></script>
<script>
    function changeToYear(val,selected = 0){
        var toYear = $('#to_year');
        toYear.empty();
        var option = '';
        if (val){
            var start = new Date().getFullYear();
            for (start; start >= val; start--){
                if (parseInt(selected) > 0){
                    option += `<option ${selected == start ? 'selected':''} value="${start}">${start}</option>`;
                }else{
                    option += `<option value="${start}">${start}</option>`;
                }

            }
        }
        toYear.append(option);
    }

    $(window).on('load', function () {
        var selected = `<?php echo @$to_year;?>`;
        var manufacturingYear = $('#year').val();
        changeToYear(manufacturingYear,selected);
        $('.select2-style select').select2({
            width: '100%'
        });
        $('.number').keyup(function (e) {
            if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
            }
        });
    })

    function vehicle_change(vehicle_type_id) {
        vehicle_change_brand(vehicle_type_id);
    }

    function get_model(id) {
        var vehicle_type_id = $('#vehicle_type_id').val();

        jQuery.ajax({
            url: 'brands/brands_frontview/brands_by_vehicle_model?type_id=' + vehicle_type_id + '&brand_id=' + id,
            type: "GET",
            dataType: "text",
            data: {id: id, vehicle_type_id: vehicle_type_id},
            beforeSend: function () {
                jQuery('#model_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#model_id').html(response);
                // jQuery('#model_id-show').html(response);
            }
        });

    }

    function vehicle_change_brand(vehicle_type_id) {
        var vehicle_type_id = vehicle_type_id;

        jQuery.ajax({
            url: 'brands/brands_frontview/get_brands_by_vechile?type_id='+vehicle_type_id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                //$('#brand_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                $('#brand_id').html(response);
            }
        });
    }

</script>
