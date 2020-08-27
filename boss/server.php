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
$page_id=2;
?>
<?php
if (isset($_POST['Submit'])) {
    $name = $_POST['txtName'];
    $server_username = $_POST['server_username'];
    $server_password = $_POST['server_password'];
    $server_link = $_POST['server_link'];
    $server_nameserver = $_POST['server_nameserver'];
    $status = $_POST['txtStatus'];

    $sql = "INSERT INTO tbl_server(`server_name`, `server_username`, `server_password`, `server_link`, `server_nameserver`, `server_status`) VALUES('" . $name . "','" . $server_username . "','" . $server_password . "','" . $server_link . "','" . $server_nameserver . "','".$status."')";
    //echo $sql;
    $cn->insertdb($sql);
    header("location:serverview.php");
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
                    <h4 class="page-title-main">Server</h4>
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
                                <h4 class="m-t-0 header-title">Add Server</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="post">
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtName">Server Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" required name="txtName" class="form-control" placeholder="Server Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="server_username">Server User Name</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="server_username" class="form-control" placeholder="Server User Name">
                                                    </div>
                                                    <label class="col-sm-2  col-form-label" for="server_password">Server Password</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="server_password" class="form-control" placeholder="Server Password">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="server_link">Server Link</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="server_link" class="form-control" placeholder="Server Link">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtStatus">Status</label>
                                                    <div class="col-sm-10">
                                                      <select name="txtStatus" id="txtStatus" class="form-control">
                                                          <option value="0">Off</option>
                                                          <option value="1">On</option>
                                                      </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="server_nameserver">Nameservers</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="server_nameserver" class="form-control" placeholder="Description"></textarea>
                                                        <script>
                                                            CKEDITOR.replace('server_nameserver');
                                                        </script>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary width-md" name="Submit">Add</button>
                                                        <a href="serverview.php" class="btn btn-lighten-primary waves-effect waves-primary width-md">Cancel</a>
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
