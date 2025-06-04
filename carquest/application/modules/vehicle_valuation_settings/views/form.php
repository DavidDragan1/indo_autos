<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1> Vehicle Valuations
        <small><?php echo $button ?></small>
        <a href="<?php echo site_url('admin/vehicle_valuation_settings') ?>" class="btn btn-default">Back</a></h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/vehicle_valuation_settings">Vehicle Valuations</a></li>
        <li class="active">Update</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Update Record</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-12" style="padding: 0px 50px">
                    <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
                        <div class="form-group">
                            <label for="varchar">Vehicle Category</label>
                            <select class="form-control" name="vehicle_type_id" id="vehicle_type_id">
                                <?php echo GlobalHelper::getDropDownVehicleTypeForVariants($vehicle_type_id); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="varchar">Vehicle Condition</label>
                            <select class="form-control" id="condition" name="vehicle_condition">
                                <?php echo GlobalHelper::getConditions($vehicle_condition, 'Select'); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="varchar">Brand Name</label>
                            <select class="form-control" id="brandName" required="" onChange="get_model(this.value, <?php echo $vehicle_type_id?>);" name="brand_id">
                                <option value="0">Select a brand</option>
                                <?php echo Modules::run('brands/all_brands_for_automech', $brand_id, $vehicle_type_id); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="varchar">Model Name</label>
                            <select class="form-control" id="model_id" name="model_id" required="">
                                <?php echo getBrand($model_id, $brand_id); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="varchar">Year of Manufacture</label>
                            <select required="" name="manufacturing_year" class="form-control" id="manufacture_year">
                                <option value="">Please Select</option>
                                <?php echo numericDropDown(1950, date('Y'), 1, $manufacturing_year, true); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="varchar">Variant</label>
                            <select required="" name="vehicle_variant" class="form-control" id="vehicle_variant">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="varchar">Minimum Price</label>
                            <input type="text" class="form-control" name="minimum_price" id="minimum_price" placeholder="Minimum Price" value="<?php echo $minimum_price; ?>" />
                        </div>

                        <div class="form-group">
                            <label for="varchar">Maximum Price</label>
                            <input type="text" class="form-control" name="maximum_price" id="maximum_price" placeholder="Maximum Price" value="<?php echo $maximum_price; ?>" />
                        </div>
                        <div class="col-md-12 text-right"><input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                            <a href="<?php echo site_url('admin/vehicle_valuation_settings') ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Millage Settings</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-12" style="padding: 0px 50px">
                    <div class="row">
                        <div style="float: right">
                            <a class="form-control btn btn-sm btn-success addButton"><i class="fa fa-plus"></i> Add More</a>
                        </div>
                    </div>
                    <form class="form-horizontal" action="<?php echo site_url(Backend_URL . 'vehicle_valuation_settings/millage_settings_action'); ?>" method="post">
                        <input type="hidden" value="<?php echo count($mileages) > 0 ? count($mileages) : 1; ?>" id="classNum" name="total_rows">
                        <?php if(count($mileages) > 0) {
                            $count = 1;
                            foreach ($mileages as $mileage) {
                        ?>
                            <input type="hidden" value="<?php echo $mileage->id; ?>" name="mileage_<?php echo $count;?>">
                            <div class="row dynamicClass">
                                <div class="col-md-3">
                                    <div class="form-group" style="margin: 0px">
                                        <label for="varchar">From</label>
                                        <input type="text" class="form-control" required name="from_<?php echo $count;?>" placeholder="From" value="<?php echo $mileage->from; ?>" />
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin: 0px">
                                        <label for="varchar">To</label>
                                        <input type="text" class="form-control" required name="to_<?php echo $count;?>" placeholder="To" value="<?php echo $mileage->to; ?>" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group" style="margin: 0px">
                                        <label for="varchar">Percentage</label>
                                        <input type="text" class="form-control" required name="percentage_<?php echo $count;?>" placeholder="Percentage" value="<?php echo $mileage->percentage; ?>" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin: 0px">
                                        <label for="varchar">Actions</label>
                                        <div style="display: flex">
                                            <a style="width: 60px; margin-right: 5px" data-mileage_id="<?php echo $mileage->id; ?>" class="form-control btn btn-sm btn-danger removeButton"><i class="fa fa-minus"></i></a>
<!--                                            <a style="width: 60px"  class="form-control btn btn-sm btn-success addButton"><i class="fa fa-plus"></i></a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php $count++;
                            } } else { ?>
                            <div class="row dynamicClass">
                                <div class="col-md-3">
                                    <div class="form-group" style="margin: 0px">
                                        <label for="varchar">From</label>
                                        <input type="text" class="form-control" required name="from_1" placeholder="From" value="" />
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin: 0px">
                                        <label for="varchar">To</label>
                                        <input type="text" class="form-control" required name="to_1" placeholder="To" value="" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group" style="margin: 0px">
                                        <label for="varchar">Percentage</label>
                                        <input type="text" class="form-control" required name="percentage_1" placeholder="Percentage" value="" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin: 0px">
                                        <label for="varchar">Actions</label>
                                        <div style="display: flex">
                                            <!--                                        <a style="width: 60px; margin-right: 5px" class="form-control btn btn-sm btn-danger removeButton"><i class="fa fa-minus"></i></a>-->
<!--                                            <a style="width: 60px"  class="form-control btn btn-sm btn-success addButton"><i class="fa fa-plus"></i></a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <div style="margin-top: 15px" class="col-md-12 text-right btn-row">
                            <input type="hidden" name="valuation_id" value="<?php echo $id; ?>"/>
                            <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                            <a href="<?php echo site_url('admin/vehicle_valuation_settings') ?>" class="btn btn-default">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Grade Settings</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-12" style="padding: 0px 50px">
                    <div class="row">
                        <div style="float: right">
                            <a class="form-control btn btn-sm btn-success addGradeButton"><i class="fa fa-plus"></i> Add More</a>
                        </div>
                    </div>
                    <form class="form-horizontal" action="<?php echo site_url(Backend_URL . 'vehicle_valuation_settings/grade_settings_action'); ?>" method="post">
                        <input type="hidden" value="<?php echo count($grades) > 0 ? count($grades) : 1; ?>" id="gradeClassNum" name="total_grade_rows">
                        <?php if(count($grades) > 0) {
                            $count = 1;
                            foreach ($grades as $grade) {
                                ?>
                                <input type="hidden" value="<?php echo $grade->id; ?>" name="grade_<?php echo $count;?>">
                                <div class="row dynamicClass">
                                    <div class="col-md-5">
                                        <div class="form-group" style="margin: 0px">
                                            <label for="varchar">Grade Name</label>
                                            <input type="text" class="form-control" required name="name_<?php echo $count;?>" placeholder="Name" value="<?php echo $grade->name; ?>" />
                                        </div>

                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group" style="margin: 0px">
                                            <label for="varchar">Percentage</label>
                                            <input type="text" class="form-control" required name="percentage_<?php echo $count;?>" placeholder="Percentage" value="<?php echo $grade->percentage; ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" style="margin: 0px">
                                            <label for="varchar">Actions</label>
                                            <div style="display: flex">
                                                <a style="width: 60px; margin-right: 5px" data-grade_id="<?php echo $grade->id; ?>" class="form-control btn btn-sm btn-danger removeGradeButton"><i class="fa fa-minus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $count++;
                            } } else { ?>
                            <div class="row dynamicClass">
                                <div class="col-md-5">
                                    <div class="form-group" style="margin: 0px">
                                        <label for="varchar">From</label>
                                        <input type="text" class="form-control" required name="name_1" placeholder="Name" value="" />
                                    </div>

                                </div>
                                <div class="col-md-5">
                                    <div class="form-group" style="margin: 0px">
                                        <label for="varchar">Percentage</label>
                                        <input type="text" class="form-control" required name="percentage_1" placeholder="Percentage" value="" />
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <div style="margin-top: 15px" class="col-md-12 text-right btn-row-grade">
                            <input type="hidden" name="valuation_id" value="<?php echo $id; ?>"/>
                            <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                            <a href="<?php echo site_url('admin/vehicle_valuation_settings') ?>" class="btn btn-default">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php load_module_asset('posts', 'js'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#vehicle_type_id, #condition, #brandName, #model_id, #manufacture_year, #manufacture_year").change(function () {
            let vehicle_variant = $("#vehicle_variant").val();
            getVariant(vehicle_variant);
        });

        getVariant(<?php echo $variant_id;?>);

        $(document).on('click', '.addButton', function () {
            var count = parseInt($("#classNum").val()) + 1;
            $('.btn-row').before("<div class=\"row dynamicClass\">\n" +
                "                            <div class=\"col-md-3\">\n" +
                "                                <div class=\"form-group\" style=\"margin: 0px\">\n" +
                "                                    <label for=\"varchar\">From</label>\n" +
                "                                    <input type=\"text\" class=\"form-control\" required name=\"from_" + count + "\" placeholder=\"From\" value=\"\" />\n" +
                "                                </div>\n" +
                "\n" +
                "                            </div>\n" +
                "                            <div class=\"col-md-3\">\n" +
                "                                <div class=\"form-group\" style=\"margin: 0px\">\n" +
                "                                    <label for=\"varchar\">To</label>\n" +
                "                                    <input type=\"text\" class=\"form-control\" required name=\"to_" + count + "\" placeholder=\"To\" value=\"\" />\n" +
                "                                </div>\n" +
                "                            </div>\n" +
                "\n" +
                "                            <div class=\"col-md-3\">\n" +
                "                                <div class=\"form-group\" style=\"margin: 0px\">\n" +
                "                                    <label for=\"varchar\">Percentage</label>\n" +
                "                                    <input type=\"text\" class=\"form-control\" required name=\"percentage_" + count + "\" placeholder=\"Percentage\" value=\"\" />\n" +
                "                                </div>\n" +
                "\n" +
                "                            </div>\n" +
                "                            <div class=\"col-md-3\">\n" +
                "                                <div class=\"form-group\" style=\"margin: 0px\">\n" +
                "                                    <label for=\"varchar\">Actions</label>\n" +
                "                                    <div style=\"display: flex\">\n" +
                "                                        <a style=\"width: 60px; margin-right: 5px\" class=\"form-control btn btn-sm btn-danger removeButton\"><i class=\"fa fa-minus\"></i></a>\n" +
                "                                    </div>\n" +
                "\n" +
                "                                </div>\n" +
                "\n" +
                "                            </div>\n" +
                "                        </div>");
            $("#classNum").val(count);
        });

        $(document).on('click', '.removeButton', function () {
            let elm = $(this).parent().closest('.dynamicClass');
            if (confirm("Do you really want to remove?")) {
                if ($(this).data("mileage_id")) {
                    jQuery.ajax({
                        url: 'admin/vehicle_valuation_settings/remove_millage_settings_action',
                        type: "POST",
                        dataType: "text",
                        data: {
                            mileage_id: $(this).data("mileage_id")
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            if (response.status) {
                                elm.remove();
                            }
                        }
                    });
                } else {
                    elm.remove();
                }
            }
        });


        $(document).on('click', '.addGradeButton', function () {
            var count = parseInt($("#gradeClassNum").val()) + 1;
            $('.btn-row-grade').before("<div class=\"row dynamicClass\">\n" +
                "                            <div class=\"col-md-5\">\n" +
                "                                <div class=\"form-group\" style=\"margin: 0px\">\n" +
                "                                    <label for=\"varchar\">Name</label>\n" +
                "                                    <input type=\"text\" class=\"form-control\" required name=\"name_" + count + "\" placeholder=\"Name\" value=\"\" />\n" +
                "                                </div>\n" +
                "                            </div>\n" +
                "                            <div class=\"col-md-5\">\n" +
                "                                <div class=\"form-group\" style=\"margin: 0px\">\n" +
                "                                    <label for=\"varchar\">Percentage</label>\n" +
                "                                    <input type=\"text\" class=\"form-control\" required name=\"percentage_" + count + "\" placeholder=\"Percentage\" value=\"\" />\n" +
                "                                </div>\n" +
                "\n" +
                "                            </div>\n" +
                "                            <div class=\"col-md-2\">\n" +
                "                                <div class=\"form-group\" style=\"margin: 0px\">\n" +
                "                                    <label for=\"varchar\">Actions</label>\n" +
                "                                    <div style=\"display: flex\">\n" +
                "                                        <a style=\"width: 60px; margin-right: 5px\" class=\"form-control btn btn-sm btn-danger removeGradeButton\"><i class=\"fa fa-minus\"></i></a>\n" +
                "                                    </div>\n" +
                "\n" +
                "                                </div>\n" +
                "\n" +
                "                            </div>\n" +
                "                        </div>");
            $("#gradeClassNum").val(count);
        });

        $(document).on('click', '.removeGradeButton', function () {
            let elm = $(this).parent().closest('.dynamicClass');
            if (confirm("Do you really want to remove?")) {
                if ($(this).data("grade_id")) {
                    jQuery.ajax({
                        url: 'admin/vehicle_valuation_settings/remove_grade_settings_action',
                        type: "POST",
                        dataType: "text",
                        data: {
                            grade_id: $(this).data("grade_id")
                        },
                        success: function (response) {
                            response = JSON.parse(response);
                            if (response.status) {
                                elm.remove();
                            }
                        }
                    });
                } else {
                    elm.remove();
                }
            }
        });
    });

    function getVariant(vehicle_variant) {
        let vehicle_type_id = $("#vehicle_type_id").val();
        let condition = $("#condition").val();
        let brandName = $("#brandName").val();
        let model_id = $("#model_id").val();
        let manufacture_year = $("#manufacture_year").val();

        jQuery.ajax({
            url: 'admin/vehicle_valuation_settings/get_vehicle_variant/',
            type: "POST",
            dataType: "text",
            data: {
                vehicle_type_id: vehicle_type_id,
                condition: condition,
                brandName: brandName,
                model_id: model_id,
                manufacture_year: manufacture_year,
                vehicle_variant: vehicle_variant,
            },
            beforeSend: function () {
                jQuery('#vehicle_variant').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#vehicle_variant').html(response);
            }
        });
    }
</script>
