<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Countries  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Countries</li>
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
                    <form action="countries/create_action" method="post">
	<div class="form-group">
                                    <label for="int">Parent Id</label>
                                    <input type="text" class="form-control" name="parent_id" id="parent_id" placeholder="Parent Id" />
                                </div>
	<div class="form-group">
                                    <label for="varchar">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" />
                                </div>
	<div class="form-group">
                                    <label for="enum">Type</label>
                                    <input type="text" class="form-control" name="type" id="type" placeholder="Type" />
                                </div>
	<div class="form-group">
                                    <label for="enum">Status</label>
                                    <input type="text" class="form-control" name="status" id="status" placeholder="Status" />
                                </div>
	    <input type="hidden" name="id" value="0" /> 
	    <button type="submit" class="btn btn-primary">Save New</button> 
	    <a href="<?php echo site_url('countries') ?>" class="btn btn-default">Reset</a>
	</form>
                </div>		
            </div>
        </div>
		
							
        <div class="col-sm-8 col-xs-12">
            <div class="panel panel-default">            
                <div class="panel-heading">					 
                    <h3 class="panel-title">
                        <i class="fa fa-users" aria-hidden="true"></i> 
                        Countries List                    
                    </h3>                                                        
                </div>
                <div class="panel-body">
                
        <table class="table table-hover table-condensed" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
		<th>Parent Id</th>
		<th>Name</th>
		<th>Type</th>
		<th>Status</th>
		<th>Action</th>
                            </tr>
                            </thead><?php foreach ($countries_data as $countries) { ?>
                                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $countries->parent_id ?></td>
			<td><?php echo $countries->name ?></td>
			<td><?php echo $countries->type ?></td>
			<td><?php echo $countries->status ?></td>
			<td width="150px">
				<?php 
			echo anchor(site_url(Backend_URL .'countries/read/'.$countries->id),'<i class="fa fa-fw fa-external-link"></i> View', 'class="btn btn-xs btn-default"'); 
			echo anchor(site_url(Backend_URL .'countries/update/'.$countries->id),'<i class="fa fa-fw fa-edit"></i> Edit',  'class="btn btn-xs btn-default"'); 
			echo anchor(site_url(Backend_URL .'countries/delete/'.$countries->id),'<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php } ?>
        </table>
		
		
		
		
		
                <div class="row" style="padding-top: 10px;">
                    <div class="col-md-3">
                <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>
	    </div>
                    <div class="col-md-9 text-right">
                        <?php echo $pagination ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>