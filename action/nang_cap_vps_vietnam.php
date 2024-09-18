<?php
    error_reporting(0);
    // thêm các file cần thiết
    include_once('../security/utils.php');    
    include_once('../sql/conn.php');
    include_once('../auth/utils.php');
    include_once('../helper/time.php');
    include_once('../security/utils.php');
    include_once('../helper/vps_vietnam.php');
    include_once('../auth/vps_vietnam.php');
    include_once('../helper/mail.php');
    include_once('../email/utils.php');
    
    // kiểm tra xem có đủ điều kiện để thực hiện request không
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $vps_id = isset($_POST['vps_id']) ? $_POST['vps_id'] : null;
        $cpu = isset($_POST['cpu']) ? $_POST['cpu'] : null;
        $ram = isset($_POST['ram']) ? $_POST['ram'] : null;
        $disk = isset($_POST['disk']) ? $_POST['disk'] : null;
      
        $last_uri = $_SERVER['HTTP_REFERER'];
        
        // check empty
        if ($vps_id == null || $cpu == null || $ram == null || $disk == null) {
            header('Location: '.$last_uri);
            die();
        }

        
        // check người dùng và thêm các file cần thiết
        $conn = new db();
        include_once('../auth/user.php');
        include_once('../auth/vps_vietnam.php');
        include_once('../auth/action_task_vps_vn.php');
        include_once('../auth/hoa_don.php');

        // check vps có phải của user không
        $infoVPS = getInfoVPSByVPS_ID($vps_id);
        if($infoVPS["user_email"] != $userInfo["email"]) {
            die ('
                <script>
                    alert("VPS không thuộc sở hữu của bạn!");
                    window.location = "'.$last_uri.'";
                </script>
            
            ');
        }


        // lấy thông tin vps 
        $vpsInfo = getInfoVPSByVPS_ID($vps_id);


        if($vpsInfo == false) {
            die ('
                <script>
                    alert("VPS không tồn tại!");
                    window.location = "'.$last_uri.'";
                </script>
            
            ');
        }


        $fullInfoVPS = getInfoVPSById($vpsInfo["product_id"]);
        if($fullInfoVPS == false) {
            die ('
                <script>
                    alert("VPS không tồn tại!");
                    window.location = "'.$last_uri.'";
                </script>
            
            ');
        }


        

        // kiểm tra lại tổng số tiền cần nâng cấp cho vps


        $productInfo = $fullInfoVPS["product"];
        if($productInfo["special"] != 0) {
            die ('
                <script>
                    alert("VPS này không thể nâng cấp");
                    window.location.href = "/";
                </script>
            ');
        }

        $name_product = $productInfo["name"];

        $addonInfoCPU = getInfoAddByName("CPU")["product"];
        $addonInfoRAM = getInfoAddByName("RAM")["product"];
        $addonInfoDISK = getInfoAddByName("SSD")["product"];



        if ($addonInfoCPU == null || $addonInfoRAM == null || $addonInfoDISK == null) {
            die('
                <script>
                    alert("Không tìm thấy thông tin sản phẩm!");
                    window.location = "'.$last_uri.'";
                </script>   
            ');
        }

        $expriDate = strtotime($vpsInfo["next_due_date"]);
        $currentDate = strtotime(date("d-m-Y"));
        $countDays = ($expriDate - $currentDate) / (60 * 60 * 24);
        $month = $countDays / 30;
        $days = $countDays - (floor($month) * 30);

        $priceCPU = $addonInfoCPU["pricing"]["monthly"]["amount"];
        $priceRAM = $addonInfoRAM["pricing"]["monthly"]["amount"];
        $priceDISK = $addonInfoDISK["pricing"]["monthly"]["amount"];


        if($countDays < 5) {
            $priceCPU = $priceCPU / 2;
            $priceDISK = $priceDISK / 2;
            $priceRAM = $priceRAM / 2;
        }
        else {
            $priceCPU = ($priceCPU * round($month))* round($cpu);
            $priceDISK = ($priceDISK * round($month))* round($disk / 10);
            $priceRAM = ($priceRAM * round($month)) * round($ram);
        }

        $totalPrice = $priceCPU + $priceRAM + $priceDISK;
        
        if ($totalPrice > $userInfo["money"]) {
            die('
                <script>
                    alert("Số dư không đủ!");
                    window.location = "'.$last_uri.'";
                </script>   
            ');
        }

        $listSanPham = [];
        if($priceCPU > 0) {
            $listSanPham[] = array(
                "ten_san_pham" => "Nâng cấp CPU",
                "so_luong" => $cpu,
                "gia" => $priceCPU
            );
        }

        if($priceRAM > 0) {
            $listSanPham[] = array(
                "ten_san_pham" => "Nâng cấp RAM",
                "so_luong" => $ram,
                "gia" => $priceRAM
            );
        }


        if($priceDISK > 0) {
            $listSanPham[] = array(
                "ten_san_pham" => "Nâng cấp ổ cứng",
                "so_luong" => $disk,
                "gia" => $priceDISK
            );
        }


        $confirmEmail = create_mail_confirm_order(
            $userInfo["username"],
            $listSanPham
        );

        sendEmail($userInfo["email"], "Xác nhận nâng cấp VPS [".$vpsInfo["ip"]."]", $confirmEmail);

        $idTask = createTaskVPSVN($userInfo["email"], "confirm-upgrade-vps", 
            json_encode(array(
                "vps_id" => $vps_id,
                "cpu" => $cpu,
                "ram" => $ram,
                "disk" => $disk
            ))
        , $vps_id);
        createNewHoaDon($idTask."nang_cap", $userInfo["email"], json_encode(
            array(  
                "Nâng cấp VPS có IP" => $vpsInfo["ip"],
                "CPU nâng cấp" => $cpu,
                "RAM nâng cấp" => $ram,
                "Disk nâng cấp" => $disk,
                "Giá" => $totalPrice,
            )
            ));



        addLog($userInfo["email"], "Xác nhận nâng cấp vps - ID: " . $vps_id, "confirm_upgrade_vps");
        die('
            <script>
                alert("Hệ thống sẽ xử lý đơn hàng bạn trong chốt lát, tiền sẽ tự trừ khi vps được nâng cấp thành công!");
                window.location = "'.$last_uri.'";
            </script>
        ');

        
        


    } else {
        header('Location: ../');
        die();
    }

?>