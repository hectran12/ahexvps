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
include_once('../auth/hoa_don.php');

$allOrders = getAllOrderVPSVietNam("request_create_order");
if($allOrders == false) {
    die('No order');
}
$firstOrder = $allOrders[0];
$idOrder = $firstOrder["id"]; // id đơn hàng
$price = $firstOrder["pricing"]; // số tiền đơn hàng
$userEmail = $firstOrder["user_email"]; // email người đặt đơn
$infoUser = getInfoByEmail($userEmail); // thông tin người đặt đơn
$auto_renew = $firstOrder["auto_renew"]; // auto renew




if ($infoUser["money"] < $price) {
    addLog($userEmail, "Không đủ tiền để thanh toán đơn hàng VPS Việt Nam - ID: ".$idOrder. "- Giá: ".$price, "cancel_order_vps_vn");
    editStatusOrderVPSVN($idOrder, "cancel_order");
    return;
}
// trừ tiền
tru_tien_user($userEmail, $price, "Thanh toán đơn hàng VPS Việt Nam - ID: ".$idOrder. "- Giá: ".$price);
editStatusOrderVPSVN($idOrder, "creating");


$cpu = $firstOrder["cpu"];
$ram = $firstOrder["ram"];
$disk = $firstOrder["disk"];
$product_id = $firstOrder["product_id"];
$billing_cycle = $firstOrder["billing_cycle"];
$quanlity = 1;
$os_id = $firstOrder["os_id"];
$note = $firstOrder["note"];


$token_agency = $conn->query("SELECT * FROM agency_data WHERE name = 'agency_token'")->fetch_assoc(); // token của agency
if($token_agency) {
    $cloudhub = new cloudhub($apiUsername, $apiApp, $apiSecret, $token_agency['data'], $proxy_address);

    // kiểm tra số dư trước khi tạo đơn
    $infoAgency = $cloudhub->getInfo();

    if($infoAgency["error"] != 0) {
        // hủy giao dịch
        addLog($userEmail, "Hệ thống đang có sự cố nên đơn hàng VPS bạn bị hủy", "cancel_order_error");
        editStatusOrderVPSVN($idOrder, "cancel_order_error");
        // hoàn tiền
        addMoney($userEmail, $price);
        return;
    } else {

        // check số dư
        $dataAgency = $infoAgency["data"];
        $creditAgency = $dataAgency["credit"];
        if ($creditAgency < $price) {
            // hủy giao dịch do tài nguyên bên hệ thống
            addLog($userEmail, "Hệ thống đang có sự cố nên đơn hàng VPS bạn bị hủy", "cancel_order_error");
            editStatusOrderVPSVN($idOrder, "cancel_order_error");
            // hoàn tiền
            addMoney($userEmail, $price);
            return;
        }
    }
    $createOrder = $cloudhub->createOrder($product_id, $billing_cycle, $os_id, $quanlity, $cpu, $ram, $disk);
    $successMessage = "
    ==================== ".date("Y-m-d H:i:s")." ====================
    User: ".$userEmail."
    Data: ".json_encode($createOrder)."
    ";
    $open = fopen("success_create_order.txt", "a+");
    fwrite($open, $successMessage . "\n");  
    fclose($open);
    if($createOrder['error'] == 0) {
        $data = $createOrder["data"][0];
        $vps_id = $data["vps-id"];
        $date_create = $data["date_create"];
        $next_due_date = $data["next_due_date"]; 
        $vps_status = $data["vps-status"];
        $is_special = $data["is-special"];
        $ip = $data["ip"];
        $username = $data["username"];
        $password = $data["password"];
       
        $infoProduct = getInfoVPSById($product_id)["product"];
        
        $nameProduct = "VPS Viet Nam";
        if($infoProduct != null) {
            $nameProduct = $infoProduct["name"];
        }
         // $user, $ten_san_pham, $price, $time_create, $end_time, $vps_status, $ip_vps, $username, $password, $url_dashboard_vps

        $mail_vps = create_mail_infomation_vps(
            $infoUser["username"],
            $nameProduct,
            $price,
            $date_create,
            $next_due_date,
            $vps_status,
            $ip,
            $username,  
            $password,
            "http://localhost:8080/vps_vietnam/?action=my_service"
            
        );
        sendEmail($userEmail, "THÔNG TIN KHỞI TẠO VPS", $mail_vps);


        editOrderVPSVN(
            $idOrder,
            $userEmail,
            $cpu,
            $ram,
            $disk,
            $product_id,
            $billing_cycle,
            "1",
            $vps_id,
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
            $price
        );

        updateStatusHoaDonByPartnerId($idOrder, 1);
        die('Create order success!! -> '.$userEmail);
    } else {
        // save result error
        $open = fopen("error_create_order.txt", "a+");
        $errorLogsMesage = "
        ==================== ".date("Y-m-d H:i:s")." ====================
        User: ".$userEmail."
        Data: ".json_encode($createOrder)."
        ==================================================================
        ";
        fwrite($open, $errorLogsMesage . "\n");
        fclose($open);
        addLog($userEmail, "Lỗi khi tạo đơn hàng VPS Việt Nam - ID: ".$idOrder. "- Giá: ".$price, "cancel_order_error");
        editStatusOrderVPSVN($idOrder, "cancel_order_error");
        // hoàn tiền
        addMoney($userEmail, $price);
        updateStatusHoaDonByPartnerId($idOrder, 2);
        return;
    }
} else {
    addLog($userEmail, "Hệ thống đang có sự cố nên đơn hàng VPS bạn bị hủy", "cancel_order_error");
    editStatusOrderVPSVN($idOrder, "cancel_order_error");
    // hoàn tiền
    addMoney($userEmail, $price);
    return;
}

?>