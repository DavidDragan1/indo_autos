<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header" id="js_ajax_scroll">
    <h1> Database Synchronize  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">DB</li>
    </ol>          
</section>

<section class="content">
    <div class="alert alert-warning">
        <h2> <i class="fa fa-warning"></i> Warning! Database Zone is Very Sensitive</h2>
        <p>If you don not have any db back and restore knowledge then</p>
    </div>
    
    <div class="row">                
        <div class="col-md-6"> 

            <?php $this->load->view('history'); ?>
        </div>

        <div class="col-md-6">

            <div class="box">
                <div class="box-header">                        
                    <button id="backup_full_db" class="btn btn-primary"><i class="fa fa-cloud-download"></i> Backup Full DB</button>                                                                                     
                </div>
            </div>
            <div class="box">
                <div class="box-header">

                    <div class="btn btn-default btn-file">
                        <i class="fa fa-hdd-o"></i> Upload Your Local DB
                        <input type="file" name="db">
                    </div>


                    <div class="form-group">
                        <label class="col-md-4 control-label">DB Type</label>
                        <div class="col-md-4">                            
                            <label class="radio">
                                <input type="radio" value="database" name="db_type" checked="checked">
                                Full Database 
                            </label>
                            
                            <label class="radio">
                                <input type="radio" value="table" name="db_type">
                                Single Table
                            </label>
                        </div>

                    </div>


                    <button id="backup_full_db" class="btn btn-primary"><i class="fa fa-cloud-upload"></i> Upload Your DB/Table</button>                                                                                     
                </div>
            </div>

            <?php $this->load->view('tables'); ?>

        </div>
    </div>          
</section>

<?php load_module_asset('db_sync', 'js'); ?>