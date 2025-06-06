<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Engine Sizes  <small>Management</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Engine Sizes</li>
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
                    <form action="<?php echo Backend_URL; ?>engine_sizes/create_action" method="post">
                        <input type="hidden" name="id" value="0" />
                        <div class="form-group">
                            <label for="engine_size">Engine Size</label>
                            <input type="text" class="form-control" name="engine_size" id="engine_size" placeholder="Engine Size" />
                        </div>
                        <div class="form-group">
                            <label for="vehicle_type">Vehicle Type</label>
                            <select class="form-control" name="vehicle_type" id="vehicle_type" placeholder="Vehicle Type">
                                <?php echo GlobalHelper::dropDownVehicleList($this->input->get('post_type')); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save New</button>
                        <button type="reset" class="btn btn-primary">Reset</button>
                    </form>
                </div>
            </div>
        </div>



        <div class="col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4 pull-left">
                            <h3 class="panel-title"><i class="fa fa-list"></i> Engine Size List</h3>
                        </div>
                    </div>
                </div>


                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="80px">No</th>
                                    <th>Vehicle Type</th>
                                    <th>Engine Size</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $start = 0;
                                foreach ($engine_sizes_data as $engine_sizes) {
                                    ?>
                                    <tr>
                                        <td><?php echo ++$start ?></td>
                                        <td><?php echo GlobalHelper::getVehicleNamebyId($engine_sizes->vehicle_type_id)  ?></td>
                                        <td><?php echo $engine_sizes->engine_size ?></td>
                                        <td>
                                            <?php
                                            echo anchor(site_url(Backend_URL . 'engine_sizes/update/' . $engine_sizes->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                                            echo anchor(site_url(Backend_URL . 'engine_sizes/delete/' . $engine_sizes->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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

<script type="text/javascript">
    $(document).ready(function () {
        $("#mytable").dataTable();
    });
</script>
