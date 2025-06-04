<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    load_module_asset('cms', 'css');
    load_module_asset('cms', 'js');
?>
<section class="content-header">
    <h1> CMS  <small>Control panel</small> <?php echo anchor(site_url('admin/cms/new_post'), ' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL); ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Cms</li>
    </ol>
</section>

<section class="content">       
    <div class="box">            
        <div class="box-header with-border"> 
            <div class="col-md-3"><h5><b>List of Pages</b></h5></div>
            <div class="col-md-3 pull-right text-right">
                <form action="<?php echo site_url('admin/cms/posts'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php if ($q <> '') { ?>
                                <a href="<?php echo site_url('admin/cms'); ?>" class="btn btn-default">Reset</a>
                            <?php } ?>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="box-body no-padding">
            <div class="">


                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th width="40">ID</th>
                            <th width="100">Thumb</th>
                            <th>Details</th>
                            <th>Category</th>
                            <th>Post Date</th>
                            <th width="90">Status</th>                            
                            <th width="115">Action</th>
                        </tr>
                    </thead>

                    <tbody>


                        <?php foreach ($post_data as $cms) { ?>
                            <tr>
                                <td><?php echo $cms->id ?></td>                       
                                <td><?php echo getCMSFeaturedThumb( $cms->thumb, 'tiny' )?></td>                                         
                                <td class="post_details">        
                                    <h4><?php echo getShortContent($cms->post_title, 40); ?></h4>                                    
                                    <p><b>Posted by: </b> <em><?php echo Modules::run('users/usernameById', $cms->user_id); ?></em></p>                                       
                                </td>
                                
                                <td><?php echo caretoryParentIdByName($cms->parent_id); ?></td>
                                <td><?php echo globalDateFormat( $cms->created ) ?></td>
                                <td>                                                                                                        
                                <div class="dropdown">                                    
                                    <?php echo getCMSStatus($cms->status, $cms->id);  ?>                                    
                                    <ul class="dropdown-menu">
                                        <li><a onclick="statusUpdate(<?php echo $cms->id; ?>, 'Publish');"> <i class="fa fa-check"></i> Publish</a></li>
                                        <li><a onclick="statusUpdate(<?php echo $cms->id; ?>, 'Draft');"> <i class="fa fa-ban"></i> Draft</a></li>
                                        <li><a onclick="statusUpdate(<?php echo $cms->id; ?>, 'Trash');"> <i class="fa fa-trash-o"></i> Trash</a></li>
                                    </ul>
                                </div>                                                                
                                </td>

                                <td>
                                <?php
                                    echo anchor(site_url($cms->post_url), '<i class="fa fa-fw fa-external-link"></i>', 'class="btn btn-xs btn-default" target="_blank" title="Preveiw"');
                                    echo anchor(site_url('cms/update_post/' . $cms->id), '<i class="fa fa-fw fa-edit"></i>', 'class="btn btn-xs btn-default"  title="Edit"');
                                    echo anchor(site_url('cms/delete/' . $cms->id), '<i class="fa fa-fw fa-trash"></i>', 'class="btn btn-xs btn-danger"  title="Move to Trash" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>





            </div>


            <div class="row">
                <div class="col-md-12" style="padding-bottom:10px">
                    <div class="col-md-6">
                        <span class="btn btn-primary">Total Page: <?php echo $total_rows ?></span>	    
                    </div>
                    <div class="col-md-6 text-right">
                        <?php echo $pagination ?>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</section>