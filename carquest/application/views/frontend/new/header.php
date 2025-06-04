<!DOCTYPE html>
<html>

<head>
    <base href="<?php echo base_url(); ?>"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" href="assets/new-theme/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="assets/new-theme/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/new-theme/css/magnific-popup.css" />
    <link rel="stylesheet" href="assets/new-theme/css/slick.css" />
    <link rel="stylesheet" href="assets/new-theme/css/default.css" />
    <link rel="stylesheet" href="assets/new-theme/css/intlTelInput.min.css">
    <link rel="stylesheet" href="assets/new-theme/css/jquery.scrollbar.css">
    <link rel="stylesheet" href="assets/new-theme/css/material-grid.css">
    <link rel="stylesheet" href="assets/new-theme/css/select2.min.css">
    <link rel="stylesheet" href="assets/new-theme/css/theme.css" />
    <link rel="stylesheet" href="assets/new-theme/css/style.css?t=<?=time()?>" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-83128659-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-83128659-1');
        var socket_receiver_online = 0;
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php
            echo isset($meta_title) ? $meta_title : 'Auction Cars Online | Vehicle Auction';
        ?>
    </title>
    <meta name="description" content="<?php  echo isset($meta_description) ? $meta_description: 'Online Car & Vehicle Auctions Buy salvage vehicles, repairable vehicles, used cars online in our online auction.'; ?>" />
    <meta name="keywords" content="<?php  echo isset($meta_keywords) ? $meta_keywords: ''; ?>" />
    <meta name="author" content="Jimi">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <meta name="apple-itunes-app" content="app-id=0000">
    <meta name="google-play-app" content="">

    <link rel="icon" href="assets/new-theme/images/favicon.png" sizes="20x20">
    <script type="text/javascript" src="assets/new-theme/js/jquery-3.2.1.min.js"></script>
    <script src="assets/new-theme/js/select2.min.js"></script>

</head>
<?php
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);
?>
<body class="pt-75">
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
<div class="backdrop-body"></div>


