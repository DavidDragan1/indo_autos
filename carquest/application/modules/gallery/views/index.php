<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<style>
    @media( max-width: 767px ){
        .table-responsive>.table>tbody>tr>td, 
        .table-responsive>.table>tbody>tr>th, 
        .table-responsive>.table>tfoot>tr>td, 
        .table-responsive>.table>tfoot>tr>th, 
        .table-responsive>.table>thead>tr>td, 
        .table-responsive>.table>thead>tr>th {
                                            white-space: normal; }
        .table-responsive tr img {  max-width: 45px;}
    }

</style>


<section class="content-header">
    <h1> Photo Gallery  <?php echo anchor(site_url(Backend_URL . 'gallery/create'), '<i class="fa fa-plus" aria-hidden="true"></i> Upload New Photo', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>                
        <li class="active">Gallery</li>
    </ol>
</section>

<section class="content">
    <div class="panel panel-default">

        <?php 
        $role_id = getLoginUserData('role_id'); 
        if( $role_id == 1 || $role_id == 2 || $role_id == 3 ): ?>
        <div class="panel-heading">    
            <div class="row">        
                <form action="<?php  echo site_url(Backend_URL . 'gallery/' ); ?>" class="form-inline" method="get">

                    <div class="col-md-4">
                        <div class="form-group">                    
                            <select class="form-control" name="user_id">
                                <option value="0">All User</option>
                                <?php echo getDropDownUsers($this->input->get('user_id')); ?>
                            </select>
                        </div>                           
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <select name="album_id" class="form-control input-md">
                                <option value="0">All Albums</option>
                                <?php echo getDropDownAlbums($this->input->get('album_id'), 'Photo'); ?>
                            </select>                    
                        </div>
                    </div>

                    <div class="col-md-4 text-right">
                        <div class="input-group">
                            <?php $q = $this->input->get('q'); ?>
                            <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                            <span class="input-group-btn">
                                <?php if ($q <> '') { ?>
                                    <a href="<?php echo site_url(Backend_URL . 'gallery'); ?>" class="btn btn-default">Reset</a>
                                <?php } ?>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </span>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        
        <?php endif; ?>
        
        <div class="box-body">
            <?php if ($gallery_photo_data): ?>
            <div class="table-responsive">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th width="40">#ID</th>
                                <th width="90">Photo</th>
                                <th>Title/Caption</th>                                        
                                <th>Album</th>
                                <th width="150">Upload By</th>
                                <th width="130">Date</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>
                        <?php foreach ($gallery_photo_data as $gallery): ?>
                            <tr id="row_<?php echo $gallery->id; ?>">
                                <td><?php echo $gallery->id; ?></td>
                                <td><?php echo getGalleryThumb($gallery->photo, 'small', ['width' => '75']); ?></td>
                                <td><?php echo $gallery->title ?></td>                                
                                <td><?php echo getAlbum($gallery->album_id); ?></td>
                                <td><?php echo getUserNameByUserId($gallery->user_id); ?></td>
                                <td><?php echo globalDateFormat($gallery->created) ?></td>
                                <td>
                                    <?php echo anchor(site_url(Backend_URL . 'gallery/update/' . $gallery->id), '<i class="fa fa-fw fa-edit"></i> Update', 'class="btn btn-xs btn-default"'); ?>
                                    <span data-id="<?php echo $gallery->id ?>" data-name="<?php echo $gallery->photo ?>" data-album_id="<?php echo $gallery->album_id ?>" class="btn btn-xs btn-danger js_photo_delete"><i class="fa fa-fw fa-trash"></i> Delete </span>
                                </td>
                            </tr>

                            <?php
                        endforeach;
                        ?>
                    </table>

                </div>
               



                <div class="row" style="padding: 10px 0;">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>
                        </div>
                        <div class="col-md-8 text-right">
                            <?php echo $pagination ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        else:
            echo "<div class='box-body'><div class='ajax_notice'>No result found</div></div>";
        endif;
        ?>

    </div>
</section>

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