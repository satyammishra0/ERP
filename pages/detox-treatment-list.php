<?php include_once '../init.php';

if (!in_array('6', explode(',', $_SESSION['ERP_ACCESS']))) {
    echo "Sorry You do not have permission to access this page";
    exit;
}
?>
<?php include_once HEAD_TOP; ?>

<head>

    <title><?php echo "Dashboard" ?> | SAAOL - Admin & Dashboard Template</title>

    <?php include_once HEAD; ?>

</head>

<body data-layout="vertical" data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include_once MENU; ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <?php
                    $maintitle = "Layouts";
                    $title = 'Reports';
                    ?>
                    <?php
                    // include_once 'layouts/breadcrumb.php'; 
                    ?>
                    <!-- end page title -->
                    <button onclick="history.back()" class="btn btn-sm btn-dark waves-effect waves-light d-flex"><i class="bx bx-left-arrow-alt fs-4"></i> Back</button>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <!--<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus me-2"></i> Add New</a>-->
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-inline float-md-end mb-3">
                                                <div class="search-box ms-2">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control rounded bg-light border-0" placeholder="Search...">
                                                        <i class="mdi mdi-magnify search-icon"></i>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                    <!-- end row -->
                                    <div class="table-responsive mb-4">
                                        <table class="table table-centered table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 50px;">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input" id="contacusercheck">
                                                            <label class="form-check-label" for="contacusercheck"></label>
                                                        </div>
                                                    </th>
                                                    <th scope="col">Patient Name</th>
                                                    <th scope="col">Detox Package</th>
                                                    <th scope="col">Location</th>
                                                    <th scope="col" style="width: 200px;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                                            <label class="form-check-label" for="contacusercheck1"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <img src="<?= get_assets() ?>images/users/avatar-2.jpg" alt="" class="avatar-sm rounded-circle me-2">
                                                        <a href="#" class="text-body">Simon Ryles</a>
                                                    </td>
                                                    <td>Full Stack Developer</td>
                                                    <td>SimonRyles@minible.com</td>
                                                    <td>
                                                        Active
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input" id="contacusercheck2">
                                                            <label class="form-check-label" for="contacusercheck2"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <img src="<?= get_assets() ?>images/users/avatar-3.jpg" alt="" class="avatar-sm rounded-circle me-2">
                                                        <a href="#" class="text-body">Marion Walker</a>
                                                    </td>
                                                    <td>Frontend Developer</td>
                                                    <td>MarionWalker@minible.com</td>
                                                    <td>
                                                        Active
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input" id="contacusercheck3">
                                                            <label class="form-check-label" for="contacusercheck3"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="avatar-sm d-inline-block me-2">
                                                            <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                                                <i class="mdi mdi-account-circle m-0"></i>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="text-body">Frederick White</a>
                                                    </td>
                                                    <td>UI/UX Designer</td>
                                                    <td>FrederickWhite@minible.com</td>
                                                    <td>
                                                        Active
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input" id="contacusercheck4">
                                                            <label class="form-check-label" for="contacusercheck4"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <img src="<?= get_assets() ?>images/users/avatar-4.jpg" alt="" class="avatar-sm rounded-circle me-2">
                                                        <a href="#" class="text-body">Shanon Marvin</a>
                                                    </td>
                                                    <td>Backend Developer</td>
                                                    <td>ShanonMarvin@minible.com</td>
                                                    <td>
                                                        Active
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input" id="contacusercheck5">
                                                            <label class="form-check-label" for="contacusercheck5"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="avatar-sm d-inline-block me-2">
                                                            <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                                                <i class="mdi mdi-account-circle m-0"></i>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="text-body">Mark Jones</a>
                                                    </td>
                                                    <td>Frontend Developer</td>
                                                    <td>MarkJones@minible.com</td>
                                                    <td>
                                                        Active
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input" id="contacusercheck6">
                                                            <label class="form-check-label" for="contacusercheck6"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <img src="<?= get_assets() ?>images/users/avatar-5.jpg" alt="" class="avatar-sm rounded-circle me-2">
                                                        <a href="#" class="text-body">Janice Morgan</a>
                                                    </td>
                                                    <td>Backend Developer</td>
                                                    <td>JaniceMorgan@minible.com</td>
                                                    <td>
                                                        Active
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input" id="contacusercheck7">
                                                            <label class="form-check-label" for="contacusercheck7"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <img src="<?= get_assets() ?>images/users/avatar-7.jpg" alt="" class="avatar-sm rounded-circle me-2">
                                                        <a href="#" class="text-body">Patrick Petty</a>
                                                    </td>
                                                    <td>UI/UX Designer</td>
                                                    <td>PatrickPetty@minible.com</td>
                                                    <td>
                                                        Active
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input" id="contacusercheck8">
                                                            <label class="form-check-label" for="contacusercheck8"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <img src="<?= get_assets() ?>images/users/avatar-8.jpg" alt="" class="avatar-sm rounded-circle me-2">
                                                        <a href="#" class="text-body">Marilyn Horton</a>
                                                    </td>
                                                    <td>Backend Developer</td>
                                                    <td>MarilynHorton@minible.com</td>
                                                    <td>
                                                        Active
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input" id="contacusercheck9">
                                                            <label class="form-check-label" for="contacusercheck9"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <img src="<?= get_assets() ?>images/users/avatar-2.jpg" alt="" class="avatar-sm rounded-circle me-2">
                                                        <a href="#" class="text-body">Neal Womack</a>
                                                    </td>
                                                    <td>Full Stack Developer</td>
                                                    <td>NealWomack@minible.com</td>
                                                    <td>
                                                        Active
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="form-check font-size-16">
                                                            <input type="checkbox" class="form-check-input" id="contacusercheck10">
                                                            <label class="form-check-label" for="contacusercheck10"></label>
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <div class="avatar-sm d-inline-block me-2">
                                                            <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                                                <i class="mdi mdi-account-circle m-0"></i>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="text-body">Steven Williams</a>
                                                    </td>
                                                    <td>Frontend Developer</td>
                                                    <td>Steven Williams@minible.com</td>
                                                    <td>
                                                        Active
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-sm-6">
                                            <div>
                                                <p class="mb-sm-0">Showing 1 to 10 of 12 entries</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="float-sm-end">
                                                <ul class="pagination mb-sm-0">
                                                    <li class="page-item disabled">
                                                        <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link">1</a>
                                                    </li>
                                                    <li class="page-item active">
                                                        <a href="#" class="page-link">2</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link">3</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include_once FOOTER; ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include_once RIGHT_SIDEBAR; ?>

    <?php include_once SCRIPT; ?>

    <!-- apexcharts -->
    <script src="<?= get_assets() ?>libs/apexcharts/apexcharts.min.js"></script>
    <!-- Chart JS -->
    <script src="<?= get_assets() ?>js/pages/chartjs.js"></script>

    <script src="<?= get_assets() ?>js/pages/dashboard.init.js"></script>

    <script src="<?= get_assets() ?>js/app.js"></script>

</body>

</html>