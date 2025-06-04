<?php load_module_asset('mails', 'css' );?>

<section class="content-header">
        <h1>
            Mailbox
            <small><?php echo count($mails);?> new messages</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li class="active">Mailbox</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <?php $this->load->view('mails_sidebar') ?>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo whichFolder(); ?></h3>
                        
                         

                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                               <button type="button" onclick="location.href='admin/mails'" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> Refresh</button>
                            </div>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="mailbox-controls">
                            
                           
                             
                            <!-- /.pull-right -->
                        </div>
                        <div class="mailbox-messages">
                            <table class="table table-hover table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th width="40"></th>
                                    <th>Sender</th>
                                    <th>Type</th>
                                    <th>Mail Subject</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $serial = 0;
                                foreach ($mails as $mail){ $serial++; ?>
                                <tr class="mail-row">                                    
                                    <td class="mailbox-star"><?php echo $serial; ?></td>
                                    <td class="open-mail" data-mailid="<?php echo $mail->id; ?>"><?php echo $mail->mail_from; ?></td>
                                    <td class="open-mail" data-mailid="<?php echo $mail->id; ?>"><?php echo $mail->mail_type ?></td>
                                    <td class="open-mail" data-mailid="<?php echo $mail->id; ?>">
                                        <b><?php echo getShortContent($mail->subject,25) ?></b> - <?php echo getShortContent($mail->body,40) ?>
                                    </td>                                   
                                    <td><?php echo globalDateFormat($mail->created);?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            </table>
                            


                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                     
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
</section>
    <script type="text/javascript">
        
            $(document).ready(function () {
                $("#mytable").dataTable();
            });
        
    </script>

<?php load_module_asset('mails', 'js');?>