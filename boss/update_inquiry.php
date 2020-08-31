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
$customer_id = $_POST['txtUCompanyID'];
$attendant_id = $_POST['txtUAttend'];
$customer_name = $_POST['txtUCompany'];
$description = $_POST['txtUDesc'];
$stime = $_POST['txtUStart'];
$etime = $_POST['txtUEnd'];
$mobile = $_POST['txtUMobile'];
$email = $_POST['txtUEmail'];
$address = $_POST['txtUAddress'];
$color = $_POST['txtUColor'];
$img = $_POST['txtImg'];
$status = $_POST['txtUStatus'];
// if($customer_id != "0")
// {
// 	$sql = $cn->selectdb("SELECT shipper_name  FROM tbl_shipper WHERE shipper_id = ".$customer_id);
// 	if(mysqli_num_rows($sql) > 0)
// 	{
// 		$row = mysqli_fetch_assoc($sql);
		// if(trim($row['shipper_name']) != $customer_name)
		// {
		// 	$cn->insertdb("INSERT INTO tbl_shipper(`shipper_name`, `shipper_address`,`shipper_phone1`,`shipper_email`) VALUES('". $customer_name . "', '". $address."','". $mobile."','". $email ."')");
		// 	$customer_id = mysqli_insert_id($cn->getConnection());
		// }
		$cn->insertdb("UPDATE tbl_shipper SET `shipper_name`='". $customer_name . "', `shipper_address`='". $address."',`shipper_phone1`='". $mobile."',`shipper_email`='". $email ."' WHERE shipper_id =".$customer_id);
// 	}
// }
// else{
// 	$cn->insertdb("INSERT INTO tbl_shipper(`shipper_name`, `shipper_address`,`shipper_phone1`,`shipper_email`) VALUES('". $customer_name . "', '". $address."','". $mobile."','". $email ."')");
// 	$customer_id = mysqli_insert_id($cn->getConnection());
// }
echo "UPDATE tbl_shipper SET `shipper_name`='". $customer_name . "', `shipper_address`='". $address."',`shipper_phone1`='". $mobile."',`shipper_email`='". $email ."' WHERE shipper_id =".$customer_id;

if(array_sum($_FILES['txtUFile']['size'])>0){
	$n = count($_FILES['txtUFile']['name']);
	$files = "";
	$path = "inquiry/".$customer_id."/";
	if (!file_exists($path)) {
		mkdir($path, 0777, true);
	}
	for ($i=0; $i < $n; $i++) { 
		$name = str_shuffle(md5(rand(0,10000)));
		$ext = strtolower(substr($_FILES['txtUFile']['name'][$i], strrpos($_FILES['txtUFile']['name'][$i],".")));
		$name .=$ext;
		move_uploaded_file($_FILES["txtUFile"]["tmp_name"][$i],$path.$name);
		$files.=$name.",";
	}
	$files = $img.$files;
	$sql="UPDATE tbl_inquiry_detail SET `description`='".$description."',inquiry_stime='".$stime."',inquiry_etime='".$etime."',inquiry_color='".$color."', meeting_document='".$files."',`status`='".$status."' WHERE inquiry_detail_id=".$inquiry_detail_id;
	//echo $sql;
}else{
	$sql="UPDATE tbl_inquiry_detail SET `description`='".$description."',inquiry_stime='".$stime."',inquiry_etime='".$etime."',inquiry_color='".$color."',`status`='".$status."' WHERE inquiry_detail_id=".$inquiry_detail_id;
}
//echo $sql;
$cn->insertdb($sql);
if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
?>