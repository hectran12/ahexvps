<?php
include_once('../config.php');
include_once('../security/utils.php');
include_once('../sql/conn.php');
include_once('utils.php');
include_once('isLogin.php');
include_once('../helper/string.php');
require_once 'vendor/autoload.php';

$clientGoogle = new Google_Client();
$clientGoogle->setClientId($client_id_google);
$clientGoogle->setClientSecret($client_secret_google);
$clientGoogle->setRedirectUri($redirectUri_google);
$clientGoogle->addScope("email");
$clientGoogle->addScope("profile");


if(isset($_GET["code"])) {
    
    $token = $clientGoogle->fetchAccessTokenWithAuthCode($_GET["code"]);
    // check if error to return header location
    if (array_key_exists('error', $token)) {
        header('Location: /page/404-error.php');
        die();
    }   
    $clientGoogle->setAccessToken($token);
    
    $google_oauth = new Google_Service_Oauth2($clientGoogle);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;

    if(strpos($email, '@gmail.com') == false) {
        die('
            <script>
                alert("Xin lỗi hiện tại chúng tôi không chấp nhận email này, vui lòng sử dụng gmail.com");
                window.location.href = "/auth/sign-up";
            </script>

        ');
    }
    $conn = new db();
    if(checkVaildEmail($email)) {
        $new_name = randomName();
        register($new_name, '', $email, true);
        $genToken = login($email, '', true);
        if($genToken == false) {
            die('
                <script>
                    alert("Đăng nhập thất bại, vui lòng thử lại sau");
                    window.location.href = "/auth/sign-up";
                </script>
            ');
        } else {
            setcookie('token', $genToken, time() + 3600, '/');
            header('Location: /');
            die();
        }
    } else {
        $genToken = login($email, '', true);
        if($genToken == false) {
            die('
                <script>
                    alert("Đăng nhập thất bại, vui lòng thử lại sau");
                    window.location.href = "/auth/sign-up";
                </script>
            ');
        } else {
            setcookie('token', $genToken, time() + 3600, '/');
            header('Location: /');
            die();
        }
    }
} else {
    $authUrl = $clientGoogle->createAuthUrl();
    header('Location: ' . $authUrl);
}
?>