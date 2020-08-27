<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
session_start();
if(!isset($_SESSION['user_id']))
{
	header("location:Login.php");
}

include_once('../connect.php'); 
$cn=new connect();
$cn->connectdb();
$cash_id = $_GET['cash_id'];
?>
<html>

<head>
    <title>Cash Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

    <style type="text/css">
    @media print {
        tr.vendorListHeading {
            background-color: #1a4567 !important;
            -webkit-print-color-adjust: exact;
        }
    }

    @media print {
        .vendorListHeading th {
            color: white !important;
        }
    }
    </style>
    <style media="print">
    @page {
        size: auto;
        margin: 0;
    }
    </style>
    <style>
    body {
        height: 1035px;
        width: 720px;
        /* to centre page on screen*/
        margin-left: auto;
        margin-right: auto;
        font-size: 7px;
        font-family: 'arial', sans-serif;
    }

    table,
    th,
    td {
        border-collapse: collapse;

        font-size: 9px;
        font-family: 'arial', sans-serif;
    }

    .style3 {
        font-size: 16px;
        font-weight: bold;
    }

    .style4 {
        font-size: 10px
    }

    .style5 {
        font-weight: bold
    }

    .style6 {
        font-size: 12px;
        font-weight: bold;
    }
    </style>
    <style type="text/css">
    table {
        page-break-inside: auto
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto
    }

    thead {
        display: table-header-group
    }

    tfoot {
        display: table-footer-group
    }

    .noborder {
        border: 0px;
    }
    </style>
</head>
<?

Class Convert {
						var $words = array();
						var $places = array();
						var $amount_in_words;
						var $decimal;
						var $decimal_len;
	
						function Convert($amount, $currency="RUPEES") {
						$this->assign();
		
						$temp = (string)$amount;
						$pos = strpos($temp,".");
						if ($pos) {
						$temp = substr($temp,0,$pos);
						$this->decimal = strstr((string)$amount,".");
						$this->decimal_len = strlen($this->decimal) - 2;
						$this->decimal = substr($this->decimal,1,$this->decimal_len+1);
					}
					$len = strlen($temp)-1;
					$ctr = 0;
					$arr = array();
					while ($len >= 0) {
						if ($len >= 2) {
						$arr[$ctr++] = substr($temp, $len-2, 3);
						$len -= 3;
					} else {
						$arr[$ctr++] = substr($temp,0,$len+1);
						$len = -1;
					}
				}
		
					$str = "";
					for ($i=count($arr)-1; $i>=0; $i--) {
						$figure = $arr[$i];
						$sub = array(); $temp="";
						for ($y=0; $y<strlen(trim($figure)); $y++) {
							$sub[$y] = substr($figure,$y,1);
						}
						$len = count($sub);
						if ($len==3) {
							if ($sub[0]!="0") {
								$temp .= ((strlen($str)>0)?" ":"") . trim($this->words[$sub[0]]) . " HUNDRED";
							}
							$temp .= $this->processTen($sub[1], $sub[2]);
						} elseif ($len==2) {
							$temp .= $this->processTen($sub[0], $sub[1]);
						} else {
							$temp .= $this->words[$sub[0]];
						}
						if (strlen($temp)>0) {
							$str .= $temp . $this->places[$i];
						}
					}
					//$str .= " " . $currency;
					if ($this->decimal_len>0) {
						$str .= " And " . $this->decimal . "/" . $this->denominator($this->decimal_len+1) .  " PAISA";
						}
					$this->amount_in_words = $str;
				}
	
				function denominator($x) {
					$temp = "1";
					for ($i=1; $i<=$x; $i++) {
					$temp .= "0";
					}
					return $temp;
				}
	
				function display() {
					return $this->amount_in_words;
					}

				function processTen($sub1, $sub2) {
					if ($sub1=="0") {
						if ($sub2=="0") {
							return "";
						} else {
							return $this->words[$sub2];
						}
					} elseif ($sub1!="1") {
						if ($sub2!="0") {
							return $this->words[$sub1."0"] . $this->words[$sub2];
						} else {
							return $this->words[$sub1 . $sub2];
						}
					} else {
						if ($sub2=="0") {
							return $this->words["10"];
						} else {
							return $this->words[$sub1 . $sub2];
						}
					}
				}

				function assign() {
					$this->words["1"] = " ONE"; 			$this->words["2"] = " TWO";
					$this->words["3"] = " THREE"; 		$this->words["4"] = " FOUR";
					$this->words["5"] = " FIVE"; 			$this->words["6"] = " SIX";
					$this->words["7"] = " SEVEN";			$this->words["8"] = " EIGHT";
					$this->words["9"] = " NINE";
	
					$this->words["10"] = " TEN";			$this->words["11"] = " ELEVEN";
					$this->words["12"] = " TWELVE";		$this->words["13"] = " THIRTEEN";
					$this->words["14"] = " FOURTEEN";		$this->words["15"] = " FIFTEEN";
					$this->words["16"] = " SIXTEEN";		$this->words["17"] = " SEVENTEEN";
					$this->words["18"] = " EIGHTEEN";		$this->words["19"] = " NINETEEN";

						$this->words["20"] = " TWENTY";		$this->words["30"] = " THIRTY";
					$this->words["40"] = " FORTY";		$this->words["50"] = " FIFTY";
					$this->words["60"] = " SIXTY";		$this->words["70"] = " SEVENTY";
					$this->words["80"] = " EIGHTY";		$this->words["90"] = " NINETY";
	
					$this->places[0] = "";					$this->places[1] = " THOUSAND";
					$this->places[2] = " MILLION";		$this->places[3] = " BILLION";
					$this->places[4] = " THRILLION";
						}
					}
					$a = "";
