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
$page_id=20;
$datepart=explode('/', $_POST['start']);
$SDate = $datepart[2].'-'.$datepart[0].'-'.$datepart[1];
$datepart=explode('/', $_POST['end']);
$EDate = $datepart[2].'-'.$datepart[0].'-'.$datepart[1]." 00:00:01";
$EDate = date('Y-m-d h:i:s', strtotime($EDate. ' + 1 days')); 
if(isset($_POST['chkCompany'])){
    $sql="SELECT D.inquiry_stime,I.company_name,A.attendant_name,I.mobile_no,I.email_id,I.inquiry_status,D.description,D.meeting_document FROM tbl_inquiry AS I, tbl_inquiry_detail AS D, tbl_attendant AS A WHERE I.inquiry_id=D.inquiry_id AND I.attendant_id=A.attendant_id AND D.inquiry_stime>='".$SDate."' AND D.inquiry_etime<='".$EDate."'";
}else{
    $sql="SELECT D.inquiry_stime,I.company_name,A.attendant_name,I.mobile_no,I.email_id,I.inquiry_status,D.description,D.meeting_document FROM tbl_inquiry AS I, tbl_inquiry_detail AS D, tbl_attendant AS A WHERE I.inquiry_id=D.inquiry_id AND I.attendant_id=A.attendant_id AND D.inquiry_stime>='".$SDate."' AND D.inquiry_etime<='".$EDate."' AND I.inquiry_id='".$_POST['txtInquiryID']."'";
}
//echo $sql;

//echo $sql;
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
                    <h4 class="page-title-main">Inquiry Report</h4>
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
                            	<h4 class="m-t-0 header-title">Inquiry Detail </h4>
                                <h4 class="m-t-0 header-title">From : </h4><?php echo $_POST['start'];?><h4 class="m-t-0 header-title"> To : </h4><?php echo $_POST['end'];?><br><br>
                                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                      <thead>
                                          <tr>
                                          	  <th>Date</th>
                                              <th>Company Name</th>
                                              <th>Attendant Name</th>
                                              <th>Mobile No.</th>
                                              <th>Email-ID</th>
                                              <th>Inquiry Status</th>
                                              <th>Decription</th>
                                              <th>Document</th>
                                          </tr>
                                      </thead>
                                      <tfoot>
                                          <tr>
                                              <th>Date</th>
                                              <th>Company Name</th>
                                              <th>Attendant Name</th>
                                              <th>Mobile No.</th>
                                              <th>Email-ID</th>
                                              <th>Inquiry Status</th>
                                              <th>Decription</th>
                                              <th>Document</th>
                                          </tr>
                                      </tfoot>
                                      <tbody>
                                          <?php
                                         //echo $sql;
                                          $result = $cn->selectdb($sql);
                                          if ($cn->numRows($result) > 0) {
                                              while ($row = $cn->fetchAssoc($result)) {
                                          ?>
                                                  <tr>
                                                      <td><?php echo $row['inquiry_stime']; ?></td>
                                                      <td><?php echo $row['company_name']; ?></td>
                                                      <td><?php echo $row['attendant_name']; ?></td>
                                                      <td><?php echo $row['mobile_no']; ?></td>
                                                      <td><?php echo $row['email_id']; ?></td>
                                                      <td><?php echo $row['inquiry_status']; ?></td>
                                                      <td><?php echo $row['description']; ?></td>
                                                      <td>
                                                        <?php
                                                            $files = explode(',',$row['meeting_document']);
                                                            for ($i=0; $i < count($files); $i++) { 
                                                                echo "<br><a href='inquiry/".$files[$i]."' target='_blank'>".$files[$i]."</a>";
                                                            }
                                                        ?>
                                                      </td>
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
