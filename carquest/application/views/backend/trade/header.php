<!DOCTYPE html>
<html>

<head>
    <base href="<?php echo base_url(); ?>"/>
    <link rel="icon" href="assets/new-theme/images/favicon.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" href="assets/new-theme/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="assets/new-theme/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/new-theme/css/magnific-popup.css" />
    <link rel="stylesheet" href="assets/new-theme/css/slick.css" />
    <link rel="stylesheet" href="assets/new-theme/css/default.css?t=<?php echo time(); ?>" />
    <link rel="stylesheet" href="assets/new-theme/css/intlTelInput.min.css">
    <link rel="stylesheet" href="assets/new-theme/css/jquery.scrollbar.css">
    <link rel="stylesheet" href="assets/new-theme/css/dataTables.min.css">
    <link rel="stylesheet" href="assets/new-theme/css/material-grid.css">
    <link rel="stylesheet" href="assets/new-theme/css/theme.css?t=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/new-theme/css/admin/style.css?t=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="assets/new-theme/css/select2.min.css">
    <link rel="stylesheet" href="assets/new-theme/css/splide.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <script type="text/javascript" src="assets/new-theme/js/jquery-3.2.1.min.js?t=<?php echo time(); ?>"></script>
    <script type="text/javascript" src="assets/new-theme/js/select2.min.js?t=<?php echo time(); ?>"></script>
</head>

<body class="bg-grey">
<?php
$background = '';
if (!empty($this->session->flashdata('status'))) {
    $background = 'bottom: auto; top: 5px;visibility: visible;opacity: 1; background: ';
    if ($this->session->flashdata('status') == 'success') $background .= 'rgb(76, 175, 80)';
    else $background .= 'rgb(244, 67, 54)';
}
    ?>
<div class="tostfyMessage" style="<?=$background?>">
    <span class="tostfyClose">&times;</span>
    <div class="messageValue"><?=$this->session->flashdata('message')?></div>
