<?php
ob_start();
session_start();
include_once("../connect.php");
$cn = new connect();
$cn->connectdb();
?>
<?php
if (isset($_POST['Submit'])) {
    global $cn;
    $user = $_POST['username'];
    $pwd = mysqli_real_escape_string($cn->_connection, $_POST['password']);
    $recordset = $cn->selectdb("SELECT u.user_email,u.user_email,u.user_password,u.user_id from tbl_user u where BINARY user_email='" . $user . "'");
    $cnt = mysqli_affected_rows($cn->_connection);
    if ($cnt == 1) {
        $rowUser = mysqli_fetch_assoc($recordset);
        if ($rowUser['user_password'] == base64_encode($pwd)) {
            
            $my_date = date("Y-m-d H:i:s");
            $cn->insertdb("UPDATE `tbl_user` SET user_last_login_date_time='" . $my_date . "' where user_email='". $user."'");
            $_SESSION['user'] = $user;
            $result = $cn->selectdb("SELECT u.user_name,u.user_id,r.role_name from tbl_user u,tbl_role r where u.role_id = r.role_id AND u.user_id = ".$rowUser['user_id']);
            $row = mysqli_fetch_array($result);
            $_SESSION['control'] = $row['role_name'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user'] = $row['user_name'];
            header("location:index.php");
        } else {
            $error = "Authentication Required..!";
        }
    } else {
        $error = "User Email Invalid..!";
    }
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

<body class="authentication-bg">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <?php
                    if (isset($error)) {
                    ?>
                        <div class="alert alert-danger">
                            <strong>Oh snap!</strong> <?php echo $error; ?>
                        </div>
                        <br>
                    <?php
                    }
                    ?>
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Sign In</h4>
                            </div>
                            <form method="post">
                                <div class="form-group mb-3">
                                    <label for="username">User Email</label>
                                    <input class="form-control" type="email" name="username" id="username" required="" placeholder="Enter your email">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" required="" id="password" name="password" placeholder="Enter your password">
                                </div>
                                <br>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block" type="submit" name="Submit"> Log In </button>
                                </div>
                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">2020 &copy; ICED Infotech.</p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
</body>

</html>
