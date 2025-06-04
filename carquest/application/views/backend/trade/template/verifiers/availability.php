<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-30">
            <h4 class="fs-18 fw-500 mb-0">Availability</h4>
            <ul class="d-flex flex-wrap availabilityBtn">
                <?php if ($exist->status != 'Job Running') :?>
                    <li class="mr-10"><a href="admin/verifier/availability_status" class="btnStyle btnStyleOutline">I’m <?=$exist->status == 'Available' ? 'Unavailable' : 'Available'?></a></li>
                <?php endif; ?>
                <li><a href="javascript:void(0)" class="btnStyle add-availability">Add Availability</a></li>
            </ul>
        </div>
        <div class="bg-white br-5 shadow p-20 mb-30 d-none availability-form">
            <form action="admin/verifier/availability_create" method="post">
                <input type="hidden" id="id" name="id" value="0">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="input-field">
                            <input id="name" value="" name="name" type="text" required>
                            <label for="name"><span>Name</span></label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="select-style">
                            <select class="browser-default" name="term" id="term">
                                <option value="" disabled>Select Term</option>
                                <option value="Short Term">Short Term</option>
                                <option value="Middle Term">Middle Term</option>
                                <option value="Long Term">Long Term</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="input-field">
                            <input id="date" value="" name="date" type="text" required>
                            <label for="date"><span>Date Range</span></label>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button class="btnStyle">Save</button>
                </div>
            </form>
        </div>
        <div class="bg-white br-5 shadow p-20 mb-30">
            <?php foreach ($times as $time) :?>
                <div class="bg-grey d-flex flex-wrap justify-content-between p-20 br-3 mb-10">
                    <span class="color-seconday mr-20"><?=$time->name?> </span>
                    <span class="color-black mr-20"><?=$time->term?></span>
                    <span class="mr-20"><?=date_format(date_create($time->start_date), 'd/m/Y')?> - <?=date_format(date_create($time->end_date), 'd/m/Y')?></span>
                    <ul class="d-flex">
                        <li>
                            <a class="color-text fs-18 edit-availability" href="javascript:void(0)"
                               data-id="<?=$time->id?>"
                               data-name="<?=$time->name?>"
                               data-term="<?=$time->term?>"
                               data-date="<?=date_format(date_create($time->start_date), 'm/d/Y')?> - <?=date_format(date_create($time->end_date), 'm/d/Y')?>"
                            >
                                <span class="material-icons"> create</span>
                            </a>
                        </li>
                        <li>
                            <a class="color-text fs-18" href="admin/verifier/availability_delete/<?=$time->id?>">
                                <span class="material-icons"> delete</span>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="assets/new-theme/js/dataTables.min.js"></script>
<script type="text/javascript" src="assets/new-theme/js/datatable.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    $('input[name="date"]').daterangepicker({
        opens: 'left'
    }, function(start, end, label) {
    });

    $('.add-availability').on('click', function () {
        $('#id').val(0);
        $('#name').val('');
        $('#term').val('').trigger('change.select2');
        $('#date').val("<?=date('m/d/Y').' - '.date('m/t/Y')?>");
        $('input[name="date"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
        });
        $('.availability-form').removeClass('d-none');
    })

    $('.edit-availability').on('click', function () {
        $('#id').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#term').val($(this).data('term')).trigger('change.select2');
        $('#date').val($(this).data('date'));
        $('input[name="date"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
        });
        $('.availability-form').removeClass('d-none');
    })
</script>
