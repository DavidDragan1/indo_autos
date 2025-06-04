<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Diagnostic  <small>Delete</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li><li><a href="<?php echo Backend_URL ?>Diagnostic">Diagnostic</a></li>
        <li class="active">Delete</li>
    </ol>
</section>

<section class="content">
    <?php echo helpTabs($id, 'delete'); ?>
    <div class="box no-border">
        <div class="box-header with-border">
            <h3 class="box-title">Preview Before Delete</h3>
        </div>
        <table class="table table-striped">             
            <tr><td width="150">Question</td><td width="5">:</td><td><?php echo $title; ?></td></tr>
            <tr><td width="150">Problem</td><td width="5">:</td><td><?php echo $problem; ?></td></tr>
            <tr><td width="150">Inspection</td><td width="5">:</td><td><?php echo $inspection; ?></td></tr>
            <tr><td width="150">Solution</td><td width="5">:</td><td><?php echo $content; ?></td></tr>
            <tr><td width="150">Created</td><td width="5">:</td><td><?php echo $created; ?></td></tr>
            <tr><td width="150">Modified</td><td width="5">:</td><td><?php echo $modified; ?></td></tr>
        </table>
        <div class="box-header">
            <?php echo anchor(site_url(Backend_URL . 'diagnostics/delete_action/' . $id), '<i class="fa fa-fw fa-trash"></i> Confrim Delete ', 'class="btn btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); ?>
        </div>
    </div>
</section>