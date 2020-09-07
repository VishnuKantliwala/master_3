<?
include_once('../connect.php'); 
session_start();
$cn=new connect();
$cn->connectdb();

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes');
}

$filter = "";
$task_emp_id = $_POST['task_emp_id'];

$qry = "SELECT t.*,te.*, u.user_id, u.user_name FROM tbl_task AS t, tbl_task_emp AS te, tbl_user u WHERE t.task_id = te.task_id AND te.user_id = u.user_id AND te.task_emp_id =".$task_emp_id;

$sql = $cn->selectdb($qry);
//echo $qry;
if(mysqli_num_rows($sql) > 0)
{
    $i=0;
    $returnObj = array();
    while($row = mysqli_fetch_assoc($sql))
    {
        $returnObj[$i]["user_name"]=$row['user_name'];
        $returnObj[$i]["task_name"]=$row['task_name'];
        $returnObj[$i]["task_emp_quantity"]=$row['task_emp_quantity'];
        $returnObj[$i]["task_emp_quantity_done"]=$row['task_emp_quantity_done'];
        $returnObj[$i]["task_emp_repetition_duration"]=$row['task_emp_repetition_duration'];
        $returnObj[$i]["date_assign"]=$row['date_assign'];
        $returnObj[$i]["date_accept"]=$row['date_accept'];
        $returnObj[$i]["date_submit"]=$row['date_submit'];       
        $returnObj[$i]["task_emp_status"]=$row['task_emp_status'];       
        $returnObj[$i]["task_emp_duration"]=secondsToTime($row['task_emp_duration']);  
        $returnObj[$i]["task_emp_expected_time"]=secondsToTime($row['task_emp_expected_time']);  
        
        $i++;
    }
    echo json_encode($returnObj);
}
else
{
    echo "false";
}
?>