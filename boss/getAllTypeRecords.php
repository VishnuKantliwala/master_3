<?
include_once('../connect.php'); 
session_start();
$cn=new connect();
$cn->connectdb();
if($_GET['type'] == "getServiceConfirmationRecords")
{
        $filter = "";
        if($_POST['payment'] != "All" && $_POST['from_date'] == "" && $_POST['end_date'] == "")
        {
            if($_POST['payment'] == "Paid")
                $filter .= " AND sc.credit_amount <= 1";
            else
                $filter .= " AND sc.credit_amount >= 1";
        }
        else if($_POST['from_date'] != "" && $_POST['end_date'] != "")
        {
            $from_date = date("Y-m-d",strtotime($_POST['from_date']));
            $end_date = date("Y-m-d",strtotime($_POST['end_date']));
            if($_POST['payment'] == "Paid")
                $filter .= " AND sc.credit_amount <= 1";
            else if($_POST['payment'] == "UnPaid")
                $filter .= " AND sc.credit_amount >= 1";

            $filter .= " AND (sc.entry_date BETWEEN '".$from_date."' AND '".$end_date."' + interval 1 day)";
        }
        $qry = "SELECT sc.*,c.shipper_name,u.user_name,a.attendant_name FROM tbl_service_confirmation AS sc, tbl_shipper AS c, tbl_attendant AS a,tbl_user u WHERE u.user_id = sc.entry_person_id AND a.attendant_id = sc.attendant_id AND sc.shipper_id = c.shipper_id " . $filter . " ORDER BY sc.service_confirmation_id DESC";
        
        $sql = $cn->selectdb($qry);
        //echo $qry;
        if(mysqli_num_rows($sql) > 0)
        {
            $i=0;
            $returnObj = array();
            while($row = mysqli_fetch_assoc($sql))
            {
                $returnObj[$i]["service_confirmation_id"]=$row['service_confirmation_id'];
                $returnObj[$i]["total_amount"]=$row['total_amount'];
                $returnObj[$i]["received_amount"]=$row['received_amount'];
                $returnObj[$i]["credit_amount"]=$row['credit_amount'];
                $returnObj[$i]["customer_name"]=$row['shipper_name'];
                $returnObj[$i]["user_name"]=$row['user_name'];
                $returnObj[$i]["attendant_name"]=$row['attendant_name'];
                $returnObj[$i]["entry_date"]=date("d-m-Y",strtotime($row['entry_date']));
                $i++;
            }
            echo json_encode($returnObj);
        }
        else
        {
            echo "false";
        }
}
if($_GET['type'] == "getInvoiceRecords")
{
        $filter = "";
        if($_POST['from_date'] != "" && $_POST['end_date'] != "")
        {
            $from_date = date("Y-m-d",strtotime($_POST['from_date']));
            $end_date = date("Y-m-d",strtotime($_POST['end_date']));
            $filter .= " AND (i.entry_date BETWEEN '".$from_date."' AND '".$end_date."' + interval 1 day)";
        }
        $qry = "SELECT i.*, (SELECT SUM(si.total_amount) FROM tbl_service_inclusion si WHERE si.invoice_id = i.invoice_id) AS total_amount,c.shipper_name,u.user_name FROM tbl_invoice i,tbl_shipper c,tbl_user u,tbl_service_confirmation sc WHERE i.service_confirmation_id = sc.service_confirmation_id AND u.user_id = i.entry_person_id AND sc.shipper_id = c.shipper_id ".$filter." ORDER BY i.invoice_id DESC";
        
        $sql = $cn->selectdb($qry);
        //echo $qry;
        if(mysqli_num_rows($sql) > 0)
        {
            $i=0;
            $returnObj = array();
            while($row = mysqli_fetch_assoc($sql))
            {
                $returnObj[$i]["invoice_id"]=$row['invoice_id'];
                $returnObj[$i]["shipper_name"]=$row['shipper_name'];
                $returnObj[$i]["total_amount"]=$row['total_amount'];
                $returnObj[$i]["user_name"]=$row['user_name'];
                $returnObj[$i]["entry_date"]=date("d-m-Y",strtotime($row['entry_date']));
                $i++;
            }
            echo json_encode($returnObj);
        }
        else
        {
            echo "false";
        }
}
if($_GET['type'] == "getCashInvoiceRecords")
{
        $filter = "";
        if($_POST['from_date'] != "" && $_POST['end_date'] != "")
        {
            $from_date = date("Y-m-d",strtotime($_POST['from_date']));
            $end_date = date("Y-m-d",strtotime($_POST['end_date']));
            $filter .= " AND (i.entry_date BETWEEN '".$from_date."' AND '".$end_date."' + interval 1 day)";
        }
        $qry = "SELECT i.*, (SELECT SUM(si.total_amount) FROM tbl_service_inclusion si WHERE si.cash_id = i.cash_id) AS total_amount,c.shipper_name,u.user_name FROM tbl_cash i,tbl_shipper c,tbl_user u,tbl_service_confirmation sc WHERE i.service_confirmation_id = sc.service_confirmation_id AND u.user_id = i.entry_person_id AND sc.shipper_id = c.shipper_id ".$filter." ORDER BY i.cash_id DESC";
        
        $sql = $cn->selectdb($qry);
        //echo $qry;
        if(mysqli_num_rows($sql) > 0)
        {
            $i=0;
            $returnObj = array();
            while($row = mysqli_fetch_assoc($sql))
            {
                $returnObj[$i]["cash_id"]=$row['cash_id'];
                $returnObj[$i]["shipper_name"]=$row['shipper_name'];
                $returnObj[$i]["total_amount"]=$row['total_amount'];
                $returnObj[$i]["user_name"]=$row['user_name'];
                $returnObj[$i]["entry_date"]=date("d-m-Y",strtotime($row['entry_date']));
                $i++;
            }
            echo json_encode($returnObj);
        }
        else
        {
            echo "false";
        }
}
if($_GET['type'] == "getProformaInvoiceRecords")
{
        $filter = "";
        if($_POST['from_date'] != "" && $_POST['end_date'] != "")
        {
            $from_date = date("Y-m-d",strtotime($_POST['from_date']));
            $end_date = date("Y-m-d",strtotime($_POST['end_date']));
            $filter .= " AND (i.entry_date BETWEEN '".$from_date."' AND '".$end_date."' + interval 1 day)";
        }
        $qry = "SELECT i.*, (SELECT SUM(si.total_amount) FROM tbl_service_inclusion si WHERE si.proforma_id = i.proforma_id) AS total_amount,c.shipper_name,u.user_name FROM tbl_proforma i,tbl_shipper c,tbl_user u,tbl_service_confirmation sc WHERE i.service_confirmation_id = sc.service_confirmation_id AND u.user_id = i.entry_person_id AND sc.shipper_id = c.shipper_id ".$filter." ORDER BY i.proforma_id DESC";
        
        $sql = $cn->selectdb($qry);
        //echo $qry;
        if(mysqli_num_rows($sql) > 0)
        {
            $i=0;
            $returnObj = array();
            while($row = mysqli_fetch_assoc($sql))
            {
                $returnObj[$i]["proforma_id"]=$row['proforma_id'];
                $returnObj[$i]["shipper_name"]=$row['shipper_name'];
                $returnObj[$i]["total_amount"]=$row['total_amount'];
                $returnObj[$i]["user_name"]=$row['user_name'];
                $returnObj[$i]["entry_date"]=date("d-m-Y",strtotime($row['entry_date']));
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