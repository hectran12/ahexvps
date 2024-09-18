<?php


    include_once('../security/utils.php');    
    include_once('../sql/conn.php');
    include_once('utils.php');
    $conn = new db();

 
    // check coookie
    $token = $_COOKIE['token'] ?? null;
    if($token == null) {
        header('Location: /auth/sign-in');
        die();
    }



    $userInfo = getUserInfo($token);

    if($userInfo == false) {
        header('Location: /auth/logout.php');
        die();
    }


    if($userInfo["isVerify"] == false) {
        if($notDirectVerify == false) {
            header('Location: /auth/verify.php');
            die();
        }
        
    }


?>