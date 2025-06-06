<?php

?>
<!-- All Adverts  -->
<div class="bg-white br-5 p-30 mb-50 products-statistics-wrap">
    <form method="POST" id="all_posts_select" action="admin/mails/change_status">
        <input type="hidden" value="Sent" name="type">
        <div class="card-top d-flex flex-wrap align-items-center justify-content-between mb-20">
            <h2 class="fs-18 fw-500 color-seconday mb-0">Inbox</h2>
            <ul class="table-header flex-wrap d-flex align-items-center justify-content-end ">
                <li class="short-search flex-wrap d-flex align-items-center">
                    <span>Mark Selected as:</span>
                    <select name="mark_as" class="browser-default">
                        <option value="Read">Read</option>
                        <option value="Unread">Unread</option>
                    </select>
                    <button disabled id="btn_done"  type="submit">Done</button>
                </li>
                <!-- <li class="search-toggle"><span class="material-icons">search</span></li> -->
            </ul>
        </div>

        <table id="all_adverts" class="table-wrapper ">
            <thead>
            <tr>
                <th>#</th>
                <th class="all">
                    <label class="checkbox-style checkbox-style-small d-inline-flex">
                        <input type="checkbox" class="filled-in checkedAll" />
                        <span class="h-20"></span>
                    </label>
                    Sender
                </th>
                <th >Type</th>
                <th class="desktop desktop-1">Mail Subject</th>
                <th>Created</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($mails as $key=>$mail) :?>
                <tr>
                    <td><?php echo $key+1 ;?></td>
                    <td>
                        <label class="checkbox-style checkbox-style-small d-inline-flex">
                            <input type="checkbox" name="mail_id[]" id="<?php echo $mail->id; ?>" value="<?php echo $mail->id; ?>"  class="filled-in checkSingle" />
                            <span class="h-20"></span>
                        </label>
                        <a  class=" fw-500 open-mail" href="javascript:void(0)" data-mailid="<?php echo $mail->id; ?>"><?php echo getShortContent($mail->mail_from,15);?></a>
                    </td>
                    <td ><?php echo $mail->mail_type ?></td>
                    <td><strong style="font-weight:bold; "><?php echo getShortContent($mail->subject,15) ?></strong><?php echo getShortContent($mail->body,15) ?></td>
                    <td><?php echo globalDateFormat($mail->created);?></td>
                    <td>
                        <ul class="inbox-action d-flex justify-content-end">
                            <li>
                                <a href="admin/mails/delete/<?php echo $mail->id; ?>" onclick="return confirm('Are you sure?');">
                                    <span class="material-icons">delete </span>
                                </a>
                            </li>
                            <li>
                                <a   href="javascript:void(0)" class="open-mail" data-mailid="<?php echo $mail->id; ?>">
                                    <span class="material-icons">email</span>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
        <?php
        if (count($mails) == 0) {
            echo '<p class="alert alert-warning">Sorry! You do not have any listing.</p>';
        }
        ?>
        <?php echo $pagination; ?>
    </form>
</div>
<style>
    table tr td button{
        border: 0;
        background: transparent;
        cursor: pointer
    }
    table tr td button:hover{
        color: #F05C26;
    }
</style>
<!-- All Adverts  -->
<script type="text/javascript" src="assets/new-theme/js/dataTables.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/datatable.responsive.min.js?t=<?php echo time(); ?>"></script>
<script>

    $(".checkedAll").change(function () {
        if (this.checked) {
            $('#btn_done').prop('disabled',false);
            $(".checkSingle").each(function () {
                this.checked = true;
            })
        } else {
            $('#btn_done').prop('disabled',true);
            $(".checkSingle").each(function () {
                this.checked = false;
            })
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;
            $(".checkSingle").each(function () {
                if (!this.checked)
                    isAllChecked = 1;
            })
            if (isAllChecked == 0) { $(".checkedAll").prop("checked", true); }
            $('#btn_done').prop('disabled',false);
        } else {
            $(".checkedAll").prop("checked", false);
            $('#btn_done').prop('disabled',true);
        }
    });

    $(document).ready(function () {
        $('#all_adverts').dataTable({
            bPaginate: false,
            bInfo : false,
            processing: false,
            searching: false,
            ordering: false,
            responsive: true,
            bSort: false,
            order: [0, 'asc'],
        });
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
                success: function(jsonData) {+
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
    jQuery('.open-mail').on('click', function(){
        var mailid = jQuery(this).data('mailid');
        var type = "<?php echo $type; ?>";
        window.location.href = "admin/mails/read-mail/"+mailid+"/"+type;
    });
</script>