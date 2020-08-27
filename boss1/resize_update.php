<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
$inquiry_detail_id = $_POST['inquiry_detail_id'];
$stime = $_POST['stime'];
$etime = $_POST['etime'];

$sql="UPDATE tbl_inquiry_detail SET inquiry_stime='".$stime."', inquiry_etime='".$etime."' WHERE inquiry_detail_id='".$inquiry_detail_id."'";
//echo $sql;
$cn->insertdb($sql);
if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
?>