<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Folders</h3>      
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">                                    
            <li <?php isActive('inbox'); ?>><a href="admin/mails"><i class="fa fa-inbox"></i> Inbox <?php echo unread_mail(); ?> </a> </li>
            <li <?php isActive('sent'); ?>><a href="admin/mails/sent"><i class="fa fa-envelope-o"></i> Sent</a></li>                        
        </ul>
    </div>    
</div>

<?php 
$role_id = getLoginUserData('role_id');
$access = checkMenuPermission('mails/report',$role_id);

if($access){
?>

<div class="box box-solid hidden">    
    <div class="box-header with-border">
        <h3 class="box-title">Mails Types</h3>

        <div class="box-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body no-padding ">
        <ul class="nav nav-pills nav-stacked">
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> 	Contact Request</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> 	Contact to Seller</a></li>                        
            <li><a href="admin/mails"><i class="fa fa-ban"></i> Report Spam</a></li> 
        </ul>
    </div>
    <!-- /.box-body -->
</div>

<?php } ?>
<!-- /.box -->