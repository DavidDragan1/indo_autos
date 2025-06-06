<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>

<link rel="stylesheet" href="assets/lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script type="text/javascript" src="assets/lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script> $(function () { $(".editor").wysihtml5(); }); </script>

<section class="content-header">
    <h1>Diagnostic<small><?php echo $button ?></small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li><li><a href="<?php echo Backend_URL ?>diagnostics">Diagnostic</a></li>
        <li class="active">Update</li>
    </ol>
</section>

<section class="content">
    <?php echo helpTabs($id, 'update'); ?>
    <div class="box no-border">





        <div class="box-header with-border">

            <h3 class="box-title">Update Question Answer</h3>
            <?php echo $this->session->flashdata('message'); ?>
        </div>

        <div class="box-body">

            <form class="" action="<?php echo $action; ?>" method="post">
                <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title" class="">Question :</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Question" value="<?php echo $title; ?>" />
                        <?php echo form_error('title') ?>
                    </div>
                    <div class="form-group">
                        <label for="problem" class="">Problem :</label>
                        <textarea class="form-control editor" rows="10" name="problem" id="problem" placeholder="Problem"><?php echo $problem; ?></textarea>
                        <?php echo form_error('problem') ?>
                    </div>
                    <div class="form-group">
                        <label for="inspection" class="">Inspection :</label>
                        <textarea class="form-control editor" rows="10" name="inspection" id="inspection" placeholder="Inspection"><?php echo $inspection; ?></textarea>
                        <?php echo form_error('inspection') ?>
                    </div>

                    <div class="form-group">
                        <label for="content" class="">Solution :</label>
                        <textarea class="form-control editor" rows="10" name="content" id="content" placeholder="Solution"><?php echo $content; ?></textarea>
                        <?php echo form_error('content') ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="vehicle_type" class="">Vehicle Type :</label>
                        <select name="vehicle_type" class="form-control" id="vehicle_type">
                            <?php echo GlobalHelper::diagnostic_type_of_cars($vehicle_type); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="brand_id" class="">Brand Name :</label>
                        <select name="brand_id" class="form-control" id="brand_id">
                            <?php // echo GlobalHelper::get_brands_by_vechile(0, $brand_id); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="model_id" class="">Model Name :</label>
                        <select name="model_id" class="form-control" id="model_id">
                            <?php // echo GlobalHelper::getModel($model_id); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="">Category Name :</label>
                        <select name="category_id" class="form-control" id="category_id">
                            <?php echo GlobalHelper::parts_categories($category_id); ?>
                        </select>


                    </div>

                    <div class="form-group">
                        <label for="content" class="">Status :</label>
                        <div class="clearfix" style="padding-top: 8px;">
                            <?php echo htmlRadio('status', $status, array('Published' => 'Published', 'Draft' => 'Draft')); ?>
                        </div>
                    </div>




                </div>


            </div>
                 <div class="box-footer">

                    <input type="hidden" name="id" value="<?php echo $id; ?>" />

                    <a href="<?php echo site_url(Backend_URL . 'diagnostics') ?>" class="btn btn-default">Cancel</a>

                    <button type="submit" class="btn btn-primary">Save Update</button>


                    <a href="diagnostics/delete/<?php echo $id;?>" onclick="return confirm('Confirm Delete?');"
                       class="btn btn-danger pull-right">
                            <i class="fa fa-times"></i> Delete
                        </a>
                </div>
               </form>
        </div>



    </div>

</section>


<script>


$(document).ready(function(){
    var type = '<?php echo $vehicle_type; ?>';
    var brand_id = '<?php echo $brand_id; ?>';
        jQuery.ajax({
            url: 'brands/brands_frontview/getDropDownBrands_view/' + type + '/'+ brand_id,
            type: "GET",
            dataType: "text",
            success: function (jsonData) {
                jQuery('#brand_id').html(jsonData);
            }
    });
    var brand_id = '<?php echo $brand_id; ?>';
    var model_id = '<?php echo $model_id; ?>';
        jQuery.ajax({
            url: 'brands/brands_frontview/getDropDownModel_view/0/'+model_id+'?brand_id=' + brand_id,
            type: "GET",
            dataType: "text",
            success: function (jsonData) {
                jQuery('#model_id').html(jsonData);
            }
        });


});


    $('#vehicle_type').change(function () {
        var type = $('#vehicle_type option:selected').val();
        jQuery.ajax({
            url: 'brands/brands_frontview/getDropDownBrands_view/' + type,
            type: "GET",
            dataType: "text",
            success: function (jsonData) {
                jQuery('#brand_id').html(jsonData);
            }
        });
    });

    $('#brand_id').change(function () {
        var brand_id = $('#brand_id option:selected').val();
        jQuery.ajax({
            url: 'brands/brands_frontview/getDropDownModel_view?brand_id=' + brand_id,
            type: "GET",
            dataType: "text",
            success: function (jsonData) {
                jQuery('#model_id').html(jsonData);
            }
        });
    });

</script>

