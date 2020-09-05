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

$sqlNewTime = $cn->selectdb("SELECT `start_time`, `end_time` FROM tbl_user_login AS ul,tbl_user_login_log AS ull WHERE ul.user_login_id = ull.user_login_id AND user_login_log_status = 1 AND ul.user_id = ".$user_id);
if( $cn->numRows($sqlNewTime) > 0 )
{
    $rowNewTime = $cn->fetchAssoc($sqlNewTime);
    $diff =  strtotime($time) - strtotime($rowNewTime['start_time'])  ;
    // echo "in ";
}
else
{
    $diff = 0;
}


$sql1 = "UPDATE tbl_user_login_log SET end_time = '".$time."', `user_login_log_status` = 0 WHERE user_login_log_status = 1 AND user_login_id = (SELECT user_login_id FROM tbl_user_login WHERE  DATEDIFF(user_login_date, CURDATE()) = 0 AND user_id = ".$user_id.") ";  
$cn->insertdb($sql1);



$sql2 = "UPDATE tbl_user_login SET `user_login_status` = 1, user_login_total_time = user_login_total_time + ".$diff." WHERE  DATEDIFF(user_login_date, CURDATE()) = 0 AND user_id = ".$user_id." ";
$cn->insertdb($sql2);

// echo "INSERT INTO tbl_task_emp_log ( `task_emp_id`, `start_date`, `task_emp_log_status`) VALUES (".$task_emp_id.", '".$date."', 1)";

if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
    //header("location:bagweightview.php");
