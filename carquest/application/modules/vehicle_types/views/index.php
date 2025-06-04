<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1>Vehicle Types  <small>Management</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Vehicle Types</li>
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
                    <form action="<?php echo Backend_URL; ?>vehicle_types/create_action" method="post">
                        <div class="form-group">
                            <label for="varchar">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" />
                        </div>
                        <input type="hidden" name="id" value="0" /> 
                        <button type="submit" class="btn btn-primary">Save New</button> 
                        <a href="<?php echo site_url('vehicle_types') ?>" class="btn btn-default">Reset</a>
                    </form>
                </div>		
            </div>
        </div>



<div class="col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4 pull-left">
                            <h3 class="panel-title"><i class="fa fa-list"></i> Vehicle List</h3>
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
            foreach ($vehicle_types_data as $vehicle_types){ ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <td><?php echo $vehicle_types->name ?></td>
		    <td style="text-align:center" width="200px">
			<?php 			
			echo anchor(site_url( Backend_URL .'vehicle_types/update/'.$vehicle_types->id),'<i class="fa fa-fw fa-edit"></i> Edit',  'class="btn btn-xs btn-default"'); 
			echo anchor(site_url( Backend_URL .'vehicle_types/delete/'.$vehicle_types->id),'<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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