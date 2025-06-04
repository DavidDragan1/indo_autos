<?php defined('BASEPATH') or exit('No direct script access allowed');


function get_all_modules($id = 0)
{

    $ci =& get_instance();
    $modules = $ci->db->get('modules')->result();

    $option = '';
    foreach ($modules as $module) {
        $option .= '<option value="' . $module->id . '"';
        $option .= ($id == $module->id) ? ' selected' : '';
        $option .= '>' . $module->name . ' </option>';
    }
    return $option;
}

function addAdminMenu($name, $url = '', $icon = 'fa-envelope-o', $childrens = null)
{
    $role_id = getLoginUserData('role_id');
    $ci =& get_instance();
    $active_url = $ci->uri->segment(2);
    $class_active = ($active_url === $url) ? 'active' : '';

    /* auto admin prefix check up ignored by kanny 
     * Due performance. We could check Backend_URL == admin 
     * so no need to add prefix or add Backend_URL as prefix;
     * 17th Oct 2016, 2:45 am 
     */

    $html = '';

    if (checkMenuPermission($url, $role_id)) {

        $html .= '<li class="treeview ' . $class_active . '">
                <a href="' . Backend_URL . $url . '">
                    <i class="fa ' . $icon . '"></i> <span>' . $name . '</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>';


        if (!empty($childrens)) {
            $html .= '<ul class="treeview-menu">';
            foreach ($childrens as $item) {
                if (checkMenuPermission($item['href'], $role_id)) {
                    $html .= addAdminChildMenu($item['title'], $item['href'], $item['icon']);
                }

                //$html .= addAdminChildMenu( $item['title'], $item['href'],  $item['icon']);
            }
            $html .= '</ul>';
        }
        $html .= '</li>';
    }

    return $html;
}

function addNewAdminMenu($name, $url = '', $img = 'assets/theme/new/images/backend/sidebar/post.svg', $hover = 'assets/theme/new/images/backend/sidebar/post-h.svg',
                         $childrens = null, $id = '')
{
    $role_id = getLoginUserData('role_id');
    $ci =& get_instance();
    $active_url = $ci->uri->segment(2);

    if ($active_url === $url) {
        $class_active = 'active';
        $show = 'show';
    } else {
        $class_active = '';
        $show = '';
    }

    /* auto admin prefix check up ignored by kanny
     * Due performance. We could check Backend_URL == admin
     * so no need to add prefix or add Backend_URL as prefix;
     * 17th Oct 2016, 2:45 am
     */

    $html = '';
    if (checkMenuPermission($url, $role_id)) {
        $html .= '<li><span class="collapsed collapsedMenu ' . $class_active . '" data-toggle="collapse" aria-expanded="false" data-target="#' . $id . '">
                         <span class="icons">
                             <img class="normal" src="' . $img . '" alt="image">
                             <img class="hover" src="' . $hover . '" alt="image">
                         </span>
                         <span class="name">' . $name . '</span></span>';

        if (!empty($childrens)) {
            $html .= '<ul id="' . $id . '" class="collapse ' . $show . '" data-parent="#accordion">';
            foreach ($childrens as $item) {
                if (checkMenuPermission($item['href'], $role_id)) {
                    if (isset($item['badge'])) {
                        $badge = $item['badge'];
                    } else {
                        $badge = '';
                    }
                    $html .= addNewAdminChildMenu($item['title'], $item['href'], $item['img'], $item['hover'], $badge);
                }

                //$html .= addAdminChildMenu( $item['title'], $item['href'],  $item['icon']);
            }
            $html .= '</ul>';
        }
        $html .= '</li>';
    }

    return $html;
}

function addAdminChildMenu($title = 'Child Item', $childURL = 'admin', $icon = 'fa-circle-o')
{
    $ci =& get_instance();
    $active_url = $ci->uri->uri_string();
    $class_active = ($active_url === (Backend_URL . $childURL)) ? ' class="active"' : '';
    return '<li' . $class_active . '><a href="' . Backend_URL . $childURL . '"><i class="fa ' . $icon . '"></i>' . $title . '</a></li>';
}

