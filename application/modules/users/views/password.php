<?php load_module_asset('profile', 'css' );?>
<?php load_module_asset('profile', 'js' );?>


<section class="content-header">
    <h1>My Account<small>Change Password</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php Backend_URL ?>"><i class="fa fa-user"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL . '/users/' ?>"><i class="fa fa-dashboard"></i> Users</a></li>    
        <li class="active">Reset Password</li>
    </ol>
</section>

<section class="content">
    <?php echo Users_helper::makeTab( $this->uri->segment('4'), 'password'); ?>
    <div class="box">
       
        <div class="box-body">
            
            <div class="col-md-12">
                <div id="ajax_respond"></div>
                <form name="updatePassword" id="update_password" role="form" method="POST">
                    
                    <div class="input-group">                               
                        <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> User ID<sup>*</sup> </span>                        
                        <input type="text" readonly="readonly" name="user_id" id="user_id" class="form-control" value="<?php echo $this->uri->segment('4'); ?>">
                    </div>                          
                                         

                    <div class="input-group">
                        <span class="input-group-addon">New Password<sup>*</sup></span>
                        <input type="password" required="" name="new_pass" id="new_pass" class="form-control">                         
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">Confirm New Password<sup>*</sup></span>
                        <input type="password" required="" name="con_pass" id="con_pass"  class="form-control">                         
                    </div>
                    <div class="col-md-3 col-lg-offset-2"> 
                        <button class="btn btn-primary emform" onclick="password_change();" type="button" ><i class="fa fa-random" ></i> Update</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

<script>
    function  password_change() {
        var formData = jQuery('#update_password').serialize();
        var error = 0;
        
        

        var new_pass = jQuery('[name=new_pass]').val();
	if(!new_pass){
            jQuery('[name=new_pass]').addClass('required');
            error = 1;
	}else{
            jQuery('[name=new_pass]').removeClass('required').addClass('required_pass');
	}
        
        var con_pass = jQuery('[name=con_pass]').val();
	if(!con_pass){
            jQuery('[name=con_pass]').addClass('required');
            error = 1;
	}else{
            jQuery('[name=con_pass]').removeClass('required').addClass('required_pass');
	}
        
                                        
        if( !error ) {
            jQuery.ajax({
                url: 'admin/users/reset_password',
                type: "post",
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    jQuery('#ajax_respond')
                            .html('<p class="ajax_processing">Please Wait...</p>')
                            .css('display', 'block');
                },
                success: function (jsonRespond) {
                    if(jsonRespond.Status === 'OK'){
                        jQuery('#ajax_respond').html(jsonRespond.Msg);
                        setTimeout(function() { 
                            jQuery('#ajax_respond').slideUp('slow');
                            document.getElementById("update_password").reset();
                            jQuery('[name=new_pass]').removeClass('required_pass');
                            jQuery('[name=con_pass]').removeClass('required_pass');
                        }, 2000);
                    } else {                    
                        jQuery('#ajax_respond').html(jsonRespond.Msg);                
                    }
                }
            });
        }
        
     
     return false;
    };
</script>
