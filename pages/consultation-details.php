<?php include '../init.php'; ?>

<?php include_once HEAD_TOP; ?>

<?php 
$hid = $_GET['_hid'];


if (isset($hid)) {
    $from_new_query = "FROM " . DB_PREFIX . "hospital_master WHERE hm_id = '$hid' AND hm_del = '0'";
    $sql = "SELECT hm_name  $from_new_query";
    $qry = $DB->prepare($sql);
    $qry->execute();
    $ResultsList = $qry->fetchAll();

    print_r($ResultsList);
}
?>

<head>

    <title><?php echo "Dashboard" ?> | SAAOL - Admin & Dashboard Template</title>

    <?php include HEAD; ?>





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
                                <div class="card-body ">

                                    <div class="row mb-4">
                                        <div class="col-md-6">

                                            <div class="mx-3">
                                                <h2>
                                                    <?= isset($ResultsList) ? $ResultsList['0']['hm_name'] : "No Results" ?>
                                                </h2>

                                                <h3 class="new-center-heading text-muted mb-0">All Consultant Patient List</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-6">



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
                                                    <th scope="col">Docter Name</th>
                                                    <th scope="col">Date</th>

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

            // var select_center = $('#select_center').val();
            var center_date_from = $('#center_date_from').val();
            var center_date_end = $('#center_date_end').val();
            var hid_value = $('#hid_inp').val();
            // var type_value = $('#type_inp').val();
            console.log(hid_value);
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
                    url: "../Auth/action_consultation_details.php", // json datasource
                    type: "post", // method  , by default get
                    data: {
                        hid: hid_value,
                        // select_center: select_center,
                        center_date_from: center_date_from,
                        center_date_end: center_date_end,
                    },
                    error: function() { // error handling
                        $(".patient_master_table-error").html("");
                        $("#center_master_table").append('<tbody class="patient_master_table-error"><tr><th colspan="8" style="text-align: center;">No Patient Found.</th></tr></tbody>');
                        $("#center_master_table_processing").css("display", "none");
                    }
                },
                bDestroy: true,
            });

            $('#search').keyup(function() {
                dataTable.search($(this).val()).draw();
            });

            $('#center_date_end').on('change', function() {
                if ($('#center_date_from').val() != "") {
                    mytable();
                }
            })


        };




        mytable();
    </script>

</body>

</html>