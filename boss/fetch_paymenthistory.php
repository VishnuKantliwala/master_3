<?php  
 //fetch.php 
 include_once('../connect.php'); 
$json=array();
	$cn=new connect();
	$cn->connectdb();
 
 if(isset($_GET["invoice_no"]))  
 {  
     $invoice_no = $_GET["invoice_no"];
     $last = $_GET["last"];
	 if($last == "yes")
		 $addFilter = "SELECT ip.*,u.user_name FROM tbl_payment_history ip,tbl_user u WHERE ip.service_confirmation_id = ".$invoice_no." AND ip.entry_person_id = u.user_id ORDER BY ip.payment_id DESC LIMIT 1";
	else
		$addFilter = "SELECT ip.*,u.user_name FROM tbl_payment_history ip,tbl_user u WHERE ip.service_confirmation_id = ".$invoice_no." AND ip.entry_person_id = u.user_id ORDER BY ip.payment_id DESC";
    $result = $cn->selectdb($addFilter); 
	?>
		
    <?$j=1;	
    if(mysqli_num_rows($result) > 0)
    {
        while($row=mysqli_fetch_assoc($result))
			{
				extract($row);
				
				?>
				
				<tr id="row<? echo $payment_id ?>" style="text-align:center;">
					
					<td ><? $payment_date_time = strtotime($payment_date_time); echo date('d-m-Y h:i:s',$payment_date_time); ?>
					</td>
					<td><? echo $paid_amount; ?></td>
					<td><? echo $description; ?></td>
					<td><? echo $user_name; ?></td>
					<td ><a href='payment_receipt.php?payment_id=<?php echo $payment_id;?>' target="_BLANK"><i class="fa fa-print"></i></a>
					</td>
					
					<!-- <td style="text-align:center;"><a><i class="fa fa-trash"  onclick="deletePayment('<?php echo $payment_id ?>')"></i></a></td> -->
				</tr>
				
				<?
				$j++;
				// END
            }
        }else{
            ?>
                <tr>
					<td colspan="5">No Payment History Available.</td>
				</tr>
            <?
        }
		?>
			
		<?	
			//print_r($json['packingl  echo json_encode($json);  
 } 

 ?>