<?php

    // header json response
    header('Content-Type: application/json');
    error_reporting(0);
    include_once('../security/utils.php');    
    include_once('../sql/conn.php');
    include_once('../auth/utils.php');
    include_once('../helper/time.php');
    include_once('../security/utils.php');
    include_once('../helper/vps_vietnam.php');
    include_once('../auth/vps_vietnam.php');
    

    $id_vps = isset($_POST["id_vps"]) ? $_POST["id_vps"] : "";
    //$id_vps = 9363;
    if (empty($id_vps)) {
        die( json_encode(array(
            "error" => 1,
            "message" => "Thiếu thông tin hoặc thông tin không hợp lệ"
        ), JSON_PRETTY_PRINT) );
    }
    $conn = new db();
    include_once('../auth/user.php');
    include_once('../auth/cloudhub.php');
    $rq_check = acceptRequestTime($userInfo, $cooldownCronVPSStatus, "get_list_os_can_reinstall_vps_vn");
    if($rq_check == false) {
        die('Thao tác chậm lại');
    }

    $vpsInfo = getInfoVPSByVPS_ID($id_vps);

    if($vpsInfo == false) {
        die( json_encode(array(
            "error" => 1,
            "message" => "Không tìm thấy vps"
        ), JSON_PRETTY_PRINT) );
    }

    if($vpsInfo["user_email"] != $userInfo["email"]) {
        die( json_encode(array(
            "error" => 1,
            "message" => "Bạn không có quyền thực hiện hành động đối với vps này"
        ), JSON_PRETTY_PRINT) );
    }

    $fullInfoVPS = getInfoVPSById($vpsInfo["product_id"]);
    if($fullInfoVPS == false) {
        die( json_encode(array(
            "error" => 1,
            "message" => "Không tìm thấy vps"
        ), JSON_PRETTY_PRINT) );
    }


    $infoBillingCycle = $fullInfoVPS["product"]["pricing"];

    if($infoBillingCycle == false) {
        die( json_encode(array(
            "error" => 1,
            "message" => "Không tìm thấy thông tin billing cycle"
        ), JSON_PRETTY_PRINT) );
    }
    

    $default_cpu = $fullInfoVPS["product"]["cpu"];
    $default_ram = $fullInfoVPS["product"]["ram"];
    $default_disk = $fullInfoVPS["product"]["disk"];

    $getInfoProductCPU = getInfoAddByName("CPU");
    if ($getInfoProductCPU == false) {
        die( json_encode(array(
            "error" => 1,
            "message" => "Không tìm thấy thông tin CPU"
        ), JSON_PRETTY_PRINT) );
    }
    $getInfoProductRAM = getInfoAddByName("RAM");
    if ($getInfoProductRAM == false) {
        die( json_encode(array(
            "error" => 1,
            "message" => "Không tìm thấy thông tin RAM"
        ), JSON_PRETTY_PRINT) );
    }
    $getInfoProductDISK = getInfoAddByName("SSD");
    if ($getInfoProductDISK == false) {
        die( json_encode(array(
            "error" => 1,
            "message" => "Không tìm thấy thông tin SSD"
        ), JSON_PRETTY_PRINT) );
    }
    
    $pricingCPU = $getInfoProductCPU["product"]["pricing"];
    $pricingRAM = $getInfoProductRAM["product"]["pricing"];
    $pricingDISK = $getInfoProductDISK["product"]["pricing"];


    $addonCPUCaculator = $vpsInfo["cpu"] - $default_cpu;
    $addonRAMCaculator = $vpsInfo["ram"] - $default_ram;
    $addonDISKCaculator = $vpsInfo["disk"] - $default_disk;
    
    $newPrice = [];
    foreach ($infoBillingCycle as $key => $value) {
        if($value["amount"] > 0) {
            $amount = $value["amount"];
            $pricePerCPU = $pricingCPU[$key]["amount"] * $addonCPUCaculator;
            $amount += $pricePerCPU;
            $pricePerRAM = $pricingRAM[$key]["amount"] * $addonRAMCaculator;
            $amount += $pricePerRAM;
            $pricePerDISK = $pricingDISK[$key]["amount"] * $addonDISKCaculator / 10;
            $amount += $pricePerDISK;
            $newPrice[$key] = array(
                "billing_cycle" => $value["billing_cycle"],
                "amount" => $amount
            );
        }
    }

    die ( json_encode(array(
        "error" => 0,
        "message" => "Thành công",
        "data" => $newPrice
    ), JSON_PRETTY_PRINT) );








?>