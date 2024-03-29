<?php include_once '../init.php' ?>

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

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <!--<a href="javascript:void(0);" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus me-2"></i> Add New</a>-->
                                                <h3 class="new-center-heading text-muted mb-0">New Center List</h3>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="" style="display:flex;align-items:center;">
                                                <div style="width:30%;">
                                                    <lable>Select Center Type: </lable>
                                                </div>
                                                <div class=" ms-2" style="width:70%;">
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
                                                    <lable>Select Zone: </lable>
                                                </div>
                                                <div class=" ms-2" style="width:70%;">
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

                                            <!--<div class="d-flex justify-content-between mt-3">-->
                                            <!--    <div>-->
                                            <!--        <input type="date" name="center_date_from" class="form-control mydate" placeholder="Select Date From" value="" id="center_date_from">-->
                                            <!--    </div>-->

                                            <!--    <div class="ms-2">-->
                                            <!--        <input type="date" name="center_date_end" class="form-control mydate" placeholder="Select Date End" value="" id="center_date_end">-->
                                            <!--    </div>-->
                                            <!--    <div class="ms-2">-->
                                            <!--        <button class="btn btn-primary clear_date">Clear</button>-->
                                            <!--    </div>-->

                                            <!--</div>-->



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
                                                    <th scope="col">Center Name</th>
                                                    <th scope="col">Manager</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Lms</th>
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
            var select_center_zone = $('#select_center_zone').val();
            // var select_center = $('#select_center').val();
            var center_date_from = $('#center_date_from').val();
            var center_date_end = $('#center_date_end').val();
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

                    "emptyTable": "No Patient(s) added",


                },

                "ajax": {

                    url: "Auth/action_new_center_master.php", // json datasource
                    type: "post", // method  , by default get
                    data: {
                        select_center_type: select_center_type,
                        select_center_zone: select_center_zone,
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


        };

        mytable();

        $('#select_center_type').on('change', function() {




            mytable();
        })

        $('#select_center_zone').on('change', function() {
            mytable();
        })

        // $('#select_center').on('change', function() {
        //     mytable();
        // })



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