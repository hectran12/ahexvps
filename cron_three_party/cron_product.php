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

$token_agency = $conn->query("SELECT * FROM agency_data WHERE name = 'agency_token'")->fetch_assoc();
if ($token_agency) {
    $cloudhub = new cloudhub($apiUsername, $apiApp, $apiSecret, $token_agency['data'], $proxy_address);
    $products = $cloudhub->getProduct();
    $os = $cloudhub->getListOS();
    if($products) {
        $products = $products["products"];
        $data = json_encode($products);
       
        // check value
        $sql = "SELECT * FROM agency_data WHERE name = 'products'";
        $conn->query($sql);
        if ($conn->numRows() == 0) {
            $sql = "INSERT INTO agency_data (name, data) VALUES ('products', '" . $data . "')";
            $conn->query($sql);
        } else {
            $sql = "UPDATE agency_data SET data = '" . $data . "' WHERE name = 'products'";
            $conn->query($sql);
        }
        // save data to file
        $myfile = fopen("../data/products.json", "w+") or die("Unable to open file!");
        fwrite($myfile, progressDataProduct($products));
        fclose($myfile);
        
    }

    if($os) {
        $os = $os["os-vps"];
        $data = json_encode($os);
        // check value
        $sql = "SELECT * FROM agency_data WHERE name = 'os'";
        $conn->query($sql);
        if ($conn->numRows() == 0) {
            $sql = "INSERT INTO agency_data (name, data) VALUES ('os', '" . $data . "')";
            $conn->query($sql);
        } else {
            $sql = "UPDATE agency_data SET data = '" . $data . "' WHERE name = 'os'";
            $conn->query($sql);
        }
        // save data to file
        $myfile = fopen("../data/os.json", "w+") or die("Unable to open file!");
        fwrite($myfile, json_encode($os));
        fclose($myfile);
    }


    die('cron product success');
} else {
    die('cron product error: token agency not found');
}




function progressDataProduct ($data) {
    global $anChenhGia;
    foreach ($data['vps'] as &$vps) {
        foreach ($vps['product'] as &$product) {
            foreach ($product['pricing'] as &$pricing) {
                if ($pricing['amount'] !== 0) {
                    $pricing['amount'] += $anChenhGia;
                }
            }
        }
    }
    foreach ($data["addon_vps"] as &$addon_vps) {
        foreach ($addon_vps['product'] as &$product) {
            foreach ($product['pricing'] as &$pricing) {
                if ($pricing['amount'] !== 0) {
                    $pricing['amount'] += $anChenhGia;
                }
            }
        }
    }

    return json_encode($data);
}

?>