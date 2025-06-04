<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h2 class="breadcumbTitle">Photo Gallary</h2>
<!-- advert-area start  -->
<div class="datatable-responsive">
    <div class="datatable-header">
        <a class="btn-wrap" href="<?php echo Backend_URL; ?>gallery/create"><i class="fa fa-plus"></i> Add New</a>
<!--        <form action="--><?php // echo site_url(Backend_URL . 'gallery/' ); ?><!--" method="get">-->
<!--            --><?php //$q = $this->input->get('q'); ?>
<!--            <input type="hidden" name="user_id" value="--><?php //echo $user_id ;?><!--">-->
<!--            <input type="text" class="search" name="q" value="--><?php //echo $q; ?><!--" placeholder="Search">-->
<!--        </form>-->
    </div>
    <?php if ($gallery_photo_data): ?>
        <table id="advert" class="datatable-wrap" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Photo</th>
            <th>Title/Caption</th>
            <th>Album</th>
            <th>Upload By</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($gallery_photo_data as $gallery): ?>
                <tr id="row_<?php echo $gallery->id; ?>">
                    <td><?php echo $gallery->id; ?></td>
                    <td><img class="tableImg" src="<?php echo GalleryFolder.$gallery->photo; ?>" alt="image"></td>
                    <td><?php echo $gallery->title ?></td>
                    <td><?php echo getAlbum($gallery->album_id); ?></td>
                    <td><?php echo getUserNameByUserId($gallery->user_id); ?></td>
                    <td><?php echo globalDateFormat($gallery->created) ?></td>
                    <td>
                        <ul class="actions-btns">
                            <li><a href="<?php echo site_url(Backend_URL . 'gallery/update/' . $gallery->id);?>">Update</a></li>
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
            <p class="btn-wrap total-record">Total Record  <?php echo $total_rows ?></p>
        </div>
        <div class="col-lg-10 col-sm-8 col-12">
            <?php echo $pagination ?>
        </div>
    </div>

</div>

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
