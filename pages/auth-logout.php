<?php include_once '../init.php'; ?>
<?php include_once HEAD_TOP; ?>
<?php
session_destroy();
?>

<head>

    <title><?php echo $language["Log_Out"]; ?> | SAAOL - Admin & Dashboard</title>

    <?php include_once HEAD; ?>


</head>

<?php include '../components/body.php'; ?>

<div class="authentication-bg min-vh-100">
    <div class="bg-overlay"></div>
    <div class="container">
        <div class="d-flex flex-column min-vh-100 px-3 pt-4">
            <div class="row justify-content-center my-auto">
                <div class="col-md-8 col-lg-6 col-xl-5">

                    <div class="text-center mb-4">
                        <a href="<?= home_path() ?>">
                            <img src="assets/images/saaol_logo.webp" alt="" height="45">
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mt-3">
                                <div class="avatar-xl mx-auto">
                                    <div class="avatar-title bg-light text-primary h1 rounded-circle">
                                        <i class="bx bxs-user"></i>
                                    </div>
                                </div>
                                <div class="mt-4 pt-2">
                                    <h5>You are Logged Out</h5>
                                    <p class="text-muted font-size-15">Thank you for using <span class="fw-semibold text-dark">SAAOL</span></p>
                                    <!-- <div class="mt-4">
                                        <a href="<?= home_path() ?>" class="btn btn-primary w-100 waves-effect waves-light">Sign In</a>
                                    </div>                                                                   -->
                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center text-muted p-4">
                        <p class="text-white-50">© <script>
                                document.write(new Date().getFullYear())
                            </script> Crafted with <i class="mdi mdi-heart text-danger"></i> by SAAOL</p>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- end container -->
</div>
<!-- end authentication section -->

<?php include_once SCRIPT; ?>

</body>

</html>