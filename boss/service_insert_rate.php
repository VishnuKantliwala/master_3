 <?php  
 include_once('../connect.php'); 
  include_once('commonFunc.php'); 
 
	 
	session_start();
	$cn=new connect();
	$cn->connectdb();
			
	 $cmnFnc = new commonFunc();
	date_default_timezone_set('Asia/Kolkata');
	if($_GET['type'] == "addCustomerDetails")
	{
		$customer_id =  $_POST["customer_id"];
		$customer_name =  trim($_POST["customer_name"]);
		$customer_address = $_POST["customer_address"];
		$customer_pincode = $_POST["customer_pincode"];
		$customer_city = $_POST["customer_city"];
		$gst_type = $_POST["gst_type"];
		$payment_type = $_POST["payment_type"];
		$txtAttendant = $_POST["txtAttendant"];
		
		$gst_no = $_POST["gst_no"];
		$currency = $_POST["currency"];
		$customer_phone1 = $_POST["customer_phone1"];
		$customer_phone2 = $_POST["customer_phone2"];
		$customer_email = $_POST["customer_email"];
		if($customer_id == 0)
		{
			$cn->insertdb("INSERT INTO tbl_shipper(`shipper_name`, `shipper_address`, `shipper_city`, `shipper_pincode`, `shipper_phone1`, `shipper_mobile`, `shipper_email`, `gst_no`,`type`,`gst_type`) VALUES('". $customer_name . "', '". $customer_address."','". $customer_city."','". $customer_pincode ."','". $customer_phone1. "','" . $customer_phone2. "','". $customer_email ."','" . $gst_no. "','".$payment_type."','".$gst_type."')");
			$customer_id = mysqli_insert_id($cn->getConnection());
		}
		else
		{
			$sql = $cn->selectdb("SELECT shipper_name  FROM tbl_shipper WHERE shipper_id = ".$customer_id);
			if(mysqli_num_rows($sql) > 0)
			{
				$row = mysqli_fetch_assoc($sql);
				
				if($row['shipper_name'] == $customer_name)
				{
					$cn->insertdb("UPDATE tbl_shipper SET `shipper_name` = '". $customer_name . "', `shipper_address` = '". $customer_address."', `shipper_pincode` = '". $customer_pincode ."', `shipper_city` = '". $customer_city."', `shipper_phone1` = '". $customer_phone1. "', `shipper_mobile` = '" . $customer_phone2. "',`shipper_email` = '". $customer_email ."', `gst_no` = '" . $gst_no. "', `gst_type` = '" . $gst_type. "', `type` = '" . $payment_type. "' WHERE `tbl_shipper`.`shipper_id` = ". $customer_id);
					
				}
				else
				{
					$cn->insertdb("INSERT INTO tbl_shipper(`shipper_name`, `shipper_address`, `shipper_city`, `shipper_pincode`, `shipper_phone1`, `shipper_mobile`, `shipper_email`, `gst_no`,`type`,`gst_type`) VALUES('". $customer_name . "', '". $customer_address."','". $customer_city."','". $customer_pincode ."','". $customer_phone1. "','" . $customer_phone2. "','". $customer_email ."','" . $gst_no. "','".$payment_type."','".$gst_type."')");
					$customer_id = mysqli_insert_id($cn->getConnection());
				}
			}
		}
		
		$booking_date = strtotime($_POST["booking_date"]); 	
		$booking_date = date('Y-m-d', $booking_date);
		$entry_date = date("Y-m-d H:i:s");
		$cn->insertdb("INSERT INTO `tbl_service_confirmation`( `shipper_id`, `entry_person_id`,`attendant_id`, `entry_date`, `confirmation_date`,`currency`) VALUES (".$customer_id.",'".$_SESSION['user_id']."',".$txtAttendant.",'".$entry_date."','".$booking_date."','".$currency."')");
		
	}
	if($_GET['type'] == "updateCustomerDetails")
	{
		$txtServiceConfirmationNo = $_POST["txtServiceConfirmationNo"];
		$customer_id =  $_POST["customer_id"];
		$txtAttendant = $_POST["txtAttendant"];
		$currency = $_POST["currency"];
		$booking_date = strtotime($_POST["booking_date"]); 	
		$booking_date = date('Y-m-d', $booking_date);
		$cn->insertdb("UPDATE `tbl_service_confirmation` SET `shipper_id`='".$customer_id."', `confirmation_date` = '".$booking_date."',`entry_person_id`='".$_SESSION["user_id"]."',attendant_id='".$txtAttendant."',`currency`='".$currency."' WHERE service_confirmation_id = ".$txtServiceConfirmationNo);
		
	}
	if($_GET['type'] == "product")
	{
		$product_id = $_POST["txtService"]; 
		// $sql = $cn->selectdb("SELECT  gst_rate  FROM tbl_product WHERE product_id = ".$product_id);
		// if(mysqli_num_rows($sql) > 0)
		// {
		// 	$row = mysqli_fetch_assoc($sql);
			$rate = $_POST["txtRate"];
			$gst_rate = $_POST["txtGSTPer"];
			$gst_charge = floatval($rate) * floatval($gst_rate) / 100;
			$total_amount = floatval($rate) + floatval($gst_charge);
			
		// }

		$ServiceConfirmationNo =  $_GET["ServiceConfirmationNo"]; 	
		$service_description = $_POST["txt_service_description"];
		$qty = $_POST["txtQuantity"];
		$txtDuration = $_POST["txtDuration"];
		$txtDurType = $_POST["txtDurType"];
		$shortDesc = $_POST["shortDesc"];
		$net_amount = $rate * floatval($qty);
		$total_amount = floatval($qty) * floatval($total_amount);
		$gst_charge = floatval($gst_charge) * floatval($qty);
		//$net_amount = floatval($total_amount) - floatval($gst_charge);
		$entry_date = date("Y-m-d H:i:s");
		$cn->insertdb("INSERT INTO `tbl_service_inclusion`(`service_confirmation_id`, `entry_person_id`, `product_id`,`short_desc`, `description`, `duration`, `yorm`, `quantity`, `service_rate`, `gst`, `gst_charge`, `net_amount`, `total_amount`, `entry_date`) VALUES (".$ServiceConfirmationNo.",".$_SESSION['user_id'].",".$product_id.",'".$shortDesc."','".$service_description."','".$txtDuration."','".$txtDurType."','".$qty."','".$cmnFnc->returnNumberInformate($rate)."','".$cmnFnc->returnNumberInformate($gst_rate)."','".$cmnFnc->returnNumberInformate($gst_charge)."','".$cmnFnc->returnNumberInformate($net_amount)."','".$cmnFnc->returnNumberInformate($total_amount)."','".$entry_date."')"); 
		
		$sql = $cn->selectdb("UPDATE tbl_service_confirmation SET total_amount=total_amount + ".$cmnFnc->returnNumberInformate($total_amount).",net_amount=net_amount + ".$cmnFnc->returnNumberInformate($rate).",gst_charge=gst_charge + ".$cmnFnc->returnNumberInformate($gst_charge).",credit_amount=credit_amount + ".$cmnFnc->returnNumberInformate($total_amount)." WHERE service_confirmation_id = ".$ServiceConfirmationNo);
	}
	if($_GET['type'] == "updateServiceDetails")
	{
		$product_id = $_POST["txtService"]; 
		$modalservice_inclusion_no = $_POST["service_inclusion_no"];
		$sql = $cn->selectdb("SELECT sc.credit_amount,si.total_amount as siTotalAmt FROM tbl_service_inclusion si,tbl_service_confirmation sc WHERE sc.service_confirmation_id = si.service_confirmation_id AND si.service_inclusion_id = ".$modalservice_inclusion_no);
		$row = mysqli_fetch_assoc($sql);
			
		$rate = $_POST["txtRate"];
		$gst_rate = $_POST["txtGSTPer"];
		$gst_charge = floatval($rate) * floatval($gst_rate) / 100;
		$total_amount = floatval($rate) + floatval($gst_charge);
		

		$ServiceConfirmationNo =  $_POST["service_confirmation_no"]; 	
		
		$service_description = $_POST["txt_service_description"];
		$qty = $_POST["txtQuantity"];
		$txtDuration = $_POST["txtDuration"];
		$txtDurType = $_POST["txtDurType"];
		$shortDesc = $_POST["shortDesc"];
		$net_amount = $rate * floatval($qty);
		$total_amount = floatval($qty) * floatval($total_amount);
		$gst_charge = floatval($gst_charge) * floatval($qty);
		//$net_amount = floatval($total_amount) - floatval($gst_charge);
		
		$siTotalAmt = $row['siTotalAmt'];
		$credit_amount = $row['credit_amount'];
		if($total_amount > $siTotalAmt)
		{
			$updateCA = $credit_amount + ($total_amount - $siTotalAmt);
		}
		else
		{
			$updateCA = $credit_amount - ($siTotalAmt - $total_amount);
			if($updateCA < 0)
				$updateCA = 0;
		}
		// echo $updateCA;
		$sql = $cn->selectdb("UPDATE `tbl_service_confirmation` as A JOIN `tbl_service_inclusion` as B ON A.service_confirmation_id = B.service_confirmation_id SET A.total_amount = (A.total_amount - B.total_amount) + ".$cmnFnc->returnNumberInformate($total_amount).", A.net_amount = (A.net_amount - B.net_amount) + ".$cmnFnc->returnNumberInformate($net_amount).", A.gst_charge = (A.gst_charge - B.gst_charge) + ".$cmnFnc->returnNumberInformate($gst_charge).", A.credit_amount = ".$updateCA." WHERE B.service_inclusion_id = ".$modalservice_inclusion_no);

		// echo "UPDATE A SET A.total_amount = (A.total_amount - B.total_amount) + ".$cmnFnc->returnNumberInformate($total_amount).", A.net_amount = (A.net_amount - B.net_amount) + ".$cmnFnc->returnNumberInformate($rate).", A.gst_charge = (A.gst_charge - B.gst_charge) + ".$cmnFnc->returnNumberInformate($gst_charge).", A.credit_amount = ".$updateCA." FROM `tbl_service_confirmation` as A, `tbl_service_inclusion` as B WHERE A.service_confirmation_id = B.service_confirmation_id AND B.service_inclusion_id = ".$modalservice_inclusion_no;


		 $cn->insertdb("UPDATE `tbl_service_inclusion` SET  `product_id`=".$product_id.", `duration`='".$txtDuration."', `yorm`='".$txtDurType."', `quantity`=".$qty.", `service_rate`=".$rate.", `gst`=".$gst_rate.", `gst_charge`=".$gst_charge.", `net_amount`=".$net_amount.", `total_amount`=".$total_amount.",`short_desc` = '".$shortDesc."', `description`='".$service_description."' WHERE service_inclusion_id = ".$modalservice_inclusion_no); 
		
		
	}
	if($_GET['type'] == "getUpdatedAmount")
	{
		$txtServiceConfirmationNo =  $_GET["txtServiceConfirmationNo"]; 	
		 echo $cmnFnc->returnAllAmt($txtServiceConfirmationNo);
		
	}
	if($_GET['type'] == "getServiceRate")
	{
		$service_no =  $_GET["service_no"]; 	
		 echo $cmnFnc->returnServiceRate($service_no);
		
	}
	if($_GET['type'] == "getExpenseGstRate")
	{
		$expense_id =  $_GET["expense_id"]; 	
		 echo $cmnFnc->returnExpenseGSTRate($expense_id);
		
	}
	if($_GET['type'] == "getServiceDetails")
	{
		$ServiceInclusionNo =  $_GET["ServiceInclusionNo"]; 	
		 echo $cmnFnc->returnServiceDetails($ServiceInclusionNo);
		
	}
	if($_GET['type'] == "addPayment")
	{
		$invoice_no =  $_POST["modal_invoice_no"]; 	
		$paid_amount =  $_POST["paid_amount"];
		$payment_mode =  $_POST["payment_mode"];
		$modal_payment_description =  $_POST["modal_payment_description"];
		$dateTime = date("Y/m/d h:i:s");
		$cn->insertdb("INSERT INTO `tbl_payment_history`(`service_confirmation_id`, `paid_amount`,`payment_date_time`,`payment_mode`,`entry_person_id`,`description`) VALUES  (".$invoice_no.",'".$paid_amount."','".$dateTime."','".$payment_mode."','".$_SESSION['user_id']."','".$modal_payment_description."')");
		$lastInsertId = mysqli_insert_id($cn->getConnection());
		
		$sql = $cn->selectdb("UPDATE tbl_service_confirmation SET received_amount=received_amount + ".$paid_amount.",credit_amount=credit_amount - ".$paid_amount." WHERE service_confirmation_id = ".$invoice_no);
		echo $lastInsertId;
	}
	if($_GET['type'] == "deletePayment")
	{
		$payment_id =  $_GET["invoice_payment_id"]; 	
		$cn->insertdb("UPDATE A SET A.credit_amount = A.credit_amount + B.paid_amount FROM `tbl_service_confirmation` as A,tbl_payment_history as B WHERE A.service_confirmation_id = B.service_confirmation_id AND b.payment_id = ".$payment_id);
		$sql = $cn->selectdb("DELETE FROM tbl_payment_history WHERE payment_id = ".$payment_id);
	}
	if($_GET['type'] == "generateInvoice")
	{
		$service_inclusion_id = $_POST["chkboxInvoice"];
		$service_confirmation_id = $_POST["service_confirmation_id"];
		$invoice_id = $_POST["invoice_id"];
		$dateTime = date("Y/m/d");
		if($invoice_id == 0)
		{
			$cn->insertdb("INSERT INTO `tbl_invoice`(`service_confirmation_id`,`entry_person_id`,`entry_date`) VALUES  (".$service_confirmation_id.",'".$_SESSION['user_id']."','".$dateTime."')");
			$invoice_id = mysqli_insert_id($cn->getConnection());
		}
		
		$cn->insertdb("UPDATE tbl_service_inclusion SET invoice_id = ".$invoice_id." WHERE service_inclusion_id IN (".$service_inclusion_id.")");
		
		
	}
	if($_GET['type'] == "generateProformaInvoice")
	{
		$service_inclusion_id = $_POST["chkboxProformaInvoice"];
		$service_confirmation_id = $_POST["service_confirmation_id"];
		$proforma_id = $_POST["proforma_id"];
		$dateTime = date("Y/m/d");
		if($proforma_id == 0)
		{
			$cn->insertdb("INSERT INTO `tbl_proforma`(`service_confirmation_id`,`entry_person_id`,`entry_date`) VALUES  (".$service_confirmation_id.",'".$_SESSION['user_id']."','".$dateTime."')");
			$proforma_id = mysqli_insert_id($cn->getConnection());
		}
			
		$cn->insertdb("UPDATE tbl_service_inclusion SET proforma_id = ".$proforma_id." WHERE service_inclusion_id IN (".$service_inclusion_id.")");
		
		
	}
	if($_GET['type'] == "generateCashInvoice")
	{
		$service_inclusion_id = $_POST["chkboxCashInvoice"];
		$service_confirmation_id = $_POST["service_confirmation_id"];
		$cash_id = $_POST["cash_id"];
		$dateTime = date("Y/m/d");
		if($cash_id == 0)
		{
			$cn->insertdb("INSERT INTO `tbl_cash`(`service_confirmation_id`,`entry_person_id`,`entry_date`) VALUES  (".$service_confirmation_id.",'".$_SESSION['user_id']."','".$dateTime."')");
			$cash_id = mysqli_insert_id($cn->getConnection());
		}
		$cn->insertdb("UPDATE tbl_service_inclusion SET cash_id = ".$cash_id." WHERE service_inclusion_id IN (".$service_inclusion_id.")");
		
		
	}
	if($_GET['type'] == "checkPreviousInvoice")
	{
		$service_confirmation_id = $_POST["service_confirmation_id"];
		if($_POST['type'] == "Invoice")
		{
			$sql = $cn->selectdb("SELECT * FROM `tbl_invoice` WHERE `service_confirmation_id` = ".$service_confirmation_id);
			//$sql = $cn->selectdb("SELECT * FROM `tbl_proforma`");
			if(mysqli_num_rows($sql) > 0)
			{
				$i=0;
				$returnObj = array();
				while($row = mysqli_fetch_assoc($sql))
				{
					$returnObj[$i]["invoice_id"]=$row['invoice_id'];
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
		if($_POST['type'] == "Proforma")
		{
			$sql = $cn->selectdb("SELECT * FROM `tbl_proforma` WHERE `service_confirmation_id` = ".$service_confirmation_id);
			//$sql = $cn->selectdb("SELECT * FROM `tbl_proforma`");
			if(mysqli_num_rows($sql) > 0)
			{
				$i=0;
				$returnObj = array();
				while($row = mysqli_fetch_assoc($sql))
				{
					$returnObj[$i]["proforma_id"]=$row['proforma_id'];
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
		if($_POST['type'] == "Cash")
		{
			$sql = $cn->selectdb("SELECT * FROM `tbl_cash` WHERE `service_confirmation_id` = ".$service_confirmation_id);
			//$sql = $cn->selectdb("SELECT * FROM `tbl_proforma`");
			if(mysqli_num_rows($sql) > 0)
			{
				$i=0;
				$returnObj = array();
				while($row = mysqli_fetch_assoc($sql))
				{
					$returnObj[$i]["cash_id"]=$row['cash_id'];
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
	}
	
 ?>
