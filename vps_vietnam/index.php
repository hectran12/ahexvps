<?php

    if(isset($_GET["action"])) {
        $whiteList = ["my_service"];
        if(!in_array($_GET["action"], $whiteList)) {
            die("<script>
            
            alert('Bạn không có quyền truy cập trang này'); 
            window.location.href = '/auth/logout.php';        
            </script>");
        }
        include_once($_GET["action"].".php");
        die();
    }


?>


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
    include_once('../auth/napthe.php');
    // if($userInfo["email"] != $adminEmail) {
    //     die("<script>
        
    //     alert('Bạn không có quyền truy cập trang này'); 
    //     window.location.href = '/auth/logout.php';        
    //     </script>");
    // }
    $infoAllCard = getFullCardByEmail($userInfo["email"]);
    echo "<script> var infoAllCard = ".json_encode($infoAllCard).";</script>";
?>

<body>

<?php include_once('../adv_page/head.php') ?>

<body>

     


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
                    <h1 class="page-title fw-semibold fs-18 mb-0" id="titleProduct">Pricing</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Pricing</li>
                            </ol>
                        </nav>
                    </div>
                </div>


                <div id="contentPricing">

                    <?php
                        error_reporting(0);
                        $pricing = file_get_contents('../data/products.json');
                        $pricing = json_decode($pricing, true);
                        $vps = $pricing["vps"];
                        if (count($vps) == 0) {
                            echo "<h3>Không có sản phẩm nào</h3>";
                        }

                        $products = $vps[$_GET["plan"]];
                        if($products == null) {
                            echo "<h3>Không tìm thấy sản phẩm</h3>";
                        } else {
                            $group_product_name = $products["group_product_name"];
                            echo '<script>document.getElementById("titleProduct").innerHTML = "Danh mục sản phẩm '.$group_product_name.'";</script>';


                            $product = $products["product"];
                            $rows = count($product)/4;
                            
                            for ($i = 0; $i < $rows; $i++) {
                                $start = $i * 4;
                                $end = $start + 4;
                                echo '  <div class="tab-pane show active p-0 border-0" id="pricing-monthly1-pane" role="tabpanel" aria-labelledby="pricing-monthly1" tabindex="0">';
                            echo ' <div class="row">';
                                for ($j = $start; $j < $end; $j++) {
                                    $name = $product[$j]["name"];
                                    if($name == null || $name == "") continue;
                                    $cpu = $product[$j]["cpu"];
                                    $product_id = $product[$j]["product_id"];
                                    $ram = $product[$j]["ram"];
                                    $disk = $product[$j]["disk"];
                                    $ip = $product[$j]["ip"];
                                    $os = $product[$j]["os"];
                                    $bandwidth = $product[$j]["bandwidth"];
                                    $gpu = $product[$j]["gpu"];
                                    $pricing = $product[$j]["pricing"];
                                    $select_price_html = ' <select class="form-select" aria-label="Chọn thời hạn thuê" id="selectPrice_'.$product_id.'" onChange="changePrice(this, '.$product_id.')">';
                                    $first_choice = false;
                                    foreach ($pricing as $name_price => $price_value) {
                                        $billing_cycle = $price_value["billing_cycle"];
                                        $amount = $price_value["amount"];
                                        $vnd_format = number_format($amount, 0, ',', '.'). ' VNĐ';
                                        if($first_choice == false) {
                                            if($amount > 0) $select_price_html .= '<option value="'.$name_price.'" selected>'.$billing_cycle.' ('.$vnd_format.')</option>';
                                            $first_choice = true;
                                        } else {
                                            if($amount > 0) $select_price_html .= '<option value="'.$name_price.'">'.$billing_cycle.' ('.$vnd_format.')</option>';
                                        }
                                        
                                    }
                                    $select_price_html .= '</select>';
                                    echo ' <div class="col-xxl-3 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="card custom-card overflow-hidden">
                                        <div class="card-body p-0">
                                            <div class="px-1 py-2 bg-success op-3"></div>
                                            <div class="p-4">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="fs-18 fw-semibold">' . $name .'</div>
                                                    
                                                </div>
                                            

                                                <div class="fs-25 fw-bold mb-1" id="pricing_title_'.$product_id.'">'.number_format($pricing["monthly"]["amount"], 0, ',', '.') . "VNĐ".'<sub class="text-muted fw-semibold fs-11 ms-1">/ 1 tháng</sub></div>

                                                    '.$select_price_html.'
                                                <br>
                                                <script></script>
                                               
                                                <ul class="list-unstyled mb-0">
                                                    <li class="d-flex align-items-center mb-3">
                                                        <span class="me-2">
                                                            <!-- icon cpu --> 
                                                            <i class="ri-cpu-line fs-15 text-success"></i>
                                                        </span>
                                                        <span>
                                                            <strong class="me-1 d-inline-block">CPU: '.$cpu.'GB</strong>
                                                        </span>
                                                    </li>


                                                   

                                                    <li class="d-flex align-items-center mb-3">
                                                    <span class="me-2">
                                                        <!-- icon ram --> 
                                                       
                                                        <i class="ri-ram-fill fs-15 text-success"></i>
                                                    </span>
                                                    <span>
                                                        <strong class="me-1 d-inline-block">RAM: '.$ram.'GB</strong>
                                                    </span>
                                                    </li>';

                                                    if($gpu != 0) {
                                                        echo '  <li class="d-flex align-items-center mb-3">
                                                        <span class="me-2">
                                                            <!-- icon gpu --> 
                                                            <i class="ri-vidicon-fill fs-15 text-success"></i>
                                                        </span>
                                                        <span>
                                                            <strong class="me-1 d-inline-block">GPU: '.$gpu.'GB</strong>
                                                        </span>
                                                        </li>';
                                                    }

                                                echo '
                                                    <li class="d-flex align-items-center mb-3">
                                                    <span class="me-2">
                                                        <!-- icon disk -->
                                                        <i class="ri-hard-drive-fill fs-15 text-success"></i>
                                                    </span>
                                                    <span>
                                                        <strong class="me-1 d-inline-block">DISK: '.$disk.'GB</strong>
                                                    </span>
                                                    </li>

                                                    <li class="d-flex align-items-center mb-3">
                                                    <span class="me-2">
                                                        <!-- icon home --> 
                                                        <i class="ri-home-4-fill fs-15 text-success"></i>
                                                    </span>
                                                    <span>
                                                        <strong class="me-1 d-inline-block">IP: '.$ip. '</strong>
                                                    </span>
                                                    </li>


                                                    <li class="d-flex align-items-center mb-3">
                                                    <span class="me-2">
                                                        <!-- icon os --> 
                                                        <i class="ri-window-line fs-15 text-success"></i>
                                                    </span>
                                                    <span>
                                                        <strong class="me-1 d-inline-block">OS: '.$os. '</strong>
                                                    </span>
                                                    </li>

                                                    <li class="d-flex align-items-center mb-3">
                                                    <span class="me-2">
                                                        <!-- icon server --> 
                                                        <i class="ri-server-fill fs-15 text-success"></i>
                                                    </span>
                                                    <span>
                                                        <strong class="me-1 d-inline-block">Băng thông: '.$bandwidth. '</strong>
                                                    </span>
                                                    </li>
                                                   
                                                    <li class="d-grid">
                                                        <button onClick="checkout('.$product_id.')" class="btn btn-light btn-wave waves-effect waves-light">Chọn</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                }
                                echo '</div>';
                                echo '</div>';


                            }

                        }





                    ?>


                </div>

                 
            </div>
        </div>
       
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

    <!-- Custom JS -->
    <script src="../assets/js/custom.js"></script>
    <script src="../js/vps_vietnam.js"></script>

</body>

</html>