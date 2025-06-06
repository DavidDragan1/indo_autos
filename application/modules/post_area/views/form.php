<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Mange State  <small>Update</small> <a href="<?php echo site_url( Backend_URL . 'post_area') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL; ?>post_area">Post_area</a></li>
        <li class="active">Update</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Update State</h3>
        </div>

        <div class="box-body">
            <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />
                        <?php echo form_error('name') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="slug" class="col-sm-2 control-label">Slug :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="<?php echo $slug; ?>" />
                        <?php echo form_error('slug') ?>
                    </div>
                </div>

                <?php if ($type == 'state') : ?>
                    <div class="form-group">
                        <label for="post_qty" class="col-sm-2 control-label">Country :</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="country_id" id="country_id">
                                <?php echo getDropDownCountries($country_id); ?>
                            </select>
                            <?php echo form_error('country_id') ?>
                        </div>
                    </div>
                <div class="form-group">
                    <label for="post_qty" class="col-sm-2 control-label">Post Qty :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="post_qty" id="post_qty" placeholder="Post Qty" value="<?php echo $post_qty; ?>" />
                        <?php echo form_error('post_qty') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="is_home" class="col-sm-2 control-label">Is Home :</label>
                    <div class="col-sm-10">                    
                        <?php echo htmlRadio('is_home', $is_home, ['Yes' => 'Yes', 'No' => 'No']); ?>                         
                    </div>
                </div>
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <input type="hidden" name="parent_id" value="<?php echo $parent_id; ?>">
                <?php else : ?>
                    <div class="form-group">
                            <label for="parent_id" class="col-sm-2 control-label">Select State :</label>
                        <div class="col-sm-10">
                        <select name="parent_id" id="parent_id" class="form-control">
                                <?php echo all_location($parent_id) ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="post_qty" value="<?php echo $post_qty; ?>">
                    <input type="hidden" name="is_home" value="<?php echo $is_home; ?>">
                    <input type="hidden" name="type" value="<?php echo $type; ?>">
                <?php endif; ?>
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                    <a href="<?php echo site_url('admin/post_area') ?>" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>