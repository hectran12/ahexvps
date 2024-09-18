<?php




$data_vps = json_decode(file_get_contents('../data/products.json'),true);
$data_os = json_decode(file_get_contents('../data/os.json'),true);

function getInfoVPSById ($id) {
    global $data_vps;
    $vps = $data_vps["vps"];

    for ($i = 0; $i < count($vps); $i++) {
        $product = $vps[$i]["product"];
        $group_product_name = $vps[$i]["group_product_name"];
        for ($j = 0; $j < count($product); $j++) {
            if ($product[$j]["product_id"] == $id) {
                return array(
                    "group_product_name" => $group_product_name,
                    "product" => $product[$j],
                );
            }
        }
    }

    return false;
}


function getOSById ($id) {
    global $data_os;
    for ($i = 0; $i < count($data_os); $i++) {
        if ($data_os[$i]["os-id"] == $id) {
            return $data_os[$i];
        }
    }
    return false;
}

function getInfoAddByName ($name) {
    global $data_vps;
    $addon = $data_vps["addon_vps"];
    for ($i = 0; $i < count($addon); $i++) {
        $group_product_name = $addon[$i]["group_product_name"];

        $product = $addon[$i]["product"];
        for ($j = 0; $j < count($product); $j++) {
            if ($product[$j]["name"] == $name) {
                return array(
                    "group_product_name" => $group_product_name,
                    "product" => $product[$j],
                );
            }
        }
    }
}






function getVPSStatusHTML ($vps_status) {
  
    if ($vps_status == 'request_create_order') {
        return '<span class="badge bg-primary">Đang chờ xử lý</span>';
    }

    if($vps_status == 'cancel_order') {
        return '<span class="badge bg-danger">Đã hủy</span>';
    }

    if($vps_status == 'cancel_order_error') {
        return '<span class="badge bg-danger">Lỗi đơn</span>';
    }

    if($vps_status == 'progressing') {
        return '<span class="badge bg-warning">Đang xử lý</span>';
    }

    if($vps_status == 'running') {
        return '<span class="badge bg-success">Đang chạy</span>';
    }

    if($vps_status == 'creating') {
        return '<span class="badge bg-info">Đang tạo ...</span>';
    }

    if($vps_status == 'off_vps') {
        return '<span class="badge bg-danger">Đã tắt</span>';
    }

    if($vps_status == 'reinstalling') {
        return '<span class="badge bg-info">Đang cài lại ...</span>';
    }


    if($vps_status == 'expired') {
        return '<span class="badge bg-danger">Hết hạn</span>';
    }

    if($vps_status == 'transfer_vps') {
        return '<span class="badge bg-info">Đang chuyển</span>';
    }

    if ($vps_status == 'error') {
        return '<span class="badge bg-danger">Lỗi</span>';
    }
   
}


function getAutoRenewHTML ($status_auto_renew) {
    if ($status_auto_renew == 1) {
        return '<span class="badge bg-success">Bật</span>';
    }

    return '<span class="badge bg-danger">Tắt</span>';
}






?>

