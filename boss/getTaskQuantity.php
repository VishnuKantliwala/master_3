<?
include_once('../connect.php'); 
session_start();
$cn=new connect();
$cn->connectdb();

$filter = "";

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes');
}

$task_id = $_GET['task_id'];

$qry = "SELECT t.*,te.* FROM tbl_task AS t, tbl_task_emp AS te WHERE t.task_id = te.task_id  AND task_id = ".$task_id;

$sql = $cn->selectdb($qry);
//echo $qry;
if(mysqli_num_rows($sql) > 0)
{
    $i=0;
    $returnObj = array();
    while($row = mysqli_fetch_assoc($sql))
    {
        $returnObj[$i]["task_id"]=$row['task_id'];
        $returnObj[$i]["shipper_name"]=$row['shipper_name'];
        $returnObj[$i]["task_name"]=$row['task_name'];
        $returnObj[$i]["task_emp_quantity"]=$row['task_emp_quantity'];
        $returnObj[$i]["task_emp_quantity_done"]=$row['task_emp_quantity_done'];
        $returnObj[$i]["task_emp_repetition_duration"]=$row['task_emp_repetition_duration'];
        $returnObj[$i]["date_assign"]=$date = date("j F Y - h : m A",strtotime($row['date_assign']));
        $returnObj[$i]["task_emp_id"]=$row['task_emp_id'];       
        $returnObj[$i]["task_emp_running_status"]=$row['task_emp_running_status'];       
        $returnObj[$i]["time"]=secondsToTime($row['task_emp_duration']);       
        $i++;
    }
    echo json_encode($returnObj);
}
else
{
    echo "false";
}
?>