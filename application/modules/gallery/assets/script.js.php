<script type="text/javascript">
    
    function create_album(){
        
        var formData = new FormData(document.getElementById("album-upload"));        
        var error   = 0;
                
        if( !error ){
            $.ajax({
                url: "<?php echo Backend_URL; ?>gallery/create_album",
                type: "POST",
                data: formData,
                dataType: 'json',
                enctype: 'multipart/form-data',
                beforeSend: function () {
                    $('#ajax_respond')
                            .css('display', 'block')
                            .html('<p class="ajax_processing">Processing...</p>');
                },
                success: function (respond) {

                    $('#ajax_respond').html(respond.Msg);

                    if (respond.Status === 'OK') {
                        setTimeout(function () {
                            $('#ajax_respond').slideUp(1000);
                            document.getElementById("album-upload").reset();
                        }, 2000);                        
                    }
                },
                processData: false, // tell jQuery not to process the data
                contentType: false   // tell jQuery not to set contentType
            });
        }        
        return false;
    }

    // Rename Category
    function edit_album(id) {
        $.ajax({
            url: "<?php echo Backend_URL; ?>gallery/edit_album/" + id,
            type: "POST",
            dataType: "text",
            data: {id: id},
            beforeSend: function () {
                $('.edit_id_' + id).html('Loading...');
            },
            success: function (respond) {
                $('.edit_id_' + id).html(respond);
            }
        });
    }

    // Update Category Value
    function update_album(id) {
        var update_form = $('#update_form').serialize();
        $.ajax({
            url: "<?php echo Backend_URL; ?>gallery/update_album",
            type: "POST",
            dataType: "json",
            data: update_form,
            cache: false,
            beforeSend: function () {
                $('.edit_id_' + id).html('<p class="ajax_processing">Updating...</p>');
            },
            success: function (jsonData) {
                $('.edit_id_' + id).html(jsonData.Msg);
            }
        });

    }

    // Delete Category ID
    function delete_album(id) {
        var yes = confirm('Really Want to Delete?');
        if (yes) {
            $.ajax({
                url: "<?php echo Backend_URL; ?>gallery/delete_album/",
                type: "POST",
                dataType: "text",
                data: {id: id},
                beforeSend: function () {
                    // $('.alert-success').html('Loading');
                    $('.role_id_' + id).css('background-color', '#FF0000');
                },
                success: function (respond) {
                    $('.role_id_' + id).fadeOut('slow');
                }
            });
        }
    }


    $(document).ready(function () {
        $('#testform').attrvalidate();
        
        $('#resetBtn').click(function () {
            $('#testform').attrvalidate('reset');
        });

        $('#expandBtn').click(function () {
            var collapsible = $('#' + $(this).attr('aria-controls'));
            $(collapsible).attr('aria-hidden', ($(collapsible).attr('aria-hidden') === 'false'));
            $(this).attr('aria-expanded', ($(this).attr('aria-expanded') === 'false'));
        });
    });

    function upload_photo() {        
        var fd = new FormData(document.getElementById("photo-upload"));
       
        var form    = jQuery('#photo-upload');               
        var url     = form.attr('action');
        var method  = form.attr('method');  
        
        $.ajax({
            url: url,
            type: method,
            data: fd,
            dataType: 'json',
            enctype: 'multipart/form-data',
            beforeSend: function () {
                $('#ajax_respon')
                        .html('<p class="ajax_processing">Processing...</p>')
                        .css('display', 'block');
            },
            success: function (respond) {

                $('#ajax_respon').html(respond.Msg);

                if (respond.Status === 'OK') {
                    setTimeout(function () {
                        $('#success_report').hide('slow')
                    }, 2000);
                    document.getElementById("photo-upload").reset();
                }
            },
            processData: false, // tell jQuery not to process the data
            contentType: false   // tell jQuery not to set contentType
        });

        return false;
    }
    
    
    function upload_video() {        
                
        var form    = jQuery('#video-upload');               
        var url     = form.attr('action');
        var method  = form.attr('method');  
        var data    = form.serialize();  
        var type    = $('#type').val();
//        var error   = 0;
        
//        var album_id    = jQeury('#album_id').val();
//        var video_code  = jQeury('#video_id').val();
//        
        
        
        
        jQuery.ajax({
            url: url,
            type: method,
            data: data,
            dataType: 'json',
            beforeSend: function () {
                jQuery('#ajax_respon')
                        .html('<p class="ajax_processing">Processing...</p>')
                        .css('display', 'block');
            },
            success: function (respond) {
                jQuery('#ajax_respon').html(respond.Msg);
                if (respond.Status === 'OK') {
                    setTimeout(function () {
                        jQuery('#ajax_respon').slideUp('slow');
                        if(type === 'create') {
                            document.getElementById("video-upload").reset();
                        }
                    }, 2000);
                    
                }
            }             
        });
        return false;
    }



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
        $('#previewing1').attr('width', '180px');
    }
    

</script>