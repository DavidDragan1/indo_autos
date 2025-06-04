<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Email Templates  <small>Control panel</small> <?php echo anchor(site_url( Backend_URL . 'email_templates/create'),' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Email Templates</li>
    </ol>
</section>

<section class="content">       
    <div class="box">            
        <div class="box-header with-border">                                   
            <div class="col-md-3 col-md-offset-9 text-right">
                <form action="<?php echo site_url( Backend_URL .'email_templates'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php if ($q <> '') { ?>
                                <a href="<?php echo site_url( Backend_URL .'email_templates'); ?>" class="btn btn-default">Reset</a>
                            <?php } ?>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                        <tr>
                            <th width="40">ID</th>
                            <th>Subject</th>
                            <th width="210">Slug for Callback</th>                            
                            <th width="210">Action</th>
                        </tr>
                    </thead>

                    <tbody class="table-striped">
                    <?php foreach ($email_templates_data as $email_templates) { ?>
                        <tr>
                            <td><?php echo $email_templates->id ?></td>
                            <td><p><?php echo $email_templates->title ?><br/>                            
                                    <small><em><?php echo $email_templates->adminnotes ?></em></small></p>
                            </td>
                            <td><?php echo $email_templates->slug ?></td>                            
                            <td>
                            <?php
                                echo anchor(site_url(Backend_URL .'email_templates/read/'.$email_templates->id),'<i class="fa fa-fw fa-external-link"></i> Preview', 'class="btn btn-xs btn-default"');
                                echo anchor(site_url(Backend_URL .'email_templates/update/'.$email_templates->id),'<i class="fa fa-fw fa-edit"></i> Edit',  'class="btn btn-xs btn-default"');
                                echo getETdeleteButton( $email_templates->status, $email_templates->id);
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