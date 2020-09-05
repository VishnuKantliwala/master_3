<?php
ob_start();
session_start();
if(!isset($_SESSION['user']))
{
	header("location:Login.php");
}

include_once("../connect.php");

$cn=new connect();
$cn->connectdb();


$action 				= mysqli_real_escape_string($cn->_connection,$_POST['action']); 
$updateRecordsArray 	= $_POST['recordsArray'];

if ($action == "updateRecordsListings"){
	
	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
		
		$query = "UPDATE tbl_task_emp SET recordListingID = " . $listingCounter . " WHERE task_emp_id = " . $recordIDValue;
		$cn->selectdb($query) or die('Error, insert query failed');
		$listingCounter = $listingCounter + 1;	
	}
	
	echo '<pre>';
	print_r($updateRecordsArray);
	echo '</pre>';
	echo 'If you refresh the page, you will see that records will stay just as you modified.';
}
?>