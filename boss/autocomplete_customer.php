<?php
    include_once('../connect.php'); 
	
	$cn=new connect();
$cn->connectdb();

    $sql = "select * from tbl_shipper where shipper_name like '%".$_GET['custname']."%'";
    $result = $cn->selectdb($sql);// or die("Error " . mysqli_error($connection));
	
	//echo "<script> alert(hi)";
    $cname_list = array();
	$cnt=0;
    while($row = mysqli_fetch_array($result))
    {
        $cname_list["customer_name"][$cnt] = $row['shipper_name'];
		$cname_list["customer_id"][$cnt] = $row['shipper_id'];
		$cname_list["customer_address"][$cnt] = $row['shipper_address'];
		$cname_list["customer_city"][$cnt] = $row['shipper_city'];
		$cname_list["customer_pincode"][$cnt] = $row['shipper_pincode'];
        $cname_list["customer_phone1"][$cnt] = $row['shipper_phone1'];
        $cname_list["customer_phone2"][$cnt] = $row['shipper_mobile'];
        $cname_list["customer_email"][$cnt] = $row['shipper_email'];
        $cname_list["gst_no"][$cnt] = $row['gst_no'];
        $cname_list["gst_type"][$cnt] = $row['gst_type'];
        $cname_list["payment_type"][$cnt] = $row['type'];
        
		$cnt++;
		
		//echo $row['department_name'];die;
    }
    echo json_encode($cname_list);
?>