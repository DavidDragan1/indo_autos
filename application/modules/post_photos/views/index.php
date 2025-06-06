<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Post_photos  <small>Control panel</small> <?php echo anchor(site_url('post_photos/create'),' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Post_photos</li>
    </ol>
</section>

<section class="content">
<div class="box" style="margin-bottom: 10px">
             
        <div class="box-header">          
            <div class="col-md-4 text-right">
	    
            </div>    
        </div>
    
    <div class="box-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="80px">No</th>
		    <th>Post Id</th>
		    <th>Photo</th>
		    <th>Featured</th>
		    <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($post_photos_data as $post_photos)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <td><?php echo $post_photos->post_id ?></td>
		    <td><?php echo $post_photos->photo ?></td>
		    <td><?php echo $post_photos->featured ?></td>
		    <td style="text-align:center" width="200px">
			<?php 
			echo anchor(site_url('post_photos/read/'.$post_photos->id),'Read'); 
			echo ' | '; 
			echo anchor(site_url('post_photos/update/'.$post_photos->id),'Update'); 
			echo ' | '; 
			echo anchor(site_url('post_photos/delete/'.$post_photos->id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
			?>
		    </td>
	        </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
</div>
</section>
        
        <script type="text/javascript">
            $(document).ready(function () {
                $("#mytable").dataTable();
            });
        </script>