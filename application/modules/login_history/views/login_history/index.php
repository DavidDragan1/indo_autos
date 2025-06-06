<?php defined('BASEPATH') OR exit('No direct script access allowed');
load_module_asset('users','css'); ?>


<section class="content-header">
    <h1> Login history  <small>Control panel</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li><li class="active">Login history</li>
    </ol>
</section>

<section class="content">    
    <ul class="tabsmenu">
        
        <li><a class="<?php echo  ($this->input->get('most_login') != 'yes') ? 'active': '' ; ?>" href="<?php echo Backend_URL.'login_history' ?>"> All</a></li>
        <li> <a class="<?php echo  ($this->input->get('most_login') == 'yes') ? 'active': '' ; ?>"  href="<?php echo Backend_URL.'login_history?most_login=yes' ?>"> Most Login Users</a></li>
    </ul>

    <div class="box no-border">            
        
        
        <?php if( $this->input->get('most_login') != 'yes' ): ?>
        <div class="filter_row">
            <div class="row clearfix">
                <div class="col-md-12 no-padding">
                    <form method="get" name="report" action="">
                        
                        <div class="col-md-7">
                                <div class="col-md-3">
                                    <select name="role_id" class="form-control">
                                        <?php echo Users_helper::getRoles($this->input->get('role_id')); ?>
                                    </select>
                                </div>

                                

                                 <?php $ragne = $this->input->get('range'); ?>

                                <div class="col-md-3">
                                    <select name="range" class="form-control" onchange="date_range(this.value)">
                                        <?php echo Users_helper::getRegistraionRange($ragne); ?>
                                    </select>
                                </div>

                                <div id="custom" <?php echo ($ragne == 'Custom') ? '' : ' style="display: none;"'; ?>>
                                    <div class="col-md-3">
                                        <input type="text" name="fd" placeholder="From Date" value="<?php echo $this->input->get('fd'); ?>"  class="form-control input-md dp_icon js_datepicker"> 
                                    </div>
                                    <div class="col-md-3">                 
                                        <input type="text" name="td"  placeholder="To Date" value="<?php echo $this->input->get('td'); ?>"   size="10" class="form-control dp_icon input-md js_datepicker">    
                                    </div>                
                                </div>
                            

                            </div>
                        
                        
                        <div class="col-md-5 pull-right">
                            <div class="row">
                                <div class="col-md-4">
                                        <select name="device" class="form-control">
                                            <?php echo getDeviceList( $this->input->get('device') ); ?>
                                        </select>
                                    </div>
                                <div class="col-md-4">
                                    <select name="browser" class="form-control">
                                        <?php echo getBrowserList( $this->input->get('browser') ); ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <input type="submit" class="btn btn-primary" name="go" value="Filter">
                                    <input type="button" class="btn btn-default" value="Reset" onclick="location.href = 'admin/login_history';">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <?php endif; ?>
        <form method="POST" id="all_log_select" style="padding-bottom:  10px;">
          <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <?php if( $this->input->get('most_login') != 'yes' ): ?>
                                        <th width="30">#</th>
                                        <th width="40">ID</th>
                                        <?php endif;  ?>
                                        
                                        <th>User Name</th>
                                        <?php if( $this->input->get('most_login') == 'yes' ) : ?>
                                        <th>Count</th>
                                        <?php endif;  ?>
                                        <th>Login Time</th>
                                        <th>Logout Time</th>
                                        <th>IP</th>
                                        <!-- <th>Location</th> -->
                                        <th>Browser</th>
                                        <th>Device</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php 
                                    
                                    foreach ($login_history_data as $login_history) { ?>
                                        <tr>
                                            <?php if( $this->input->get('most_login') != 'yes' ): ?>
                                            <td><input type="checkbox" name="log_id[]" value="<?php echo $login_history->id; ?>"></td>
                                            <td><?php echo $login_history->id; ?></td>
                                            <?php endif;  ?>
                                            
                                            <td><a href="<?php echo Backend_URL . 'users/profile/' . $login_history->user_id; ?>"><?php echo getUserName($login_history->user_id) ?></a></td>
                                            <?php if( $this->input->get('most_login') == 'yes' ) : ?>
                                            <td><span class="badge bg-light-blue"><?php echo $login_history->visit ?></span></td>
                                            <?php endif;  ?>
                                            <td><?php echo globalDateTimeFormat( $login_history->login_time ); ?></td>
                                            <td><?php echo globalDateTimeFormat($login_history->logout_time); ?></td>
                                            <td><?php echo $login_history->ip ?></td>
                                            <!-- <td><?php //echo $login_history->location ?></td> -->
                                            <td><?php echo $login_history->browser ?></td>
                                            <td><?php echo $login_history->device ?></td>
                                            <td>
                                                <?php
                                                // echo anchor(site_url(Backend_URL . 'login_history/read/' . $login_history->id), '<i class="fa fa-fw fa-external-link"></i> View', 'class="btn btn-xs btn-default"');
                                               //  echo anchor(site_url(Backend_URL . 'login_history/update/' . $login_history->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                                                echo anchor(site_url(Backend_URL . 'login_history/delete/' . $login_history->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-default"');
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>


                        
                    </div>
        
    
        <div id="ajax_respond"> </div>
        
              <div class="clearfix" style="padding-top: 10px;  ">                                      
                   <div class="col-md-5">
                       
                       <?php if( $this->input->get('most_login') != 'yes') : ?>
                       <div class="row" style="">
                           <div class="col-md-12">
                            <div class="col-md-3 no-padding">
                                <label class="btn btn-default"><input type="checkbox" name="checkall" onclick="checkedAll();"> Mark All</label>                                                             
                            </div>

                            <div class="col-md-4 no-padding">
                                 <select class="form-control" name="action" >
                                     <option value="0">--Bulk Action--</option>                                     
                                     <option value="Delete">Delete</option>                                                                        
                                 </select>

                             </div>                         
                            <div class="col-md-2 no-padding">
                                 <button type="button" id="open_dialog" class="btn btn-primary btn-flat">Action</button>
                            </div>
                           </div>
                       </div>
                       
                       <?php endif;  ?>
                       
                    </div>
                  <div class="col-md-7">
                      <div class="row">    
                          <div class="col-md-8 text-right">
                                <?php echo $pagination ?>
                            </div> 
                            <div class="col-md-4 text-right">
                                <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>

                            </div>
                                           
                        </div>
                  </div>
                                                
                                  
            </div>
        
        </form>
        
   </div>
    

    
</section>

<script>
    var checked = false;
function checkedAll() {
    if (checked == false) {
        checked = true
    } else {
        checked = false
    }
    for (var i = 0; i < document.getElementById('all_log_select').elements.length; i++) {
        document.getElementById('all_log_select').elements[i].checked = checked;
    }
}


jQuery('#open_dialog').on('click', function(){
    
    var formData = jQuery('#all_log_select').serialize();
    
    jQuery.ajax({
        url: 'admin/login_history/bulk_action',
        type: "POST",
        dataType: "json",
        data: formData,
        beforeSend: function () {
            jQuery('#ajax_respond').html('<p class="ajax_processing">Loading....</p>');
        },
        success: function (jsonRepond ) {                     
           if(jsonRepond.Status === 'OK'){
               jQuery('#ajax_respond').html( jsonRepond.Msg );
               setTimeout(function() {	
                   jQuery('#ajax_respond').fadeOut(); 
                   location.reload();},
                2000);
               
           } else {
               jQuery('#ajax_respond').html( jsonRepond.Msg );
           }
        }
    });        
    
});

 function date_range(range){
     var range = range;
     if( range == 'Custom'){       
      $('#custom').css('display','block');
     } else {      
      $('#custom').css('display','none');
     }
    }
    
</script>