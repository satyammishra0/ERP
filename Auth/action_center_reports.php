<?php

include_once '../init.php';

error_reporting(1);
ini_set('display_errors', true);


$requestData = $_REQUEST;

$from_new_query = " FROM `tbl_hospital_master` hm
LEFT JOIN `tbl_patient_package_master` PP ON hm.hm_id = PP.hm_id";

if (!empty($_POST['center_date_from']) && !empty($_POST['center_date_from'])) {
    $from = $_POST['center_date_from'];
    $end = $_POST['center_date_end'];


    $from_new_query .= " LEFT JOIN (
    SELECT hm_id, COUNT(hm_id) AS Consultant
    FROM `tbl_appointment_master`
    WHERE pam_status = '3' AND pam_del = '0'
    GROUP BY hm_id
    AND date(pam_app_date) BETWEEN '$from' AND ' $end'
) subquery ON hm.hm_id = subquery.hm_id
WHERE PP.tppm_del = '0' AND PP.tppm_status IN ('0', '1') AND date(PP.tppm_date) BETWEEN '$from' AND ' $end'";
} else {
    $from_new_query .= " LEFT JOIN (
    SELECT hm_id, COUNT(hm_id) AS Consultant
    FROM `tbl_appointment_master`
    WHERE pam_status = '3' AND pam_del = '0'
    GROUP BY hm_id
) subquery ON hm.hm_id = subquery.hm_id
WHERE PP.tppm_del = '0' AND PP.tppm_status IN ('0', '1')";
}



if (isset($_POST['select_center_type']) && $_POST['select_center_type'] != 0) {
    $select_center_type = $_POST['select_center_type'];

    $from_new_query .= " AND hm.ht_id = '$select_center_type'";
}
if (isset($_POST['select_center_zone']) && !empty($_POST['select_center_zone'])) {
    $center_zone = $_POST['select_center_zone'];
    $from_new_query .= " AND hm.hm_zone = '$center_zone'";
}

// Adding conditions based on manager name
if (isset($_POST['manager_name']) && !empty($_POST['manager_name'])) {
    $manager_name = $_POST['manager_name'];
    $from_new_query .= " AND hm.manager_name = '$manager_name'";
}


if (!empty($requestData['search']['value'])) {
    $from_new_query .= " AND (hm.hm_name LIKE '%" . $requestData['search']['value'] . "%');";
}

$sql = "SELECT hm.hm_id AS hospital_id,
    hm.hm_name AS hospital_name,
    COUNT(CASE WHEN PP.package_type = 2 THEN 1 END) AS EECP_count,
    COUNT(CASE WHEN PP.package_type = 1 THEN 1 END) AS SDT_count,
    IFNULL(subquery.Consultant, 0) AS Consultant_count $from_new_query";



$array = array();

$sql .= !empty(total_hospitals) ? " AND hm.hm_id IN(" . implode(',', total_hospitals) . " )" : "";

$sql .= " GROUP BY hm.hm_id, hm.hm_name";

$sqlListType = "SELECT count(*) as cnt $from_new_query";
$qryListType = $DB->prepare($sqlListType);
$qryListType->execute();
$ResultsList = $qryListType->fetch();
$totalData = $ResultsList['cnt'];
$totalFiltered = $totalData;



$qry = $DB->prepare($sql);
$qry->execute();
$totalFiltered = $qry->rowCount();

$sql .= " ORDER BY hm.hm_id ASC LIMIT " . $requestData['start'] . " ," . $requestData['length'];
$qry = $DB->prepare($sql);
$qry->execute();
$ResultsList = $qry->fetchAll();


$data = array();
$CounterNumber = 0;


// print_r($ResultsList);

foreach ($ResultsList as $row) {
    $CounterNumber++;

    $center_name = $row['hospital_name'];
    // $manager = $row['manager_name'];

    //   $center_status1 = $row['hm_del'];
    //   if($center_status1 == 0){
    //       $center_status = "Active";
    //   }else{
    //       $center_status = "Inactive";
    //   }

    // $last_lead_row = get_last_lead_entry_from_hospital($DB, $row['hm_id']);
    // $last_entry_date = date('Y-m-d', strtotime($last_lead_row['lm_created_date']));


    // $lms_count = get_all_count_converted_leads($DB, $row['hm_id']);
    $ecp_count = $row['EECP_count'];
    $sdt_count = $row['SDT_count'];
    $counsltation =  $row['Consultant_count'];

    $nestedData = array();


    $nestedData[] = $CounterNumber;
    $nestedData[] = $center_name;
    // $nestedData[] = $manager;
    // $nestedData[] = $last_entry_date;

    $nestedData[] = "<a href='" . home_path() . '/report-details/ecp/' .  $row['hospital_id'] . "'>" . $ecp_count . "</a>";
    $nestedData[] = "<a href='" . home_path() . '/report-details/sdt/' .  $row['hospital_id'] . "'>" . $sdt_count . "</a>";
    $nestedData[] = "<a href='" . home_path() . '/consultation-details/' .  $row['hospital_id'] . "'>" . $counsltation . "</a>";

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