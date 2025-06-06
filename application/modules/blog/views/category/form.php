<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>


<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/fileinput.js" type="text/javascript"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"
        type="text/javascript"></script>

<style>
    .box-body {
        margin-bottom: 20px;
    }
</style>


<section class="content-header">
    <h1> Cms_options <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/blog/category') ?>"
                                                             class="btn btn-default">Back</a></h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/blog/category">Add New Category</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Record</h3>
        </div>

        <div class="box-body">
            <form class="form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                               value="<?php echo $name; ?>"/>
                        <?php echo form_error('name') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="slug" class="col-sm-2 control-label">Slug :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="slug" id="slug" placeholder="slug"
                               value="<?php echo $slug; ?>"/>
                        <?php echo form_error('slug') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="menu_order" class="col-sm-2 control-label">Menu Order :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="menu_order" id="menu_order" placeholder="menu_order"
                               value="<?php echo $menu_order; ?>"/>
                        <?php echo form_error('menu_order') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="seo_title" class="col-sm-2 control-label">Meta Title :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="seo_title" id="seo_title" placeholder="seo_title"
                               value="<?php echo $seo_title; ?>"/>
                        <?php echo form_error('seo_title') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="seo_keyword" class="col-sm-2 control-label">Meta Keyword :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="seo_keyword" id="seo_keyword" placeholder="seo_keyword"
                               value="<?php echo $seo_keyword; ?>"/>
                        <?php echo form_error('seo_keyword') ?>
                    </div>
                </div>



                <div class="form-group">
                    <label for="seo_description" class="col-sm-2 control-label">Meta Description :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="seo_description" id="seo_description"
                                  placeholder="seo_description"><?php echo $seo_description; ?></textarea>
                        <?php echo form_error('seo_description') ?>
                    </div>
                </div>



        </div>


        <div class="col-md-12 text-right"><input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
            <a href="<?php echo site_url('admin/cms_options') ?>" class="btn btn-default">Cancel</a>
        </div>
        </form>
    </div>
    </div></section>

<script>
    $("#name, #slug").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        $("#slug").val(Text);
    });
</script>