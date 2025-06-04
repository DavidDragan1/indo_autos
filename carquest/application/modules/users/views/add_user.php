<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Register New  User</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL;  ?>"><i class="fa fa-dashboard"></i> Admin </a></li>        
        <li class="active">User list</li>
    </ol>
</section>

<section class="content"> 
<div class="box box-primary">

    <div class="panel-body user_profile_form">
        <div id="success_report"></div>
        
        <form action="<?php echo Backend_URL; ?>users/create_action" method="post" id="user_form" class="form-horizontal">
                                                           
            
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="role_id" class="col-sm-3 control-label">Role<sup>*</sup>: </label>
                        <div class="col-sm-9">
                            <select name="role_id" class="form-control" id="role_id">
                                <?php echo Users_helper::getDropDownRoleName( 6 ); ?>
                            </select>
                        </div>
                    </div>
                     
                    <div class="form-group">
                        <label for="first_name" class="col-sm-3 control-label">First Name<sup>*</sup>: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" />

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-sm-3 control-label">Last Name<sup>*</sup>:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" />
                        </div> 
                    </div>
                    <div class="form-group" >
                        <label for="your_email" class="col-sm-3 control-label">Email<sup>*</sup>:</label>
                        <div class="col-sm-9"> <input autocomplete="off" type="text" class="form-control" name="your_email" id="your_email" placeholder="Valid & Unique  Email Address" />
                        </div>   
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password<sup>*</sup>:</label>
                        <div class="col-sm-9">
                            <input type="password" autocomplete="off" class="form-control" name="password" id="password" placeholder="Password" />
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="contact" class="col-sm-3 control-label">Contact Number 01 :</label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="contact" id="contact" placeholder="Contact Number"/>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="contact1" class="col-sm-3 control-label">Contact Number 02 :</label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="contact1" id="contact1" placeholder="Contact Number"/>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="contact2" class="col-sm-3 control-label">Contact Number 03 :</label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="contact2" id="contact2" placeholder="Contact Number"/>
                        </div> 
                    </div>
                    

                </div>
                
                
                
                <div class="col-md-6 col-sm-6 col-xs-12">
                    
                    <div class="form-group" >
                        <label class="col-sm-3 control-label" for="dob">Date of Birth :</label>
                        <div class="col-sm-9">
                            <div class="" >
                                <div class="col-md-3 no-padding"><select id="dob" name="dd" class="form-control"><option>DD</option><?php echo numericDropDown(1,31,1,0); ?></select></div>
                                <div class="col-md-3 no-padding"><select  name="mm" class="form-control"><option>MM</option><?php echo numericDropDown(1,12,1,0); ?></select></div>
                                <div class="col-md-3 no-padding"><select  name="yy" class="form-control"><option>YYYY</option><?php echo numericDropDown( date( 'Y', strtotime('-50 years')), date('Y'),1,0); ?></select></div>                                                                                                                        
                            </div>                                                             
                        </div>
                    </div>
                   
                    
                    <div class="form-group">
                        <label for="add_line1" class="col-sm-3 control-label">Address Line1 :</label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="add_line1" id="add_line1" placeholder="Address Line1" />
                        </div>   
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="add_line2" class="col-sm-3 control-label">Address Line2 :</label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="add_line2" id="add_line2" placeholder="Address Line2" />
                        </div>   
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="city" class="col-sm-3 control-label">City :</label>
                        <div class="col-sm-9"> <input type="text" class="form-control" name="city" id="city" placeholder="City" />
                        </div>  </div>
                    <div class="form-group">
                        <label for="state" class="col-sm-3 control-label">State :</label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="state" id="state" placeholder="State" />
                        </div>  </div>
                    <div class="form-group">
                        <label for="postcode" class="col-sm-3 control-label">Postcode :</label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="postcode" id="postcode" placeholder="Postcode"  />
                        </div>  </div>
                    <div class="form-group">
                        <label for="country_id" class="col-sm-3 control-label">Country :</label>
                        <div class="col-sm-9">
                            <select name="country_id" class="form-control" id="country_id">
                                <?php echo getDropDownCountries($country_id); ?>
                            </select>
                        </div>
                    </div>

                     
                    <div class="form-group">
                        <label for="status" class="col-sm-3 control-label">Status :<?php echo form_error('status') ?></label>
                        <div class="col-sm-5"><select name="status" class="form-control" id="status">
                                <?php echo userStatus($status) ?>
                            </select>
                        </div>  
                    </div>
                </div>
            </div>


                                     
            <a href="<?php echo site_url( Backend_URL . 'users') ?>" class="btn btn-default"><i class="fa fa-long-arrow-left" ></i> Cancel & Back to List</a>
            <button type="submit" class="btn btn-primary">Register & Continue Update <i class="fa fa-long-arrow-right" ></i> </button> 
        </form>
    </div>

</div>

</section>


<script type="text/javascript">
 
    $(document).ready(function (e) {
        $("#user_form").on('submit', (function (e) {
            e.preventDefault();
            var formData = $('#user_form').serialize();
         
            var error = 0;

            var first_name = $('[name=first_name]').val();
            if (!first_name) {
                $('[name=first_name]').addClass('required');
                error = 1;
            } else {
                $('[name=first_name]').addClass('required_pass');
            }

            var last_name = $('[name=last_name]').val();
            if (!last_name) {
                $('[name=last_name]').addClass('required');
                error = 1;
            } else {
                $('[name=last_name]').addClass('required_pass');
            }

            var your_email = $('[name=your_email]').val();
            if (!your_email) {
                $('[name=your_email]').addClass('required');
                error = 1;
            } else {
                $('[name=your_email]').addClass('required_pass');
            }

            var password = $('[name=password]').val();
            if (!password) {
                $('[name=password]').addClass('required');
                error = 1;
            } else {
                $('[name=password]').addClass('required_pass');
            }



            if (!error) {
                $.ajax({
                    url: "<?php echo Backend_URL; ?>users/create_action",
                    type: "POST", 
                    dataType: "json", 
                    data: formData,                    
                    cache: false,                    
                    beforeSend: function () {
                        $('#success_report').html('<p class="ajax_processing"> Loading...</p>').css('display','block');
                    },
                    success: function (jsonRespond) {
                        if(jsonRespond.Status === 'OK'){
                           
                            $('#success_report').html( jsonRespond.Msg );
                            document.getElementById("user_form").reset();
                            setTimeout(function () {
                                $('#success_report').slideUp('slow');                           
                            }, 4000); 
                        } else {
                            $('#success_report').html( jsonRespond.Msg );
                        }
                        
                                                                                                                   
                    }


                });
            }
        }));

         

       
         
    });




</script>