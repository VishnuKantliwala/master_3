<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location:login.php");
}
if ($_SESSION['control'] != "admin") {
    header("location:login.php");
}
include_once("../connect.php");
include_once("../navigationfun.php");
$cn = new connect();
$cn->connectdb();
if($_POST['task'] == 'Invoice')
{
    $invoice_id = $_POST['invoice_id'];
    $sql = "UPDATE tbl_service_inclusion SET invoice_id = 0 WHERE invoice_id = ".$invoice_id;
    $cn->insertdb($sql);
    $sql = "DELETE FROM tbl_invoice WHERE invoice_id='" . $invoice_id . "'";
    //echo $sql;
    $cn->insertdb($sql);
    if (mysqli_affected_rows($cn->getConnection()) > 0) {
        echo "true";
    } else {
        echo "false";
    }
}
if($_POST['task'] == 'Proforma')
{
    $proforma_id = $_POST['proforma_id'];
    $sql = "UPDATE tbl_service_inclusion SET proforma_id = 0 WHERE proforma_id = ".$proforma_id;
    $cn->insertdb($sql);
    $sql = "DELETE FROM tbl_proforma WHERE proforma_id=" . $proforma_id;
    //echo $sql;
    $cn->insertdb($sql);
    if (mysqli_affected_rows($cn->getConnection()) > 0) {
        echo "true";
    } else {
        echo "false";
    }
}
if($_POST['task'] == 'CashInvoice')
{
    $cash_id = $_POST['cash_id'];
    $sql = "UPDATE tbl_service_inclusion SET cash_id = 0 WHERE cash_id = ".$cash_id;
    $cn->insertdb($sql);
    $sql = "DELETE FROM tbl_cash WHERE cash_id=" . $cash_id;
    //echo $sql;
    $cn->insertdb($sql);
    if (mysqli_affected_rows($cn->getConnection()) > 0) {
        echo "true";
    } else {
        echo "false";
    }
}
?>
 
