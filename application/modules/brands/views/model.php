<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1> Models  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/brands') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL; ?>brands">Brands</a></li>
        <li class="active">Update</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Update Model</h3>
        </div>

        <div class="box-body">
            <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
                <div class="form-group">
                    <label for="parent_id" class="col-sm-2 control-label">Select Brand :</label>
                    <div class="col-sm-10">                    
                        <?php $brands = Modules::run('Brands/all_brands'); ?>

                        <select name="parent_id" class="form-control">
                            <?php foreach ($brands as $brand) : ?>
                                <option <?php if ($parent_id == $brand->id) {
                                echo 'selected';
                            } ?> value="<?php echo $brand->id ?>"><?php echo $brand->name ?></option>
                        <?php endforeach; ?>

                        </select>
                            <?php echo form_error('parent_id') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="parent_id" class="col-sm-2 control-label">Vehicle Type :</label>
                    <div class="col-sm-10">  
                        <select class="form-control" name="type_id">
                        <?php echo vehicleType($type_id); ?>
                        </select>
                        <?php echo form_error('type_id') ?>
                    </div>
                </div>


                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Model Name :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />
                        <?php echo form_error('name') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="slug" class="col-sm-2 control-label">Model Slug :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="<?php echo $slug; ?>" />
                        <?php echo form_error('slug') ?>
                    </div>
                </div>

                <div class="col-md-12 text-right">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                    <a href="<?php echo site_url('admin/brands') ?>" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div></div></section>