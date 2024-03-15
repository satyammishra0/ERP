<?php include_once '../init.php';

if (!in_array('3', explode(',', $_SESSION['ERP_ACCESS']))) {
    echo "Sorry You do not have permission to access this page";
    exit;
}

// Function to populate all manager names in dropdown

function get_manager_details_case_center_type($DB)
{
    $fetchManagerQuery = "SELECT `manager_name` FROM " . DB_PREFIX  . "hospital_master WHERE `hm_del` = '0'";
    $prepFetchManagerQuery = $DB->prepare($fetchManagerQuery);
    $prepFetchManagerQuery->execute();
    $resultFetchManagerQuery = $prepFetchManagerQuery->fetchAll();
    return $resultFetchManagerQuery;
}
?>

<?php include_once HEAD_TOP; ?>

<head>

    <title><?php echo "Dashboard" ?> | SAAOL </title>

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
                    <button onclick="history.back()" class="btn btn-sm btn-dark waves-effect waves-light d-flex"><i class="bx bx-left-arrow-alt fs-4"></i> Back</button>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <!--<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus me-2"></i> Add New</a>-->
                                                <h3 class="new-center-heading text-muted mb-0">All Patient List</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="" style="display:flex;align-items:center;">
                                                <div style="width:30%;">
                                                    <lable>Select Center Type: </lable>
                                                </div>
                                                <div class="ms-2" style="width:70%;">
                                                    <select class="form-select" name="select_center_type" id="select_center_type">
                                                        <option value="0">All</option>
                                                        <option value="1">Owner</option>
                                                        <option value="2">Partnership</option>
                                                        <option value="3">Franchise</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mt-2" style="display:flex;align-items:center;">
                                                <div style="width:30%;">
                                                    <lable>Managers name: </lable>
                                                </div>
                                                <div class="ms-2" style="width:70%;">
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

                                            <div class="mt-2" style="display:flex;align-items:center;">
                                                <div style="width:30%;">
                                                    <lable>Select Center: </lable>
                                                </div>
                                                <div class=" ms-2" style="width:70%;">
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
                                            <div class="d-flex justify-content-between mt-3">
                                                <div>
                                                    <input type="date" name="center_date_from" class="form-control mydate" placeholder="Select Date From" value="" id="center_date_from">
                                                </div>

                                                <div class="ms-2">
                                                    <input type="date" name="center_date_end" class="form-control mydate" placeholder="Select Date End" value="" id="center_date_end">
                                                </div>
                                                <div class="ms-2">
                                                    <button class="btn btn-primary clear_date">Clear</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <h3 class="text-end new-center-heading text-muted mb-0">Total Patient</h3>
                                            <p class="text-end" id="total_patients_retrived">1000</p>
                                        </div>


                                    </div>
                                    <!-- end row -->
                                    <div class="table-responsive mb-4">
                                        <table class="table table-centered table-nowrap mb-0" id="patient_master_table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 50px;">Sr. No.</th>
                                                    <th scope="col">Patient Name</th>
                                                    <th scope="col">Center Name</th>
                                                    <th scope="col">Recommended <br>
                                                        EECP | SDT</th>
                                                    <th scope="col" id="date_p">Added On</th>
                                                    <th scope="col" style="width: 200px;">Action</th>
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
        // Modifying the date input field with repected library
        $(".mydate").flatpickr();


        // Function to populate table data 

        function mytable() {
            var select_center_type = $('#select_center_type').val();
            var select_center = $('#select_center').val();
            var center_date_from = $('#center_date_from').val();
            var center_date_end = $('#center_date_end').val();
            var manager_name = $('#select_manager_name').val();

            // initialising the datatable and setting attributes
            var dataTable = $('#patient_master_table').DataTable({
                "searching": true,
                "processing": true,
                "serverSide": true,
                "responsive": true,
                order: [
                    [3, 'asc']
                ],
                "iDisplayLength": 10, //How much data to  diplay in page  
                "rowCallback": function(nRow, aData, iDisplayIndex) { //
                    var oSettings = this.fnSettings();
                    $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                    return nRow;
                },
                "columnDefs": [{ //Function to allow specific behaviour to specific columns
                        "orderable": false,
                        "targets": [0, 1, 2, 4]
                    },
                    {
                        "orderable": true,
                        "targets": []
                    }
                ],
                "lengthMenu": [ //data in dropdown to show how muc data to show each page
                    [10, 50, 200, 1000, -1],
                    [10, 50, 200, 1000, "All"]
                ],
                "language": { //Tooltip
                    "emptyTable": "No Patient(s) added",
                },

                "ajax": {
                    url: "Auth/action_get_all_patient.php",
                    type: "post",
                    data: {
                        select_center_type: select_center_type,
                        select_center: select_center,
                        center_date_from: center_date_from,
                        center_date_end: center_date_end,
                        manager_name: manager_name
                    },
                    // this is the attribute setted in which the data from the backend will come here "DATA"
                    dataSrc: "data",
                },
                // Populating the table rows with data getting in obj form
                "columns": [{
                        "data": 0
                    },
                    {
                        "data": 1
                    },
                    {
                        "data": 2
                    },
                    {
                        "data": 3
                    },
                    {
                        "data": 4
                    },
                    {
                        "data": 5
                    }
                ],
                // this is the callback which runs only the data of table is populated and query is completed
                "initComplete": function(settings, json) {
                    // Update the text of the p tag with id "total_patients_retrived" with the value of "recordsFiltered"
                    $("#total_patients_retrived").text(json.recordsFiltered);
                },
                bDestroy: true, //set attribute to destroy existing table whenever condition changes
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

        // Populating table data based on the center change
        $('#select_center').on('change', function() {
            mytable(); // Calling function when both AJAX calls are completed
        })

        // Populating table data depending on start date change
        $('#center_date_from').on('change', function() {
            if ($('#center_date_end').val() != "") {
                mytable();
            }
        })

        // Populating table data based on the ending date change
        $('#center_date_end').on('change', function() {
            if ($('#center_date_from').val() != "") {
                mytable();
            }
        })

        // Populating table data based on the both the date selected
        $('.clear_date').on('click', function() {
            $('#center_date_from').val("");
            $('#center_date_end').val("");
            mytable();
        })
    </script>

</body>

</html>