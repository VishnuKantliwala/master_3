<?
include_once('../connect.php'); 
session_start();
$cn=new connect();
$cn->connectdb();

$filter = "";

$task_id = $_POST['task_id'];

$qry = "SELECT user_name, user_id from tbl_user ORDER BY user_name";

$sql = $cn->selectdb($qry);
//echo $qry;
if(mysqli_num_rows($sql) > 0)
{
    $i=0;
    $returnObj = array();
    while($row = mysqli_fetch_assoc($sql))
    {
        // $sqlAlreadyTask = $cn->selectdb("SELECT task_emp_quantity, task_emp_repetation_duration FROM tbl_task_emp WHERE emp_id = '".$row['user_id']."' AND task_id = ".$task_id);

        $returnObj[$i]["user_id"]=$row['user_id'];
        $returnObj[$i]["user_name"]=$row['user_name'];
        // $returnObj[$i]["task_emp_quantity"]=$row['task_emp_quantity'];
        // $returnObj[$i]["task_emp_repetation_duration"]=$row['task_emp_repetation_duration'];
        
        $i++;
    }
    echo json_encode($returnObj);
}
else
{
    echo "false";
}
?>