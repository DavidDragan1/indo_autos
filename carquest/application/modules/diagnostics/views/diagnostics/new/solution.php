<h2 class="breadcumbTitle">Solution</h2>
<!-- cars-area start -->
<div class="card-wrap-style-two faq-table-wrap">
    <h3 class="card-header-withbtn">Solution List <button data-toggle="modal"
                                                         data-target="#mechanicDiagnosticQuestionsType" class="header-btn">+ Add New</button>
    </h3>
    <div class="row">
        <div class="col-lg-4 offset-lg-8">
            <form class="search-form" action="admin/diagnostics/solution" method="get">
                <input type="text" class="search" placeholder="Search" name="q" value="<?php echo $q; ?>">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th>#</th>
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
                    <td><?php echo $question->solution; ?></td>
                    <td><?php echo getShortContent($question->description,100); ?></td>
                    <td><?php echo $question->status; ?></td>
                    <td><?php echo $question->created_at; ?></td>
                    <td>
                        <ul class="actionsbtn">
                            <li>
                                <button onclick="update_period(this)" data-id="<?php echo $question->id; ?>"
                                        data-problem="<?php echo $question->solution; ?>"
                                        data-description="<?php echo $question->description; ?>"
                                        data-question="<?php echo $question->inspection_id; ?>"
                                        data-status="<?php echo $question->status; ?>"
                                ><i class="fa fa-pencil-square-o"></i></button>
                            </li>
                            <li><a href="admin/diagnostics/delete-solution/<?php echo $question->id; ?>"
                                   onclick="javasciprt: return confirm('Do you really want to delete this item?')"><i
                                        class="fa fa-trash"></i></a>
                            </li>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        if (count($questions) == 0) {
            echo '<p class="alert alert-warning">Sorry! You do not have any listing.</p>';
        }
        ?>
    </div>
</div>
<?php
if (count($questions) > 0) {
    echo $pagination;
}
?>

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
                    <label class="input-label">Select Inspection</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="inspection" id="inspection">
                            <?php echo makeInspection(getLoginUserData('user_id')); ?>
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
                <div class="col-12 text-center">
                    <button class="btn-wrap btn-big float-none" type="submit">Update</button>
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

