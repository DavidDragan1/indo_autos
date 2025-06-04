<div class="sidebar-main-wrap">
    <div class="left-sidebar">
        <span class="toggleNav closeNav"><img src="assets/theme/new/images/backend/close.png" alt="image"></span>
        <div class="logo">
            <a href="<?php echo base_url(); ?>">
                <img class="fullview" src="assets/theme/new/images/logo.svg" alt="logo">
                <img class="smallview" src="assets/theme/new/images/backend/logo-small.png" alt="image">
            </a>
        </div>
        <?php
        $user_id = getLoginUserData('user_id');
        $user = $this->db->where('id', $user_id)->get('users')->row();
        ?>
        <div class="short-profile">
            <img src="<?=get_logged_user_photo_link()?>" alt="image">
            <span><?php echo getLoginUserData( 'name' ) ;?></span>
            <a href="<?php echo site_url('auth/logout'); ?>"><i class="fa fa-sign-out"></i> Logout</a>
        </div>
        <div class="scrollbar-inner">
            <ul class="sidebar-menu" id="accordion">
                <?php
                $role_id = getLoginUserData('role_id');

                if ($role_id != 6 || $role_id != 9) : ?>
                <li>
                    <a class="
                        <?php
                            $ci =& get_instance();
                            $active_url = $ci->uri->segment( 2 );
                            if($active_url == "") {
                               echo "active";
                            } else {
                                echo "";
                            }
                        ?>"
                   href="admin">
                    <span class="icons">
                        <img class="normal" src="assets/theme/new/images/backend/sidebar/dashboard.svg" alt="image">
                        <img class="hover" src="assets/theme/new/images/backend/sidebar/dashboard-h.svg" alt="image">
                    </span>
                    <span class="name"> Dashboard </span>
                    </a>
                </li>
                <?php endif; ?>
                <?php
                    echo Modules::run('posts/newSidebarMenus');
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
                    echo buildMenuForMoudle([
                        'module'    => 'Reviews',
                        'icon'      => 'fa-thumbs-o-up',
                        'href'      => 'reviews',
                        'children'  => ''
                    ]);

                    echo Modules::run('mails/newSidebarMenus');

                    echo Modules::run('cms/sidebarMenus');

                    echo add_main_menu('Manage State', 'post_area', 'post_area', 'fa-map-marker');

                    echo add_main_menu('Manage Engine Size', 'engine_sizes', 'engine_sizes', 'fa-car');

                echo add_main_menu('Manage Fuel Type', 'fuel_types', 'fuel_types', 'fa-hourglass-start');

                    echo Modules::run('brands/sidebarMenus');

                    echo add_main_menu('Manage Colour', 'color', 'color', 'fa-dashboard');
                    echo add_main_menu('Vehicle Types', 'vehicle_types', 'vehicle_types', 'fa-car');
                    echo add_main_menu('Manage Body Type', 'body_types', 'body_types', 'fa-car');
                    echo add_main_menu('Special Features', 'special_features', 'special_features', 'fa-bullhorn');
                    echo add_main_menu('Manage Towing', 'admin/towing', 'towing', 'fa-dashboard');
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

                    echo add_new_main_menu('Help/FAQs', 'admin/help', 'help', 'assets/theme/new/images/backend/sidebar/faq.svg', 'assets/theme/new/images/backend/sidebar/faq-h.svg');
                    echo add_new_main_menu('Ask an Expert', 'admin/ask_expert', 'ask_expert', 'assets/theme/new/images/backend/sidebar/faq.svg', 'assets/theme/new/images/backend/sidebar/faq-h.svg');
                    echo add_new_main_menu('Notification', 'admin/notification', 'notification', 'assets/theme/new/images/backend/sidebar/faq.svg', 'assets/theme/new/images/backend/sidebar/faq-h.svg');
                    echo buildNewMenuForMoudle([
                        'module'    => 'Diagnostics',
                        'img'      => 'assets/theme/new/images/backend/sidebar/faq.svg',
                        'hover'      => 'assets/theme/new/images/backend/sidebar/faq-h.svg',
                        'href'      => 'diagnostics',
                        'id'      => 'diagnostics',
                        'children'  => [
                            [
                                'title' => 'Question Type',
                                'img'  => 'assets/theme/new/images/backend/sidebar/photo.svg',
                                'hover'  => 'assets/theme/new/images/backend/sidebar/photo-h.svg',
                                'href'  => 'diagnostics'
                            ],
                            [
                                'title' => 'Question',
                                'img'  => 'assets/theme/new/images/backend/sidebar/photo.svg',
                                'hover'  => 'assets/theme/new/images/backend/sidebar/photo-h.svg',
                                'href'  => 'diagnostics/questions'
                            ],
                            [
                                'title' => 'Problem',
                                'img'  => 'assets/theme/new/images/backend/sidebar/photo.svg',
                                'hover'  => 'assets/theme/new/images/backend/sidebar/photo-h.svg',
                                'href'  => 'diagnostics/problem'
                            ],
                            [
                                'title' => 'Inspection',
                                'img'  => 'assets/theme/new/images/backend/sidebar/photo.svg',
                                'hover'  => 'assets/theme/new/images/backend/sidebar/photo-h.svg',
                                'href'  => 'diagnostics/inspection'
                            ],
                            [
                                'title' => 'Solution',
                                'img'  => 'assets/theme/new/images/backend/sidebar/photo.svg',
                                'hover'  => 'assets/theme/new/images/backend/sidebar/photo-h.svg',
                                'href'  => 'diagnostics/solution'
                            ]
                        ]
                    ]);
                    echo add_main_menu('Newsletter Subscribers', 'newsletter_subscriber', 'newsletter_subscriber', 'fa-envelope-o');
                    // Speceally for Developers
                    echo add_main_menu('Email Templates', 'email_templates', 'email_templates', 'fa-list-alt');
                    echo add_main_menu('Settings', 'settings', 'settings', 'fa-gear');
                    echo add_main_menu('List of Modules ', 'module', 'module', 'fa-columns');
                    echo add_main_menu('ACLs ', 'acls', 'acls', 'fa-columns');
                    echo add_new_main_menu('My Account', 'profile', 'profile', 'assets/theme/new/images/backend/sidebar/user.svg', 'assets/theme/new/images/backend/sidebar/user-h.svg');
                    echo add_main_menu('Packages', 'admin/package', 'package', 'fa-gear');
                ?>
                <?php
                $role_id = getLoginUserData('role_id');

                if ($role_id == 6) : ?>

                    <li>
                        <a class="
                        <?php
                        $ci =& get_instance();
                        $active_url = $ci->uri->segment( 1 );
                        if($active_url == "diagnostic") {
                            echo "active";
                        } else {
                            echo "";
                        }
                        ?>"
                           href="<?php echo site_url('diagnostic') ?>">
                    <span class="icons">
                        <img class="normal" src="assets/theme/new/images/backend/icons/online.svg" alt="image">
                        <img class="hover" src="assets/theme/new/images/backend/icons/online-h.svg" alt="image">
                    </span>
                            <span class="name"> Online Diagnostic </span>
                        </a>
                    </li>

                    <li>
                        <a class="
                        <?php
                        $ci =& get_instance();
                        $active_url = $ci->uri->segment( 1 );
                        if($active_url == "faq") {
                            echo "active";
                        } else {
                            echo "";
                        }
                        ?>"
                           href="<?php echo site_url('faq') ?>">
                    <span class="icons">
                        <img class="normal" src="assets/theme/new/images/backend/sidebar/faq.svg" alt="image">
                        <img class="hover" src="assets/theme/new/images/backend/sidebar/faq-h.svg" alt="image">
                    </span>
                            <span class="name"> FAQ/Help </span>
                        </a>
                    </li>

                    <li>
                        <a class="
                        <?php
                        $ci =& get_instance();
                        $active_url = $ci->uri->segment( 1 );
                        if($active_url == "driver-hire") {
                            echo "active";
                        } else {
                            echo "";
                        }
                        ?>"
                           href="<?php echo site_url('driver-hire') ?>">
                    <span class="icons">
                        <img class="normal" src="assets/theme/new/images/backend/sidebar/dashboard.svg" alt="image">
                        <img class="hover" src="assets/theme/new/images/backend/sidebar/dashboard-h.svg" alt="image">
                    </span>
                            <span class="name"> Driver Hire </span>
                        </a>
                    </li>

                    <li>
                        <a class="
                        <?php
                        $ci =& get_instance();
                        $active_url = $ci->uri->segment( 1 );
                        if($active_url == "motor-association") {
                            echo "active";
                        } else {
                            echo "";
                        }
                        ?>"
                           href="<?php echo site_url('motor-association') ?>">
                    <span class="icons">
                        <img class="normal" src="assets/theme/new/images/backend/sidebar/dashboard.svg" alt="image">
                        <img class="hover" src="assets/theme/new/images/backend/sidebar/dashboard-h.svg" alt="image">
                    </span>
                            <span class="name"> Motor Association </span>
                        </a>
                    </li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<style>
    .tostfyMessage {
        position: fixed;
        right: 5px;
        opacity: 0;
        visibility: hidden;
        -webkit-box-shadow: 0 2px 7px 0 rgba(0, 0, 0, 0.2);
        box-shadow: 0 2px 7px 0 rgba(0, 0, 0, 0.2);
        top: -100%;
        min-width: 280px;
        min-height: 50px;
        z-index: 9999;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        padding: 5px 20px;
        color: #fff;
        text-transform: capitalize;
        border-radius: 2px;
        -webkit-transition: all .4s ease-in-out 0s;
        transition: all .4s ease-in-out 0s;
    }

    .tostfyMessage .tostfyClose {
        position: absolute;
        right: 5px;
        top: 0px;
        font-size: 20px;
        cursor: pointer;
    }
