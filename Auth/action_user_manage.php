<?php

include_once '../init.php';
// Check if data was received via POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the selected options from the POST data

    $uid = $_POST["uid"];
    $data = [];

    if (isset($_POST["options"])) {
        $selectedOptions = $_POST["options"];
        $options =  implode(",", $selectedOptions);

        $updateQuery = "UPDATE  " . DB_PREFIX . "user_master SET erp_menu = :newValue WHERE um_id = '$uid' AND um_del = '0'";

        $stmt = $DB->prepare($updateQuery);

        $stmt->bindParam(':newValue', $options, PDO::PARAM_STR);

        // Create a prepared statement
        $stmt->execute();
    }

    $from_new_query = "FROM " . DB_PREFIX . "user_master WHERE um_id = '$uid' AND um_del = '0'";
    $sql = "SELECT erp_menu $from_new_query";
    $qry = $DB->prepare($sql);
    $qry->execute();
    $ResultsList = $qry->fetchAll();


    $data = $ResultsList;



    echo json_encode($data);
} else {
    // Handle other HTTP methods or requests
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
