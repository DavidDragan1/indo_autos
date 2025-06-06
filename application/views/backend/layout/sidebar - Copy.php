<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="assets/admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
                <a href="admin">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>         
            </li>


           <?php 
           // For User Module 
            echo \buildMenuForMoudle([
                    'module'    => 'Users',
                    'icon'      => 'fa-users',
                    'href'      => 'users',                    
                    'children'  => [
                        [
                            'title' => 'All User',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'users'
                        ],            
                        [
                            'title' => 'Add New User',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'users/create'
                        ],
                        [
                            'title' => 'Reol / ACL',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'users/roles'
                        ]                        
                    ]        
                ]);
            
            echo Modules::run('posts/sidebarMenus');
            echo Modules::run('email_templates/sidebarMenus');
            echo Modules::run('mails/sidebarMenus');
           // For Mails Report Only for Admin/Developer
           echo \buildMenuForMoudle([
               'module'    => 'Report On Mail',
               'icon'      => 'fa-envelope-o',
               'href'      => 'mails/report'
           ]);
            echo Modules::run('engine_sizes/sidebarMenus');
            echo Modules::run('fuel_types/sidebarMenus');
            echo Modules::run('color/sidebarMenus');
            echo Modules::run('brands/sidebarMenus');
            echo Modules::run('body_types/sidebarMenus');
            echo Modules::run('special_features/sidebarMenus');
            echo Modules::run('vehicle_types/sidebarMenus');

			// For Newsletter Module 
            echo \buildMenuForMoudle([
                    'module'    => 'DB Backup',
                    'icon'      => 'fa-columns',
                    'href'      => 'db_sync'                           
                ]);

           ?>            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>


<!-- Body Content Start -->
<div class="content-wrapper">  
    <section class="content-header"> <?php echo $this->session->flashdata('permission_error_msg'); ?></section>

	<div id="ajaxContent">
	
	
	
	
	
	
	
	
	
	
	
	
	
	