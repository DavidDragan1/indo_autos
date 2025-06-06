<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    load_module_asset('email_templates', 'css');
    load_module_asset('email_templates', 'js');
?>
<section class="content-header">
    <h1> Email Template  <small><?php echo $button ?></small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL; ?>email_templates">Email templates</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">
    <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    

                    <div class="box-body">

                        <?php echo $this->session->flashdata('message'); ?>
                        <div class="form-group  no-margin">
                            <label for="title" class="control-label">Email Subject :</label>
                            <?php echo form_error('title') ?>                    
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo $title; ?>" />                                                             
                        </div>
                        
                        <div class="form-group no-margin">        
                            <label for="template" class="control-label">Email Boby: </label>
                            <?php echo form_error('template') ?>                            
                            <textarea class="form-control" rows="4" name="template" id="template" placeholder="Template"><?php echo $template; ?></textarea>                                                            
                        </div>

                        <div class="form-group no-margin">
                            <label for="adminnotes" class="control-label">Notes :</label>
                            <textarea class="form-control" name="adminnotes" id="adminnotes"><?php echo $adminnotes; ?></textarea>                                
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Settings</h3>
                    </div>

                    <div class="box-body">

                        <div class="form-group">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-addon">Slug :</span>
                                <input type="text" class="form-control" <?php echo ($status =='Locked') ? ' readonly': '' ?> name="slug" id="slug" placeholder="Slug" value="<?php echo $slug; ?>"/>
                              </div> 
                                <?php echo form_error('slug') ?>  
                            </div>
                                                                                                                                         
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                              <div class="input-group">
                                <span class="input-group-addon">Status :</span>
                                <select name="status" class="form-control">
                                    <?php echo status($status); ?>
                                </select>
                                
                              </div>
                            </div>
                        </div>
                        
                      
                        <div class="col-md-12 text-right">
                            
                            <a href="<?php echo site_url( Backend_URL . 'email_templates') ?>" class="btn btn-default"> <i class="fa fa-long-arrow-left" ></i> Back</a>
                            <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
                            
                            
                        </div>
                    </div></div>
            </div>
        </div>
    </form>

</section>

<script type="text/javascript" src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('template', {
    toolbar: [
        {name: 'document', items: ['NewPage', 'Preview', '-', 'Templates']}, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
        ['Cut', 'Copy', 'Paste', 'Undo', 'Redo', 'Links'], // Defines toolbar group without name.
        // Line break - next group will be placed in new line.
        {name: 'basicstyles', items: ['Bold', 'Italic', 'Source']},
        { name: 'links', items: [ 'Link', 'Unlink' ] },
    ],
    // uiColor: '#337ab7'

});


</script>
