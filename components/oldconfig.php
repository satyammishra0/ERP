<?php

// 
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

// $Mdb_username = 'saaol_erp_dashboard_user';
// $Mdb_password = 'H@6G1Py1+A](';
// $Mdb_name = 'saaol_erp_dashboard';
// $Mdb_host = 'localhost';
$Mdb_username = 'root';
$Mdb_password = '';
$Mdb_name = 'saool_crm';
$Mdb_host = 'localhost';
$DB_Prefix = "tbl_";
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// error_reporting(0);

define('DB_DRIVER', 'mysql');
define("DB_HOST", $Mdb_host);
define("DB_USER", $Mdb_username);
define("DB_PASSWORD", $Mdb_password);
define("DB_DATABASE", $Mdb_name);
define("DB_PREFIX", $DB_Prefix);

// basic options for PDO 
$dboptions = array(
    PDO::ATTR_PERSISTENT => FALSE,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

//connect with the server
try {
    $DB = new PDO(DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_DATABASE, DB_USER, DB_PASSWORD, $dboptions);
} catch (Exception $ex) {
    echo ($ex->getMessage());
    die;
}

date_default_timezone_set("Asia/Kolkata");

ini_set('xdebug.max_nesting_level', 50000000000000);
ini_set('memory_limit', -1);
ini_set('max_execution_time', 4500000000); //300 seconds = 5 minutes
ini_set("pcre.backtrack_limit", "500000000000");
ini_set('upload_max_filesize', '150000M'); // For image upload
ini_set('post_max_size', '10000000M'); // For image upload
ini_set('max_input_time', 300000000); // For image upload
ini_set('innodb_log_file_size', '512M'); // For database
ini_set('max_allowed_packet', '16M');  // For database

$sqlList = "SELECT tss_value FROM " . DB_PREFIX . "site_settings WHERE tss_parameter = 'site_url'";
$qryList = $DB->prepare($sqlList);
$qryList->execute();
$row = $qryList->fetch();
$Site_Url =  $row['tss_value'];

$Main_Site_Url =  $Site_Url;

$UrlMain = $_SERVER['REQUEST_URI']; // this gives you /folder1/folder2/THIS_ONE/file.php
$ArrayUrlMain = explode('/', $UrlMain); // splits folders in array
$FolderNameMainPage = end($ArrayUrlMain);
$FolderNameMain = prev($ArrayUrlMain);




// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'saaol_erp_dashboard_user');
// define('DB_PASSWORD', 'H@6G1Py1+A](');
// define('DB_NAME', 'saaol_erp_dashboard');

// /* Attempt to connect to MySQL database */
// $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// // Check connection
// if($link === false){
//     die("ERROR: Could not connect. " . mysqli_connect_error());
// }

// $gmailid = ''; // YOUR gmail email
// $gmailpassword = ''; // YOUR gmail password
// $gmailusername = ''; // YOUR gmail User name
