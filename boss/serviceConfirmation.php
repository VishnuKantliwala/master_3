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
$page_id=25;
$database = $cn->_database;
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
    <!-- third party js -->
    <script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
            <script src="assets/libs/datatables/dataTables.bootstrap4.js"></script>
            <script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
            <script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <script src="assets/libs/ckeditor/ckeditor.js"></script>
    	
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <style>
  .ui-autocomplete {
    max-height: 100px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }
  /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
  * html .ui-autocomplete {
    height: 100px;
  }
  </style>

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
                    <h4 class="page-title-main"> Service Confirmation</h4>
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
                                <form class="form-horizontal" id="customerForm" name="customerForm" autocomplete="off" role="form" method="post">
                                    <h4 class="m-t-0 header-title">Service Confirmation Info</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-2">
                                                <div class="form-group row">
                                                    <div class="col-sm-8">
                                                        <label class="col-form-label" for="txtServiceConfirmationNo">Service Confirmation No.</label>
                                                        <?php //fetching next autogenerated code from db..
															
															$sql = $con->selectdb("SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'tbl_service_confirmation'  AND TABLE_SCHEMA='$database'");
															if (mysqli_num_rows($sql) > 0) 
															{
																$row = mysqli_fetch_assoc($sql);
																//print_r($row);
																$auto_code = $row["auto_increment"];
																//echo $auto_code;
															}		 
														
														?>
                                                        <input type="text" name="txtServiceConfirmationNo" id="txtServiceConfirmationNo" readonly class="form-control-plaintext" value="<? echo $auto_code; ?>">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="col-form-label" for="txtDate">Date</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="booking_date" value="<?php echo date("m/d/Y"); ?>" placeholder="mm/dd/yyyy" id="datepicker">
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
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="customer_name">Name</label>
                                                        <input type="text" id="customer_name" required title="Enter only Alphabate" name="customer_name" class="form-control" placeholder="Name">
                                                        
                                                        <input type="hidden" id="customer_id" name="customer_id" class="form-control">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="txtAttendant">Attendant</label>
                                                        <select name="txtAttendant" id="txtAttendant" class="form-control">
                                                            <?php
                                                            $sql = "SELECT attendant_id,attendant_name FROM tbl_attendant";
                                                            $result = $cn->selectdb($sql);
                                                            if ($cn->numRows($result) > 0) {
                                                                while ($row = $cn->fetchAssoc($result)) {
                                                            ?>
                                                                <option value="<?php echo $row['attendant_id']; ?> "><?php echo $row['attendant_name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <label class="col-form-label" for="customer_address">Address</label>
                                                        <textarea id="customer_address" name="customer_address" class="form-control" placeholder="Address"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="customer_pincode">Pincode</label>
                                                        <input type="text" id="customer_pincode" name="customer_pincode" pattern="[0-9]{6}" title="Enter only Digit between 0 to 9 and 6 character" class="form-control" placeholder="Pincode">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="customer_city">City</label>
                                                        <input type="text" id="customer_city" name="customer_city"  title="Enter only Alphabet" class="form-control" placeholder="City">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-4">
                                                        <label class="col-form-label" for="customer_phone1">Phone No.</label>
                                                        <input type="text" id="customer_phone1" name="customer_phone1" title="Enter only Digit between 0 to 9 and 10 character" class="form-control" placeholder="Phone No.">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="col-form-label" for="customer_phone2">Mobile</label>
                                                        <input type="text" id="customer_phone2"  name="customer_phone2" pattern="[0-9]{10}" title="Enter only Digit between 0 to 9 and 10 character" class="form-control" placeholder="Mobile">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label class="col-form-label" for="customer_email">Email-ID</label>
                                                        <input type="email" id="customer_email"  name="customer_email" class="form-control" placeholder="Email-ID">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="gst_type">GST Type</label>
                                                        <select name="gst_type" id="gst_type" class="form-control">
                                                            <option value="NOGST" selected>NOGST</option>
                                                            <option value="CGST/SGST" >CGST/SGST</option>
                                                            <option value="IGST" >IGST</option>
                                                            <option value="UTGST" >UTGST</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="gst_no">GST No.</label>
                                                        <input type="text" id="gst_no" name="gst_no" class="form-control" placeholder="GST No.">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="payment_type">Payment Type</label>
                                                        <select name="payment_type" id="payment_type" class="form-control">
                                                            <option>Payment Type</option>
                                                            <option value="cash" selected>CASH</option>
                                                            <option value="cheque" >CHEQUE</option>
                                                            <option value="credit" >CREDIT</option>
                                                            <option value="topay" >TO-PAY</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="col-form-label" for="gst_no">Currency</label>
                                                        <input type="text" id="currency" name="currency" class="form-control" placeholder="Currency" value="INR">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                &nbsp;
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <button type="submit" class="btn btn-primary width-sm" id="addConfirmation" name="addConfirmation">Save Customer Details</button>
                                                                <a href="serviceConfirmationView.php" class="btn btn-lighten-primary waves-effect waves-primary  width-sm">Cancel</a>
                                                                <input type="hidden" id="txtResult">
                                                                <img src='loader1.gif' style='width:2%;display:none;' id='custloader'/>
                                                                <label id="Message" style="font-weight:bold;color:green;"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </form>
                                <form class="form-horizontal" method="post" id="productForm" name="productForm"> 
                                    <div class="row" style="border-top:1px solid black;">
                                        <h4 class="m-t-0 header-title">Service Details</h4>
                                        <div class="col-12">
                                            <div class="p-1">
                                                
                                                <div class="form-group row" id="rowid" style="padding: 0 .5rem;">
                                                    <div class="col-md-2 cols">
                                                        <label class="col-form-label" for="txtService">Service</label>
                                                        <select id="txtService" name="txtService" class="form-control fctrl">
                                                            <option value="0">Select Service</option>
                                                            <?php
                                                            $sql = "SELECT product_id,`name` FROM tbl_product";
                                                            $resultP = $cn->selectdb($sql);
                                                            if ($cn->numRows($result) > 0) {
                                                                while ($rowP = $cn->fetchAssoc($resultP)) {
                                                            ?>
                                                                <option value="<?php echo $rowP['product_id']; ?>"><?php echo $rowP['name']; ?></option>
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
                                                        <input type="text" name="txtQuantity" id="txtQuantity" class="form-control digit fctrl" placeholder="Quantity">
                                                    </div>
                                                    <div class="col-md-1 cols">
                                                        <label class="col-form-label" for="txtRate">Rate</label>
                                                        <input type="text" name="txtRate" id="txtRate" class="form-control fctrl digit" placeholder="Rate">
                                                    </div>
                                                    <div class="col-md-2 cols">
                                                        <label class="col-form-label" for="txtGSTPer">GST</label>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-6" style="padding-right: 0px;">
                                                                <input type="text" name="txtGSTPer" readonly id="txtGSTPer" class="form-control-plaintext fctrl" placeholder="%">
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6" style="padding-left: 0px;">
                                                                <input type="text" name="txtGSTAmt" readonly id="txtGSTAmt" class="form-control-plaintext fctrl" placeholder="GST">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--div class="col-md-1 cols">
                                                        <label class="col-form-label" for="txtRenewAmt">Renew</label>
                                                        <input type="text" name="txtRenewAmt" id="txtRenewAmt" class="form-control digit fctrl" placeholder="Renew Amt">
                                                    </div-->
                                                    <div class="col-md-2 cols">
                                                        <label class="col-form-label" for="txtRate">Description</label>
                                                        <textarea name="shortDesc" id="shortDesc" class="form-control fctrl digit" placeholder="Short Description"></textarea>
                                                    </div>
                                                    <div class="col-md-1 cols">
                                                        <label class="col-form-label" for="btnAdd">&nbsp;</label>
                                                        <!-- <div class="row"> -->
                                                            <input type="submit" name="btnAdd" id="btnAdd" class="form-control btn btn-icon waves-effect waves-light btn-primary" value="Add Service">
                                                        <!-- </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-8">
                                            <div class="p-1">
                                                
                                                <div class="form-group row" id="rowid" style="padding: 0 .5rem;">
                                                    <div class="col-md-12 cols">
                                                    <textarea name="service_description" class="form-control" placeholder="Description"></textarea>
                                                        <script>
                                                            CKEDITOR.replace('service_description');
                                                        </script>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-1">
                                                <div class="form-group row" style="margin-bottom: 0.5rem;">
                                                    <label class="col-md-6  col-form-label" for="total_amt">Gross Total</label>
                                                    <div class="col-md-6">
                                                        <input type="text" required id="total_amt" name="total_amt" readonly class="form-control-plaintext" placeholder="Total">
                                                    </div>
                                                </div>
                                                <!--div class="form-group row" style="margin-bottom: 0.5rem;">
                                                    <label class="col-md-6  col-form-label" for="txtEC">Extra Charges</label>
                                                    <div class="col-md-6">
                                                        <input type="text" onkeyup="countTotal()" required id="txtEC" name="txtEC" class="form-control" placeholder="Extra Charges">
                                                    </div>
                                                </div-->
                                                <!--div class="form-group row" style="margin-bottom: 0.5rem;">
                                                    <label class="col-md-6  col-form-label" for="txtGT">Gross Total</label>
                                                    <div class="col-md-6">
                                                        <input type="text" required id="txtGT" name="txtGT" readonly class="form-control-plaintext" placeholder="Gross Total">
                                                    </div>
                                                </div-->
                                                <div class="form-group row" style="margin-bottom: 0.5rem;">
                                                    <label class="col-md-6  col-form-label" for="gst_charge">GST</label>
                                                    <div class="col-md-6">
                                                        <input type="text"  id="gst_charge" name="gst_charge" readonly class="form-control-plaintext" placeholder="GST">
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 0.5rem;">
                                                    <label class="col-md-6  col-form-label" for="net_amt">Net Amount</label>
                                                    <div class="col-md-6">
                                                        <input type="text"  id="net_amt" name="net_amt" readonly class="form-control-plaintext" placeholder="Net Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 0.5rem;">
                                                    <label class="col-md-6  col-form-label" for="received" >Received</label>
                                                    <div class="col-md-6">
                                                        <input type="text"  id="received" name="received" class="form-control-plaintext" readonly placeholder="Received">
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 0.5rem;">
                                                    <label class="col-md-6  col-form-label" for="credit">Credit</label>
                                                    <div class="col-md-6">
                                                        <input type="text"  id="credit" name="credit" readonly class="form-control-plaintext" placeholder="Credit">
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom: 0.5rem;display:none;" id="PaymentButton">
                                                    <div class="col-md-6 cols">
                                                        <input type="button" name="addPaymentModal" id="addPaymentModal" class="btn btn-icon waves-effect waves-light btn-primary" value="Add Payment">
                                                    </div>
                                                    <div class="col-md-6 cols">
                                                        <input type="button" name="addPaymentHistoryModal" id="addPaymentHistoryModal" class="btn btn-icon waves-effect waves-light btn-primary" value="Payment History">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-1">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <table id="datatable1" class=" table table-bordered dt-responsive nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th>Invoice</th>
                                                                    <th>Proforma</th>
                                                                    <th>Cash</th>
                                                                    <th>Service Name</th>
                                                                    <th>Quantity</th>
                                                                    <th>Rate</th>
                                                                    <th>GST</th>
                                                                    <th>GST Charge</th>
                                                                    <th>Total</th>
                                                                    <th>Duration</th>
                                                                    <!--th>Renew Amt</th-->
                                                                    <th>Edit</th>
                                                                    <th>Details</th>
                                                                    <th>
                                                                    <button type="button" id="delete"><i class="fa fa-trash"></i></button></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="service-list">

                                                            </tbody>
                                                        </table>
                                                        <!--a id="delRow" style='color:white' class='btn  waves-effect waves-light btn-danger .btn-xs'> delete Row</a-->
                                                    </div>
                                                    <!-- <div > -->
                                                        <div class="col-md-2 cols" id="buttonDivInv" style="display:none;">
                                                            <input type="button" name="generateInvoice" id="generateInvoice" class="btn btn-icon waves-effect waves-light btn-primary" value="Generate Invoice">
                                                        </div>
                                                        <div class="col-md-2 cols" id="buttonDivPro" style="display:none;">
                                                            <input type="button" name="generateProformaInvoice" id="generateProformaInvoice" class="btn btn-icon waves-effect waves-light btn-primary" value="Generate Proforma">
                                                        </div>
                                                        <div class="col-md-2 cols" id="buttonDivCash" style="display:none;">
                                                            <input type="button" name="generateCashInvoice" id="generateCashInvoice" class="btn btn-icon waves-effect waves-light btn-primary" value="Generate Cash Invoice">
                                                        </div>
                                                    <!-- </div> -->
                                                </div>               
                                            </div>
                                        </div>
                                        
                                    </div><!-- end row -->
                                    </form>
                                </div> <!-- end card-box -->
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div> <!-- container-fluid -->
                    <div id="paymentHistoryDataModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									
									<h4 class="modal-title">Payment History of Confirmation No : <span id="payment_history_invoice_no"></span></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body" id="paymentHistoryDataModalBody">

									<table id="paymentList" class="table table-striped">
										<thead>
											<tr >
												<th style="text-align:center;">Payment Date/Time</th>
												<th style="text-align:center;">Amount</th>
                                                <th style="text-align:center;">Description</th>
                                                <th style="text-align:center;">Received By</th>
                                                <th style="text-align:center;">Receipt</th>
												<!-- <th style="text-align:center;">Remove</th> -->
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
                    <div id="payment_Modal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									
									<h4 class="modal-title">Add Payment</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body" id="mymodal">
									<form method="post" id="payment_form">
										<label>Confirmation No.</label>
										<span id="label_invoice_no"></span>
										<div style="float:right;">
											<label>Credit Amount : </label>
											<span id="label_credit_amt"></span>
										</div>
										<input type="hidden" class="form-control" id="modal_invoice_no" name="modal_invoice_no" placeholder="Invoice No.">
										<input type="hidden" class="form-control" id="payment_invoice_id" name="payment_invoice_id" value="0" placeholder="Invoice No.">
										
										<br />

										<label>Paid Amount</label> 
										<input type="text" name="paid_amount" id="paid_amount" class="form-control" placeholder="Amount" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) ) || event.keyCode == 32) return false;" autocomplete="off"/>
										<br />
										<label style="font-weight:bold;">Received in :</label> 
										<input type="radio" name="payment_mode" id="payment_mode_cash" value="CASH" />&nbsp;<label for="payment_mode_cash">Cash</label>
										<input type="radio" name="payment_mode" id="payment_mode_cheque" value="CHEQUE" />&nbsp;<label for="payment_mode_cheque">Cheque</label>
										<input type="radio" name="payment_mode" id="payment_mode_other" value="OTHER"  />&nbsp;<label for="payment_mode_other">Other</label>
                                        <br />
                                        <textarea name="modal_payment_description" class="form-control" placeholder="Description"></textarea>
                                                       
                                         <br /><br />
										<input type="submit" name="addPayment" id="addPayment" value="Add Payment" class="btn btn-success" />
										<input type="button" name="getReceipt" id="getReceipt" value="Receipt" class="btn btn-success" style="display:none;"/>
										<button type="button" class="btn btn-icon waves-effect waves-light btn-primary" data-dismiss="modal">Close</button>
										<label id="ModalMessage" style="font-weight:bold;color:green;"></label>

										
										</div>
										

									</form>
								</div>
							</div>
						</div>
   					</div>
                    <div id="proformaHistoryDataModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									
									<h4 class="modal-title">Proforma Invoice List</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body" id="proformaHistoryDataModalBody">

									<table id="proformaList" class="table table-striped">
										<thead>
											<tr >
												<th style="text-align:center;">Proforma ID</th>
												<th style="text-align:center;">Date</th>
                                                <th style="text-align:center;">Print</th>
                                                <th style="text-align:center;">Add In</th>
                                                
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
                                    <button id="assignInProforma" class="btn btn-icon waves-effect waves-light btn-primary">Add</button>
                                    <button id="newProforma" class="btn btn-icon waves-effect waves-light btn-primary">New Proforma</button>
								</div>
							</div>
						</div>
					</div>
                    <div id="invoiceHistoryDataModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									
									<h4 class="modal-title">Invoice List</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body" id="invoiceHistoryDataModalBody">

									<table id="invoiceList" class="table table-striped">
										<thead>
											<tr >
												<th style="text-align:center;">Invoice ID</th>
												<th style="text-align:center;">Date</th>
                                                <th style="text-align:center;">Print</th>
                                                <th style="text-align:center;">Add In</th>
                                                
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
                                    <button id="assignInInvoice" class="btn btn-icon waves-effect waves-light btn-primary">Add</button>
                                    <button id="newInvoice" class="btn btn-icon waves-effect waves-light btn-primary">New Invoice</button>
								</div>
							</div>
						</div>
					</div>
                    <div id="cashHistoryDataModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									
									<h4 class="modal-title">Cash Invoice List</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>
								<div class="modal-body" id="cashHistoryDataModalBody">

									<table id="cashList" class="table table-striped">
										<thead>
											<tr >
												<th style="text-align:center;">Cash Invoice ID</th>
												<th style="text-align:center;">Date</th>
                                                <th style="text-align:center;">Print</th>
                                                <th style="text-align:center;">Add In</th>
                                                
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
                                    <button id="assignInCash" class="btn btn-icon waves-effect waves-light btn-primary">Add</button>
                                    <button id="newCash" class="btn btn-icon waves-effect waves-light btn-primary">New Cash Invoice</button>
								</div>
							</div>
						</div>
					</div>
                    <div id="ServiceDetailsDataModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
                                    <h4 class="modal-title">Service Details </h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									
								</div>
								<div class="modal-body" id="ServiceDetailsDataModalBody">

									<table id="serviceDetails" class="table table-striped">
										<tbody>
                                            <tr>
                                                <td>Service Name : </td>
                                                <td><label id="lbl_service_name"></label></td>
                                            </tr>
                                            <tr>
                                                <td>Entry Person Name : </td>
                                                <td><label id="lbl_user_name"></label></td>
                                            </tr>
                                            <tr>
                                                <td>Entry Date : </td>
                                                <td><label id="lbl_entry_date"></label></td>
                                            </tr>
                                            <tr>
                                                <td>Short Desc : </td>
                                                <td><label id="lbl_short_desc"></label></td>
                                            </tr>
                                            <tr>
                                                <td>Description : </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label id="lbl_description"></label></td>
                                            </tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
                    </div>
                    <div id="ServiceDetailsDataEditModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
                                    <h4 class="modal-title">Update Service Details - ID : <label id="service_inclusion_no"></label></h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									
								</div>
								<div class="modal-body" id="ServiceDetailsDataEditdModalBody">
                                    <form id="serviceDetailsUpdateForm" method="post">
									<table id="serviceDetails" class="table table-striped">
										<tbody>
                                             <tr>
                                                <td><input type="hidden" name="service_inclusion_no" id="modalservice_inclusion_no">
                                                Service :
                                                <select id="modaltxtService" name="txtService" class="form-control fctrl">
                                                            <option value="0">Select Service</option>
                                                            <?php
                                                            $sql = "SELECT product_id,`name` FROM tbl_product";
                                                            $resultP = $cn->selectdb($sql);
                                                            if ($cn->numRows($result) > 0) {
                                                                while ($rowP = $cn->fetchAssoc($resultP)) {
                                                            ?>
                                                                <option value="<?php echo $rowP['product_id']; ?>"><?php echo $rowP['name']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                </td> 
                                                <td>Duration : <input type="text" name="txtDuration" id="modaltxtDuration" class="form-control digit fctrl" placeholder="Duration"></td>
                                                <td>
                                                Duration Type:
                                                <select id="modaltxtDurType" name="txtDurType" class="form-control fctrl">
                                                    <option value="Month">Month</option>
                                                    <option value="Year">Year</option>
                                                </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Quantity : <input type="text" name="txtQuantity" id="modaltxtQuantity" class="form-control digit fctrl" placeholder="Quantity"></td>
                                                <td>Rate : <input type="text" name="txtRate" id="modaltxtRate" class="form-control fctrl digit" placeholder="Rate"></td>
                                                <td>GST(%): <input type="text" name="txtGSTPer" id="modaltxtGSTPer" class="form-control fctrl digit" placeholder="GST(%)" readonly></td>
                                            </tr> 
                                            <tr>
                                                <td colspan="3">Total Amount : <input type="text" name="txtTotalAmt" id="modaltxtTotalAmt" class="form-control fctrl digit" placeholder="Total Amount" readonly></td>
                                                
                                            </tr> 
                                            <tr>
                                                <td colspan="3">Short Desc : <textarea name="shortDesc" id="modalshortdesc" class="form-control" placeholder="Short Desc"></textarea></td>
                                                
                                            </tr> 
                                            <tr>
                                                <td colspan="3">
                                                Description
                                                <textarea name="modal_service_description" class="form-control" placeholder="Description"></textarea>
                                                        <script>
                                                            CKEDITOR.replace('modal_service_description');
                                                        </script>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><input type="submit" name="btnUpdate" id="btnUpdate" class="btn btn-icon waves-effect waves-light btn-primary" value="Save Changes"></td>
                                            </tr>
										</tbody>
									</table>
                                    </form>
								</div>
							</div>
						</div>
                    </div>
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
            <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
            <script src="assets/js/pages/sweet-alerts.init.js"></script>
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
                var n = 0;
                function selectCustomer(name,id) {
                    $("#customer_name").val(name);
                    $("#customer_id").val(id);
                    $("#suggesstion-box").hide();
                    $.ajax({
                        url: "fetch_customer_detail.php",
                        data: {customer_id:id},
                        type: "POST",
                        success: function(data) {
                            console.log(data);
                            if(data!="False"){
                                data = JSON.parse(data);
                                $("#customer_address").val(data.customer_address);
                                $("#customer_pincode").val(data.customer_pincode);
                                $("#customer_city").val(data.customer_city);
                                $("#customer_phone1").val(data.customer_phone1);
                                $("#customer_phone2").val(data.customer_phone2);
                                $("#customer_email").val(data.customer_email);
                                $("#gst_type").val(data.gst_type);
                                $("#gst_no").val(data.gst_no);
                                $("#payment_type").val(data.payment_type);
                                //countTotal();
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
                    //Fetch Inward_ID
                   
                    // $("#customer_name").keyup(function(){
                    //     $.ajax({
                    //         type: "POST",
                    //         url: "fetch_shipper.php",
                    //         data:'keyword='+$(this).val(),
                    //         success: function(data){
                    //             $("#suggesstion-box").show();
                    //             $("#suggesstion-box").html(data);
                    //             $("#customer_name").css("background","#FFF");
                    //         }
                    //     });
                    // });

                    $('#txtDuration').val(0);
                    $("#txtQuantity").val(0);
                    $('#txtRate').val(0);

                    $('#txtTotal').val(0);
                    $("#txtEC").val(0);
                    $('#txtGT').val(0);
                    $('#txtGSTs').val(0);
                    $("#txtNet").val(0);
                    $('#txtRec').val(0);
                    $('#txtCredit').val(0);

                   
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
                    //countTotal();
                    datatab = $('#datatable1').DataTable({
                        "destroy": true,
                        "searching": false,
                        "paging": false,
                        "info": false,
                        "ordering": false,
                    });
                   // console.log (tag);
                }
                
                <?php
                if (isset($error)) {
                    echo "toastr.error('" . $error . "');";
                }
                if (isset($success)) {
                    echo "toastr.success('" . $success . "');setTimeout(()=>{window.open('proformaUpdate.php?proforma_id=".$proforma_id."','_self');},2000);";
                }
                ?>

            </script>
<script>  
   counter = 0;
 $(document).ready(function(){  
	fetchInvoiceProducts('no');
	  $(document).on('click', '#delete', function(event){  
			
           event.preventDefault();  
		   $("#datatable1 input:checkbox:checked").map(function(){
			// alert($(this).val());
			setTimeout(() => {
				$('#datatable1 > tbody > #row'+$(this).val()).fadeOut();
			}, 300);
			
			}); 
			$.ajax({  
					url:"service_delete_rates.php",  
					method:"POST",  
					data:$('#productForm').serialize(),  
					success:function(data){  
					
					fetchAllAmount();	
				}  
			});  
				
      });
})};
 </script>
  <script>
    //Invoice Start
    $(document).on('click', '#generateInvoice', function(event){  
    
        event.preventDefault(); 
        var chkboxInvoice = [];
        $.each($("input[name='chkboxInvoice']:enabled:checked"), function(){
            chkboxInvoice.push($(this).val());
            //alert($(this).val());
        });
        if(chkboxInvoice.join(",") != "")
        { 
            var txtServiceConfirmationNo = $("#txtServiceConfirmationNo").val();
            $.ajax({  
                url:"service_insert_rate.php?type=checkPreviousInvoice",  
                method:"POST",  
                data:"service_confirmation_id="+txtServiceConfirmationNo+"&type=Invoice",  
                success:function(data){  
                    if(data != "false")
                    {
                        data = JSON.parse(data);
                        var length = data.length;
                        var row = "";
                        $('#invoiceList > tbody').empty();
                        for(i=0;i<length;i++)
                        {
                            row += "<tr id='rowInvoice"+i+"'>"+
                            "<td style='text-align:center;'>"+data[i].invoice_id+"</td>"+
                            "<td style='text-align:center;'>"+data[i].entry_date+"</td>"+
                            "<td style='text-align:center;'><a href='invoiceOriginal.php?invoice_id="+data[i].invoice_id+"' target='_blank'><i class='dripicons-print'></i></a></td>"+
                            "<td style='text-align:center;'><input type='radio' name='rdbtnInvoice' value='"+data[i].invoice_id+"'/></td>"+
                            "</tr>";
                        }
                    
                        $('#invoiceList > tbody').append(row);
                        openListModal('invoice');
                    }
                    else
                    {
                        registerInvoice('false');
                    }
                }  
            });
        }
        else
        {
            Swal.fire({
                title: "Error",
                text: "Please Select any checkbox of Invoice!",
                type: "error",
                confirmButtonText: "Ok, Sure!",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ml-2 mt-2",
                buttonsStyling: !1
                });
            
        }
    });
    $(document).on('click', '#assignInInvoice', function(event){  
    
        event.preventDefault();  
        if($('input[name="rdbtnInvoice"]:checked').val() != undefined)
        {
        //alert($('input[name="rdbtnProforma"]:checked').val());
        registerInvoice('true');
        }
        else
        {
        alert("Please select any..!")
        }  
    });
    $(document).on('click', '#newInvoice', function(event){  
    
        event.preventDefault();  
        registerInvoice('false');
        
    });
    function registerInvoice(flag)
    {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes",
            cancelButtonText: "No, cancel!",
            confirmButtonClass: "btn btn-success mt-2",
            cancelButtonClass: "btn btn-danger ml-2 mt-2",
            buttonsStyling: !1
        }).then(function(t) {
                if (t.value) {
                    var chkboxInvoice = [];
                $.each($("input[name='chkboxInvoice']:enabled:checked"), function(){
                    chkboxInvoice.push($(this).val());
                    //alert($(this).val());
                });
                //alert(chkboxInvoice.join(","));
                var invoice_id = 0;
                if(flag == "true")
                    invoice_id = $('input[name="rdbtnInvoice"]:checked').val();
                var txtServiceConfirmationNo = $("#txtServiceConfirmationNo").val();
                if(chkboxInvoice.join(",") != "")
                {
                
                    $.ajax({  
                        url:"service_insert_rate.php?type=generateInvoice",  
                        method:"POST",  
                        data:"chkboxInvoice="+chkboxInvoice.join(",")+"&service_confirmation_id="+txtServiceConfirmationNo+"&invoice_id="+invoice_id,  
                        success:function(data){  
                            if($.trim(data) == "")
                            {
                                alert("Invoice Created Successfully for Selected Service.");
                                closeListModal('invoice');
                                fetchInvoiceProducts('no');
                            }
                            else
                            {
                                alert(data);
                            }
                        }  
                        });  
                }
                else
                {
                    alert("Invoice already generated or select any checkbox please..!");
                }
            } else if (t.dismiss === Swal.DismissReason.cancel) {
                closeListModal('invoice');
                Swal.fire({
                    title: "Cancelled",
                    type: "error"
                });
            }
        });
            
    }
    //Invoice End
    //Proforma Start
    $(document).on('click', '#generateProformaInvoice', function(event){  
    
        event.preventDefault();
        var chkboxProformaInvoice = [];
        $.each($("input[name='chkboxProformaInvoice']:enabled:checked"), function(){
            chkboxProformaInvoice.push($(this).val());
            //alert($(this).val());
        });
        if(chkboxProformaInvoice.join(",") != "")
        {
            var txtServiceConfirmationNo = $("#txtServiceConfirmationNo").val();
            $.ajax({  
                url:"service_insert_rate.php?type=checkPreviousInvoice",  
                method:"POST",  
                data:"service_confirmation_id="+txtServiceConfirmationNo+"&type=Proforma",
                success:function(data){  
                    if(data != "false")
                    {
                        data = JSON.parse(data);
                        var length = data.length;
                        var row = "";
                        $('#proformaList > tbody').empty();
                        for(i=0;i<length;i++)
                        {
                            row += "<tr id='rowProforma"+i+"'>"+
                            "<td style='text-align:center;'>"+data[i].proforma_id+"</td>"+
                            "<td style='text-align:center;'>"+data[i].entry_date+"</td>"+
                            "<td style='text-align:center;'><a href='invoiceProforma.php?proforma_id="+data[i].proforma_id+"' target='_blank'><i class='dripicons-print'></i></a></td>"+
                            "<td style='text-align:center;'><input type='radio' name='rdbtnProforma' value='"+data[i].proforma_id+"'/></td>"+
                            "</tr>";
                        }
                    
                        $('#proformaList > tbody').append(row);
                        openListModal('proforma');
                    }
                    else
                    {
                        registerProforma('false');
                    }
                }  
            });
        }
        else
        {
            Swal.fire({
                title: "Error",
                text: "Please Select any checkbox of Proforma Invoice!",
                type: "error",
                confirmButtonText: "Ok, Sure!",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ml-2 mt-2",
                buttonsStyling: !1
                });
        }
    });
    $(document).on('click', '#assignInProforma', function(event){  
    
        event.preventDefault();  
        if($('input[name="rdbtnProforma"]:checked').val() != undefined)
        {
        //alert($('input[name="rdbtnProforma"]:checked').val());
        registerProforma('true');
        }
        else
        {
        alert("Please select any..!")
        }  
    });
    $(document).on('click', '#newProforma', function(event){  
    
        event.preventDefault();  
        registerProforma('false');
        
    });
    function registerProforma(flag)
    {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes",
            cancelButtonText: "No, cancel!",
            confirmButtonClass: "btn btn-success mt-2",
            cancelButtonClass: "btn btn-danger ml-2 mt-2",
            buttonsStyling: !1
        }).then(function(t) {
                if (t.value) {
                    var chkboxProformaInvoice = [];
                    $.each($("input[name='chkboxProformaInvoice']:enabled:checked"), function(){
                        chkboxProformaInvoice.push($(this).val());
                        //alert($(this).val());
                    });
                    //alert(chkboxInvoice.join(","));
                    var proforma_id = 0;
                    if(flag == "true")
                        proforma_id = $('input[name="rdbtnProforma"]:checked').val();
                    var txtServiceConfirmationNo = $("#txtServiceConfirmationNo").val();
                    if(chkboxProformaInvoice.join(",") != "")
                    {
                    
                        $.ajax({  
                            url:"service_insert_rate.php?type=generateProformaInvoice",  
                            method:"POST",  
                            data:"chkboxProformaInvoice="+chkboxProformaInvoice.join(",")+"&service_confirmation_id="+txtServiceConfirmationNo+"&proforma_id="+proforma_id,  
                            success:function(data){  
                                if($.trim(data) == "")
                                {
                                    alert("Proforma Invoice Created Successfully for Selected Service.");
                                    closeListModal('proforma');
                                    fetchInvoiceProducts('no');
                                }
                                else
                                {
                                    alert(data);
                                }
                            }  
                            });  
                    }
                    else
                    {
                        alert("Proforma Invoice already generated or select any checkbox please..!");
                    }
            } else if (t.dismiss === Swal.DismissReason.cancel) {
                closeListModal('proforma');
                Swal.fire({
                    title: "Cancelled",
                    type: "error"
                });
            }
        });
            
    }
    //Proforma End
    //Cash Start
    $(document).on('click', '#generateCashInvoice', function(event){  
    
        event.preventDefault();
        var chkboxCashInvoice = [];
        $.each($("input[name='chkboxCashInvoice']:enabled:checked"), function(){
            chkboxCashInvoice.push($(this).val());
            //alert($(this).val());
        });
        if(chkboxCashInvoice.join(",") != "")
        {
            var txtServiceConfirmationNo = $("#txtServiceConfirmationNo").val();
            $.ajax({  
                url:"service_insert_rate.php?type=checkPreviousInvoice",  
                method:"POST",  
                data:"service_confirmation_id="+txtServiceConfirmationNo+"&type=Cash",
                success:function(data){  
                    if(data != "false")
                    {
                        data = JSON.parse(data);
                        var length = data.length;
                        var row = "";
                        $('#cashList > tbody').empty();
                        for(i=0;i<length;i++)
                        {
                            row += "<tr id='rowCash"+i+"'>"+
                            "<td style='text-align:center;'>"+data[i].cash_id+"</td>"+
                            "<td style='text-align:center;'>"+data[i].entry_date+"</td>"+
                            "<td style='text-align:center;'><a href='invoiceCash.php?cash_id="+data[i].cash_id+"' target='_blank'><i class='dripicons-print'></i></a></td>"+
                            "<td style='text-align:center;'><input type='radio' name='rdbtnCash' value='"+data[i].cash_id+"'/></td>"+
                            "</tr>";
                        }
                    
                        $('#cashList > tbody').append(row);
                        openListModal('cash');
                    }
                    else
                    {
                        registerCash('false');
                    }
                }  
            });
        }
        else
        {
            Swal.fire({
                title: "Error",
                text: "Please Select any checkbox of Cash Invoice!",
                type: "error",
                confirmButtonText: "Ok, Sure!",
                confirmButtonClass: "btn btn-success mt-2",
                cancelButtonClass: "btn btn-danger ml-2 mt-2",
                buttonsStyling: !1
                });
        }
    });
    $(document).on('click', '#assignInCash', function(event){  
    
        event.preventDefault();  
        if($('input[name="rdbtnCash"]:checked').val() != undefined)
        {
        //alert($('input[name="rdbtnProforma"]:checked').val());
        registerCash('true');
        }
        else
        {
        alert("Please select any..!")
        }  
    });
    $(document).on('click', '#newCash', function(event){  
    
        event.preventDefault();  
        registerCash('false');
        
    });
    function registerCash(flag)
    {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes",
            cancelButtonText: "No, cancel!",
            confirmButtonClass: "btn btn-success mt-2",
            cancelButtonClass: "btn btn-danger ml-2 mt-2",
            buttonsStyling: !1
        }).then(function(t) {
                if (t.value) {
                    var chkboxCashInvoice = [];
                    $.each($("input[name='chkboxCashInvoice']:enabled:checked"), function(){
                        chkboxCashInvoice.push($(this).val());
                        //alert($(this).val());
                    });
                    //alert(chkboxInvoice.join(","));
                    var cash_id = 0;
                    if(flag == "true")
                        cash_id = $('input[name="rdbtnCash"]:checked').val();
                    var txtServiceConfirmationNo = $("#txtServiceConfirmationNo").val();
                    if(chkboxCashInvoice.join(",") != "")
                    {
                    
                        $.ajax({  
                            url:"service_insert_rate.php?type=generateCashInvoice",  
                            method:"POST",  
                            data:"chkboxCashInvoice="+chkboxCashInvoice.join(",")+"&service_confirmation_id="+txtServiceConfirmationNo+"&cash_id="+cash_id,  
                            success:function(data){  
                                if($.trim(data) == "")
                                {
                                    alert("Cash Invoice Created Successfully for Selected Service.");
                                    closeListModal('cash');
                                    fetchInvoiceProducts('no');
                                }
                                else
                                {
                                    alert(data);
                                }
                            }  
                            });  
                    }
                    else
                    {
                        alert("Cash Invoice already generated or select any checkbox please..!");
                    }
            } else if (t.dismiss === Swal.DismissReason.cancel) {
                closeListModal('cash');
                Swal.fire({
                    title: "Cancelled",
                    type: "error"
                });
            }
        });
            
    }
    //Cash End
</script>	
	<script>

function fetchInvoiceProducts(task)
{
	
		//$('#service-list').replaceWith("<tbody id='service-list'></tbody>");
		$txtServiceConfirmationNo = $("#txtServiceConfirmationNo").val();
        // url:'service_fetch_rates.php?txtServiceConfirmationNo='+$txtServiceConfirmationNo+'&last='+task,	
		$.ajax({		
			type:'POST',
			url:'service_fetch_rates.php?txtServiceConfirmationNo='+$txtServiceConfirmationNo+'&last='+task,	
			success:function(data)
			{
				addLoader();
				setTimeout(() => {
					if(task == "yes")
						$('#datatable1 > tbody > #loaderRow').replaceWith(data);
					else
					{
						$('#datatable1 > tbody').empty();
						$('#datatable1 > tbody').append(data);
					}
						
				}, 1000);
			}
		});
}
function fetchAllAmount()
{
	var txtServiceConfirmationNo = $("#txtServiceConfirmationNo").val();
	$.ajax({		
		type:'GET',
		url:"service_insert_rate.php?type=getUpdatedAmount&txtServiceConfirmationNo="+txtServiceConfirmationNo,  	
		success:function(data)
		{
			data = JSON.parse(data);
            $('#total_amt').val(data.total_amount);
			$('#gst_charge').val(data.gst_charge);
			$('#net_amt').val(data.net_amount);
			$('#credit').val(data.credit);
            $('#received').val(data.received);
            $("#PaymentButton").show();
		}
	});
}
$("#txtService").on("change",function(){
    var service_no = $("#txtService").val();
    if($("#gst_type").val() != "NOGST")
    {
        $.ajax({		
            type:'GET',
            url:"service_insert_rate.php?type=getServiceRate&service_no="+service_no,  	
            success:function(data)
            {
                data = JSON.parse(data);
                $('#txtGSTPer').val(data.gst_rate);
            }
	    });
    }
    else
    {
        $('#txtGSTPer').val(0);
    }
});
$("#txtRate").on("blur",function(){
    getCalculatedAmtOfSelectedService();
});
$("#txtQuantity").on("blur",function(){
    getCalculatedAmtOfSelectedService();
    
});
function getCalculatedAmtOfSelectedService()
{
    if($("#txtQuantity").val() != "" && $("#txtRate").val() != "")
    {
        var gstPer = $('#txtGSTPer').val();
        var amountwithgst = parseFloat($("#txtRate").val()) +  (parseFloat($("#txtRate").val()) * parseFloat(gstPer) / 100);
        amountwithgst = $('#txtQuantity').val() * amountwithgst;
        $('#txtGSTAmt').val(amountwithgst.toFixed(2));
    }
    
}
//Edit Modal Calculation
$("#modaltxtService").on("change",function(){
    var service_no = $("#modaltxtService").val();
    if($("#gst_type").val() != "NOGST")
    {
        $.ajax({		
            type:'GET',
            url:"service_insert_rate.php?type=getServiceRate&service_no="+service_no,  	
            success:function(data)
            {
                data = JSON.parse(data);
                $('#modaltxtGSTPer').val(data.gst_rate);
            }
	    });
    }
    else
    {
        $('#modaltxtGSTPer').val(0);
    }
});
$("#modaltxtRate").on("blur",function(){
    getCalculatedAmtOfSelectedServiceModal();
});
$("#modaltxtQuantity").on("blur",function(){
    getCalculatedAmtOfSelectedServiceModal();
    
});
function getCalculatedAmtOfSelectedServiceModal()
{
    if($("#modaltxtQuantity").val() != "" && $("#modaltxtRate").val() != "")
    {
        var gstPer = $('#modaltxtGSTPer').val();
        var amountwithgst = parseFloat($("#modaltxtRate").val()) +  (parseFloat($("#modaltxtRate").val()) * parseFloat(gstPer) / 100);
        amountwithgst = $('#modaltxtQuantity').val() * amountwithgst;
        $('#modaltxtTotalAmt').val(amountwithgst.toFixed(2));
    }
    
}
//End
function addLoader()
{
	loaderRow = "<tr id='loaderRow'><td colspan='13' style='text-align:center;'><img src='Loader.gif' style='width:17%;' id='loader'/></td></tr>";
	$('#datatable1 > tbody:last-child').append(loaderRow);
}
  </script>	
	<script>  
 
		$('#customerForm').on('submit',function(event){  
			event.preventDefault();
			 
			$('#lbl').html("");  
            $("#custloader").show();
            $('#Message').html("Saving..");
			$('#addConfirmation').val("Saving..");  
			setTimeout(() => {
				$.ajax({  
					url:"service_insert_rate.php?type=addCustomerDetails",  
					method:"POST",  
					data:$('#customerForm').serialize(),  
					success:function(data){  
						$('#addConfirmation').val("Saved Successfully"); 
						$('#Message').html("Customer Details Saved Successfully.");
						setTimeout(() => {
                            $("#custloader").hide();
							$('#addConfirmation').val("Save Customer Details"); 
						}, 1000);
						$("#customerForm :input").prop("disabled",true);
						
					},
                    error:function(data)
                    {
                        $("#custloader").hide();
						$('#addConfirmation').val(data); 
                    } 
				});  
			}, 2000);
			
			
      });  
	  $('#productForm').on('submit',function(event){  
			event.preventDefault();
		   	if($("#addConfirmation").is(":disabled"))
			{
				if($('#txtService').val() == 0)  
				{  
						$('#txtService').focus();
						alert("Please Select Service");  
				} 
				else if($('#txtDuration').val() == '')  
				{  
						$('#txtDuration').focus();
						alert("Duration required");  
				}
				else  
				{  
						$txtServiceConfirmationNo = $("#txtServiceConfirmationNo").val();
                        var service_description = CKEDITOR.instances.service_description.getData();
						$.ajax({  
							url:"service_insert_rate.php?type=product&ServiceConfirmationNo="+$txtServiceConfirmationNo,  
							method:"POST",  
							data:$('#productForm').serialize() + '&txt_service_description='+service_description, 
							success:function(data){ 
								 fetchInvoiceProducts("yes");
                                $('#productForm')[0].reset();
                                CKEDITOR.instances.service_description.setData("");
                                $("#buttonDivInv").show();
                                $("#buttonDivPro").show();
                                $("#buttonDivCash").show();
								 fetchAllAmount();
                                
							}  
						});  
						
					
				}  
			}
			else
			{
				alert("Please Save Customer Details First..!");
			}
		    
      });  
      $('#serviceDetailsUpdateForm').on('submit',function(event){  
			event.preventDefault();
            service_confirmation_no = $("#txtServiceConfirmationNo").val();
            var service_description = CKEDITOR.instances.modal_service_description.getData();
            
            $.ajax({  
                url:"service_insert_rate.php?type=updateServiceDetails",  
                method:"POST",  
                data:$('#serviceDetailsUpdateForm').serialize() + '&txt_service_description='+service_description+"&service_confirmation_no="+service_confirmation_no, 
                success:function(data){ 
                   
                    CKEDITOR.instances.modal_service_description.setData("");
                       
                     $("#ServiceDetailsDataEditModal").modal('hide');
                     fetchInvoiceProducts('no');
                    fetchAllAmount();
                }  
            });  
			
		    
      });   
 </script>   
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script>

 $('#customer_name').keyup( function() {
//    if( this.value.length < 1 ) return;
   /* code to run below */
  

  	var custname = document.getElementById( "customer_name" ).value;
    //   alert(custname);
  
  	$.ajax({  
             url:"autocomplete_customer.php?custname="+custname,  
             method:"GET",  
             success:function(data){  
              var customer_list = $.parseJSON(data);
			//   alert(JSON.stringify(data));
				
					$( "#customer_name" ).autocomplete({
                            source: customer_list['customer_name'],
                            select: function(event, ui) 
                                {
                                    var index = customer_list['customer_name'].indexOf(ui.item.value);
                                    $("#customer_id").val(customer_list['customer_id'][index]);
                                    $("#customer_address").val(customer_list['customer_address'][index]);
                                    $("#customer_pincode").val(customer_list['customer_pincode'][index]);
                                    $("#customer_city").val(customer_list['customer_city'][index]);
                                    $("#customer_phone1").val(customer_list['customer_phone1'][index]);
                                    $("#customer_phone2").val(customer_list['customer_phone2'][index]);
                                    $("#customer_email").val(customer_list['customer_email'][index]);
                                    $("#gst_no").val(customer_list['gst_no'][index]);
                                    $("#gst_type").val(customer_list['gst_type'][index]);
                                    var paymentType = customer_list['payment_type'][index].toLowerCase();
                                    $("#payment_type").val(paymentType);
                                }
                        });
				
			 
						
			}  
        }); 
});
</script>
<!-- modal window-->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>   -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="assets/css/modal.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
<!-- end of modal window-->
<script>
function openServiceDetailsModal(id)
{
    $.ajax({		
			type:'GET',
			url:"service_insert_rate.php?type=getServiceDetails&ServiceInclusionNo="+id,
			success:function(data)
			{
                data = JSON.parse(data);
                $("#lbl_description").html(data.description);
                $("#lbl_short_desc").html(data.short_desc);
                $("#lbl_service_name").html(data.service_name);
                $("#lbl_user_name").html(data.user_name);
                $("#lbl_entry_date").html(data.entry_date);
                $("#ServiceDetailsDataModal").modal('show');
                $("#ServiceDetailsDataModal").css("opacity","1");
			}
		});
    
}
function openServiceDetailsEditModal(id)
{
    $.ajax({		
			type:'GET',
			url:"service_insert_rate.php?type=getServiceDetails&ServiceInclusionNo="+id,
			success:function(data)
			{
                data = JSON.parse(data);
                
                CKEDITOR.instances.modal_service_description.setData(data.description);
                 $("#modaltxtService").val(data.product_id);
                $("#service_inclusion_no").html(data.service_inclusion_id);
                $("#modalservice_inclusion_no").val(data.service_inclusion_id);
                $("#modaltxtDuration").val(data.duration);
                $("#modaltxtDurType").val(data.yorm);
                $("#modaltxtQuantity").val(data.quantity);
                $("#modaltxtRate").val(data.service_rate);
                $("#modaltxtGSTPer").val(data.gst);
                $("#modaltxtTotalAmt").val(data.total_amount);
                $("#modalshortdesc").val(data.short_desc);
                $("#ServiceDetailsDataEditModal").modal('show');
                $("#ServiceDetailsDataEditModal").css("opacity","1");
			}
		});
    
}
</script>
<script>
 $("#addPaymentModal").on("click",function(){
	invoice_no = $("#txtServiceConfirmationNo").val();
	$("#label_invoice_no").html(invoice_no);
	$("#modal_invoice_no").val(invoice_no);
	$("#label_credit_amt").html($('#credit').val());
	$("#payment_Modal").modal('show');
    $("#payment_Modal").css("opacity","1");
 });
 $("#payment_form").on("submit",function(event){
	event.preventDefault();
	paid_amount = $('#paid_amount').val();
	credit_amount = $("#label_credit_amt").html();
	
	if(paid_amount == "")
	{
		$('#ModalMessage').html("Please add payment amount.");
		setTimeout(() => {
			$('#ModalMessage').html("");
		}, 1500);
		return false;
	}
	else if(parseFloat(paid_amount) > parseFloat(credit_amount))
	{
		$('#ModalMessage').html("Payment should be less than credit amount.");
		setTimeout(() => {
			$('#ModalMessage').html("");
		}, 1500);
		return false;
	}
	else if(($("#payment_mode_cash").prop("checked") == false) && ($("#payment_mode_cheque").prop("checked") == false) && ($("#payment_mode_other").prop("checked") == false))
	{
		$('#ModalMessage').html("Please select payment mode.");
		setTimeout(() => {
			$('#ModalMessage').html("");
		}, 1500);
		return false;
	}
	else
	{
		$('#addPayment').val("Adding..");
		setTimeout(() => {
			$.ajax({  
				url:"service_insert_rate.php?type=addPayment",  
				method:"POST",  
				data:$('#payment_form').serialize(),  
				success:function(data){  
					$('#ModalMessage').html("Payment Added Successfully.");
					setTimeout(() => {
						$('#getReceipt').show();
						$('#addPayment').val("Add Payment");
						setTimeout(() => {
							$('#ModalMessage').html("");
							$('#paid_amount').val("");
						}, 500);
						$("#payment_invoice_id").val(data);
						fetchAllAmount();
					}, 500);
				}  
			});  
		}, 2000);
	}
	
 });
 $("#addPaymentHistoryModal").on("click",function(){
	invoice_no = $("#txtServiceConfirmationNo").val();
	$("#payment_history_invoice_no").html(invoice_no);
	task = "no";
        $('#paymentList > tbody').empty();
        $.ajax({		
			type:'POST',
			url:'fetch_paymenthistory.php?invoice_no='+invoice_no+"&last="+task,			
			success:function(data)
			{
				loaderRow = "<tr id='loaderRowPayment'><td colspan='8' style='text-align:center;'><img src='Loader.gif' style='width:17%;' id='loader'/></td></tr>";
				$('#paymentList > tbody:last-child').append(loaderRow);
				setTimeout(() => {
					if(task == "yes")
						$('#paymentList > tbody > #loaderRowPayment').replaceWith(data);
					else
					{
						$('#paymentList > tbody').empty();
						$('#paymentList > tbody').append(data);
					}
						
				}, 1000);
			}
		});
        $("#paymentHistoryDataModal").modal("show");
        $("#paymentHistoryDataModal").css("opacity","1");
 });
 $("#getReceipt").on("click",function(){
	payment_invoice_id = $("#payment_invoice_id").val().trim();
	$('#ModalMessage').html("Receipt is generating.. Please Wait..!");
	setTimeout(() => {
		$('#ModalMessage').html("");
		window.open("payment_receipt.php?payment_id="+payment_invoice_id,"_BLANK");
	}, 500);
 });
 function openListModal(type)
 {
    $("#"+type+"HistoryDataModal").modal("show");
    $("#"+type+"HistoryDataModal").css("opacity","1");
 }
 function closeListModal(type)
 {
    $("#"+type+"HistoryDataModal").modal("hide");
    $("#"+type+"HistoryDataModal").css("opacity","0");
 }
 </script>
</body>

</html>