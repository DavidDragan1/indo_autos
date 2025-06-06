<?php load_module_asset('profile', 'css' );?>
<?php load_module_asset('profile', 'js' );?>

<section class="content-header">
    <h1>My Account <small>Update Profile</small>  </h1>
	<ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-user"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL . 'profile' ?>"><i class="fa fa-dashboard"></i> Profile</a></li>
        <li class="active">Update Profile</li>
    </ol>
</section>


<section class="content">    
    <?php echo Profile_helper::makeTab('#'); ?>            
    <div class="box no-border">       
        <div class="box-body">
            <div class="col-md-12"><div id="ajax_respond"></div></div>
            <form method="post" id="update_profile_info">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="text">Contact Number 01</label>
                        <input type="text" class="form-control" name="contact" value="<?php echo $contact; ?>">
                    </div>
                    <div class="form-group">
                        <label for="text">Contact Number 02</label>
                        <input type="text" class="form-control" name="contact1" value="<?php echo $contact1; ?>">
                    </div>
                    <div class="form-group">
                        <label for="text">Contact Number 03</label>
                        <input type="text" class="form-control" name="contact2" value="<?php echo $contact2; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Contact Email</label>
                        <input type="email" class="form-control readonly" name="user_email" readonly="readonly" value="<?php echo $email; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="text">Country</label>
                        <select name="country" class="form-control">
                            <?php echo getDropDownCountries($country_id); ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="text">Address Line 1</label>
                        <input type="text" class="form-control" id="text" name="userAddress1" value="<?php echo $add_line1; ?>">
                    </div>
                    <div class="form-group">
                        <label for="text">Address Line 2</label>
                        <input type="text" class="form-control" id="text" name="userAddress2" value="<?php echo $add_line2; ?>">
                    </div>
                    <div class="form-group">
                        <label for="text">City</label>
                        <input type="text" class="form-control" id="text" name="userCity" value="<?php echo $city; ?>">
                    </div>
                    <div class="form-group">
                        <label for="text">State/Region</label>
                        <input type="text" class="form-control" id="text" name="state" value="<?php echo $state; ?>">
                    </div>
                    <div class="form-group">
                        <label for="text">Post Code</label>
                        <input type="text" class="form-control" id="text" name="userPostCode" value="<?php echo $postcode; ?>">
                    </div>

                </div>
                <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6 pull-right">
                                <button type="button" onclick="update_profile();"  class="pull-right btn btn-sm btn-success">Update</button>
                            </div>                                    
                        </div>
                    </div>
                
            </form>
        </div>

    </div>


</section>
