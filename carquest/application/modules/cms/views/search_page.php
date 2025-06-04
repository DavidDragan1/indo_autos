<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1> CMS  <small>Control panel</small> <?php echo anchor(site_url( Backend_URL . 'cms/search-page/add'),' + Add New', 'class="btn btn-default"'); ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">CMS</li>
    </ol>
</section>


<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <div class="col-md-3"><h5><b>List of Pages</b></h5></div>
        </div>


        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-condensed">
                    <thead>
                    <tr>
                        <th width="40">ID</th>
                        <th>Search Item</th>
                        <th width="120" class="text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($data as $d) {
                        $search_item = '';
                        foreach (array_keys((array) $d) as $t){
                            if (!empty($d->$t) && !in_array($t, ['id', 'title', 'var']))
                            $search_item .= '<span style="background-color: #5bc0de;margin: 5px">'.search_array($t)."</span>";
                        }
                        ?>
                        <tr>
                            <td><?php echo $d->id; ?></td>
                            <td><?php echo $search_item; ?></td>
                            <td class="text-right">
                                <?php
                                echo anchor(site_url(  Backend_URL .  'cms/search-page/update/'.$d->id),'<i class="fa fa-fw fa-edit"></i>',  'class="btn btn-xs btn-default"');
                                echo anchor(site_url(  Backend_URL .  'cms/search-page/delete/'.$d->id),'<i class="fa fa-fw fa-trash"></i> ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
