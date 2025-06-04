<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Mechanic Request</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Chat</li>
    </ol>
</section>

<section class="content">       
    <div class="box">            
     

        <div class="box-body">
         
            
            <div class="response"></div>
            <div class="table-responsive">
           <?php if($requests): ?>
            <table class="table table-striped table-hover table-condensed">                           
                <thead>
                    <tr>                        
                        <th width="40">ID</th>
                        <th width="150">Requester Name</th>
                        <th width="150">Package Name</th>
                        <th width="150">Payment Status</th>                        
                        <th width="150">Created</th>                        
                        <th width="150">Status</th>                        
                        <th width="150">Action</th>                        
                    </tr>
                </thead>
                <tbody>
                                        
                <?php foreach ($requests as $request) { ?>
                    <tr>
                        <td><?php echo $request->id; ?></td>
                        <td><?php echo getUserNameByUserId($request->requester_id); ?></td>
                        <td><?php echo getPackageNameApi( $request->package_id); ?></td>
                        <td><?php echo $request->payment; ?></td>
                        <td><?php echo globalDateFormat($request->created); ?></td>
                        <td><?php echo $request->status; ?></td>
                        <td>
                            <button type="button" onclick="updateStatus(<?php echo $request->id; ?>, 'Approved')" 
                                    class="btn btn-xs btn-success">Click to Active</button>
                                    <button type="button" onclick="updateStatus(<?php echo $request->id; ?>, 'Canceled')" 
                                            class="btn btn-xs btn-warning"><i class="fa fa-ban"></i></button>
                                    <button type="button" onclick="deletePermission(<?php echo $request->id; ?>)" 
                                            class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                <?php } ?>
                    </tbody>
                </table>
                <?php else: ?> 
                    <p class="ajax_notice">No Record Found</p>
                <?php endif; ?> 
                
              
                
               
            </div>

            <div id="ajax_respond"> </div>
                 
       </div>
  
    </div>
</section>


<script>
    function updateStatus(id, status){ 
         jQuery.ajax({
            url: 'admin/chat/chat_status_update',
            type: 'POST',
            dataType: "text",
            data: { id: id, status: status  },
            beforeSend: function(){
                jQuery('.response' ).html('<p class="ajax_processing">Updating...</p>');
            },
            success: function ( res) {     
                 jQuery('.response' ).html(res);
                 setTimeout(function(){
                     location.reload();
                 },2000); 
                
                 
            }
    });  
 }
    function deletePermission(id){ 
         jQuery.ajax({
            url: 'admin/chat/chat_status_delete',
            type: 'POST',
            dataType: "text",
            data: { id: id  },
            beforeSend: function(){
                jQuery('.response' ).html('<p class="ajax_processing">Deleting...</p>');
            },
            success: function ( res) {     
                 jQuery('.response' ).html(res);
                 setTimeout(function(){
                     location.reload();
                 },2000); 
                
                 
            }
    });  
 }
       

</script>