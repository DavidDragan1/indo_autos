<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('cms','css');?>

<section class="content-header">
    <h1> CMS Page  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/cms') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL; ?>/cms">Pages</a></li>
        <li class="active">Add New Page</li>
    </ol>
</section>


<section class="content">
    <?php echo $this->session->flashdata( 'message' );?>
    <div class="row"> 


<form class="form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="post_type" value="page"/>
    <input type="hidden" name="user_id" value="<?php echo getLoginUserData('user_id'); ?>" />    
    <input type="hidden" name="id" value="<?php echo $id; ?>" />

    <div class="col-md-9">
        <div class="box box-primary">
            
            

            <div class="box-body">
                <div class="col-md-12">
                    
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> Page Title</span>
                        <input required="required" type="text" name="post_title" class="form-control" id="postTitle" placeholder="Page Title" value="<?php echo $post_title; ?>"/>
                    </div>
                     
                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-globe"></i> Page-link : <?php echo base_url(); ?></span>                  
                        <input type="text" name="post_url" class="form-control" value="<?php echo $post_url; ?>" id="postSlug">
                    </div>

                    <div class="form-group">
                        <textarea name="content" rows="10" cols="100" id="content" ><?php echo $content; ?></textarea>
                        
                    </div>  

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> SEO Title</span>
                        <input type="text" name="seo_title" class="form-control" placeholder="Page Seo Title" value="<?php echo $seo_title; ?>">
                    </div>

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> SEO Keyword</span>
                        <input type="text" name="seo_keyword" class="form-control" placeholder="Page Keywords" value="<?php echo $seo_keyword; ?>">
                    </div>

                    
                    <div class="form-group input-group">                               
                        <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> SEO Description</span>
                        <textarea class="form-control" name="seo_description" rows="3" cols="100" placeholder="Page Description"><?php echo $seo_description; ?></textarea>
                    </div>


                    
                </div>



            </div>

            <div class="box-footer">
            </div>

        </div>
    </div>
    <div class="col-md-3">
        
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="form-group  no-margin">
                    <h3 class="box-title">Additional Settings</h3>
                </div>
            </div>

            <div class="box-header with-border hidden">
                <div class="form-group  no-margin">
                    <select style="width:100%;" class="form-control" name="parent_id" >
                        <option value="0">Select Parent</option>
                        <option value="1">Semplate 1</option>
                        <option value="2">Template 2</option>
                        <option value="3">Uemplate 3</option>
                        <option value="4">Vemplate 4</option>
                        <option value="5">Template 5</option>
                    </select>
                
                </div>
            </div>
            <div class="box-header with-border hidden">
                <div class="form-group  no-margin">
                    <select style="width:100%;" class="form-control" name="template">
                        <option value="0">Select Template</option>
                        <option value="temp6">Semplate 6</option>
                        <option value="temp7">Template 7</option>
                        <option value="temp8">Uemplate 8</option>
                        <option value="temp9">Vemplate 9</option>
                        <option value="temp10">Template 10</option>
                    </select>
                </div>
            </div>
            
            <div class="box-header with-border">
               
                <div class="form-group  no-margin">
                    
                    <select style="width:100%;" class="form-control" name="status">
                       <?php echo cmsStatus($status);  ?>
                    </select>
                </div>
            </div>
            <div class="box-header with-border">
                <div class="form-group  no-margin">
                    <input type="text" name="page_order" class="form-control" id="inputSuccess" placeholder="Page Order" value="<?php echo $page_order; ?>">
                </div>
               
            </div>
            
            <div class="box-header with-border">
                
                <div class="form-group no-margin">
                    <button type="submit" class="btn btn-flat btn-block btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>


        </div>

        <div class="box box-success">
            <div class="box-header with-border">
                <div class="form-group  no-margin">
                    <h3 class="box-title">Upload Feature Image</h3>
                </div>

                
                
                
                
                <div class="thumbnail upload_image">                    
                    <?php echo getCMSPhoto( $thumb, 'full' ); ?>                    
                </div>
                <div class="btn btn-default btn-file">
                    <i class="fa fa-picture-o"></i> Set Thumbnail 
                    <input type="file" name="thumb" class="file_select" onchange="instantShowUploadImage(this, '.upload_image')">
                </div>
            </div>       
        </div>
    
       
        
    </div>
</form>
    </div>
</section>

<script src="assets/lib/plugins/ckeditor/ckeditor.js"></script>

<script>
    //CKEDITOR.config.allowedContent = true;
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
    
    
<?php if($id == 0){ ?>
$("#postTitle").on('keyup keypress blur change', function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp,'-');
        $("#postSlug").val(Text);        
        $(".pageSlug").text(Text);        
});
<?php } ?>


</script>