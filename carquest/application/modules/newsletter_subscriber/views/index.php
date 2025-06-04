<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Newsletter Subscriber  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Subscribers</li>
    </ol>
</section>

<section class="content">
    <div class="row">    
        <div class="col-sm-4 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Add New
                    </h3>
                </div>

                <div class="panel-body">                   
                    <form action="admin/newsletter_subscriber/create_action" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" />
                        </div>
                        <div class="form-group">
                            <label for="status">Status: &nbsp;&nbsp;</label>                           
                            <?php echo htmlRadio('status', 'Subscribe', ['Subscribe' => 'Subscribe', 'Unsubscribe' => 'Unsubscribe'])?>
                        </div>
                        
                        <input type="hidden" name="id" value="0" /> 
                        <button type="submit" class="btn btn-primary">Save New</button> 
                        <button type="reset" class="btn btn-default">Reset</button>                         
                    </form>
                </div>		
            </div>
        </div>


        <div class="col-sm-8 col-xs-12">
            <div class="panel panel-default">            
                <div class="panel-heading">					 
                    <h3 class="panel-title">
                        <i class="fa fa-users" aria-hidden="true"></i> 
                        Subscriber List                    
                    </h3>                                                        
                </div>
                <div class="panel-body">

                    <table class="table table-hover table-condensed" style="margin-bottom: 10px">
                        <thead>
                            <tr>
                                <th  width="50">No</th>
                                
                                <th>Email</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Modified</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead><?php foreach ($subscribers as $subscriber) { ?>
                            <tr>
                                <td><?php echo ++$start ?></td>
                                <td><?php echo $subscriber->email ?></td>
                                <td><?php echo $subscriber->name ?></td>                                
                                <td><?php echo $subscriber->status ?></td>
                                <td><?php echo globalDateFormat($subscriber->created) ?></td>
                                <td><?php echo globalDateFormat($subscriber->modified); ?></td>
                                <td>
                                    <?php
                                            echo anchor(site_url(Backend_URL . 'newsletter_subscriber/update/' . $subscriber->id), '<i class="fa fa-fw fa-edit"></i>', 'class="btn btn-xs btn-default"');
                                            echo anchor(site_url(Backend_URL . 'newsletter_subscriber/delete/' . $subscriber->id), '<i class="fa fa-fw fa-trash"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                            ?>
                                     
                                </td>
                            </tr>
                        <?php } ?>
                    </table>





                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-3">
                            <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>
                        </div>
                        <div class="col-md-9 text-right">
                            <?php echo $pagination ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>