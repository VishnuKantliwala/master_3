<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
function fetchSName($id){
    $cn = new connect();
    $cn->connectdb();
    $sql="SELECT shipper_name FROM tbl_shipper WHERE shipper_id=$id";
    $res = $cn->selectdb($sql);
    $ro = $cn->fetchAssoc($res);
    return $ro['shipper_name'];
}
$task_id = $_POST['task_id'];
$sql="SELECT task_id,shipper_id,task_desc, task_files FROM tbl_task WHERE task_id='".$task_id."'";
$result = $cn->selectdb($sql);
$row = $cn->fetchAssoc($result);
//print_r($data);
//T.task_id,S.shipper_name, T.task_desc, T.task_files
if($row['shipper_id']==0){
	$data = array(
		"task_id" => $row['task_id'],
		"shipper_name" => "Other",
		"task_desc" => $row['task_desc'],
		"task_files" => $row['task_files']
	);
}else{
	$data = array(
		"task_id" => $row['task_id'],
		"shipper_name" => fetchSName($row['shipper_id']),
		"task_desc" => $row['task_desc'],
		"task_files" => $row['task_files']
	);
}
echo json_encode($data);
?>