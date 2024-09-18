<?php

    include_once ('../security/utils.php');

    $uri = checkXSSInURI();
    if ($uri == false) {
        die('
            <script>
            alert("Không thể xử lý yêu cầu!");
            window.location.href = "../page/404-error.php";
            </script>
            
        ');
    }


    $filePath = explode('/', $uri);
    if (count($filePath) == 0) {
        die('
            <script>
            alert("Không thể xử lý yêu cầu!");
            window.location.href = "../page/404-error.php";
            </script>
            
        ');
    }
    $filePath = $filePath[count($filePath) - 1];
    if(strpos($filePath, '?') !== false) {
        $filePath = explode('?', $filePath)[0];
    }

    $whiteListPage = ['profile'];

    if (!in_array($filePath, $whiteListPage)) {
        die('
            <script>
            alert("Không thể xử lý yêu cầu!");
            window.location.href = "../page/404-error.php";
            </script>
            
        ');
    }

    include_once($filePath . '.php');



?>