<!-- hero-area start  -->
<div class="hero-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-5 col-12">
                <div class="hero-content">
                    <h1>Buy and Sell New & Used Cars</h1>
                    <p class="mb-15">Get your next car from CarQuest. We have made buying and selling of new and used cars simple, easy and quick. <br><br>

                        Whether you're looking for what's available in your local area or performing a quick search by brand and model. We can help you get the best auto/car deals around.
                    </p>
                    <ul class="hero-btns">
                        <li><a class="waves-effect btnStyle" href="buy/car">Buy Car</a></li>
                        <li><a class="waves-effect btnStyle btnStyleOutline" href="admin/posts/create?post_type=car">Sell Car</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-shape-bg">
        <img class="hero-shape" src="assets/new-theme/images/shapes/hero.png" alt="Shape">
    </div>
</div>
<!-- hero-area end  -->

<!-- new-and-use car start  -->
<div class="new-use-car-area ptb-75">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Best New and Used Car Deals This Month</h2>
            </div>
            <div class="col-12">
                <div class="scroll-products">
                    <div class="row">
                         <?php  foreach ($recentCars as $recentCar) :?>
                            <div class="col-3">
                                <div class="carPost-wrap">
                                    <a class="carPost-img" href="post/<?php echo $recentCar->post_slug;?>">
                                        <?php echo GlobalHelper::getPostThumbPhotoById($recentCar->id,$recentCar->title)?>
                                    </a>
                                    <div class="carPost-content">
                                        <span class="level"><?php echo $recentCar->condition;?></span>
                                        <h4><a href="post/<?php echo $recentCar->post_slug;?>"><?php echo getShortContent($recentCar->title,20);?></a>
                                            <?php if ($recentCar->is_verified == 'Verified seller') { ?>
                                                <img src="assets/new-theme/images/icons/verify-new.svg" title="Verified" alt="">
                                            <?php } ?>
                                        </h4>
                                        <ul class="post-price">
                                            <li class="price"><?php echo GlobalHelper::getPrice($recentCar->priceinnaira, $recentCar->priceindollar, $recentCar->pricein);?></li>
                                            <li class="km"><?php echo number_shorten($recentCar->mileage);?> Miles</li>
                                        </ul>
                                        <span class="location"><?php echo $recentCar->location;?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>

            <div class="col-12 text-center mt-20">
                <a href="buy/car/search" style="padding: 0px 50px;" class="btnStyle">See all Cars</a>
            </div>
        </div>
    </div>
</div>
<!-- new-and-use car end  -->

<div class="how_it_works-area ptb-75">
    <div class="container">
        <h2 class="section-title">How it works</h2>
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <div class="how_it_works-wrap">
                    <!-- <h4 class="fs-34 fw-500 mb-15">See the video to see how it works</h4> -->
                    <p class="fs-16">We have made buying and selling of our auto products simple, easy and quick. Kindly watch the video guide on how to use our website.</p>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="how_it_works-img">
                    <img src="assets/new-theme/images/bg/video.jpg" alt="">
                    <a class="play-video" href="https://youtu.be/0CovmT9wsJk?si=x-Plk_6__vE0Tyuy">
                            <span class="material-icons">
                                play_circle_outline
                            </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- buy_and_sell-area start  -->
<div class="buy_and_sell-area pt-75">
    <div class="container">
        <div class="row align-items-center md-flex-revarce">
            <div class="col-xl-5 offset-xl-1 col-lg-5">
                <div class="buy_and_sell-wrap">
                    <h4>Buy and Sell New and Used Motorbike</h4>
                    <p>Find your next bike with CarQuest. Check out new and used motorcycles for sale on CarQuest - all bikes listed are from leading Motorcycle Dealers. Buy your next new & used bike with confidence using our verified dealers.</p>
                    <ul class="hero-btns">
                        <li><a class="waves-effect btnStyle" href="buy/motorbike">Buy Motorbike</a></li>
                        <li><a class="waves-effect btnStyle btnStyleOutline" href="admin/posts/create?post_type=motorbike">Sell Motorbike</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-5 col-lg-7">
                <div class="buy_and_sell-img text-right">
                    <img src="assets/new-theme/images/shapes/buy-sell.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- buy_and_sell-area end  -->
