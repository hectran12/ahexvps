<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="light" data-toggled="close">

<?php include_once('../config.php'); ?>
<?php include_once('../page/head.php') ?>

<?php
$notDirectVerify = true;
include_once('user.php');

include_once('../security/utils.php');
include_once('../helper/time.php');
include_once('utils.php');
include_once('verify_utils.php');
include_once('../helper/mail.php');
include_once('../helper/string.php');
include_once('../email/utils.php');

if($userInfo["isVerify"]) {
    die('<script>
    alert("Tài khoản của bạn đã được xác thực!");
    window.location.href = "/home";
    </script>');
} else {
    $acceptReq = acceptRequestTime($userInfo, $cooldownVerifySendMail, "verify_email");


    $code = $_GET["code"] ?? null;

    if($code != null && checkInjection($code)) {
        // check number
        if(strlen($code) != 4) {
            die('<script>
            alert("Mã xác thực không hợp lệ!");
            window.location.href = "/auth/verify";
            </script>');
        }


        if(is_numeric($code)) {
            $isCheck = checkVerify($userInfo["email"], $code);
            if($isCheck) {
                editVerify($userInfo["email"], 1);
                die('<script>
                alert("Xác thực tài khoản thành công!");
                window.location.href = "/home";
                </script>');
            } else {
                die('<script>
                alert("Mã xác thực không hợp lệ!");
                window.location.href = "/auth/verify";
                </script>');
            }
        } else {
            die('<script>
            alert("Mã xác thực không hợp lệ!");
            window.location.href = "/auth/verify";
            </script>');
        }
    }

    if($acceptReq == false) {
        if(isset($_GET["resend"])) {
            $isResend = $_GET["resend"];
            if($isResend == "check") {
                echo ('<script>
                alert("Vui lòng chờ '.$cooldownVerifySendMail.' giây để gửi lại mã xác thực!");
                </script>');
            }   
        }
       
    } else {
        updateTimeRequestServer($userInfo, "verify_email");
        $code = createSessionVerify($userInfo["email"]);
        $htmlMessageBody = create_mail_verify_account($code);
        sendEmail($userInfo["email"], "Xác thực tài khoản", $htmlMessageBody);
    }
   
}




?>


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
                        <p class="mb-4 text-muted op-7 fw-normal" id="message_alert"></p>
                        <p class="h5 fw-semibold mb-2 text-center">Xác thực tài khoản</p>
                        <p class="mb-4 text-muted op-7 fw-normal text-center">Vui lòng nhập mã để xác thực tài khoản.</p>
                        <div class="row gy-3">
                            <div class="col-xl-12 mb-2">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control form-control-lg text-center" id="one" maxlength="1" onkeyup="clickEvent(this,'two')">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control form-control-lg text-center" id="two" maxlength="1" onkeyup="clickEvent(this,'three')">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control form-control-lg text-center" id="three" maxlength="1" onkeyup="clickEvent(this,'four')">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control form-control-lg text-center" id="four" maxlength="1">
                                    </div>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                    <label class="form-check-label" for="defaultCheck1">
                                        Bạn không nhập được code ?<a href="?resend=check" class="text-primary ms-2 d-inline-block">gửi lại</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-12 d-grid mt-2">
                                <button id="btnSubmitVerify" class="btn btn-lg btn-primary">Xác thực</a>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="fs-12 text-danger mt-3 mb-0"><sup><i class="ri-asterisk"></i></sup>Không được share mã xác thực cho bất kì ai!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Internal Two Step Verification JS -->
    <script src="../assets/js/two-step-verification.js"></script>
    <script src="../js/alert.js"></script>
    <script src="../js/verify.js"></script>

</body>

</html>