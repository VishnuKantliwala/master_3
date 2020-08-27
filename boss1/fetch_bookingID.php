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
    $sql="SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$database."' AND TABLE_NAME = 'tbl_booking'";
    $result = $cn->selectdb($sql);
    if($cn->numRows($result)>0){
        $row=$cn->fetchAssoc($result);
        echo $row['AUTO_INCREMENT'];
    }
?>                    