
<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">
<?php include_once('../config.php'); ?>
<?php include_once('../page/head.php') ?>

<body>

    <?php include_once('../page/switcher.php') ?>

    <div class="container-lg">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="my-5 d-flex justify-content-center">
                    <a href="">
                        <img src="../img/white_border_logo.png" alt="logo" class="desktop-logo">
                        <img src="../img/dark_border_logo.png" alt="logo" class="desktop-dark">
                    </a>
                </div>
                <div class="card custom-card">
                    <div class="card-body p-5">
                        <p class="h5 fw-semibold mb-2 text-center">Đăng ký</p>
                        <p class="mb-4 text-muted op-7 fw-normal text-center">Hãy tiến hành đăng ký tài khoản để có thể sử dụng dịch vụ của chúng tôi!</p>
                        <p class="mb-4 text-muted op-7 fw-normal" id="message_alert"></p>
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <label for="signup-firstname" class="form-label text-default">Tên tài khoản</label>
                                <input type="text" class="form-control form-control-lg" id="username" placeholder="Nhập username">
                            </div>


                            <div class="col-xl-12">
                                <label for="signup-email" class="form-label text-default">Email</label>
                                <input type="email" class="form-control form-control-lg" id="email" placeholder="Nhập email">
                            </div>
                         
                            <div class="col-xl-12">
                                <label for="signup-password" class="form-label text-default">Mật khẩu</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg" id="signup-password" placeholder="Nhập mật khẩu">
                                    <button class="btn btn-light" onclick="createpassword('signup-password',this)" type="button" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label for="signup-confirmpassword" class="form-label text-default">Nhập lại mật khẩu</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg" id="signup-confirmpassword" placeholder="Nhập lại mật khẩu">
                                    <button class="btn btn-light" onclick="createpassword('signup-confirmpassword',this)" type="button" id="button-addon21"><i class="ri-eye-off-line align-middle"></i></button>
                                </div>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                        Việc tạo tài khoản là bạn đã chấp nhận <a href="../page/chinh_sach.php" class="text-success"><u>điều khoản và điều kiện</u></a> cũng như <a class="text-success"><u>chính sách bảo mật</u></a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-12 d-grid mt-2">
                                <button class="btn btn-lg btn-primary" id="register_btn">Tạo tài khoản</button>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="fs-12 text-muted mt-3">Bạn đã có tài khoản <a href="../auth/sign-in" class="text-primary">đăng nhập</a></p>
                        </div>
                        <div class="text-center my-3 authentication-barrier">
                            <span>OR</span>
                        </div>
                        <div class="btn-list text-center">
                         
                            <button onClick="window.location.href='./google_auth.php'" class="btn btn-icon btn-light">
                                <i class="ri-google-line fw-bold text-dark op-7"></i>
                            </button>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Show Password JS -->
    <script src="../assets/js/show-password.js"></script>

    <!-- page script -->
    <script src="../js/alert.js"></script>
    <script src="../js/sign_up.js"></script>

</body>

</html>