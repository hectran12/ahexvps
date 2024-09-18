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

    $id_vps = isset($_POST['id_vps']) ? $_POST['id_vps'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    if($id_vps == null || $status == null) {
        die ( json_encode(array(
            "error" => 1,
            "message" => "Thiếu dữ liệu"
        )));
    }

    $conn = new db();
    include_once('../auth/user.php');

    $rq_check = acceptRequestTime($userInfo, $cooldownCronVPSStatus, "auto_renew_vps_vn");
    if($rq_check == false) {
        die('Thao tác chậm lại');
    }

    if(is_numeric($id_vps) == false) {
        die ( json_encode(array(
            "error" => 1,
            "message" => "ID không hợp lệ"
        )));
    }

    if($status != "on" && $status != "off") {
        die ( json_encode(array(
            "error" => 1,
            "message" => "Trạng thái không hợp lệ"
        )));
    }

    if($status == "on") $status = 1;
    if($status == "off") $status = 0;
    

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


    editAutoRenew($id_vps, $status);
    die ( json_encode(array(
        "error" => 0,
        "message" => "Cập nhật thành công"
    )));
    updateTimeRequestServer($userInfo, "auto_renew_vps_vn");


    