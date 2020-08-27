<?
 include_once('../connect.php'); 
class commonFunc
{
    
    
	public function returnAllAmt($txtServiceConfirmationNo)
    {
        $cn=new connect();
	$cn->connectdb();
        $sql = $cn->selectdb("SELECT  total_amount,net_amount,gst_charge,received_amount,credit_amount  FROM tbl_service_confirmation WHERE service_confirmation_id = ".$txtServiceConfirmationNo);
		if(mysqli_num_rows($sql) > 0)
		{
			$row = mysqli_fetch_assoc($sql);
			
			$returnObj = (object)[]; 
			$returnObj->total_amount=$row['total_amount'];
			$returnObj->net_amount=$row['net_amount'];
			$returnObj->gst_charge=$row['gst_charge'];
			$returnObj->received=$row['received_amount'];
			$returnObj->credit=$row['credit_amount'];
			return json_encode($returnObj);
		}
	}
	public function returnServiceRate($service_no)
    {
        $cn=new connect();
	$cn->connectdb();
        $sql = $cn->selectdb("SELECT  gst_rate  FROM tbl_product WHERE product_id = ".$service_no);
		if(mysqli_num_rows($sql) > 0)
		{
			$row = mysqli_fetch_assoc($sql);
			
			$returnObj = (object)[]; 
			$returnObj->gst_rate=$row['gst_rate'];
			
			return json_encode($returnObj);
		}
	}
	public function returnExpenseGSTRate($expense_id)
    {
        $cn=new connect();
	$cn->connectdb();
        $sql = $cn->selectdb("SELECT  expense_gst  FROM tbl_expense WHERE expense_id = ".$expense_id);
		if(mysqli_num_rows($sql) > 0)
		{
			$row = mysqli_fetch_assoc($sql);
			
			$returnObj = (object)[]; 
			$returnObj->gst_rate=$row['expense_gst'];
			
			return json_encode($returnObj);
		}
	}
	public function returnServiceDetails($ServiceInclusionNo)
    {
        $cn=new connect();
	$cn->connectdb();
        $sql = $cn->selectdb("SELECT u.user_name,p.name,si.* FROM tbl_product p, tbl_user u, tbl_service_inclusion si WHERE si.product_id = p.product_id AND si.entry_person_id = u.user_id AND si.service_inclusion_id = ".$ServiceInclusionNo);
		if(mysqli_num_rows($sql) > 0)
		{
			$row = mysqli_fetch_assoc($sql);
			
			$returnObj = (object)[]; 
			$returnObj->service_inclusion_id=$row['service_inclusion_id'];
			$returnObj->user_name=$row['user_name'];
			$returnObj->description=$row['description'];
			$returnObj->short_desc=$row['short_desc'];
			$returnObj->service_name=$row['name'];
			$returnObj->product_id=$row['product_id'];
			$returnObj->duration=$row['duration'];
			$returnObj->yorm=$row['yorm'];
			$returnObj->gst=$row['gst'];
			$returnObj->total_amount=$row['total_amount'];
			$returnObj->quantity=$row['quantity'];
			$returnObj->service_rate=$row['service_rate'];
			$returnObj->entry_date=date("d-m-Y H:i:s",strtotime($row['entry_date']));
			return json_encode($returnObj);
		}
	}
	public function returnAllAmtProforma($txtServiceConfirmationNo)
    {
        $cn=new connect();
	$cn->connectdb();
        $sql = $cn->selectdb("SELECT  total_amount,net_amount,gst_charge,received,credit  FROM tbl_proforma WHERE proforma_id = ".$proforma_no);
		if(mysqli_num_rows($sql) > 0)
		{
			$row = mysqli_fetch_assoc($sql);
			
			$returnObj = (object)[]; 
			$returnObj->total_amount=$row['total_amount'];
			$returnObj->net_amount=$row['total_amount'];
			$returnObj->gst_charge=$row['gst_charge'];
			$returnObj->received=$row['received'];
			$returnObj->credit=$row['credit'];
			return json_encode($returnObj);
		}
	}
	public function returnNumberInformate($number)
	{
		return number_format($number, 2, '.', '');
	}
}
?>