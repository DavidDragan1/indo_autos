<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('files','css');?>
<section class="content-header">
    <h1>File Upload</h1>
   <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>learner">Learner</a></li>
        <li class="active">File</li>
    </ol>
</section>

<section class="content"> 
    <div class="box box-primary">

        <div class="panel-body user_profile_form">
            
            <form class="form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="page_management">
                        <div id="output"></div>



                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Title</span>
                                <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
                            </div>
                            <?php echo form_error('title') ?>
                        </div>


                       <?php /*  <div class="form-group"> 
                            <div class="input-group">
                                <span class="input-group-addon">Category</span>                                    
                                <select id="category" name="category" class="form-control">
                                    <?php
                                    echo selectOptions($category, array(
                                        'Additional Material' => 'Additional Material',
                                        'Support Centre' => 'Support Centre'
                                    ));
                                    ?>                        
                                </select> 
                            </div>
                        </div> */ ?>


                        <div class="form-group">
                            <div class="col-sm-12 no-padding">
                                <input type="file" name="file">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="box-footer">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    
                    <button class="btn btn-primary" type="submit">
                        <i class="fa fa-upload" aria-hidden="true"></i> Upload
                    </button>

                    <a href="<?php echo site_url( Backend_URL . 'files'); ?>" class="btn btn-default">
                        <i class="fa fa-long-arrow-left"></i> Back
                    </a>
                </div>
            </form>


        </div>

    </div>

</section>
