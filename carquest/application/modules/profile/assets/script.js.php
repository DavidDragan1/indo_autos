<script>
    
function update_profile() {
    var formData = jQuery('#update_profile_info').serialize();
    jQuery.ajax({
        url: 'admin/profile/update',
        type: "POST",
        dataType: 'json',
        data: formData,
        beforeSend: function () {
            jQuery('#ajax_respond')
                    .html('<p class="ajax_processing">Loading...</p>')
                    .css('display','block');
        },
        success: function ( jsonRespond ) {
            jQuery('#ajax_respond').html( jsonRespond.Msg );
            if(jsonRespond.Status === 'OK'){                
                setTimeout(function () {
                    jQuery('#ajax_respond').slideUp( );                    
                }, 2000);
            }                                           
        }
    });
    return false;
}

function isCheck( day ){                                
        var yes = $('[name='+ day +']').is(":checked");     
       
        if( yes ){
           $('.'+day).css('opacity','0.2'); 
        } else {
           $('.'+day).css('opacity','1');  
        }             
}

</script>

