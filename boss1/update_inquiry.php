<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
$inquiry_detail_id = $_POST['txtUID'];
$inquiry_id = $_POST['txtUCompanyID'];
$attendant_id = $_POST['txtUAttend'];
$company = $_POST['txtUCompany'];
$description = $_POST['txtUDesc'];
$stime = $_POST['txtUStart'];
$etime = $_POST['txtUEnd'];
$mobile = $_POST['txtUMobile'];
$email = $_POST['txtUEmail'];
$color = $_POST['txtUColor'];
$img = $_POST['txtImg'];
$status = $_POST['txtUStatus'];
if($inquiry_id != ""){
	$sql="UPDATE tbl_inquiry SET attendant_id='".$attendant_id."', company_name='".$company."', mobile_no='".$mobile."', email_id='".$email."', inquiry_status='".$status."' WHERE inquiry_id='".$inquiry_id."'";
	//echo $sql;
	$cn->insertdb($sql);
	$last_id = $inquiry_id;
}else{
	$sql="INSERT INTO tbl_inquiry(attendant_id,company_name,mobile_no,email_id,inquiry_status) VALUES('".$attendant_id."','".$company."','".$mobile."','".$email."','".$status."')";
	$cn->insertdb($sql);
	$last_id = mysqli_insert_id($cn->getConnection());
}
if(array_sum($_FILES['txtUFile']['size'])>0){
	$n = count($_FILES['txtUFile']['name']);
	$files = "";
	for ($i=0; $i < $n; $i++) { 
		$name = str_shuffle(md5(rand(0,10000)));
		$ext = strtolower(substr($_FILES['txtUFile']['name'][$i], strrpos($_FILES['txtUFile']['name'][$i],".")));
		$name .=$ext;
		move_uploaded_file($_FILES["txtUFile"]["tmp_name"][$i],"inquiry/" .$name);
		$files.=$name.",";
	}
	$files = $img.$files;
	$sql="UPDATE tbl_inquiry_detail SET description='".$description."',inquiry_stime='".$stime."',inquiry_etime='".$etime."',inquiry_color='".$color."', inquiry_id='".$last_id."', meeting_document='".$files."' WHERE inquiry_detail_id='".$inquiry_detail_id."'";
	echo $sql;
}else{
	$sql="UPDATE tbl_inquiry_detail SET description='".$description."',inquiry_stime='".$stime."',inquiry_etime='".$etime."',inquiry_color='".$color."',inquiry_id='".$last_id."' WHERE inquiry_detail_id='".$inquiry_detail_id."'";
}
//echo $sql;
$cn->insertdb($sql);
if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
?>