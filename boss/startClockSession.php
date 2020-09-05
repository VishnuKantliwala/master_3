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

$sqlTodaysLogin = $cn->selectdb("SELECT user_login_id FROM tbl_user_login WHERE DATEDIFF(user_login_date, CURDATE()) = 0 AND user_id = ".$_SESSION['user_id']." ");
if( $cn->numRows($sqlTodaysLogin) > 0 )
{
    $rowTodaysLogin = $cn->fetchAssoc($sqlTodaysLogin);
    $user_login_id = $rowTodaysLogin['user_login_id'];
}
else
{
    $user_login_id = 0;
}

$sql2 = "INSERT INTO tbl_user_login_log ( `user_login_id`, `start_time`, `user_login_log_status`) VALUES (".$user_login_id.", '".$time."', 1)";
$cn->insertdb($sql2);

// echo "INSERT INTO tbl_task_emp_log ( `task_emp_id`, `start_date`, `task_emp_log_status`) VALUES (".$task_emp_id.", '".$date."', 1)";

if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
    //header("location:bagweightview.php");
