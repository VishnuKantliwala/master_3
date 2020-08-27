<?php
    include_once("../connect.php");
    include_once("../navigationfun.php");
    $cn=new connect();
    $cn->connectdb();

    $keyword = $_POST['keyword'];
    if($keyword!=""){
        $sql="SELECT inquiry_id,company_name FROM tbl_inquiry WHERE company_name LIKE '%".$keyword."%'";
        $result = $cn->selectdb($sql);
        if($cn->numRows($result)>0){
?>
    <ul id="company-list">
<?php
            while($row=$cn->fetchAssoc($result)){
?>
        <li onClick="selectCompany('<?php echo $row["company_name"]; ?>','<?php echo $row['inquiry_id'];?>');"><?php echo $row["company_name"]; ?></li>
<?php
            }
?>
    </ul>
<?php
        }
    }
?>