function addNewAdminChildMenu($title = 'Child Item', $childURL = 'admin', $img = '', $hover = '', $badge = '')
{
    $ci =& get_instance();
    $active_url = $ci->uri->uri_string();
    $class_active = ($active_url === (Backend_URL . $childURL)) ? ' class="active"' : '';
    return '<li' . $class_active . '><a href="' . Backend_URL . $childURL . '"><img class="normal" src="' . $img . '" alt="image">
     <img class="hover" src="' . $hover . '" alt="image">' . $title . $badge . '</a></li>';
}


function checkMenuPermission($access_key, $role_id)
{
    $ci =& get_instance();

    $query = $ci->db->select('access')
        ->from('role_permissions')
        ->join('acls', 'acls.id = role_permissions.acl_id', 'left')
        ->where('role_id', $role_id)
        ->where('permission_key', $access_key)
        ->get()
        ->row();
    return ($query);
}

function checkPermission($access_key, $role_id)
{
    $ci =& get_instance();
    $query = $ci->db->select('access')
        ->from('role_permissions')
        ->join('acls', 'acls.id = role_permissions.acl_id', 'left')
        ->where('role_id', $role_id)
        ->where('permission_key', $access_key)
        ->get()
        ->result_array();
//    pp($query);
    return is_array($query) ? count($query) : 0;
//    return 1;
}


function add_main_menu($title, $url, $access, $icon)
{
    // $title, $url, $icon, $access.
    $role_id = getLoginUserData('role_id');
    $menu = '';
    if (checkPermission($access, $role_id)) {
        $menu .= '<li><a href="' . $url . '">';
        $menu .= '<i class="fa ' . $icon . '"></i>';
        $menu .= '<span>' . $title . '</span>';
        $menu .= '</a><li>';
        return $menu;
    }
}

function add_new_main_menu($title, $url, $access, $img, $hover)
{
    // $title, $url, $icon, $access.
    $role_id = getLoginUserData('role_id');
    $menu = '';
    $ci =& get_instance();
    $active_url = $ci->uri->segment(2);

    if ($active_url == $url) {
        $active = "active";
    } else {
        $active = "";
    }

    if (checkPermission($access, $role_id)) {

        return '<li><a class="' . $active . '" href="' . $url . '"><span class="icons"><img class="normal" src="' . $img . '" alt="image">
                 <img class="hover" src="' . $hover . '" alt="image"></span><span class="name">' . $title . '</span></a></li>';
    }
}


function buildMenuForMoudle($menus = null)
{
    /* Example Array 
     * only display when developer forgot to assign array;
     * Noted by Kanny 
     * 17th Oct 2016, 3:05am 
    */
    $array = [
        'module' => 'Menu Title',
        'icon' => 'fa-users',
        'href' => 'module',
        'children' => [
            [
                'title' => 'Sub Title 1',
                'icon' => 'fa fa-circle-o',
                'href' => 'module/controller/method1'
            ]
        ]
    ];
    if (!is_null($menus)) {
        $array = $menus;
    }
    $menu = addAdminMenu($array['module'], $array['href'], $array['icon'], @$array['children']);
    return $menu;
}

function buildNewMenuForMoudle($menus = null)
{
    $array = [
        'module' => 'Menu Title',
        'img' => 'assets/theme/new/images/backend/sidebar/photo.svg',
        'hover' => 'assets/theme/new/images/backend/sidebar/photo-h.svg',
        'id' => '',
        'href' => 'module',
        'children' => [
            [
                'title' => 'Sub Title 1',
                'img' => 'assets/theme/new/images/backend/sidebar/photo.svg',
                'hover' => 'assets/theme/new/images/backend/sidebar/photo-h.svg',
                'id' => '',
                'href' => 'module/controller/method1',
                'badge' => '',
            ]
        ]
    ];
    if (!is_null($menus)) {
        $array = $menus;
    }
    $menu = addNewAdminMenu($array['module'], $array['href'], $array['img'], $array['hover'], @$array['children'], $array['id']);

    return $menu;
}

