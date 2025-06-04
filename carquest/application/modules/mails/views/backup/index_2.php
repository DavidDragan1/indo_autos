<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Mails  <small>Control panel</small> <?php echo anchor(site_url(Backend_URL.'mails/create'),' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Mails</li>
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
                    <th width="20px">No</th>
		    <th>Parent Id</th>
		    <th>Sender Id</th>
		    <th>Reciever Id</th>
		    <th>Subject</th>
		    <th>Body</th>
		    <th>Status</th>
		    <th>Important</th>
		    <th>Log</th>
		    <th>Created</th>
		    <th>Folder Id</th>
		    <th width="150">Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($mails_data as $mails)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
		    <td><?php echo $mails->parent_id ?></td>
		    <td><?php echo $mails->sender_id ?></td>
		    <td><?php echo $mails->reciever_id ?></td>
		    <td><?php echo $mails->subject ?></td>
		    <td><?php echo $mails->body ?></td>
		    <td><?php echo $mails->status ?></td>
		    <td><?php echo $mails->important ?></td>
		    <td><?php echo $mails->log ?></td>
		    <td><?php echo $mails->created ?></td>
		    <td><?php echo $mails->folder_id ?></td>
		    <td>
			<?php 
			echo anchor(site_url( Backend_URL .'mails/read/'.$mails->id),'<i class="fa fa-fw fa-external-link"></i> View', 'class="btn btn-xs btn-default"'); 
			echo anchor(site_url( Backend_URL .'mails/update/'.$mails->id),'<i class="fa fa-fw fa-edit"></i> Edit',  'class="btn btn-xs btn-default"'); 
			echo anchor(site_url( Backend_URL .'mails/delete/'.$mails->id),'<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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