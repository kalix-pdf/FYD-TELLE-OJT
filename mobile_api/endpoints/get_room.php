<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // allows React Native to fetch
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $doctorId = $_GET['doctor_id'] ?? null;
    
    if (!$doctorId || !is_string($doctorId)) {
        echo json_encode(["success" => false, "message" => "Invalid user ID"]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT `room_id`, `room_class`, `room_rate`, `no_of_days`, `total_amount` FROM `room_details` 
    WHERE `doctor_id` = ?");
    $stmt->execute([$doctorId]);
    $room_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($doctorId) {
        echo json_encode(["success" => true, "data" => $room_details]);
    } else {
        echo json_encode(["success" => false, "message" => "User not found"]);
    }
}
?>
