<h2 class="breadcumbTitle"><?php echo $type; ?></h2>
<!-- inbox-mail-area start  -->
<div class="reload-btn-wrap text-right">
    <?php if ($type == 'Sent') : ?>
        <button type="button" onclick="location.href='admin/mails/sent'"><i class="fa fa-refresh"></i> Refresh</button>
    <?php else: ?>
        <button type="button" onclick="location.href='admin/mails'"><i class="fa fa-refresh"></i> Refresh</button>
    <?php endif; ?>
</div>
<div class="datatable-responsive">
    <table id="advert" class="datatable-wrap" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Sender</th>
            <th>Type</th>
            <th>Mail Subject</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $serial = 0;
        foreach ($mails as $mail){ $serial++; ?>
            <tr>
                <td><?php echo $serial; ?></td>
                <td class="open-mail" data-mailid="<?php echo $mail->id; ?>"><a href="javascript:void(0)"><?php echo $mail->mail_from; ?></a></td>
                <td class="open-mail" data-mailid="<?php echo $mail->id; ?>"><a href="javascript:void(0)"><?php echo $mail->mail_type ?></a></td>
                <td class="open-mail" data-mailid="<?php echo $mail->id; ?>">
                    <a href="javascript:void(0)">
                        <strong><?php echo getShortContent($mail->subject,25) ?></strong> <?php echo getShortContent($mail->body,20) ?>
                    </a>
                </td>
                <td><?php echo globalDateFormat($mail->created);?></td>
                <td>
                    <ul class="actionBtn">
                        <li><button type="button" onclick="deleteMail(<?php echo $mail->id; ?>)"><i class="fa fa-trash"></i></button></li>
                        <li><a href="javascript:void(0)" class="open-mail" data-mailid="<?php echo $mail->id; ?>"><i class="fa fa-eye"></i></a></li>
                    </ul>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        var table = $('#advert').DataTable({
            "language": {
                "paginate": {
                    "previous": '<i class="fa fa-angle-left" > </i>',
                    "next": '<i class="fa fa-angle-right" > </i>',
                },
                "searchPlaceholder": "Search"
            },
            "searching": true,
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "bAutoWidth": true,
            "responsive": true,
            'select': {
                'style': 'multi'
            },
            'order': [
                [0, 'asc']
            ]
        });
    });

    jQuery('.open-mail').on('click', function(){
        var mailid = jQuery(this).data('mailid');
        var type = "<?php echo $type; ?>";
        window.location.href = "admin/mails/read-mail/"+mailid+"/"+type;
    });

    function deleteMail(id){
        var yes = confirm('Are you sure?');
        var type = "<?php echo $type; ?>";
        if (yes) {
            jQuery.ajax({
                type: "POST",
                url: "admin/mails/delete",
                dataType: 'json',
                data: {
                    "id" : id,
                },
                success: function(jsonData) {
                    jQuery('#msg').html(jsonData.Msg).slideDown('slow');

                    if(jsonData.Status === 'OK'){
                        jQuery('#msg').delay(1000).slideUp('slow');
                        if (type === "Inbox") {
                            window.location.href = '<?php echo  site_url(Backend_URL.'mails'); ?>'
                        } else {
                            window.location.href = '<?php echo  site_url(Backend_URL.'mails/sent'); ?>'
                        }
                    } else {
                        jQuery('#msg').delay(5000).slideUp('slow');
                    }
                }
            });
        }
    }

</script>

<?php //load_module_asset('mails', 'js');?>