<?php


    function create_mail_verify_account ($code) {
        global $site_name;
        $message = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>['.$site_name.'] Xác thực tài khoản</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                h2 {
                    color: #333;
                }
                p {
                    color: #666;
                }
                .code-box {
                    background-color: #f5f5f5;
                    padding: 10px;
                    margin-bottom: 20px;
                    border-radius: 6px;
                }
                .code {
                    color: #3366cc;
                    font-weight: bold;
                    font-size: 18px;
                }
                .logo {
                    max-width: 150px;
                    margin-bottom: 20px;
                }
                .banner {
                    margin-top: 40px;
                    padding: 20px;
                    background-color: #3366cc;
                    border-radius: 8px;
                    text-align: center;
                }
                .banner-text {
                    color: #fff;
                    font-size: 18px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <img class="logo" src="https://raw.githubusercontent.com/hectran12/AHEXVPS_StoragePublic/main/img_test/dark_border_logo.png" alt="Logo">
                <h2>Xác thực tài khoản</h2>
                <p>Xin chào,</p>
                <p>Bạn vừa yêu cầu xác thực tài khoản của mình. Đây là mã xác thực của bạn:</p>
                <div class="code-box">
                    <h3 style="margin-top: 0;">Mã xác thực: <span class="code">{{code}}</span></h3>
                </div>
                <p>Vui lòng sao chép mã này và dán vào trang web để hoàn tất quá trình xác thực.</p>
                <p>Nếu bạn không yêu cầu xác thực này, xin vui lòng bỏ qua email này.</p>
                <p>Trân trọng,</p>
                <p>'. $site_name . '</p>
            </div>
            <div class="banner">
                <p class="banner-text">Liên hệ với chúng tôi nếu bạn cần trợ giúp thêm</p>
                <img src="https://raw.githubusercontent.com/hectran12/AHEXVPS_StoragePublic/main/img_test/Picsart_24-04-29_14-10-06-196.jpg" width="600px">
            </div>
           
        </body>
        </html>
        ';
        $message = str_replace('{{code}}', $code, $message);
        return $message;
    }


    function create_mail_infomation_vps ($user, $ten_san_pham, $price, $time_create, $end_time, $vps_status, $ip_vps, $username, $password, $url_dashboard_vps) {
        global $site_name, $smtpUser;
        $data = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>['.$site_name.'] Thông tin VPS</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                h1 {
                    text-align: center;
                    color: #333;
                }
                p {
                    margin-bottom: 20px;
                    color: #666;
                }
                .button {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: #fff;
                    text-decoration: none;
                    border-radius: 4px;
                }
                .footer {
                    margin-top: 20px;
                    text-align: center;
                    color: #999;
                }
                .logo {
                            max-width: 150px;
                            margin-bottom: 20px;
                        }
                .logo img {
                    max-width: 100%;
                    height: auto;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="logo">
                    <img src="https://raw.githubusercontent.com/hectran12/AHEXVPS_StoragePublic/main/img_test/dark_border_logo.png" alt="Your Company Logo">
                </div>
                <h1>THÔNG TIN KHỞI TẠO VPS</h1>
                <p>Xin chào {user},</p>
                <p>Cảm ơn bạn đã đặt hàng tại chúng tôi. Dưới đây là chi tiết đơn hàng của bạn:</p>
                <table>
                    <tr>
                        <td><strong>Sản phẩm:</strong></td>
                        <td>{ten_san_pham}</td>
                    </tr>
                    <tr>
                        <td><strong>Giá:</strong></td>
                        <td>{price}</td>
                    </tr>
                    <tr>
                        <td><strong>Thời gian tạo:</strong></td>
                        <td>{time_create}</td>
                    </tr>
                    <tr>
                        <td><strong>Thời gian hết hạn:</strong></td>
                        <td>{end_time}</td>
                    </tr>
                     <tr>
                        <td><strong>Trạng thái khởi tạo:</strong></td>
                        <td>{vps_status}</td>
                    </tr>
                     <tr>
                        <td><strong>IP:</strong></td>
                        <td>{ip_vps}</td>
                    </tr>
                    
                      <tr>
                        <td><strong>Username:</strong></td>
                        <td>{username}</td>
                    </tr>
                    
                     <tr>
                        <td><strong>Password:</strong></td>
                        <td>{password}</td>
                    </tr>
                </table>
                <br>
                <p>Để quản lý VPS của bạn, vui lòng truy cập vào trang quản lý:</p>
                <a href="{url_dashboard_vps}" class="button">Xem danh sách VPS</a>
                <p>Nếu bạn cần hỗ trợ, vui lòng liên hệ với chúng tôi qua email: '. $smtpUser .'</p>
                <p>Trân trọng,</p>
                <p>'. $site_name .'</p>
            </div>
        </body>
        </html>
        ';
        $data = str_replace('{user}', $user, $data);
        $data = str_replace('{ten_san_pham}', $ten_san_pham, $data);
        $data = str_replace('{price}', $price, $data);
        $data = str_replace('{time_create}', $time_create, $data);
        $data = str_replace('{end_time}', $end_time, $data);
        $data = str_replace('{vps_status}', $vps_status, $data);
        $data = str_replace('{ip_vps}', $ip_vps, $data);
        $data = str_replace('{username}', $username, $data);
        $data = str_replace('{password}', $password, $data);
        $data = str_replace('{url_dashboard_vps}', $url_dashboard_vps, $data);
        return $data;
    }


    function create_mail_confirm_order ($user, $listSanPham) {
        global $site_name, $smtpUser;
        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Xác nhận đơn hàng</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
          }
          table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
          }
          th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
          }
          th {
            background-color: #f2f2f2;
          }
          .logo {
            text-align: center;
            margin-bottom: 20px;
          }
          .logo img {
            max-width: 200px;
            height: auto;
          }
          .footer-img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            margin-top: 20px;
          }
        </style>
        </head>
        <body>
          <div class="logo">
            <img src="https://raw.githubusercontent.com/hectran12/AHEXVPS_StoragePublic/main/img_test/dark_border_logo.png" alt="Logo của cửa hàng">
          </div>
          <h2>Xác Nhận Đơn Hàng</h2>
          <p>Xin chào {user},</p>
          <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Dưới đây là chi tiết của đơn hàng của bạn:</p>
          <table>
            <tr>
              <th>Sản phẩm</th>
              <th>Số lượng</th>
              <th>Giá</th>
            </tr>
            ';

        $tong_cong = 0;

        foreach ($listSanPham as $sanPham) {
            $html .= '
            <tr>
              <td>'. $sanPham["ten_san_pham"] .'</td>
              <td>'. $sanPham["so_luong"] .'</td>
              <td>'. number_format($sanPham["gia"], 0, ',', '.') .'đ</td>
            </tr>
            ';
            $tong_cong += $sanPham["gia"];
        }
        
        $html .= '
            <tr>
              <td colspan="2"><strong>Tổng cộng</strong></td>
              <td><strong>'. number_format($tong_cong, 0, ',', '.') .'đ</strong></td>
            </tr>
          </table>
          <p>Xin vui lòng kiểm tra thông tin đơn hàng của bạn. Nếu bạn có bất kỳ câu hỏi nào, xin đừng ngần ngại liên hệ với chúng tôi qua email này!</p>
          <p>Trân trọng,</p>
          <p>'. $site_name .'</p>
          <img class="footer-img" src="https://raw.githubusercontent.com/hectran12/AHEXVPS_StoragePublic/main/img_test/Picsart_24-05-06_18-46-20-993.jpg" alt="Ảnh dưới cùng của email">
        </body>
        </html>
        ';
        $html = str_replace('{user}', $user, $html);
        return $html;
    }


    function create_mail_infomation_renew_vps ($user, $listSanPham) {
        global $site_name, $smtpUser;
        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Thông báo gia hạn thành công</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
          }
          table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
          }
          th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
          }
          th {
            background-color: #f2f2f2;
          }
          .logo {
            text-align: center;
            margin-bottom: 20px;
          }
          .logo img {
            max-width: 200px;
            height: auto;
          }
          .footer-img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            margin-top: 20px;
          }
        </style>
        </head>
        <body>
          <div class="logo">
            <img src="https://raw.githubusercontent.com/hectran12/AHEXVPS_StoragePublic/main/img_test/dark_border_logo.png" alt="ahex vps">
          </div>
          <h2>Thông Báo Gia Hạn Thành Công</h2>
          <p>Xin chào '.$user.',</p>
          <p>Chúng tôi rất vui mừng thông báo rằng VPS của bạn đã được gia hạn thành công. Dưới đây là chi tiết về gói dịch vụ đã được gia hạn:</p>
          <table>
            <tr>
              <th>Gói dịch vụ</th>
              <th>Thời gian gia hạn</th>
              <th>Giá</th>
            </tr>
            ';

        $tong_cong = 0;
        for ($i = 0; $i < count($listSanPham); $i++) {
            $html .= '
            <tr>
              <td>'. $listSanPham[$i]["ten_san_pham"] .'</td>
              <td>'. $listSanPham[$i]["so_luong"] .'</td>
              <td>'. number_format($listSanPham[$i]["gia"], 0, ',', '.') .'đ</td>
            </tr>
            ';
            $tong_cong += $listSanPham[$i]["gia"];
        }

          $html .= '
          </table>
          <p>Xin vui lòng kiểm tra lại thông tin của bạn. Nếu bạn có bất kỳ câu hỏi hoặc cần hỗ trợ, đừng ngần ngại liên hệ với chúng tôi.</p>
          <p>Trân trọng,</p>
          <p>'.$site_name.'</p>
          <img class="footer-img" src="https://raw.githubusercontent.com/hectran12/AHEXVPS_StoragePublic/main/img_test/gia_han_vps.jpg" alt="Gia han thanh cong">
        </body>
        </html>
        ';     
        return $html;
    }

    function create_mail_infomation_upgrade_vps ($user, $listSanPham) {
        global $site_name, $smtpUser;
        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Thông báo nâng cấp thành công</title>
        <style>
          body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
          }
          table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
          }
          th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
          }
          th {
            background-color: #f2f2f2;
          }
          .logo {
            text-align: center;
            margin-bottom: 20px;
          }
          .logo img {
            max-width: 200px;
            height: auto;
          }
          .footer-img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            margin-top: 20px;
          }
        </style>
        </head>
        <body>
          <div class="logo">
            <img src="https://raw.githubusercontent.com/hectran12/AHEXVPS_StoragePublic/main/img_test/dark_border_logo.png" alt="ahex vps">
          </div>
          <h2>Thông Báo Nâng Cấp VPS Thành Công</h2>
          <p>Xin chào '.$user.',</p>
          <p>Chúc mừng VPS của bạn đã được nâng cấp thành công, dưới đây là thông tin chi tiết:</p>
          <table>
            <tr>
              <th>Gói dịch vụ</th>
              <th>Số lượng</th>
              <th>Giá</th>
            </tr>
            ';

        $tong_cong = 0;
        for ($i = 0; $i < count($listSanPham); $i++) {
            $html .= '
            <tr>
              <td>'. $listSanPham[$i]["ten_san_pham"] .'</td>
              <td>'. $listSanPham[$i]["so_luong"] .'</td>
              <td>'. number_format($listSanPham[$i]["gia"], 0, ',', '.') .'đ</td>
            </tr>
            ';
            $tong_cong += $listSanPham[$i]["gia"];
        }

          $html .= '
          </table>
          <p>Xin vui lòng kiểm tra lại thông tin của bạn. Nếu bạn có bất kỳ câu hỏi hoặc cần hỗ trợ, đừng ngần ngại liên hệ với chúng tôi.</p>
          <p>Trân trọng,</p>
          <p>'.$site_name.'</p>
          <img class="footer-img" src="https://raw.githubusercontent.com/hectran12/AHEXVPS_StoragePublic/main/img_test/upgrade_success.jpg" alt="Nang cap thanh cong">
        </body>
        </html>
        ';     
        return $html;
    }
?>