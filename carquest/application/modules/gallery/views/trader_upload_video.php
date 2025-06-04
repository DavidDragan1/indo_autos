<?php
defined('BASEPATH') OR exit('No direct script access allowed');

load_module_asset('gallery', 'css');
$role_id = getLoginUserData('role_id');
?>

<h2 class="breadcumbTitle"><?php echo $page_title; ?></h2>
<!-- update-photo-area start  -->
<div class="update-photo-area">
    <form class="form-horizontal" action="<?php echo $action; ?>" onsubmit="return upload_video();" method="post"
          id="video-upload" novalidate>
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <input type="hidden" id="type" value="<?php echo $type; ?>"/>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">User Name </label>
                <input type="hidden" name="user_id" hidden="" value="<?php echo getLoginUserData('user_id'); ?>"
                       readonly="" class="form-control">
                <input value="<?php echo getUserNameById(getLoginUserData('user_id')); ?>" readonly="" type="text"
                       class="inputbox-style">
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">Video Name </label>
                <input name="title" value="<?php echo $title; ?>" type="text" class="inputbox-style"
                       placeholder="type video name">
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <label class="input-label">https://www.youtube.com/watch?v=</label>
                <input name="video_code" id="video_code" placeholder="type 11 Digit Code"
                       value="<?php echo $video_id; ?>" maxlength="12" type="text">
            </div>
            <div class="col-lg-8 col-12">
                <label class="input-label">Video Caption </label>
                <textarea class="form-control custom-control" name="caption" id="caption" rows="5"
                          style="resize:none"><?php echo $caption; ?></textarea>
            </div>
            <div class="col-12">
                <div id="ajax_respon" class="text-success"></div>
            </div>
            <div class="col-12">
                <ul class="backto-home-btn">
                    <li>
                        <a href="<?php echo Backend_URL . 'gallery/video'; ?>" class="btn-wrap btn-big">
                            <i class="fa fa-long-arrow-left"></i>
                            Back to List
                        </a>
                    </li>
                    <li>
                        <button type="submit" class="btn-wrap btn-big">Save Video</button>
                    </li>
                </ul>
            </div>
        </div>
    </form>
</div>
<!-- update-photo-area end  -->
<?php load_module_asset('gallery', 'js'); ?>


