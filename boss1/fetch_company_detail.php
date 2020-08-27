<?php
	include_once("../connect.php");
    include_once("../navigationfun.php");
    $cn=new connect();
    $cn->connectdb();

    $inquiry_id = $_POST['inquiry_id'];
    $sql="SELECT * FROM tbl_inquiry WHERE inquiry_id='".$inquiry_id."'";
    //echo $sql;
    $result = $cn->selectdb($sql);
    if($cn->numRows($result)>0){
    	$row = $cn->fetchAssoc($result);
    	echo json_encode($row);
    }else{
    	echo "False";
    }
?>