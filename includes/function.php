<?php



function get_all_user_type_details(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_type WHERE ut_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_hospital_type_details(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "hospital_type";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_single_admin_primary_id_from_random_id(PDO $DB, $SessionRandomId)

{

    $sqlListType = "SELECT ta_id FROM " . DB_PREFIX . "admin WHERE admin_ran_id = '$SessionRandomId'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    $RowUser = $qryListType->fetch();

    return $RowUser['ta_id'];
}



function get_hospital_master_details_from_id(PDO $DB, $HospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "hospital_master WHERE hm_id = '$HospitalId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function check_user_from_user_name(PDO $DB, $Username)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE user_name = BINARY '$Username' AND um_del = 1";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_all_active_hospital_details(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "hospital_master WHERE hm_del = '0'";

    $sqlList .= !empty(total_hospitals) ? " AND hm_id IN(" . implode(',', total_hospitals) . ")" : "";


    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_user_master_details_from_id(PDO $DB, $UserId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE um_id = '$UserId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_single_user_type_details_from_id(PDO $DB, $UtId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_type WHERE ut_id = '$UtId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_biiling_payment_option_details(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "biiling_payment_option WHERE del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function check_biiling_payment_option_from_title(PDO $DB, $Title)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "biiling_payment_option WHERE title = BINARY '$Title'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_single_biiling_payment_option_details_from_id(PDO $DB, $bpid)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "biiling_payment_option WHERE bpid = '$bpid'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_single_user_primary_id_from_random_id(PDO $DB, $SessionRandomId)

{

    $sqlListType = "SELECT um_id FROM " . DB_PREFIX . "user_master WHERE doctor_unique_id = '$SessionRandomId'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    $RowUser = $qryListType->fetch();

    return $RowUser['um_id'];
}



function get_single_user_details_from_random_id(PDO $DB, $SessionRandomId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "user_master WHERE doctor_unique_id = '$SessionRandomId'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_single_module_detials_from_id(PDO $DB, $MMid)

{

    $sqlListModule = "SELECT * FROM " . DB_PREFIX . "module_master WHERE mm_id = '$MMid'";

    $qryListModule = $DB->prepare($sqlListModule);

    $qryListModule->execute();

    return $qryListModule->fetch();
}



function get_all_active_doctor_details(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE ut_id = '1' AND um_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_active_case_type(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "opd_case_type WHERE toct_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_id_generator_opd(PDO $DB)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "id_genrerater WHERE id_place  = 'OPD'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_patient_last_id(PDO $DB)

{



    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master ORDER BY pm_id DESC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RowList = $qryList->fetch();

        $patient_old_id1 = $RowList['seq_no'];

        $patient_new_id = $patient_old_id1 + 1;

        return  "S" . $patient_new_id;
    } else {

        return "S1";
    }
}



function get_last_seq_number(PDO $DB, $SerNumber)

{



    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master ORDER BY pm_id DESC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RowList = $qryList->fetch();

        $patient_old_id1 = $RowList['seq_no'];

        $patient_new_id = $patient_old_id1 + 1;

        return  $patient_new_id;
    } else {

        if (!empty($SerNumber)) {

            return $SerNumber;
        } else {

            return 1;
        }
    }
}





function get_patient_random_id()

{

    $random_chars = "";

    $characters = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

    $keys = array();

    while (count($keys) < 5) {

        $x = mt_rand(0, count($characters) - 1);

        if (!in_array($x, $keys)) {

            $keys[] = $x;
        }
    }

    foreach ($keys as $key) {

        $random_chars .= $characters[$key];
    }

    $random_chars;

    return $random_chars;
}



function get_patient_random_last_id(PDO $DB, $PrefixNumber)

{



    $RandomId = get_patient_random_id();



    $PmPid = $PrefixNumber . $RandomId;



    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE patient_unique_id = '$PmPid'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RandomId = get_patient_random_id();
    } else {

        $RandomId = $RandomId;
    }



    return $PrefixNumber . $RandomId;
}



function get_custom_last_seq_number(PDO $DB, $Custom_Opt)

{



    $date_new = date("Y-m-d");

    $trimdate = explode('-', $date_new);

    $p_year = $trimdate[0];

    $p_month   = $trimdate[1];

    $p_day  = $trimdate[2];



    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master ORDER BY pm_id DESC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RowList = $qryList->fetch();

        $LastId = $RowList['seq_no'];



        if ($Custom_Opt == "Year") {



            $o_year = substr($LastId, 0, 4);



            if ($p_year == $o_year) {

                //$NewId = $LastId+1;

                $Incriement_one_with_this_no = substr($LastId, 4);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 4;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $NewId;
            } else {

                return $p_year . "001";
            }
        } else if ($Custom_Opt == "YearMonth") {



            $o_year_month = substr($LastId, 0, 6);

            $o_year = substr($o_year_month, 0, 4);

            $o_month = substr($o_year_month, -2);



            if ($p_year . $p_month == $o_year . $o_month) {

                //$NewId = $LastId+1;



                $Incriement_one_with_this_no = substr($LastId, 6);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 6;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $p_month . $NewId;
            } else {

                return $p_year . $p_month . "001";
            }
        } else {



            $o_year_month_day = substr($LastId, 0, 8);

            $o_year_month = substr($o_year_month_day, 0, 6);

            $o_year = substr($o_year_month, 0, 4);

            $o_month = substr($o_year_month, -2);

            $o_day = substr($o_year_month_day, -2);



            if ($p_year . $p_month . $p_day == $o_year . $o_month . $o_day) {

                //$NewId = $LastId+1;



                $Incriement_one_with_this_no = substr($LastId, 8);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 8;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $p_month . $p_day . $NewId;
            } else {

                return $p_year . $p_month . $p_day . '001';
            }
        }
    } else {

        if ($Custom_Opt == "Year") {

            return $p_year . '001';
        } else if ($Custom_Opt == "YearMonth") {

            return $p_year . $p_month . '001';
        } else {

            return $p_year . $p_month . $p_day . '001';
        }
    }
}



function get_id_generator_appo(PDO $DB)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "id_genrerater WHERE id_place  = 'APPOINTMENT'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_appo_last_seq_number(PDO $DB, $SerNumber, $hos_id)

{



    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$hos_id' ORDER BY pam_id DESC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RowList = $qryList->fetch();

        $patient_old_id1 = $RowList['seq_no'];

        $patient_new_id = $patient_old_id1 + 1;

        return  $patient_new_id;
    } else {

        if (!empty($SerNumber)) {

            return $SerNumber;
        } else {

            return 1;
        }
    }
}









function get_appo_random_last_id(PDO $DB, $PrefixNumber, $hos_id)

{



    $RandomId = get_patient_random_id();



    $PmPid = $PrefixNumber . $RandomId;



    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE pam_pid = '$PmPid' AND hm_id = '$hos_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RandomId = get_patient_random_id();
    } else {

        $RandomId = $RandomId;
    }



    return $PrefixNumber . $RandomId;
}



function get_appo_custom_last_seq_number(PDO $DB, $Custom_Opt, $hos_id)

{



    $date_new = date("Y-m-d");

    $trimdate = explode('-', $date_new);

    $p_year = $trimdate[0];

    $p_month   = $trimdate[1];

    $p_day  = $trimdate[2];



    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$hos_id' ORDER BY pam_id DESC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RowList = $qryList->fetch();

        $LastId = $RowList['seq_no'];



        if ($Custom_Opt == "Year") {



            $o_year = substr($LastId, 0, 4);



            if ($p_year == $o_year) {

                //$NewId = $LastId+1;

                $Incriement_one_with_this_no = substr($LastId, 4);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 4;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $NewId;
            } else {

                return $p_year . "001";
            }
        } else if ($Custom_Opt == "YearMonth") {



            $o_year_month = substr($LastId, 0, 6);

            $o_year = substr($o_year_month, 0, 4);

            $o_month = substr($o_year_month, -2);



            if ($p_year . $p_month == $o_year . $o_month) {

                //$NewId = $LastId+1;



                $Incriement_one_with_this_no = substr($LastId, 6);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 6;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $p_month . $NewId;
            } else {

                return $p_year . $p_month . "001";
            }
        } else {



            $o_year_month_day = substr($LastId, 0, 8);

            $o_year_month = substr($o_year_month_day, 0, 6);

            $o_year = substr($o_year_month, 0, 4);

            $o_month = substr($o_year_month, -2);

            $o_day = substr($o_year_month_day, -2);



            if ($p_year . $p_month . $p_day == $o_year . $o_month . $o_day) {

                //$NewId = $LastId+1;



                $Incriement_one_with_this_no = substr($LastId, 8);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 8;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $p_month . $p_day . $NewId;
            } else {

                return $p_year . $p_month . $p_day . '001';
            }
        }
    } else {

        if ($Custom_Opt == "Year") {

            return $p_year . '001';
        } else if ($Custom_Opt == "YearMonth") {

            return $p_year . $p_month . '001';
        } else {

            return $p_year . $p_month . $p_day . '001';
        }
    }
}



function get_datewise_appointment_from_hmid(PDO $DB, $Date, $hm_id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE pam_app_date = '$Date' AND hm_id = '$hm_id' AND pam_del = '0' ORDER BY " . DB_PREFIX . "appointment_master.pam_app_time ASC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_doctor_datewise_appointment_from_hmid(PDO $DB, $Date, $DocId, $hm_id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE um_id = '$DocId' AND pam_app_date = '$Date' AND hm_id = '$hm_id' AND pam_del = '0' ORDER BY " . DB_PREFIX . "appointment_master.pam_app_time ASC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_single_patient_details_from_patient_universal_id(PDO $DB, $patient_unique_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE patient_unique_id = '$patient_unique_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}

// z019 start
function get_single_patient_details_from_patient_contact_no(PDO $DB, $patient_contact_no)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE pm_contact_no = '$patient_contact_no'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}

// z019 stop



function get_single_case_type_id(PDO $DB, $toct_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "opd_case_type WHERE toct_id = '$toct_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_patient_type_single(PDO $DB, $pc_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_type WHERE pt_id='$pc_id' AND pt_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_single_patient_logs_from_appo_id(PDO $DB, $patient_unique_id, $app_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_visit_logs WHERE patient_unique_id = '$patient_unique_id' AND pam_id = '$app_id' AND status = '1'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function age_calculation($DOB)

{

    $Today = date('d-m-Y');

    $MainDate = date('d-m-Y', strtotime($DOB));



    $datetime1 = new DateTime($MainDate);

    $datetime2 = new DateTime($Today);



    $interval = $datetime1->diff($datetime2);

    //return $interval->format('%y years %m months and %d days');



    $Year = $interval->format('%y');

    $Month = $interval->format('%m');

    $Day = $interval->format('%d');



    if ($Year == 0) {

        if ($Month == 0) {

            $Age = $Day . " Day(s)";
        } else {

            $Age = $Month . " Month(s)";
        }
    } else {

        $Age = $Year . " Year(s)";
    }



    return $Age;
}



function get_appointment(PDO $DB, $APP_ID)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE pam_id = '$APP_ID'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function update_status(PDO $DB, $status, $app_id)

{

    $sql_Edit = "UPDATE " . DB_PREFIX . "appointment_master SET pam_status = :pam_status WHERE pam_id ='$app_id'";

    $statement_Edit = $DB->prepare($sql_Edit);

    $statement_Edit->bindValue(":pam_status", $status);

    $count = $statement_Edit->execute();
}



function get_doctor_all_appointment_from_hmid_datewise(PDO $DB, $DocId, $hm_id, $SID, $StartDate, $EndDate)

{



    if ($SID == "") {

        $Qry = "";
    } else {

        $Qry = "AND pam_status = '$SID'";
    }



    //  $sqlListType= "SELECT pam_id FROM ".DB_PREFIX."appointment_master WHERE um_id = '$DocId' AND hm_id = '$hm_id' AND pam_app_date BETWEEN '$StartDate' AND '$EndDate' AND pam_del = '0' $Qry ORDER BY ".DB_PREFIX."appointment_master.pam_app_time ASC";

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "appointment_master AS pam INNER JOIN " . DB_PREFIX . "patient_master AS pm ON pam.patient_unique_id=pm.patient_unique_id AND pam.um_id = '$DocId' AND pam.hm_id = '$hm_id' AND pam.pam_app_date BETWEEN '$StartDate' AND '$EndDate' AND pam.pam_del = '0' AND pm.pm_del = '0' $Qry ORDER BY pam.pam_app_time ASC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_appointment_selected_rows(PDO $DB, $APP_ID)

{





    $sqlListType = "SELECT patient_unique_id,pam_app_date,pam_app_time,pam_appointment_duration,pam_status FROM " . DB_PREFIX . "appointment_master WHERE pam_id = '$APP_ID'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_old_patient_from_fname_limit(PDO $DB, $Term)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE CONCAT( pm_first_name,  ' ', pm_last_name ) LIKE '$Term%' AND pm_del = 0  LIMIT 0,20";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_old_patient_from_phone_limit(PDO $DB, $Term)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE pm_contact_no LIKE '$Term%' AND pm_del = 0  LIMIT 0,20";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_last_visit_appointment(PDO $DB, $PatientUniId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE patient_unique_id = '$PatientUniId'  AND `pam_status`= '3' ORDER BY pam_app_date DESC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_total_visit_appointment(PDO $DB, $PatientUniId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE patient_unique_id = '$PatientUniId' AND pam_status='3'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    $count = $qryListType->rowCount();

    return $count;
}



function get_patient_case_dia_diagnosis_pid(PDO $DB, $PatientUniId, $PatientId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_diagnosis WHERE patient_unique_id = '$PatientUniId' AND pm_id = '$PatientId' AND tcd_del = '0'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_single_patient_master_details_from_id(PDO $DB, $pmid)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE pm_id = '$pmid'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_search_new_outpatient(PDO $DB, $Gender, $Area, $Pincode, $MinAge, $MaxAge, $StartDate, $EndDate)

{



    $MinAge = str_replace('undefined', '', $MinAge);

    $MaxAge = str_replace('undefined', '', $MaxAge);



    if (!empty($Gender)) {

        $genderSrch = "AND tbl_patient_master.pm_gender = '$Gender'";
    } else {

        $genderSrch = "";
    }



    if (!empty($Pincode)) {

        $pincodeSrch = "AND tbl_patient_master.pm_pincode = '$Pincode'";
    } else {

        $pincodeSrch = "";
    }



    if (!empty($Area)) {

        $areaSrch = "AND (tbl_patient_master.pm_state LIKE '%$Area%' OR tbl_patient_master.pm_city LIKE '%$Area%' OR tbl_patient_master.pm_district LIKE '%$Area%')";
    } else {

        $areaSrch = "";
    }



    if (!empty($StartDate) && !empty($EndDate)) {

        $StartDate = str_replace('/', '-', $StartDate);

        $StartDate = date('Y-m-d', strtotime($StartDate));



        $EndDate = str_replace('/', '-', $EndDate);

        $EndDate = date('Y-m-d', strtotime($EndDate));



        $visitSrch = "AND tbl_appointment_master.pam_app_date BETWEEN '$StartDate' AND '$EndDate' AND tbl_appointment_master.pam_status = '3'";
    } else {

        $visitSrch = "";
    }



    //tbl_appointment_master.pam_app_date BETWEEN '2018-07-11' AND '2018-07-27' AND `pam_status` = '3'





    // $ageSrch = "AND YEAR(CURDATE()) - YEAR(pm_dob) > $MinAge AND YEAR(CURDATE()) - YEAR(pm_dob) < $MaxAge";



    if (!empty($MinAge) || !empty($MaxAge)) {

        $ageSrch = "AND YEAR(CURDATE()) - YEAR(pm_dob) BETWEEN $MinAge AND $MaxAge";
    } else {

        $ageSrch = "";
    }





    //$ageSrch = "";



    //$sqlList= "SELECT * FROM `".DB_PREFIX."patient_master` WHERE pm_del = 0 $genderSrch $pincodeSrch $areaSrch $ageSrch ORDER BY seq_no DESC";





    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master join tbl_appointment_master on  tbl_patient_master.patient_unique_id=tbl_appointment_master.patient_unique_id WHERE  pm_del = 0 $genderSrch $pincodeSrch $areaSrch $ageSrch $visitSrch ORDER BY tbl_patient_master.seq_no DESC";





    $qryList = $DB->prepare($sqlList);

    $qryList->execute();



    return $qryList->fetchAll();
}



function get_all_patient_values_wise_excel_export(PDO $DB, $PatientIds)

{

    if (!empty($PatientIds)) {

        $ArrayPId = explode(",", $PatientIds);

        $PatId = array();

        foreach ($ArrayPId as $StringPIds) {

            $PatId[] = "'" . $StringPIds . "'";
        }

        $PatientIdsNew = implode(",", $PatId);

        $QryP_PId = "AND pm_id IN ($PatientIdsNew)";
    } else {

        $QryP_PId = "";
    }

    $sqlList = "SELECT * FROM `" . DB_PREFIX . "patient_master` WHERE pm_del = 0 $QryP_PId";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_active_Service_details_from_id(PDO $DB, $BillServiceId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "biiling_services WHERE tbs_id='$BillServiceId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_active_doctor_details_from_hspital_id(PDO $DB, $HospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE (ut_id = '1' or ut_id = '2') AND hm_id REGEXP CONCAT('(^|,)(', REPLACE('$HospitalId', ',', '|'), ')(,|$)') AND um_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_id_generator_billing(PDO $DB)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "id_genrerater WHERE id_place  = 'BILLING'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_last_seq_number_billing(PDO $DB, $SerNumber, $HospitalId)

{



    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing WHERE hm_id = '$HospitalId' ORDER BY tb_id DESC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RowList = $qryList->fetch();

        $patient_old_id1 = $RowList['seq_no'];

        $patient_new_id = $patient_old_id1 + 1;

        return  $patient_new_id;
    } else {

        if (!empty($SerNumber)) {

            return $SerNumber;
        } else {

            return 1;
        }
    }
}



function get_patient_random_last_id_billing(PDO $DB, $PrefixNumber, $HospitalId)

{



    $RandomId = get_patient_random_id();



    $BillingId = $PrefixNumber . $RandomId;



    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing WHERE billing_id = '$BillingId' AND hm_id = '$HospitalId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RandomId = get_patient_random_id();
    } else {

        $RandomId = $RandomId;
    }



    return $PrefixNumber . $RandomId;
}



function get_custom_last_seq_number_billing(PDO $DB, $Custom_Opt, $HospitalId)

{



    $date_new = date("Y-m-d");

    $trimdate = explode('-', $date_new);

    $p_year = $trimdate[0];

    $p_month   = $trimdate[1];

    $p_day  = $trimdate[2];



    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing WHERE hm_id = '$HospitalId' ORDER BY tb_id DESC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RowList = $qryList->fetch();

        $LastId = $RowList['seq_no'];



        if ($Custom_Opt == "Year") {



            $o_year = substr($LastId, 0, 4);



            if ($p_year == $o_year) {

                //$NewId = $LastId+1;

                $Incriement_one_with_this_no = substr($LastId, 4);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 4;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $NewId;
            } else {

                return $p_year . "001";
            }
        } else if ($Custom_Opt == "YearMonth") {



            $o_year_month = substr($LastId, 0, 6);

            $o_year = substr($o_year_month, 0, 4);

            $o_month = substr($o_year_month, -2);



            if ($p_year . $p_month == $o_year . $o_month) {

                //$NewId = $LastId+1;



                $Incriement_one_with_this_no = substr($LastId, 6);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 6;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $p_month . $NewId;
            } else {

                return $p_year . $p_month . "001";
            }
        } else {



            $o_year_month_day = substr($LastId, 0, 8);

            $o_year_month = substr($o_year_month_day, 0, 6);

            $o_year = substr($o_year_month, 0, 4);

            $o_month = substr($o_year_month, -2);

            $o_day = substr($o_year_month_day, -2);



            if ($p_year . $p_month . $p_day == $o_year . $o_month . $o_day) {

                //$NewId = $LastId+1;



                $Incriement_one_with_this_no = substr($LastId, 8);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 8;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $p_month . $p_day . $NewId;
            } else {

                return $p_year . $p_month . $p_day . '001';
            }
        }
    } else {

        if ($Custom_Opt == "Year") {

            return $p_year . '001';
        } else if ($Custom_Opt == "YearMonth") {

            return $p_year . $p_month . '001';
        } else {

            return $p_year . $p_month . $p_day . '001';
        }
    }
}



function age_calculation_in_number($DOB)

{

    $Today = date('d-m-Y');

    $MainDate = date('d-m-Y', strtotime($DOB));

    $datetime1 = new DateTime($MainDate);

    $datetime2 = new DateTime($Today);

    $interval = $datetime1->diff($datetime2);

    //return $interval->format('%y years %m months and %d days');

    $Year = $interval->format('%y');

    $Month = $interval->format('%m');

    $Day = $interval->format('%d');

    if ($Year == 0) {

        if ($Month == 0) {

            $Age = $Day;
        } else {

            $Age = $Month;
        }
    } else {

        $Age = $Year;
    }

    return $Age;
}



function get_all_billing_details_from_id(PDO $DB, $BillId, $HospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing WHERE tb_id='$BillId' AND hm_id = '$HospitalId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_billing_qty_details_from_id(PDO $DB, $BillId, $HospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing_qty WHERE tb_id='$BillId' AND hm_id = '$HospitalId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_active_user_details_from_hspital_id(PDO $DB, $HospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE hm_id REGEXP CONCAT('(^|,)(', REPLACE('$HospitalId', ',', '|'), ')(,|$)') AND um_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_user_type_details_from_id(PDO $DB, $User_type_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_type WHERE ut_id = '$User_type_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_old_patient_from_patient_id_name(PDO $DB, $Term)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE pm_contact_no LIKE '$Term%' OR patient_unique_id LIKE '$Term%' OR CONCAT(" . DB_PREFIX . "patient_master.pm_first_name, ' '," . DB_PREFIX . "patient_master.pm_last_name) LIKE '$Term%' AND pm_del = 0  LIMIT 0,20";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}

function get_old_patient_from_patient_id_name_and_hospitel_id(PDO $DB, $Term, $SessionUHospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master AS pm JOIN " . DB_PREFIX . "patient_master_logs AS pml ON pml.pm_id=pm.pm_id AND pml.hm_id = '$SessionUHospitalId' AND (pm.pm_contact_no LIKE '$Term%' OR pm.patient_unique_id LIKE '$Term%' OR CONCAT(pm.pm_first_name, ' ',pm.pm_last_name) LIKE '$Term%') AND pm.pm_del = 0  GROUP BY pm.patient_unique_id LIMIT 0,20";

    // echo $sqlList= "SELECT * FROM ".DB_PREFIX."patient_master_logs` AS pml JOIN `" . DB_PREFIX . "patient_master` AS pm ON pml.pm_id = pm.pm_id AND pml.hm_id = '$SessionUHospitalId' AND pm.pm_contact_no LIKE '$Term%' OR pm.patient_unique_id LIKE '$Term%' OR CONCAT(pm.pm_first_name, ' ',pm.pm_last_name) LIKE '$Term%' LIMIT 0,20";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_document_option(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "document_option WHERE del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchall();
}



function get_document_type_from_id(PDO $DB, $document_type)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "document_option WHERE doid = '$document_type'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_document_details_from_id(PDO $DB, $document_id)
{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_document WHERE tpd_id = '$document_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_user_department_type_details(PDO $DB, $dp_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "department WHERE dp_id = '$dp_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}

function get_appointment_details_from_apointment_id(PDO $DB, $appointment_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE pam_id = '$appointment_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_billing_package_details(PDO $DB, $tbp_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing_package WHERE tbp_id NOT IN ($tbp_id) AND tbp_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_single_billing_package_details_from_id(PDO $DB, $bpid)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing_package WHERE tbp_id = '$bpid'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_active_patient_package_from_type(PDO $DB, $HospitalId, $Type)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HospitalId' AND package_type = '$Type' AND tppm_del = '0' AND (tppm_status = '1' OR tppm_status = '0')";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_single_patient_package_master_details_from_id(PDO $DB, $tppm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE tppm_id = '$tppm_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function count_patient_complted_treatment_session_from_package_id(PDO $DB, $patient_unique_id, $tppm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE patient_unique_id = '$patient_unique_id' AND tppm_id = '$tppm_id' AND ttm_del = '0' AND ttm_status != '2'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}

function count_patient_complted_treatment_session_from_package(PDO $DB, $patient_unique_id, $package_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE patient_unique_id = '$patient_unique_id' AND package_type = '$package_id' AND ttm_del = '0' AND ttm_status != '2'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}


function count_patient_finished_complted_treatment_session_from_package_id(PDO $DB, $patient_unique_id, $tppm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE patient_unique_id = '$patient_unique_id' AND tppm_id = '$tppm_id' AND ttm_del = '0' AND (ttm_status != '0' AND ttm_status != '2' )";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function check_treatment_room_from_date_time(PDO $DB, $HospitalId, $dx_room_no, $dx_room_date, $dx_room_time, $ttm_end_time, $dx_type)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE hm_id = '$HospitalId' AND ttm_room_name = '$dx_room_no' AND DATE(ttm_date) = '$dx_room_date' AND TIME(ttm_end_time) >= '$dx_room_time' AND TIME(ttm_time) <= '$ttm_end_time' AND package_type = '$dx_type' AND ttm_del = '0' AND ttm_status != '2'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function check_edit_treatment_room_from_date_time(PDO $DB, $HospitalId, $dx_room_no, $dx_room_date, $dx_room_time, $ttm_end_time, $dx_type, $ttm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE hm_id = '$HospitalId' AND ttm_room_name = '$dx_room_no' AND DATE(ttm_date) = '$dx_room_date' AND TIME(ttm_end_time) >= '$dx_room_time' AND TIME(ttm_time) <= '$ttm_end_time' AND package_type = '$dx_type' AND ttm_del = '0' AND ttm_status != '2' AND ttm_id != '$ttm_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_treatment_from_hmid_datewise(PDO $DB, $hm_id, $room_no, $StartDate, $EndDate, $type)

{



    if ($room_no == 0) {

        $Qry = "";
    } else {

        $Qry = "AND ttm_room_name = '$room_no'";
    }



    $sqlListType = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE hm_id = '$hm_id' AND ttm_date BETWEEN '$StartDate' AND '$EndDate' AND ttm_del = '0' AND package_type = '$type' $Qry ORDER BY " . DB_PREFIX . "treatment_master.ttm_time ASC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_single_treatment_master_details_from_id(PDO $DB, $tppm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE tppm_id = '$tppm_id' AND ttm_status != 2 ORDER BY `ttm_date` ASC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_single_treatment_master_details_from_tppm_id(PDO $DB, $tppm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE ttm_id = '$tppm_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_single_patient_package_master_details_from_universal_id(PDO $DB, $patient_unique_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



// function check_treatment_master_from_time(PDO $DB,$Title)

// {

//   $sqlList= "SELECT * FROM ".DB_PREFIX."treatment_master WHERE ttm_time = '$Title' ";

//   $qryList= $DB->prepare($sqlList);

//   $qryList->execute();

//   $count = $qryList->rowCount();

//   return $count;



// }



function get_single_patient_package_master_details_from_patient_id(PDO $DB, $tppm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE tppm_id = '$tppm_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_count_patient_complted_treatment_session_from_package_id(PDO $DB, $patient_unique_id, $tppm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE patient_unique_id = '$patient_unique_id' AND tppm_id = '$tppm_id' AND ttm_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_print_settings_id(PDO $DB, $SubType)
{

    $sqlList = "SELECT * FROM `" . DB_PREFIX . "print_settings` WHERE tpsm_page_type = '$SubType' AND tps_del_by ='0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_payment_option_from_id(PDO $DB, $bpid)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "biiling_payment_option WHERE bpid = '$bpid'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_biiling_services(pdo $DB, $tbs_id)
{

    $sqlList = "SELECT  * FROM " . DB_PREFIX . "billing WHERE tb_id = '$tbs_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_schedule_time_duration_Detox(PDO $DB)

{

    $sqlList = "SELECT * FROM `" . DB_PREFIX . "schedule_duration` WHERE tosd_room_flag = '1'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_schedule_time_duration_EECP(PDO $DB)

{

    $sqlList = "SELECT * FROM `" . DB_PREFIX . "schedule_duration` WHERE tosd_room_flag = '2'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_single_patient_logs_from_patient_uniq_id(PDO $DB, $patient_unique_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_visit_logs WHERE patient_unique_id = '$patient_unique_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_consultation_type(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "consultation_type WHERE tct_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}

function get_all_brief_summary_master_details(PDO $DB, $SessionRandomId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "brief_summary_master WHERE (doctor_unique_id = '$SessionRandomId' OR saaol_default = '1') AND tbsm_del='0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_single_brief_summary_master(PDO $DB, $Id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "brief_summary_master WHERE tbsm_id = '$Id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_usg_master_details(PDO $DB, $SessionRandomId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "usg_master WHERE (doctor_unique_id = '$SessionRandomId' OR saaol_default = '1') AND tum_del='0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_single_usg_master(PDO $DB, $Id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "usg_master WHERE tum_id = '$Id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_advice_master_details(PDO $DB, $SessionRandomId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "advice_master WHERE (doctor_unique_id = '$SessionRandomId' OR saaol_default = '1') AND tam_del='0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_single_advice_master(PDO $DB, $Id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "advice_master WHERE tam_id = '$Id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_patient_case_examination_patient_uni_id(PDO $DB, $PatientUniId, $HospitalId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_examination WHERE patient_unique_id = '$PatientUniId' AND hm_id = '$HospitalId' AND tce_del = '0' ORDER BY tce_id DESC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}

// z010 start
function get_patient_case_usg_patient_uni_id(PDO $DB, $PatientUniId, $HospitalId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_usg WHERE patient_unique_id = '$PatientUniId' AND hm_id = '$HospitalId' AND tcu_del = '0' ORDER BY tcu_id DESC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}

// z010 stop



function get_patient_case_tmt_patient_uni_id(PDO $DB, $PatientUniId, $HospitalId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_tmt WHERE patient_unique_id = '$PatientUniId' AND hm_id = '$HospitalId' AND tct_del  = '0' ORDER BY tct_id  DESC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_patient_case_echo_patient_uni_id(PDO $DB, $PatientUniId, $HospitalId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_echo WHERE patient_unique_id = '$PatientUniId' AND hm_id = '$HospitalId' AND tce_del  = '0' ORDER BY tce_id  DESC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_patient_case_habits_behaviour_patient_uni_id(PDO $DB, $PatientUniId, $HospitalId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_habits_behaviour WHERE patient_unique_id = '$PatientUniId' AND hm_id = '$HospitalId' AND tchb_del  = '0' ORDER BY tchb_id  DESC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_all_medicine_details_from_doc_id(PDO $DB, $HospitalId, $DocId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "medicine_master WHERE (um_id = '$DocId' OR saaol_default = 1) AND tmm_del='0' ORDER BY tmm_id DESC"; //z021

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}
// z021 start
function get_medicine_details_from_uni_id(PDO $DB, $MediId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "medicine_master WHERE tmm_id = '$MediId'"; //z021

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}
// z021 stop

// z028 start
function cm2feet($cm)
{
    $inches = $cm / 2.54;
    $feet = intval($inches / 12);
    $inches = $inches % 12;
    return sprintf('%d ft %d in', $feet, $inches);
}
// z028 stop



function get_medicine_template(PDO $DB, $DocId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "medicine_template_detail WHERE um_id = '$DocId' AND tmtd_del = '0' ORDER BY tmtd_id DESC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_search_medicine_details_from_doc_id(PDO $DB, $searchName, $HospitalId, $DocId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "medicine_master WHERE (saaol_default = 1 or um_id = '$DocId') AND tmm_medicine_name LIKE '%$searchName%' AND tmm_del='0' ORDER BY tmm_medicine_name ASC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_single_medicine_template_details(PDO $DB, $Id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "medicine_master WHERE tmm_id = '$Id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_single_user_treatment_master_package_details_from_id(PDO $DB, $tppm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE tppm_id = '$tppm_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_medicine_template_id(PDO $DB, $Id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "medicine_template_detail WHERE tmtd_id = '$Id' AND tmtd_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_medicine_details_using_id(PDO $DB, $medicine_id)
{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "medicine_master WHERE tmm_id = '$medicine_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_patient_case_biochemistry_patient_uni_id(PDO $DB, $PatientUniId, $PatientId, $HospitalId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_biochemistry WHERE pm_id = '$PatientId' AND patient_unique_id = '$PatientUniId' AND hm_id = '$HospitalId' AND tcb_del = '0' ORDER BY tcb_id DESC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}

// z014 start
function get_patient_case_biochemistry_uni_id(PDO $DB, $bio_chemistryId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_biochemistry WHERE tcb_id = '$bio_chemistryId'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}
// z014 stop



function get_patient_case_ct_parametrer_patient_uni_id(PDO $DB, $PatientUniId, $PatientId, $HospitalId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_ct_parametrer WHERE pm_id = '$PatientId' AND patient_unique_id = '$PatientUniId' AND hm_id = '$HospitalId' AND tccp_del = '0' ORDER BY tccp_id DESC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}

// z006 start
function get_patient_case_ct_parametrer_uni_id(PDO $DB, $ct_angio_id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_ct_parametrer WHERE tccp_id = '$ct_angio_id'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}
// z006 stop



function get_consultation_type_details_from_id(PDO $DB, $tct_id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "consultation_type WHERE tct_id = '$tct_id'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_all_patient_case_manager_detials(PDO $DB, $PM_PId, $patient_unique_id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "case_manager WHERE pm_id = '$PM_PId' AND patient_unique_id = '$patient_unique_id' AND tcm_del = '0' order BY tcm_datetime DESC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_all_patient_case_manager_detials_doc_filter(PDO $DB, $PM_PId, $patient_unique_id, $doc_id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "case_manager WHERE pm_id = '$PM_PId' AND patient_unique_id = '$patient_unique_id' AND tcm_del = '0' AND um_id='$doc_id' order BY tcm_datetime DESC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_department_details_from_id(PDO $DB, $Dp_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "department WHERE dp_id = '$Dp_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_single_casemanager_examination_id(PDO $DB, $Id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_examination WHERE tce_id = '$Id'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}

// z018 start
function get_single_casemanager_usg_id(PDO $DB, $Id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_usg WHERE tcu_id = '$Id'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}
// z018 stop



function get_single_casemanager_tmt_id(PDO $DB, $Id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_tmt WHERE tct_id = '$Id'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_single_casemanager_echo_id(PDO $DB, $Id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_echo WHERE tce_id = '$Id'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_single_casemanager_habits_behaviour_id(PDO $DB, $Id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_habits_behaviour WHERE tchb_id = '$Id'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_single_casemanager_biochemistry_id(PDO $DB, $Id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_biochemistry WHERE tcb_id = '$Id'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_single_casemanager_ct_parametrer_id(PDO $DB, $Id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_ct_parametrer WHERE tccp_id = '$Id'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_single_casemanager_risk_factor_from_case_id(PDO $DB, $Id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_risk_factor WHERE tcm_id = '$Id'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_single_patient_case_manager_detials(PDO $DB, $Patient_Univsesal_Id, $CaseId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "case_manager WHERE patient_unique_id = '$Patient_Univsesal_Id' AND tcm_id = '$CaseId'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_single_patient_casemanager_risk_factor_detials(PDO $DB, $Patient_Univsesal_Id, $CaseId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "casemanager_risk_factor WHERE patient_unique_id = '$Patient_Univsesal_Id' AND tcm_id = '$CaseId'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_all_page_title(pdo $DB, $Id)
{

    $sqlList = "SELECT hm_name FROM " . DB_PREFIX . "hospital_master WHERE hm_id = '$Id' and (hm_delete_by = '0' OR hm_delete_by IS NULL)";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $hm_name = $qryList->fetch()['hm_name'];

    if ($hm_name != '') {

        $title = $hm_name;
    } else {

        $title = "Saaol";
    }

    return $title;
}



function get_single_biling_details_from_billing_id(PDO $DB, $billing_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing WHERE tb_id = '$billing_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_billing_qty_details_from_billing_id(PDO $DB, $BillId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing_qty WHERE tb_id='$BillId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}

function number_decimal($Number)

{

    return number_format((float)$Number, 2, '.', '');
}





function convertToIndianCurrency($number)
{

    $no = round($number);

    $decimal = round($number - ($no = floor($number)), 2) * 100;

    $digits_length = strlen($no);

    $i = 0;

    $str = array();

    $words = array(

        0 => '',

        1 => 'One',

        2 => 'Two',

        3 => 'Three',

        4 => 'Four',

        5 => 'Five',

        6 => 'Six',

        7 => 'Seven',

        8 => 'Eight',

        9 => 'Nine',

        10 => 'Ten',

        11 => 'Eleven',

        12 => 'Twelve',

        13 => 'Thirteen',

        14 => 'Fourteen',

        15 => 'Fifteen',

        16 => 'Sixteen',

        17 => 'Seventeen',

        18 => 'Eighteen',

        19 => 'Nineteen',

        20 => 'Twenty',

        30 => 'Thirty',

        40 => 'Forty',

        50 => 'Fifty',

        60 => 'Sixty',

        70 => 'Seventy',

        80 => 'Eighty',

        90 => 'Ninety'
    );

    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');

    while ($i < $digits_length) {

        $divider = ($i == 2) ? 10 : 100;

        $number = floor($no % $divider);

        $no = floor($no / $divider);

        $i += $divider == 10 ? 1 : 2;

        if ($number) {

            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;

            $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
        } else {

            $str[] = null;
        }
    }



    $Rupees = implode(' ', array_reverse($str));

    $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal % 10]) . " " . ($words[$decimal % 10])  : '';

    return ($Rupees ? ' ' . $Rupees : '') . $paise;
}



function get_old_patient_from_contact_no(PDO $DB, $contact_no)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE pm_contact_no LIKE '$contact_no' AND pm_del = 0";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_old_lead_from_contact_no(PDO $DB, $contact_no, $HospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE lm_contact_no LIKE '$contact_no' AND hm_id= '$HospitalId' AND lm_del = 0";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_active_lead_primary_source(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_primary_source WHERE tlps_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_active_lead_services(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_services WHERE tls_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_active_lead_followup_type(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_followup_type WHERE tlft_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_id_generator_lead(PDO $DB)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "id_genrerater WHERE id_place  = 'LEAD'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_last_seq_number_lead(PDO $DB, $SerNumber, $HospitalId)

{



    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE hm_id = '$HospitalId' ORDER BY lm_id DESC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RowList = $qryList->fetch();

        $patient_old_id1 = $RowList['seq_no'];

        $patient_new_id = $patient_old_id1 + 1;

        return  $patient_new_id;
    } else {

        if (!empty($SerNumber)) {

            return $SerNumber;
        } else {

            return 1;
        }
    }
}



function get_lead_random_last_id(PDO $DB, $PrefixNumber, $HospitalId)

{



    $RandomId = get_patient_random_id();



    $PmPid = $PrefixNumber . $RandomId;



    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE hm_id = '$HospitalId' AND lead_unique_id = '$PmPid'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RandomId = get_patient_random_id();
    } else {

        $RandomId = $RandomId;
    }



    return $PrefixNumber . $RandomId;
}



function get_custom_last_seq_number_lead(PDO $DB, $Custom_Opt, $HospitalId)

{



    $date_new = date("Y-m-d");

    $trimdate = explode('-', $date_new);

    $p_year = $trimdate[0];

    $p_month   = $trimdate[1];

    $p_day  = $trimdate[2];



    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE hm_id = '$HospitalId' ORDER BY lm_id DESC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if ($count > 0) {

        $RowList = $qryList->fetch();

        $LastId = $RowList['seq_no'];



        if ($Custom_Opt == "Year") {



            $o_year = substr($LastId, 0, 4);



            if ($p_year == $o_year) {

                //$NewId = $LastId+1;

                $Incriement_one_with_this_no = substr($LastId, 4);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 4;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $NewId;
            } else {

                return $p_year . "001";
            }
        } else if ($Custom_Opt == "YearMonth") {



            $o_year_month = substr($LastId, 0, 6);

            $o_year = substr($o_year_month, 0, 4);

            $o_month = substr($o_year_month, -2);



            if ($p_year . $p_month == $o_year . $o_month) {

                //$NewId = $LastId+1;



                $Incriement_one_with_this_no = substr($LastId, 6);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 6;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $p_month . $NewId;
            } else {

                return $p_year . $p_month . "001";
            }
        } else {



            $o_year_month_day = substr($LastId, 0, 8);

            $o_year_month = substr($o_year_month_day, 0, 6);

            $o_year = substr($o_year_month, 0, 4);

            $o_month = substr($o_year_month, -2);

            $o_day = substr($o_year_month_day, -2);



            if ($p_year . $p_month . $p_day == $o_year . $o_month . $o_day) {

                //$NewId = $LastId+1;



                $Incriement_one_with_this_no = substr($LastId, 8);

                //get all charector count after six charector start

                $OLD_invoice_ID_Length = strlen($LastId);

                $set_string = $OLD_invoice_ID_Length - 8;

                //get all charector count after six charector End

                $NewId = str_pad($Incriement_one_with_this_no + 1, $set_string, 0, STR_PAD_LEFT);



                return $p_year . $p_month . $p_day . $NewId;
            } else {

                return $p_year . $p_month . $p_day . '001';
            }
        }
    } else {

        if ($Custom_Opt == "Year") {

            return $p_year . '001';
        } else if ($Custom_Opt == "YearMonth") {

            return $p_year . $p_month . '001';
        } else {

            return $p_year . $p_month . $p_day . '001';
        }
    }
}



function get_single_lead_followup_type(PDO $DB, $tlft_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_followup_type WHERE tlft_id = '$tlft_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_single_lead_primary_source(PDO $DB, $tlps_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_primary_source WHERE tlps_id = '$tlps_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_active_hospital_details_except_hm_id(PDO $DB, $HmId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "hospital_master WHERE hm_id != '$HmId' AND hm_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_single_lead_from_lead_id(PDO $DB, $lm_id, $HospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE lm_id = '$lm_id' AND hm_id= '$HospitalId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_active_lead_close_reason(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_close_reason WHERE tlcr_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}





function get_single_lead_from_lead_id_lead_pmid(PDO $DB, $lead_unique_id, $lm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE lm_id = '$lm_id' AND lead_unique_id= '$lead_unique_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}

//z002 start
// lead open close history
function get_lead_history_lead_id(PDO $DB, $lm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "open_close_lead WHERE lead_id = '$lm_id' ORDER BY id DESC ";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}

// z002 stop


function get_single_lead_services(PDO $DB, $tls_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_services WHERE tls_id = '$tls_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_total_vistte_log_by_patient_id(PDO $DB, $patient_unique_id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "patient_visit_logs WHERE patient_unique_id = '$patient_unique_id' AND status = '3'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    $count = $qryListType->rowCount();

    return $count;
}



function get_all_count_active_leads(PDO $DB, $HospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE hm_id = '$HospitalId' AND (lm_status = 0 OR lm_status = 1 OR lm_status = 2)";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if (!empty($count)) {

        return $count;
    } else {

        return 0;
    }
}



function get_all_count_converted_leads(PDO $DB, $HospitalId, $start_date = null, $end_date = null)
{

    if ($start_date != null && $end_date != null) {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE hm_id = '$HospitalId' AND lm_status = 3 AND date(lm_created_date) BETWEEN '$start_date' AND ' $end_date'";
    } else {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE hm_id = '$HospitalId' AND lm_status = 3";
    }

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    if (!empty($count)) {
        return $count;
    } else {
        return 0;
    }
}


function get_all_count_close_leads(PDO $DB, $HospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE hm_id = '$HospitalId' AND lm_status = 4";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if (!empty($count)) {

        return $count;
    } else {

        return 0;
    }
}



function get_all_count_total_leads(PDO $DB, $HospitalId, $start_date = null, $end_date = null)
{

    if ($start_date != null && $end_date != null) {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE hm_id = '$HospitalId' AND date(lm_created_date) BETWEEN '$start_date' AND ' $end_date'";
    } else {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_master WHERE hm_id = '$HospitalId'";
    }


    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if (!empty($count)) {

        return $count;
    } else {

        return 0;
    }
}


function get_id_lead_followup_visit(PDO $DB, $lm_id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "lead_followup_visit WHERE lm_id  = '$lm_id'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_all_video_category(PDO $DB)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "video_category WHERE tvc_delate  = 0";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_all_video_details_from_id(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "video_master WHERE tvm_delate = '0'";

    $List = $DB->prepare($sqlList);

    $List->execute();

    return $List->fetchAll();
}



function get_all_video_category_from_id(PDO $DB, $tvc_id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "video_category WHERE tvc_id = '$tvc_id' AND tvc_delate  = 0";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_singal_video_details_from_id(PDO $DB, $tvm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "video_master WHERE tvm_id = '$tvm_id'";

    $List = $DB->prepare($sqlList);

    $List->execute();

    return $List->fetch();
}



function get_next_video_details_from_id(PDO $DB, $tvm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "video_master WHERE tvm_id > '$tvm_id' AND tvm_delate = 0 LIMIT 1";

    $List = $DB->prepare($sqlList);

    $List->execute();

    return $List->fetch();
}



function get_previous_video_details_from_id(PDO $DB, $tvm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "video_master WHERE tvm_id < '$tvm_id' AND tvm_delate = 0 LIMIT 1";

    $List = $DB->prepare($sqlList);

    $List->execute();

    return $List->fetch();
}



function get_all_video_details_from_category_id(PDO $DB, $cat_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "video_master WHERE tvc_id = '$cat_id' AND tvm_delate = '0'";

    $List = $DB->prepare($sqlList);

    $List->execute();

    return $List->fetchAll();
}





function get_load_previous_prescription_frpm_pm_pid(PDO $DB, $PM_PId, $patient_unique_id, $HospitalId)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "case_manager WHERE pm_id = '$PM_PId' AND hm_id = '$HospitalId' AND patient_unique_id = '$patient_unique_id' AND tcm_del = '0' order BY tcm_datetime DESC";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetch();
}



function get_lead_details_from_id(PDO $DB, $lm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_followup_visit WHERE tlfv_id = '$lm_id' AND tpf_del = 0";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}







function get_all_count_active_leads_using_date(PDO $DB, $HospitalId, $show_date)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_followup_visit WHERE hm_id = '$HospitalId' AND (status = 0 OR status = 1 OR status = 2) AND tlfv_followup_date = '$show_date'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if (!empty($count)) {

        return $count;
    } else {

        return 0;
    }
}



function get_all_count_converted_leads_using_date(PDO $DB, $HospitalId, $show_date)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_followup_visit WHERE hm_id = '$HospitalId' AND status = 3 AND tlfv_followup_date = '$show_date'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if (!empty($count)) {

        return $count;
    } else {

        return 0;
    }
}



function get_all_count_close_leads_using_date(PDO $DB, $HospitalId, $show_date)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_followup_visit WHERE hm_id = '$HospitalId' AND status = '4' AND tlfv_followup_date = '$show_date'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if (!empty($count)) {

        return $count;
    } else {

        return 0;
    }
}



function get_all_count_total_leads_using_date(PDO $DB, $HospitalId, $show_date)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_followup_visit WHERE hm_id = '$HospitalId' AND tlfv_followup_date = '$show_date'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if (!empty($count)) {

        return $count;
    } else {

        return 0;
    }
}







function get_all_count_active_due_leads_using_date(PDO $DB, $HospitalId, $date)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_followup_visit WHERE hm_id = '$HospitalId' AND (status = '1' OR status = '2' ) AND tlfv_followup_date < '$date'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if (!empty($count)) {

        return $count;
    } else {

        return 0;
    }
}



function get_all_count_total_due_leads_using_date(PDO $DB, $HospitalId, $date)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_followup_visit WHERE hm_id = '$HospitalId' AND (status = '1' OR status = '2') AND tlfv_followup_date < '$date'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();



    if (!empty($count)) {

        return $count;
    } else {

        return 0;
    }
}



function get_treatment_master_details(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_package_payment_history_from_package_id(PDO $DB, $PackageId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "package_payment_history WHERE tppm_id = '$PackageId' AND paid_price != '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_lead_close_reason_from_id(PDO $DB, $close_resion_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "lead_close_reason WHERE tlcr_id = '$close_resion_id' AND tlcr_del = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_single_patient_package_master_total_paid_amount_from_universal_id(PDO $DB, $patient_unique_id, $hm_id)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "patient_package_master WHERE patient_unique_id = '$patient_unique_id' AND hm_id = $hm_id";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}

function get_single_patient_package_master_total_package_amount_from_universal_id(PDO $DB, $patient_unique_id, $hm_id)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT SUM(package_price) FROM " . DB_PREFIX . "patient_package_master WHERE patient_unique_id = '$patient_unique_id' AND hm_id = $hm_id";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}

function get_single_patient_package_master_total_package_Outstanding_amount_from_universal_id(PDO $DB, $patient_unique_id, $hm_id)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT SUM(remaining_price) FROM " . DB_PREFIX . "patient_package_master WHERE patient_unique_id = '$patient_unique_id' AND hm_id = $hm_id AND tppm_del = 0 AND tppm_status != 3";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}

function get_single_patient_package_master_total_package_refund_amount_from_universal_id(PDO $DB, $patient_unique_id, $hm_id)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "package_payment_history WHERE patient_unique_id = '$patient_unique_id' AND hm_id = $hm_id AND action_refund = '1'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_datewise_followup_appointment_from_hmid(PDO $DB, $Date, $SessionDoctor, $hm_id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "patient_followup WHERE um_id = '$SessionDoctor' AND tpf_followup_date = '$Date' AND hm_id = '$hm_id' AND tpf_del = '0'";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_today_appointments_count_total_leads(PDO $DB, $HospitalId, $date)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HospitalId'  AND pam_app_date = '$date' ";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}

function get_last_month_appointments_count_total_leads(PDO $DB, $HospitalId, $prevmonth, $date)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE hm_id = '$HospitalId'  AND pm_created_date BETWEEN '$prevmonth' AND '$date' ";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}

function get_last_month_cansel_appointments_count_total_leads(PDO $DB, $HospitalId, $prevmonth, $date)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HospitalId'  AND pam_app_date BETWEEN '$prevmonth' AND '$date' AND pam_status = '4' ";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}

function get_total_paid_amount(PDO $DB, $HospitalId, $prevmonth, $date)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HospitalId'  AND tppm_date BETWEEN '$prevmonth' AND '$date'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_site_setting_type(PDO $DB, $Type)
{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "site_settings WHERE tss_parameter = '$Type'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $rowFetch = $qryList->fetch();

    return $rowFetch['tss_value'];
}



function get_user_name_to_get_id(PDO $DB, $Username)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE user_name = BINARY '$Username'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_all_id_lead_followup_visit(PDO $DB, $lm_id)

{

    $sqlListType = "SELECT * FROM " . DB_PREFIX . "lead_followup_visit WHERE lm_id  = '$lm_id' AND (status != '0' AND status != '3')";

    $qryListType = $DB->prepare($sqlListType);

    $qryListType->execute();

    return $qryListType->fetchAll();
}



function get_billing_qty_details_from_id(PDO $DB, $BillId, $HospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing_qty WHERE tb_id='$BillId' AND hm_id = '$HospitalId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_active_Service_details_from_id_multiple_service(PDO $DB, $BillServiceId)

{

    $sqlList = "SELECT service_name FROM " . DB_PREFIX . "biiling_services WHERE tbs_id IN ($BillServiceId)";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_billing_details_hospital_wise_from_user_id(PDO $DB, $Patient_universal_id, $SessionUHospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing WHERE patient_unique_id = '$Patient_universal_id' AND hm_id = '$SessionUHospitalId' AND tb_del ='0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_biling_details_from_billing_id(PDO $DB, $billing_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing WHERE tb_id in ($billing_id)";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_total_paid_amount_in_billing(PDO $DB, $billing_id)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT SUM(tb_grand_total) FROM " . DB_PREFIX . "billing WHERE tb_id in ($billing_id)";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_billing_qty_details_from_billing_id(PDO $DB, $BillId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "billing_qty WHERE tb_id in ($BillId)";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function check_patient_from_patient_uniq_id_and_hospital_id(PDO $DB, $patient_unique_id, $pm_id, $hospital_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master_logs WHERE patient_unique_id = '$patient_unique_id' AND pm_id = '$pm_id' AND hm_id = '$hospital_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_appoinmet_patient_id_and_hospital_id(PDO $DB, $HospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HospitalId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



// function get_all_patient_hospital_wise(PDO $DB,$pm_id)

// {

//   $sqlList= "SELECT pm_id FROM ".DB_PREFIX."patient_master WHERE pm_id IN ($pm_id)";

//   $qryList= $DB->prepare($sqlList);

//   $qryList->execute();

//   return $qryList->fetch();

// }



function get_all_patient_hospital_data(PDO $DB, $SessionUHospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master AS pml JOIN " . DB_PREFIX . "patient_master AS pm ON pml.patient_unique_id = pm.patient_unique_id AND pml.hm_id = '$SessionUHospitalId'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_patient_hospital_wise(PDO $DB, $pm_id)

{

    $sqlList = "SELECT pm_id FROM " . DB_PREFIX . "patient_master WHERE pm_id IN ($pm_id)";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_patient_details_from_patient_universal_id(PDO $DB, $pm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master WHERE pm_id IN ($pm_id)";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function check_All_patient_from_patient_uniq_id_and_hospital_id(PDO $DB, $patient_unique_id, $pm_id, $hospital_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master_logs WHERE patient_unique_id = '$patient_unique_id' AND pm_id = '$pm_id' AND hm_id = '$hospital_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_all_country_list(PDO $DB)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "countries";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_state_list(PDO $DB, $pm_country)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "states WHERE country_id = '$pm_country' ORDER BY name ASC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_all_cities_list(PDO $DB, $pm_state)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "cities WHERE state_id = '$pm_state' ORDER BY name ASC";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_country_name_using_id(PDO $DB, $pm_country)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "countries WHERE id = '$pm_country'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_state_name_using_id(PDO $DB, $pm_states)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "states WHERE id = '$pm_states'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_cities_name_using_id(PDO $DB, $pm_cities)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "cities WHERE id = '$pm_cities'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_total_appoinment_in_last_month(PDO $DB, $HospitalId, $prevmonth, $date)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HospitalId'  AND pam_app_date BETWEEN '$prevmonth' AND '$date'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_total_finished_appoinment_in_last_month(PDO $DB, $HospitalId, $prevmonth, $date)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HospitalId'  AND pam_app_date BETWEEN '$prevmonth' AND '$date' AND pam_status = '3'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_total_schedule_appoinment_in_last_month(PDO $DB, $HospitalId, $prevmonth, $date)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HospitalId'  AND pam_app_date BETWEEN '$prevmonth' AND '$date' AND pam_status = '0'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_total_cancelled_appoinment_in_last_month(PDO $DB, $HospitalId, $prevmonth, $date)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HospitalId'  AND pam_app_date BETWEEN '$prevmonth' AND '$date' AND pam_status = '4'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_total_new_patient_appoinment_in_last_month(PDO $DB, $HospitalId, $prevmonth, $date)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HospitalId'  AND pam_app_date BETWEEN '$prevmonth' AND '$date' AND pam_type = 'New'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_total_eecp_tritment_in_last_month(PDO $DB, $HospitalId, $prevmonth, $date)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE hm_id = '$HospitalId'  AND ttm_date BETWEEN '$prevmonth' AND '$date' AND package_type = '2'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_total_detox_tritment_in_last_month(PDO $DB, $HospitalId, $prevmonth, $date)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE hm_id = '$HospitalId'  AND ttm_date BETWEEN '$prevmonth' AND '$date' AND package_type = '1'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function check_count_patient_complted_treatment_session_from_package_id(PDO $DB, $tppm_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE tppm_id = '$tppm_id' AND ttm_status = '1' LIMIT 1";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function Percent($a, $b)
{

    $result = 0;

    $result = (($a - $b) * 100) / $a;

    return $result;
}



function getPercentageChange($oldNumber, $newNumber)
{

    $decreaseValue = $oldNumber - $newNumber;



    return ($decreaseValue / $oldNumber) * 100;
}



function get_total_incomplate_package_in_last_month(PDO $DB, $HospitalId, $prevmonth, $date)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    // echo $sqlList = "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE hm_id = '$HospitalId'  AND tppm_created_date BETWEEN '$prevmonth' AND '$date' AND tppm_status = '3'";

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master AS ppm JOIN " . DB_PREFIX . "treatment_master AS tm ON ppm.tppm_id = tm.tppm_id AND ppm.hm_id = '$HospitalId' AND ppm.tppm_status = '3' AND tm.ttm_status = '1' AND DATE(ppm.tppm_created_date) BETWEEN '$prevmonth' AND '$date' GROUP BY tm.tppm_id";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_7_day_Appointments_data_analytics(PDO $DB)

{

    $date = date('Y-m-d');

    $prevmonth = date('d', strtotime('-7 day'));



    // for ($date1 = date('d', strtotime('-7 day', strtotime($date))); $date1 <= date('d', strtotime('-1 day', strtotime($date))); $date1++){

    //   	$date1.',';



    //   }

    // return $date1;

}



function get_total_finished_appoinment_in_chart(PDO $DB, $HospitalId, $date)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HospitalId' AND pam_app_date = '$date' AND pam_status = '3'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_total_Cancelled_appoinment_in_chart(PDO $DB, $HospitalId, $date)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT * FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HospitalId' AND pam_app_date = '$date' AND pam_status = '4'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_daily_appointment_chart_data_hospital($DB, $HosId, $Days)

{



    $Weak_Array = array();

    $Total_Apoointment = array();

    $Total_Cancelled_Appointment = array();

    $timestamp = time();



    for ($i = 0; $i < $Days; $i++) {



        $weakly_date = date('Y-m-d', $timestamp);

        $weakly_date = date('Y-m-d', strtotime('-1 day', strtotime($weakly_date)));

        $weakly_dm = date('d M', $timestamp);

        $weakly_dm = date('d M', strtotime('-1 day', strtotime($weakly_dm)));

        $timestamp -= 24 * 3600;



        $sqlListAppointment = "SELECT pam_id FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HosId' AND date(pam_app_date) = '$weakly_date' AND pam_del = '0' AND pam_status = '3'";

        $qryListAppointment = $DB->prepare($sqlListAppointment);

        $qryListAppointment->execute();

        $count_appointment = $qryListAppointment->rowCount();



        array_push($Total_Apoointment, $count_appointment);



        $sqlListCanAppointment = "SELECT pam_id FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HosId' AND date(pam_app_date) = '$weakly_date' AND pam_del = '0' AND pam_status = '4'";

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_can_appointment = $qryListCanAppointment->rowCount();



        array_push($Total_Cancelled_Appointment, $count_can_appointment);



        array_push($Weak_Array, $weakly_dm);
    }

    return array(array_reverse($Weak_Array), array_reverse($Total_Apoointment), array_reverse($Total_Cancelled_Appointment));
}



function get_years_appointment_chart_data_hospital($DB, $HosId, $Days)

{



    $Weak_Array = array();

    $Total_Apoointment = array();

    $Total_Cancelled_Appointment = array();

    $timestamp = time();

    for ($i = 0; $i < 12; $i++) {



        $LastMonthYear =  date("M", strtotime(date('Y-m-01') . " -$i months"));

        $LastMonth =  date('m', strtotime(date('Y-m-01') . " -$i months"));

        $LastYear =  date('Y', strtotime(date('Y-m-01') . " -$i months"));



        $sqlListAppointment = "SELECT pam_id FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HosId' AND MONTH(pam_app_date) = '$LastMonth' AND YEAR(pam_app_date) = '$LastYear' AND pam_del = '0' AND pam_status = '3'";

        $qryListAppointment = $DB->prepare($sqlListAppointment);

        $qryListAppointment->execute();

        $count_appointment = $qryListAppointment->rowCount();



        array_push($Total_Apoointment, $count_appointment);



        $sqlListCanAppointment = "SELECT pam_id FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HosId' AND MONTH(pam_app_date) = '$LastMonth' AND YEAR(pam_app_date) = '$LastYear' AND pam_del = '0' AND pam_status = '4'";

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_can_appointment = $qryListCanAppointment->rowCount();



        array_push($Total_Cancelled_Appointment, $count_can_appointment);



        array_push($Weak_Array, $LastMonthYear);
    }

    return array(array_reverse($Weak_Array), array_reverse($Total_Apoointment), array_reverse($Total_Cancelled_Appointment));
}



function get_appointment_years_chart_data_hospital($DB, $HosId, $Days)

{



    $Weak_Array = array();

    $Total_Apoointment = array();

    $Total_Cancelled_Appointment = array();

    $timestamp = time();

    for ($i = 0; $i < 6; $i++) {



        $LastMonthYear =  date("Y", strtotime(date('Y-m-01') . " -$i year"));

        $LastMonth =  date('m', strtotime(date('Y-m-01') . " -$i year"));

        $LastYear =  date('Y', strtotime(date('Y-m-01') . " -$i year"));



        $sqlListAppointment = "SELECT pam_id FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HosId' AND  YEAR(pam_app_date) = '$LastYear' AND pam_del = '0' AND pam_status = '3'";

        $qryListAppointment = $DB->prepare($sqlListAppointment);

        $qryListAppointment->execute();

        $count_appointment = $qryListAppointment->rowCount();



        array_push($Total_Apoointment, $count_appointment);



        $sqlListCanAppointment = "SELECT pam_id FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HosId' AND YEAR(pam_app_date) = '$LastYear' AND pam_del = '0' AND pam_status = '4'";

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_can_appointment = $qryListCanAppointment->rowCount();



        array_push($Total_Cancelled_Appointment, $count_can_appointment);



        array_push($Weak_Array, $LastMonthYear);
    }

    return array(array_reverse($Weak_Array), array_reverse($Total_Apoointment), array_reverse($Total_Cancelled_Appointment));
}



function get_patient_package_master_total_package_amount_from_universal_id($DB)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT SUM(package_price) FROM " . DB_PREFIX . "patient_package_master";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_patient_package_master_total_paid_amount_from_universal_id($DB)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_package_master WHERE patient_unique_id = '$patient_unique_id'";

    $sqlList = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "patient_package_master";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function get_daily_package_chart_data_hospital($DB, $HosId, $Days)

{



    $Weak_Array = array();

    $net_amount = array();

    $paid_amount = array();

    $outstanding_amount = array();

    $refund_amount = array();

    $timestamp = time();



    for ($i = 0; $i < $Days; $i++) {



        $weakly_date = date('Y-m-d', $timestamp);

        $weakly_date = date('Y-m-d', strtotime('-1 day', strtotime($weakly_date)));

        $weakly_dm = date('d M', $timestamp);

        $weakly_dm = date('d M', strtotime('-1 day', strtotime($weakly_dm)));

        $timestamp -= 24 * 3600;



        $sqlListAppointment = "SELECT SUM(package_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND date(tppm_created_date) = '$weakly_date' AND tppm_del = '0'"; // net amount

        $qryListAppointment = $DB->prepare($sqlListAppointment);

        $qryListAppointment->execute();

        $count_net_amount = $qryListAppointment->fetch();

        if ($count_net_amount['SUM(package_price)'] == "") {

            $sum_package_total_amount = "0";
        } else {

            $sum_package_total_amount = $count_net_amount['SUM(package_price)'];
        }



        array_push($net_amount, $sum_package_total_amount);



        $sqlListCanAppointment = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND date(tppm_created_date) = '$weakly_date' AND tppm_del = '0'"; // paid amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_paid_amount = $qryListCanAppointment->fetch();

        if ($count_paid_amount['SUM(paid_price)'] == "") {

            $sum_paid_amount = "0";
        } else {

            $sum_paid_amount = $count_paid_amount['SUM(paid_price)'];
        }



        array_push($paid_amount, $sum_paid_amount);



        $sqlListCanAppointment = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "package_payment_history WHERE hm_id = '$HosId' AND date(tpph_created_date) = '$weakly_date' AND tpph_del = '0' AND action_refund = '1'"; // Outstanding amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_outstanding_amount = $qryListCanAppointment->fetch();



        if ($count_outstanding_amount['SUM(paid_price)'] == "") {

            $sum_outstanding_paid_price = "0";
        } else {

            $sum_outstanding_paid_price = $count_outstanding_amount['SUM(paid_price)'];
        }



        array_push($refund_amount, $sum_outstanding_paid_price);



        $sqlListCanAppointment = "SELECT SUM(remaining_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND date(tppm_created_date) = '$weakly_date' AND tppm_del = '0' AND tppm_status != '3'"; // refund amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_refund_amount = $qryListCanAppointment->fetch();



        if ($count_refund_amount['SUM(remaining_price)'] == "") {

            $sum_remaining_price = "0";
        } else {

            $sum_remaining_price = $count_refund_amount['SUM(remaining_price)'];
        }



        array_push($outstanding_amount, $sum_remaining_price);



        array_push($Weak_Array, $weakly_dm);
    }

    return array(array_reverse($Weak_Array), array_reverse($net_amount), array_reverse($paid_amount), array_reverse($refund_amount), array_reverse($outstanding_amount));
}



function get_years_package_chart_data_hospital($DB, $HosId, $Days)

{



    $Weak_Array = array();

    $net_amount = array();

    $paid_amount = array();

    $outstanding_amount = array();

    $refund_amount = array();

    $timestamp = time();

    for ($i = 0; $i < 12; $i++) {



        $LastMonthYear =  date("M", strtotime(date('Y-m-01') . " -$i months"));

        $LastMonth =  date('m', strtotime(date('Y-m-01') . " -$i months"));

        $LastYear =  date('Y', strtotime(date('Y-m-01') . " -$i months"));



        $sqlListAppointment = "SELECT SUM(package_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND MONTH(tppm_created_date) = '$LastMonth' AND YEAR(tppm_created_date) = '$LastYear' AND tppm_del = '0'"; // net amount

        $qryListAppointment = $DB->prepare($sqlListAppointment);

        $qryListAppointment->execute();

        $count_net_amount = $qryListAppointment->fetch();

        if ($count_net_amount['SUM(package_price)'] == "") {

            $sum_package_total_amount = "0";
        } else {

            $sum_package_total_amount = $count_net_amount['SUM(package_price)'];
        }



        array_push($net_amount, $sum_package_total_amount);



        $sqlListCanAppointment = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND MONTH(tppm_created_date) = '$LastMonth' AND YEAR(tppm_created_date) = '$LastYear' AND tppm_del = '0'"; // paid amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_paid_amount = $qryListCanAppointment->fetch();

        if ($count_paid_amount['SUM(paid_price)'] == "") {

            $sum_paid_amount = "0";
        } else {

            $sum_paid_amount = $count_paid_amount['SUM(paid_price)'];
        }



        array_push($paid_amount, $sum_paid_amount);



        $sqlListCanAppointment = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "package_payment_history WHERE hm_id = '$HosId' AND MONTH(tpph_created_date) = '$LastMonth' AND YEAR(tpph_created_date) = '$LastYear' AND tpph_del = '0' AND action_refund = '1'"; // Outstanding amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_outstanding_amount = $qryListCanAppointment->fetch();



        if ($count_outstanding_amount['SUM(paid_price)'] == "") {

            $sum_outstanding_paid_price = "0";
        } else {

            $sum_outstanding_paid_price = $count_outstanding_amount['SUM(paid_price)'];
        }



        array_push($refund_amount, $sum_outstanding_paid_price);



        $sqlListCanAppointment = "SELECT SUM(remaining_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND MONTH(tppm_created_date) = '$LastMonth' AND YEAR(tppm_created_date) = '$LastYear' AND tppm_del = '0' AND tppm_status != '3'"; // refund amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_refund_amount = $qryListCanAppointment->fetch();



        if ($count_refund_amount['SUM(remaining_price)'] == "") {

            $sum_remaining_price = "0";
        } else {

            $sum_remaining_price = $count_refund_amount['SUM(remaining_price)'];
        }



        array_push($outstanding_amount, $sum_remaining_price);



        array_push($Weak_Array, $LastMonthYear);
    }

    return array(array_reverse($Weak_Array), array_reverse($net_amount), array_reverse($paid_amount), array_reverse($refund_amount), array_reverse($outstanding_amount));
}



function get_package_package_chart_data_hospital($DB, $HosId, $Days)

{



    $Weak_Array = array();

    $net_amount = array();

    $paid_amount = array();

    $outstanding_amount = array();

    $refund_amount = array();

    $timestamp = time();

    for ($i = 0; $i < 6; $i++) {



        $LastMonthYear =  date("Y", strtotime(date('Y-m-01') . " -$i year"));

        $LastMonth =  date('m', strtotime(date('Y-m-01') . " -$i months"));

        $LastYear =  date('Y', strtotime(date('Y-m-01') . " -$i year"));



        $sqlListAppointment = "SELECT SUM(package_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND YEAR(tppm_created_date) = '$LastYear' AND tppm_del = '0'"; // net amount

        $qryListAppointment = $DB->prepare($sqlListAppointment);

        $qryListAppointment->execute();

        $count_net_amount = $qryListAppointment->fetch();

        if ($count_net_amount['SUM(package_price)'] == "") {

            $sum_package_total_amount = "0";
        } else {

            $sum_package_total_amount = $count_net_amount['SUM(package_price)'];
        }



        array_push($net_amount, $sum_package_total_amount);



        $sqlListCanAppointment = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND YEAR(tppm_created_date) = '$LastYear' AND tppm_del = '0'"; // paid amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_paid_amount = $qryListCanAppointment->fetch();

        if ($count_paid_amount['SUM(paid_price)'] == "") {

            $sum_paid_amount = "0";
        } else {

            $sum_paid_amount = $count_paid_amount['SUM(paid_price)'];
        }



        array_push($paid_amount, $sum_paid_amount);



        $sqlListCanAppointment = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "package_payment_history WHERE hm_id = '$HosId' AND YEAR(tpph_created_date) = '$LastYear' AND tpph_del = '0' AND action_refund = '1'"; // Outstanding amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_outstanding_amount = $qryListCanAppointment->fetch();



        if ($count_outstanding_amount['SUM(paid_price)'] == "") {

            $sum_outstanding_paid_price = "0";
        } else {

            $sum_outstanding_paid_price = $count_outstanding_amount['SUM(paid_price)'];
        }

        array_push($refund_amount, $sum_outstanding_paid_price);







        $sqlListCanAppointment = "SELECT SUM(remaining_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND YEAR(tppm_created_date) = '$LastYear' AND tppm_del = '0' AND tppm_status != '3'"; // refund amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_refund_amount = $qryListCanAppointment->fetch();



        if ($count_refund_amount['SUM(remaining_price)'] == "") {

            $sum_remaining_price = "0";
        } else {

            $sum_remaining_price = $count_refund_amount['SUM(remaining_price)'];
        }



        array_push($outstanding_amount, $sum_remaining_price);



        array_push($Weak_Array, $LastMonthYear);
    }

    return array(array_reverse($Weak_Array), array_reverse($net_amount), array_reverse($paid_amount), array_reverse($refund_amount), array_reverse($outstanding_amount));
}



function check_patient_package_active(PDO $DB, $patient_unique_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE patient_unique_id = '$patient_unique_id' AND tppm_status != 3";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function check_count_patient_complted_package_session_from_package_id(PDO $DB, $tppm_id, $patient_unique_id)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "treatment_master WHERE tppm_id = '$tppm_id' AND patient_unique_id = '$patient_unique_id' AND ttm_status = 1";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function booster_package_Detox_count(PDO $DB, $HospitalId, $prevmonth2, $date)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE `hm_id` = '$HospitalId'  AND `tppm_status` != '3' AND `package_type` = '1' AND DATE(`tppm_created_date`) BETWEEN '$prevmonth2' AND '$date' AND `tbp_id` IN ( SELECT `tbp_id` FROM `tbl_patient_package_master` GROUP BY `tbp_id` HAVING COUNT(*) > 1) GROUP BY `tbp_id`, `patient_unique_id`";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function booster_package_EECP_count(PDO $DB, $HospitalId, $prevmonth2, $date)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_package_master WHERE `hm_id` = '$HospitalId'  AND `tppm_status` != '3' AND `package_type` = '2' AND DATE(`tppm_created_date`) BETWEEN '$prevmonth2' AND '$date' AND `tbp_id` IN ( SELECT `tbp_id` FROM `tbl_patient_package_master` GROUP BY `tbp_id` HAVING COUNT(*) > 1) GROUP BY `tbp_id`, `patient_unique_id`";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_state_list(PDO $DB, $pm_country)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "states WHERE country_id =' $pm_country'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function week_between_two_dates_analytics($date1, $date2)

{

    $first = DateTime::createFromFormat('Y-m-d', $date1);

    $second = DateTime::createFromFormat('Y-m-d', $date2);

    if ($date1 > $date2) {

        return week_between_two_dates_analytics($date2, $date1);
    } else {

        return floor($first->diff($second)->days / 7);
    }
}



function get_weekly_appointment_chart_data_hospital($DB, $HosId, $Days)

{



    $Weak_Array = array();

    $Total_Apoointment = array();

    $Total_Cancelled_Appointment = array();

    $timestamp = time();



    $Today = date('Y-m-d');

    $PrevDays = date('Y-m-d', strtotime(' -90 day'));



    $WeekDays = week_between_two_dates_analytics($PrevDays, $Today);



    for ($i = 0; $i < $WeekDays; $i++) {



        // $LastWeeks =  $i + intval(1) . " Weeks";

        // $WeekIndex = $i + intval(1);

        // $FisrtDate =  date('Y-m-d', strtotime("-$i weeks"));

        // $LastDatetDate =  date('Y-m-d', strtotime("-$WeekIndex weeks"));



        $LastWeeks =  $i + intval(1) . " Weeks";

        $WeekIndex = $i + intval(1);

        $FisrtDate =  date('Y-m-d', strtotime("-$i weeks"));

        $LastDatetDate =  date('Y-m-d', strtotime("-$WeekIndex weeks"));

        $LastDatetDate = date('Y-m-d', strtotime('+1 day', strtotime($LastDatetDate)));



        $sqlListAppointment = "SELECT pam_id FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HosId' AND date(pam_app_date) BETWEEN '$LastDatetDate' AND '$FisrtDate' AND pam_del = '0' AND pam_status = '3'";

        $qryListAppointment = $DB->prepare($sqlListAppointment);

        $qryListAppointment->execute();

        $count_appointment = $qryListAppointment->rowCount();



        array_push($Total_Apoointment, $count_appointment);



        $sqlListCanAppointment = "SELECT pam_id FROM " . DB_PREFIX . "appointment_master WHERE hm_id = '$HosId' AND date(pam_app_date) BETWEEN '$LastDatetDate' AND '$FisrtDate' AND pam_del = '0' AND pam_status = '4'";

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_can_appointment = $qryListCanAppointment->rowCount();



        array_push($Total_Cancelled_Appointment, $count_can_appointment);



        array_push($Weak_Array, $LastWeeks);
    }

    return array(array_reverse($Weak_Array), array_reverse($Total_Apoointment), array_reverse($Total_Cancelled_Appointment));
}



function get_weekly_package_chart_data_hospital($DB, $HosId, $Days)

{



    $Weak_Array = array();

    $net_amount = array();

    $paid_amount = array();

    $outstanding_amount = array();

    $refund_amount = array();

    $timestamp = time();



    $Today = date('Y-m-d');

    $PrevDays = date('Y-m-d', strtotime(' -90 day'));



    $WeekDays = week_between_two_dates_analytics($PrevDays, $Today);



    for ($i = 0; $i < $WeekDays; $i++) {



        // $weakly_date = date('Y-m-d', $timestamp);

        // $weakly_date = date('Y-m-d', strtotime('-1 day', strtotime($weakly_date)));

        // $weakly_dm = date('d M', $timestamp);

        // $weakly_dm = date('d M', strtotime('1 day', strtotime($weakly_dm)));

        // $timestamp -= 24 * 3600;



        $LastWeeks =  $i + intval(1) . " Weeks";

        $WeekIndex = $i + intval(1);

        $FisrtDate =  date('Y-m-d', strtotime("-$i weeks"));

        $LastDatetDate =  date('Y-m-d', strtotime("-$WeekIndex weeks"));

        $LastDatetDate = date('Y-m-d', strtotime('+1 day', strtotime($LastDatetDate)));



        $sqlListAppointment = "SELECT SUM(package_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND date(tppm_created_date) BETWEEN '$LastDatetDate' AND '$FisrtDate' AND tppm_del = '0'"; // net amount 

        $qryListAppointment = $DB->prepare($sqlListAppointment);

        $qryListAppointment->execute();

        $count_net_amount = $qryListAppointment->fetch();



        if ($count_net_amount['SUM(package_price)'] == "") {

            $sum_package_total_amount = "0";
        } else {

            $sum_package_total_amount = $count_net_amount['SUM(package_price)'];
        }



        array_push($net_amount, $sum_package_total_amount);



        $sqlListCanAppointment = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND date(tppm_created_date) BETWEEN '$LastDatetDate' AND '$FisrtDate' AND tppm_del = '0'"; // paid amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_paid_amount = $qryListCanAppointment->fetch();

        if ($count_paid_amount['SUM(paid_price)'] == "") {

            $sum_paid_amount = "0";
        } else {

            $sum_paid_amount = $count_paid_amount['SUM(paid_price)'];
        }



        array_push($paid_amount, $sum_paid_amount);



        $sqlListCanAppointment = "SELECT SUM(paid_price) FROM " . DB_PREFIX . "package_payment_history WHERE hm_id = '$HosId' AND date(tpph_created_date) BETWEEN '$LastDatetDate' AND '$FisrtDate' AND tpph_del = '0' AND action_refund = '1'"; // Outstanding amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_outstanding_amount = $qryListCanAppointment->fetch();



        if ($count_outstanding_amount['SUM(paid_price)'] == "") {

            $sum_outstanding_paid_price = "0";
        } else {

            $sum_outstanding_paid_price = $count_outstanding_amount['SUM(paid_price)'];
        }

        array_push($refund_amount, $sum_outstanding_paid_price);



        $sqlListCanAppointment = "SELECT SUM(remaining_price) FROM " . DB_PREFIX . "patient_package_master WHERE hm_id = '$HosId' AND date(tppm_created_date) BETWEEN '$LastDatetDate' AND '$FisrtDate' AND tppm_del = '0' AND tppm_status != '3'"; // refund amount

        $qryListCanAppointment = $DB->prepare($sqlListCanAppointment);

        $qryListCanAppointment->execute();

        $count_refund_amount = $qryListCanAppointment->fetch();



        if ($count_refund_amount['SUM(remaining_price)'] == "") {

            $sum_remaining_price = "0";
        } else {

            $sum_remaining_price = $count_refund_amount['SUM(remaining_price)'];
        }



        array_push($outstanding_amount, $sum_remaining_price);



        // array_push($Total_Cancelled_Appointment, $count_can_appointment);



        array_push($Weak_Array, $LastWeeks);
    }

    return array(array_reverse($Weak_Array), array_reverse($net_amount), array_reverse($paid_amount), array_reverse($refund_amount), array_reverse($outstanding_amount));
}



function get_patient_From_hospital_id(PDO $DB, $Hm_id)
{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master_logs AS pml JOIN `tbl_patient_master` AS pm ON pml.pm_id = pm.pm_id AND pml.hm_id = '$Hm_id'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



// $sqlList= "SELECT * FROM ".DB_PREFIX."patient_master AS pm JOIN " . DB_PREFIX . "patient_master_logs AS pml ON pml.pm_id=pm.pm_id AND pml.hm_id = '$SessionUHospitalId' AND (pm.pm_contact_no LIKE '$Term%' OR pm.patient_unique_id LIKE '$Term%' OR CONCAT(pm.pm_first_name, ' ',pm.pm_last_name) LIKE '$Term%') AND pm.pm_del = 0  GROUP BY pm.patient_unique_id LIMIT 0,20";



function get_patient_in_billing_from_fname_limit(PDO $DB, $Term, $SessionUHospitalId)

{

    // $sqlList= "SELECT * FROM ".DB_PREFIX."patient_master WHERE CONCAT( pm_first_name,  ' ', pm_last_name ) LIKE '$Term%' AND pm_del = 0  LIMIT 0,20";

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master AS pm JOIN " . DB_PREFIX . "patient_master_logs AS pml ON pml.pm_id=pm.pm_id AND pml.hm_id = '$SessionUHospitalId' AND (CONCAT(pm.pm_first_name, ' ',pm.pm_last_name) LIKE '$Term%') AND pm.pm_del = 0  GROUP BY pm.patient_unique_id LIMIT 0,20";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_patient_in_from_patient_id_name(PDO $DB, $Term, $SessionUHospitalId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "patient_master AS pm JOIN " . DB_PREFIX . "patient_master_logs AS pml ON pml.pm_id=pm.pm_id AND pml.hm_id = '$SessionUHospitalId' AND (pm.pm_contact_no LIKE '$Term%' OR pm.patient_unique_id LIKE '$Term%' OR CONCAT(pm.pm_first_name, ' ',pm.pm_last_name) LIKE '$Term%') AND pm_del = 0  LIMIT 0,20";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetchAll();
}



function get_user_name_to_get_Email_id(PDO $DB, $Username)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE user_name = '$Username'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    return $qryList->fetch();
}



function check_all_user_from_user_name(PDO $DB, $Username)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE user_name = '$Username'";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}



function get_user_master_pasword_status_from_id(PDO $DB, $UserId)

{

    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE um_id = '$UserId' And pass_type = '1' ";

    $qryList = $DB->prepare($sqlList);

    $qryList->execute();

    $count = $qryList->rowCount();

    return $count;
}


function check_auth_access()
{
}
