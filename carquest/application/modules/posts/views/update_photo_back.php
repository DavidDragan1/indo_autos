<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

load_module_asset('posts', 'css');
?>

<script src="assets/admin/jquery.cropit.js"></script>

<style>
      .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 800px;
        height: 540px;
        
      }
     .cropit-preview-image-container {
        cursor: move;
      }
.showBox { display: none; }
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
            <div class="col-md-12" style="margin-bottom: 15px;">  
                
                

                
                <form method="post" id="new_post" name="fileinfo" onchange="showBox();" >                                
                    <input type="hidden" name="post_id" value="<?php echo $this->uri->segment(4); ?>">                    
                  <input type="hidden" value="" name="encoded" id="encoded">
                    
                  
                    <div class="image-editor">
                     
                        <input type="file" name="file"  class="cropit-image-input">
                      <div class="showBox">  
                        <div class="cropit-preview"></div>   
                        <div class="image-size-label" style="margin-top: 10px; ">
                            Resize image
                        </div>
                        <input type="range" class="cropit-image-zoom-input">
                        <button type="button" class="rotate-ccw" style="margin-top: 10px; "><i class="fa fa-undo" aria-hidden="true"></i></button>
                        <button type="button"  class="rotate-cw" style="margin-top: 10px; "><i class="fa fa-repeat" aria-hidden="true"></i></button>
                     </div>
                    </div>
                  
                    
                    
                    
                    <div class="row" style="padding-top:20px;">
                        <div class="col-md-3">                             
                            <button type="button" class="btn btn-success btn-lg" onclick="startUpload();"><i class="fa fa-cloud-upload"></i> Upload</div>
                        </div>
                        <div class="col-md-9">
                            <div id="respondImg"><img src="assets/admin/icons/progress.gif"/> Uploading &AMP; Processing Photo</div>
                        </div>
                        <div class="clearfix"></div>                        
                    </div>                        
                </form>
                
                
   
                <div id="get_service_photos"><p>Additional Picture</p>
                    <?php echo Modules::run('posts/get_service_photo', $this->uri->segment(4)); ?>
                </div> 
            </div>                                                                                                                                                                                        
        </div>                        
    </div>                                               
</section>
<script>

var $ = jQuery;
//    $(document).ready(function () {
//        $('#myfile').change(function (evt) {
//        });
//    });
    
     var $ = jQuery;
      $(function() {
        $('.image-editor').cropit({
          imageState: {
            src: 'uploads/no-photo.jpg',
          },
        });

// $('.image-editor').cropit('previewSize', { width: 800, height: 540 });

        $('.rotate-cw').click(function() {
          $('.image-editor').cropit('rotateCW');
        });
        $('.rotate-ccw').click(function() {
          $('.image-editor').cropit('rotateCCW');
        });

//        $('.export').click(function() {
//          var imageData = $('.image-editor').cropit('export');
//         // alert(imageData);
//          $('#xxx').attr('value','imageData');
//          // window.open(imageData);
//        });
      });

    function startUpload() {        
      var imageData = $('.image-editor').cropit('export');
          //alert(imageData);
        $('#encoded').attr('value',imageData);
        
        var post_id = <?php echo $this->uri->segment(4); ?>;
        var fd = new FormData(document.getElementById("new_post"));
        jQuery.ajax({
            url: "<?php echo Backend_URL; ?>posts/upload_service_photo/"+post_id,
            type: "POST",
            dataType: "text",
            data: fd,
            enctype: 'multipart/form-data',
            beforeSend: function () {
                jQuery('#respondImg')
                        .css('display', 'block');
            },
            success: function (jsonData) {
                //if (jsonData.Status === 'OK') {
                    jQuery('#respondImg').css('display','none');
                    jQuery('#get_service_photos').html(jsonData);
                    //jQuery('#get_service_photos').load('posts/get_service_photo_reload/'+post_id);
                //}                                 
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
    
        function markActive( id ){                     
        var post_id  = <?php echo $this->uri->segment(4); ?>;      
        
        jQuery.ajax({
            url: "<?php echo Backend_URL; ?>posts/mark_as_feature",
            type: "POST",
            dataType: 'json',
            data: {id: id, post_id: post_id},                        
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
