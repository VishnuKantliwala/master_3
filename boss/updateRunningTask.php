<?
session_start();
include_once("../connect.php");

$cn=new connect(); 
$cn->connectdb();

$task_emp_id = $_POST['task_emp_id'];
$chkQuantity = $_POST['chkQuantity'];
$task_emp_description = $_POST['task_emp_description'];

foreach ($_POST['chkQuantity'] as $attributeKey => $attributes){
    // echo $attributeKey.' '.$_POST['mulradio'][$attributeKey].'<br>';
    $cn->selectdb("UPDATE tbl_task_emp_qty SET task_emp_status = 1 WHERE  task_emp_qty = ".$_POST['chkQuantity'][$attributeKey]);
    
 } //foreach
    $cn->selectdb("UPDATE tbl_task_emp SET task_emp_quantity_done = (SELECT COUNT(*) FROM tbl_task_emp_qty WHERE  task_emp_id = ".$task_emp_id." and task_emp_status = 1), task_emp_description = '".$task_emp_description."' WHERE  task_emp_id = ".$task_emp_id);

    $cn->selectdb("UPDATE tbl_task_emp SET task_emp_status = 2 WHERE task_emp_quantity = task_emp_quantity_done AND task_emp_id = ".$task_emp_id);

    


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