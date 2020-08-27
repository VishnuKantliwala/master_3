   <?php  
 //fetch.php 
 include_once('../connect.php'); 
$json=array();
	$cn=new connect();
	$cn->connectdb();
 
 if(isset($_GET["txtServiceConfirmationNo"]))  
 {  
	 $txtServiceConfirmationNo = $_GET["txtServiceConfirmationNo"];
	 $last = $_GET["last"];
	 if($last == "yes")
		 $addFilter = "SELECT ip.*,p.name FROM tbl_service_inclusion ip,tbl_product p WHERE ip.product_id = p.product_id AND ip.service_confirmation_id = ".$txtServiceConfirmationNo." ORDER BY ip.service_inclusion_id DESC LIMIT 1";
	else
		$addFilter = "SELECT ip.*,p.name,p.gst_rate FROM tbl_service_inclusion ip,tbl_product p WHERE ip.product_id = p.product_id AND ip.service_confirmation_id = ".$txtServiceConfirmationNo;
    $result = $cn->selectdb($addFilter); 
	?>
		
	<?$j=1;	
       while($row=mysqli_fetch_assoc($result))
			{
				extract($row);
				
				?>
				
				<tr id="row<? echo $service_inclusion_id ?>">
					<td style="text-align:center;"><input type="checkbox" value="<? echo $row['service_inclusion_id']; ?>" name="chkboxInvoice"  id="chkboxInvoice<?echo $j?>" <? if($row['invoice_id'] != 0) echo "CHECKED DISABLED"; ?>/>
					</td>
					<td style="text-align:center;"><input type="checkbox" value="<? echo $row['service_inclusion_id']; ?>" name="chkboxProformaInvoice"  id="chkboxProformaInvoice<?echo $j?>" <? if($row['proforma_id'] != 0) echo "CHECKED DISABLED"; ?>/>
					</td>
					<td style="text-align:center;"><input type="checkbox" value="<? echo $row['service_inclusion_id']; ?>" name="chkboxCashInvoice"  id="chkboxCashInvoice<?echo $j?>" <? if($row['cash_id'] != 0) echo "CHECKED DISABLED"; ?>/>
					</td>
					<td><? echo $name; ?>
					</td>
					<td ><? echo $quantity; ?>
					</td>
					<td ><? echo number_format($service_rate); ?>
					</td>
					<td ><? echo number_format($gst,2); ?>
					</td>
					<td ><? echo number_format($gst_charge,2); ?>
					</td>
					<td ><? echo number_format($total_amount,2); ?>
					</td>
					<td ><? echo $duration ." ". $yorm; ?>
					</td>
					<td>
						<div onClick="openServiceDetailsEditModal('<? echo $row['service_inclusion_id']; ?>');"><i class="fa fa-edit"></i></div>
					</td>
					<td>
						<div onClick="openServiceDetailsModal('<? echo $row['service_inclusion_id']; ?>');"><i class="fa fa-info-circle"></i></div>
					</td>
					
					<td>
					<input type="checkbox" value="<? echo $row['service_inclusion_id']; ?>" name="chkbox[]"  id="chkFile<?echo $j?>" />
					</td>
				
				
				
				</tr>
				
				<?
				$j++;
				// END
			}
		?>
			
		<?	
			//print_r($json['packingl  echo json_encode($json);  
 } 

 ?>