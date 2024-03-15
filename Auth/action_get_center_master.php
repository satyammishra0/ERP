<?php

include_once '../init.php';



function get_ecp_count_from_hospital_id(PDO $DB, $HospitalId, $start_date = null, $end_date = null)
{

    if ($start_date != null && $end_date != null) {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HospitalId' AND package_type = '2' AND tppm_del = '0' AND (tppm_status = '1' OR tppm_status = '0') AND date(tppm_created_date) BETWEEN '$start_date' AND ' $end_date'";
    } else {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HospitalId' AND package_type = '2' AND tppm_del = '0' AND (tppm_status = '1' OR tppm_status = '0')";
    }


    $qryList = $DB->prepare($sqlList);
    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}
function get_sdt_count_from_hospital_id(PDO $DB, $HospitalId, $start_date = null, $end_date = null)
{

    if ($start_date != null && $end_date != null) {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HospitalId' AND package_type = '1'  AND tppm_del = '0' AND (tppm_status = '1' OR tppm_status = '0') AND date(tppm_created_date) BETWEEN '$start_date' AND ' $end_date'";
    } else {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HospitalId' AND package_type = '1'  AND tppm_del = '0' AND (tppm_status = '1' OR tppm_status = '0')";
    }

    $qryList = $DB->prepare($sqlList);
    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}

function get_last_lead_entry_from_hospital(PDO $DB, $HospitalId)
{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE hm_id = '$HospitalId' ORDER BY lm_id DESC LIMIT 1";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();

    return $qryList->fetch();
}

function get_last_sdt_entry_from_hospital(PDO $DB, $HospitalId)
{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HospitalId' AND package_type = '1'  AND tppm_del = '0' AND (tppm_status = '1' OR tppm_status = '0') ORDER BY tppm_id DESC LIMIT 1";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();

    return $qryList->fetch();
}

function get_last_eecp_entry_from_hospital(PDO $DB, $HospitalId)
{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HospitalId' AND package_type = '2'  AND tppm_del = '0' AND (tppm_status = '1' OR tppm_status = '0') ORDER BY tppm_id DESC LIMIT 1";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();

    return $qryList->fetch();
}

error_reporting(1);
ini_set('display_errors', true);


$requestData = $_REQUEST;


if (isset($_POST['select_center_type']) && $_POST['select_center_type'] != 0) {

    $select_center_type = $_POST['select_center_type'];

    $from_new_query = "FROM `" . DB_PREFIX . "hospital_master` WHERE hm_del = '0' AND ht_id = '$select_center_type'";
} else {
    $from_new_query = "FROM `" . DB_PREFIX . "hospital_master` WHERE hm_del = '0'";
}


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

if (!empty($_POST['center_date_from']) && !empty($_POST['center_date_from'])) {

    $from = $_POST['center_date_from'];
    $end = $_POST['center_date_end'];

    // $sql .= " AND date(hm_opening_date) BETWEEN '$from' AND ' $end'";
}

if (isset($_POST['select_center_zone']) && !empty($_POST['select_center_zone'])) {
    $center_zone = $_POST['select_center_zone'];


    $sql .= " AND hm_zone = '$center_zone'";
}

$sql .= !empty(total_hospitals) ? " AND hm_id IN(" . implode(',', total_hospitals) . " )" : "";

$qry = $DB->prepare($sql);
$qry->execute();
$totalFiltered = $qry->rowCount();


$qry = $DB->prepare($sql);
$qry->execute();
$ResultsList = $qry->fetchAll();


