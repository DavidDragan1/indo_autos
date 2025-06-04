<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Coming form controller
// $access = $access;
 ?>

<?php load_module_asset('posts', 'css' );?>
<style>
    #updateDate span.input-group-addon {min-width: 40px;}
</style>

<section class="content-header">
    <h1> Posts <small>Control panel</small> <?php echo anchor( ( Backend_URL . 'posts/create'),' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Posts</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border" style="padding: 0;"">
            <?php $this->load->view('filter_form'); ?>

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
                        <th width="80">Change Status</th>
                        <th width="80">Change Position</th>
                        <th width="110">Action</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach ($posts as $post) { ?>
                    <tr>
                        <td><input type="checkbox" name="post_id[]" value="<?php echo $post->id; ?>"></td>
                        <td><?php echo $post->id; ?></td>
                        <td style="position:relative;"><?php echo GlobalHelper::getPostFeaturedPhoto($post->id, 'small', $post->is_featured, 'in_side' );?></td>
                        <td class="post_details">
                                <h4><a target="_blank" href="<?php echo site_url('post/' . $post->post_slug ); ?>"><?php echo $post->title ?></a></h4>
                                <p>Vehicle Type: <?php echo getTagName('vehicle_types', 'name', $post->vehicle_type_id); ?> </p>
                                <p><strong>Posted by: </strong> <em><?php echo getUserName ( $post->user_id); ?></em></p>
                                <p><strong>Listing Type: </strong> <em><?php echo $post->advert_type ?></em></p>
                                <?php echo getPackageName($post->package_id); ?>
                        </td>

                        <td><?php echo deadline( $post->activation_date, $post->expiry_date ); ?>

                            <?php if($post->activation_date){ ?>
                                <br/><span class="btn btn-xs btn-warning chanage_pub_date"
                                           data-date="<?php echo $post->expiry_date; ?>"
                                           data-id="<?php echo $post->id; ?>"
                                           >
                                    <i class="fa fa-calendar"></i>
                                    Change Expire Date
                                </span>

                                <span class="btn btn-xs btn-success change-position-add"
                                      data-featured_section="<?php echo $post->featured_section; ?>"
                                      data-featured_position="<?php echo $post->featured_position; ?>"
                                      data-featured_page="<?php echo $post->featured_page; ?>"
                                      data-brand_id="<?php echo $post->brand_id; ?>"
                                      data-model_id="<?php echo $post->model_id; ?>"
                                      data-id="<?php echo $post->id; ?>"
                                >
                                    <i class="fa fa-calendar"></i>
                                    Make Position AD
                                </span>
                            <?php } ?>
                        </td>
                        <td class="hit-count"><?php echo $post->hit; ?></td>
                        <td>
                            <?php echo GlobalHelper::getStatus($post->status,$post->id, TRUE); ?>
                            <?php //echo GlobalHelper::isFeatured($post->is_featured,$post->id, $access); ?>
                        </td>
                        <td>
                            <?php echo GlobalHelper::getHomePagePosition($post->position, $post->id, TRUE); ?>
                            <?php //echo GlobalHelper::isFeatured($post->is_featured,$post->id, $access); ?>
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

                <?php
                    if(count($posts) == 0 ) {
                        echo '<p class="alert alert-warning">Sorry! You do not have any listing.</p>';

                    }
                ?>


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

                                     <?php if($access) { ?>
                                     <option value="ActiveFor30D">Activation for 30 days</option>
                                     <option value="Active">Mark as Active</option>
                                     <option value="Inactive">Mark as Inactive</option>
                                     <option value="Pending">Mark as Pending</option>

                                     <option value="Yes">Mark as Featured Listing</option>
                                     <option value="No">Mark as Regular Listing</option>
                                     <option value="Extended">Extended Expiration Date</option>
                                     <?php } ?>
                                     <option value="Sold">Mark as Sold</option>
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
<?php load_module_asset('posts', 'js' ); ?>

<script type="text/javascript">

    jQuery(document).on('click', '.chanage_pub_date', function(){
        var id      = jQuery(this).data('id');
        var date    = jQuery(this).data('date');

        $('#id').val( id );
        $('#date').val( date );

        $("#date").datepicker("setDate", new Date(date));

        jQuery('#updateDate').modal({
            show: 'false'
        });


    });

    jQuery(document).on('click', '.change-position-add', function(){
        var id      = jQuery(this).data('id');
        var featured_section    = jQuery(this).data('featured_section');
        var featured_position    = jQuery(this).data('featured_position');
        var featured_page    = jQuery(this).data('featured_page');
        var brand_id    = jQuery(this).data('brand_id');
        var model_id    = jQuery(this).data('model_id');

        $('#post-id').val( id );
        $('#featured_section').val( featured_section );
        $('#featured_position').val( featured_position );
        $('#featured_page').val( featured_page );
        $('#brand_id').val( brand_id );
        $('#model_id').val( model_id );

        jQuery('#position-ad').modal({
            show: 'false'
        });


    });

    function publishDateUpdate(){
       var id = jQuery('#updateDate #id').val();
       var date = jQuery('#updateDate #date').val();
        jQuery.ajax({
            url: 'admin/posts/change_publish_date',
            type: 'POST',
            dataType: "json",
            data: { date: date, post_id: id  },
            beforeSend: function(){
                jQuery('.js_update_respond').html('<p class="ajax_processing">Updating...</p>');
            },
            success: function ( jsonRespond ) {
                jQuery('.js_update_respond').html(jsonRespond.Msg);
                if(jsonRespond.Status === 'OK'){
                    setTimeout(function(){
                        jQuery('#updateDate').modal('hide');
                        location.reload();
                    },2000);
                }
            }
        });
    }

    function position_ad(){
        var post_id = jQuery('#position-ad #post-id').val();
        var featured_section = jQuery('#position-ad #featured_section').val();
        var featured_page = parseInt(jQuery('#position-ad #featured_page').val());
        var featured_position = parseInt(jQuery('#position-ad #featured_position').val());
        var model_id = jQuery('#position-ad #model_id').val();
        var brand_id = jQuery('#position-ad #brand_id').val();
        if (!featured_section){
            jQuery('.js_update_respond_msg').html('<p class="ajax_error">Please Select Section</p>');
        } else if (!featured_page){
            jQuery('.js_update_respond_msg').html('<p class="ajax_error">Please Input Page</p>');
        } else if (!featured_position){
            jQuery('.js_update_respond_msg').html('<p class="ajax_error">Please Input Position</p>');
        } else {
            jQuery.ajax({
                url: 'admin/posts/make_position_add',
                type: 'POST',
                dataType: "json",
                data: { post_id, featured_section, featured_page, featured_position, brand_id, model_id },
                beforeSend: function(){
                    jQuery('.js_update_respond_msg').html('<p class="ajax_processing">Updating...</p>');
                },
                success: function ( jsonRespond ) {
                    jQuery('.js_update_respond_msg').html(jsonRespond.Msg);
                    if(jsonRespond.Status === 'OK'){
                        setTimeout(function(){
                            jQuery('#position-ad').modal('hide');
                            location.reload();
                        },2000);
                    }
                }
            });
        }

    }
</script>

<!-- Modal -->
    <div class="modal fade" id="updateDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" id="access_permission">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Change Post Expire Date</h4>
                    </div>

                    <div class="modal-body" >
                        <div class="js_update_respond"></div>
                        <div>
                            <input type="hidden" name="id" id="id" value="">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>

                                </span>
                                <input type="text" name="date" autocomplete="off" id="date" value="" class="js_datepicker form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button>
                        <button type="button" class="btn btn-primary " onclick="publishDateUpdate();"><i class="fa fa-save"></i> Submit</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

<div class="modal fade" id="position-ad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="access_permission">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Make Position AD</h4>
                </div>

                <div class="modal-body" >
                    <div class="js_update_respond_msg"></div>
                    <div>
                        <input type="hidden" name="id" id="post-id" value="">
                        <input type="hidden" name="brand_id" id="brand_id" value="">
                        <input type="hidden" name="model_id" id="model_id" value="">
                        <div class="form-group">
                            <label>Select Section</label>
                            <select class="form-control" name="featured_section" id="featured_section" required>
                                <option value="General">General</option>
                                <option value="Brand">Brand</option>
                                <option value="Model">Model</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Input Page</label>
                            <input type="number" name="featured_page" class="form-control" id="featured_page" required>
                        </div>

                        <div class="form-group">
                            <label>Input Position</label>
                            <input type="number" name="featured_position" class="form-control" id="featured_position" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button>
                    <button type="button" class="btn btn-primary " onclick="position_ad();"><i class="fa fa-save"></i> Submit</button>
                </div>
            </form>


        </div>
    </div>
</div>
<script>
    $(window).on('load',function (){
        date_range($('select[name="range"]').val())
    })
    function date_range(range){
        var range = range;
        if( range == 'Custom'){
            $('#custom').css('display','block');
        } else {
            $('#custom').css('display','none');
        }
    }
</script>
