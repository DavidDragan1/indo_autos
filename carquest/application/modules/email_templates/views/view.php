<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>Email Templates  <small>Preview</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'email_templates') ?>">Email Templates</a></li>
        <li class="active">Preview</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">                
                <div class="box-body">
                    <div><?php echo mail_header($title).$template.mail_footer(); ?></div>
                </div>
                                                                                       
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Notes</h3>
                </div>
                <table class="table table-striped">
                    
                    <tr><td width="90">Admin notes</td><td width="5">:</td><td><?php echo $adminnotes; ?></td></tr>
                    <tr><td>Slug</td><td>:</td><td><?php echo $slug; ?></td></tr>                    
                    <tr><td>Status</td><td>:</td><td><?php echo $status; ?></td></tr>                                        
                    <tr><td>Created</td><td>:</td><td><?php echo $created; ?></td></tr>
                    <tr><td>Modified</td><td>:</td><td><?php echo $modified; ?></td></tr>
                    <tr><td></td><td></td><td>
                            <a href="<?php echo site_url(Backend_URL . 'email_templates') ?>" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> Back</a>
                            <a href="<?php echo site_url(Backend_URL . 'email_templates/update/' . $id) ?>" class="btn btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                        </td></tr>
                </table>
            </div>
        </div>
    </div>


</section>