<?php
    include_once('../security/utils.php');
    include_once('../sql/conn.php');
    include_once('utils.php');
    $conn = new db();
    $getTokenInCookie = $_COOKIE['token'] ?? null;
    if (empty($getTokenInCookie) == false) {

        if (checkInjection($getTokenInCookie) == false) {
            header('Location: ../page/404-error.php');
            die();
        }
        if (checkExistToken($getTokenInCookie)) {
            $userInfo = getUserInfo($getTokenInCookie);
            if($userInfo == false) {
                // delete cookie
                setcookie('token', '', time() - 3600, '/');
                header('Location: /page/404-error.php');
                die();
            } else {
                deleteToken($getTokenInCookie);
                setcookie('token', '', time() - 3600, '/');
                header('Location: /');
                die();
            }
        }

        // delete cookie
        setcookie('token', '', time() - 3600, '/');
        header('Location: /page/404-error.php');
        die();
    }



?>