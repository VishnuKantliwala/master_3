<?
session_start();
include_once("../connect.php");

$cn=new connect(); 
$cn->connectdb();

$task_emp_id = $_POST['task_emp_id'];
$chkQuantity = $_POST['chkQuantity'];
$task_emp_description = $_POST['task_emp_description'];
$totalQty = $_POST['modal_task_emp_quantity'];

$cnt = 0;
$date = date("Y-m-d h:i:s");

foreach ($_POST['chkQuantity'] as $attributeKey => $attributes){
    // echo $attributeKey.' '.$_POST['mulradio'][$attributeKey].'<br>';
    
    $cn->selectdb("UPDATE tbl_task_emp_qty SET task_emp_status = 1 WHERE  task_emp_qty = ".$_POST['chkQuantity'][$attributeKey]);
    $cnt++;

        
 } //foreach

$diff = 0;
 if($cnt == $totalQty)
 {  
    $diff = 0;
    $sqlNewTime = $cn->selectdb("SELECT `start_date`, `end_date` FROM tbl_task_emp_log WHERE task_emp_log_status = 1 AND task_emp_id = ".$task_emp_id);
    if( $cn->numRows($sqlNewTime) > 0 )
    {
        $rowNewTime = $cn->fetchAssoc($sqlNewTime);
        $diff =  strtotime($date) - strtotime($rowNewTime['start_date'])  ;
    }

    $sql2 = "UPDATE tbl_task_emp_log SET end_date = '".$date."', `task_emp_log_status` = 0 WHERE task_emp_log_status = 1 AND task_emp_id = ".$task_emp_id;  
    $cn->insertdb($sql2);

    

 }
    $cn->selectdb("UPDATE tbl_task_emp SET task_emp_quantity_done = (SELECT COUNT(*) FROM tbl_task_emp_qty WHERE  task_emp_id = ".$task_emp_id." and task_emp_status = 1), task_emp_description = '".$task_emp_description."' WHERE  task_emp_id = ".$task_emp_id);

    $cn->selectdb("UPDATE tbl_task_emp SET task_emp_status = 2, task_emp_running_status = 0, task_emp_duration = task_emp_duration + ".$diff."  WHERE task_emp_quantity = task_emp_quantity_done AND task_emp_id = ".$task_emp_id);

    


    display_success("Task Updated Successfully!");


 
function display_error($error)
{
    echo '<div class="alert alert-warning"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$error.' </div>';
}
function display_success($message)
{
    echo '<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$message.' </div>';
}
// echo "Account successfully updated";		
?>