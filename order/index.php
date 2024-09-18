<?php

    include_once ('../security/utils.php');

    $type = isset($_GET['type']) ? $_GET['type'] : null;
    if($type == null) {
        die('
            <script>
            alert("Không thể xử lý yêu cầu!");
            window.location.href = "../page/404-error.php";
            </script>
            
        ');
    }

    $whiteListPage = ["hoa_don", "nhat_ky_tiente"];
    if (!in_array($type, $whiteListPage)) {
        die('
            <script>
            alert("Không thể xử lý yêu cầu!");
            window.location.href = "../page/404-error.php";
            </script>
            
        ');
    }

    include_once($type . '.php');


?>