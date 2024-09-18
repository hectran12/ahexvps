<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">

<!-- Start::main-sidebar-header -->
<div class="main-sidebar-header">
    <a href="index.html" class="header-logo">
        <img src="../img/favicon.ico" alt="logo" class="desktop-logo">
        <img src="../img/dark_border_logo.png" alt="logo" class="toggle-logo">
        <img src="../img/dark_border_logo.png" alt="logo" class="desktop-dark">
        <img src="../img/favicon.ico" alt="logo" class="toggle-dark">
        <img src="../img/white_border_logo.png" alt="logo" class="desktop-white">
        <img src="../img/white_border_logo.png" alt="logo" class="toggle-white">
    </a>
</div>
<!-- End::main-sidebar-header -->

<!-- Start::main-sidebar -->
<div class="main-sidebar" id="sidebar-scroll">

    <!-- Start::nav -->
    <nav class="main-menu-container nav nav-pills flex-column sub-open">
        <div class="slide-left" id="slide-left">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg>
        </div>
        <ul class="main-menu">
            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">Main</span></li>
            <!-- End::slide__category -->

            <!-- Start::slide -->
            <li class="slide has-sub">
                <a href="javascript:void(0);" class="side-menu__item">
                    <i class="bx bx-home side-menu__icon"></i>
                    <span class="side-menu__label">Dashboards<span class="badge bg-warning-transparent ms-2">1</span></span>
                    <i class="fe fe-chevron-right side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    <li class="slide side-menu__label1 active">
                        <a href="javascript:void(0)">Dashboards</a>
                    </li>
                    <li class="slide">
                        <a href="../home" class="side-menu__item">Home</a>
                    </li>
                  
                </ul>
            </li>
            <!-- End::slide -->

            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">TOPUP</span></li>
            <!-- End::slide__category -->

            <!-- Start::slide -->
            <li class="slide has-sub">
                <a href="javascript:void(0);" class="side-menu__item">
                    <!-- icon ecommerce -->
                    <i class="bx bx-money side-menu__icon"></i>
                    <span class="side-menu__label">Nạp tiền<span class="badge bg-warning-transparent ms-2">2</span></span>
                    <i class="fe fe-chevron-right side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    <li class="slide side-menu__label1">
                        <a href="javascript:void(0)">Nạp tiền</a>
                    </li>
                    <li class="slide">
                        <a href="../topup/bank" class="side-menu__item">Bank</a>
                    </li>
                    <li class="slide">
                        <a href="../topup/card" class="side-menu__item">Thẻ cào</a>
                    </li>
                    
                </ul>
            </li>
            <!-- End::slide -->

            <!-- Start::slide -->
            <?php
                if($userInfo["email"] == $adminEmail) {
                    echo '
                        
                        <li class="slide has-sub">
                            <a href="javascript:void(0);" class="side-menu__item">
                                <i class="bx bx-task side-menu__icon"></i>
                                <span class="side-menu__label">Q.lý nạp tiền user<span class="badge bg-warning-transparent ms-2">2</span></span>
                                <i class="fe fe-chevron-right side-menu__angle"></i>
                            </a>
                            <ul class="slide-menu child1">
                                <li class="slide side-menu__label1">
                                    <a href="javascript:void(0)">Q.lý nạp tiền user</a>
                                </li>
                                <li class="slide">
                                    <a href="../admin/topup_bank" class="side-menu__item">Hóa đơn nạp bank</a>
                                </li>
                                <li class="slide">
                                    <a href="../admin/topup_card" class="side-menu__item">Hóa đơn nạp thẻ cào</a>
                                </li>
                              
                            </ul>
                        </li>
                        
                    ';
                }


            ?>
           
            <!-- End::slide -->

         


            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">Register Service</span></li>   
 
            <!-- End::slide__category -->

            <!-- Start::slide -->
            <li class="slide has-sub">
                <a href="javascript:void(0);" class="side-menu__item">
                    <!-- ICON VPS--> 
                    <i class="bx bx-server side-menu__icon"></i>
                    <span class="side-menu__label">VPS VIỆT NAM </span>  <span class="badge bg-warning-transparent ms-2"><?= count(
                json_decode(file_get_contents('../data/products.json'), true)["vps"]
            ) ?></span>
                    <i class="fe fe-chevron-right side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1 mega-menu">
                    <li class="slide side-menu__label1">
                        <a href="javascript:void(0)">VPS VIỆT NAM</a>
                    </li>
                    <?php 
                        $data = json_decode(file_get_contents('../data/products.json'), true)["vps"];
                        if($data == null) {
                            die('Product not found');
                        } else {
                            for($i = 0; $i < count($data); $i++) {
                                $product = $data[$i];
                                $group_product_name = $product["group_product_name"];
                                echo '
                                    <li class="slide">
                                        <a href="../vps_vietnam?plan='.$i.'" class="side-menu__item">'.$group_product_name.'</a>
                                    </li>
                                ';
                            }
                        }

                    ?>
                   
                    
                </ul>
            </li>
            <!-- End::slide -->
            

            <?php 
                if($userInfo["email"] == $adminEmail) {
                    echo '<!-- Start::slide -->
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <!-- icon task --> 
                            <i class="bx bx-task side-menu__icon"></i>
                            <span class="side-menu__label">Q.lý hóa đơn VPS</span> <span class="badge bg-warning-transparent ms-2">1</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Q.lý hóa đơn VPS</a>
                            </li>
                            <li class="slide">
                                <a href="../admin/manager_bill_vps" class="side-menu__item">Toàn bộ hóa đơn</a>
                            </li>
                           
                        </ul>
                    </li>';
                }

            ?>
            
            
    

            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">my service</span></li>
            <!-- End::slide__category -->

    

            <!-- Start::slide -->
            <li class="slide has-sub">
                <a href="javascript:void(0);" class="side-menu__item">
                    
                <i class='bx bx-briefcase-alt-2 side-menu__icon'></i>
                    <span class="side-menu__label">Dịch vụ của tôi </span><span class="badge bg-warning-transparent ms-2">1</span>
                    <i class="fe fe-chevron-right side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    <li class="slide side-menu__label1">
                        <a href="javascript:void(0)">Dịch vụ của tôi</a>
                    </li>
                    <li class="slide">
                        <a href="../vps_vietnam/?action=my_service" class="side-menu__item">VPS Việt Nam</a>
                    </li>
                 
                </ul>
            </li>
            <!-- End::slide -->


            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">SERVICE BILL</span></li>
            <!-- End::slide__category -->

            <!-- Start::slide -->
            <li class="slide has-sub">
                <a href="javascript:void(0);" class="side-menu__item">
                    <!-- icon management -->
                    <i class="bx bx-layer side-menu__icon"></i>
                    <span class="side-menu__label">Q.lý thanh toán</span> <span class="badge bg-warning-transparent ms-2">2</span>
                    <i class="fe fe-chevron-right side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    <li class="slide side-menu__label1">
                        <a href="javascript:void(0)">Q.lý thanh toán</a>
                    </li>
                    <li class="slide">
                        <a href="../order?type=nhat_ky_tiente" class="side-menu__item">Nhật ký cộng/trừ tiền</a>
                    </li>
                    <li class="slide">
                        <a href="../order?type=hoa_don" class="side-menu__item">Hóa đơn</a>
                    </li>
                   
                </ul>
            </li>
            <!-- End::slide -->


            
      
            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">ACCOUNT</span></li>
            <!-- End::slide__category -->

     

            <!-- Start::slide -->
            <li class="slide">
                <a href="../view/profile" class="side-menu__item">
                    <!-- icon user -->
                    <i class="bx bx-user side-menu__icon"></i>
                    <span class="side-menu__label">Profile</span>
                </a>
            </li>
            <!-- End::slide -->


             <!-- Start::support -->
             <li class="slide__category"><span class="category-name">SUPPORT</span></li>
            <!-- End::support -->

     

            <!-- Start::slide -->
            <li class="slide">
                <a href="https://zalo.me/0866369917" class="side-menu__item">
                    <!-- icon calling --> 
                    <i class='bx bx-phone side-menu__icon'></i>
                    <span class="side-menu__label">Zalo: 0866369917</span>
                </a>
            </li>
            <!-- End::slide -->
             <!-- Start::slide -->
             <li class="slide">
                <a href="../support?type=create_ticket" class="side-menu__item">
                    <!-- icon facebook --> 
                    <i class='bx bxl-facebook side-menu__icon'></i>
                    <span class="side-menu__label">Fanpage</span>
                </a>
            </li>
            <!-- End::slide -->
             <!-- Start::slide -->
             <li class="slide">
                <a href="https://t.me/tronghoadz123" class="side-menu__item">
                    <!-- icon telegram--> 
                    <i class='bx bxl-telegram side-menu__icon'></i>
                    <span class="side-menu__label">Telegram</span>
                </a>
            </li>
            <!-- End::slide -->


              <!-- Start::support -->
              <li class="slide__category"><span class="category-name">COMMUNITY</span></li>
            <!-- End::support -->

             <!-- Start::slide -->
             <li class="slide">
                <a 
                    onClick="alert('Cộng đồng này không chỉ nói về VPS mà còn nói về game..., nên lưu ý trước khi vào!'); window.location.href='https://discord.gg/ahex';"
                class="side-menu__item">
                    <!-- icon calling --> 
                    <i class='bx bxl-discord-alt side-menu__icon'></i>
                    <span class="side-menu__label">Discord</span>
                </a>
            </li>
            <!-- End::slide -->

        </ul>
        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
    </nav>
    <!-- End::nav -->

</div>
<!-- End::main-sidebar -->

</aside>