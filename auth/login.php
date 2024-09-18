<?php

include_once('../security/utils.php');
include_once('../sql/conn.php');
include_once('utils.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new db();
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // check empty
    if(empty($email) || empty($password)) {
        die('
            <script>
                alert("Vui lòng nhập đầy đủ thông tin");
                window.location.href = "/auth/sign-in";
            </script>
        ');
    }

    // check injection
    if(checkInjection($password) == false) {
        die('
            <script>
                alert("Có lỗi xảy ra, vui lòng thử lại sau");
                window.location.href = "/auth/sign-in";
            </script>
        ');
    }



    // check vaild email
    $emailFilter = filter_var($email, FILTER_VALIDATE_EMAIL);
    if($emailFilter == false) {
        die('
            <script>
                alert("Email không hợp lệ");
                window.location.href = "/auth/sign-in";
            </script>
        ');
    }
    // check vaiid email
    if(checkVaildEmail($email)) {
        die('
            <script>
                alert("Email không tồn tại");
                window.location.href = "/auth/sign-in";
            </script>
        ');
    }

    $genToken = login($email, $password, false);
    if($genToken == false) {
        die('
            <script>
                alert("Đăng nhập thất bại, vui lòng thử lại sau");
                window.location.href = "/auth/sign-in";
            </script> 
        ');
    } else {
        setcookie('token', $genToken, time() + 3600, '/');
        header('Location: /');
        die();
    }
}

?>