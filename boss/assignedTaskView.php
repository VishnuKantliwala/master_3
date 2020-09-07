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
                    <h4 class="page-title-main">Assigned Tasks</h4>
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

                            <!-- <div class="col-sm-1">
                                <button id="clearFilter" class="btn btn-primary width-md openTaskModal">Open modal</button>
                            </div> -->
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <select class="form-control" type="text" name="ddl_shipper_id"
                                    id="ddl_shipper_id" >
                                    <option value="0">-- SELECT CLIENT --</option>
                                    <?
                                    $sqlShipper = $cn->selectdb("SELECT s.shipper_name, s.shipper_id FROM tbl_shipper AS s, tbl_task AS t WHERE s.shipper_id = t.shipper_id ORDER BY s.shipper_name");
                                    if( $cn->numRows($sqlShipper) > 0 )
                                    {
                                        while($rowShipper = $cn->fetchAssoc($sqlShipper))
                                        {
                                    ?>
                                    <option value="<?echo $rowShipper['shipper_id']?>"><?echo $rowShipper['shipper_name']?></option>
                                    <?
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" type="text" name="ddl_user_id"
                                    id="ddl_user_id" >
                                    <option value="0">-- SELECT USER --</option>
                                    <?
                                    $sqlShipper = $cn->selectdb("SELECT u.user_name, u.user_id FROM tbl_user AS u, tbl_task_emp AS te WHERE u.user_id = te.user_id ORDER BY u.user_name");
                                    if( $cn->numRows($sqlShipper) > 0 )
                                    {
                                        while($rowShipper = $cn->fetchAssoc($sqlShipper))
                                        {
                                    ?>
                                    <option value="<?echo $rowShipper['user_id']?>"><?echo $rowShipper['user_name']?></option>
                                    <?
                                        }
                                    }
                                    ?>
                                </select>

                            </div>

                            <div class="col-md-4">
                                <select class="form-control" type="text" name="ddl_task_status"
                                    id="ddl_task_status" >
                                    <option value="0">All Tasks</option>
                                    <option value="1">Running Tasks</option>
                                    <option value="2">Complete Tasks</option>
                                    
                                </select>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <input class="form-control input-daterange-datepicker" type="text" name="daterange"
                                    id="daterange" placeholder="Select Date Range" />
                            </div>
                            <div class="col-md-2">
                                <button id="applyFilter" class="btn btn-primary width-md">Filter</button>
                            </div>
                            <div class="col-md-2">
                                <button id="clearFilter" class="btn btn-primary width-md">Clear</button>
                            </div>

                            <div class="col-md-2">
                                <button id="sorting" class="btn btn-primary width-md">Sorting</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table id="datatable" class="table table-bordered dt-responsive ">
                                    <thead>
                                        <tr>
                                            <th>Task Name</th>
                                            <th>Employee Name</th>
                                            <th>Quantity</th>
                                            <th>Task Date</th>
                                            <th>Timeline</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Task Name</th>
                                            <th>Employee Name</th>
                                            <th>Quantity</th>
                                            <th>Task Date</th>
                                            <th>Timeline</th>
                                            <th>Delete</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td style="">
                                                <div style="" class="">
                                                    
                                                    <img src="./assets/images/loading.gif" />
                                                    
                                                </div>
                                            </td>
                                        <tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div> <!-- container-fluid -->
            </div> <!-- content -->
            <div id="TimelineModal" class="modal fade">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h4 class="modal-title">Task timeline: <span id="user_name"></span></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div style="width:100%;display:block;text-align:center; display:none"
                            class="timelineLoader">
                            
                            <img src="./assets/images/loading.gif" />
                            <br/>
                        </div>
                        <div class="modal-body" id="TimelineModalBody">
                            
                        </div>
                        
                    </div>
                </div>
            </div>

            <div id="TimelineModal" class="modal fade">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h4 class="modal-title">Task timeline: <span id="user_name"></span></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div style="width:100%;display:block;text-align:center; display:none"
                            class="timelineLoader">
                            
                            <img src="./assets/images/loading.gif" />
                            <br/>
                        </div>
                        <div class="modal-body" id="TimelineModalBody">
                            
                        </div>
                        
                    </div>
                </div>
            </div>

            <div id="SortingModal" class="modal fade">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h4 class="modal-title">Sorting tasks</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" id="SortingModalBody">
                            <form id="sortingModal" action="sortingAssignedTasks.php">
                                <h5>Select employee</h5>
                                <div class="form-group">
                                <select name="user_id" class="form-control">
                                <?
                                $sqlFetchEmployee = $cn->selectdb( 'SELECT u.user_id, user_name FROM tbl_user AS u, tbl_task_emp AS te WHERE u.user_id = te.user_id GROUP BY u.user_id ORDER BY user_name' );
                                if( $cn->numRows($sqlFetchEmployee) > 0 )
                                {
                                    while($rowFetchEmployee = $cn->fetchAssoc($sqlFetchEmployee))
                                    {
                                ?>
                                    <option value="<? echo $rowFetchEmployee['user_id'] ?>"><? echo $rowFetchEmployee['user_name'] ?></option>
                                <?
                                    }
                                }
                                ?>    
                                </select>
                                </div>
                                
                                
                                <div style="width:100%;display:block;text-align:center; display:none"
                                    class="assignTaskLoader">
                                    <img src="./assets/images/loading.gif" />
                                </div>

                                <button class="btn btn-success " type="submit" name="">Sort</button>
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
                
                getRecords("", "", "", 0, 0, 0);

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
                            url: "assigned_task_delete.php",
                            data: 'task_emp_id=' + id,
                            success: function(data) {
                                if (data == 'true') {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Your record has been deleted.",
                                        type: "success"
                                    }).then(function() {
                                        window.open('assignedTaskView.php', '_self');
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

            $('#sorting').click(() => {
                $("#SortingModal").modal("show");
                $("#SortingModal").css("opacity", "1"); 
            })

            function showTimeline(id, task_id) {
                // alert(id);
                $("#TimelineModal").modal("show");
                $("#TimelineModal").css("opacity", "1");
                
                $('.modal-body').empty();
                $(".timelineLoader").show(500);

                setTimeout(() => {
                    $.ajax({
                        url: "getTimeline.php",
                        method: "POST",
                        data: "task_emp_id=" + id,
                        success: function(data) {
                            // alert(data);
                            if (data != "false") {
                                data = JSON.parse(data);
                                var length = data.length;

                                let status;
                                let step;
                                let date = data[0].date_assign;
                                const quantity = data[0].task_emp_quantity;
                                const done_quantity = data[0].task_emp_quantity_done;
                                const task_emp_duration = data[0].task_emp_duration;
                                const task_emp_expected_time = data[0].task_emp_expected_time;
                                
                                
                                const task_name = data[0].task_name;
                                const user_name = data[0].user_name;
                                $('#user_name').html(user_name);

                                if(data[0].task_emp_status == 0)
                                {
                                    status = "Assigned";
                                    step = 20;
                                }
                                if(data[0].task_emp_status == 1)
                                {
                                    status = "Working";
                                    step = 33 + Math.floor(done_quantity * 66 / quantity);
                                    
                                }
                                if(data[0].task_emp_status == 2)
                                {
                                    status = "Submitted";
                                    // date = data[0].date_submit;
                                    step = 100;
                                }

                                if(data[0].task_emp_status == 3)
                                {
                                    status = "Reappointed";
                                    
                                    step = 33;
                                }
                                
                                var row = "<h3>"+task_name+"</h3><div class='widget-detail-2 text-left'><h2 class='font-weight-normal mb-1'> "+status+" </h2><p class='text-muted mb-3' style='margin-bottom: 1px !important;'>Date - "+date+"</p><p>Expected_time : "+task_emp_expected_time+" | Total time : "+task_emp_duration+"</p><p class='text-muted mb-3'>Task - "+done_quantity+" / "+quantity+"</p></div>";

                                row+="<div class='progress progress-bar-alt-success progress-sm'><div class='progress-bar bg-success' role='progressbar' aria-valuenow='"+step+"' aria-valuemin='0' aria-valuemax='100' style='width: "+step+"%;'><span class='sr-only'>77% Complete</span></div></div>";

                                row += '<br/><div style="width:100%; display:block">';
                                if(data[0].task_emp_status == 2)
                                    row+='<button class="btn btn-blue" onClick="reappointTask('+id+', '+task_id+')">Reappoint Task</button>&nbsp;&nbsp;';
                                row += '<a class="btn btn-success" href="taskUpdate.php?task_id='+task_id+'">Update Task</a></div>';
                                
                                
                                $('.modal-body').html(row);

                            }
                        },
                    }).done(() => {
                        $(".timelineLoader").hide(500);
                    });
                }, 700);

            }

            function reappointTask(id, task_id) {
                // alert(id);
                
                $(".timelineLoader").show(500);
                $('.modal-body').html("<h3>Reappointing....</h3>");

                setTimeout(() => {
                    $.ajax({
                        url: "reappointTask.php",
                        method: "POST",
                        data: "task_emp_id=" + id,
                        success: function(data) {
                            // alert(data);
                            if (data != "false") {
                                showTimeline(id, task_id);
                            }
                            else
                            {
                                $('.modal-body').html("<h3>Something went wrong....</h3>");
                            }
                        },
                    }).done(() => {
                        
                    });
                }, 2000);

            }

            

            // To get records
            function getRecords(shipper_id, from_date, end_date, user_id, task_status) {
                counter++;
                $('#datatable > tbody').html('<tr><td style=""><div style="" class=""><img src="./assets/images/loading.gif" /></div></td><tr>');
                setTimeout(() => {
                    $.ajax({
                    url: "getAssignedTasks.php",
                    method: "POST",
                    data: "shipper_id=" + shipper_id + "&from_date=" + from_date + "&end_date=" + end_date + "&user_id=" + user_id + "&task_status=" + task_status,
                    success: function(data) {
                        //alert(data);
                        if (data != "false") {
                            data = JSON.parse(data);
                            var length = data.length;
                            var row = "<tbody>";
                            $('#datatable > tbody').empty();
                            for (i = 0; i < length; i++) {
                                row += "<tr id='rowTask" + i + "'>" +
                                    "<td >" + data[i].task_name + "</td>" +
                                    "<td >" + data[i].user_name + "</td>" +
                                    "<td >" + data[i].task_emp_quantity + "</td>" +
                                    "<td >" + data[i].date_assign + "</td>" +
                                    "<td ><button onClick='showTimeline(" + data[i].task_emp_id + ", " + data[i].task_id + ")' type='button' class='btn btn-success ' >Timeline <i class='mdi  mdi-chart-timeline'></i></button></td>" +

                                    "<td ><a onClick='deleteRecord(" + data[i].task_emp_id +
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
                }, 200);
                
            }
            $("#applyFilter").on("click", function() {
                var fromDate = "";
                var endDate = "";
                if($("#daterange").val() != "")
                {
                    var dateRange = $("#daterange").val().split("-");
                    fromDate = dateRange[0].trim();
                    endDate = dateRange[1].trim();
                }
                

                var shipper_id = $("#ddl_shipper_id").val();
                var user_id = $("#ddl_user_id").val();
                var task_status = $("#ddl_task_status").val();
                
                //alert(fromDate+" "+endDate);
                getRecords(shipper_id, fromDate, endDate, user_id, task_status);
            });
            $("#clearFilter").on("click", function() {
                
                $("#daterange").val("");
                $("#ddl_shipper_id").val("0");
                $("#ddl_user_id").val("0");
                $("#ddl_task_status").val("0");
                getRecords('', '', '', 0, 0, 0);
            });
            
            </script>
</body>

</html>