<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Help  <small>Control panel</small> <?php echo anchor(site_url(Backend_URL . 'help/create'), ' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li><li class="active">Help</li>
    </ol>
</section>

<section class="content">       
    <div class="box">            
        <div class="box-header with-border">                                   
            <div class="col-md-3 col-md-offset-9 text-right">
                <form action="<?php echo site_url(Backend_URL . 'help'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php if ($q <> '') { ?>
                                <a href="<?php echo site_url(Backend_URL . 'help'); ?>" class="btn btn-default">Reset</a>
                            <?php } ?>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="box-body">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="table-responsive">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th width="40">ID</th>
                            <th>Question</th>                            
                            <th>Created</th>
                            <th>Modified</th>
                            <th width="220">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($help_data as $help) { ?>
                            <tr>
                                <td><?php echo ++$start ?></td>
                                <td>
                                    <h3><?php echo $help->title; ?></h3>
                                    <?php echo htmlentities($help->content); ?>
                                </td>                                
                                <td><?php echo globalDateFormat($help->created) ?></td>
                                <td><?php echo globalDateFormat($help->modified) ?></td>
                                <td>
                                    <?php
                                    echo anchor(site_url(Backend_URL . 'help/read/' . $help->id), '<i class="fa fa-fw fa-external-link"></i> View', 'class="btn btn-xs btn-default"');
                                    echo anchor(site_url(Backend_URL . 'help/update/' . $help->id), '<i class="fa fa-fw fa-edit"></i> Update', 'class="btn btn-xs btn-warning"');
                                    echo anchor(site_url(Backend_URL . 'help/delete/' . $help->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="return confirm(\'Confirm Delete?\')"');
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


            <div class="row">                
                <div class="col-md-6">
                    <span class="btn btn-primary">Total Question : <?php echo $total_rows ?></span>

                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>                
            </div>
        </div>
    </div>
</section>