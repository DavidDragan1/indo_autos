<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> <?=@$cms->post_title?>  <small>Document panel</small> <?php echo anchor(site_url('admin/users/document_create/'.$this->uri->segment('4')), ' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL); ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">User Document</li>
    </ol>
</section>

<section class="content">       
    <div class="box">            
        <div class="box-header with-border"> 
            <div class="col-md-3"><h5><b>List of Pages</b></h5></div>
        </div>

        <div class="box-body no-padding">
            <div class="">
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th width="40">ID</th>
                            <th width="100">Document</th>
                            <th>name</th>
                            <th>Created</th>
                            <th width="115">Action</th>
                        </tr>
                    </thead>

                    <tbody>


                        <?php foreach ($documents as $document) { ?>
                            <tr>
                                <td><?php echo $document->id ?></td>
                                <td><img width="100" src="uploads/user_document/<?=$document->photo?>"></td>
                                <td><?=$document->name?></td>
                                <td><?php echo globalDateFormat( $document->created ) ?></td>
                                <td>
                                <?php
                                    echo anchor(site_url('admin/users/document_edit/' . $document->id), '<i class="fa fa-fw fa-edit"></i>', 'class="btn btn-xs btn-default"  title="Edit"');
                                    echo anchor(site_url('admin/users/document_delete/' . $document->id), '<i class="fa fa-fw fa-trash"></i>', 'class="btn btn-xs btn-danger"  title="Move to Trash" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>





            </div>


            <div class="row">
                <div class="col-md-12" style="padding-bottom:10px">
                    <div class="col-md-6">
                        <span class="btn btn-primary">Total Page: <?php echo $total_rows ?></span>	    
                    </div>
                    <div class="col-md-6 text-right">
                        <?php echo $pagination ?>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</section>