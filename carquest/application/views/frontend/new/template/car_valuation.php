<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css" integrity="sha512-KRrxEp/6rgIme11XXeYvYRYY/x6XPGwk0RsIC6PyMRc072vj2tcjBzFmn939xzjeDhj0aDO7TDMd7Rbz3OEuBQ==" crossorigin="anonymous" />
<div class="pt-75">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div
                    class="car_valuation-wrap p-30 br-5 d-flex align-items-center justify-content-between mb-50 flex-wrap"
                >
                    <img src="assets/new-theme/images/car.png" alt="car" />
                    <div class="bg-white shadow br-5 p-20">
                        <h1 class="d-flex flex-wrap fs-24 fw-500 align-items-center color-theme mb-0">
                            Free Car Valuation
                            <span
                                data-position="left"
                                data-tooltip="This is the information buyers will if they want to contact you."
                                class="tooltip-trigger tooltipped"
                            >
										<img src="assets/new-theme/images/icons/info.svg" alt="icon" />
									</span>
                        </h1>
                        <form class="car_valuation-form" id="car_valuation-form">
                            <p class="mb-15">See how much your car is worth in seconds</p>
                            <div class="select-style mb-10">
                                <select class="material-select" name="brand_id" onChange="get_model(this.value);" id="brandName" >
                                    <?php echo GlobalHelper::getAllBrands(1); ?>
                                </select>
                            </div>
                            <div class="select-style mb-10">
                                <select class="material-select" name="model_id" id="model_id">
                                    <option value="" disabled selected>Model</option>
                                </select>
                            </div>
                            <div class="select-style mb-10">
                                <select class="material-select" name="year">
                                    <option value="" disabled selected>Year</option>
                                    <?php echo numericDropDown(2005, date('Y'), 1, 0, true); ?>
                                </select>
                            </div>
                            <div class="mb-10">
                                <label>Millage</label>
                                <div id="slider"></div>
                                <input type="hidden" id="millage_from" name="millage_from">
                                <input type="hidden" id="millage_to" name="millage_to">
                            </div>
                            <button type="button" class="btnStyle w-100" id="valuation-button">Get a Valuation</button>
                        </form>
                         <form class="car_valuation-result d-none" id="car_valuation-result">
                            <p>Here’s how much your car is worth.</p>
                            <div class="car_valuation">
                                <h4 class="d-flex flex-wrap align-items-center fs-14 fw-500">
                                    <span class="car_name">Honda Accord 2010 LX</span>
                                    <span
                                        data-position="left"
                                        data-tooltip="This is the information buyers will if they want to contact you."
                                        class="tooltip-trigger tooltipped"
                                    >
                                        <img src="assets/new-theme/images/icons/info.svg" alt="icon" />
                                    </span>
                                </h4>
                                <ul id="car_valuation-body">
                                    <li>₦5,000,000 - ₦7,000,000 <span>new</span></li>
                                    <li>₦5,000,000 - ₦7,000,000 <span>Nigeria Used</span></li>
                                    <li>₦5,000,000 - ₦7,000,000 <span>Foreign Used</span></li>
                                </ul>
                            </div>
                            <div>
                                <a href="#" class="btnStyle btnStyleOutline w-100 mb-15 car_search_url buy_car_name">
                                    Buy Honda Accord 2020
                                </a>
                            </div>
                            <div>
                                <a href="admin/posts/create?post_type=car" class="btnStyle w-100 sell_car_name">Sell Honda Accord 2020</a>
                            </div>
                        </form>
                         <form class="car_valuation-result d-none" id="car_valuation-error">
                            <p>Here’s how much your car is worth.</p>
                            <div class="car_valuation d-flex align-items-center justify-content-center p-30">
                                We couldn’t valuate your car. <span class="color-theme" style="cursor: pointer" onclick="return window.location.reload()">Try again</span>
                            </div>
                            <div>
                                <a href="buy/car/search" class="btnStyle btnStyleOutline w-100 mb-15">Buy a car</a>
                            </div>
                            <div>
                                <a href="admin/posts/create?post_type=car"" class="btnStyle w-100">Sell a car</a>
                            </div>
                        </form> 
                    </div>
                </div>
                <h4 class="fs-24 mb-50 fw-500 text-center">How our Car Valuations can help you</h4>
                <div class="row mb-30">
                    <div class="col-lg-6 col-12">
                        <div class="bg-grey p-40 br-5 mb-30 buy_sell-wrap">
									<span class="image">
										<img src="assets/new-theme/images/buy.png" alt="buy" />
										<span class="buy">BUY</span>
									</span>
                            <h5 class="fs-20 fw-500 mb-15">If you’re buying a car</h5>
                            <p class="fs-14">
                                We’ll give you two valuations: the first will show how much you could get if you
                                sell your car privately, the second will show how much you may be offered if you
                                part exchange. That way, you can compare your options and make an informed
                                decision.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="bg-grey p-40 br-5 mb-30 buy_sell-wrap">
									<span class="image">
										<img src="assets/new-theme/images/sell.png" alt="sell" />
										<span class="sell">sell</span>
									</span>
                            <h5 class="fs-20 fw-500 mb-15">If you’re selling a car</h5>
                            <p class="fs-14">
                                We’ll give you two valuations: the first will show how much you could get if you
                                sell your car privately, the second will show how much you may be offered if you
                                part exchange. That way, you can compare your options and make an informed
                                decision.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row mb-30">
                    <div class="col-lg-10 offset-lg-1 col-12">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div
                                    class="shadow bg-white br-5 p-30 d-flex flex-wrap align-items-center mb-30 buy_sell_info-wrap"
                                >
                                    <img src="assets/new-theme/images/buy-car.svg" alt="" />
                                    <div class="content">
                                        <h4 class="fs-24 fw-600 mb-15">Buy a Car</h4>
                                        <p class="fs-16">The best car deals on the market at your fingertips</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div
                                    class="shadow bg-white br-5 p-30 d-flex flex-wrap align-items-center mb-30 buy_sell_info-wrap"
                                >
                                    <img src="assets/new-theme/images/sell-car.svg" alt="" />
                                    <div class="content">
                                        <h4 class="fs-24 fw-600 mb-15">Sell your Car</h4>
                                        <p class="fs-16">The best car deals on the market at your fingertips</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="fs-24 mb-30 fw-500 text-center">Good car deals this month</h4>
                <div class="row">
                    <?php foreach ($trending as $k => $post) {?>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="carPost-wrap">
                                <a class="carPost-img" href="post/<?=$post->post_slug?>">
                                    <?=GlobalHelper::getPostFeaturedPhoto($post->id, 'featured', null, 'grayscale lazyload post-img',getShortContentAltTag(($post->title), 60))?>
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
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js" integrity="sha512-EnXkkBUGl2gBm/EIZEgwWpQNavsnBbeMtjklwAa7jLj60mJk932aqzXFmdPKCG6ge/i8iOCK0Uwl1Qp+S0zowg==" crossorigin="anonymous"></script>
<script>
    $(function () {
        var slider = document.getElementById('slider');

        noUiSlider.create(slider, {
            start: [0, 80000],
            connect: true,
            step: 1,
            range: {
                'min': 0,
                'max': 120000
            },
            tooltips : [true, true]
        });

        slider.noUiSlider.on('update', function(values, handle) {
            if (handle === 0){
                $('#millage_from').val(values[handle])
            } else {
                $('#millage_to').val(values[handle])
            }
        });
    })

    function get_model(id) {
        jQuery.ajax({
            url: 'get_brands',
            type: "POST",
            dataType: "text",
            data: {id: id},
            beforeSend: function () {
                jQuery('#model_id').html('<option value="0">Loading...</option>');
            },
            success: function (response) {
                jQuery('#model_id').html(response).formSelect();
            }
        });
    }

    $('.advanceSearchTrigger').on('click', function () {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $(this).text('Back to Basic Search');
        } else {
            $(this).text('Advance Search');
        }
        $('.advance-search').toggleClass('active');
        $(this).parents('ul').toggleClass('active');
    });



    $('#valuation-button').on('click', function () {
        var requestData =  $('#car_valuation-form').serialize();

        jQuery.ajax({
            url: 'car_valuation_ajax',
            type: "POST",
            dataType: "json",
            data: requestData,
            success: function (jsonRepond) {
                if (jsonRepond.status === 'error'){
                    if (jsonRepond.message){
                        tosetrMessage('error', jsonRepond.message)
                    } else {
                        $('#car_valuation-form').addClass('d-none');
                        $('#car_valuation-error').removeClass('d-none');
                    }
                } else {
                    $('#car_valuation-form').addClass('d-none');
                    $('.buy_car_name').text('BUY ' + jsonRepond.data.car_name);
                    $('.sell_car_name').text('SELL ' + jsonRepond.data.car_name);
                    $('.car_name').text(jsonRepond.data.car_name);
                    $('.car_search_url').attr('href', `buy/car/search?${jsonRepond.data.car_search_slug}`);

                    let html = '';

                    for (var i = 0; i < jsonRepond.data.val.length; i++){
                        html += `<li>₦${jsonRepond.data.val[i].min} - ₦${jsonRepond.data.val[i].max} <span>${jsonRepond.data.val[i].condition}</span></li>`
                    }

                    $('#car_valuation-body').html(html)

                    $('#car_valuation-result').removeClass('d-none')
                }
                
            }
        });


    })
</script>
