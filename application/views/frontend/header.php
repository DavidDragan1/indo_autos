<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-83128659-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-83128659-1');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php $c_page = $this->uri->segment(1); ?>
        <?php
        if( $c_page == 'spare-parts' ){
            $temp =  create_search_parts($c_page);
            echo $temp;
            $meta_description = $temp;
        } else if( $c_page == 'automech-search' ){
            $temp =create_search_auto($c_page);
            echo $temp;
            $meta_description = $temp;
        } else if( $c_page == 'search' || $c_page == 'motorbike'){
            $temp =create_search_tags($c_page);
            echo $temp;
            $meta_description = $temp;
        } else if( $c_page == 'towing-search'){
            $temp =create_search_towing($c_page);
            echo $temp;
            $meta_description = $temp;
        } else {
            echo isset($meta_title) ? $meta_title : 'Auction Cars Online | Vehicle Auction';
        }
        ?>
    </title>
    <meta name="description" content="<?php  echo isset($meta_description) ? $meta_description: 'Online Car & Vehicle Auctions Buy salvage vehicles, repairable vehicles, used cars online in our online auction.'; ?>" />
    <meta name="keywords" content="<?php  echo isset($meta_keywords) ? $meta_keywords: ''; ?>" />
    <meta name="author" content="Jimi">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <meta name="apple-itunes-app" content="app-id=0000">
    <meta name="google-play-app" content="app-id=com.carquest">
    <base href="<?php echo base_url(); ?>"/>
    <link rel="icon" href="assets/theme/new/images/favicon.png" sizes="20x20">
    <link rel="stylesheet" href="assets/theme/new/css/bootstrap.min.css?t=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/theme/new/css/font-awesome.min.css?t=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/theme/new/css/jquery.scrollbar.css?t=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/theme/new/css/slick.css?t=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/theme/new/css/slick-theme.css?t=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/theme/new/css/gijgo.min.css?t=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/theme/new/css/magnific-popup.css?t=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/theme/new/css/animate.min.css?t=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/theme/new/css/select2.min.css?t=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/theme/new/css/jquery.smartbanner.css?t=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/theme/new/css/style.css?t=<?php echo time(); ?>">
    <script src="assets/theme/new/js/jquery-3.4.1.min.js"></script>
</head>
<body>
<!-- <div class="preloader-wrapper">
    <img src="assets/theme/new/images/logo.png" alt="image">
</div> -->
<?php $remove = isMobileDevice(); ?>

<?php if (empty($remove)) { ?>
<!-- header-area start -->
<header class="header-area">
    <div class="header-container">
        <div class="row align-items-center">
            <div class="col-xl-2 col-sm-5 col-md-6 col-7">
                <div class="logo">
                    <a href="<?php echo base_url(); ?>">
                        <img src="assets/theme/new/images/logo.svg" alt="logo">
                    </a>
                </div>
            </div>

            <div id="responsiveMenuWrap" class="col-xl-8 responsiveMenu">
                <?php
                $page_title='';
                if(isset($cms['post_url'])){
                    $page_title=$cms['post_url'];
                }
                    require 'menu_main.php';
                ?>
            </div>
            <div class="col-xl-2 col-sm-5 col-3 col-md-5">
             
                    <?php
                    $user_id = getLoginUserData('user_id');
                    if($user_id) :
                        $user = $this->db->where('id', $user_id)->get('users')->row(); ?>
                       <div class="dropdown frontend-userProfile">
                            <span class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?=get_logged_user_photo_link()?>" class="user-image" alt="User Image">
                                <span><?php echo getLoginUserData( 'name' ) ;?></span>
                            </span>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url('admin/profile'); ?>">Profile</a></li>
                                <li><a href="<?php echo site_url('auth/logout'); ?>">Sign out</a></li>
                            </ul>
                        </div>
                    <?php else :  ?>
                        <ul class="account-wrap d-flex ">
                            <li><a href="my-account">
                                    <img class="hoverImg" src="assets/theme/new/images/icons/login-hover.png" alt="image">
                                    <img class="img" src="assets/theme/new/images/icons/login.png" alt="image">
                                </a>
                            </li>
                            <li>
                                <a href="sign-up">
                                    <img class="hoverImg" src="assets/theme/new/images/icons/account.png" alt="image">
                                    <img class="img" src="assets/theme/new/images/icons/account-hover.png" alt="image">
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>

               
            </div>
            <div class="col-2 col-md-1 col-sm-2 d-xl-none d-lg-block">
                <ul class="menuTrigger">
                    <li class="first"></li>
                    <li class="second"></li>
                    <li class="last"></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- header-area end -->
<?php } ?>