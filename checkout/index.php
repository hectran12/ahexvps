<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">
<?php
$title_site = "Tạo VPS";

?>
<?php 
    error_reporting(0);
    include_once('../config.php');
    include_once('../auth/user.php');
    include_once('../helper/role.php');
    include_once('../helper/money.php');
    include_once('../auth/napthe.php');
    include_once('../helper/vps_vietnam.php');
?>

<body>

    <?php include_once('../adv_page/head.php') ?>


    <?php
        $id = isset($_GET["id"]) ? $_GET["id"] : null;
        $package = isset($_GET["package"]) ? $_GET["package"] : null;
        $last_uri = $_SERVER['HTTP_REFERER'];
        if ($id == null || $package == null) {
            die('
                <script>
                    alert("Không tìm thấy thông tin sản phẩm!");
                    window.location = "'.$last_uri.'";
                </script>   
            ');
        }

        $infoProduct = getInfoVPSById($id);
        if($infoProduct == false) {
            die('
                <script>
                    alert("Không tìm thấy thông tin sản phẩm!");
                    window.location = "'.$last_uri.'";
                </script>   
            ');
        }

        $product = $infoProduct["product"];
        $name_product = $product["name"];
        $cpu_vps = $product["cpu"];
        $ram_vps = $product["ram"];
        $ssd_vps = $product["disk"];
        $ip_vps = $product["ip"];
        $os = $product["os"];
        $bandwidth_vps = $product["bandwidth"];

        $gpu = $product["gpu"];
        
        $pricing_list = $product["pricing"];
        $limit_os = $product["limit-os"];

        if(count($limit_os) == 0) $limit_os = $data_os;
        


        $pricing = $product["pricing"];
        if($pricing[$package] == null) {
            die('
                <script>
                    alert("Không tìm thấy thông tin sản phẩm!");
                    window.location = "../page/404-error.php";
                </script>   
            ');
        }

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

        $data_req_for_js = array(
            "name" => $name_product,
            "product_id" => $id,
            "pricing_cpu" => $addonInfoCPU["pricing"],
            "pricing_ram" => $addonInfoRAM["pricing"],
            "pricing_disk" => $addonInfoDISK["pricing"],
            "max_core_up" => $max_core_up,
            "max_ram_up" => $max_ram_up,
            "max_disk_up" => $max_disk_up,


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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Khởi tạo VPS</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Checkout</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Khởi tạo VPS</li>
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
                                                Khởi tạo VPS
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
                                                                <li class="list-group-item">CPU: <?php echo $cpu_vps ?></li>
                                                                <li class="list-group-item">RAM: <?php echo $ram_vps ?></li>
                                                                <li class="list-group-item">SSD: <?php echo $ssd_vps ?></li>
                                                                <?php 
                                                                    if($gpu != 0) {
                                                                        echo '<li class="list-group-item">GPU: '.$gpu.'</li>';
                                                                    }
                                                                ?>
                                                                <li class="list-group-item">IP: <?php echo $ip_vps ?></li>
                                                                <li class="list-group-item">Bandwidth: <?php echo $bandwidth_vps ?></li>
                                                                

                                                            </ul>

                                                        </p>
                                                    </div>
                                                   
                                                </div><br>
                                                <div class="row gy-3">
                                                    <p class="fs-15 fw-semibold mb-1">Thời gian thanh toán</p>
                                                    <div class="col">
                                                        <select class="form-select" id="package" name="package">
                                                            <option value="0">Chọn thời gian thanh toán</option>
                                                            <?php
                                                                foreach ($pricing_list as $key => $value) {
                                                                    $billing_cycle = $value["billing_cycle"];
                                                                    $amount = $value["amount"];
                                                                    $money = number_format($amount, 0, ',', '.'). "VNĐ";

                                                                    if($amount != 0) {
                                                                        if($key == $package) {
                                                                            echo '<option gia="'.$amount.'" value="'.$key.'" selected>'.$billing_cycle.' ( '.$money.' )'.'</option>';
                                                                        } else {
                                                                            echo '<option  gia="'.$amount.'" value="'.$key.'">'.$billing_cycle.' ( '.$money.' )'.'</option>';
                                                                        }
                                                                      
                                                                    } 
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div><br>
                                                <div class="row gy-3">
                                                    <p class="fs-15 fw-semibold mb-1">Số lượng</p>
                                                    <div class="col">
                                                        <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" min="1" max="50" value="1">
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
                                                <div class="row gy-3">
                                                    <p class="fs-15 fw-semibold mb-1">Hệ điều hành</p>
                                                    <div class="col">
                                                        <select class="form-select" id="os" name="os">
                                                            <option value="0">Chọn hệ điều hành</option>
                                                            <?php
                                                                
                                                                for($i = 0; $i < count($limit_os); $i++) {
                                                                    echo '<option value="'.$limit_os[$i]["os-id"].'">'.$limit_os[$i]["os-name"].'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
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
    
    <!-- check out-->
    <script src="../js/checkout.js"></script>

   
</body>

</html>