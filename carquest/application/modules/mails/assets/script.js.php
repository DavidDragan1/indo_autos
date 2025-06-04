<script>
jQuery('.open-mail').on('click', function(){
	var mailid = jQuery(this).data('mailid');
	window.location.href = "admin/mails/read/"+mailid;
	// alert( mailid );
	// <a href="admin/mails/read/mails->id; 
});

function change_Important( id, impo ){
	jQuery.ajax({
		url: "admin/mails/update_important_ajax",
		type: "POST",
		dataType: 'json',
		data: { id : id },
		success: function(jsonData) {

			if(jsonData.Status=="OK"){
                            if(jsonData.Msg == 'Important'){
                                jQuery('#star_'+ id + ' i').removeClass('fa-star-o');
                                jQuery('#star_'+ id + ' i').addClass('fa-star');
                            } else {
                                jQuery('#star_'+ id + ' i').removeClass('fa-star');
                                jQuery('#star_'+ id + ' i').addClass('fa-star-o');
                            }
			}
		}
	});
}
</script>