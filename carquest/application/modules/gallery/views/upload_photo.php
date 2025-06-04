<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$role_id = getLoginUserData('role_id');
load_module_asset('gallery', 'css');
?>




<section class="content-header">
    <h1>Photo Gallery <small>Upload Photo</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>gallery"><i class="fa fa-dashboard"></i> Gallery</a></li>
        <li class="active">Add Photo</li>
    </ol>
</section>


<section class="content">
    <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">Upload New Photo</h3>
        </div>

        <div class="box-body">
            <div id="ajax_respon"></div>
            <div class="row">
                <div class="col-md-8">
                    <form class="form-horizontal" action="<?php echo $action; ?>"   onsubmit="return upload_photo();" method="post" enctype="multipart/form-data"  id="photo-upload" novalidate>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />


                        <div class="form-group">
                            <div class="col-md-2">
                                <p class="text-right"><b><span>Select Album: </span></b></p>
                            </div>
                            <div class="col-md-5">
                                <select name="album_id" class="col-md-4 form-control"  id="powerRanger" data-error-msg="Plz Select a Album" required>
                                    <option value="0">Select Album</option>
                                    <?php echo getDropDownAlbums($album_id, 'Photo') ?>
                                </select>
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-md-2">
                                <p class="text-right"><b><span>User Name :  </span></b></p>
                            </div>
                            <div class="col-md-5">
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


                        <div class="form-group">
                            <div class="col-md-2">
                                <p class="text-right"><b><span>Title <?php echo form_error('title') ?>:  </span></b></p>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php echo $title; ?>" data-do-validate="true" class="invalid" data-error-msg="Plz Enter Photo Title" />
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-md-2">
                                <p class="text-right"><b>Photo <?php echo form_error('photo') ?>:</b></p>
                            </div>
                            <div class="col-md-5">
                                <input type="hidden" name="old_img" value="<?php echo $photo; ?>" />
                                <div class="btn btn-default btn-file">
                                    <i class="fa fa-paperclip"></i> Select Photo
                                    <input type="file" name="photo"  id="profilePic" value="<?php echo $photo; ?>">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-2">
                                <p class="text-right"><b>Description <?php echo form_error('photo_description') ?>:</b></p>
                            </div>
                            <div class="col-md-5">
                                <textarea class="form-control custom-control"  name="photo_description" rows="3" style="resize:none"><?php echo $photo_description ?></textarea>
                            </div>
                        </div>


                        <div class="col-md-12" style="margin:10px;">
                            <a href="<?php echo Backend_URL . 'gallery'; ?>" class="btn btn-default"> <i class="fa fa-long-arrow-left"></i> Back to List</a>
                            <button type="submit" class="btn btn-primary"> <i class="fa fa-cloud-upload"></i> Upload Photo</button>
                        </div>
                    </form>

                </div>

                <div class="col-md-4">
                    <div id="image_preview1"><?php echo getGalleryThumb($photo, 'small', ['id' => 'previewing1', 'width' => '180']); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php load_module_asset('gallery', 'js'); ?>
