<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> CMS  <small>Control panel</small> <?php echo anchor(site_url( Backend_URL . 'cms/create'),' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">CMS</li>
    </ol>
</section>


<section class="content">       
    <div class="box">            
        <div class="box-header with-border"> 
            <div class="col-md-3"><h5><b>List of Pages</b></h5></div>
            <div class="col-md-3 pull-right text-right">
                <form action="<?php echo site_url( Backend_URL . 'cms'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php if ($q <> '') { ?>
                                <a href="<?php echo site_url( Backend_URL . 'cms'); ?>" class="btn btn-default">Reset</a>
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
                        <th>Post Title</th>				
                        <th width="140">Created</th>
                        <th width="50">Status</th>		
                        <th width="120" class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cms_data as $cms) { ?>
                    <tr>
                        <td><?php echo $cms->id ?></td>		
                        <td><b><?php echo $cms->post_title ?></b></td>		
                        <td><?php echo globalDateTimeFormat($cms->created) ?></td>		
                        <td><?php echo $cms->status ?></td>		
                        <td class="text-right">
                            <?php 
                            
                                if($cms->post_url === 'home'){
                                    $page_url = '';
                                } elseif ($cms->post_url == 'sign-in') {
                                    $page_url = 'my-account';
                                } elseif ($cms->post_url == 'sign-up') {
                                    $page_url = 'my-account?mode=signup';
                                }else {
                                    $page_url = $cms->post_url;
                                }
                            
                            
                                echo anchor(site_url(  $page_url  ),'<i class="fa fa-fw fa-external-link"></i>', 'class="btn btn-xs btn-default" target="_blank"'); 
                                echo anchor(site_url(  Backend_URL .  'cms/update/'.$cms->id),'<i class="fa fa-fw fa-edit"></i>',  'class="btn btn-xs btn-default"'); 
                                echo anchor(site_url(  Backend_URL .  'cms/delete/'.$cms->id),'<i class="fa fa-fw fa-trash"></i> ', 'class="btn btn-xs btn-danger" onclick="javascript: return confirm(\'Are You Sure ?\')"');
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                    </tbody>
                </table>
            </div>


            <div class="row">            
                <div class="col-md-6">
                    <span class="btn btn-primary">Total Page: <?php echo $total_rows ?></span>	    
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $pagination ?>
                </div>             
            </div>
        </div>
    </div>
</section>