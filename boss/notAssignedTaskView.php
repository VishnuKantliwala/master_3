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
$page_id=25;
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
    <script src="assets/libs/ckeditor/ckeditor.js"></script>
    <style>
    .form-control {
        padding: 10px;
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
                    <h4 class="page-title-main">Task Confirmation</h4>
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
                            <div class="col-sm-2">
                                <a href="task.php" class="btn btn-primary width-md">Add</a>
                            </div>

                            <div class="col-lg-4">
                                <input class="form-control input-daterange-datepicker" type="text" name="daterange"
                                    id="daterange" placeholder="Select Date Range" />
                            </div>
                            <div class="col-sm-1">
                                <button id="applyFilter" class="btn btn-primary width-md">Filter</button>
                            </div>
                            <div class="col-sm-1">
                                <button id="clearFilter" class="btn btn-primary width-md">Clear</button>
                            </div>
                            <!-- <div class="col-sm-1">
                                <button id="clearFilter" class="btn btn-primary width-md openTaskModal">Open modal</button>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table id="datatable" class="table table-bordered dt-responsive ">
                                    <thead>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Task Name</th>
                                            <th>Quantity</th>
                                            <th>Date</th>
                                            <th>Assign</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>Task Name</th>
                                            <th>Quantity</th>
                                            <th>Date</th>
                                            <th>Assign</th>
                                            <th>Edit</th>
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
            </div> <!-- content -->
            <div id="EmployeeModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h4 class="modal-title">Assign employee for task: <span id="task_name"></span></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" id="EmployeeModalBody">
                            <form id="taskAssignForm">
                                <input type="hidden" name="task_id" id="modal_task_id" />
                                <input type="hidden" name="task_quantity" id="modal_task_quantity" />
                                <input type="hidden" name="modal_task_quantity_assigned" id="modal_task_quantity_assigned" />
                                <input type="hidden" name="row_number" id="row_number" />
                                <table id="empTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Employee Name</th>
                                            <th style="text-align:center;">Quantity</th>
                                            <th style="text-align:center;">Repeatation</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                                <div style="width:100%;display:block" >
                                    <textarea name="task_emp_description" class="form-control"
                                        placeholder="Description"></textarea>
                                    <script>
                                    CKEDITOR.replace('task_emp_description');
                                    </script>
                                    <br/>
                                </div>

                                <div style="width:100%;display:block" class="assignTaskResult">

                                </div>
                                <div style="width:100%;display:block;text-align:center; display:none"
                                    class="assignTaskLoader">
                                    <img src="./assets/images/loading.gif" />
                                </div>

                                <button class="btn btn-success btnAssignTask" type="submit" name="">Assign</button>
                            </form>
                        </div>
                    </div>
                </div>
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
            <!-- <script src="assets/libs/select2/select2.min.js"></script> -->
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
            var shipper_id = "";
            var from_date = "";
            var end_date = "";
            $(document).ready(function() {
                
                getRecords("", "", "");

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
                            url: "not_assigned_task_delete.php",
                            data: 'task_id=' + id,
                            success: function(data) {
                                if (data == 'true') {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Your record has been deleted.",
                                        type: "success"
                                    }).then(function() {
                                        window.open('notAssignedTaskView.php', '_self');
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



            function assignTask(id, qty, qty_assigned, row_number) {
                // alert(id);
                $("#EmployeeModal").modal("show");
                $("#EmployeeModal").css("opacity", "1");
                $('.empTable > tbody').empty();
                $(".assignTaskLoader").show(500);

                $("#modal_task_id").val(id);
                $("#modal_task_quantity").val(qty);
                $("#modal_task_quantity_assigned").val(qty_assigned);
                $("#row_number").val(row_number);

                setTimeout(() => {
                    $.ajax({
                        url: "getUsers.php",
                        method: "POST",
                        data: "task_id=" + id,
                        success: function(data) {
                            // alert(data);
                            if (data != "false") {
                                data = JSON.parse(data);
                                var length = data.length;
                                var row = "<tbody>";
                                for (i = 0; i < length; i++) {

                                    row += "<tr id='rowEmp" + i + "'>" +
                                        "<td ><input type='hidden' name='user_id[]' value='" + data[
                                            i].user_id + "'/>" + data[i].user_name + "</td>" +
                                        "<td ><select class='form-control' name='task_emp_quantity[]'>";
                                    for (let i = 0; i <= qty - qty_assigned; i++) {
                                        row += "<option >" + i + "</option>";
                                    }
                                    row +=
                                        "</select></td>" +
                                        "<td><select class='form-control' name='task_emp_repetition_duration[]'>" +
                                        "<option value='0'>One time</option>" +
                                        "<option value='1'>Weekly</option>" +
                                        "<option value='2'>Monthly</option>" +
                                        "<option value='3'>Quarterly</option>" +
                                        "<option value='4'>Half Yearly</option>" +
                                        "<option value='5'>Yearly</option>" +
                                        "</select></td>" +
                                        "</tr>";
                                }
                                row += "</tbody>";
                                $('#empTable > tbody').replaceWith(row);

                            }
                        },
                    }).done(() => {
                        $(".assignTaskLoader").hide(500);
                    });
                }, 500);

            }

            $('#taskAssignForm').submit(function(e) {

                e.preventDefault();
                // alert("call");
                $(".assignTaskLoader").show(500);
                $(".btnAssignTask").hide();

                const formData = $(this);
                setTimeout(() => {
                    $.ajax({
                        type: "POST",
                        url: "assignTask.php",
                        data: formData.serialize(),
                        cache: false,
                        processData: false,
                        success: (result) => {
                            // alert(result);
                            return result;
                        }
                    }).then((result) => {
                        
                        if ($.trim(result) =='<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Task Assigned Successfully! </div>') {
                            
                            $('#taskAssignForm')[0].reset();
                            $("#EmployeeModal").modal("hide");
                            $("#EmployeeModal").css("opacity", "0");
                            getRecords("", "", "");
                            // $row_number = $('#row_number').val()
                            // $("#rowTask"+$row_number).delete();
                            // getRecords(shipper_id, form_date, end_date);
                            
                            
                            
                            

                        } else {
                            $(".btnAssignTask").show();
                            
                        }
                        $('.assignTaskResult').html(result);
                        $('.assignTaskLoader').hide(500);

                    });
                }, 500);


            });

            // To get records
            function getRecords(shipper_id, from_date, end_date) {
                counter++;
                $.ajax({
                    url: "getNotAssignedTasks.php",
                    method: "POST",
                    data: "shipper_id=" + shipper_id + "&from_date=" + from_date + "&end_date=" + end_date,
                    success: function(data) {
                        //alert(data);
                        if (data != "false") {
                            data = JSON.parse(data);
                            var length = data.length;
                            var row = "<tbody>";
                            $('#datatable > tbody').empty();
                            for (i = 0; i < length; i++) {
                                row += "<tr id='rowTask" + i + "'>" +
                                    "<td >" + data[i].customer_name + "</td>" +
                                    "<td >" + data[i].task_name + "</td>" +
                                    "<td >"+data[i].qty_assigned+" / " + data[i].qty + "</td>" +
                                    "<td >" + data[i].task_date + "</td>" +
                                    "<td ><button onClick='assignTask(" + data[i].task_id +
                                    ", " + data[i].qty + ", " + data[i].qty_assigned + ", " + i + ")' type='button' class='btn btn-success ' >Assign <i class='mdi  mdi-account-multiple-outline'></i></button></td>" +

                                    "<td ><a href='taskUpdate.php?task_id=" + data[i].task_id +
                                    "'><div style='border:1px solid #dee2e6;text-align:center;padding:5px;'>Edit <i class='far fa-edit'></i></div></a></td>" +

                                    "<td ><a onClick='deleteRecord(" + data[i].task_id +
                                    ")'><div style='border:1px solid #dee2e6;text-align:center;padding:5px;'>Delete <i class='mdi mdi-delete'></i></div></a></td>" +
                                    "</tr>";
                            }
                            row += "</tbody>";
                            $('#datatable > tbody').replaceWith(row);

                            //openListModal('invoice');
                        }
                        if (data == "false") {
                            var row = "<tbody>";
                            row += "<tr id='rowTask'>" +
                                "<td colspan='4'>No Records..!</td>" +
                                "</tr>";
                            row += "</tbody>";
                            $('#datatable > tbody').replaceWith(row);
                        } else {
                            //registerInvoice('false');
                        }
                        if (counter == 1) {
                            $('#datatable').DataTable({
                                order: ['1', 'DESC']
                            });
                        }

                    }
                });
            }
            $("#applyFilter").on("click", function() {
                var shipper_id = "";
                var dateRange = $("#daterange").val().split("-");
                var fromDate = dateRange[0].trim();
                var endDate = dateRange[1].trim();
                //alert(fromDate+" "+endDate);
                getRecords(shipper_id, fromDate, endDate);
            });
            $("#clearFilter").on("click", function() {
                
                $("#daterange").val("");
                getRecords('', '', '');
            });
            $("#payment").on("change", function() {
                var payment = $("#payment").val();
                var dateRange = $("#daterange").val() == "" ? "" : $("#daterange").val().split("-");
                var fromDate = "";
                var endDate = "";
                if (dateRange != "") {
                    fromDate = dateRange[0].trim() == dateRange[1].trim() ? "" : dateRange[0].trim();
                    endDate = dateRange[0].trim() == dateRange[1].trim() ? "" : dateRange[1].trim();
                }


                getRecords(payment, fromDate, endDate);
                //getRecords(taskId,'','');
            });
            </script>
</body>

</html>