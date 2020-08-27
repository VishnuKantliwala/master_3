<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
include_once("image_lib_rname.php");
$cn = new connect();
$cn->connectdb();

$start = date_parse_from_format("Y-m-d", date("Y-m-d"));
$end = date_parse_from_format("Y-m-d",date('Y-m-d', strtotime("+1 months", strtotime(date("Y-m-d")))));
$sDate = DateTime::createFromFormat('m-d', $start['month']."-".$start['day']);
$eDate = DateTime::createFromFormat('m-d', $end['month']."-".$end['day']);

$sql = "SELECT B.booking_date,B.shipper_code,S.duration,S.yorm,P.name,SH.shipper_name,SH.shipper_email,SH.shipper_mobile FROM tbl_booking AS B, tbl_servicelist AS S, tbl_product AS P, tbl_shipper AS SH WHERE B.booking_id = S.booking_id AND B.shipper_code = SH.shipper_id AND S.product_id = P.product_id";
	$result = $cn->selectdb($sql);
	while ($row = $cn->fetchAssoc($result)) {
		if($row['yorm'] == "Month"){
			$bdate = date_parse_from_format("Y-m-d",date('Y-m-d', strtotime("+".$row['duration']." months", strtotime($row['booking_date']))));
		}else{
			$n = $row['duration']*12;
			$bdate = date_parse_from_format("Y-m-d",date('Y-m-d', strtotime("+".$n." months", strtotime($row['booking_date']))));
		}
		///$bdate = date_parse_from_format("Y-m-d", $row['booking_date']);
		$date = DateTime::createFromFormat('m-d', $bdate['month']."-".$bdate['day']);
		print_r($date);
		if($sDate->format('md') <= $date->format('md') AND $eDate->format('md') >= $date->format('md')){
				//print_r($row);
				echo "<br>";
		}
	}
?>