?>

<body>
<?
  //echo "SELECT * FROM `tbl_booking` as b,tbl_shipper s,tbl_servicelist as l,tbl_product as p  WHERE b.booking_id = ".$booking_id." and l.booking_id = b.booking_id and p.product_id = l.product_id and s.shipper_id = b.shipper_code";
$sqlBooking = $cn->selectdb("SELECT i.entry_date,c.*,sc.* FROM tbl_cash i,tbl_shipper c,tbl_service_confirmation sc WHERE i.service_confirmation_id = sc.service_confirmation_id AND sc.shipper_id = c.shipper_id AND i.cash_id =".$cash_id);
if(mysqli_num_rows($sqlBooking) > 0)
{
  $rowBooking = mysqli_fetch_assoc($sqlBooking);
  
?>
    <table width="100%" style="border:2px solid black;">
        <tr>
            <td style="padding:13px;">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">

                    <tr style="border-bottom:2px solid black;border-top:0px solid black;">
                        <td colspan="2" style="border-top:0px">
                            <table width="100%" border="0" bordercolor="#FFFFFF">
                                <tr style="border-top:0px">
                                    <td width="65%" style="border-top:0px;padding-bottom:9px;" align="right">
                                        <?
	 $sql = $cn->selectdb("select * from tbl_logo where logo_id = 1");
	 $row = mysqli_fetch_assoc($sql);
	 ?>
                                        <img id="logo" name="logo" src="logo/<? echo $row['image_name'] ?>"
                                            style="width:200px;height:80px;">
                                    </td>
                                
                                    <td width="35%" style="border-top:0px" align="right">
                                        <p align="right" class="style6"><span style="color:#015289;">CASH INVOICE NO:</span>
                                            <? echo $cash_id;?>
                                        </p>
                                        <p align="right" class="style6"><span style="color:#015289;">Date:</span>
                                            <? echo date("d-m-Y",strtotime($rowBooking['entry_date'])); ?>
                                        </p>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr style="border-left:0px;border-bottom:2px solid black;">

                        <td width="49%" height="158" style="border-left:0px;border-right:2px solid black;">

                            <p align="left" class="style3" style="color:#f27122;">
                                <? echo $rowBooking['shipper_name']; ?>
                            </p>
                            <p align="left" class="style4" style="width:200px;">
                                <? echo $rowBooking['shipper_address']; ?>
                            </p>
                            <p align="left" class="style4" style="width:200px;">
                                <? echo $rowBooking['shipper_city'] ."-". $rowBooking['shipper_pincode'];?>
                            </p>

                            <p align="left" class="style6">
                                <? if($rowBooking['gst_no'] != ""){ ?>GST No. :
                                <? echo $rowBooking['gst_no'] ; }?>
                            </p>
                        </td>

                        <td width="50%" style="border-right:0px" align="right">

                            <?
	 $sql = $cn->selectdb("select * from tbl_company where companyId = 1");
	 $row = mysqli_fetch_assoc($sql);
	 ?>
                            <p class="style3" style="color:#f27122;">
                                <? echo $row['CompanyName'] ?>
                            </p>
                            <p class="style4">
                                <? echo $row['CompanyAddress'] ?>
                            </p>

                            <? if($rowBooking['gst_no'] != ""){ ?>
                            <p align="right" class="style6">GST No. :
                                <? echo $row['CompanyGstNo']; ?>
                            </p>
                            <? } ?>
                        </td>
                    </tr>
                </table>

                <table width="100%" border="1" style="border: 0px solid black;margin-top:10px" cellpadding="0"
                    cellspacing="0">
                    <thead class="noborder">
                        <tr class="noborder">
                            <td class="noborder">&nbsp;</td>
                        </tr>
                    </thead>
                    <tfoot class="noborder">
                        <tr class="noborder">
                            <td class="noborder">&nbsp;</td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr style="border: 1px solid rgba(0, 0, 0, .5);">
                            <th colspan="3" style="font-size:15px;color:#015289;">
                                <p align="center">Service</p>
                            </th>

                            <th style="font-size:15px;color:#015289;">
                                <p align="center">SAC Code</p>
                            </th>
                            <th style="font-size:15px;color:#015289;">
                                <p align="center">Duration</p>
                            </th>
                            <th style="font-size:15px;color:#015289;padding:5px;">
                                <p align="center">Qty</p>
                            </th>
                            <th style="font-size:15px;color:#015289;padding:5px;">
                                <p align="center">Rate</p>
                            </th>
                            <th width="11%" style="font-size:15px;color:#015289;">
                                <p align="center">Amount</p>
                            </th>
                        </tr>
                        <?

		$sql = $cn->selectdb("SELECT p.name,p.code,p.gst_rate,si.duration,si.yorm,si.quantity,si.service_rate,si.gst_charge,si.net_amount,si.total_amount,si.short_desc FROM tbl_product p,tbl_service_inclusion si WHERE si.product_id = p.product_id AND si.cash_id = ".$cash_id);
 
  $i=0;
  $total_weight = 0;
  $amount = 0;
  $varGstCharge = 0;
  while($row = mysqli_fetch_assoc($sql))
  {
	  $i++;
  extract($row);
if($duration > 1)
		$time =  $duration." ".$yorm."s";
	else
		$time =  $duration." ".$yorm;
  ?>
                        <tr
                            style="border-top: 1px solid rgba(0, 0, 0, .5);border-left: 1px solid rgba(0, 0, 0, .5);border-right: 1px solid rgba(0, 0, 0, .5);border-bottom: 0px solid rgba(0, 0, 0, .5);">
                            <td style="font-size:13px;padding-left:5px;" colspan="3">
                                <p align="left"><strong><? echo $name; ?></strong>
                                <br/>
                                <? echo $short_desc != "" ? "(".$short_desc.")" : "";  ?>
                                </p>
                                
                            </td>

                            <td style="font-size:13px;">
                                <p align="center"><strong>
                                        <? echo $code; ?></strong></p>
                            </td>
                            <td style="font-size:13px;">
                                <p align="center"><strong>
                                        <? echo $time; ?></strong></p>
                            </td>
                            <td style="font-size:13px;padding:5px;">
                                <div align="center">
                                    <p>
                                        <? echo $quantity; ?>
                                    </p>
                                </div>
                            </td>
                            <td style="font-size:13px;padding:5px;">
                                <div align="center">
                                    <p>
                                        <? echo number_format($service_rate,2); ?>
                                    </p>
                                </div>
                            </td>
                            <td style="font-size:13px;">
                                <div align="center">
                                    <p>
                                        <? echo number_format($net_amount,2); ?>
                                    </p>
                                </div>
                            </td>
                        </tr>

                        <?
  $amount = (float)$amount + (float)$net_amount;
  $varGstCharge = (float)$varGstCharge + (float)$gst_charge;
  } 
  $cnt = 8 - $i;
  for($j=0;$j<$cnt;$j++)
  {
  ?>
                        <tr style="height:52px;">
                            <td colspan="3"
                                style="font-size:13px;border-top: 0px solid rgba(0, 0, 0, .5);border-left: 1px solid rgba(0, 0, 0, .5);border-right: 1px solid rgba(0, 0, 0, .5);border-bottom: 0px solid rgba(0, 0, 0, .5);">
                                <p>&nbsp;</p>
                            </td>
                            <td
                                style="font-size:13px;border-top: 0px solid rgba(0, 0, 0, .5);border-left: 1px solid rgba(0, 0, 0, .5);border-right: 1px solid rgba(0, 0, 0, .5);border-bottom: 0px solid rgba(0, 0, 0, .5);">
                                <p>&nbsp;</p>
                            </td>
                            <td
                                style="font-size:13px;border-top: 0px solid rgba(0, 0, 0, .5);border-left: 1px solid rgba(0, 0, 0, .5);border-right: 1px solid rgba(0, 0, 0, .5);border-bottom: 0px solid rgba(0, 0, 0, .5);">
                                <p>&nbsp;</p>
                            </td>
                            <td
                                style="font-size:13px;border-top: 0px solid rgba(0, 0, 0, .5);border-left: 1px solid rgba(0, 0, 0, .5);border-right: 1px solid rgba(0, 0, 0, .5);border-bottom: 0px solid rgba(0, 0, 0, .5);">
                                <p>&nbsp;</p>
                            </td>
                            <td
                                style="font-size:13px;border-top: 0px solid rgba(0, 0, 0, .5);border-left: 1px solid rgba(0, 0, 0, .5);border-right: 1px solid rgba(0, 0, 0, .5);border-bottom: 0px solid rgba(0, 0, 0, .5);">
                                <p>&nbsp;</p>
                            </td>
                            <td
                                style="font-size:13px;border-top: 0px solid rgba(0, 0, 0, .5);border-left: 1px solid rgba(0, 0, 0, .5);border-right: 1px solid rgba(0, 0, 0, .5);border-bottom: 0px solid rgba(0, 0, 0, .5);">
                                <p>&nbsp;</p>
                            </td>
                        </tr>
                        <? } ?>
                        <tr style="border-left: 1px solid rgba(0, 0, 0, .5);border-right: 1px solid rgba(0, 0, 0, .5);">


                            <td style="border-top: 1px solid rgba(0, 0, 0, .5);;border-bottom: 0;font-size:13px;padding-left:5px;"
                                colspan="3">
                                <p align="left"><strong>Total:</strong></p>
                            </td>
                            <td style="border-top: 1px solid rgba(0, 0, 0, .5);;border-bottom: 0;font-size:13px;">
                                <p align="left"><strong></strong></p>
                            </td>
                            <td style="border-top: 1px solid rgba(0, 0, 0, .5);;border-bottom: 0;font-size:13px;">
                                <p align="left"><strong></strong></p>
                            </td>
                            <td style="border-top: 1px solid rgba(0, 0, 0, .5);border-bottom: 0;font-size:13px;">
                                <div align="center">
                                    <p></p>
                                </div>
                            </td>
                            <td style="border-top: 1px solid rgba(0, 0, 0, .5);border-bottom: 0;font-size:13px;">
                                <div align="center">
                                    <p></p>
                                </div>
                            </td>
                            <td style="border-top: 1px solid rgba(0, 0, 0, .5);border-bottom: 0;font-size:13px;">
                                <div align="center">
                                    <p>
                                        <? echo number_format($amount,2); ?>
                                    </p>
                                </div>
                            </td>
                        </tr>

                        <?
  $amountgst = 0;
  $totalamount = $varGstCharge + $amount;
  $amountigst = 0;
 
  if($rowBooking['gst_type'] == "CGST/SGST")
  {
  ?>
                        <tr style="border-left: 1px solid rgba(0, 0, 0, .5);border-right: 1px solid rgba(0, 0, 0, .5);">

                            <td style="border-top: 0;border-bottom: 0;padding-left:5px;" colspan="3">
                                <p><strong>SGST@9%:</strong></p>
                            </td>
                            <td style="border-top: 0;border-bottom: 0;">
                                <p><strong></strong></p>
                            </td>
                            <td style="border-top: 0;border-bottom: 0;">
                                <p><strong></strong></p>
                            </td>
                            <td style="border-top: 0;border-bottom: 0;">
                                <div align="center">
                                    <p></p>
                                </div>
                            </td>
                            <td style="border-top: 0;border-bottom: 0;">
                                <div align="center">
                                    <p></p>
                                </div>
                            </td>
                            <td style="border-top: 0;border-bottom: 0;">
                                <div align="center">
                                    <p>
                                        <? echo number_format($varGstCharge/2,2);?>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr style="border-left: 1px solid rgba(0, 0, 0, .5);border-right: 1px solid rgba(0, 0, 0, .5);">

                            <td style="border-top: 0;border-bottom: 0;padding-left:5px;" colspan="3">
                                <p><strong>CGST@9%:</strong></p>
                            </td>
                            <td style="border-top: 0;border-bottom: 0;">
                                <p><strong></strong></p>
                            </td>
                            <td style="border-top: 0;border-bottom: 0;">
                                <p><strong></strong></p>
                            </td>
                            <td style="border-top: 0;border-bottom: 0;">
                                <div align="center">
                                    <p></p>
                                </div>
                            </td>
                            <td style="border-top: 0;border-bottom: 0;">
                                <div align="center">
                                    <p></p>
                                </div>
                            </td>
                            <td style="border-top: 0;border-bottom: 0;">
                                <div align="center">
                                    <p>
                                        <? echo number_format($varGstCharge/2,2);?>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <? }else if($rowBooking['gst_type'] == "IGST"){ ?>
        </tr>
        <tr style="border-left: 1px solid black;border-right: 1px solid rgba(0, 0, 0, .5);">
            <td style="border-top: 0;border-bottom: 0;padding-left:5px;" colspan="3">
                <p><strong>IGST@18%:</strong></p>
            </td>
            <td style="border-top: 0;border-bottom: 0;">
                <p><strong></strong></p>
            </td>
            <td style="border-top: 0;border-bottom: 0;">
                <p><strong></strong></p>
            </td>
            <td style="border-top: 0;border-bottom: 0;font-size:13px;">
                <div align="center">
                    <p></p>
                </div>
            </td>
            <td style="border-top: 0;border-bottom: 0;font-size:13px;">
                <div align="center">
                    <p></p>
                </div>
            </td>
            <td style="border-top: 0;border-bottom: 0;font-size:13px;">
                <div align="center">
                    <p>
                        <? echo number_format($varGstCharge,2); ?>
                    </p>
                </div>
            </td>
        </tr>
        <? }else if($rowBooking['gst_type'] == "UTGST"){ ?>
        <tr style="border-left: 1px solid black;border-right: 1px solid rgba(0, 0, 0, .5);">
            <td style="border-top: 0;border-bottom: 0;padding-left:5px;" colspan="3">
                <p><strong>UTGST@18%:</strong></p>
            </td>
            <td style="border-top: 0;border-bottom: 0;">
                <p><strong></strong></p>
            </td>
            <td style="border-top: 0;border-bottom: 0;">
                <p><strong></strong></p>
            </td>
            <td style="border-top: 0;border-bottom: 0;">
                <div align="center">
                    <p></p>
                </div>
            </td>
            <td style="border-top: 0;border-bottom: 0;">
                <div align="center">
                    <p></p>
                </div>
            </td>
            <td style="border-top: 0;border-bottom: 0;">
                <div align="center">
                    <p>
                        <? echo number_format($varGstCharge,2);?>
                    </p>
                </div>
            </td>
        </tr>
        <? }else { 
$total_amount = $totalamount;
} 
  
  /*
  $j = 22 - $i;
  for($i = 0;$i<=0; $i++){ ?>
        <tr
            style="border-top: 2px solid black;border-left: 2px solid black;border-right: 2px solid black;border-bottom: 0px solid black;">
            <td style="border-bottom: 0;">
                <p align="right"><strong>
                        <? echo $i; ?></strong></p>
            </td>
            <td style="border-bottom: 0;">
                <p><strong>
                        <? echo $booking_date; ?></strong></p>
            </td>
            <td style="border-bottom: 0;">
                <p><strong>
                        <? echo $booking_id; ?></strong></p>
            </td>
            <td style="border-bottom: 0;">
                <p><strong>
                        <? echo $country; ?></strong></p>
            </td>
            <td style="border-bottom: 0;">
                <p><strong>
                        <? echo $remark; ?></strong></p>
            </td>
            <td style="border-bottom: 0;">
                <p><strong>
                        <? echo $flight_no; ?></strong></p>
            </td>
            <td style="border-bottom: 0;">
                <p align="right"><strong>
                        <? echo $pieces; ?></strong></p>
            </td>
            <td>
                <p align="right"><strong>
                        <? echo $charge_weight; ?></strong></p>
            </td>
            <td style="border-bottom: 0;">
                <div align="right" class="style5">
                    <p>
                        <? echo $rate; ?>
                    </p>
                </div>
            </td>
            <td>
                <div align="right" class="style5">
                    <p>
                        <? echo $total_amount; ?>
                    </p>
                </div>
            </td>
        </tr>
        <? } */?>

        <tr style="border: 1px solid rgba(0, 0, 0, .5);">
        <th colspan="3" style="font-size:12px;color:#015289;padding-left:5px;">
                <div style="text-align:left;max-width:255px;"><? echo $rowBooking['currency']." " ?>(IN WORDS):
                    <? if($totalamount!= '0.00'){$c = new Convert(round($totalamount)) ;
	echo $a=$c->display();} ?><? echo " ".$rowBooking['currency'] ?>
                </div>
            </th>
            <td style="font-size:15px;color:#015289;">
                <div align="center"></div>
            </td>
            <th style="font-size:15px;color:#015289;">
                <div align="right"></div>
            </th>
            <td style="font-size:15px;color:#015289;">
                <div align="center"></div>
            </td>
            <td style="font-size:15px;color:#015289;">
                <div align="center">Total:</div>
            </td>
            <td style="font-size:15px;color:#015289;">
                <div align="center">
                    <? echo number_format($totalamount,2); ?>
                </div>
            </td>
        </tr>
        <?
  $sql = $cn->selectdb("select * from tbl_tc where tc_id = 1");
  if(mysqli_num_rows($sql)>0)
  { 
    $row1 = mysqli_fetch_assoc($sql);
  ?>
        <tr style="border: 1px solid rgba(0, 0, 0, .5);">

            <td colspan="8" style="font-size:12px;color:#000000;padding-left:5px;">
                <div style="text-align:left;">
                    <?echo $row1['tc_desc'] ?>
                </div>
            </td>

        </tr>
        <?  }?>
        </tbody>
    </table>
    </td>
    </tr>
    </table>
  <? } ?>
</body>

</html>