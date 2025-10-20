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

    $stmt = $pdo->prepare("SELECT `doctor_pf_id`, `doctor_name`, `pf_amount`, `discount`, `net_amount`
     FROM `doctor_pf` WHERE `doctor_id` = ?");
    $stmt->execute([$doctorId]);
    $doctor_pf = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($doctorId) {
        echo json_encode(["success" => true, "data" => $doctor_pf]);
    } else {
        echo json_encode(["success" => false, "message" => "User not found"]);
    }
}
?>
