<?php
    header('Content-Type: application/json');
    error_reporting(0);
    include_once('../security/utils.php');    
    include_once('../sql/conn.php');
    include_once('../auth/utils.php');
    include_once('../helper/time.php');
    include_once('../security/utils.php');

    $conn = new db();
    include_once('../auth/user.php');


    $bankHistory = getBankInvoiceByEmail($userInfo["email"]);
    $bankHistory = json_encode($bankHistory);
    echo $bankHistory;

    
?>