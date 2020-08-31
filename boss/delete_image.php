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
$img = $_POST['img'].",";
if(file_exists("inquiry/". $_POST['shipper_id'] ."/" . $_POST['img']))
	unlink("inquiry/". $_POST['shipper_id'] ."/" . $_POST['img']);
$sql = "UPDATE tbl_inquiry_detail SET meeting_document=REPLACE(meeting_document,'".$img."','') WHERE inquiry_detail_id='".$inquiry_detail_id."'";
//echo $sql;
$cn->insertdb($sql);
$sql="SELECT d.meeting_document,s.shipper_id,d.inquiry_detail_id FROM tbl_inquiry_detail as d,tbl_inquiry s WHERE d.inquiry_id = s.inquiry_id AND d.inquiry_detail_id='".$inquiry_detail_id."'";
$result=$cn->selectdb($sql);
if($cn->numRows($result)>0){
	$row=$cn->fetchAssoc($result);
	echo json_encode($row);
}else{
	echo "false";
}

?>