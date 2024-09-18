
<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">
<?php
$title_site = "Trang cá nhân";

?>
<?php 
    include_once('../config.php');
    include_once('../auth/user.php');
    include_once('../helper/role.php');
    include_once('../helper/money.php');
    
    echo '<script>var logs = '.json_encode(getLogsByEmail($userInfo["email"])).'</script>';

    

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
    <?php include_once('../adv_page/header.php'); ?>
        <!-- Start::app-sidebar -->
    <?php include_once('../adv_page/aside.php'); ?>
        <!-- End::app-sidebar -->

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">Profile</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">View</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <!-- Start::row-1 -->
                <div class="row">
                    <div class="col-xxl-4 col-xl-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body p-0">
                                <div class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                                    <div>
                                        <span class="avatar avatar-xxl avatar-rounded online me-3">
                                            <img src="<?php
                            if($userInfo["base64_avt"] == null) {
                                echo "../img/default_avt.jpg";
                            } else {
                                echo $userInfo["base64_avt"];
                            }
                        
                        ?>" alt="">
                                        </span>
                                    </div>
                                    <div class="flex-fill main-profile-info">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h6 class="fw-semibold mb-1 text-fixed-white"><?= $userInfo["username"]; ?></h6>
                                           
                                            
                                        </div>
                                        <p class="mb-1 text-muted text-fixed-white op-7"><?= getRole($userInfo, $adminEmail); ?></p>
                                       
                                    </div>
                                </div>
                            
                                <div class="p-4 border-bottom border-block-end-dashed">
                                    <p class="fs-15 mb-2 me-4 fw-semibold">Thông tin tài khoản:</p>
                                    <div class="text-muted">
                                        <p class="mb-2">
                                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                               
                                                <i class="ri-money-dollar-box-line align-middle fs-14"></i>
                                            </span>
                                            <?= number_format($userInfo["money"], 0, ',', '.'); ?> VNĐ
                                        </p>
                                        <p class="mb-2">
                                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                <i class="ri-mail-line align-middle fs-14"></i>
                                            </span>
                                            <?= $userInfo["email"]; ?>
                                        </p>
                                        
                                        <p class="mb-0">
                                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                                <!-- icon home -->
                                                <i class="ri-home-4-line align-middle fs-14"></i>
                                            </span>
                                     <?= $userInfo["address"] == null ? "Chưa cập nhật" : $userInfo["address"] ?>
                                        </p>

                                      
                                        
                                    </div>
                                </div>
                         
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-8 col-xl-12">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-body p-0">
                                        <div class="p-3 border-bottom border-block-end-dashed d-flex align-items-center justify-content-between">
                                            <div>
                                                <ul class="nav nav-tabs mb-0 tab-style-6 justify-content-start" id="myTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="activity-tab" data-bs-toggle="tab"
                                                            data-bs-target="#activity-tab-pane" type="button" role="tab"
                                                            aria-controls="activity-tab-pane" aria-selected="true">
                                                            
                                                            <!-- icon profile --> 
                                                            <i class="ri-user-3-line me-1 align-middle d-inline-block"></i>
                                                            Thông tin</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="posts-tab" data-bs-toggle="tab"
                                                            data-bs-target="#posts-tab-pane" type="button" role="tab"
                                                            aria-controls="posts-tab-pane" aria-selected="false">
                                                            <!-- icon password --> 
                                                            <i class="ri-lock-password-line me-1 align-middle d-inline-block"></i>
                                                            Mật khẩu</button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="followers-tab" data-bs-toggle="tab"
                                                            data-bs-target="#followers-tab-pane" type="button" role="tab"
                                                            aria-controls="followers-tab-pane" aria-selected="false">
                                                            <!-- icon log--> 
                                                            <i class="ri-clipboard-line me-1 align-middle d-inline-block"></i>
                                                            Nhật ký hoạt động</button>
                                                    </li>
                                                   
                                                </ul>
                                            </div>   
                                       
                                        </div>
                                        <div class="p-3">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane show active fade p-0 border-0" id="activity-tab-pane"
                                                    role="tabpanel" aria-labelledby="activity-tab" tabindex="0">


                                                    <!-- setting profile --> 
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="card-title">Chỉnh sửa ảnh hồ sơ</div>
                                                        </div>
                                                        <div class="card-body">
                                                            <label for="input-file"  class="form-label">Upload ảnh tại đây (lưu ý: ảnh được lưu vào imgbb.com, một dịch vụ chia sẻ ảnh miễn phí và công cộng. Vui lòng không up ảnh quá cá nhân)</label>
                                                            <input class="form-control" type="file" id="input-file">
                                                            <br>
                                                            <span class="avatar avatar-xxl me-2 avatar-rounded">
                                                                <img id="avtImg" src="<?php
                                                                    if($userInfo["base64_avt"] == null) {
                                                                        echo "../img/default_avt.jpg";
                                                                    } else {
                                                                        echo $userInfo["base64_avt"];
                                                                    }
                                                                
                                                                ?>" alt="img">
                                                            </span>
                                                            <br>
                                                            <button id="actionUploadImage" class="btn btn-primary">Chỉnh sửa</button>
                                                        </div>
                                                    </div>
                                                    

                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div class="card-title">Chỉnh sửa thông tin cá nhân</div>
                                                        </div>
                                                       
                                                        <div class="card-body">
                                                            
                                                            <div class="col-xl-12">
                                                                <label for="input-noradius" class="form-label">Username</label>
                                                                <input type="text" class="form-control rounded-0" id="username" placeholder="Nhập username" value="<?=$userInfo["username"];?>">
                                                            </div>
                                                            
                                                            <br>
                                                            <div class="col-xl-12">
                                                                <label for="input-noradius" class="form-label">Email</label>
                                                                <input type="text" class="form-control rounded-0" id="email" placeholder="Nhập email" value="<?=$userInfo["email"];?>" disabled>
                                                            </div>
                                                            <br> 
                                                            
                                                            <div class="col-xl-12">
                                                                <label for="input-noradius" class="form-label">Số điện thoại</label>
                                                                <input type="text" class="form-control rounded-0" id="phoneNumber" placeholder="<?=$userInfo["phoneNumber"] == null ? 'Chưa cập nhật' : $userInfo["phoneNumber"] ?>" value="<?=$userInfo["phoneNumber"] == null ? '' : $userInfo["phoneNumber"];?>">
                                                            </div>
                                                            <br>


                                                            <div class="col-xl-12">
                                                                <label for="input-noradius" class="form-label">Địa chỉ</label>
                                                                <input type="text" class="form-control rounded-0" id="address" placeholder="<?=$userInfo["address"] == null ? 'Chưa cập nhật' : $userInfo["address"] ?>" value="<?=$userInfo["address"] == null ? '' : $userInfo["address"];?>">
                                                            </div>
                                                            <br>

                                                            <div class="col-xl-12">
                                                                <label for="input-noradius" class="form-label">IP tạo tài khoản</label>
                                                                <input type="text" class="form-control rounded-0" id="ipaddress" placeholder="<?=$userInfo["ip"];?>" value="<?=$userInfo["ip"];?>" disabled>
                                                            </div>
                                                            <br>
                                                            
                                                            <div class="col-xl-12">
                                                                <label for="input-noradius" class="form-label">User-Agent đăng nhập</label>
                                                                <input type="text" class="form-control rounded-0" id="userAgent" placeholder="<?=$userInfo["useragent"];?>" value="<?=$userInfo["useragent"];?>" disabled>
                                                            </div>
                                                            <br>
                                                            <button id="actionEditInfo" class="btn btn-primary">Chỉnh sửa</button>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="tab-pane fade p-0 border-0" id="posts-tab-pane"
                                                    role="tabpanel" aria-labelledby="posts-tab" tabindex="0">
                                                    <div class="card">
                                                            <div class="card-header">
                                                                <div class="card-title">Thay đổi và thiết lập mật khẩu</div>
                                                            </div>
                                                            <div class="card-body">
                                                                <label for="exampleInputPassword1" class="form-label">Mật khẩu mới</label>
                                                                <input type="password" class="form-control" id="newPassword">
                                                                <br>
                                                                <label for="exampleInputPassword1" class="form-label">Nhập lại mật khẩu mới</label>
                                                                <input type="password" class="form-control" id="reInputNewPassword">
                                                                <br>
                                                                <div class="alert alert-secondary" role="alert">
                                                                    Sau khi xác nhận đổi mật khẩu, bạn sẽ được yêu cầu xác thực lại tài khoản!
                                                                </div>
                                                                <button type="button" id="submitNewPassword" class="btn btn-secondary btn-wave">Đổi mật khẩu</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <div class="tab-pane fade p-0 border-0" id="followers-tab-pane"
                                                    role="tabpanel" aria-labelledby="followers-tab" tabindex="0">
                                                    <div class="card">
                                            <div class="card-header justify-content-between">
                                                <div class="card-title">
                                                    Nhật ký hoạt động
                                                </div>
                                                <div class="dropdown">
                                                    <button onClick="getLogs(true, false)" class="p-2 fs-12 text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Xem toàn bộ<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                                                </button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><button class="dropdown-item" onClick="getLogs(false, true)">Hôm nay</button></li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div>
                                                    <ul class="list-unstyled mb-0 crm-recent-activity" id="renderLogs">
                                                        <!-- <li class="crm-recent-activity-content">
                                                            <div class="d-flex align-items-top">
                                                                <div class="me-3">
                                                                    <span class="avatar avatar-xs bg-primary-transparent avatar-rounded">
                                                                        <i class="bi bi-circle-fill fs-8"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="crm-timeline-content">
                                                                    <span class="fw-semibold">Update of calendar events &amp;</span><span><a href="javascript:void(0);" class="text-primary fw-semibold"> Added new events in next week.</a></span>
                                                                </div>
                                                                <div class="flex-fill text-end">
                                                                    <span class="d-block text-muted fs-11 op-7">4:45PM</span>
                                                                </div>
                                                            </div>
                                                        </li> -->
                                                      
                                                    </ul>
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
    
    <!-- Gallery JS -->
    <script src="../assets/libs/glightbox/js/glightbox.min.js"></script>

    <!-- Internal Profile JS -->
    <script src="../assets/js/profile.js"></script>

    <!-- Custom JS -->
    <script src="../assets/js/custom.js"></script>

    <script src="../js/alert.js"></script>
    <script src="../js/profile.js"></script>
    

</body>

</html>