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
unlink("inquiry/" . $_POST['img']);
$sql = "UPDATE tbl_inquiry_detail SET meeting_document=REPLACE(meeting_document,'".$img."','') WHERE inquiry_detail_id='".$inquiry_detail_id."'";
//echo $sql;
$cn->insertdb($sql);
$sql="SELECT meeting_document FROM tbl_inquiry_detail WHERE inquiry_detail_id='".$inquiry_detail_id."'";
$result=$cn->selectdb($sql);
if($cn->numRows($result)>0){
	$row=$cn->fetchAssoc($result);
	echo json_encode($row);
}else{
	echo "false";
}

?>