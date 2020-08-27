<?
session_start();
include_once("../connect.php");
$con=new connect();
$con->connectdb();
$proforma_id =  $_GET['proforma_id'];
//echo "select booking_id from tbl_booking where proforma_id = '".$proforma_id."'";
$sqlSearch = $con->selectdb("select booking_id from tbl_booking where proforma_id = '".$proforma_id."'");
if(mysqli_num_rows($sqlSearch) > 0)
{
    $row = mysqli_fetch_assoc($sqlSearch);
    header("location:bookingUpdate.php?booking_id=".$row['booking_id']."&page=".$page."&mode=c");
}
else
{
    $sql = $con->selectdb("select * from tbl_proforma where proforma_id = '". $proforma_id ."'");
    $row = mysqli_fetch_assoc($sql);

    $con->insertdb("INSERT INTO `tbl_booking`(`booking_date`,`shipper_code`,`rate`, `charge`, `total_amount`, `gst_charge`, `net_amount`, `received`, `credit`, `website_link`, `entrypersonname`, `attendant_id`,`proforma_id`) VALUES ('".$row['booking_date']."','".$row['shipper_code']."','".$row['rate']."','".$row['charge']."','".$row['total_amount']."','".$row['gst_charge']."','".$row['net_amount']."','".$row['received']."', '".$row['credit']."','".$row['website_link']."','".$_SESSION['user']."',".$row['attendant_id'].",".$row['proforma_id'].")");
        
    $last_id = mysqli_insert_id($con->getConnection());

    $sql = $con->selectdb("select * from tbl_proservicelist where proforma_id = ".$proforma_id);
    if(mysqli_num_rows($sql) > 0)
    {
        while($row = mysqli_fetch_assoc($sql))
        {
            $con->insertdb("INSERT INTO `tbl_servicelist`( `booking_id`, `product_id`, `duration`, `yorm`,`qty`,`rate`, `price`) VALUES (".$last_id.",".$row['product_id'].",'".$row['duration']."','".$row['yorm']."',".$row['qty'].",".$row['rate'].",'".$row['price']."')"); 
        }
    }
    header("location:bookingUpdate.php?booking_id=".$last_id."&page=".$page."&mode=s");
}
?>