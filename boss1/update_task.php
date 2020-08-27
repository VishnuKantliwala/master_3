<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
$task_id = $_POST['task_id'];
$status = $_POST['status'];
if($status == "Completed"){
	$sql = "UPDATE tbl_task SET task_status='".$status."',task_edate=SYSDATE() WHERE task_id='".$task_id."'";
	$cn->insertdb($sql);
}else{
	$sql="SELECT task_status FROM tbl_task WHERE task_id='".$task_id."'";
	$result = $cn->selectdb($sql);
	$row = $cn->fetchAssoc($result);
	if($row['task_status']=="Created"){
		$sql = "UPDATE tbl_task SET task_status='".$status."' WHERE task_id='".$task_id."'";
		$cn->insertdb($sql);
	}
}
?>