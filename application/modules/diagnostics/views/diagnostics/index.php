<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> Diagnostic  
        <small>Control panel</small>         
    
        <form action="<?php echo site_url(Backend_URL . 'diagnostics'); ?>" class="form-inline" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                <span class="input-group-btn">
                    <?php if ($q <> '') { ?>
                        <a href="<?php echo site_url(Backend_URL . 'diagnostics'); ?>" class="btn btn-default">Reset</a>
                    <?php } ?>
                    <button class="btn btn-primary" type="submit">Search</button>
                    <?php echo anchor(site_url(Backend_URL . 'diagnostics/create'), ' + Add New', 'class="btn btn-warning"'); ?>
                </span>
            </div>
        </form>
    </h1>

    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Diagnostics</li>
    </ol>
</section>
<style type="text/css">.label-big { font-size: 11pt;}</style>

<section class="content">

    <!-- row -->
    <div class="row">

        <div class="col-md-12 no-padding">
            <?php echo $this->session->flashdata('message'); ?>
            
            <!-- The time line -->
            <ul class="timeline">
                <?php foreach ($diagnostics_data as $diagnostic) { ?>
                <li>
                    <i class="fa fa-question  bg-blue"></i>

                    <div class="timeline-item">
                        <span class="time">
                            <i class="fa fa-calendar"></i>&nbsp; 
                            <?php echo globalDateFormat($diagnostic->created); ?>
                        </span>
                        <h3 class="timeline-header">
                            <p><a href="javascript::void(0);">
                                <?php echo $diagnostic->title; ?></a></p>
                            <p>
                                <span class="label label-info"><?php echo 'Status: ' . $diagnostic->status; ?></span>&nbsp;
                                <em><?php echo getQuestionBy($diagnostic); ?> </em>

                                <span class="label label-big pull-right label-warning">
                                    Popular: 
                                    <?php echo ($diagnostic->featured); ?>
                                </span>
                            </p>                            
                        </h3>
                        <div class="timeline-body">
                            <?php echo showMoreTxtBtn($diagnostic->content, 250); ?>
                        </div>
                        <div class="timeline-footer">
                            <a href="diagnostics/read/<?php echo $diagnostic->id;?>" class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i> Give / Update Answer
                            </a>
                            <a href="diagnostics/delete/<?php echo $diagnostic->id;?>" onclick="return confirm('Confirm Delete?');" class="btn btn-danger btn-xs">
                                <i class="fa fa-times"></i> Delete
                            </a>
                        </div>
                    </div>
                </li>
                <?php } ?>
                <!-- END timeline item -->


            </ul>
        </div><!-- /.col -->
    </div><!-- /.row -->





    <div class="row">                
        <div class="col-md-6">
            <span class="btn btn-primary">Total Question : <?php echo $total_rows ?></span>

        </div>
        <div class="col-md-6 text-right">
            <?php echo $pagination ?>
        </div>                
    </div>

</section>


