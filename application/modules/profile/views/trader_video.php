<?php load_module_asset('profile', 'js' );?>

<h2 class="breadcumbTitle">My Account</h2>
<!-- .account-area start  -->
<div class="account-area">
    <?php echo Profile_helper::makeNewTab('video'); ?>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="videoGallery">
            <form id="update_company_info" name="business_profile" action="" method="POST">
                <div class="row">
                    <?php
                        $isExistVideoGalley = Modules::run('Profile/isExistVideoGalley', getLoginUserData('user_id') );
                        $retriveVideos = Modules::run('Profile/getAllVideoGallery', getLoginUserData('user_id'));
                    ?>
                    <div class="col-lg-2 col-sm-2">
                        <h3>Video Id :</h3>
                    </div>
                    <div class="col-lg-6 col-sm-10">
                        <div id="response_upload" class="text-center text-success"></div>
                        <em>(https://www.youtube.com/watch?v=<strong>ObWiQPqbFqo</strong>)</em>
                        <?php if ($isExistVideoGalley > 0) : ?>
                        <?php
                            $numItems = count($retriveVideos);
                            $i = 0;

                            foreach ($retriveVideos as $video) {
                                $i++;
                        ?>
                        <div class="field">
                            <input class="inputbox-style pr_tg" id="" name="video_id[]" type="text" placeholder="Video ID" value="<?php echo $video->video; ?>"/>

                            <i class="<?php
                            if ($i == 1) {
                                echo 'fa fa-plus-square-o add-more';
                            } else {
                                echo 'fa fa-minus-square-o remove-me';
                            }
                            ?>" type="button"></i>
                        </div>
                            <?php } ?>

                        <?php else : ?>
                            <div class="field">
                                <input class="inputbox-style pr_tg" id="" name="video_id[]" type="text" placeholder="Video ID"/>
                                <i class="fa fa-plus-square-o add-more" type="button"></i>
                            </div>
                        <?php endif; ?>
                        <div id="after_append"></div>
                        <button type="submit" class="btn-wrap btn-big">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var $ = jQuery;
    $('#update_company_info').on('submit', function () {
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
        var newHtml = $('<div class="field">' +
            '<input class="inputbox-style pr_tg" id="" name="video_id[]" type="text" placeholder="Video ID"/>' +
            '<i class="fa fa-minus-square-o remove-me" ></i><div class="row"></div></div>');
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