<script>
jQuery.noConflict();
jQuery('#signin').on('click', function(e){       
    e.preventDefault();    
    var credential = jQuery('#credential').serialize();    
    //alert( credential );
    
   jQuery.ajax({
        url: 'auth/login',
        type: "POST",
        dataType: "json",
        cache: false,
        data: credential,
        beforeSend: function(){
            jQuery('#respond').html('<p class="ajax_processing text-warning">Please Wait... Checking....</p>');
        },
        success: function( jsonData ){
            if(jsonData.Status === 'OK'){
                jQuery('#respond').html( jsonData.Msg );   
                <?php $goto = @$_GET['goto'];
                if(@$_SERVER['HTTP_REFERER'] && (@$_SERVER['HTTP_REFERER'] == site_url('driver-hire'))){ ?>
                        window.location.href = '<?php echo  @$_SERVER['HTTP_REFERER']; ?>';
                <?php } elseif($goto == 'mechanic'){ ?>
                    window.location.href = '<?php echo  site_url('mechanic'); ?>'
               <?php  } else { ?>
                        location.reload();    
                <?php } ?>
                             
            } else {
                jQuery('#respond').html( jsonData.Msg );    
            }                                    
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            jQuery('#respond').html( '<p> XML: '+ XMLHttpRequest + '</p>' );
            jQuery('#respond').append( '<p>  Status: '+textStatus + '</p>' );
            jQuery('#respond').append( '<p> Error: '+ errorThrown + '</p>' );            
        }  
    });        
});


    function  update_profile() {
        var formData = jQuery('#update_profile_info').serialize();
        jQuery.ajax({
            url: 'my_account/update_user_profile',
            type: "post",
            dataType: 'json',
            data: formData,
            beforeSend: function () {
                jQuery('#ajax_respond')
                        .html('<p class="ajax_processing">Updating...</p>')
                        .css('display','block');
            },
            success: function ( jsonRespond ) {
                jQuery('#ajax_respond').html( jsonRespond.Msg );
                if(jsonRespond.Status === 'OK'){
                   setTimeout(function() {	jQuery('#ajax_respond').slideUp('slow'); }, 2000);	  
                }                               	
            }
        });
        return false;
    }
 
    function  password_change() {
        var formData = jQuery('#update_password').serialize();
        jQuery.ajax({
            url: 'my_account/change_password',
            type: "POST",
            dataType: 'json',
            data: formData,
            beforeSend: function () {
                jQuery('#ajax_respond')
                        .html('<p class="ajax_processing">Updating...</p>')
                        .css('display','block');
            },
            success: function ( jsonRespond ) {
                jQuery('#ajax_respond').html( jsonRespond.Msg );
                if(jsonRespond.Status === 'OK'){
                   setTimeout(function() {	jQuery('#ajax_respond').slideUp('slow'); }, 2000);	  
                }                               	
            }
        });
        return false;
    }    
    
    
    
    jQuery('.open-mail').on('click', function(){
	    var mail_id = jQuery(this).data('mailid');     
        
        jQuery('#manageReport').modal({
            show: 'false'
    }).load('my_account/read_mail/' + mail_id );        
     
});    
    
    
    
    
    
 
</script>
