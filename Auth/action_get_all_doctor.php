<?php
include_once '../init.php';

error_reporting(1);
ini_set('display_errors', true);

$requestData = $_REQUEST;

function get_hospital_master_details_id_from(PDO $DB, $HospitalId)
{
    $sqlList = "SELECT hm_name FROM " . DB_PREFIX . "hospital_master WHERE hm_id = '$HospitalId' AND hm_del = '0';";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}

if (isset($_POST['select_center_type']) && $_POST['select_center_type'] != 0) {

    $select_center_type = $_POST['select_center_type'];

    $from_new_query = "FROM `tbl_user_master` tum JOIN `tbl_hospital_master` thm ON thm.hm_id = tum.hm_id 
    WHERE tum.ut_id IN ('1','2') AND tum.um_del = '0' AND thm.ht_id IN (" . $select_center_type . ")";
} else {

    $from_new_query = "FROM `tbl_user_master` tum JOIN `tbl_hospital_master` thm ON thm.hm_id = tum.hm_id
    WHERE tum.ut_id IN ('1','2') AND tum.um_del = '0'";

    if (!empty(total_hospitals)) {
        $from_new_query .= "AND (";
        for ($i = 0; $i < count(total_hospitals); $i++) {

            $from_new_query .= "FIND_IN_SET('" . total_hospitals[$i] . "', tum.hm_id) > 0";
            if ($i == count(total_hospitals) - 1) {
                $from_new_query .= " ";
            } else {
                $from_new_query .= " OR ";
            }
        }
        $from_new_query .= ")";
    }
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
    $sql .= " AND CONCAT (tum.first_name, ' ', tum.last_name) LIKE '%" . $requestData['search']['value'] . "%' ";
}


if (!empty($_POST['select_center'])) {
    $center_id = $_POST['select_center'];
    $sql .= " AND  tum.hm_id IN ('$center_id')";
}


// Add condition to fetch data based on manager name
if (!empty($_POST['manager_name'])) {
    $manager_name = $_POST['manager_name'];
    $sql .= " AND  thm.manager_name = '$manager_name'";
}


if (!empty(total_hospitals)) {
    $sql .= "AND (";
    for ($i = 0; $i < count(total_hospitals); $i++) {
        $sql .= "FIND_IN_SET('" . total_hospitals[$i] . "', tum.hm_id) > 0";
        if ($i == count(total_hospitals) - 1) {
            $sql .= " ";
        } else {
            $sql .= " OR ";
        }
    }
    $sql .= ")";
}


$qry = $DB->prepare($sql);
$qry->execute();
$totalFiltered = $qry->rowCount();

$sql .= " ORDER BY tum.first_name DESC LIMIT " . $requestData['start'] . " ," . $requestData['length'];
$qry = $DB->prepare($sql);
$qry->execute();
$ResultsList = $qry->fetchAll();


$data = array();
$CounterNumber = 0;



foreach ($ResultsList as $row) {
    $CounterNumber++;

    $PatientId = $row['um_id'];

    $fname = $row['first_name'];
    $lname = $row['last_name'];

    $FullName = "Dr. "  . $fname .  " " . $lname;

    $CaseLink = $FullName; //Full name

    $center_id = $row['hm_id'];

    $added_on1 = $row['mobile_no'];
    $added_on = date('d/m/Y', strtotime($added_on1));

    $nestedData = array();

    $cnt_name = "";

    if (strpos("$center_id", ",")) {
        $centerArr = explode(",", $center_id);
        $cntet_name = "";
        foreach ($centerArr as $hm_id) {
            $center_name = get_hospital_master_details_id_from($DB, $hm_id);
            if ($center_name['hm_name']) {
                $cntet_name = $center_name['hm_name'] . "<br>";
                $cnt_name .= $cntet_name;
            }
        }
    } else {
        $center_name = get_hospital_master_details_id_from($DB, $center_id);
        if ($center_name['hm_name']) {
            $cnt_name = $center_name['hm_name'] . "<br>";
        }
    }

    $nestedData[] = $CounterNumber;
    $nestedData[] = $CaseLink;
    $nestedData[] = $cnt_name;
    $nestedData[] = $added_on1;
    $nestedData[] = $row['doc_speciality'];
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
