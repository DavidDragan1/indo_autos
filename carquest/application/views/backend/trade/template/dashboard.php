<ul class="post_info-tabs dashboard-tabs tabs">
    <li class="tab">
        <a class="active" href="#dashboard">Dashboard</a>
    </li>
    <li class="tab">
        <a href="#reporting">Reporting</a>
    </li>
</ul>
<div id="dashboard">
    <div class="row">
        <div class="col-xl-3 col-6">
            <div class="featured-card d-flex align-items-center bg-white br-5 p-30 mb-30">
                <img class="icon" src="assets/new-theme//images/icons/car-color.svg" alt="">
                <div class="content">
                    <span class="fs-18 d-flex">Car</span>
                    <h5 class="fw-500"><?= $totalCar ?></h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-6">
            <div class="featured-card d-flex align-items-center bg-white br-5 p-30 mb-30">
                <img class="icon" src="assets/new-theme//images/icons/bike-color.svg" alt="">
                <div class="content">
                    <span class="fs-18 d-flex">Motorbike</span>
                    <h5 class="fw-500"><?= $totalMotorbike ?></h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-6">
            <div class="featured-card d-flex align-items-center bg-white br-5 p-30 mb-30">
                <img class="icon" src="assets/new-theme/images/icons/parts.svg" alt="">
                <div class="content">
                    <span class="fs-18 d-flex">Spare Parts</span>
                    <h5 class="fw-500"><?= $totalParts ?></h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-6">
            <a class="featured-card waves-effect bg-theme_black br-5 p-30 mb-30 d-block text-center color-white"
               href="admin/posts/create">
                        <span class="material-icons plus-icon">
                            add_circle_outline
                        </span>
                <span class="d-block">Post New Advert</span>
            </a>
        </div>
    </div>


    <!-- chart area  -->
    <div class="bg-white br-5 p-30 mb-50 products-statistics-wrap">
        <div class="d-flex flex-wrap align-items-center mb-30">
            <h4 class="fs-18 mb-0 fw-500">Products Statistics</h4>
            <ul class="d-flex filter-list">
                <li class="active">Total Post Per Month</li>
            </ul>
        </div>
        <div id="products_statistics"></div>
    </div>
    <!-- chart area  -->
    <!-- Recently Adverts area  -->
    <h2 class="fs-18 fw-500 mb-25">Recently Posted Adverts</h2>
    <div class="recently-post-slider mb-40">
        <?php
        foreach ($latestPost as $k => $post) {
            ?>
            <div class="recently-wrap bg-white br-5 hidden">
                <a class="image" href="post/<?= $post->post_slug ?>">
                    <?= GlobalHelper::getPostFeaturedPhoto($post->id, 'medium', '', 'obj-cover w-100', $post->title) ?>
                </a>
                <div class="content p-20">
                    <a class="title fs-16 fw-500 mb-5 d-inline-block color-text"
                       href="post/<?= $post->post_slug ?>"><?= $post->title ?></a>
                    <h6 class="fs-16 fw-500 mb-0"><?= GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) ?></h6>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- Recently Adverts area  -->

    <!-- All Adverts  -->
    <div class="bg-white br-5 p-30 mb-50 products-statistics-wrap">
        <div class="d-flex flex-wrap align-items-center mb-30 justify-content-between">
            <h4 class="fs-18 mb-0 fw-500">All Adverts</h4>
            <a class="d-inline-flex align-items-center see-all-btn" href="admin/posts">See All <span
                        class="material-icons">
                            keyboard_arrow_right
                        </span></a>
        </div>
        <table id="all_adverts" class="table-wrapper ">
            <thead>
            <tr>
                <th class="all">Name</th>
                <th class="desktop desktop-1">Type</th>
                <th class="desktop desktop-1">Date Posted</th>
                <th class="desktop">Date Sold</th>
                <th class="desktop desktop-1">Status</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($latestPost as $k => $post) {
                $text = 'success';
                if ($post->status == 'Active') {
                    $text = 'info';
                } elseif ($post->status == 'Inactive') {
                    $text = 'danger';
                } elseif ($post->status == 'Pending') {
                    $text = 'warning';
                } else {
                    $text = 'success';
                }
                ?>
                <tr>
                    <td><a class=" fw-500" href="post/<?=$post->post_slug?>"><?= $post->title ?></a></td>
                    <td><?= $post->name ?></td>
                    <td><?= date_format(date_create($post->created), 'd-m-Y') ?></td>
                    <td><?= $post->sold_date==null?'':date_format(date_create($post->sold_date), 'd-m-Y') ?></td>
                    <td class="fw-500 text-<?= $text ?>"><?= $post->status ?></td>
                    <td class="fw-500 color-theme"><?= GlobalHelper::getPrice($post->priceinnaira, $post->priceindollar, $post->pricein) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- All Adverts  -->
</div>

<div id="reporting">
    <div class="row">
        <div class="col-xl-6 col-12">
            <div class="bg-white br-5 p-30 mb-30 products-statistics-wrap">
                <div class="d-flex flex-wrap align-items-center mb-30 justify-content-between">
                    <h4 class="fs-18 mb-0 fw-500">Views</h4>
                    <ul class="d-flex flex-wrap align-items-center filter_list">
                        <li>Year
                            <ul class="filter-dropdown view-year">
                                <?=numericDropDown_li_a('2010', date('Y'), 1, date('Y'), true, "onclick=\"changeChart(this,'view', 'year')\"")?>
                            </ul>
                        </li>
                        <li>Month
                            <ul class="filter-dropdown view-month">
                                <?=month_to_li_a(0, "onclick=\"changeChart(this,'view', 'month')\"")?>
                            </ul>
                        </li>
                        <li>Week
                            <ul class="filter-dropdown view-week">
                                <?=week_to_li_a(0, "onclick=\"changeChart(this,'view', 'week')\"")?>
                            </ul>
                        </li>
                        <li>Export <span class="material-icons">arrow_drop_down</span>
                            <ul class="filter-dropdown">
                                <li onclick="exportData('view', 'csv')">Export as CSV</li>
                                <li onclick="exportData('view', 'xls')">Export as Excel</li>
                                <li onclick="exportData('view', 'png')">Export as PNG</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="view"></div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="bg-white br-5 p-30 mb-30 products-statistics-wrap">
                <div class="d-flex flex-wrap align-items-center mb-30 justify-content-between">
                    <h4 class="fs-18 mb-0 fw-500">Impressions</h4>
                    <ul class="d-flex flex-wrap align-items-center filter_list">
                        <li>Year
                            <ul class="filter-dropdown impressions-year">
                                <?=numericDropDown_li_a('2010', date('Y'), 1, date('Y'), true, "onclick=\"changeChart(this,'impressions', 'year')\"")?>
                            </ul>
                        </li>
                        <li>Month
                            <ul class="filter-dropdown impressions-month">
                                <?=month_to_li_a(0, "onclick=\"changeChart(this,'impressions', 'month')\"")?>
                            </ul>
                        </li>
                        <li>Week
                            <ul class="filter-dropdown impressions-week">
                                <?=week_to_li_a(0, "onclick=\"changeChart(this,'impressions', 'week')\"")?>
                            </ul>
                        </li>
                        <li>Export <span class="material-icons">arrow_drop_down</span>
                            <ul class="filter-dropdown">
                                <li onclick="exportData('impressions', 'csv')">Export as CSV</li>
                                <li onclick="exportData('impressions', 'xls')">Export as Excel</li>
                                <li onclick="exportData('impressions', 'png')">Export as PNG</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="impressions"></div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="bg-white br-5 p-30 mb-30 products-statistics-wrap">
                <div class="d-flex flex-wrap align-items-center mb-30 justify-content-between">
                    <h4 class="fs-18 mb-0 fw-500">Vehicle Sold</h4>
                    <ul class="d-flex flex-wrap align-items-center filter_list">
                        <li>Year
                            <ul class="filter-dropdown sold-year">
                                <?=numericDropDown_li_a('2010', date('Y'), 1, date('Y'), true, "onclick=\"changeChart(this,'sold', 'year')\"")?>
                            </ul>
                        </li>
                        <li>Month
                            <ul class="filter-dropdown sold-month">
                                <?=month_to_li_a(0, "onclick=\"changeChart(this,'sold', 'month')\"")?>
                            </ul>
                        </li>
                        <li>Week
                            <ul class="filter-dropdown sold-week">
                                <?=week_to_li_a(0, "onclick=\"changeChart(this,'sold', 'week')\"")?>
                            </ul>
                        </li>
                        <li>Export <span class="material-icons">arrow_drop_down</span>
                            <ul class="filter-dropdown">
                                <li onclick="exportData('sold', 'csv')">Export as CSV</li>
                                <li onclick="exportData('sold', 'xls')">Export as Excel</li>
                                <li onclick="exportData('sold', 'png')">Export as PNG</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="sold"></div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="bg-white br-5 p-30 mb-30 products-statistics-wrap">
                <div class="d-flex flex-wrap align-items-center mb-30 justify-content-between">
                    <h4 class="fs-18 mb-0 fw-500">Mails</h4>
                    <ul class="d-flex flex-wrap align-items-center filter_list">
                        <li>Year
                            <ul class="filter-dropdown mails-year">
                                <?=numericDropDown_li_a('2010', date('Y'), 1, date('Y'), true, "onclick=\"changeChart(this,'mails', 'year')\"")?>
                            </ul>
                        </li>
                        <li>Month
                            <ul class="filter-dropdown mails-month">
                                <?=month_to_li_a(0, "onclick=\"changeChart(this,'mails', 'month')\"")?>
                            </ul>
                        </li>
                        <li>Week
                            <ul class="filter-dropdown mails-week">
                                <?=week_to_li_a(0, "onclick=\"changeChart(this,'mails', 'week')\"")?>
                            </ul>
                        </li>
                        <li>Export <span class="material-icons">arrow_drop_down</span>
                            <ul class="filter-dropdown">
                                <li onclick="exportData('mails', 'csv')">Export as CSV</li>
                                <li onclick="exportData('mails', 'xls')">Export as Excel</li>
                                <li onclick="exportData('mails', 'png')">Export as PNG</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="mails"></div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="bg-white br-5 p-30 mb-30 products-statistics-wrap">
                <div class="d-flex flex-wrap align-items-center mb-30 justify-content-between">
                    <h4 class="fs-18 mb-0 fw-500">Most Viewed Cars</h4>
                    <ul class="d-flex flex-wrap align-items-center filter_list">
                        <li>Year
                            <ul class="filter-dropdown most_viewed_cars-year">
                                <?=numericDropDown_li_a('2010', date('Y'), 1, date('Y'), true, "onclick=\"changeChart(this,'most_viewed_cars', 'year')\"")?>
                            </ul>
                        </li>
                        <li>Month
                            <ul class="filter-dropdown most_viewed_cars-month">
                                <?=month_to_li_a(0, "onclick=\"changeChart(this,'most_viewed_cars', 'month')\"")?>
                            </ul>
                        </li>
                        <li>Week
                            <ul class="filter-dropdown most_viewed_cars-week">
                                <?=week_to_li_a(0, "onclick=\"changeChart(this,'most_viewed_cars', 'week')\"")?>
                            </ul>
                        </li>
                        <li>Export <span class="material-icons">arrow_drop_down</span>
                            <ul class="filter-dropdown">
                                <li onclick="exportData('most_viewed_cars', 'csv')">Export as CSV</li>
                                <li onclick="exportData('most_viewed_cars', 'xls')">Export as Excel</li>
                                <li onclick="exportData('most_viewed_cars', 'png')">Export as PNG</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div id="most_viewed_cars"></div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/new-theme/js/slick.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/highcharts.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/dataTables.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/datatable.responsive.min.js?t=<?php echo time(); ?>"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>
    // $('.filter-list li').on('click', function () {
    //     $('.filter-list li').removeClass('active');
    //     $(this).addClass('active')
    // })


    $(function () {
        'use strict';
        (function (factory) {
            if (typeof module === 'object' && module.exports) {
                module.exports = factory;
            } else {
                factory(Highcharts);
            }
        }(function (Highcharts) {
            (function (H) {
                H.wrap(H.seriesTypes.column.prototype, 'translate', function (proceed) {
                    const options = this.options;
                    const topMargin = options.topMargin || 0;
                    const bottomMargin = options.bottomMargin || 0;

                    proceed.call(this);

                    H.each(this.points, function (point) {
                        if (options.borderRadiusTopLeft || options.borderRadiusTopRight || options.borderRadiusBottomRight || options.borderRadiusBottomLeft) {
                            const w = point.shapeArgs.width;
                            const h = point.shapeArgs.height;
                            const x = point.shapeArgs.x;
                            const y = point.shapeArgs.y;

                            let radiusTopLeft = H.relativeLength(options.borderRadiusTopLeft || 0, w);
                            let radiusTopRight = H.relativeLength(options.borderRadiusTopRight || 0, w);
                            let radiusBottomRight = H.relativeLength(options.borderRadiusBottomRight || 0, w);
                            let radiusBottomLeft = H.relativeLength(options.borderRadiusBottomLeft || 0, w);

                            const maxR = Math.min(w, h) / 2

                            radiusTopLeft = radiusTopLeft > maxR ? maxR : radiusTopLeft;
                            radiusTopRight = radiusTopRight > maxR ? maxR : radiusTopRight;
                            radiusBottomRight = radiusBottomRight > maxR ? maxR : radiusBottomRight;
                            radiusBottomLeft = radiusBottomLeft > maxR ? maxR : radiusBottomLeft;

                            point.dlBox = point.shapeArgs;

                            point.shapeType = 'path';
                            point.shapeArgs = {
                                d: [
                                    'M', x + radiusTopLeft, y + topMargin,
                                    'L', x + w - radiusTopRight, y + topMargin,
                                    'C', x + w - radiusTopRight / 2, y, x + w, y + radiusTopRight / 2, x + w, y + radiusTopRight,
                                    'L', x + w, y + h - radiusBottomRight,
                                    'C', x + w, y + h - radiusBottomRight / 2, x + w - radiusBottomRight / 2, y + h, x + w - radiusBottomRight, y + h + bottomMargin,
                                    'L', x + radiusBottomLeft, y + h + bottomMargin,
                                    'C', x + radiusBottomLeft / 2, y + h, x, y + h - radiusBottomLeft / 2, x, y + h - radiusBottomLeft,
                                    'L', x, y + radiusTopLeft,
                                    'C', x, y + radiusTopLeft / 2, x + radiusTopLeft / 2, y, x + radiusTopLeft, y,
                                    'Z'
                                ]
                            };
                        }

                    });
                });
            }(Highcharts));
        }));


        Highcharts.chart('products_statistics', {
            chart: {
                type: 'column',
                height: '350px',
                borderRadius: 5
            },
            title: false,
            xAxis: {
                gridLineColor: '#DCE0EE',
                gridLineDashStyle: 'solid',
                gridLineWidth: 0,
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec',
                ],
                crosshair: true,
                labels: {
                    style: {
                        color: '#C4C4C4',
                        fontSize: '14px',
                        fontWeight: "400",
                    }
                },
                lineColor: '#fff',
                lineWidth: 1,
            },
            legend: {
                enabled: false,
                itemStyle: {
                    color: "#676B79",
                    fontSize: "14px",
                    fontWeight: "400",
                },

                itemHoverStyle: {
                    color: "#0171F5",
                },
            },
            yAxis: {
                min: 0,
                title: false,
                gridLineColor: '#DBDBDB',
                gridLineDashStyle: 'longdash',
                gridLineWidth: .5,
                labels: {
                    style: {
                        color: '#C4C4C4',
                        fontSize: '14px',
                        fontWeight: "400",
                    }
                }
            },

            tooltip: {
                className: 'heighChartTooltip',
                headerFormat: '<h6 className="tooltipTitle">{point.key}</h6><ul className="chatTooltip">',
                pointFormat: '<li><span style="color:{series.color};padding:0">{series.name}: </span>' +
                    '<span style="padding:0"><b>{point.y:.1f}</b></span></li>',
                footerFormat: '</ul>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    grouping: false,
                    borderRadiusTopLeft: 5,
                    borderRadiusTopRight: 5
                }
            },
            colors: ['#F05C26'],
            series: [
                {
                    name: 'Total',
                    data: JSON.parse('<?=$chart_data?>'),
                    shadow: {
                        color: 'rgba(103, 103, 103, 0.25)',
                        offsetX: 3,
                        offsetY: 5,
                        opacity: '.1',
                        width: 5
                    },
                },
            ],
        });

        Highcharts.chart('view', {
            chart: {
                type: 'column',
                height: '280px',
                borderRadius: 5
            },
            title: false,
            xAxis: {
                gridLineColor: '#DCE0EE',
                gridLineDashStyle: 'solid',
                gridLineWidth: 0,
                categories: JSON.parse('<?=json_encode($view['key'])?>'),
                crosshair: true,
                labels: {
                    style: {
                        color: '#C4C4C4',
                        fontSize: '14px',
                        fontWeight: "400",
                    }
                },
                lineColor: '#fff',
                lineWidth: 1,
            },
            legend: {
                enabled: false,
                itemStyle: {
                    color: "#676B79",
                    fontSize: "14px",
                    fontWeight: "400",
                },

                itemHoverStyle: {
                    color: "#0171F5",
                },
            },
            yAxis: {
                min: 0,
                title: false,
                gridLineColor: '#DBDBDB',
                gridLineDashStyle: 'longdash',
                gridLineWidth: .5,
                labels: {
                    style: {
                        color: '#C4C4C4',
                        fontSize: '14px',
                        fontWeight: "400",
                    }
                }
            },

            tooltip: {
                className: 'heighChartTooltip',
                headerFormat: '<h6 className="tooltipTitle">{point.key}</h6><ul className="chatTooltip">',
                pointFormat: '<li><span style="color:{series.color};padding:0">{series.name}: </span>' +
                    '<span style="padding:0"><b>{point.y:.1f} $</b></span></li>',
                footerFormat: '</ul>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    grouping: false,
                    borderRadiusTopLeft: 5,
                    borderRadiusTopRight: 5
                }
            },
            colors: ['#F05C26'],
            series: [
                {
                    name: 'View',
                    data: JSON.parse('<?=json_encode($view['data'], JSON_NUMERIC_CHECK)?>'),
                    shadow: {
                        color: 'rgba(103, 103, 103, 0.25)',
                        offsetX: 3,
                        offsetY: 5,
                        opacity: '.1',
                        width: 5
                    },
                },
            ],
        });
        Highcharts.chart('sold', {
            chart: {
                type: 'column',
                height: '280px',
                borderRadius: 5
            },
            title: false,
            xAxis: {
                gridLineColor: '#DCE0EE',
                gridLineDashStyle: 'solid',
                gridLineWidth: 0,
                categories: JSON.parse('<?=json_encode($sold['key'])?>'),
                crosshair: true,
                labels: {
                    style: {
                        color: '#C4C4C4',
                        fontSize: '14px',
                        fontWeight: "400",
                    }
                },
                lineColor: '#fff',
                lineWidth: 1,
            },
            legend: {
                enabled: false,
                itemStyle: {
                    color: "#676B79",
                    fontSize: "14px",
                    fontWeight: "400",
                },

                itemHoverStyle: {
                    color: "#0171F5",
                },
            },
            yAxis: {
                min: 0,
                title: false,
                gridLineColor: '#DBDBDB',
                gridLineDashStyle: 'longdash',
                gridLineWidth: .5,
                labels: {
                    style: {
                        color: '#C4C4C4',
                        fontSize: '14px',
                        fontWeight: "400",
                    }
                }
            },

            tooltip: {
                className: 'heighChartTooltip',
                headerFormat: '<h6 className="tooltipTitle">{point.key}</h6><ul className="chatTooltip">',
                pointFormat: '<li><span style="color:{series.color};padding:0">{series.name}: </span>' +
                    '<span style="padding:0"><b>{point.y:.1f} $</b></span></li>',
                footerFormat: '</ul>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    grouping: false,
                    borderRadiusTopLeft: 5,
                    borderRadiusTopRight: 5
                }
            },
            colors: ['#F05C26'],
            series: [
                {
                    name: 'Impression',
                    data: JSON.parse('<?=json_encode($sold['data'], JSON_NUMERIC_CHECK)?>'),
                    shadow: {
                        color: 'rgba(103, 103, 103, 0.25)',
                        offsetX: 3,
                        offsetY: 5,
                        opacity: '.1',
                        width: 5
                    },
                },
            ],
        });
        Highcharts.chart('mails', {
            chart: {
                type: 'column',
                height: '280px',
                borderRadius: 5
            },
            title: false,
            xAxis: {
                gridLineColor: '#DCE0EE',
                gridLineDashStyle: 'solid',
                gridLineWidth: 0,
                categories: JSON.parse('<?=json_encode($mails['key'])?>'),
                crosshair: true,
                labels: {
                    style: {
                        color: '#C4C4C4',
                        fontSize: '14px',
                        fontWeight: "400",
                    }
                },
                lineColor: '#fff',
                lineWidth: 1,
            },
            legend: {
                enabled: false,
                itemStyle: {
                    color: "#676B79",
                    fontSize: "14px",
                    fontWeight: "400",
                },

                itemHoverStyle: {
                    color: "#0171F5",
                },
            },
            yAxis: {
                min: 0,
                title: false,
                gridLineColor: '#DBDBDB',
                gridLineDashStyle: 'longdash',
                gridLineWidth: .5,
                labels: {
                    style: {
                        color: '#C4C4C4',
                        fontSize: '14px',
                        fontWeight: "400",
                    }
                }
            },

            tooltip: {
                className: 'heighChartTooltip',
                headerFormat: '<h6 className="tooltipTitle">{point.key}</h6><ul className="chatTooltip">',
                pointFormat: '<li><span style="color:{series.color};padding:0">{series.name}: </span>' +
                    '<span style="padding:0"><b>{point.y:.1f} $</b></span></li>',
                footerFormat: '</ul>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    grouping: false,
                    borderRadiusTopLeft: 5,
                    borderRadiusTopRight: 5
                }
            },
            colors: ['#F05C26'],
            series: [
                {
                    name: 'Mail',
                    data: JSON.parse('<?=json_encode($mails['data'], JSON_NUMERIC_CHECK)?>'),
                    shadow: {
                        color: 'rgba(103, 103, 103, 0.25)',
                        offsetX: 3,
                        offsetY: 5,
                        opacity: '.1',
                        width: 5
                    },
                },
            ],
        });
        Highcharts.chart('impressions', {
            chart: {
                type: 'line',
                height: '280px',
                borderRadius: 5
            },
            title: false,
            xAxis: {
                gridLineColor: '#DCE0EE',
                gridLineDashStyle: 'solid',
                gridLineWidth: 0,
                categories: JSON.parse('<?=json_encode($impressions['key'])?>'),
                crosshair: true,
                labels: {
                    style: {
                        color: '#C4C4C4',
                        fontSize: '14px',
                        fontWeight: "400",
                    }
                },
                lineColor: '#fff',
                lineWidth: 1,
            },
            legend: {
                enabled: true,
                itemStyle: {
                    color: "#676B79",
                    fontSize: "14px",
                    fontWeight: "400",
                },

                itemHoverStyle: {
                    color: "#0171F5",
                },
            },
            yAxis: {
                min: 0,
                title: false,
                gridLineColor: '#DBDBDB',
                gridLineDashStyle: 'longdash',
                gridLineWidth: .5,
                labels: {
                    style: {
                        color: '#C4C4C4',
                        fontSize: '14px',
                        fontWeight: "400",
                    }
                }
            },

            tooltip: {
                className: 'heighChartTooltip',
                headerFormat: '<h6 className="tooltipTitle">{point.key}</h6><ul className="chatTooltip">',
                pointFormat: '<li><span style="color:{series.color};padding:0">{series.name}: </span>' +
                    '<span style="padding:0"><b>{point.y:.1f} $</b></span></li>',
                footerFormat: '</ul>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    grouping: false,
                }
            },
            colors: ['#20B038', '#F05C26'],
            series: [
                {
                    name: 'Impressions',
                    data: JSON.parse('<?=json_encode($impressions['data'], JSON_NUMERIC_CHECK)?>'),
                    shadow: {
                        color: 'rgba(103, 103, 103, 0.25)',
                        offsetX: 3,
                        offsetY: 5,
                        opacity: '.1',
                        width: 5
                    },
                }
            ],
        });
        Highcharts.chart('most_viewed_cars', {
            chart: {
                height: '280px',
                type: 'pie'
            },
            title: false,
            tooltip: {
                className: 'heighChartTooltip',
                headerFormat: '<h6 className="tooltipTitle">{point.key}</h6><ul className="chatTooltip">',
                pointFormat: '<li><span style="color:{series.color};padding:0">{series.name}: </span>' +
                    '<span style="padding:0"><b>{point.y:.1f}</b></span></li>',
                footerFormat: '</ul>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    colors: ['#F05C26', '#DDA019', '#0E538C'],
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b><br><b>{point.y:.1f}</b><br> {point.percentage:.1f} %',
                        distance: -50,
                    }
                }
            },
            series: [{
                name: 'Cars Views',
                data: JSON.parse('<?=json_encode($most_viewed_cars['data'], JSON_NUMERIC_CHECK)?>')
            }]
        });
    });


    $('.recently-post-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: false,
        focusOnSelect: true,
        arrows: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $(document).ready(function () {
        $('#all_adverts').dataTable({
            bPaginate: false,
            bInfo : false,
            processing: false,
            searching: false,
            ordering: false,
            responsive: true,
            bSort: false,
            order: [0, 'asc'],
        });
    });
    function changeChart(e, section, selection) {

        $('.'+section+'-'+selection+' .active').removeClass('active');
        $(e).addClass('active');

        var year = $('.'+section+'-year .active').data('year');
        var month = $('.'+section+'-month .active').data('month');
        var week = $('.'+section+'-week .active').data('week');

        if (week) {
            if (!month){
                alert('Please select Month')
                return false;
            }
        }

        jQuery.ajax({
            url: 'admin/dashboard/report',
            type: "POST",
            dataType: "json",
            cache: false,
            data: {
                year, month, week, section
            },
            beforeSend: function(){

            },
            success: function( jsonData ){
                var chart = jsonData;

                if (section == 'impressions'){

                    Highcharts.chart('impressions', {
                        chart: {
                            type: 'line',
                            height: '280px',
                            borderRadius: 5
                        },
                        title: false,
                        xAxis: {
                            gridLineColor: '#DCE0EE',
                            gridLineDashStyle: 'solid',
                            gridLineWidth: 0,
                            categories: chart.key,
                            crosshair: true,
                            labels: {
                                style: {
                                    color: '#C4C4C4',
                                    fontSize: '14px',
                                    fontWeight: "400",
                                }
                            },
                            lineColor: '#fff',
                            lineWidth: 1,
                        },
                        legend: {
                            enabled: true,
                            itemStyle: {
                                color: "#676B79",
                                fontSize: "14px",
                                fontWeight: "400",
                            },

                            itemHoverStyle: {
                                color: "#0171F5",
                            },
                        },
                        yAxis: {
                            min: 0,
                            title: false,
                            gridLineColor: '#DBDBDB',
                            gridLineDashStyle: 'longdash',
                            gridLineWidth: .5,
                            labels: {
                                style: {
                                    color: '#C4C4C4',
                                    fontSize: '14px',
                                    fontWeight: "400",
                                }
                            }
                        },

                        tooltip: {
                            className: 'heighChartTooltip',
                            headerFormat: '<h6 className="tooltipTitle">{point.key}</h6><ul className="chatTooltip">',
                            pointFormat: '<li><span style="color:{series.color};padding:0">{series.name}: </span>' +
                                '<span style="padding:0"><b>{point.y:.1f} $</b></span></li>',
                            footerFormat: '</ul>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                grouping: false,
                            }
                        },
                        colors: ['#20B038', '#F05C26'],
                        series: [
                            {
                                name: 'Impressions',
                                data: chart.data,
                                shadow: {
                                    color: 'rgba(103, 103, 103, 0.25)',
                                    offsetX: 3,
                                    offsetY: 5,
                                    opacity: '.1',
                                    width: 5
                                },
                            }
                        ],
                    });
                } else if (section == 'most_viewed_cars'){
                    Highcharts.chart('most_viewed_cars', {
                        chart: {
                            height: '280px',
                            type: 'pie'
                        },
                        title: false,
                        tooltip: {
                            className: 'heighChartTooltip',
                            headerFormat: '<h6 className="tooltipTitle">{point.key}</h6><ul className="chatTooltip">',
                            pointFormat: '<li><span style="color:{series.color};padding:0">{series.name}: </span>' +
                                '<span style="padding:0"><b>{point.y:.1f}</b></span></li>',
                            footerFormat: '</ul>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                colors: ['#F05C26', '#DDA019', '#0E538C'],
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b><br><b>{point.y:.1f}</b><br> {point.percentage:.1f} %',
                                    distance: -50,
                                }
                            }
                        },
                        series: [{
                            name: 'Cars Views',
                            data: chart.data
                        }]
                    });
                }else {
                    Highcharts.chart(section, {
                        chart: {
                            type: 'column',
                            height: '280px',
                            borderRadius: 5
                        },
                        title: false,
                        xAxis: {
                            gridLineColor: '#DCE0EE',
                            gridLineDashStyle: 'solid',
                            gridLineWidth: 0,
                            categories: chart.key,
                            crosshair: true,
                            labels: {
                                style: {
                                    color: '#C4C4C4',
                                    fontSize: '14px',
                                    fontWeight: "400",
                                }
                            },
                            lineColor: '#fff',
                            lineWidth: 1,
                        },
                        legend: {
                            enabled: false,
                            itemStyle: {
                                color: "#676B79",
                                fontSize: "14px",
                                fontWeight: "400",
                            },

                            itemHoverStyle: {
                                color: "#0171F5",
                            },
                        },
                        yAxis: {
                            min: 0,
                            title: false,
                            gridLineColor: '#DBDBDB',
                            gridLineDashStyle: 'longdash',
                            gridLineWidth: .5,
                            labels: {
                                style: {
                                    color: '#C4C4C4',
                                    fontSize: '14px',
                                    fontWeight: "400",
                                }
                            }
                        },

                        tooltip: {
                            className: 'heighChartTooltip',
                            headerFormat: '<h6 className="tooltipTitle">{point.key}</h6><ul className="chatTooltip">',
                            pointFormat: '<li><span style="color:{series.color};padding:0">{series.name}: </span>' +
                                '<span style="padding:0"><b>{point.y:.1f} $</b></span></li>',
                            footerFormat: '</ul>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                grouping: false,
                                borderRadiusTopLeft: 5,
                                borderRadiusTopRight: 5
                            }
                        },
                        colors: ['#F05C26'],
                        series: [
                            {
                                name: 'View',
                                data: chart.data,
                                shadow: {
                                    color: 'rgba(103, 103, 103, 0.25)',
                                    offsetX: 3,
                                    offsetY: 5,
                                    opacity: '.1',
                                    width: 5
                                },
                            },
                        ],
                    });
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                tosetrMessage('success', XMLHttpRequest);
            }
        });
    }

    function exportData(selector, format) {
        var chart = $('#'+ selector).highcharts();
        if (format == 'xls'){
            chart.downloadXLS();
        } if (format == 'csv'){
            chart.downloadCSV();
        } if (format == 'png'){
            chart.exportChart()
        }


    }
</script>
