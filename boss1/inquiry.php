<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
$page_id=14;
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
        <link rel="stylesheet" type="text/css" href="assets/libs/datetimepicker/jquery.datetimepicker.min.css">
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
                        <h4 class="page-title-main">Inquiry</h4>
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

                                <!-- Modal Add Category -->
                                <div class="modal fade none-border" id="add-category">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title mt-0"><strong>Add Inquiry </strong></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" id="formInsert" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="control-label">Start Time</label>
                                                            <input class="form-control form-white" placeholder="Start Time" type="text" id="txtStart" name="txtStart"/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label">End Time</label>
                                                            <input class="form-control form-white" placeholder="End Time" type="text" id="txtEnd" name="txtEnd"/>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Attendant</label>
                                                            <select class="form-control form-white" id="txtAttend" name="txtAttend">
                                                        <?php
                                                            $sql="SELECT attendant_id,attendant_name FROM tbl_attendant";
                                                            $resultA=$cn->selectdb($sql);
                                                            while($rowA=$cn->fetchAssoc($resultA)){
                                                        ?>
                                                                <option value="<?php echo $rowA['attendant_id'];?>"> <?php echo $rowA['attendant_name'];?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Company Name</label>
                                                            <input class="form-control form-white" placeholder="Company name" type="text" id="txtCompany" name="txtCompany"/>
                                                            <div id="suggesstion-box"></div>
                                                            <input type="hidden" name="txtCompanyID" id="txtCompanyID">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Mobile</label>
                                                            <input class="form-control form-white" placeholder="Mobile" type="text" name="txtMobile" id="txtMobile"/>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Email-ID</label>
                                                            <input class="form-control form-white" placeholder="Email-ID" type="text" name="txtEmail" id="txtEmail"/>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Description</label>
                                                            <textarea class="form-control form-white" placeholder="Description" type="text" name="txtDesc" id="txtDesc"></textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Documents</label>
                                                            <input class="form-control form-white" placeholder="Documents" type="file" name="txtFile[]" id="txtFile[]" multiple />
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Status</label>
                                                            <select class="form-control form-white" placeholder="Status" name="txtStatus" id="txtStatus">
                                                                <option value="Pending">Pending</option>
                                                                <option value="Commplete">Complete</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Choose Color</label>
                                                            <select class="form-control form-white" data-placeholder="Choose a color..." id="txtColor" name="txtColor">
                                                                <option value="success" style="background-color: #10c469;color:#fff"> Malachite</option>
                                                                <option value="danger" style="background-color: #ff5b5b;color:#fff">Persimmon</option>
                                                                <option value="primary" style="background-color: #71b6f9;color:#fff">Malibu</option>
                                                                <option value="pink" style="background-color: #ff8acc;color:#fff">Carnation Pink</option>
                                                                <option value="info" style="background-color: #35b8e0;color:#fff">Picton Blue</option>
                                                                <option value="inverse" style="background-color: #3a87ad;color:#fff">Boston Blue</option>
                                                                <option value="warning" style="background-color: #f9c851;color:#fff">Saffron Mango</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                                <button type="button" id="btnInsert" class="btn btn-primary waves-effect waves-light save-category" data-dismiss="modal">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- END MODAL -->
                                <!-- Modal Update Category -->
                                <div class="modal fade none-border" id="update-category">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title mt-0"><strong>Update Inquiry </strong></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" id="formUpdate" enctype="multipart/form-data">
                                                    <input type="hidden" name="txtUID" id="txtUID">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label class="control-label">Start Time</label>
                                                            <input class="form-control form-white" placeholder="Start Time" type="text" id="txtUStart" name="txtUStart"/>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label">End Time</label>
                                                            <input class="form-control form-white" placeholder="End Time" type="text" id="txtUEnd" name="txtUEnd"/>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Attendant</label>
                                                            <select class="form-control form-white" id="txtUAttend" name="txtUAttend">
                                                        <?php
                                                            $sql="SELECT attendant_id,attendant_name FROM tbl_attendant";
                                                            $resultA=$cn->selectdb($sql);
                                                            while($rowA=$cn->fetchAssoc($resultA)){
                                                        ?>
                                                                <option value="<?php echo $rowA['attendant_id'];?>"> <?php echo $rowA['attendant_name'];?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Company Name</label>
                                                            <input class="form-control form-white" placeholder="Company name" type="text" id="txtUCompany" name="txtUCompany"/>
                                                            <div id="Usuggesstion-box"></div>
                                                            <input type="hidden" name="txtUCompanyID" id="txtUCompanyID" name="txtUCompanyID">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Mobile</label>
                                                            <input class="form-control form-white" placeholder="Mobile" type="text" name="txtUMobile" id="txtUMobile"/>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Email-ID</label>
                                                            <input class="form-control form-white" placeholder="Email-ID" type="text" name="txtUEmail" id="txtUEmail"/>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Description</label>
                                                            <textarea class="form-control form-white" placeholder="Description" type="text" name="txtUDesc" id="txtUDesc"></textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Document</label>
                                                            <input class="form-control form-white" placeholder="Document" type="file" name="txtUFile[]" id="txtUFile[]" multiple /><input type="hidden" name="txtImg" id="txtImg">
                                                            <div class="attached-files">
                                                                <ul class="list-inline files-list">
                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Status</label>
                                                            <select class="form-control form-white" placeholder="Status" name="txtUStatus" id="txtUStatus">
                                                                <option value="Pending">Pending</option>
                                                                <option value="Commplete">Complete</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="control-label">Choose Color</label>
                                                            <select class="form-control form-white" data-placeholder="Choose a color..." id="txtUColor" name="txtUColor">
                                                                <option value="success" style="background-color: #10c469;color:#fff"> Malachite</option>
                                                                <option value="danger" style="background-color: #ff5b5b;color:#fff">Persimmon</option>
                                                                <option value="primary" style="background-color: #71b6f9;color:#fff">Malibu</option>
                                                                <option value="pink" style="background-color: #ff8acc;color:#fff">Carnation Pink</option>
                                                                <option value="info" style="background-color: #35b8e0;color:#fff">Picton Blue</option>
                                                                <option value="inverse" style="background-color: #3a87ad;color:#fff">Boston Blue</option>
                                                                <option value="warning" style="background-color: #f9c851;color:#fff">Saffron Mango</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                                <button type="button" id="btnDelete" class="btn btn-danger waves-effect waves-light save-category" data-dismiss="modal">Delete</button>
                                                <button type="button" id="btnUpdate" class="btn btn-primary waves-effect waves-light save-category" data-dismiss="modal">Update</button>
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
        <style type="text/css">
            .add_box{
                position: fixed;
                bottom: 15px;
                right: 25px;
                z-index: 1;
            }
        </style>
        <div class="add_box">
            <img src="assets/add.png" onclick="addInquiry()">
        </div>
        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <!-- fullcalendar plugins -->
        <script src="assets/libs/moment/moment.js"></script>
        <script src="assets/libs/jquery-ui/jquery-ui.min.js"></script>
        <script src="assets/libs/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="assets/libs/datetimepicker/jquery.datetimepicker.full.js"></script>
        <!-- fullcalendar js -->
        <!--script src="assets/js/pages/fullcalendar.init.js"></script-->

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        <script>
            $(document).ready(function() {
                jQuery('#txtStart').datetimepicker({
                    format:'Y-m-d H:i:00',
                    step:15
                });
                jQuery('#txtUStart').datetimepicker({
                    format:'Y-m-d H:i:00',
                    step:15
                });
                jQuery('#txtEnd').datetimepicker({
                    format:'Y-m-d H:i:00',
                    step:15
                });
                jQuery('#txtUEnd').datetimepicker({
                    format:'Y-m-d H:i:00',
                    step:15
                });
                $("#txtStart").change(function() {
                    var e =  new Date(new Date($(this).val()).getTime() + 15*60000).getTime();
                    var time = moment(e).format("YYYY-MM-DD HH:mm:00");
                    $("#txtEnd").val(time);
                });
                $("#txtUStart").change(function() {
                    var e =  new Date(new Date($(this).val()).getTime() + 15*60000).getTime();
                    var time = moment(e).format("YYYY-MM-DD HH:mm:00");
                    $("#txtUEnd").val(time);
                    //$("#txtUEnd").val($(this).val());
                });
                $("#txtCompany").keyup(function(){
                    if($("#txtCompany").val() == ""){
                        $("txtCompanyID").val('');
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "fetch_company.php",
                            data:'keyword='+$(this).val(),
                            success: function(data){
                                $("#suggesstion-box").show();
                                $("#suggesstion-box").html(data);
                                $("#txtCompany").css("background","#FFF");
                            }
                        });
                    }
                });
                $("#txtUCompany").keyup(function(){
                    if($("#txtUCompany").val() == ""){
                        $("#txtUCompanyID").val('');
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "fetch_Ucompany.php",
                            data:'keyword='+$(this).val(),
                            success: function(data){
                                $("#Usuggesstion-box").show();
                                $("#Usuggesstion-box").html(data);
                                $("#txtUCompany").css("background","#FFF");
                            }
                        });
                    }
                });
            });
            function selectCompany(name,id) {
                $("#txtCompany").val(name);
                $("#txtCompanyID").val(id);
                $("#suggesstion-box").hide();
                $.ajax({
                    url: "fetch_company_detail.php",
                    data: {inquiry_id:id},
                    type: "POST",
                    success: function(data) {
                        //console.log(data);
                        if(data!="False"){
                            data = JSON.parse(data);
                            $("#txtMobile").val(data.mobile_no);
                            $("#txtEmail").val(data.email_id);
                            $("#txtStatus").val(data.inquiry_status);
                        }
                    }
                });
            }
            function addInquiry() {
                $("#add-category").modal("show");
            }
            function selectUCompany(name,id) {
                $("#txtUCompany").val(name);
                $("#txtUCompanyID").val(id);
                $("#Usuggesstion-box").hide();
                $.ajax({
                    url: "fetch_company_detail.php",
                    data: {inquiry_id:id},
                    type: "POST",
                    success: function(data) {
                        //console.log(data);
                        if(data!="False"){
                            data = JSON.parse(data);
                            $("#txtUMobile").val(data.mobile_no);
                            $("#txtUEmail").val(data.email_id);
                            $("#txtYStatus").val(data.inquiry_status);
                        }
                    }
                });
            }
            var calendar = $("#calendar").fullCalendar({
                editable:true,
                contentHeight: "auto",
                defaultView: 'month',
                slotDuration: '00:15:00',
                header:{
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,listWeek'
                },
                navLinks: true,
                eventLimit: 4,
                events: "view_inquiry.php",
                selectable: true,
                selectHelper: true,
                select: function(start,end) {
                        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                        $("#txtStart").val(start);
                        $("#txtEnd").val(end);
                        $("#add-category").modal("show");
                },
                eventResize:function(event) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    var id = event.id;
                    $.ajax({
                        type:'POST',
                        url:'resize_update.php',
                        data:{
                            inquiry_detail_id:id,
                            stime:start,
                            etime:end
                        },
                        success:function(data) {
                            calendar.fullCalendar('refetchEvents');
                        }
                    });
                },
                eventDrop:function(event) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    var id = event.id;
                    $.ajax({
                        type:'POST',
                        url:'resize_update.php',
                        data:{
                            inquiry_detail_id:id,
                            stime:start,
                            etime:end
                        },
                        success:function(data) {
                            calendar.fullCalendar('refetchEvents');
                        }
                    });
                },
                eventClick:function(event) {
                    var id = event.id;
                    $.ajax({
                        type:'POST',
                        url:'fetch_inquiry.php',
                        data:{inquiry_detail_id:id},
                        success:function(data){
                            //console.log(data);
                            data = JSON.parse(data);
                            $("#txtUStart").val(data.inquiry_stime);
                            $("#txtUEnd").val(data.inquiry_etime);
                            $("#txtUCompany").val(data.company_name);
                            $("#txtUCompanyID").val(data.inquiry_id);
                            $("#txtUDesc").val(data.description);
                            $("#txtUMobile").val(data.mobile_no);
                            $("#txtUEmail").val(data.email_id);
                            $("#txtUAttend").val(data.attendant_id);
                            $("#txtUColor").val(data.inquiry_color);
                            $("#txtUID").val(data.inquiry_detail_id);
                            $("#txtImg").val(data.meeting_document);
                            $("#txtUStatus").val(data.inquiry_status);
                            var imgs = data.meeting_document.split(",");
                            imgs.pop();
                            var img = "";
                            jQuery.each(imgs,function(i,val) {
                                var ext = val.substring(val.lastIndexOf(".")+1);
                                if(ext=="pdf"){
                                    img+="<li class='list-inline-item file-box'><a href='inquiry/"+val+"' target='_blank'><img src='assets/file/pdf.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a><p class='font-13 mb-1 text-muted'><small><a onclick='imgDel("+data.inquiry_detail_id+",\""+val+"\")'>Delete</a></small></p></li>";
                                }else if(ext=="png" || ext=="jpg" || ext=="jpeg" || ext=="gif"){
                                    img+="<li class='list-inline-item file-box'><a href='inquiry/"+val+"' target='_blank'><img src='inquiry/"+val+"' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a><p class='font-13 mb-1 text-muted'><small><a onclick='imgDel("+data.inquiry_detail_id+",\""+val+"\")'>Delete</a></small></p></li>";
                                }else if(ext=="doc" || ext=="docx"){
                                    img+="<li class='list-inline-item file-box'><a href='inquiry/"+val+"' target='_blank'><img src='assets/file/doc.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a><p class='font-13 mb-1 text-muted'><small><a onclick='imgDel("+data.inquiry_detail_id+",\""+val+"\")'>Delete</a></small></p></li>";
                                }else if(ext=="xls" || ext=="xlsx"){
                                    img+="<li class='list-inline-item file-box'><a href='inquiry/"+val+"' target='_blank'><img src='assets/file/xls.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a><p class='font-13 mb-1 text-muted'><small><a onclick='imgDel("+data.inquiry_detail_id+",\""+val+"\")'>Delete</a></small></p></li>";
                                }else if(ext=="txt"){
                                    img+="<li class='list-inline-item file-box'><a href='inquiry/"+val+"' target='_blank'><img src='assets/file/txt.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a><p class='font-13 mb-1 text-muted'><small><a onclick='imgDel("+data.inquiry_detail_id+",\""+val+"\")'>Delete</a></small></p></li>";
                                }
                            });
                            $(".attached-files ul li").remove();
                            $(".attached-files ul").append(img);
                            $("#update-category").modal("show");
                        }
                    });
                }
            });
            $("#btnInsert").click(function (event) {
                event.preventDefault();
                var form = $('#formInsert')[0];
                var data = new FormData(form);
                $.ajax({
                    type:'POST',
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    cache: false,
                    url:'insert_inquiry.php',
                    data:data,
                    success:function(data){
                        calendar.fullCalendar('refetchEvents');
                        document.getElementById("formInsert").reset();
                    }
                });
            });
            $("#btnUpdate").click(function () {
                event.preventDefault();
                var form = $('#formUpdate')[0];
                var data = new FormData(form);
                $.ajax({
                    type:'POST',
                    enctype: 'multipart/form-data',
                    processData: false,  // Important!
                    contentType: false,
                    cache: false,
                    url:'update_inquiry.php',
                    data:data,
                    success:function(data){
                        //console.log(data);
                        calendar.fullCalendar('refetchEvents');
                        document.getElementById("formUpdate").reset();
                    }
                });
            });
            $("#btnDelete").click(function() {
                var id = $("#txtUID").val();
                $.ajax({
                    type:'POST',
                    url:'delete_inquiry.php',
                    data:{inquiry_detail_id:id},
                    success:function(data){
                        calendar.fullCalendar('refetchEvents');
                        document.getElementById("formUpdate").reset();
                    }
                });
            });
            function imgDel(id,name) {
                $.ajax({
                    type:'POST',
                    url:'delete_image.php',
                    data:{inquiry_detail_id:id,img:name},
                    success:function(data){
                        //data=$.trim(data);
                        //console.log(data);
                        if(data!="false"){
                            data = JSON.parse(data);
                            var imgs = data.meeting_document.split(",");
                            $("#txtImg").val(data.meeting_document);
                            imgs.pop();
                            var img = "";
                            jQuery.each(imgs,function(i,val) {
                                var ext = val.substring(val.lastIndexOf(".")+1);
                                //console.log(ext);
                                if(ext=="pdf"){
                                    img+="<li class='list-inline-item file-box'><a href='inquiry/"+val+"' target='_blank'><img src='assets/file/pdf.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a><p class='font-13 mb-1 text-muted'><small><a onclick='imgDel("+id+",\""+val+"\")'>Delete</a></small></p></li>";
                                }else if(ext=="png" || ext=="jpg" || ext=="jpeg" || ext=="gif"){
                                    img+="<li class='list-inline-item file-box'><a href='inquiry/"+val+"' target='_blank'><img src='inquiry/"+val+"' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a><p class='font-13 mb-1 text-muted'><small><a onclick='imgDel("+id+",\""+val+"\")'>Delete</a></small></p></li>";
                                }else if(ext=="doc" || ext=="docx"){
                                    img+="<li class='list-inline-item file-box'><a href='inquiry/"+val+"' target='_blank'><img src='assets/file/doc.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a><p class='font-13 mb-1 text-muted'><small><a onclick='imgDel("+id+",\""+val+"\")'>Delete</a></small></p></li>";
                                }else if(ext=="xls" || ext=="xlsx"){
                                    img+="<li class='list-inline-item file-box'><a href='inquiry/"+val+"' target='_blank'><img src='assets/file/xls.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a><p class='font-13 mb-1 text-muted'><small><a onclick='imgDel("+id+",\""+val+"\")'>Delete</a></small></p></li>";
                                }else if(ext=="txt"){
                                    img+="<li class='list-inline-item file-box'><a href='inquiry/"+val+"' target='_blank'><img src='assets/file/txt.png' class='img-fluid img-thumbnail' alt='attached-img' width='80'></a><p class='font-13 mb-1 text-muted'><small><a onclick='imgDel("+id+",\""+val+"\")'>Delete</a></small></p></li>";
                                }
                            });
                            $(".attached-files ul li").remove();
                            $(".attached-files ul").append(img);
                        }
                    }
                });
            }
        </script>
        
    </body>
</html>