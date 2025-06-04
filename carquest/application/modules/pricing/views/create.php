<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<section class="content-header">
    <h1> Plan Description <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/parts') ?>"
                                                                   class="btn btn-default">Back</a></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/parts_description">Parts Description</a></li>
        <li class="active">Create</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New Plan
                    </h3>
                </div>
                <div class="panel-body">
                    <form action="<?=base_url('admin/pricing/create-action')?>" method="post">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">Package Name : </label>
                                <input required type="text" class="form-control" name="name" id="name" placeholder="Name">
                                <?php echo form_error('name') ?>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="package_type">Package Type :</label>
                                <select required name="package_type" id="package_type" class="form-control">
                                    <?= getRoleDropdown() ?>
                                </select>
                                <?php echo form_error('package_type') ?>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="duration">Duration :</label>
                                <select required name="duration" id="duration" class="form-control">
                                    <?= getPricingDuration() ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="price">Price : </label>
                                <input required type="number" step="any" class="form-control" name="price" id="price" placeholder="0.00">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="description">Description : </label>
                                <textarea required name="description" id="description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div style="justify-content: space-between;display: flex;align-items: center;margin-bottom: 20px">
                            <h4>Feature</h4>
                            <a id="add_more" href="" class="btn btn-success">Add more</a>
                        </div>
                        <div id="feature-col">
                            <div class="row">
                                <div class="form-group col-lg-7">
                                    <input required type="text"  class="form-control" name="feature_description[]" id="feature_description" placeholder="Feature description">
                                </div>
                                <div class="form-group col-lg-4">
                                    <input  type="text"  class="form-control" name="feature_extra" id="feature_extra[]" placeholder="Feature extra">
                                </div>
                                <div class="form-group col-lg-1">
                                    <a href="" class="btn btn-danger remove"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save New Brand</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="assets/new-theme/js/jquery.validate.min.js"></script>
<script>
    $(document).ready(function (){
       $(document).on('click','#add_more',function (e){
           e.preventDefault();
           var html = `<div class="row">
                                <div class="form-group col-lg-7">
                                    <input required type="text"  class="form-control" name="feature_description[]" id="feature_description" placeholder="Feature description">
                                </div>
                                <div class="form-group col-lg-4">
                                    <input  type="text"  class="form-control" name="feature_extra[]" id="feature_extra" placeholder="Feature extra">
                                </div>
                                <div class="form-group col-lg-1">
                                    <a href="" class="btn btn-danger remove"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>`;
           $('#feature-col').append(html);
       });
       $(document).on('click','.remove',function (e){
           e.preventDefault();
          $(this).parent('div').parent('.row').remove();
       });
       $('form').validate({
           errorClass:'text-danger',
           errorElement:'span'
       });
    });
</script>