<!-- new-and-use car start  -->
<div class="new-use-car-area ptb-75">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Recently Posted Bikes</h2>
            </div>
            <div class="col-12">
                <div class="scroll-products">
                    <div class="row">
                        <?php  foreach ($recentBikes as $recentBike) :?>
                            <div class="col-3">
                                <div class="carPost-wrap">
                                    <a class="carPost-img" href="post/<?php echo $recentBike->post_slug;?>">
                                        <?php echo GlobalHelper::getPostThumbPhotoById($recentBike->id,$recentBike->title)?>
                                    </a>
                                    <div class="carPost-content">
                                        <span class="level"><?php echo $recentBike->condition;?></span>
                                        <h4><a href="post/<?php echo $recentBike->post_slug;?>"><?php echo getShortContent($recentBike->title,20);?></a>
                                            <?php if ($recentBike->is_verified == 'Verified seller') { ?>
                                                <img src="assets/new-theme/images/icons/verify-new.svg" title="Verified" alt="">
                                            <?php } ?>
                                            </h4>
                                        <ul class="post-price">
                                            <li class="price"><?php echo GlobalHelper::getPrice($recentBike->priceinnaira, $recentBike->priceindollar, $recentBike->pricein,);?></li>
                                            <li class="km"><?php echo number_shorten($recentBike->mileage);?> Miles</li>
                                        </ul>
                                        <span class="location"><?php echo $recentBike->location;?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center mt-20">
                <a href="buy/motorbike/search" style="padding: 0 50px;" class="btnStyle">See all Motorbikes</a>
            </div>
        </div>
    </div>
</div>
<!-- new-and-use car end  -->

<!-- buy_and_sell-area start  -->
<div class="buy_and_sell_parts-area ptb-75 bg-grey ">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-5 offset-xl-1 col-lg-7">
                <div class="buy_and_sell-img">
                    <img src="assets/new-theme/images/shapes/parts.png" alt="">
                </div>
            </div>
            <div class="col-xl-5 offset-xl-1 col-lg-5">
                <div class="buy_and_sell-wrap">
                    <h4>Buy and Sell Spare Parts</h4>
                    <p>Search our inventory for new & used car parts. Get the best deal on genuine car spare parts from top  dealers.</p>
                    <ul class="hero-btns">
                        <li><a class="waves-effect btnStyle" href="buy/spare-parts">Buy Spare Parts</a></li>
                        <li><a class="waves-effect btnStyle btnStyleOutline" href="admin/posts/create?post_type=spare-parts">Sell Spare
                                Parts</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- buy_and_sell-area end  -->

<!-- new-and-use car start  -->
<div class="new-use-car-area ptb-75">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Recently Posted Spare Parts</h2>
            </div>
            <div class="col-12">
                <div class="scroll-products">
                    <div class="row">
                        <?php  foreach ($recentSpareParts as $sparePart) :?>
                            <div class="col-3">
                                <div class="carPost-wrap">
                                    <a class="carPost-img" href="post/<?php echo $sparePart->post_slug;?>">
                                        <?php echo GlobalHelper::getPostThumbPhotoById($sparePart->id,$sparePart->title)?>
                                    </a>
                                    <div class="carPost-content">
                                        <span class="level"><?php echo $sparePart->condition;?></span>
                                        <h4><a href="post/<?php echo $sparePart->post_slug;?>"><?php echo getShortContent($sparePart->title,20);?></a></h4>
                                        <ul class="post-price">
                                            <li class="price"><?php echo GlobalHelper::getPrice($sparePart->priceinnaira, $sparePart->priceindollar, $sparePart->pricein);?></li>
                                        </ul>
                                        <span class="location"><?php echo $sparePart->location;?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center mt-20">
                <a href="buy/spare-parts/search" style="padding: 0px 50px;" class="btnStyle">See all Spare Parts</a>
            </div>
        </div>
    </div>
</div>
<!-- new-and-use car end  -->

<!-- .popular-brands-area start  -->
<div class="popular-brands-area pb-75">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">Browse Popular Brands</h2>
            </div>
            <div class="col-xl-10 offset-xl-1">
                <ul class="popular-brands-list">
                    <?=GlobalHelper::homeBrands()?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- .popular-brands-area end  -->
<!-- <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5b92655aafc2c34e96e85035/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
    Tawk_API.customStyle = {
		visibility : {
			mobile : {
				position : 'br',
				xOffset : 10,
				yOffset : 80
			}
		}
	};

</script> -->
