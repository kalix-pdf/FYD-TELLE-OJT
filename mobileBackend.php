<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // allows React Native to fetch
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$servername = "localhost";
$username = "root";        // your DB username
$password = "";            // your DB password
$dbname = "eac_findyourdoctor_db"; // your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

$sql = "SELECT `doctor_id`, `doctor_firstname`, `doctor_category`, `doctor_sex`, `doctor_status` FROM doctor"; 
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
