<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Diagnostics  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li><li><a href="<?php echo site_url(Backend_URL . 'diagnostics') ?>">Diagnostics</a></li>
        <li class="active">Details</li>
    </ol>
</section>

<section class="content">
    
    <div class="row">
        <div class="col-md-8">
            <?php echo helpTabs($id, 'read'); ?>       
        <div class="box no-border">
            <div class="box-header with-border">
                <h3 class="box-title">Details View</h3>
                <?php echo $this->session->flashdata('message'); ?>
            </div>
            <table class="table table-striped">
                <tr><td width="100">Question</td><td width="5">:</td><td><p><b><?php echo $title; ?></b></p></td></tr>
                <tr><td>Problem</td><td width="5">:</td><td><p><?php echo $problem; ?></p></td></tr>
                <tr><td>Inspection</td><td width="5">:</td><td><p><?php echo $inspection; ?></p></td></tr>
                <tr><td>Solution</td><td width="5">:</td><td><p><?php echo $content; ?></p></td></tr>
            </table>
        </div>
        </div>
        <div class="col-md-4">
            <div class="box no-border" style="margin-top: 28px;">
            <div class="box-header with-border">
                <h3 class="box-title">Summer | Question By</h3>                
            </div>
            <table class="table table-striped">
                <tr><td>Status</td><td width="5">:</td><td><?php echo $status; ?></td></tr>
                <tr><td>Created</td><td width="5">:</td><td><?php echo globalDateFormat($created); ?></td></tr>
                <tr><td>Updated</td><td width="5">:</td><td><?php echo globalDateFormat($modified); ?></td></tr>                
                <tr><td colspan="3">
                        <a href="<?php echo site_url(Backend_URL . 'diagnostics') ?>" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> Back</a>
                        <a href="<?php echo site_url(Backend_URL . 'diagnostics/update/' . $id) ?>" class="btn btn-primary"> <i class="fa fa-edit"></i> Edit/Update</a>
                        <a href="diagnostics/delete/<?php echo $id;?>" onclick="return confirm('Confirm Delete?');" class="btn btn-danger">
                            <i class="fa fa-times"></i> Delete
                        </a>
                    </td></tr>                
            </table>
        </div>
            
        </div>
    
    </div>
    
</section>