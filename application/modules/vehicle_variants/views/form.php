<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1> Vehicle Variants
        <small><?php echo $button ?></small>
        <a href="<?php echo site_url('admin/vehicle_variants') ?>" class="btn btn-default">Back</a></h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/vehicle_variants">Vehicle Variants</a></li>
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
                            <label for="varchar">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $variant_name; ?>"/>
                        </div>
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
                        <div class="col-md-12 text-right"><input type="hidden" name="id" value="<?php echo $id; ?>"/>
                            <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                            <a href="<?php echo site_url('admin/vehicle_variants') ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php load_module_asset('posts', 'js'); ?>
