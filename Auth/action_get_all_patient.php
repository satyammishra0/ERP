<?php
// Include and Error reporting
include_once '../init.php';
error_reporting(1);
ini_set('display_errors', true);


// Storing the data getting from page
$requestData = $_REQUEST;


// constructing query based on center type selection 
if (isset($_POST['select_center_type']) && $_POST['select_center_type'] != 0) {

    $select_center_type = $_POST['select_center_type'];

    $from_new_query = "FROM `" . DB_PREFIX . "patient_master` AS p_master JOIN `" . DB_PREFIX . "hospital_master` AS h_master ON p_master.hm_id = h_master.hm_id WHERE h_master.ht_id = " . $select_center_type . " AND p_master.pm_del = 0";
} else {
    $from_new_query = "FROM `" . DB_PREFIX . "patient_master` AS p_master JOIN `" . DB_PREFIX . "hospital_master` AS h_master ON p_master.hm_id = h_master.hm_id AND p_master.pm_del = 0";
}

// concatanaing the query with desired values from DB
$sqlListType = "SELECT count(p_master.pm_id) as cnt $from_new_query";
$qryListType = $DB->prepare($sqlListType);
$qryListType->execute();
$ResultsList = $qryListType->fetch();
$totalData = $ResultsList['cnt'];
$totalFiltered = $totalData; // total data of Filtered values are per above conditions

// Now extracting the data from thee query mentioned above
$sql = "SELECT * $from_new_query";

$array = array();  // intialising the blank array

// Taking the output based on the manager names

if (isset($_POST['manager_name']) && !empty($_POST['manager_name'])) {
    $manager_name = $_POST['manager_name'];
    $sql .= " AND h_master.manager_name = '$manager_name'";
}

//  Filter data on based of search value
if (!empty($requestData['search']['value'])) {
    $sql .= " AND (p_master.patient_unique_id LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " OR CONCAT ( p_master.pm_first_name, ' ',p_master.pm_middle_name, ' ',p_master.pm_last_name ) LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " OR CONCAT ( p_master.pm_first_name, ' ',p_master.pm_last_name ) LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " OR p_master.pm_first_name LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " OR p_master.pm_middle_name LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " OR p_master.pm_last_name LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " OR p_master.pm_contact_no LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " OR p_master.pm_pincode LIKE '%" . $requestData['search']['value'] . "%' ";
    $sql .= " OR p_master.pm_city LIKE '%" . $requestData['search']['value'] . "%' )";
}


// Fetch data based on the date filter
if (isset($_POST['center_date_from']) && !empty($_POST['center_date_from'])) {
    $from = $_POST['center_date_from'];
    $end = $_POST['center_date_end'];
    $sql .= " AND date(p_master.pm_created_date) BETWEEN '$from' AND ' $end'";
}

// Condtion if any center is selected from all centers present 
if (isset($_POST['select_center']) && !empty($_POST['select_center'])) {
    $center_id = $_POST['select_center'];
    $sql .= " AND p_master.hm_id = '$center_id'";
}


// If total hospitals are empty filter data based on hm_id 
$sql .= !empty(total_hospitals) ? " AND p_master.hm_id IN(" . implode(',', total_hospitals) . " )" : "";


// filter the data based on the order 
if (!empty($requestData['order']['0']['column'])) {
    if ($requestData['order']['0']['dir'] == "desc") {
        $sql .= " ORDER BY p_master.pm_created_date ASC";
    } else {
        $sql .= " ORDER BY p_master.pm_created_date DESC";
    }
}

// ------------------------------------------------------------
// Fetching the data based on conditions added above in sql query
// ------------------------------------------------------------

$qry = $DB->prepare($sql);
$qry->execute();
$totalFiltered = $qry->rowCount();


// Fetching the data based on conditions added above in sql query
$sql .= " LIMIT " . $requestData['start'] . " ," . $requestData['length'];

$qry = $DB->prepare($sql);
$qry->execute();
$ResultsList = $qry->fetchAll();



// Populating the recomended values of EECP | STD 
// package_type == 1- Detox/SDT 2- EECP ||| patient_unique_id- patient_id ex.OP ||| tppm_del- patient is deleted/not ||| tppm_status- 0-book /1-activated/  2-finished /3-cancel
function count_patient_reccomended_treatment_session_from_package_id(PDO $DB, $PatientUniId, $package_id)
{
    $fetch_recommended_values = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE `patient_unique_id` = '$PatientUniId' AND `package_type` = '$package_id' AND `tppm_del` = '0' AND `tppm_status` != '3'";

    $prep_fetch_recommended_values = $DB->prepare($fetch_recommended_values);
    $prep_fetch_recommended_values->execute();
    $resulted_recomended_values = $prep_fetch_recommended_values->fetchAll();

    return $resulted_recomended_values;
}

// intialising empty array
$data = array();
$CounterNumber = 0;

foreach ($ResultsList as $row) {
    $CounterNumber++;

    // Filling up data based on data extracted from DB
    $PatientUniId = $row['patient_unique_id'];
    $PatientId = $row['pm_id'];
    $fname = $row['pm_first_name'];
    $mname = $row['pm_middle_name'];
    $lname = $row['pm_last_name'];

    $FullName = $fname . " " . $mname . " " . $lname;

    $CaseLink = $FullName;

    $center_name = $row['hm_name'];

    $added_on1 = $row['pm_created_date'];
    $added_on = date('d/m/Y', strtotime($added_on1));

    // Extracting SDT Values from above Function
    $final_resulted_recomended_values =  count_patient_reccomended_treatment_session_from_package_id($DB, $PatientUniId, 1);

    if (!count($final_resulted_recomended_values) > 0) {
        $sdt = 0;
    } else {
        $sdt = $final_resulted_recomended_values['0']['sessions'];
    };

    // Extracting EECP Values form above functions
    $final_resulted_recomended_values =  count_patient_reccomended_treatment_session_from_package_id($DB, $PatientUniId, 2);

    if (!count($final_resulted_recomended_values) > 0) {
        $eecp = 0;
    } else {
        $eecp = $final_resulted_recomended_values[0]['sessions'];
    };

    $recommended_values = "$eecp  | $sdt";

    // Intialising empty array to add up the data
    $nestedData = array();

    $nestedData[] = $CounterNumber;  //Serial no
    $nestedData[] = $CaseLink . "</br>" . $PatientUniId; // Name + OP-id
    $nestedData[] = $center_name;  // Center Name
    $nestedData[] = $recommended_values;  // Recomended EECP || STD  value
    $nestedData[] = $added_on; // Added date
    $nestedData[] = "<a href='" . home_path() . '/patient-details/' .  base64_encode($row['patient_unique_id']) . "'>View Patient Details</a>"; //Link to all details


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
