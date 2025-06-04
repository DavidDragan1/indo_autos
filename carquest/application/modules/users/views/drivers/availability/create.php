<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Availability
        <small>Add</small>
        <a href="<?php echo site_url(Backend_URL . 'users/availability/') . $user_id ?>"
           class="btn btn-default">Back</a></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>users">Users</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'users/availability/') . $user_id ?>">Availability</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Create New Availability</h3>
        </div>

        <div class="box-body">
            <?php echo form_open($action, array('class' => 'form-horizontal', 'method' => 'post')); ?>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name :</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                           value="<?php echo $name; ?>"/>
                    <?php echo form_error('name') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="type_id" class="col-sm-2 control-label">Type :</label>
                <div class="col-sm-10">
                    <select class="form-control" name="term" id="term">
                        <option value="" disabled>Select Term</option>
                        <option value="Short Term">Short Term</option>
                        <option value="Middle Term">Middle Term</option>
                        <option value="Long Term">Long Term</option>
                    </select>
                    <?php echo form_error('term') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="brand_id" class="col-sm-2 control-label">Start Date :</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="start_date" id="start_date" placeholder="Start Date"
                           value="<?php echo $start_date; ?>"/>
                    <?php echo form_error('start_date') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="brand_id" class="col-sm-2 control-label">End Date :</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="end_date" id="end_date" placeholder="End Date"
                           value="<?php echo $end_date; ?>"/>
                    <?php echo form_error('end_date') ?>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
                <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                <a href="<?php echo site_url(Backend_URL . 'users/notification') ?>" class="btn btn-default">Cancel</a>
            </div>
            </form>
        </div>
    </div>
</section>
