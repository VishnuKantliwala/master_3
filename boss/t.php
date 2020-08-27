<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location:login.php");
}
if ($_SESSION['control'] != "admin") {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();

function sendEmail($date,$person,$email,$amount,$service)
{
  $to = $email;
  $from = "info@icedinfotech.com";
  $subject = "Renewal Notification";
  $body = "<html><head><style>a{text-decoration:none;}table{width:100%; border:1px solid black;}table tr{line-height: 30px;}table tr:first-child{background-color: #dfdfdf; font-weight:bold;}table tr td{padding:10px;}</style></head><body><p>Dear <b>".$person."</b>,</p><br><p>Your product will not be renew automatically. Renew them now to ensure they remain active and in your name! </p><p> Your product listed below is expire soon.</p><p><table><tr><td>Product Name</td><td>Expire Date</td><td>Remewal Amount</td></tr><tr><td> ".$service."</td><td>".$date."</td><td>".$amount."</td></tr></table></p><p> For renew your product, Contact on <a href='tel:+919898405794'><b>+91 9898405794</b></a> or mail on <a href='mailto:info@icedinfotech.com'><b>info@icedinfotech.com</b></a>.</p><br><p>Thank you,<br><b>ICED Infotech</b></p></body></html>";
  // Always set content-type when sending HTML email
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  // More headers
  $headers .= "From:".$from."\r\n";
  //mail($to,$subject,$body,$headers);
}

function sendSMS($date,$person,$sms,$amount,$service)
{
  //SMS------------------
  $apikey='5b1245b953e98';       // write your apikey in between ''
  $senderid='MAHICS'; // write your senderid in between ''
  $route='trans';      // write your route in between ''
  //$rapidsms= new rapidsms($apikey,$senderid,$route);
  $numbers=$sms; //enter the number on which text to be messaged
  $message="Dear ".$person.",\n\nYour ".$service." will be expire on ".$date.".Your renewal amount is ".$amount.".\nFor renew, contact on : +919898405794"; // write your msg here between ""
  $url = "http://1.rapidsms.co.in/api/push?apikey=".$apikey."&route=".$route."&sender=".$senderid."&mobileno=".$numbers."&text=".urlencode($message);
	//echo "<script>alert('".$url."')</script>";
	$ch = curl_init($url);
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//$output = curl_exec($ch);
	curl_close($ch);
}

$start = date_parse_from_format("Y-m-d", date("Y-m-d"));
$end = date_parse_from_format("Y-m-d",date('Y-m-d', strtotime("+1 months", strtotime(date("Y-m-d")))));
$sDate = DateTime::createFromFormat('m-d', $start['month']."-".$start['day']);
$eDate = DateTime::createFromFormat('m-d', $end['month']."-".$end['day']);

  $sql = "SELECT B.booking_date,B.shipper_code,S.duration,S.yorm,P.name,SH.shipper_name,SH.shipper_email,SH.shipper_mobile,S.renew_amt FROM tbl_booking AS B, tbl_servicelist AS S, tbl_product AS P, tbl_shipper AS SH WHERE B.booking_id = S.booking_id AND B.shipper_code = SH.shipper_id AND S.product_id = P.product_id";
  $result = $cn->selectdb($sql);
  while ($row = $cn->fetchAssoc($result)) {
    if($row['yorm'] == "Month"){
      $bdate = date_parse_from_format("Y-m-d",date('Y-m-d', strtotime("+".$row['duration']." months", strtotime($row['booking_date']))));
    }else{
      $n = $row['duration']*12;
      $bdate = date_parse_from_format("Y-m-d",date('Y-m-d', strtotime("+".$n." months", strtotime($row['booking_date']))));
    }
    ///$bdate = date_parse_from_format("Y-m-d", $row['booking_date']);
    $date = DateTime::createFromFormat('m-d', $bdate['month']."-".$bdate['day']);
    if($sDate->format('md') <= $date->format('md') AND $eDate->format('md') >= $date->format('md')){
        $rdate = substr($date['date'], 0,10);
        if(isset($row['shipper_mobile'])){
          sendSMS($rdate,$row['shipper_name'],$row['shipper_mobile'],$row['renew_amt'],$row['name']);
        }
        if(isset($row['shippler_email'])){
          sendEmail($rdate,$row['shipper_name'],$row['shipper_email'],$row['renew_amt'],$row['name']);
        }
    }
  }
?>
