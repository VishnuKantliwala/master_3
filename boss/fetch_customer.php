<?php
    include_once("../connect.php");
    include_once("../navigationfun.php");
    $cn=new connect();
    $cn->connectdb();

    $keyword = $_POST['keyword'];
    if($keyword!=""){
        $sql="SELECT shipper_id,shipper_name FROM tbl_shipper WHERE shipper_name LIKE '%".$keyword."%'";
        $result = $cn->selectdb($sql);
        if($cn->numRows($result)>0){
?>
    <ul id="customer-list" style="max-height:200px;overflow-x:hidden;overflow-y:auto;">
<?php
            while($row=$cn->fetchAssoc($result)){
?>
        <li onClick="selectCustomer('<?php echo $row["shipper_name"]; ?>','<?php echo $row['shipper_id'];?>');"><?php echo $row["shipper_name"]; ?></li>
<?php
            }
?>
    </ul>
<?php
        }
    }
?>