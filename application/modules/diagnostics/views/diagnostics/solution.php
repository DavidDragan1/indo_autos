<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content-header">
    <h1> Diagnostics Solution  <small>Control panel</small>
        <button data-toggle="modal"
                data-target="#mechanicDiagnosticQuestionsType" class="btn btn-success">+ Add New</button>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL); ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Solution</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-body no-padding">
            <div class="">
                <table class="table table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Solution</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>


                    <?php
                    $count = $this->input->get('start');
                    $count = $count + 1;
                    foreach ($questions as $question) : ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $question->solution; ?></td>
                            <td><?php echo getShortContent($question->description,100); ?></td>
                            <td><?php echo $question->status; ?></td>
                            <td><?php echo $question->created_at; ?></td>
                            <td>

                                        <button onclick="update_period(this)" data-id="<?php echo $question->id; ?>"
                                                data-problem="<?php echo $question->solution; ?>"
                                                data-description="<?php echo $question->description; ?>"
                                                data-question="<?php echo $question->question_id; ?>"
                                                data-status="<?php echo $question->status; ?>"
                                        ><i class="fa fa-pencil-square-o"></i></button>
                                    <a href="admin/diagnostics/delete-solution/<?php echo $question->id; ?>"
                                           onclick="javasciprt: return confirm('Do you really want to delete this item?')"><i
                                                class="fa fa-trash"></i></a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
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
            <form class="row" method="post" action="admin/diagnostics/solution-update">
                <div class="col-12 text-center">
                    <h3 class="title-add-car">Update Solution</h3>
                </div>
                <div class="col-12">
                    <label class="input-label">Select Question</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="question" id="question">
                            <?php echo makeQuestion(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <label class="input-label">Solution Title</label>
                    <input name="solution" id="solution" type="text" class="inputbox-style" placeholder="Type Problem Title">
                </div>

                <div class="col-12 mb-3">
                    <label class="input-label">Description</label>
                    <textarea class="ckeditor-wrap" id="problemDescription" name="description"></textarea>
                </div>
                <div class="col-12">
                    <label class="input-label">Status</label>
                    <select class="inputbox-style" name="status" id="status">
                        <option value="">Select type</option>
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
                <input type="hidden" name="id" value="0" id="id">
                <div class="col-xs-12 mt-4 text-center">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/ckeditor.js"></script>
<script>
    CKEDITOR.replace('problemDescription', {
        height: ['130px'],
    })
</script>
<script>
    function update_period(element) {
        $('#id').val($(element).data('id'));
        $("#solution").val($(element).data("problem"));
        CKEDITOR.instances['problemDescription'].setData($(element).data("description"))
        $("#inspection").val($(element).data("question")).change();
        $("#status").val($(element).data("status")).change();
        $('#mechanicDiagnosticQuestionsType').modal('show');
    }

    $('#mechanicDiagnosticQuestionsType').on('hidden.bs.modal', function (e) {
        $('#period_form').trigger("reset");
    })

</script>