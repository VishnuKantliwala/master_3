<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
$page_id=17;
$sql = "SELECT count(B.booking_id) AS TotalCount, A.attendant_name FROM tbl_booking AS B, tbl_attendant AS A WHERE B.attendant_id = A.attendant_id GROUP BY A.attendant_id";
$result = $cn->selectdb($sql);
$str = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
if($cn->numRows($result)>0){
    $n = $cn->numRows($result);
    $colors = array();
    for ($i=0; $i < $n; $i++) { 
        $d = "\"#";
        for ($j=0; $j < 6; $j++) { 
            $k = rand(0,15);
            $d.=$str[$k];
        }
        $d .= "\"";
        //echo $d;
        if(in_array($d, $colors)){
            $j--;
        }else{
            array_push($colors, $d);
        }
    }
    $colors = implode(',', $colors);
    $projects = array();
    $attendants = array();
    $i=0;
    while ($row = $cn->fetchAssoc($result)) {
        array_push($projects, "\"".$row['TotalCount']."\"");
        array_push($attendants, "\"".$row['attendant_name']."\"");
    }
    $projects = implode(',', $projects);
    $attendants = implode(',', $attendants);
}
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
                    <a href="index.php" class="logo text-center">
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
                        <h4 class="page-title-main">Attendant Report</h4>
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
                                    <h4 class="header-title mt-0 mb-3">Attendant wise Project Report</h4>
                                    <div class="chartjs-chart">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <canvas id="doughnut" height="300"></canvas>
                                            </div>
                                        </div>
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

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        <script>
            var ctx = document.getElementById("doughnut").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [<?php echo $attendants;?>],
                    datasets: [{
                        backgroundColor: [<?php echo $colors;?>],
                        data: [<?php echo $projects;?>],
                        hoverBackgroundColor: [<?php echo $colors;?>],
                        hoverBorderColor: "#fff"
                    }]
                }
            });
        </script>
    </body>
</html>