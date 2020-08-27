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
if (!isset($_GET['si_id'])) {
    header("location:customerview.php");
}
$si_id = $_GET['si_id'];
  $sql = "DELETE FROM tbl_shipper_info WHERE si_id='" . $si_id . "'";
  //echo $sql;
  $cn->insertdb($sql);
  header("location:customerupdate.php?shipper_id=".$_GET['shipper_id']);
?>
