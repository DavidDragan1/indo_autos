<?php
defined('BASEPATH') OR exit('No direct script access allowed');

load_module_asset('gallery', 'css');
$role_id = getLoginUserData('role_id');
?>

<section class="content-header">
    <h1>Video Gallery <small>Upload Video</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>gallery/video"><i class="fa fa-dashboard"></i> Video Gallery</a></li>
        <li class="active">Add Video</li>
    </ol>
</section>


<section class="content">
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">Save Your YouTube Video Link</h3>
        </div>

        <div class="box-body">

            <div class="row">
                <div class="col-md-7 col-md-offset-1">
                    <div id="ajax_respon"></div>
                    <form class="form-horizontal" action="<?php echo $action; ?>" onsubmit="return upload_video();" method="post" id="video-upload" novalidate>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />


                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">User Name</span>
                                    <?php if( $role_id == 1 || $role_id == 2 || $role_id == 3 ): ?>
                                    <select name="user_id" class="form-control">
                                       <?php echo GlobalHelper::getAllUser( $user_id ); ?>
                                    </select>
                                    <?php else : ?>
                                    <input type="hidden" name="user_id" hidden="" value="<?php echo getLoginUserData('user_id'); ?>" readonly="" class="form-control">
                                    <input  value="<?php echo getUserNameById( getLoginUserData('user_id')); ?>" readonly="" class="form-control">
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">Video Name</span>
                                    <input class="form-control"  name="title" value="<?php echo $title; ?>" type="text">
                                </div>
                            </div>
                        </div>

                        <?php if($canManageAlbum){ ?>

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">Select Album</span>
                                    <select name="album_id" class="form-control"  id="album_id">
                                        <?php echo getDropDownAlbums($album_id, 'Video') ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php } ?>



                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">https://www.youtube.com/watch?v=</span>
                                    <input class="form-control"  name="video_code" id="video_code" placeholder="E.g xxyyzz" value="<?php echo $video_id; ?>" maxlength="12" type="text">
                                    <span class="input-group-addon"><sup>*</sup>11 Digit Code</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">Video Caption</span>
                                    <textarea class="form-control"  name="caption" id="caption"><?php echo $caption; ?></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-12">
                                 <a href="<?php echo Backend_URL . 'gallery/video'; ?>" class="btn btn-default"> <i class="fa fa-long-arrow-left"></i> Back to List</a>
                                 <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Save Video Link</button>

                            </div>
                        </div>




                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
<?php load_module_asset('gallery', 'js'); ?>
