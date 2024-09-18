
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
                    <h1 class="page-title fw-semibold fs-18 mb-0">Nạp tiền thẻ cào</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Nạp tiền</a></li>
                                <li class="breadcrumb-item active" aria-current="page">thẻ cào</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <!-- Start::row-1 -->
                <div class="row justify-content-center mb-5">
                  
                    <div class="col-xl-10">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card custom-card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            Nạp thẻ
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted">Loại thẻ</p>
                                        <select class="form-select" aria-label="Default select example" id="telco" >
                                            <option selected> -- Chọn loại thẻ -- 
                                            </option> 
                                            <option value="VIETTEL" >Viettel</option>
                                            <option value="VINAPHONE">Vinaphone</option>
                                            <option value="MOBIFONE">Mobifone</option>
                                            <option value="VNMOBI">Vietnammobile</option>
                                            <option value="ZING">Zing</option>
                                          
                                        </select><br> 
                                        <p class="text-muted">Mệnh giá</p>
                                        <select class="form-select" aria-label="Default select example" id="price">
                                            <option value="">-- Chọn mệnh giá --</option>
                                            <option value="10000">10.000đ</option>
                                            <option value="20000">20.000đ</option>
                                            <option value="30000">30.000đ</option>
                                            <option value="50000">50.000đ</option>
                                            <option value="100000">100.000đ</option>
                                            <option value="200000">200.000đ</option>
                                            <option value="300000">300.000đ</option>
                                            <option value="500000">500.000đ</option>
                                            <option value="1000000">1.000.000đ</option>
                                            <option value="2000000">2.000.000đ</option>
                                        </select><br>

                                        <p class="text-muted">Mã thẻ</p>
                                        <input type="text" class="form-control rounded-0" id="code" placeholder="Nhập mã thẻ">
                                        <br>
                                        <p class="text-muted">Seri</p>
                                        <input type="text" class="form-control rounded-0" id="seri" placeholder="Nhập seri">
                                        <br>
                                        <button type="button" id="btnCharge" class="btn btn-secondary btn-wave">Nạp tiền</button>
                                    </div>
                                </div>
                             </div>  
                            <div class="col-xl-6">
                                <div class="card custom-card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            Lịch sử nạp thẻ
                                        </div>
                                    </div>
                                    <div class="card-body">
                                    <div class="table-responsive">
                                      <table class="table text-nowrap">
                                          <thead>
                                              <tr>
                                                  <th scope="col">ID</th>
                                                  <th scope="col">Loại</th>
                                                  <th scope="col">Mã thẻ</th>
                                                  <th scope="col">Serial</th>
                                                  <th scope="col">Mệnh giá</th>
                                                  <th scope="col">Thực nhận</th>
                                                  <th scope="col">Thời gian</th>
                                                  <th scope="col">Trạng thái</th>
                                              </tr>
                                          </thead>
                                          <tbody id="listcard">
                                           
                                          </tbody>
                                      </table>
                                    
                                  </div>  <br>
                                  <input type="number" class="form-control rounded-0" id="page" placeholder="Nhập trang" min="1" max="2">
                                    </div>
                                </div>
                             </div>  
                        
                        </div>
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
        <?php include_once('../adv_page/footer.php') ?>

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
    <script src="../js/update_card.js"></script>

</body>

</html>