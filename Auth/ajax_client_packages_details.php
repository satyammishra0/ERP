<?php
include_once '../init.php';

error_reporting(1);
ini_set('display_errors', true);

$patient_id = base64_decode($_REQUEST['patient_details_id']);


$Rowpatient = get_single_patient_details_from_patient_universal_id($DB, $patient_id);

$HsopitalBusId = $Rowpatient['hm_id'];

$Counter = 0;

$requestData = $_REQUEST;

$HsopitalBusId =
    $row_header_hospital_mail = get_hospital_master_details_from_id($DB, $HsopitalBusId);
$SessionUHospitalId = $row_header_hospital_mail['hm_id'];

$columns = array(
    0 => 'counter', // no 
    1 => 'package_type  ', // package Nmae
    2 => '-', // rate plan
    3 => 'sessions', // sessions
    4 => '-', // complated
    5 => 'package_price', // price
    6 => 'paid_price', // paid 
    7 => '-', // balance
    8 => 'tppm_date', // activated on
    9 => '-', // end date 
    10 => '-', // status
    11 => 'tppm_created_by' // booked by
);

$sqlListTypeCount = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE patient_unique_id = '$patient_id'";
$qryListTypeCount = $DB->prepare($sqlListTypeCount);
$qryListTypeCount->execute();
$ResultsList = $qryListTypeCount->fetchAll();
$totalData = count($ResultsList);
$totalFiltered = $totalData;


$sql = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE patient_unique_id = '$patient_id' AND hm_id = '$SessionUHospitalId' ";

if (!empty($requestData['search']['value'])) {
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql .= " AND (patient_unique_id LIKE '%" . $requestData['search']['value'] . "%')";
    //$sql.=" OR pmb.tpmb_name LIKE '%".$requestData['search']['value']."%' )";
}

//echo $sql;

$qry = $DB->prepare($sql);
$qry->execute();
$totalFiltered = $qry->rowCount();

$sql .= " ORDER BY patient_unique_id ASC LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
$qry = $DB->prepare($sql);
$qry->execute();
$Results = $qry->fetchAll();

$data = array();

