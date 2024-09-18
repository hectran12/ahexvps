<?php

// CREATE TABLE user (
//     id INT PRIMARY KEY AUTO_INCREMENT,
//     base64_avt TEXT,
//     username TEXT NOT NULL,
//     password TEXT NOT NULL,
//     email TEXT NOT NULL,
//     money INT DEFAULT 0,
//     request_time DATETIME DEFAULT CURRENT_TIMESTAMP,
//     isband BOOLEAN DEFAULT FALSE,
//     isVerify BOOLEAN DEFAULT FALSE
//      ip TEXT;

        // isGmailLogin BOOLEAN DEFAULT FALSE,
        // token TEXT;
        // timeRequestServer TEXT;
        // useragent TEXT DEFAULT NULL;
        // address TEXT DEFAULT NULL;
        // total_money INT DEFAULT 0;


// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


// CREATE TABLE logs (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     user_email TEXT,
//     info_log TEXT,
//     cat_log TEXT
// ) CHARACTER SET utf8 COLLATE utf8_unicode_ci;


// CREATE TABLE bank_invoice (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     user_email TEXT,
//     amount INT,
//     type TEXT,
//     info TEXT,
//     dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


// CREATE TABLE bank_history (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     user_email TEXT,
//     id_pos TEXT,
//     dateCreated DATE DEFAULT CURRENT_DATE
// );




// CREATE TABLE history_trucongtien (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     user_email TEXT,
//     amount INT DEFAULT 0,
//     reason TEXT,
//     isAdd BOOLEAN DEFAULT 0
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


function addNewHistoryTruCongTien($user_email, $amount, $reason, $isAdd) {
    global $conn;

    $sql = "INSERT INTO history_trucongtien (user_email, amount, reason, isAdd) VALUES ('$user_email', $amount, '$reason', $isAdd)";
    $conn->query($sql);
}


function getAllHistoryTruCongTienByUserEmail($user_email) {
    global $conn;
    $sql = "SELECT * FROM history_trucongtien WHERE user_email = '$user_email'";
    $conn->query($sql);
    return $conn->fetchAll();
}


function addNewBankHistory ($email, $id_pos) {
    global $conn;
    $sql = "INSERT INTO bank_history (user_email, id_pos) VALUES ('$email', '$id_pos')";
    $conn->query($sql);
}

function findBankHistory ($id_pos) {
    global $conn;
    $sql = "SELECT * FROM bank_history WHERE id_pos = '$id_pos'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return $conn->fetchArray();
    }
    return false;
}

function getBankInvoiceByEmail ($email) {
    global $conn;
    $sql = "SELECT * FROM bank_invoice WHERE user_email = '$email'";
    $conn->query($sql);
    return $conn->fetchAll();
}   

function addBankInvoice ($email, $amount, $type, $info) {
    global $conn;
    $sql = "INSERT INTO bank_invoice (user_email, amount, type, info) VALUES ('$email', $amount, '$type', '$info')";
    $conn->query($sql);
}

function tru_tien_user ($email, $amount, $reason) {
    global $conn;
    $sql = "UPDATE user SET money = money - $amount WHERE email = '$email'";
    $conn->query($sql);
    addLog($email, $reason, "tru_tien");
    addNewHistoryTruCongTien($email, $amount, $reason, 0);
}

function findEmailByUsername ($username) {
    global $conn;
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return $conn->fetchArray();
    }
    return false;
}

function limitAccPerIp ($ip, $max) {
    global $conn;
    $sql = "SELECT * FROM user WHERE ip = '$ip'";
    $conn->query($sql);
    if ($conn->numRows() >= $max) {
        return true;
    }
    return false;

}
function addMoney ($email, $amount) {
    global $conn;
    $sql = "UPDATE user SET money = money + $amount WHERE email = '$email'";
    $conn->query($sql);
    $sql_2 = "UPDATE user SET total_money = total_money + $amount WHERE email = '$email'";
    $conn->query($sql_2);
    addLog($email, "Nạp tiền", "add_money");
    addNewHistoryTruCongTien($email, $amount, "Nạp tiền", 1);
}

function addLog ($email, $info, $cat) {
    global $conn;
    if(getCountLogsByEmail($email) > 1000) {
        $sql = "DELETE FROM logs WHERE user_email = '$email'";
        $conn->query($sql);
    }
    $sql = "INSERT INTO logs (user_email, info_log, cat_log) VALUES ('$email', '$info', '$cat')";
    $conn->query($sql);
}

function getCountLogsByEmail ($email) {
    global $conn;
    $sql = "SELECT * FROM logs WHERE user_email = '$email'";
    $conn->query($sql);
    return $conn->numRows();
}

function getLogsByEmail ($email) {
    global $conn;
    $sql = "SELECT * FROM logs WHERE user_email = '$email'";
    $conn->query($sql);
    return $conn->fetchAll();
}

