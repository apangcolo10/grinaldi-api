<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}
require_once 'koneksi.php';
$kode = strtoupper(trim($_POST['kode_mapel'] ?? ''));
if (!$kode){echo json_encode(['status'=>'error','message'=>'kode_mapel tidak valid']);exit;}
$k=$conn->real_escape_string($kode);
$tabel='jadwal';
$cek=$conn->query("SHOW TABLES LIKE 'jadwal'");
if ($cek->num_rows===0) $tabel='data_jadwal';
$cekJ=$conn->query("SELECT id_jadwal FROM $tabel WHERE kode_mapel='$k' LIMIT 1");
if ($cekJ->num_rows>0){echo json_encode(['status'=>'error','message'=>'Mapel masih digunakan di jadwal aktif']);exit;}
if ($conn->query("DELETE FROM mapel WHERE kode_mapel='$k'")) {
    echo json_encode(['status'=>'success','message'=>'Mapel dihapus']);
} else { echo json_encode(['status'=>'error','message'=>$conn->error]); }
$conn->close();
?>
