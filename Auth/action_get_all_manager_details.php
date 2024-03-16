<?php

// Setting up init and error files
include '../init.php';
error_reporting(1);
ini_set('display_errors', true);


// Code to fetch manager name based on center type and active hospital 
if (isset($_REQUEST['list'])) {
    $centerTypeID = $_REQUEST['list'];

    $fetchManagerQuery = "SELECT DISTINCT `manager_name` AS distinct_manager_name  FROM " . DB_PREFIX . "hospital_master WHERE `hm_del` = '0'";

    if ($centerTypeID != 0) {
        $fetchManagerQuery .= " AND `ht_id` = '$centerTypeID'";
    }

    $prepCenterType = $DB->prepare($fetchManagerQuery);
    $prepCenterType->execute();

    $managerList = $prepCenterType->fetchAll();

    $data[] = '<option value="0">All</option>';

    foreach ($managerList as $row) {
        $data[] = '<option value="' . $row['distinct_manager_name'] . '">' . $row['distinct_manager_name'] . '</option>';
    }
    echo json_encode($data);
}