<?php


include_once '../init.php';


error_reporting(1);
ini_set('display_errors', true);


$requestData = $_REQUEST;


$from_new_query = "FROM `" . DB_PREFIX . "user_master` WHERE um_del = '0' AND erp_role = 'manager'";  


$sqlListType = "SELECT count(*) as cnt $from_new_query";
$qryListType = $DB->prepare($sqlListType);
$qryListType->execute();
$ResultsList = $qryListType->fetch();
$totalData = $ResultsList['cnt'];
$totalFiltered = $totalData;

$sql = "SELECT * $from_new_query";

$array = array();


if (!empty($requestData['search']['value'])) {

    $sql .= " AND (first_name LIKE '%" . $requestData['search']['value'] . "%'  OR last_name LIKE '%" . $requestData['search']['value'] . "%' )";
}

$sql .= " ORDER BY hm_id ASC LIMIT " . $requestData['start'] . " ," . $requestData['length'];

$qry = $DB->prepare($sql);
$qry->execute();
// $totalFiltered = $qry->rowCount();
$ResultsList = $qry->fetchAll();


$CounterNumber = 0;

$data = array();


foreach ($ResultsList as $row) {
    $CounterNumber++;
    $user_name = $row['salutation'] . " " . $row['first_name'] . " " . $row['last_name'];
    $contact_num = $row['mobile_no'];
    $contact_mail = $row['email'];
    $manage = "<button type='button' class='btn btn-outline-info waves-effect waves-light' onclick='window.location.href = `user-manage/" . $row['um_id']  . "`'>Manage</button>";
    $nestedData = array();
    
    $nestedData[] = $CounterNumber;
    $nestedData[] = $user_name;
    $nestedData[] = $contact_num;
    $nestedData[] = $contact_mail;
    $nestedData[] = $manage;
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
