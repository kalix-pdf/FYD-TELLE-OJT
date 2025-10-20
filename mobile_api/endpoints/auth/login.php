<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);

    $email = trim($input["email"] ?? "");
    $password = trim($input["password"] ?? "");

    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Email and password are required."]);
        exit;
    }

    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM `doctors` WHERE email = ?");
    $stmt->execute([$email]);
    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$doctor) {
        echo json_encode(["success" => false, "message" => "Email not found."]);
        exit;
    }

    if (!password_verify($password, $doctor["password"])) {
        echo json_encode(["success" => false, "message" => "Incorrect password."]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "message" => "Login successful!",
        "doctor" => [
            "doctor_id" => $doctor["doctor_id"],
            "fullname" => $doctor["doctor_fullname"],
            "email" => $doctor["email"]
        ]
    ]);
}
?>
