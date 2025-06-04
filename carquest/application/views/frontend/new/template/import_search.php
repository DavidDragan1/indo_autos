<!-- breadcumb_search-area start  -->
<?php include_once dirname(APPPATH) . "/application/views/frontend/new/template/global_search.php"; ?>
<!-- breadcumb_search-area end  -->
<!-- search_post-area start  -->
<div class="search_post-area pb-75">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-12">
                <aside class="search_post-sidebar">
                    <div class="search_post-wrap">
                        <ul class="search_post-tabs">
                            <li class="tab">
                                <a class="<?=$this->input->get('condition') == 'New' ? 'active' : ''?> waves-effect" href="<?=search_link_builder($this->input->get(), 'condition', 'New')?>">New Cars</a>
                            </li>
                            <li class="tab">
                                <a class="<?=$this->input->get('condition') == 'Foreign used' ? 'active' : ''?> waves-effect" href="<?=search_link_builder($this->input->get(), 'condition', 'Foreign used')?>">Used Cars</a>
                            </li>
                        </ul>
                    </div>
                    <div id="newCars">
                        <!-- <ul class="search_post-form browser-default">

                            <li>
                                <span class="label">Country</span>
                                <div class="select-dropdown d-flex align-items-center color-seconday">
                                    <span class="select-value fs-16 fw-500 ">Select Country</span>
                                    <span class="material-icons">
                                            expand_more
                                        </span>
                                </div>
                                <div class="dropdown">
                                    <div class="search-list">
                                        <input placeholder="Search.." class="browser-default search" type="text">
                                    </div>
                                    <ul class="scrollbar search-list">
                                        <?=GlobalHelper::all_country_for_search()?>
                                    </ul>
                                </div>

                            </li>
                            <li>
                                <span class="label">State</span>
                                <div class="select-dropdown d-flex align-items-center color-seconday">
                                    <span class="select-value fs-16 fw-500 ">Select State</span>
                                    <span class="material-icons">
                                            expand_more
                                        </span>
                                </div>
                                <div class="dropdown">
                                    <div class="search-list">
                                        <input placeholder="Search.." class="browser-default search" type="text">
                                    </div>
                                    <ul class="scrollbar search-list">
                                        <?=GlobalHelper::all_location_for_search(0,null,empty($this->input->get('country')) ? 155:$this->input->get('country'))?>
                                    </ul>
                                </div>

                            </li>


                            <li>
                                <span>Brand</span>
                                <div class="select-dropdown d-flex align-items-center color-seconday">
                                    <span class="select-value fs-16 fw-500 ">Select Brand</span>
                                    <span class="material-icons">
                                            expand_more
                                        </span>
                                </div>
                                <div class="dropdown">
                                    <div class="search-list">
                                        <input placeholder="Search.." class="browser-default search" type="text">
                                    </div>
                                    <ul class="scrollbar search-list">
                                        <?=GlobalHelper::all_brand_for_search()?>
                                    </ul>
                                </div>

                            </li>
                            <li>
                                <span>Model</span>
                                <div class="select-dropdown d-flex align-items-center color-seconday">
                                    <span class="select-value fs-16 fw-500 ">Select Model</span>
                                    <span class="material-icons">
                                            expand_more
                                        </span>
                                </div>
                                <div class="dropdown">
                                    <div class="search-list">
                                        <input placeholder="Search.." class="browser-default search" type="text">
                                    </div>
                                    <ul class="scrollbar search-list">
                                        <?=GlobalHelper::all_model_for_search()?>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <span>Year</span>
                                <div class="year-filter">
                                    <div class="filter-dropdown">
                                        <div class="select-dropdown-year d-flex align-items-center color-seconday">
                                            <span class="select-value fs-16 fw-500 "> Min</span>
                                            <span class="material-icons">
                                                    expand_more
                                                </span>
                                        </div>
                                        <div class="dropdown">
                                            <div class="search-list">
                                                <input placeholder="Search.." class="browser-default search"
                                                       type="text">
                                            </div>
                                            <ul class="scrollbar search-list-year">
                                                <li><a href="<?=search_link_builder($this->input->get(),'from_year', 0)?>">Min</a></li>
                                                <?=GlobalHelper::yearRange_for_search()?>
                                            </ul>
                                        </div>
                                    </div>

                                    <span class="to">to</span>
                                    <div class="filter-dropdown">
                                        <div class="select-dropdown-year d-flex align-items-center color-seconday">
                                            <span class="select-value fs-16 fw-500 "> Max</span>
                                            <span class="material-icons">
                                                    expand_more
                                                </span>
                                        </div>
                                        <div class="dropdown">
                                            <div class="search-list">
                                                <input placeholder="Search.." class="browser-default search"
                                                       type="text">
                                            </div>
                                            <ul class="scrollbar search-list-year">
                                                <li><a href="<?=search_link_builder($this->input->get(),'to_year', 0)?>">Max</a></li>
                                                <?=GlobalHelper::yearRange_for_search('to_year')?>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </li>
                            <li>
                                <span>Price</span>
                                <div class="year-filter">
                                    <div class="filter-dropdown">
                                        <div class="select-dropdown-year d-flex align-items-center color-seconday">
                                            <span class="select-value fs-16 fw-500 "> Min</span>
                                            <span class="material-icons">
                                                    expand_more
                                                </span>
                                        </div>
                                        <div class="dropdown">
                                            <div class="search-list">
                                                <input placeholder="Search.." class="browser-default search"
                                                       type="text">
                                            </div>
                                            <ul class="scrollbar search-list-year">
                                                <li><a href="<?=search_link_builder($this->input->get(),'price_from', 0)?>">Min</a></li>
                                                <?=GlobalHelper::get_price_for_search(1000000, 10000000, 100000, 'price_from')?>
                                            </ul>
                                        </div>
                                    </div>

                                    <span class="to">to</span>
                                    <div class="filter-dropdown">
                                        <div class="select-dropdown-year d-flex align-items-center color-seconday">
                                            <span class="select-value fs-16 fw-500 "> Max</span>
                                            <span class="material-icons">
                                                    expand_more
                                                </span>
                                        </div>
                                        <div class="dropdown">
                                            <div class="search-list">
                                                <input placeholder="Search.." class="browser-default search"
                                                       type="text">
                                            </div>
                                            <ul class="scrollbar search-list-year">
                                                <li><a href="<?=search_link_builder($this->input->get(),'price_to', 0)?>">Max</a></li>
                                                <?=GlobalHelper::get_price_for_search(1000000, 10000000, 100000, 'price_to')?>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </li>
                        </ul> -->
                        <h3 class="post-card-title">Basic</h3>
                        <div class="post-card-wrap">
                            
                            <div class="search-select-style">
                                <label for="country">Country</label>
                                <input id="country" autocomplete="off" placeholder="Search country.." class="browser-default search search_input" type="text">
                                <i class="material-icons">arrow_drop_down</i>
                                <ul class="search-list">
                                   <?=GlobalHelper::all_country_for_search()?>
                                </ul>
                            </div>
                            <div class="search-select-style">
                                <label for="state">State</label>
                                <input id="state" autocomplete="off" placeholder="Search State..." class="browser-default search search_input" type="text">
                                <i class="material-icons">arrow_drop_down</i>
                                <ul class="search-list">
                                    <?=GlobalHelper::all_location_for_search()?>
                                </ul>
                            </div>
                            <div class="search-select-style">
                                <label for="brand">Brand</label>
                                <input id="brand" autocomplete="off" placeholder="Search brand.." class="browser-default search search_input" type="text">
                                <i class="material-icons">arrow_drop_down</i>
                                <ul class="search-list">
                                    <?=GlobalHelper::all_brand_for_search()?>
                                </ul>
                            </div>
                            <div class="search-select-style">
                                <label for="model">Model</label>
                                <input id="model" autocomplete="off" placeholder="Search model.." class="browser-default search search_input" type="text">
                                <i class="material-icons">arrow_drop_down</i>
                                <ul class="search-list">
                                    <?=GlobalHelper::all_model_for_search()?>
                                </ul>
                            </div>
                        </div>
                        <ul class="collapsible expandable search_post_collapsible-wrap">
                            <li class="<?=!empty($_GET['from_year']) || !empty($_GET['to_year']) ? 'active':''?>">
                                <div class="collapsible-header">Year</div>
                                <div class="collapsible-body search_post_collapsible-body">
                                    <div class="year-filter">
                                        <div class="filter-dropdown">
                                            <div class="select-dropdown-year d-flex align-items-center color-seconday">
                                                <span class="select-value"> Min</span>
                                                <span class="material-icons">
                                                        expand_more
                                                    </span>
                                            </div>
                                            <div class="dropdown">
                                                <input placeholder="Search.." class="browser-default search" type="text">
                                                <ul class="scrollbar search-list-year">
                                                    <li><a href="<?=search_link_builder($this->input->get(),'from_year', 0)?>">Min</a></li>
                                                    <?=GlobalHelper::yearRange_for_search()?>
                                                </ul>
                                            </div>
                                        </div>

                                        <span class="to">to</span>
                                        <div class="filter-dropdown">
                                            <div class="select-dropdown-year d-flex align-items-center color-seconday">
                                                <span class="select-value"> Max</span>
                                                <span class="material-icons">
                                                        expand_more
                                                    </span>
                                            </div>
                                            <div class="dropdown">
                                                <input placeholder="Search.." class="browser-default search" type="text">
                                                <ul class="scrollbar search-list-year">
                                                    <li><a href="<?=search_link_builder($this->input->get(),'to_year', 0)?>">Max</a></li>
                                                    <?=GlobalHelper::yearRange_for_search('to_year')?>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </li>
                            <li class="<?=!empty($_GET['price_from']) || !empty($_GET['price_to']) ? 'active':''?>">
                                <div class="collapsible-header">Price</div>
                                <div class="collapsible-body search_post_collapsible-body">
                                    <div class="year-filter">
                                        <div class="filter-dropdown">
                                            <div class="select-dropdown-year d-flex align-items-center color-seconday">
                                                <span class="select-value"> Min</span>
                                                <span class="material-icons">
                                                        expand_more
                                                    </span>
                                            </div>
                                            <div class="dropdown">
                                                <div class="search-list">
                                                    <input placeholder="Search.." class="browser-default search"
                                                        type="text">
                                                </div>
                                                <ul class="scrollbar search-list-year">
                                                    <li><a href="<?=search_link_builder($this->input->get(),'price_from', 0)?>">Min</a></li>
                                                    <?=GlobalHelper::get_price_for_search(1000000, 10000000, 100000, 'price_from')?>
                                                </ul>
                                            </div>
                                        </div>

                                        <span class="to">to</span>
                                        <div class="filter-dropdown">
                                            <div class="select-dropdown-year d-flex align-items-center color-seconday">
                                                <span class="select-value"> Max</span>
                                                <span class="material-icons">
                                                        expand_more
                                                    </span>
                                            </div>
                                            <div class="dropdown">
                                                <div class="search-list">
                                                    <input placeholder="Search.." class="browser-default search"
                                                        type="text">
                                                </div>
                                                <ul class="scrollbar search-list-year">
                                                    <li><a href="<?=search_link_builder($this->input->get(),'price_to', 0)?>">Max</a></li>
                                                    <?=GlobalHelper::get_price_for_search(1000000, 10000000, 100000, 'price_to')?>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                            </li>
                        </ul>
                        <?php if (in_array($vehicle_type_id, [1, 3])) {?>
                            <h3 class="post-card-title">Style</h3>
                            <div class="post-card-wrap bg-none">
                                <div class="search-select-style">
                                    <label for="transmission">Transmission</label>
                                    <input id="transmission" autocomplete="off" placeholder="Search transmission..." class="browser-default search search_input" type="text">
                                    <i class="material-icons">arrow_drop_down</i>
                                    <ul class="search-list">
                                        <?=GlobalHelper::transmission_for_search()?>
                                    </ul>
                                </div>
                                <div class="search-select-style">
                                    <label for="engine">Engine</label>
                                    <input id="engine" autocomplete="off" placeholder="Search engine..." class="browser-default search search_input" type="text">
                                    <i class="material-icons">arrow_drop_down</i>
                                    <ul class="search-list">
                                        <?=GlobalHelper::engine_search_for_search()?>
                                    </ul>
                                </div>
                                <div class="search-select-style">
                                    <label for="fuel_type">Fuel Type</label>
                                    <input id="fuel_type" autocomplete="off" placeholder="Search Fuel Type..." class="browser-default search search_input" type="text">
                                    <i class="material-icons">arrow_drop_down</i>
                                    <ul class="search-list">
                                        <?=GlobalHelper::fuel_type_for_search()?>
                                    </ul>
                                </div>
                                <div class="search-select-style">
                                    <label for="color">Color</label>
                                    <input id="color" autocomplete="off" placeholder="Search color..." class="browser-default search search_input" type="text">
                                    <i class="material-icons">arrow_drop_down</i>
                                    <ul class="search-list">
                                        <?=GlobalHelper::color_for_search()?>
                                    </ul>
                                </div>
                                
                            </div>
                        <?php } ?>
                    </div>
                </aside>
            </div>
            <div class="col-xl-9 col-lg-8 col-12">
                <h1 class="fs-24 fw-500 mb-15"><?=$meta_title?></h1>
                <div class="search_post-filter-wrap">
                    <?php
                    $end_page_count = !empty($this->input->get('page')) ? $this->input->get('page') * 30 : 30;
                    if ($end_page_count > $total){
                        $end_page_count = $total;
                    }
                    ?>
                    <h2 class="fs-16 fw-500 color-seconday mb-0">Showing From <?=!empty($this->input->get('page')) ? ($this->input->get('page')-1) * 30 : 0?> To <?=$end_page_count?> of <?=number_format($total)?> Results</h2>
                    <div class="search_post-filter">
                        <div class="dropdown-profile shortby" data-target="dropdown">
                            Sort By
                            <i class="material-icons">arrow_drop_down</i>
                        </div>
                        <ul class="search_post_collapsible-filter dropdown-content" id="dropdown">
                            <?php echo GlobalHelper::get_short_for_search()?>
                        </ul>
                        <button class="btnStyle btnStyleOutline waves-effect"><a href="<?='buy-import/'.$this->uri->segment(2). '/'.$this->uri->segment(3)?>">Refresh Listing</a> </button>
                    </div>
                </div>
                <div class="row">

                    <?php
                    //                    $post_slug = $this->uri->segment(2);
                    //                    echo Modules::run('posts/posts_frontview/getPosts', $post_slug );
                    echo $html;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- search_post-area end  -->

