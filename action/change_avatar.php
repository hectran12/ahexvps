<?php
    error_reporting(0);
    // thêm các file cần thiết
    include_once('../security/utils.php');    
    include_once('../sql/conn.php');
    include_once('../auth/utils.php');
    include_once('../helper/imgbb.php');
    include_once('../helper/time.php');
    

    $conn = new db();
    $imgbb = new ImgbbApi('0effb03c2238bb2f2d9c175a8535c78a');



    // kiểm tra xem có đủ điều kiện để thực hiện request không
    include_once('../auth/user.php');
    $check_rq = acceptRequestTime($userInfo, $cooldownUploadAvatar, "change_avatar");
    if ($check_rq == false) {
        die('
            <script>
                alert("Đổi avatar quá nhanh, vui lòng thử lại sau!");
                window.location = "../view/profile";
            </script>   
        ');
    }
    $lastUri = $_SERVER['HTTP_REFERER'];
    // kiểm tra xem request có phải là post không
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        

        // kiểm tra xem có dữ liệu base64 không
        $imgBs64 = $_POST["base64Img"];
        if ($imgBs64 == null) {
            die('
                <script>
                    alert("Đổi avatar thất bại!");
                    window.location = "'.$lastUri.'";
                </script>   
            ');
        }


        // upload ảnh lên imgbb
        $imgUrl = $imgbb->uploadImage(explode(',', $imgBs64)[1]);


        // kiểm tra xem upload ảnh lên imgbb có thành công không
        if ($imgUrl == false) {
            die('
                <script>
                    alert("Đổi avatar thất bại!");
                    window.location = "'.$lastUri.'";
                </script>   
            ');
        }

        // thay đổi avatar
        changeAvt($userInfo["email"], $imgUrl);
        updateTimeRequestServer($userInfo, "change_avatar");
        die('
            <script>
                alert("Đổi avatar thành công, có thể mất một lúc lâu để tải lên server imgbb!");
                window.location = "'.$lastUri.'";
            </script>
        ');
    } else {
        // nếu không phải là post thì thông báo lỗi
        die('
            <script>
                alert("Đổi avatar thất bại!");
                window.location = "'.$lastUri.'";
            </script>   
        ');
    }


?>