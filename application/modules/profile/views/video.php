<?php load_module_asset('profile', 'css' );?>
<?php load_module_asset('profile', 'js' );?>

<section class="content-header">
    <h1>Trade Seller <small>Update page</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-user"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL . '/profile/' ?>"><i class="fa fa-dashboard"></i> Profile</a></li>
        <li class="active">Seller</li>
    </ol>
</section>

<section class="content">
    <?php echo Profile_helper::makeTab('video'); ?>                                                                                                            
    <div class="box no-border">        
        <div class="box-body">
            <div id="response_upload"></div> 
            <form id="update_company_info" name="business_profile" action="" method="POST">
                <div class="row">

                    <div class="col-md-12">
                                                     
                        
                        <?php
                            $isExistVideoGalley = Modules::run('Profile/isExistVideoGalley', getLoginUserData('user_id') );
                            $retriveVideos = Modules::run('Profile/getAllVideoGallery', getLoginUserData('user_id'));
                        ?>

                        
                <div class="form-group">        
                    <label  class="col-sm-2 control-label">Video Id :</label>
                    <div class="col-sm-10">
                        <em>(https://www.youtube.com/watch?v=<strong>ObWiQPqbFqo</strong>)</em><br>

                        <?php if ($isExistVideoGalley > 0) : ?>
                            <?php
                            $numItems = count($retriveVideos);
                            $i = 0;
                            foreach ($retriveVideos as $video) {
                                $i++;
                                ?>



                                <div class="field">
                                    <input class="form-control pr_tg" id="" name="video_id[]" type="text" placeholder="Video ID" value="<?php echo $video->video; ?>"/>                            

                                    <i class="<?php
                                    if ($i == 1) {
                                        echo 'fa fa-2x fa-plus-square-o add-more text-success';
                                    } else {
                                        echo 'fa fa-minus-square-o remove-me text-danger';
                                    }
                                    ?>" type="button"></i>
                                </div>                        
                            <?php } ?>




<?php else : ?>

                            <div class="field">
                                <input class="form-control pr_tg" id="" name="video_id[]" type="text" placeholder="Video ID"/>                            
                                <i class="fa fa-2x fa-plus-square-o add-more text-success" type="button"></i>
                            </div>


<?php endif; ?>
                        <div id="after_append"></div>

                    </div>
                </div>

                        
                     
                
                        
                            
                    </div>

              </div>
                
      
                
                <!--Video Upload End-->

                <div class="row" style="margin-top: 15px; ">
                    <div class="col-md-12 text-right">
                        <button type="submit"  class="btn btn-primary"><i class="fa fa-cloud-upload"></i> Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



      
</section>


<script>
    var $ = jQuery; 
    $('#update_company_info').on('submit', function () {
       // updateBeforeSend();
        var formData = $('#update_company_info').serialize();
                
        $.ajax({
            url: "admin/profile/video_update",   // Url to which the request is send
            type: "POST",                           // Type of request to be send, called as method
            data: new FormData(this),               // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            dataType: 'json',               // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,                     // The content type used when sending data to the server.
            cache: false,                           // To unable request pages to be cached
            processData: false,
            beforeSend: function () {
                $('#response_upload')
                        .css('display','block')        
                        .html('<p class="ajax_processing">Loading...</p>');
            },
            success: function ( jsonRespond ) {
                
                if( jsonRespond.Status === 'OK'){
                  $('#response_upload').html( jsonRespond.Msg );
                  setTimeout(function() { $('#response_upload').slideUp('slow'); }, 2000);
                } else {
                   $('#response_upload').html( jsonRespond.Msg ); 
                }
                           
                
            }
        });
        
        return false;
        
    });

       

                
    // Video Upload            
    $(".add-more").click(function (e) {
        e.preventDefault();
        var newHtml = $('<div class="field">'
                + '<input class="form-control pr_tg" id="" name="video_id[]" type="text" placeholder="Video ID"/>'

                + '<i class="fa fa-minus-square-o remove-me text-danger" ></i><div class="row"></div></div>');
        $('#after_append').append(newHtml);
        $('.remove-me').click(function (e) {
            e.preventDefault();
            $(this).parent('div').remove();
        });
    });
    $('.remove-me').click(function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
    });


            
</script>