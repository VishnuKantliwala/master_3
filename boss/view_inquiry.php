<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();

$sql="SELECT D.inquiry_detail_id,s.shipper_name,D.inquiry_stime,D.inquiry_etime,D.inquiry_color FROM tbl_inquiry_detail AS D, tbl_inquiry AS I,tbl_shipper AS s WHERE s.shipper_id = I.shipper_id AND D.inquiry_id = I.inquiry_id";
$result = $cn->selectdb($sql);
while ($row = $cn->fetchAssoc($result)) {
	$data[] = array(
		"id" => $row['inquiry_detail_id'],
		"title" => $row['shipper_name'],
		"start" => $row['inquiry_stime'],
		"end" => $row['inquiry_etime'],
		"className" => 'bg-'.$row['inquiry_color']
	);
}
//print_r($data);
echo json_encode($data);
?>