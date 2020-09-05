<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
if ($_SESSION['control'] != "admin") {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();

$time = date("h:i:s");
$user_id = $_SESSION['user_id'];

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%h hours, %i minutes');
}


$sqlNewTime = $cn->selectdb("SELECT `user_login_total_time` FROM tbl_user_login WHERE   DATEDIFF(user_login_date, CURDATE()) = 0 AND user_id = ".$user_id." ");
if( $cn->numRows($sqlNewTime) > 0 )
{
    $rowNewTime = $cn->fetchAssoc($sqlNewTime);
    $data_time =  secondsToTime($rowNewTime['user_login_total_time']);
}
else
{
    $data_time =  "0 minutes";
}

echo $data_time;