function buildNewMenuForTrade($menus = null)
{
    $array = [
        'module' => 'Menu Title',
        'icon' => 'material icon',
        'id' => '',
        'href' => 'module',
        'badge' => '',
        'children' => [
            [
                'title' => 'Sub Title 1',
                'id' => '',
                'href' => 'module/controller/method1',
                'badge' => '',
            ]
        ]
    ];
    if (!is_null($menus)) {
        $array = $menus;
    }
    $menu = addNewTradeMenu($array['module'], $array['href'], $array['icon'], @$array['children'], $array['id'], $array['badge']);
    return $menu;
}

function buildMenuForMoudleForInsuranceOrLoan($menus = null)
{
    $array = [
        'module' => 'Menu Title',
        'icon' => '',
        'badge' => '',
        'id' => '',
        'href' => 'module',
        'children' => [
            [
                'title' => 'Sub Title 1',
                'icon' => 'assets/theme/new/images/backend/sidebar/photo.svg',
                'id' => '',
                'href' => 'module/controller/method1',
                'badge' => '',
            ]
        ]
    ];
    if (!is_null($menus)) {
        $array = $menus;
    }
    $menu = addAdminMenuForInsuranceOrLoan($array['module'], $array['href'], $array['icon'], @$array['children'], $array['badge']);

    return $menu;
}

function buildMenuForSetting($menus = null)
{
    $array = [
        'module' => 'Menu Title',
        'icon' => '',
        'badge' => '',
        'id' => '',
        'href' => 'module',
        'children' => [
            [
                'title' => 'Sub Title 1',
                'icon' => 'assets/theme/new/images/backend/sidebar/photo.svg',
                'id' => '',
                'href' => 'module/controller/method1',
                'badge' => '',
            ]
        ]
    ];
    if (!is_null($menus)) {
        $array = $menus;
    }
    $menu = addAdminMenuForSetting($array['module'], $array['href'], $array['icon'], @$array['children'], $array['badge']);

    return $menu;
}
function addAdminMenuForSetting($name, $url = '', $icon = '', $childrens = null, $badge = 0)
{
    $role_id = getLoginUserData('role_id');
    $ci =& get_instance();
    $active_url = $ci->uri->segment(3);

    if (in_array($active_url,['company-profile','change-password'])) {
        $class_active = 'active';
        $show = 'show';
    } else {
        $class_active = '';
        $show = '';
    }
    $html = '';
    $menu_permission = false;
    foreach ($childrens as $k => $url) {
        if (checkInsuranceOrLoanPermission($url['href'], $role_id)) {
            $menu_permission = true;
            break;
        }
    }
    if ($menu_permission) {
        $badge_html = !empty($badge) ? "<span class=\"menu-badge\">$badge</span>" : "";
        $html .= "<li class=\"menuitem-collapsible $class_active\">
            <div class=\"collapsible-header $class_active\">
                <span class=\"material-icons icon\">$icon</span>
                <span class=\"name d-flex align-items-center\">$name
                            <span class=\"material-icons\">
                                arrow_drop_down
                            </span>
                        </span>
                $badge_html
            </div>
            <div class=\"collapsible-body $show\">
                <ul>";
        if (!empty($childrens)) {
            foreach ($childrens as $item) {
                if (checkInsuranceOrLoanPermission($item['href'], $role_id)) {
                    if (isset($item['badge'])) {
                        $badge = $item['badge'];
                    } else {
                        $badge = '';
                    }
                    $html .= addNewTradeChildMenu($item['title'], $item['href'], $badge);
                }
            }
        }
        $html .= "</ul>
            </div></li>";
    }

    return $html;
}

