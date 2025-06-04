<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Parts Description  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Parts Description</li>
    </ol>
</section>

<section class="content">
    <div class="row">

        <div class="col-md-4 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New Parts Description
                    </h3>
                </div>

                <div class="panel-body">                   
                    <form action="<?php echo Backend_URL; ?>parts/create_action" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" />
                        </div>
                        <div class="form-group">
                            <label for="parent_id" class="control-label">Vehicle Type :</label>   
                            <div class="col-sm-12"><?php echo parts_for_checkbox(); ?></div>
                                    
                               
                        </div>
                        <input type="hidden" name="id" value="0" /> 
                        <button type="submit" class="btn btn-primary">Save New</button> 
                        <button type="reset" class="btn btn-default">Reset</button>
                    </form>
                </div>		
            </div>
        </div>



        <div class="col-md-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4 pull-left">
                            <h3 class="panel-title"><i class="fa fa-list"></i> Parts Description List</h3>
                        </div>


                        <div class="col-md-8 text-right">

                        </div>
                    </div>  
                </div>


                <div class="panel-body">
                    <table class="table table-bordered table-striped" id="mytable">
                        <thead>
                            <tr>
                                <th width="80px">No</th>
                                <th>Name</th>
                                <th>Vehicle Type</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $start = 0;
                            foreach ($parts_data as $parts) {
                                ?>
                                <tr>
                                    <td><?php echo ++$start; ?></td>
                                     <td><?php echo $parts->name; ?></td>
                                    <td><?php echo get_parts_for($parts->parent_id); ?></td>
                                   
                                    <td>
                                        <?php                                            
                                        echo anchor(site_url(Backend_URL . 'parts/update/' . $parts->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                                        echo anchor(site_url(Backend_URL . 'parts/delete/' . $parts->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $("#mytable").dataTable();
    });
</script>