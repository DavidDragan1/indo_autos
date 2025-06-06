<style>
    .text-primary{
        color: #007bff!important;
    }
</style>
<h2 class="fs-18 fw-500 mb-25">Dashboard</h2>
<!-- featured area  -->
<div class="row">
    <div class="col-xl-3 col-md-6 col-12">
        <div class="featured-card d-flex align-items-center bg-white br-5 p-15 mb-30">
            <img class="icon" src="assets/new-theme/images/icons/car-color.svg" alt="" />
            <div class="content">
                <span class="fs-18 d-flex">All Requests</span>
                <h5 class="fw-500 text-center"><?=$totalRequest?></h5>
            </div>
        </div>
    </div>
</div>
<!-- featured area  -->
<div class="bg-white br-5 p-30 mb-30 products-statistics-wrap shadow">
    <div class="d-flex flex-wrap align-items-center mb-30 justify-content-between">
        <h4 class="fs-18 mb-0 fw-500">Requests</h4>
        <ul class="d-flex flex-wrap align-items-center filter_list">
            <li>Year
                <ul class="filter-dropdown total_application-year">
                    <?=numericDropDown_li_a('2010', date('Y'), 1, date('Y'), true, "onclick=\"changeChart(this,'total_application', 'year')\"")?>
                </ul>
            </li>
            <li>Month
                <ul class="filter-dropdown total_application-month">
                    <?=month_to_li_a(0, "onclick=\"changeChart(this,'total_application', 'month')\"")?>
                </ul>
            </li>
            <li>Week
                <ul class="filter-dropdown total_application-week">
                    <?=week_to_li_a(0, "onclick=\"changeChart(this,'total_application', 'week')\"")?>
                </ul>
            </li>
            <li>Export <span class="material-icons">arrow_drop_down</span>
                <ul class="filter-dropdown">
                    <li onclick="exportData('total_application', 'csv')">Export as CSV</li>
                    <li onclick="exportData('total_application', 'xls')">Export as Excel</li>
                    <li onclick="exportData('total_application', 'png')">Export as PNG</li>
                </ul>
            </li>
        </ul>
    </div>
    <div id="total_application"></div>
</div>
<!-- All Adverts  -->

<h2 class="fs-18 fw-500 mb-25">Recent Requests</h2>
<div class="recently-post-slider mb-40">
    <?php if ($recentRequest):?>
        <?php foreach ($recentRequest as $row) : ?>
            <div class="recently-wrap bg-white br-5 hidden">
                <a class="image" href="javascript:void(0)">
                    <?=GlobalHelper::getPostFeaturedPhoto($row->post_id, 'featured', null, 'obj-cover w-100','Don\'t Need')?>
                </a>
                <div class="content p-20">
                    <a
                            class="title fs-16 fw-500 mb-5 d-inline-block color-text"
                            href="javascript:void(0)">
                        <?=GlobalHelper::getBrandNameById($row->brand_id).' '.GlobalHelper::getModelNameById($row->model_id).' '.$row->manufacture_year?>
                    </a>
                    <h6 class="fs-16 fw-500 mb-0"><?=GlobalHelper::getPrice($row->amount, 0, 'NGR')?></h6>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif;?>
</div>
<!-- Recently Adverts area  -->

