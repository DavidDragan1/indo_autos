<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Parts categories  <small>Control panel</small> <?php echo anchor(site_url(Backend_URL.'parts/category/create'),' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Parts category List</li>
    </ol>
</section>

<section class="content">
<div class="box" style="margin-bottom: 10px">
             
        <div class="box-header">          
            <div class="col-md-4 text-right">
	    
            </div>    
        </div>
    
    <div class="box-body">
    <div class=""> <!-- table-responsive -->
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="20px">No</th>
		    <th>Category</th>
		    <th width="150">Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($category_data as $category)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <td><?php echo $category->category ?></td>
		    <td>
			<?php 			
			echo anchor(site_url( Backend_URL .'parts/category/update/'.$category->id),'<i class="fa fa-fw fa-edit"></i> Edit',  'class="btn btn-xs btn-default"'); 
			echo anchor(site_url( Backend_URL .'parts/category/delete/'.$category->id),'<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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