<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/fileinput.js" type="text/javascript"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>

<style>
    .box-body { margin-bottom: 20px; }
</style>



<section class="content-header">
    <h1> Cms_options  <small><?php echo $button ?></small> <a href="<?php echo site_url('admin/cms/category') ?>" class="btn btn-default">Back</a> </h1>
    <ol class="breadcrumb">
        <li><a href="admin/"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="admin/cms/category">Add New Category</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Add New Record</h3>
        </div>
        
        <div class="box-body">
        <form class="form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
             <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />
                        <?php echo form_error('name') ?>
                    </div>
                </div>
	    <div class="form-group">
                    <label for="url" class="col-sm-2 control-label">Url :</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" name="url" id="url" placeholder="Url" value="<?php echo $url; ?>" />
                        <?php echo form_error('url') ?>
                    </div>
                </div>

	    
	 <div class="form-group">
                                    <label for="int" class="col-sm-2 control-label">Parent</label>
                                    <div class="col-sm-10">  
                                    <select name="parent" class="form-control">
                                        
                                       <?php echo  getCategoryDropDown($parent); ?>
                                    </select>
                                         <?php echo form_error('parent') ?>
                                    </div>
                                </div>
            <div class="form-group">        
                    <label for="description" class="col-sm-2 control-label">Description :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="description" id="description" placeholder="Description"><?php echo $description; ?></textarea>
                        <?php echo form_error('description') ?>
                    </div>
                </div>

	
                        
                 <div class="form-group">
                    <label for="thumb" class="col-sm-2 control-label">Thumb</label>
                       <div class="col-sm-10">               
                         <input id="file-3" type="file" name="thumb" >                  
          </div>
                   
                </div>
                       
            
            
            
            
                </div>
            
   
            
            
            
            
	<div class="col-md-12 text-right">    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('admin/cms_options') ?>" class="btn btn-default">Cancel</a>
	</div></form>
	</div></div></section>




<?php if(!empty($thumb)){
    $thumb = '<img src="uploads/cms_photos/'.$thumb.'" alt="image" style="width:160px">'; 
} else { 
     $thumb = '<img src="uploads/cms_photos/default.jpg" alt="image" style="width:160px">'; 
    
}
    
?>

<script>
    $("#file-3").fileinput({
        showUpload: false,
        showCaption: false,
        maxFileSize: 5000,
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