<?
include_once('../connect.php'); 
session_start();
$cn=new connect();
$cn->connectdb();

$filter = "";

$shipper_id = $_POST['shipper_id'];
$from_date = $_POST['from_date'];
$end_date = $_POST['end_date'];

if($from_date != "" && $end_date != "")
{
    $from_date = date("Y-m-d",strtotime($from_date));
    $end_date = date("Y-m-d",strtotime($end_date));    

    $filter .= " AND (te.date_assign BETWEEN '".$from_date."' AND '".$end_date."' + interval 1 day)";
}
$qry = "SELECT t.*,te.*, u.user_id, u.user_name FROM tbl_task AS t, tbl_task_emp AS te, tbl_user u WHERE t.task_id = te.task_id AND te.user_id = u.user_id " . $filter . " ORDER BY te.task_emp_id DESC";

$sql = $cn->selectdb($qry);
//echo $qry;
if(mysqli_num_rows($sql) > 0)
{
    $i=0;
    $returnObj = array();
    while($row = mysqli_fetch_assoc($sql))
    {
        $returnObj[$i]["task_id"]=$row['task_id'];
        $returnObj[$i]["task_emp_id"]=$row['task_emp_id'];
        $returnObj[$i]["task_name"]=$row['task_name'];
        $returnObj[$i]["user_name"]=$row['user_name'];
        $returnObj[$i]["user_id"]=$row['user_id'];
        $returnObj[$i]["task_emp_quantity"]=$row['task_emp_quantity'];
        $returnObj[$i]["date_assign"]=date("d-m-Y",strtotime($row['date_assign']));
        
        $i++;
    }
    echo json_encode($returnObj);
}
else
{
    echo "false";
}
?>