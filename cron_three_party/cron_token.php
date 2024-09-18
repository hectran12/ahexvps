<?php

// CREATE TABLE agency_data (
//     name VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
//     data TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
// );


include_once('../sql/conn.php');
if($pass_cron != $_GET["key"]) {
    die('cron key not found');
}
include_once('../utils_system/cloudhub.php');
$conn = new db();
$cloudhub = new cloudhub($apiUsername, $apiApp, $apiSecret, '',$proxy_address);
$tokenAgency = $cloudhub->getToken();

if ($tokenAgency) {
    // check token is not in db
    $sql = "SELECT * FROM agency_data WHERE name = 'agency_token'";
    $conn->query($sql);
    if ($conn->numRows() == 0) {
        $sql = "INSERT INTO agency_data (name, data) VALUES ('agency_token', '" . $tokenAgency . "')";
        $conn->query($sql);
    } else {
        $sql = "UPDATE agency_data SET data = '" . $tokenAgency . "' WHERE name = 'agency_token'";
        $conn->query($sql);
    }

    echo "Token: " . $tokenAgency;

} else {
    echo "Error: Can't get token from cloudhub";
}

?>