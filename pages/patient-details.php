<?php include_once '../init.php';

if (!in_array('3', explode(',', $_SESSION['ERP_ACCESS']))) {
    echo "Sorry You do not have permission to access this page";
    exit;
}

if (isset($_GET)) {
    $patient_id =  base64_decode($_GET['_pid']);
}

$patient_details = get_single_patient_details_from_patient_universal_id($DB, $patient_id);

$HospitalId = $patient_details['hm_id'];

$sqlList = "SELECT hm_name FROM " . DB_PREFIX . "hospital_master WHERE hm_id = '$HospitalId'";

$qryList = $DB->prepare($sqlList);

$qryList->execute();

$hm_name = $qryList->fetch();

$package_details = "";



function count_patient_reccomended_treatment_session_from_package_id(PDO $DB, $patient_unique_id, $package_id)
{
    $sql = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE patient_unique_id = '$patient_unique_id' AND package_type = '$package_id' AND tppm_del = '0' AND tppm_status != '3'";

    $qry = $DB->prepare($sql);
    $qry->execute();
    $Results = $qry->fetchAll();

    return $Results;
}

// print_r(count_patient_reccomended_treatment_session_from_package_id($DB, $patient_id, 1));
// print_r(count_patient_reccomended_treatment_session_from_package_id($DB, $patient_id, 2));

// print_r(get_state_name_using_id($DB, $patient_details['pm_state'])['name']);
?>

<?php include_once HEAD_TOP; ?>

<head>

    <title><?php echo "Dashboard" ?> | SAAOL - Admin & Dashboard Template</title>

    <?php include HEAD; ?>

    <style>
        .text-muted {
            font-size: 15px;
            font-weight: 400;
            --bs-text-opacity: 1;
            color: #74788d !important;
        }

        .avatar-lg {
            height: 8rem;
            width: 8rem;
            object-fit: cover;
        }

        .profile-content {
            margin-top: 0px;
        }

        .profile_right_bg_border {
            margin-bottom: 7px;
        }

        h5 a,
        h6 a {
            color: #495057 !important;
            font-size: 17px;
            font-weight: 500;
            text-decoration: none;
        }

        h5 a i,
        h6 a i {
            color: #009ED6;
            position: relative;
            top: 4px;
            font-size: 18px;
        }

        h6 {
            margin-bottom: 0;
        }

        .table-nowrap td,
        .table-nowrap th {
            padding: 0.45rem 0.35rem;
        }

        table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 8px;
        }
    </style>

</head>

