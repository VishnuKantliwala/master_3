<?php
    session_start();
    if(!isset($_SESSION['user'])){
	    header("location:login.php");
    }
    include_once("../connect.php");
    include_once("../navigationfun.php");
    $cn=new connect();
    $cn->connectdb();
    $database = $cn->_database;
    $product_id = $_POST['product_id'];
    $sql="SELECT gst_rate FROM tbl_product WHERE product_id=$product_id";
    $result = $cn->selectdb($sql);
    if($cn->numRows($result)>0){
        $row=$cn->fetchAssoc($result);
        echo $row['gst_rate'];
    }
?>                    