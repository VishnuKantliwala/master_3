<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
$page_id=1;
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
    <!--Morris Chart-->
    <link rel="stylesheet" href="assets/libs/morris-js/morris.css" />
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
                    <h4 class="page-title-main">Daily Tasks</h4>
                </li>

            </ul>
        </div>
        <!-- end Topbar -->
        <?php
        include 'menu.php';
        ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-4">
                            <div class="card-box">
                                <h4 class="header-title">New Tasks</h4>
                                

                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2 new-tasks-result">
                                           
                                        </div>
                                    </div>

                                </div>
                                <!-- end row -->

                            </div> <!-- end card-box -->
                        </div><!-- end col -->

                        <div class="col-4">
                            <div class="card-box">
                                <h4 class="header-title">Running Tasks</h4>                               

                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2 running-tasks-result">
                                           
                                        </div>
                                    </div>

                                </div>
                                <!-- end row -->

                            </div> <!-- end card-box -->
                        </div><!-- end col -->

                        <div class="col-4">
                            <div class="card-box">
                                <h4 class="header-title">Completed Tasks</h4>
                                

                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2 completed-tasks-result">
                                           
                                        </div>
                                    </div>

                                </div>
                                <!-- end row -->

                            </div> <!-- end card-box -->
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->
                    <div id="TaskModal" class="modal fade">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h4 class="modal-title">Task instructions: <span id="task_name"></span></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div style="width:100%;display:block;text-align:center; display:none"
                                    class="taskLoader">
                                    
                                    <img src="./assets/images/loading.gif" />
                                    <br/>
                                </div>
                                <div class="modal-body" id="TaskModalBody">
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div> <!-- container -->
            </div> <!-- content -->
            <?php
            include 'footer.php';
            ?>


            <!-- Vendor js -->
            <script src="assets/js/vendor.min.js"></script>

            <!-- knob plugin -->
            <!--script src="assets/libs/jquery-knob/jquery.knob.min.js"></script-->

            <!--Morris Chart-->
            <!--script src="assets/libs/morris-js/morris.min.js"></script-->
            <!--script src="assets/libs/raphael/raphael.min.js"></script-->

            <!-- Dashboard init js-->
            <!--script src="assets/js/pages/dashboard.init.js"></script-->

            <!-- App js -->
            <script src="assets/js/app.min.js"></script>

            <script src="assets/js/gettasks.js"></script>




</body>

</html>