<body data-layout="vertical" data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include MENU; ?>

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
                    // include 'layouts/breadcrumb.php'; 
                    ?>
                    <!-- end page title -->
                    <button onclick="history.back()" class="btn btn-sm btn-dark waves-effect waves-light d-flex"><i class="bx bx-left-arrow-alt fs-4"></i> Back</button>

                    <div class="row mb-1">
                        <div class="col-xl-4">
                            <div class="card overflow-hidden">
                                <!-- <div class="profile-user"></div> -->
                                <div class="card-body">
                                    <div class="profile-content text-center">
                                        <div class="profile-user-img">
                                            <!-- <?= $patient_details['pm_images'] ?> -->
                                            <img src="<?php if (isset($patient_details['pm_images']) && !empty($patient_details['pm_images'])) {
                                                            echo "https://crm.saaol.com/upload/patient_images/" . $patient_details['pm_images'];
                                                        } else {
                                                            echo "https://ohmylens.com/wp-content/uploads/2017/06/dummy-profile-pic.png";
                                                        } ?>" alt="patient image" class="avatar-lg rounded-circle img-thumbnail">


                                        </div>
                                        <h5 class="mt-3 mb-1"><?= $patient_details['pm_salutation'] . " " . $patient_details['pm_first_name'] . " " . $patient_details['pm_middle_name'] . " " . $patient_details['pm_last_name'] ?></h5>
                                        <p class="text-muted"><?= $patient_details['patient_unique_id'] ?></p>
                                        <h5><a href="#"><i class="bx bx-phone-call"></i> <?= $patient_details['pm_contact_no'] ?></a></h5>
                                        <h6><a href="#"><i class="bx bx-mail-send"></i> <?= $patient_details['pm_email'] ?></a></h6>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="card mb-0">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#about" role="tab">
                                            <i class="bx bx-clipboard font-size-20"></i>
                                            <span class="d-none d-sm-block">Patient Treatment</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                                            <i class="bx bx-user-circle font-size-20"></i>
                                            <span class="d-none d-sm-block">Patient Details</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- Tab content -->
                                <div class="tab-content p-4">
                                    <div class="tab-pane active" id="about" role="tabpanel">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                                                <table class="table table-bordered table-striped table-nowrap mb-0 eecp_table_pd">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th scope="col"><b>Treatment</b></th>
                                                            <th scope="col" class="text-center">
                                                                <b>EECP</b>
                                                                <!-- <span class="fw-normal">&lt;576px</span> -->
                                                            </th>
                                                            <th scope="col" class="text-center">
                                                                <b>SDT</b>
                                                                <!-- <span class="fw-normal">≥576px</span> -->
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <?php

                                                            ?>
                                                            <th class="text-nowrap" scope="row">Recommend</th>
                                                            <input type="text" hidden id="patient_inp" value="<?= $patient_id ?>">
                                                            <?php $res =  count_patient_reccomended_treatment_session_from_package_id($DB, $patient_id, 2);

                                                            if (!count($res) > 0) {
                                                                $eecp = 0;
                                                            } else {
                                                                $eecp = $res[0]['sessions'];
                                                                $eecp_inp = $res[0]['tppm_id'];
                                                                $eecp_rem_payment = $res[0]['remaining_price'];
                                                            }; ?>
                                                            <input type="text" hidden id="eecp_inp" value="<?= $eecp_inp ?>">
                                                            <td><?= $eecp ?></td>
                                                            <?php $res =  count_patient_reccomended_treatment_session_from_package_id($DB, $patient_id, 1);

                                                            if (!count($res) > 0) {
                                                                $sdt = 0;
                                                            } else {
                                                                $sdt = $res['0']['sessions'];
                                                                $sdt_inp = $res[0]['tppm_id'];
                                                                $sdt_rem_payment = $res[0]['remaining_price'];
                                                            }; ?>
                                                            <input type="text" hidden id="sdt_inp" value="<?= $sdt_inp ?>">
                                                            <td><?= $sdt ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Completed</th>
                                                            <td><?= count_patient_complted_treatment_session_from_package($DB, $patient_id, 2); ?></td>
                                                            <td><?= count_patient_complted_treatment_session_from_package($DB, $patient_id, 1); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-nowrap" scope="row">Balance</th>
                                                            <td><code><?= $eecp -  count_patient_complted_treatment_session_from_package($DB, $patient_id, 2); ?></code></td>
                                                            <td><code><?= $sdt - count_patient_complted_treatment_session_from_package($DB, $patient_id, 1); ?></code></td>
                                                        </tr>


                                                    </tbody>
                                                </table>
                                                <div class="p-2 bg-light mt-1">
                                                    <h5 class="font-size-15 mb-0">Pending Amount: <span class="float-end ms-2">
                                                            ₹ <?= (isset($eecp_rem_payment) ? $eecp_rem_payment : 0) + (isset($sdt_rem_payment) ? $sdt_rem_payment : 0) ?>
                                                        </span></h5>
                                                </div>

                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                                                <div class="table-responsive">
                                                    <div class="p-2 bg-light mb-1">
                                                        <h5 class="font-size-15 mb-0">Treatment Package: <span class="float-end ms-2">₹ <?= ($eecp * 2500) + ($sdt * 2000) ?></span></h5>
                                                    </div>
                                                    <table class="table table-centered mb-0 table-nowrap">
                                                        <!-- <thead>
                                                            <tr>
                                                                <th class="border-top-0" style="width: 110px;" scope="col">TREATMENT PACKAGE :</th>
                                                                <th class="border-top-0" scope="col"> ₹ 1,40,000</th>
                                                            </tr>
                                                        </thead> -->
                                                        <tbody>


                                                            <tr>
                                                                <td colspan="2">
                                                                    <h5 class="font-size-14 m-0">Discount :</h5>
                                                                </td>
                                                                <td>
                                                                    - ₹ 0
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td colspan="2">
                                                                    <h5 class="font-size-14 m-0">Charge Per EECP :</h5>
                                                                </td>
                                                                <td>
                                                                    ₹ 2,500
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <h5 class="font-size-14 m-0">Charge Per SDT :</h5>
                                                                </td>
                                                                <td>
                                                                    ₹ 2,000
                                                                </td>
                                                            </tr>

                                                            <tr class="bg-light">
                                                                <td colspan="2">
                                                                    <h5 class="font-size-14 m-0">Amount Payable: </h5>
                                                                </td>
                                                                <td>
                                                                    <b>₹ <?= ($eecp * 2500) + ($sdt * 2000) ?></b>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="tab-pane" id="tasks" role="tabpanel">
                                        <div>
                                            <h5 class="font-size-16 mb-3">Active</h5>

                                            <div class="table-responsive">
                                                <table class="table table-nowrap table-centered">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 60px;">
                                                                <div class="form-check font-size-16 text-center">
                                                                    <input type="checkbox" class="form-check-input" id="tasks-activeCheck2">
                                                                    <label class="form-check-label" for="tasks-activeCheck2"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="fw-bold text-dark">Ecommerce Product Detail</a>
                                                            </td>

                                                            <td>
                                                                <p class="ml-4 text-muted mb-0">
                                                                    <i class="mdi mdi-comment-outline align-middle text-muted font-size-16 me-1"></i> 3
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p class="ml-4 mb-0">Product Design</p>
                                                            </td>

                                                            <td>27 May, 2020</td>
                                                            <td style="width: 160px;"><span class="badge badge-soft-primary font-size-12">Active</span></td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check font-size-16 text-center">
                                                                    <input type="checkbox" class="form-check-input" id="tasks-activeCheck1">
                                                                    <label class="form-check-label" for="tasks-activeCheck1"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="fw-bold text-dark">Ecommerce Product</a>
                                                            </td>

                                                            <td>
                                                                <p class="ml-4 text-muted mb-0">
                                                                    <i class="mdi mdi-comment-outline align-middle text-muted font-size-16 me-1"></i> 7
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p class="ml-4 mb-0">Web Development</p>
                                                            </td>

                                                            <td>26 May, 2020</td>
                                                            <td><span class="badge badge-soft-primary font-size-12">Active</span></td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <h5 class="font-size-16 my-3">Upcoming</h5>

                                            <div class="table-responsive">
                                                <table class="table table-nowrap table-centered">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 60px;">
                                                                <div class="form-check font-size-16 text-center">
                                                                    <input type="checkbox" class="form-check-input" id="tasks-upcomingCheck3">
                                                                    <label class="form-check-label" for="tasks-upcomingCheck3"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="fw-bold text-dark">Chat app Page</a>
                                                            </td>

                                                            <td>
                                                                <p class="ml-4 text-muted mb-0">
                                                                    <i class="mdi mdi-comment-outline align-middle text-muted font-size-16 me-1"></i> 2
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p class="ml-4 mb-0">Web Development</p>
                                                            </td>

                                                            <td>-</td>
                                                            <td style="width: 160px;"><span class="badge badge-soft-secondary font-size-12">Waiting</span></td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check font-size-16 text-center">
                                                                    <input type="checkbox" class="form-check-input" id="tasks-upcomingCheck2">
                                                                    <label class="form-check-label" for="tasks-upcomingCheck2"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="fw-bold text-dark">Email Pages</a>
                                                            </td>

                                                            <td>
                                                                <p class="ml-4 text-muted mb-0">
                                                                    <i class="mdi mdi-comment-outline align-middle text-muted font-size-16 me-1"></i> 1
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p class="ml-4 mb-0">Illustration</p>
                                                            </td>

                                                            <td>04 June, 2020</td>
                                                            <td><span class="badge badge-soft-primary font-size-12">Approved</span></td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check font-size-16 text-center">
                                                                    <input type="checkbox" class="form-check-input" id="tasks-upcomingCheck1">
                                                                    <label class="form-check-label" for="tasks-upcomingCheck1"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="fw-bold text-dark">Contacts Profile Page</a>
                                                            </td>
                                                            <td>
                                                                <p class="ml-4 text-muted mb-0">
                                                                    <i class="mdi mdi-comment-outline align-middle text-muted font-size-16 me-1"></i> 6
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p class="ml-4 mb-0">Product Design</p>
                                                            </td>

                                                            <td>-</td>
                                                            <td><span class="badge badge-soft-secondary font-size-12">Waiting</span></td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <h5 class="font-size-16 my-3">Complete</h5>

                                            <div class="table-responsive">
                                                <table class="table table-nowrap table-centered">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 60px;">
                                                                <div class="form-check font-size-16 text-center">
                                                                    <input type="checkbox" class="form-check-input" id="tasks-completeCheck3">
                                                                    <label class="form-check-label" for="tasks-completeCheck3"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="fw-bold text-dark">UI Elements</a>
                                                            </td>

                                                            <td>
                                                                <p class="ml-4 text-muted mb-0">
                                                                    <i class="mdi mdi-comment-outline align-middle text-muted font-size-16 me-1"></i> 6
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p class="ml-4 mb-0">Product Design</p>
                                                            </td>

                                                            <td>27 May, 2020</td>
                                                            <td style="width: 160px;"><span class="badge badge-soft-success font-size-12">Complete</span></td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check font-size-16 text-center">
                                                                    <input type="checkbox" class="form-check-input" id="tasks-completeCheck2">
                                                                    <label class="form-check-label" for="tasks-completeCheck2"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="fw-bold text-dark">Authentication Pages</a>
                                                            </td>

                                                            <td>
                                                                <p class="ml-4 text-muted mb-0">
                                                                    <i class="mdi mdi-comment-outline align-middle text-muted font-size-16 me-1"></i> 2
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p class="ml-4 mb-0">Illustration</p>
                                                            </td>

                                                            <td>27 May, 2020</td>
                                                            <td><span class="badge badge-soft-success font-size-12">Complete</span></td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check font-size-16 text-center">
                                                                    <input type="checkbox" class="form-check-input" id="tasks-completeCheck1">
                                                                    <label class="form-check-label" for="tasks-completeCheck1"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="fw-bold text-dark">Admin Layout</a>
                                                            </td>

                                                            <td>
                                                                <p class="ml-4 text-muted mb-0">
                                                                    <i class="mdi mdi-comment-outline align-middle text-muted font-size-16 me-1"></i> 3
                                                                </p>
                                                            </td>
                                                            <td>
                                                                <p class="ml-4 mb-0">Product Design</p>
                                                            </td>

                                                            <td>26 May, 2020</td>
                                                            <td><span class="badge badge-soft-success font-size-12">Complete</span></td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="tab-pane" id="messages" role="tabpanel">
                                        <div>
                                            <div class="col-xl-12 col-lg-8 col-md-8 col-12">
                                                <div class="profile_right_bg">
                                                    <div class="profile_right_bg_border">
                                                        <div class="row">
                                                            <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                                                <h6>Center Name:</h6>
                                                            </div>
                                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                                <span><?= $hm_name['hm_name'] ?></span>
                                                                <!-- <div class="row">
                                                                    <div class="col-xl-4 col-lg-3 col-md-4 col-12">
                                                                        <h5 class="font-size-14">Center:</h5>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-9 col-md-8 col-12">
                                                                        <h4>SAAOL Delhi Chhatarpur </h4>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-xl-4 col-lg-3 col-md-4 col-12">
                                                                        <h5 class="font-size-14">Age:</h5>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-9 col-md-8 col-12">
                                                                        <span>56</span>
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="profile_right_bg_border">
                                                        <div class="row">
                                                            <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                                                <h6>User Details</h6>
                                                            </div>
                                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                                <div class="row">
                                                                    <div class="col-xl-4 col-lg-3 col-md-4 col-12">
                                                                        <h5 class="font-size-14">Date of Birth :</h5>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-9 col-md-8 col-12">
                                                                        <span><?= $patient_details['pm_dob'] ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 col-lg-3 col-md-4 col-12">
                                                                        <h5 class="font-size-14">Gender :</h5>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-9 col-md-8 col-12">
                                                                        <span><?= $patient_details['pm_gender'] ?></span>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="row">
                                                                    <div class="col-xl-4 col-lg-3 col-md-4 col-12">
                                                                        <h5 class="font-size-14">Qualification :</h5>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-9 col-md-8 col-12">
                                                                        <span>-</span>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 col-lg-3 col-md-4 col-12">
                                                                        <h5 class="font-size-14">Speciality :</h5>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-9 col-md-8 col-12">
                                                                        <span>-</span>
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="profile_right_bg_border">
                                                        <div class="row">
                                                            <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                                                <h6>Address Details</h6>
                                                            </div>
                                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                                <div class="row">
                                                                    <div class="col-xl-4 col-lg-3 col-md-4 col-12">
                                                                        <h5 class="font-size-14">Address:</h5>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-9 col-md-8 col-12">
                                                                        <span><?= $patient_details['pm_address'] ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 col-lg-3 col-md-4 col-12">
                                                                        <h5 class="font-size-14">State:</h5>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-9 col-md-8 col-12">
                                                                        <span><?= get_state_name_using_id($DB, $patient_details['pm_state'])['name'] ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 col-lg-3 col-md-4 col-12">
                                                                        <h5 class="font-size-14">Country:</h5>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-9 col-md-8 col-12">
                                                                        <span><?= get_country_name_using_id($DB, $patient_details['pm_country'])['name'] ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 col-lg-3 col-md-4 col-12">
                                                                        <h5 class="font-size-14">Pin Code:</h5>
                                                                    </div>
                                                                    <div class="col-xl-8 col-lg-9 col-md-8 col-12">
                                                                        <span><?= $patient_details['pm_pincode'] ?></span>
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

                    </div>



                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <!-- end row -->
                                    <div class="table-responsive mb-4">
                                        <table class="table table-centered table-nowrap mb-0 display" id="patient_master_table">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>

                                                    <th>Package Type</th>
                                                    <th>DATE</th>
                                                    <th>Time</th>
                                                    <th>Booked By</th>
                                                    <!-- <th scope="col" style="width: 200px;">Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <!-- <tr>
                                                    <td>1</td>
                                                    <td>28/08/23</td>
                                                    <td>--</td>
                                                    <td>2500</td>

                                                    <td>Transaction Details</td>

                                                    <td>EECP</td>
                                                    <td>SDT</td>
                                                    <td>Total</td>
                                                    <td>Balance</td>
                                                </tr> -->

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include FOOTER; ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include RIGHT_SIDEBAR; ?>

    <?php include SCRIPT; ?>





    <!-- apexcharts -->
    <script src="<?= get_assets() ?>libs/apexcharts/apexcharts.min.js"></script>
    <!-- Chart JS -->
    <script src="<?= get_assets() ?>js/pages/chartjs.js"></script>

    <script src="<?= get_assets() ?>js/pages/dashboard.init.js"></script>

    <script src="<?= get_assets() ?>js/app.js"></script>

    <script>
        $(".mydate").flatpickr();
        var ascending = true;
        console.log('hello');


        function toggleSorting() {
            var table = $('#patient_master_table').DataTable();
            var order = ascending ? 'desc' : 'asc';

            table.order([0, order]).draw();

            ascending = !ascending;

        }

        function mytable() {
            var select_center_type = $('#select_center_type').val();
            var select_center = $('#select_center').val();
            var center_date_from = $('#center_date_from').val();
            var center_date_end = $('#center_date_end').val();
            var sdt_inp = $('#sdt_inp').val();
            var eecp_inp = $('#eecp_inp').val();
            var patient_inp = $('#patient_inp').val();
            console.log(sdt_inp, eecp_inp);
            var dataTable = $('#patient_master_table').DataTable({
                "searching": true,
                // "processing": true,
                // "serverSide": true,
                "responsive": true,
                "order": [
                    [0, 'asc'],
                    [1, 'asc']
                ],
                "iDisplayLength": 10,
                "rowCallback": function(nRow, aData, iDisplayIndex) {
                    var oSettings = this.fnSettings();
                    $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                    return nRow;
                },
                // "scrollY": "calc(100vh - 290px)",
                // 			"rowCallback": function(nRow, aData, iDisplayIndex) {
                // 				var oSettings = this.fnSettings();
                // 				$("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                // 				return nRow;
                // 			},
                "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 1, 2, 3]
                    },
                    {
                        "orderable": true,
                        "targets": []
                    }
                ],
                "lengthMenu": [
                    [10, 50, 200, 1000, -1],
                    [10, 50, 200, 1000, "All"]
                ],
                "language": {

                    "emptyTable": "No Treatment(s) added",

                },

                "ajax": {

                    url: "../Auth/new.php", // json datasource
                    type: "post", // method  , by default get
                    data: {
                        select_center_type: select_center_type,
                        select_center: select_center,
                        center_date_from: center_date_from,
                        center_date_end: center_date_end,
                        eecp_inp: eecp_inp,
                        sdt_inp: sdt_inp,
                        patient_inp: patient_inp
                    },
                    error: function() { // error handling
                        $(".patient_master_table-error").html("");
                        $("#patient_master_table").append('<tbody class="patient_master_table-error"><tr><th colspan="8" style="text-align: center;">No Data Found.</th></tr></tbody>');
                        $("#patient_master_table_processing").css("display", "none");
                    }
                },
                bDestroy: true,
            });

            $('#search').keyup(function() {
                dataTable.search($(this).val()).draw();
            });


        };

        mytable();

        $('#select_center_type').on('change', function() {
            type = $(this).val();
            $.ajax({
                url: "Auth/action_get_center_list.php?list=" + type,
                method: "GET",
                dataType: "JSON",
            }).done(function(result) {
                $('#select_center').html(result);
            })



            mytable();
        })

        $('#select_center').on('change', function() {
            mytable();
        })

        $('#center_date_from').on('change', function() {
            if ($('#center_date_end').val() != "") {
                mytable();
            }

        })

        $('#center_date_end').on('change', function() {
            if ($('#center_date_from').val() != "") {
                mytable();
            }

        })



        $('.clear_date').on('click', function() {
            $('#center_date_from').val("");
            $('#center_date_end').val("");
            mytable();


        })
    </script>

</body>

</html>