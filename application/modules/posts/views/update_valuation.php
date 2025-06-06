<?php
defined('BASEPATH') OR exit('No direct script access allowed');
load_module_asset('posts', 'css');
load_module_asset('posts', 'js');

 $roleID =  getLoginUserData('role_id');
 $getType = $post_type;
 
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

    <?php echo postUpdateTabs('update_general', $this->uri->segment(5)); ?>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Upload Vehicle For Sale</h3>
        </div>
        <div class="box-body" onload="initialize();">

            <div class="col-sm-12">

                <form class="form-horizontal" id="upload_new" action="<?php echo $action; ?>" method="post" onsubmit="return upload_new_post();"> 
                    <input type="hidden" name="lat" id="latitude" value="<?php echo $lat; ?>">
                    <input type="hidden" name="lng" id="longitude" value="<?php echo $lng; ?>">
                    <style type="text/css"> .input-group-addon { min-width: 200px; } </style>         
                    <div class="form_fields">                                                                                                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-globe"></i> Milage <sup>*</sup></span>
                            <select class="form-control" name="location_id" id="location_id" required>                                    
                                <?php echo GlobalHelper::all_location($location_id); ?>                                                                        
                            </select>                                                                
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-2"><span class="input-group-addon"> <i class="fa fa-map-marker"></i> Color<sup>*</sup></span></div>
                                <div class="col-sm-10">
                                    <div class="col-sm-6">Excellent</div>
                                    <div class="col-sm-6"><input class="form-control0"></div>
                                    <div class="col-sm-6">Good</div>
                                    <div class="col-sm-6"><input class="form-control0"></div>
                                    <div class="col-sm-6">Fair</div>
                                    <div class="col-sm-6"><input class="form-control0"></div>
                                    <div class="col-sm-6">Band</div>
                                    <div class="col-sm-6"><input class="form-control0"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-2"><span class="input-group-addon"> <i class="fa fa-map-marker"></i> Color<sup>*</sup></span></div>
                                <div class="col-sm-10">
                                    <div class="col-sm-6">Black</div>
                                    <div class="col-sm-6"><input class="form-control0"></div>
                                    <div class="col-sm-6">White</div>
                                    <div class="col-sm-6"><input class="form-control0"></div>
                                    <div class="col-sm-6">Gray</div>
                                    <div class="col-sm-6"><input class="form-control0"></div>
                                    <div class="col-sm-6">Other</div>
                                    <div class="col-sm-6"><input class="form-control0"></div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>" />  
                        <a href="<?php echo site_url(Backend_URL . 'posts') ?>" class="btn btn-default"><i class="fa fa-arrow-left" ></i> Back to List</a>
                        <button class="btn btn-primary" type="submit">Save & Continue <i class="fa fa-arrow-right" ></i></button>                   
                    </div>
                </form>

            </div>


        </div>
    </div>
</section>

<?php $this->load->view('google_map_script'); ?>

