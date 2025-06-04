<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>CMS Category <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url( Backend_URL .'cms/category' )?>">CMS Category</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Single View</h3>
        </div>
        <table class="table table-striped">
            
             
                  
            
	    <tr><td width="150">Parent</td><td width="5">:</td><td><?php echo caretoryParentIdByName($parent); ?></td></tr>
	    <tr><td width="150">Type</td><td width="5">:</td><td><?php echo $type; ?></td></tr>
	    <tr><td width="150">Name</td><td width="5">:</td><td><?php echo $name; ?></td></tr>
	    <tr><td width="150">Url</td><td width="5">:</td><td><?php echo $url; ?></td></tr>
	   
	    <tr><td width="150">Description</td><td width="5">:</td><td><?php echo $description; ?></td></tr>
	    <tr><td width="150">Thumb</td><td width="5">:</td><td><img src="uploads/cms_photos/<?php if(!empty($thumb)) { echo $thumb; } else { echo 'default.jpg';} ?>" width="60" /></td>
                  </tr>
	    <tr><td></td><td></td><td><a href="<?php echo site_url( Backend_URL .'cms/category') ?>" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> Back</a><a href="<?php echo site_url( Backend_URL .'cms/category/update/'.$id ) ?>" class="btn btn-primary"> <i class="fa fa-edit"></i> Edit</a></td></tr>
	</table>
	</div></section>

