<?php include 'layouts/session.php'; ?>

<?php include 'layouts/config.php'; ?>
<?php include 'functions.php'; ?>
<?php


if (isset($_GET['pu_id'])) {
    $patient_id = base64_decode($_GET['pu_id']);
    $PatientRow = get_single_patient_master_details_from_id($DB, $patient_id);
    $patient_unique_id = $PatientRow['patient_unique_id'];

    $hospital_id = $PatientRow['hm_id'];

    $patient_package_total_amount_master = get_single_patient_package_master_total_package_amount_from_universal_id($DB, $patient_unique_id, $hospital_id);
    $patient_package_master = get_single_patient_package_master_total_paid_amount_from_universal_id($DB, $patient_unique_id, $hospital_id);
    $patient_package_refund_amount_master = get_single_patient_package_master_total_package_refund_amount_from_universal_id($DB, $patient_unique_id, $hospital_id);
    $patient_package_Outstanding_amount_master = get_single_patient_package_master_total_package_Outstanding_amount_from_universal_id($DB, $patient_unique_id, $hospital_id);
}

?>

<?php include 'layouts/head-main.php'; ?>

<head>

    <title><?php echo "Dashboard" ?> | SAAOL - Admin & Dashboard Template</title>

    <?php include 'layouts/head.php'; ?>

    <?php include 'layouts/head-style.php'; ?>



    <link rel="stylesheet" href="assets/css/datatables.min.css">

</head>

<body data-layout="vertical" data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include 'layouts/menu.php'; ?>

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

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <!--<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus me-2"></i> Add New</a>-->
                                                <h3 class="new-center-heading text-muted mb-0"><?php echo $PatientRow['pm_first_name'] . " " . $PatientRow['pm_middle_name'] . " " . $PatientRow['pm_last_name']; ?></h3>
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                        </div>


                                    </div>
                                    <!-- end row -->
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 client-details-main-two">

                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane tab-content-bg fade show active" id="packages" role="tabpanel" aria-labelledby="home-tab">
                                                <div class="row">
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                        <div class="billing-net-amount">
                                                            <h4>₹<?php if ($patient_package_total_amount_master['SUM(package_price)'] == "") {
                                                                        echo 0;
                                                                    } else {
                                                                        echo $patient_package_total_amount_master['SUM(package_price)'];
                                                                    } ?></h4>
                                                            <h5>Net Amount</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                        <div class="billing-amount-paid">
                                                            <h4>₹<?php if ($patient_package_master['SUM(paid_price)'] == "") {
                                                                        echo 0;
                                                                    } else {
                                                                        echo $patient_package_master['SUM(paid_price)'];
                                                                    } ?></h4>
                                                            <h5>Amount Paid</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                        <div class="billing-refund">
                                                            <h4>₹<?php if ($patient_package_refund_amount_master['SUM(paid_price)'] == "") {
                                                                        echo 0;
                                                                    } else {
                                                                        echo $patient_package_refund_amount_master['SUM(paid_price)'];
                                                                    } ?></h4>
                                                            <h5>Refund</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                        <div class="billing-outstanding">
                                                            <h4>₹<?php if ($patient_package_Outstanding_amount_master['SUM(remaining_price)'] == "") {
                                                                        echo 0;
                                                                    } else {
                                                                        echo $patient_package_Outstanding_amount_master['SUM(remaining_price)'];
                                                                    } ?></h4>
                                                            <h5>Outstanding</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row client-packages-add-new" style="margin-top: 30px;">
                                                    <div class="col-lg-6 col-lg-6 col-md-6 col-6">
                                                        <h5>Patient Packages</h5>
                                                    </div>

                                                </div>
                                                <div class="">
                                                    <div class="appointments-right-table client-packages-table single_table_entry_class">
                                                        <table class="table " id="packages_details">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th scope="col">Sr. No.</th>
                                                                    <th style="width: 12%;" scope="col">Package Name</th>
                                                                    <!--<th style="width: 10%;" scope="col">Rate Plan</th>-->
                                                                    <th style="width: 6%;" scope="col">Sessions</th>
                                                                    <th style="width: 8%;" scope="col">Completed</th>
                                                                    <th style="width: 8%;" scope="col">Price</th>
                                                                    <th style="width: 6%;" scope="col">Paid</th>
                                                                    <th style="width: 8%;" scope="col">Balance</th>
                                                                    <th style="width: 10%;" scope="col">Activated on</th>
                                                                    <th style="width: 8%;" scope="col">Status</th>
                                                                    <!--<th style="width: 12%;" scope="col">Booked By</th>-->
                                                                    <!--<th style="width: 3%;" scope="col"></th>-->
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
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


            <?php include 'layouts/footer.php'; ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include 'layouts/right-sidebar.php'; ?>

    <?php include 'layouts/vendor-scripts.php'; ?>





    <!-- apexcharts -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <!-- Chart JS -->
    <script src="assets/js/pages/chartjs.js"></script>

    <script src="assets/js/pages/dashboard.init.js"></script>

    <script src="assets/js/app.js"></script>

    <script>
        var dataTable = $('#packages_details').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "responsive": true,
            "lengthChange": false,
            "rowCallback": function(nRow, aData, iDisplayIndex) {
                var oSettings = this.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            },
            "columnDefs": [{
                    "orderable": true,
                    "targets": [0, 1, 2, 3]
                },
                {
                    "orderable": true,
                    "targets": []
                }
            ],
            "bInfo": false,
            "bLengthChange": false,
            "language": {
                "emptyTable": "No Package added",


            },
            "ajax": {
                url: "Auth/ajax_client_packages_details.php?patient_details_id=<?php echo base64_encode($patient_unique_id); ?>", // json datasource
                //url :"action/ajax_patient_user.php", // json datasource
                type: "post", // method  , by default get
                error: function() { // error handling
                    $(".packages_details-error").html("");
                    $("#packages_details").append('<tbody class="packages_details-error"><tr><th colspan="10" style="text-align: center;">No Package Found.</th></tr></tbody>');
                    $("#packages_details").css("display", "none");
                }
            }
        });
    </script>


</body>

</html>