</div>
<div class="backdrop-body-admin"></div>
<div class="admin-container d-flex flex-wrap">
    <!-- sidemenu area  -->
    <?php require_once 'sidebar.php'?>
    <!-- sidemenu area  -->
    <div class="main-container">
        <!-- header area  -->
        <header class="header-area d-flex flex-wrap align-items-center justify-content-between mb-25">
            <div class="flex-wrap d-flex align-items-center">
                    <span class="material-icons d-lg-none d-block responsive-menu-admin">
                        menu
                    </span>
                <?php
                $ci = &get_instance();
                if (checkPermission('posts/create',getLoginUserData('role_id')) && $ci->uri->uri_string() != 'admin/posts/create' && getLoginUserData('role_id') != 6) {
                    ?>
                    <ul class="saler-btns">
                        <li>
                            <a class="btnStyle waves-effect" href="admin/posts/create">
                                Post New Advert
                            </a>
                        </li>
                        <?php if (getLoginUserData('role_id') == 4):?>
                        <!-- <li>
                            <span>
                                <img src="assets/new-theme/images/icons/loan.svg" alt="logo"> Need a business loan?
                            </span>
                            <a target="_blank" class="btnStyle btn-link waves-effect" href="https://docs.google.com/forms/d/e/1FAIpQLSeAZPtYr3SWrY8ESndb5T0dtwKlet3w_gGQmMECSHs2XlhwhQ/viewform">
                                Apply for Business Loan
                            </a>
                        </li> -->
                        <?php endif; ?>
                    </ul>
                <?php } elseif (getLoginUserData('role_id') == 6) {?>
                    <div class="dropdown-switch-wrap">
                        <span class="label"><img src="assets/new-theme/images/icons/switch.svg" alt=""> Want to Start Selling ? Switch Account !</span>
                        <select name="" id="switchRoleDropdown" class="browser-default">
                            <?php echo getRoleSwitchDropdown(); ?>
                        </select>
                    </div>
                    <script>
                        $("#switchRoleDropdown").change(function () {
                            $('.get_value').text($(this).find("option:selected").text() + " ?");
                            $("#newRole").val($(this).val());
                            $("#checkEligibilityModal").modal('open');
                        });
                    </script>
                <?php } ?>

                <?php if (checkPermission('clearing/product_create',getLoginUserData('role_id')) && $ci->uri->uri_string() != 'admin/clearing/product_create') {
                    ?>
                    <a class="btnStyle waves-effect ml-10" href="admin/clearing/product_create">
                        Add Products
                    </a>
                <?php } ?>
                <?php if (checkPermission('verifier/product_add',getLoginUserData('role_id'))) {
                    ?>
                    <a class="btnStyle waves-effect ml-10" href="admin/verifier/product_add">
                        Add Products
                    </a>
                <?php } ?>
                <?php if (checkPermission('verifier/manage_product',getLoginUserData('role_id'))) {
                    ?>
                    <a class="btnStyle waves-effect ml-10" href="admin/verifier/manage_product">
                        Manage Product
                    </a>
                <?php } ?>
                <?php if (checkPermission('clearing/product',getLoginUserData('role_id')) && $ci->uri->uri_string() != 'admin/clearing/product') {
                    ?>
                    <a class="btnStyle waves-effect ml-10" href="admin/clearing/product">
                        Manage Products
                    </a>
                <?php } ?>
                <?php if (checkPermission('verifier/availability',getLoginUserData('role_id'))) {
                    ?>
                    <a class="btnStyle waves-effect ml-10" href="admin/verifier/availability">
                        Availability
                    </a>
                <?php } ?>


                <?php if (checkPermission('shipping/product_create',getLoginUserData('role_id')) && $ci->uri->uri_string() != 'admin/shipping/product_create') {
                    ?>
                    <a class="btnStyle waves-effect ml-10" href="admin/shipping/product_create">
                        Add Products
                    </a>
                <?php } ?>

                <?php if (checkPermission('shipping/product',getLoginUserData('role_id')) && $ci->uri->uri_string() != 'admin/shipping/product') {
                    ?>
                    <a class="btnStyle waves-effect ml-10" href="admin/shipping/product">
                        Manage Products
                    </a>
                <?php } ?>

            </div>
            <?php
            $get_logged_company_info = get_logged_company_info();
            ?>
            <div class="profile-view dropdown-profile d-flex align-items-center  justify-content-sm-end" data-target="dropdown">
                <?php if (getLoginUserData('role_id') == 4): ?>
                <?=GlobalHelper::getSellrCompanyPhoto(@$get_logged_company_info->profile_photo, @$get_logged_company_info->post_title, 'obj-cover br-5')?>
                <?php else: ?>
                <?=GlobalHelper::getUserPhoto(@$get_logged_company_info->profile_photo, @$get_logged_company_info->post_title, 'obj-cover br-5')?>
                <?php endif; ?>
                <div class="content">
                    <p><?=@$get_logged_company_info->post_title?></p>
                    <span><?=getRoleName(getLoginUserData('role_id'))?></span>
                </div>
                <span class="material-icons">arrow_drop_down</span>
                <ul class="dropdown-content" id="dropdown">
                    <?php if (checkPermission('profile',getLoginUserData('role_id'))) {?>
                        <li><a href="admin/profile">My Profile</a></li>
                    <?php } ?>
                    <?php if (checkPermission('profile/password',getLoginUserData('role_id'))) {?>
                        <li><a href="admin/profile/password">Change Password</a></li>
                    <?php } ?>
                    <li><a href="<?=base_url(); ?>">Go to Public Page</a></li>
                    <li><a href="auth/logout">Log out</a></li>
                </ul>
            </div>
        </header>
        <header class="responsive-header-area">
            <div class="container">
                <div class="responsive-header">
                    <a href="<?php echo base_url();?>" class="logo">
                        <img src="assets/new-theme/images/car-logo.svg" alt="logo">
                    </a>
                    <?php
                    $get_logged_company_info = get_logged_company_info();
                    ?>
                    <div class="profile-view dropdown-profile d-flex align-items-center  justify-content-sm-end" data-target="dropdown1">
                        <?php if (getLoginUserData('role_id') == 4): ?>
                        <?=GlobalHelper::getSellrCompanyPhoto(@$get_logged_company_info->profile_photo, @$get_logged_company_info->post_title, 'obj-cover br-5')?>
                        <?php else: ?>
                        <?=GlobalHelper::getUserPhoto(@$get_logged_company_info->profile_photo, @$get_logged_company_info->post_title, 'obj-cover br-5')?>
                        <?php endif; ?>
                        <div class="content">
                            <p><?=@$get_logged_company_info->post_title?></p>
                            <span><?=getRoleName(getLoginUserData('role_id'))?></span>
                        </div>
                        <span class="material-icons">arrow_drop_down</span>
                        <ul class="dropdown-content" id="dropdown1">
                            <?php if (checkPermission('profile',getLoginUserData('role_id'))) {?>
                                <li><a href="admin/profile">My Profile</a></li>
                            <?php } ?>
                            <?php if (checkPermission('profile/password',getLoginUserData('role_id'))) {?>
                                <li><a href="admin/profile/password">Change Password</a></li>
                            <?php } ?>
                            <li><a href="<?=base_url(); ?>">Go to Public Page</a></li>
                            <li><a href="auth/logout">Log out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <div class="flex-wrap d-flex d-lg-none align-items-center mb-20">
            <?php
            $ci = &get_instance();
            if (checkPermission('posts/create',getLoginUserData('role_id')) && $ci->uri->uri_string() != 'admin/posts/create' && getLoginUserData('role_id') != 6) {
                ?>
                <ul class="saler-btns">
                    <li>
                        <a class="btnStyle waves-effect" href="admin/posts/create">
                            Post New Advert
                        </a>
                    </li>
                    <?php if (getLoginUserData('role_id') == 4):?>
                        <li>
                            <a target="_blank" class="btnStyle btn-link waves-effect" href="https://docs.google.com/forms/d/e/1FAIpQLSeAZPtYr3SWrY8ESndb5T0dtwKlet3w_gGQmMECSHs2XlhwhQ/viewform">
                                Apply for Business Loan
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php } elseif (getLoginUserData('role_id') == 6) {?>
                <div class="dropdown-switch-wrap">
                    <span class="label"><img src="assets/new-theme/images/icons/switch.svg" alt=""> Switch Account:</span>
                    <select name="" id="switchRoleDropdownMobile" class="browser-default">
                        <?php echo getRoleSwitchDropdown(); ?>
                    </select>
                </div>

                <script>
                    $("#switchRoleDropdownMobile").change(function () {
                        $('.get_value').text($(this).find("option:selected").text() + " ?");
                        $("#newRole").val($(this).val());
                        $("#checkEligibilityModal").modal('open');
                    });
                </script>
            <?php } ?>

            <?php if (checkPermission('clearing/product_create',getLoginUserData('role_id')) && $ci->uri->uri_string() != 'admin/clearing/product_create') {
                ?>
                <a class="btnStyle waves-effect ml-10" href="admin/clearing/product_create">
                    Add Products
                </a>
            <?php } ?>
            <?php if (checkPermission('verifier/product_add',getLoginUserData('role_id'))) {
                ?>
                <a class="btnStyle waves-effect ml-10" href="admin/verifier/product_add">
                    Add Products
                </a>
            <?php } ?>
            <?php if (checkPermission('verifier/manage_product',getLoginUserData('role_id'))) {
                ?>
                <a class="btnStyle waves-effect ml-10" href="admin/verifier/manage_product">
                    Manage Product
                </a>
            <?php } ?>
            <?php if (checkPermission('clearing/product',getLoginUserData('role_id')) && $ci->uri->uri_string() != 'admin/clearing/product') {
                ?>
                <a class="btnStyle waves-effect ml-10" href="admin/clearing/product">
                    Manage Products
                </a>
            <?php } ?>
            <?php if (checkPermission('verifier/availability',getLoginUserData('role_id'))) {
                ?>
                <a class="btnStyle waves-effect ml-10" href="admin/verifier/availability">
                    Availability
                </a>
            <?php } ?>


            <?php if (checkPermission('shipping/product_create',getLoginUserData('role_id')) && $ci->uri->uri_string() != 'admin/shipping/product_create') {
                ?>
                <a class="btnStyle waves-effect ml-10" href="admin/shipping/product_create">
                    Add Products
                </a>
            <?php } ?>

            <?php if (checkPermission('shipping/product',getLoginUserData('role_id')) && $ci->uri->uri_string() != 'admin/shipping/product') {
                ?>
                <a class="btnStyle waves-effect ml-10" href="admin/shipping/product">
                    Manage Products
                </a>
            <?php } ?>

        </div>
        <!-- header area  -->
