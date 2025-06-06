<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Mails  <small>Report</small> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Mail Report</li>
    </ol>
</section>


<section class="content" style="min-height: 542px;">

    <div class="row">
        <div class="col-md-8">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Last 7 Days Mails Report</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="mailChart" style="height:250px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">

            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-envelope"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Mails</span>
                    <span class="info-box-number"><?php echo 100; //$total_mails; ?></span>
                </div>
            </div>

            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Emails of Different Categories</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <canvas id="pieChartForEmails" style="height:250px"></canvas>
                </div>
            </div>
              

        </div>

    </div>


</section>



<script src="assets/lib/plugins/chartjs/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="assets/lib/plugins/morris/morris.min.js"></script>




<!-- page script -->
<script>
    $(function () {
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChartForEmails").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
            {
                value: 200,
                color: "#f56954",
                highlight: "#f56954",
                label: "Contact Us Request"
            },
            {
                value: 100,
                color: "#00a65a",
                highlight: "#00a65a",
                label: "Newsletter Subscribe"
            },
            {
                value: 50,
                color: "#f39c12",
                highlight: "#f39c12",
                label: "Contact Seller Request"
            },
            {
                value: 50,
                color: "#00c0ef",
                highlight: "#00c0ef",
                label: "Contact Request"
            },
            {
                value: 50,
                color: "#3c8dbc",
                highlight: "#3c8dbc",
                label: "Payment Notification"
            },
            {
                value: 50,
                color: "#d2d6de",
                highlight: "#d2d6de",
                label: "Make An Offer Request"
            }
        ];
        var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);




        //-------------
        //- Post CHART -
        //-------------

        var mailChartData = {
            labels: <?php echo Modules::run('mails/getMailChart');?>,
            datasets: [
                {
                    label: "Contact Us Request",
                    fillColor: "#f56954",
                    strokeColor: "#f56954",
                    pointColor: "#f56954",
                    pointStrokeColor: "#f56954",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#f56954",
                    data: <?php echo Modules::run('mails/getMailRequest','ContactUsRequest');?>
                },
                {
                    label: "Newsletter Subscribe ",
                    fillColor: "#00a65a",
                    strokeColor: "#00a65a",
                    pointColor: "#00a65a",
                    pointStrokeColor: "#00a65a",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#00a65a",
                    data: <?php echo Modules::run('mails/getMailRequest','NewsletterSubscribe');?>
                },
                {
                    label: "Contact Seller Request",
                    fillColor: "#f39c12",
                    strokeColor: "#f39c12",
                    pointColor: "#f39c12",
                    pointStrokeColor: "#f39c12",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#f39c12",
                    data: <?php echo Modules::run('mails/getMailRequest','ContactSellerRequest');?>
                },
                {
                    label: "Contact Request",
                    fillColor: "#00c0ef",
                    strokeColor: "#00c0ef",
                    pointColor: "#00c0ef",
                    pointStrokeColor: "#00c0ef",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#00c0ef",
                    data: <?php echo Modules::run('mails/getMailRequest','ContactRequest');?>
                },
                {
                    label: "Payment Notification",
                    fillColor: "#3c8dbc",
                    strokeColor: "#3c8dbc",
                    pointColor: "#3c8dbc",
                    pointStrokeColor: "#3c8dbc",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#3c8dbc",
                    data: <?php echo Modules::run('mails/getMailRequest','PaymentNotification');?>
                },
                {
                    label: "Make An Offer Request",
                    fillColor: "#d2d6de",
                    strokeColor: "#d2d6de",
                    pointColor: "#d2d6de",
                    pointStrokeColor: "#d2d6de",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#d2d6de",
                    data: <?php echo Modules::run('mails/getMailRequest','MakeAnOfferRequest');?>
                }
            ]
        };

        var postChartCanvas = $("#mailChart").get(0).getContext("2d");
        var postChart = new Chart(postChartCanvas);
        var mailChartData = mailChartData;
        mailChartData.datasets[1].fillColor = "#00a65a";
        mailChartData.datasets[1].strokeColor = "";
        mailChartData.datasets[1].pointColor = "";
        var mailChartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: .5,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 1,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 10,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true
        };

        mailChartOptions.datasetFill = false;
        postChart.Bar(mailChartData,mailChartOptions);
    });



</script>

