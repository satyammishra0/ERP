<?php include '../init.php';

if (!in_array('2', explode(',', $_SESSION['ERP_ACCESS']))) {
    echo "Sorry You do not have permission to access this page";
    exit;
}


?>


<?php include_once HEAD_TOP; ?>

<head>

    <title><?php echo "Dashboard" ?> | SAAOL - Admin & Dashboard Template</title>

    <?php include HEAD; ?>



    <style>
        .under_line_text {
            text-decoration: underline !important;
        }

        .badge {
            padding: 0.15em 0.6em 0.35em 0.6em !important;
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
                    <!-- Back Button with page title -->
                    <div class="d-flex mb-2" style="display:flex;align-items:center;">
                        <button onclick="history.back()" class="btn btn-sm btn-dark waves-effect waves-light d-flex mb-2" style="width: max-content;"><i class="bx bx-left-arrow-alt fs-4"></i> </button>
                        <h3 class="new-center-heading text-muted ml-3 ms-3">All Center List</h3>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="row">
                                            <!-- Center type filters -->

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

                                            <!-- Zone wise filters -->

                                            <div class="col-md-4" style="display:flex;flex-direction:column;">
                                                <div>
                                                    <lable>Select Zone: </lable>
                                                </div>
                                                <div class="" style="width:100%;">
                                                    <select class="form-select" name="select_center_zone" id="select_center_zone">
                                                        <option value="0">All</option>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                        <option value="E">E</option>
                                                        <option value="F">F</option>
                                                        <option value="G">G</option>
                                                        <option value="H">H</option>
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

                                            <!-- Date Filters -->
                                            <div class="row mt-4">
                                                <div class="col-md-8 d-flex justify-content-between">
                                                    <div style="width:100%;">
                                                        <lable>Select Date: </lable>
                                                    </div>
                                                    <div class="ms-2" style="width:100%;">
                                                        <input type="date" name="center_date_from" class="form-control mydate" placeholder="Select Date From" value="" id="center_date_from">
                                                    </div>
                                                    <div class="ms-2" style="width:100%;">
                                                        <input type="date" name="center_date_end" class="form-control mydate" placeholder="Select Date End" value="" id="center_date_end">
                                                    </div>
                                                    <div class="ms-2" style="width:100%;">
                                                        <button class="btn btn-primary clear_date">Clear</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="display:flex; align-items:center; justify-content:right; ">
                                                    <div class="pl-2 pr-2" style="display:flex; align-items:center; justify-content:center; ">
                                                        <div>
                                                            <lable style="color:#003032; font-size:large;"><b>Total Centers</b> </lable>
                                                        </div>
                                                        <div class="ms-2">
                                                            <p class="text-end " style="color:#3980c0; font-size:medium; margin:0;" id="total_patients_retrived">100000</p>
                                                        </div>
                                                    </div>
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
                                                    <th scope="col">Center Name</th>
                                                    <th scope="col">Manager</th>
                                                    <th scope="col">Leads</th>
                                                    <th scope="col">Patients</th>
                                                    <th scope="col">ECP</th>
                                                    <th scope="col">SDT</th>
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


        function mytable() {
            var select_center_type = $('#select_center_type').val();
            var select_center_zone = $('#select_center_zone').val();
            // var select_center = $('#select_center').val();
            var center_date_from = $('#center_date_from').val();
            var center_date_end = $('#center_date_end').val();
            var manager_name = $("#select_manager_name").val();
            var dataTable = $('#center_master_table').DataTable({
                "searching": true,
                "processing": true,
                "serverSide": false,
                "iDisplayLength": 10,
                "aLengthMenu": [
                    [10, 20, 50, 1000],
                    [10, 20, 50, "All"]
                ],
                "responsive": true,
                "ordering": false,
                "iDisplayLength": 10,
                "paging": true, // Enable pagination
                "pageLength": 10, // Set number of rows per page
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
                    url: "./Auth/action_get_center_master.php", // json datasource
                    type: "post", // method  , by default get
                    data: {
                        select_center_type: select_center_type,
                        select_center_zone: select_center_zone,
                        center_date_from: center_date_from,
                        center_date_end: center_date_end,
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
            var ajax2 = $.ajax({
                url: "Auth/action_get_all_manager_details.php?list=" + type,
                method: "GET",
                dataType: "JSON",
            }).done(function(result) {
                $('#select_manager_name').html(result);
            });

            $.when(ajax2).done(function() {
                mytable(); // Calling function when AJAX calls are completed
            });
        });


        // Populate manager name based on the zone type
        $('#select_center_zone').on('change', function() {
            var zone = $(this).val();
            var ajax1 = $.ajax({
                url: "Auth/action_get_all_manager_details.php?zoneName=" + zone,
                method: "GET",
                dataType: 'JSON',
            }).done(function(result) {
                $("#select_manager_name").html(result);
            })
            $.when(ajax1).done(function() {
                mytable();
            })
        });


        // Populating data acc to Onchange of the manager name
        $("#select_manager_name").on('change', function() {
            mytable();
        });


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