<?php if (checkPermission('clearing/product_create',getLoginUserData('role_id')) && $ci->uri->uri_string() != 'admin/clearing/product_create') {
        ?>
    <a class="add-product-btn waves-effect" href="admin/clearing/product_create">
        Add Products
    </a>
<?php } ?>

        <?php
        $role_id = getLoginUserData('role_id');
        $user_id = getLoginUserData('user_id');
        $ci =& get_instance();
        $unreadChat = $ci->db->select('id') ->get_where('message', ['receiver ' => $user_id, 'read_status' => '0'])->num_rows();
        $totalReview = $ci->db->select('id') ->get_where('reviews', ['vendor_id ' => $user_id, 'status' => 'Approve'])->num_rows();
        $verifierRequest = 0;
        if($role_id == 17){
            $verifierRequest = $ci->db->select('id') ->get_where('verifier_requests', ['is_read'=>0,'user_id'=>$user_id])->num_rows();
        }

        ?>
<div class="footer-sticky-menu-wrap">
    <ul class="footer-sticky-menu">
        <?php
        $role_id = getLoginUserData('role_id');
        $user_id = getLoginUserData('user_id');
        $active_url = $ci->uri->segment( 2 );
        if ($role_id != 6 || $role_id != 9) {
        if($active_url == "") {
            $class = "active";
        } else {
            $class = "";
        }
        ?>
        <li>
            <a class="active" href="admin">
                <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 11.1111H8.88889V0H0V11.1111ZM0 20H8.88889V13.3333H0V20ZM11.1111 20H20V8.88889H11.1111V20ZM11.1111 0V6.66667H20V0H11.1111Z" fill="#F05C26"/>
                </svg>
                <span>Dashboard</span>
            </a>
        </li>
        <?php } ?>
        <?=add_responsive_menu_trade('Chatbox', 'admin/chat', 'chat')?>
        <?=add_responsive_menu_trade('Inbox', 'admin/mails', 'mails')?>
        <?=add_responsive_menu_trade('Reviews', 'admin/reviews', 'reviews')?>
        <li>
            <span class="quicklink">
                <svg class="icon" viewBox="0 0 16 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 0C0.9 0 0 0.9 0 2C0 3.1 0.9 4 2 4C3.1 4 4 3.1 4 2C4 0.9 3.1 0 2 0ZM14 0C12.9 0 12 0.9 12 2C12 3.1 12.9 4 14 4C15.1 4 16 3.1 16 2C16 0.9 15.1 0 14 0ZM8 0C6.9 0 6 0.9 6 2C6 3.1 6.9 4 8 4C9.1 4 10 3.1 10 2C10 0.9 9.1 0 8 0Z"
                          fill="#666666"/>
                </svg>

                <span>More</span>
            </span>
        </li>
    </ul>
