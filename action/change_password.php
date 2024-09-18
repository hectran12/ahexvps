<?php
    // Turn off error reporting
    error_reporting(0);

    // thêm các file cần thiết
    include_once('../security/utils.php');    
    include_once('../sql/conn.php');
    include_once('../auth/utils.php');
    include_once('../helper/time.php');
    include_once('../security/utils.php');


    // kiểm tra xem có đủ điều kiện để thực hiện request không
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db();
        include_once('../auth/user.php');


        // kiểm tra xem có đủ điều kiện để thực hiện request không (limit request)
        $check_rq = acceptRequestTime($userInfo, $cooldownChangePassword, "change_password");
        if ($check_rq == false) {
            die('
                <script>
                    alert("Thay đổi mật khẩu quá nhanh, vui lòng thử lại sau!");
                    window.location = "../view/profile";
                </script>   
            ');
        }

        // kiểm tra xem request có phải là post không
        $password = $_POST["password"];
        if (empty($password)) {
            die('
                <script>
                    alert("Thay đổi mật khẩu thất bại! [1]");
                    window.location = "../view/profile";
                </script>   
            ');
        }

        // check length and injection
        if (strlen($password) <= 6) {
            die('
                <script>
                    alert("Mật khẩu phải lớn hơn 6 kí tự!");
                    window.location = "../view/profile";
                </script>   
            ');
        }

        // check xem có khoảng trắng không
        if (strpos($password, " ") !== false) {
            die('
                <script>
                    alert("Mật khẩu không được chứa khoảng trắng!");
                    window.location = "../view/profile";
                </script>   
            ');
        }


        changePassword($userInfo["email"], $password);
        editVerify($userInfo["email"], 0);
        updateTimeRequestServer($userInfo, "change_password");
        die('
            <script>
                alert("Thay đổi mật khẩu thành công!");
                window.location = "../view/profile";
            </script>
        ');


    }

?>