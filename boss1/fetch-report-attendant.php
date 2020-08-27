<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
$sql = "SELECT count(B.booking_id) AS TotalCount, A.attendant_name FROM tbl_booking AS B, tbl_attendant AS A WHERE B.attendant_id = A.attendant_id GROUP BY A.attendant_id";
$result = $cn->selectdb($sql);
$str = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
if($cn->numRows($result)>0){
	$n = $cn->numRows($result);
	$colors = array();
	for ($i=0; $i < $n; $i++) { 
		$d = "'#";
		for ($j=0; $j < 6; $j++) { 
			$k = rand(0,15);
			$d.=$str[$k];
		}
		$d .= "'";
		//echo $d;
		if(in_array($d, $colors)){
			$j--;
		}else{
			array_push($colors, $d);
		}
	}
	//print_r($colors);
	$colors = implode(',', $colors);
	//echo $colors;
	$projects = array();
	$attendants = array();
	$i=0;
	while ($row = $cn->fetchAssoc($result)) {
		array_push($projects, "'".$row['TotalCount']."'");
		array_push($attendants, "'".$row['attendant_name']."'");
	}
	$projects = implode(',', $projects);
	$attendants = implode(',', $attendants);
	//echo $projects;
	//echo $attendants;
	$data = array(
		"projects" => $projects,
		"attendants" => $attendants,
		"colors" => $colors
	);
	echo json_encode($data);
}else{
	echo "false";
}