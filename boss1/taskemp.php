<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
$page_id=23;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>ICED Infotech</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <!-- Plugin css -->
        <link href="assets/libs/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .attached-files ul li a{
                cursor: pointer;
            }
            #company-list{
                float:left;
                list-style:none;
                margin-top:-3px;
                padding:0;
                width:97%;
                position: absolute;
                z-index:1;
            }
            #company-list li{
                padding: 10px;
                background: #f0f0f0;
                border-bottom: #bbb9b9 1px solid;
            }
            #company-list li:hover{
                background:#ece3d2;
                cursor: pointer;
            }
            #Ucompany-list{
                float:left;
                list-style:none;
                margin-top:-3px;
                padding:0;
                width:97%;
                position: absolute;
                z-index:1;
            }
            #Ucompany-list li{
                padding: 10px;
                background: #f0f0f0;
                border-bottom: #bbb9b9 1px solid;
            }
            #Ucompany-list li:hover{
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
                    <a href="index.html" class="logo text-center">
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
                        <h4 class="page-title-main">Task</h4>
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
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box">
                                            <div id="calendar"></div>
                                        </div>
                                    </div> <!-- end col -->
                                </div>  <!-- end row -->
                                <!-- Modal Update Category -->
                                <div class="modal fade none-border" id="update-category">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title mt-0"><strong>View Task</strong></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" id="formUpdate" enctype="multipart/form-data">
                                                    <input type="hidden" name="txtID" id="txtID">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="control-label">Name</label>
                                                            <input class="form-control form-white" placeholder="Start Time" type="text" id="txtCustomer" name="txtCustomer"/>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Description</label>
                                                            <div id="divDesc">
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Document</label>
                                                            <div class="attached-files">
                                                                <ul class="list-inline files-list">
                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                                <button type="button" id="btnComplete" class="btn btn-success waves-effect waves-light save-category" data-dismiss="modal">Complete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- END MODAL -->
                            </div><!-- end col-12 -->
                        </div> <!-- end row -->
                    </div> <!-- container-fluid -->
                </div> <!-- content -->
            </div>
        </div>
        <!-- END wrapper -->
        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <!-- fullcalendar plugins -->
        <script src="assets/libs/moment/moment.js"></script>
        <script src="assets/libs/jquery-ui/jquery-ui.min.js"></script>
        <script src="assets/libs/fullcalendar/fullcalendar.min.js"></script>

        <!-- fullcalendar js -->
        <!--script src="assets/js/pages/fullcalendar.init.js"></script-->

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        <script>
            var calendar = $("#calendar").fullCalendar({
                //editable:true,
                contentHeight: "auto",
                header:{
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: "view_task.php",
                eventClick:function(event) {
                    var id = event.id;
                    $.ajax({
                        type:'POST',
                        url:'update_task.php',
                        data:{
                            task_id:id,
                            status: "Pending"
                        },
                        success:function(data){
                            //console.log(data);
                            calendar.fullCalendar('refetchEvents');
                        }
                    });
                    $.ajax({
                        type:'POST',
                        url:'fetch_task.php',
                        data:{task_id:id},
                        success:function(data){
                            //console.log(data);
                            data = JSON.parse(data);
                            $("#txtID").val(data.task_id);
                            $("#txtCustomer").val(data.shipper_name);
                            $("#divDesc").empty();
                            $("#divDesc").append(data.task_desc);
                            var imgs = data.task_files.split(",");
                            imgs.pop();
                            var img = "";
                            jQuery.each(imgs,function(i,val) {
                                var ext = val.substring(val.lastIndexOf(".")+1);
                                if(ext=="pdf"){
                                    img+="<li class='list-inline-item file-box'><a href='task/"+val+"' target='_blank'><img src='assets/file/pdf.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a></li>";
                                }else if(ext=="png" || ext=="jpg" || ext=="jpeg" || ext=="gif"){
                                    img+="<li class='list-inline-item file-box'><a href='task/"+val+"' target='_blank'><img src='task/"+val+"' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a></li>";
                                }else if(ext=="doc" || ext=="docx"){
                                    img+="<li class='list-inline-item file-box'><a href='task/"+val+"' target='_blank'><img src='assets/file/doc.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a></li>";
                                }else if(ext=="xls" || ext=="xlsx"){
                                    img+="<li class='list-inline-item file-box'><a href='task/"+val+"' target='_blank'><img src='assets/file/xls.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a></li>";
                                }else if(ext=="txt"){
                                    img+="<li class='list-inline-item file-box'><a href='task/"+val+"' target='_blank'><img src='assets/file/txt.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a></li>";
                                }
                            });
                            $(".attached-files ul li").remove();
                            $(".attached-files ul").append(img);
                            $("#update-category").modal("show");
                        }
                    });
                }
            });
            $("#btnComplete").click(function() {
                var id = $("#txtID").val();
                $.ajax({
                    type:'POST',
                    url:'update_task.php',
                    data:{
                        task_id:id,
                        status: "Completed"
                    },
                    success:function(data){
                        calendar.fullCalendar('refetchEvents');
                    }
                });
            });
        </script>
        
    </body>
</html>