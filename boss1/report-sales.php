<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
if ($_SESSION['control'] != "admin") {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
include_once("image_lib_rname.php");
$cn = new connect();
$cn->connectdb();
$page_id=19;
?>
<?php
    $sdate = date('Y-m-d', strtotime("-5 months", strtotime(date('Y-m-01'))));
    $Months = array();
    $Total = array();
    for ($i=0; $i < 6; $i++) { 
        $edate = date('Y-m-d', strtotime("+1 months -1day", strtotime($sdate)));
        $ed = getdate(strtotime($sdate));
        $sql = "SELECT sum(net_amount) TotalSales FROM tbl_booking WHERE booking_date>='".$sdate."' AND booking_date<='".$edate."' GROUP BY MONTH(booking_date)";
        $result = $cn->selectdb($sql);
        if($cn->numRows($result)>0){
            $row = $cn->fetchAssoc($result);
            $TotalSales = $row['TotalSales'];
        }else{
            $TotalSales = 0;
        }
        array_push($Months, "\"".$ed['month']."\"");
        array_push($Total, $TotalSales);
        $sdate = date('Y-m-d', strtotime("+1 months", strtotime($sdate)));
    }
    $Months = implode(',', $Months);
    $Total = implode(',', $Total);
    /*echo "<br><br>";
    print_r($Months);
    echo "<br><br>";
    print_r($Total);*/
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>ICED Infotech</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <div class="navbar-custom">
                <!-- LOGO -->
                <div class="logo-box">
                    <a href="index.html" class="logo text-center">
                        <span class="logo-lg">
                            <img src="assets/images/logo-dark.png" alt="" height="16">
                            <!-- <span class="logo-lg-text-light">Xeria</span> -->
                        </span>
                        <span class="logo-sm">
                            <!-- <span class="logo-sm-text-dark">X</span> -->
                            <img src="assets/images/logo-sm.png" alt="" height="24">
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile disable-btn waves-effect">
                            <i class="fe-menu"></i>
                        </button>
                    </li>

                    <li>
                        <h4 class="page-title-main">Sales Report</h4>
                    </li>
        
                </ul>
            </div>
            <!-- end Topbar -->

            <?php include 'menu.php';?>

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card-box">
                                    <h4 class="header-title mt-0 mb-3">Last 6 month Sales</h4>

                                    <div class="chartjs-chart">
                                        <canvas id="lineChart" height="125"></canvas>
                                    </div>

                                </div>
                            </div><!-- end col-->
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->

                </div> <!-- content -->

                <?php include 'footer.php';?>

            </div>

        </div>
        <!-- END wrapper -->

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>
        
        <!-- Chart JS -->
        <script src="assets/libs/chart-js/Chart.bundle.min.js"></script>

        <!-- Init js -->
        <!--script src="assets/js/pages/chartjs.init.js"></script-->

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
        <script>
            var ctx = document.getElementById("lineChart").getContext('2d');
            var data = {
                  labels: [<?php echo $Months;?>],
                  datasets: [{
                      label: "Sales Analytics",
                      fill: false,
                      lineTension: 0.1,
                      backgroundColor: "#10c469",
                      borderColor: "#10c469", // The main line color
                      borderCapStyle: 'square',
                      borderDash: [], // try [5, 15] for instance
                      borderDashOffset: 0.0,
                      borderJoinStyle: 'miter',
                      pointBorderColor: "black",
                      pointBackgroundColor: "white",
                      pointBorderWidth: 1,
                      pointHoverRadius: 8,
                      pointHoverBackgroundColor: "yellow",
                      pointHoverBorderColor: "brown",
                      pointHoverBorderWidth: 2,
                      pointRadius: 4,
                      pointHitRadius: 10,
                      // notice the gap in the data and the spanGaps: true
                      data:  [<?php echo $Total;?>],
                      spanGaps: true,
                    }, 
                  ]
                };

                // Notice the scaleLabel at the same level as Ticks
                var options = {
                  scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                },
                                scaleLabel: {
                                     display: true,
                                     labelString: 'Total Sales',
                                     fontSize: 20 
                                  }
                            }],
                            xAxes: [{
                                ticks: {
                                    beginAtZero:true
                                },
                                scaleLabel: {
                                     display: true,
                                     labelString: 'Months',
                                     fontSize: 20 
                                  }
                            }]   
                        }  
                };

                // Chart declaration:
                var myBarChart = new Chart(ctx, {
                  type: 'line',
                  data: data,
                  options: options
                });
        </script>
    </body>
</html>