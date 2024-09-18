<?php



include_once('../sql/conn.php');
if($pass_cron != $_GET["key"]) {
    die('cron key not found');
}
include_once('../auth/utils.php');
include_once('../auth/vps_vietnam.php');
include_once('../utils_system/cloudhub.php');
include_once('../helper/mail.php');
include_once('../helper/vps_vietnam.php');
include_once('../auth/action_task_vps_vn.php');
include_once('../email/utils.php');
$conn = new db();
include_once('../auth/hoa_don.php');

$getTask = getAndDeleteTaskVPSVPN();
if($getTask == false) {
    die('No task');
}


$user_email = $getTask["user_email"];
$task = $getTask["task"];
$value_task = $getTask["value_task"];
$id_vps = $getTask["id_vps"];
$infoVPS = getInfoVPSByVPS_ID($id_vps);

if($infoVPS == false) {
    die('VPS not found');
}

if($infoVPS["user_email"] != $user_email) {
    die('User not found');
}

// check khả dụng của token agency
$token_agency = $conn->query("SELECT * FROM agency_data WHERE name = 'agency_token'")->fetch_assoc(); // token của agency
if($token_agency == false) {
    die('Token agency not found');
}

$cloudhub = new cloudhub($apiUsername, $apiApp, $apiSecret, $token_agency['data'], $proxy_address);

// kiểm tra số dư trước khi tạo đơn
$infoAgency = $cloudhub->getInfo();

if($infoAgency["error"] != 0) {
    die('Agency error');
}



// xử lý hành động
if($task == "on") {
    $taskResult = $cloudhub->actionVPS($id_vps, "on");

    if($taskResult["error"] == 0) {
        addLog($user_email, "Bật VPS - ID: ".$id_vps, "action_vps_vn");
    } else {
        addLog($user_email, "Lỗi bật VPS - ID: ".$id_vps, "action_vps_vn");
    }

    die(json_encode($taskResult, JSON_PRETTY_PRINT));
} 


if($task == "off") {
    $taskResult = $cloudhub->actionVPS($id_vps, "off");

    if($taskResult["error"] == 0) {
        addLog($user_email, "Tắt VPS - ID: ".$id_vps, "action_vps_vn");
    } else {
        addLog($user_email, "Lỗi tắt VPS - ID: ".$id_vps, "action_vps_vn");
    }

    die(json_encode($taskResult, JSON_PRETTY_PRINT));
}



if($task == "restart") {
    $taskResult = $cloudhub->actionVPS($id_vps, "restart");

    if($taskResult["error"] == 0) {
        addLog($user_email, "Khởi động lại VPS - ID: ".$id_vps, "action_vps_vn");
    } else {
        addLog($user_email, "Lỗi khởi động lại VPS - ID: ".$id_vps, "action_vps_vn");
    }

    die(json_encode($taskResult, JSON_PRETTY_PRINT));
}



if($task == "cancel") {
    $taskResult = $cloudhub->actionVPS($id_vps, "cancel");

    if($taskResult["error"] == 0) {
        addLog($user_email, "Hủy VPS - ID: ".$id_vps, "action_vps_vn");
    } else {
        addLog($user_email, "Lỗi hủy VPS - ID: ".$id_vps, "action_vps_vn");
    }

    die(json_encode($taskResult, JSON_PRETTY_PRINT));
}


if($task == "confirm-rebuild-vps") {
   
    $taskResult = $cloudhub->reinstallOS($id_vps, $value_task);

    if ($taskResult["error"] == 0) {
        editOSVPSVN($id_vps, $value_task);
        addLog($user_email, "Rebuild VPS - ID: ".$id_vps, "action_vps_vn");
    } else {
        addLog($user_email, "Lỗi rebuild VPS - ID: ".$id_vps, "action_vps_vn");
    }
}


