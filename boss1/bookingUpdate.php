<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
include_once("image_lib_rname.php");
$cn = new connect();
$cn->connectdb();
$page_id=10;
if (!isset($_GET['booking_id'])) {
    header("location:bookingview.php");
}
$booking_id = $_GET['booking_id'];
$sql = "SELECT * FROM tbl_booking WHERE booking_id='".$booking_id."'";
$resultB = $cn->selectdb($sql);
if($cn->numRows($resultB)>0){
    $rowB = $cn->fetchAssoc($resultB);
}else{
    header("location:bookingview.php");
}
$sql = "SELECT * FROM tbl_shipper WHERE shipper_id='".$rowB['shipper_code']."'";
$resultS = $cn->selectdb($sql);
if($cn->numRows($resultS)>0){
    $rowS = $cn->fetchAssoc($resultS);
}else{
    header("location:bookingview.php");
}
$sql = "SELECT S.*,P.name FROM tbl_servicelist AS S, tbl_product AS P WHERE S.product_id=P.product_id AND S.booking_id='".$rowB['booking_id']."'";
//echo $sql;
$resultSP = $cn->selectdb($sql);
?>

<?php
if (isset($_POST['btnSubmit'])) {
    //phpinfo();
    if($_POST['txtNet']!="0"){
        $shipper_id = NULL;
        $shipper_name = NULL;
        $shipper_address = NULL;
        $shipper_pincode = NULL;
        $shipper_city = NULL;
        $shipper_phone1 = NULL;
        $shipper_mobile = NULL;
        $shipper_email = NULL;
        $gst_no = NULL;
        if($_POST['txtShipperID'] != '')
            $shipper_id = $_POST['txtShipperID'];
        if($_POST['txtShipper'] != '')
            $shipper_name = $_POST['txtShipper'];
        if($_POST['txtAddress'] != '')
            $shipper_address = $_POST['txtAddress'];
        if($_POST['txtPincode'] != '')
            $shipper_pincode = $_POST['txtPincode'];
        if($_POST['txtCity'] != '')
            $shipper_city = $_POST['txtCity'];
        if($_POST['txtPhone'] != '')
            $shipper_phone1 = $_POST['txtPhone'];
        if($_POST['txtMobile'] != '')
            $shipper_mobile = $_POST['txtMobile'];
        if($_POST['txtEmail'] != '')
            $shipper_email = $_POST['txtEmail'];
        if($_POST['txtGST'] != '')
            $gst_no = $_POST['txtGST'];
        $gst_type = $_POST['txtGSTType'];
        $type = $_POST['txtType'];
    
        $parts = explode('/', $_POST['datepicker']);
        $booking_date  = "$parts[2]-$parts[0]-$parts[1]";
        $booking_id = $_POST['txtBook'];
        $attendant = $_POST['txtAttendant'];
        $link = $_POST['txtTemplate'];
    
        $actual_price = $_POST['txtTotal'];
        $charges = 0;
        $total_amount = $_POST['txtTotal'];
        $gst_charge = $_POST['txtGSTs'];
        $net_amount = $_POST['txtNet'];
        $received = 0;
        $credit = 0;
    
        $product_ids = $_POST['txtsids'];
        $durations = $_POST['txtdids'];
        $dnames = $_POST['txtdnames'];
        $qtys = $_POST['txtqtys'];
        $rates = $_POST['txtrates'];
        $totals = $_POST['txttotals'];
        $remarks = $_POST['txtremarks'];
        $renews = $_POST['txtrenews'];
    
        if($shipper_id != ""){
            $sql="SELECT * FROM tbl_shipper WHERE shipper_id='".$shipper_id."'";
            $result = $cn->selectdb($sql);
            if($cn->numRows($result)>0){
                $row = $cn->fetchAssoc($result);
                if($row['shipper_name'] == $shipper_name || $row['shipper_address'] == $shipper_address || $row['shipper_pincode'] == $shipper_pincode || $row['shipper_city'] == $shipper_city || $row['shipper_phone1'] == $shipper_phone1 || $row['shipper_mobile'] == $shipper_mobile || $row['shipper_email'] == $shipper_email || $row['gst_type'] == $gst_type || $row['type'] == $type || $row['gst_no'] == $gst_no){
    
                    $sql="UPDATE tbl_shipper SET shipper_name='".$shipper_name."',shipper_address = '".$shipper_address."',shipper_pincode='".$shipper_pincode."',shipper_city='".$shipper_city."',gst_no='".$gst_no."', shipper_phone1='".$shipper_phone1."',shipper_mobile='".$shipper_mobile."',shipper_email='".$shipper_email."',gst_no = '".$gst_no."',type='".$type."',gst_type='".$gst_type."' WHERE shipper_id = '".$shipper_id."'";
                    //echo $sql;
                    $cn->insertdb($sql);
                    $lastShipper_id = $shipper_id;
                }
            }
    
        }else {
            $sql="INSERT INTO tbl_shipper(shipper_name,shipper_address,shipper_pincode,shipper_city,shipper_phone1,shipper_mobile,shipper_email,`gst_type`,`gst_no`,`type`) VALUES ('".$shipper_name."','".$shipper_address."', '".$shipper_pincode."', '".$shipper_city."', '".$shipper_phone1."', '".$shipper_mobile."','".$shipper_email."','".$gst_type."','".$gst_no."','".$type."')";
            $cn->insertdb($sql);
            $lastShipper_id = mysqli_insert_id($con->getConnection());
        }
    
        $sql = "UPDATE `tbl_booking` SET `booking_date`='".$booking_date."',`shipper_code`='".$lastShipper_id."',`rate`='".$actual_price."', `charge`='".$charges."', `total_amount`='".$total_amount."', `gst_charge`='".$gst_charge."', `net_amount`='".$net_amount."', `received`='".$received."', `credit`='".$credit."', `website_link`='".$link."', `entrypersonname`='".$_SESSION['user']."', `attendant_id`=".$attendant." WHERE booking_id='".$booking_id."'";
        $cn->insertdb($sql);
        $sql="DELETE FROM tbl_servicelist WHERE booking_id='".$booking_id."'";
        $cn->insertdb($sql);
        //$last_id = mysqli_insert_id($con->getConnection());
        if (mysqli_affected_rows($cn->getConnection()) > 0) {
            foreach ($product_ids as $keys => $value) {
                $sql="INSERT INTO tbl_servicelist(booking_id,product_id,duration,yorm,qty,rate,price,remarks,renew_amt) VALUES('".$booking_id."','".$product_ids[$keys]."','".$durations[$keys]."','".$dnames[$keys]."','".$qtys[$keys]."','".$rates[$keys]."','".$totals[$keys]."','".$remarks[$keys]."','".$renews[$keys]."')";
               // echo $sql;
                $cn->insertdb($sql);
            }
            $success = "Data Updated";
        }else{
            $error = "Something went to wrong";
        }
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
    <link href="assets/libs/tablesaw/tablesaw.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/libs/multiselect/multi-select.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="assets/libs/switchery/switchery.min.css" rel="stylesheet" />
    <link href="assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-datepicker/bootstrap-datepicker.css" rel="stylesheet">
    <link href="assets/libs/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- third party css -->
    <link href="assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .form-group{
            margin-bottom: 0rem;
        }
        #shipper-list{
            float:left;
            list-style:none;
            margin-top:-3px;
            padding:0;
            width:97%;
            position: absolute;
            z-index:1;
        }
        #shipper-list li{
            padding: 10px;
            background: #f0f0f0;
            border-bottom: #bbb9b9 1px solid;
        }
        #shipper-list li:hover{
            background:#ece3d2;
            cursor: pointer;
        }
        .cols{
            padding-left: 5px;
            padding-right: 0px;
        }
        .fctrl{
            padding: 0.45rem 0.2rem
        }
    </style>
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
                    <h4 class="page-title-main">Update Invoice</h4>
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
                <form class="form-horizontal" autocomplete="off" role="form" method="post" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">Invoice Info</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-2">
                                                <div class="form-group row">
                                                    <div class="col-sm-8">
                                                        <label class="col-form-label" for="txtBook">Invoice No.</label>
                                                        <input type="text" name="txtBook" id="txtBook" value="<?php echo $rowB['booking_id'];?>" readonly class="form-control-plaintext">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="col-form-label" for="txtDate">Date</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="datepicker" value="<?php echo date('m/d/Y', strtotime($rowB['booking_date'])); ?>" placeholder="mm/dd/yyyy" id="datepicker">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="ti-calendar"></i></span>
                                                            </div>
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="m-t-0 header-title">Customer Details</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-1">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label" for="txtShipper">Name</label>
                                                        <input type="text" required pattern="[A-Z a-z]{3,50}" title="Enter only Aplabet between 3 to 50 character" value="<?php echo $rowS['shipper_name'];?>" id="txtShipper" name="txtShipper" class="form-control" placeholder="Name">
                                                        <div id="suggesstion-box"></div>
                                                        <input type="hidden" value="<?php echo $rowS['shipper_id'];?>" id="txtShipperID" name="txtShipperID" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label" for="txtAttendant">Attendant</label>
                                                        <select name="txtAttendant" id="txtAttendant" class="form-control">
                                                            <?php
                                                            $sql = "SELECT attendant_id,attendant_name FROM tbl_attendant";
                                                            $result = $cn->selectdb($sql);
                                                            if ($cn->numRows($result) > 0) {
                                                                while ($row = $cn->fetchAssoc($result)) {
                                                            ?>
                                                                <option value="<?php echo $row['attendant_id']; ?>" <?php if($rowB['attendant_id']==$row['attendant_id']) echo "selected";?>><?php echo $row['attendant_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label" for="txtAddress">Address</label>
                                                        <textarea id="txtAddress" name="txtAddress" class="form-control" placeholder="Address"><?php echo $rowS['shipper_address'];?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="txtPincode">Pincode</label>
                                                        <input type="text" id="txtPincode" pattern="[0-9]{6}" title="Enter only Digit between 0 to 9 and 6 character" name="txtPincode" value="<?php echo $rowS['shipper_pincode'];?>" class="form-control" placeholder="Pincode">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="txtCity">City</label>
                                                        <input type="text" id="txtCity" pattern="[A-Z a-z]{3,50}" title="Enter only Alphabet" name="txtCity" class="form-control" value="<?php echo $rowS['shipper_city'];?>" placeholder="City">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="txtPhone">Phone No.</label>
                                                        <input type="text" id="txtPhone" name="txtPhone" pattern="[0-9]{10}" title="Enter only Digit between 0 to 9 and 10 character" class="form-control" value="<?php echo $rowS['shipper_phone1'];?>" placeholder="Phone No.">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="txtMobile">Mobile</label>
                                                        <input type="text" id="txtMobile" required name="txtMobile" pattern="[0-9]{10}" title="Enter only Digit between 0 to 9 and 10 character" class="form-control" value="<?php echo $rowS['shipper_mobile'];?>" placeholder="Mobile">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label" for="txtEmail">Email-ID</label>
                                                        <input type="email" id="txtEmail" required name="txtEmail" class="form-control" value="<?php echo $rowS['shipper_email'];?>" placeholder="Email-ID">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="txtGSTType">GST Type</label>
                                                        <select name="txtGSTType" id="txtGSTType" class="form-control" onchange="countTotal()">
                                                            <option value="NOGST" <?php if($rowS['gst_type']=="NOGST") echo "selected";?>>NOGST</option>
                                                            <option value="CGST/SGST" <?php if($rowS['gst_type']=="CGST/SGST") echo "selected";?>>CGST/SGST</option>
                                                            <option value="IGST" <?php if($rowS['gst_type']=="IGST") echo "selected";?>>IGST</option>
                                                            <option value="UTGST" <?php if($rowS['gst_type']=="UTGST") echo "selected";?>>UTGST</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="txtGST">GST No.</label>
                                                        <input type="text" value="<?php echo $rowS['gst_no'];?>" pattern="[A_Z0-9]{15}" title="Enter only Alphabet and Digit and 15 character" id="txtGST" name="txtGST" class="form-control" placeholder="GST No.">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label" for="txtType">Payment Type</label>
                                                        <select name="txtType" id="txtType" class="form-control">
                                                            <option>Payment Type</option>
                                                            <option value="cash" <?php if($rowS['type']=="cash") echo "selected";?>>CASH</option>
                                                            <option value="cheque" <?php if($rowS['type']=="cheque") echo "selected";?>>CHEQUE</option>
                                                            <option value="credit" <?php if($rowS['type']=="credit") echo "selected";?>>CREDIT</option>
                                                            <option value="topay" <?php if($rowS['type']=="topay") echo "selected";?>>TO-PAY</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->

                                    <h4 class="m-t-0 header-title">Service Details</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-1">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label class="col-form-label" for="txtTemplate">Template Link</label>
                                                        <input type="text" id="txtTemplate" name="txtTemplate" value="<?php echo $rowB['website_link'];?>" class="form-control" placeholder="Template Link">
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="rowid" style="padding: 0 .5rem;">
                                                    <div class="col-md-2 cols">
                                                        <label class="col-form-label" for="txtService">Service</label>
                                                        <select id="txtService" name="txtService" class="form-control fctrl">
                                                            <option value="0">Select Service</option>
                                                            <?php
                                                            $sql = "SELECT product_id,name FROM tbl_product";
                                                            $resultP = $cn->selectdb($sql);
                                                            if ($cn->numRows($result) > 0) {
                                                                while ($rowP = $cn->fetchAssoc($resultP)) {
                                                            ?>
                                                                <option value="<?php echo $rowP['product_id']; ?> "><?php echo $rowP['name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 cols">
                                                        <label class="col-form-label" for="txtDuration">Duration</label>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-6" style="padding-right: 0px;">
                                                                <input type="text" name="txtDuration" id="txtDuration" class="form-control digit fctrl" placeholder="Duration">
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6" style="padding-left: 0px;">
                                                                <select id="txtDurType" name="txtDurType" class="form-control fctrl">
                                                                    <option value="Month">Month</option>
                                                                    <option value="Year">Year</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 cols">
                                                        <label class="col-form-label" for="txtQuantity">Quantity</label>
                                                        <input type="text" name="txtQuantity" id="txtQuantity" class="form-control digit fctrl" placeholder="Quantity" onkeyup="countGST();">
                                                    </div>
                                                    <div class="col-md-1 cols">
                                                        <label class="col-form-label" for="txtRate">Rate</label>
                                                        <input type="text" name="txtRate" id="txtRate" class="form-control fctrl digit" placeholder="Rate" onkeyup="countGST();">
                                                    </div>
                                                    <div class="col-md-2 cols">
                                                        <label class="col-form-label" for="txtGSTPer">GST</label>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-6" style="padding-right: 0px;">
                                                                <input type="text" name="txtGSTPer" id="txtGSTPer" class="form-control-plaintext digit fctrl" readonly 
                                                                placeholder="%">
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6" style="padding-left: 0px;">
                                                                <input type="text" name="txtGSTAmt" id="txtGSTAmt"
                                                                readonly class="form-control-plaintext fctrl digit" placeholder="Amt">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 cols">
                                                        <label class="col-form-label" for="txtRenewAmt">Renew</label>
                                                        <input type="text" name="txtRenewAmt" id="txtRenewAmt" class="form-control fctrl digit" placeholder="Renew Amt">
                                                    </div>
                                                    <div class="col-md-2 cols">
                                                        <label class="col-form-label" for="txtRemark">Remark</label>
                                                        <input type="text" name="txtRemark" id="txtRemark" class="form-control fctrl" placeholder="Remark">
                                                    </div>
                                                    <div class="col-md-1 cols">
                                                        <label class="col-form-label" for="btnAdd">&nbsp;</label>
                                                        <input type="button" name="btnAdd" id="btnAdd" class="btn btn-icon waves-effect waves-light btn-primary" value="+" style="width:100%;font-weight: bold;font-size: 18px;padding: 4px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                <div class="row">
                    <div class="col-8">
                        <div class="p-1">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <table id="datatable1" class=" table table-bordered dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>Service Name</th>
                                                <th>Quantity</th>
                                                <th>Rate</th>
                                                <th>GST</th>
                                                <th>Total</th>
                                                <th>Duration</th>
                                                <th>Renew Amt</th>
                                                <th>Remark</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="product-list">
                                        <?php
                                            $n=0;
                                            while($rowSP = $cn->fetchAssoc($resultSP)){
                                        ?>
                                            <tr>
                                                <td>
                                                    <label class='col-form-label'><?php echo $rowSP['name'];?></label><input type = 'hidden' name = 'txtspnames[<?php echo $n;?>]' id = 'txtsnames[<?php echo $n;?>]' readonly class = 'form-control-plaintext' value="<?php echo $rowSP['name'];?>"><input type = 'hidden' name = 'txtsids[<?php echo $n;?>]' id = 'txtsids[<?php echo $n;?>]' readonly class = 'form-control-plaintext' value="<?php echo $rowSP['product_id'];?>">
                                                </td>
                                                <td>
                                                    <label class='col-form-label'><?php echo $rowSP['qty'];?></label><input type = 'hidden' name = 'txtqtys[<?php echo $n;?>]' id = 'txtqtys[<?php echo $n;?>]' readonly class = 'form-control-plaintext' value="<?php echo $rowSP['qty'];?>">
                                                </td>
                                                <td>
                                                    <label class='col-form-label'><?php echo $rowSP['rate'];?></label><input type = 'hidden' name = 'txtrates[<?php echo $n;?>]' id = 'txtrates[<?php echo $n;?>]' readonly class = 'form-control-plaintext' value="<?php echo $rowSP['rate'];?>">
                                                </td>
                                                <td>
                                                <?php
                                                    $sql="SELECT gst_rate FROM tbl_product WHERE product_id=".$rowSP['product_id'];
                                                    $rGST = $cn->selectdb($sql);
                                                    $rowGST=$cn->fetchAssoc($rGST);
                                                    $gamt = ($rowSP['qty']*$rowSP['rate']*$rowGST['gst_rate'])/100;
                                                ?>
                                                    <label class='col-form-label'><?php echo $gamt;?></label><input type = 'hidden' name = 'txtgsts[<?php echo $n;?>]' id = 'txtgsts[<?php echo $n;?>]' readonly class = 'form-control-plaintext' value="<?php echo $gamt;?>">
                                                </td>
                                                <td>
                                                    <label class='col-form-label'><?php echo $rowSP['price'];?></label><input type = 'hidden' name = 'txttotals[<?php echo $n;?>]' id = 'txttotals[<?php echo $n;?>]' readonly class = 'form-control-plaintext' value="<?php echo $rowSP['price'];?>">
                                                </td>
                                                <td>
                                                    <label class='col-form-label'><?php echo $rowSP['duration'];?>&nbsp;<?php echo $rowSP['yorm'];?></label><input type = 'hidden' name = 'txtdids[<?php echo $n;?>]' id = 'txtdids[<?php echo $n;?>]' readonly class = 'form-control-plaintext' value="<?php echo $rowSP['duration'];?>"><input type = 'hidden' name = 'txtdnames[<?php echo $n;?>]' id = 'txtdnames[<?php echo $n;?>]' readonly class = 'form-control-plaintext' value="<?php echo $rowSP['yorm'];?>">
                                                </td>
                                                <td>
                                                    <label class='col-form-label'><?php echo $rowSP['renew_amt'];?></label><input type = 'hidden' name = 'txtrenews[<?php echo $n;?>]' id = 'txtrenews[<?php echo $n;?>]' readonly class = 'form-control-plaintext' value="<?php echo $rowSP['renew_amt'];?>">
                                                </td>
                                                <td>
                                                    <label class='col-form-label'><?php echo $rowSP['remarks'];?></label><input type = 'hidden' name = 'txtremarks[<?php echo $n;?>]' id = 'txtremarks[<?php echo $n;?>]' readonly class = 'form-control-plaintext' value="<?php echo $rowSP['remarks'];?>">
                                                </td>
                                                <td>
                                                    <button type='button' name='btnDel<?php echo $n;?>' id='btnDel<?php echo $n;?>' class='btn btn-icon waves-effect waves-light btn-danger' style='font-size: 15px;' onclick='delRow(<?php echo $n;?>);'><i class='fas fa-times'></i></button>
                                                </td>
                                            </tr>
                                        <?php
                                            $n++;
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                    <!--a id="delRow" style='color:white' class='btn  waves-effect waves-light btn-danger .btn-xs'> delete Row</a-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-1">
                            <div class="form-group row" style="margin-bottom: 0.5rem;">
                                <label class="col-md-6  col-form-label" for="txtTotal">Gross Total</label>
                                <div class="col-md-6">
                                    <input type="text" required id="txtTotal" name="txtTotal" value="<?php echo $rowB['rate'];?>" value="" readonly class="form-control-plaintext" placeholder="Total">
                                </div>
                            </div>
                            <!--div class="form-group row" style="margin-bottom: 0.5rem;">
                                <label class="col-md-6  col-form-label" for="txtEC">Extra Charges</label>
                                <div class="col-md-6">
                                    <input type="text" onkeyup="countTotal()" required id="txtEC" value="<?php //echo $rowB['charge'];?>" name="txtEC" class="form-control" placeholder="Extra Charges">
                                </div>
                            </div-->
                            <!--div class="form-group row" style="margin-bottom: 0.5rem;">
                                <label class="col-md-6  col-form-label" for="txtGT">Gross Total</label>
                                <div class="col-md-6">
                                    <input type="text" required id="txtGT" name="txtGT" value="<?php //echo $rowB['total_amount'];?>" readonly class="form-control-plaintext" placeholder="Gross Total">
                                </div>
                            </div-->
                            <div class="form-group row" style="margin-bottom: 0.5rem;">
                                <label class="col-md-6  col-form-label" for="txtGSTs">GST</label>
                                <div class="col-md-6">
                                    <input type="text" required id="txtGSTs" name="txtGSTs" value="<?php echo $rowB['gst_charge'];?>" readonly class="form-control-plaintext" placeholder="GST">
                                </div>
                            </div>
                            <div class="form-group row" style="margin-bottom: 0.5rem;">
                                <label class="col-md-6  col-form-label" for="txtNet">Net Amount</label>
                                <div class="col-md-6">
                                    <input type="text" required id="txtNet" name="txtNet" value="<?php echo $rowB['net_amount'];?>" readonly class="form-control-plaintext" placeholder="Net Amount">
                                </div>
                            </div>
                            <!--div class="form-group row" style="margin-bottom: 0.5rem;">
                                <label class="col-md-6  col-form-label" for="txtRec">Received</label>
                                <div class="col-md-6">
                                    <input type="text" onkeyup="countTotal()" required id="txtRec" value="<?php //echo $rowB['received'];?>" name="txtRec" class="form-control" placeholder="Received">
                                </div>
                            </div>
                            <div class="form-group row" style="margin-bottom: 0.5rem;">
                                <label class="col-md-6  col-form-label" for="txtCredit">Credit</label>
                                <div class="col-md-6">
                                    <input type="text" required id="txtCredit" name="txtCredit" value="<?php //echo $rowB['credit'];?>" readonly class="form-control-plaintext" placeholder="Credit">
                                </div>
                            </div-->
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-icon btn-primary" id="btnSubmit" name="btnSubmit">Update</button>
                                            <a href="invoiceOriginal.php?bookind_id=<?php echo $_GET['booking_id'];?>" class="btn btn-icon waves-effect waves-light btn-success" target="_blank"> <i class="dripicons-print" style="color:#fff;"></i> </a>
                                            <a href="bookingcopy.php?booking_id=<?php echo $_GET['booking_id'];?>" class="btn btn-icon btn-primary"><i class="far fa-copy" style="color:#fff;"></i></a>
                                            <a href="bookingview.php" class="btn btn-lighten-primary waves-effect waves-primary">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end row -->
                                </div> <!-- end card-box -->
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div> <!-- container-fluid -->
                </form>
            </div> <!-- content -->
            <?php
            include 'footer.php';
            ?>
            <script src="assets/js/vendor.min.js"></script>
            <!-- Vendor js -->
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
            <script src="assets/libs/toastr/toastr.min.js"></script>
            <script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
            <script src="assets/libs/datatables/dataTables.bootstrap4.js"></script>
            <script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
            <script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>
            <script src="assets/js/pages/datatables.init.js"></script>
            <!-- Tablesaw js -->
            <!-- App js -->
            <script src="assets/js/app.min.js"></script>
            <script>
                var datatab;
                jQuery.fn.ForceNumericOnly =
                    function() {
                        return this.each(function() {
                            $(this).keydown(function(e) {
                                var key = e.charCode || e.keyCode || 0;
                                return (
                                    key == 8 ||
                                    key == 9 ||
                                    key == 13 ||
                                    key == 46 ||
                                    key == 110 ||
                                    key == 190 ||
                                    (key >= 35 && key <= 40) ||
                                    (key >= 48 && key <= 57) ||
                                    (key >= 96 && key <= 105));
                            });
                        });
                    }
                var n = <?php echo $n;?>;
                function selectShipper(name,id) {
                    $("#txtShipper").val(name);
                    $("#txtShipperID").val(id);
                    $("#suggesstion-box").hide();
                    $.ajax({
                        url: "fetch_shipper_detail.php",
                        data: {shipper_id:id},
                        type: "POST",
                        success: function(data) {
                            console.log(data);
                            if(data!="False"){
                                data = JSON.parse(data);
                                $("#txtAddress").val(data.shipper_address);
                                $("#txtPincode").val(data.shipper_pincode);
                                $("#txtCity").val(data.shipper_city);
                                $("#txtPhone").val(data.shipper_phone1);
                                $("#txtMobile").val(data.shipper_mobile);
                                $("#txtEmail").val(data.shipper_email);
                                $("#txtGSTType").val(data.gst_type);
                                $("#txtGST").val(data.gst_no);
                                $("#txtType").val(data.type);
                                countTotal();
                            }
                        }
                    });
                }
                $(document).ready(function() {
                    if($(window).width()<576){
                        $("#rowid div").removeClass("cols");
                        $("#rowid input").removeClass("fctrl");
                        $("#rowid").removeAttr('style');
                        $("#rowid div").removeAttr('style');
                    }
                    datatab = $('#datatable1').DataTable({
                        "destroy": true,
                        "searching": false,
                        "paging": false,
                        "info": false,
                        "ordering": false
                    });
                    $(".digit").ForceNumericOnly();

                    $(".digit").focus(function() {
                        if($(this).val() == "0")
                            $(this).val('');
                    });
                    $(".digit").blur(function() {
                        if($(this).val() == "")
                            $(this).val('0');
                    });

                    $("#txtShipper").keyup(function(){
                        $.ajax({
                            type: "POST",
                            url: "fetch_shipper.php",
                            data:'keyword='+$(this).val(),
                            success: function(data){
                                $("#suggesstion-box").show();
                                $("#suggesstion-box").html(data);
                                $("#txtShipper").css("background","#FFF");
                            }
                        });
                    });
                    $("#txtService").change(function() {
                        $.ajax({
                            type: "POST",
                            url: "fetch_gstPer.php",
                            data: {product_id:$(this).val()},
                            success: function(data) {
                                $("#txtGSTPer").val(data.trim());
                            }
                        });
                    });
                    $('#txtDuration').val(0);
                    $("#txtQuantity").val(0);
                    $('#txtRate').val(0);

                    $("#btnAdd").click(function() {
                        var sid = $("#txtService").val();
                        var sname = $('#txtService option:selected').html();
                        var duration = $('#txtDuration').val();
                        var durType = $("#txtDurType").val();
                        var qty = $("#txtQuantity").val();
                        var rate = $("#txtRate").val();
                        var remark = $("#txtRemark").val();
                        var renew = $("#txtRenewAmt").val();
                        var total = parseInt(qty)*parseInt(rate);
                        var gsta = $("#txtGSTAmt").val();
                        if (sid == 0 || qty == 0 || rate == 0) {
                            toastr.error('Please enter data');
                        } else {
                            var service1 = "<label class='col-form-label'>"+sname+"</label><input type = 'hidden' name = 'txtspnames["+n+"]' id = 'txtsnames["+n+"]' readonly class = 'form-control-plaintext' value='" + sname + "'><input type = 'hidden' name = 'txtsids["+n+"]' id = 'txtsids["+n+"]' readonly class = 'form-control-plaintext' value='" + sid + "'>";
                            var duration1 = "<label class='col-form-label'>"+duration+"&nbsp;"+durType+"</label><input type = 'hidden' name = 'txtdids["+n+"]' id = 'txtdids["+n+"]' readonly class = 'form-control-plaintext' value='" + duration + "'><input type = 'hidden' name = 'txtdnames["+n+"]' id = 'txtdnames["+n+"]' readonly class = 'form-control-plaintext' value='" + durType + "'>";
                            var qty1 = "<label class='col-form-label'>"+qty+"</label><input type = 'hidden' name = 'txtqtys["+n+"]' id = 'txtqtys["+n+"]' readonly class = 'form-control-plaintext' value='" + qty + "'>";
                            var rate1 = "<label class='col-form-label'>"+rate+"</label><input type = 'hidden' name = 'txtrates["+n+"]' id = 'txtrates["+n+"]' readonly class = 'form-control-plaintext' value='" + rate + "'>";
                            var remark1 = "<label class='col-form-label'>"+remark+"</label><input type = 'hidden' name = 'txtremarks["+n+"]' id = 'txtremarks["+n+"]' readonly class = 'form-control-plaintext' value='" + remark + "'>";
                            var total1 = "<label class='col-form-label'>"+total+"</label><input type = 'hidden' name = 'txttotals["+n+"]' id = 'txttotals["+n+"]' readonly class = 'form-control-plaintext' value='" + total + "'>";
                            var renew1 = "<label class='col-form-label'>"+renew+"</label><input type = 'hidden' name = 'txtrenews["+n+"]' id = 'txtrenews["+n+"]' readonly class = 'form-control-plaintext' value='" + renew + "'>";
                            var gsta1 = "<label class='col-form-label'>"+gsta+"</label><input type = 'hidden' name = 'txtgsts["+n+"]' id = 'txtgsts["+n+"]' readonly class = 'form-control-plaintext' value='" + gsta + "'>";
                            var del1 = "<button type='button' name='btnDel"+n+"' id='btnDel"+n+"' class='btn btn-icon waves-effect waves-light btn-danger' style='font-size: 15px;' onclick='delRow("+n+");'><i class='fas fa-times'></i></button>";
                            datatab.row.add([
                                service1,
                                qty1,
                                rate1,
                                gsta1,
                                total1,
                                duration1,
                                renew1,
                                remark1,
                                del1
                            ]).draw(false);
                            $('#txtService').focus();
                            n++;
                            grossTotal();
                            countTotal();
                            datatab = $('#datatable1').DataTable({
                                "destroy": true,
                                "searching": false,
                                "paging": false,
                                "info": false,
                                "ordering": false
                            });
                        }
                    });
                    /*$('#datatable1 tbody').on('click', 'tr', function() {
                        if ($(this).hasClass('selected')) {
                            $(this).removeClass('selected');
                        } else {
                            datatab.$('tr.selected').removeClass('selected');
                            $(this).addClass('selected');
                        }
                    });
                    $('#delRow').click(function() {
                        if (datatab.rows('.selected').data().length == 0) {
                            alert(datatab.rows('.selected').data().length + ' row(s) selected, you should select the row you want to delete!');
                        } else {
                            alert(datatab.rows('.selected').data().length + ' row(s) selected, are you sure you want to delete this row?');
                            datatab.row('.selected').remove().draw(false);
                            grossTotal();
                            countTotal();
                        }
                    });*/
                });
                function delRow(id) {
                    //let class1 = $("btnDel0").parentsUntil("tr");
                    //var a = $(this).parentElement.nodeName;
                    //alert(a);
                    //var a =  class1.attr("class");
                    //console.log(a);
                    /*if($("#btnDel0").parent().parent().hasClass("parent")){
                        //$("#btnDel0").parent().parent().remove();
                    }else{
                        //a.remove();
                        //alert("p");
                        $("#btnDel0").parent().parent().remove();
                    }*/
                    //alert(id);
                    $("#btnDel"+id).parent().parent().addClass('del');;
                    datatab.row('.del').remove().draw(false);
                    grossTotal();
                    countTotal();
                    datatab = $('#datatable1').DataTable({
                        "destroy": true,
                        "searching": false,
                        "paging": false,
                        "info": false,
                        "ordering": false,
                    });
                   // console.log (tag);
                }
                function countGST() {
                    //alert("hello");
                    var qty = 0;
                    var rate = 0;
                    var gst = 0;
                    if($("#txtQuantity").val() != "")
                        qty = $("#txtQuantity").val();
                    if($("#txtRate").val() != "")
                        rate = $("#txtRate").val();
                    if($("#txtGSTPer").val() != "")
                        gst = $("#txtGSTPer").val();
                    //var total = ;
                    var gstAmt = (qty * rate * gst)/100;
                    $("#txtGSTAmt").val(gstAmt);
                }
                function grossTotal() {
                    var total = 0;
                    $("#product-list tr").each(function() {
                        var t = $(this).find("td:eq(4)").find("input").val();
                        total = total + parseInt(t);
                    });
                    $("#txtTotal").val(total);
                }
                function totalGST() {
                    var total = 0;
                    $("#product-list tr").each(function() {
                        var t = $(this).find("td:eq(3)").find("input").val();
                        total = total + parseInt(t);
                    });
                    return total
                }
                function countTotal() {
                    var Total = 0;
                    //var Extra = 0;
                    //var Gross = 0;
                    var GST = 0;
                    var Net = 0;
                    //var Received = 0;
                    //var Credit = 0;
                    //var EGST = 0;
                    if($("#txtTotal").val() != "")
                        Total = $("#txtTotal").val();
                    //if($("#txtEC").val() != "")
                        //Extra = $("#txtEC").val();
                    //if($("#txtRec").val() != "")
                        //Received = $("#txtRec").val();

                    //Gross = parseFloat(Total) + parseFloat(Extra);
                    if($("#txtGSTType").val() != "NOGST"){
                        //EGST = 
                        GST = totalGST();
                        Net = parseFloat(Total) + parseFloat(GST);
                    }else{
                        Net = parseFloat(Total) + parseFloat(GST);
                    }
                    //Credit = parseFloat(Net) - parseFloat(Received);

                   /* if(Extra != 0)
                        Extra = Math.round(Extra,2);
                    if(Gross != 0)
                        Gross = Gross.toFixed(2);
                    if(GST != 0)
                        GST = GST.toFixed(2);
                    if(Net != 0)
                        Net = Net.toFixed(2);
                    if(Received != 0)
                        Received = Math.round(Received,2);
                    if(Credit != 0)
                        Credit = Credit.toFixed(0);*/

                    //$("#txtEC").val(Extra);
                    //$("#txtGT").val(Gross);
                    $("#txtGSTs").val(GST);
                    $("#txtNet").val(Net);
                    //$("#txtRec").val(Received);
                    //$("#txtCredit").val(Credit.toFixed(2));
                }
                <?php
                if (isset($error)) {
                    echo "toastr.error('" . $error . "');";
                }
                if (isset($success)) {
                    echo "toastr.success('" . $success . "');setTimeout(()=>{window.open('bookingview.php','_self');},2000);";
                }
                ?>
            </script>

</body>

</html>