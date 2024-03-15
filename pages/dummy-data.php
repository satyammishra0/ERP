<?php include '../init.php';

if (!in_array('1', explode(',', $_SESSION['ERP_ACCESS']))) {
    echo "Sorry You do not have permission to access this page";
    exit;
}
?>

<?php

// Code to set ini settings to print error
ini_set('display_errors', true);
error_reporting(1);



function get_all_center_count(PDO $DB)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "hospital_master  WHERE hm_del = '0'";

    $sqlList .= !empty(total_hospitals) ? " AND hm_id IN(" . implode(',', total_hospitals) . ")" : "";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}

function get_all_active_center_count(PDO $DB)
//center that not entered any lead 30 days ago from today

{
    $date = strtotime(date('Y-m-d'));  // today

    $beforeDate = date('Y-m-d', strtotime('-30 days', $date)); //30 day before

    $sqlList = "SELECT COUNT(*) FROM " . DB_PREFIX . "patient_master WHERE pm_del = '0' AND pm_created_date >= '$beforeDate' ";

    $sqlList .= !empty(total_hospitals) ? " AND hm_id IN(" . implode(',', total_hospitals) . " ) GROUP BY(hm_id);" : "GROUP BY(hm_id);";


    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}


function get_all_new_center_count(PDO $DB)

{
    $start_date = date("Y-m-d", strtotime("first day of previous month"));
    $last_date = date("Y-m-d", strtotime("last day of previous month"));

    $sqlList = "SELECT * FROM " . DB_PREFIX . "hospital_master WHERE hm_opening_date BETWEEN '$start_date' AND '$last_date'";

    $sqlList .= !empty(total_hospitals) ? " AND hm_id IN(" . implode(',', total_hospitals) . " );" : "";


    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}

function get_all_patient_count(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE pm_del = '0'";

    $sqlList .= !empty(total_hospitals) ? " AND hm_id IN(" . implode(',', total_hospitals) . " )" : "";

    $qryList = $DB->prepare($sqlList);

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}


function get_all_doctor_count(PDO $DB)
{
    $from_new_query = "FROM tbl_user_master
    WHERE ut_id IN ('1','2') AND um_del = '0' ";

    if (!empty(total_hospitals)) {
        $from_new_query .= "AND (";
        for ($i = 0; $i < count(total_hospitals); $i++) {
            $from_new_query .= "FIND_IN_SET('" . total_hospitals[$i] . "', hm_id) > 0";
            if ($i == count(total_hospitals) - 1) {
                $from_new_query .= " ";
            } else {
                $from_new_query .= " OR ";
            }
        }
        $from_new_query .= ")";
    }

    $sqlList = "SELECT *  $from_new_query";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}

?>

<?php include_once HEAD_TOP; ?>

<head>

    <title><?php echo "Dashboard" ?> | SAAOL - Admin & Dashboard Template</title>

    <?php include HEAD; ?>


    <style>
        .new-center-heading {
            font-size: 22px;
            font-weight: 600;
        }

        .new-number-heading {
            font-size: 27px;
        }
    </style>
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
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body col-xl-12">
                                            <div class="avatar col-lg-4 col-md-6">
                                                <span class="avatar-title bg-soft-primary rounded">
                                                    <i class="bx bx-buildings text-primary font-size-24"></i>
                                                </span>
                                            </div>
                                            <div class="col-lg-8 col-md-6">
                                                <p class="new-center-heading text-muted mt-4 mb-0"><a href="<?= home_path() ?>/all-center-list">Total Centers</a></p>
                                                <?php
                                                $count_all_active_centers = get_all_center_count($DB);
                                                ?>
                                                <h4 class="mt-1 mb-0 new-number-heading"><?php echo $count_all_active_centers; ?> </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="avatar">
                                                <span class="avatar-title bg-soft-success rounded">
                                                    <i class="bx bx-building text-primary font-size-24"></i>
                                                </span>
                                            </div>
                                            <p class="new-center-heading text-muted mt-4 mb-0"><a href="<?= home_path() ?>/new-center-list">New Center</a></p>
                                            <h4 class="mt-1 mb-0 new-number-heading">
                                                <?php $all_new_center = get_all_new_center_count($DB);
                                                echo $all_new_center;
                                                ?>
                                            </h4>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="avatar">
                                                <span class="avatar-title bg-soft-primary rounded">
                                                    <i class="bx bx-group text-primary font-size-24"></i>
                                                    <!--<i class="mdi mdi-rocket-outline text-primary font-size-24"></i>-->
                                                </span>
                                            </div>
                                            <p class="new-center-heading text-muted mt-4 mb-0"><a href="<?= home_path() ?>/patient-list">Total Patients</a></p>
                                            <?php
                                            $count_all_patient = get_all_patient_count($DB);
                                            ?>
                                            <h4 class="mt-1 mb-0 new-number-heading"><?php echo "$count_all_patient"; ?>
                                                <!-- <sup class="text-success fw-medium font-size-14"><i class="mdi mdi-arrow-down"></i> 22%</sup> -->
                                            </h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="avatar">
                                                <span class="avatar-title bg-soft-primary rounded">
                                                    <!--<i class="mdi mdi-shopping-outline text-primary font-size-24"></i>-->
                                                    <i class="bx bx-bed text-primary font-size-24"></i>
                                                </span>
                                            </div>
                                            <p class="new-center-heading text-muted mt-4 mb-0"><a href="<?= home_path() ?>/doctor-list">Total Doctors</a></p>
                                            <?php
                                            $count_all_doctor = get_all_doctor_count($DB);
                                            ?>
                                            <h4 class="mt-1 mb-0 new-number-heading"><?php echo $count_all_doctor;  ?>
                                                <!-- <sup class="text-success fw-medium font-size-14"><i class="mdi mdi-arrow-down"></i> 10%</sup> -->
                                            </h4>
                                        </div>
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

    <?php include_once RIGHT_SIDEBAR; ?>

    <?php include_once SCRIPT; ?>

    <!-- apexcharts -->
    <script src="<?= get_assets() ?>/libs/apexcharts/apexcharts.min.js"></script>
    <!-- Chart JS -->
    <script src="<?= get_assets() ?>/js/pages/chartjs.js"></script>

    <script src="<?= get_assets() ?>/js/pages/dashboard.init.js"></script>

    <script src="<?= get_assets() ?>/js/app.js"></script>

</body>

</html>