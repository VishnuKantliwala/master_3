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



$sql = "UPDATE tbl_task_emp SET task_emp_running_status = 1 WHERE task_emp_id='" . $task_emp_id . "'";
$cn->insertdb($sql);

$sql2 = "INSERT INTO tbl_task_emp_log ( `task_emp_id`, `start_date`, `task_emp_log_status`) VALUES (".$task_emp_id.", '".$date."', 1)";
$cn->insertdb($sql2);

// echo "INSERT INTO tbl_task_emp_log ( `task_emp_id`, `start_date`, `task_emp_log_status`) VALUES (".$task_emp_id.", '".$date."', 1)";

if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
    //header("location:bagweightview.php");
