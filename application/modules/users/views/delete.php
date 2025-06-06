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
    <?php echo Users_helper::makeTab( $this->uri->segment('4'), 'delete'); ?>
    <div class="box">
       
        <div class="box-body">
            
            <div class="col-md-12" style="min-height: 250px;">
                <p class="ajax_notice"> Page Underdevelopment </p>
                <h4><br/><b>Delete Area:</b></h4>
                <hr/>
                <ul>
                    <li>User Profile</li>
                    <li>Profile Photo</li>
                    <li>User uploaded post in DB</li>
                    <li>User uploaded post File in Folder</li>
                    <li>User mails</li>
                    <li>etc...</li>
                    
                </ul>
                
                
                
                
            </div>

        </div>
    </div>
</section> 