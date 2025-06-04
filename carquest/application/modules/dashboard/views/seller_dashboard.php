
    <h2 class="breadcumbTitle">Dashboard</h2>
    <!-- featured-area start  -->
    <div class="row">
        <div class="col-xl-4 col-lg-6 col-md-6 col-12">
            <div style="background: linear-gradient(180deg, #F5941E 0%, #F05C26 100%);" class="featured-wrap">
                        <span class="featured-icon">
                            <img src="assets/theme/new/images/backend/featured/sell.svg" alt="image">
                        </span>
                <div class="featured-content">
                    <h4>Sell</h4>
                    <h2><?php echo  $totalSell?></h2>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-12">
            <div style="background:linear-gradient(180deg, #104B94 0%, #011A39 100%)" class="featured-wrap">
                        <span class="featured-icon">
                            <img src="assets/theme/new/images/backend/featured/email.svg" alt="image">
                        </span>
                <div class="featured-content">
                    <h4>Email</h4>
                    <h2><?php echo $email; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-12">
            <div style="background:linear-gradient(180deg, #F5DD38 0%, #FC9631 100%)" class="featured-wrap">
                        <span class="featured-icon">
                            <img src="assets/theme/new/images/backend/featured/post.svg" alt="image">
                        </span>
                <div class="featured-content">
                    <h4>Total Post</h4>
                    <h2><?php echo $totalPost;  ?></h2>
                </div>
                <div class="featured-text">
                    <p>Active Post- <?php echo  $totalActive ?></p>
                    <p>Pending Post- <?php echo $totalPending ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- featured-area end  -->
    <!-- overview area start -->
    <div class="card-wrap">
        <h3>Post Overview</h3>
        <div class="post-overview" id="post_overview"> </div>
    </div>
    <!-- overview area end -->

    <!-- upcomming-overview-area start -->
    <div class="card-wrap-style-two">
        <h3>Up Coming Expire Post</h3>
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Post Title</th>
                    <th>Created at</th>
                    <th>Expired at</th>
                    <th>Remaing Days</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $sl = 0;
                    foreach ($upComoingExpire as $ex_post): $sl++;
                ?>
                <tr>
                    <td><?php  echo $sl;  ?></td>
                    <td><?php echo $ex_post->title;  ?></td>
                    <td><?php echo $ex_post->created ?></td>
                    <td><?php echo $ex_post->expiry_date ?></td>
                    <td><?php echo ((strtotime($ex_post->expiry_date ) - strtotime(date('Y-m-d'))) / 86400) ?></td>
                </tr>
                    <?php  endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- upcomming-overview-area end -->

<script type="text/javascript" src="assets/theme/new/js/highcharts.js"></script>
<script>
    Highcharts.chart('post_overview', {
        chart: {
            type: 'spline',
            height: '350px',
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
                    color: '#676B79',
                    fontSize: '14px',
                    fontWeight: "400",
                }
            },
            lineColor: '#EAEAF5',
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
            gridLineColor: '#DCE0EE',
            gridLineWidth: 1,
            labels: {
                style: {
                    color: '#676B79',
                    fontSize: '14px',
                    fontWeight: "400",
                }
            }
        },

        tooltip: {
            className: 'heighChartTooltip',
            headerFormat: '<h4 className="tooltipTitle">{point.key}</h4><ul className="chatTooltip">',
            pointFormat: '<li><span style="color:{series.color};padding:0">{series.name}: </span>' +
                '<span style="padding:0"><b>{point.y:.1f} $</b></span></li>',
            footerFormat: '</ul>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            spline: {
                lineWidth: 2,
                states: {
                    hover: {
                        lineWidth: 2
                    }
                },
            }
        },
        colors: ['#FFD000'],
        series: [{
            name: 'Total Post',
            data: <?php echo $chart_data; ?>,
            shadow: {
                color: 'rgba(103, 103, 103, 0.25)',
                offsetX: 3,
                offsetY: 5,
                opacity: '.1',
                width: 5
            },
        }, ],
    });
</script>