<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('files', 'css'); ?>
<section class="content-header">
    <h1> File  <small>Control panel</small>

        <?php echo anchor(site_url(Backend_URL . 'files/create'), ' + Upload New', 'class="btn btn-default"'); ?>

    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>        
        <li class="active">File</li>
    </ol>
</section>


<section class="content">       
    <div class="box">            
        <div class="box-header with-border">                                   
            <div class="col-md-3 col-md-offset-9 text-right">
                <form action="<?php echo site_url(Backend_URL . 'files'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php if ($q <> '') { ?>
                                <a href="<?php echo site_url(Backend_URL . 'files'); ?>" class="btn btn-default">Reset</a>
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
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th width="40">ID</th>
                            <th width="80">Date</th>
                            <th>Title</th>                           
                            <th width="80">File</th>                            
                                                        
                            <th width="175">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($files as $file) { ?>
                            <tr>
                                <td><?php echo ++$start ?></td>
                                <td><?php echo globalDateFormat($file->created); ?></td>                                    
                                <td title="Uploaded By: <?php echo getUserNameByID($file->user_id) ?>">
                                    <?php echo $file->title ?>
                                </td>                               
                                <td><?php echo admin_download_attachment($file->attach); ?></td>                                
                                
                                <td>                                                                                                                                            
                                <?php      
                                    // echo file_action($file->id);
                                    echo anchor(site_url(Backend_URL . 'files/update/' . $file->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                                    echo anchor(site_url(Backend_URL . 'files/delete/' . $file->id), 
                                            '<i class="fa fa-fw fa-times"></i> Delete ', 
                                            'class="btn btn-xs btn-danger" onclick="return confirm(\'Confirm File Delete!\')"');
                                ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


            <div class="row">                
                <div class="col-md-6">
                    <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>

                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>                
            </div>
        </div>
    </div>
</section>
<?php load_module_asset('files', 'js'); ?> 
<?php $this->load->view('preview_modal'); ?>

