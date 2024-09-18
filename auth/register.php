<?php




if($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once('../sql/conn.php');
    include_once('utils.php');
    include_once('../security/utils.php');

    include_once('isLogin.php');
    
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    $_REQUEST = $data;
    

    if (empty($_REQUEST['username']) || empty($_REQUEST['password']) || empty($_REQUEST['email'])) {
        echo json_encode(array('error' => 'Vui lòng điền đầy đủ trường'));
        die();
    }


    if (strlen($_REQUEST['username']) < 6 || strlen($_REQUEST['username']) > 36) {
        echo json_encode(array('error' => 'Username phải từ 3 đến 36 ký tự'));
        die();
    }
    if (strlen($_REQUEST['password']) < 6 || strlen($_REQUEST['password']) > 36) {
        echo json_encode(array('error' => 'Mật khẩu phải từ 6 đến 36 ký tự'));
        die();
    }
    $emailFormat = filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL);
    if ($emailFormat == false) {
        echo json_encode(array('error' => 'Lỗi email format'));
        die();
    }

    if(checkInjection($_REQUEST['username']) == false || checkInjection($_REQUEST['password']) == false) {
        echo json_encode(array('error' => 'Username hoặc mật khẩu không được có ký tự đặt biệt!'));
        die();
    }

    if(strpos($_REQUEST['username'], " ") !== false || strpos($_REQUEST['password'], " ") !== false) {
        echo json_encode(array('error' => 'Không chấp nhận khoảng trắng'));
        die();
    }
    
    $conn = new db();
    $username = $conn->escape($_REQUEST['username']);
    $password = $conn->escape($_REQUEST['password']);
    $email = $conn->escape($_REQUEST['email']);
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    if(strpos($email, "@gmail.com") == false) {
        echo json_encode(array('error' => 'Chỉ chấp nhận @gmail.com!'));
        die();
    }

    if(checkVaildEmail($email) == false) {
        echo json_encode(array('error' => 'Email đã tồn tại'));
        die();
    }

    if(checkVaildUsername($username) == false) {
        echo json_encode(array('error' => 'Username đã tồn tại'));
        die();
    }




    if(register($username, $password, $email)) {
        echo json_encode(array('success' => 'Đăng ký thành công'));
        die();
    } else {
        echo json_encode(array('error' => 'Đăng ký thất bại'));
        die();
    }
    
}

?>