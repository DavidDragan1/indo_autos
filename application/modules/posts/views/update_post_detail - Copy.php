<?php
defined('BASEPATH') OR exit('No direct script access allowed');

load_module_asset('posts', 'css');
?>


<section class="content-header">
    <h1> Posts <small>Update</small> <a href="<?php echo site_url('admin/posts') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL; ?>posts">Posts</a></li>
        <li class="active">Add New</li>
    </ol>
</section>
<section class="content">
    <?php echo postUpdateTabs('update_post_detail', $this->uri->segment(4)); ?> 
    <div class="box">
        <form action="<?php echo $action; ?>" method="post"  onload="initialize()" id="post_details">    
            <div class="box-header with-border">
                <div class="col-md-5">
                    <h2 class="box-title"><b>Update Product Information</b></h2>
                </div>

                <div class="col-md-5 pull-right no-padding">
                    <div class="form-group text-right no-margin">
                        <button class="btn btn-primary" name="update_only" value="stay" type="submit"><i class="fa fa-save" ></i> Update &AMP; Stay Here</button>
                        <button class="btn btn-primary" name="update_continue" value="continue" type="submit"><i class="fa fa-save" ></i> Save &AMP; Goto Next Step <i class="fa fa-arrow-right" ></i> </button>
                    </div>
                </div>			
            </div>

            <div class="box-body">


                <div class="row">
                    <div class="col-sm-7">

                        <div class="form-group">
                            <div class="text-left">                                
                                <span class="label label-primary label-big"> Area/Location: <?php echo getTagName('post_area', 'name', $location_id); ?></span>&nbsp;
                                <span class="label label-success label-big"> Vehicle Category: <?php echo getTagName('vehicle_types', 'name', $vehicle_type_id); ?> </span>&nbsp;
                                <span class="label label-primary label-big"> Condition: <?php echo $condition; ?> </span>&nbsp;
                                <a href="<?php echo Backend_URL . 'posts/update_general/'. $id; ?>" class="label label-danger label-big pull-right"><i class="fa fa-times-circle"></i> Change </a>
                            </div>
                        </div>



                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> Title <sup>*</sup></span>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="<?php echo $title; ?>" required="">                                    
                        </div>

                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-globe"></i> Page-link : <?php echo base_url(); ?><sup>*</sup></span>                  
                            <input type="text" name="post_slug" class="form-control" value="<?php echo $post_slug; ?>" id="postSlug" required="">
                        </div>


                        <div class="form-group clearfix">                                                                                                                  
                            <div class="form-group input-group" style="width:100%;">
                                <span class="input-group-addon no-padding" style="width:250px; border: 0;">

                                    <select name="pricein" class="form-control" id="currency" required="required">
                                        <option value="USD" <?php echo ($pricein == 'USD') ? ' selected' : ''; ?> >Currency:  &dollar; USD </option>
                                    </select>
                                </span>
                                <input  name="pricevalue" type="text" onKeyPress="return DegitOnly(event);" class="form-control" required=""  value="<?php echo $price; ?>"/>                                                                                                                                                                                                                             
                            </div>                                                                                                                                                                                                                                                                                                                                                
                        </div>


                        <div class="form-group col-md-12 no-padding clearfix">
                            <label for="description">Description <sup>*</sup></label>
                            <textarea class="form-control textareasize" rows="5"  name="description" required="" id="description"><?php echo $description; ?></textarea>                                    
                        </div>
                        
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-signal"></i> Age </span>
                            <select class="form-control" name="car_age" id="car_age">
                                <?php echo car_age($car_age); ?>
                            </select>                                
                        </div>
                        
                       <?php  if (in_array($vehicle_type_id, [1,2,5,6])) : ?>
                            <div class="form-group spfeatures" id="morefName">
                                <label>Special Features</label>
                                <div class="clearfix">
                                    <?php echo Modules::run('special_features/all_features', $feature_ids); ?>                                                                                                          
                                </div>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    <div class="col-sm-5">

                        <?php if ($vehicle_type_id == 4) : ?>
                        <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-unsorted"></i> Parts For <sup>*</sup></span>
                                <select class="form-control " id="parts_for" name="parts_for" required="">
                                    <option value="0">Please Select</option>
                                    <?php echo parts_for($parts_for); ?>
                                </select>                                
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-puzzle-piece"></i> Parts Description <sup>*</sup></span>
                                <select class="form-control " id="parts_description" name="parts_description" required="">
                                    <option value="">Please Select</option>
                                    <?php echo parts_description($parts_description); ?>
                                </select>                                
                            </div>
                        <?php endif; ?>

                        <?php if (in_array($vehicle_type_id, [1,2,3,5,6])) : ?>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> Registration Number</span>
                                <input type="text" class="form-control" id="RegistrationNumber" name="registration_no" value="<?php echo $registration_no; ?>">
                            </div>
                        <?php endif; ?>

                        <?php if (in_array($vehicle_type_id, [1,2,3,5,6])) : ?>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-tachometer"></i> Mileage (Miles)</span>
                                <input type="number" class="form-control" id="mileage" name="mileage" value="<?php echo $mileage; ?>"  onKeyPress="return DegitOnly(event);">                                        
                            </div>
                        <?php endif; ?>



                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i> Year of Manufacture <sup>*</sup></span>
                            <select required="" name="manufacture_year" class="form-control" id="manufacture_year">
                                <option value="">Please Select</option>
                                <?php echo numericDropDown(1950, date('Y'), 1, $manufacture_year); ?>
                            </select>
                        </div>


                        <div class="form-group input-group">
                            

                            <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> Brand Name <sup>*</sup></span>
                            <select class="form-control" id="brandName" required="" onChange="get_model(this.value, <?php echo $vehicle_type_id; ?>);" name="brand_id">
                                <option value="0">Select a brand</option>
                                <?php echo Modules::run('brands/all_brands_by_vehicle', $vehicle_type_id, $brand_id); ?>                                
                            </select>                                    
                        </div>





                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-gg"></i> Model Name <sup>*</sup></span>

                            <select class="form-control" id="model_id" name="model_id" required="">
                                <?php echo getBrand($model_id, $brand_id); ?>                                                                                   
                            </select>  


                        </div>





                        <?php if (in_array($vehicle_type_id, [1,2,3,5,6])) : ?>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-fire"></i> Fuel Type <sup>*</sup></span>                                
                                <select class="form-control" id="fueltype" name="fuel_id" required="">
                                    <?php echo GlobalHelper::createDropDownFromTable( $tbl = 'fuel_types', $col = 'fuel_name', $fuel_id );?>
                                </select>                                        
                            </div>

                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-automobile"></i> Engine Size</span>                                    
                                <select name="enginesize_id" class="form-control" id="Enginesize">                                   
                                    <?php echo GlobalHelper::createDropDownFromTable( $tbl = 'engine_sizes', $col = 'engine_size', $enginesize_id );?>                                    
                                </select>                                        
                            </div>                                

                        <?php endif; ?> 
                        
                        <?php if (in_array($vehicle_type_id, [1,2,5,6])) :
                            ?>                              
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i> Seats <sup>*</sup></span>
                                <select class="form-control" name="seats" id="seats" required="">
                                    <?php echo GlobalHelper::seat($seats, 'Select Seats'); ?>
                                </select>                                       
                            </div>
                        <?php endif; ?>  

                        <?php if (in_array($vehicle_type_id, [1,2,3,5,6])) :
                            ?>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-sun-o"></i> Gearbox <sup>*</sup></span>
                                <select class="form-control" id="gearBox" name="gear_box_type" required=""> 
                                    <?php echo GlobalHelper::gearBox($gear_box_type); ?>
                                </select>                                        
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-car"></i> Body Type <sup>*</sup></span>                                    
                                <select class="form-control " id="Bodytype" name="body_type" required="">
                                    <?php echo GlobalHelper::createDropDownFromTable( $tbl = 'body_types', $col = 'type_name', $body_type );?>                                                                
                                </select>    
                            </div>
                        <?php endif; ?>                  


                        <?php if (in_array($vehicle_type_id, [1,2,3,5,6])) : ?>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-flask"></i> Colour <sup>*</sup></span>                                
                                <?php // $color_list = Modules::run('Color/color_list'); ?>                                                                                                                                
                                <select class="form-control"  name="color" id="color" required="">                                    
                                    <?php echo GlobalHelper::createDropDownFromTable( $tbl = 'color', $col = 'color_name', $color );?>
                                </select>
                            </div>
                        <?php endif; ?>



                            <?php if (in_array($vehicle_type_id, [1,2,3,5,6])) : ?>

                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i> 1st Registration Date </span>
                                <?php $reg_date = explode('-', $registration_date); ?>
                                <div class="row" style="margin: 0 -15px 0 0; ">
                                    <div class="col-sm-3 no-padding">

                                        <select name="regiday" class="form-control" id="regiday">
                                            <option value="00">DD</option>
                                            <?php echo numericDropDown(1, 31, 1, $reg_date[2]); ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 no-padding">
                                        <select name="regimonth" class="form-control" id="regimonth">
                                            <option value="00">MM</option>
                                            <?php echo numericDropDown(1, 12, 1, $reg_date[1]); ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6" style="padding-left:0;">
                                        <select name="regiyear" class="form-control" id="regiyear">
                                            <option value="0000">YYYY</option>
                                            <?php echo numericDropDown(1950, date('Y'), 1, $reg_date[0]); ?>
                                        </select>
                                    </div>
                                </div>


                            </div>


                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-cogs"></i> Service History</span>
                                <select class="form-control " id="Servicehistory" name="service_history">
                                    <option value="0">Please Select</option>
                                    <?php echo service_history($service_history); ?>
                                </select>

                            </div>
                        <?php endif; ?>    
                        
                        <?php if (in_array($vehicle_type_id, [1,2,3,5,6])) { ?>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-circle-o"></i> Alloy Wheels</span>
                                <select class="form-control " id="alloywheels" name="alloywheels">
                                    <?php echo GlobalHelper::wheel_list($alloywheels); ?>
                                </select>
                            </div>
                        <?php } ?>
                        
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i> Owner</span>
                                <select class="form-control " id="owners" name="owners">
                                    <option value="0">Please Select</option>
                                    <?php echo owners($owners); ?>
                                </select>
                            </div>                                
                                    
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />                             
                    </div>



                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group text-right">
                            <button class="btn btn-primary" name="update_only" value="stay" type="submit"><i class="fa fa-save" ></i> Update &AMP; Stay Here</button>
                            <button class="btn btn-primary" name="update_continue" value="continue" type="submit"><i class="fa fa-save" ></i> Save &AMP; Goto Next Step <i class="fa fa-arrow-right" ></i> </button>
                        </div>
                    </div>
                </div>


            </div>
        </form>
    </div>
</section>

<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script> 
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js"></script> 
<!-- validate --> 

<script><?php echo load_module_asset('posts', 'js', 'tooltip.js'); ?></script>
<?php load_module_asset('posts', 'js'); ?>
<script type="text/javascript">
    $("#title").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        $("#postSlug").val(Text);
        $(".pageSlug").text(Text);
    });


    CKEDITOR.replace('description', {
        toolbar: [
            {name: 'document', items: ['NewPage', 'Preview', '-', 'Templates']}, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
            ['Cut', 'Copy', 'Paste', 'Undo', 'Redo'], // Defines toolbar group without name.
            // Line break - next group will be placed in new line.
            {name: 'basicstyles', items: ['Bold', 'Italic']}
        ],
        // uiColor: '#337ab7'
    });
</script>