<header class="header-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-2 col-lg-3 col-6">
                <div class="d-flex align-items-center">
                    <a class="logo" href="<?php echo base_url(); ?>">

                        <img src="assets/new-theme/images/car-logo.svg" alt="">
                    </a>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6 d-none d-lg-block">
                <ul class="mainmenu">
                    <li class="<?=$segment1 == 'buy' ? 'active' : ''?>"><span>Buy <i class="fa fa-angle-down"></i></span>
                        <ul class="dropdown-menu">
                            <li class="<?=$segment1 == 'buy' && $segment2 == 'car' ? 'active' : ''?>"><a class="waves-effect" href="buy/car">Car</a></li>
                            <li class="<?=$segment1 == 'buy' && $segment2 == 'motorbike' ? 'active' : ''?>"><a class="waves-effect" href="buy/motorbike">Motorbike</a></li>
                            <li class="<?=$segment1 == 'buy' && $segment2 == 'spare-parts' ? 'active' : ''?>"><a class="waves-effect" href="buy/spare-parts">Spare Parts</a></li>
                        </ul>
                    </li>
                    <li><span>Sell <i class="fa fa-angle-down"></i></span>
                        <ul class="dropdown-menu">
                            <li class=""><a class="waves-effect " href="admin/posts/create?post_type=car">Car</a></li>
                            <li><a class="waves-effect" href="admin/posts/create?post_type=motorbike">Motorbike</a></li>
                            <li><a class="waves-effect" href="admin/posts/create?post_type=spare-parts">Spare Parts</a></li>
                        </ul>
                    </li>

                    <li><span>Import<i class="fa fa-angle-down"></i></span>
                        <ul class="dropdown-menu">
                            <li class="<?=$segment1 == 'buy-import' && $segment2 == 'car' ? 'active' : ''?>"><a class="waves-effect" href="buy-import/car">Car</a></li>
                            <li class="<?=$segment1 == 'buy-import' && $segment2 == 'motorbike' ? 'active' : ''?>"><a class="waves-effect" href="buy-import/motorbike">Motorbike</a></li>
                            <li class="<?=$segment1 == 'buy-import' && $segment2 == 'spare-parts' ? 'active' : ''?>"><a class="waves-effect" href="buy-import/spare-parts">Spare Parts</a></li>
                        </ul>
                    </li>
                    <li><span>Compare <i class="fa fa-angle-down"></i></span>
                        <ul class="dropdown-menu">
                            <li><a class="waves-effect" href="post/compare?vehicle=car">Vehicle</a></li>
                        </ul>
                    </li>
                    <li><span>Other <i class="fa fa-angle-down"></i></span>
                        <ul class="dropdown-menu">
                            <li <?php if((isset($page_active) && $page_active=='car-valuation')) echo 'class="active"';?>><a class="waves-effect" href="car-valuation">Car Valuation</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-6">
                <?php if (!empty(getLoginUserData('user_id'))): ?>
                    <?php
                    $get_logged_company_info = get_logged_company_info();
                    ?>
                    <ul class="short-profile-list">
                        <li><a class="d-flex align-items-center" href="favourite/car"><span class="material-icons">
                                    favorite
                                </span></a></li>
                        <li>
                            <a class="d-flex align-items-center profile-trigger" href='javascript:void(0)'>
                                <?php if (getLoginUserData('role_id') == 4): ?>
                                    <?=GlobalHelper::getSellrCompanyPhoto(@$get_logged_company_info->profile_photo, @$get_logged_company_info->post_title, 'obj-cover br-5')?>
                                <?php else: ?>
                                    <?=GlobalHelper::getUserPhoto(@$get_logged_company_info->profile_photo, @$get_logged_company_info->post_title, 'obj-cover br-5')?>
                                <?php endif; ?>
                                <?=@$get_logged_company_info->post_title?>
                            </a>

                            <ul class='profile-dropdown'>
                                <li><a href="admin">Dashboard</a></li>
                                <li><a href="auth/logout">Log Out</a></li>
                            </ul>
                        </li>
                        <li class="search-trigger">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23.6736 20.7495L18.9998 16.0766C18.7889 15.8656 18.5029 15.7485 18.2029 15.7485H17.4388C18.7326 14.0939 19.5014 12.0129 19.5014 9.74905C19.5014 4.36364 15.137 0 9.75071 0C4.36438 0 0 4.36364 0 9.74905C0 15.1345 4.36438 19.4981 9.75071 19.4981C12.0149 19.4981 14.0963 18.7294 15.7512 17.4358V18.1998C15.7512 18.4998 15.8683 18.7857 16.0793 18.9966L20.7531 23.6696C21.1937 24.1101 21.9063 24.1101 22.3423 23.6696L23.6689 22.3431C24.1096 21.9025 24.1096 21.1901 23.6736 20.7495ZM9.75071 15.7485C6.43641 15.7485 3.75027 13.0675 3.75027 9.74905C3.75027 6.43531 6.43172 3.74963 9.75071 3.74963C13.065 3.74963 15.7512 6.43062 15.7512 9.74905C15.7512 13.0628 13.0697 15.7485 9.75071 15.7485Z" fill="#D01818"/>
                            </svg>
                        </li>
                    </ul>
                <?php else: ?>

                    <ul class="login-signup">
                        <li><a href="my-account">Log in</a></li>
                        <li><a class="waves-effect signup" href="my-account?mode=signup">Sign up</a></li>
                        <li class="search-trigger">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23.6736 20.7495L18.9998 16.0766C18.7889 15.8656 18.5029 15.7485 18.2029 15.7485H17.4388C18.7326 14.0939 19.5014 12.0129 19.5014 9.74905C19.5014 4.36364 15.137 0 9.75071 0C4.36438 0 0 4.36364 0 9.74905C0 15.1345 4.36438 19.4981 9.75071 19.4981C12.0149 19.4981 14.0963 18.7294 15.7512 17.4358V18.1998C15.7512 18.4998 15.8683 18.7857 16.0793 18.9966L20.7531 23.6696C21.1937 24.1101 21.9063 24.1101 22.3423 23.6696L23.6689 22.3431C24.1096 21.9025 24.1096 21.1901 23.6736 20.7495ZM9.75071 15.7485C6.43641 15.7485 3.75027 13.0675 3.75027 9.74905C3.75027 6.43531 6.43172 3.74963 9.75071 3.74963C13.065 3.74963 15.7512 6.43062 15.7512 9.74905C15.7512 13.0628 13.0697 15.7485 9.75071 15.7485Z" fill="#D01818"/>
                            </svg>
                        </li>
                    </ul>

                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="header-search">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <form action="buy/car/search" method="get">
                        <input name="global_search"  type="text" required
                               placeholder="Search Make, Model, Location" class="browser-default">
                        <button>
                            <svg width="20" height="26" viewBox="0 0 20 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="9.12701" cy="8.79893" r="6.04821" transform="rotate(-11.3482 9.12701 8.79893)" stroke="#0E538C" stroke-width="2"/>
                                <path d="M13.1795 15.7889L17.5692 22.9679" stroke="#0E538C" stroke-width="2"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="category-menu-area">
    <div class="container">
        <div class="category-wrapper">
            <ul class="responsive-category-menu">
                <?php if ($segment1 == 'buy') {?>
                <li class="<?=$segment1 == 'buy' && $segment2 == 'car' ? 'active' : ''?>"><a class="waves-effect" href="buy/car">Car</a></li>
                <li class="<?=$segment1 == 'buy' && $segment2 == 'motorbike' ? 'active' : ''?>"><a class="waves-effect" href="buy/motorbike">Motorbike</a></li>
                <li class="<?=$segment1 == 'buy' && $segment2 == 'spare-parts' ? 'active' : ''?>"><a class="waves-effect" href="buy/spare-parts">Spare Parts</a></li>
                <?php } elseif (in_array($segment1, ['mechanic','hire-mobile-mechanic','drivers','hire-shipping-agent','hire-clearing-agent','hire-verifier'])) {?>
                <?php } ?>
            </ul>
            
        </div>
    </div>
