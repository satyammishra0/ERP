<?php
include_once '../init.php';

error_reporting(1);
ini_set('display_errors', true);

$requestData = $_REQUEST;



if (isset($_POST['type'])) {
    $type = $_POST['type'];
    if ($type == 'ecp') {
        if ($_POST['hid'] != '') {
            $hid = $_POST['hid'];
            $from_new_query = "FROM tbl_patient_package_master tppm LEFT JOIN `tbl_patient_master` tpm ON tppm.patient_unique_id = tpm.patient_unique_id LEFT JOIN `tbl_hospital_master` thm ON thm.hm_id = tpm.hm_id WHERE tppm.hm_id = '$hid' AND tppm.package_type = '2' AND tppm.tppm_del = '0' AND (tppm.tppm_status = '1' OR tppm.tppm_status = '0')";
        } else {
            $from_new_query = "FROM tbl_patient_package_master tppm LEFT JOIN `tbl_patient_master` tpm ON tppm.patient_unique_id = tpm.patient_unique_id LEFT JOIN `tbl_hospital_master` thm ON thm.hm_id = tpm.hm_id WHERE tppm.package_type = '2' AND tppm.tppm_del = '0' AND (tppm.tppm_status = '1' OR tppm.tppm_status = '0')";
        }
    } else if ($type == 'sdt') {
        if ($_POST['hid'] != '') {
            $hid = $_POST['hid'];
            $from_new_query = "FROM tbl_patient_package_master tppm LEFT JOIN `tbl_patient_master` tpm ON tppm.patient_unique_id = tpm.patient_unique_id LEFT JOIN `tbl_hospital_master` thm ON tppm.hm_id = thm.hm_id WHERE tppm.hm_id = '$hid' AND tppm.package_type = '1' AND tppm.tppm_del = '0' AND (tppm.tppm_status = '1' OR tppm.tppm_status = '0')";
        } else {
            $from_new_query = "FROM tbl_patient_package_master tppm LEFT JOIN `tbl_patient_master` tpm ON tppm.patient_unique_id = tpm.patient_unique_id LEFT JOIN `tbl_hospital_master` thm ON tppm.hm_id = thm.hm_id WHERE tppm.package_type = '1' AND tppm.tppm_del = '0' AND (tppm.tppm_status = '1' OR tppm.tppm_status = '0')";
        }
    }
} else {
    echo "error";
}


$from_new_query .= !empty(total_hospitals) ? " AND tppm.hm_id IN(" . implode(',', total_hospitals) . ")" : "";


if (isset($_POST['select_center_type']) && $_POST['select_center_type'] != 0) {
    $select_center_type = $_POST['select_center_type'];
    $from_new_query .= " AND thm.ht_id = '$select_center_type'";
}

if (isset($_POST['select_center']) && !empty($_POST['select_center'])) {
    $center_id = $_POST['select_center'];
    $from_new_query .= " AND thm.hm_id = '$center_id'";
}

if (!empty($requestData['search']['value'])) {
    $from_new_query .= " AND (CONCAT(tpm.pm_first_name ,' ', tpm.pm_middle_name,' ',tpm.pm_last_name) LIKE '%" . $requestData['search']['value'] . "%')";
}
if (!empty($_POST['center_date_from']) && !empty($_POST['center_date_from'])) {
    $from = $_POST['center_date_from'];
    $end = $_POST['center_date_end'];
    $from_new_query .= " AND date(tppm.tppm_date) BETWEEN '$from' AND ' $end'";
}


// Adding conditions based on manager name
if (isset($_POST['manager_name']) && !empty($_POST['manager_name'])) {
    $manager_name = $_POST['manager_name'];
    $from_new_query .= " AND thm.manager_name = '$manager_name'";
}

$sqlListType = "SELECT count(*) as cnt $from_new_query";
$qryListType = $DB->prepare($sqlListType);
$qryListType->execute();
$ResultsList = $qryListType->fetch();
$totalData = $ResultsList['cnt'];
$totalFiltered = $totalData;


$sql = "SELECT CONCAT(tpm.pm_first_name ,' ', tpm.pm_middle_name,' ',tpm.pm_last_name) as P_name, tppm.total_price, tppm.paid_price, tppm.remaining_price, tppm.tppm_date , tppm.tppm_id , tppm.patient_unique_id, tppm.sessions, tppm.free_session  $from_new_query";

$array = array();

// print_r($requestData['order']['0']['column']);
if (!empty($requestData['order']['0']['column'])) {
    if ($requestData['order']['0']['dir'] == "desc") {
        $sql .= " ORDER BY tppm.tppm_date DESC";
    } else {
        $sql .= " ORDER BY tppm.tppm_date ASC";
    }
}

// echo $sql;
$sql .= " LIMIT " . $requestData['start'] . " ," . $requestData['length'];

$qry = $DB->prepare($sql);
$qry->execute();
$ResultsList = $qry->fetchAll();

$data = array();
$CounterNumber = 0;

foreach ($ResultsList as $row) {
    $CounterNumber++;

    $patient_name = "<a href='" . home_path() . '/patient-details/' .  base64_encode($row['patient_unique_id']) . "'>" . $row['P_name'] . "</a>";
    $total_price = $row['total_price'];
    $patient_id = $row['patient_unique_id'];
    $paid_price = $row['paid_price'];
    $rem_price = $row['remaining_price'];
    $tppm_date = $row['tppm_date'];
    $tppm_id = $row['tppm_id'];
    $sessions = $row['sessions'];
    $free_session = $row['free_session'];

    $total_session = $sessions + $free_session;

    $CountCompltedTreatment = count_patient_complted_treatment_session_from_package_id($DB, $patient_id, $tppm_id);

    $nestedData = array();

    if ($total_session == $CountCompltedTreatment) {
        $status_patient = "<span class='badge badge-soft-success font-size-12'>Complete</span>";
    } else {
        $status_patient = "<span class='badge badge-soft-warning font-size-12'>Pending</span>";
    }

    $dateTime = new DateTime($tppm_date);
    $tppm_date_format = $dateTime->format('d-m-y');

    $nestedData[] = $CounterNumber;
    $nestedData[] = $patient_name;
    $nestedData[] = $CountCompltedTreatment;
    $nestedData[] = $total_session;
    $nestedData[] = $paid_price;
    $nestedData[] = $rem_price;
    $nestedData[] = $status_patient;
    $nestedData[] = $tppm_date_format;
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


// systolic ranges
