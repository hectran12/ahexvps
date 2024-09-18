<?php
// CREATE TABLE agency_data (
//     name VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
//     data TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
// );

include_once('../config.php');
if($pass_cron != $_GET["key"]) {
    die('cron key not found');
}
include_once('../sql/conn.php');
$conn = new db();
include_once('../auth/utils.php');

$total_invoice_progress = 0;
$history_mbbank = get_history_mbbank();
if($history_mbbank["success"] == 1) {
    $data = $history_mbbank["data"];
    foreach ($data as $item) {
        $description = $item["description"];
        if(strpos($description, "AHEXVPS")) {
            if(strpos($description, 'NAPTIEN')) {
                $username = explode("AHEXVPS", $description)[1];
                $username = explode("NAPTIEN", $username)[0];
                $pos = $item["pos"];
                $creditAmount = $item["creditAmount"];
                if ($creditAmount >= $min_payment) {
                    if(findBankHistory($pos) == false) {
                        $dataUser = findEmailByUsername($username);
                        if($dataUser) {
                            $email  = $dataUser["email"];
                            addNewBankHistory($email, $pos);
                            addMoney($email, $creditAmount);
                            addBankInvoice($email, $creditAmount, "MBBANK", "Nạp tiền từ MBBank");
                            $total_invoice_progress++;
                        }
                    }
                }

            }
        }

    }
    die('cron mbbank success: ' . $total_invoice_progress . ' invoices');
} else {
    die('cron mbbank error: history_mbbank not found');
}
function get_history_mbbank () {
    global $mbbank_cron_url;
    return json_decode(file_get_contents($mbbank_cron_url), true);
}

?>