<!--<div class="other_cars-area bg-grey pt-75 pb-45 mb-75">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-12 col-lg-3 col-md-6">-->
<!--                <div class="other_cars-wrap">-->
<!--                    <h4>Other Type of Camry</h4>-->
<!--                    <ul class="other_cars-list">-->
<!--                        <li><a href="#">Toyota Camry 2012 XLE</a></li>-->
<!--                        <li><a href="#">Toyota Camry 2008 LE</a></li>-->
<!--                        <li><a href="#">Toyota Camry 2012 XLE</a></li>-->
<!--                        <li><a href="#">Toyota Camry 2008 LE</a></li>-->
<!--                        <li><a href="#">Toyota Camry 2012 XLE</a></li>-->
<!--                        <li><a href="#">Toyota Camry 2008 LE</a></li>-->
<!--                        <li><a href="#">Toyota Camry 2012 XLE</a></li>-->
<!--                        <li><a href="#">Toyota Camry 2008 LE</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-12 col-lg-3 col-md-6">-->
<!--                <div class="other_cars-wrap">-->
<!--                    <h4>Similar Cars</h4>-->
<!--                    <ul class="other_cars-list">-->
<!--                        <li><a href="#">Honda Accord </a></li>-->
<!--                        <li><a href="#">Hyundai Sonata</a></li>-->
<!--                        <li><a href="#"> Kia Optima</a></li>-->
<!--                        <li><a href="#">Suzuki</a></li>-->
<!--                        <li><a href="#">GAC</a></li>-->
<!--                        <li><a href="#">Innoson</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-12 col-lg-3 col-md-6">-->
<!--                <div class="other_cars-wrap">-->
<!--                    <h4>Popular Cities for Toyota Camry</h4>-->
<!--                    <ul class="other_cars-list">-->
<!--                        <li><a href="#">Lagos </a></li>-->
<!--                        <li><a href="#">Abeokuta</a></li>-->
<!--                        <li><a href="#"> Port Harcourt</a></li>-->
<!--                        <li><a href="#">Abuja</a></li>-->
<!--                        <li><a href="#">Maiduguri</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-12 col-lg-3 col-md-6">-->
<!--                <div class="other_cars-wrap">-->
<!--                    <h4>Other Cars by Toyota</h4>-->
<!--                    <ul class="other_cars-list">-->
<!--                        <li><a href="#">4 Runner</a></li>-->
<!--                        <li><a href="#">Avalon</a></li>-->
<!--                        <li><a href="#">Highlander</a></li>-->
<!--                        <li><a href="#">Corolla</a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


