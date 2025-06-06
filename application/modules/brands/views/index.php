<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Brands &amp; Models  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Brands</li>
    </ol>
</section>

<section class="content">
    <?php //echo $this->session->flashdata('message');?>
    <div class="row">    
        <div class="col-sm-4 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New Brand
                    </h3>
                </div>

                <div class="panel-body">                   
                    <form action="<?php echo Backend_URL; ?>brands/brand_create_action" method="post">

                        <div class="form-group">
                            <label for="name">Brand Name</label>
                            <input type="text" class="form-control" name="name" id="brand-name" placeholder="Name" />
                        </div>
                        <div class="form-group">
                            <label for="slug">Brand Slug</label>
                            <input type="text" class="form-control" name="slug" id="brand-slug" placeholder="Slug" />
                        </div>
                        <div class="form-group">
                            <label for="enum">Vehicle type</label>
                            <?php echo vehicleTypeCheckBox(); ?>
                        </div>
                        <input type="hidden" name="id" value="0" /> 
                        <button type="submit" class="btn btn-primary">Save New Brand</button> 
                        <button type="reset" class="btn btn-default">Reset</button> 

                    </form>
                </div>		


            </div>

            <br>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New Model with Bran
                    </h3>
                </div>

                <div class="panel-body">                   
                    <form action="<?php echo Backend_URL; ?>brands/create_action" name="model_form" method="post">
                        <input type="hidden" name="id" value="0" /> 
						<div class="form-group">
                            <label for="name">Model Name</label>
                            <input type="text" class="form-control" name="name" id="model-name" placeholder="Name" />
                        </div>
                        <div class="form-group">
                            <label for="slug">Model Slug</label>
                            <input type="text" class="form-control" name="slug" id="model-slug" placeholder="Slug" />
                        </div>
						<div class="form-group">
                            <label for="parent_id">Select Brand</label>
                            <?php $brands = Modules::run('Brands/all_brands'); ?>

                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="0"> --- Parent ID --- </option>
                                <?php foreach ($brands as $brand) : ?>
                                    <option value="<?php echo $brand->id ?>"><?php echo $brand->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
						
                        <div class="form-group">
                            <label for="type_id">Vehicle Type</label>
                            <select class="form-control" name="type_id" id="type_id">
                                <?php echo vehicleType(); ?>
                            </select>

                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save New</button> 
                        <button type="reset" class="btn btn-default">Reset</button> 

                    </form>
                </div>		


            </div>

        </div>



        <div class="col-sm-8 col-xs-12">
            <div class="panel panel-default">            
                <div class="panel-heading">
                    <h3 class="panel-title">                                               
                        <i class="fa fa-users" aria-hidden="true"></i> 
                        List of Brands & Models
                    </h3>
                </div>

                <div class="panel-body no-padding">
                    <form action="<?php echo Backend_URL; ?>brands" class="col-md-6 pull-right form-inline" method="get">
                        <div class="input-group pull-right">
                            <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                            <span class="input-group-btn">
                                <?php if ($q <> '') { ?>
                                    <a href="<?php echo ( Backend_URL . 'brands'); ?>" class="btn btn-default">Reset</a>
                                <?php } ?>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </span>
                        </div>
                    </form>

                    <table class="table table-hover table-striped table-condensed" style="margin-top: 50px">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Parent Id</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Type</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($brands_data as $brands) { ?>
                                <tr>
                                    <td><?php echo $brands->id ?></td>
                                    <td><?php echo $brands->parent_id ?></td>
                                    <td><?php echo $brands->name ?></td>
                                    <td><?php echo $brands->slug ?></td>
                                    <td><?php echo $brands->type ?></td>
                                    <td>
                                        <?php
                                        echo anchor(site_url(Backend_URL . 'brands/update/' . $brands->id), '<i class="fa fa-fw fa-edit"></i>', 'class="btn btn-xs btn-default"');
                                        echo anchor(site_url(Backend_URL . 'brands/delete/' . $brands->id), '<i class="fa fa-fw fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?> 
                        </tbody>                            
                    </table>

                    <div class="row" style="padding: 10px;">
                        <div class="col-md-3">
                            <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>
                        </div>
                        <div class="col-md-9 text-right">
                            <?php echo $pagination ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $("#brand-name").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        $("#brand-slug").val(Text);
    });

    $("#model-name").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        $("#model-slug").val(Text);
    });
</script>