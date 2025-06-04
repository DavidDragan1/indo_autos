<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>

<link rel="stylesheet" href="assets/lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="assets/lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script> $(function () { $("#content").wysihtml5(); }); </script>

<section class="content-header">
    <h1>ask_expert<small><?php echo $button ?></small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li><li><a href="<?php echo Backend_URL ?>ask_expert">ask_expert</a></li>
        <li class="active">Update</li>
    </ol>
</section>

<section class="content">       
    
    <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
    
    <div class="row">
        <div class="col-md-8">
            <?php echo ask_expertTabs($id, 'update'); ?>
    <div class="box no-border">
        
        <div class="box-header with-border">
            <h3 class="box-title">Update Question Answer</h3>
            <?php echo $this->session->flashdata('message'); ?>
        </div>

        <div class="box-body">                                    
            <div class="col-md-12">
                <div class="form-group">
                    <label for="title" class="control-label">Question :</label>                                      
                    <input type="text" class="form-control" name="title" id="title" placeholder="Question" value="<?php echo $title; ?>" />
                    <?php echo form_error('title') ?>
                    
                </div>
                <div class="form-group">
                    <label for="content" class="control-label">Description :</label>

                    <textarea class="form-control" rows="10" name="description" id="description" placeholder="Description"><?php echo $description; ?></textarea>
                    <?php echo form_error('description') ?>
                </div>
                <div class="form-group">        
                    <label for="content" class="control-label">Answer :</label>
                    
                    <textarea class="form-control" rows="10" name="content" id="content" placeholder="Answer"><?php echo $content; ?></textarea>
                    <?php echo form_error('content') ?>
                </div>
            </div>                           
        </div>
    </div>
    
            
        </div>
        <div class="col-md-4">
            
            <div class="box" style="margin-top: 28px;">
                <div class="box-header">
                    <h3 class="box-title">Question By</h3>                    
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">        
                            <label for="content" class="control-label">Name :</label>                                          
                            <input name="email" class="form-control" readonly="" value="<?php echo $qustion_by_name; ?>"/>                    
                        </div>

                        <div class="form-group">        
                            <label for="content" class="control-label">Email :</label>

                            <input name="email" class="form-control"  readonly="" value="<?php echo $question_by_email; ?>"/>                        
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="status" class="control-label">Set Status &nbsp;</label>                        
                            <?php echo htmlRadio('status', $status, array('Published' => 'Published', 'Draft' => 'Draft') ); ?>
                        </div>
                        
                        <div class="form-group">        
                            <label for="content" class="col-sm-5 control-label">Top Ask an Expert</label>
                            <div class="col-sm-7" style="padding-top: 8px;">
                               <?php echo htmlRadio('featured', $featured, array('Yes' => 'Yes', 'No' => 'No') ); ?>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label for="send_notify" class="control-label">Notify to Visitor</label>                        
                            <input type="checkbox" name="send_notify" id="send_notify">                         
                        </div>

                    </div>
                </div>
                <div class="box-footer">
                    
                    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
                    
                    <a href="<?php echo site_url(Backend_URL . 'ask_expert') ?>" class="btn btn-default">Cancel</a>
                    
                    <button type="submit" class="btn btn-primary">Save Update</button> 
                    
                    
                    <a href="ask_expert/delete/<?php echo $id;?>" onclick="return confirm('Confirm Delete?');" 
                       class="btn btn-danger pull-right">
                            <i class="fa fa-times"></i> Delete
                        </a>
                </div>
                    
            </div>
            
            
        </div>
    </div>
     </form>
    
    
    
</section>