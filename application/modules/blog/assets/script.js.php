<script>
    function statusUpdate(post_id, status){
        var status  = status; 
        var post_id  = post_id; 

        jQuery.ajax({
                url: 'admin/blog/update_status',
                type: 'POST',
                dataType: "json",
                data: { status: status, post_id: post_id  },
                beforeSend: function(){
                    jQuery('#active_status_'+ post_id ).html('Updating...');
                },
                success: function ( jsonRespond ) {
                    jQuery('#active_status_'+post_id).html(jsonRespond.Status);                  
                    jQuery('#active_status_'+post_id).removeClass( 'btn-default');
                    jQuery('#active_status_'+post_id).removeClass( 'btn-danger');
                    jQuery('#active_status_'+post_id).removeClass( 'btn-success');
                    jQuery('#active_status_'+post_id).addClass(  jsonRespond.Class );
                    
                }
        });   
    } 
    
    
    

    
</script>

