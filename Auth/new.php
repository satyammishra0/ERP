<?php
include_once '../init.php';

error_reporting(1);
ini_set('display_errors', true);

$requestData = $_REQUEST;


$patient_id = $requestData['patient_inp'];
// print_r($patient_id);

$from_new_query = "FROM " . DB_PREFIX . "treatment_master WHERE patient_unique_id = '$patient_id'";

function get_single_user_treatment_master_package_details_(PDO $DB, $patient_id)
{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE patient_unique_id = '$patient_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}

$sqlListType = "SELECT count(*) as cnt $from_new_query";
$qryListType = $DB->prepare($sqlListType);
$qryListType->execute();
$ResultsList = $qryListType->fetch();
$totalData = $ResultsList['cnt'];
$totalFiltered = $totalData;

$sql = "SELECT * $from_new_query";

$array = array();





$sql .= " ORDER BY ttm_date DESC";

$qry = $DB->prepare($sql);
$qry->execute();
$totalFiltered = $qry->rowCount();


$qry = $DB->prepare($sql);

// echo $sql;
$qry->execute();
$ResultsList = $qry->fetchAll();


$data = array();
$CounterNumber = 0;



foreach ($ResultsList as $row) {
    $CounterNumber++;

    if ($row['package_type'] == 1) {
        $packageType = "Detox";
    } else if ($row['package_type'] == 2) {
        $packageType = "EECP";
    }

    $PatientUniId = $row['patient_unique_id'];
    $tppm_date = $row['ttm_date'];
    $tppm_time = $row['ttm_time'];
    $added_on = date('d/m/Y', strtotime($tppm_date));
    $dr = get_user_master_details_from_id($DB, $row['um_id']);
    $dr_name = $dr['first_name'];


    $nestedData = array();

    $nestedData[] = $CounterNumber;
    $nestedData[] = $packageType;
    $nestedData[] = $tppm_date;
    $nestedData[] = $tppm_time;
    $nestedData[] = $dr_name;

    $data[] = $nestedData;
    $ArryDia = empty($ArryDia);
}




$json_data = array(
    "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    "recordsTotal" => intval($totalData), // total number of records
    "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data" => $data // total data array
);

echo json_encode($json_data); // send data as json format
