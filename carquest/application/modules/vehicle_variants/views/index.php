<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1>Vehicle Variants
        <small>Management</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Vehicle Variants</li>
    </ol>
</section>

<section class="content">
    <div class="row">


        <div class="col-sm-4 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New
                    </h3>
                </div>

                <div class="panel-body">
                    <form action="<?php echo Backend_URL; ?>vehicle_variants/create_action" method="post">
                        <div class="form-group">
                            <label for="varchar">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name"/>
                        </div>
                        <div class="form-group">
                            <label for="varchar">Vehicle Category</label>
                            <select <?php echo ($this->input->get('post_type')) ? 'readonly' : ''; ?>
                                    class="form-control" name="vehicle_type_id" id="vehicle_type_id">
                                <?php echo GlobalHelper::dropDownVehicleListForVariants($this->input->get('post_type')); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="varchar">Vehicle Condition</label>
                            <select class="form-control" id="condition" name="vehicle_condition">
                                <?php echo GlobalHelper::getConditions(0, 'Select'); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="varchar">Brand Name</label>
                            <select class="form-control" id="brandName" required="" onChange="get_model(this.value,0);" name="brand_id">
                                <option value="0">Select a brand</option>
                                <?php echo Modules::run('brands/all_brands_for_automech', 0, 0); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="varchar">Model Name</label>
                            <select class="form-control" id="model_id" name="model_id" required="">
                                <?php echo getBrand(0, 0); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="varchar">Year of Manufacture</label>
                            <select required="" name="manufacturing_year" class="form-control" id="manufacture_year">
                                <option value="">Please Select</option>
                                <?php echo numericDropDown(1950, date('Y'), 1, 0, true); ?>
                            </select>
                        </div>
                        <input type="hidden" name="id" value="0"/>
                        <button type="submit" class="btn btn-primary">Save New</button>
                        <a href="<?php echo site_url('vehicle_variants') ?>" class="btn btn-default">Reset</a>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4 pull-left">
                            <h3 class="panel-title"><i class="fa fa-list"></i> Vehicle Variant List</h3>
                        </div>


                        <div class="col-md-8 text-right">

                        </div>
                    </div>
                </div>


                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                            <tr>
                                <th width="80px">No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $start = 0;
                            foreach ($vehicle_variants_data as $vehicle_variants) { ?>
                                <tr>
                                    <td><?php echo ++$start ?></td>
                                    <td><?php echo $vehicle_variants->variant_name ?></td>
                                    <td style="text-align:center" width="200px">
                                        <?php
                                        echo anchor(site_url(Backend_URL . 'vehicle_variants/update/' . $vehicle_variants->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                                        echo anchor(site_url(Backend_URL . 'vehicle_variants/delete/' . $vehicle_variants->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php load_module_asset('posts', 'js'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#mytable").dataTable();
    });
</script>
