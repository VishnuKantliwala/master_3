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
$task_emp_id = $_POST['task_emp_id'];

$date = date("Y-m-d h:i:s");


$sqlNewTime = $cn->selectdb("SELECT `start_date`, `end_date` FROM tbl_task_emp_log WHERE task_emp_log_status = 1 AND task_emp_id = ".$task_emp_id);
if( $cn->numRows($sqlNewTime) > 0 )
{
    $rowNewTime = $cn->fetchAssoc($sqlNewTime);
    $diff =  strtotime($date) - strtotime($rowNewTime['start_date'])  ;
}

$sql = "UPDATE tbl_task_emp SET task_emp_running_status = 0, task_emp_duration = task_emp_duration + ".$diff."  WHERE task_emp_id='" . $task_emp_id . "'";
$cn->insertdb($sql);

// echo "SELECT `start_date`, `end_date` FROM tbl_task_emp_log WHERE task_emp_log_status = 1 AND task_emp_id = ".$task_emp_id;
// echo secondsToTime($diff);

$sql2 = "UPDATE tbl_task_emp_log SET end_date = '".$date."', `task_emp_log_status` = 0 WHERE task_emp_log_status = 1 AND task_emp_id = ".$task_emp_id;  
$cn->insertdb($sql2);


if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}


    //header("location:bagweightview.php");
