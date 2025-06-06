<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h2 class="breadcumbTitle">Video Gallary</h2>
<!-- advert-area start  -->
<div class="datatable-responsive">
    <div class="datatable-header">
        <a class="btn-wrap" href="<?php echo Backend_URL; ?>gallery/create_video"><i class="fa fa-plus"></i> Add New</a>
<!--        <input type="text" class="search" placeholder="Search">-->
    </div>
    <?php if ($gallery_photo_data): ?>
    <table id="advert" class="datatable-wrap" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Video</th>
            <th>Title/Caption</th>
            <th>Upload By</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($gallery_photo_data as $gallery): ?>
            <tr id="row_<?php echo $gallery->id; ?>">
                <td><?php echo $gallery->id; ?></td>
                <td>
                    <div class="video-gallary-img">
                        <a class="video-gallary" href="https://www.youtube.com/watch?v=<?php echo $gallery->photo ?>">
                            <img class="tableImg" src="https://img.youtube.com/vi/<?php echo $gallery->photo ?>/1.jpg">
                        </a>
                    </div>
                </td>
                <td><?php echo ($gallery->title);?></td>
                <td><?php echo getUserNameByUserId($gallery->user_id); ?></td>
                <td><?php echo globalDateFormat($gallery->created) ?></td>
                <td>
                    <ul class="actions-btns">
                        <li><a href="<?php echo site_url(Backend_URL . 'gallery/update_video/' . $gallery->id);?>">Update</a></li>
                        <li><button data-id="<?php echo $gallery->id ?>" data-name="<?php echo $gallery->photo ?>" data-album_id="<?php echo $gallery->album_id ?>" class="js_photo_delete">Delete</button></li>
                    </ul>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>
    <?php
    else:
        echo "<div class='ajax_notice'>No result found</div>";
    endif;
    ?>
    <div class="row">
        <div class="col-lg-2 col-sm-4 col-7">
            <p class="btn-wrap total-record">Total Record <?php echo $total_rows; ?></p>
        </div>
        <div class="col-lg-10 col-sm-8 col-12">
            <?php echo $pagination; ?>
        </div>
    </div>
</div>
<!-- advert-area start  -->

<script>
    $('.js_photo_delete').on('click', function () {
        var id = $(this).data('id');
        var photo = $(this).data('name');
        var album_id = $(this).data('album_id');
        var yes = confirm('Are you sure?');
        if (yes) {
            $.ajax({
                url: "admin/gallery/delete",
                type: "POST",
                dataType: "json",
                data: {id: id, photo: photo, album_id: album_id},
                beforeSend: function () {
                    $('#row_' + id).css('background-color', '#FF0000');
                },
                success: function (jsonData) {
                    if (jsonData.Status === 'OK') {
                        $('#row_' + id).fadeOut(500);
                    } else {
                        alert(jsonData.Msg);
                    }
                }
            });
        }

    });
</script>