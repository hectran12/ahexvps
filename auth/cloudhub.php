<?php


include_once('../utils_system/cloudhub.php');
$token_agency = $conn->query("SELECT * FROM agency_data WHERE name = 'agency_token'")->fetch_assoc();
if ($token_agency) {
    // conn
    $cloudhub = new cloudhub($apiUsername, $apiApp, $apiSecret, $token_agency['data'], $proxy_address);
} else {
    die('Không thể truy vấn, vì hệ thống có lỗi!');
}