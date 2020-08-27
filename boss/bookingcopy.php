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
if (!isset($_GET['booking_id'])) {
    header("location:bookingview.php");
}
$booking_id = $_GET['booking_id'];
$sql = "SELECT * FROM tbl_booking WHERE booking_id='".$booking_id."'";
$resultB = $cn->selectdb($sql);
if($cn->numRows($resultB)>0){
    $rowB = $cn->fetchAssoc($resultB);
}else{
    header("location:bookingview.php");
}
$sql = "SELECT * FROM tbl_servicelist WHERE booking_id='".$rowB['booking_id']."'";
//echo $sql;
$resultSP = $cn->selectdb($sql);

$sql = "INSERT INTO `tbl_booking`(`booking_date`,`shipper_code`,`rate`, `charge`, `total_amount`, `gst_charge`, `net_amount`, `received`, `credit`, `website_link`, `entrypersonname`, `attendant_id`) VALUES ('".$rowB['booking_date']."','".$rowB['shipper_code']."','".$rowB['rate']."','".$rowB['charge']."','".$rowB['total_amount']."','".$rowB['gst_charge']."','".$rowB['net_amount']."','".$rowB['received']."', '".$rowB['credit']."','".$rowB['website_link']."','".$_SESSION['user']."',".$rowB['attendant_id'].")";
    $cn->insertdb($sql);
    $last_id = mysqli_insert_id($cn->getConnection());
    while ($row = $cn->fetchAssoc($resultSP)) {
    	$sql="INSERT INTO tbl_servicelist(booking_id,product_id,duration,yorm,qty,rate,price,remarks) VALUES('".$last_id."','".$row['product_id']."','".$row['duration']."','".$row['yorm']."','".$row['qty']."','".$row['rate']."','".$row['price']."','".$row['remarks']."')";
           // echo $sql;
        $cn->insertdb($sql);
    }
    header("location:bookingUpdate.php?booking_id=".$last_id);
?>
