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
$page_id=21;
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
                    <h4 class="page-title-main">Renewal Report</h4>
                </li>
            </ul>
        </div>
        <!-- end Topbar -->
        <?php
        include 'menu.php';
        ?>

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                            	<h4 class="m-t-0 header-title">Renewal </h4>
                              <h4 class="m-t-0 header-title">From : </h4><?php echo $_POST['start'];?><h4 class="m-t-0 header-title"> To : </h4><?php echo $_POST['end'];?><br><br>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                      <thead>
                                          <tr>
                                              <th>Booking Date</th>
                                              <th>Customer Name</th>
                                              <th>Mobile No.</th>
                                              <th>Email-ID</th>
                                              <th>Service Name</th>
                                              <th>Duration</th>
                                              <th>Renew Amount</th>
                                          </tr>
                                      </thead>
                                      <tfoot>
                                          <tr>
                                              <th>Booking Date</th>
                                              <th>Customer Name</th>
                                              <th>Mobile No.</th>
                                              <th>Email-ID</th>
                                              <th>Service Name</th>
                                              <th>Duration</th>
                                              <th>Renew Amount</th>
                                          </tr>
                                      </tfoot>
                                      <tbody>
<?php
$datepart=explode('/', $_POST['start']);
$SDate = $datepart[2].'-'.$datepart[0].'-'.$datepart[1];
$datepart=explode('/', $_POST['end']);
$EDate = $datepart[2].'-'.$datepart[0].'-'.$datepart[1];
$addQuery = "";
if(!isset($_POST['chkCustomer'])){
    $addQuery.=" AND SH.shipper_id=".$_POST['txtShipperID'];
}
if(!isset($_POST['chkService'])){
    $addQuery.= " AND P.product_id=".$_POST['txtService'];
}

$start = date_parse_from_format("Y-m-d", date($SDate));
$end = date_parse_from_format("Y-m-d",date($EDate));

$sDate = DateTime::createFromFormat('m-d', $start['month']."-".$start['day']);
$eDate = DateTime::createFromFormat('m-d', $end['month']."-".$end['day']);

$sql = "SELECT B.booking_date,B.shipper_code,S.duration,S.yorm,P.name,SH.shipper_name,SH.shipper_email,SH.shipper_mobile,S.renew_amt FROM tbl_booking AS B, tbl_servicelist AS S, tbl_product AS P, tbl_shipper AS SH WHERE B.booking_id = S.booking_id AND B.shipper_code = SH.shipper_id AND S.product_id = P.product_id".$addQuery;
//echo $sql."<br>";
  $result = $cn->selectdb($sql);
  while ($row = $cn->fetchAssoc($result)) {
    if($row['yorm'] == "Month"){
      $bdate = date_parse_from_format("Y-m-d",date('Y-m-d', strtotime("+".$row['duration']." months", strtotime($row['booking_date']))));
    }else{
      $n = $row['duration']*12;
      $bdate = date_parse_from_format("Y-m-d",date('Y-m-d', strtotime("+".$n." months", strtotime($row['booking_date']))));
    }
    $bdate = date_parse_from_format("Y-m-d", $row['booking_date']);
    $date = DateTime::createFromFormat('m-d', $bdate['month']."-".$bdate['day']);
    //print_r($date);
    if($sDate->format('md') <= $date->format('md') AND $eDate->format('md') >= $date->format('md')){
       // print_r($row);
        //echo "<br>";
?>
                                                  <tr>
                                                      <td><?php echo $row['booking_date']; ?></td>
                                                      <td><?php echo $row['shipper_name']; ?></td>
                                                      <td><?php echo $row['shipper_mobile'];?></td>
                                                      <td><?php echo $row['shipper_email'];?></td>
                                                      <td><?php echo $row['name'];?></td>
                                                      <td><?php echo $row['duration'];?>&nbsp;<?php echo $row['yorm'];?></td>
                                                      <td><?php echo $row['renew_amt'];?></td>
                                                  </tr>
<?php
      }
    }
?>
                                      </tbody>
                                  </table>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div> <!-- container-fluid -->
            </div> <!-- content -->
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

            <!-- App js -->
            <script src="assets/js/app.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#datatable').DataTable();
                });
            </script>
</body>

</html>
