<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Port  <small>Management</small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Port List</li>
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
                    <form action="<?php echo Backend_URL; ?>port/create_action" method="post">
                        <div class="form-group">
                            <label for="varchar">Port Name</label>
                            <input type="text" class="form-control" name="name" id="fuel_name" placeholder="Port Name" />
                        </div>
                        <input type="hidden" name="id" value="0" /> 
                        <button type="submit" class="btn btn-primary">Save New</button> 
                        <a href="<?php echo site_url('port') ?>" class="btn btn-default">Reset</a>
                    </form>
                </div>		
            </div>
        </div>



        <div class="col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4 pull-left">
                            <h3 class="panel-title"><i class="fa fa-list"></i> Port List</h3>
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
                                    <th>Port Name</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $start = 0;
                                foreach ($fuel_types_data as $fuel_types) {
                                    ?>
                                    <tr>
                                        <td><?php echo ++$start ?></td>
                                        <td><?php echo ucfirst($fuel_types->name) ?></td>
                                        <td>
                                            <?php
                                            echo anchor(site_url(Backend_URL . 'port/update/' . $fuel_types->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                                            echo anchor(site_url(Backend_URL . 'port/delete/' . $fuel_types->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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