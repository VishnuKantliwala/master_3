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

function sendEmail($domain,$date,$person,$email,$amount,$service)
{
  $to = $email;
  $from = "info@icedinfotech.com";
  $subject = "Renewal Notification";
  $body = "<html><head><style>a{text-decoration:none;}table{width:100%; border:1px solid black;}table tr{line-height: 30px;}table tr:first-child{background-color: #dfdfdf; font-weight:bold;}table tr td{padding:10px;}</style></head><body><p>Dear <b>".$person."</b>,</p><br><p>Your product will not be renew automatically. Renew them now to ensure they remain active and in your name! </p><p> Your product listed below is expire soon.</p><p><table><tr><td>Product Name</td><td>Domain Name</td><td>Expire Date</td><td>Remewal Amount</td></tr><tr><td> ".$service."</td><td>".$domain."</td><td>".$date."</td><td>".$amount."</td></tr></table></p><p> For renew your product, Contact on <a href='tel:+919898405794'><b>+91 9898405794</b></a> or mail on <a href='mailto:info@icedinfotech.com'><b>info@icedinfotech.com</b></a>.</p><br><p>Thank you,<br><b>ICED Infotech</b></p></body></html>";
  // Always set content-type when sending HTML email
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  // More headers
  $headers .= "From:".$from."\r\n";
  //mail($to,$subject,$body,$headers);
}

function sendSMS($domain,$date,$person,$sms,$amount,$service)
{
  //SMS------------------
  $apikey='5b1245b953e98';       // write your apikey in between ''
  $senderid='MAHICS'; // write your senderid in between ''
  $route='trans';      // write your route in between ''
  //$rapidsms= new rapidsms($apikey,$senderid,$route);
  $numbers=$sms; //enter the number on which text to be messaged
  $message="Dear ".$person.",\n\nYour ".$service." - ".$domain." will be expire on ".$date.".Your renewal amount is ".$amount.".\nFor renew, contact on : +919898405794"; // write your msg here between ""
  $url = "http://1.rapidsms.co.in/api/push?apikey=".$apikey."&route=".$route."&sender=".$senderid."&mobileno=".$numbers."&text=".urlencode($message);
	//echo "<script>alert('".$url."')</script>";
	$ch = curl_init($url);
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//$output = curl_exec($ch);
	curl_close($ch);
}

$sdate = date("Y-m-d");
echo $sdate;
$edate = date('Y-m-d', strtotime("+1 months", strtotime($sdate)));
echo $edate;

$sql = "SELECT * FROM tbl_renewal WHERE renewal_date>='".$sdate."' AND renewal_date<='".$edate."'";
echo $sql;
$result = $cn->selectdb($sql);
if($cn->numRows($result)>0){
  while ($row=$cn->fetchAssoc($result)) {
    if(isset($row['sms_no'])){
      sendSMS($row['domain_name'],$row['renewal_date'],$row['person_name'],$row['sms_no'],$row['renewal_amt'],$row['name']);
    }
    if(isset($row['email_id'])){
      sendEmail($row['domain_name'],$row['renewal_date'],$row['person_name'],$row['email_id'],$row['renewal_amt'],$row['name']);
    }
  }
}
?>