function changePassword ($email, $password) {
    global $conn;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE user SET password = '$hash' WHERE email = '$email'";
    $conn->query($sql);
    addLog($email, "Thay đổi mật khẩu", "doimk");
}

function checkVaildEmail ($email) {
    global $conn;
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return false;
    }
    return true;
}



function checkVaildUsername ($username) {
    global $conn;
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return false;
    }
    return true;
}


function checkExistToken ($token) {
    global $conn;
    $sql = "SELECT * FROM user WHERE token = '$token'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return true;
    }
    return false;
}

function register ($username, $password, $email, $isGoogle = false) {
    $ip = $_SERVER['REMOTE_ADDR'];
    global $conn;

    if(limitAccPerIp($ip, 5)) {
        return false;
    }

    
    if ($isGoogle == false) {
        $sql = "INSERT INTO user (username, password, email, ip) VALUES ('$username', '$password', '$email', '$ip')";
        if ($conn->query($sql) === TRUE) {
            addLog($email, "Đăng ký", "register");
    
            return true;
        }
        return false;
    } else {
        $sql = "INSERT INTO user (username, email, ip, isGmailLogin) VALUES ('$username', '$email', '$ip', TRUE)";
        if ($conn->query($sql) === TRUE) {
            addLog($email, "Đăng ký bằng google", "register");
            return true;
        }
        return false;
    }
   
}


function editVerify ($email, $status=0) {
    global $conn;
    $sql = "UPDATE user SET isVerify = $status WHERE email = '$email'";
    $conn->query($sql);
}

function gen_token ($email) {
    return md5($email . time());
}

function updateTime ($email) {
    global $conn;
    $sql = "UPDATE user SET request_time = CURRENT_TIMESTAMP WHERE email = '$email'";
    $conn->query($sql);
}

function updateTimeRequestServer ($userInfo, $name_service) {
    global $conn;
    $email = $userInfo["email"];
    $timeService = $userInfo["timeRequestServer"];

    if($timeService == null) {
        $data = array(
            $name_service => time()
        );
        $data = json_encode($data);
        $sql = "UPDATE user SET timeRequestServer = '$data' WHERE email = '$email'";
    } else {
        $timeService = json_decode($timeService, true);
        $timeService[$name_service] = time();
        $timeService = json_encode($timeService);
        $sql = "UPDATE user SET timeRequestServer = '$timeService' WHERE email = '$email'";
    }
    $conn->query($sql);

}

function login ($email, $password, $isGoogle = false) {
    global $conn;
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        $row = $conn->fetchArray();
        if($isGoogle == false) {
            if(password_verify($password, $row['password'])) {
                $genToken = gen_token($email);
                $userAgentLogin = $_SERVER['HTTP_USER_AGENT'];
                if (checkInjectionUseragent()) {
                    return false;
                }
                $sql = "UPDATE user SET token = '$genToken', useragent = '$userAgentLogin' WHERE email = '$email'";
                $conn->query($sql);
                updateTime($email);
                addLog($email, "Đăng nhập", "login");
                return $genToken;
            } else {
                return false;
            }
        } else {
            $genToken = gen_token($email);
            $userAgentLogin = $_SERVER['HTTP_USER_AGENT'];
            if (checkInjectionUseragent()) {
                return false;
            }
            $sql = "UPDATE user SET token = '$genToken', useragent = '$userAgentLogin' WHERE email = '$email'";
            $conn->query($sql);
            addLog($email, "Đăng nhập bằng google", "login");
            return $genToken;
        }
    }
    return false;
}

function editProfile ($email, $username, $phoneNumber, $address) {
    // not change email
    global $conn;
    $sql = "UPDATE user SET username = '$username', phoneNumber = '$phoneNumber', address = '$address' WHERE email = '$email'";
    $conn->query($sql);
    addLog($email, "Thay đổi thông tin", "edit_profile");
}
function checkInjectionUseragent () {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($userAgent, "'") !== false || strpos($userAgent, '"') !== false) {
        return true;
    }
    return false;
}

function deleteToken ($token) {
    global $conn;
    $sql = "UPDATE user SET token = NULL WHERE token = '$token'";
    $conn->query($sql);
}

function getUserInfo ($token) {
    global $conn;
    $sql = "SELECT * FROM user WHERE token = '$token'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return $conn->fetchArray();
    }
    return false;
}

function getInfoByEmail ($email) {
    global $conn;
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return $conn->fetchArray();
    }
    return false;
}


function changeAvt ($email, $base64) {
    global $conn;
    $sql = "UPDATE user SET base64_avt = '$base64' WHERE email = '$email'";
    $conn->query($sql);
    addLog($email, "Thay đổi avatar", "change_avatar");
}
?>