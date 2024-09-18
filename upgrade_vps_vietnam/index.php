<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">
<?php
$title_site = "Nâng cấp VPS";

?>
<?php 
    error_reporting(0);
    include_once('../config.php');
    include_once('../auth/user.php');
    include_once('../helper/role.php');
    include_once('../helper/money.php');
    include_once('../auth/napthe.php');
    include_once('../auth/vps_vietnam.php');
    include_once('../helper/vps_vietnam.php');
?>
    <?php include_once('../adv_page/head.php') ?>
<body>




    <?php


        $id_vps = isset($_GET["id"]) ? $_GET["id"] : null;
        $direct_uri  = $_SERVER['REQUEST_URI'];
        if ($id_vps == null) {
            die('
            
                <script>
                    alert("Không tìm thấy VPS này!");
                    window.location.href = "/";

                </script>
            ');
        }


        $vpsInfo = getInfoVPSByVPS_ID($id_vps);
        if($vpsInfo["user_email"] != $userInfo["email"]) {
            die ('
                <script>
                    alert("Bạn không có quyền thực hiện hành động đối với vps này");
                    window.location.href = "/";
                </script>
            
            ');
        }



        $fullInfoVPS = getInfoVPSById($vpsInfo["product_id"]);
        if ($fullInfoVPS == false) {
            die('
                <script>
                    alert("Không tìm thấy VPS");
                    window.location.href = "/";
                </script>
            ');
        }


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
            $priceCPU = $priceCPU * round($month);
            $priceDISK = $priceDISK * round($month);
            $priceRAM = $priceRAM * round($month);
        }



        $data_req_for_js = array(
            "id_vps" => $id_vps,
            "name_product" => $name_product,
            "max_core_up" => $max_core_up,
            "max_ram_up" => $max_ram_up,
            "max_disk_up" => $max_disk_up,
            "priceCPU" => $priceCPU,
            "priceRAM" => $priceRAM,
            "priceDISK" => $priceDISK,
            "billing_cycle" => $vpsInfo["billing_cycle"]


        );
        echo '<script>
            var data_req_for_js = '.json_encode($data_req_for_js).';
        </script>';

    ?>
    <!-- Loader -->
    <div id="loader">
        <img src="../assets/images/media/loader.svg" alt="">
    </div>
    <!-- Loader -->



    <div class="page">
        <?php include_once('../adv_page/header.php'); ?>
        <!-- Start::app-sidebar -->
        <?php include_once('../adv_page/aside.php'); ?>
        <!-- End::app-sidebar -->

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Nâng cấp VPS</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Nâng cấp vps Việt Nam</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Nâng cấp</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <div class="container">
                    <!-- Start::row-1 -->
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="card custom-card">
                                <div class="card-body p-0 product-checkout">
                                    <ul class="nav nav-tabs tab-style-2 d-sm-flex d-block border-bottom border-block-end-dashed"
                                        id="myTab1" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="order-tab" data-bs-toggle="tab"
                                                data-bs-target="#order-tab-pane" type="button" role="tab"
                                                aria-controls="order-tab" aria-selected="true">
                                                <!-- ICON CREATE -->
                                                <i class="ri-shopping-cart-2-line me-2 align-middle d-inline-block"></i>
                                                Nâng cấp VPS
                                            </button>
                                        </li>

                                    </ul>
                                    
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active border-0 p-0" id="order-tab-pane"
                                            role="tabpanel" aria-labelledby="order-tab-pane" tabindex="0">
                                            <div class="p-4">
                                                <div class="card border border-success mb-3">
                                                    <div
                                                        class="card-header bg-transparent border-bottom border-success">
                                                        <?php
                                                            echo '<h5 class="mb-0 fw-semibold text-success">'.$name_product.'</h5>'
                                                        ?></div>
                                                    <div class="card-body text-success">
                                                        <h6 class="card-title fw-semibold">Thông tin cấu hình</h6>
                                                            <p class="card-text">
                                                                
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item">CPU: <?php echo $vpsInfo["cpu"] ?> Core</li>
                                                                    <li class="list-group-item">RAM: <?php echo $vpsInfo["ram"] ?> GB</li>
                                                                 
                                                                    <li class="list-group-item">SSD: <?php echo $vpsInfo["disk"] ?> GB</li>
                                                                    <?php 
                                                                        if($gpu != 0) {
                                                                            echo '<li class="list-group-item">GPU: '.$gpu.'</li>';
                                                                        }
                                                                    ?>
                                                                    <li class="list-group-item">IP: <?php echo $vpsInfo["ip"] ?></li>
                                                                
                                                                </ul>

                                                            </p>
                                                    </div>
                                                   
                                                </div><br>
                                                
                                               
                                                <div class="row gy-3">
                                                    <p class="fs-15 fw-semibold mb-1">Thêm cấu hình</p>
                                                    <div class="col">
                                                        <center><label for="cpu">CPU</label></center>
                                                        <div class="input-group">
                                                            <button class="btn btn-outline-secondary" type="button" onClick="giam_cpu()">-</button>
                                                            <input type="number" class="form-control" id="cpu" name="cpu" placeholder="Enter CPU" min="0" value="0" max="<?= $max_core_up; ?>">
                                                            <button class="btn btn-outline-secondary" type="button" onClick="tang_cpu()">+</button>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        
                                                        <center><label for="ram">RAM</label></center>
                                                        <div class="input-group">
                                                            <button class="btn btn-outline-secondary" type="button" onClick="giam_ram()">-</button>
                                                            <input type="number" class="form-control" id="ram" name="ram" placeholder="Enter RAM" min="0" value="0" max="<?= $max_ram_up; ?>">
                                                            <button class="btn btn-outline-secondary" type="button" onClick="tang_ram()">+</button>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <center><label for="disk">DISK</label></center>
                                                        <div class="input-group">
                                                            <button class="btn btn-outline-secondary" type="button" onClick="giam_disk()">-</button>
                                                            <input type="number" class="form-control" id="disk" name="disk" placeholder="Enter DISK" min="0" value="0" step="10" max="<?= $max_disk_up; ?>">
                                                            <button class="btn btn-outline-secondary" type="button" onClick="tang_disk()">+</button>
                                                        </div>
                                                    </div>
                                                </div><br>
                                               
                                            </div>
                                            <div
                                                class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">
                                                <button type="button" class="btn btn-success-light"
                                                    onClick="create_don_hang()">Tạo đơn hàng
                                                    <i class="ri-arrow-right-s-line ms-2"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title me-1">Tóm tắt đơn hàng</div>
                                </div>
                                <div class="card-body p-0">
                                 
                                    <div class="p-3 border-bottom border-block-end-dashed">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>SẢN PHẨM</th>
                                                    <th>SỐ LƯỢNG</th>
                                                    <th>CHI PHÍ</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tomtatdonhang">
                                             
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="p-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="fs-15">Tổng tiền: </div>
                                            <div class="fw-semibold fs-16 text-dark" id="tongtien"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End::row-1 -->
                </div>

            </div>
        </div>
        <!-- End::app-content -->

        <!-- Footer Start -->
        <?php include_once('../adv_page/footer.php'); ?>
        <!-- Footer End -->

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



    <!-- Custom-Switcher JS -->
    <script src="../assets/js/custom-switcher.min.js"></script>

    <!-- Internal Checkout JS -->
    <script src="../assets/js/checkout.js"></script>

    <!-- Custom JS -->
    <script src="../assets/js/custom.js"></script>

    <script src="../js/upgrade_vps_vietnam.js"></script>

</body>

</html>