<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/fileinput.js" type="text/javascript"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>
<section class="content-header">
  <h1> Cms Categories <small>Control panel</small></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo site_url( Backend_URL ); ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">All Categories</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-sm-4 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"> <i class="fa fa-user-plus" aria-hidden="true"></i> Add New </h3>
        </div>
        <div class="panel-body">
          <form action="admin/cms/category/create_action" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="varchar">Name</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Name" />
            </div>
            <div class="form-group">
              <label for="varchar">Url</label>
              <input type="text" class="form-control" name="url" id="url" placeholder="Url" />
            </div>
            <div class="form-group">
              <label for="int">Parent</label>
              <select name="parent" class="form-control">
                <?php echo  getCategoryDropDown(); ?>
              </select>
            </div>
            <div class="form-group">
              <label for="description" class="">Description :</label>
              <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description"></textarea>
              <?php echo form_error('description') ?> </div>
            <div class="form-group">
              <label for="thumb">Thumb</label>
              <input id="file-3" type="file" name="thumb" >
            </div>
            <input type="hidden" name="id" value="0" />
            <button type="submit" class="btn btn-primary">Save New</button>
            <a href="<?php echo site_url('cms_options') ?>" class="btn btn-default">Reset</a>
          </form>
        </div>
      </div>
    </div>
    <div class="col-sm-8 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-4 pull-left">
              <h3 class="panel-title"><i class="fa fa-list"></i> Category List</h3>
            </div>
            <div class="col-md-8 text-right"> </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped" id="mytable">
              <thead>
                <tr>
                  <th width="80px">No</th>                  
                  <th>Name</th>
                  <th>Parent</th>
                  <th>Thumb</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
            $start = 0;
            foreach ($cms_options_data as $cms_options){ ?>
                <tr>
                  <td><?php echo ++$start ?></td>                  
                  <td><?php echo $cms_options->name ?></td>
                  <td><?php echo caretoryParentIdByName($cms_options->parent); ?></td>
                 
                  <td><img src="uploads/cms_photos/<?php if(!empty($cms_options->thumb)) {echo $cms_options->thumb; } else { echo 'default.jpg';} ?>" width="60" /></td>
                  <td style="text-align:center" width="200px"><?php 
			echo anchor(site_url( Backend_URL .'cms/category/read/'.$cms_options->id),'<i class="fa fa-fw fa-external-link"></i> View', 'class="btn btn-xs btn-default"'); 
			echo anchor(site_url( Backend_URL .'cms/category/update/'.$cms_options->id),'<i class="fa fa-fw fa-edit"></i> Edit',  'class="btn btn-xs btn-default"'); 
			echo anchor(site_url( Backend_URL .'cms/category/delete/'.$cms_options->id),'<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
			?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php if(!empty($thumb)){
    $thumb = '<img src="uploads/cms_photos/'.$thumb.'" alt="image" style="width:100px">'; 
} else { 
     $thumb = '<img src="uploads/cms_photos/default.jpg" alt="image" style="width:100px">'; 
    
}
    
?>
<script type="text/javascript">
            $(document).ready(function () {
                $("#mytable").dataTable();
            });

    $("#file-3").fileinput({
        showUpload: false,
        showCaption: false,
        maxFileSize: 2024,
        browseClass: "btn btn-primary btn-sm",
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeLabel: '',
        removeTitle: 'Cancel or reset changes',
        fileType: "file",
        defaultPreviewContent: '<?php echo $thumb; ?>',
        allowedFileExtensions: ["jpg", "png", "gif"],
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
    });

        </script> 
