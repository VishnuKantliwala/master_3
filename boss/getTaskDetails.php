<?
include_once('../connect.php'); 
session_start();
$cn=new connect();
$cn->connectdb();

$filter = "";

$task_emp_id = $_POST['task_emp_id'];

$qry = "SELECT t.*,te.*, s.shipper_name FROM tbl_task AS t, tbl_task_emp AS te, tbl_shipper AS s WHERE t.task_id = te.task_id AND s.shipper_id = t.shipper_id AND te.task_emp_id=".$task_emp_id;

$sql = $cn->selectdb($qry);
//echo $qry;
if(mysqli_num_rows($sql) > 0)
{
    $i=0;
    
    $returnObj = array();
    while($row = mysqli_fetch_assoc($sql))
    {
        
        $returnObj[$i]["shipper_name"]=$row['shipper_name'];
        $returnObj[$i]["task_name"]=$row['task_name'];
        $returnObj[$i]["task_id"]=$row['task_id'];
        $returnObj[$i]["task_emp_id"]=$row['task_emp_id'];
        $returnObj[$i]["task_emp_description"]=$row['task_emp_description'];
        $returnObj[$i]["task_emp_quantity"]=$row['task_emp_quantity'];
        $returnObj[$i]["task_emp_quantity_done"]=$row['task_emp_quantity_done'];
        $returnObj[$i]["task_emp_repetition_duration"]=$row['task_emp_repetition_duration'];        
        $returnObj[$i]["date_assign"]=$date = date("j F Y - h : m A",strtotime($row['date_assign']));

        $j=0;
        $sqlQty = $cn->selectdb( "SELECT `task_emp_status`, task_emp_qty FROM `tbl_task_emp_qty` WHERE task_emp_id=".$task_emp_id);
        if( $cn->numRows($sqlQty) > 0 )
        {
            while($rowQty = $cn->fetchAssoc($sqlQty))
            {
                $returnObj[$i]["task_emp_status"][$j] = $rowQty["task_emp_status"];
                $returnObj[$i]["task_emp_qty_id"][$j] = $rowQty["task_emp_qty"];
                $j++;
            }

        }
        
        $i++;
    }
    echo json_encode($returnObj);
}
else
{
    echo "false";
}
?>