foreach ($Results as $Row_Admin) {

    $Counter++; // Visit No.    

    $tppm_id = $Row_Admin['tppm_id']; // package id
    $package_type = $Row_Admin['package_type']; //  package type
    $sessions = $Row_Admin['sessions'];
    $free_session = $Row_Admin['free_session'];
    $package_price = $Row_Admin['package_price']; // package_price
    $paid_price = $Row_Admin['paid_price']; // paid_price
    $tppm_date = $Row_Admin['tppm_date']; // tppm_date 
    $tppm_created_by = $Row_Admin['tppm_created_by']; // tppm_created_by 
    $bpid = $Row_Admin['tbp_id']; // tbp_id 
    $tppm_status = $Row_Admin['tppm_status']; // tppm_status 

    if ($Row_Admin['package_type'] == "1") {
        $Package_type_name = "Detox";
    } else if ($Row_Admin['package_type'] == "2") {
        $Package_type_name = "EECP";
    } else {
    }

    $total_session = $sessions + $free_session;

    $CountCompltedTreatment = count_patient_complted_treatment_session_from_package_id($DB, $patient_id, $tppm_id);

    $balance = $Row_Admin['remaining_price'];

    $biling_package =  get_single_billing_package_details_from_id($DB, $bpid);
    $biling_name = $biling_package['title'];

    $row_Schedule  = get_user_master_details_from_id($DB, $tppm_created_by);
    $Schedule_first_name = $row_Schedule['first_name'];
    $Schedule_laste_name = $row_Schedule['last_name'];

    $Schedule_name = $Schedule_first_name . " " . $Schedule_laste_name;



    $count = count_patient_finished_complted_treatment_session_from_package_id($DB, $patient_id, $tppm_id);


    // if ($tppm_status == 1) {
    //     $get_last_date_row = get_single_treatment_master_details_from_id($DB, $tppm_id);
    //     $active_date = date('d-m-Y',strtotime($get_last_date_row['ttm_date']));
    // } else if($tppm_status == 2){
    //     $get_last_date_row = get_single_treatment_master_details_from_id($DB, $tppm_id);
    //     $active_date = date('d-m-Y',strtotime($get_last_date_row['ttm_date']));
    // }  else 
    if ($tppm_status == 0) {

        $active_date = "-";
    } else {
        $get_last_date_row = get_single_treatment_master_details_from_id($DB, $tppm_id);
        if ($get_last_date_row == "") {
            $active_date = "-";
        } else {
            $active_date = date('d-m-Y', strtotime($get_last_date_row['ttm_date']));
        }
    }



    if ($package_price == $paid_price) {
        $add_payment = '';
    } else {
        $add_payment = '<a class="dropdown-item" href="javascript:;" id="add_payment_session" data-id=' . $tppm_id . '>Add Payment</a>';
    }

    if ($CountCompltedTreatment == $total_session) {
        $status = "Completed";
        $StatusCssName = "cl-completed";

        $Action = '<td>
            <div class="btn-group dropleft client-button-left dropleftcustom">
                <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-more-2-line"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:;" id="view_session" data-id="' . $tppm_id . '" data-name="' . $biling_name . '" data-delid="' . $package_type . '" title="View Session">View Sessions</a>
                    <a class="dropdown-item" href="javascript:;" id="view_payment_session" data-id=' . $tppm_id . '>View Payments</a>
                </div>
            </div>
        </td>';
    } else {

        if ($CountCompltedTreatment == 0) {
            $status = "Booked";
            $StatusCssName = "cl-active";

            $Action = '<td>
            <div class="btn-group dropleft client-button-left dropleftcustom">
                <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-more-2-line"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:;" id="view_session" data-id="' . $tppm_id . '" data-name="' . $biling_name . '" data-delid="' . $package_type . '" title="View Session">View Sessions</a>
                    ' . $add_payment . '
                    <a class="dropdown-item" href="javascript:;" id="view_payment_session" data-id=' . $tppm_id . '>View Payments</a>
                    <a class="dropdown-item" href="javascript:;" id="cancel_package" data-id=' . $tppm_id . '>Cancel Package</a>
                </div>
            </div>
        </td>';
        } else if ($CountCompltedTreatment < $total_session) {
            $status = "Activated";
            $StatusCssName = "cl-active";

            $Action = '<td>
            <div class="btn-group dropleft client-button-left dropleftcustom">
                <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-more-2-line"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:;" id="view_session" data-id="' . $tppm_id . '" data-name="' . $biling_name . '" data-delid="' . $package_type . '" title="View Session">View Sessions</a>
                    ' . $add_payment . '
                    <a class="dropdown-item" href="javascript:;" id="view_payment_session" data-id=' . $tppm_id . '>View Payments</a>
                    <a class="dropdown-item" href="javascript:;" id="cancel_package" data-id=' . $tppm_id . '>Cancel Package</a>
                </div>
            </div>
        </td>';
        } else {
        }
    }
    if ($tppm_status == 3) {
        $status = "Cancelled";
        $StatusCssName = "cl-cancelled";

        $Action = '<td>
            <div class="btn-group dropleft client-button-left dropleftcustom">
                <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-more-2-line"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:;" id="view_session" data-id="' . $tppm_id . '" data-name="' . $biling_name . '" data-delid="' . $package_type . '" title="View Session">View Sessions</a>
                    <a class="dropdown-item" href="javascript:;" id="view_payment_session" data-id=' . $tppm_id . '>View Payments</a>
                </div>
            </div>
        </td>';
    }

    $status_flag = '<td>
                        <div class="' . $StatusCssName . '">' . $status . '</div>
                    </td>';


    $nestedData = array();
    $nestedData[] = $Counter;  // Visit No. 
    // $nestedData[] = $biling_name;  // Rate Plan 
    $nestedData[] = $Package_type_name;  // Package_type_name 
    $nestedData[] = $sessions + $free_session;  // Visit No. 
    $nestedData[] = $CountCompltedTreatment . "/" . $total_session;  // Completed
    $nestedData[] = "₹" . $package_price;  // package_price
    $nestedData[] = "₹" . $paid_price;  // paid_price. 
    $nestedData[] = "₹" . $balance;  // Balance
    $nestedData[] = $active_date;  // Activated on
    $nestedData[] = $status_flag;  // Status
    // $nestedData[] = $Schedule_name;  // Visit No. 
    // $nestedData[] = $Action;  // Visit No. 

    $data[] = $nestedData;
}

$json_data = array(
    "draw"            => intval($requestData['draw']),
    "recordsTotal"    => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data


);

echo json_encode($json_data); // send data as json format
