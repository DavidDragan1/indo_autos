<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

load_module_asset('posts', 'css');
?>
<style>
    img#previewing1 {
        max-width: 100%;
        margin-top: 20px;
    }
</style>
<section class="content-header">
    <h1> Posts  <small>Update</small>  <a href="<?php echo site_url('admin/posts') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL; ?>posts/update_photo">Update Service</a></li>
        <li class="active">Set Photo</li>
    </ol>
</section>
<section class="content">

    <div class="step_holder">        
        <?php echo postUpdateTabs('update_photo', $this->uri->segment(4) ); ?>                             
    </div>


    
    <div class="box">
        
        <div class="box-body">                        
            
            <div class="box-body">                        
                <div class="col-md-12" style="margin-top: 50px;">
                    <form method="post" id="new_post" name="fileinfo" enctype="multipart/form-data">                                
                        <input type="hidden" name="post_id" value="<?php echo $this->uri->segment(4); ?>">                  
                        <input type="hidden" value="" name="encoded" id="encoded">
                        
                        <div class="col-md-12" style="text-align: center">
                            <div id="image_preview1">
                                <img id="previewing1" width="180" src="uploads/no-thumb.jpg" alt="Thumb">
                            </div>
                        </div>


                        <div class="col-md-12" style="padding-top:50px;">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="btn btn-default btn-file" style="width: 100%">
                                            <i class="fa fa-picture-o"></i> Select Photo  
                                            <input type="file" name="file" id="profilePic" value="">                                                                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Rotate Image: </label>
                                    <label><input type="radio" class="btnRotate" name="rotate" value="270" onClick="rotateImage(this.value);" /> <i class="fa fa-undo" aria-hidden="true"></i> &nbsp;Right &nbsp;&nbsp;&nbsp;</label>
                                    <label><input type="radio" class="btnRotate" name="rotate" value="360" checked="checked" onClick="rotateImage(this.value);" /> <i class="fa fa-picture-o" aria-hidden="true"></i>&nbsp; Original &nbsp;&nbsp;&nbsp;</label>
                                    <label><input type="radio" class="btnRotate" name="rotate" value="180" onClick="rotateImage(this.value);" /> <i class="fa fa-random" aria-hidden="true"></i> &nbsp;Flip &nbsp;&nbsp;&nbsp;</label>
                                    <label><input type="radio" class="btnRotate" name="rotate" value="90" onClick="rotateImage(this.value);" /> <i class="fa fa-repeat" aria-hidden="true"></i> &nbsp;Left &nbsp;&nbsp;&nbsp;</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-success" onclick="startUpload();">
                                <i class="fa fa-cloud-upload"></i> Upload</button>
                            </div>
                        </div>                    


                        <div class="col-md-12">
                            <strong>Image Size: To get best view, Image size should be 875 pixel by 540 pixel</strong>
                        </div>


                        <div class="col-md-9">
                            <div id="ajax_respond"></div>
                            <div id="respondImg"><img src="assets/admin/icons/progress.gif"/> Uploading &AMP; Processing Photo</div>
                        </div>
                        <div class="clearfix"></div>  
                    </form>
                </div>                        


                    <div class="row" class="clearfix">
                        <div class="col-md-12" style="margin-top: 20px;">
                            <div id="get_service_photos" class="clearfix">                            
                                <?php echo Modules::run('posts/get_service_photo', $this->uri->segment(4)); ?>
                            </div> 
                        </div> 
                    </div> 
                </div>
            
            
            </div>                                                                                                                                                                                        
        </div>                                              
</section>
<script>

    var $ = jQuery;
    $("#profilePic").change(function () {

        var file        = this.files[0];
        var imagefile   = file.type;
        var match       = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile === match[0]) || (imagefile === match[1]) || (imagefile === match[2]))){
            $('#previewing1').attr('src', 'noimage.png');
            return false;
        } else {
            var reader      = new FileReader();
            reader.onload   = imageIsLoaded1;
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    
    function imageIsLoaded1(e) {
        $("#profilePic").css("color", "green");
        $('#image_preview1').css("display", "block");
        $('#previewing1').attr('src', e.target.result);
        
        var width = $(window).width();
        
        if( width <= 767 ){
            $('#previewing1').attr('width', '100%');
        }else{
            $('#previewing1').attr('width', '60%');
        }
    }
    
    function rotateImage(degree) {
	$('#previewing1').animate({  transform: degree }, {
        step: function(now,fx) {
            $(this).css({
                '-webkit-transform':'rotate('+now+'deg)', 
                '-moz-transform':'rotate('+now+'deg)',
                'transform':'rotate('+now+'deg)'
            });
        }
        });
    }

    function startUpload() {        
          //alert(imageData);       
          var imageData = $('#previewing1').attr('src');
          //alert(imageData);
        $('#encoded').attr('value',imageData);
        
        var post_id = <?php echo $this->uri->segment(4); ?>;
        var fd = new FormData(document.getElementById("new_post"));
        
        
        
        jQuery.ajax({
            url: "<?php echo Backend_URL; ?>posts/upload_service_photo/"+post_id,
            type: "POST",
            dataType: "json",
            data: fd,
            enctype: 'multipart/form-data',
            beforeSend: function () {
                jQuery('#respondImg')
                .css('display', 'block');
            },
            success: function (jsonData) {
                jQuery('#respondImg').css('display','none');
                jQuery('#ajax_respond').html(jsonData.Msg);
                
                if (jsonData.Status === 'OK') {
                    jQuery('#respondImg').css('display','none');
                    jQuery('#get_service_photos').html(jsonData);
                    jQuery('#get_service_photos').load('posts/get_service_photo_reload/'+post_id);
                  
                 }                                 
            },
            
            processData: false, // tell jQuery not to process the data
            contentType: false   // tell jQuery not to set contentType
        });
        return false;
    }

    function deletePhoto( id, photo ){
        
        var yes     = confirm ('Are you sure?');
        //alert( id );
        
        if( yes ){
            jQuery.ajax({
                url: "<?php echo Backend_URL; ?>posts/delete_service_photo",
                type: "POST",
                dataType: 'json',
                data: {id: id, photo: photo},
                beforeSend: function () {                    
                    jQuery('#photo_' + id ).css( 'opacity', '0.5');    
                },
                success: function (jsonRepond) {
                    if( jsonRepond.Status === 'OK' ){
                        jQuery('#photo_' + id ).fadeOut(1000);    
                    } else {
                        alert('Something went wrong! Please check');
                    }
                }
            }); 
        }
        
    }
    
        function markActive( id, name ){
        var post_id  = <?php echo $this->uri->segment(4); ?>;      
        
        jQuery.ajax({
            url: "<?php echo Backend_URL; ?>posts/mark_as_feature",
            type: "POST",
            dataType: 'json',
            data: {id: id, post_id: post_id, name: name},
            beforeSend: function () {
                jQuery(".markActive").html("<i class=\"fa fa-check-square-o\"></i> Feature This");                
                jQuery('#photo_' + id +' span' ).text( 'Loading...');    
            },
            success: function (data) {
                jQuery('#photo_' + id +' span' ).html( '&radic; Featured' );                
            }            
        });                
    }
   
    

     function showBox(){
        $('.showBox').slideDown('slow');
     }
    
</script>
