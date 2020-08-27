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
$page_id=4;
date_default_timezone_set('Asia/Kolkata');
?>
<?php
if (isset($_POST['Submit'])) {
    $name = $_POST['txtName'];
    $pass = base64_encode($_POST['txtPassword']);
    $deg = $_POST['txtDeg'];
    $txtRole = $_POST['txtRole'];
    $txtEmail = $_POST['txtEmail'];
    $txtMobile = $_POST['txtMobile'];
    $dateTime = date("Y/m/d h:i:s");
    $sql = "INSERT INTO `tbl_user`( `role_id`, `user_name`, `user_password`, `user_email`, `user_mobile`, `user_designation`, `user_entry_date`) VALUES ('".$txtRole."','".$name."','".$pass."','".$txtEmail."','".$txtMobile."','".$deg."','".$dateTime."')";
    //echo $sql;
    $cn->insertdb($sql);
    header("location:userview.php");
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
                    <h4 class="page-title-main">Employee</h4>
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
                                <h4 class="m-t-0 header-title">Add Employee</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="post">
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtName">Employee Name</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" required name="txtName" class="form-control" placeholder="Employee Name">
                                                    </div>
                                                    <label class="col-sm-2  col-form-label" for="txtPassword">Password</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" required name="txtPassword" class="form-control" placeholder="Password">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtEmail">Employee Email</label>
                                                    <div class="col-sm-4">
                                                        <input type="email" required name="txtEmail" class="form-control" placeholder="Employee Email">
                                                    </div>
                                                    <label class="col-sm-2  col-form-label" for="txtMobile">Mobile No.</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" required name="txtMobile" class="form-control" placeholder="Mobile No.">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                <?
                                                $sqlRole = $cn->selectdb("SELECT * from tbl_role");
                                                if(mysqli_num_rows($sqlRole) > 0)
                                                {
                                                    ?>
                                                    <label class="col-sm-2  col-form-label" for="txtRole">Role</label>
                                                    <div class="col-sm-4">
                                                        <select name="txtRole" id="txtRole" class="form-control">
                                                            <?
                                                            while($rowRole = mysqli_fetch_assoc($sqlRole))
                                                            {
                                                                ?>
                                                                <option value="<? echo $rowRole['role_id'] ?>"><? echo $rowRole['role_name'] ?></option>
                                                              <?
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <?
                                                }
                                               ?>
                                                    <label class="col-sm-2  col-form-label" for="txtDeg">Designation</label>
                                                    <div class="col-sm-4">
                                                        <select name="txtDeg" id="txtDeg" class="form-control">
                                                              <option value="Director">Director</option>
                                                              <option value="Developer">Developer</option>
                                                              <option value="Marketing">Marketing</option>
                                                              <option value="Designer">Designer</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary width-md" name="Submit">Add</button>
                                                        <a href="userview.php" class="btn btn-lighten-primary waves-effect waves-primary width-md">Cancel</a>
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
</body>

</html>
