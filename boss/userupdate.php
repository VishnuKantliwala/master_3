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
    $sql = "UPDATE `tbl_user` SET `role_id`='".$txtRole."', `user_name`='".$name."', `user_password`='".$pass."', `user_email`='".$txtEmail."', `user_mobile`='".$txtMobile."', `user_designation`='".$deg."', `user_modification_date`='".$dateTime."' WHERE user_id = ".$_GET['user_id'];
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
                                <h4 class="m-t-0 header-title">Update Employee</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                        <?
                                        $sqlUser = $cn->selectdb("SELECT * FROM tbl_user WHERE user_id = ".$_GET['user_id']);
                                        if(mysqli_num_rows($sqlUser) > 0)
                                        {
                                            $rowUser = mysqli_fetch_assoc($sqlUser);
                                            ?>
                                            
                                            <form class="form-horizontal" role="form" method="post">
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtName">Employee Name</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" required name="txtName" class="form-control" placeholder="Employee Name" value="<?php echo $rowUser['user_name']; ?>">
                                                    </div>
                                                    <label class="col-sm-2  col-form-label" for="txtPassword">Password</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" required name="txtPassword" class="form-control" placeholder="Password" value="<?php echo base64_decode($rowUser['user_password']); ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtEmail">Employee Email</label>
                                                    <div class="col-sm-4">
                                                        <input type="email" required name="txtEmail" class="form-control" placeholder="Employee Email" value="<?php echo $rowUser['user_email']; ?>">
                                                    </div>
                                                    <label class="col-sm-2  col-form-label" for="txtMobile">Mobile No.</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" required name="txtMobile" class="form-control" placeholder="Mobile No." value="<?php echo $rowUser['user_mobile']; ?>">
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
                                                                <option value="<? echo $rowRole['role_id'] ?>" <?php if($rowUser['role_id']==$rowRole['role_id']) echo "selected";?>><? echo $rowRole['role_name'] ?></option>
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
                                                             <option value="Director" <?php if($rowUser['user_designation']=='Director') echo "selected";?>>Director</option>
                                                              <option value="Developer" <?php if($rowUser['user_designation']=='Developer') echo "selected";?>>Developer</option>
                                                              <option value="Marketing" <?php if($rowUser['user_designation']=='Marketing') echo "selected";?>>Marketing</option>
                                                              <option value="Designer" <?php if($rowUser['user_designation']=='Designer') echo "selected";?>>Designer</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary width-md" name="Submit">Update</button>
                                                        <a href="userview.php" class="btn btn-lighten-primary waves-effect waves-primary width-md">Cancel</a>
                                                    </div>
                                                </div>
                                            </form>
                                            <?
                                        }
                                        ?>
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
