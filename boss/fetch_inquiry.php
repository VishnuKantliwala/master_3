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
$sql="SELECT D.*,I.company_name,I.mobile_no,I.email_id,I.inquiry_status,I.attendant_id FROM tbl_inquiry AS I,tbl_inquiry_detail AS D WHERE I.inquiry_id=D.inquiry_id AND inquiry_detail_id='".$inquiry_detail_id."'";
$result = $cn->selectdb($sql);
$row = $cn->fetchAssoc($result);
//print_r($data);
echo json_encode($row);
?>