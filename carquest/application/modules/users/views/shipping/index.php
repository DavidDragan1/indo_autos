<?php load_module_asset('users', 'css'); ?>
<?php load_module_asset('users', 'js'); ?>
<section class="content-header">
    <h1> User <small>Shipping</small> &nbsp;&nbsp;
        <?php //echo anchor(site_url('admin/users/create'), ' + Add User', 'class="btn btn-default"'); ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin </a></li>        
        <li class="active">Shipping Product</li>
    </ol>
</section>

<section class="content"> 
    <div class="panel panel-default">

        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-users" aria-hidden="true"></i> List of Shipping Product
            </h3>
        </div>


        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>From</th>
                    <th>Destination</th>
                    <th>Vehicle</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th width="200">Action </th>
                </tr>   
            </thead>
            <tbody>
                <?php foreach ($products as $key => $post) { ?>
                    <tr>
                        <td class="fw-500"><?=$post->title?></td>
                        <td><?php echo getCountryName($post->shipping_port); ?></td>
                        <td><?php echo GlobalHelper::getPortNameById($post->destination_port); ?></td>
                        <td><?php echo GlobalHelper::getBrandNameById($post->brand_id).' '. GlobalHelper::getModelNameById($post->model_id).' '.$post->year; ?></td>
                        <td class="fw-500 color-theme"><?=GlobalHelper::getPrice($post->total_amount, 0, 'NGR')?></td>
                        <td><?=$post->product_status?></td>
                        <td>
                        <?php
                        echo anchor(site_url(Backend_URL . 'users/shipping-agent-product/update/' . $post->id), '<i class="fa fa-fw fa-edit"></i> Edit', 'class="btn btn-xs btn-default"');
                        echo anchor(site_url(Backend_URL . 'users/shipping-agent-product/delete/' . $post->id), '<i class="fa fa-fw fa-trash"></i> Delete ', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                        ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>     



        <div class="row" style="padding-top: 10px; padding-bottom: 10px; margin: 0;">
            <div class="col-md-6">
                <span class="btn btn-primary">Total Record : <?php echo $total_rows ?></span>
            </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </div>
</section>
<script>
    $(window).on('load',function (){
        date_range($('select[name="range"]').val())
    })
    function date_range(range){
        var range = range;
        if( range == 'Custom'){
            $('#custom').css('display','block');
        } else {
            $('#custom').css('display','none');
        }
    }
</script>
