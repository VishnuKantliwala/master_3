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

$sql = "UPDATE tbl_task_emp SET task_emp_status = 1, date_accept = '".$date."' WHERE task_emp_id='" . $task_emp_id . "'";
$cn->insertdb($sql);

if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
    //header("location:bagweightview.php");
