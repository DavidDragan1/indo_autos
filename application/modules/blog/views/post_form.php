<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<?php load_module_asset('blog','css');?>
<style>
    .show {
        display: block;
    }
    .hide {
        display: none;
    }
</style>


<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>

<!-- 
<link href="assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="assets/js/fileinput.js" type="text/javascript"></script>
-->

<section class="content-header">
  <h1> CMS Page <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/blog') ?>" class="btn btn-default">Back</a> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><a href="<?php echo Backend_URL; ?>blog">Posts</a></li>
    <li class="active">Add New Post</li>
  </ol>
</section>


<form class="form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="add_post">


    <section class="content col-md-9">
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
                        <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> Page Title</span>
                        <input required="required" type="text" name="post_title" class="form-control" id="postTitle" placeholder="Page Title" value="<?php echo $post_title; ?>" >
                        <?php echo form_error('post_title') ?>
                        <input type="hidden" name="user_id" value="<?php echo getLoginUserData('user_id'); ?>" />
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        
                    </div>
                    
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-globe"></i> Permalink : <?php echo base_url().'blog/'; ?></span>
                        <input type="text" name="post_url" class="form-control" value="<?php echo $post_url; ?>" id="postSlug" required="required">
                        <?php echo form_error('post_url') ?>
                    </div>

                    <div class="form-group">
                        <textarea name="description" rows="10" cols="100" id="content" ><?php echo $description; ?></textarea>
                        
                    </div>  

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-globe"></i> Page SEO Title</span>        
                        <input type="text" name="seo_title" class="form-control"  placeholder="Blog Seo Title" value="<?php echo $seo_title; ?>">
                    </div>

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-globe"></i> Page Keywords</span> 
                        <input type="text" name="seo_keyword" class="form-control"  placeholder="Page Keywords" value="<?php echo $seo_keyword; ?>">
                    </div>

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-globe"></i> Page Description</span> 
                        <textarea class="form-control" name="seo_description" rows="3" cols="100" placeholder="Page Description"><?php echo $seo_description; ?></textarea>
                    </div>

                </div>



            </div>

            <div class="box-footer">
            </div>

        </div>
    </section>
    <section class="content col-md-3 ">

        <div class="box box-success">
            <div class="box-header with-border">
                <div class="form-group  no-margin">
                    <h3 class="box-title">Additional Settings</h3>
                </div>
            </div>

            <div class="box-header with-border">
                <div class="form-group  no-margin">
                   <label for="category_id" class="control-label">Category:</label>
		 <select name="category_id" class="form-control" id="category_id">
                    <?php echo CategoryDropDown($category_id) ;?>
                </select>
                    <?php echo form_error('category_id') ?>
                </div>

                <div class="form-group  no-margin">
                    <label for="category_id" class="control-label">Status:</label>
                    <select style="width:100%;" class="form-control" name="status">
                        <?php echo cmsStatus($status);  ?>
                    </select>
                </div>

                <div class="form-group  no-margin">
                    <label for="" class="control-label">Is Featured:</label>
                    <?=htmlRadio('is_featured', $is_featured, [ 0 => 'No', 1 => 'Yes'])?>
                </div>
            </div>


        </div>

        <div class="box box-success">
            <div class="box-header with-border">
                <div class="form-group  no-margin">
                    <h3 class="box-title">Tags</h3>
                </div>
            </div>
            <div class="box-header with-border">
                <div class="form-group no-margin">
                    <!-- <select name="tags[]" id="tags" class="form-control" multiple
                            style="width: 100%;">
                    </select> -->
                    <select id="tagstest" name="tags[]" placeholder="Search tags" class="form-control" multiple>
                        <?php echo getTagsList($tags); ?>
                    </select>
                </div>
            </div>

        </div>

        <div class="box box-success" id="image_up">
            <div class="box-header with-border">
                <div class="form-group  no-margin">
                    <h3 class="box-title">Upload Feature Image</h3>
                </div>

                <div class="thumbnail upload_image" style="border:0!important;">
                    <?php if (!empty($thumb)) : ?>
                        <img src="uploads/blog_photos/<?php echo $thumb; ?>" class="img-responsive lazyload" alt="image">
                    <?php else : ?>
                        <img src="uploads/blog_photos/no-thumb.png" class="img-responsive lazyload" alt="image">
                    <?php endif; ?>
                </div>
                <input type="file" name="thumb" class="file_select" onchange="instantShowUploadImage(this, '.upload_image')">
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