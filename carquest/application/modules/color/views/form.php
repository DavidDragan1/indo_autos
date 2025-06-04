<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<section class="content-header">
    <h1> Color <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/color') ?>"
                                                       class="btn btn-default">Back</a></h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/color">Color</a></li>
        <li class="active">Update</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Update Record</h3>
        </div>

        <div class="box-body">
            <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
                <div class="form-group">
                    <label for="color_name" class="col-sm-2 control-label">Color Name :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="color_name" id="color_name"
                               placeholder="Color Name" value="<?php echo $color_name; ?>"/>
                        <?php echo form_error('color_name') ?>
                    </div>
                </div>
                <div class="col-md-12 text-right"><input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url('admin/color') ?>" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>