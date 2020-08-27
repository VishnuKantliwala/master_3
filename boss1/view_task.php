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

$sql="SELECT task_id,shipper_id,task_cdate,task_status FROM tbl_task  WHERE uname='".$_SESSION['user']."'";
$result = $cn->selectdb($sql);
while ($row = $cn->fetchAssoc($result)) {
	$color="";
	if($row['task_status']=="Created")
		$color = "bg-primary";
	else if($row['task_status']=="Pending")
		$color = "bg-danger";
	else if($row['task_status']=="Completed")
		$color = "bg-success";
	$minutes_to_add = 5;
	$time = new DateTime($row['task_cdate']);
	$time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
	$edate = $time->format('Y-m-d H:i:s');
	if($row['shipper_id']==0){
		$data[] = array(
			"id" => $row['task_id'],
			"title" => "Other",
			"start" => $row['task_cdate'],
			"end" => $edate,
			"className" => $color
		);
	}else{
		$data[] = array(
			"id" => $row['task_id'],
			"title" => fetchSName($row['shipper_id']),
			"start" => $row['task_cdate'],
			"end" => $edate,
			"className" => $color
		);
	}
	
}
//print_r($data);
echo json_encode($data);
?>