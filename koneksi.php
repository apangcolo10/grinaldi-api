<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$host   = 'centerbeam.proxy.rlwy.net';
$dbname = 'railway';
$user   = 'root';
$pass   = 'cmApvVYAkvQYQBkKITqodrfFgcHjSgnK';
$port   = 14473;

$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Koneksi gagal: ' . $conn->connect_error]);
    exit();
}
$conn->set_charset('utf8mb4');
?>
