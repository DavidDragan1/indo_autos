<?php
$role_id = getLoginUserData('role_id');
$user_id = getLoginUserData('user_id');
$ci =& get_instance();
$active_url = $ci->uri->segment( 2 );

$unreadChat = $ci->db->select('id') ->get_where('message', ['receiver ' => $user_id, 'read_status' => '0'])->num_rows();
$totalReview = $ci->db->select('id') ->get_where('reviews', ['vendor_id ' => $user_id, 'status' => 'Approve'])->num_rows();
$verifierRequest = 0;
if($role_id == 17){
    $verifierRequest = $ci->db->select('id') ->get_where('verifier_requests', ['is_read'=>0,'user_id'=>$user_id])->num_rows();
}
?>
<!-- sidemenu area  -->
<div class="sidebar-nav">
            <span class="material-icons cancel-menu">
                cancel
            </span>
    <div class="logo">
        <a href="<?php echo base_url();?>">
            <img src="assets/new-theme/images/car-logo.svg" alt="CarQuest">
        </a>
    </div>
    <ul class="collapsible mainmenu-wrap">
        <?php if ($role_id != 6 || $role_id != 9) {
            if($active_url == "") {
                $class = "active";
            } else {
                $class = "";
            }
            ?>
        <li class="menuitem <?=$class?>">
            <a href="admin">
                <span class="material-icons icon">dashboard</span>
                <span class="name">Dashboard</span>
            </a>
        </li>
        <?php } ?>
        <?=add_main_menu_trade('Products', 'admin/posts', 'posts', 'work')?>
        <?=add_main_menu_trade('Request', 'admin/clearing/request', 'clearing/request', 'work')?>
        <?=add_main_menu_trade('Request', 'admin/shipping/request', 'shipping/request', 'work')?>
        <?=add_main_menu_trade('Request', 'admin/verifier/all_request', 'verifier/all_request', 'work',$verifierRequest)?>
        <?=Modules::run('mails/newSidebarMenusTrade');?>
        <?=add_main_menu_trade('Chatbox', 'admin/chat', 'chat', 'chat', $unreadChat)?>
    </ul>
</div>
<!-- sidemenu area  -->