function addAdminMenuForInsuranceOrLoan($name, $url = '', $icon = '', $childrens = null, $badge = 0)
{
    $role_id = getLoginUserData('role_id');
    $ci =& get_instance();
    $active_url = $ci->uri->segment(2) . '/' . $ci->uri->segment(3);
    if ($active_url === $url) {
        $class_active = 'active';
        $show = 'show';
    } else {
        $class_active = '';
        $show = '';
    }

    $html = '';
    $menu_permission = false;
    foreach ($childrens as $k => $url) {
        if (checkInsuranceOrLoanPermission($url['href'], $role_id)) {
            $menu_permission = true;
            break;
        }
    }
    if ($menu_permission) {
        $badge_html = !empty($badge) ? "<span class=\"menu-badge\">$badge</span>" : "";
        $html .= "<li class=\"menuitem-collapsible $class_active\">
            <div class=\"collapsible-header $class_active\">
                <span class=\"material-icons icon\">$icon</span>
                <span class=\"name d-flex align-items-center\">$name
                            <span class=\"material-icons\">
                                arrow_drop_down
                            </span>
                        </span>
                $badge_html
            </div>
            <div class=\"collapsible-body $show\">
                <ul>";
        if (!empty($childrens)) {
            foreach ($childrens as $item) {
                if (checkInsuranceOrLoanPermission($item['href'], $role_id)) {
                    if (isset($item['badge'])) {
                        $badge = $item['badge'];
                    } else {
                        $badge = '';
                    }
                    $html .= addNewTradeChildMenu($item['title'], $item['href'], $badge);
                }
            }
        }
        $html .= "</ul>
            </div></li>";
    }

    return $html;
}

function addNewTradeMenu($name, $url = '', $icon = 'email', $childrens = null, $id = '', $badge = '')
{
    $role_id = getLoginUserData('role_id');
    $ci =& get_instance();
    $active_url = $ci->uri->segment(3);
    if ($active_url === $url) {
        $class_active = 'active';
        $show = 'show';
    } else {
        $class_active = '';
        $show = '';
    }

    $html = '';

    if (checkMenuPermission($url, $role_id)) {
        $badge_html = !empty($badge) ? "<span class=\"menu-badge\">$badge</span>" : "";
        $html .= "<li class=\"menuitem-collapsible $class_active\">
            <div class=\"collapsible-header $class_active\">
                <span class=\"material-icons icon\">$icon</span>
                <span class=\"name d-flex align-items-center\">$name
                            <span class=\"material-icons\">
                                arrow_drop_down
                            </span>
                        </span>
                $badge_html
            </div>
            <div class=\"collapsible-body $show\">
                <ul>";
        if (!empty($childrens)) {
            foreach ($childrens as $item) {
                if (checkMenuPermission($item['href'], $role_id)) {
                    if (isset($item['badge'])) {
                        $badge = $item['badge'];
                    } else {
                        $badge = '';
                    }
                    $html .= addNewTradeChildMenu($item['title'], $item['href'], $badge);
                }
            }
        }
        $html .= "</ul>
            </div></li>";
    }

    return $html;
}

function addNewTradeChildMenu($title = 'Child Item', $childURL = 'admin', $badge = '')
{
    $ci =& get_instance();
    $active_url = $ci->uri->uri_string();
    $class_active = ($active_url === (Backend_URL . $childURL)) ? ' class="active"' : '';
    $badge_html = !empty($badge) ? " <span>$badge</span>" : "";
    return '<li' . $class_active . '><a href="' . Backend_URL . $childURL . '">' . $title . $badge_html . '</a></li>';
}

function add_main_menu_trade($title, $url, $access, $icon, $badge = '')
{
    // $title, $url, $icon, $access.
    $role_id = getLoginUserData('role_id');
    $menu = '';
    if (checkPermission($access, $role_id)) {
        $badge_html = !empty($badge) ? "<span class=\"menu-badge\">$badge</span>" : "";
        $ci =& get_instance();
        $active_url = $ci->uri->uri_string();
        $class_active = $active_url === $url ? 'active' : '';

        $menu = "<li class=\"menuitem $class_active\">
            <a href=\"$url\">
                <span class=\"material-icons icon\">$icon</span>
                <span class=\"name\">$title</span>
                $badge_html
            </a>
        </li>";
        return $menu;
    }
}

