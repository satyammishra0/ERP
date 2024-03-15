<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <?php

    $access_value = $_SESSION['ERP_ACCESS'];

    $access_value_arr = explode(',', $access_value);


    ?>
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="<?= home_path() ?>" class="logo logo-dark">
            <span class="logo-sm">
                <img loading="lazy" src="<?= get_assets() ?>images/logo-sm.svg" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img loading="lazy" src="<?= get_assets() ?>images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">SAAOL ERP</span>
            </span>
        </a>

        <a href="<?= home_path() ?>" class="logo logo-light">
            <span class="logo-lg">
                <img loading="lazy" src="<?= get_assets() ?>images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">SAAOL ERP</span>
            </span>
            <span class="logo-sm">
                <img loading="lazy" src="<?= get_assets() ?>images/logo-sm.svg" alt="" height="22">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <!-- <li class="menu-title" data-key="t-menu"><?= $language["Menu"]; ?></li> -->


                <?php
                foreach ($access_value_arr as $key) {
                    if ($key == 1) {
                        echo '<li><a href="' . home_path() . '">
                        <i class="bx bx-tachometer icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboards">' . $language["Dashboard"] .
                            '</span></li>';
                    } else if ($key == 2) {
                        echo '<li><a href="' . home_path() . '/all-center-list">
                        <i class="bx bx-buildings icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboards">All Center List</span></li>';
                    } else if ($key == 3) {
                        echo '<li><a href="' . home_path() . '/patient-list">
                         <i class="bx bx-user icon nav-icon"></i>
                        <span class="menu-item" data-key="t-dashboards">Patient List</span></li>';
                    } else if ($key == 4) {
                        echo '<li><a href="' . home_path() . '/doctor-list">
                        <i class="bx bx-plus icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Doctor List</span>';
                    } else if ($key == 5) {
                        echo '<li><a href="' . home_path() . '/report-details/ecp">
                        <i class="bx bx-bed icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">EECP Treatment</span>';
                    } else if ($key == 6) {
                        echo '<li><a href="' . home_path() . '/report-details/sdt">
                        <i class="bx bx-pulse icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Detox Treatment</span>';
                    } else if ($key == 7) {
                        echo '<li><a href="' . home_path() . '/center-reports">
                        <i class="bx bx-user-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="Center Reports">Center Reports</span>';
                    } else if ($key == 8) {
                        echo '<li><a href="' . home_path() . '/users">
                        <i class="bx bx-receipt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar">Users</span>';
                    }
                }
                ?>



                <!-- <li>
                    <a href="<?= home_path() ?>/all-center-list">
                        <i class="bx bx-buildings icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar"><?= "All Center List"; ?></span>
                    </a>
                </li>

                <li>
                    <a href="<?= home_path() ?>/patient-list">
                        <i class="bx bx-user icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar"><?= "Patient List"; ?></span>
                    </a>
                </li>

                <li>
                    <a href="<?= home_path() ?>/doctor-list">
                        <i class="bx bx-plus icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar"><?= "Doctor List"; ?></span>
                    </a>
                </li>

                <li>
                    <a href="<?= home_path() ?>/eecp-treatment-list">
                        <i class='bx bx-bed icon nav-icon'></i>

                        <span class="menu-item" data-key="t-calendar">EECP Treatment</span>
                    </a>
                </li>
                <li>
                    <a href="<?= home_path() ?>/detox-treatment-list">
                        <i class='bx bx-pulse icon nav-icon'></i>
                        <span class="menu-item" data-key="t-calendar"><?= "Detox Treatment"; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= home_path() ?>/center-reports">
                        <i class="bx bx-user-circle icon nav-icon"></i>
                        <span class="menu-item" data-key="Center Reports">Center Reports</span>
                    </a>
                </li>
                <li>
                    <a href="<?= home_path() ?>/users">
                        <i class="bx bx-receipt icon nav-icon"></i>
                        <span class="menu-item" data-key="t-calendar"><?= "Users" ?></span>
                    </a>
                </li> -->
                <!--<li>-->
                <!--    <a href="apps-chat.php">-->
                <!--        <i class="bx bx-chat icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-chat"><?= $language["Chat"]; ?></span>-->
                <!--        <span class="badge rounded-pill bg-danger" data-key="t-hot"><?= $language["Hot"]; ?></span>-->
                <!--    </a>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bx-envelope icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-email"><?= $language["Email"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="email-inbox.php" data-key="t-inbox"><?= $language["Inbox"]; ?></a></li>-->
                <!--        <li><a href="email-read.php" data-key="t-read-email"><?= $language["Read_Email"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bx-store icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-ecommerce"><?= $language["Ecommerce"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="ecommerce-products.php" data-key="t-products"><?= $language["Products"]; ?></a></li>-->
                <!--        <li><a href="ecommerce-product-detail.php" data-key="t-product-detail"><?= $language["Product_Detail"]; ?></a></li>-->
                <!--        <li><a href="ecommerce-orders.php" data-key="t-orders"><?= $language["Orders"]; ?></a></li>-->
                <!--        <li><a href="ecommerce-customers.php" data-key="t-customers"><?= $language["Customers"]; ?></a></li>-->
                <!--        <li><a href="ecommerce-cart.php" data-key="t-cart"><?= $language["Cart"]; ?></a></li>-->
                <!--        <li><a href="ecommerce-checkout.php" data-key="t-checkout"><?= $language["Checkout"]; ?></a></li>-->
                <!--        <li><a href="ecommerce-shops.php" data-key="t-shops"><?= $language["Shops"]; ?></a></li>-->
                <!--        <li><a href="ecommerce-add-product.php" data-key="t-add-product"><?= $language["Add_Product"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bx-receipt icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-invoices"><?= $language["Invoices"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="invoices-list.php" data-key="t-invoice-list"><?= $language["Invoice_List"]; ?></a></li>-->
                <!--        <li><a href="invoices-detail.php" data-key="t-invoice-detail"><?= $language["Invoice_Detail"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bxs-user-detail icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-contacts"><?= $language["Contacts"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="contacts-grid.php" data-key="t-user-grid"><?= $language["User_Grid"]; ?></a></li>-->
                <!--        <li><a href="contacts-list.php" data-key="t-user-list"><?= $language["User_List"]; ?></a></li>-->
                <!--        <li><a href="contacts-profile.php" data-key="t-user-settings"><?= $language["Profile"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li class="menu-title" data-key="t-pages"><?= $language["Pages"]; ?></li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bx-user-circle icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-authentication"><?= $language["Authentication"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="page-login.php" data-key="t-login"><?= $language["Login"]; ?></a></li>-->
                <!--        <li><a href="page-register.php" data-key="t-register"><?= $language["Register"]; ?></a></li>-->
                <!--        <li><a href="page-recoverpw.php" data-key="t-recover-password"><?= $language["ecover_Password"]; ?></a></li>-->
                <!--        <li><a href="auth-lock-screen.php" data-key="t-lock-screen"><?= $language["Lock_Screen"]; ?></a></li>-->
                <!--        <li><a href="auth-logout.php" data-key="t-logout"><?= $language["Log_Out"]; ?></a></li>-->
                <!--        <li><a href="auth-confirm-mail.php" data-key="t-confirm-mail"><?= $language["Confirm_Mail"]; ?></a></li>-->
                <!--        <li><a href="auth-email-verification.php" data-key="t-email-verification"><?= $language["Email_Verification"]; ?></a></li>-->
                <!--        <li><a href="auth-two-step-verification.php" data-key="t-two-step-verification"><?= $language["Two_Step_Verification"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bx-file icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-utility"><?= $language["Utility"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="pages-starter.php" data-key="t-starter-page"><?= $language["Starter_Page"]; ?></a></li>-->
                <!--        <li><a href="pages-maintenance.php" data-key="t-maintenance"><?= $language["Maintenance"]; ?></a></li>-->
                <!--        <li><a href="pages-comingsoon.php" data-key="t-coming-soon"><?= $language["Coming_Soon"]; ?></a></li>-->
                <!--        <li><a href="pages-timeline.php" data-key="t-timeline"><?= $language["Timeline"]; ?></a></li>-->
                <!--        <li><a href="pages-faqs.php" data-key="t-faqs"><?= $language["FAQs"]; ?></a></li>-->
                <!--        <li><a href="pages-pricing.php" data-key="t-pricing"><?= $language["Pricing"]; ?></a></li>-->
                <!--        <li><a href="pages-404.php" data-key="t-error-404"><?= $language["Error_404"]; ?></a></li>-->
                <!--        <li><a href="pages-500.php" data-key="t-error-500"><?= $language["Error_500"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="layouts-vertical.php">-->
                <!--        <i class="bx bx-layout icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-vertical"><?= $language["Vertical"]; ?></span>-->
                <!--    </a>-->
                <!--</li>-->

                <!--<li class="menu-title" data-key="t-components"><?= $language["Components"]; ?></li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bxl-bootstrap icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-bootstrap"><?= $language["Bootstrap"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="ui-alerts.php" data-key="t-alerts"><?= $language["Alerts"]; ?></a></li>-->
                <!--        <li><a href="ui-buttons.php" data-key="t-buttons"><?= $language["Buttons"]; ?></a></li>-->
                <!--        <li><a href="ui-cards.php" data-key="t-cards"><?= $language["Cards"]; ?></a></li>-->
                <!--        <li><a href="ui-carousel.php" data-key="t-carousel"><?= $language["Carousel"]; ?></a></li>-->
                <!--        <li><a href="ui-dropdowns.php" data-key="t-dropdowns"><?= $language["Dropdowns"]; ?></a></li>-->
                <!--        <li><a href="ui-grid.php" data-key="t-grid"><?= $language["Grid"]; ?></a></li>-->
                <!--        <li><a href="ui-images.php" data-key="t-images"><?= $language["Images"]; ?></a></li>-->
                <!--        <li><a href="ui-modals.php" data-key="t-modals"><?= $language["Modals"]; ?></a></li>-->
                <!--        <li><a href="ui-offcanvas.php" data-key="t-offcanvas"><?= $language["Offcanvas"]; ?></a></li>-->
                <!--        <li><a href="ui-placeholders.php" data-key="t-placeholders"><?= $language["Placeholders"]; ?></a></li>-->
                <!--        <li><a href="ui-progressbars.php" data-key="t-progress-bars"><?= $language["Progress_Bars"]; ?></a></li>-->
                <!--        <li><a href="ui-tabs-accordions.php" data-key="t-tabs-accordions"><?= $language["Tabs_n_Accordions"]; ?></a></li>-->
                <!--        <li><a href="ui-typography.php" data-key="t-typography"><?= $language["Typography"]; ?></a></li>-->
                <!--        <li><a href="ui-video.php" data-key="t-video"><?= $language["Video"]; ?></a></li>-->
                <!--        <li><a href="ui-general.php" data-key="t-general"><?= $language["General"]; ?></a></li>-->
                <!--        <li><a href="ui-colors.php" data-key="t-colors"><?= $language["Colors"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bx-disc icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-extended"><?= $language["Extended"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="extended-lightbox.php" data-key="t-lightbox"><?= $language["Lightbox"]; ?></a></li>-->
                <!--        <li><a href="extended-rangeslider.php" data-key="t-range-slider"><?= $language["Range_Slider"]; ?></a></li>-->
                <!--        <li><a href="extended-sweet-alert.php" data-key="t-sweet-alert"><?= $language["SweetAlert_2"]; ?></a></li>-->
                <!--        <li><a href="extended-rating.php" data-key="t-rating"><?= $language["Rating"]; ?></a></li>-->
                <!--        <li><a href="extended-notifications.php" data-key="t-notifications"><?= $language["Notifications"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bxs-eraser icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-forms"><?= $language["Forms"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="form-elements.php" data-key="t-basic-elements"><?= $language["Basic_Elements"]; ?></a></li>-->
                <!--        <li><a href="form-validation.php" data-key="t-validation"><?= $language["Validation"]; ?></a></li>-->
                <!--        <li><a href="form-advanced.php" data-key="t-advanced-plugins"><?= $language["Advanced_Plugins"]; ?></a></li>-->
                <!--        <li><a href="form-editors.php" data-key="t-editors"><?= $language["Editors"]; ?></a></li>-->
                <!--        <li><a href="form-uploads.php" data-key="t-file-upload"><?= $language["File_Upload"]; ?></a></li>-->
                <!--        <li><a href="form-wizard.php" data-key="t-wizard"><?= $language["Wizard"]; ?></a></li>-->
                <!--        <li><a href="form-mask.php" data-key="t-mask"><?= $language["Mask"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bx-list-ul icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-tables"><?= $language["Tables"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="tables-basic.php" data-key="t-bootstrap-basic"><?= $language["Bootstrap_Basic"]; ?></a></li>-->
                <!--        <li><a href="tables-advanced.php" data-key="t-advanced-tables"><?= $language["Advance_Tables"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bxs-bar-chart-alt-2 icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-charts"><?= $language["Charts"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="charts-apex.php" data-key="t-apex-charts"><?= $language["Apex"]; ?></a></li>-->
                <!--        <li><a href="charts-chartjs.php" data-key="t-chartjs-charts"><?= $language["Chartjs"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bx-aperture icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-icons"><?= $language["Icons"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="icons-feather.php" data-key="t-feather"><?= $language["Feather"]; ?></a></li>-->
                <!--        <li><a href="icons-boxicons.php" data-key="t-boxicons"><?= $language["Boxicons"]; ?></a></li>-->
                <!--        <li><a href="icons-materialdesign.php" data-key="t-material-design"><?= $language["Material_Design"]; ?></a></li>-->
                <!--        <li><a href="icons-dripicons.php" data-key="t-dripicons"><?= $language["Dripicons"]; ?></a></li>-->
                <!--        <li><a href="icons-fontawesome.php" data-key="t-font-awesome"><?= $language["Font_awesome"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bx-map icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-maps"><?= $language["Maps"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="false">-->
                <!--        <li><a href="maps-google.php" data-key="t-google"><?= $language["Google"]; ?></a></li>-->
                <!--        <li><a href="maps-vector.php" data-key="t-vector"><?= $language["Vector"]; ?></a></li>-->
                <!--        <li><a href="maps-leaflet.php" data-key="t-leaflet"><?= $language["Leaflet"]; ?></a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                <!--<li>-->
                <!--    <a href="javascript: void(0);" class="has-arrow">-->
                <!--        <i class="bx bx-share-alt icon nav-icon"></i>-->
                <!--        <span class="menu-item" data-key="t-multi-level"><?= $language["Multi_Level"]; ?></span>-->
                <!--    </a>-->
                <!--    <ul class="sub-menu" aria-expanded="true">-->
                <!--        <li><a href="javascript: void(0);" data-key="t-level-1.1"><?= $language["Level_1_1"]; ?></a></li>-->
                <!--        <li><a href="javascript: void(0);" class="has-arrow" data-key="t-level-1.2"><?= $language["Level_1_2"]; ?></a>-->
                <!--            <ul class="sub-menu" aria-expanded="true">-->
                <!--                <li><a href="javascript: void(0);" data-key="t-level-2.1"><?= $language["Level_2_1"]; ?></a></li>-->
                <!--                <li><a href="javascript: void(0);" data-key="t-level-2.2"><?= $language["Level_2_2"]; ?></a></li>-->
                <!--            </ul>-->
                <!--        </li>-->
                <!--    </ul>-->
                <!--</li>-->

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->