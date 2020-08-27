<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
$page_id=15;
if (!isset($_GET['achknow_id'])) {
    header("location:serverview.php");
}
$achknow_id = $_GET['achknow_id'];
$sql = "SELECT * FROM tbl_project_achknow WHERE achknow_id='$achknow_id'";
$result = $cn->selectdb($sql);
if ($cn->numRows($result) > 0) {
    $row = $cn->fetchAssoc($result);
} else {
    header("location:pro_achknow_view.php");
}
?>
<?php
if (isset($_POST['Submit'])) {
    $project = $_POST['txtProject'];
    $desc = $_POST['txtDesc'];
    $datepart = explode('/', $_POST['txtDate']);
    $date = $datepart[2]."-".$datepart[0]."-".$datepart[1];
    $stime = $_POST['txtSTime'];
    $etime = $_POST['txtETime'];

    $sql = "UPDATE tbl_project_achknow SET shipper_id='" . $project . "', description='".$desc."', work_date='".$date."', work_stime='".$stime."', work_etime='".$etime."', uname='".$_SESSION['user']."' WHERE achknow_id='" . $achknow_id . "'";
    //echo $sql;
    $cn->insertdb($sql);
    header("location:pro_achknow_view.php");
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
    <link href="assets/libs/tablesaw/tablesaw.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="assets/libs/switchery/switchery.min.css" rel="stylesheet" />
    <link href="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-datepicker/bootstrap-datepicker.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <script src="assets/libs/ckeditor/ckeditor.js"></script>
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
                    <h4 class="page-title-main"> Project Work</h4>
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
                <form class="form-horizontal" autocomplete="off" role="form" method="post" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">Add Work</h4>
                                    <div class="row">
                                      <div class="col-12">
                                          <div class="p-2">
                                              <form class="form-horizontal" role="form" method="post">
                                                  
                                                  <div class="form-group row">
                                                      <label class="col-sm-2  col-form-label" for="txtProject">Project Name</label>
                                                      <div class="col-sm-10">
                                                        <select name="txtProject" id="txtProject" class="form-control">
                                                        <?php
                                                            $sql="SELECT S.shipper_id,S.shipper_name FROM tbl_shipper as S, tbl_project_allocate AS P WHERE S.shipper_id=P.shipper_id AND P.uname='".$_SESSION['user']."'";
                                                            $result = $cn->selectdb($sql);
                                                            while ($row1=$cn->fetchAssoc($result)) {
                                                        ?>
                                                            <option value="<?php echo $row1['shipper_id'];?>" <?php if($row['shipper_id']==$row1['shipper_id']) echo "selected";?>><?php echo $row1['shipper_name'];?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                        </select>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label class="col-sm-2  col-form-label" for="txtDesc">Description</label>
                                                      <div class="col-sm-10">
                                                          <textarea type="text" name="txtDesc" class="form-control" placeholder="Description"><?php echo $row['description'];?></textarea>
                                                           <script>
                                                            CKEDITOR.replace('txtDesc');
                                                          </script>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label class="col-sm-2  col-form-label" for="datepicker">Date</label>
                                                      <div class="col-sm-10">
                                                          <div class="input-group">
                                                                <input type="text" class="form-control" name="txtDate" placeholder="mm/dd/yyyy" id="datepicker" value="<?php echo date('m/d/Y', strtotime($row['work_date'])); ?>">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="ti-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label class="col-sm-2  col-form-label" for="timepicker2">Start Time</label>
                                                      <div class="col-sm-10">
                                                          <div class="input-group">
                                                            <input id="timepicker2" name ="txtSTime" type="text" class="form-control" value="<?php echo $row['work_stime'];?>">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                                            </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label class="col-sm-2  col-form-label" for="timepicker22">End Time</label>
                                                      <div class="col-sm-10">
                                                          <div class="input-group">
                                                            <input id="timepicker22" name="txtETime" type="text" class="form-control" value="<?php echo $row['work_etime'];?>">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                                            </div>
                                                        </div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                      <div class="col-sm-10">
                                                          <button type="submit" class="btn btn-primary width-md" name="Submit">Update</button>
                                                          <a href="pro_achknow_view.php" class="btn btn-lighten-primary waves-effect waves-primary width-md">Cancel</a>
                                                      </div>
                                                  </div>
                                              </form>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- end row -->
                                </div> <!-- end card-box -->
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div> <!-- container-fluid -->
                </form>
            </div> <!-- content -->
            <?php
            include 'footer.php';
            ?>
            <script src="assets/js/vendor.min.js"></script>
            <!-- Vendor js -->
            <script src="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
            <script src="assets/libs/switchery/switchery.min.js"></script>
            <script src="assets/libs/multiselect/jquery.multi-select.js"></script>
            <script src="assets/libs/jquery-quicksearch/jquery.quicksearch.min.js"></script>
            <script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
            <script src="assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>
            <script src="assets/libs/moment/moment.js"></script>
            <script src="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
            <script src="assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
            <script src="assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
            <script src="assets/libs/bootstrap-daterangepicker/daterangepicker.js"></script>
            <script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
            <script src="assets/js/pages/form-advanced.init.js"></script>
            <script src="assets/libs/toastr/toastr.min.js"></script>

            <!-- Tablesaw js -->
            <!-- App js -->
            <script src="assets/js/app.min.js"></script>
            <script>
                jQuery("#timepicker22").timepicker({
                    showMeridian: !1,
                    icons: {
                        up: "mdi mdi-chevron-up",
                        down: "mdi mdi-chevron-down"
                    }
                });
            </script>

</body>

</html>
