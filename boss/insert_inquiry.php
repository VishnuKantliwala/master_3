<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
$attendant_id = $_POST['txtAttend'];
$inquiry_id = $_POST['txtCompanyID'];
$company = $_POST['txtCompany'];
$description = $_POST['txtDesc'];
$stime = $_POST['txtStart'];
$etime = $_POST['txtEnd'];
$mobile = $_POST['txtMobile'];
$email = $_POST['txtEmail'];
$color = $_POST['txtColor'];
$status = $_POST['txtStatus'];
$n = count($_FILES['txtFile']['name']);
$size = array_sum($_FILES['txtFile']['size']);
$files = "";
if($inquiry_id != ""){
	$sql="UPDATE tbl_inquiry SET attendant_id='".$attendant_id."', company_name='".$company."', mobile_no='".$mobile."', email_id='".$email."', inquiry_status='".$status."' WHERE inquiry_id='".$inquiry_id."'";
	$cn->insertdb($sql);
	$last_id = $inquiry_id;
}else{
	$sql="INSERT INTO tbl_inquiry(attendant_id,company_name,mobile_no,email_id,inquiry_status) VALUES('".$attendant_id."','".$company."','".$mobile."','".$email."','".$status."')";
	$cn->insertdb($sql);
	$last_id = mysqli_insert_id($cn->getConnection());
}
if($size>0){
for ($i=0; $i < $n; $i++) { 
	$name = str_shuffle(md5(rand(0,10000)));
	$ext = strtolower(substr($_FILES['txtFile']['name'][$i], strrpos($_FILES['txtFile']['name'][$i],".")));
	$name .=$ext;
	move_uploaded_file($_FILES["txtFile"]["tmp_name"][$i],"inquiry/" .$name);
	$files.=$name.",";
}}
//echo $files;
$sql="INSERT INTO tbl_inquiry_detail(inquiry_id,description,inquiry_stime,inquiry_etime,inquiry_color,meeting_document) VALUES('".$last_id."','".$description."','".$stime."','".$etime."','".$color."','".$files."')";
//echo $sql;
$cn->insertdb($sql);
if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
?>