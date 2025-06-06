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
                        <th>Name</th>
                        <th>Rating</th>
                        <th width="115">Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php
                    $count = $this->input->get('start');
                    $count = $count + 1;
                    foreach ($items as $item) { ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $item->first_name . ' ' . $item->last_name; ?></td>
                            <td><?php echo $item->rating; ?></td>
                            <td >
                                <button class="viewDetails" data-details="<?php echo $item->comment; ?>"
                                ><i class="fa fa-eye"></i></button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-12" style="padding-bottom:10px">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-right">
                        <?php echo $pagination ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade modalWrapper" id="reviewDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">Comment</div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <p id="viewDetails"></p>
            </div>
        </div>
    </div>
</div>

<script>
    $(".viewDetails").click(function () {
        let details = $(this).data('details');
        $("#viewDetails").text(details);
        $('#reviewDetailsModal').modal('show');
    });
</script>
