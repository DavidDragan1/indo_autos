<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('cms','css');?>
<style>
    .show {
        display: block;
    }
    .hide {
        display: none;
    }
</style>
<?php
if ($parent_id == 91) {
    $review = $this->db->where('cms_id', $id)->get('admin_review')->row();
}
?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/fileinput.js" type="text/javascript"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>

<!-- 
<link href="assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="assets/js/fileinput.js" type="text/javascript"></script>
-->

<section class="content-header">
  <h1> CMS Page <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/cms/posts') ?>" class="btn btn-default">Back</a> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li><a href="<?php echo Backend_URL; ?>cms/posts">Posts</a></li>
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
                        <input required="required" type="hidden" name="post_type" value="page">
                        <input type="hidden" name="user_id" value="<?php echo getLoginUserData('user_id'); ?>" />
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        
                    </div>
                    
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-globe"></i> Permalink : <?php echo base_url(); ?></span>                  
                        <input type="text" name="post_url" class="form-control" value="<?php echo $post_url; ?>" id="postSlug" required="required">
                    </div>

                    <div class="form-group">
                        <textarea name="content" rows="10" cols="100" id="content" ><?php echo $content; ?></textarea>
                        
                    </div>  

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-globe"></i> Page SEO Title</span>        
                        <input type="text" name="seo_title" class="form-control" id="" placeholder="Blog Seo Title" value="<?php echo $seo_title; ?>">
                    </div>

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-globe"></i> Page Keywords</span> 
                        <input type="text" name="seo_keyword" class="form-control" id="" placeholder="Page Keywords" value="<?php echo $seo_keyword; ?>">
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
                
                <div class="form-group no-margin">
                    <button id="post_save" type="button" class="btn btn-flat btn-block btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
        <div class="box box-success">
            <div class="box-header with-border">
                <div class="form-group  no-margin">
                    <h3 class="box-title">Additional Settings</h3>
                </div>
            </div>

            <div class="box-header with-border">
                <div class="form-group  no-margin">
                   <label for="int" class="control-label">Category:</label>
		 <select name="parent_id" class="form-control" id="parent_id">
                    <?php echo getCategoryDropDown($parent_id) ;?>
                </select>
                <p class="text-danger" id="warning"></p>
                    
                    
                
                </div>
            </div>

            <div class="box-header with-border hide" id="vehicle">
                <div class="form-group  no-margin">
                    <label for="int" class="control-label">Vehicle:</label>
                    <select name="vehicle_id" class="form-control" id="vehicle_id" onchange="get_brand(this.value, 0)">
                        <?php echo GlobalHelper::getDropDownVehicleType((isset($review->vehicle_type_id)) ? $review->vehicle_type_id : 0) ;?>
                    </select>
                    <p class="text-danger" id="warning_vehicle"></p>



                </div>
            </div>

            <div class="box-header with-border hide" id="brand">
                <div class="form-group  no-margin">
                    <label for="int" class="control-label">Brand:</label>
                    <select name="brand_id" class="form-control" id="brand_id" onchange="get_model(this.value, 0)">
                        <?php echo Modules::run('brands/all_brands_by_vehicle', (isset($review->vehicle_type_id)) ? $review->vehicle_type_id : 0, (isset($review->brand_id)) ? $review->brand_id : 0 ); ?>
                    </select>
                    <p class="text-danger" id="warning_brand"></p>
                </div>
            </div>

            <div class="box-header with-border hide" id="model">
                <div class="form-group  no-margin">
                    <label for="int" class="control-label">Model:</label>
                    <select name="model_id" class="form-control" id="model_id">
                        <?php echo Modules::run('brands/all_model_by_brand', (isset($review->brand_id)) ? $review->brand_id : 0, (isset($review->model_id)) ? $review->model_id : 0 ); ?>
                    </select>
                    <p class="text-danger" id="warning_model"></p>
                </div>
            </div>
          
            <div class="box-header with-border">
                <div class="form-group  no-margin">
                    <input type="text" name="page_order" class="form-control" id="inputSuccess" placeholder="Page Order" value="">
                </div>
               
            </div>
            <div class="box-header with-border">
               
                <div class="form-group  no-margin">
                    
                    <select style="width:100%;" class="form-control" name="status">
                       <?php echo cmsStatus($status);  ?>
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
                        <img src="uploads/cms_photos/<?php echo $thumb; ?>" class="img-responsive lazyload" alt="image">
                    <?php else : ?>
                        <img src="uploads/cms_photos/no-thumb.png" class="img-responsive lazyload" alt="image">
                    <?php endif; ?>
                </div>
                <input type="file" name="thumb" class="file_select" onchange="instantShowUploadImage(this, '.upload_image')">
            </div>       
        </div>
    
       
        
    </section>
</form>


<script type="text/javascript" src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        var parent_id = "<?php echo $parent_id; ?>";

        if (parent_id == "91") {
            $("#vehicle").removeClass('hide');
            $("#brand").removeClass('hide');
            $("#model").removeClass('hide');
            $("#image_up").addClass('hide');
        }
    });
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
    
    


    $("#postTitle").on('keyup keypress blur change', function(){
            var Text = $(this).val();
            Text = Text.toLowerCase();
            var regExp = /\s+/g;
            Text = Text.replace(regExp,'-');
            $("#postSlug").val(Text);
            $(".pageSlug").text(Text);
    });

    $("#post_save").on('click', function () {
       var parent_id =  $("#parent_id").val();
       if (parent_id !== "0" && parent_id !== "91") {
           $("#add_post").submit();
       } else if (parent_id == "91") {
           if ($("#vehicle_id").val() !== "0" && $("#brand_id").val() !== "0" && $("#model_id").val() !== "0") {
               $("#add_post").submit();
           }

           if ($("#vehicle_id").val() === "0") {
               $("#warning_vehicle").html('Please add a vehicle type.');
           }

           if ($("#brand_id").val() === "0") {
               $("#warning_brand").html('Please add a brand.');
           }

           if ($("#model_id").val() === "0") {
               $("#warning_model").html('Please add a model.');
           }
       } else {
           $("#warning").html('Please add a category.');
       }
    });

    $("#parent_id").on('click', function () {
        var parent_id =  $("#parent_id").val();
        if (parent_id !== "0") {
            $("#warning").html('');
        }

        if (parent_id == "<?php echo 91; ?>") {
            $("#vehicle").removeClass('hide');
            $("#brand").removeClass('hide');
            $("#model").removeClass('hide');
            $("#image_up").addClass('hide');
        } else {
            $("#vehicle").addClass('hide');
            $("#brand").addClass('hide');
            $("#model").addClass('hide');
            $("#image_up").removeClass('hide');
        }
    });

    $("#vehicle_id").on('click', function () {
        if ($("#vehicle_id").val() !== "0") {
            $("#warning_vehicle").html('');
        }
    });

    $("#brand_id").on('click', function () {
        if ($("#brand_id").val() !== "0") {
            $("#warning_brand").html('');
        }
    });

    $("#model_id").on('click', function () {
        if ($("#model_id").val() !== "0") {
            $("#warning_model").html('');
        }
    });

    function get_brand(vehicle_type_id, brand_id) {
        var vehicle_type_id = vehicle_type_id;
        var brand_id = brand_id;
        jQuery.ajax({
            url: 'admin/brands/brands_by_vehicle_type/',
            type: "POST",
            dataType: "text",
            data: {vehicle_type_id: vehicle_type_id, brand_id: brand_id},
            beforeSend: function () {
                jQuery('#brand_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#brand_id').html(response);
            }
        });
    };

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
    };
</script>
