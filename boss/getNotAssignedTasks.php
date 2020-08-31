<?
include_once('../connect.php'); 
session_start();
$cn=new connect();
$cn->connectdb();

$filter = "";

$shipper_id = $_POST['shipper_id'];
$from_date = $_POST['from_date'];
$end_date = $_POST['end_date'];

if($shipper_id != "" )
{
    $filter .= " AND s.shipper_id = ".$shipper_id;
    
}
else if($from_date != "" && $end_date != "")
{
    $from_date = date("Y-m-d",strtotime($from_date));
    $end_date = date("Y-m-d",strtotime($end_date));    

    $filter .= " AND (t.task_date BETWEEN '".$from_date."' AND '".$end_date."' + interval 1 day)";
}
$qry = "SELECT t.*,s.shipper_name FROM tbl_task AS t, tbl_shipper AS s WHERE t.shipper_id = s.shipper_id and t.task_quantity != task_quantity_assigned " . $filter . " ORDER BY t.task_id DESC";

$sql = $cn->selectdb($qry);
//echo $qry;
if(mysqli_num_rows($sql) > 0)
{
    $i=0;
    $returnObj = array();
    while($row = mysqli_fetch_assoc($sql))
    {
        $returnObj[$i]["task_id"]=$row['task_id'];
        $returnObj[$i]["customer_name"]=$row['shipper_name'];
        $returnObj[$i]["task_name"]=$row['task_name'];
        $returnObj[$i]["qty"]=$row['task_quantity'];
        $returnObj[$i]["qty_assigned"]=$row['task_quantity_assigned'];
        $returnObj[$i]["task_date"]=date("d-m-Y",strtotime($row['task_date']));
        
        $i++;
    }
    echo json_encode($returnObj);
}
else
{
    echo "false";
}
?>