<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>Body_types  <small>Read</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url( Backend_URL )?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url( Backend_URL .'body_types' )?>">Body_types</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">       
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Single View</h3>
        </div>
        <table class="table table-striped">
	    <tr><td width="150">Type Name</td><td width="5">:</td><td><?php echo $type_name; ?></td></tr>
	    <tr><td></td><td></td><td><a href="<?php echo site_url( Backend_URL .'body_types') ?>" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> Back</a><a href="<?php echo site_url( Backend_URL .'body_types/update/'.$id ) ?>" class="btn btn-primary"> <i class="fa fa-edit"></i> Edit</a></td></tr>
	</table>
	</div></section>