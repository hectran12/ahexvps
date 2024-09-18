<?php
    error_reporting(0);
    include_once('../security/utils.php');    
    include_once('../sql/conn.php');
    include_once('../auth/utils.php');
    include_once('../helper/time.php');
    include_once('../security/utils.php');


    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db();
        include_once('../auth/user.php');
        include_once('../auth/vps_vietnam.php');
        $vpsId = isset($_POST["vps_id"]) ? $_POST["vps_id"] : null;

        if ($vpsId == null) {
            die(json_encode(
                array(
                    "error" => 1,
                    "message" => "Không thể xử lý yêu cầu!"
                )     ,
                 JSON_PRETTY_PRINT));
        }


        $vpsInfo = getInfoVPSByVPS_ID($vpsId);
        if($vpsInfo == false) {
            die(json_encode(
                array(
                    "error" => 1,
                    "message" => "Không thể xử lý yêu cầu!"
                )     ,
                 JSON_PRETTY_PRINT));
        }
        if($vpsInfo["user_email"] !== $userInfo["email"]) {
            die(json_encode(
                array(
                    "error" => 1,
                    "message" => "Không thể xử lý yêu cầu!"
                )     ,
                 JSON_PRETTY_PRINT));
        }
        $lastUri = $_SERVER['HTTP_REFERER'];
        deleteVPSByVPS_ID($vpsId);
        die(json_encode(
            array(
                "error" => 0,
                "message" => "Xóa VPS thành công!"
            )     ,
             JSON_PRETTY_PRINT));
        
        
    } else {
        die(json_encode(
            array(
                "error" => 1,
                "message" => "Không thể xử lý yêu cầu!"
            )     ,
             JSON_PRETTY_PRINT));
    }
    



?>