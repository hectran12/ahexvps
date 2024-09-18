<?php
    error_reporting(0);
    include_once('../security/utils.php');    
    include_once('../sql/conn.php');
    include_once('../auth/utils.php');
    include_once('../helper/time.php');
    include_once('../security/utils.php');
    include_once('../helper/string.php');
    

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db();
        $check_rq = acceptRequestTime($userInfo, $cooldownNapthe, "nap_the");
        if ($check_rq == false) {
            die('
                <script>
                    alert("Nạp thẻ quá nhanh, vui lòng thử lại sau!");
                    window.location = "../view/topup";
                </script>   
            ');
        }
        include_once('../auth/user.php');
        include_once('../auth/napthe.php');
        
        $last_uri = $_SERVER['HTTP_REFERER'];

        $telco = isset($_POST['telco']) ? $_POST['telco'] : null;
        $price = isset($_POST['price']) ? $_POST['price'] : null;
        $code = isset($_POST['code']) ? $_POST['code'] : null;
        $seri = isset($_POST['seri']) ? $_POST['seri'] : null;
        
        if (empty($telco) || empty($price) || empty($code) || empty($seri)) {
            die('
                <script>
                    alert("Vui lòng nhập đầy đủ thông tin!");
                    window.location = "../view/topup";
                </script>   
            ');
        }

        if (!is_numeric($price) || !is_numeric($code) || !is_numeric($seri)) {
            die('
                <script>
                    alert("Số tiền, mã thẻ, seri phải là số!");
                    window.location = "../view/topup";
                </script>   
            ');
        }

        if (checkFormatCard($telco, $seri, $code)['status'] == false) {
            die('
                <script>
                    alert("Định dạng thẻ không hợp lệ!");
                    window.location = "../view/topup";
                </script>   
            ');
        }

        $trans_id = randomString();
        $nap = doithe($telco, $seri, $code, $price, $trans_id);
        if($nap["status"] == 99) {
            addNewCard(
                $userInfo['email'],
                $trans_id,
                $telco,
                $price,
                0,
                $seri,
                $code,
                0,
                gettime(),
                gettime(),
                ''
            );

            updateTimeRequestServer($userInfo, "nap_the");
            die('
                <script>
                    alert("Nạp thẻ thành công, vui lòng chờ xác nhận!");
                    window.location = "'.$last_uri.'";

                </script>
            ');

        

        } else {
            die('
                <script>
                    alert("Nạp thẻ thất bại, có thể thẻ lỗi hoặc đã bị nạp trước đó!");
                    window.location = "'.$last_uri.'";
                </script>
            ');
        }
    } else {
        die('
            <script>
                alert("Không thể xử lý yêu cầu!");
                window.location = "../page/404-error.php";
            </script>   
        ');
    
    }


function doithe ($telco, $seri, $code, $price, $trans_id) {
    global $partner_id, $partner_key, $url_charge;
    $sign = md5($partner_key.$code.$seri);
    $url = $url_charge.$sign.'&telco='.$telco.'&code='.$code.'&serial='.$seri.'&amount='.$price.'&request_id='.$trans_id.'&partner_id='.$partner_id.'&command=charging';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}
function checkFormatCard($type, $seri, $pin)
{
    $seri = strlen($seri);
    $pin = strlen($pin);
    $data = [];
    if ($type == 'Viettel' || $type == "viettel" || $type == "VT" || $type == "VIETTEL") {
        if ($seri != 11 && $seri != 14) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if ($pin != 13 && $pin != 15) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if ($type == 'Mobifone' || $type == "mobifone" || $type == "Mobi" || $type == "MOBIFONE") {
        if ($seri != 15) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if ($pin != 12) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if ($type == 'VNMB' || $type == "Vnmb" || $type == "VNM" || $type == "VNMOBI") {
        if ($seri != 16) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if ($pin != 12) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if ($type == 'Vinaphone' || $type == "vinaphone" || $type == "Vina" || $type == "VINAPHONE") {
        if ($seri != 14) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if ($pin != 14) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if ($type == 'Garena' || $type == "garena") {
        if ($seri != 9) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if ($pin != 16) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if ($type == 'Zing' || $type == "zing" || $type == "ZING") {
        if ($seri != 12) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if ($pin != 9) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    if ($type == 'Vcoin' || $type == "VTC") {
        if ($seri != 12) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài seri không phù hợp'
            ];
            return $data;
        }
        if ($pin != 12) {
            $data = [
                'status'    => false,
                'msg'       => 'Độ dài mã thẻ không phù hợp'
            ];
            return $data;
        }
    }
    $data = [
        'status'    => true,
        'msg'       => 'Success'
    ];
    return $data;
}

?>