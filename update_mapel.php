<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}
require_once 'koneksi.php';
$kode_lama = strtoupper(trim($_POST['kode_mapel_lama'] ?? ''));
$nama      = trim($_POST['nama_mapel'] ?? '');
if (!$kode_lama||!$nama){echo json_encode(['status'=>'error','message'=>'kode_mapel_lama dan nama_mapel wajib diisi']);exit;}
$k=$conn->real_escape_string($kode_lama); $n=$conn->real_escape_string($nama);
if ($conn->query("UPDATE mapel SET nama_mapel='$n' WHERE kode_mapel='$k'")) {
    echo json_encode(['status'=>'success','message'=>'Mapel diperbarui']);
} else { echo json_encode(['status'=>'error','message'=>$conn->error]); }
$conn->close();
?>
