<?php load_module_asset('profile', 'css'); ?>
<?php load_module_asset('profile', 'js'); ?>

<section class="content-header">
    <h1>User Video <small>Update page</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-user"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL . '/users/' ?>"><i class="fa fa-dashboard"></i> Users</a></li>        
        <li class="active">Video</li>
    </ol>
</section>

<section class="content">
    <?php echo Users_helper::makeTab($this->uri->segment('4'),'video'); ?>                                                                                                            
    <div class="box no-border">        
        <div class="box-body">
            <div id="response_upload"></div> 
            <form id="update_company_info" name="business_profile" action="" method="POST">
                <input type="user_id" value="<?php echo $this->uri->segment('4'); ?>"/>
                <div class="row">

                    <div class="col-md-12"> 
                        
                            
                            <div class="col-sm-8">
                                <h2>Update your youtube's video here:</h2>                                                                                                                                                                                                                                       
                                    <?php
                                    $numItems = count($videos);
                                    $i = 0;
                                    foreach ($videos as $video) {
                                        $i++;
                                        ?>
                                        <div class="form-group">                                
                                            <div class="input-group">
                                              <span class="input-group-addon">https://www.youtube.com/watch?v=</span>
                                              <input class="form-control" name="video_id[]" placeholder="E.g. ObWiQPqbFqo" value="<?php echo $video->video; ?>" maxlength="12" id="prependedInput" type="text">
                                              <span class="input-group-addon no-padding"><span class="btn no-margin btn-xs btn-default remove-me"><i class="fa fa-trash-o "></i> Remove</span></span>
                                            </div>
                                        </div>                                       
                                    <?php } ?>
                                
                                        <div class="form-group">                                
                                            <div class="input-group">
                                              <span class="input-group-addon">https://www.youtube.com/watch?v=</span>
                                              <input class="form-control" placeholder="E.g. ObWiQPqbFqo" id="prependedInput"  maxlength="12" type="text">
                                              <span class="input-group-addon no-padding"><span class="btn no-margin btn-xs btn-default add-more"><i class="fa fa-plus "></i> Add New</span></span>
                                            </div>
                                        </div>
                                                            
                                <div id="after_append"></div>

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
        
        var formData = $('#update_company_info').serialize();

        $.ajax({
            url: "admin/users/video_update",
            type: "POST", 
            data: formData, 
            dataType: 'json',
                                    
            beforeSend: function () {
                $('#response_upload')
                        .css('display', 'block')
                        .html('<p class="ajax_processing">Loading...</p>');
            },
            success: function (jsonRespond) {
                
                $('#response_upload').html(jsonRespond.Msg);
                if (jsonRespond.Status === 'OK') {                   
                    setTimeout(function () {
                        $('#response_upload').slideUp('slow');
                    }, 2000);
                }  
            }
        });

        return false;

    });




    // Video Upload            
    $(".add-more").click(function (e) {
        e.preventDefault();
        var newHtml = $(
                
                '<div class="form-group"><div class="input-group">'
                + '<span class="input-group-addon">https://www.youtube.com/watch?v=</span>'
                + '<input class="form-control" name="video_id[]" placeholder="E.g. ObWiQPqbFqo" id="prependedInput" type="text">'
                + '<span class="input-group-addon no-padding"><span class="btn no-margin btn-xs btn-default remove"><i class="fa fa-trash-o "></i> Remove</span></span>'
                + '</div></div>'
        );
        
        
        
        $('#after_append').append(newHtml);
        
        $('.remove').click(function (e) {
            e.preventDefault();
          
            $(this).parent().parent().parent().remove();
        });
    });
    
    
     

    


</script>