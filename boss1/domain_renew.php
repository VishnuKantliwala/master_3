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
$page_id=13;
?>
<?php
if (isset($_POST['Submit'])) {
    $Dname = $_POST['txtDName'];
    $Pname = $_POST['txtPName'];
    $server = $_POST['txtServer'];
    $product = $_POST['txtService'];
    $datepart = explode('/',$_POST['txtDate']);
    $date = $datepart[2]."-".$datepart[0]."-".$datepart[1];
    $amount = $_POST['txtAmount'];
    $SMS = "";
    $Email = "";
    if(isset($_POST['chkSMS']))
      $SMS = $_POST['txtSMS'];
    if(isset($_POST['chkEmail']))
      $Email = $_POST['txtEmail'];
    $sql = "INSERT INTO tbl_renewal(domain_name,server_id,product_id,renewal_date, person_name,sms_no,email_id,renewal_amt) VALUES('" . $Dname . "','".$server."','".$product."','".$date."','".$Pname."','".$SMS."','".$Email."','".$amount."')";
    //echo $sql;
    $cn->insertdb($sql);
    header("location:domain_renew_view.php");
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
    <link href="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/libs/multiselect/multi-select.css"  rel="stylesheet" type="text/css" />
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
                    <h4 class="page-title-main">Domain Renew</h4>
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
                                <h4 class="m-t-0 header-title">Domain Renew</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="post">
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtDName">Domain Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="txtDName" class="form-control" placeholder="Domain Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtServer">Server Name</label>
                                                    <div class="col-sm-10">
                                                      <select name="txtServer" id="txtServer" class="form-control">
                                                          <?php
                                                            $sql="SELECT server_id,server_name FROM tbl_server";
                                                            $result=$cn->selectdb($sql);
                                                            if($cn->numRows($result)){
                                                              while($row=$cn->fetchAssoc($result)){
                                                          ?>
                                                          <option value="<?php echo $row['server_id'];?>"><?php echo $row['server_name'];?></option>
                                                          <?php
                                                              }
                                                            }
                                                          ?>
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtService">Type of Services</label>
                                                    <div class="col-sm-10">
                                                      <select name="txtService" id="txtService" class="form-control">
                                                          <?php
                                                            $sql="SELECT product_id,name FROM tbl_product";
                                                            $result=$cn->selectdb($sql);
                                                            if($cn->numRows($result)){
                                                              while($row=$cn->fetchAssoc($result)){
                                                          ?>
                                                          <option value="<?php echo $row['product_id'];?>"><?php echo $row['name'];?></option>
                                                          <?php
                                                              }
                                                            }
                                                          ?>
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtStatus">Renew Date</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker" name="txtDate">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="ti-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtPName">Person Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="txtPName" class="form-control" placeholder="Person Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtAmount">Amount</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="txtAmount" class="form-control" placeholder="Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtStatus">Notification</label>
                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                              <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" name="chkSMS" id="chkSMS">
                                                                <label class="custom-control-label" for="chkSMS">SMS</label>
                                                                <input type="text" name="txtSMS" id="txtSMS" placeholder="Mobile Number" class="form-control">
                                                              </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                              <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" name="chkEmail" id="chkEmail">
                                                                <label class="custom-control-label" for="chkEmail">Email</label>
                                                                <input type="text" name="txtEmail"
                                                                id="txtEmail" placeholder="Email-ID" class="form-control">
                                                              </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary width-md" name="Submit">Add</button>
                                                        <a href="domain_renew_view.php" class="btn btn-lighten-primary waves-effect waves-primary width-md">Cancel</a>
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
            <!-- Plugins Js -->
            <script src="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
            <script src="assets/libs/switchery/switchery.min.js"></script>
            <script src="assets/libs/multiselect/jquery.multi-select.js"></script>
            <script src="assets/libs/jquery-quicksearch/jquery.quicksearch.min.js"></script>

            <script src="assets/libs/select2/select2.min.js"></script>
            <script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
            <script src="assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>
            <script src="assets/libs/moment/moment.js"></script>
            <script src="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
            <script src="assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
            <script src="assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
            <script src="assets/libs/bootstrap-daterangepicker/daterangepicker.js"></script>
            <script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>

            <!-- Init js-->
            <script src="assets/js/pages/form-advanced.init.js"></script>
            <!-- App js -->
            <script src="assets/js/app.min.js"></script>
            <script>
                $("#txtSMS").hide();
                $("#chkSMS").click(function(){
                    if($(this).prop("checked")==true){
                        $("#txtSMS").show(500);
                    }else{
                        $("#txtSMS").hide(500);
                    }
                });
                $("#txtEmail").hide();
                $("#chkEmail").click(function(){
                    if($(this).prop("checked")==true){
                        $("#txtEmail").show(500);
                    }else{
                        $("#txtEmail").hide(500);
                    }
                });
            </script>
</body>

</html>
