<?php



include_once('../sql/conn.php');
if($pass_cron != $_GET["key"]) {
    die('cron key not found');
}
include_once('../auth/utils.php');
include_once('../auth/vps_vietnam.php');
include_once('../utils_system/cloudhub.php');
include_once('../helper/mail.php');
include_once('../helper/vps_vietnam.php');


include_once('../email/utils.php');
$conn = new db();



$allOrders = getAllOrderVPS();
$allOrdersHasIDVPS = [];
foreach ($allOrders as $order) {
    $idVPS = $order["id_vps"];
    if($idVPS != null && $idVPS != "" && $idVPS != 0) {
        array_push($allOrdersHasIDVPS, $idVPS);
    }
}


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


$allOrdersHasIDVPS = loc_trung($allOrdersHasIDVPS);
$sliceData = silceData($allOrdersHasIDVPS, 100);

$token_agency = $conn->query("SELECT * FROM agency_data WHERE name = 'agency_token'")->fetch_assoc();

if($token_agency) {
    $cloudhub = new cloudhub($apiUsername, $apiApp, $apiSecret, $token_agency['data'], $proxy_address);
   
    
    


} else {
    die('cron error: token agency not found');
}



function silceData ($array, $element_count) {
    $countElement = count($array);
    $countSlice = round($countElement / $element_count)+1;
    $result = [];
    for ($i = 0; $i < $countSlice; $i++) {
        $start = $i * $element_count;
        $end = $start + $element_count;
        $slice = array_slice($array, $start, $end);
        array_push($result, $slice);
    }
    return $result;
}

function loc_trung ($array) {
    $array = array_unique($array);
    $array = array_values($array);
    return $array;
}   

?>