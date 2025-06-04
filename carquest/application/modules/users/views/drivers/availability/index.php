<?php load_module_asset('users', 'css'); ?>
<?php load_module_asset('users', 'js'); ?>
<section class="content-header">
    <h1> Driver
        <small>Availability</small> &nbsp;&nbsp;
        <?php echo anchor(site_url('admin/users/add-availability/' . $user_id), ' + Add Availability', 'class="btn btn-default"'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin </a></li>
        <li class="active">Availability</li>
    </ol>
</section>
<section class="content" style="margin-bottom: -100px">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-clock-o" aria-hidden="true"></i>Driver Availability
            </h3>
        </div>
        <div class="panel-body">
            <div>
                <h4>
                Driver is
                <span class="<?= $driver->status == 'Available' ? 'text-success' : 'text-danger' ?>">
                    <?= $driver->status == 'Available' ? 'Available' : 'Unavailable' ?>
                </span>
                </h4>
            </div>
            <div class="float-right">
                <form action="<?=site_url('admin/users/availability-status-change/' . $user_id)?>">
                    <button type="submit" class="btn btn-info">Change Status</button>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="panel panel-default">

        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-users" aria-hidden="true"></i> List of Driver Availability
            </h3>
        </div>


        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>From</th>
                <th>To</th>
                <th width="200">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $key => $post) { ?>
                <tr>
                    <td class="fw-500"><?= $post->name ?></td>
                    <td><?= $post->term ?></td>
                    <td><?= $post->start_date ?></td>
                    <td><?= $post->end_date ?></td>
                    <td>
                        <?php
                        echo anchor(site_url(Backend_URL . 'users/availability-update/' . $post->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                        echo anchor(site_url(Backend_URL . 'users/availability-delete/' . $post->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                        ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>


        <div class="row" style="padding-top: 10px; padding-bottom: 10px; margin: 0;">
            <div class="col-md-6">
                <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>
            </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </div>
</section>
<script>
    $(window).on('load', function () {
        date_range($('select[name="range"]').val())
    })

    function date_range(range) {
        var range = range;
        if (range == 'Custom') {
            $('#custom').css('display', 'block');
        } else {
            $('#custom').css('display', 'none');
        }
    }
</script>
