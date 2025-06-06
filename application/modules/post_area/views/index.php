<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Manage State  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">State</li>
    </ol>
</section>

<section class="content">
    <div class="row">


        <div class="col-sm-4 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New State
                    </h3>
                </div>

                <div class="panel-body">
                    <form action="<?=Backend_URL?>post_area/create_action" method="POST">
                        <input type="hidden" name="post_qty" value="0" />
                        <div class="form-group">
                            <label for="country_id">Select Country</label>
                            <select name="country_id" id="country_id" class="form-control">
                                <?php echo getDropDownCountries(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name-state" placeholder="Name" />
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug-state" placeholder="Slug" />
                        </div>

                        <div class="form-group">
                            <label>Is Home&nbsp;</label>&nbsp;&nbsp;
                            <?php echo htmlRadio('is_home', 'No', ['Yes' => 'Yes', 'No' => 'No']); ?>
                        </div>
                        <input type="hidden" name="id" value="0" />
                        <button type="submit" class="btn btn-primary">Save New</button>
                        <a href="<?php echo site_url('post_area') ?>" class="btn btn-default">Reset</a>
                    </form>
                </div>
            </div>

            <br>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New Location with State
                    </h3>
                </div>

                <div class="panel-body">
                    <form action="<?=Backend_URL?>post_area/create_location" method="post">
                        <input type="hidden" name="id" value="0" />
                        <div class="form-group">
                            <label for="name">Location Name</label>
                            <input type="text" class="form-control" name="name" id="name-location" placeholder="Name" />
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" name="slug" id="slug-location" placeholder="Slug" />
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Select State</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <?php echo all_location() ?>
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
                    <div class="row">
                        <div class="col-md-4 pull-left">
                            <h3 class="panel-title"><i class="fa fa-list"></i> List of State</h3>
                        </div>


                        <div class="col-md-8 text-right">

                        </div>
                    </div>
                </div>


                <div class="panel-body">

                    <table class="table table-bordered table-striped" id="mytable">
                        <thead>
                            <tr>
                                <th width="80px">No</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Type</th>
                                <th>Country</th>
                                <th>Post Qty</th>
                                <th>Show in Home</th>
                                <th width="50">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($states as $state) { ?>
                                <tr>
                                    <td><?php echo $state->id ?></td>
                                    <td><?php echo $state->name ?></td>
                                    <td><?php echo $state->slug ?></td>
                                    <td><?php echo $state->type ?></td>
                                    <td><?php echo getCountryName($state->country_id)?></td>
                                    <td><?php echo GlobalHelper::countPostByState($state->id); ?></td>
                                    <td><?php echo $state->is_home ?></td>
                                    <td>
                                    <?php
                                    echo anchor(site_url(Backend_URL . 'post_area/update/' . $state->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                                    ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $("#mytable").dataTable();
    });
    $("#name-state").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        $("#slug-state").val(Text);
    });

    $("#name-location").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        $("#slug-location").val(Text);
    });
</script>
