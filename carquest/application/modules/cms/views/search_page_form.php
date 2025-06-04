<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Manage State  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">State</li>
    </ol>
</section>

<section class="content">
    <form action="<?=Backend_URL?>cms/search-page/add_action" method="POST">
        <input type="hidden" name="id" value="<?=$id?>">
    <div class="row">


        <div class="col-sm-4 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Select Search Item
                    </h3>
                </div>

                <div class="panel-body">
                    <?php foreach (search_array() as $k => $d) {?>
                        <div class="form-group">
                            <label><?=$d['show_name']?></label>
                            <?php $vv = in_array($d['var'], $var) ? $d['var'] : 'no' ?>
                            <?php echo htmlRadio($d['field_name'], $vv, [$d['var'] => 'Yes', 'no' => 'No'], 'change-input'); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>



        <div class="col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-user-plus" aria-hidden="true"></i> Available %value%
                    </h3>
                </div>

                <div class="panel-body" >
                    <div class="row" id="available-value">
                        <?php
                        foreach ($var as $d=>$k){
                            echo "<div class='col-md-3 var-list'>%".$k."%</div>";
                        }
                        ?>
                    </div>
                </div>


            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4 pull-left">
                            <h3 class="panel-title"><i class="fa fa-list"></i> Meta Title Builder</h3>
                        </div>


                        <div class="col-md-8 text-right">

                        </div>
                    </div>
                </div>


                <div class="panel-body">
                    <div class="form-group">
                        <label><b>Example</b> %condition% %type% sale</label>
                        <textarea name="meta_title" id="meta_title" class="form-control"><?=$title?></textarea>
                    </div>

                    <button class="btn btn-block"><?=$button?></button>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $('.change-input').on('change', function (){

        $('#available-value').empty();

        var html = "<div class='col-md-3 var-list'>%type%</div>";
        $('input:checked').each(function (i, e) {
            var value = $(e).val();
             if (value !== 'no'){
                html += "<div class='col-md-3 var-list'>%"+value+"%</div>"
            }
        });

        $('#available-value').html(html);
        $('#meta_title').val().split(' ').forEach(function (e, i) {
            $('.var-list').each(function (i, ee) {
                if ($(ee).text().trim() === e){
                    $(ee).addClass('text-primary')
                }
            })
        })
    })

    $('#meta_title').keyup( function () {
        $('.var-list').removeClass('text-primary')
        $(this).val().split(' ').forEach(function (e, i) {
            $('.var-list').each(function (i, ee) {
                if ($(ee).text().trim() === e){
                    $(ee).addClass('text-primary')
                }
            })
        })

    })
    $(document).ready(function () {
        $('#meta_title').val().split(' ').forEach(function (e, i) {
            $('.var-list').each(function (i, ee) {
                if ($(ee).text().trim() === e){
                    $(ee).addClass('text-primary')
                }
            })
        })
    })
</script>
