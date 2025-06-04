<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<section class="content-header">
    <h1>Vehicle_variants
        <small>Read</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(Backend_URL) ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo site_url(Backend_URL . 'vehicle_variants') ?>">Vehicle_variants</a></li>
        <li class="active">Add New</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Single View</h3>
        </div>
        <table class="table table-striped">
            <tr>
                <td width="150">Name</td>
                <td width="5">:</td>
                <td><?php echo $name; ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <a href="<?php echo site_url(Backend_URL . 'vehicle_variants') ?>" class="btn btn-default">
                        <i class="fa fa-long-arrow-left"></i> Back
                    </a>
                    <a href="<?php echo site_url(Backend_URL . 'vehicle_variants/update/' . $id) ?>"
                       class="btn btn-primary">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                </td>
            </tr>
        </table>
    </div>
</section>