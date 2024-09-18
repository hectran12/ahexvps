<?php
error_reporting(0);
include_once('../security/utils.php');    
include_once('../sql/conn.php');
include_once('../auth/utils.php');
include_once('../helper/time.php');
include_once('../security/utils.php');
include_once('../helper/string.php');
include_once('../auth/napthe.php');

$conn = new db();
/** CALLBACK */
if(isset($_GET['request_id']) && isset($_GET['callback_sign'])){
    $status = isset($_GET['status']) ? $_GET['status'] : null;
    $message = isset($_GET['message']) ? $_GET['message'] : null;
    $request_id = isset($_GET['request_id']) ? $_GET['request_id'] : null;
    $declared_value = isset($_GET['declared_value']) ? $_GET['declared_value'] : null;
    $value = isset($_GET['value']) ? $_GET['value'] : null;
    $amount = isset($_GET['amount']) ? $_GET['amount'] : null;
    $code = isset($_GET['code']) ? $_GET['code'] : null;
    $serial = isset($_GET['serial']) ? $_GET['serial'] : null;
    $telco = isset($_GET['telco']) ? $_GET['telco'] : null;
    $trans_id = isset($_GET['trans_id']) ? $_GET['trans_id'] : null;
    $callback_sign = isset($_GET['callback_sign']) ? $_GET['callback_sign'] : null;



    if($callback_sign != md5($partner_key.$code.$serial)){
        die('callback_sign_error');
    }
    //$code = check_string($_GET['content']);
    $infoCard = findCardByTransId($request_id);
    if($infoCard["status"] != 0){
        die('transaction_already_processed');
    }
    if($infoCard == false) {
        die('transaction_not_found');
    }

    if($status == 1){
        if($chietkhau_default == 0){
            $price = $amount;
        }else{
            $price = $value - $value * $chietkhau_default / 100;
        }
        updateCardByTransId($request_id, 1, $price, gettime());
        $email = $infoCard["user_id"];
        addMoney($email, $price);
        die('payment.success');
    }
    else{
        updateCardByTransId($request_id, 2, 0, gettime());
        exit('payment.error');
    }
}



