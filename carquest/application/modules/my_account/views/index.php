<style type="text/css">
    .tiles .tile {
        padding: 12px 20px;
        background-color: #f8f8f8;
        border-right: 1px solid #ccc;
    }
    .tiles .tile a {
        text-decoration: none;
    }
    .start:hover{
        text-decoration: none;
    }
    .tile .icon {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 48px;
        line-height: 1;
        color: #ccc;
    }
    .tile .stat {
        margin-top: 20px;
        font-size: 40px;
        line-height: 1;
    }
    .tile .title {
        font-weight: bold;
        color: #888;
        text-transform: uppercase;
        font-size: 12px;
    }
    .tiles .tile .highlight {
        margin-top: 4px;
        height: 2px;
        border-radius: 2px;
    }
    .bg-color-blue {
        background-color: #5bc0de;
        height: 3px;
        margin-top: 13px;
    }
    .bg-color-red {
        background-color: red;
        height: 3px;
        margin-top: 13px;
    }
    .bg-color-green {
        background-color: green;
        height: 3px;
        margin-top: 13px;
    }
    .bg-one{
        background-color: #F5F5F5;
        border-right: 1px solid #999;
        padding: 20px;
    }
    .bg-two{
        background-color: #F5F5F5;
        border-right: 1px solid #999;
        padding: 20px;
    }
    .bg-three{
        background-color: #F5F5F5;
        padding: 20px;
    }
</style>


<?php load_module_asset('my_account', 'css' );?>  
<div class="my_account">
    <div class="container">
        <div class="col-md-12">
            <h1>&nbsp;</h1>
        </div>
        <div class="row">
             
                <div class="col-md-3">                    
                    <?php echo Modules::run('my_account/menu');?>
                </div>

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="col-md-12">
                        
                        <h1><small>Welcome Back, </small> <?php echo getLoginUserData('name'); ?> <small style="float: right; font-size: 16px;">You login as <?php echo getRoleName( getLoginUserData('role_id') ); ?></small> </h1>
                    <hr/>
                    </div>
                    <div class="panel-body">
                        <div class="row" style="padding:40px 20px;">
                            <div class="col-md-4 tile bg-one">
                                <a href="my_account?tab=mails" style="text-decoration: none">
                                    <div class="icon"><i class="fa fa-inbox"></i></div>
                                    <div class="stat"><?php echo count_my_mails(); ?></div>
                                    <div class="title">Inbox</div>
                                    <div class="highlight bg-color-blue"></div>
                                </a>
                            </div>
                            <div class="col-md-4 tile bg-two">
                                <a href="my_account?tab=mails" style="text-decoration: none">
                                    <div class="icon"><i class="fa fa-envelope"></i></div>
                                    <div class="stat"><?php echo unread_mails(); ?></div>
                                    <div class="title">Unread Message</div>
                                    <div class="highlight bg-color-red"></div>
                                </a>
                            </div>
                            <div class="col-md-4 tile bg-three">
                                <a href="my_account?tab=mails&type=sent" style="text-decoration: none">
                                    <div class="icon"><i class="fa fa-send"></i></div>
                                    <div class="stat"><?php echo total_send_mails(); ?></div>
                                    <div class="title">Total Sent Mail</div>
                                    <div class="highlight bg-color-green"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</div>

<?php load_module_asset('my_account', 'js' );?>