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
$page_id=7;
if (!isset($_GET['logo_id'])) {
    header("location:logoview.php");
}
$logo_id = $_GET['logo_id'];

if(isset($_POST['Delete'])){
    $img = $_POST['txtImage'];
    if($img!="")
        unlink("logo/".$img);
    $sql="UPDATE tbl_logo SET image_name='' WHERE logo_id='".$logo_id."'";
    $cn->insertdb($sql);
}
?>
<?php
if (isset($_POST['Submit'])) {
    $img = $_POST['txtImage'];
    if($img!="")
        unlink("logo/".$img);
    $name = str_shuffle(md5(rand(0,10000)));
    $ext = strtolower(substr($_FILES['txtFile']['name'], strrpos($_FILES['txtFile']['name'],".")));
    $name .=$ext;
    move_uploaded_file($_FILES["txtFile"]["tmp_name"],"logo/" .$name);
    $sql = "UPDATE tbl_logo SET image_name='" . $name . "' WHERE logo_id='" . $logo_id . "'";
    //echo $sql;
    $cn->insertdb($sql);
    header("location:logoview.php");
}
$sql = "SELECT * FROM tbl_logo WHERE logo_id='$logo_id'";
$result = $cn->selectdb($sql);
if ($cn->numRows($result) > 0) {
    $row = $cn->fetchAssoc($result);
} else {
    header("location:logoview.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from coderthemes.com/adminto/layouts/light/form-fileupload.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 25 Jan 2020 08:38:15 GMT -->
<head>
        <meta charset="utf-8" />
        <title>ICED Infotech</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- dropify -->
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
                        <h4 class="page-title-main">Logo</h4>
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
                            <div class="col-md-12">
                                <div class="card-box">
                                    <h4 class="header-title mt-0 mb-3">Logo</h4>
                                    <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal"  enctype="multipart/form-data" role="form" method="post">
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtName">Image</label>
                                                    <div class="col-sm-4">
                                                        <input type="hidden" name="txtImage" value="<?php echo $row['image_name'];?>">
                                                        <input type="file" name="txtFile" class="dropify" <?php if($row['image_name']!="") echo "data-default-file='logo/".$row['image_name']."'";?>  />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary width-md" name="Submit">Update</button>
                                                        <button type="submit" class="btn btn-danger width-md" name="Delete">Delete</button>
                                                        <a href="logoview.php" class="btn btn-lighten-primary waves-effect waves-primary width-md">Cancel</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div> <!-- container-fluid -->
                </div> <!-- content -->
            </div>
        </div>
        <!-- END wrapper -->

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- dropify js -->
        <script src="assets/libs/dropify/dropify.min.js"></script>

        <!-- form-upload init -->
        <script src="assets/js/pages/form-fileupload.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>
</html>