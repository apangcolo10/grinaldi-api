<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(200);exit;}
require_once 'koneksi.php';

$raw = file_get_contents('php://input');
$d   = json_decode($raw, true);
if (!$d) { echo json_encode(['status'=>'error','message'=>'Body tidak valid']); exit; }

$id_jadwal     = intval($d['id_jadwal'] ?? 0);
$hari          = $conn->real_escape_string(trim($d['hari'] ?? ''));
$jam_ke        = intval($d['jam_ke'] ?? 0);
$waktu_mulai   = $conn->real_escape_string(trim($d['waktu_mulai'] ?? ''));
$waktu_selesai = $conn->real_escape_string(trim($d['waktu_selesai'] ?? ''));
$id_kelas      = intval($d['id_kelas'] ?? 0);
$kode_mapel    = $conn->real_escape_string(trim($d['kode_mapel'] ?? ''));
$id_guru       = intval($d['id_guru'] ?? 0);

if (!$id_jadwal||!$hari||!$jam_ke||!$waktu_mulai||!$waktu_selesai||!$id_kelas||!$kode_mapel||!$id_guru) {
    echo json_encode(['status'=>'error','message'=>'Semua field wajib diisi']); exit;
}

$tabel = 'jadwal';
$cek = $conn->query("SHOW TABLES LIKE 'jadwal'");
if ($cek->num_rows === 0) $tabel = 'data_jadwal';

$sql = "UPDATE $tabel SET hari='$hari', jam_ke=$jam_ke, waktu_mulai='$waktu_mulai',
        waktu_selesai='$waktu_selesai', id_kelas=$id_kelas, kode_mapel='$kode_mapel',
        id_guru=$id_guru WHERE id_jadwal=$id_jadwal";
if ($conn->query($sql)) {
    echo json_encode(['status'=>'success','message'=>'Jadwal diperbarui']);
} else {
    echo json_encode(['status'=>'error','message'=>$conn->error]);
}
$conn->close();
?>
