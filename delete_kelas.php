<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}
require_once 'koneksi.php';
$id = intval($_POST['id_kelas'] ?? 0);
if (!$id){echo json_encode(['status'=>'error','message'=>'id_kelas tidak valid']);exit;}
$tabel = 'jadwal';
$cek = $conn->query("SHOW TABLES LIKE 'jadwal'");
if ($cek->num_rows===0) $tabel='data_jadwal';
$cekJ = $conn->query("SELECT id_jadwal FROM $tabel WHERE id_kelas=$id LIMIT 1");
if ($cekJ->num_rows>0){echo json_encode(['status'=>'error','message'=>'Kelas masih memiliki jadwal aktif']);exit;}
if ($conn->query("DELETE FROM kelas WHERE id_kelas=$id")) {
    echo json_encode(['status'=>'success','message'=>'Kelas dihapus']);
} else { echo json_encode(['status'=>'error','message'=>$conn->error]); }
$conn->close();
?>
