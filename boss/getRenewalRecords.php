<?
include_once('../connect.php'); 
session_start();
$cn=new connect();
$cn->connectdb();
if($_GET['type'] == "getRenewalRecords")
{
        $filter = " AND (si.entry_date + INTERVAL 1 YEAR BETWEEN CURDATE() AND CURDATE() + INTERVAL 30 DAY OR si.entry_date + INTERVAL 1 YEAR < CURDATE() - INTERVAL 10 DAY)";
        if($_POST['service_id'] != "0" && $_POST['from_date'] == "" && $_POST['end_date'] == "")
        {
            $filter .= " AND si.product_id = ".$_POST['service_id'];
        }
        else if($_POST['service_id'] == "0" && $_POST['from_date'] != "" && $_POST['end_date'] != "")
        {
            $from_date = date("Y-m-d",strtotime($_POST['from_date']));
            $end_date = date("Y-m-d",strtotime($_POST['end_date']));
            $filter = " AND (si.entry_date + INTERVAL 1 YEAR BETWEEN '".$from_date."' AND '".$end_date."' + interval 1 day)";
        }
        else if($_POST['service_id'] != "0" && $_POST['from_date'] != "" && $_POST['end_date'] != "")
        {
            $from_date = date("Y-m-d",strtotime($_POST['from_date']));
            $end_date = date("Y-m-d",strtotime($_POST['end_date']));
            $filter = "  AND si.product_id = ".$_POST['service_id']." AND (si.entry_date + INTERVAL 1 YEAR BETWEEN '".$from_date."' AND '".$end_date."' + interval 1 day)";
        }
        $qry = "SELECT c.shipper_name,si.entry_date,p.name FROM `tbl_service_inclusion` si,tbl_product p,tbl_shipper c,tbl_service_confirmation sc WHERE si.service_confirmation_id = sc.service_confirmation_id AND si.product_id = p.product_id AND sc.shipper_id = c.shipper_id " . $filter . " ORDER BY si.entry_date ASC";
        $sql = $cn->selectdb($qry);
        //echo $qry;
        if(mysqli_num_rows($sql) > 0)
        {
            $i=0;
            $returnObj = array();
            while($row = mysqli_fetch_assoc($sql))
            {
                $returnObj[$i]["customer_name"]=$row['shipper_name'];
                $returnObj[$i]["service_name"]=$row['name'];
                $returnObj[$i]["entry_date"]=date("d-m-Y",strtotime($row['entry_date']));
                $returnObj[$i]["renew_date"]=date("d-m-Y",strtotime('+1 year',strtotime($row['entry_date'])));
                $i++;
            }
            echo json_encode($returnObj);
        }
        else
        {
            echo "false";
        }
}
?>