$data = array();
$CounterNumber = 0;
$recordCount = 0;
$i = 1;
foreach ($ResultsList as $row) {
    $CounterNumber++;

    // if($i%2==0){
    //     $last_login = '<button class="btn btn-sm btn-success m-0">Login</button>';
    // }else{
    //     $last_login = '<button class="btn btn-sm btn-danger m-0">Logout</button>';
    // }

    $i++;
    $center_name = $row['hm_name'];
    $manager = $row['manager_name'];


    $last_lead_row = get_last_lead_entry_from_hospital($DB, $row['hm_id']);
    $last_eecp_row = get_last_eecp_entry_from_hospital($DB, $row['hm_id']);
    $last_sdt_row = get_last_sdt_entry_from_hospital($DB, $row['hm_id']);
    $last_entry_date = date('d-m-y', strtotime($last_lead_row['lm_created_date']));
    $last_eecp_row_date = date('d-m-y', strtotime($last_eecp_row['tppm_created_date'])) == '01-01-70' ? '-' : date('d-m-y', strtotime($last_eecp_row['tppm_created_date']));
    $last_sdt_row_date = date('d-m-y', strtotime($last_sdt_row['tppm_created_date'])) == '01-01-70' ? '-' : date('d-m-y', strtotime($last_sdt_row['tppm_created_date']));


    if (isset($from) && isset($end)) {
        $lms_count = get_all_count_converted_leads($DB, $row['hm_id'], $from, $end);
        $ecp_count_f = get_ecp_count_from_hospital_id($DB, $row['hm_id'], $from, $end);
        $ecp_count = '<b><a class="under_line_text" href="' . home_path() . "/report-details/ecp/" .  $row["hm_id"] . '">' . $ecp_count_f . '</a></b> ';
        $sdt_count_f = get_sdt_count_from_hospital_id($DB, $row['hm_id'], $from, $end);
        $sdt_count = '<b><a class="under_line_text" href="' . home_path() . "/report-details/sdt/" .  $row["hm_id"] . '">' . $sdt_count_f . '</a></b> ';
        $total_lead_f = get_all_count_total_leads($DB, $row['hm_id'], $from, $end);
        $total_lead = '<b>' . $total_lead_f . '</b> ';
    } else {
        $lms_count = get_all_count_converted_leads($DB, $row['hm_id']);
        $ecp_count_f = get_ecp_count_from_hospital_id($DB, $row['hm_id']);
        $ecp_count = '<b><a class="under_line_text" href="' . home_path() . "/report-details/ecp/" .  $row["hm_id"] . '">' . $ecp_count_f . '</a></b> ';
        $sdt_count_f = get_sdt_count_from_hospital_id($DB, $row['hm_id']);
        $sdt_count = '<b><a class="under_line_text" href="' . home_path() . "/report-details/sdt/" .  $row["hm_id"] . '">' . $sdt_count_f . '</a></b> ';
        $total_lead_f = get_all_count_total_leads($DB, $row['hm_id']);
        $total_lead = '<b>' . $total_lead_f . '</b> ';
    }







    if (date('d-m-y', strtotime($last_lead_row['lm_created_date'])) == '01-01-70') {
        $last_entry_date = '-';
    } else {

        $inputDate = $last_entry_date;

        // Create DateTime objects for today and the input date
        $today = new DateTime(); // Current date and time
        $inputDateTime = DateTime::createFromFormat('d-m-y', $inputDate);

        // Calculate the interval between dates
        $interval = $today->diff($inputDateTime);
        $hoursDifference = $interval->h + ($interval->days * 24);

        // Check conditions based on hours difference
        if ($hoursDifference <= 24) {
            $last_entry_date =  '<p class="badge badge-soft-success m-0">' . $last_entry_date . '</p>'; // Within 24 hours
        } else if ($hoursDifference <= 72) {
            $last_entry_date =  '<p class="badge badge-soft-warning m-0">' . $last_entry_date . '</p>'; // Within 72 hours
        } else {
            $last_entry_date =  '<p class="badge badge-soft-danger m-0">' . $last_entry_date . '</p>'; // Beyond 72 hours
        }
    }
    if (date('d-m-y', strtotime($last_eecp_row['tppm_created_date'])) == '01-01-70') {
        $last_eecp_row_date = '-';
    } else {

        $inputDate = $last_eecp_row_date;

        // Create DateTime objects for today and the input date
        $today = new DateTime(); // Current date and time
        $inputDateTime = DateTime::createFromFormat('d-m-y', $inputDate);

        // Calculate the interval between dates
        $interval = $today->diff($inputDateTime);
        $hoursDifference = $interval->h + ($interval->days * 24);

        // Check conditions based on hours difference
        if ($hoursDifference <= 24) {
            $last_eecp_row_date =  '<p class="badge badge-soft-success m-0">' . $last_eecp_row_date . '</p>'; // Within 24 hours
        } else if ($hoursDifference <= 72) {
            $last_eecp_row_date =  '<p class="badge badge-soft-warning m-0">' . $last_eecp_row_date . '</p>'; // Within 72 hours
        } else {
            $last_eecp_row_date =  '<p class="badge badge-soft-danger m-0">' . $last_eecp_row_date . '</p>'; // Beyond 72 hours
        }
    }
    if (date('d-m-y', strtotime($last_sdt_row['tppm_created_date'])) == '01-01-70') {
        $last_sdt_row_date = '-';
    } else {

        $inputDate = $last_sdt_row_date;

        // Create DateTime objects for today and the input date
        $today = new DateTime(); // Current date and time
        $inputDateTime = DateTime::createFromFormat('d-m-y', $inputDate);

        // Calculate the interval between dates
        $interval = $today->diff($inputDateTime);
        $hoursDifference = $interval->h + ($interval->days * 24);

        // Check conditions based on hours difference
        if ($hoursDifference <= 24) {
            $last_sdt_row_date =  '<p class="badge badge-soft-success m-0">' . $last_sdt_row_date . '</p>'; // Within 24 hours
            // $last_login = '<p class="badge badge-soft-success m-0">Login</p>';
        } else if ($hoursDifference <= 72) {
            $last_sdt_row_date =  '<p class="badge badge-soft-warning m-0">' . $last_sdt_row_date . '</p>'; // Within 72 hours
            // $last_login = '<p class="badge badge-soft-success m-0">Login</p>';
        } else {
            $last_sdt_row_date =  '<p class="badge badge-soft-danger m-0">' . $last_sdt_row_date . '</p>'; // Beyond 72 hours
            // $last_login = '<button class="btn btn-sm btn-success m-0">Login</button>';
        }
    }


    // $last_entry_date = '<p class="badge badge-soft-warning">' . $last_entry_date . '</p>';

    $nestedData = array();


    if ($total_lead_f == 0 && $ecp_count_f == 0 && $sdt_count_f == 0 && $lms_count == 0 && false) {
        continue;
    } else {
        $recordCount++;
        $nestedData[] = $CounterNumber;
        $nestedData[] =  $center_name . ' ' . $last_login . '';
        $nestedData[] = $manager;
        $nestedData[] = $total_lead . ' ' . $last_entry_date . '';
        $nestedData[] = $lms_count;
        $nestedData[] = $ecp_count  . ' ' . $last_eecp_row_date . '';
        $nestedData[] = $sdt_count  . ' ' . $last_sdt_row_date . '';
    }


    $data[] = $nestedData;
    $ArryDia = empty($ArryDia);
}


$json_data = array(
    "draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
    "recordsTotal"    => intval($recordCount),  // total number of records
    "recordsFiltered" => intval($recordCount), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format




// SELECT PP.hm_id, hm.hm_name, SUM(CASE WHEN PP.package_type = 2 THEN 1 ELSE 0 END) AS count_package_type_2 , SUM(CASE WHEN PP.package_type = 1 THEN 1 ELSE 0 END) AS count_package_type_1 FROM `tbl_patient_package_master` PP RIGHT JOIN `tbl_hospital_master` hm ON pp.hm_id = hm.hm_id WHERE PP.tppm_del = '0' AND (PP.tppm_status = '1' OR PP.tppm_status = '0') GROUP BY PP.hm_id;



// SELECT thm.hm_id, thm.hm_name , count(tam.hm_id) AS count FROM `tbl_hospital_master` thm  LEFT JOIN `tbl_appointment_master` tam ON thm.hm_id = tam.hm_id WHERE tam.pam_status = '3' AND tam.pam_del = '0' GROUP BY tam.hm_id ;