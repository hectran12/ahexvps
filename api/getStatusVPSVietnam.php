<?php
    header('Content-Type: application/json');
    error_reporting(0);
    include_once('../security/utils.php');    
    include_once('../sql/conn.php');
    include_once('../auth/utils.php');
    include_once('../helper/time.php');
    include_once('../security/utils.php');
    include_once('../helper/vps_vietnam.php');
    include_once('../auth/vps_vietnam.php');
    include_once('../helper/vps_vietnam.php');

    $conn = new db();
    include_once('../auth/user.php');

    $rq_check = acceptRequestTime($userInfo, $cooldownCronVPSStatus, "cron_status_vpsvn");
    if($rq_check == false) {
        die('Thao tác chậm lại');
    }

    $allOrders = getOrderVPSVNByUserEmail($userInfo["email"]);
    $allIds = [];
    foreach ($allOrders as $order) {
        array_push($allIds, array(
            "vps_id" => $order["id_vps"],
            "ip" => $order["ip"],
            "username" => $order["username"],
            "password" => $order["password"],
            "os_name" => getOSById($order["os_id"])["os-name"],
            "vps_status" => getVPSStatusHTML($order["vps_status"]),
            "auto_renew" => getAutoRenewHTML($order["auto_renew"]),
            "note" => $order["note"]
        ));
    }
    updateTimeRequestServer($userInfo, "cron_status_vpsvn");
    echo json_encode($allIds);





?>