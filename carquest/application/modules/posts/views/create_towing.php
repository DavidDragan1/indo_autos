<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

 load_module_asset('posts','css');
 load_module_asset('posts','js');

 $roleID =  getLoginUserData('role_id');
 
?>

<section class="content-header">
    <h1> Post <small>Upload</small>  </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>posts">Posts</a></li>
        <li class="active">Add New</li>
    </ol>
</section>
<section class="content">
    

    <?php echo postUpdateTabs('general'); ?> 
    
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Upload Vehicle For Sale</h3>
        </div>
        <div class="box-body">
           
            <div class="col-sm-12">
                <form class="form-horizontal" id="upload_new" action="<?php echo $action; ?>" method="post" onsubmit="return upload_new_post();">
                    
                    
                    <style type="text/css"> .input-group-addon { min-width: 200px; } </style>
                    <div class="form_fields">
                                                    
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i> State <sup>*</sup></span>                                                                                               
                                <select class="form-control" name="location_id" id="location_id" onchange="getCity()">
                                    <?php echo GlobalHelper::all_location(); ?>                                                                        
                                </select>                                                                
                            </div>
                            
                            
                            <div class="input-group">
                                <span class="input-group-addon"> <i class="fa fa-map-marker"></i> Location of the Product  <sup>*</sup></span>
                                <select class="form-control" name="location" id="location">
                                    <?php echo GlobalHelper::all_city(); ?>
                                </select>
                                <input type="hidden" name="lat" id="latitude" value="">
                                <input type="hidden" name="lng" id="longitude" value="">
                            </div>
                            
                            
                        <?php /* if( $roleID != 8 ) : ?>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-unsorted"></i> Vehicle Category  <sup>*</sup></span>
                                <select class="form-control" name="vehicle_type_id" id="vehicle_type_id">
                                    <?php echo GlobalHelper::getDropDownVehicleType(0); ?>                                                                        
                                </select>
                            </div>
                        <?php endif;  
                            
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-check-square"></i> Vehicle Condition  <sup>*</sup></span>
                                                                
                                <select class="form-control" id="condition" name="condition">
                                    <?php echo GlobalHelper::getConditions(0, 'Select');?>
                                </select>
                                
                            </div> */ ?>
                                  
                        <input type="hidden" name="post_type" value="Towing">
                         <input type="hidden" name="condition" value="Nigerian used">
                            
                             <?php if(getLoginUserData('role_id') == 4): ?>                             
                                <input type="hidden" name="listing_type" value="Business">
                             <?php elseif(getLoginUserData('role_id') == 5): ?>
                                <input type="hidden" name="listing_type" value="Personal">
                             <?php else: ?>
                                 <?php /* if( $roleID != 8 ) : ?>
                                
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i> Seller Type<sup>*</sup></span>
                                   <select class="form-control" id="listing_type" name="listing_type">                                    
                                       <?php echo listing_type();  ?>
                                   </select>                                
                               </div>
                                <?php endif; */ ?>
                             <?php endif; ?>
                            
                           
                            
                            <!--<div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i> Listing Package</span>
                                <select class="form-control" id="advert_type" name="advert_type">                                    
                                    <?php echo advert_type(); ?>
                                </select>                                
                            </div>-->
                            
                            
                            
                                <div class="input-group">
                                    <span class="input-group-addon" for="package_id"><i class="fa fa-user"></i> Listing Package<sup>*</sup></span>                                 
                                    <select name="package_id" class="form-control">
                                        <?php echo getPostPackages($package_id); ?>
                                    </select>
                                    <?php //echo form_error('package_id') ?>                                                       
                                </div>
                            
                            
                                                        
                            
                           <a href="<?php echo site_url('admin/posts') ?>" class="btn btn-default"><i class="fa fa-arrow-left" ></i> Cancel</a>
                           <button class="btn btn-primary" type="submit">Submit & Continue <i class="fa fa-arrow-right" ></i></button>                           
                    
                    </div>
                </form>

            </div>
            


        </div>
    </div>
</section>
<script>
    function getCity() {
        var id = $("#location_id").val();
        jQuery.ajax({
            url: 'all-city?id='+id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                jQuery('#location').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#location').html(response);
            }
        });
    }
</script>
