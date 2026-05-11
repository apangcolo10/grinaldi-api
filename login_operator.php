<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}
require_once 'koneksi.php';

$raw = file_get_contents('php://input');
$d   = json_decode($raw, true);
$username = trim($d['username'] ?? '');
$password = trim($d['password'] ?? '');

if (!$username||!$password) {
    echo json_encode(['status'=>'error','message'=>'Username dan password wajib diisi']); exit;
}

// Cek tabel operator ada
$cekTbl = $conn->query("SHOW TABLES LIKE 'operator'");
if ($cekTbl->num_rows === 0) {
    // Auto buat tabel + akun default jika belum ada
    $conn->query("CREATE TABLE operator (
        id_operator INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        nama VARCHAR(100) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    $conn->query("INSERT INTO operator (username,password,nama) VALUES ('admin','admin123','Administrator')");
}

$u = $conn->real_escape_string($username);
$r = $conn->query("SELECT id_operator,username,nama,password FROM operator WHERE username='$u' LIMIT 1");
if ($r->num_rows === 0) {
    echo json_encode(['status'=>'error','message'=>'Username tidak ditemukan']); exit;
}
$op = $r->fetch_assoc();

// Support plain text dan password_hash
$valid = ($password === $op['password']) || password_verify($password, $op['password']);
if ($valid) {
    echo json_encode([
        'status'   => 'success',
        'message'  => 'Login berhasil',
        'operator' => ['id'=>$op['id_operator'],'username'=>$op['username'],'nama'=>$op['nama']]
    ]);
} else {
    echo json_encode(['status'=>'error','message'=>'Password salah']);
}
$conn->close();
?>
