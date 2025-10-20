<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);

    $fullname = trim($input["fullname"] ?? "");
    $email = trim($input["email"] ?? "");
    $password = trim($input["password"] ?? "");

    if (empty($fullname) || empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // ✅ Check if email exists
    $stmt = $pdo->prepare("SELECT * FROM `doctors` WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(["success" => false, "message" => "Email already registered."]);
        exit;
    }

    $stmt = $pdo->query("SELECT doctor_id FROM doctors ORDER BY id DESC LIMIT 1");
    $lastDoctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastDoctor && preg_match('/dc-(\d+)/', $lastDoctor['doctor_id'], $matches)) {
        $nextId = (int)$matches[1] + 1;
    } else {
        $nextId = 1; 
    }

    $stmt = $pdo->prepare("INSERT INTO `doctors` (`doctor_fullname`, `email`, `password`) VALUES (?, ?, ?)");
    $success = $stmt->execute([$fullname, $email, $hashedPassword]);

    if ($success) {
        echo json_encode(["success" => true, "message" => "Signup successful!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Something went wrong."]);
    }
}
?>