</style>
<?php if($this->session->flashdata('status')):
    if ($this->session->flashdata('status') == 'success') :?>
        <div class="tostfyMessage bg-success" style="top: 5px; visibility: visible; opacity: 1">
            <span class="tostfyClose">&times;</span>
            <div class="messageValue" id="session_msg">
                <?php echo $this->session->flashdata('message'); ?>
            </div>
        </div>
    <?php else : ?>
        <div class="tostfyMessage bg-danger" style="top: 5px; visibility: visible; opacity: 1">
            <span class="tostfyClose">&times;</span>
            <div class="messageValue" id="session_msg">
                <?php echo $this->session->flashdata('message'); ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<script>
    setTimeout(function () {
        $('.tostfyMessage').css({ "top": "-100%", "visibility": "hidden", "opacity": 0 })
    }, 10000);
    $('.tostfyClose').on('click', function () {
        $('.tostfyMessage').css({ "top": "-100%", "visibility": "hidden", "opacity": 0 })
    })
</script>

<div class="main-content">
    <header class="header-area">
        <div class="responsiveMenu">
            <div class="logo">
                <a href="<?php echo base_url(); ?>">
                    <img class="fullview" src="assets/theme/new/images/backend/car-logo.svg" alt="image">
                </a>
            </div>
            <div class="header-left">
                <span class="toggleNav"><img src="assets/theme/new/images/backend/icons/menu.svg" alt="image"></span>
            </div>
        </div>

        <ul class="header-right">
            <li><a target="_blank" href="<?php echo site_url( 'diagnostic'); ?>"><img src="assets/theme/new/images/backend/icons/online.svg" alt="image"> Online Vehicle Diagnostic</a></li>
            <?php
            $role_id = getLoginUserData('role_id');
            if (in_array($role_id, array(1,2,3))){ ?>
                <li><a href="<?php echo base_url( Backend_URL . 'help'); ?>"><img src="assets/theme/new/images/backend/icons/faq.svg" alt="image"> FAQ/Help</a></li>
            <?php } else { ?>
                <li><a href="<?php echo base_url( 'faq'); ?>"><img src="assets/theme/new/images/backend/icons/faq.svg" alt="image"> FAQ/Help</a></li>
            <?php }  ?>
            <li><a href="<?php echo base_url(); ?>"><img src="assets/theme/new/images/backend/icons/home.svg" alt="image"> Go to Home</a></li>

        </ul>
    </header>
