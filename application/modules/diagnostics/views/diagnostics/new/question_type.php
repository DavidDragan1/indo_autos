<h2 class="breadcumbTitle">Question Type</h2>
<!-- cars-area start -->
<div class="card-wrap-style-two faq-table-wrap">
    <h3 class="card-header-withbtn">Question Type List <button data-toggle="modal"
                                                               data-target="#mechanicDiagnosticQuestionsType" class="header-btn">+ Add New</button>
    </h3>
    <div class="row">
        <div class="col-lg-4 offset-lg-8">
            <form class="search-form" action="admin/diagnostics" method="get">
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
                <th>Title</th>
                <th>Created at</th>
                <th>Type</th>
                <th>Status</th>
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
                <td><?php echo $question->title; ?></td>
                <td><?php echo $question->created_at; ?></td>
                <td><?php echo $question->type; ?></td>
                <td><?php echo $question->status; ?></td>
                <td>
                    <ul class="actionsbtn">
                        <li>
                            <button onclick="update_period(this)" data-id="<?php echo $question->id; ?>"
                                    data-type="<?php echo $question->type; ?>"
                                    data-title="<?php echo $question->title; ?>"
                                    data-status="<?php echo $question->status; ?>"
                            ><i class="fa fa-pencil-square-o"></i></button>
                        </li>
                        <li><a href="admin/diagnostics/deleteQuestionType/<?php echo $question->id; ?>"
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
            <form class="row" method="post" action="admin/diagnostics/question-type">
                <div class="col-12 text-center">
                    <h3 class="title-add-car">Update Question Type</h3>
                </div>
                <div class="col-12">
                    <label class="input-label">Title</label>
                    <input name="title" type="text" class="inputbox-style" placeholder="Type title" id="title">
                </div>
                <div class="col-12">
                    <label class="input-label">Type</label>
                    <select class="inputbox-style" name="type" id="type">
                        <option value="">Select type</option>
                        <option value="Known">Known</option>
                        <option value="Unknown">Feel/Unknown</option>
                    </select>
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

<script>
    function update_period(element) {
        $('#id').val($(element).data('id'));
        $("#type").val($(element).data("type")).change();
        $("#title").val($(element).data("title"));
        $("#status").val($(element).data("status")).change();
        $('#mechanicDiagnosticQuestionsType').modal('show');
    }

    $('#mechanicDiagnosticQuestionsType').on('hidden.bs.modal', function (e) {
        $('#period_form').trigger("reset");
    })

</script>