<?php
include_once '../init.php';

// function get_all_patient_details_from_patient_unique_id(PDO $DB,  $patient_unique_id)
// {

//     $sqlList = "SELECT CONCAT(`pm_first_name` ,' ', `pm_middle_name`,' ',`pm_last_name`) as name_p  FROM " . DB_PREFIX . "patient_master WHERE `patient_unique_id` = '$patient_unique_id'";

//     $qryList = $DB->prepare($sqlList);
//     $qryList->execute();

//     return $qryList->fetch();
// }

// function get_doctor_name_from_um_id(PDO $DB, $id)
// {
//     $sqlList =  "SELECT CONCAT(`salutation` ,' ', `first_name`,' ',`last_name`) as name FROM  " . DB_PREFIX . "user_master WHERE `um_id` = '$id' AND `um_del` = 0";
//     $qryList = $DB->prepare($sqlList);
//     $qryList->execute();
//     if ($qryList->rowCount()) {
//         return $qryList->fetch();
//     } else {
//         return ['name' => ''];
//     }
// }



// SELECT CONCAT(tpm.pm_first_name ,' ', tpm.pm_middle_name,' ',tpm.pm_last_name) as P_name, tam.pam_app_date, CONCAT(tum.salutation ,' ', tum.first_name,' ',tum.last_name) as D_name FROM `tbl_appointment_master` tam LEFT JOIN `tbl_patient_master` tpm ON tam.patient_unique_id = tpm.patient_unique_id LEFT JOIN `tbl_user_master` tum ON tam.um_id = tum.um_id WHERE tam.hm_id = '1' AND tam.pam_status = '3' AND tam.pam_del = '0';

error_reporting(1);
ini_set('display_errors', true);

$requestData = $_REQUEST;



if (isset($_POST['hid'])) {
    $hid = $_POST['hid'];
    $from_new_query = "FROM `tbl_appointment_master` tam LEFT JOIN `tbl_patient_master` tpm ON tam.patient_unique_id = tpm.patient_unique_id LEFT JOIN `tbl_user_master` tum ON tam.um_id = tum.um_id WHERE tam.hm_id = '$hid' AND tam.pam_status = '3' AND tam.pam_del = '0'";
} else {
    echo "error";
}



if (!empty($requestData['search']['value'])) {

    $from_new_query .= " AND (tpm.pm_first_name LIKE '%" . $requestData['search']['value'] . "%')";
}


if (!empty($_POST['center_date_from']) && !empty($_POST['center_date_end'])) {
    $from = $_POST['center_date_from'];
    $end = $_POST['center_date_end'];



    $from_new_query .= " AND date(tam.pam_app_date) BETWEEN '$from' AND '$end'";

    // echo $from_new_query;
}



$sqlListType = "SELECT count(*) as cnt $from_new_query";
$qryListType = $DB->prepare($sqlListType);
$qryListType->execute();
$ResultsList = $qryListType->fetch();
$totalData = $ResultsList['cnt'];
$totalFiltered = $totalData;


$sql = "SELECT CONCAT(tpm.pm_first_name ,' ', tpm.pm_middle_name,' ',tpm.pm_last_name) as P_name, tam.pam_app_date, CONCAT(tum.salutation ,' ', tum.first_name,' ',tum.last_name) as D_name $from_new_query";

$array = array();





$sql .= " ORDER BY pam_app_date DESC LIMIT " . $requestData['start'] . " ," . $requestData['length'];
$qry = $DB->prepare($sql);
$qry->execute();
$ResultsList = $qry->fetchAll();


$data = array();
$CounterNumber = 0;




foreach ($ResultsList as $row) {
    $CounterNumber++;
    // print_r($row);

    $patient_unique_id = $row['patient_unique_id'];
    $patient_app_date = $row['pam_app_date'];
    $doctor_id = $row['um_id'];
    $total_price = $row['total_price'];
    $paid_price = $row['paid_price'];

    $patient_name = $row['P_name'];
    $doctor_name = $row['D_name'];


    // print_r($doctor_name['name']); 
    //   $center_status1 = $row['hm_del'];
    //   if($center_status1 == 0){
    //       $center_status = "Active";
    //   }else{
    //       $center_status = "Inactive";
    //   }

    // $last_lead_row = get_last_lead_entry_from_hospital($DB, $row['hm_id']);
    // $last_entry_date = date('Y-m-d', strtotime($last_lead_row['lm_created_date']));



    $nestedData = array();

    // $doctorName =  count($doctor_name) > 0 ? $doctor_name['salutation'] . ' ' . $doctor_name['first_name'] . ' ' . $doctor_name['last_name'] : 'User Deleted';

    $nestedData[] = $CounterNumber;
    $nestedData[] = $patient_name;
    $nestedData[] = $doctor_name == '' ? 'Deleted User' :  $doctor_name;
    $nestedData[] = $patient_app_date;
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
