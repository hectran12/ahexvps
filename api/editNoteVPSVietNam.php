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
    $note = isset($_POST['note']) ? $_POST['note'] : null;

    if($id_vps == null || $note == null) {
        die ( json_encode(array(
            "error" => 1,
            "message" => "Thiếu dữ liệu"
        )));
    }

    $conn = new db();
    include_once('../auth/user.php');


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

    // edit note
    editNote($id_vps, $note);
    die ( json_encode(array(
        "error" => 0,
        "message" => "Sửa ghi chú thành công"
    ), JSON_PRETTY_PRINT) );
