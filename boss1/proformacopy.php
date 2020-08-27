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
if (!isset($_GET['proforma_id'])) {
    header("location:proformaview.php");
}
$proforma_id = $_GET['proforma_id'];
$sql = "SELECT * FROM tbl_proforma WHERE proforma_id='".$proforma_id."'";
$resultB = $cn->selectdb($sql);
if($cn->numRows($resultB)>0){
    $rowB = $cn->fetchAssoc($resultB);
}else{
    header("location:proformaview.php");
}
$sql = "SELECT * FROM tbl_proservicelist WHERE proforma_id='".$rowB['proforma_id']."'";
//echo $sql;
$resultSP = $cn->selectdb($sql);

$sql = "INSERT INTO `tbl_proforma`(`booking_date`,`shipper_code`,`rate`, `charge`, `total_amount`, `gst_charge`, `net_amount`, `received`, `credit`, `website_link`, `entrypersonname`, `attendant_id`) VALUES ('".$rowB['booking_date']."','".$rowB['shipper_code']."','".$rowB['rate']."','".$rowB['charge']."','".$rowB['total_amount']."','".$rowB['gst_charge']."','".$rowB['net_amount']."','".$rowB['received']."', '".$rowB['credit']."','".$rowB['website_link']."','".$_SESSION['user']."',".$rowB['attendant_id'].")";
    $cn->insertdb($sql);
    $last_id = mysqli_insert_id($cn->getConnection());
    while ($row = $cn->fetchAssoc($resultSP)) {
    	$sql="INSERT INTO tbl_proservicelist(proforma_id,product_id,duration,yorm,qty,rate,price,remarks) VALUES('".$last_id."','".$row['product_id']."','".$row['duration']."','".$row['yorm']."','".$row['qty']."','".$row['rate']."','".$row['price']."','".$row['remarks']."')";
           // echo $sql;
        $cn->insertdb($sql);
    }
    header("location:proformaUpdate.php?proforma_id=".$last_id);
?>
