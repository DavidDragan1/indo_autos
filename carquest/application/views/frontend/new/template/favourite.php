<?php
$saved_title = '';

if ($this->uri->uri_string() == 'favourite/car'){
    $saved_title = 'Cars';
} elseif ($this->uri->uri_string() == 'favourite/motorbike'){
    $saved_title = 'Bikes';
} elseif ($this->uri->uri_string() == 'favourite/spare-parts'){
    $saved_title = 'Spare Parts';
}
?>

<!-- breadcumb_search-area start  -->
<?php include_once dirname(APPPATH) . "/application/views/frontend/new/template/global_search.php"; ?>
<!-- breadcumb_search-area end  -->
<!-- saved-cars-area start  -->
<div class="saved-cars-area pb-75">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="saved-cars-filter d-flex flex-wrap justify-content-between mb-20">
                    <h1 class="section-title-two mb-0">Saved <?=$saved_title?></h1>
                    <ul class="saved-cars-filter-list d-flex flex-wrap">
                        <li><a class="waves-effect <?=$this->uri->uri_string() == 'favourite/car' ? 'active' : ''?>" href="favourite/car">Cars</a></li>
                        <li><a class="waves-effect <?=$this->uri->uri_string() == 'favourite/motorbike' ? 'active' : ''?>" href="favourite/motorbike">Bikes</a></li>
                        <li><a class="waves-effect <?=$this->uri->uri_string() == 'favourite/spare-parts' ? 'active' : ''?>" href="favourite/spare-parts">Spare Parts</a></li>
<!--                        <li><a class="waves-effect" href="Javascript:void(0)">Drivers</a></li>-->
<!--                        <li><a class="waves-effect" href="Javascript:void(0)">Mechanics</a></li>-->
                    </ul>
                </div>
                <?php foreach ($data_posts as $k => $post) :?>
                <div class="saved-cars-wrap  d-lg-flex d-md-block flex-wrap mb-30">
                    <div class="saved-cars-img">
                        <a href="post/<?=$post->post_slug?>">
                            <?=GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, '',getShortContentAltTag(($post->title), 60))?>
                        </a>
                    </div>
                    <div class="saved-cars-info">
                        <?php if ($post->is_financing) :?>
                            <span class="badge d-flex align-items-center">
                                <span class="material-icons">verified_user</span>
                                Financing
                            </span>
                        <?php endif; ?>
                        <h4 class="fs-25 fw-500 d-flex mb-5"><a href="post/<?=$post->post_slug?>"><?=getShortContent(($post->title), 20)?></a>
                            <?php
                            if (!empty($post->gear_box_type)) echo "<span class=\badge-wrap theme-badge\">$post->gear_box_type</span>";
                            ?>
                        </h4>
                        <p class="saved-cars-action"><?=$post->manufacture_year?> | <?=$post->condition?></p>
                        <div
                            class="saved-cars-price-wrap d-flex  align-items-center flex-wrap justify-content-between">
                            <ul class="saved-cars-price">
                                <li class="mb-10">
                                    <p class="fs-14">Location:</p>
                                    <h5 class="fs-16 fw-500 color-seconday mb-0"><?=$post->location?>, <?=$post->state_name?></h5>
                                </li>
                                <?php if ($post->vehicle_type_id == 1) : ?>
                                <li>
                                    <p class="fs-14">Mileage:</p>
                                    <h5 class="fs-16 fw-500 color-theme mb-0"><?=number_shorten($post->mileage)?> Miles</h5>
                                </li>
                                <?php endif; ?>
                            </ul>
                            <div>
                                <p class="fs-14">Pricing:</p>
                                <h2 class="fs-40 fw-500 color-theme mb-0"><?=GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein)?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php endforeach; ?>
                <?=$pagination?>
            </div>
        </div>
    </div>
</div>
<!-- saved-cars-area end  -->
