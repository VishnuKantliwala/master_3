<?php
    include_once("../connect.php");
    include_once("../navigationfun.php");
    $cn=new connect();
    $cn->connectdb();

    $keyword = $_POST['keyword'];
    if($keyword!=""){
        $sql="SELECT customer_id,customer_name FROM tbl_customer WHERE customer_name LIKE '%".$keyword."%'";
        $result = $cn->selectdb($sql);
        if($cn->numRows($result)>0){
?>
    <ul id="customer-list">
<?php
            while($row=$cn->fetchAssoc($result)){
?>
        <li onClick="selectCustomer('<?php echo $row["customer_name"]; ?>','<?php echo $row['customer_id'];?>');"><?php echo $row["customer_name"]; ?></li>
<?php
            }
?>
    </ul>
<?php
        }
    }
?>