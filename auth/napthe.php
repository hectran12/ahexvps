<?php
// CREATE TABLE `cards` (
//     `id` int(11) NOT NULL AUTO_INCREMENT,
//     `user_id` TEXT,
//     `trans_id` varchar(64) DEFAULT NULL,
//     `telco` varchar(255) DEFAULT NULL,
//     `amount` int(11) NOT NULL DEFAULT 0,
//     `price` int(11) NOT NULL DEFAULT 0,
//     `serial` text DEFAULT NULL,
//     `pin` text DEFAULT NULL,
//     `status` int(11) NOT NULL DEFAULT 0,
//     `create_date` datetime NOT NULL,
//     `update_date` datetime NOT NULL,
//     `reason` text DEFAULT NULL,
//     PRIMARY KEY (`id`)
//   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
  


function addNewCard (
    $user_email,
    $trans_id,
    $telco,
    $amount,
    $price,
    $serial,
    $pin,
    $status,
    $create_date,
    $update_date,
    $reason
) {
    global $conn;
    $sql = "INSERT INTO cards (user_id, trans_id, telco, amount, price, serial, pin, status, create_date, update_date, reason) VALUES ('$user_email', '$trans_id', '$telco', $amount, $price, '$serial', '$pin', $status, '$create_date', '$update_date', '$reason')";
    $conn->query($sql);
}

function getFullCardByEmail ($email) {
    global $conn;
    $sql = "SELECT * FROM cards WHERE user_id = '$email'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return $conn->fetchAll();
    }
    return false;
}

function updateCardByTransId($trans_id, $status, $price, $update_date) {
    global $conn;
    $sql = "UPDATE cards SET status = $status, price = $price, update_date = '$update_date' WHERE trans_id = '$trans_id'";
    $conn->query($sql);
}

function findCardByTransId ($trans_id) {
    global $conn;
    $sql = "SELECT * FROM cards WHERE trans_id = '$trans_id'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return $conn->fetchArray();
    }
    return false;
}


?>