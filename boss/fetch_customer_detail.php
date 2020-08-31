<?php
	include_once("../connect.php");
    include_once("../navigationfun.php");
    $cn=new connect();
    $cn->connectdb();

    $customer_id = $_POST['customer_id'];
    $sql="SELECT * FROM tbl_shipper WHERE shipper_id='".$customer_id."'";
    //echo $sql;
    $result = $cn->selectdb($sql);
    if($cn->numRows($result)>0){
    	$row = $cn->fetchAssoc($result);
    	echo json_encode($row);
    }else{
    	echo "False";
    }
?>