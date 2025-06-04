<?php load_module_asset('users', 'css'); ?>
<?php load_module_asset('users', 'js'); ?>
<section class="content-header">
    <h1> User <small>list</small> &nbsp;&nbsp;
        <?php echo anchor(site_url('admin/users/create'), ' + Add User', 'class="btn btn-default"'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin </a></li>        
        <li class="active">User list</li>
    </ol>
</section>

<section class="content"> 
    <div class="panel panel-default">

        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-users" aria-hidden="true"></i> List of All User
            </h3>
        </div>


        <div class="filter_row">
            <div class="row">
                <form style="padding: 0 15px" class="" method="get" name="report" action="">
                    <div class="col-md-2">
                        <select name="range" class="form-control" onchange="date_range(this.value)">
                            <?php echo Users_helper::getRegistraionRange($range); ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-control"><?php echo globalStatus($status); ?></select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="q" placeholder="Keyword" value="<?php echo $q ?>">
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-control">
                            <?php echo getRoleDropdown($role);?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="submit" class="btn btn-primary" name="go" value="Filter">
                        <input type="button" class="btn btn-default" value="Reset" onclick="location.href = 'admin/users';">
                    </div>
                    <div id="custom" style="display: none">
                        <div class="col-md-2">
                            <label for="">Start Date</label>
                            <input type="date" value="<?php echo $fd;?>" name="fd" placeholder="From Date"  class="form-control input-md js_datepicker">
                        </div>
                        <div class="col-md-2">
                            <label for="">End Date</label>
                            <input type="date" value="<?php echo $td;?>" name="td"  placeholder="To Date"  class="form-control input-md js_datepicker">
                        </div>
                    </div>
                </form>
            </div>
        </div>



<!-- <p class="ajax_notice">Only keyword is functional right this time.</p>-->


        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th width="40">ID</th>
                    <th width="90">Reg.Date</th>
                    <th width="120">Role</th>
                    <th>Name</th>
                    <th>Email Address </th>
                    <th>Contact</th>                    
                    <th width="100">Total Post </th>
                    <th width="200">Action </th>
                </tr>   
            </thead>
            <tbody>
                <?php foreach ($users_data as $user) { ?>
                    <tr>
                        <td><?php echo $user->id; ?></td>
                        <td><?php echo globalDateFormat($user->created); ?></td>
                        <td><?php echo Users_helper::getRoleNameByID($user->role_id); ?></td>
                        <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                        <td><?php echo $user->email; ?></td>
                        <td><?php echo $user->contact; ?></td>
                        <td><a href=" <?php echo base_url('/admin/posts/?id='.$user->id);?>"><span class="badge"><?php echo Users_helper::getTotalPostByUserID($user->id); ?></span></a></td>
                        <td><?php
                            if ($user->is_publish == 'Pending' && in_array($user->role_id, [14, 8, 17, 15, 16])){
                                echo anchor(site_url(Backend_URL . 'users/change-profile-status/' . $user->id.'/Publish'), 'Make Approve', 'class="btn btn-xs btn-default"');
                            } elseif ($user->is_publish == 'Publish' && in_array($user->role_id, [14, 8, 17, 15, 16])){
                                echo anchor(site_url(Backend_URL . 'users/change-profile-status/' . $user->id.'/Pending'), 'Make Pending', 'class="btn btn-xs btn-default"');

                            }
                            if ($user->role_id == 4){
                                echo anchor(site_url(Backend_URL . 'users/document_list/' . $user->id), 'Document', 'class="btn btn-xs btn-default"');
                            }
                            if ($user->role_id == 16){
                                echo anchor(site_url(Backend_URL . 'users/clearing-agent-product/' . $user->id), 'Products', 'class="btn btn-xs btn-default"');
                            }elseif ($user->role_id == 17){
                                echo anchor(site_url(Backend_URL . 'users/verifier-agent-product/' . $user->id), 'Products', 'class="btn btn-xs btn-default"');
                            }elseif ($user->role_id == 15){
                                echo anchor(site_url(Backend_URL . 'users/shipping-agent-product/' . $user->id), 'Products', 'class="btn btn-xs btn-default"');
                            }
                            echo anchor(site_url(Backend_URL . 'users/profile/' . $user->id), '<i class="fa fa-fw fa-external-link"></i> View', 'class="btn btn-xs btn-default"');
                            echo anchor(site_url(Backend_URL . 'users/update/' . $user->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                            echo anchor(site_url(Backend_URL . 'users/delete/' . $user->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                            ?>                                                      
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>     



        <div class="row" style="padding-top: 10px; padding-bottom: 10px; margin: 0;">
            <div class="col-md-6">
                <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>
            </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </div>
</section>
<script>
    $(window).on('load',function (){
        date_range($('select[name="range"]').val())
    })
    function date_range(range){
        var range = range;
        if( range == 'Custom'){
            $('#custom').css('display','block');
        } else {
            $('#custom').css('display','none');
        }
    }
</script>