</div>
<ul class="quickmenu-wrapper">
    <?=add_main_menu_trade('Products', 'admin/posts', 'posts', 'work')?>
    <?=add_main_menu_trade('Request', 'admin/clearing/request', 'clearing/request', 'work')?>
    <?=add_main_menu_trade('Request', 'admin/shipping/request', 'shipping/request', 'work')?>
    <?=add_main_menu_trade('Request', 'admin/verifier/all_request', 'verifier/all_request', 'work',$verifierRequest)?>
    <?=Modules::run('mails/newSidebarMenusTrade');?>
    <?=add_main_menu_trade('Chatbox', 'admin/chat', 'chat', 'chat', $unreadChat)?>
    <?=add_main_menu_trade('Reviews', 'admin/reviews', 'reviews', 'remove_red_eye', $totalReview)?>
</ul>


<div id="checkEligibilityModal" class="modal modal-wrapper">
    <span class="material-icons modal-close">close</span>
    <div class="eligibility-modal-wrap">
        <div id="eligibility_modal_data">
            <form class="eligibility-wrap switch-wrapper" action="<?=base_url()?>admin/profile/switch-account-type" method="post">
                <div id="checkEligibilityData">
                    <img src="assets/new-theme/images/icons/info2.svg" alt="">
                    <h3 class="title">Are you sure you want to switch your account to <span class="get_value">Trade seller ?</span></h3>
                    <div class="warning-wrap">
                        <h4 class="label">Warning</h4>
                        <p>The change of account type cannot be reversed and may affect access. Be aware of the consequences before proceeding, as it is not possible to return to the current account type</p>
                    </div>
                    <input type="hidden" name="role" id="newRole">
                </div>
                <ul class="eligibility-modal-btn">
                    <li>
                        <button type="button" class="btnStyle btnStyleOutline modal-close">Cancel</button>
                    </li>
                    <li>
                        <button type="submit" class="btnStyle">Confirm</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>