function add_responsive_menu_trade($title, $url, $access)
{
    // $title, $url, $icon, $access.
    $role_id = getLoginUserData('role_id');
    $menu = '';
    if (checkPermission($access, $role_id)) {
        $ci =& get_instance();
        $active_url = $ci->uri->uri_string();
        $class_active = $active_url === $url ? 'active' : '';
        $icons = '';
        if ($access == 'chat'){
            $icons = '<svg class="icon" width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.25 13V1.75C19.25 1.41848 19.1183 1.10054 18.8839 0.866116C18.6495 0.631696 18.3315 0.5 18 0.5H1.75C1.41848 0.5 1.10054 0.631696 0.866116 0.866116C0.631696 1.10054 0.5 1.41848 0.5 1.75V19.25L5.5 14.25H18C18.3315 14.25 18.6495 14.1183 18.8839 13.8839C19.1183 13.6495 19.25 13.3315 19.25 13ZM24.25 5.5H21.75V16.75H5.5V19.25C5.5 19.5815 5.6317 19.8995 5.86612 20.1339C6.10054 20.3683 6.41848 20.5 6.75 20.5H20.5L25.5 25.5V6.75C25.5 6.41848 25.3683 6.10054 25.1339 5.86612C24.8995 5.6317 24.5815 5.5 24.25 5.5Z" fill="#2E302A"/>
            </svg>
            ';
        } elseif ($access == 'mails'){
            $icons = '<svg class="icon" width="23" height="18" viewBox="0 0 23 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.7 4.5L11.5 10.125L2.3 4.5V2.25L11.5 7.875L20.7 2.25V4.5ZM20.7 0H2.3C1.0235 0 0 1.00125 0 2.25V15.75C0 16.3467 0.242321 16.919 0.673654 17.341C1.10499 17.7629 1.69 18 2.3 18H20.7C21.31 18 21.895 17.7629 22.3263 17.341C22.7577 16.919 23 16.3467 23 15.75V2.25C23 1.00125 21.965 0 20.7 0Z" fill="#2E302A"/>
                </svg>';
        } elseif ($access == 'reviews'){
            $icons = '<svg class="icon" width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4V2H8V4H12ZM2 6V17H18V6H2ZM18 4C19.11 4 20 4.89 20 6V17C20 18.11 19.11 19 18 19H2C0.89 19 0 18.11 0 17L0.00999999 6C0.00999999 4.89 0.89 4 2 4H6V2C6 0.89 6.89 0 8 0H12C13.11 0 14 0.89 14 2V4H18Z" fill="#1E1E1E"/>
                </svg>';
        }

        $menu = '<li>
            <a class="'.$class_active.'" href="'.$url.'">
                '.$icons.'

                <span>'.$title.'</span>
            </a>
        </li>';
        return $menu;
    }
}

function checkInsuranceOrLoanPermission($access_key, $role_id)
{
    if (in_array($role_id, [11, 12])) {
        return 1;
    }
    $ci =& get_instance();
    $query = $ci->db->select('access')
        ->from('insurance_role_permission')
        ->join('insurance_acls', 'insurance_acls.id = insurance_role_permission.insurance_acl_id', 'left')
        ->where('role_id', $role_id)
        ->where('permission_key', $access_key)
        ->get()
        ->row();
    return isset($query) && !empty($query) ? 1 : 0;
//    return 1;
}

function addNewAdminChildMenuForInsuranceOrLoan($title = 'Child Item', $childURL = 'admin', $badge = '')
{
    $ci =& get_instance();
    $active_url = $ci->uri->uri_string();
    $class_active = ($active_url === (Backend_URL . $childURL)) ? ' class="active"' : '';
    $badge_html = !empty($badge) ? " <span>$badge</span>" : "";
    return '<li' . $class_active . '><a href="' . Backend_URL . $childURL . '">' . $title . $badge_html . '</a></li>';
}

function add_main_menu_for_insurance_or_loan($title, $url, $icon, $badge = 0)
{
    // $title, $url, $icon, $access.
    $role_id = getLoginUserData('role_id');
    $menu = '';
    if (checkInsuranceOrLoanPermission($url, $role_id)) {
        $badge_html = !empty($badge) ? "<span class=\"menu-badge\">$badge</span>" : "";
        $ci =& get_instance();
        $active_url = $ci->uri->uri_string();
        $class_active = $active_url === Backend_URL.$url ? 'active' : '';

        $menu = "<li class=\"menuitem $class_active\">
            <a href=\"".Backend_URL.$url."\">
                <span class=\"material-icons icon\">$icon</span>
                <span class=\"name\">$title</span>
                $badge_html
            </a>
        </li>";
        return $menu;
    }
}
