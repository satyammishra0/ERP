<?php

// Setting up init and error files
include '../init.php';
error_reporting(1);
ini_set('display_errors', true);


// Get Last entry based on hm_id
function get_last_entry_from_hm_id(PDO $DB, $hm_id)

{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE pm_del = '0' AND hm_id = '$hm_id' ORDER BY pm_id DESC LIMIT 1";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}


// 
if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {
    $type_id = $_REQUEST['type'];

    if ($type_id == 4) {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "hospital_master WHERE  hm_del = 0 ";
    } else {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "hospital_master WHERE ht_id = '$type_id' AND hm_del = 0 ";
    }

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();
    $res  = $qryList->fetchAll();

    $data = array();

    foreach ($res as $row) {
        $Patient_last = get_last_entry_from_hm_id($DB, $row['hm_id']);

        $data[] = '<tr>
                        <td>
                              <a href="#" class="text-body">' . $row['hm_name'] . '</a>
                        </td>
                        <td>
                         ' . $row['manager_name'] . '
                        </td>

                        <td>
                            ' . date('d/m/Y', strtotime($row['hm_created_date'])) . '
                        </td>
                        <td>
                            ' . date('d/m/Y', strtotime($Patient_last['pm_created_date'])) . '
                        </td>
                        <td>
                            Active
                        </td>
                        <td>
                            <a href="#" class="text-body">View</a>
                        </td>
                        </tr>';
    }

    echo json_encode($data);
}


// Function to fetch center names based on their type
if (isset($_REQUEST['list'])) {

    $type_id = $_REQUEST['list'];

    if ($type_id == 0) {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "hospital_master WHERE  hm_del = 0 ";
    } else {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "hospital_master WHERE ht_id = '$type_id' AND hm_del = 0 ";
    }

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();
    $res  = $qryList->fetchAll();

    $data[] = '<option value="0">All</option>';

    foreach ($res as $row) {
        $data[] = '<option value="' . $row['hm_id'] . '">' . $row['hm_name'] . '</option>';
    }

    echo json_encode($data);
}


// Code to fetch center details based on thier manager name
if (isset($_REQUEST['manager_name'])) {

    $managerName = $_REQUEST['manager_name'];

    $sqlList = "SELECT * FROM " . DB_PREFIX . "hospital_master WHERE `manager_name` = '$managerName' AND hm_del = 0 ";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();
    $res  = $qryList->fetchAll();

    $data[] = '<option value="0">All</option>';

    foreach ($res as $row) {
        $data[] = '<option value="' . $row['hm_id'] . '">' . $row['hm_name'] . '</option>';
    }

    echo json_encode($data);
}
