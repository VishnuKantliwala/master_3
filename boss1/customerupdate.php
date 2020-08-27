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
if (!isset($_GET['shipper_id'])) {
    header("location:customerview.php");
}
$shipper_id = $_GET['shipper_id'];
$sql = "SELECT * FROM tbl_shipper WHERE shipper_id='$shipper_id'";
$result = $cn->selectdb($sql);
if ($cn->numRows($result) > 0) {
    $row = $cn->fetchAssoc($result);
    $sql = "SELECT * FROM tbl_shipper_info WHERE shipper_id='$shipper_id'";
    $resultCon = $cn->selectdb($sql);
    $sql="SELECT uname FROM tbl_project_allocate WHERE shipper_id='$shipper_id'";
    $resultEmp = $cn->selectdb($sql);
    $Employee = array();
    while($row11=$cn->fetchAssoc($resultEmp)){
        array_push($Employee, $row11['uname']);
    }
    //print_r($Employee);
} else {
    header("location:customerview.php");
}
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
    $sql = "UPDATE tbl_shipper SET shipper_name='".$customer."',shipper_address='".$address."',shipper_pincode='".$pincode."',shipper_city='".$city."',shipper_phone1='".$phone."',shipper_mobile='".$mob."',shipper_email='".$emailid."',type='".$type."',gst_type='".$gstType."',gst_no='".$gstNo."'  WHERE shipper_id='".$code."'";
    //echo $sql;
    $cn->insertdb($sql);
    $sql="DELETE FROM tbl_project_allocate WHERE shipper_id='$shipper_id'";
    $cn->insertdb($sql);
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
                                <h4 class="m-t-0 header-title">Update Customer</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="post">
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtCode">Code</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" required name="txtCode" readonly="" class="form-control-plaintext" value="<? echo $_GET['shipper_id'];?>" placeholder="Code">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtCustomer">Customer Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" required name="txtCustomer" pattern="[A-Za-z 0-9]{3,50}" title="Enter only Alphabet and digit between 3 to 50 character long" class="form-control" value="<?php echo $row['shipper_name'];?>" placeholder="Customer Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtAddress">Address</label>
                                                    <div class="col-sm-10">
                                                        <textarea type="text" required name="txtAddress" class="form-control" placeholder="Address"> <?php echo $row['shipper_address'];?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtPincode">Pincode</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="txtPincode" pattern="[0-9]{6}" title="Enter only Digit between 0 to 9 and 6 character long" value="<?php echo $row['shipper_pincode'];?>" class="form-control" placeholder="Pincode">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtCity">City</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="txtCity" pattern="[A-Za-z ]{3,50}" title="Enter only Alphabet" class="form-control" required value="<?php echo $row['shipper_city'];?>" placeholder="City">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtPhone">Phone</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="txtPhone" pattern="[0-9]{10}" title="Enter only Digit between 0 to 9 and 10 character" value="<?php echo $row['shipper_phone1'];?>" class="form-control" placeholder="Phone">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtMob">Mobile</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" required name="txtMob" pattern="[0-9]{10}" title="Enter only Digit between 0 to 9 and 10 character" class="form-control" value="<?php echo $row['shipper_mobile'];?>" placeholder="Mobile No.">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtEmailID">Email-ID</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" required name="txtEmailID" value="<?php echo $row['shipper_email'];?>" class="form-control" placeholder="Email-ID">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtGSTNo">GST No.</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="txtGSTNo" pattern="[A-Z0-9]{15}" title="Enter only Capital Alphabate and Digit and 15 character" value="<?php echo $row['gst_no'];?>" class="form-control" placeholder="GST No.">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtGSTType">GST Type</label>
                                                    <div class="col-sm-10">
                                                      <select name="txtGSTType" id="txtGSTType" class="form-control">
                                                        <option value="NOGST" <?php if($row['gst_type']=="NOGST") echo "selected";?>>NO GST</option>
                                                        <option value="CGST/SGST" <?php if($row['gst_type']=="CGST/SGST") echo "selected";?>>CGST/SGST</option>
                                                        <option value="IGST" <?php if($row['gst_type']=="IGST") echo "selected";?>>IGST</option>
                                                        <option value="UTGST" <?php if($row['gst_type']=="UTGST") echo "selected";?>>UTGST</option>
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtType">Type</label>
                                                    <div class="col-sm-10">
                                                      <select name="txtType" id="txtType" class="form-control">
                                                        <option>Select Type</option>
      													<option value="cash" <?php if($row['type']=="cash") echo "selected";?> >CASH</option>
      													<option value="cheque" <?php if($row['type']=="cheque") echo "selected";?> >CHEQUE</option>
      													<option value="credit" <?php if($row['type']=="credit") echo "selected";?> >CREDIT</option>
      													<option value="topay" <?php if($row['type']=="topay") echo "selected";?> >TO-PAY</option>
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtCustomer">Person Name(s)</label>
                                                    <div class="col-sm-10">
                                                    <?php
                                                        while($rowC = $cn->fetchAssoc($resultCon)){
                                                    ?>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <input type="text" name="txtPerson[0]" readonly="" class="form-control-plaintext" value="<?php echo $rowC['person_name'];?>" placeholder="Person Name">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" name="txtMobile[0]" readonly="" class="form-control-plaintext" value="<?php echo $rowC['mobile_no'];?>" placeholder="Mobile No">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" name="txtEmail[0]" readonly="" class="form-control-plaintext" value="<?php echo $rowC['email_id'];?>" placeholder="Email-ID">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a href="custConUpdate.php?shipper_id=<?php echo $shipper_id;?>&si_id=<?php echo $rowC['si_id'];?>" class=" btn btn-icon waves-effect waves-light btn-primary"> <i class="fa fa-edit"></i> </a>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <a href="custConDelete.php?shipper_id=<?php echo $shipper_id;?>&si_id=<?php echo $rowC['si_id'];?>" class=" btn btn-icon waves-effect waves-light btn-danger"> <i class="fa fa-times"></i> </a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                        }
                                                    ?>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                    <div class="col-sm-10">
                                                        <a href="custConInsert.php?shipper_id=<?php echo $shipper_id;?>" class="btn btn-secondary  btn-rounded width-md waves-effect waves-light">Add Contact</a>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtGSTNo">Employee</label>
                                                    <div class="col-sm-10">
                                                        <div class="row">
                                                    <?php
                                                        $sql="SELECT uname FROM admintable WHERE control='developer'";
                                                        $result = $cn->selectdb($sql);
                                                        while($row1=$cn->fetchAssoc($result)){
                                                    ?>
                                                            <div class="col-md-4">
                                                                <div class="switchery-demo">
                                                                    <input type="checkbox" <?php if(in_array($row1['uname'], $Employee)) echo "checked";?> data-size="small" name="chkEmp[]" value="<?php echo $row1['uname'];?>" data-plugin="switchery" data-color="#3bafda"/>
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
                                                        <button type="submit" class="btn btn-primary width-md" name="Submit">Update</button>
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
</body>

</html>
