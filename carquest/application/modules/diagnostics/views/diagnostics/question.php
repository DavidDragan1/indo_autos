<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Diagnostics Questions  <small>Control panel</small>
        <button data-toggle="modal"
                data-target="#mechanicDiagnosticQuestionsType" class="btn btn-success">+ Add New</button>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL); ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Question</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-body no-padding">
            <div class="">
                <table class="table table-hover table-condensed">
                    <thead>
                    <tr>
                        <th width="40">ID</th>
                        <th>Question</th>
                        <th>Vehicle</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Status</th>
                        <th width="115">Action</th>
                    </tr>
                    </thead>

                    <tbody>


                    <?php
                    $count = $this->input->get('start');
                    $count = $count + 1;

//                    var_dump($questions);
//                    die();

                    foreach ($questions as $question) { ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $question->question; ?></td>
                            <td><?php echo getVehcileNameById($question->vehicle_type_id); ?></td>
                            <td><?php echo get_brand_by_id($question->brand_id); ?></td>
                            <td><?php echo getModelNameById($question->model_id, $question->brand_id); ?></td>
                            <td><?php echo $question->status; ?></td>
                            <td>

                                        <button onclick="update_period(this)" data-id="<?php echo $question->id; ?>"
                                                data-vehicle="<?php echo $question->vehicle_type_id; ?>"
                                                data-brand="<?php echo $question->brand_id; ?>"
                                                data-model="<?php echo $question->model_id; ?>"
                                                data-type="<?php echo $question->question_type_id; ?>"
                                                data-issue_type="<?php echo $question->issue_type??''; ?>"
                                                data-question="<?php echo $question->question; ?>"
                                                data-status="<?php echo $question->status; ?>"
                                                data-meta_title="<?php echo $question->meta_title??''; ?>"
                                                data-meta_description="<?php echo $question->meta_description??''; ?>"
                                                data-meta_keyword="<?php echo $question->meta_keyword??''; ?>"
                                        ><i class="fa fa-pencil-square-o"></i></button>
                                    <a href="admin/diagnostics/delete-question/<?php echo $question->id; ?>"
                                           onclick="javasciprt: return confirm('Do you really want to delete this item?')"><i
                                                class="fa fa-trash"></i></a>

                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>





            </div>


            <div class="row">
                <div class="col-md-12" style="padding-bottom:10px">
                    <div class="col-md-6">
<!--                        <span class="btn btn-primary">Total Page: --><?php //echo $total_rows ?><!--</span>-->
                    </div>
                    <div class="col-md-6 text-right">
                        <?php echo $pagination ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade modalWrapper" id="mechanicDiagnosticQuestionsType" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <form class="row" method="post" action="admin/diagnostics/question-update">
                <div class="col-xs-12 text-center">
                    <h3 class="title-add-car">Update Question</h3>
                </div>
                <div class="col-xs-12">
                    <label class="input-label">Question</label>
                    <input name="question" type="text" class="inputbox-style" placeholder="Type question" id="title">
                </div>
                <div class="col-xs-12">
                    <label class="input-label">Issue Type</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="issue_type" id="issue_type">
                            <?php echo GlobalHelper::diagnostics_issue_type_dropdown(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <label class="input-label">Question Type</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="type" id="type">
                            <?php echo GlobalHelper::diagnostics_question_type_dropdown(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <label class="input-label">Vehicle Type</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="vehicle_type_id" id="vehicle_type_id" onChange="vehicle_change(this.value);">
                            <?php echo GlobalHelper::dropDownVehicleList("General"); ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <label class="input-label">Brand Name</label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="brand_id" onChange="get_model(this.value);" name="brand_id">
                            <?php echo GlobalHelper::get_brands_by_vechile(0, 0); ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <label class="input-label">Model Name</label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="model_id" name="model_id">
                            <option value="" disabled selected>Model</option>
                            <?php  echo GlobalHelper::get_brands_by_vehicle_model(0, 0);   ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <label class="input-label">Status</label>
                    <select class="inputbox-style" name="status" id="status">
                        <option value="">Select type</option>
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
                <div class="col-xs-12">
                    <label class="input-label">Meta Title</label>
                    <input name="meta_title" type="text" class="inputbox-style" placeholder="Meta Title" id="meta_title">
                </div>
                <div class="col-xs-12">
                    <label class="input-label">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="inputbox-style"  cols="30" rows="10"></textarea>
                </div>
                <div class="col-xs-12">
                    <label class="input-label">Meta Keyword</label>
                    <textarea name="meta_keyword" id="meta_keyword" class="inputbox-style"  cols="30" rows="10"></textarea>
                </div>
                <input type="hidden" name="id" value="0" id="id">
                <div class="col-xs-12 text-center mt-4">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function vehicle_change(vehicle_type_id) {
        var vehicle_type_id = vehicle_type_id;

        jQuery.ajax({
            url: 'brands/brands_frontview/get_brands_by_vechile?type_id='+vehicle_type_id,
            type: "GET",
            dataType: "text",
            beforeSend: function () {
                jQuery('#brand_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#brand_id').html(response);
            }
        });
    }

    function get_model(id) {
        var vehicle_type_id = $('#vehicle_type_id').val();

        jQuery.ajax({
            url: 'brands/brands_frontview/brands_by_vehicle_model?type_id='+vehicle_type_id+'&brand_id='+id,
            type: "GET",
            dataType: "text",
            data: {id: id, vehicle_type_id: vehicle_type_id},
            beforeSend: function () {
                jQuery('#model_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#model_id').html(response);
            }
        });
    }

    function update_period(element) {
        $('#id').val($(element).data('id'));
        $("#vehicle_type_id").val($(element).data("vehicle")).change();
        setTimeout(function () {
            $("#brand_id").val($(element).data("brand")).change();
        }, 1000);
        setTimeout(function () {
            $("#model_id").val($(element).data("model")).change();
        }, 3000);
        $("#type").val($(element).data("type")).change();
        $("#issue_type").val($(element).data("issue_type")).change();
        $("#title").val($(element).data("question"));
        $("#meta_title").val($(element).data("meta_title"));
        $("#meta_description").val($(element).data("meta_description"));
        $("#meta_keyword").val($(element).data("meta_keyword"));
        $("#status").val($(element).data("status")).change();
        $('#mechanicDiagnosticQuestionsType').modal('show');
    }

    $('#mechanicDiagnosticQuestionsType').on('hidden.bs.modal', function (e) {
        $('#period_form').trigger("reset");
    })

</script>
