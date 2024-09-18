<?php

// config database
$username = "root";
$password = "";
$server = "localhost";
$dbname = "ahexvps";
$pass_cron = "tronghoa2069";


$adminEmail = "";

// cloudhub api setup
$apiUsername = "<CLOUD_HUB_USERNAME>";
$apiApp = "<APP_ID_CLOUD_HUB>";
$apiSecret = "<SECRET_CLOUD>";
$anChenhGia = 0; // muốn ăn chênh 10k thì thì điền 10000 , khi đó giá sản phẩm sẽ tăng 10k so với giá trong api
$max_core_up = 16; // gb
$max_ram_up = 16; // gb
$max_disk_up = 200; // gb

// config site
$site_name = "AHEX VPS";
$description = "AHEX VPS - Chuyên cung cấp các loại vps abcxyz";
$tag_seo = "ahex, vps, vps cloud, cloud vps, server, hosting";
$icon_site = "../img/favicon.ico";
$white_border_logo = "../img/white_border_logo.png";
$dark_border_logo = "../img/dark_border_logo.png";
$primaryRGB = "34, 155, 234";

$proxy_address = "103.65.234.88:6969";


$notication = '

<div class="card">
<img src="../img/banner_noticaiton.jpg" class="card-img-top img-fluid" alt="...">
    <div class="card-body">
        
        <p class="card-text">AHEXVPS.COM là một nền tảng cung cấp VPS giá rẻ và chất lượng, luôn đặt uy tín lên hàng đầu. Do mới lập ra không lâu, do đó trong quá trình sử dụng
        bạn có thể sẽ gặp một số lỗi vặt, mong bạn thông cảm và báo cho chúng tôi để chúng tôi khắc phục sớm nhất có thể. Chúc bạn sử dụng vui vẻ!
        </p>
    </div>
</div>
';

// card config (thesieure or another site)
$partner_id = "<PARTNER_ID>";
$partner_key = "<PARTNER_KEY";
$url_charge = "https://thesieure.com/chargingws/v2?sign="; // CUSTOM IF YOU WANT TO USE ANOTHER SITE
$chietkhau_default = 20; // 20% default

// email config
$smtpHost = "smtp.gmail.com"; // mail server
$smtpPort = 465; // port
$smtpUser = "<YOUR_EMAIL>"; // email
$smtpPass = "<YOUR_PASSWORD>"; // password
$smtpSecure = "ssl"; // secure


// auth (gmail regiser) setting
$client_id_google = "<YOUR_CLIENT>"; // client id
$client_secret_google = "<YOUR_SECRET>"; // client secret
$redirectUri_google = "<YOUR_REDIRECT_URI>"; // redirect uri


// cooldown setting (second)
$cooldownVerifySendMail = 15;
$cooldownUploadAvatar = 84600;
$cooldownChangeProfileInfo = 120;
$cooldownChangePassword = 120;
$cooldownNapthe = 120;
$cooldownCronVPSStatus = 5;
// bank config
$mbbank_cron_url = "<cron mbbank>";
$mbbank_number = "123123"; // bank number
$mbbank_account_name = "NGUYEN VAN A";
$min_payment = 50000; // min pay
?>