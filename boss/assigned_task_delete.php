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

// Fetch assigned tasks
$sqlTasks = $cn->selectdb("SELECT task_emp_quantity, task_id FROM tbl_task_emp WHERE task_emp_id='" . $task_emp_id . "'");
if( $cn->numRows($sqlTasks) > 0 )
{
    $rowTasks = $cn->fetchAssoc($sqlTasks);
    extract($rowTasks);
    $sqlUpdateTask = $cn->selectdb("UPDATE tbl_task SET task_quantity_assigned = task_quantity_assigned - ".$task_emp_quantity." WHERE task_id=".$task_id);
}

$sql = "DELETE FROM tbl_task_emp WHERE task_emp_id='" . $task_emp_id . "'";
$cn->insertdb($sql);

if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
    //header("location:bagweightview.php");
