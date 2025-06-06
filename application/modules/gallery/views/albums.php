<?php load_module_asset('gallery','css'); ?>

<section class="content-header">
    <h1> Manage Album </h1>
    <ol class="breadcrumb">
        <li><a href="<?php Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php Backend_URL . 'gallery/' ?>"> Gallery</a></li>
        <li class="active">Manage Album</li>
    </ol>
</section>



<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-sm-8 col-xs-12">                    
                    <div class="box">  
                        <div class="box-header with-border">
                            <h3 class="panel-title"><i class="fa fa-list"></i> Album List</h3>
                        </div>
                        <div class="box-body" style="margin-top: -15px;"> 
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead>
                                    <tr>
                                        <th width="50">ID</th>
                                        <th width="110">Thumb</th>
                                        <th>Album</th>
                                        <th>Type</th>
                                        <th>Photos</th>
                                        <th width="240">Action</th>
                                    </tr>
                                </thead>
                                    
                                <tbody>
                                    <?php 
                                    //dd($gallery_albums_data);
                                    foreach ($gallery_albums_data as $row) : ?>
                                        <tr class="role_id_<?php echo $row->id; ?>">
                                            <td width="50"><?php echo $row->id; ?></td>
                                            <td><?php echo getAlbumThumb( $row->thumb, 'small', [ 'width' => '100' ] ); ?></td>

                                            <td class="edit_id_<?php echo $row->id; ?>"><?php echo $row->name; ?></td>
                                            <td><?php echo $row->type; ?></td>
                                            <td width="50"><span class="badge"><?php echo $row->qty; ?></span></td>
                                            <td>
                                                <?php echo anchor(site_url( Backend_URL . 'gallery/album_update/' . $row->id), '<i class="fa fa-fw fa-edit"></i> Update',  'class="btn btn-xs btn-default"'); ?>
                                                <a onClick="edit_album(<?php echo $row->id; ?>)" class="btn btn-xs btn-default"> <i class="fa fa-fw fa-external-link"></i> Rename</a>
                                                <a onClick="delete_album(<?php echo $row->id; ?>)" class="btn btn-danger btn-xs"> <i class="fa fa-fw fa-trash"></i> Delete</a>
                                            </td>                                            
                                        </tr>                                        
                                    <?php endforeach; ?>                                     
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
        </div>
        
        <div class="col-sm-4 col-xs-12">
                <div class="body-body">
                    
                    <div class="box">  
                        <div class="box-header with-border">
                            <h3 class="panel-title"><i class="fa fa-plus"></i> Add New Album</h3>
                        </div>
                        <div class="panel-body" >
                            <div id="ajax_respond"></div>
                            <form role="form" method="post" id="album-upload"  onsubmit="return create_album();">
                                <div class="form-group">
                                    <label for="album_name" style="margin-top:0;">Name</label>
                                    <input type="text" class="form-control" id="album_name" name="album_name" />
                                </div> 
                                <div class="form-group">
                                    <label for="album_slug">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug" value="" data-do-validate="true" class="invalid" data-error-msg="" />
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="type" class="form-control" id="type">
                                        <?php echo albumType($type) ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                   <div class="btn btn-default btn-file">
                                        <i class="fa fa-paperclip"></i> Select Album Thumb
                                        <input type="file" name="thumb"  id="profilePic">                                                                                                                                     
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success js_add_album"><i class="fa fa-plus"></i> Create</button>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
        </div>
        
    </div>
</section>
<!-- /.content -->


<?php load_module_asset('gallery','js'); ?>
