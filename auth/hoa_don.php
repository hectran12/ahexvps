<?php


// CREATE TABLE hoa_don (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     partner_id TEXT,
//     user_email TEXT,
//     info TEXT,
//     status BOOLEAN DEFAULT 0,
//     dateCreated DATE DEFAULT CURRENT_TIMESTAMP
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


function createNewHoaDon ($partner_id, $user_email, $info) {
    global $conn;
    $info = base64_encode($info);
    $sql = "INSERT INTO hoa_don (
        partner_id,
        user_email,
        info
    ) VALUES (
        '$partner_id',
        '$user_email',
        '$info'
    )";
    $conn->query($sql);
    return $conn->insert_id();
}


function getAllHoaDonByUserEmail ($user_email) {
    global $conn;
    $sql = "SELECT * FROM hoa_don WHERE user_email = '$user_email'";
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}



function getInfoHoaDonByPartnerId ($partner_id) {
    global $conn;
    $sql = "SELECT * FROM hoa_don WHERE partner_id = '$partner_id'";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

function updateStatusHoaDonByPartnerId ($partner_id, $status) {
    global $conn;
    $sql = "UPDATE hoa_don SET status = $status WHERE partner_id = '$partner_id'";
    $conn->query($sql);
}


?>