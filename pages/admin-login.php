<?php
// Initialize the session

include_once "../config.php";
include_once "../includes/function.php";
include_once "../includes/route.inc.php";



error_reporting(1);
if (isset($_GET['_security_id'])) {
    $security_id = $_GET['_security_id'];
    if ($security_id == 'sdsdsr7hf87hfe8fe7hf87347rhewuh873das6') {
    } else {
        header("location:" . home_path());
    }
} else {
    header("location:" . home_path());
}



session_start();

function get_erp_access_menu($DB, $uid)
{
    $from_new_query = "FROM " . DB_PREFIX . "user_master WHERE um_id = '$uid' AND um_del = '0'";
    $sql = "SELECT erp_menu $from_new_query";
    $qry = $DB->prepare($sql);
    $qry->execute();
    $ResultsList = $qry->fetchAll();
    return $ResultsList;
}



// Check if the user is already logged in, if yes then redirect him to index page
if (isset($_SESSION["loggedin"]) === true) {
    header("location:" . home_path());
    exit;
}



// Include config file


// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty



    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $user_name = trim($_POST["username"]);
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter your password.";
        } else {
            $Password = trim(md5($_POST["password"]));

            try {

                $sqllogin = "SELECT * FROM " . $DB_Prefix . "user_master WHERE user_name = '$user_name' AND password = '$Password' AND um_del='0' AND erp_role='admin'";
                $stmtlogin = $DB->prepare($sqllogin);
                $stmtlogin->execute();
                $Logincount = $stmtlogin->rowCount();

                if ($Logincount > 0) {
                    $resultslogin = $stmtlogin->fetch();

                    $UserId = $resultslogin['um_id'];
                    // $HospitalId = $resultslogin['hm_id'];    


                    if (!empty($UserId)) {

                        // $ArrayHmId = explode(",", $HospitalId);
                        $RandomIdSession = $resultslogin['doctor_unique_id'];
                        $_SESSION['saaol_main_user'] = $RandomIdSession;

                        // $HospitalBusinessSession = $ArrayHmId[0];
                        // $_SESSION['saaol_main_hospital'] = $HospitalBusinessSession;

                        $_SESSION['action_lock'] = 0;

                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $UserId;
                        $_SESSION["username"] = $user_name;

                        // $_SESSION["ERP_ACCESS"] = "1,2";
                        $get_erp_access =  get_erp_access_menu($DB, $UserId);
                        $_SESSION["ERP_ACCESS"] = $get_erp_access['0']['erp_menu'];
                        unset($_SESSION['err_msg']);
                        header("location:" . home_path());
                    } else {

                        $_SESSION['err_msg'] = "Sorry!! You can not login in admin panel.";
                    }
                } else {

                    $_SESSION['err_msg'] = "Invalid User Name or password. Please Enter correct User Name and password.";
                    $username_err = "Invalid UserName";
                    $password_err = "Invalid PassWord";
                }
            } catch (Exception $ex) {
                $_SESSION['err_msg'] = "Invalid User Name or password. Please Enter correct User Name and password.";
                $username_err = "Invalid Username";
                $password_err = "Invalid Password";
            }
        }
    }

    // Check if password is empty



}
?>

<?php include_once '../components/head-main.php'; ?>

<head>

    <title><?php echo $language["Login"]; ?> | SAAOL - Admin & Dashboard Template</title>

    <?php include_once '../components/head.php'; ?>

</head>

<?php include '../components/body.php'; ?>

<div class="authentication-bg min-vh-100">
    <div class="bg-overlay"></div>
    <div class="container">
        <div class="d-flex flex-column min-vh-100 px-3 pt-4">
            <div class="row justify-content-center my-auto">
                <div class="col-md-8 col-lg-6 col-xl-5">

                    <div class="text-center mb-4 " style="display:flex;align-items:center;justify-content:center;">
                        <a href="<?= home_path() ?>">
                            <img src="<?= get_assets() ?>images/logo-sm.svg" alt="" height="45"> <span class="logo-txt" style="font-size:35px;font-weight:600;">SAAOL ERP</span>
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h3 class="text-primary">Admin Login</h3>
                            </div>
                            <?php $actionurl = htmlspecialchars($_SERVER["PHP_SELF"]) ?>
                            <div class="p-2 mt-4">
                                <form method="post" action="<?= home_path() . "/admin-login/sdsdsr7hf87hfe8fe7hf87347rhewuh873das6" ?>">

                                    <div class="mb-3 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="">
                                        <span class="text-danger"><?php echo $username_err; ?></span>
                                    </div>

                                    <div class="mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="userpassword" name="password" value="" placeholder="Enter password">
                                        <span class="text-danger"><?php echo $password_err; ?></span>
                                    </div>


                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Log In</button>
                                    </div>


                                </form>
                            </div>

                        </div>
                    </div>

                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center p-4">
                        <p class="text-white-50">© <script>
                                document.write(new Date().getFullYear())
                            </script> SAAOL ERP Crafted with <i class="mdi mdi-heart text-danger"></i> by SAAOL</p>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- end container -->
</div>
<!-- end authentication section -->

<?php include_once '../components/script.php'; ?>

</body>

</html>