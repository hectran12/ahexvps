<?php

    // file này cần: connect db, utils.php, security/utils.php
    $getTokenInCookie = $_COOKIE['token'] ?? null;
    if (empty($getTokenInCookie) == false) {

        if (checkInjection($getTokenInCookie) == false) {
            header('Location: ../page/404-error.php');
            die();
        }
        if (checkExistToken($getTokenInCookie)) {
            $userInfo = getUserInfo($getTokenInCookie);
            // check verify account
            if($userInfo["isVerify"] == false) {
                header('Location: ../auth/verify.php');
                die();
            }
            header('Location: ../home');
            die();
        }
    } 


?>