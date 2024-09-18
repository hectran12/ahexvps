<?php



function getRole ($userInfo, $adminEmail) {
    $email = $userInfo["email"];

    if($email == $adminEmail) {
        return "Admin";
    } else {
        if($userInfo["iscoWorker"] == 0) {
            return "User";
        } else {
            return "coWorker";
        }
    }
}


?>