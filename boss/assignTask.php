<?
session_start();
include_once("../connect.php");

$cn=new connect(); 
$cn->connectdb();

$task_id = $_POST['task_id'];
$task_quantity = $_POST['task_quantity'];
$task_emp_description = $_POST['task_emp_description'];

    $task_emp_quantity = 0;
    for($i=0;$i<count($_POST['user_id']);$i++)
    {
        $task_emp_quantity += $_POST['task_emp_quantity'][$i];
    }
    if($task_emp_quantity > $task_quantity)
    {
        display_error("Task is not assigned accourding to quantity.<br/> Quantity - ".$task_quantity.". Assigned - ".$task_emp_quantity);
        return;
    }

    for($i=0;$i<count($_POST['user_id']);$i++)
    {
        if($_POST['task_emp_quantity'][$i] != 0)
        {
            $user_id = $_POST['user_id'][$i];
            $task_emp_quantity = $_POST['task_emp_quantity'][$i];
            $task_emp_repetition_duration = $_POST['task_emp_repetition_duration'][$i];
            $date = date("Y-m-d h:i:s");

            $cn->selectdb("INSERT INTO `tbl_task_emp`( `task_id`, `user_id`, `task_emp_quantity`, `task_emp_repetition_duration`, `task_emp_description`, `date_assign`,`task_emp_duration`,  `task_emp_status`) VALUES (".$task_id.",".$user_id.",".$task_emp_quantity.",".$task_emp_repetition_duration.",'".$task_emp_description."', '".$date."','0' ,0)");

            $lastID = $cn->getLastInsertedID();

            for($i=0; $i<$task_emp_quantity ;$i++)
            {
                $cn->selectdb("INSERT INTO `tbl_task_emp_qty`( `task_emp_id`, `task_emp_status`) VALUES ( ".$lastID.", 0 )");
            }

        }
    }
    $cn->selectdb("UPDATE tbl_task SET task_status = 1, task_quantity_assigned=task_quantity_assigned+".$task_emp_quantity." WHERE task_id=".$task_id);

    display_success("Task Assigned Successfully!");


 
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