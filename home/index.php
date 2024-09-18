
<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">
<?php
$title_site = "Trang quản lý dịch vụ";

?>
<?php 
    include_once('../config.php');
    include_once('../auth/user.php');
    include_once('../helper/role.php');
    include_once('../helper/money.php');
    include_once('../auth/vps_vietnam.php');
    include_once('../auth/napthe.php');
    include_once('../auth/utils.php');
    include_once('../auth/hoa_don.php');
    $count_vps_vietnam = getOrderVPSVNByUserEmail($userInfo["email"]);
    if($count_vps_vietnam == false) {
        $count_vps_vietnam = [];
    }
    $total_service = 0;

    $total_service += count($count_vps_vietnam);


    
    // if($userInfo["email"] != $adminEmail) {
    //     die("<script>
        
    //     alert('Bạn không có quyền truy cập trang này'); 
    //     window.location.href = '/auth/logout.php';        
    //     </script>");
    // }



?>
<?php include_once('../adv_page/head.php') ?>

<body>

   <?php include_once('../adv_page/switcher.php'); ?>


    <!-- Loader -->
    <div id="loader" >
        <img src="../assets/images/media/loader.svg" alt="">
    </div>
    <!-- Loader -->

    <div class="page">
          <!-- app-header -->
          <?php include_once('../adv_page/header.php'); ?>
        <!-- /app-header -->
        
        <?php include_once('../adv_page/aside.php'); ?>

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Quản lý dịch vụ</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Service Management</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <!-- Start::row-1 -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-md-flex d-block flex-wrap align-items-center justify-content-between">
                                    <div class="flex-fill">
                                        <ul class="nav nav-pills nav-style-3" role="tablist">
                                        <p class="fw-semibold fs-18 mb-0">Chào mừng trở lại, <?= $userInfo["username"]; ?>!</p>
                                        </ul>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End::row-1 -->

                <!-- Start::row-2 -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="tab-content">
                            <div class="tab-pane show active p-0 border-0" id="stocks-portfolio" role="tabpanel">
                                <div class="row">
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="d-flex gap-3 flex-wrap align-items-top justify-content-between">
                                                    <div class="flex-fill d-flex align-items-top mb-4 mb-sm-0">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-rounded bg-primary">
                                                                <i class="ti ti-wallet fs-16"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="d-block text-muted">Số tiền hiện có</span>
                                                            <span class="fs-16 fw-semibold"><?= number_format($userInfo["money"], 0, ',', '.'); ?> VNĐ</span>
                                                         
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="d-flex gap-3 flex-wrap align-items-top justify-content-between">
                                                    <div class="flex-fill d-flex align-items-top mb-4 mb-sm-0">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-rounded bg-secondary">
                                                                <!-- icon service --> 
                                                                <i class="bi bi-briefcase fs-16"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="d-block text-muted">Số dịch vụ đã tạo</span>
                                                            <span class="fs-16 fw-semibold"><?= $total_service; ?></span>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="d-flex gap-3 flex-wrap align-items-top justify-content-between">
                                                    <div class="flex-fill d-flex align-items-top mb-4 mb-sm-0">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-rounded bg-warning">
                                                                <i class="ti ti-wallet fs-16"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="d-block text-muted">Tổng tiền đã nạp</span>
                                                            <span class="fs-16 fw-semibold"><?= number_format($userInfo["total_money"], 0, ',', '.'); ?> VNĐ</span>
                                                        </div>
                                                    </div>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="d-flex gap-3 flex-wrap align-items-top justify-content-between">
                                                    <div class="flex-fill d-flex align-items-top mb-4 mb-sm-0">
                                                        <div class="me-3">
                                                            <span class="avatar avatar-rounded bg-success">
                                                                <!-- icon money total --> 
                                                                <i class="bi bi-currency-dollar fs-16"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="d-block text-muted">Tổng tiền đã sử dụng</span>
                                                            <span class="fs-16 fw-semibold"><?php 
                                                                $total_money_used = $userInfo["total_money"] - $userInfo["money"];
                                                                echo number_format($total_money_used, 0, ',', '.');
                                                            ?>VNĐ</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div id="returns-rate"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="card custom-card">
                                            <div class="card-header justify-content-between">
                                                <div class="card-title mb-2 mb-sm-0">
                                                    Thống kê dịch vụ
                                                </div>
                                            
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table text-nowrap table-bordered border-primary">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">DỊCH VỤ</th>
                                                                <th scope="col">SỐ LƯỢNG</th>
                                                                <th scope="col">HÀNH ĐỘNG</th>
                                                                
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody id="render_lichsunaptien">
                                                            <tr>
                                                                <td>
                                                                    VPS VIỆT NAM
                                                                </td>
                                                                <td>
                                                                    <?= count($count_vps_vietnam); ?>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-secondary rounded-pill btn-wave" onClick="window.location.href='../vps_vietnam?action=my_service'">Xem</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="card custom-card">
                                            <div class="card-header justify-content-between">
                                                <div class="card-title mb-2 mb-sm-0">
                                                    Thông báo
                                                </div>
                                            
                                            </div>
                                            <div class="card-body">
                                                <?= $notication ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="card custom-card">
                                            <div class="card-header justify-content-between">
                                                <div class="card-title">
                                                    Hỗ trợ
                                                </div>
                                                
                                            </div>
                                            <div class="card-body p-0">
                                                <ul class="list-unstyled my-stocks-ul mb-0">
                                                <li>
                                                        <div class="d-flex align-items-center flex-fill lh-1">
                                                            <div class="me-2">
                                                                <span class="avatar avatar-rounded bg-light p-2">
                                                                    <!-- icon guide --> 
                                                                    <i class="bi bi-book-fill"></i>
                                                                </span>
                                                            </div>
                                                            <div class="lh-1 flex-fill">
                                                                <span class="fw-semibold d-block mb-2">Hướng dẫn cho người mới</span>
                                                                <span class="d-block text-muted fs-12">Cập nhật ngày: 02/05/2024</span>
                                                            </div>
                                                           
                                                            <div>
                                                                <span class="fs-14">
                                                                <button type="button" class="btn btn-secondary rounded-pill btn-wave" onClick="window.location.href='https://blog.ahexvps.com'">Xem</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-xl-5">
                                        <div class="card custom-card">
                                            <div class="card-header justify-content-between">
                                                <div class="card-title">
                                                    Lịch sử nạp tiền
                                                </div>
                                      
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table text-nowrap table-bordered border-primary">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">ID</th>
                                                                <th scope="col">LOẠI</th>
                                                                <th scope="col">SỐ TIỀN</th>
                                                                <th scope="col">THỜI GIAN</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody id="render_lichsunaptien">
                                                           <?php
                                                                $bank_invoice = getBankInvoiceByEmail($userInfo["email"]);
                                                                $card_invoice = getFullCardByEmail($userInfo["email"]);
                                                                $fullInvoiceFormats = [];
                                                                foreach ($bank_invoice as $bank) {
                                                                    $fullInvoiceFormats[] = [
                                                                        "id" => $bank["id"],
                                                                        "type" => "Bank",
                                                                        "money" => number_format($bank["amount"], 0, ',', '.')." VNĐ",
                                                                        "time" => $bank["dateCreated"]
                                                                    ];
                                                                }

                                                                foreach ($card_invoice as $card) {
                                                                    if($card["status"] == 1) {
                                                                        $fullInvoiceFormats[] = [
                                                                            "id" => $card["id"],
                                                                            "type" => "Card",
                                                                            "money" => number_format($card["price"], 0, ',', '.')." VNĐ",
                                                                            "time" => $card["update_date"]
                                                                        ];
                                                                    
                                                                    }
                                                                }

                                                                usort($fullInvoiceFormats, function($a, $b) {
                                                                    return strtotime($b["time"]) - strtotime($a["time"]);
                                                                });
                                                                for ($i = 0; $i < count($fullInvoiceFormats); $i++) {
                                                                    $invoice = $fullInvoiceFormats[$i];
                                                                    echo '<tr style="display: none;" id="invoice_'.$i.'">
                                                                    <td>'.$invoice["id"].'</td>
                                                                    <td>'.$invoice["type"].'</td>
                                                                    <td>'.$invoice["money"].'</td>
                                                                    <td>'.$invoice["time"].'</td>
                                                                </tr>';

                                                                }
                                                                $infoTableForJS = array(
                                                                    "count_invoice" => count($fullInvoiceFormats),
                                                                );
                                                                echo '<script>
                                                                var infoTableForJS = '.json_encode($infoTableForJS).';
                                                                
                                                                </script>';
                                                           ?>
                                                        </tbody>
                                                    </table><br>
                                                   <div class="input-group">
                                                    <button class="btn btn-outline-secondary" type="button" onClick="prevInvoicePage()">-</button>
                                                        <input type="number" class="form-control" aria-label="Quantity" id="pageInvoice" value="1" min="1">
                                                        <button class="btn btn-outline-secondary" type="button" onClick="nextInvoicePage()">+</button>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-7">
                                        <div class="card custom-card">
                                            <div class="card-header justify-content-between">
                                                <div class="card-title">
                                                    Lịch sử giao dịch
                                                </div>
                                               
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table text-nowrap table-bordered border-primary">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">ID</th>
                                                                <th scope="col">Thông tin</th>
                                                                <th scope="col">Ngày</th>
                                                                <th scope="col">Trạng thái</th>
                                                            
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $allHoaDon = getAllHoaDonByUserEmail($userInfo["email"]);
                                                                // limit 5 element
                                                                $allHoaDon = array_slice($allHoaDon, 0, 5);
                                                                for ($i = 0; $i < count($allHoaDon); $i++) {
                                                                    $hoaDon = $allHoaDon[$i];
                                                                    $infoDecode = json_decode(base64_decode($hoaDon["info"]),JSON_UNESCAPED_UNICODE);
                                                                    $strInfo = "";
                                                                    foreach ($infoDecode as $key => $value) {
                                                                        $strInfo .= $key.": ".$value."<br>";
                                                                    }

                                                                    $status = "";
                                                                    if($hoaDon["status"] == 0) {
                                                                        $status = "<span class='badge bg-warning'>Đang chờ</span>";
                                                                    } else if($hoaDon["status"] == 2) {
                                                                        $status = "<span class='badge bg-danger'>Thất bại</span>";
                                                                    } else {
                                                                        $status = "<span class='badge bg-success'>Thành công</span>";
                                                                    }

                                                                    echo '<tr>
                                                                    <td>'.$i.'</td>
                                                                    <td>'.$strInfo.'</td>
                                                                    <td>'.$hoaDon["dateCreated"].'</td>
                                                                    <td>'.$status.'</td>
                                                                </tr>';
                                                                
                                                                }

                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- button view more --> 
                                                <div class="text-center mt-3">
                                                    <button type="button" onClick="window.location.href='../order?type=hoa_don'" class="btn btn-primary btn-wave">Xem thêm</button>
                                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-0 border-0" id="stocks-market" role="tabpanel">
                                <div class="row">
                                    <div class="col-xxl-2 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2">
                                                            <span class="avatar bg-danger-transparent">
                                                                <i class="ti ti-trending-down fs-18"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="d-block fw-semibold">Nifty 50</span>
                                                            <span class="d-block">$12,289.44</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end text-danger fs-12">
                                                        <span class="d-block">-0.14%</span>
                                                        <span class="d-block">-$1,780.80</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2">
                                                            <span class="avatar bg-danger-transparent">
                                                                <i class="ti ti-trending-down fs-18"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="d-block fw-semibold">SENSEX</span>
                                                            <span class="d-block">$12,289.44</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end text-danger fs-12">
                                                        <span class="d-block">-0.14%</span>
                                                        <span class="d-block">-$1,780.80</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2">
                                                            <span class="avatar bg-success-transparent">
                                                                <i class="ti ti-trending-up fs-18"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="d-block fw-semibold">DJIA</span>
                                                            <span class="d-block">$12,289.44</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end text-danger fs-12">
                                                        <span class="d-block">-0.14%</span>
                                                        <span class="d-block">-$1,780.80</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2">
                                                            <span class="avatar bg-danger-transparent">
                                                                <i class="ti ti-trending-up fs-18"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="d-block fw-semibold">S&amp;P 500</span>
                                                            <span class="d-block">$12,289.44</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end text-danger fs-12">
                                                        <span class="d-block">-0.14%</span>
                                                        <span class="d-block">-$1,780.80</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2">
                                                            <span class="avatar bg-success-transparent">
                                                                <i class="ti ti-trending-up fs-18"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="d-block fw-semibold">NASDAQ</span>
                                                            <span class="d-block">$12,289.44</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end text-danger fs-12">
                                                        <span class="d-block">-0.14%</span>
                                                        <span class="d-block">-$1,780.80</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-2">
                                                            <span class="avatar bg-success-transparent">
                                                                <i class="ti ti-trending-up fs-18"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="d-block fw-semibold">NIFTY IT</span>
                                                            <span class="d-block">$12,289.44</span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end text-danger fs-12">
                                                        <span class="d-block">-0.14%</span>
                                                        <span class="d-block">-$1,780.80</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card custom-card">
                                            <div class="card-header justify-content-between">
                                                <div class="card-title">
                                                    Market Cap
                                                </div>
                                                <div>
                                                    <input class="form-control form-control-sm" type="text" placeholder="Search Any Stock Here" aria-label=".form-control-sm example">
                                                </div>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="row">
                                                    <div class="col-xl-7 border-end">
                                                        <div class="p-3">
                                                            <div class="d-flex flex-wrap alilgn-items-center justify-content-between">
                                                                <div class="d-flex flex-fill gap-3 ms-5">
                                                                    <div>
                                                                        <h5 class="fw-semibold text-primary">$12,390.02<span class="fs-12 ms-1 text-danger">0.14%<i class="ti ti-trending-down ms-1"></i></span></h5>
                                                                        <span class="d-block text-muted mb-1 fs-12"><span class="text-danger me-1">-89.75</span>. Today</span>
                                                                        <span class="d-block text-muted fs-11">Jun 17, 2023  11:25 AM  UTC +5:30</span>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex text-end">
                                                                    <div>
                                                                        <h6 class="fw-semibold">GITUHB</h6>
                                                                        <span class="d-block text-muted fs-11 mb-1">GTHB  INDEXNSE</span>
                                                                        <span class="d-block"><a href="javascript:void(0);" class="text-primary fw-semibold">+ Compare</a></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div id="stocks-marketcap"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-5">
                                                        <div class="p-3">
                                                            <div class="table-responsive mb-5">
                                                                <table class="table text-nowrap table-borderless table-sm text-muted">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">Open</th>
                                                                            <td>125.80</td>
                                                                            <td>Volume</td>
                                                                            <td>1,253.20</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">High</th>
                                                                            <td>352.15</td>
                                                                            <td>Avg. Volume</td>
                                                                            <td>1.05M</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Low</th>
                                                                            <td>120.13</td>
                                                                            <td>52 Week High</td>
                                                                            <td>2569.25</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">Dividend Yield</th>
                                                                            <td>3.5%</td>
                                                                            <td>52 Week Low</td>
                                                                            <td>1586.20</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">P/E Ratio</th>
                                                                            <td>25%</td>
                                                                            <td>Market Cap</td>
                                                                            <td>2.15Cr</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-semibold mb-2">
                                                                    Market Depth:
                                                                </h6>
                                                                <div class="row">
                                                                    <div class="col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table text-nowrap table-sm text-center table-borderless text-muted">
                                                                                <thead class="text-default bg-light">
                                                                                    <tr>
                                                                                        <th scope="col">Qty</th>
                                                                                        <th scope="col">Orders</th>
                                                                                        <th scope="col">Bid</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">
                                                                                            <span class="text-success">20</span>
                                                                                        </th>
                                                                                        <td>2</td>
                                                                                        <td>$12,908</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">
                                                                                            <span class="text-success">12</span>
                                                                                        </th>
                                                                                        <td>1</td>
                                                                                        <td>$20,632</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">
                                                                                            <span class="text-success">36</span>
                                                                                        </th>
                                                                                        <td>1</td>
                                                                                        <td>$19,102</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">
                                                                                            <span class="text-success">10</span>
                                                                                        </th>
                                                                                        <td>3</td>
                                                                                        <td>$16,650</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">
                                                                                            <span class="text-success">15</span>
                                                                                        </th>
                                                                                        <td>2</td>
                                                                                        <td>$18,850</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-6">
                                                                        <div class="table-responsive mb-3">
                                                                            <table class="table text-nowrap table-sm text-center table-borderless text-muted">
                                                                                <thead class="text-default bg-light">
                                                                                    <tr>
                                                                                        <th scope="col">Qty</th>
                                                                                        <th scope="col">Orders</th>
                                                                                        <th scope="col">Bid</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">
                                                                                            <span class="text-danger">20</span>
                                                                                        </th>
                                                                                        <td>2</td>
                                                                                        <td>$12,908</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">
                                                                                            <span class="text-danger">12</span>
                                                                                        </th>
                                                                                        <td>1</td>
                                                                                        <td>$20,632</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">
                                                                                            <span class="text-danger">36</span>
                                                                                        </th>
                                                                                        <td>1</td>
                                                                                        <td>$19,102</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">
                                                                                            <span class="text-danger">10</span>
                                                                                        </th>
                                                                                        <td>3</td>
                                                                                        <td>$16,650</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">
                                                                                            <span class="text-danger">15</span>
                                                                                        </th>
                                                                                        <td>2</td>
                                                                                        <td>$18,850</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div class="d-flex gap-3">
                                                                            <button type="button" class="flex-fill btn btn-sm btn-primary btn-wave">Buy</button>
                                                                            <button type="button" class="flex-fill btn btn-sm btn-secondary btn-wave">Sell</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End::row-2 -->

            </div>
        </div>
        <!-- End::app-content -->

        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="input-group">
                    <a href="javascript:void(0);" class="input-group-text" id="Search-Grid"><i class="fe fe-search header-link-icon fs-18"></i></a>
                    <input type="search" class="form-control border-0 px-2" placeholder="Search" aria-label="Username">
                    <a href="javascript:void(0);" class="input-group-text" id="voice-search"><i class="fe fe-mic header-link-icon"></i></a>
                    <a href="javascript:void(0);" class="btn btn-light btn-icon" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fe fe-more-vertical"></i>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                      <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                      <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li>
                    </ul>
                  </div>
                  <div class="mt-4">
                    <p class="font-weight-semibold text-muted mb-2">Are You Looking For...</p>
                    <span class="search-tags alert"><i class="fe fe-user me-2"></i>People<a href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert"><i class="fe fe-x"></i></a></span>
                    <span class="search-tags alert"><i class="fe fe-file-text me-2"></i>Pages<a href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert"><i class="fe fe-x"></i></a></span>
                    <span class="search-tags alert"><i class="fe fe-align-left me-2"></i>Articles<a href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert"><i class="fe fe-x"></i></a></span>
                    <span class="search-tags alert"><i class="fe fe-server me-2"></i>Tags<a href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert"><i class="fe fe-x"></i></a></span>
                  </div>
                  <div class="my-4">
                    <p class="font-weight-semibold text-muted mb-2">Recent Search :</p>
                    <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                      <a href="notifications.html"><span>Notifications</span></a>
                      <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert" aria-label="Close"><i class="fe fe-x text-muted"></i></a>
                    </div>
                    <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                      <a href="alerts.html"><span>Alerts</span></a>
                      <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert" aria-label="Close"><i class="fe fe-x text-muted"></i></a>
                    </div>
                    <div class="p-2 border br-5 d-flex align-items-center text-muted mb-0 alert">
                      <a href="mail.html"><span>Mail</span></a>
                      <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert" aria-label="Close"><i class="fe fe-x text-muted"></i></a>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <div class="btn-group ms-auto">
                    <button type="button" class="btn btn-sm btn-primary-light">Search</button>
                    <button type="button" class="btn btn-sm btn-primary">Clear Recents</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- Footer Start -->
        <?php include_once('../adv_page/footer.php'); ?>

    </div>

    
    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->

    <!-- Popper JS -->
    <script src="../assets/libs/@popperjs/core/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Defaultmenu JS -->
    <script src="../assets/js/defaultmenu.min.js"></script>

    <!-- Node Waves JS-->
    <script src="../assets/libs/node-waves/waves.min.js"></script>

    <!-- Sticky JS -->
    <script src="../assets/js/sticky.js"></script>

    <!-- Simplebar JS -->
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/js/simplebar.js"></script>

    <!-- Color Picker JS -->
    <script src="../assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>


    <!-- Apex Charts JS -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- HRM Dashboard JS -->
    <script src="../assets/js/stocks-dashboard.js"></script>

    
    <!-- Custom-Switcher JS -->
    <script src="../assets/js/custom-switcher.min.js"></script>

    <!-- Custom JS -->
    <script src="../assets/js/custom.js"></script>

    <script src="../js/home.js"></script>
</body>

</html>