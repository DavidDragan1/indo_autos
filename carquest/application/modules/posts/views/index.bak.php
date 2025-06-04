<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Coming form controller
// $access = $access;
 ?>
<?php load_module_asset('posts', 'css' );?>

  
<section class="content-header">
    <h1> Posts <small>Control panel</small> <?php echo anchor( ( Backend_URL . 'posts/create'),' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Posts</li>
    </ol>
</section>

<section class="content">       
    <div class="box">            
        <div class="box-header with-border">                                   
            <div class="col-md-3 col-md-offset-9 text-right">
                <form action="<?php echo site_url( Backend_URL .'posts/'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php if ($q <> '') { ?>
                                <a href="<?php echo site_url('admin/posts'); ?>" class="btn btn-default">Reset</a>
                            <?php } ?>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
     <form method="POST" id="all_posts_select">
        <div class="box-body">
            <div class="table-responsive">
           
            <table class="table table-striped table-hover table-condensed">                           
                <thead>
                    <tr>
                        <th width="30">#</th>
                        <th width="40">ID</th>
                        <th width="100">Photo</th>
                        <th>Short Details</th>
                        <th>Deadline Status</th>
                        <th width="90" class="hit-count">Total View</th>
                        <th width="90">Status</th>
                        <th width="110">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    
                <?php foreach ($posts as $post) { ?>
                    <tr>
                        <td><input type="checkbox" name="post_id[]" value="<?php echo $post->id; ?>"></td>
                        <td><?php echo $post->id; ?></td>
                        <td style="position:relative;"><?php echo GlobalHelper::getPostFeaturedPhoto($post->id, 'small', $post->advert_type );?></td>
                        <td class="post_details">							 
                                <h4><a target="_blank" href="<?php echo site_url('post/' . $post->post_slug ); ?>"><?php echo $post->title ?></a></h4>
                                <p><label>Reg.No. <span class="text-info"><?php echo $post->registration_no ?></span></label></p>
                                <p><strong>Posted by: </strong> <em><?php echo Modules::run('users/usernameById', $post->user_id); ?></em></p>	
                                <p><strong>Advert Type: </strong> <em><?php echo $post->advert_type ?></em></p>																	
                        </td>
						
                        <td id="expiry_date_<?php echo $post->id; ?>">                            
                           <?php echo deadline( $post->created, $post->expiry_date ); ?>                                                                           
                        </td>
                        <td class="hit-count"><?php echo $post->hit; ?></td>                                        
                        
                        <td>
                        <?php echo GlobalHelper::getStatus($post->status,$post->id, $access); ?>

                        <br/><?php echo GlobalHelper::isFeatured($post->is_featured,$post->id, $access); ?>
                            						
                        </td>
                         
                        <td class="text-right">
                            <?php 
                            echo anchor(('post/'.$post->post_slug),'<i class="fa fa-fw fa-external-link"></i>', 'class="btn btn-xs btn-default" target="_blank"'); 
                            echo anchor((Backend_URL . 'posts/update_general/'.$post->id),'<i class="fa fa-fw fa-edit"></i>',  'class="btn btn-xs btn-default"'); 
                            echo anchor((Backend_URL . 'posts/delete/'.$post->id),'<i class="fa fa-fw fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                    </tbody>
                </table>
               
            </div>

            <div id="ajax_respond"> </div>
                 
            <div class="row" style="padding-top: 10px;">                                      
                   <div class="col-md-5">
                       
                       <div class="row">
                           <div class="col-md-12">
                            <div class="col-md-3 no-padding">
                                <label class="btn btn-default"><input type="checkbox" name="checkall" onclick="checkedAll();"> Mark All</label>                                                             
                            </div>

                            <div class="col-md-4 no-padding">
                                 <select class="form-control" name="action" onchange="setExpireDate(this.value)">
                                     <option value="0">--Bulk Action--</option>
                                     <option value="Active">Mark as Active</option>
                                     <option value="Inactive">Mark as Inactive</option>
                                     <option value="Sold">Mark as Sold</option>
                                     <option value="Yes">Mark as Featured Listing</option>
                                     <option value="No">Mark as Regular Listing</option>
                                     <option value="Extended">Extended Expiration Date</option>
                                     <option value="Delete">Delete</option>                                                                        
                                 </select>

                             </div>
                            <div class="col-md-3 no-padding" id="extended" style="display: none;">

                                 <input type="text" name="extended_date" placeholder="Set Date"  class="form-control input-md js_datepicker">

                             </div>
                            <div class="col-md-2 no-padding">
                                 <button type="button" id="open_dialog" class="btn btn-primary btn-flat">Action</button>
                            </div>
                           </div>
                       </div>
                        
                       
                        
                       
                      
                       
                    </div>
                                                
                    <div class="col-md-7 text-right">
                        <?php echo $pagination; ?>
                        <span class="btn btn-primary" style="margin-right:10px; font-size: 12px;">Total Record: <?php echo $total_rows; ?></span>
                    </div>                 
            </div>
        </div>
     </form>
    </div>
</section>
<?php load_module_asset('posts', 'js' );?>
