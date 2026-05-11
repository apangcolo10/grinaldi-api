<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}
require_once 'koneksi.php';
$id   = intval($_POST['id_kelas'] ?? 0);
$nama = strtoupper(trim($_POST['nama_kelas'] ?? ''));
if (!$id||!$nama){echo json_encode(['status'=>'error','message'=>'id_kelas dan nama_kelas wajib diisi']);exit;}
$n = $conn->real_escape_string($nama);
if ($conn->query("UPDATE kelas SET nama_kelas='$n' WHERE id_kelas=$id")) {
    echo json_encode(['status'=>'success','message'=>'Kelas diperbarui']);
} else { echo json_encode(['status'=>'error','message'=>$conn->error]); }
$conn->close();
?>
