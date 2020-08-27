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
include_once("image_lib_rname.php");
$cn = new connect();
$cn->connectdb();
$page_id=21;
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
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
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
                    <h4 class="page-title-main">Renewal Report</h4>
                </li>

            </ul>
        </div>
        <!-- end Topbar -->

        <?php
        include 'menu.php';
        ?>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <form class="form-horizontal" action="lbl_print_renew_report.php" autocomplete="off" role="form" method="post" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">Renewal</h4>
                                    <div class="row">
                                      <div class="col-12">
                                          <div class="p-2">
                                                  <div class="form-group row">
                                                      <label class="col-sm-2  col-form-label" for="txtCustomer">Customer Name</label>
                                                      <div class="col-sm-10">
                                                        <input type="text" id="txtShipper" name="txtShipper" class="form-control" placeholder="Name">
                                                        <div id="suggesstion-box"></div>
                                                        <input type="hidden" id="txtShipperID" name="txtShipperID" class="form-control">
                                                        <br> All Customer
                                                        <input type="checkbox" name="chkCustomer" id="chkCustomer" checked />
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label class="col-sm-2  col-form-label" for="txtService">Service Name</label>
                                                      <div class="col-sm-10">
                                                        <select name="txtService" id="txtService" class="form-control">
                                                        <?php
                                                            $sql="SELECT product_id,name FROM tbl_product WHERE is_renew='yes'";
                                                            $result = $cn->selectdb($sql);
                                                            while ($row1=$cn->fetchAssoc($result)) {
                                                        ?>
                                                            <option value="<?php echo $row1['product_id'];?>"><?php echo $row1['name'];?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                        </select>
                                                        <br> All Employee
                                                        <input type="checkbox" name="chkService" data-plugin="switchery" data-color="#00b19d" data-size="small"/>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label class="col-sm-2  col-form-label" for="datepicker">Date</label>
                                                      <div class="col-sm-10">
                                                          <div class="input-daterange input-group" id="date-range">
                                                                <input type="text" required placeholder="from" class="form-control" name="start">
                                                                <input type="text" required placeholder="to" class="form-control" name="end">
                                                            </div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                      <div class="col-sm-10">
                                                          <button type="submit" class="btn btn-primary width-md" name="Submit">Search</button>
                                                          <a href="index.php" class="btn btn-lighten-primary waves-effect waves-primary width-md">Cancel</a>
                                                      </div>
                                                  </div>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- end row -->
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

            <!-- Tablesaw js -->
            <!-- App js -->
            <script src="assets/js/app.min.js"></script>
            <script>
                jQuery("#timepicker22").timepicker({
                    showMeridian: !1,
                    icons: {
                        up: "mdi mdi-chevron-up",
                        down: "mdi mdi-chevron-down"
                    }
                });
                $("#txtShipper").keyup(function(){
                    if($("#txtShipper").val() == ""){
                        $("#txtShipperID").val('');
                        $("#suggesstion-box").hide();
                        $("#chkCustomer").prop("checked",true);
                    }else{
                        $("#chkCustomer").prop("checked",false);
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
                    }
                });
                function selectShipper(name,id) {
                    $("#txtShipper").val(name);
                    $("#txtShipperID").val(id);
                    $("#suggesstion-box").hide();
                }
            </script>

</body>

</html>
