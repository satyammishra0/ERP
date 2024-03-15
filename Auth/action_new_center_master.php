<?php

include_once '../init.php';

function get_ecp_count_from_hospital_id(PDO $DB, $HospitalId)
{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HospitalId' AND package_type = '2' AND tppm_del = '0' AND (tppm_status = '1' OR tppm_status = '0')";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}
function get_sdt_count_from_hospital_id(PDO $DB, $HospitalId)
{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HospitalId' AND package_type = '1'  AND tppm_del = '0' AND (tppm_status = '1' OR tppm_status = '0')";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}


error_reporting(1);
ini_set('display_errors', true);


$requestData = $_REQUEST;

$start_date = date("Y-m-d", strtotime("first day of previous month"));
$end_date = date("Y-m-d", strtotime("last day of previous month"));


if (isset($_POST['select_center_type']) && $_POST['select_center_type'] != 0) {

    $select_center_type = $_POST['select_center_type'];

    $from_new_query = "FROM `" . DB_PREFIX . "hospital_master` WHERE hm_del = '0' AND (date(hm_opening_date) BETWEEN '$start_date' AND '$end_date') AND ht_id = '$select_center_type'";
} else {
    $from_new_query = "FROM `" . DB_PREFIX . "hospital_master` WHERE hm_del = '0' AND (date(hm_opening_date) BETWEEN '$start_date' AND '$end_date')";
}

// echo $from_new_query;
// die();

$sqlListType = "SELECT count(*) as cnt $from_new_query";
$qryListType = $DB->prepare($sqlListType);
$qryListType->execute();
$ResultsList = $qryListType->fetch();
$totalData = $ResultsList['cnt'];
$totalFiltered = $totalData;

$sql = "SELECT * $from_new_query";

$array = array();


if (!empty($requestData['search']['value'])) {

    $sql .= " AND (hm_name LIKE '%" . $requestData['search']['value'] . "%')";
}

// if(!empty($_POST['center_date_from']) && !empty($_POST['center_date_from'])){
//     $from = $_POST['center_date_from'];
//     $end = $_POST['center_date_end'];


//      $sql .= " AND date(hm_opening_date) BETWEEN '$from' AND ' $end'";

// }

if (isset($_POST['select_center_zone']) && !empty($_POST['select_center_zone'])) {
    $center_zone = $_POST['select_center_zone'];


    $sql .= " AND hm_zone = '$center_zone'";
}

$sql .= !empty(total_hospitals) ? " AND hm_id IN(" . implode(',', total_hospitals) . " );" : "";



$qry = $DB->prepare($sql);
$qry->execute();
$totalFiltered = $qry->rowCount();

$sql .= " ORDER BY hm_id ASC LIMIT " . $requestData['start'] . " ," . $requestData['length'];
$qry = $DB->prepare($sql);
$qry->execute();
$ResultsList = $qry->fetchAll();


$data = array();
$CounterNumber = 0;



foreach ($ResultsList as $row) {
    $CounterNumber++;

    $center_name = $row['hm_name'];
    $manager = $row['manager_name'];

    $center_status1 = $row['hm_del'];
    if ($center_status1 == 0) {
        $center_status = "Active";
    } else {
        $center_status = "Inactive";
    }


    $lms_count = get_all_count_active_leads($DB, $row['hm_id']);
    $ecp_count = get_ecp_count_from_hospital_id($DB, $row['hm_id']);
    $sdt_count = get_sdt_count_from_hospital_id($DB, $row['hm_id']);

    $nestedData = array();

    $nestedData[] = $CounterNumber;
    $nestedData[] = $center_name;
    $nestedData[] = $manager;
    $nestedData[] = $center_status;
    $nestedData[] = $lms_count;
    $nestedData[] = $ecp_count;
    $nestedData[] = $sdt_count;
    $data[] = $nestedData;
    $ArryDia = empty($ArryDia);
}




$json_data = array(
    "draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal"    => intval($totalData),  // total number of records
    "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
