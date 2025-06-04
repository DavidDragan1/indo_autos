<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/fileinput.js" type="text/javascript"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>
<section class="content-header">
  <h1> Blog Categories <small>Control panel</small></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo site_url( Backend_URL ); ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">All Blog Categories</li>
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
          <form action="admin/blog/category/create_action" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="varchar">Name</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Name" />
            </div>
            <div class="form-group">
              <label for="varchar">Slug</label>
              <input type="text" class="form-control" name="slug" id="slug" placeholder="slug" />

            </div>
              <div class="form-group">
              <label for="menu_order">Menu Order</label>
              <input type="number" class="form-control" name="menu_order" id="menu_order" placeholder="menu_order" />
              </div>

              <div class="form-group">
              <label for="seo_title">Meta Title</label>
              <input type="text" class="form-control" name="seo_title" id="seo_title" placeholder="seo_title" />
              </div>

              <div class="form-group">
              <label for="seo_keyword">Meta Keyword</label>
              <input type="text" class="form-control" name="seo_keyword" id="seo_keyword" placeholder="seo_keyword" />
              </div>

              <div class="form-group">
              <label for="seo_description">Meta Description</label>
                  <textarea class="form-control" name="seo_description" id="seo_description"></textarea>
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
                  <th>Slug</th>
                  <th>Menu Order</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
            $start = 0;
            foreach ($blog_categories as $blog_category){ ?>
                <tr>
                  <td><?php echo ++$start ?></td>                  
                  <td><?php echo $blog_category->name ?></td>
                  <td><?php echo $blog_category->slug; ?></td>
                  <td><?php echo $blog_category->menu_order; ?></td>

                  <td style="text-align:center" width="200px"><?php
			echo anchor(site_url( Backend_URL .'blog/category/update/'.$blog_category->id),'<i class="fa fa-fw fa-edit"></i> Edit',  'class="btn btn-xs btn-default"');
			echo anchor(site_url( Backend_URL .'blog/category/delete/'.$blog_category->id),'<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
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

<script type="text/javascript">
    $("#name, #slug").on('keyup keypress blur change', function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp, '-');
        Text=Text.replace(/(^\s+|[^a-zA-Z0-9._-]+|\s+$)/g,"");
        $("#slug").val(Text);
    });
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
        allowedFileExtensions: ["jpg", "png", "gif"],
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
    });

        </script> 
