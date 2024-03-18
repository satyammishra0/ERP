<?php

// Setting up init and error files
include '../init.php';
error_reporting(1);
ini_set('display_errors', true);


$fetchManagerQuery = "SELECT DISTINCT `manager_name` AS distinct_manager_name  FROM " . DB_PREFIX . "hospital_master WHERE `hm_del` = '0'";

// Code to fetch manager name based on center type and active hospital 
if (isset($_REQUEST['list'])) {
    $centerTypeID = $_REQUEST['list'];
    if ($centerTypeID != 0) {
        $fetchManagerQuery .= " AND `ht_id` = '$centerTypeID'";
    }
}

// If zone name is set then it fetches names based on zonenames
if (isset($_REQUEST['zoneName'])) {
    $zoneName = $_REQUEST['zoneName'];
    if ($zoneName != 0) {
        $fetchManagerQuery .= " AND `hm_zone` = '$zoneName'";
    }
}

$prepCenterType = $DB->prepare($fetchManagerQuery);
$prepCenterType->execute();

$managerList = $prepCenterType->fetchAll();

$data[] = '<option value="0">Select Name</option>';

foreach ($managerList as $row) {
    $data[] = '<option value="' . $row['distinct_manager_name'] . '">' . $row['distinct_manager_name'] . '</option>';
}
echo json_encode($data);
