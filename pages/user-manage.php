<?php include '../init.php'; ?>

<?php include_once HEAD_TOP; ?>

<?php $uid = $_GET['_uid'];


if (isset($uid)) {
    $from_new_query = "FROM " . DB_PREFIX . "user_master WHERE um_id = '$uid' AND um_del = '0'";
    $sql = "SELECT  CONCAT(`salutation` ,' ', `first_name`,' ',`last_name`) as name  $from_new_query";
    $qry = $DB->prepare($sql);
    $qry->execute();
    $ResultsList = $qry->fetchAll();
}
?>

<head>

    <title><?php echo "Dashboard" ?> | SAAOL - Admin & Dashboard </title>

    <?php include HEAD; ?>

    <style>
        /* Additional CSS styles */
        .custom-checkbox.large-checkbox .custom-control-label::before {
            border: 3px solid #007bff;
            /* Increase border thickness */
            width: 40px;
            /* Increase width */
            height: 40px;
            /* Increase height */
        }

        .custom-checkbox.large-checkbox .custom-control-label::after {
            width: 36px;
            /* Increase width of inner checkbox */
            height: 36px;
            /* Increase height of inner checkbox */
        }

        .form-container {
            border: 1px solid #dcdcdc;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .danger {
            color: red;
            font-weight: 600;
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
                    <input type="hidden" name="" id="hid_inp" value="<?= $hid ?>">

                    <button onclick="history.back()" class="btn btn-sm btn-dark waves-effect waves-light d-flex"><i class="bx bx-left-arrow-alt fs-4"></i> Back</button>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <!--<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus me-2"></i> Add New</a>-->

                                                <h2>
                                                    <?= isset($ResultsList) ? $ResultsList['0']['name'] : "No Results" ?>
                                                </h2>

                                                <h3 class="new-center-heading text-muted mb-0">Manage Access</h3>
                                            </div>
                                        </div>






                                        <div class="container mt-2">
                                            <input type="hidden" name="" id="uid_val" value="<?= $uid ?>">
                                            <div class="row justify-content-center">
                                                <div class="col-md-12 form-container">
                                                    <h2 class="text-center">Select Tabs</h2>
                                                    <div class="form-group ">
                                                        <div class="custom-control custom-checkbox custom-control-inline mb-2 large-checkbox">
                                                            <input type="checkbox" class="form-check-input" id="option1" name="options[]" value="1">
                                                            <label class="custom-control-label" for="option1"></label>
                                                            <span>DashBoard</span>
                                                        </div>
                                                        <div class="custom-control custom-checkbox custom-control-inline mb-2">
                                                            <input type="checkbox" class="form-check-input" id="option2" name="options[]" value="2">
                                                            <label class="custom-control-label" for="option2"></label>
                                                            <span>All Center List</span>
                                                        </div>
                                                        <div class="custom-control custom-checkbox custom-control-inline mb-2">
                                                            <input type="checkbox" class="form-check-input" id="option3" name="options[]" value="3">
                                                            <label class="custom-control-label" for="option3"></label>
                                                            <span>Patient List</span>
                                                        </div>
                                                        <div class="custom-control custom-checkbox custom-control-inline mb-2">
                                                            <input type="checkbox" class="form-check-input" id="option4" name="options[]" value="4">
                                                            <label class="custom-control-label" for="option4"></label>
                                                            <span>Doctor List</span>
                                                        </div>
                                                        <div class="custom-control custom-checkbox custom-control-inline mb-2">
                                                            <input type="checkbox" class="form-check-input" id="option5" name="options[]" value="5">
                                                            <label class="custom-control-label" for="option5"></label>
                                                            <span>EECP Treatment</span>
                                                        </div>
                                                        <div class="custom-control custom-checkbox custom-control-inline mb-2">
                                                            <input type="checkbox" class="form-check-input" id="option6" name="options[]" value="6">
                                                            <label class="custom-control-label" for="option6"></label>
                                                            <span>Detox Treatment</span>
                                                        </div>

                                                        <div class="custom-control custom-checkbox custom-control-inline mb-2">
                                                            <input type="checkbox" class="form-check-input" id="option7" name="options[]" value="7">
                                                            <label class="custom-control-label" for="option7"></label>
                                                            <span>Center Reports</span>
                                                        </div>
                                                        <div class="custom-control custom-checkbox custom-control-inline mb-2">
                                                            <input type="checkbox" class="form-check-input" id="option8" name="options[]" value="8">
                                                            <label class="custom-control-label" for="option8"></label>
                                                            <span>Users</span>
                                                        </div>

                                                    </div>

                                                    <!-- <p class="danger bold" id="success_msg">
                                                        hello
                                                    </p> -->
                                                    <button type="submit" id="submitBtn" class="btn btn-primary btn-block mt-2">Submit</button>

                                                </div>
                                            </div>
                                        </div>






                                    </div>
                                    <!-- end row -->


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
    </script>

    <script>
        function user_data_ajax() {
            $(document).ready(function() {

                const selectedOptions = [];
                $('input[name="options[]"]:checked').each(function() {
                    selectedOptions.push($(this).val());
                });
                const uid_val = $('#uid_val').val();
                // Send the data to the destination page using AJAX
                $.ajax({
                    url: "../Auth/action_user_manage.php", // Replace with the actual URL of the destination page
                    type: "POST",
                    data: {
                        uid: uid_val,
                        options: selectedOptions
                    },
                    success: function(response) {
                        // Handle the response from the destination page if needed
                        console.log("Data sent successfully!");
                        $data = JSON.parse(response);
                        enable_check($data['0']['erp_menu'])

                    },
                    error: function(xhr, status, error) {
                        // Handle errors if the request fails
                        console.error("Error:", error);
                    }
                });;
            });
        }


        user_data_ajax();

        $('#submitBtn').on('click', function() {
            user_data_ajax();
            alert("Successfully submitted");
        })

        function enable_check($data) {
            $data = $data.split(',');
            console.log($data);
            $.each($data, (key, value) => {

                $('#option' + value).prop("checked", true);
                console.log(value);

            })
        }
    </script>
</body>

</html>