<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

load_module_asset('gallery','css');
?>

<section class="content-header">
    <h1>Manage Albums</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>gallery"> Gallery</a></li>
        <li><a href="<?php echo Backend_URL ?>gallery/albums"> Albums</a></li>
        <li class="active">Update</li>
    </ol>
</section>


<section class="content">
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">Update Album</h3>
        </div>

        <div class="box-body">
        <div class="row">
            <div class="col-md-12"><div id="ajax_respon"></div></div>
            <div id="ajax_respon"></div>
            <div class="col-md-8">                           
                    <form class="form-horizontal" action="<?php echo $action; ?>"   onsubmit="return submitForm();" method="post" enctype="multipart/form-data"  id="photo-upload" novalidate>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                        
                        <div class="form-group">
                            <div class="col-md-2">
                                <p class="text-right"><b><span>Album Name <?php echo form_error('album_name') ?>:  </span></b></p>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="album_name" id="title" placeholder="Album Name" value="<?php echo $album_name; ?>" data-do-validate="true" class="invalid" data-error-msg="Plz Enter Photo Title" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2">
                                <p class="text-right"><b><span>Slug <?php echo form_error('album_name') ?>:  </span></b></p>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="slug" id="title" placeholder="Slug" value="<?php echo $slug; ?>" data-do-validate="true" class="invalid" data-error-msg="" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-2">
                                <p class="text-right"><b><span>Type <?php echo form_error('type') ?>:  </span></b></p>
                            </div>
                            <div class="col-md-5">
                                <select name="type" class="form-control" id="type">
                                    <?php echo albumType($type) ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-2">
                                <p class="text-right"><b>Album Thumb <?php echo form_error('thumb') ?>:</b></p>
                            </div>
                            <div class="col-md-5">                
                                <input type="hidden" name="thumb_old" value="<?php echo $thumb; ?>" />
                                <div class="btn btn-default btn-file">
                                    <i class="fa fa-paperclip"></i> Select Album Thumb
                                    <input type="file" name="thumb"  id="profilePic" value="<?php echo $thumb; ?>">                                                                                                                                     
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12" style="margin:10px;"> 
                            <a href="<?php echo (Backend_URL.'gallery/albums') ?>" class="btn btn-default"> <i class="fa fa-long-arrow-left"></i> Back to List</a>
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-cloud-upload"></i> Upload Photo</button>                       
                        
                        </div>
                    </form>

            </div>

            <div class="col-md-4">
                <div id="image_preview1"><?php echo  getAlbumThumb( $thumb, 'small', [ 'id' => 'previewing1', 'width' => '180' ] ); ?></div>
            </div>
        </div>
        </div>


    </div>
</section>

<script type="text/javascript">
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

    function submitForm() {

        var fd = new FormData(document.getElementById("photo-upload"));
        $.ajax({
            url: "<?php echo $action; ?>",
            type: "POST",
            data: fd,
            dataType: 'json',
            enctype: 'multipart/form-data',
            beforeSend: function () {
                $('#ajax_respon').css('display', 'block').html('<p class="ajax_processing">Processing...</p>');
            },
            success: function (respond) {
                $('#ajax_respon').html(respond.Msg);

                if (respond.Status === 'OK') {
                    setTimeout(function () {
                        $('#success_report').hide('slow')
                    }, 2000);
                    // document.getElementById("photo-upload").reset();
                }
            },
            processData: false, // tell jQuery not to process the data
            contentType: false   // tell jQuery not to set contentType
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
