<h2 class="breadcumbTitle">Question</h2>
<!-- cars-area start -->
<div class="card-wrap-style-two faq-table-wrap">
    <h3 class="card-header-withbtn">Question List <button data-toggle="modal"
                                                               data-target="#mechanicDiagnosticQuestionsType" class="header-btn">+ Add New</button>
    </h3>
    <div class="row">
        <div class="col-lg-4 offset-lg-8">
            <form class="search-form" action="admin/diagnostics/questions" method="get">
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
                <th>Question</th>
                <th>Vehicle Type</th>
                <th>Brand</th>
                <th>model</th>
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
                    <td><?php echo $question->question; ?></td>
                    <td><?php echo getVehcileNameById($question->vehicle_type_id); ?></td>
                    <td><?php echo get_brand_by_id($question->brand_id); ?></td>
                    <td><?php echo getModelNameById($question->model_id, $question->brand_id); ?></td>
                    <td><?php echo $question->status; ?></td>
                    <td>
                        <ul class="actionsbtn">
                            <li>
                                <button onclick="update_period(this)" data-id="<?php echo $question->id; ?>"
                                        data-vehicle="<?php echo $question->vehicle_type_id; ?>"
                                        data-brand="<?php echo $question->brand_id; ?>"
                                        data-model="<?php echo $question->model_id; ?>"
                                        data-type="<?php echo $question->question_type_id; ?>"
                                        data-question="<?php echo $question->question; ?>"
                                        data-status="<?php echo $question->status; ?>"
                                ><i class="fa fa-pencil-square-o"></i></button>
                            </li>
                            <li><a href="admin/diagnostics/delete-question/<?php echo $question->id; ?>"
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
            <form class="row" method="post" action="admin/diagnostics/question-update">
                <div class="col-12 text-center">
                    <h3 class="title-add-car">Update Question</h3>
                </div>
                <div class="col-12">
                    <label class="input-label">Question</label>
                    <input name="question" type="text" class="inputbox-style" placeholder="Type question" id="title">
                </div>
                <div class="col-12">
                    <label class="input-label">Question Type</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="type" id="type">
                           <?php echo makeQuestionType(getLoginUserData('user_id')); ?>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <label class="input-label">Vehicle Type</label>
                    <div class="select2-wrapper">
                        <select class="input-style" name="vehicle_type_id" id="vehicle_type_id" onChange="vehicle_change(this.value);">
                            <?php echo GlobalHelper::dropDownVehicleList("General"); ?>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <label class="input-label">Brand Name</label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="brand_id" onChange="get_model(this.value);" name="brand_id">
                            <?php echo GlobalHelper::get_brands_by_vechile(0, 0); ?>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <label class="input-label">Model Name</label>
                    <div class="select2-wrapper">
                        <select class="input-style" id="model_id" name="model_id">
                            <option value="" disabled selected>Model</option>
                            <?php  echo GlobalHelper::get_brands_by_vehicle_model(0, 0);   ?>
                        </select>
                    </div>
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
        $("#title").val($(element).data("question"));
        $("#status").val($(element).data("status")).change();
        $('#mechanicDiagnosticQuestionsType').modal('show');
    }

    $('#mechanicDiagnosticQuestionsType').on('hidden.bs.modal', function (e) {
        $('#period_form').trigger("reset");
    })

</script>
