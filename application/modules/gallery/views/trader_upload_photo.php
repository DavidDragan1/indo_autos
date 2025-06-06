<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$role_id = getLoginUserData('role_id');
?>
<h2 class="breadcumbTitle"><?php echo $page_title; ?></h2>
<!-- update-photo-area start  -->
<div class="update-photo-area">
    <form action="<?php echo $action; ?>"   onsubmit="return upload_photo();" method="post" enctype="multipart/form-data"  id="photo-upload" novalidate>
        <div class="row">
            <input type="hidden" name="id" value="<?php echo $id; ?>" />
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Select Album</label>
                <div class="select2-wrapper">
                    <select name="album_id" class="input-style"  id="powerRanger" data-error-msg="Plz Select a Album" required>
                        <?php echo getDropDownAlbums($album_id, 'Photo') ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">User Name </label>
                <?php if( $role_id != 1 || $role_id != 2 ): ?>
                    <input type="hidden" name="user_id" hidden="" value="<?php echo getLoginUserData('user_id'); ?>" readonly="">
                    <input  value="<?php echo getUserNameById( getLoginUserData('user_id')); ?>" readonly="" type="text" class="inputbox-style">
                <?php endif; ?>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Title <?php echo form_error('title') ?></label>
                <input type="text" class="inputbox-style" name="title" id="title" placeholder="Title" value="<?php echo $title; ?>" data-do-validate="true" data-error-msg="Plz Enter Photo Title" />
            </div>
            <div class="col-lg-8 col-12">
                <label class="input-label">Description <?php echo form_error('photo_description') ?></label>
                <textarea name="photo_description" id="editor"><?php echo $photo_description ?></textarea>
            </div>
            <div class="col-lg-4 col-12">
                <label class="input-label">Photo </label>
                <div class="file-upload-wrap">
                    <div class="upload-img">
                        <img id="previewing1" src="<?php if (!empty($photo)) { echo GalleryFolder.$photo; } else { echo 'assets/theme/new/images/backend/img.svg';} ?>" alt="your image" />
                    </div>
                    <div class="upload-btn-wrapper">
                        <input type="hidden" name="old_img" value="<?php echo $photo; ?>" />
                        <button><i class="fa fa-link"></i> Select Photo</button>
                        <input type="file" name="photo"  id="profilePic" value="<?php echo $photo; ?>">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div id="ajax_respon" class="text-success"></div>
            </div>
            <div class="col-12">
                <ul class="backto-home-btn">
                    <li>
                        <a href="<?php echo Backend_URL . 'gallery'; ?>" class="btn-wrap btn-big">
                            <i class="fa fa-long-arrow-left"></i>
                            Back to List
                        </a>
                    </li>
                    <li><button type="submit" class="btn-wrap btn-big">Update Photo</button></li>
                </ul>
            </div>
        </div>
    </form>

</div>
<!-- update-photo-area end  -->

<?php load_module_asset('gallery', 'js'); ?>
<script type="text/javascript" src="assets/theme/new/js/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {})
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });
</script>
