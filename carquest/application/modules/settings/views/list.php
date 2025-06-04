<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Settings  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Settings</li>
    </ol>
</section>

<section class="content">
    <div class="row">           
        <div class="col-md-12 col-xs-12">
            <div class="panel panel-default">            
                <div class="panel-heading">					 
                    <h3 class="panel-title">
                        <i class="fa fa-users" aria-hidden="true"></i> 
                        Settings List                    
                    </h3>                                                        
                </div>
                <div class="panel-body">

                    <table class="table table-hover table-condensed" style="margin-bottom: 10px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Label</th>
                                <th>Value</th>
                                <th width="130">Action</th>
                            </tr>
                        </thead><?php foreach ($settings_data as $settings) { ?>
                            <tr>
                                <td><?php echo $settings->id ?></td>
                                <td><?php echo $settings->label ?></td>
                                <td><?php //echo $settings->value ?></td>
                                <td>
                                    <?php
                                    //echo anchor(site_url(Backend_URL . 'settings/read/' . $settings->id), '<i class="fa fa-fw fa-external-link"></i> View', 'class="btn btn-xs btn-default"');
                                    echo anchor(site_url(Backend_URL . 'settings/update/' . $settings->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                                    echo anchor(site_url(Backend_URL . 'settings/delete/' . $settings->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>              
                </div>
            </div>
        </div>
    </div>
</section>