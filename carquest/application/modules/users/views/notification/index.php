<?php defined('BASEPATH') OR exit('No direct script access allowed');
 load_module_asset('users', 'css');
?>
<section class="content-header">
    <h1> Notification  <small>Control panel</small>  </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li><li><a href="<?php echo Backend_URL ?>users">Users</a></li><li class="active">Notification</li>
    </ol>
</section>

<section class="content">       
    <div class="box">            
        
    
        <div class="box-body">
            <?php echo $this->session->flashdata('message'); ?>
            
            <div class="filter_row">
                <div class="clearfix">
                    <div class="col-md-12 no-padding">
                        <form method="get" name="report" action="">
                            <div class="col-md-2">
                                <select name="type_id" class="form-control" id="type_id">
                                    <?php echo getvehicleTypes( $this->input->get('type_id') ); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="brand_id" class="form-control" id="brand_id">
                                    <?php 
                                    if($this->input->get('brand_id') ) {
                                        echo GlobalHelper::getAllBrands( $this->input->get('type_id'), $this->input->get('brand_id') );
                                    }
                                     ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="model_id" class="form-control" id="model_id">
                                    <?php
                                    if($this->input->get('model_id') ) {
                                        echo GlobalHelper::getAllBrand( $this->input->get('model_id'), $this->input->get('brand_id') );
                                    }  ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="user_id" class="form-control" id="model_id">
                                    <?php echo GlobalHelper::getCustomers( $this->input->get('user_id') ); ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <input type="submit" class="btn btn-primary" name="go" value="Filter"> 
                                <input type="button" class="btn btn-default" value="Reset" onclick="location.href = 'admin/users/notification';">
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            
            
            <div class="table-responsive">
            <table class="table table-hover table-condensed">
                <thead>
                    <tr>
                    	<th width="40">ID</th>
		<th>User Name</th>
		<th>Vehicle Type</th>
		<th>Brand Name</th>
		<th>Model Name</th>
		<!-- <th>Year</th> -->
		<th width="200">Action</th>
                    </tr>
                </thead>

                <tbody>
	<?php foreach ($notification_data as $notification) { ?>
                    <tr>
		<td><?php echo ++$start ?></td>
                <td><?php echo getUserNameById( $notification->user_id ); ?></td>
                <td><?php echo getVehcileNameById( $notification->type_id ) ; ?></td>
		<td><?php echo getBrandModelNameById($notification->brand_id) ?></td>
		<td><?php echo getBrandModelNameById($notification->model_id) ?></td>
		<?php /*<td><?php echo $notification->year ?></td> */ ?>
		<td>
			<?php 
			//echo anchor(site_url(Backend_URL .'users/notification/read/'.$notification->id),'<i class="fa fa-fw fa-external-link"></i> View', 'class="btn btn-xs btn-default"'); 
			// echo anchor(site_url(Backend_URL .'users/notification/update/'.$notification->id),'<i class="fa fa-fw fa-edit"></i> Edit',  'class="btn btn-xs btn-default"'); 
			echo anchor(site_url(Backend_URL .'users/notification/delete/'.$notification->id),'<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-default"'); 
			?>
		</td>
                    </tr>
                <?php } ?>
                    </tbody>
                </table>
            </div>
        
        
            <div class="row">                
                <div class="col-md-6">
                    <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>
	    
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>                
            </div>
        </div>
    </div>
</section>


<script>
    
    
jQuery('#type_id').on('change', function(){
    var type_id =  jQuery(this).val();
    jQuery.ajax({
            url: 'frontend/getBrand',
            type: "POST",
            dataType: 'text',
            data: { type_id: type_id },
            success: function ( respond ) {
                jQuery('#brand_id').html( respond );                          
            }
        });
});
jQuery('#brand_id').on('change', function(){
    var brand_id =  jQuery(this).val();
    jQuery.ajax({
            url: 'frontend/getModel',
            type: "POST",
            dataType: 'text',
            data: { brand_id: brand_id },
            success: function ( respond ) {
                jQuery('#model_id').html( respond );             
            }
        });
});
   
 <?php   /*
    jQuery(document).ready(function(){
        <?php if( $this->input->get('brand_id')): ?>
               jQuery('#brand_id').html('<option value="<?php echo $this->input->get('brand_id') ?>"><?php echo getBrandModelNameById( $this->input->get('brand_id') ); ?></option>') 
        <?php endif; ?>
        <?php if( $this->input->get('model_id')): ?>
               jQuery('#model_id').html('<option value="<?php echo $this->input->get('model_id') ?>"><?php echo getBrandModelNameById( $this->input->get('model_id') ); ?></option>') 
        <?php endif; ?>
    });

*/ ?>
</script>
