<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<section class="content-header">
    <h1> <?=$user_name?> <small> Document <?php echo $button ?></small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Add New Document</li>
    </ol>
</section>


<form class="form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="add_post">


    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add New Post</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="col-md-12">

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> Document Name</span>
                        <input required="required" type="text" name="name" class="form-control" id="name" placeholder="Document Name" value="<?php echo $name; ?>" >
                        <?php echo form_error('name') ?>
                        <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    </div>

                </div>



            </div>

        </div>



        <div class="box box-success" id="image_up">
            <div class="box-header with-border">
                <div class="form-group  no-margin">
                    <h3 class="box-title">Upload Feature Image</h3>
                </div>

                <div class="thumbnail upload_image" style="border:0!important;">
                    <?php if (!empty($photo)) : ?>
                        <img src="uploads/user_document/<?php echo $photo; ?>" class="img-responsive lazyload" alt="image">
                    <?php else : ?>
                        <img src="assets/new-theme/images/no-photo.png" class="img-responsive lazyload" alt="image">
                    <?php endif; ?>
                </div>
                <input type="file" name="photo" class="file_select" onchange="instantShowUploadImage(this, '.upload_image')">
                <?php echo form_error('name') ?>
            </div>
        </div>

        <div class="box box-success">
            <div class="box-header with-border">

                <div class="form-group no-margin">
                    <button id="post_save" type="submit" class="btn btn-flat btn-block btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>

    </section>
</form>


<script type="text/javascript" src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

    var base_url = "<?php echo base_url() ?>";
    $(window).on('load', function () {
        $("#tagstest").select2({
            multiple: true,
            tokenSeparators: [','],
            minimumInputLength: 1,
            minimumResultsForSearch: 10,
            tags: true,
            ajax: {
                url: base_url+'admin/blog/get_tags',
                dataType: "json",
                type: "GET",
                data: function (params) {

                    var queryParameters = {
                        term: params.term
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id,
                                value : item.id
                            }
                        })
                    };
                }
            }
        });
    })
    /*------------ Instant Show Preview Image to a targeted place ------------*/
    function instantShowUploadImage(input, target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(target + ' img').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
        $(target).show();
    }

    CKEDITOR.replace('content',  {
        width:['100%'],
        height: ['500px']

    });

    $("#postTitle, #postSlug").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        $("#postSlug").val(Text);
    });

</script>