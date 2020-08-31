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
$sql="SELECT d.meeting_document,s.shipper_id FROM tbl_inquiry_detail as d,tbl_inquiry s WHERE d.inquiry_id = s.inquiry_id AND d.inquiry_detail_id='".$inquiry_detail_id."'";
$result=$cn->selectdb($sql);
if($cn->numRows($result)>0){
    $row=$cn->fetchAssoc($result);
    $docs = explode(",",$row['meeting_document']);
    for($i=0;$i<count($docs);$i++)
    {
        if(file_exists("inquiry/". $row['shipper_id'] ."/" . $docs[$i]))
	        unlink("inquiry/". $row['shipper_id'] ."/" . $docs[$i]);
    }
}

$sql="DELETE FROM tbl_inquiry_detail WHERE inquiry_detail_id='".$inquiry_detail_id."'";
//echo $sql;
$cn->insertdb($sql);
if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
?>