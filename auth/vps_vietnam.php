<?php

// CREATE TABLE order_vps_vietnam (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     user_email TEXT,
//     cpu INT,
//     ram INT,
//     disk INT,
//     product_id INT,
//     billing_cycle TEXT,
//     quantity INT,
//     id_vps TEXT,
//     os_id INT,
//     date_create TEXT,
//     next_due_date TEXT,
//     vps_status TEXT,
//     is_special TEXT,
//     ip TEXT,
//     username TEXT,
//     password TEXT,
//   note TEXT,
//     auto_renew TEXT,
//     pricing INT,
//     dateCreate_donhang DATE DEFAULT CURRENT_DATE
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



function addNewOrderVPSVietnam (
    $user_email,
    $cpu,
    $ram,
    $disk,
    $product_id,
    $billing_cycle,
    $quantity,
    $id_vps,
    $os_id,
    $date_create,
    $next_due_date,
    $vps_status,    
    $is_special,
    $ip,    
    $username,
    $password,
    $note,
    $auto_renew,
    $pricing
) {
    global $conn;
    $sql = "INSERT INTO order_vps_vietnam (
        user_email,
        cpu,
        ram,
        disk,
        product_id,
        billing_cycle,
        quantity,
        id_vps,
        os_id,
        date_create,
        next_due_date,
        vps_status,
        is_special,
        ip,
        username,
        password,
        note,
        auto_renew,
        pricing
    ) VALUES (
        '$user_email',
        '$cpu',
        '$ram',
        '$disk',
        '$product_id',
        '$billing_cycle',
        '$quantity',
        '$id_vps',
        '$os_id',
        '$date_create',
        '$next_due_date',
        '$vps_status',
        '$is_special',
        '$ip',
        '$username',
        '$password',
        '$note',
        '$auto_renew',
        '$pricing'
    )";
    $conn->query($sql);
    return $conn->insertId();

}

function getOrderVPSVNByUserEmail ($user_email) {
    global $conn;
    $sql = "SELECT * FROM order_vps_vietnam WHERE user_email = '$user_email'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return $conn->fetchAll();
    } else {
        return false;
    }
}


function deleteVPSByVPS_ID ($id_vps) {
    global $conn;
    $sql = "DELETE FROM order_vps_vietnam WHERE id_vps = '$id_vps'";
    $conn->query($sql);
}

function getInfoVPSByVPS_ID ($id_vps) {
    global $conn;
    $sql = "SELECT * FROM order_vps_vietnam WHERE id_vps = '$id_vps'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return $conn->fetch();
    } else {
        return false;
    }
}

function deleteOrderVPSVNById ($id) {
    global $conn;
    $sql = "DELETE FROM order_vps_vietnam WHERE id = '$id'";
    $conn->query($sql);
}


function getAllOrderVPS () {
    global $conn;
    $sql = "SELECT * FROM order_vps_vietnam";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return $conn->fetchAll();
    } else {
        return false;
    }
}

function getAllOrderVPSVietNam ($vps_status) {
    global $conn;
    $sql = "SELECT * FROM order_vps_vietnam WHERE vps_status = '$vps_status'";
    $conn->query($sql);
    if ($conn->numRows() > 0) {
        return $conn->fetchAll();
    } else {
        return false;
    }
}


function editOrderVPSVN (
    $id,
    $user_email,
    $cpu,
    $ram,
    $disk,
    $product_id,
    $billing_cycle,
    $quantity,
    $id_vps,
    $os_id,
    $date_create,
    $next_due_date,
    $vps_status,    
    $is_special,
    $ip,    
    $username,
    $password,
    $note,
    $auto_renew,
    $pricing
) {
    global $conn;
    $sql = "UPDATE order_vps_vietnam SET 
        user_email = '$user_email',
        cpu = '$cpu',
        ram = '$ram',
        disk = '$disk',
        product_id = '$product_id',
        billing_cycle = '$billing_cycle',
        quantity = '$quantity',
        id_vps = '$id_vps',
        os_id = '$os_id',
        date_create = '$date_create',
        next_due_date = '$next_due_date',
        vps_status = '$vps_status',
        is_special = '$is_special',
        ip = '$ip',
        username = '$username',
        password = '$password',
        note = '$note',
        auto_renew = '$auto_renew',
        pricing = '$pricing'
    WHERE id = '$id'";
    $conn->query($sql);

    
    

}


function editAutoRenew ($id_vps, $auto_renew) {
    global $conn;
    $sql = "UPDATE order_vps_vietnam SET auto_renew = '$auto_renew' WHERE id_vps = '$id_vps'";
    $conn->query($sql);
}

function editNote ($id_vps, $note) {
    global $conn;
    $sql = "UPDATE order_vps_vietnam SET note = '$note' WHERE id_vps = '$id_vps'";
    $conn->query($sql);

}
function editOSVPSVN ($vps_id, $os_id) {
    global $conn;
    $sql = "UPDATE order_vps_vietnam SET os_id = '$os_id' WHERE id_vps = '$vps_id'";
    $conn->query($sql);
}

function editStatusOrderVPSVN ($id, $vps_status) {
    global $conn;
    $sql = "UPDATE order_vps_vietnam SET vps_status = '$vps_status' WHERE id = '$id'";
    $conn->query($sql);
}


function editBillingCycle ($vps_id, $billing_cycle) {
    global $conn;
    $sql = "UPDATE order_vps_vietnam SET billing_cycle = '$billing_cycle' WHERE id_vps = '$vps_id'";
    $conn->query($sql);
}
?>