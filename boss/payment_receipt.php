<?php
session_start();
include_once('../connect.php'); 
$cn=new connect();
$cn->connectdb();
$payment_id = $_GET["payment_id"];
$html = "
<html>
<head>
<title>Payment Receipt | ICED INFOTECH</title>
<style>
@media print {
tr.vendorListHeading {
    background-color: #1a4567 !important;
    -webkit-print-color-adjust: exact; 
}}
@media print {
    .vendorListHeading th {
    color: white !important;
	
}}
body 
{
    height: 842px;
    width: 700px;
    /* to centre page on screen*/
    margin-left: auto;
    margin-right: auto;
    font-size: 15px; font-family: Arial, Helvetica, sans-serif;
}
table,th,td{
    font-size: 18px; font-family: Arial, Helvetica, sans-serif;
}
.alignCenter{
    text-align:center;
}
.alignLeft{
    text-align:left;
}
.alignRight{
    text-align:right;
}
h4{
    margin:0px;
}
</style>
</head>
 <body>";
$sqlComp = $cn->selectdb("SELECT * FROM tbl_company WHERE companyId = 2");
if(mysqli_num_rows($sqlComp) > 0)
{
    $rowComp = mysqli_fetch_assoc($sqlComp);
    $sqlLogo = $cn->selectdb("SELECT * from tbl_logo where logo_id = 1");
    $rowLogo = mysqli_fetch_assoc($sqlLogo);
    $html .= "<div>
                <div style='width:50%;display:inline-block;' class='alignLeft'>
                    <img src='logo/".$rowLogo['image_name']."' style='margin-bottom:45px;'/>
                    
                </div>";
    $html .= "<div style='width:50%;display:inline-block;margin-top:30px;' class='alignRight'>
              <h4>".$rowComp['CompanyAddress']."</h4>
              </div>
            </div>";
}
$html .= "<div style='width:100%;border: 2px solid;margin-top: 10px;margin-bottom: 15px;' class='alignCenter'>
            <h2>Payment Receipt</h2>
        </div>";

$sql = $cn->selectdb("SELECT ip.*,b.currency,b.total_amount,b.credit_amount,c.shipper_name FROM `tbl_payment_history` as ip,tbl_service_confirmation as b,tbl_shipper as c WHERE ip.payment_id = ".$payment_id." AND ip.service_confirmation_id = b.service_confirmation_id AND b.shipper_id = c.shipper_id");
if (mysqli_num_rows($sql) > 0) 
{
    $row = mysqli_fetch_assoc($sql);
    // $payment_date_time = explode(" ",strtotime($row['payment_date_time']));
    // $payment_date_time = date("d-m-Y",$payment_date_time[0]);
    $html .= "<table style='border:0px;width:100%;'>
    <tr>
        <td><b>Receipt No. : </b> ".$payment_id."</td>
        <td><b>Invoice No. : </b> ".$row['service_confirmation_id'] ."</td>
        <td style='text-align:right;'><b>Date : </b> ". date('d-m-Y H:i:s',strtotime($row['payment_date_time']))  ."</td>
    </tr>
    <tr>
        <td colspan='3'>&nbsp;</td>
    </tr>
    <tr>
        <td colspan='3'>Payment Received from <div style='text-decoration:underline;display:inline;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$row['shipper_name']."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div> 
        of ".$row['currency']."<div style='text-decoration:underline;display:inline;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".number_format($row['paid_amount'],2)."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>.</td>
    </tr>
    <tr>
        <td colspan='3'>&nbsp;</td>
    </tr>
    <tr>
        <td colspan='3'>&nbsp;</td>
    </tr>
    <tr>
        <td><b>Payment Received in: </b></td>
        <td colspan='2' style='text-align:right;'><b>Total Amount Due : </b>".number_format($row['total_amount'],2)."</td>
    </tr>
    <tr>
        <td>".$row['payment_mode']."</td>
        <td colspan='2' style='text-align:right;'><b>Amount Received : </b>".number_format($row['paid_amount'],2)."</td>
    </tr>
    <tr>
        <td></td>
        <td colspan='2' style='text-align:right;'><b>Balance Due : </b>".number_format(round($row['credit_amount']),2)."</td>
    </tr>
    <tr>
        <td colspan='3'>&nbsp;</td>
    </tr>
    <tr>
        <td colspan='3'>&nbsp;</td>
    </tr>
    <tr>
        <td colspan='3' style='text-align:right;'><div style='text-decoration:underline;display:inline;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
    </tr>
    <tr>
        <td colspan='3' style='text-align:right;'><b>Signed By </b></td>
    </tr>
</table>";

}

 $html .="</body>
</html>";
$fileName = "Reciept_No_".$payment_id;

echo $html;

// // include autoloader
// require_once 'dompdf/autoload.inc.php';

// // reference the Dompdf namespace
// use Dompdf\Dompdf;

// // instantiate and use the dompdf class
// $dompdf = new Dompdf();

// $dompdf->loadHtml($html);

// // (Optional) Setup the paper size and orientation
// $dompdf->setPaper('A4', 'portrait');

// // Render the HTML as PDF
// $dompdf->render();

// // Output the generated PDF to Browser
// // echo $html;
// $dompdf->stream($fileName,array("Attachment"=>0));
?>