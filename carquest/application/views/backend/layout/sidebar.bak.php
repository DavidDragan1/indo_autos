<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">                             
        <ul class="sidebar-menu">            
            <li><a href="admin"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>           
            <?php     
                                                    
            echo Modules::run('posts/sidebarMenus');
            echo Modules::run('users/sidebarMenus');
            echo buildMenuForMoudle([
                    'module'    => 'User Log',
                    'icon'      => 'fa-history',
                    'href'      => 'login_history',                    
                    'children'  => [
                        [
                            'title' => 'All Logs',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'login_history'
                        ],[
                            'title' => 'Graph View',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'login_history/graph_view'
                        ]                        
                    ]        
                ]);
            
                        
              echo buildMenuForMoudle([
                    'module'    => 'Reviews',
                    'icon'      => 'fa-thumbs-o-up',
                    'href'      => 'reviews', 
                    'children'  => ''
                ]);
            
            echo Modules::run('mails/sidebarMenus');
            
            echo Modules::run('cms/sidebarMenus');
			            
            echo add_main_menu('Manage State', 'post_area', 'post_area', 'fa-map-marker');            
                        
            echo add_main_menu('Manage Engine Size', 'engine_sizes', 'engine_sizes', 'fa-car');

            echo add_main_menu('Manage Fuel Type', 'fuel_types', 'fuel_types', 'fa-hourglass-start');
            
            echo Modules::run('brands/sidebarMenus');   

            echo add_main_menu('Manage Colour', 'color', 'color', 'fa-dashboard');
            echo add_main_menu('Vehicle Types', 'vehicle_types', 'vehicle_types', 'fa-car');
            echo add_main_menu('Manage Body Type', 'body_types', 'body_types', 'fa-car');
            echo add_main_menu('Special Features', 'special_features', 'special_features', 'fa-bullhorn');
			
            //echo add_main_menu('Parts Description', 'parts', 'parts', 'fa-code-fork');                                   
            echo buildMenuForMoudle([
                    'module'    => 'Parts Description',
                    'icon'      => 'fa-camera',
                    'href'      => 'parts',                    
                    'children'  => [
                        [
                            'title' => 'Parts Description',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'parts'
                        ],
                        [
                            'title' => 'Parts Category',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'parts/category'
                        ]
					]
				]);

			echo add_main_menu('Repair Type', 'admin/repair_type', 'repair_type', 'fa-bullhorn');
			echo add_main_menu('Specialism', 'admin/specialism', 'specialism', 'fa-bullhorn');			
				
            echo add_main_menu('Newsletter Subscribers', 'newsletter_subscriber', 'newsletter_subscriber', 'fa-envelope-o');
            // Speceally for Developers            
            echo add_main_menu('Email Templates', 'email_templates', 'email_templates', 'fa-list-alt');            
            echo add_main_menu('Settings', 'settings', 'settings', 'fa-gear');            
            echo add_main_menu('DB Backup & Restore', 'db_sync', 'settings', 'fa-columns');
            echo add_main_menu('List of Modules ', 'module', 'module', 'fa-columns');
            echo add_main_menu('ACLs ', 'acls', 'acls', 'fa-columns');
            echo add_main_menu('My Account', 'profile', 'profile', 'fa-user');
            echo add_main_menu('Packages', 'admin/package', 'package', 'fa-gear');
            // For Gallery Module 
            echo buildMenuForMoudle([
                    'module'    => 'Photo Gallery',
                    'icon'      => 'fa-camera',
                    'href'      => 'gallery',                    
                    'children'  => [
                        [
                            'title' => 'All Photo',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'gallery'
                        ],
                        [
                            'title' => 'All Video',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'gallery/video'
                        ],
                        [
                            'title' => 'Manage Alubms',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'gallery/albums'
                        ],
                        [
                            'title' => 'Gallery Settings',
                            'icon'  => 'fa fa-circle-o',
                            'href'  => 'gallery/settings'
                        ]                        
                    ]        
                ]);
             echo add_main_menu('Chat ', 'admin/chat', 'chat', 'fa-comments');
            
           ?>            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>


<!-- Body Content Start -->
<div class="content-wrapper">
	<div id="ajaxContent">
	
	
	
	
	
	
	
	
	
	
	
	
	
	