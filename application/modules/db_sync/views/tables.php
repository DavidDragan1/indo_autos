<div class="box">
    <div class="box-header with-border">
        <h3 class="panel-title"><i class="fa fa-list"></i> All Tables </h3>
    </div>

    <div class="box-body"> 
        <div id="ajax_respond"></div>
        
        <div id="jquery-dialog"></div>
        
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="40">ID</th>                                
                    <th>Table Name</th>
                    <th>Columns</th>
                    <th>Rows</th>
                    <th width="140">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tables as $sl => $table) { ?>
                    <tr>                    
                        <td><?php echo $sl + 1; ?></td>
                        <td><?php echo $table; ?></td>
                        <td><?php echo( Modules::run('db_sync/countColumns', $table) ); ?></td>
                        <td><?php echo( Modules::run('db_sync/countRows', $table) ); ?></td>
                        <td>
                            <button class="btn btn-xs btn-default" onclick="exportTable('<?php echo $table; ?>');"><i class="fa fa-hdd-o"></i> Backup </button>
                             
                            <?php echo getTableTruncateButton( $table );?>
                            
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div> 


