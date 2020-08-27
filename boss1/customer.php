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
$page_id=6;
$database = $cn->_database;
?>
<?php
if (isset($_POST['Submit'])) {
    $code = $_POST['txtCode'];
    $customer = $_POST['txtCustomer'];
    $address = $_POST['txtAddress'];
    $pincode = $_POST['txtPincode'];
    $city = $_POST['txtCity'];
    $phone = $_POST['txtPhone'];
    $mob = $_POST['txtMob'];
    $emailid = $_POST['txtEmailID'];
    $gstNo = $_POST['txtGSTNo'];
    $gstType = $_POST['txtGSTType'];
    $type = $_POST['txtType'];
    $sql = "INSERT INTO tbl_shipper(shipper_name,shipper_address,shipper_pincode,shipper_city,shipper_phone1,shipper_mobile,shipper_email,type,gst_type,gst_no) VALUES('".$customer."','".$address."','".$pincode."','".$city."','".$phone."','".$mob."','".$emailid."','".$type."','".$gstType."','".$gstNo."')";
    //echo $sql;
    $cn->insertdb($sql);
    $mobile = $_POST['txtMobile'];
    $person = $_POST['txtPerson'];
    $email = $_POST['txtEmail'];
    foreach ($person as $key => $value) {
        $sql="INSERT INTO tbl_shipper_info(shipper_id,person_name,mobile_no,email_id) VALUES('".$code."','".$person[$key]."','".$mobile[$key]."','".$email[$key]."')";
        //echo $sql;
        $cn->insertdb($sql);
    }
    $emp = $_POST['chkEmp'];
    foreach ($emp as $key => $value) {
        $sql="INSERT INTO tbl_project_allocate(shipper_id,uname) VALUES('".$code."','".$value."')";
        $cn->insertdb($sql);
    }
    header("location:customerview.php");
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
    <!-- Plugins css -->
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
                    <h4 class="page-title-main">Customer</h4>
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
                                <h4 class="m-t-0 header-title">Add Customer</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="post">
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtCode">Code</label>
                                                    <div class="col-sm-10">
                                                    <?php
                                                      $sql = $cn->selectdb("SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'tbl_shipper' AND TABLE_SCHEMA='$database'");
                                                      if (mysqli_num_rows($sql) > 0) {
                                                          $row = mysqli_fetch_assoc($sql);
                                                          //print_r($row);
                                                          $auto_code = $row["auto_increment"];
                                                          //echo $auto_code;
                                                      }
                                                    ?>
                                                        <input type="text" name="txtCode" readonly="" class="form-control-plaintext" value="<? echo $auto_code;?>" placeholder="Code">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtCustomer">Customer Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" required name="txtCustomer" pattern="[A-Za-z 0-9]{3,50}" title="Enter only Alphabet and Digit between 3 to 50 character" class="form-control" placeholder="Customer Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtAddress">Address</label>
                                                    <div class="col-sm-10">
                                                        <textarea type="text" required name="txtAddress" class="form-control" placeholder="Address"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtPincode">Pincode</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="txtPincode" pattern="[0-9]{6}" title="Enter only Digit between 0 to 9 and 6 character" class="form-control" placeholder="Pincode">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtCity">City</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" required pattern="[A-Za-z ]{3,50}" title="Enter only Alphabet" name="txtCity" class="form-control" placeholder="City">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtPhone">Phone</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="txtPhone" class="form-control" pattern="[0-9]{10}" title="Enter only Digit between 0 to 9 and 10 character" placeholder="Phone">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtMob">Mobile</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" required name="txtMob" pattern="[0-9]{10}" title="Enter only Digit between 0 to 9 and 10 character" class="form-control" placeholder="Mobile No.">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtEmailID">Email-ID</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" name="txtEmailID" required class="form-control" placeholder="Email-ID">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtGSTNo">GST No.</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="txtGSTNo" class="form-control" pattern="[A-Z0-9]{15}" title="Enter only Capital Alphabate and Digit and 15 character" placeholder="GST No.">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtGSTType">GST Type</label>
                                                    <div class="col-sm-10">
                                                      <select name="txtGSTType" id="txtGSTType" class="form-control">
                                                        <option value="NOGST">NO GST</option>
                                                        <option value="CGST/SGST">CGST/SGST</option>
                                                        <option value="IGST">IGST</option>
                                                        <option value="UTGST">UTGST</option>
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtType">Type</label>
                                                    <div class="col-sm-10">
                                                      <select name="txtType" id="txtType" class="form-control">
                                                        <option>Select Type</option>
      													<option value="cash">CASH</option>
      													<option value="cheque">CHEQUE</option>
      													<option value="credit">CREDIT</option>
      													<option value="topay">TO-PAY</option>
                                                      </select>
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtCustomer">Person Name(s)</label>
                                                    <div class="col-sm-10" id="conPerson">
                                                        <div class="row" id="row0">
                                                            <div class="col-md-4">
                                                                <input type="text" name="txtPerson[0]" class="form-control" placeholder="Person Name">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" name="txtMobile[0]" class="form-control" placeholder="Mobile No">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="text" name="txtEmail[0]" class="form-control" placeholder="Email-ID">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" onclick="delRow(0)" class=" btn btn-icon waves-effect waves-light btn-danger"> <i class="fa fa-times"></i> </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                    <div class="col-sm-10">
                                                        <button type="button" id="btnAddMore" class="btn btn-secondary  btn-rounded width-md waves-effect waves-light">Add More</button>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtType">Employee</label>
                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                    <?php
                                                        $sql="SELECT uname FROM admintable WHERE control='developer'";
                                                        $result = $cn->selectdb($sql);
                                                        while($row1=$cn->fetchAssoc($result)){
                                                    ?>
                                                            <div class="col-md-4">
                                                                <div class="switchery-demo">
                                                                    <input type="checkbox" data-size="small" name="chkEmp[]" value="<?php echo $row1['uname'];?>" data-plugin="switchery" data-color="#3bafda"/>
                                                                    <?php echo $row1['uname'];?>
                                                                </div>
                                                            </div>
                                                    <?php
                                                        }
                                                    ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary width-md" name="Submit">Add</button>
                                                        <a href="customerview.php" class="btn btn-lighten-primary waves-effect waves-primary width-md">Cancel</a>
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

            <script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
            <script src="assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>
            <script src="assets/libs/moment/moment.js"></script>
            <script src="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
            <script src="assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
            <script src="assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
            <script src="assets/libs/bootstrap-daterangepicker/daterangepicker.js"></script>
            <script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
            <script src="assets/js/pages/form-advanced.init.js"></script>
            <!-- App js -->
            <script src="assets/js/app.min.js"></script>
            <script>
                var n=1;
                $("#btnAddMore").on("click",function() {
                    $("#conPerson").append("<div class='row' id='row"+n+"'><div class='col-md-4'><input type='text' name='txtPerson["+n+"]' class='form-control' placeholder='Person Name'></div><div class='col-md-3'><input type='text' name='txtMobile["+n+"]' class='form-control' placeholder='Mobile No'></div><div class='col-md-4'><input type='text' name='txtEmail["+n+"]' class='form-control' placeholder='Email-ID'></div><div class='col-md-1'><button type='button' onclick='delRow("+n+")' class='delbtn btn btn-icon waves-effect waves-light btn-danger'> <i class='fa fa-times'></i> </button></div></div>");
                    n++;
                });
                function delRow(id) {
                    $("#row"+id).remove();
                }
            </script>
</body>

</html>
