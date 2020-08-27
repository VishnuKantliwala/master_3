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
$page_id=28;
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
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive Table css -->
<link href="assets/libs/rwd-table/rwd-table.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <link href="assets/libs/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <style>
        .btn-toolbar
        {
            display:none !important;
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
                    <h4 class="page-title-main">Service Reminder</h4>
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
                                <div class="responsive-table-plugin">
                                        <div class="table-rep-plugin">
                                            <div class="form-horizontal">
                                                
                                                <div class="form-group row">
                                                        <div class="col-sm-2">
                                                            <select id="serviceList" class="form-control">
                                                                <option value="0">Select Service</option>
                                                                <?php
                                                                $sql = "SELECT product_id,`name` FROM tbl_product";
                                                                $resultP = $cn->selectdb($sql);
                                                                if ($cn->numRows($resultP) > 0) {
                                                                    while ($rowP = $cn->fetchAssoc($resultP)) {
                                                                ?>
                                                                    <option value="<?php echo $rowP['product_id']; ?>"><?php echo $rowP['name']; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="col-lg-6">
                                                        <input class="form-control input-daterange-datepicker" type="text" name="daterange" id="daterange" placeholder="Select Date Range"/>
                                                        </div>
                                                        <div class="col-sm-2">
                                                        <button id="applyFilter" class="btn btn-primary width-md">Filter</button>
                                                        </div>
                                                        <div class="col-sm-2">
                                                        <button id="clearFilter" class="btn btn-primary width-md">Clear</button>
                                                        </div>
                                                    </div>
                                                
                                               
                                            </div>
                                            <div class="table-responsive" data-pattern="priority-columns">
                                                <table id="reminderList" class="table table-striped mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th>Service Name</th>
                                                        <th>Client</th>
                                                        <th>Purchase Date</th>
                                                        <th>Renew Date</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
    
                                        </div>
                                    </div>
                                
                               
                            </div>
                           
                        </div>
                    </div>
                    <!-- end row -->
                </div> <!-- container-fluid -->
            </div> <!-- content -->
            <?php
            include 'footer.php';
            ?>

            <!-- Vendor js -->
            <script src="assets/js/vendor.min.js"></script>
            <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
            <script src="assets/js/pages/sweet-alerts.init.js"></script>
            <!-- Responsive Table js -->
            <script src="assets/libs/rwd-table/rwd-table.min.js"></script>
            <!-- Init js -->
            <script src="assets/js/pages/responsive-table.init.js"></script>

            <script src="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
            <script src="assets/libs/switchery/switchery.min.js"></script>
            <script src="assets/libs/multiselect/jquery.multi-select.js"></script>
            <script src="assets/libs/jquery-quicksearch/jquery.quicksearch.min.js"></script>

            <!-- <script src="assets/libs/select2/select2.min.js"></script> -->
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
                $(document).ready(function() {
                    getRecords('0','','');
                    $("#daterange").val("");
                    
                });
                function getRecords(service_id,from_date,end_date)
                {
                    $.ajax({  
                        url:"getRenewalRecords.php?type=getRenewalRecords",  
                        method:"POST",  
                        data:"service_id="+service_id+"&from_date="+from_date+"&end_date="+end_date,  
                        success:function(data){  
                            //alert(data);
                            if(data != "false")
                            {
                                data = JSON.parse(data);
                                var length = data.length;
                                var row = "<tbody>";
                                $('#reminderList > tbody').empty();
                                for(i=0;i<length;i++)
                                {
                                    row += "<tr id='rowService"+i+"'>"+
                                    "<td >"+data[i].service_name+"</td>"+
                                    "<td >"+data[i].customer_name+"</td>"+
                                    "<td>"+data[i].entry_date+"</td>"+
                                    "<td >"+data[i].renew_date+"</td>"+
                                
                                    "</tr>";
                                }
                                row += "</tbody>";
                                $('#reminderList > tbody').replaceWith(row);
                                //openListModal('invoice');
                            }
                            if(data == "false")
                            {
                                var row = "<tbody>";
                                row += "<tr id='rowService'>"+
                                            "<td colspan='4'>No Reminders..!</td>"+
                                        "</tr>";
                                row += "</tbody>";
                                    $('#reminderList > tbody').replaceWith(row);
                            }
                            else
                            {
                                //registerInvoice('false');
                            }
                            $('#reminderList').DataTable({
                                order: ['0', 'DESC']
                            });
                        }  
                    });
                }
                $("#serviceList").on("change",function(){
                    var serviceId = $("#serviceList").val();
                    var dateRange = $("#daterange").val() == "" ? "" : $("#daterange").val().split("-");
                    var fromDate = "";
                    var endDate = "";
                    if(dateRange != "")
                    {
                        fromDate = dateRange[0].trim() == dateRange[1].trim() ? "" : dateRange[0].trim();
                        endDate = dateRange[0].trim() == dateRange[1].trim() ? "" : dateRange[1].trim();
                    }
                    

                    getRecords(serviceId,fromDate,endDate);
                    //getRecords(serviceId,'','');
                });
                $("#applyFilter").on("click",function(){
                    var serviceId = $("#serviceList").val();
                    var dateRange = $("#daterange").val().split("-");
                    var fromDate = dateRange[0].trim();
                    var endDate = dateRange[1].trim();
                    //alert(fromDate+" "+endDate);
                    getRecords(serviceId,fromDate,endDate);
                });
                $("#clearFilter").on("click",function(){
                    $("#serviceList").val('0');
                    $("#daterange").val("");
                    getRecords('0','','');
                });
                function deleteRecord(id) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel!",
                        confirmButtonClass: "btn btn-success mt-2",
                        cancelButtonClass: "btn btn-danger ml-2 mt-2",
                        buttonsStyling: !1
                    }).then(function(t) {
                        if (t.value) {
                            $.ajax({
                                type: "POST",
                                async: false,
                                url: "service_confirmation_delete.php",
                                data: 'service_confirmation_id=' + id,
                                success: function(data) {
                                    if (data == 'true') {
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "Your record has been deleted.",
                                            type: "success"
                                        }).then(function(){
                                          window.open('serviceConfirmationView.php', '_self');
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Something went to wrong!",
                                            type: "error"
                                        });
                                    }
                                }
                            });
                        } else if (t.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                title: "Cancelled",
                                type: "error"
                            });
                        }
                    });
                }
                
            </script>
</body>

</html>