<!-- All Adverts  -->
<div class="bg-white br-5 p-30 mb-50 products-statistics-wrap">
    <div class="d-flex flex-wrap align-items-center mb-30 justify-content-between">
        <h4 class="fs-18 mb-0 fw-500">Verification Requests</h4>
        <a class="d-inline-flex align-items-center see-all-btn" href="admin/verifier/all_request">See All <span class="material-icons"> keyboard_arrow_right </span></a>
    </div>
    <table id="all_adverts" class="table-wrapper text-center">
            <thead>
            <tr>
                <th class="all text-center">Name</th>
                <th class="desktop desktop-1 text-center">Type</th>
                <th class="desktop desktop-1 text-center ">Date Requested</th>
                <th class="desktop desktop-1 text-center">Date Verified</th>
                <th class="desktop desktop-1 text-center">Status</th>
                <th class="text-center">Amount</th>
            </tr>
            </thead>
            <tbody>
                <?php if ($recentRequest):?>
                <?php foreach ($recentRequest as $row):
                        $class = '';
                        if ($row->status == 'Pending'){
                            $class = 'text-primary';
                        } elseif ($row->status == 'Verified'){
                            $class = 'text-success';
                        } elseif ($row->status == 'Rejected'){
                            $class = 'text-danger';
                        } else {
                            $class = 'text-info';
                        }
                        ?>
                    <tr <?php if ($row->is_read == 0):?> style="background: #ededed" <?php endif;?>>
                        <td><a class="fw-500 modal-trigger" href="#customerDetails<?=$row->id?>" onclick="changeReadStatus(<?php echo $row->id;?>,<?php echo $row->is_read;?>)"><?=GlobalHelper::getBrandNameById($row->brand_id).' '.GlobalHelper::getModelNameById($row->model_id).' '.$row->manufacture_year?></a></td>
                        <td><?=GlobalHelper::getVehicleNamebyId($row->vehicle_type_id)?></td>
                        <td><?=date('j/n/y', strtotime($row->request_date))?></td>
                        <td><?=$row->verification_date ? date('j/n/y', strtotime($row->verification_date)):'-'?></td>
                        <td class="fw-500  <?php echo $class; ?>"><?=$row->status?></td>
                        <td class="fw-500 color-theme"><?=GlobalHelper::getPrice($row->amount, 0, 'NGR')?>
                            <?php if ($row->is_read == 0):?>
                                <span style="color: #999;font-size: 10px;">new</span>
                            <?php endif;?>
                        </td>

                    </tr>
                    <div id="customerDetails<?=$row->id?>" class="modal modal-wrapper" style="min-height: 80%;min-width: 700px" >
                            <span class="material-icons modal-close">close</span>
                            <h4 class="fs-18 fw-500 ">Request Details</h4>
                            <p class="mb-15">Vehicle ID:#<?php echo $row->post_id;?></p>
                            <div class="customer_details-wrap d-flex flex-wrap">
                                <div class="customer_details-img">
                                    <?=GlobalHelper::getPostFeaturedPhoto($row->post_id, 'featured', null, '','Don\'t Need')?>
                                </div>
                                <ul class="customer_details-list">
                                    <li>
                                        <span>Amount</span>
                                        <h4 class="fs-16 fw-500 color-theme mb-0"><?=GlobalHelper::getPrice($row->amount, 0, 'NGR')?></h4>
                                    </li>
                                    <li>
                                        <span class="d-block">Status</span>
                                        <span class="<?php echo $class; ?> color-white br-5"><?=$row->status?></span>
                                    </li>
                                    <li>
                                        <span>Client Name</span>
                                        <h4 class="fs-16 fw-500 mb-0"><?=$row->client_name?></h4>
                                    </li>
                                    <li>
                                        <span>Brand</span>
                                        <h4 class="fs-16 fw-500 mb-0"><?=GlobalHelper::getBrandNameById($row->brand_id)?></h4>
                                    </li>
                                    <li class="email">
                                        <span>Email</span>
                                        <h4 class="fs-16 fw-500 mb-0"><?=$row->client_email?></h4>
                                    </li>
                                    <li>
                                        <span>Condition</span>
                                        <h4 class="fs-16 fw-500 mb-0"><?=$row->vehicle_condition?></h4>
                                    </li>
                                    <li>
                                        <span>Request Date</span>
                                        <h4 class="fs-16 fw-500 mb-0"><?=$row->request_date ? date('j/n/y', strtotime($row->request_date)):'-'?></h4>
                                    </li>
                                    <li>
                                        <span>Model</span>
                                        <h4 class="fs-16 fw-500 mb-0"><?php echo GlobalHelper::getModelNameById($row->model_id); ?></h4>
                                    </li>
                                    <li>
                                        <span>Verified Date</span>
                                        <h4 class="fs-16 fw-500 mb-0"><?=$row->verification_date ? date('j/n/y', strtotime($row->verification_date)):'-'?></h4>
                                    </li>
                                    <li>
                                        <span>Year</span>
                                        <h4 class="fs-16 fw-500 mb-0"><?=$row->manufacture_year?></h4>
                                    </li>
                                    <li>
                                        <span>Dealer's Phone</span>
                                        <h4 class="fs-16 fw-500 mb-0"><?=$row->dellers_phone?></h4>
                                    </li>
                                    <li>
                                        <span>Vehicle's Location</span>
                                        <h4 class="fs-16 fw-500 mb-0"><?=$row->address.', '.GlobalHelper::getLocationById($row->location_id).', '.getCountryName($row->country_id)?></h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                <?php endforeach;?>
            <?php endif;?>
            </tbody>
        </table>

