<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('files', 'css'); ?>

<h2 class="breadcumbTitle">Vehicle Price Guide</h2>
<!-- advert-area start  -->
<div class="datatable-responsive">
    <div class="datatable-header justify-content-end">
        <form action="<?php echo site_url(Backend_URL . 'files'); ?>" method="get">
            <input type="text" class="search" placeholder="Search" name="q" value="<?php echo $q; ?>">
        </form>
    </div>
    <table id="advert" class="datatable-wrap" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th class="all">#</th>
            <th class="all">Date</th>
            <th class="all">Title</th>
            <th class="all ">File</th>
            <th class="all"> Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($files as $file) { ?>
        <tr>
            <td><?php echo ++$start ?></td>
            <td><?php echo globalDateFormat($file->created); ?></td>
            <td><?php echo $file->title ?></td>
            <td>
                <ul class="action-wrapper">
                    <li><?php echo admin_new_download_attachment($file->attach); ?></li>
                </ul>
            </td>
            <td>
                <ul class="action-wrapper">
                    <li><button class="preview_file_note" data-id="<?php echo $file->id; ?>">Preview</button></li>
                </ul>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-4 col-lg-3 col-12">
            <p class="btn-wrap total-record">Total Record <?php echo $total_rows ?></p>
        </div>
        <div class="col-md-6 col-lg-9 col-12">
            <?php echo $pagination ?>
        </div>
    </div>

</div>
<?php load_module_asset('files', 'js'); ?>
<?php $this->load->view('preview_modal'); ?>
