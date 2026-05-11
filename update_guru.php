<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}
require_once 'koneksi.php';
$id   = intval($_POST['id_guru'] ?? 0);
$nama = trim($_POST['nama_guru'] ?? '');
if (!$id||!$nama){echo json_encode(['status'=>'error','message'=>'id_guru dan nama_guru wajib diisi']);exit;}
$n = $conn->real_escape_string($nama);
if ($conn->query("UPDATE guru SET nama_guru='$n' WHERE id_guru=$id")) {
    echo json_encode(['status'=>'success','message'=>'Guru diperbarui']);
} else { echo json_encode(['status'=>'error','message'=>$conn->error]); }
$conn->close();
?>