</div>
<!-- All Adverts  -->
<!--<script type="text/javascript" src="assets/new-theme/js/slick.min.js?t=--><?php //echo time(); ?><!--"></script>-->
<script type="text/javascript" src="assets/new-theme/js/slick.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/dataTables.min.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="assets/new-theme/js/datatable.responsive.min.js?t=<?php echo time(); ?>"></script>
<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="http://code.highcharts.com/modules/offline-exporting.js"></script>
<script src="http://code.highcharts.com/modules/export-data.js"></script>
<script src="http://code.highcharts.com/modules/series-label.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script>
    function changeReadStatus(id, currentStatus){
        if (id != 0 && id != ''){
            if (currentStatus == 0 && currentStatus !=1){

                $.ajax({
                    url: "admin/verifier/change_read_status/"+id,
                    method: 'GET',
                    success: function(){

                    }
                });
            }
        }
    }
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
    Highcharts.chart('total_application', {
        chart: {
            type: 'line',
            height: '280px',
            borderRadius: 5,
        },
        title: false,
        xAxis: {
            gridLineColor: '#DCE0EE',
            gridLineDashStyle: 'solid',
            gridLineWidth: 0,
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            crosshair: true,
            labels: {
                style: {
                    color: '#C4C4C4',
                    fontSize: '14px',
                    fontWeight: '400',
                },
            },
            lineColor: '#fff',
            lineWidth: 1,
        },
        legend: {
            enabled: true,
            itemStyle: {
                color: '#676B79',
                fontSize: '14px',
                fontWeight: '400',
            },

            itemHoverStyle: {
                color: '#0171F5',
            },
        },
        yAxis: {
            min: 0,
            title: false,
            gridLineColor: '#DBDBDB',
            gridLineDashStyle: 'longdash',
            gridLineWidth: 0.5,
            labels: {
                style: {
                    color: '#C4C4C4',
                    fontSize: '14px',
                    fontWeight: '400',
                },
            },
        },

        tooltip: {
            className: 'heighChartTooltip',
            headerFormat: '<h6 className="tooltipTitle">{point.key}</h6><ul className="chatTooltip">',
            pointFormat:
                '<li><span style="color:{series.color};padding:0">{series.name}: </span>' +
                '<span style="padding:0"><b>{point.y:.1f} $</b></span></li>',
            footerFormat: '</ul>',
            shared: true,
            useHTML: true,
        },
        plotOptions: {
            column: {
                grouping: false,
            },
        },
        colors: ['#20B038', '#F05C26'],
        series: [
            {
                name: 'Impressions 1',
                data: [1401, 1450, 3540, 4501, 1450, 6540, 1450, 6541, 3654, 3654, 3245, 4123],
                shadow: {
                    color: 'rgba(103, 103, 103, 0.25)',
                    offsetX: 3,
                    offsetY: 5,
                    opacity: '.1',
                    width: 5,
                },
            },
        ],
    });

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

    $(function () {
        $(document).ready(function () {
            changeChart('', 'total_application', 'year', true)
        })
    })

    function changeChart(e, section, selection, onload = false) {
        if (!onload){
            $('.'+section+'-'+selection+' .active').removeClass('active');
            $(e).addClass('active');
        }


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
            url: 'admin/verifier/report',
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

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                tosetrMessage('success', XMLHttpRequest);
            }
        });
    }

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

</script>