if($task == "renew-vps") {
    $infoUser = getInfoByEmail($user_email); // thông tin người đặt đơn
    if ($infoUser == false) {
        die('User not found');
    }


    $money = $infoUser["money"];

    $vpsInfo = getInfoVPSByVPS_ID($id_vps);

    if($vpsInfo == false) {
        die( json_encode(array(
            "error" => 1,
            "message" => "Không tìm thấy vps"
        ), JSON_PRETTY_PRINT) );
    }

    if($vpsInfo["user_email"] != $user_email) {
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


    $priceProduct = $newPrice[$value_task];
    if ($priceProduct == null) {
        die( json_encode(array(
            "error" => 1,
            "message" => "Không tìm thấy giá sản phẩm"
        ), JSON_PRETTY_PRINT) );
    }

    $priceProduct = $priceProduct["amount"];


    if($money < $priceProduct) {
        addLog($user_email, "Không đủ tiền để gia hạn VPS - ID: ".$id_vps, "action_vps_vn");
        die( json_encode(array(
            "error" => 1,
            "message" => "Số dư không đủ"
        ), JSON_PRETTY_PRINT) );
    }


    // tru tien
    tru_tien_user($user_email, $priceProduct, "Gia hạn VPS - ID: ".$id_vps. "- Giá: ".$priceProduct);


    // gia hạn
    $taskResult = $cloudhub->renewVPS($id_vps, $value_task);

    if($taskResult["error"] == 0) {
        addLog($user_email, "Gia hạn VPS - ID: ".$id_vps, "action_vps_vn");
        editBillingCycle($id_vps, $value_task);
        $info = array(
            array(
                "ten_san_pham" => "Gia hạn VPS [ID: ".$id_vps."]",
                "so_luong" => $value_task,
                "gia" => $priceProduct
            )
            );

        updateStatusHoaDonByPartnerId($getTask["id"]."gia_han", 1);
        $emailContent = create_mail_infomation_renew_vps($infoUser["username"], $info);
        sendEmail($infoUser["email"], "Thông tin gia hạn VPS", $emailContent);

    } else {
        addLog($user_email, "Lỗi gia hạn VPS - ID: ".$id_vps, "action_vps_vn");
        // hoàn tiền

        addMoney($user_email, $priceProduct);
        updateStatusHoaDonByPartnerId($getTask["id"]."gia_han", 2);
    }


}

if($task == 'confirm-upgrade-vps') {
    $infoUser = getInfoByEmail($user_email); // thông tin người đặt đơn
    if ($infoUser == false) {
        die('User not found');
    }

    $money = $infoUser["money"];

    $vpsInfo = getInfoVPSByVPS_ID($id_vps);

    if($vpsInfo == false) {
        die( json_encode(array(
            "error" => 1,
            "message" => "Không tìm thấy vps"
        ), JSON_PRETTY_PRINT) );
    }

    if($vpsInfo["user_email"] != $user_email) {
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


    $infoUpgrade = json_decode($value_task, true);
    $cpuUpgrade = $infoUpgrade["cpu"];
    $ramUpgrade = $infoUpgrade["ram"];
    $diskUpgrade = $infoUpgrade["disk"];


    $addonInfoCPU = getInfoAddByName("CPU")["product"];
    $addonInfoRAM = getInfoAddByName("RAM")["product"];
    $addonInfoDISK = getInfoAddByName("SSD")["product"];



    if ($addonInfoCPU == null || $addonInfoRAM == null || $addonInfoDISK == null) {
        updateStatusHoaDonByPartnerId($getTask["id"]."nang_cap", 2);
        die('
           Không tìm thấy thông tin sản phẩm!
        ');
        
    }

    $expriDate = strtotime($vpsInfo["next_due_date"]);
    $currentDate = strtotime(date("d-m-Y"));
    $countDays = ($expriDate - $currentDate) / (60 * 60 * 24);
    $month = $countDays / 30;
    $days = $countDays - (floor($month) * 30);

    $priceCPU = $addonInfoCPU["pricing"]["monthly"]["amount"];
    $priceRAM = $addonInfoRAM["pricing"]["monthly"]["amount"];
    $priceDISK = $addonInfoDISK["pricing"]["monthly"]["amount"];

    if($countDays < 5) {
        $priceCPU = $priceCPU / 2;
        $priceDISK = $priceDISK / 2;
        $priceRAM = $priceRAM / 2;
    }
    else {
        $priceCPU = ($priceCPU * round($month))* round($cpuUpgrade);
        $priceDISK = ($priceDISK * round($month))* round($diskUpgrade / 10);
        $priceRAM = ($priceRAM * round($month)) * round($ramUpgrade);
    }

    $total = $priceCPU + $priceRAM + $priceDISK;
    // check tiền
    if ($money < $total) {
        updateStatusHoaDonByPartnerId($getTask["id"]."nang_cap", 2);
        addLog($user_email, "Không đủ tiền để nâng cấp VPS - ID: ".$id_vps, "action_vps_vn");
        die($user_email['email'].'Không đủ tiền để nâng cấp VPS - ID: '.$id_vps);
    }

    // tru tien
    tru_tien_user($user_email, $total, "Nâng cấp VPS - ID: ".$id_vps. "- Giá: ".$total);
    

    // tien hanh nang cap
    $taskResult = $cloudhub->upgradeVPS($id_vps, $cpuUpgrade, $ramUpgrade, $diskUpgrade);
    if($taskResult["error"] == 0) {
        addLog($user_email, "Nâng cấp VPS - ID: ".$id_vps, "action_vps_vn");
        updateStatusHoaDonByPartnerId($getTask["id"]."nang_cap", 1);
        $info = array(
            array(
                "ten_san_pham" => "Nâng cấp VPS [ID: ".$id_vps."]",
                "so_luong" => 1,
                "gia" => $total
            )
            );

        $emailContent = create_mail_infomation_upgrade_vps($infoUser["username"], $info);
        sendEmail($infoUser["email"], "Thông tin nâng cấp VPS", $emailContent);
    } else {
        addLog($user_email, "Lỗi nâng cấp VPS - ID: ".$id_vps, "action_vps_vn");
        // hoàn tiền
        addMoney($user_email, $total);
        updateStatusHoaDonByPartnerId($getTask["id"]."nang_cap", 2);
    }
}



