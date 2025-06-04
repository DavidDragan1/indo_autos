<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h2> Tags  <small><?php echo $button ?></small> <a href="<?php echo site_url(Backend_URL . 'posts/tags') ?>" class="btn btn-default">Back</a> </h2>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>posts">Posts</a></li>
        <li><a href="<?php echo Backend_URL ?>posts/tags">Tags</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Create New Tags</h3>
        </div>
        <div class="box-body">
            <?php echo form_open($action, array('class' => 'form-horizontal', 'method' => 'post')); ?>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Tag Name :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Tag Name" value="<?php echo $name; ?>" />
                    <?php echo form_error('name') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Meta Title :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Meta Title" value="<?php echo $meta_title; ?>" />
                    <?php echo form_error('meta_title') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Meta Description :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="meta_description" id="meta_description" placeholder="Meta description" value="<?php echo $meta_description; ?>" />
                    <?php echo form_error('meta_description') ?>
                </div>
            </div>

            <div class="col-md-12 no-padding text-right">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <button type="submit" class="btn btn-primary"><?php echo $button; ?></button>
                <a href="<?php echo site_url(Backend_URL . 'posts/tags') ?>" class="btn btn-default">Cancel</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
<script>
    $("#name").on('keyup keypress blur change', function () {
        var name = $(this).val();

        if (name == '') {
            $("#meta_title").val('');
            $("#meta_description").val('');
        } else {
            $("#meta_title").val(name + " for sale | Buy " + name +"");
            $("#meta_description").val("Find " + name + " cars for Sale by owner or from a trusted dealer. Compare prices of cars, features, photos and Reviews. Contact sellers now.");
        }
    });
</script>
