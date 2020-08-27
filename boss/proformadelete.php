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
$proforma_id = $_POST['proforma_id'];
$sql = "DELETE FROM tbl_servicelist WHERE proforma_id='" . $proforma_id . "'";
$cn->insertdb($sql);
$sql = "DELETE FROM tbl_proforma WHERE proforma_id='" . $proforma_id . "'";
//echo $sql;
$cn->insertdb($sql);
if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
    //header("location:bagweightview.php");
