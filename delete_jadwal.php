<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}
require_once 'koneksi.php';

// Support POST body atau DELETE query string
$id_jadwal = intval($_POST['id_jadwal'] ?? $_GET['id_jadwal'] ?? 0);
if (!$id_jadwal) { echo json_encode(['status'=>'error','message'=>'id_jadwal tidak valid']); exit; }

$tabel = 'jadwal';
$cek = $conn->query("SHOW TABLES LIKE 'jadwal'");
if ($cek->num_rows === 0) $tabel = 'data_jadwal';

if ($conn->query("DELETE FROM $tabel WHERE id_jadwal=$id_jadwal")) {
    echo json_encode(['status'=>'success','message'=>'Jadwal dihapus']);
} else {
    echo json_encode(['status'=>'error','message'=>$conn->error]);
}
$conn->close();
?>
