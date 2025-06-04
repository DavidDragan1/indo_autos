<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Dashboard <small>Report</small> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content" style="min-height: 542px;">
  <div class="row">
    <div class="col-md-3">
      <div class="info-box bg-red"> <span class="info-box-icon"><i class="fa fa-car"></i></span>
        <div class="info-box-content"> <span class="info-box-text">Brand</span> <span class="info-box-number"><?php echo $total_brand; ?></span> </div>
        <!-- /.info-box-content --> 
      </div>
    </div>
    <!-- /.info-box -->
    
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-green"> <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
        <div class="info-box-content"> <span class="info-box-text">Total Post</span> <span class="info-box-number"><?php echo $allHits;  ?></span>
          <div class="progress">
            <div class="progress-bar" style="width: 70%"></div>
          </div>
          <span class="progress-description"> 70% Increase in 30 Days </span> </div>
        <!-- /.info-box-content --> 
      </div>
      <!-- /.info-box --> 
    </div>
    <?php
     $vendor = ($totalVendor / $total_users  ) * 100; 
     $total_User = ($totalUser / $total_users  ) * 100; 
     ?>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-aqua"> <span class="info-box-icon"><i class="fa fa-group"></i></span>
        <div class="info-box-content"> <span class="info-box-text">Vendor</span> <span class="info-box-number"><?php echo $totalVendor; ?></span>
          <div class="progress">
            <div class="progress-bar" style="width: <?php echo $vendor; ?>%"></div>
          </div>
          <span class="progress-description"> <?php echo $vendor; ?>% Increase in 30 Days </span> </div>
        <!-- /.info-box-content --> 
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-yellow"> <span class="info-box-icon"><i class="fa fa-user"></i></span>
        <div class="info-box-content"> <span class="info-box-text">Customer/user</span> <span class="info-box-number"><?php echo $totalUser; ?></span>
          <div class="progress">
            <div class="progress-bar" style="width: <?php echo $total_User; ?>%"></div>
          </div>
          <span class="progress-description"> <?php echo $total_User; ?>% Increase in 30 Days </span> </div>
        <!-- /.info-box-content --> 
      </div>
      <!-- /.info-box --> 
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Last 30 Days Advert Posting Report</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="postChart" style="height:230px"></canvas>
          </div>
        </div>
        <!-- /.box-body --> 
      </div>
    </div>
  </div>
  
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Income Statement</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="chart">
            <canvas id="barChart" style="height:230px"></canvas>
          </div>
        </div>
        <!-- /.box-body --> 
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Up Coming Expire Post</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
         
          <div class="box-body no-padding">
            <table class="table table-striped">
              <tr>
                <th style="width: 10px">#</th>
                <th>Post Title</th>
                <th>Ex Progress</th>
                <th style="width: 40px">Days</th>
              </tr>
              <?php
				$sl 	= 0; 
				foreach ($upComoingExpire as $ex_post): $sl++; 
				$days 	= ((strtotime($ex_post->expiry_date ) - strtotime(date('Y-m-d'))) / 86400);
			  ?>
              <tr>
                <td><?php echo $sl;  ?></td>
                <td><?php echo getShortContent($ex_post->title,40);  ?></td>
                <td><div class="progress progress-xs">
                    <div class="progress-bar progress-bar-danger" style="width:<?php echo ceil($days/100)  ; ?>%"></div>
                  </div></td>
                <td><span class="badge bg-red"><?php echo ceil($days)  ; ?> </span></td>
              </tr>
              <?php endforeach; ?>
            </table>
          </div>
          <!-- /.box-body --> 
          
         
      </div>
    </div>
  </div>
  <div class="row">
                  
        <div class="col-md-6"> 
    
    <!-- DONUT CHART -->
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Vehicle Count By Types</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body chart-responsive">
        <canvas id="pieChart" style="height:250px"></canvas>
      </div>
      <!-- /.box-body --> 
    </div>
  </div>              
  <div class="col-md-6"> 
    
    <!-- DONUT CHART -->
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">Post Condition</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i> </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body chart-responsive">
        <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
      </div>
      <!-- /.box-body --> 
    </div>
  </div>
