<?php


    include_once('../security/utils.php');    
    include_once('../sql/conn.php');
    include_once('utils.php');
    $conn = new db();

    
    include_once('isLogin.php');
    
    
    $path = checkXSSInURI();
    if($path == false) {
        header('Location: /page/404-error.php');
        die();
    }

    $path = explode('/', $path);
    $path = $path[count($path) - 1];
    if(strpos($path, '?') !== false) {
        $path = explode('?', $path)[0];
    }


    if($path == 'sign-in') {
        include_once('sign_in.php');
        die();
    } 
    if($path == 'sign-up') {
        include_once('sign_up.php');
        die();
    }


   
    header('Location: /page/404-error.php');
    die();



?>