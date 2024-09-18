<?php
    error_reporting(0);
    // thêm các file cần thiết
    include_once('../security/utils.php');    
    include_once('../sql/conn.php');
    include_once('../auth/utils.php');
    include_once('../helper/time.php');
    include_once('../security/utils.php');
    include_once('../helper/vps_vietnam.php');
    include_once('../helper/mail.php');
    include_once('../email/utils.php');
    

    // kiểm tra xem có đủ điều kiện để thực hiện request không
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        // lấy thông tin từ form
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
        $billing_cycle = isset($_POST['billing_cycle']) ? $_POST['billing_cycle'] : null;
        $os = isset($_POST['os']) ? $_POST['os'] : null;
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
        $cpu = isset($_POST['cpu']) ? $_POST['cpu'] : null;
        $ram = isset($_POST['ram']) ? $_POST['ram'] : null;
        $disk = isset($_POST['disk']) ? $_POST['disk'] : null;
        $last_uri = $_SERVER['HTTP_REFERER'];
        if ($product_id == null || $billing_cycle == null || $os == null || $quantity == null || $cpu == null || $ram == null || $disk == null) {
            die('
                <script>
                    alert("Vui lòng nhập đầy đủ thông tin");
                    window.location.href = "'.$last_uri.'";
                </script>
            ');
        }

        
        // check người dùng và thêm các file cần thiết
        $conn = new db();
        include_once('../auth/user.php');
        include_once('../auth/vps_vietnam.php');
        include_once('../auth/hoa_don.php');


        if(!is_numeric($product_id) || !is_numeric($os) || !is_numeric($quantity) || !is_numeric($cpu) || !is_numeric($ram) || !is_numeric($disk)) {
            die('
                <script>
                    alert("Dữ liệu không hợp lệ");
                    window.location.href = "'.$last_uri.'";
                </script>
            ');
        }


        // check số lượng (giả sử có người đó mua 1.5 sản phẩm thì sẽ làm tròn lên 2 sản phẩm)
        $cpu = round($cpu);
        $ram = round($ram);
        $disk = round($disk);
        $quantity = round($quantity);

        // lấy thông tin sản phẩm
        $info_product = getInfoVPSById($product_id);    
        if($info_product == false) {
            die('
                <script>
                    alert("Sản phẩm không tồn tại");
                    window.location.href = "'.$last_uri.'";
                </script>
            ');
        }
        
        $product = $info_product["product"];
        $pricing = $product["pricing"];
        $limit_os = $product["limit-os"];
        $nameProduct = $product["name"];
        if(count($limit_os) == 0) $limit_os = $data_os;

        $statusFind_os = false;
        for($os_id = 0; $os_id < count($limit_os); $os_id++) {
            if($limit_os[$os_id]["os-id"] == $os) {
                $statusFind_os = true;
                break;
            }
        }

        if($statusFind_os == false) {
            die('
                <script>
                    alert("Hệ điều hành không hợp lệ");
                    window.location.href = "'.$last_uri.'";
                </script>
            ');
        }
        if($pricing[$billing_cycle] == null) {
            die('
                <script>
                    alert("Chu kỳ thanh toán không hợp lệ");
                    window.location.href = "'.$last_uri.'";
                </script>
            ');
        }

        $amount_pricing = $product["pricing"][$billing_cycle];
        if($amount_pricing["amount"] == 0 || $amount_pricing["amount"] == null) {
            die('
                <script>
                    alert("Giá sản phẩm không hợp lệ");
                    window.location.href = "'.$last_uri.'";
                </script>
            ');
        }
      
        $amount = $amount_pricing["amount"] * $quantity;

        if($cpu > 0) {
            $addon_cpu = getInfoAddByName('CPU');
            $addon_cpu_product = $addon_cpu["product"];

        
            $addon_cpu_pricing = $addon_cpu_product["pricing"];
            if(count($addon_cpu_pricing) == 0) {
                die('
                    <script>
                        alert("Giá CPU không hợp lệ");
                        window.location.href = "'.$last_uri.'";
                    </script>
                ');
            }
            if($addon_cpu_pricing[$billing_cycle] > 0) {
                $amount += ($addon_cpu_pricing[$billing_cycle]["amount"] * $cpu) *$quantity;
            }
        }


        if($ram > 0) {
            $addon_ram = getInfoAddByName('RAM');
            $addon_ram_product = $addon_ram["product"];
            $addon_ram_pricing = $addon_ram_product["pricing"];
            if ($addon_ram_pricing[$billing_cycle] == null) {
                die('
                    <script>
                        alert("Giá RAM không hợp lệ");
                        window.location.href = "'.$last_uri.'";
                    </script>
                ');
            }
    
            if($addon_ram_pricing[$billing_cycle] > 0) {
                $amount += ($addon_ram_pricing[$billing_cycle]["amount"] * $ram) *$quantity;
            }
        }

        if($disk % 10 == 0) {
            $addon_disk = getInfoAddByName('SSD');
            $addon_disk_product = $addon_disk["product"];
            $addon_disk_pricing = $addon_disk_product["pricing"];
            if ($addon_disk_pricing[$billing_cycle] == null) {
                die('
                    <script>
                        alert("Giá ổ cứng không hợp lệ");
                        window.location.href = "'.$last_uri.'";
                    </script>
                ');
            }
            if($addon_disk_pricing[$billing_cycle] > 0) {
                $amount += ($addon_disk_pricing[$billing_cycle]["amount"] * $disk / 10) *$quantity;
            }
        }
        
        $listSanPham = [];
        $listSanPham[] = array(
            "ten_san_pham" => $nameProduct . ' (chu kỳ thanh toán: '.$billing_cycle.')',
            "so_luong" => $quantity,
            "gia" => $amount_pricing["amount"] * $quantity
        );

        if ($cpu > 0) {
            $listSanPham[] = array(
                "ten_san_pham" => "CPU Thêm",
                "so_luong" => $cpu,
                "gia" => ($addon_cpu_pricing[$billing_cycle]["amount"] * $cpu) * $quantity
            );
        }

        if ($ram > 0) {
            $listSanPham[] = array(
                "ten_san_pham" => "RAM Thêm",
                "so_luong" => $ram,
                "gia" => ($addon_ram_pricing[$billing_cycle]["amount"] * $ram) * $quantity
            );
        }

        if ($disk % 10 == 0 && $disk > 0) {
            $listSanPham[] = array(
                "ten_san_pham" => "SSD Thêm",
                "so_luong" => $disk,
                "gia" => ($addon_disk_pricing[$billing_cycle]["amount"] * $disk / 10) * $quantity
            );
        }
        
        // send email confirm
        $confirmEmail = create_mail_confirm_order(
            $userInfo["username"],
            $listSanPham
        );
        sendEmail($userInfo["email"], "Xác nhận đơn hàng", $confirmEmail);
        $allOrders = getOrderVPSVNByUserEmail($userInfo["email"]);

        $pricePerVPS = $amount / $quantity;
        if ($allOrders == false) {
            if($userInfo["money"] >= $amount) {
                for ($i = 0; $i<$quantity; $i++) {
                    $idDonhang = addNewOrderVPSVietnam(
                        $userInfo["email"],
                        $cpu,
                        $ram,
                        $disk,
                        $product_id,
                        $billing_cycle,

                        "1",
                        "0",
                        $os,
                        "",
                        "",
                        "request_create_order",
                        "0",
                        "chưa có",
                        "chưa có",
                        "chưa có",
                        '',
                        0,
                        $pricePerVPS
                    );
                    createNewHoaDon($idDonhang, $userInfo["email"], json_encode(
                        array(
                            "Sản phẩm" => $nameProduct . ' (chu kỳ thanh toán: '.$billing_cycle.')',
                            "Giá" => $pricePerVPS
                        )
                    ));
                }
                die('
                    <script>
                        alert("Tạo đơn hàng thành công");
                        window.location.href = "'.$last_uri.'";
                    </script>
                ');
            } else {
                die('
                    <script>
                        alert("Số dư không đủ");
                        window.location.href = "'.$last_uri.'";
                    </script>
                ');
            }
        } else {
            $countOrderProgressRequest = 0;
            foreach ($allOrders as $order) {
                if($order["vps_status"] == "request_create_order") {
                    $amount += $order["pricing"];
                    $countOrderProgressRequest++;
                }
            }

            if($userInfo["money"] >= $amount) {
                for ($i = 0; $i<$quantity; $i++) {
                    $idDonhang = addNewOrderVPSVietnam(
                        $userInfo["email"],
                        $cpu,
                        $ram,
                        $disk,
                        $product_id,
                        $billing_cycle,
                        "1",
                        "0",
                        $os,
                        "",
                        "",
                        "request_create_order",
                        "0",
                        "chưa có",
                        "chưa có",
                        "chưa có",
                        '',
                        0,
                        $pricePerVPS
                    );

                    createNewHoaDon($idDonhang, $userInfo["email"], json_encode(
                        array(
                            "Sản phẩm" => $nameProduct . ' (chu kỳ thanh toán: '.$billing_cycle.')',
                            "Giá" => $pricePerVPS
                        )
                    ));
                }
                die('
                    <script>
                        alert("Tạo đơn hàng thành công, hiện tại bạn có '.$countOrderProgressRequest.' đơn hàng đang chờ xử lý");
                        window.location.href = "'.$last_uri.'";
                    </script>
                ');
            } else {
                die('
                    <script>
                        alert("Số dư không đủ, hiện tại bạn có '.$countOrderProgressRequest.' đơn hàng đang chờ xử lý");
                        window.location.href = "'.$last_uri.'";
                    </script>
                ');
            }
        }



    }
?>
