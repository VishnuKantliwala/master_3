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
$cn = new connect();
$cn->connectdb();
$page_id=12;
if (!isset($_GET['companyId'])) {
    header("location:companyview.php");
}
$companyId = $_GET['companyId'];
$sql = "SELECT * FROM tbl_company WHERE companyId='$companyId'";
$result = $cn->selectdb($sql);
if ($cn->numRows($result) > 0) {
    $row = $cn->fetchAssoc($result);
} else {
    header("location:companyview.php");
}
?>
<?php
if (isset($_POST['Submit'])) {
    $name = $_POST['txtName'];
    $address = $_POST['txtAddress'];
    $gst = $_POST['txtGST'];
    $sql = "UPDATE tbl_company SET CompanyName='" . $name . "', CompanyAddress='" . $address . "', CompanyGstNo='" . $gst . "' WHERE companyId='" . $companyId . "'";
    //echo $sql;
    $cn->insertdb($sql);
    header("location:companyview.php");
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
    <link href="assets/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
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
                    <h4 class="page-title-main">Company</h4>
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
                            <div class="card-box">
                                <h4 class="m-t-0 header-title">Update Company</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtName">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" required name="txtName" class="form-control" placeholder="Name" value="<?php echo $row['CompanyName']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtAddress">Address</label>
                                                    <div class="col-sm-10">
                                                        <textarea required placeholder="Address" class="form-control" rows="5" name="txtAddress"><?php echo $row['CompanyAddress']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtGST">GST No</label>
                                                    <div class="col-sm-10">
                                                        <input required type="text" placeholder="Mobile" name="txtGST" value="<?php echo $row['CompanyGstNo']; ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary width-md" name="Submit">Update</button>
                                                        <a href="companyview.php" class="btn btn-lighten-primary waves-effect waves-primary  width-md">Cancel</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div> <!-- end card-box -->
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- container-fluid -->
            </div> <!-- content -->
            <?php
            include 'footer.php';
            ?>

            <!-- Vendor js -->
            <script src="assets/js/vendor.min.js"></script>
            <script src="assets/libs/dropify/dropify.min.js"></script>
            <script src="assets/js/pages/form-fileupload.init.js"></script>
            <!-- App js -->
            <script src="assets/js/app.min.js"></script>

</body>

</html>