<div class="box">
    <div class="box-header">
        <h3 class="box-title">DB Export/Import Record</h3>

        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">«</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">»</a></li>
            </ul>
        </div>
    </div>

    <div class="box-body no-padding">   
        <table class="table" id="history">
            <thead>
                <tr>
                    <th width="40">#</th>                                
                    <th width="130">Timestamp</th>
                    <th>DB</th>
					<th>Event on Table</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($db_sync_data as $db_sync) { ?>
                    <tr>
                        <td><?php echo $db_sync->id ?></td>
                        <td><?php echo globalDateTimeFormat($db_sync->created); ?></td>
						<td><code><?php echo $db_sync->db ?></code></td>
                        <td><code><?php echo $db_sync->event_fired ?></code></td>
                        <td>
                            <span class="btn btn-xs btn-success"><i class="fa fa-download"></i></span>
                            <span class="btn btn-xs btn-warning"><i class="fa fa-rotate-left"></i></span>
                            <span class="btn btn-xs btn-danger"><i class="fa fa-times"></i></span>
                            
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>  