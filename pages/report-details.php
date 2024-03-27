<?php include '../init.php';



if (!in_array('5', explode(',', $_SESSION['ERP_ACCESS']))) {
    echo "Sorry You do not have permission to access this page";
    exit;
}

include_once HEAD_TOP;

$hid = isset($_GET['_hid']) ? $_GET['_hid'] : "";


$report_type = $_GET['_type'];



if ($hid != '') {
    $from_new_query = "FROM " . DB_PREFIX . "hospital_master WHERE hm_id = '$hid' AND hm_del = '0'";
    $sql = "SELECT hm_name  $from_new_query";
    $qry = $DB->prepare($sql);
    $qry->execute();
    $ResultsList = $qry->fetchAll();

    print_r($ResultsList);
} else {
    $from_new_query = "FROM " . DB_PREFIX . "hospital_master WHERE AND hm_del = '0'";
}

?>

<head>

    <title><?php echo "Dashboard" ?> | SAAOL - Admin & Dashboard Template</title>

    <?php include HEAD; ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <style>
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
                    <input type="hidden" name="" id="hid_inp" value="<?= $hid ?>">
                    <input type="hidden" name="" id="type_inp" value="<?= $report_type ?>">

                    <div class="d-flex mb-2" style="display:flex;align-items:center;">
                        <button onclick="history.back()" class="btn btn-sm btn-dark waves-effect waves-light d-flex mb-2" style="width: max-content;"><i class="bx bx-left-arrow-alt fs-4"></i> </button>
                        <h3 class="new-center-heading text-muted ml-3 ms-3"><?= $report_type == 'ecp' ? "All ECP Reports" : "All SDT Reports" ?></h3>
                    </div>

                    <!-- <button onclick="history.back()" class="btn btn-sm btn-dark waves-effect waves-light d-flex">
                        <i class="bx bx-left-arrow-alt fs-4"></i> Back
                    </button> -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-4">

                                        <!-- filter by franchise type -->
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

                                        <!-- Filter by manager name -->
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

                                        <!-- filter by center name -->
                                        <div class="col-md-4" style="display:flex;flex-direction:column;">
                                            <div style="width:100%;">
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

                                    </div>

                                    <div class="row">
                                        <div style="width: 70%;">
                                            <!-- Date Filters -->
                                            <div class="mt-3" style="display: flex; justify-content:center;align-items:center;">
                                                <div style="display: flex; justify-content:center;align-items:center;">
                                                    <div style="width:40%;">
                                                        <lable>Select Date: </lable>
                                                    </div>
                                                    <div class="ms-2" style="width:60%;">
                                                        <input type="date" name="center_date_from" class="form-control mydate" placeholder="Select Date From" value="" id="center_date_from">
                                                    </div>
                                                </div>
                                                <div class="ms-2">
                                                    <input type="date" name="center_date_end" class="form-control mydate" placeholder="Select Date End" value="" id="center_date_end">
                                                </div>
                                                <div class="ms-2">
                                                    <button class="btn btn-primary clear_date">Clear</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="width: 30%;">
                                            <div class="pl-2 pr-2" style="display:flex; align-items:center; justify-content:space-between; ">
                                                <div>
                                                    <lable style="color:#003032; font-size:large;"><b> <?= $report_type == 'ecp' ? "Total EECP Reports" : "Total SDT Reports" ?></b> </lable>
                                                </div>
                                                <div class="ms-2">
                                                    <p class="text-end mt-2" style="color:#3980c0; font-size:medium;" id="total_patients_retrived">100000</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- end row -->
                                    <div class="table-responsive mb-4">
                                        <table class="table table-centered table-nowrap mb-0" id="center_master_table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 50px;">Sr. No.
                                                    </th>
                                                    <th scope="col">Patient Name</th>
                                                    <th scope="col">Complete Sitting</th>
                                                    <th scope="col">Total Sitting</th>
                                                    <th scope="col">Paid Price</th>
                                                    <th>Remaining Price</th>
                                                    <th>Status</th>
                                                    <th id="date_p">Date</th>
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

        function mytable() {
            var select_center_type = $('#select_center_type').val();
            var select_center = $('#select_center').val();
            var center_date_from = $('#center_date_from').val();
            var center_date_end = $('#center_date_end').val();
            var hid_value = $('#hid_inp').val();
            var url_ajax = hid_value == '' ? "" : "../";
            var type_value = $('#type_inp').val();
            var manager_name = $("#select_manager_name").val();



            var dataTable = $('#center_master_table').DataTable({
                "searching": true,
                "processing": true,
                "serverSide": true,
                "responsive": true,
                order: [
                    [7, 'desc']
                ],
                "iDisplayLength": 10,
                "rowCallback": function(nRow, aData, iDisplayIndex) {
                    var oSettings = this.fnSettings();
                    $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                    return nRow;
                },

                "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 1, 2, 3, 4, 5, 6]
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
                    "emptyTable": "No Reports Found",
                },

                "ajax": {
                    url: url_ajax + "../Auth/action_report_details.php", // json datasource
                    type: "post", // method  , by default get
                    data: {
                        hid: hid_value,
                        type: type_value,
                        select_center_type: select_center_type,
                        select_center: select_center,
                        center_date_from: center_date_from,
                        center_date_end: center_date_end,
                        manager_name: manager_name,
                    },
                    error: function() { // error handling
                        $(".patient_master_table-error").html("");
                        $("#center_master_table").append('<tbody class="patient_master_table-error"><tr><th colspan="8" style="text-align: center;">No Patient Found.</th></tr></tbody>');
                        $("#center_master_table_processing").css("display", "none");
                    },
                },

                "initComplete": function(settings, json) {
                    $("#total_patients_retrived").text(json.recordsFiltered);
                },
                bDestroy: true,
            });

            $('#search').keyup(function() {
                dataTable.search($(this).val()).draw();
            });

            $('#date_p').click(function() {
                var order = ascending ? 'desc' : 'asc';
                dataTable.order([7, order]).draw();
                ascending = !ascending;
            });
        };

        mytable();


        // Changing table based on center type
        $('#select_center_type').on('change', function() {
            var type = $(this).val();
            var ajax1 = $.ajax({
                url: "../Auth/action_get_center_list.php?list=" + type,
                method: "GET",
                dataType: "JSON",
            }).done(function(result) {
                $('#select_center').html(result);
            });

            var ajax2 = $.ajax({
                url: "../Auth/action_get_all_manager_details.php?list=" + type,
                method: "GET",
                dataType: "JSON",
            }).done(function(result) {
                $('#select_manager_name').html(result);
            });

            $.when(ajax1, ajax2).done(function() {
                mytable(); // Calling function when both AJAX calls are completed
            });
            mytable();
        })

        // Function to update table data || center names based on their manager names
        $('#select_manager_name').on('change', function() {
            mytable();

            var manager_name = $(this).val();

            var ajax2 = $.ajax({
                url: "../Auth/action_get_center_list.php?manager_name=" + manager_name,
                method: "GET",
                dataType: "JSON",
            }).done(function(result) {
                $('#select_center').html(result);
            });

            $.when(ajax2).done(function() {
                mytable(); // Calling function when both AJAX calls are completed
            });
        })


        // Changing table based on center name
        $('#select_center').on('change', function() {
            mytable();
        })

        // Changing table based on date satrt
        $('#center_date_from').on('change', function() {
            if ($('#center_date_end').val() != "") {
                mytable();
            }
        })

        // Changing table based on date end
        $('#center_date_end').on('change', function() {
            if ($('#center_date_from').val() != "") {
                mytable();
            }
        })

        // Changing table based on clearing date
        $('.clear_date').on('click', function() {
            $('#center_date_from').val("");
            $('#center_date_end').val("");
            mytable();
        })
    </script>

</body>

</html>