<script>
    $('.search-select-style').on('click',function(){
        $(this).toggleClass('active');
    })
    $(".search-select-style ul li").each((id, elem) => {
        if($(elem).hasClass('active')){
            $(elem).parents('.search-select-style').find('.search_input').val($(elem).text())
        }
    });
    $(".search").on("keyup", function () {
        let value = $(this).val().toLowerCase();
        $(this).parent('.search-select-style').find(".search-list li").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $('.search_post-tabs li a').on('click', function () {
        $('.search_post-tabs li a').removeClass('active');
        $(this).addClass('active');
    })

    
    $(document).on('click', '.search_post-form li .select-dropdown', function () {
        $(this).parent('.search_post-form li').toggleClass('active');
        $('.backdrop-body').show()
        $(".search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".search-list li").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    })
    $('.search-list li a').on('click', function () {
        let selectText = $(this).text();
        $('.search-list li a').removeClass('selected')
        $(this).addClass('selected')
        $(this).parents('.search_post-form li').find('.select-value').text(selectText)
    })
    $(document).ready(function (){
        $('.search-list li a').each(function (e, i){
            if ($(i).hasClass('selected')){
                $(i).parents('.search_post-form li').find('.select-value').text($(i).text())
            }

        })

        $('.search-list-year li a').each(function (e, i){
            if ($(i).hasClass('selected')){
                $(i).parents('.filter-dropdown').find('.select-value').text($(i).text())
            }

        })
    })
    $(document).on('click', '.search_post-form li .select-dropdown-year', function () {
        $(this).parent('.filter-dropdown').toggleClass('active');
        $('.backdrop-body').show()
        $(".search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".search-list li").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    })

    $('.search-list-year li a').on('click', function () {
        let selectText = $(this).text();
        $('.search-list-year li a').removeClass('selected')
        $(this).addClass('selected')
        $(this).parents('.filter-dropdown').find('.select-value').text(selectText)
    })

    $(document).on('click', '.backdrop-body', function () {
        $('.search_post-form li').removeClass('active');
        $('.filter-dropdown').removeClass('active');
        $(this).hide()
    })
    $(document).on('click', '.select-dropdown-year', function () {
        $(this).parent('.filter-dropdown').toggleClass('active');
        $('.backdrop-body').show()
        $(".search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".search-list-year li").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    })

    $(".checkedAll").change(function () {
        if (this.checked) {
            $(this).parents('.search_post_collapsible-body').find(".checkSingle").each(function () {
                this.checked = true;
            })
        } else {
            $(this).parents('.search_post_collapsible-body').find(".checkSingle").each(function () {
                this.checked = false;
            })
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;
            $(this).parents('.search_post_collapsible-body').find(".checkSingle").each(function () {
                if (!this.checked)
                    isAllChecked = 1;
            })
            if (isAllChecked == 0) { $(".checkedAll").prop("checked", true); }
        } else {
            $(".checkedAll").prop("checked", false);
        }
    });


    $('#condition-used-selector').on('click', function (){
        $('#condition-used-field').removeClass('d-none');
        $('#condition-used-field').addClass('show');
    })

    $('.search-list-show-extra').on('click', function () {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')){
            $(this).prev().css({'height' : 'auto'});
            $(this).text('Show Less')
        } else {
            $(this).prev().css({'height' : '200px'});
            $(this).text('Show More')
        }

    })
</script>
