<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();

$sql="SELECT inquiry_detail_id,company_name,inquiry_stime,inquiry_etime,inquiry_color FROM tbl_inquiry_detail AS D, tbl_inquiry AS I WHERE D.inquiry_id = I.inquiry_id";
$result = $cn->selectdb($sql);
while ($row = $cn->fetchAssoc($result)) {
	$data[] = array(
		"id" => $row['inquiry_detail_id'],
		"title" => $row['company_name'],
		"start" => $row['inquiry_stime'],
		"end" => $row['inquiry_etime'],
		"className" => 'bg-'.$row['inquiry_color']
	);
}
//print_r($data);
echo json_encode($data);
?>