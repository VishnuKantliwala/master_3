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
$customer_id = $_POST['txtCompanyID'];
$customer_name = trim($_POST['txtCompany']);
$description = $_POST['txtDesc'];
$stime = $_POST['txtStart'];
$etime = $_POST['txtEnd'];
$address = $_POST['txtAddress'];
$mobile = $_POST['txtMobile'];
$email = $_POST['txtEmail'];
$color = $_POST['txtColor'];
$status = $_POST['txtStatus'];
$n = count($_FILES['txtFile']['name']);
$size = array_sum($_FILES['txtFile']['size']);
$entry_date = date("Y-m-d");
$files = "";
if($customer_id != "0"){
	$sql = $cn->selectdb("SELECT shipper_name  FROM tbl_shipper WHERE shipper_id = ".$customer_id);
	if(mysqli_num_rows($sql) > 0)
	{
		$row = mysqli_fetch_assoc($sql);
		if(trim($row['shipper_name']) != $customer_name)
		{
			$cn->insertdb("INSERT INTO tbl_shipper(`shipper_name`, `shipper_address`,`shipper_phone1`,`shipper_email`) VALUES('". $customer_name . "', '". $address."','". $mobile."','". $email ."')");
			$customer_id = mysqli_insert_id($cn->getConnection());
		}
	}
}else{
	$cn->insertdb("INSERT INTO tbl_shipper(`shipper_name`, `shipper_address`,`shipper_phone1`,`shipper_email`) VALUES('". $customer_name . "', '". $address."','". $mobile."','". $email ."')");
	$customer_id = mysqli_insert_id($cn->getConnection());
}
$sqlInquiry = $cn->selectdb("SELECT inquiry_id FROM tbl_inquiry WHERE shipper_id = ".$customer_id);
if(mysqli_num_rows($sqlInquiry) > 0)
{
	$rowInquiry = mysqli_fetch_assoc($sqlInquiry);
	$last_id = $rowInquiry['inquiry_id'];
}
else
{
	$sql="INSERT INTO tbl_inquiry(attendant_id,shipper_id) VALUES('".$attendant_id."','".$customer_id."')";
	$cn->insertdb($sql);
	$last_id = mysqli_insert_id($cn->getConnection());
}
if($size>0)
{
	$path = "inquiry/".$customer_id."/";
	if (!file_exists($path)) {
		mkdir($path, 0777, true);
	}
	for ($i=0; $i < $n; $i++) { 
		$name = str_shuffle(md5(rand(0,10000)));
		$ext = strtolower(substr($_FILES['txtFile']['name'][$i], strrpos($_FILES['txtFile']['name'][$i],".")));
		$name .=$ext;
		
		move_uploaded_file($_FILES["txtFile"]["tmp_name"][$i],$path.$name);
		$files.=$name.",";
	}
}
//echo $files;
$sql="INSERT INTO tbl_inquiry_detail(inquiry_id,`description`,inquiry_stime,inquiry_etime,inquiry_color,meeting_document,entry_date,entry_person_id,`status`) VALUES('".$last_id."','".$description."','".$stime."','".$etime."','".$color."','".$files."','".$entry_date."',".$_SESSION['user_id'].",'".$status."')";
//echo $sql;
$cn->insertdb($sql);
if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
?>