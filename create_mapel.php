<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}
require_once 'koneksi.php';
$kode = strtoupper(trim($_POST['kode_mapel'] ?? ''));
$nama = trim($_POST['nama_mapel'] ?? '');
if (!$kode||!$nama){echo json_encode(['status'=>'error','message'=>'Kode dan nama mapel wajib diisi']);exit;}
$k=$conn->real_escape_string($kode); $n=$conn->real_escape_string($nama);
$cek=$conn->query("SELECT kode_mapel FROM mapel WHERE kode_mapel='$k'");
if ($cek->num_rows>0){echo json_encode(['status'=>'error','message'=>"Kode '$kode' sudah ada"]);exit;}
if ($conn->query("INSERT INTO mapel (kode_mapel,nama_mapel) VALUES ('$k','$n')")) {
    echo json_encode(['status'=>'success','message'=>'Mapel ditambahkan']);
} else { echo json_encode(['status'=>'error','message'=>$conn->error]); }
$conn->close();
?>
