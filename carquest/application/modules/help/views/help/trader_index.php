<h2 class="breadcumbTitle">Help Control panel</h2>
<!-- cars-area start -->
<div class="card-wrap-style-two faq-table-wrap">
    <h3 class="card-header-withbtn">FAQ List <button data-toggle="modal" data-target="#addNewFaq"
                                                     class="header-btn">+ Add New</button>
    </h3>
    <div class="row">
        <div class="col-lg-4 offset-lg-8">
            <form class="search-form" action="<?php echo site_url(Backend_URL . 'help'); ?>" method="get">
                <input type="text" placeholder="Search" name="q" value="<?php echo $q; ?>">
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
                <th>Name</th>
                <th>Email</th>
                <th>Created at</th>
                <th>Popular</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $count = $this->input->get('start');
            $count = $count + 1;
            foreach ($help_data as $help) { ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                    <td><strong><?php echo $help->title; ?></strong> </td>
                    <td><?php echo $help->qustion_by_name; ?></td>
                    <td><?php echo $help->question_by_email; ?></td>
                    <td> <?php echo globalDateFormat($help->created); ?></td>
                    <td><?php echo ($help->featured); ?></td>
                    <td><?php echo $help->status; ?></td>
                    <td>
                        <ul class="actionsbtn">
                            <li><a href="help/read/<?php echo $help->id;?>"><i class="fa fa-eye"></i></a></li>
                            <li><button onclick="update_period(this)" data-id="<?php echo $help->id; ?>"
                                   data-question="<?php echo $help->title; ?>"
                                   data-answer="<?php echo $help->content; ?>"
                                   data-description="<?php echo $help->description; ?>"
                                   data-status="<?php echo $help->status; ?>"
                                   data-featured="<?php echo $help->featured; ?>"
                                >
                                    <i class="fa fa-pencil-square-o"></i></button>
                            </li>
                            <li><a href="help/delete/<?php echo $help->id;?>" onclick="return confirm('Do you really Delete this item?');">
                                    <i class="fa fa-trash"></i></a></li>
                        </ul>
                    </td>
                </tr>
            <?php }; ?>
            </tbody>
        </table>
    </div>

</div>
<?php
if (count($help_data) > 0) {
    echo $pagination;
} else {
    echo '<p class="alert alert-warning">Sorry! You do not have any listing.</p>';
}
?>

<div class="modal fade modalWrapper" id="addNewFaq" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <form class="row" method="post" action="admin/help/create_action">
                <div class="col-12 text-center">
                    <h3 class="title-add-car">Create New Help</h3>
                </div>
                <div class="col-12">
                    <label class="input-label">Question</label>
                    <input type="text" class="inputbox-style" placeholder="Type question" name="title">
                </div>
                <div class="col-12 mb-3">
                    <label class="input-label">Description</label>
                    <textarea class="ckeditor-wrap" id="description" name="description"></textarea>
                </div>
                <div class="col-12 mb-3">
                    <label class="input-label">Answer</label>
                    <textarea class="ckeditor-wrap" id="answer" name="content"></textarea>
                </div>
                <div class="col-12 mb-3">
                    <label class="input-label">Status</label>
                    <ul class="radio-btn-style">
                        <li>
                            <input name="status" type="radio" id="one" value="Published">
                            <label for="one">Published</label>
                        </li>
                        <li>
                            <input name="status" type="radio" id="two" value="Draft">
                            <label for="two">Draft </label>
                        </li>
                    </ul>
                </div>
                <div class="col-12 mb-3">
                    <label class="input-label">Top FAQ </label>
                    <ul class="radio-btn-style">
                        <li>
                            <input name="featured" type="radio" id="Yes" value="Yes">
                            <label for="yes">Yes</label>
                        </li>
                        <li>
                            <input name="featured" type="radio" id="No" value="No">
                            <label for="no">No </label>
                        </li>
                    </ul>
                    <input name="temp" type="hidden" value="temp">
                </div>
                <div class="col-12 text-right">
                    <button class="btn-wrap btn-big float-none">Create</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade modalWrapper" id="addNewUpdate" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <form class="row" method="post" action="admin/help/update_action">
                <div class="col-12 text-center">
                    <h3 class="title-add-car">Update Help</h3>
                </div>
                <div class="col-12">
                    <label class="input-label">Question</label>
                    <input type="text" class="inputbox-style" placeholder="Type question" name="title" id="question">
                </div>
                <div class="col-12 mb-3">
                    <label class="input-label">Description</label>
                    <textarea class="ckeditor-wrap" id="description_u" name="description"></textarea>
                </div>
                <div class="col-12 mb-3">
                    <label class="input-label">Answer</label>
                    <textarea class="ckeditor-wrap" id="answer_u" name="content"></textarea>
                </div>
                <div class="col-12 mb-3">
                    <label class="input-label">Status</label>
                    <ul class="radio-btn-style">
                        <li>
                            <input name="status" type="radio" id="one_u" value="Published">
                            <label for="one">Published</label>
                        </li>
                        <li>
                            <input name="status" type="radio" id="two_u" value="Draft">
                            <label for="two">Draft </label>
                        </li>
                    </ul>
                </div>
                <div class="col-12 mb-3">
                    <label class="input-label">Top FAQ </label>
                    <ul class="radio-btn-style">
                        <li>
                            <input name="featured" type="radio" id="Yes_u" value="Yes">
                            <label for="yes">Yes</label>
                        </li>
                        <li>
                            <input name="featured" type="radio" id="No_u" value="No">
                            <label for="no">No </label>
                        </li>
                    </ul>
                    <input name="id" type="hidden" value="0" id="id">
                    <input name="temp" type="hidden" value="temp">
                </div>
                <div class="col-12 text-right">
                    <button class="btn-wrap btn-big float-none">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.6.2/ckeditor.js"></script>
<script>
    CKEDITOR.replace('answer', {
        height: ['130px'],
    });

    CKEDITOR.replace('description', {
            height: ['130px'],
    });

    CKEDITOR.replace('answer_u', {
        height: ['130px'],
    });

    CKEDITOR.replace('description_u', {
        height: ['130px'],
    });

    function update_period(element) {
        $('#id').val($(element).data('id'));
        $('#question').val($(element).data('question'));
        CKEDITOR.instances['answer_u'].setData($(element).data('answer'));
        CKEDITOR.instances['description_u'].setData($(element).data('description'));

        if ($(element).data('status') === 'Published') {
            $("#one_u").prop("checked", true);
        } else {
            $("#two_u").prop("checked", true);
        }

        if ($(element).data('featured') === 'Yes') {
            $("#Yes_u").prop("checked", true);
        } else {
            $("#No_u").prop("checked", true);
        }

        $('#addNewUpdate').modal('show');
    }

</script>
