
<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">
<?php include_once('../config.php'); ?>
<?php include_once('../page/head.php') ?>

<body>

    <?php include_once('../page/switcher.php') ?>

    <div class="container">
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
                        <p class="h5 fw-semibold mb-2 text-center">Đăng nhập</p>
                        <p class="mb-4 text-muted op-7 fw-normal text-center">Chào mừng trở lại, vui lòng đăng nhập!</p>
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">Email</label>
                                <input type="email" class="form-control form-control-lg" id="signin-email" placeholder="Nhập email" >
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label for="signin-password" class="form-label text-default d-block">Mật khẩu<a href="../auth/forget_password" class="float-end text-danger">Quên mật khẩu ?</a></label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg" id="signin-password" placeholder="password">
                                    <button class="btn btn-light" type="button" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                </div>
                                <div class="mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                            Ghi nhớ mật khẩu?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 d-grid mt-2">
                                <button id="btnLogin" class="btn btn-lg btn-primary">Đăng nhập</button>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="fs-12 text-muted mt-3">Bạn không có tài khoản? <a href="../auth/sign-up" class="text-primary">đăng ký</a></p>
                        </div>
                        <div class="text-center my-3 authentication-barrier">
                            <span>OR</span>
                        </div>
                        <div class="btn-list text-center">
                         
                            <button onClick="window.location.href='../auth/google_auth.php';" class="btn btn-icon btn-light">
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
    <script src="../js/sign_in.js"></script>

</body>

</html>