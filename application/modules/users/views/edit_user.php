<?php
defined('BASEPATH') OR exit('No direct script access allowed');

load_module_asset('users', 'css');
load_module_asset('users', 'js');

require_once ( __DIR__ . '/tabs.php');
?>


<div class="panel panel-default">

    <div class="panel-body user_profile_form">
        <div id="success_report"></div>
        
        <form method="post" id="update_user_aliza" name="fileinfo"  class="form-horizontal">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
        <!-- form action="<?php echo $action; ?>" id="user_form" name="fileinfo" method="POST" enctype="multipart/form-data"  class="form-horizontal"-->
            <input name="isRobot" type="hidden" value="0"/>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="role_id" class="col-sm-3 control-label">Role<sup>*</sup> :<?php echo form_error('role_id') ?></label>
                        <div class="col-sm-9">
                            <select name="role_id" class="form-control" id="role_id">
                                <?php echo Users_helper::getDropDownRoleName($role_id); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-3 control-label">Title<sup>*</sup>: <?php echo form_error('title') ?></label>
                        <div class="col-sm-9">
                            <select name="title" class="form-control" id="title">
                                <?php echo Users_helper::getTitleName($title); ?>
                            </select>
                        </div>      
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="col-sm-3 control-label">First Name<sup>*</sup> :<?php echo form_error('first_name') ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="<?php echo $first_name; ?>" />

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-sm-3 control-label">Last Name<sup>*</sup> :<?php echo form_error('last_name') ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="<?php echo $last_name; ?>" />
                        </div> 
                    </div>
                    <div class="form-group" >
                        <label for="email" class="col-sm-3 control-label">Email<sup>*</sup> <?php echo form_error('email') ?></label>
                        <div class="col-sm-9"> <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
                        </div>   
                    </div>
                    
                    <div class="form-group">
                        <label for="contact" class="col-sm-3 control-label">Contact Number 01 :<?php echo form_error('contact') ?></label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="contact" id="contact" placeholder="Contact Number" value="<?php echo $contact; ?>" />
                        </div> 
                    </div>
                    
                    <div class="form-group">
                        <label for="contact1" class="col-sm-3 control-label">Contact Number 02 :<?php echo form_error('contact1') ?></label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="contact1" id="contact" placeholder="Contact Number" value="<?php echo $contact1; ?>" />
                        </div> 
                    </div>
                    
                    <div class="form-group">
                        <label for="contact2" class="col-sm-3 control-label">Contact Number 03 :<?php echo form_error('contact2') ?></label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="contact2" id="contact2" placeholder="Contact Number" value="<?php echo $contact2; ?>" />
                        </div> 
                    </div>
                    
                    <div class="form-group" >
                        <?php $date = explode('-', $dob??'');?>
                        
                        <label class="col-sm-3 control-label" for="dob">Date of Birth :</label>
                        <div class="col-sm-9">
                            <div class="" >
                                <div class="col-md-3 no-padding"><select id="dob" name="dd" class="form-control"><option>DD</option><?php echo numericDropDown(1,31,1,$date[2]); ?></select></div>
                                <div class="col-md-3 no-padding"><select  name="mm" class="form-control"><option>MM</option><?php echo numericDropDown(1,12,1,$date[1]); ?></select></div>
                                <div class="col-md-3 no-padding"><select  name="yy" class="form-control"><option>YYYY</option><?php echo numericDropDown( date( 'Y', strtotime('-50 years')), date('Y'),1,$date[0]); ?></select></div>                                                                                                                        
                            </div>                                                             
                        </div>
                    </div>

                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="add_line1" class="col-sm-3 control-label">Address Line 1 :<?php echo form_error('add_line1') ?></label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="add_line1" id="add_line1" placeholder="Address Line 1" value="<?php echo $add_line1; ?>" />
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="add_line2" class="col-sm-3 control-label">Address Line 2 :<?php echo form_error('add_line2') ?></label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="add_line2" id="add_line2" placeholder="Address Line 2" value="<?php echo $add_line2; ?>" />
                        </div>   </div>
                    <div class="form-group">
                        <label for="city" class="col-sm-2 control-label">City :<?php echo form_error('city') ?></label>
                        <div class="col-sm-10"> <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php echo $city; ?>" />
                        </div>  </div>
                    <div class="form-group">
                        <label for="state" class="col-sm-2 control-label">State :<?php echo form_error('state') ?></label>
                        <div class="col-sm-10"><input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?php echo $state; ?>" />
                        </div>  </div>
                    <div class="form-group">
                        <label for="postcode" class="col-sm-2 control-label">Postcode :<?php echo form_error('postcode') ?></label>
                        <div class="col-sm-10"><input type="text" class="form-control" name="postcode" id="postcode" placeholder="Postcode" value="<?php echo $postcode; ?>" />
                        </div>  </div>
                    <div class="form-group">
                        <label for="country_id" class="col-sm-2 control-label">Country :<?php echo form_error('country_id') ?></label>
                        <div class="col-sm-10">
                            <select name="country_id" class="form-control" id="country_id">
                                <?php echo getDropDownCountries($country_id); ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="profilePic" class="col-sm-2 control-label">Profile Photo :<?php echo form_error('profile_photo') ?></label>

                        <div class="col-sm-10">
                            
                            <input type="hidden" name="old_img" value="<?php echo $profile_photo; ?>" />    
                            <div class="row">
                            <div class="thumbnail upload_image" style="border:0!important;">
                                <?php if (!empty($profile_photo)) : ?>
                                    <img src="uploads/users_profile/<?php echo $profile_photo; ?>" class="img-responsive lazyload" alt="image"/>
                                <?php else : ?>
                                    <img src="uploads/cms_photos/no-thumb.png" class="img-responsive lazyload" alt="image"/>
                                <?php endif; ?>
                            </div>
                            <div class="btn btn-default btn-file" style="margin: 10px 150px; overflow: hidden;">
                                <i class="fa fa-picture-o"></i> Set Thumbnail 
                                <input type="file" name="profile_photo" class="file_select" onchange="instantShowUploadImage(this, '.upload_image')"/>
                            </div>  
                             
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status :<?php echo form_error('status') ?></label>
                        <div class="col-sm-10"><select name="status" class="form-control" id="status">
                                <?php echo userStatus($status) ?>
                            </select>
                        </div>  
                    </div>
                </div>
            </div>       
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i>
                <?php echo $button ?>
            </button>             
        </form>
    </div>

</div>
</section>