</div>
  
  <div class="row">
      <div class="col-md-12">
          <div class="box">
              <div class="box-header">
                  <h3 class="box-title">What's up Phone Number Correction List [ Private & Trade Seller Only] </h3>
              </div>
              <div class="box-body">
                  <table class="table table-striped table-bordered">
                      <tr>
                          <th>S/L</th>
                          <th>Name</th>
                          <th>Type</th>
                          <th>Email</th>
                          <th>Primary Contact [01]</th>
                          <th>Add Contact [02]</th>
                          <th>Add Contact [03]</th>
                          <th>Action</th>
                      </tr>
                      <?php foreach($sellers as $seller ) { ?>
                      <tr>
                          <td><?php echo ++$start;?></td>
                          <td><?php echo $seller->first_name .' '. $seller->last_name;?></td>
                          <td><?php echo $s_type[$seller->role_id]; ?></td>
                          <td><?php echo $seller->email;?></td>
                          <td><?php echo $seller->contact;?></td>
                          <td><?php echo $seller->contact1;?></td>
                          <td><?php echo $seller->contact2;?></td>
                          <td>
                              <a href="admin/users/update/<?php echo $seller->id;?>" target="_blank" class="btn btn-xs btn-primary">
                                  <i class="fa fa-external-link"></i>
                                  Details</a>
                          </td>
                      </tr>
                      <?php } ?>
                  </table>
              </div>
              <div class="box-footer text-center">
                  <p><b class="text-red">Total Number Need to Correct: <?php echo $sellers_phone; ?></b><br/>
                      Please Update One by One... More Data Will Come here ... </p>
              </div>
          </div>
      </div>
  </div>
</section>
<!-- /.content --> 

<!-- ChartJS 1.0.1 --> 
<script type="text/javascript" src="assets/lib/plugins/chartjs/Chart.min.js"></script> 
<!-- FastClick --> 
<!-- Morris.js charts --> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script> 
<script type="text/javascript" src="assets/lib/plugins/morris/morris.min.js"></script> 

<!-- page script --> 
<script>
    $(function () {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        var areaChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
                {
                    label: "Electronics",
                    fillColor: "rgba(210, 214, 222, 1)",
                    strokeColor: "rgba(210, 214, 222, 1)",
                    pointColor: "rgba(210, 214, 222, 1)",
                    pointStrokeColor: "#c1c7d1",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [65, 59, 80, 81, 56, 55, 40]
                },
                {
                    label: "Digital Goods",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: [28, 48, 40, 19, 86, 27, 90]
                }
            ]
        };

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        
        var PieData = [
            {
                value: <?php echo $post_qty[1]; ?>,
                color: "#f56954",
                highlight: "#f56954",
                label: "Car"
            },{
                value: <?php echo $post_qty[3]; ?>,
                color: "#00a65a",
                highlight: "#00a65a",
                label: "Motorbike"
            },{
                value: <?php echo $post_qty[2]; ?>,
                color: "#f39c12",
                highlight: "#f39c12",
                label: "Van"
            },{
                value: <?php echo $post_qty[4]; ?>,
                color: "#00c0ef",
                highlight: "#00c0ef",
                label: "Parts"
            },{
                value: <?php echo $post_qty[5]; ?>,
                color: "#3c8dbc",
                highlight: "#3c8dbc",
                label: "Import Car"
            },{
                value: <?php echo $post_qty[6]; ?>,
                color: "#d2d6de",
                highlight: "#d2d6de",
                label: "Auction Cars"
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
        //- BAR CHART -
        //-------------
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = areaChartData;
        barChartData.datasets[1].fillColor = "#00a65a";
        barChartData.datasets[1].strokeColor = "#00a65a";
        barChartData.datasets[1].pointColor = "#00a65a";
        var barChartOptions = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            //Boolean - whether to make the chart responsive
            responsive: true,
            maintainAspectRatio: true
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);






        //-------------
        //- Post CHART -
        //-------------

        var postChartData = {
            labels: <?php echo Modules::run('posts/getChart'); ?>,
            datasets: [
                {
                    label: "Expaired",
                    fillColor: "#dd4b39",
                    strokeColor: "",
                    pointColor: "",
                    pointStrokeColor: "#dd4b39",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#dd4b39",
                    data: <?php echo Modules::run('posts/getChartExpiry'); ?>
                },
                {
                    label: "New Upload",
                    fillColor: "#dd4b39",
                    strokeColor: "#dd4b39",
                    pointColor: "#dd4b39",
                    pointStrokeColor: "#dd4b39",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "#dd4b39",
                    data: <?php echo Modules::run('posts/getChartPost'); ?>
                }
            ]
        };

        var postChartCanvas = $("#postChart").get(0).getContext("2d");
        var postChart = new Chart(postChartCanvas);
        var postChartData = postChartData;
        postChartData.datasets[1].fillColor = "#00a65a";
        postChartData.datasets[1].strokeColor = "";
        postChartData.datasets[1].pointColor = "";
        var postChartOptions = {
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

        postChartOptions.datasetFill = false;
        postChart.Bar(postChartData, postChartOptions);
    });

    //DONUT CHART
        var donut = new Morris.Donut({
        element: 'sales-chart',
        resize: true,
        colors: ["#3c8dbc", "#f56954", "#00a65a"],
        data: [
            {label: "New", value: <?php echo $carNew; ?> },
            {label: "Foreign used", value: <?php echo $carForeignUsed; ?> },
            {label: "Nigerian used", value: <?php echo $carNigerianUsed; ?> }
        ],
        hideHover: 'auto'
    });
</script>