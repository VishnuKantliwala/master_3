 <?php  
 include_once('../connect.php'); 
 include_once('commonFunc.php'); 
 if(!empty($_POST))  
 {  
	$cn=new connect();
	$cn->connectdb();
	$cmnFnc = new commonFunc();
	$cnt=array();
	$cnt=count($_POST['chkbox']);
	$product_rate = 0;
	$gst_charge = 0;
	$total_amount = 0;
	$net_amount = 0;
	$id = implode(",",$_POST['chkbox']);
	if($cnt > 0)
	{
		$sql = $cn->selectdb("SELECT service_confirmation_id,service_rate,gst_charge,total_amount,net_amount FROM tbl_service_inclusion WHERE service_inclusion_id IN (".$id.")");
		while($row = mysqli_fetch_assoc($sql))
		{
			$product_rate = $product_rate + floatval($row["product_rate"]);
			$gst_charge = $gst_charge + floatval($row["gst_charge"]);
			$total_amount = $total_amount + floatval($row["total_amount"]);
			$net_amount = $net_amount + floatval($row["net_amount"]);
			$service_confirmation_id = $row['service_confirmation_id'];
		}
		$cn->insertdb("delete from `tbl_service_inclusion` where service_inclusion_id IN (".$id.")");
		
		$cn->insertdb("UPDATE tbl_service_confirmation SET total_amount = total_amount-".$total_amount.",gst_charge = gst_charge - ".$gst_charge.",net_amount = net_amount - ".$net_amount.",credit_amount = CASE WHEN credit_amount <= ".$total_amount." THEN 0 ELSE (credit_amount - ".$total_amount.") END where service_confirmation_id=".$service_confirmation_id);
		//echo $cmnFnc->returnAllAmtProforma($proforma_id);
	}
	
} 

 ?>
