<script>
function statusUpdate(post_id, status){
    var status  = status;
    var post_id  = post_id;

    jQuery.ajax({
            url: 'admin/posts/statusUpdate',
            type: 'POST',
			dataType: "json",
            data: { status: status, post_id: post_id  },
            beforeSend: function(){
                jQuery('#active_status_'+ post_id ).html('Updating...');
            },
            success: function ( jsonRespond ) {
                jQuery('#active_status_'+post_id).html(jsonRespond.status);
                //jQuery('#expiry_date_'+post_id).text(jsonRespond.expiry_date);
				//alert(data);
                if(status == 'Active'){
                    jQuery('#active_status_'+post_id ).load( 'mail/activation_notice/' + post_id );
                }

                //location.reload();
            }
    });
}



function DegitOnly(e){
	var unicode = e.charCode ? e.charCode : e.keyCode;
	if (unicode!=8 && unicode!=9)//Excepting the backspace and tab keys
	{
		if (unicode<46||unicode>57||unicode==47) //If not a number or decimal point
		return false //Disable key press
	}
}


function get_model(id, type_id) {
    var vehicle_type_id = type_id;
    jQuery.ajax({
        url: 'admin/brands/brands_by_vehicle_model/',
        type: "POST",
        dataType: "text",
        data: {id: id, vehicle_type_id: vehicle_type_id},
        beforeSend: function () {
            jQuery('#model_id').html('<option value="0">Loading...</option>');
        },
        success: function (response) {
            jQuery('#model_id').html(response);
        }
    });
}

 function setExpireDate(action){
    var action = action;
    if( action === 'Extended'){
        $('#extended').css('display','block');
    } else {
        $('#extended').css('display','none');
    }
}

function mark_featured( post_id ){
    jQuery.ajax({
        url: 'admin/posts/mark_featured',
        type: "POST",
        dataType: "json",
        data: {post_id: post_id },
        beforeSend: function () {
            jQuery('#featured_'+post_id).html('Loading...');
        },
        success: function (jsonRepond ) {
           jQuery('#featured_'+post_id).html( jsonRepond.Msg  );
        }
    });



}


var checked = false;
function checkedAll() {
    if (checked == false) {
        checked = true
    } else {
        checked = false
    }
    for (var i = 0; i < document.getElementById('all_posts_select').elements.length; i++) {
        document.getElementById('all_posts_select').elements[i].checked = checked;
    }
}


jQuery('#open_dialog').on('click', function(){

    var formData = jQuery('#all_posts_select').serialize();

    jQuery.ajax({
        url: 'admin/posts/bulk_action',
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


function upload_new_post(){
  //preventDefault();
  var formData = jQuery('#upload_new').serialize();
  //alert( formData );
  var error = 0;

  var location_id = jQuery('#location_id').val();
  if(location_id == ""){
      error = 1;
      jQuery('#location_id').addClass('required');
  } else {
      jQuery('#location_id').removeClass('required').addClass('required_pass');
  }

  var autocomplete = jQuery('#location').val();
  if(!location){
      error = 1;
      jQuery('#location').addClass('required');
  } else {
      jQuery('#location').removeClass('required').addClass('required_pass');
  }

  var vehicle_type_id = jQuery('#vehicle_type_id').val();
  if(vehicle_type_id == '0'){
      error = 1;
      jQuery('#vehicle_type_id').addClass('required');
  } else {
      jQuery('#vehicle_type_id').removeClass('required').addClass('required_pass');
  }

  var condition = jQuery('#condition').val();
  if(condition == '0'){
      error = 1;
      jQuery('#condition').addClass('required');
  } else {
      jQuery('#condition').removeClass('required').addClass('required_pass');
  }

  if(error){
     return false;
  } else {
      jQuery('#upload_new').submit();
  }


}





    function date_range(range){
        var range = range;
        if( range == 'Custom'){
            $('#custom').css('display','block');
        } else {
            $('#custom').css('display','none');
        }
    }


   function isCheck( day ){
        var yes = $('[name='+ day +']').is(":checked");

        if( yes ){
           $('.'+day).css('opacity','0.2');
        } else {
           $('.'+day).css('opacity','1');
        }


   }


   function towing_servic(service, selected){

       var x = (service.value || service.options[service.selectedIndex].value);  //crossbrowser solution =)
        $.ajax({
                url: "posts/posts_frontview/towing_type_of_services?cat_id="+x + '&selected='+selected,
                type: "GET",
                dataType: "html",
                success: function (html) {
                $('#towing_type_of_service_id').html(html);
                }
            });


   }
//   $('#towing_service_id').change(function(){
//       $("#testLoad").load("test.html #" + divId + '');
//   });


    function homepagePositionUpdate(post_id, position){
        var position  = position;
        var post_id  = post_id;

        jQuery.ajax({
            url: 'admin/posts/homepagePositionUpdate',
            type: 'POST',
            dataType: "json",
            data: { position: position, post_id: post_id  },
            beforeSend: function(){
                jQuery('#active_status_'+ post_id ).html('Updating...');
            },
            success: function ( jsonRespond ) {
                jQuery('#active_status_'+post_id).html(jsonRespond.status);

                location.reload();
            }
        });
    }
</script>
