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

$date = date("Y-m-d h:i:s");

$sql2 = "INSERT INTO tbl_user_login ( `user_id`, `user_login_date`) VALUES (".$_SESSION['user_id'].", '".$date."')";
$cn->insertdb($sql2);

// Check tasks renewal when Clock-in

// Check for task_emp_repetition_duration code

// 1. Weekly
// $cn->selectdb("INSERT INTO `tbl_task_emp` (`task_id`, `user_id`, `task_emp_quantity`, `task_emp_repetition_duration`, `task_emp_description`, `date_assign`)  SELECT `task_id`, `user_id`, `task_emp_quantity`, `task_emp_repetition_duration`, `task_emp_description`, CURDATE() FROM `tbl_task_emp` WHERE DATEDIFF( CURDATE(), date_assign ) = 7 AND task_emp_repetition_duration = 1" );

// // 2. Monthly
// $cn->selectdb("INSERT INTO `tbl_task_emp` (`task_id`, `user_id`, `task_emp_quantity`, `task_emp_repetition_duration`, `task_emp_description`, `date_assign`)  SELECT `task_id`, `user_id`, `task_emp_quantity`, `task_emp_repetition_duration`, `task_emp_description`, CURDATE() FROM `tbl_task_emp` WHERE DATEDIFF( CURDATE(), date_assign ) = 30 AND task_emp_repetition_duration = 2" );

// // 3. Quarterly
// $cn->selectdb("INSERT INTO `tbl_task_emp` (`task_id`, `user_id`, `task_emp_quantity`, `task_emp_repetition_duration`, `task_emp_description`, `date_assign`)  SELECT `task_id`, `user_id`, `task_emp_quantity`, `task_emp_repetition_duration`, `task_emp_description`, CURDATE() FROM `tbl_task_emp` WHERE DATEDIFF( CURDATE(), date_assign ) = 120 AND task_emp_repetition_duration = 3" );

// // 4. Half yearly
// $cn->selectdb("INSERT INTO `tbl_task_emp` (`task_id`, `user_id`, `task_emp_quantity`, `task_emp_repetition_duration`, `task_emp_description`, `date_assign`)  SELECT `task_id`, `user_id`, `task_emp_quantity`, `task_emp_repetition_duration`, `task_emp_description`, CURDATE() FROM `tbl_task_emp` WHERE DATEDIFF( CURDATE(), date_assign ) = 180 AND task_emp_repetition_duration = 4" );

// // 5. Yearly
// $cn->selectdb("INSERT INTO `tbl_task_emp` (`task_id`, `user_id`, `task_emp_quantity`, `task_emp_repetition_duration`, `task_emp_description`, `date_assign`)  SELECT `task_id`, `user_id`, `task_emp_quantity`, `task_emp_repetition_duration`, `task_emp_description`, CURDATE() FROM `tbl_task_emp` WHERE DATEDIFF( CURDATE(), date_assign ) = 365 AND task_emp_repetition_duration = 5" );



if (mysqli_affected_rows($cn->getConnection()) > 0) {
    echo "true";
} else {
    echo "false";
}
    //header("location:bagweightview.php");