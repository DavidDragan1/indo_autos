
<!DOCTYPE html>

<html>

 <head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?php echo getSettingItem('comName'); ?></title>

  <!-- Tell the browser to be responsive to screen width -->

  <link rel="icon" href="assets/theme/images/favicon.png" type="image/png" sizes="16x16">

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.6 -->

  <base href="<?php echo base_url(); ?>"/>

  <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.min.css">

  <link rel="stylesheet" href="assets/admin/dist/css/style.css">



  <!-- Font Awesome -->

  <link rel="stylesheet" href="assets/lib/font-awesome/font-awesome.min.css">

<!--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">-->



  

  <link rel="stylesheet" href="assets/lib/plugins/datatables/dataTables.bootstrap.css">





  <!-- Theme style -->

  <link rel="stylesheet" href="assets/admin/dist/css/AdminLTE.min.css">

  <!-- AdminLTE Skins. Choose a skin from the css/skins

       folder instead of downloading all of them to reduce the load. -->

  <link rel="stylesheet" href="assets/admin/dist/css/skins/_all-skins.min.css">

  <!-- iCheck -->

  <link rel="stylesheet" href="assets/lib/plugins/iCheck/flat/blue.css">

  <!-- Morris chart -->

  <link rel="stylesheet" href="assets/lib/plugins/morris/morris.css">

  <!-- jvectormap -->

  <link rel="stylesheet" href="assets/lib/plugins/jvectormap/jquery-jvectormap-1.2.2.css">

  <!-- Date Picker -->

  <link rel="stylesheet" href="assets/lib/plugins/datepicker/datepicker3.css">

  <!-- Daterange picker -->

  <link rel="stylesheet" href="assets/lib/plugins/daterangepicker/daterangepicker.css">

  

  <!-- bootstrap wysihtml5 - text editor -->

  <link rel="stylesheet" href="assets/lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">



  



  <!-- jQuery 2.2.3 -->

    <script src="assets/lib/plugins/jQuery/jquery-2.2.3.min.js"></script>

    <!-- Bootstrap 3.3.6 -->

    <script src="assets/lib/bootstrap/js/bootstrap.min.js"></script>



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

  <!--[if lt IE 9]>

  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <![endif]-->

  

<link rel="stylesheet" href="assets/lib/ajax.css">

  

</head>

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">



  <header class="main-header">

    <!-- Logo -->

    <a href="admin" class="logo">

      <!-- mini logo for sidebar mini 50x50 pixels -->

      <span class="logo-mini"><img height="35" src="assets/admin/icons/logo-full.svg" alt="logo"></span>

      <!-- logo for regular state and mobile devices -->

      <span class="logo-lg"><img height="35" src="assets/admin/icons/logo-full.svg" alt="logo"></span>

    </a>

    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top">

      <!-- Sidebar toggle button-->

      <span class="sidebar-toggle" data-toggle="offcanvas" role="button">

        <span class="sr-only">Toggle navigation</span>

      </span>



      <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">

          

            <li><a href="<?php echo base_url(); ?>">Go to Home</a></li>  

            

          <!-- User Account: style can be found in dropdown.less -->

          <li class="dropdown user user-menu">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              <img src="assets/admin/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">

              <span class="hidden-xs"><?php echo getLoginUserData( 'name' ) ;?></span>

            </a>

            <ul class="dropdown-menu">

              <!-- User image -->

              <li class="user-header">

                <img src="assets/admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">



                <p> 

                  <?php echo getLoginUserData( 'name' ) ;?> - <?php echo getRoleName ( getLoginUserData( 'role_id' )) ;?> 

                  <small><?php echo getLoginUserData( 'user_mail' ) ;?></small>

                </p>

              </li>

              

              <!-- Menu Footer-->

              <li class="user-footer" style="background-color: #1b6d9c;">

                <div class="pull-left">

                  <a href="<?php echo site_url('admin/profile'); ?>" class="btn btn-default btn-flat">Profile</a>

                </div>

                <div class="pull-right">

                  <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>

                </div>

              </li>

            </ul>

          </li>                   

        </ul>

      </div>

    </nav>

  </header>

