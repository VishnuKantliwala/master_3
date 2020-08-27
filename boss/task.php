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
$page_id=22;
?>
<?php
if (isset($_POST['Submit'])) {
    $customer = $_POST['txtShipperID'];
    $emp = $_POST['txtEmployee'];
    $type = $_POST['txtType'];
    $desc = $_POST['txtDesc'];
    $files = "";
    //$data = date("Y-d-m H:i:s");
    //$date = getdate();
    //$date = $date['year']."-".$date['mon']."-".$date['mday']." ".$date['hours'].":".$date['minutes'].":".$date['seconds'];
    $n = count($_FILES['txtFile']['name']);
    $size = array_sum($_FILES['txtFile']['size']);
    $status = "Created";
    if($size>0){
        for ($i=0; $i < $n; $i++) { 
            $name = str_shuffle(md5(rand(0,10000)));
            $ext = strtolower(substr($_FILES['txtFile']['name'][$i], strrpos($_FILES['txtFile']['name'][$i],".")));
            $name .=$ext;
            move_uploaded_file($_FILES["txtFile"]["tmp_name"][$i],"task/" .$name);
            $files.=$name.",";
        }
    }
    if(isset($_POST['chkOther'])){
        $sql = "INSERT INTO tbl_task(shipper_id,uname, task_type, task_desc, task_files, task_status, task_cdate) VALUES('0','".$emp."','".$type."','".$desc."','".$files."','".$status."',SYSDATE())";
    }else{
        $sql = "INSERT INTO tbl_task(shipper_id,uname,task_type,task_desc,task_files,task_status,task_cdate) VALUES('".$customer."','".$emp."','".$type."','".$desc."','".$files."','".$status."',SYSDATE())";
    }
    echo $sql;
    $cn->insertdb($sql);
    //header("location:taskview.php");
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
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <script src="assets/libs/ckeditor/ckeditor.js"></script>
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
                        <div class="col-12">
                            <div class="card-box">
                                <h4 class="m-t-0 header-title">Add Task</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" enctype="multipart/form-data" role="form" method="post">
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtCustomer">Customer</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" id="txtShipper" name="txtShipper" class="form-control" placeholder="Name">
                                                        <div id="suggesstion-box"></div>
                                                        <input type="hidden" id="txtShipperID" name="txtShipperID" class="form-control">
                                                        <br> Other
                                                        <input type="checkbox" name="chkOther" id="chkOther" checked />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtEmployee">Employee</label>
                                                    <div class="col-sm-10">
                                                      <select name="txtEmployee" id="txtEmployee" class="form-control">
                                                    <?php
                                                        $sql="SELECT uname FROM admintable";
                                                        $result = $cn->selectdb($sql);
                                                        while ($row=$cn->fetchAssoc($result)) {
                                                    ?>
                                                          <option value="<?php echo $row['uname'];?>"><?php echo $row['uname'];?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtType">Task Type</label>
                                                    <div class="col-sm-10">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" checked id="customRadio1" name="txtType" class="custom-control-input" value="New">
                                                            <label class="custom-control-label" for="customRadio1">New</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="customRadio2" name="txtType" class="custom-control-input">
                                                            <label class="custom-control-label" for="customRadio2" value="Support">Support</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtDesc">Description</label>
                                                    <div class="col-sm-10">
                                                      <textarea name="txtDesc" id="txtDesc" class="form-control">
                                                      </textarea>
                                                      <script>
                                                            CKEDITOR.replace('txtDesc');
                                                      </script>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label">Files</label>
                                                    <div class="col-sm-10">
                                                      <input type="file" name="txtFile[]" class="form-control" multiple>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="example-placeholder"></label>
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary width-md" name="Submit">Add</button>
                                                        <a href="taskview.php" class="btn btn-lighten-primary waves-effect waves-primary width-md">Cancel</a>
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

            <!-- App js -->
            <script src="assets/js/app.min.js"></script>
            <script type="text/javascript">
                $("#txtShipper").keyup(function(){
                    if($("#txtShipper").val() == ""){
                        $("#txtShipperID").val('');
                        $("#suggesstion-box").hide();
                        $("#chkOther").prop("checked",true);
                    }else{
                        $("#chkOther").prop("checked",false);
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
