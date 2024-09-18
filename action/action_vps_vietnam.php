<?php
error_reporting(0);
include_once '../security/utils.php';
include_once '../sql/conn.php';
include_once '../auth/utils.php';
include_once '../helper/time.php';
include_once '../security/utils.php';
include_once '../auth/vps_vietnam.php';
include_once '../helper/vps_vietnam.php';
include_once('../helper/mail.php');
include_once('../email/utils.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_vps = isset($_POST["id_vps"]) ? $_POST["id_vps"] : "";
    $action = isset($_POST["action"]) ? $_POST["action"] : "";

    $white_list_action = [
        "on", // bật vps
        "off", // tắt vps
        "restart", // khởi động vps
        "cancel", // hủy vps
        "confirm_rebuild_vps", // xác nhận rebuild vps
        "renew_vps", // gia hạn vps
    ];


    // kiểm tra thông tin (bao gồm cả action và id_vps)
    if (empty($id_vps) || empty($action) || !in_array($action, $white_list_action)) {
        return json_encode(array(
            "error" => 1,
            "message" => "Thiếu thông tin hoặc thông tin không hợp lệ",
        ), JSON_PRETTY_PRINT);
    }


    // thêm các file cần thiết
    $conn = new db();
    include_once '../auth/user.php';
    include_once '../auth/action_task_vps_vn.php';
    include_once '../auth/cloudhub.php';
    include_once '../auth/hoa_don.php';


    // check thông tin vps
    $vpsInfo = getInfoVPSByVPS_ID($id_vps);
    if ($vpsInfo == false) {
        return json_encode(array(
            "error" => 1,
            "message" => "Không tìm thấy vps",
        ), JSON_PRETTY_PRINT);
    }


    // kiểm tra quyền hạn (chỉ có thể thực hiện hành động đối với vps của mình)
    if ($vpsInfo["user_email"] !== $userInfo["email"]) {
        return json_encode(array(
            "error" => 1,
            "message" => "Bạn không có quyền thực hiện hành động đối với vps này",
        ), JSON_PRETTY_PRINT);
    }


    // kiểm tra số lượng task đã tạo
    $countTaskCreateByUser = getCountTaskByEmailVPSVN($userInfo["email"]);
    if ($countTaskCreateByUser > 50) {
        return json_encode(array(
            "error" => 1,
            "message" => "Bạn đã tạo quá nhiều task, vui lòng chờ task cũ hoàn thành",
        ), JSON_PRETTY_PRINT);
    }


    // kiểm tra action và thực hiện hành động tương ứng
    if ($action == "on") {

        if ($vpsInfo["vps_status"] != "running" && $vpsInfo["vps_status"] != "off_vps") {
            return json_encode(array(
                "error" => 1,
                "message" => "Vps không thể bật",
            ), JSON_PRETTY_PRINT);
        }

        createTaskVPSVN($userInfo["email"], "on", "", $id_vps);
        addLog($userInfo["email"], "Bật vps - ID: " . $id_vps, "on_vps");
        die(json_encode(array(
            "error" => 0,
            "message" => "Đã tạo task bật vps",
        ), JSON_PRETTY_PRINT));

    }

    if ($action == "off") {
        if ($vpsInfo["vps_status"] != "running" && $vpsInfo["vps_status"] != "off_vps") {
            return json_encode(array(
                "error" => 1,
                "message" => "Vps không thể bật",
            ), JSON_PRETTY_PRINT);
        }

        createTaskVPSVN($userInfo["email"], "off", "", $id_vps);
        addLog($userInfo["email"], "Tắt vps - ID: " . $id_vps, "off_vps");
        die(json_encode(array(
            "error" => 0,
            "message" => "Đã tạo task tắt vps",
        ), JSON_PRETTY_PRINT));
    }

    if ($action == 'restart') {
        if ($vpsInfo["vps_status"] != "running" && $vpsInfo["vps_status"] != "off_vps") {
            return json_encode(array(
                "error" => 1,
                "message" => "Vps không khởi động lại",
            ), JSON_PRETTY_PRINT);
        }

        createTaskVPSVN($userInfo["email"], "restart", "", $id_vps);
        addLog($userInfo["email"], "Khởi động lại vps - ID: " . $id_vps, "restart_vps");
        die(json_encode(array(
            "error" => 0,
            "message" => "Đã tạo task khởi động lại vps",
        ), JSON_PRETTY_PRINT));
    }

    if ($action == 'cancel') {
        if ($vpsInfo["vps_status"] != "running" && $vpsInfo["vps_status"] != "off_vps") {
            return json_encode(array(
                "error" => 1,
                "message" => "Vps không thể hủy",
            ), JSON_PRETTY_PRINT);
        }

        createTaskVPSVN($userInfo["email"], "cancel", "", $id_vps);
        addLog($userInfo["email"], "Hủy vps - ID: " . $id_vps, "cancel_vps");
        die(json_encode(array(
            "error" => 0,
            "message" => "Đã tạo task hủy vps",
        ), JSON_PRETTY_PRINT));
    }

    if ($action == "confirm_rebuild_vps") {
        if ($vpsInfo["vps_status"] != "running" && $vpsInfo["vps_status"] != "off_vps") {
            return json_encode(array(
                "error" => 1,
                "message" => "Vps không thể rebuild",
            ), JSON_PRETTY_PRINT);
        }

        $os_id = isset($_POST["os_id"]) ? $_POST["os_id"] : "";
        if (empty($os_id)) {
            return json_encode(array(
                "error" => 1,
                "message" => "Thiếu thông tin hoặc thông tin không hợp lệ",
            ), JSON_PRETTY_PRINT);
        }

        $osCanReinstall = $cloudhub->actionVPS($id_vps, "check-os-when-rebuild-vps");
        if ($osCanReinstall["error"] == 0) {
            for ($i = 0; $i < count($osCanReinstall["list-os"]); $i++) {
                if ($osCanReinstall["list-os"][$i]["os-id"] == $os_id) {
                    createTaskVPSVN($userInfo["email"], "confirm-rebuild-vps", $os_id, $id_vps);
                    addLog($userInfo["email"], "Xác nhận rebuild vps - ID: " . $id_vps, "confirm_rebuild_vps");
                    die(json_encode(array(
                        "error" => 0,
                        "message" => "Đã tạo task xác nhận rebuild vps",
                    ), JSON_PRETTY_PRINT));
                }
            }
        }
        die(json_encode(array(
            "error" => 1,
            "message" => "Không thể xác nhận rebuild vps",
        ), JSON_PRETTY_PRINT));
    }

    if ($action == "renew_vps") {
        $billingCycle = isset($_POST["billing_cycle"]) ? $_POST["billing_cycle"] : "";
        $billingCycle = str_replace(" ", "", $billingCycle);
        if (empty($billingCycle)) {
            return json_encode(array(
                "error" => 1,
                "message" => "Thiếu thông tin hoặc thông tin không hợp lệ",
            ), JSON_PRETTY_PRINT);
        }

        $fullInfoVPS = getInfoVPSById($vpsInfo["product_id"]);
        if ($fullInfoVPS == false) {
            die(json_encode(array(
                "error" => 1,
                "message" => "Không tìm thấy vps",
            ), JSON_PRETTY_PRINT));
        }

        $infoBillingCycle = $fullInfoVPS["product"]["pricing"];

        if ($infoBillingCycle == false) {
            die(json_encode(array(
                "error" => 1,
                "message" => "Không tìm thấy thông tin billing cycle",
            ), JSON_PRETTY_PRINT));
        }

        $default_cpu = $fullInfoVPS["product"]["cpu"];
        $default_ram = $fullInfoVPS["product"]["ram"];
        $default_disk = $fullInfoVPS["product"]["disk"];

        $getInfoProductCPU = getInfoAddByName("CPU");
        if ($getInfoProductCPU == false) {
            die(json_encode(array(
                "error" => 1,
                "message" => "Không tìm thấy thông tin CPU",
            ), JSON_PRETTY_PRINT));
        }
        $getInfoProductRAM = getInfoAddByName("RAM");
        if ($getInfoProductRAM == false) {
            die(json_encode(array(
                "error" => 1,
                "message" => "Không tìm thấy thông tin RAM",
            ), JSON_PRETTY_PRINT));
        }
        $getInfoProductDISK = getInfoAddByName("SSD");
        if ($getInfoProductDISK == false) {
            die(json_encode(array(
                "error" => 1,
                "message" => "Không tìm thấy thông tin SSD",
            ), JSON_PRETTY_PRINT));
        }

        $pricingCPU = $getInfoProductCPU["product"]["pricing"];
        $pricingRAM = $getInfoProductRAM["product"]["pricing"];
        $pricingDISK = $getInfoProductDISK["product"]["pricing"];

        $addonCPUCaculator = $vpsInfo["cpu"] - $default_cpu;
        $addonRAMCaculator = $vpsInfo["ram"] - $default_ram;
        $addonDISKCaculator = $vpsInfo["disk"] - $default_disk;

        $newPrice = [];
        foreach ($infoBillingCycle as $key => $value) {
            if ($value["amount"] > 0) {
                $amount = $value["amount"];
                $pricePerCPU = $pricingCPU[$key]["amount"] * $addonCPUCaculator;
                $amount += $pricePerCPU;
                $pricePerRAM = $pricingRAM[$key]["amount"] * $addonRAMCaculator;
                $amount += $pricePerRAM;
                $pricePerDISK = $pricingDISK[$key]["amount"] * $addonDISKCaculator / 10;
                $amount += $pricePerDISK;
                $newPrice[$key] = array(
                    "billing_cycle" => $value["billing_cycle"],
                    "amount" => $amount,
                );
            }
        }

        $packageSelected = $newPrice[$billingCycle];
        if ($packageSelected == null) {
            die(json_encode(array(
                "error" => 1,
                "message" => "Không tìm thấy thông tin billing cycle",
            ), JSON_PRETTY_PRINT));
        }

        // check wallet
        if($userInfo["money"] >= $packageSelected["amount"]) {
            $idTask = createTaskVPSVN($userInfo["email"], "renew-vps", $billingCycle, $id_vps);
            $confirmEmail = create_mail_confirm_order(
                $userInfo["username"],
                array(

                    array(
                        "ten_san_pham" => "Gia hạn VPS có id " . $id_vps,
                        "so_luong" => $billingCycle,
                        "gia" => $packageSelected["amount"]
                    )
                )
            );

            sendEmail($userInfo["email"], "Xác nhận gia hạn VPS", $confirmEmail);
            createNewHoaDon($idTask."gia_han", $userInfo["email"], json_encode(
                array(
                    "Gia hạn VPS có id" => $id_vps,
                    "Gói cước" => $billingCycle,
                    "Giá" => $packageSelected["amount"],
                )
            ));
            addLog($userInfo["email"], "Gia hạn vps - ID: " . $id_vps, "renew_vps");
            die (json_encode(array(
                "error" => 0,
                "message" => "Đã tạo task gia hạn vps",
            ), JSON_PRETTY_PRINT));
        } else {
            die(json_encode(array(
                "error" => 1,
                "message" => "Số dư không đủ",
            ), JSON_PRETTY_PRINT));
        }
    }
}
