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
$page_id=27;
?>
<?php
if (isset($_POST['Submit'])) {
    $expense_id = $_POST['expense_id'];
    $amount = $_POST['amount'];
    $file_name = $_POST['oldimg'];
    if($_FILES['file']['name'] != "")
    {
        $file_name = $_FILES['file']['name'];
        $file_size =$_FILES['file']['size'];
        $file_tmp =$_FILES['file']['tmp_name'];
        $file_type=$_FILES['file']['type'];  
    
        move_uploaded_file($file_tmp,"receipt/".$file_name);
    }
    
    $dateTime = date("Y/m/d h:i:s");
    $sql = "UPDATE `tbl_purchase` SET `entry_person_id`=".$_SESSION['user_id'].", `expense_id`=".$expense_id.", `isGST`=".$_POST['isgst'].", `amount`='" . $amount . "',`gst_rate`='".$_POST['gstrate']."', `receipt_img`='".$file_name."',`description`='".$_POST['description']."' WHERE purchase_id = ".$_GET['purchase_id'];
    //echo $sql;
    $cn->insertdb($sql);
    header("location:purchaseView.php");
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
    <!-- dropify -->
    <link href="assets/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
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
                    <h4 class="page-title-main">Purchase</h4>
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
                                <h4 class="m-t-0 header-title">Update Purchase</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <?
                                            $sqlFetch = $cn->selectdb("SELECT * FROM tbl_purchase WHERE purchase_id = ".$_GET['purchase_id']);
                                            if(mysqli_num_rows($sqlFetch) > 0)
                                            {
                                                $rowFetch = mysqli_fetch_assoc($sqlFetch);
                                                ?>
                                                
                                            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="txtName">Expense Type</label>
                                                    <div class="col-sm-3">
                                                    <select id="expense_id" name="expense_id" class="form-control">
                                                        <option disabled selected value="">Select Expense</option>
                                                        <?
                                                        $sql = $cn->selectdb("SELECT * FROM tbl_expense");
                                                        if(mysqli_fetch_assoc($sql) > 0)
                                                        {
                                                            while($row = mysqli_fetch_assoc($sql))
                                                            {
                                                                ?>
                                                                    <option <? if($rowFetch['expense_id'] == $row['expense_id']) echo "selected" ?> value="<? echo $row['expense_id'] ?>"><? echo $row['expense_name'] ?></option>
                                                                <?
                                                            }
                                                        }
                                                        ?>
                                                        </select>
                                                    </div>
                                                    <label class="col-sm-2  col-form-label" for="isgst">Is GST</label>
                                                    <div class="col-sm-3">
                                                        <select id="isgst" name="isgst" class="form-control">
                                                            <option value="1" <? if($rowFetch['isGST'] == 1) echo "selected" ?>>Yes</option>
                                                            <option value="0" <? if($rowFetch['isGST'] == 0) echo "selected" ?>>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2  col-form-label" for="amount">Amount</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="amount" id="amount" class="form-control" value="<? echo $rowFetch['amount'] ?>" placeholder="Amount" required>
                                                    </div>
                                                    <label class="col-sm-2  col-form-label" for="txtGST">GST Rate</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" value="<? echo $rowFetch['gst_rate'] ?>" name="gstrate" id="gstrate" class="form-control" placeholder="GST Rate">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-6">
                                                    
                                                        <textarea name="description" placeholder="Add Description Here" class="form-control" style="height:175px;"><? echo $rowFetch['description'] ?></textarea>
                                                    </div><!-- end col -->
                                                    <div class="col-sm-6">
                                                        <div class="card-box">
                                                            <h4 class="header-title mt-0 mb-3">Bill Reciept (Optional)
                                                            <?
                                                        if($rowFetch['receipt_img'] != "")
                                                        {
                                                            ?>
                                                            <a href="receipt/<? echo $rowFetch['receipt_img'] ?>" target="_BLANK">View Uploaded Image</a>
                                                            <?
                                                        }
                                                        ?>

                                                            </h4>
                                                            <input type="file" name="file" class="dropify" data-height="100" />
                                                        </div>
                                                        
                                                        
                                                        <input type="hidden" name="oldimg" value="<? echo $rowFetch['receipt_img'] ?>" />
                                                    </div><!-- end col -->
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-primary width-md" name="Submit">Update</button>
                                                        <a href="expenseview.php" class="btn btn-lighten-primary waves-effect waves-primary width-md">Cancel</a>
                                                    </div>
                                                </div>
                                            </form>
                                            <?
                                            }
                                            ?>
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
            <!-- dropify js -->
            <script src="assets/libs/dropify/dropify.min.js"></script>

            <!-- form-upload init -->
            <script src="assets/js/pages/form-fileupload.init.js"></script>
<script>
$("#expense_id").on("change",function(){
    var expense_id = $("#expense_id").val();
    $.ajax({		
            type:'GET',
            url:"service_insert_rate.php?type=getExpenseGstRate&expense_id="+expense_id,  	
            success:function(data)
            {
                data = JSON.parse(data);
                $('#gstrate').val(data.gst_rate);
            }
	    });
    
});

</script>
</body>

</html>
