<?php
session_start();
if(!isset($_SESSION['user']))
{
	header("location:Login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn=new connect();
$cn->connectdb();
$page_id=25;

$user_id = $_GET['user_id'];
// Check if any tasks
$query  = "SELECT t.task_name, te.recordListingID, te.task_emp_id, te.date_assign FROM tbl_task AS t, tbl_task_emp AS te WHERE te.user_id = ".$user_id." AND DATEDIFF( te.date_assign , CURDATE()) <=0 ORDER BY te.recordListingID ASC";
$result = $cn->selectdb($query);
if( $cn->numRows($result) <= 0 )
{
    // header("location:assignedTaskview.php");
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
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css -->
    <link href="assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <script src="assets/libs/ckeditor/ckeditor.js"></script>
    <style>
    .form-control {
        padding: 10px;
    }
    </style>
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
                    <h4 class="page-title-main">Assigned Tasks</h4>
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
                        <div class="col-12">
                            <h4 class="mt-0 header-title">Task List</h4>
                            <div class="card-box">
                            <div class="sortable">
                                <?php
															
								while($row = mysqli_fetch_assoc($result))
								{
								?>
                                <div id="recordsArray_<?php echo $row['task_emp_id']; ?>" class="card card-draggable">
                                    <div class="card-body bg-light">
                                        <p class="card-text"><?php echo $row['recordListingID'] . ". " . $row['task_name']; ?> - <? echo $row['date_assign'] ?></p>
                                    </div>
                                </div>
								<?php } ?>
                                
                            </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end content -->
                
            </div>
        </div>

    </div><!-- End page -->


    <?php
    include 'footer.php';
    ?>

            <!-- Vendor js -->
            <script src="assets/js/vendor.min.js"></script>
            <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
            <script src="assets/js/pages/sweet-alerts.init.js"></script>
            <!-- third party js -->
            <script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
            <script src="assets/libs/datatables/dataTables.bootstrap4.js"></script>
            <script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
            <script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>
            <!-- third party js ends -->
            <!-- <script src="assets/libs/select2/select2.min.js"></script> -->
            <script src="assets/libs/multiselect/jquery.multi-select.js"></script>
            <script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
            <script src="assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>
            <script src="assets/libs/moment/moment.js"></script>
            <script src="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
            <script src="assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
            <script src="assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
            <script src="assets/libs/bootstrap-daterangepicker/daterangepicker.js"></script>
            <script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
            <!-- Init js-->
            <script src="assets/js/pages/form-advanced.init.js"></script>
            <!-- App js -->
            <script src="assets/js/app.min.js"></script>

             <!-- sorting -->
            <script type="text/javascript" src="boss-asset/js/jquery-1.3.2.min.js"></script>
            <script type="text/javascript" src="boss-asset/js/jquery-ui-1.7.1.custom.min.js"></script>

            <script type="text/javascript">
                $(document).ready(function(){ 
                    
                    $(function() {
                        $(".sortable").sortable({ opacity: 0.6, cursor: 'move', update: function() {
                            var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
                            $.post("sortAssignedTasks.php", order, function(theResponse){
                                // $(".sortable").html(theResponse);
                            }); 															 
                        }								  
                    });
                });
                

                });	
            </script>
            
            
            <!-- draggable init -->
            <script src="assets/js/pages/draggable.init.js"></script>
            
</body>

</html>