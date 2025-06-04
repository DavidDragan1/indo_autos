<div class="tag-breadcumb-area">
    <div class="container">
        <h1 class="breadcumb-title">
            <span class="title"><?=$tag->name?></span>
            <span class="breadcumb-border">
                <span class="icon">
                    <img src="assets/new-theme/images/tags.svg" alt="<?=$tag->name?>">
                </span>
            </span>
        </h1>
        <p>We offer you a super VIP experience</p>
    </div>
</div>
<div class="tag-area ptb-75">
    <div class="container">
        <div class="row">
            <?php foreach ($posts as $k => $post) {?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <div class="carPost-wrap">
                    <a class="carPost-img" href="post/<?=$post->post_slug?>">
                        <?=GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, 'grayscale lazyload post-img',getShortContentAltTag(($post->title), 60))?>
<!--                        --><?php
//                        if ($post->is_financing){
//                            echo "<span class=\"badge\">
//                                        <span class=\"material-icons\">verified_user</span>
//                                        Financing
//                                    </span>";
//                        }
                        ?>
                    </a>
                    <div class="carPost-content">
                        <span class="level"><?=$post->condition?></span>
                        <h4><a href="post/<?=$post->post_slug?>"><?=getShortContent(($post->title), 20)?></a></h4>
                        <ul class="post-price">
                            <li class="price"><?=GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein)?></li>
                            <?php
                            if ($post->vehicle_type_id == 1){
                                echo "<li class=\"km\">".number_shorten($post->mileage)." Miles</li>";
                            }
                            ?>
                        </ul>
                        <span class="location"><?=$post->location?>, <?=$post->state_name?></span>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="col-12">
                <?php echo $pagination; ?>
<!--                <ul class="pagination-wrap">-->
<!--                    <li class="disabled prev"><a><i class="fa fa-angle-left"></i></a></li>-->
<!--                    <li><a class="active">1</a></li>-->
<!--                    <li><a href="buy/car/search?&amp;page=2">2</a></li>-->
<!--                    <li><a href="buy/car/search?&amp;page=3">3</a></li>-->
<!--                    <li><a href="buy/car/search?&amp;page=4">4</a></li>-->
<!--                    <li><a href="buy/car/search?&amp;page=5">5</a></li>-->
<!--                    <li class="disabled"><span class="material-icons">more_horiz</span></li>-->
<!--                    <li><a href="buy/car/search?&amp;page=16">16</a></li>-->
<!--                    <li><a href="buy/car/search?&amp;page=17">17</a></li>-->
<!--                    <li class="next"><a href="buy/car/search?&amp;page=2"><i class="fa fa-angle-right"></i></a></li>-->
<!--                </ul>-->
            </div>
        </div>
    </div>
</div>
