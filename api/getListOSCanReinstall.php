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
    //$id_vps = 9322;
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

    $dataCheck = $cloudhub->actionVPS($id_vps, "check-os-when-rebuild-vps");
    if($dataCheck["error"] == 0) {
        updateTimeRequestServer($userInfo, "get_list_os_can_reinstall_vps_vn");
        die(json_encode(array(
            "error" => 0,
            "data" => $dataCheck["list-os"]
        ), JSON_PRETTY_PRINT));
    } else {
        updateTimeRequestServer($userInfo, "get_list_os_can_reinstall_vps_vn");
        die(json_encode(array(
            "error" => 1,
            "message" => "Lỗi không xác định"
        ), JSON_PRETTY_PRINT));
    }
    





?>