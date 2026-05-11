<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}
require_once 'koneksi.php';
$nama = trim($_POST['nama_guru'] ?? '');
if (!$nama){echo json_encode(['status'=>'error','message'=>'Nama guru wajib diisi']);exit;}
$n = $conn->real_escape_string($nama);
$cek = $conn->query("SELECT id_guru FROM guru WHERE nama_guru='$n'");
if ($cek->num_rows>0){echo json_encode(['status'=>'error','message'=>'Nama guru sudah ada']);exit;}
if ($conn->query("INSERT INTO guru (nama_guru) VALUES ('$n')")) {
    echo json_encode(['status'=>'success','message'=>'Guru ditambahkan','data'=>['id_guru'=>$conn->insert_id,'nama_guru'=>$nama]]);
} else { echo json_encode(['status'=>'error','message'=>$conn->error]); }
$conn->close();
?>
