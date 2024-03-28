<?php include_once '../init.php';

if (!in_array('4', explode(',', $_SESSION['ERP_ACCESS']))) {
    echo "Sorry You do not have permission to access this page";
    exit;
}

include_once HEAD_TOP;
?>



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
                    <!-- <button onclick="history.back()" class="btn btn-sm btn-dark waves-effect waves-light d-flex"><i class="bx bx-left-arrow-alt fs-4"></i> Back</button> -->

                    <!-- Back and page naming -->
                    <div class="d-flex mb-2" style="display:flex;align-items:center;">
                        <button onclick="history.back()" class="btn btn-sm btn-dark waves-effect waves-light d-flex mb-2" style="width: max-content;"><i class="bx bx-left-arrow-alt fs-4"></i> </button>
                        <h3 class="new-center-heading text-muted ml-3 ms-3">All Doctor List</h3>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">

                                        <!-- Center type filter -->
                                        <div class="col-md-4" style="display:flex;flex-direction:column;">
                                            <div style="width:100%;">
                                                <lable>Select Center Type: </lable>
                                            </div>
                                            <div class="" style="width:100%;">
                                                <select class="form-select" name="select_center_type" id="select_center_type">
                                                    <option value="0">All</option>
                                                    <option value="1">Owner</option>
                                                    <option value="2">Partnership</option>
                                                    <option value="3">Franchise</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Manager name filter -->
                                        <div class="col-md-4" style="display:flex;flex-direction:column;">
                                            <div style="width: 100%;">
                                                <lable>Select Manager Name: </lable>
                                            </div>
                                            <div style="width: 100%;">
                                                <select class="form-select" id="select_manager_name">
                                                    <option value="0">All</option>
                                                    <?php
                                                    $managerDetails = get_manager_details_case_center_type($DB);
                                                    foreach ($managerDetails as $row) {
                                                    ?>
                                                        <option value="<?php echo ($row['manager_name']); ?>"><?php echo ($row['manager_name']); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Center Name filters -->
                                        <div class="col-md-4" style="display:flex;flex-direction:column;">
                                            <div>
                                                <lable>Select Center: </lable>
                                            </div>
                                            <div class="" style="width:100%;">
                                                <select class="form-select" name="select_center" id="select_center">
                                                    <option value="0">All</option>
                                                    <?php $RowCenter = get_all_active_hospital_details($DB);
                                                    foreach ($RowCenter as $row) { ?>
                                                        <option value="<?php echo $row['hm_id']; ?>"><?php echo $row['hm_name']; ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-8"></div>
                                        <div class="col-md-4 mt-4" style="display: flex; justify-content:right;align-items:center;">
                                            <div class="pl-2 pr-2" style="display:flex; align-items:center; justify-content:center; ">
                                                <div>
                                                    <lable style="color:#003032; font-size:large;"><b>Total Doctor</b> </lable>
                                                </div>
                                                <div class="ms-2">
                                                    <p class="text-end" style="color:#3980c0; font-size:medium; margin:0;" id="total_patients_retrived">100000</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <div class="table-responsive mb-4 mt-4">
                                        <table class="table table-centered table-nowrap mb-0 mt-2" id="center_master_table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 50px;">Sr. No.

                                                    </th>
                                                    <th scope="col">Doctor Name</th>
                                                    <th scope="col">Center Name</th>
                                                    <th scope="col">Contact No.</th>
                                                    <th scope="col">Status</th>

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

    <script>
        $(".mydate").flatpickr();


        function mytable() {
            var select_center_type = $('#select_center_type').val();
            var select_center = $('#select_center').val();
            var manager_name = $("#select_manager_name").val();


            var dataTable = $('#center_master_table').DataTable({
                "searching": true,
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ordering": false,
                "iDisplayLength": 10,
                "rowCallback": function(nRow, aData, iDisplayIndex) {
                    var oSettings = this.fnSettings();
                    $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                    return nRow;
                },
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
                    "emptyTable": "No Patient(s) added",
                },

                "ajax": {

                    url: "Auth/action_get_all_doctor.php", // json datasource
                    type: "post", // method  , by default get
                    data: {
                        select_center_type: select_center_type,
                        select_center: select_center,
                        manager_name: manager_name,
                    },
                    error: function() { // error handling
                        $(".patient_master_table-error").html("");
                        $("#center_master_table").append('<tbody class="patient_master_table-error"><tr><th colspan="8" style="text-align: center;">No Patient Found.</th></tr></tbody>');
                        $("#center_master_table_processing").css("display", "none");
                    }
                },

                "initComplete": function(settings, json) {
                    $("#total_patients_retrived").text(json.recordsFiltered);
                },

                bDestroy: true,
            });

            $('#search').keyup(function() {
                dataTable.search($(this).val()).draw();
            });
        };

        mytable();

        // Function to populate table values depending on center|| Franchise || Owner
        $('#select_center_type').on('change', function() {
            var type = $(this).val();
            var ajax1 = $.ajax({
                url: "Auth/action_get_center_list.php?list=" + type,
                method: "GET",
                dataType: "JSON",
            }).done(function(result) {
                $('#select_center').html(result);
            });

            var ajax2 = $.ajax({
                url: "Auth/action_get_all_manager_details.php?list=" + type,
                method: "GET",
                dataType: "JSON",
            }).done(function(result) {
                $('#select_manager_name').html(result);
            });

            $.when(ajax1, ajax2).done(function() {
                mytable(); // Calling function when both AJAX calls are completed
            });
        });

        // Function to update table data || center names based on their manager names
        $('#select_manager_name').on('change', function() {
            mytable();

            var manager_name = $(this).val();

            var ajax2 = $.ajax({
                url: "Auth/action_get_center_list.php?manager_name=" + manager_name,
                method: "GET",
                dataType: "JSON",
            }).done(function(result) {
                $('#select_center').html(result);
            });

            $.when(ajax2).done(function() {
                mytable(); // Calling function when both AJAX calls are completed
            });
        })



        $('#select_center').on('change', function() {
            mytable();
        })
    </script>

</body>

</html>