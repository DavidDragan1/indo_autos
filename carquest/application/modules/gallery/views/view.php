<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h2 style="margin-top:0px">Gallery Read</h2>
        <table class="table">
	    <tr><td>Category Id</td><td><?php echo $category_id; ?></td></tr>
	    <tr><td>Title</td><td><?php echo $title; ?></td></tr>
	    <tr><td>Photo</td><td><?php echo $photo; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('gallery') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>