</div>

<div class="footer-sticky-menu-wrap">
    <ul class="footer-sticky-menu">
        <li>
            <a class="<?=empty($segment1) ? 'active' : ''?>" href="<?php echo base_url(); ?>">
                <svg class="icon" width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 17V11H12V17H17V9H20L10 0L0 9H3V17H8Z" fill="#F05C26"/>
                </svg>
                <span>Home</span>
            </a>
        </li>

        <li>
            <a class="<?=$segment1 == 'buy' ? 'active' : ''?>" href="buy/car">
                <svg class="icon" width="22" height="12" viewBox="0 0 22 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 4H11.65C10.83 1.67 8.61 0 6 0C2.69 0 0 2.69 0 6C0 9.31 2.69 12 6 12C8.61 12 10.83 10.33 11.65 8H12L14 10L16 8L18 10L22 5.96L20 4ZM6 9C4.35 9 3 7.65 3 6C3 4.35 4.35 3 6 3C7.65 3 9 4.35 9 6C9 7.65 7.65 9 6 9Z" fill="#011A39"/>
                </svg>
                <span>Buy</span>
            </a>
        </li>
        <li>
            <a class="" href="admin/posts/create?post_type=car">
                <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 16C4.9 16 4.01 16.9 4.01 18C4.01 19.1 4.9 20 6 20C7.1 20 8 19.1 8 18C8 16.9 7.1 16 6 16ZM0 0V2H2L5.6 9.59L4.25 12.04C4.09 12.32 4 12.65 4 13C4 14.1 4.9 15 6 15H18V13H6.42C6.28 13 6.17 12.89 6.17 12.75L6.2 12.63L7.1 11H14.55C15.3 11 15.96 10.59 16.3 9.97L19.88 3.48C19.96 3.34 20 3.17 20 3C20 2.45 19.55 2 19 2H4.21L3.27 0H0ZM16 16C14.9 16 14.01 16.9 14.01 18C14.01 19.1 14.9 20 16 20C17.1 20 18 19.1 18 18C18 16.9 17.1 16 16 16Z" fill="#011A39"/>
                </svg>

                <span>Sell</span>
            </a>
        </li>

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
<div class="quickmenu-wrapper">
    <div class="quick-service">

    </div>
    <h4>QUICK LINKS</h4>
    <ul class="resmainmenu">
        <li class="menu-item">
            <span class="responsive-menu">Buy </span>
            <ul class="responsive-submenu">
                <li class="<?=$segment1 == 'buy' && $segment2 == 'car' ? 'active' : ''?>"><a class="waves-effect" href="buy/car">Car</a></li>
                <li class="<?=$segment1 == 'buy' && $segment2 == 'motorbike' ? 'active' : ''?>"><a class="waves-effect" href="buy/motorbike">Motorbike</a></li>
                <li class="<?=$segment1 == 'buy' && $segment2 == 'spare-parts' ? 'active' : ''?>"><a class="waves-effect" href="buy/spare-parts">Spare Parts</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <span class="responsive-menu">Sell </span>
            <ul class="responsive-submenu">
                <li class=""><a class="waves-effect " href="admin/posts/create?post_type=car">Car</a></li>
                <li><a class="waves-effect" href="admin/posts/create?post_type=motorbike">Motorbike</a></li>
                <li><a class="waves-effect" href="admin/posts/create?post_type=spare-parts">Spare Parts</a></li>

            </ul>
        </li>

        <li class="menu-item">
            <span class="responsive-menu">Import</span>
            <ul class="responsive-submenu">
                <li class="<?=$segment1 == 'buy-import' && $segment2 == 'car' ? 'active' : ''?>"><a class="waves-effect" href="buy-import/car">Car</a></li>
                <li class="<?=$segment1 == 'buy-import' && $segment2 == 'motorbike' ? 'active' : ''?>"><a class="waves-effect" href="buy-import/motorbike">Motorbike</a></li>
                <li class="<?=$segment1 == 'buy-import' && $segment2 == 'spare-parts' ? 'active' : ''?>"><a class="waves-effect" href="buy-import/spare-parts">Spare Parts</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <span class="responsive-menu">Compare </span>
            <ul class="responsive-submenu">
                <li><a class="waves-effect" href="post/compare?vehicle=car">Vehicle</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <span class="responsive-menu">Other </span>
            <ul class="responsive-submenu">
                <li <?php if((isset($page_active) && $page_active=='car-valuation')) echo 'class="active"';?>><a class="waves-effect" href="car-valuation">Car Valuation</a></li>
            </ul>
        </li>
    </ul>
    <div class="quick-btns">
        <a class="waves-effect sale-btn" href="admin/posts/create?post_type=car">Start Selling</a>
        <ul>
            <li><a class="waves-effect login" href="my-account">Log in</a></li>
            <li><a class="waves-effect signup" href="my-account?mode=signup">Sign up</a></li>
        </ul>
    </div>
</div>
<script>
    $(document).on('click', '.quicklink', function () {
        $(this).toggleClass('active')
        $('.quickmenu-wrapper').toggleClass('active')
        $('.moremenu-area').removeClass('active');
        $('.search-area').removeClass('active');
        $('.menu-trigger').removeClass('active');
    })
    $('.moremenu, .responsive-trigger').on('click', function () {
        $('.moremenu-area').toggleClass('active');
        $('.search-area').removeClass('active');
        $('.search-btn').removeClass('active');
    })
    $(document).on('click', '.search-trigger', function () {
        $('.header-search').toggleClass('active')
    })
    $(document).on('click', '.advance-search-trigger', function () {
        $(this).toggleClass('active')
        $('.filtar-responsive-search.advance').slideToggle()
    })
    $(document).on('click', '.category-filtar,.close-filtar', function () {
        $(this).toggleClass('active')
        $('.responsive-filtar-wrap').toggleClass('active')
    })
   
</script>
