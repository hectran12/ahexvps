<?php
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
        $check_rq = acceptRequestTime($userInfo, $cooldownChangeProfileInfo, "change_profile");
        if ($check_rq == false) {
            die('
                <script>
                    alert("Thay đổi thông tin quá nhanh, vui lòng thử lại sau!");
                    window.location = "../view/profile";
                </script>   
            ');
        }


        // kiểm tra xem request có phải là post không
        $lastUri = $_SERVER['HTTP_REFERER'];
        $username = $_POST["username"];
        $phoneNumber = $_POST["phoneNumber"];
        $address = $_POST["address"];
        
        // check empty
        if(empty($username) || empty($phoneNumber) || empty($address)) {
            die('
                <script>
                    alert("Thay đổi thông tin thất bại! [1]");
                    window.location = "'.$lastUri.'";
                </script>   
            ');
        }

        // check injection
        if(is_numeric($phoneNumber) == false) {
            die('
                <script>
                    alert("Số điện thoại phải là số!");
                    window.location = "'.$lastUri.'";
                </script>   
            ');
        }

        // check length
        if(strlen($username) <= 3 && strlen($phoneNumber) <= 9 || strlen($address) <= 10) {
            die('
                <script>
                    alert("Username phải lớn hơn 3 kí tự, số điện thoại phải lớn hơn 9 kí tự, địa chỉ phải lớn hơn 10 kí tự");
                    window.location = "'.$lastUri.'";
                </script>   
            ');
        }

        if(strpos($username, " ") !== false) {
            die('
                <script>
                    alert("Username không được chứa khoảng trắng!");
                    window.location = "'.$lastUri.'";
                </script>   
            ');
        }

        if(checkVaildUsername($username) == false) {
            die('
                <script>
                    alert("Username bị trùng hoặc không hợp lệ");
                    window.location = "'.$lastUri.'";
                </script>   
            ');


        }

        editProfile($userInfo["email"], $username, $phoneNumber, $address);
        updateTimeRequestServer($userInfo, "change_profile");
        die('
            <script>
                alert("Thay đổi thông tin thành công!");
                window.location = "'.$lastUri.'";
            </script>
        ');
    } else {
        die('
            <script>
                alert("Thay đổi thông tin thất bại! [3]");
                window.location = "'.$lastUri.'";
            </script>   
        ');
    }
    



?>