<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="dark" data-toggled="close">
<?php
$title_site = "Trang quản lý dịch vụ";

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

    

    <!-- Loader -->
    <div id="loader">
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Dịch vụ của tôi</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">VPS Vietnam</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Danh sách VPS Việt Nam</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <!-- Start::row-1 -->
                <div class="btn-list">

                    <button type="button" class="btn btn-success-light rounded-pill btn-wave" onClick="filterStatus('Đang chạy')">Đang sử dụng</button>
                    <button type="button" class="btn btn-info-light rounded-pill btn-wave" onClick="filterStatus('Hết hạn')">Đã hết hạn</button>
                    <button type="button" class="btn btn-purple-light rounded-pill btn-wave" onClick="filterStatus('Hủy')">Hủy</button>
                    <button type="button" class="btn btn-purple-light rounded-pill btn-wave" onClick="filterStatus('Lỗi đơn')">Xóa</button>
                    <button type="button" class="btn btn-warning-light rounded-pill btn-wave" onClick="filterStatus('Đang chuyển')">Chuyển</button>
                    <button type="button" class="btn btn-danger-light rounded-pill btn-wave" onClick="filterStatus('Đã tắt')">Đã tắt</button>
                    <button type="button" class="btn btn-orange-light rounded-pill btn-wave" onClick="resetFilter()">Tất cả VPS</button>
                </div> <br>
                <div class="card custom-card">

                    <div class="card-header">
                        <div class="card-title">Quản lý VPS</div>
                    </div>
                    <div class="card-body">
                        <div class="btn-list">

                            <div class="btn-group">
                                <!-- btn tạo vps -->
                                <button type="button" class="btn btn-primary" data-bs-target="#createVPSModal"
                                    onClick=" window.location.href ='../vps_vietnam?plan=0'">Tạo VPS</button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="defaultDropdown"
                                    data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                    Hành động với VPS
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                    <li><a class="dropdown-item" onClick="sendActionVPS('on')">Bật</a></li>
                                    <li><a class="dropdown-item" onClick="sendActionVPS('off')">Tắt</a></li>
                                    <li><a class="dropdown-item" onClick="sendActionVPS('restart')">Khởi động lại</a>
                                    </li>
                                    <li><a class="dropdown-item" onClick="sendActionVPS('cancel')">Hủy</a></li>
                                    <li><a class="dropdown-item" onClick="xoa_vps()">Xóa</a></li>
                                    <li><a class="dropdown-item" onClick="autoRenewAllVPSSelected('on')">Tự động gia
                                            hạn</a></li>
                                    <li><a class="dropdown-item" onClick="autoRenewAllVPSSelected('off')">Tắt tự động
                                            gia hạn</a></li>
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#formmodal"
                                            data-bs-whatever="@mdo">Chỉnh sửa ghi chú</a></li>

                                </ul>
                            </div>

                            <div class="btn-group">
                                <!-- btn tạo vps -->
                                <button type="button" onClick="reinstallOS()" class="btn btn-warning"
                                    data-bs-toggle="modal" data-bs-target="#exampleModalScrollable4">
                                    Cài lại hệ điều hành
                                </button>


                            </div>

                            <div class="btn-group">
                                <!-- nâng cấp vps -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalScrollable3" onClick="nang_cap_vps()">
                                    Nâng cấp VPS
                                </button>

                            </div>

                            <div class="btn-group">
                                <!-- btn gia hanj vps -->
                                <button type="button" class="btn btn-secondary mb-1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalFullscreenSm" onClick="renewVPS()">Gia hạn VPS</button>


                            </div>

                            <div class="btn-group">
                                <!-- Input tìm kiếm -->
                                <input type="text" class="form-control" placeholder="Tìm kiếm..." id="inputFind">
                                <button type="button" class="btn btn-primary" onClick="findItem()">Tìm</button>
                            </div>

                            
                            <div class="btn-group">
                               
                                <button type="button" class="btn btn-primary" onClick="window.location.reload()">Làm mới</button>
                            </div>

                        </div>

                        
                        <div class="modal fade" id="formmodal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalLabel">Chỉnh sửa ghi chú</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                        
                                            <div class="mb-3">
                                                <label for="message-text" class="col-form-label">Ghi chú mới:</label>
                                                <textarea class="form-control" id="messageNote"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-primary" onClick="submit_editNote()">Chỉnh sửa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModalFullscreenSm" tabindex="-1"
                            aria-labelledby="exampleModalFullscreenSmLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-fullscreen-sm-down">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="titleGiaHanVPS">
                                            Đang gia hạn cho VPS...</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- SELECTED subcription -->
                                        <select class="form-select" id="selectGiaHanVPS">
                                            <option selected>Chọn thời gian gia hạn</option>

                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal" id="btnCancelGiaHanVPS">Đóng</button>

                                        <button type="button" class="btn btn-primary" onClick="submit_renewVPS()">Xác
                                            nhận</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModalScrollable4" tabindex="-1"
                            aria-labelledby="exampleModalScrollable4" data-bs-keyboard="false" aria-hidden="true">
                            <!-- Scrollable modal -->
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="staticBackdropLabel4">Cài lại hệ điều hành
                                        </h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <h5 id="title_reinstall_os">Cài lại hệ điều hành cho ...</h5>
                                        <!-- <p>This <a href="javascript:void(0);" role="button"
                                                        class="btn btn-secondary" data-bs-toggle="popover"
                                                        title="Popover title"
                                                        data-bs-content="Popover body content is set in this attribute.">button</a>
                                                    triggers a popover on click.</p> -->
                                        <code>Chọn hệ điều hành bạn muốn cài lại</code>
                                        <!-- SELECT BOX -->
                                        <select class="form-select" aria-label="Chọn hệ điều hành" id="os_id">
                                            <option selected>Chọn hệ điều hành</option>

                                        </select>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="btnCancelReinstallVPS" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="button" class="btn btn-primary" onClick="submit_reinstallOS()">Xác
                                            nhận cài lại</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">

                            <table class="table text-nowrap" id="tableRenderVPS">
                                <thead>
                                    <tr>
                                        <th scope="col"><input class="form-check-input" type="checkbox"
                                                id="checkboxNoLabel" value="" aria-label="..."></th>
                                        <th scope="col">IP</th>
                                        <th scope="col">MẬT KHẨU</th>
                                        <th scope="col">CẤU HÌNH</th>
                                        <th scope="col">HỆ ĐIỀU HÀNH</th>
                                        <th scope="col">NGÀY KẾT THÚC</th>
                                        <th scope="col">THỜI GIAN THUÊ</th>
                                        <th scope="col">CHI PHÍ</th>
                                        <th scope="col">GHI CHÚ</th>
                                        <th scope="col">TRẠNG THÁI</th>
                                        <th scope="col">TỰ ĐỘNG GIA HẠN</th>

                                    </tr>
                                </thead>
                                <tbody id="tableVPS">


                                    <?php 
                  $isDisabled = false;
                  $allOrders = getOrderVPSVNByUserEmail($userInfo["email"]);
                  $id_vps = 0;
                  foreach ($allOrders as $order) {
                    
                   
                    $productInfo = getInfoVPSById($order["product_id"])["product"];
                    if($productInfo == null) continue;
                    if($productInfo["gpu"] > 0) {
                        $cauhinh .= ", " . $productInfo["gpu"] . " GPU";
                    }
                    $os_info = getOSById($order["os_id"]);

                    if($os_info == false) {
                        continue;
                    }

                    $os_info = $os_info["os-name"];
                
                    $cauhinh = $order["cpu"]. " CPU, " . $order["ram"]. " RAM, " . $order["disk"]. " GB";
                 
                    $thoi_gian_thue = $order["billing_cycle"];
                    if($thoi_gian_thue == "monthly") {
                        $thoi_gian_thue = "Hàng tháng";
                    } else if($thoi_gian_thue == "quarterly") {
                        $thoi_gian_thue = "Hàng quý";
                    } else if($thoi_gian_thue == "semi_annually") {
                        $thoi_gian_thue = "Hàng 6 tháng";
                    } else if($thoi_gian_thue == "annually") {
                        $thoi_gian_thue = "Hàng năm";
                    } else {
                        $thoi_gian_thue = "Không xác định";
                    }
                    $id_vps = $order["id_vps"];
                    $ip = $order["ip"];
                    $username = $order["username"];
                    $password = $order["password"];
                    $note = $order["note"];
                    
                    $vps_status = getVPSStatusHTML($order["vps_status"]);
                   
                   
                    
                    echo '<tr id="vps_'.$id_vps.'" ip_vps="'.$ip.'">';
                    echo '<th scope="row"><input class="form-check-input" type="checkbox" id="vps_so_'.$id_vps.'" value="'. $id_vps. '" aria-label="..."></th>';
                    echo '<td id="vps_ip_id_'.$id_vps.'">' . $ip . '</td>';
                    echo '<td id="vps_password_id_'.$id_vps.'">' . $password . '</td>';
                    echo '<td>' . $cauhinh . '</td>';
                    echo '<td id="vps_os_name_id_'.$id_vps.'">' . $os_info . '</td>';
                    echo '<td>' . ($order["next_due_date"] == '' ? 'Chưa cập nhật' : $order["next_due_date"]) . '</td>';
                    echo '<td>' . $thoi_gian_thue . '</td>';
                    echo '<td>' . number_format($order["pricing"]) . ' VNĐ</td>';
                    echo '<td id="vps_note_id_'.$id_vps.'">' . $note . '</td>';
                    echo '<td id="vps_status_id_'.$id_vps.'">' . $vps_status . '</td>';
                    echo '<td id="vps_autorenew_id_'.$id_vps.'">' . getAutoRenewHTML($order["auto_renew"]) . '</td>';
                
                    echo '</tr>';

                  }

                ?>

                                </tbody>
                            </table>
                            <div id="infoTableVPS">

                            </div>
                        </div>
                        <p id="infoSelected">hihi</p>
                    </div>
                   
                </div>
                <!--End::row-1 -->
                
            </div>
        </div>
        <!-- End::app-content -->

        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="input-group">
                            <a href="javascript:void(0);" class="input-group-text" id="Search-Grid"><i
                                    class="fe fe-search header-link-icon fs-18"></i></a>
                            <input type="search" class="form-control border-0 px-2" placeholder="Search"
                                aria-label="Username">
                            <a href="javascript:void(0);" class="input-group-text" id="voice-search"><i
                                    class="fe fe-mic header-link-icon"></i></a>
                            <a href="javascript:void(0);" class="btn btn-light btn-icon" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fe fe-more-vertical"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <p class="font-weight-semibold text-muted mb-2">Are You Looking For...</p>
                            <span class="search-tags alert"><i class="fe fe-user me-2"></i>People<a
                                    href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert"><i
                                        class="fe fe-x"></i></a></span>
                            <span class="search-tags alert"><i class="fe fe-file-text me-2"></i>Pages<a
                                    href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert"><i
                                        class="fe fe-x"></i></a></span>
                            <span class="search-tags alert"><i class="fe fe-align-left me-2"></i>Articles<a
                                    href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert"><i
                                        class="fe fe-x"></i></a></span>
                            <span class="search-tags alert"><i class="fe fe-server me-2"></i>Tags<a
                                    href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert"><i
                                        class="fe fe-x"></i></a></span>
                        </div>
                        <div class="my-4">
                            <p class="font-weight-semibold text-muted mb-2">Recent Search :</p>
                            <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                                <a href="notifications.html"><span>Notifications</span></a>
                                <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert"
                                    aria-label="Close"><i class="fe fe-x text-muted"></i></a>
                            </div>
                            <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                                <a href="alerts.html"><span>Alerts</span></a>
                                <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert"
                                    aria-label="Close"><i class="fe fe-x text-muted"></i></a>
                            </div>
                            <div class="p-2 border br-5 d-flex align-items-center text-muted mb-0 alert">
                                <a href="mail.html"><span>Mail</span></a>
                                <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert"
                                    aria-label="Close"><i class="fe fe-x text-muted"></i></a>
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

        <?php include_once('../adv_page/footer.php') ?>
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
    <script src="../js/my_service.js"></script>
</body>

</html>