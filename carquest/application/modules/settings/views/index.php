<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker-standalone.min.css" />
<section class="content-header">
    <h1> Site Setting  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Settings</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-body">
            <div id="ajaxRespond"></div>

            <form method="post" id="settings" action="<?php echo Backend_URL; ?>settings/update" name="settings">
                <input type="hidden" name="local_time_zone_offset" id="localTimeZoneOffset">
                <table class="table table-hover table-striped" style="margin-bottom: 10px">
                    <?php
                    foreach ($settings_data as $setting){
                    if (!in_array($setting->label, ['AndroidVersion', 'IosVersion', 'AndroidForceUpdate', 'IosForceUpdate', 'AndroidAppStoreLink', 'IosAppLink'])){
                        if($setting->label == 'Maintenance') {
                            $maintenance_value = maintenanceValue($setting->value);
                        }
                        ?>
                        <tr>
                            <td width="220"><?php echo Setting_helper::splitSettings($setting->label); ?></td>
                            <td><?php Setting_helper::switchFormFiled($setting->label, $setting->value); ?></td>
                        </tr>
                    <?php }} ?>
                </table>
                <div class="text-right">

                    <button class="btn btn-primary" id="submit" type="button" name="save"><i class="fa fa-save"></i> Update Setting </button>
                </div>
            </form>
            <script type="text/javascript">
                $('#submit').on('click', function(e){
                    e.preventDefault();
                    for ( instance in CKEDITOR.instances )
                    {
                        CKEDITOR.instances[instance].updateElement();
                    }
                    var data = CKEDITOR.instances.RequirementService.getData();
                    var settings = $('#settings').serializeArray();
                    settings.push({
                        name: "RequirementService",
                        value: data
                    });

                    $.ajax({
                        url: 'admin/settings/update',
                        type: 'POST',
                        dataType: "json",
                        data: settings,
                        beforeSend: function(){
                            $('#ajaxRespond')
                                    .html('<p class="ajax_processing">Loading...</p>')
                                    .css('display','block');
                        },
                        success: function ( jsonRespond ) {
                            $('#ajaxRespond').html(jsonRespond.Msg);
                            if( jsonRespond.Status === 'OK'){
                                setTimeout(function() { $('#ajaxRespond').slideUp(); }, 2000);
                            }
                        }
                    });


                });
            </script>
        </div>
    </div>
</section>


<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script>
    $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD hh:mm A',
        minDate: new Date()
    });
    $("#localTimeZoneOffset").val(Intl.DateTimeFormat().resolvedOptions().timeZone);

    $(document.body).on('click','#maintance_check',function() {
        $('#maintance_data').val(0);
        $('#maintance_input').prop('disabled',true).val('');
        if($(this).is(':checked')) {
            $('#maintance_input').prop('disabled',false);
            $('#maintance_data').val(1);
        }
    });

    <?php if(!empty($maintenance_value[2])) { ?>
    function getLocalDatetime(){
        var date = new Date('<?php echo date('D, d M Y H:i:s',strtotime($maintenance_value[2])).' GMT'; ?>');
        var hours = date.getHours();
        var ampm = (hours >= 12) ? "PM" : "AM";
        hours = hours % 12;
        hours = hours ? hours : 12;
        hours = ("0" + hours).slice(-2);
        minutes = ("0" + date.getMinutes()).slice(-2);
        dates = ("0" + date.getDate()).slice(-2);
        var months = date.getMonth()+1;
        months = ("0" + months).slice(-2);

        var datetime = date.getFullYear()+'-'+months+'-'+dates+' '+hours+':'+minutes+' '+ampm;

        $('.datetime').val(datetime);
    }
    getLocalDatetime();
    <?php } ?>

    CKEDITOR.replace('RequirementService', {
        height: ['120px'],
    });
</script>
