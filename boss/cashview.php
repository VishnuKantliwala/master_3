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
$page_id=26;
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
    <link href="assets/libs/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
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
                    <h4 class="page-title-main">Cash Invoice</h4>
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
                    <div class="card-box">
                        <div class="form-group row">
                            <div class="col-sm-1">
                                <a href="serviceConfirmation.php" class="btn btn-primary width-md">Add</a>
                            </div>
                            <div class="col-lg-4">
                                <input class="form-control input-daterange-datepicker" type="text" name="daterange" id="daterange" placeholder="Select Date Range"/>
                            </div>
                            <div class="col-sm-1">
                                <button id="applyFilter" class="btn btn-primary width-md">Filter</button>
                            </div>
                            <div class="col-sm-1">
                                <button id="clearFilter" class="btn btn-primary width-md">Clear</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Bill No.</th>
                                            
                                            <th>Date</th>
                                            <th>Total Amount</th>
                                            <th>Entry Person</th>
                                            <th>Print</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Bill No.</th>
                                            
                                            <th>Date</th>
                                            <th>Total Amount</th>
                                            <th>Entry Person</th>
                                            <th>Print</th>
                                            <th>Delete</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div> <!-- container-fluid -->
            </div><!-- content -->
        </div>
            <?php
            include 'footer.php';
            ?>

            <!-- Vendor js -->
            <script src="assets/js/vendor.min.js"></script>
            <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
            <script src="assets/js/pages/sweet-alerts.init.js"></script>
            <!-- third party js -->
            <script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
            <script src="assets/libs/datatables/dataTables.bootstrap4.js"></script>
            <script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
            <script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>
            <!-- third party js ends -->
            <script src="assets/libs/multiselect/jquery.multi-select.js"></script>
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
                    getRecords('','');
                });
                var counter = 0;
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
                                url: "bookingdelete.php",
                                data: 'cash_id=' + id + '&task=CashInvoice',
                                success: function(data) {
                                    // if (data == "true") {
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "Your record has been deleted.",
                                            type: "success"
                                        }).then(function(){
                                            getRecords('','');
                                        });
                                    // } else {
                                    //     Swal.fire({
                                    //         title: "Something went to wrong!",
                                    //         type: "error"
                                    //     });
                                    // }
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
                function getRecords(from_date,end_date)
                {
                    counter++;
                    $.ajax({  
                        url:"getAllTypeRecords.php?type=getCashInvoiceRecords",  
                        method:"POST",  
                        data:"from_date="+from_date+"&end_date="+end_date,  
                        success:function(data){  
                            //alert(data);
                            if(data != "false")
                            {
                                data = JSON.parse(data);
                                var length = data.length;
                                var row = "<tbody>";
                                $('#datatable > tbody').empty();
                                for(i=0;i<length;i++)
                                {
                                    row += "<tr id='rowService"+i+"'>"+
                                    "<td >"+data[i].shipper_name+"</td>"+
                                    "<td >"+data[i].cash_id+"</td>"+
                                    "<td >"+data[i].entry_date+"</td>"+
                                    "<td >"+data[i].total_amount+"</td>"+
                                    "<td >"+data[i].user_name+"</td>"+
                                    "<td ><a href='invoiceCash.php?cash_id="+data[i].cash_id+"' target='_BLANK'><div style='border:1px solid #dee2e6;text-align:center;padding:5px;'>Print <i class='dripicons-print'></i></div></a></td>"+
                                    "<td ><a onClick='deleteRecord("+data[i].cash_id+")'><div style='border:1px solid #dee2e6;text-align:center;padding:5px;'>Delete <i class='mdi mdi-delete'></i></div></a></td>"+
                                    "</tr>";
                                }
                                row += "</tbody>";
                                $('#datatable > tbody').replaceWith(row);
                                
                                //openListModal('invoice');
                            }
                            if(data == "false")
                            {
                                var row = "<tbody>";
                                row += "<tr id='rowService'>"+
                                            "<td colspan='4'>No Records..!</td>"+
                                        "</tr>";
                                row += "</tbody>";
                                    $('#datatable > tbody').replaceWith(row);
                            }
                            else
                            {
                                //registerInvoice('false');
                            }
                            if(counter == 1)
                            {
                                $('#datatable').DataTable({
                                    order: ['1', 'DESC']
                                });
                            }
                            
                        }  
                    });
                }
                $("#applyFilter").on("click",function(){
                    if($("#daterange").val() != "")
                    {
                        var dateRange = $("#daterange").val().split("-");
                        var fromDate = dateRange[0].trim();
                        var endDate = dateRange[1].trim();
                        //alert(fromDate+" "+endDate);
                        getRecords(fromDate,endDate);
                    }
                    
                });
                $("#clearFilter").on("click",function(){
                    getRecords('','');
                });
            </script>
</body>

</html>
