<?php
$env = parse_ini_file(__DIR__ . '/../.env', true);

$host = $env['DB_HOST'];
$db   = $env['DB_NAME'];
$user = $env['DB_USER'];
$pass = $env['DB_PASS'];
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // throws errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                   // real prepared stmts
    PDO::ATTR_PERSISTENT         => true,                    // persistent connection
];

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode([
        "success" => false,
        "message" => "Database connection failed."
    ]));
}
?>
