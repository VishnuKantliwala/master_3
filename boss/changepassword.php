<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
$page_id=18;
?>
<?php
if (isset($_POST['Submit'])) {
    $old = $_POST['txtOld'];
    $new = $_POST['txtNew'];
    $new1 = $_POST['txtNew1'];
    $user = $_SESSION['user'];
    $sql = "SELECT pwd FROM admintable WHERE uname='$user'";
    $result = $cn->selectdb($sql);
    $row = $cn->fetchAssoc($result);
    if ($old == $row['pwd']) {
        if ($old == $new) {
            $warning = "Old password and new password cannot be same.";
        } else {
            if ($new == $new1) {
                $sql = "UPDATE admintable SET pwd='$new' WHERE uname='$user'";
                $cn->insertdb($sql);
                $success = "Your password has been changed.";
            } else {
                $error = "Passwords do not match.";
            }
        }
    } else {
        $error = "Your old password was incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Milap Trade Link Pvt. Ltd.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Notification css (Toastr) -->
    <link href="assets/libs/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
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
                    <h4 class="page-title-main">Change Password</h4>
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
                                <h4 class="m-t-0 header-title">Update Password</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="post">
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtOld">Old Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" name="txtOld" class="form-control" placeholder="Old Password" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtNew">New Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" placeholder="New Password" name="txtNew" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtNew1">Confirm Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" name="txtNew1" class="form-control" placeholder="Confirm Password" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary width-md" name="Submit">Update</button>
                                                        <a href="index.php" class="btn btn-lighten-primary waves-effect waves-primary  width-md">Cancel</a>
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
            <!-- App js -->
            <script src="assets/js/app.min.js"></script>
            <!-- Toastr js -->
            <script src="assets/libs/toastr/toastr.min.js"></script>
            <?php
            if (isset($error)) {
                echo "<script>toastr.error('" . $error . "')</script>";
            }
            if (isset($success)) {
                echo "<script>toastr.success('" . $success . "')</script>";
            }
            if (isset($warning)) {
                echo "<script>toastr.warning('" . $warning . "')</script>";
            }
            ?>
</body>

</html>